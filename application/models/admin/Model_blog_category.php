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
class Model_blog_category extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    function getCategoryList() { 
        $query = $this->db->select("*")->from("sp_blog_category")->where('status!=', '2')         
                ->order_by("position", 'ASC')->get();   
        return ($query->num_rows() > 0) ? $query->result_array() : '';
    }
    function addBlogCategory($action,$image='') {

        $insertData = array(
            'name' => $this->input->post('txtCatName'),
            'slug' => $this->input->post('txtCatSlug'),
            'position' => $this->input->post('txtCatPosition')  
        ); 
        switch ($action) {
            case 'edit':
                $insertData['updated_by'] = $_SESSION['user_id'];
                $insertData['updated_at'] = C_DATE_TIME; 
                $this->db->where('id', $this->input->post('hidCityId'));
                $this->db->update('sp_blog_category', $insertData);
                break;
            default:
                $insertData['created_by'] = $_SESSION['user_id'];
                $insertData['created_at'] = C_DATE_TIME;
                $this->db->insert('sp_blog_category', $insertData); 
                break;
        }
        return true;
    } 
    function deleteBlogCategory() {

        $this->db->where('id', $this->input->post("hidDeleteId"));
        $this->db->update('sp_blog_category', array('status' => 2));
        return 1;
    }
    function categoryListOption() {

        $query = $this->db->select("id,name")->from("sp_blog_category")->where('status!=', '2')         
                ->order_by("position", 'ASC')->get();
         return ($query->num_rows() > 0) ? $query->result_array() : '';
    }
}
