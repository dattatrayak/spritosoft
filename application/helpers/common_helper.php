<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function p($array, $flag = 0) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    if ($flag) {
        exit();
    }
}

function q($flag = 0) {
    $ci = & get_instance();
    echo "<pre>";
    echo $ci->db->last_query();
    echo "</pre>";
    if ($flag) {
        exit();
    }
}

function showErrorMessage($message) {
    $returnErrorMessage = '';
    if ($message) {
        $returnErrorMessage = '<div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fa fa-warning"></i> Error Message
                                        ' . $message . '    
                                    </div>';
    }
    return $returnErrorMessage;
}

function showSuccessMessage($message) {
    if ($message) {
        $returnErrorMessage = '<div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fa fa-check"></i> Success Message<br/>
                                        ' . $message . '    
                                    </div>';
    }
    return $returnErrorMessage;
}

function fnGetSinleRowData($tableName, $selctRow = '*', $where = array()) {
    $ci = & get_instance();
    $ci->db->select($selctRow);
    $result = $ci->db->get_where($tableName, $where);
    return ($result->num_rows() > 0 ) ? $result->row_array() : '';
}

function fnGetMultipleData($tableName,$where = array(), $selctRow = '*') {
    $ci = & get_instance();
    $ci->db->select($selctRow);
    $result = $ci->db->get_where($tableName, $where);
    return ($result->num_rows() > 0 ) ? $result->result_array() : '';
}

function showFlashMessage() {
    $ci = & get_instance();
    $ci->load->library("session");
    $return = '';
    if ($ci->session->flashdata('success')) {
        $return .= '<div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success! </strong>' . $ci->session->flashdata('success') . '
        </div>';
    } else if ($ci->session->flashdata('error')) {
        $return .= '<div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error!</strong> ' . $ci->session->flashdata('error') . '
        </div>';
    } else if ($ci->session->flashdata('warning')) {
        $return .= '<div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Warning!</strong> ' . $ci->session->flashdata('warning') . ' 
        </div>';
    } else if ($ci->session->flashdata('info')) {
        $return .= '<div class="alert alert-info">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Info!</strong> ' . $ci->session->flashdata('info') . ' 
        </div>';
    }
    return $return;
}

function showStatus($status) {
    $returnStatus = '';
    if ($status == '1') {
        $returnStatus = '<span class="label label-success">Active</span>';
    }
    if ($status == '0') {
        $returnStatus = '<span class="label label-warning">Inactive</span>';
    }
    if ($status == '2') {
        $returnStatus = '<span class="label label-warning">Delete</span>';
    }
    return $returnStatus;
}

/*
 * get dome data from array
 *  send the array and array feilds to get 
 * 
 */

function getDataFromArray($array, $arrayGet) {
    return array_column($array, $arrayGet);
}

/*
 * function used to make 
 * 
 * 
 */

function enc_password($password, $primary_key = 'encode') {
    $returnPassowrd = '';
    $ci = & get_instance();
    $ci->load->library('encryption');
    $key = '';
    if ($primary_key == 'encode') {
        $returnPassowrd = $ci->encryption->encrypt($password);
    }
    if ($primary_key == 'd') {
        $returnPassowrd = $ci->encryption->decrypt($password);
    }
    return $returnPassowrd;
}
/*
 * function used to make get access page name
 */
function getPageAccessFromPageName($url){
    $ci = & get_instance();
    $query = $ci->db->select("id,title,page_heading,url,description,parent_id")
            ->from("sp_menu")
            ->where('url',$url)
            ->where('menu_group','admin')
            ->where('status','1')
            ->get();
        return ($query->num_rows() > 0) ? $query->row_array() : '';
}
/*
 * this function used to get group level access details
 */
function getMenuLevelAsscess( $menuId ){
   $ci = & get_instance();
    $query = $ci->db->select("*")
                    ->from("sp_group_access")
                    ->where('group_id',$_SESSION['user_type'])
                    ->where('menu_id',$menuId)
                    ->get();
        $getGroupLevel = ($query->num_rows() > 0) ? $query->row_array() : '';
        
        $query = $ci->db->select("*")
                    ->from("sp_user_access")
                    ->where('user_id',$_SESSION['user_id'])
                    ->where('menu_id',$menuId)
                    ->get();
      $userLevelAccess = ($query->num_rows() > 0) ? $query->row_array() : '';
      //q();
      //p($userLevelAccess);
      return (!empty($userLevelAccess)) ? $userLevelAccess : $getGroupLevel;
}

function show_submit_button($btnSubmit) {
    //check if access for edit
    $ci = & get_instance();  
   //p($ci->data['accessLevel']);
    if (!empty($ci->data['accessLevel']) && $ci->data['accessLevel']['is_add'] == 1) {
        return form_submit($btnSubmit);
    }
    return '';
}
/**
 * 
 * @param type $id
 * @param type $pageId
 * @return string button for edit
 */
function show_edit_button($rowData) {
    //check if access for edit 
    $ci = & get_instance(); 
    //p($accessLevel);
    
    if (!empty($ci->data['accessLevel']) && $ci->data['accessLevel']['is_his_edit'] == 1 && $ci->data['accessLevel']['created_by'] == $_SESSION['is_admin_login']) {
        return '<button class="btn btn-success btn-xs" onclick="fnEdit('.$rowData['id'].')">Edit</button>';
    }elseif (isset($ci->data['accessLevel']) && $ci->data['accessLevel']['is_other_edit'] == 1 && $rowData['created_by'] != $_SESSION['is_admin_login'] ){
       return '<button class="btn btn-success btn-xs" onclick="fnEdit('.$rowData['id'].')">Edit</button>'; 
    }
    return '';
}

function show_delete_button($rowData) {
    //check if access for delete
    $ci = & get_instance(); 
    if (!empty($ci->data['accessLevel']) && $ci->data['accessLevel']['is_his_delete'] == 1 && $rowData['created_by'] == $_SESSION['is_admin_login']) {
        return '<button class="btn btn-danger btn-xs" onclick="fnDelete('.$rowData['id'].')">Delete</button>';
    }elseif (isset($ci->data['accessLevel']) && $ci->data['accessLevel']['is_other_delete'] == 1 && $rowData['created_by'] != $_SESSION['is_admin_login'] ){
       return '<button class="btn btn-danger btn-xs" onclick="fnDelete('.$rowData['id'].')">Delete</button>';
    }
    return '';
}

function  getAccessViewList($createdBy = 'created_by'){
    $userId = '';
    $ci = & get_instance();
        //if ($accessLevel['is_his_view'] == 1 && $accessLevel['is_other_view'] == 1) {
            //$userId = '';
        //}else
        if($ci->data['accessLevel']['is_his_view'] == 1 && $ci->data['accessLevel']['is_other_view']!= 1){
            $userId = $createdBy." = '". $_SESSION['is_admin_login']."'";
        } 
        if($ci->data['accessLevel']['is_his_view'] != 1 && $ci->data['accessLevel']['is_other_view'] == 1){
            $userId = $createdBy." != '". $_SESSION['is_admin_login']."'";
        } 
        ////else {
            //$userId ='';
        //}
        return $userId;
}

