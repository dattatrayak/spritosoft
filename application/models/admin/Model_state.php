<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_login
 *
 * @author Dattatray Khatav
 */
class Model_state extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getStateList($countryId = '') {
        $this->db->select("S.id, S.name,C.name as countryName")->from("states as S")
                ->join("countries C", "C.id = S.country_id", "left");
        if ($countryId)
            $this->db->where("S.country_id", $countryId);
        $query = $this->db->group_by("C.id")
                        ->order_by("sortname", 'ASC')->get();
        return ($query->num_rows() > 0) ? $query->result_array() : '';
    }

    function addstates($action) {

        $insertData = array(
            'name' => $this->input->post('txtStateName'),
            'country_id' => $this->input->post('selCountry')
        );
        switch ($action) {
            case 'edit':
                /*  $insertData['updated_by'] = $_SESSION['user_id'];
                  $insertData['updated_at'] = C_DATE_TIME; */
                $this->db->where('id', $this->input->post('hidStateId'));
                $this->db->update('states', $insertData);
                break;
            default:
                /* $insertData['created_by'] = $_SESSION['user_id'];
                  $insertData['created_at'] = C_DATE_TIME; */
                $this->db->insert('states', $insertData);
                break;
        }
        return true;
    }

    function deleteCountry() {

        /* $this->db->where('id', $this->input->post("hidDeleteId"));
          $this->db->delete('countries'); */
        return 1;
    }

    function getStateListOption($countryId = '') {
        $this->db->select("S.id, S.name")->from("states as S");
        if ($countryId)
            $this->db->where("S.country_id", $countryId);
        $query = $this->db->order_by("S.name", 'ASC')->get();
        return ($query->num_rows() > 0) ? $query->result_array() : '';
    }

}
