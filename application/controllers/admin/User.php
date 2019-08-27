<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dashboard
 *
 * @author Dattatraya
 */
class User extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin/model_user');
        $this->load->model('admin/model_menu');
        $this->lang->load('menu_lang', 'english');
        $this->lang->load('user_lang', 'english');
    }

    function index() {
        $page = 1; 
        $this->data['pageName'] = 'user';
        $this->data['page'] = 1;
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
         
        $this->data['accessLevel'] = $accessLevel;
        /* if($this->input->post('hidDeleteId')){
          $this->model_menu->deleteMenu();
          } */
        $this->data['userForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );
        $this->data['userFormDel'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHidele",
            'novalidate' => 'true'
        );
        $this->data['hiddenData'] = array(
            'name' => 'hiddenId',
            'id' => "hiddenId"
        );
        $this->data["userListing"] = $this->model_user->getUser();
        $this->data['onLoadFunctionScript'] = "$('#example2').DataTable( )";
        $this->data["main_content"] = $this->load->view('admin/user/user_list', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

    function listing() {
        redirect('admin/user');
    }

    function add() {
        $this->data['strHidMenuId'] = '';
        $this->data['pageName'] = 'user/add';
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        if ($this->input->post('hidDeleteId')) {

            $this->model_user->deleteUser();
        }
        $userGroupList = $this->model_user->getTypeOption();
        array_unshift($userGroupList, array('id' => '', 'group_name' => '---Select User Group---'));

        $this->data['grounplist'] = array_column($userGroupList, 'group_name', 'id');
        if ($this->input->post("btnSubmit")) {

            $this->form_validation->set_rules('selGroup', 'Group', 'required');
            $this->form_validation->set_rules('txtFirstName', lang('user_first_name'), 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('txtLastName', lang('user_last_name'), 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('txtUserName', lang('user_name'), 'required|min_length[6]|max_length[50]');
            $this->form_validation->set_rules('txtEmail', lang('user_email'), 'required|min_length[4]|max_length[100]');
            if (!$this->input->post('hidUserId')) {
                $this->form_validation->set_rules('txtPasword', lang('password'), 'required|min_length[6]|max_length[12]');
                $this->form_validation->set_rules('txtConfirmPasword', lang('confirm_password'), 'required|min_length[6]|max_length[12]|matches[txtPasword]');
            }
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');
            if ($this->form_validation->run() == TRUE) {
                if ($this->input->post('hidUserId')) {
                    $this->model_user->addUser('edit');
                    //$this->data['message'] = showSuccessMessage("Menu updated successfully! ");
                    $this->session->set_flashdata('success', lang('user') . " " . lang("success_update"));
                    redirect('admin/user');
                } else {
                    $this->model_user->addUser('add');
                    //$this->data['message'] = showSuccessMessage("Menu added successfully! ");
                    $this->session->set_flashdata('success', lang('user') . " " . lang("success_added"));
                    redirect('admin/user');
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }
        if ($this->input->post("hidDataId")) {
            $editData = fnGetSinleRowData("sp_user", '*', "id='" . $this->input->post("hidDataId") . "'");
            $txtFirstName = $editData['firstName'];
            $txtLastName = $editData['lastName'];
            $txtUserName = $editData['userName'];
            $txtEmail = $editData['email'];
            $selGroup = $editData['user_group_id'];
            $this->data['radStatus'] = $editData['status'];
            $this->data['strHidUserId'] = $editData['id'];
            $this->data['onLoadScript'] = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {
            $txtFirstName = $this->form_validation->set_value('txtFirstName');
            $txtLastName = $this->form_validation->set_value('txtLastName');
            $txtUserName = $this->form_validation->set_value('txtUserName');
            $txtEmail = $this->form_validation->set_value('txtEmail');
            $selGroup = $this->form_validation->set_value('selGroup');
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            $this->data['onLoadScript'] = ($this->data['radStatus'] === 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
            $this->data['strHidUserId'] = '';
        }
        $this->data['userForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'novalidate' => 'true'
        );

        $this->data['txtUserName'] = array(
            'name' => 'txtUserName',
            'id' => 'txtUserName',
            'type' => 'text',
            'value' => $txtUserName,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('user_name'))),
            'data-error' => lang('user_name'),
            'required' => 'true'
        );
        $this->data['txtEmail'] = array(
            'name' => 'txtEmail',
            'id' => 'txtEmail',
            'type' => 'text',
            'value' => $txtEmail,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('user_email'))),
            'data-error' => lang('user_email'),
            'required' => 'true'
        );
        $this->data['txtFirstName'] = array(
            'name' => 'txtFirstName',
            'id' => 'txtFirstName',
            'type' => 'text',
            'value' => $txtFirstName,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('user_last_name'))),
            'data-error' => lang('user_last_name'),
            'required' => 'true'
        );
        $this->data['txtLastName'] = array(
            'name' => 'txtLastName',
            'id' => 'txtLastName',
            'type' => 'text',
            'value' => $txtLastName,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('user_last_name'))),
            'data-error' => lang('user_last_name'),
            'required' => 'true'
        );
        $this->data['txtPasword'] = array(
            'name' => 'txtPasword',
            'id' => 'txtPasword',
            'type' => 'text',
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('password'))),
            'data-error' => lang('password'),
            'required' => 'true'
        );
        $this->data['txtConfirmPasword'] = array(
            'name' => 'txtConfirmPasword',
            'id' => 'txtConfirmPasword',
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('confirm_password'))),
            'data-error' => lang('confirm_password'),
            'required' => 'true'
        );

        $this->data['txtUserType'] = array(
            'name' => 'selGroup',
            'id' => 'selGroup',
            'selected' => $selGroup,
            'class' => 'form-control',
            'options' => $this->data['grounplist'],
            'data-error' => lang('user_type_label')
        );

        $this->data['reSetCancle'] = array(
            'name' => 'btnReset',
            'id' => 'btnReset',
            'value' => lang('actions_reset'),
            'class' => 'btn btn-default btn-warning',
        );
        $this->data["radStatus"] = ($this->form_validation->set_value('radStatus')) ? $this->form_validation->set_value('radStatus') : '1';
        $this->data['btnSubmit'] = array(
            'type' => 'submit',
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'value' => lang('Save'),
            'class' => 'btn btn-primary'
        );

        $this->data["main_content"] = $this->load->view('admin/user/user_add', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

    function type() {
        $this->data['strHidMenuId'] = '';
        $this->data['pageName'] = 'user/type';
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        $dataEditStatus = '';
        if ($this->input->post("btnSubmit")) {
            $this->form_validation->set_rules('txtUserType', lang('user_type'), 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');
      
            if ($this->form_validation->run() == TRUE) {
               
                if ($this->input->post('hidUserGroupId')) {
                    $this->model_user->addUserType('edit');
                    //$this->data['message'] = showSuccessMessage("Menu updated successfully! ");
                    $this->session->set_flashdata('success', lang('user_type_updated'));
                    redirect('admin/user/type');
                } else {
                    $this->model_user->addUserType('add');
                    //$this->data['message'] = showSuccessMessage("Menu added successfully! ");
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }
        //delete user group
        if ($this->input->post('hidDeleteId')) {
            $this->model_user->deleteUserType();
            $this->session->set_flashdata('success', lang('user_type_delete'));
            redirect('admin/user/type');
        }
        if ($this->input->post("hidDataId")) {
            $editData = fnGetSinleRowData("sp_user_group", '*', "id='" . $this->input->post("hidDataId") . "'");
            $txtUserType = $editData['group_name'];
            $this->data['radStatus'] = $editData['status'];
            $this->data['strhidUserGroupId'] = $editData['id'];
            $dataEditStatus = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {
            $txtUserType = $this->form_validation->set_value('txtUserType');
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            $this->data['strhidUserGroupId'] = '';
        }
        $this->data['txtUserType'] = array(
            'name' => 'txtUserType',
            'id' => 'txtUserType',
            'type' => 'text',
            'value' => $txtUserType,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('user_type_label'))),
            'data-error' => lang('menu_title'),
            'required' => 'true'
        );
        $this->data['userTypeForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'novalidate' => 'true'
        );

        $this->data['reSetCancle'] = array(
            'name' => 'btnReset',
            'id' => 'btnReset',
            'value' => lang('actions_reset'),
            'class' => 'btn btn-default btn-warning',
        );
        $this->data['userForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );
        $this->data['userFormDel'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHidele",
            'novalidate' => 'true'
        );
        $this->data['hiddenData'] = array(
            'name' => 'hiddenId',
            'id' => "hiddenId"
        );
        $this->data["radStatus"] = ($this->form_validation->set_value('radStatus')) ? $this->form_validation->set_value('radStatus') : '1';
        $this->data['btnSubmit'] = array(
            'type' => 'submit',
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'value' => lang('Save'),
            'class' => 'btn btn-primary'
        );
        $this->data['functionLoadScript'] = "function giveAccess(id) {
                    $.ajax({
                        url: base_url + 'admin/getData/get_group_access_level',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            '" . $this->security->get_csrf_token_name() . "': $(\"input[name='" . $this->security->get_csrf_token_name() . "']\").val(),
                            'id': id},
                        success: function (data)
                        {
                            for (i = 0; i < data.length; i++) {
                                var menuid = '';
                                $.each(data[i], function (key, value) {
                                    if (key === 'menu_id') {
                                        menuid = value;
                                    } else {
                                        showSelectedCheck(key, menuid, value);
                                    }
                                });
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown)
                        {
                            $('#status').text('Server Error');
                        }
                    });
                    }
                    function showSelectedCheck(name,menuNameId ,status){
                                if(status == 1){
                                    $('#'+name+ menuNameId).iCheck('check');
                                    $('#'+name+ menuNameId).parent().parent().parent().parent().children().iCheck('check');
                                }else{
                                      $('#'+name+ menuNameId).iCheck('uncheck');
                                      $('#'+name+ menuNameId).parent().parent().parent().parent().children().iCheck('uncheck');
                                }
                             } 
                    ";
        $this->data['onLoadScript'] = " giveAccess(" . $this->data['strhidUserGroupId'] . "); $('#check-all').on('ifClicked', function(event){ 
                                            if(this.checked){
                                                $('.menuAccessLevel').iCheck('uncheck');
                                                $('.menuAccessLevelHead').iCheck('uncheck');
                                                
                                            }else{
                                                $('.menuAccessLevel').iCheck('check');  
                                                $('.menuAccessLevelHead').iCheck('check');  
                                            } 
                                        });  
                                        $('.menuAccessLevelHead').on('ifClicked',function(event){
                                             if(this.checked){
                                                $(this).parent().parent().next().find('.menuAccessLevel').iCheck('uncheck');
                                            }else{
                                                $(this).parent().parent().next().find('.menuAccessLevel').iCheck('check');  
                                            } 
                                             
                                        });" . $dataEditStatus;
        $this->data["menuListingAccess"] = $this->model_user->categoryTreeMenuLevel();
        $this->data["userTypeList"] = $this->model_user->getType();
        $this->data["main_content"] = $this->load->view('admin/user/user_type', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

    function accesslevel() {
        $this->data['pageName'] = 'user/accesslevel';
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        if ($this->input->post("btnSubmit")) {
           
            $this->form_validation->set_rules('userId', lang('user_name'), 'required|min_length[2]|max_length[100]');
            if ($this->form_validation->run() == TRUE) {

                $menuAccessArray = []; 
                $menuIds = $this->input->post("menuid"); 
                $userid = $this->input->post("userId");
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
               
                    $menuAccessArray[$i]['user_id'] = $userid;
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
                $insertFlag = $this->model_user->addUserManuAccess($menuAccessArray);
                if ($insertFlag) {
                    $this->session->set_flashdata('success', lang('user_access_insert'));
                    redirect('admin/user/accesslevel');
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }

        $this->data['btnSubmit'] = array(
            'type' => 'submit',
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'value' => lang('Save'),
            'class' => 'btn btn-primary'
        );
        $this->data['reSetCancle'] = array(
            'name' => 'btnReset',
            'id' => 'btnReset',
            'value' => lang('actions_reset'),
            'class' => 'btn btn-default btn-warning',
        );
        $this->data['menuForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'novalidate' => 'true'
        );
        $ajax = array(
            'url' => "admin/user/accesslevel",
            'data' => "",
            'type' => "post",
            'success' => "",
        );

        $this->data['onLoadScript'] = " $('#check-all').on('ifClicked', function(event){ 
                                            if(this.checked){
                                                $('.menuAccessLevel').iCheck('uncheck');
                                                $('.menuAccessLevelHead').iCheck('uncheck');
                                                
                                            }else{
                                                $('.menuAccessLevel').iCheck('check');  
                                                $('.menuAccessLevelHead').iCheck('check');  
                                            } 
                                        });  
                                        $('.menuAccessLevelHead').on('ifClicked',function(event){
                                             if(this.checked){
                                                $(this).parent().parent().next().find('.menuAccessLevel').iCheck('uncheck');
                                            }else{
                                                $(this).parent().parent().next().find('.menuAccessLevel').iCheck('check');  
                                            } 
                                             
                                        });";
        $this->data['functionLoadScript'] = "function giveAccess(id) {
                    $.ajax({
                        url: base_url + 'admin/getData/get_user_access_level',
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            '" . $this->security->get_csrf_token_name() . "': $(\"input[name='" . $this->security->get_csrf_token_name() . "']\").val(),
                            'id': id},
                        success: function (data)
                        {
                            for (i = 0; i < data.length; i++) {
                                var menuid = '';
                                $.each(data[i], function (key, value) {
                                    if (key === 'menu_id') {
                                        menuid = value;
                                    } else {
                                        showSelectedCheck(key, menuid, value);
                                    }
                                });
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown)
                        {
                            $('#status').text('Server Error');
                        }
                    });
                    }
                    function showSelectedCheck(name,menuNameId ,status){
                                if(status == 1){
                                    $('#'+name+ menuNameId).iCheck('check');
                                    $('#'+name+ menuNameId).parent().parent().parent().parent().children().iCheck('check');
                                }else{
                                      $('#'+name+ menuNameId).iCheck('uncheck');
                                      $('#'+name+ menuNameId).parent().parent().parent().parent().children().iCheck('uncheck');
                                }
                             } 
                    ";
        $this->data["menuListingAccess"] = $this->model_user->categoryTreeMenuLevel();
        $listUserArray = $this->model_user->getUser('id,userName,firstName,firstName,lastName,email');
        $this->data["userList"] = $listUserArray;
        $this->data["main_content"] = $this->load->view('admin/user/level_access', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

}
