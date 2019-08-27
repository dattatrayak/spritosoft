<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Form_validation
 *
 * @author Dattatray Khatav
 */
class MY_Form_validation extends CI_Form_validation
{
    function edit_unique($value, $params)
    {
        $this->set_message('edit_unique', "This %s is already in use!");
        list($table, $field, $current_id) = explode(".", $params);
        $result = $this->CI->db->where($field, $value)->get($table)->row();
        return ($result && $result->id != $current_id) ? FALSE : TRUE;
    }
}