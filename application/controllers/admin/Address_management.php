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
class Address_management extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin/model_country');
        $this->load->model('admin/model_state');
        $this->load->model('admin/model_city');
        $this->lang->load('address_lang', 'english');
    }

    function index() {
        redirect('admin/address_management/cities');
    }
    function country_management() {
        redirect('admin/address_management/cities');
    }

    function country() {
        $this->data['pageName'] = 'address_management/country';
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        $page = 1;
        $this->data['hidCountryId'] = '';
        if ($this->input->post('hidDeleteId')) {
            $this->model_country->deleteCountry();
        }
        if ($this->input->post("btnSubmit")) {
            $this->form_validation->set_rules('txtCountryName', lang('country_name'), 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('txtCountrySortName', lang('country_sort_name'), 'required|min_length[1]|max_length[100]');
            $this->form_validation->set_rules('txtCountryPhoneCode', lang('country_phone_code'), 'required|min_length[1]|max_length[11]|integer');
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');

            if ($this->form_validation->run() == TRUE) {

                if ($this->input->post('hidCountryId')) {
                    $this->model_country->addCountry('edit');
                    $this->session->set_flashdata('success', lang('country') . " " . lang("success_update"));
                    redirect(ADMIN.$this->data['pageName']);
                } else {
                    $this->model_country->addCountry('add');
                    $this->session->set_flashdata('success', lang('country') . " " . lang("success_added"));
                    redirect(ADMIN.$this->data['pageName']);
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }

        if ($this->input->post("hidDataId")) {
            $editData = fnGetSinleRowData("countries", '*', "id='" . $this->input->post("hidDataId") . "'");
            $txtCountryName = $editData['name'];
            $txtCountrySortName = $editData['sortname'];
            $txtCountryPhoneCode = $editData['phonecode'];
            $this->data['hidCountryId'] = $editData['id'];
            // $this->data['onLoadScript'] = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {
            $txtCountryName = $this->form_validation->set_value('txtCountryName');
            $txtCountrySortName = $this->form_validation->set_value('txtCountrySortName');
            $txtCountryPhoneCode = $this->form_validation->set_value('txtCountryPhoneCode');
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            //$this->data['onLoadScript'] = ($this->data['radStatus'] === 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
            $this->data['hidCountryId'] = '';
        }


        $this->data['countryForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'novalidate' => 'true'
        );

        $this->data['menuForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );

        $this->data['txtCountryName'] = array(
            'name' => 'txtCountryName',
            'id' => 'txtCountryName',
            'type' => 'text',
            'value' => $txtCountryName,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('country_name'))),
            'data-error' => lang('country_name'),
            'required' => 'true'
        );
        $this->data['txtCountrySortName'] = array(
            'name' => 'txtCountrySortName',
            'id' => 'txtCountrySortName',
            'type' => 'text',
            'value' => $txtCountrySortName,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('country_sort_name'))),
            'data-error' => lang('country_sort_name'),
            'required' => 'true'
        );
        $this->data['txtCountryPhoneCode'] = array(
            'name' => 'txtCountryPhoneCode',
            'id' => 'txtCountryPhoneCode',
            'type' => 'text',
            'value' => $txtCountryPhoneCode,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('country_phone_code'))),
            'data-error' => lang('country_phone_code'),
            'required' => 'true'
        );
        $this->data["radStatus"] = ($this->form_validation->set_value('radStatus')) ? $this->form_validation->set_value('radStatus') : '1';
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
        $this->data["countryList"] = $this->model_country->getCountryList('', $page, 15);
        $this->data['onLoadFunctionScript'] = "$('#example2').DataTable( )";
        $this->data["main_content"] = $this->load->view('admin/address/country_list', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

    function states() {

        $this->data['pageName'] = 'address_management/states';
        $page = 1;
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        if ($this->input->post('hidDeleteId')) {
            // $this->model_menu->deleteMenu(); 
        }
        if ($this->input->post("btnSubmit")) {
            $this->form_validation->set_rules('txtStateName', lang('states'), 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('selCountry', lang('country_name'), 'required|integer|max_length[11]');
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');

            if ($this->form_validation->run() == TRUE) {

                if ($this->input->post('hidStateId')) {
                    $this->model_state->addstates('edit');
                    $this->session->set_flashdata('success', lang('state') . " " . lang("success_update"));
                    redirect(ADMIN.'address_management/states');
                } else {
                    $this->model_state->addstates('add');
                    $this->session->set_flashdata('success', lang('state') . " " . lang("success_added"));
                    redirect(ADMIN.'address_management/states');
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }

        if ($this->input->post("hidDataId")) {
            $editData = fnGetSinleRowData("states", '*', "id='" . $this->input->post("hidDataId") . "'");
            $txtStateName = $editData['name'];
            $selCountry = $editData['country_id'];
            $this->data['hidStateId'] = $editData['id'];
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            // $this->data['onLoadScript'] = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {
            $txtStateName = $this->form_validation->set_value('txtCountryName');
            $selCountry = $this->form_validation->set_value('txtCountrySortName');
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            //$this->data['onLoadScript'] = ($this->data['radStatus'] === 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
            $this->data['hidStateId'] = '';
        }
        $countryList = $this->model_country->getCountryList();
        array_unshift($countryList, array('id' => '', 'name' => '---Select Country---'));

        $this->data['countryList'] = array_column($countryList, 'name', 'id');

        $this->data['txtStateName'] = array(
            'name' => 'txtStateName',
            'id' => 'txtStateName',
            'type' => 'text',
            'value' => $txtStateName,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('states'))),
            'data-error' => lang('states'),
            'required' => 'true'
        );
        $this->data['selCountry'] = array(
            'name' => 'selCountry',
            'id' => 'selCountry',
            'selected' => $selCountry,
            'class' => 'form-control',
            'options' => $this->data['countryList'],
            'data-error' => lang('user_type_label')
        );
        $this->data['stateForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );
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
        $this->data['stateFormDel'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHidele",
            'novalidate' => 'true'
        );
        $this->data['hiddenData'] = array(
            'name' => 'hiddenId',
            'id' => "hiddenId"
        );
        $this->data["statelist"] = $this->model_state->getStateList('', $page, 15);
        //p($this->data["statelist"]);
        $this->data['onLoadFunctionScript'] = "$('#example2').DataTable( )";
        $this->data["main_content"] = $this->load->view('admin/address/state_list', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

    function cities() {

        $this->data['pageName'] = 'address_management/cities';
        $page = 1;
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        $statesList = [];
        if ($this->input->post('hidDeleteId')) {
            // $this->model_menu->deleteMenu(); 
        }
        if ($this->input->post("btnSubmit")) {
            $this->form_validation->set_rules('txtCitesName', lang('cities_name'), 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('selCountry', lang('country_name'), 'required|integer|max_length[11]');
            $this->form_validation->set_rules('selState', lang('states'), 'required|integer|max_length[11]');
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');

            if ($this->form_validation->run() == TRUE) {

                if ($this->input->post('hidCityId')) {
                    $this->model_city->addCities('edit');
                    $this->session->set_flashdata('success', lang('city') . " " . lang("success_update"));
                    redirect('admin/address_management/cities');
                } else {
                    $this->model_city->addCities('add');
                    $this->session->set_flashdata('success', lang('city') . " " . lang("success_added"));
                    redirect('admin/address_management/cities');
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }

        if ($this->input->post("hidDataId")) {
             $editData = $this->model_city->editCiety($this->input->post("hidDataId"));
           
           
            $txtCitesName = $editData['name'];
            $selState = $editData['state_id'];
            $selCountry = $editData['CountryId'];
            $statesList = $this->model_state->getStateListOption($selCountry);
            $this->data['hidCityId'] = $editData['id'];
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            // $this->data['onLoadScript'] = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {
            $txtCitesName = $this->form_validation->set_value('txtCitesName');
            $selState = $this->form_validation->set_value('selState');
            $selCountry = $this->form_validation->set_value('selCountry');
            $statesList = $this->model_state->getStateListOption($selCountry);
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            //$this->data['onLoadScript'] = ($this->data['radStatus'] === 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
            $this->data['hidCityId'] = '';
        }
        
        $countryList = $this->model_country->getCountryList();
        array_unshift($countryList, array('id' => '', 'name' => '---Select Country---'));

        $this->data['countryList'] = array_column($countryList, 'name', 'id');
        
        $this->data['selCountry'] = array(
            'name' => 'selCountry',
            'id' => 'selCountry',
            'selected' => $selCountry,
            'class' => 'form-control',
            'options' => $this->data['countryList'],
            'data-error' => lang('user_type_label'),
            'onchange' => 'showState(\'selState\',this.value)'
        );
        
        //$statesList = $this->model_state->getStateList();
       
        array_unshift($statesList, array('id' => '', 'name' => '---Select states---'));

        $this->data['statesList'] = array_column($statesList, 'name', 'id');

        $this->data['txtCitesName'] = array(
            'name' => 'txtCitesName',
            'id' => 'txtCitesName',
            'type' => 'text',
            'value' => $txtCitesName,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('cities_name'))),
            'data-error' => lang('cities_name'),
            'required' => 'true'
        );
        $this->data['selState'] = array(
            'name' => 'selState',
            'id' => 'selState',
            'selected' => $selState,
            'class' => 'form-control',
            'options' => $this->data['statesList'],
            'data-error' => lang('states')
        );
        $this->data['cityForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );
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
        $this->data['cityFormDel'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHidele",
            'novalidate' => 'true'
        );
        $this->data['hiddenData'] = array(
            'name' => 'hiddenId',
            'id' => "hiddenId"
        );
        $this->data["citylist"] = $this->model_city->getCityList('', $page, 15);
        //p($this->data["statelist"]);
        $this->data['onLoadFunctionScript'] = "$('#example2').DataTable( )";
        $this->data["main_content"] = $this->load->view('admin/address/city_list', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

}
