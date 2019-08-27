<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin/model_login');
    }

    public function index() { 
       /* $password = '8i9o0p-[';
        $passwor4d =  enc_password($password,'encode');
       $this->db->set('password',$passwor4d);
        $this->db->update("sp_user");
        die();*/
        
        /* Valid form */
        $this->form_validation->set_rules('txtUserName', 'txtUserName',
        'required|min_length[5]|max_length[12]',
        array(
                'required'      => 'You have not provided %s.' 
        ));
       $this->form_validation->set_rules('txtPassword', 'Password', 'required|min_length[5]|max_length[12]'); 
        if ($this->form_validation->run() == TRUE) {
            //check username in to database 
            $userData = $this->model_login->checkLoginUser($this->input->post("txtUserName"));
            $password = $userData['password'];
            //check login attempts  
           /* $attemptsCheck = $this->model_login->checkLoginAttempts($this->input->post("txtUserName"));
           $lastATime = $this->model_login->checkLastLoginAttempts($this->input->post("txtUserName")); 
 $checkAfterTime = strtotime(date("Y-m-d h:i:s",$lastATime['time'] + $this->config->item('login_try_after_time')));
 
            $loginTryAfterSecond = $this->config->item('login_try_after_time');
            if( $attemptsCheck <= $this->config->item('limitLoginAttempts')){ */
                if ($this->input->post("txtPassword") == enc_password($password,'d')) {
                    $this->model_login->setLoginData($userData);
                    $this->session->set_flashdata('message', "<p>".lang("login_success")."</p>");
                    $this->data['message'] = showSuccessMessage($this->session->flashdata('message'));
                    redirect("admin/dashboard","refresh");
                } else { 
                    //updatge login attempts
                    $this->model_login->setLoginAttempts($this->input->post("txtUserName"));
                    $this->session->set_flashdata('message', "<p>".lang("error_password")."</p>");
                    $this->data['message'] = showErrorMessage($this->session->flashdata('message'));
                }
            /*}else{ 
                    $this->session->set_flashdata('message', "<p>". sprintf(lang("login_attempts"),$attemptsCheck, floor( $loginTryAfterSecond / 60 ))." Min."."</p>");
                    $this->data['message'] = showErrorMessage($this->session->flashdata('message'));
            }*/
        } else {
            $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
        }
        $this->data['txtEmail'] = array(
            'name' => 'txtUserName',
            'id' => 'txtUserName',
            'type' => 'text',
            'value' => $this->form_validation->set_value('txtUserName'),
            'class' => 'form-control',
            'placeholder' => lang('user_name'),
            'data-error' => lang('user_name'),
            'required' => 'true'
        );
        $this->data['loginForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'novalidate' => 'true'
        );
        $this->data['txtpassword'] = array(
            'name' => 'txtPassword',
            'id' => 'txtPassword',
            'type' => 'password',
            'class' => 'form-control',
            'placeholder' => lang('password'),
            'autocomplete' => "false",
            'required' => 'true'
        );
        $this->data['btnSubmit'] = array(
            'type' => 'submit',
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'value' => lang('sign_in'),
            'class' => 'btn btn-primary btn-block btn-flat'
        );
        //$this->data["onLoadFunctionScript"] = "$('#myForm').validator()";
        $this->data["includeJs"] = '';
        $this->data["main_content"] = $this->load->view('admin/login', $this->data, TRUE);
        $this->templete->show_admin_login($this->data);
    }
}
