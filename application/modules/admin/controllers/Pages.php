<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $data = $this->common_model->commonFunction();
         $this->load->database();
           $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));

        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        //$this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        // $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year'));

        /* Load Product model */
        // $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));
        $this->load->model('backend/section_model');
        $this->load->model('backend/site_section');
        $this->load->model('backend/pages_model');
        $this->load->model('backend/page_category');

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
    }
    
    public function page($editid = NULL)
    {
        //echo $editid ;
        if($editid==''){
            $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Pages';
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
         $this->data['page_category'] = $this->page_category->dropdown('category_name');
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'pages/_pages_view', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
        }
 else {
     $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
$this->data['pages'] = $this->pages_model->get_record($editid);
        $this->data['page_title'] = 'Manage Pages';
       // $this->data['pages'] = $this->pages_model->as_array()->get_all();
         $this->data['page_category'] = $this->page_category->dropdown('category_name');
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'pages/_edit_page', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
 }
          
    }
    
    public function add_page($method = NULL, $catId = NULL) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "add") {
            
            //print_r($_POST);
            $insertPage=array(
                    'title' => $this->input->post('title'),
                    'description'=> $this->input->post('editor'),
                    'category_id'=> $this->input->post('category_id'),
                    'title_menu'=> $this->input->post('mtitle'),
                    'link'=> $this->input->post('link'),
                    'status' => $this->input->post('status')
                     );
                $this->pages_model->insert($insertPage);
                $this->session->set_flashdata("msg", "Page  Added successfully!");

        }
         if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "edit") {
             //echo $catId;
              $insertPage=array(
                    'title' => $this->input->post('title'),
                    'description'=> $this->input->post('editor'),
                    'title_menu'=> $this->input->post('mtitle'),
                    'link'=> $this->input->post('link'),
                    'category_id'=> $this->input->post('category_id'),
                    'status' => $this->input->post('status')
                     );
                $this->pages_model->update($catId,$insertPage);
                $this->session->set_flashdata("msg", "Page Updated successfully!");
         }
        redirect('admin/pages/page');
        
    }
    

}
