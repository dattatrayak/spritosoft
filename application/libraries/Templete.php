<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Templete
 *
 * @author Dattatraya Khatav
 * 19-08-2018
 * this libraries is used to show the template for admin as well as site
 */
class Templete {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function show_admin( $data = NULL) {
        if (empty($data)) {
            return NULL;
        } else {  
            $this->CI->load->model('admin/model_menu');
            $menuarray = $this->CI->model_menu->getAllCategory();
            //p($menuarray);
            $data['menuSide'] = $this->CI->model_menu->showSidebarMenu($menuarray,$data['pageName']); 
            if(isset($data['pageDetails']['parent_id'])){
                $data['breadcrumb'] = $this->CI->model_menu->breadcrumbData($data['pageDetails']['parent_id']);  
            }
        //p($this->template['menuSide']);
            $this->template['header'] = $this->CI->load->view('admin/template/header', $data, TRUE);
            $this->template['header_main'] = $this->CI->load->view('admin/template/header_main', $data, TRUE);
            $this->template['main_sidebar'] = $this->CI->load->view('admin/template/main_sidebar', $data, TRUE);
            //$this->data['main_content'] = $this->CI->load->view($content_path, $data, TRUE);
            $this->template['main_area'] = $this->CI->load->view('admin/template/main_area', $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('admin/template/footer', $data, TRUE);

            return $this->CI->load->view('admin/template/template', $this->template);
        }
    }

    public function show_admin_login($data = NULL) {
        if (!$data) {
            return NULL;
        } else {

            $data['templateSkins'] = "login-page";
            $data['layoutOption'] = "";
            $data['checkPage'] = "login Page";


            $this->template['header'] = $this->CI->load->view('admin/template/header', $data, TRUE);
            $this->template['main_area'] = $this->CI->load->view('admin/template/main_area', $data, TRUE);
            $this->template['footer'] = $this->CI->load->view('admin/template/footer', $data, TRUE);

            return $this->CI->load->view('admin/template/template', $this->template);
        }
    }

}
