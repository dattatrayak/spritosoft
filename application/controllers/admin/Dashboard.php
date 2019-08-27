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
class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation'); 
    }
    function index(){  
        $this->data['pageName'] = 'dashboard';
        
        //$this->data['pageDetails'] = array('pageName' => 'dashboard','parent_id'=>'','title'=>'');
        $this->data["main_content"] = $this->load->view('admin/dashboard', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

}
