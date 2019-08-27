<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
        $this->data['base_url'] = $this->config->item('base_url');
        $this->data['assets_url'] = $this->config->item('assets_url');
        
        $this->data['image_url'] = $this->config->item('images_url');
        $this->data['js_url'] = $this->config->item('js_url');
        $this->data['css_url'] = $this->config->item('js_url');
        
        
    }

}

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $templateSkins = array("skin-blue","skin-black","skin-purple","skin-yellow","skin-red","skin-green");
        $layoutOption = array("fixed","layout-boxed","layout-top-nav","sidebar-collapse","sidebar-mini");
        $this->data['admin_title'] = "Spritosoft";
        $this->data['templateSkins'] = $templateSkins[0];
        $this->data['layoutOption'] = $layoutOption[4]; 
        $this->data['login_user'] = array("loginId"=>101, "LoginGroup"=>"webmaster");
        $urlSegment = $this->uri->segment(1)."/". $this->uri->segment(2);
        if (!$this->session->userdata('is_admin_login') && $urlSegment!='admin/login'){
            redirect('/admin/login', 'refresh');
        }
        
    }

}

class Public_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

}
