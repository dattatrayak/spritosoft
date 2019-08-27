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
class Getdata extends Admin_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->load->model('admin/model_state');
        
    } 
    function get_user_access_level(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $userId = $this->input->post('id'); 
        $userId = fnGetMultipleData('sp_user_access',"user_id='".$userId."'",'menu_id,is_add ,is_edit,is_delete,'
                . 'is_his_view,is_his_edit,is_his_delete,'
                . 'is_other_view,is_other_edit,is_other_delete');
        
        echo (!empty($userId)) ? json_encode($userId) : '';
    }
    function get_group_access_level(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $userId = $this->input->post('id'); 
        $userId = fnGetMultipleData('sp_group_access',"group_id='".$userId."'",'menu_id,is_add,'
                . 'is_edit,is_delete,is_his_view,is_his_edit,is_his_delete,'
                . 'is_other_view,is_other_edit,is_other_delete');
        
        echo (!empty($userId)) ? json_encode($userId) : '';
    }
    
    function get_states_option(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }  
        $countryId = $this->input->post('CountryId'); 
        $stateList = $this->model_state->getStateListOption($countryId); 
        echo (!empty($stateList)) ? json_encode($stateList) : '';
    }

}
