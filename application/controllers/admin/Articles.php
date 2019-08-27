<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dashboard
 *
 * @author Dattatraya
 */
class Articles extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('form_validation');
        $this->lang->load('blog_lang', 'english');
        $this->load->model('admin/model_blog_category');
        $this->load->model('admin/model_blog_article');
        $this->load->helper('ckeditor_helper');
    }

    function index() {
        redirect('admin/articles/add');
    }

    function add() { 
     
        $this->data['pageName'] = 'articles/add';
        $this->data['page'] = 1;
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        //p($pageAccess);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        if ($this->input->post('hidDeleteId')) {
            $this->model_blog_article->deleteArticle();
            $this->session->set_flashdata('success', lang('blog_category') . " " . lang("success_update"));
        }
        if ($this->input->post("btnSubmit")) {

            $this->form_validation->set_rules('txtArticleName', lang('article_title'), 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('txtBlogCat', lang('blog_category'), 'required|min_length[1]|max_length[3]|is_natural');
            if ($this->input->post('hidCatId')) {
                $this->form_validation->set_rules('txtCatSlug', lang('blog_category_slug'), 'required|min_length[2]|max_length[100]|edit_unique[sp_articles.slug.'.$this->input->post('hidCatId').']');
            }else{
                $this->form_validation->set_rules('txtCatSlug', lang('blog_category_slug'), 'required|min_length[2]|max_length[100]|is_unique[sp_articles.slug]');
            }
            $this->form_validation->set_rules('txtCatPosition', lang('position'), 'required|min_length[1]|max_length[3]|is_natural');
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');
            if ($this->form_validation->run() == TRUE) { 
                    $image = time().'-'.$_FILES["fileArt"]['name'];
                    $config['upload_path']          = './public/uploads/news';
                    $config['allowed_types']        = '*';
                    $config['max_size']             = 1000;
                    $config['max_width']            = 1024;
                    $config['max_height']           = 768;
                    $config['file_name']           = $image;
                   
                    $this->load->library('upload', $config);
                    $error = '';
                    $dataImages ='';
                    if(!empty($_FILES['fileArt']['name'])){
                        
                        if ( ! $this->upload->do_upload('fileArt'))
                        {   
                            $error = $this->upload->display_errors();
                        }
                        else
                        {
                            $dataImages = $this->upload->data();
                        }
                    }
                    if(!$error){
                       
                        if ($this->input->post('hidCatId')) {
                            $this->model_blog_article->addArticle('edit',$dataImages);
                            $this->session->set_flashdata('success', lang('article') . " " . lang("success_update"));
                            redirect('admin/' . $this->data['pageName']);
                        } else {
                            $this->model_blog_article->addArticle('add',$dataImages);
                            $this->session->set_flashdata('success', lang('blog_category') . " " . lang("success_added"));
                            redirect('admin/' . $this->data['pageName']);
                        }    
                    }else{
                         $this->session->set_flashdata('error',$error);
                    }
                
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }
        $bannerImage = '';
        if ($this->input->post("hidDataId")) {
            $editData = fnGetSinleRowData("sp_articles", '*', "id='" . $this->input->post("hidDataId") . "'");
           
            $txtArticleName = $editData['title'];
            $txtCatPosition = $editData['position'];
            $txtBlogCat = $editData['category_id'];
            $txtCatSlug = $editData['slug'];
            $txtbody = $editData['body'];
            $bannerImage = $editData['banner'];
            $txtMetaDesc = $editData['meta_desc'];
            $txtMetakey = $editData['meta_key'];
            $this->data['radStatus'] = $editData['status'];
            $this->data['strHidCatId'] = $editData['id'];
            $this->data['onLoadScript'] = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {

            $txtArticleName = $this->form_validation->set_value('txtArticleName');
            $txtCatSlug = $this->form_validation->set_value('txtCatSlug');
            $txtBlogCat = $this->form_validation->set_value('txtBlogCat');
            $txtCatPosition = $this->form_validation->set_value('txtCatPosition');
            $txtMetakey = $this->form_validation->set_value('txtMetakey');
            $txtbody = $this->form_validation->set_value('article');
            $txtMetaDesc = $this->form_validation->set_value('txtMetaDesc');
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            $this->data['onLoadScript'] = ($this->data['radStatus'] === 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
            $this->data['strHidCatId'] = '';
        }
         $this->data['bannerImage'] = $bannerImage;
        $blogCat = $this->data['catList'] = $this->model_blog_category->categoryListOption();
        array_unshift($blogCat, array('id' => '', 'name' => '---Select Category---'));
        $this->data['catList'] = array_column($blogCat, 'name', 'id');
        $this->data['blogCatForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );
        $this->data['blogCatFormDel'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHidele",
            'novalidate' => 'true'
        );
        $this->data['txtBlogCat'] = array(
            'name' => 'txtBlogCat',
            'id' => 'txtBlogCat',
            'selected' => $txtBlogCat,
            'class' => 'form-control',
            'options' => $this->data['catList'],
            'data-error' => lang('blog_category')
        );
        $this->data['hiddenData'] = array(
            'name' => 'hiddenId',
            'id' => "hiddenId"
        );
        $this->data['txtArticleName'] = array(
            'name' => 'txtArticleName',
            'id' => 'txtArticleName',
            'type' => 'text',
            'value' => $txtArticleName,
            'onblur' => 'showSlug(\'txtCatSlug\',this.value)',
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('article_title'))),
            'data-error' => lang('article_title'),
            'required' => 'true'
        );
        $this->data['txtCatSlug'] = array(
            'name' => 'txtCatSlug',
            'id' => 'txtCatSlug',
            'value' => $txtCatSlug,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('blog_category_slug'))),
            'data-error' => lang('blog_category_slug'),
            'required' => 'true'
        );
        $this->data['txtMetakey'] = array(
            'name' => 'txtMetakey',
            'id' => 'txtMetakey',
            'value' => $txtMetakey,
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('meta_key'))),
            'data-error' => lang('meta_key'),
            'required' => 'true'
        );
        $this->data['txtMetaDesc'] = array(
            'name' => 'txtMetaDesc',
            'id' => 'txtMetaDesc',
            'value' => $txtMetaDesc,
            'class' => 'form-control not_enter_next_line',
            'rows' => '5',
            'placeholder' => ucfirst(strtolower(lang('meta_desc'))),
            'data-error' => lang('meta_desc'),
            'required' => 'true'
        );
        $this->data['txtCatPosition'] = array(
            'name' => 'txtCatPosition',
            'id' => 'txtCatPosition',
            'value' => $txtCatPosition,
            'class' => 'form-control only_number',
            'placeholder' => ucfirst(strtolower(lang('position'))),
            'maxlength' => 4,
            'size' => 4,
            'data-error' => lang('position'),
            'required' => 'true'
        );
        $this->data['fileArt'] = array(
            'name' => 'fileArt',
            'id' => 'fileArt', 
            'class' => 'form-control', 
            'data-error' => lang('article_Image'),
            'required' => 'true'
        );
        $this->data['reSetCancle'] = array(
            'name' => 'btnReset',
            'id' => 'btnReset',
            'value' => lang('actions_reset'),
            'class' => 'btn btn-default btn-warning',
        );
        $this->data["radStatus"] = ($this->form_validation->set_value('radStatus')) ? $this->form_validation->set_value('radStatus') : '1';
        $this->data['btnSubmit'] = array(
            'type' => 'submit',
            'name' => 'btnSubmit',
            'id' => 'btnSubmit',
            'value' => lang('Save'),
            'class' => 'btn btn-primary'
        );
        $this->load->library('ckeditor');

        $this->ckeditor->basePath = base_url() . 'public/assets/ckeditor/';
		
		
        $this->ckeditor->config['width'] = '100%';
        $this->ckeditor->config['height'] = '300px';
        $this->data['txtbody'] = $txtbody;
        $this->data["includeHeader"] = '<script type="text/javascript" src="' . $this->config->item('assets_url') . 'ckeditor/ckeditor.js"></script>';
        $this->data['blogCat'] = $this->model_blog_article->getArticleList();
        $this->data["main_content"] = $this->load->view('admin/blog/articles_add', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

}
