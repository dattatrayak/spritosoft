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
class Model_login extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function checkLoginUser($userName) {
        if ($userName) {
            $getUserQuery = $this->db->select("id,userName,user_group_id,password,email,last_login")->from("sp_user")->where("userName", $userName)->get();
            return ($getUserQuery->num_rows() > 0 ) ? $getUserQuery->row_array() : '';
        }
        return false;
    }

    function setLoginData($data = array()) {
        if (!empty($data)) {
            $this->db->where("id", $data['id']);
            $this->db->update("sp_user", array("last_login" => time()));;
            //check Login Attempts
            $session_data = array(
                'user_id' => $data['id'],
                'userName' => $data['userName'],
                'user_type' => $data['user_group_id'],
                'email' => $data['email'],
                'old_last_login' => $data['last_login'],
                'last_check' => time(),
            );
            $this->session->set_userdata($session_data);
            $this->session->set_userdata("is_admin_login",$data['id']); 
            return TRUE;
        }
        return FALSE;
    }

    function checkLoginAttempts($userName) {
        $query = $this->db->select("id")->from("sp_login_attempts")->where("login", $userName)->get();
        return ($query->num_rows() > 0) ? $query->num_rows() : '';
    }

    function setLoginAttempts($userName) {

        $insertArray = array(
            "ip_address" => $this->input->ip_address(),
            "login" => $userName,
            "time" => time()
        );

        $this->db->insert("sp_login_attempts", $insertArray);
        return true;
    }

    function checkLastLoginAttempts($userName) {
        $query = $this->db->select("time")->from("sp_login_attempts")->where("login", $userName)->order_by("id", 'DESC')->limit(1)->get();
        return ($query->num_rows() > 0) ? $query->row_array() : '';
    }

}
