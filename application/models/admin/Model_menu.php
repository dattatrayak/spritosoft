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
class Model_menu extends CI_Model {

    public $dataArray = ['Root'];
    public $menuReturn = '';
    public $breadCrum = [];

    public function __construct() {
        parent::__construct();
    }
            
    function getBaseMenu($items = array(), $parent_id = 0) {
        $tree = '<ul class="asdf">';
        for ($i = 0, $ni = count($items); $i < $ni; $i++) {
            if ($items[$i]['parent_id'] == $parent_id) {
                $tree .= '<li>';
                $tree .= $items[$i]['title'];
                $tree .= $this->getBaseMenu($items, $items[$i]['id']);
                $tree .= '</li>';
            }
        }
        $tree .= '</ul>';
        return $tree;
    }

    function getAllMenu($menuGroup = 'admin') {
        $menuRes = $this->db->select("id,title,parent_id,level")
                ->from("sp_menu")
                ->where('menu_group', $menuGroup)
                ->where('status', '1')
                ->order_by("menu_order", "ASC")
                ->get();
        return $menuRes->result_array();
    }

//TESTING
    public function getAllCategory() {
        $this->db->select('distinct(SM.id),SM.title,SM.parent_id,SM.level,SM.url,SM.icon');
        $this->db->from('sp_menu as SM');
        $this->db->join('sp_group_access as SGA', 'SM.id=SGA.menu_id');
        $this->db->join('sp_user_access as SUA', 'SM.id=SUA.menu_id','left' );
        $this->db->where('parent_id', 0);

        $parent = $this->db->get(); 
        $categories = $parent->result();
        
        $i = 0;
        foreach ($categories as $p_cat) {

            $categories[$i]->sub = $this->sub_categories($p_cat->id);
            $i++;
        }
        return $categories;
    }

    public function sub_categories($id) {

        $this->db->select('distinct(SM.id),SM.title,SM.parent_id,SM.level,SM.url,SM.icon');
        $this->db->from('sp_menu as SM');
        $this->db->join('sp_group_access as SGA', 'SM.id=SGA.menu_id');
        $this->db->where('SM.parent_id', $id);
        $this->db->where('SGA.group_id', $_SESSION['user_type']);

        $child = $this->db->get();
        $categories = $child->result(); 
        //p($categories);
        $i = 0;
        foreach ($categories as $p_cat) {

            $categories[$i]->sub = $this->sub_categories($p_cat->id);
            $i++;
        }
        return $categories;
    }

    function addMenu($action) {
        $insertData = array(
            'parent_id' => $this->input->post('selCategory'),
            'title' => $this->input->post('txtMenuTitle'),
            'url' => $this->input->post('txtMenuUrl'),
            'page_heading' => $this->input->post('txtPageHeading'),
            'icon' => $this->input->post('txtMenuIcon'),
            'description' => $this->input->post('txtPageDes'),
            'menu_order' => $this->input->post('txtMenuPosition'),
            'status' => $this->input->post('radStatus'),
        );
        $insertData['level'] = substr_count($this->input->post('selLevel'),"-");
        switch ($action) {
            case 'edit':
                $insertData['updated_by'] = $_SESSION['user_id'];
                $insertData['updated_at'] = C_DATE_TIME;
                $this->db->where('id', $this->input->post('hidMenuId'));
                $this->db->update('sp_menu', $insertData);
                break;
            default:
                $insertData['created_by'] = $_SESSION['user_id'];
                $insertData['created_at'] = C_DATE_TIME;
                $this->db->insert('sp_menu', $insertData);
                break;
        }
        return true;
    }

    /*
     * $this->data['firstname']  = ! empty($user->first_name) ? htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8') : NULL;


     */

    function CategoryTree(&$output = null, $parent = 0, $indent = null) {
        $this->db->select('id,title,parent_id');
        $this->db->from('sp_menu');
        $this->db->where('parent_id', $parent);

        $child = $this->db->get();
        $categories = $child->result(); 
        foreach ($categories as $cat) {
            $this->dataArray[$cat->id] = $indent . $cat->title;
            $output .= '<option value=' . $cat->id . '>' . $indent . $cat->title . "</option>";
            if ($cat->id != $parent) {
                // in case the current category's id is different that $parent
                // we call our function again with new parameters
                $this->CategoryTree($output, $cat->id, $indent . "-");
            }
        }
        // return the list of categories
        return $this->dataArray;
    }

    function showSidebarMenu($selectedValue,$pageName,$activeClass='') { 
        if (!empty($selectedValue)) {
            foreach ($selectedValue as $menuValue) {  
                if (!empty($menuValue->sub)) {
            
                    $this->menuReturn .= '<li class="treeview">
                                    <a href="' . base_url('admin/' . $menuValue->url) . '"><i class="' . $menuValue->icon . '"></i><span>' . $menuValue->title . '</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">';

                    foreach ($menuValue->sub as $subMenu) {
            
                      /* $activeClass = '';
                            if($subMenu->url === $pageName){
                                $activeClass = 'class="active"';
                            }*/
                        if (!empty($subMenu->sub)) {
                            $this->menuReturn .= '<li class="treeview ">
                                    <a href="' . base_url('admin/' . $subMenu->url) . '"><i class="' . $subMenu->icon . '"></i> <span>' . $subMenu->title . '</span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">';
                            $this->showSidebarMenu($subMenu->sub,$pageName);
                            $this->menuReturn .= ' </ul>
                                </li> ';
                        } else {
                            
                            $this->menuReturn .= '<li><a href="' . base_url('admin/' . $subMenu->url) . '"><i class="' . $subMenu->icon . '"></i> <span>' . $subMenu->title . '</span></a></li>';
                        }
                    }
                    $this->menuReturn .= ' </ul>
                   </li> '; 
                } else {
                    //$this->menuReturn .= '<li class="parent-only-menu"><a href="' . base_url('admin/' . $menuValue->url) . '"><i class="' . $menuValue->icon . '"></i> <span>' . $menuValue->title . '</span></a></li>';
                }
            }
        }
        return $this->menuReturn;
    }
    
    function menuListing($where = array(),$page=1,$per_page=25){
        
        $this->db->select("*")->from('sp_menu');
        if(!empty($where)){ 
           $this->db->where($where,false); 
        }        
        $this->db->order_by('menu_order','ASC');
        
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : '';
    } 
    
    function deleteMenu(){
        
       $this->db->where('id', $this->input->post("hidDeleteId"));
       $this->db->delete('sp_menu');
        
    }
    public function breadcrumbData($id) {

        $this->db->select('id,title,parent_id,level,url,icon');
        $this->db->from('sp_menu');
        $this->db->where('id', $id); 
        $child = $this->db->get(); 
        $categories = $child->result_array();
        
        foreach ($categories as $p_cat) {
           $this->breadCrum[]= $p_cat;
           $this->breadcrumbData($p_cat['parent_id']); 
        }
        return array_reverse($this->breadCrum);
    }
}
