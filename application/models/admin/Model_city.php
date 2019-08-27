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
class Model_city extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    function getCityList() { 
        $query = $this->db->select("CI.id, CI.name,S.name as stateName,C.name as CountryName")->from("cities as CI")
                ->join("states S","CI.state_id = S.id","left")
                ->join("countries C","C.id = S.country_id","left") 
                ->order_by("CI.name", 'ASC')->limit(200,0)->get();   
        return ($query->num_rows() > 0) ? $query->result_array() : '';
    }
    function addCities($action) {

        $insertData = array(
            'name' => $this->input->post('txtCitesName'),
            'state_id' => $this->input->post('selState')  
        ); 
        switch ($action) {
            case 'edit':
              /*  $insertData['updated_by'] = $_SESSION['user_id'];
                $insertData['updated_at'] = C_DATE_TIME;*/
                $this->db->where('id', $this->input->post('hidCityId'));
                $this->db->update('cities', $insertData);
                break;
            default:
                /*$insertData['created_by'] = $_SESSION['user_id'];
                $insertData['created_at'] = C_DATE_TIME;*/
                $this->db->insert('cities', $insertData); 
                break;
        }
        return true;
    }
    function editCiety($cityId){
        $query = $this->db->select("CI.id, CI.name,CI.state_id,S.name as stateName,C.id as CountryId")->from("cities as CI")
                ->join("states S","CI.state_id = S.id")
                ->join("countries C","C.id = S.country_id")
                ->where('CI.id',$cityId)->get();
        return ($query->num_rows() > 0) ? $query->row_array() : '';
    }
    
    function deleteCity() {

        /*$this->db->where('id', $this->input->post("hidDeleteId"));
        $this->db->delete('countries');*/
        return 1;
    } 
}
