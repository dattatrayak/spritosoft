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
class Menu extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin/model_menu');
        $this->lang->load('menu_lang', 'english');
    }

    function index() {

        $this->data['pageName'] = 'menu';
        $page = 1;
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        if ($this->input->post('hidDeleteId')) {
            $this->model_menu->deleteMenu();
        }
        $this->data['menuForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );
        $this->data['menuFormDel'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHidele",
            'novalidate' => 'true'
        );
        $this->data['hiddenData'] = array(
            'name' => 'hiddenId',
            'id' => "hiddenId"
        );
        $this->data["menuListing"] = $this->model_menu->menuListing('', $page, 15);
        $this->data['onLoadFunctionScript'] = "$('#example2').DataTable( )";
        $this->data["main_content"] = $this->load->view('admin/menu/menu_list', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

    function add() {
        $loadScript = '';
        $this->data['pageName'] = 'menu/add';
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        if ($this->input->post("btnSubmit")) {
            $this->form_validation->set_rules('selCategory', 'Parent', 'required');
            $this->form_validation->set_rules('txtMenuTitle', lang('menu_title'), 'required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('txtPageHeading', 'Page Heading', 'required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('txtMenuUrl', lang('menu_url'), 'required|min_length[4]|max_length[100]');
            $this->form_validation->set_rules('txtMenuIcon', 'Menu icon', 'required|min_length[6]|max_length[100]');
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');

            if ($this->form_validation->run() == TRUE) {
                if ($this->input->post('hidMenuId')) {
                    $this->model_menu->addMenu('edit');
                    //$this->data['message'] = showSuccessMessage("Menu updated successfully! ");
                    $this->session->set_flashdata('success', 'Menu updated successfully!');
                    redirect('admin/menu');
                } else {
                    $this->model_menu->addMenu('add');
                    //$this->data['message'] = showSuccessMessage("Menu added successfully! ");
                    $this->session->set_flashdata('success', 'Menu added successfully!');
                    redirect('admin/menu');
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }

        $this->data['menuForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'novalidate' => 'true'
        );
        $menuArray = $this->model_menu->CategoryTree();


        $this->data['menuParentOption'] = $menuArray;

        if ($this->input->post("hidDataId")) {
            $editData = fnGetSinleRowData("sp_menu", '*', "id='" . $this->input->post("hidDataId") . "'");
            $selCategory = $editData['parent_id'];
            $txtMenuTitle = $editData['title'];
            $txtMenuUrl = $editData['url'];
            $txtPageHeading = $editData['page_heading'];
            $txtPageDes = $editData['description'];
            $txtMenuIcon = $editData['icon'];
            $txtMenuPosition = $editData['menu_order'];
            $this->data['radStatus'] = $editData['status'];
            $this->data['strHidMenuId'] = $editData['id'];
            $loadScript = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {
            $selCategory = $this->form_validation->set_value('selCategory');
            $txtMenuTitle = $this->form_validation->set_value('txtMenuTitle');
            $txtMenuUrl = $this->form_validation->set_value('txtMenuUrl');
            $txtPageHeading = $this->form_validation->set_value('txtPageHeading');
            $txtPageDes = $this->form_validation->set_value('txtPageDes');
            $txtMenuIcon = $this->form_validation->set_value('txtMenuIcon');
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            $this->data['strHidMenuId'] = '';
            $txtMenuPosition = $this->form_validation->set_value('txtMenuPosition');
            $loadScript = ($this->data['radStatus'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        }

        $this->data['selCategory'] = array(
            'name' => 'selCategory',
            'id' => 'selCategory',
            'selected' => $selCategory,
            'class' => 'form-control',
            'options' => $this->data['menuParentOption'],
            'data-error' => lang('menu_title'),
            'required' => 'true'
        );
        $this->data['txtMenuTitle'] = array(
            'name' => 'txtMenuTitle',
            'id' => 'txtMenuTitle',
            'type' => 'text',
            'value' => $txtMenuTitle,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('menu_title'))),
            'data-error' => lang('menu_title'),
            'required' => 'true'
        );
        $this->data['txtMenuUrl'] = array(
            'name' => 'txtMenuUrl',
            'id' => 'txtMenuUrl',
            'type' => 'text',
            'value' => $txtMenuUrl,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('menu_url'))),
            'data-error' => lang('menu_url'),
            'required' => 'true'
        );
        $this->data['txtPageHeading'] = array(
            'name' => 'txtPageHeading',
            'id' => 'txtPageHeading',
            'type' => 'text',
            'value' => $txtPageHeading,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('page_heading'))),
            'data-error' => lang('page_heading'),
            'required' => 'true'
        );
        $this->data['txtPageDes'] = array(
            'name' => 'txtPageDes',
            'id' => 'txtPageDes',
            'type' => 'text',
            'value' => $txtPageDes,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('page_heading_desc')))
        );
        $this->data['txtMenuIcon'] = array(
            'name' => 'txtMenuIcon',
            'id' => 'txtMenuIcon',
            'cols' => '10',
            'value' => $txtMenuIcon,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('menu_icon'))),
            'data-error' => lang('menu_icon'),
            'required' => 'true'
        );

        $this->data['txtMenuPosition'] = array(
            'name' => 'txtMenuPosition',
            'id' => 'txtMenuPosition',
            'value' => $txtMenuPosition,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('menu_Position'))),
            'data-error' => lang('menu_Position'),
            'required' => 'true'
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
        $this->data['onLoadScript'] = $loadScript . " setTimeout(function(){ $('#selCategory').trigger('change');},500);";

        $this->data['onLoadFunctionScript'] = " $('#selCategory').change(function(){ $('#selLevel').val(this.options[this.selectedIndex].text);  });";

        $this->data["main_content"] = $this->load->view('admin/menu/menu_add', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

}
