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
class Model_blog_article extends CI_Model {
    private $tableName = 'sp_articles';
    public function __construct() {
        parent::__construct();
    }


    function getArticleList($accessWhere='') {
        
        $query = $this->db->select("*")->from($this->tableName)->where('status!=', '2'); 
        if($accessWhere)
            $query =  $this->db->where($accessWhere);
        $query =  $this->db->order_by("position", 'ASC')->get();
        return ($query->num_rows() > 0) ? $query->result_array() : '';
    }
    function addArticle($action,$image='') {

        $insertData = array(
            'title' => $this->input->post('txtArticleName'),
            'slug' => $this->input->post('txtCatSlug'),
            'category_id' => $this->input->post('txtBlogCat'), 
            'body' => $this->input->post('article'),
            'meta_key' => $this->input->post('txtMetakey'),
            'meta_desc' => $this->input->post('txtMetaDesc'),
            'position' => $this->input->post('txtCatPosition')  
        ); 
        if($image){
            $insertData['banner'] = $image['file_name'];
        }
        switch ($action) {
            case 'edit':
                $insertData['updated_by'] = $_SESSION['user_id'];
                $insertData['updated_at'] = C_DATE_TIME; 
                $this->db->where('id', $this->input->post('hidCatId'));
                $this->db->update($this->tableName, $insertData);
                break;
            default:
                $insertData['created_by'] = $_SESSION['user_id'];
                $insertData['created_at'] = C_DATE_TIME;
                $this->db->insert($this->tableName, $insertData); 
                break;
        }
        return true;
    } 
    function deleteArticle() {

        $this->db->where('id', $this->input->post("hidDeleteId"));
        $this->db->update($this->tableName, array('status' => 2));
        return 1;
    }
    function categoryListOption() {

        $query = $this->db->select("id,name")->from($this->tableName)->where('status!=', '2')
                ->order_by("position", 'ASC')->get();
         return ($query->num_rows() > 0) ? $query->result_array() : '';
    }
}
