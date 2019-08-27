<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 *
 * @author Dattatraya khatav
 */
class Blog extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->lang->load('blog_lang', 'english');
        $this->load->model('admin/model_blog_category');
        $this->load->model('admin/model_blog_article');
    }

    function index() {
        redirect('admin/blog/articles');
    }

    function category() {
        $this->data['pageName'] = 'blog/category';
        $this->data['page'] = 1;
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        $this->data['accessLevel'] = $accessLevel;
        if ($this->input->post('hidDeleteId')) {
            $this->model_blog_category->deleteBlogCategory();
            $this->session->set_flashdata('success', lang('blog_category') . " " . lang("success_update"));
        }
        if ($this->input->post("btnSubmit")) {

            $this->form_validation->set_rules('txtCatName', lang('blog_category'), 'required|min_length[2]|max_length[100]');
            if ($this->input->post('hidCatId')) {
                $this->form_validation->set_rules('txtCatSlug', lang('blog_category_slug'), 'required|min_length[2]|max_length[100]|edit_unique[sp_blog_category.slug.' . $this->input->post('hidCatId') . ']');
            } else {
                $this->form_validation->set_rules('txtCatSlug', lang('blog_category_slug'), 'required|min_length[2]|max_length[100]|is_unique[sp_blog_category.slug]');
            }
            $this->form_validation->set_rules('txtCatPosition', lang('position'), 'required|min_length[1]|max_length[3]|is_natural');
            $this->form_validation->set_rules('radStatus', 'Status ', 'required');
            if ($this->form_validation->run() == TRUE) {
                if ($this->input->post('hidCatId')) {
                    $this->model_blog_category->addBlogCategory('edit');
                    //$this->data['message'] = showSuccessMessage("Menu updated successfully! ");
                    $this->session->set_flashdata('success', lang('blog_category') . " " . lang("success_update"));
                    redirect('admin/' . $this->data['pageName']);
                } else {
                    $this->model_blog_category->addBlogCategory('add');
                    //$this->data['message'] = showSuccessMessage("Menu added successfully! ");
                    $this->session->set_flashdata('success', lang('blog_category') . " " . lang("success_added"));
                    redirect('admin/' . $this->data['pageName']);
                }
            } else {
                $this->data['message'] = showErrorMessage((validation_errors()) ? validation_errors() : "");
            }
        }
        if ($this->input->post("hidDataId")) {
            $editData = fnGetSinleRowData("sp_blog_category", '*', "id='" . $this->input->post("hidDataId") . "'");
            $txtCatName = $editData['name'];
            $txtCatPosition = $editData['position'];
            $txtCatSlug = $editData['slug'];
            $this->data['radStatus'] = $editData['status'];
            $this->data['strHidCatId'] = $editData['id'];
            $this->data['onLoadScript'] = ($editData['status'] == 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
        } else {

            $txtCatName = $this->form_validation->set_value('txtCatName');
            $txtCatSlug = $this->form_validation->set_value('txtCatSlug');
            $txtCatPosition = $this->form_validation->set_value('txtCatPosition');
            $this->data['radStatus'] = $this->form_validation->set_value('radStatus');
            $this->data['onLoadScript'] = ($this->data['radStatus'] === 0 ) ? "$('#radStatus2').iCheck('check');" : "$('#radStatus1').iCheck('check');";
            $this->data['strHidCatId'] = '';
        }
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
        $this->data['hiddenData'] = array(
            'name' => 'hiddenId',
            'id' => "hiddenId"
        );
        $this->data['txtCatName'] = array(
            'name' => 'txtCatName',
            'id' => 'txtCatName',
            'type' => 'text',
            'value' => $txtCatName,
            'onblur' => 'showSlug(\'txtCatSlug\',this.value)',
            'class' => 'form-control',
            'placeholder' => ucfirst(strtolower(lang('blog_category'))),
            'data-error' => lang('blog_category'),
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
        $this->data['blogCat'] = $this->model_blog_category->getCategoryList();
        $this->data["main_content"] = $this->load->view('admin/blog/category', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

    function articles() {
        $this->data['pageName'] = 'blog/articles';
        $this->data['page'] = 1;
        $pageAccess = getPageAccessFromPageName($this->data['pageName']);
        
        $this->data['pageDetails'] = $pageAccess;
        $accessLevel = getMenuLevelAsscess($pageAccess['id']);
        
        $this->data['accessLevel'] = $accessLevel;
        $this->data['vp_news_picture'] = $this->config->item('vp_news_picture');
        if ($this->input->post('hidDeleteId')) {
            $this->model_blog_article->deleteArticle();
            $this->session->set_flashdata('success', lang('article') . " " . lang("success_update"));
        }
        $this->data['blogArticleForm'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHid",
            'novalidate' => 'true'
        );
        $this->data['blogArticleFormDel'] = array(
            'data-toggle' => "validator",
            'role' => "form",
            'class' => "formClassHidele",
            'novalidate' => 'true'
        );
        $accessWhere = getAccessViewList($accessLevel);
        $this->data['blogCat'] = $this->model_blog_article->getArticleList($accessWhere);
        $this->data["main_content"] = $this->load->view('admin/blog/articles', $this->data, TRUE);
        $this->templete->show_admin($this->data);
    }

}
