<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_login
 *
 * @author Dattatraya
 */
class Model_user extends CI_Model {

    public $dataArray;

    public function __construct() {
        parent::__construct();
    }

    function getUser($select = '*') {
        $user = $this->db->select($select)->from("sp_user")->where('status!=', '2')->get();
        return ($user->num_rows() > 0) ? $user->result_array() : '';
    }

    function getType() {
        $userType = $this->db->select("*")->from("sp_user_group")->where('status!=', '2')->get();
        return ($userType->num_rows() > 0) ? $userType->result_array() : '';
    }

    function addUserType($action) {

        $insertData = array(
            'group_name' => $this->input->post('txtUserType'),
            'status' => $this->input->post('radStatus'),
        );

        switch ($action) {
            case 'edit':
                $insertData['updated_by'] = $_SESSION['user_id'];
                $insertData['updated_at'] = C_DATE_TIME;
                $this->db->where('id', $this->input->post('hidUserGroupId'));
                $this->db->update('sp_user_group', $insertData);
                $this->updateGroupMenuAccess($this->input->post('hidUserGroupId'));
                break;
            default:
                $insertData['created_by'] = $_SESSION['user_id'];
                $insertData['created_at'] = C_DATE_TIME;
                $this->db->insert('sp_user_group', $insertData);
                $this->updateGroupMenuAccess($this->db->insert_id());
                break;
        }
        return true;
    }

    function deleteUserType() {

        $this->db->where('id', $this->input->post("hidDeleteId"));
        $this->db->update('sp_user_group', array('status' => 2));
        return 1;
    }

    function categoryTreeMenuLevel(&$output = null, $parent = 0, $indent = null) {
        $this->db->select('id,title,parent_id');
        $this->db->from('sp_menu');
        $this->db->where('parent_id', $parent);

        $child = $this->db->get();
        $categories = $child->result();
        $i = 0;
        foreach ($categories as $cat) {
            $this->dataArray[$cat->id] = array('id' => $cat->id, 'title' => $cat->title);
            if ($cat->id != $parent) {
                $this->categoryTreeMenuLevel($output, $cat->id, $indent . "-");
            }
        }
        // return the list of categories
        return $this->dataArray;
    }

    function getTypeOption() {
        $userType = $this->db->select("id,group_name")->from("sp_user_group")->where('status!=', '2')->get();
        return ($userType->num_rows() > 0) ? $userType->result_array() : '';
    }

    function addUser($action) {

        $insertData = array(
            'firstName' => $this->input->post('txtFirstName'),
            'lastName' => $this->input->post('txtLastName'),
            'userName' => $this->input->post('txtUserName'),
            'email' => $this->input->post('txtEmail'),
            'user_group_id' => $this->input->post('selGroup'),
            'status' => $this->input->post('radStatus'),
        );
        if ($this->input->post('txtPasword')) {
            $insertData['password'] = enc_password($this->input->post('txtPasword'));
        }
        switch ($action) {
            case 'edit':
                $insertData['updated_by'] = $_SESSION['user_id'];
                $insertData['updated_at'] = C_DATE_TIME;
                $this->db->where('id', $this->input->post('hidUserId'));
                $this->db->update('sp_user', $insertData);
                break;
            default:
                $insertData['created_by'] = $_SESSION['user_id'];
                $insertData['created_at'] = C_DATE_TIME;
                $this->db->insert('sp_user', $insertData);
                break;
        }
        return true;
    }

    function deleteUser() {
        $this->db->where('id', $this->input->post("hidDeleteId"));
        $this->db->update('sp_user', array('status' => 2));
        return 1;
    }

    function addUserManuAccess($accessMenu) {
        if (!empty($accessMenu)) {
            //delete query for access
            // $checkExit = $this->db->select("count(id)as count")->from()
            $userid = $this->input->post("userId");
            $this->db->where('user_id', $userid);
            $this->db->delete('sp_user_access');

            $this->db->insert_batch('sp_user_access', $accessMenu);
            return true;
        }
        return FALSE;
    }

    function updateGroupMenuAccess($userTypeId) {
        if ($userTypeId) {
            $menuAccessArray = [];
            $menuIds = $this->input->post("menuid");
            
            $is_add = $this->input->post("is_add");
            $is_edit = $this->input->post("is_edit");
            $is_delete = $this->input->post("is_delete");
            
            $is_his_view = $this->input->post("is_his_view");
            $is_his_edit = $this->input->post("is_his_edit");
            $is_his_delete = $this->input->post("is_his_delete");
            
            $is_other_view = $this->input->post("is_other_view");
            $is_other_edit = $this->input->post("is_other_edit");
            $is_other_delete = $this->input->post("is_other_delete");
            $i = 0;
            foreach ($menuIds as $menuKey) {
                $menuAccessArray[$i]['group_id'] = $userTypeId;
                $menuAccessArray[$i]['menu_id'] = $menuKey;

                $menuAccessArray[$i]['is_add'] = (isset($is_add[$menuKey])) ? ($is_add[$menuKey]) : NULL;
                $menuAccessArray[$i]['is_edit'] = (isset($is_edit[$menuKey])) ? $is_edit[$menuKey] : NULL;
                $menuAccessArray[$i]['is_delete'] = (isset($is_delete[$menuKey])) ? $is_delete[$menuKey] : NULL;

                $menuAccessArray[$i]['is_his_view'] = (isset($is_his_view[$menuKey])) ? $is_his_view[$menuKey] : NULL;
                $menuAccessArray[$i]['is_his_edit'] = (isset($is_his_edit[$menuKey])) ? $is_his_edit[$menuKey] : NULL;
                $menuAccessArray[$i]['is_his_delete'] = (isset($is_his_delete[$menuKey])) ? $is_his_delete[$menuKey] : NULL;

                $menuAccessArray[$i]['is_other_view'] = (isset($is_other_view[$menuKey])) ? $is_other_view[$menuKey] : NULL;
                $menuAccessArray[$i]['is_other_edit'] = (isset($is_other_edit[$menuKey])) ? $is_other_edit[$menuKey] : NULL;
                $menuAccessArray[$i]['is_other_delete'] = (isset($is_other_delete[$menuKey])) ? $is_other_delete[$menuKey] : NULL;

                $menuAccessArray[$i]['created_by'] = $_SESSION['user_id'];
                $menuAccessArray[$i]['created_at'] = C_DATE_TIME;
                $i++;
            }

            $this->db->where('group_id', $userTypeId);
            $this->db->delete('sp_group_access');
            $this->db->insert_batch('sp_group_access', $menuAccessArray);
        }
    }

}
