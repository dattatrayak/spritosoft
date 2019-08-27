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
class Model_country extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    function getCountryList() {
        $query = $this->db->select("*")->from("countries")->order_by("sortname", 'ASC')->get();
        return ($query->num_rows() > 0) ? $query->result_array() : '';
    }
    function addCountry($action) {

        $insertData = array(
            'sortname' => $this->input->post('txtCountrySortName'),
            'name' => $this->input->post('txtCountryName'),
            'phonecode' => $this->input->post('txtCountryPhoneCode')
        ); 
        switch ($action) {
            case 'edit':
              /*  $insertData['updated_by'] = $_SESSION['user_id'];
                $insertData['updated_at'] = C_DATE_TIME;*/
                $this->db->where('id', $this->input->post('hidCountryId'));
                $this->db->update('countries', $insertData);
                break;
            default:
                /*9$insertData['created_by'] = $_SESSION['user_id'];
                $insertData['created_at'] = C_DATE_TIME;*/
                $this->db->insert('countries', $insertData);
                break;
        }
        return true;
    }
    
    
    function deleteCountry() {

        /*$this->db->where('id', $this->input->post("hidDeleteId"));
        $this->db->delete('countries');*/
        return 1;
    }

}
