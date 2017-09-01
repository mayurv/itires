<?php

class Section extends MY_Controller {

    public function __construct() {
        parent::__construct();
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

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Section';
        $this->data['section'] = $this->section_model->as_array()->get_all();

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'section/_section_view', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function edit_section($editid = NULL) {


        $this->data['home_page_section'] = $this->section_model->get_home_page_section($editid);


        if (empty($this->data['home_page_section'])) {
            //$this->data['home_page_section']= $this->section_model->get_home_page_section($editid);
            $this->data['edidid'] = $editid;
            $this->data['title_s'] = $this->section_model->as_array()->get($editid);
            $user_id = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['title'] = $this->section_model->get_home_title($editid);
            $this->data['page_title'] = 'Manage Section';
            $this->data['section'] = $this->section_model->as_array()->get_all();

            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', $this->data);
            $this->template->write_view('sidebar', 'backend/sidebar', NULL);
            $this->template->write_view('content', 'section/_edit_section', $this->data);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        } else {
         
            $this->data['title_s'] = $this->section_model->as_array()->get($editid);
          
            $this->data['home_page_section'] = $this->section_model->get_home_page_section($editid);
            $this->data['slider_page_section'] = $this->section_model->get_slider_page_section($editid);
            $this->data['title'] = $this->section_model->get_home_title($editid);
          
            $user_id = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);

            $this->data['page_title'] = 'Manage Section';
            $this->data['section'] = $this->section_model->as_array()->get_all();

            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', $this->data);
            $this->template->write_view('sidebar', 'backend/sidebar', NULL);
            $this->template->write_view('content', 'section/_update_section', $this->data);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }
      
    }

    public function add_section($method = NULL, $catId = NULL) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "add") {

            $error = array();
            $extension = array("jpeg", "jpg", "png", "gif");
            $banner = array();

            foreach ($_FILES["upload1"]["tmp_name"] as $key => $tmp_name) {
                $file_name = $_FILES["upload1"]["name"][$key];
                $file_tmp = $_FILES["upload1"]["tmp_name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                if (in_array($ext, $extension)) {
                    if (!file_exists("media/" . $file_name)) {
                        move_uploaded_file($file_tmp = $_FILES["upload1"]["tmp_name"][$key], "media/" . $file_name);
                    } else {
                        $filename = basename($file_name, $ext);
                        $fileeName = $filename . time() . "." . $ext;

                        array_push($banner, $fileeName);
                        $newFileName = $filename . time() . "." . $ext;
                        move_uploaded_file($file_tmp = $_FILES["upload1"]["tmp_name"][$key], "media/" . $newFileName);
                    }
                } else {
                    array_push($error, "$file_name, ");
                }
            }

            $indicator = array();
            foreach ($_FILES["upload2"]["tmp_name"] as $key => $tmp_name1) {
                $file_name1 = $_FILES["upload2"]["name"][$key];
                $file_tmp1 = $_FILES["upload2"]["tmp_name"][$key];
                $ext1 = pathinfo($file_name1, PATHINFO_EXTENSION);
                if (in_array($ext1, $extension)) {
                    if (!file_exists("media/upload/" . $file_name1)) {
                        move_uploaded_file($file_tmp1 = $_FILES["upload2"]["tmp_name"][$key], "media/upload/" . $file_name1);
                    } else {
                        $filename1 = basename($file_name1, $ext1);
//                        $indicator[] = $filename1 . time() . "." . $ext1;
                        $fileeNameInd = $filename1 . time() . "." . $ext1;

                        array_push($indicator, $fileeNameInd);
                        $newFileName1 = $filename1 . time() . "." . $ext1;
                        move_uploaded_file($file_tmp1 = $_FILES["upload2"]["tmp_name"][$key], "media/upload/" . $newFileName1);
                    }
                } else {
                    array_push($error, "$file_name1, ");
                }
            }

            $arr = $this->input->post('title1');
            for ($i = 0; $i < count($arr); $i++) {
                $insertB[] = array(
                    'title' => $this->input->post('title1')[$i],
                    'description' => $this->input->post('editor1')[$i],
                    'link' => $this->input->post('link1')[$i],
                    'banner_image' => $banner[$i],
                    'small_image' =>$indicator[$i],
                    'cms_id' => 1
                );
            }
            //print_r($insertB);
            //exit;
            if(!empty($insertB))
            {
            $this->site_section->insert_slider($insertB);
            }
           
            $arr1 = $this->input->post('title');
            for ($i = 0; $i < count($arr1); $i++) {
                $insertS[] = array(
                    'page_title' => $this->input->post('title')[$i],
                    'page_content' => $this->input->post('editor')[$i],
                    'cms_id' => $this->input->post('page_id')
                );
            }


            $this->site_section->insert_many($insertS);
            $this->session->set_flashdata("msg", "Section Added successfully!");
            redirect('admin/section');
        }
        
        /* Edit section */
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "edit") {
            
    if(isset($_FILES["upload1"]["tmp_name"]) && isset($_FILES["upload1"]["tmp_name"])){
         $error = array();
            $extension = array("jpeg", "jpg", "png", "gif");
            $banner = array();

            foreach ($_FILES["upload1"]["tmp_name"] as $key => $tmp_name) {
               // if (isset($tmp_name[$key]) && $tmp_name[$key] != '') {
                $file_name = $_FILES["upload1"]["name"][$key];
                $file_tmp = $_FILES["upload1"]["tmp_name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                if (in_array($ext, $extension)) {
                    if (!file_exists("media/backend/img/slider_img/" . $file_name)) {
                        move_uploaded_file($file_tmp = $_FILES["upload1"]["tmp_name"][$key], "media/backend/img/slider_img/" . $file_name);
                    } else {
                        $filename = basename($file_name, $ext);
                        $fileeName = $filename . time() . "." . $ext;

                        array_push($banner, $fileeName);
                        $newFileName = $filename . time() . "." . $ext;
                        move_uploaded_file($file_tmp = $_FILES["upload1"]["tmp_name"][$key], "media/backend/img/slider_img/" . $newFileName);
                    }
                } else {
                    array_push($error, "$file_name, ");
                }

            }

            $indicator = array();

            foreach ($_FILES["upload2"]["tmp_name"] as $key => $tmp_name1) {
              //  if (isset($tmp_name[$key]) && $tmp_name[$key] != '') {
                $file_name1 = $_FILES["upload2"]["name"][$key];
                $file_tmp1 = $_FILES["upload2"]["tmp_name"][$key];
                $ext1 = pathinfo($file_name1, PATHINFO_EXTENSION);
                if (in_array($ext1, $extension)) {
                    if (!file_exists("media/backend/img/slider_img/slider_small_image/" . $file_name1)) {
                       // echo 'ok';
                        move_uploaded_file($file_tmp1 = $_FILES["upload2"]["tmp_name"][$key], "media/backend/img/slider_img/slider_small_image/" . $file_name1);
                    } else {
                        $filename1 = basename($file_name1, $ext1);

                        $fileeNameInd = $filename1 . time() . "." . $ext1;

                        array_push($indicator, $fileeNameInd);
                        $newFileName1 = $filename1 . time() . "." . $ext1;
                        move_uploaded_file($file_tmp1 = $_FILES["upload2"]["tmp_name"][$key], "media/backend/img/slider_img/slider_small_image/" . $newFileName1);
                    }
                } else {
                    array_push($error, "$file_name1, ");
                }

            }

    
        $arr = $this->input->post('title1');
            for ($i = 0; $i < count($arr); $i++) {
                if($banner[$i]!='')
                {
                    $updateS[] = array(
                    'title' => $this->input->post('title1')[$i],
                    'description' => $this->input->post('editor1')[$i],
                    'link' => $this->input->post('link1')[$i],
                    'banner_image' => $banner[$i],
                    'our_img_slider' =>$our_img[$i],
                    'id' => $this->input->post('sid')[$i]
                );
                         $this->site_section->update_s($updateS);
           if(!empty($insertB))
            {
            $this->site_section->insert_slider($insertB);
            }
                      
                }
 else if($indicator[$i]!='') {
    $updateS[] = array(
                    'title' => $this->input->post('title1')[$i],
                    'description' => $this->input->post('editor1')[$i],
                    'link' => $this->input->post('link1')[$i],
                    'our_img_slider' =>$our_img[$i],
                    'small_image' =>$indicator[$i],
                    'id' => $this->input->post('sid')[$i]
                );
    $this->site_section->update_s($updateS);
 
 }
 else {
      $updateS[] = array(
                    'title' => $this->input->post('title1')[$i],
                    'description' => $this->input->post('editor1')[$i],
                    'link' => $this->input->post('link1')[$i],

                    'id' => $this->input->post('sid')[$i]
                );
    $this->site_section->update_s($updateS);
 }
              
            }
        }


                $logo=array();
                $config['upload_path']   = 'media/backend/img/logo/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc';
                $config['max_size']      = 1000;
                $config['max_width']     = 1024;
                $config['max_height']    = 768;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('logo'))
                {
                    array_push($logo, $this->input->post('logo_edit'));
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    array_push($logo, $data['upload_data']['file_name']);
                }
   /*our slider*/
                //$file_path_img='media/backend/img/our_services_slide/';
             $our_img_slider1=array();
              //  $config['upload_path']   = 'media/backend/img/our_services_slide/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc';
                $config['max_size']      = 1000;
                $config['max_width']     = 1024;
                $config['max_height']    = 768;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('our_img_1'))
                {
                    array_push($our_img_slider1, $this->input->post('our_img1'));
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                     $file_path_img_1='media/backend/img/logo/'.$data['upload_data']['file_name'];
                    array_push($our_img_slider1,$file_path_img_1);
                }
              $our_img_slider2=array();
              //  $config['upload_path']   = 'media/backend/img/our_services_slide/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc';
                $config['max_size']      = 1000;
                $config['max_width']     = 1024;
                $config['max_height']    = 768;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('our_img_2'))
                {
                    array_push($our_img_slider2, $this->input->post('our_img2'));
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $file_path_img_2='media/backend/img/logo/'.$data['upload_data']['file_name'];
                    array_push($our_img_slider2,$file_path_img_2);
                }
                
         $our_img_slider3=array();
               // $config['upload_path']   = 'media/backend/img/our_services_slide/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc';
                $config['max_size']      = 1000;
                $config['max_width']     = 1024;
                $config['max_height']    = 768;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('our_img_3'))
                {
                    array_push($our_img_slider3, $this->input->post('our_img3'));
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $file_path_img_3='media/backend/img/logo/'.$data['upload_data']['file_name'];
                    array_push($our_img_slider3, $file_path_img_3);
                }
                
            $our_img_slider4=array();
               // $config['upload_path']   = 'media/backend/img/our_services_slide/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc';
                $config['max_size']      = 1000;
                $config['max_width']     = 1024;
                $config['max_height']    = 768;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('our_img_4'))
                {
                    array_push($our_img_slider4, $this->input->post('our_img4'));
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());
                    $file_path_img_4='media/backend/img/logo/'.$data['upload_data']['file_name'];
                    array_push($our_img_slider4, $file_path_img_4);
                }
   /*End Slider*/             
   //print_r($our_img_slider4);
if (isset($logo))
            $arr1 = $this->input->post('title');
            for ($i = 0; $i < count($arr1); $i++) {

                $updateSection[] = array(
                    'cms_val_id' => $this->input->post('test')[$i],
                    'page_title' => $this->input->post('title')[$i],
                    'page_content' => $this->input->post('editor')[$i],
                    'logo' => $logo[0],
                    'our_slider_img' => $our_img_slider1[0],
                    'our_slider_img2' => $our_img_slider2[0],
                    'our_slider_img3' => $our_img_slider3[0],
                    'our_slider_img4' => $our_img_slider4[0],
                    
                );
            }

            $this->site_section->update_d($updateSection);
            $this->session->set_flashdata("msg", "Section Updated successfully!");
            redirect('admin/section');
        }

        
    }



    public function add_page_section($method = NULL, $pageid = NULL) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "add") {

            $insertPage = array(
                'page_alias' => $this->input->post('title'),
                'status' => $this->input->post('status')
            );



            $this->section_model->insert($insertPage);
            $this->session->set_flashdata("msg", "Page Section Added successfully!");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "edit") {

            $this->site_section->update_d($updateSection);
            $this->session->set_flashdata("msg", "Section Added successfully!");
        }

        redirect('admin/section');
    }
private function set_upload_options()
{   
    //upload an image options
    $config = array();
    $config['upload_path'] = 'media/backend/img/our_services_slide/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']      = '0';
    $config['overwrite']     = FALSE;

    return $config;
}
    public function add_slider() {

        @$upload1 = $_FILES['upload1']['name'];

        if ($upload1 !== "") {
            $upload1 = $_FILES['upload1']['name'];
            $upload2 = $_FILES['upload2']['name'];

            $config = array(
                'upload_path' => 'media/backend/img/slider_img/',
                'log_threshold' => 1,
                'allowed_types' => 'jpg|png|jpeg|gif',
                'max_size' => '0',
                'overwrite' => false
            );
            for ($i = 1; $i <= 2; $i++) {
                if (!empty('$upload' . $i)) {
                    $config['file_name'] = 'slider_img_' . $i;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('upload' . $i);
                    $upload_data = $this->upload->data();
                    $file_name[] = $upload_data['file_name'];
                }
            }


            $arr = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'banner_image' => $file_name[0],
                'small_image' => $file_name[1],
                'link' => $this->input->post('link')
            );

            $result = $this->slider_home->add_slider_backend($arr);
            if ($result) {
                redirect('admin/slider');
            }
        }
    }

    public function delete() {

        $id = $this->uri->segment(4);
        $result = $this->slider_home->delete_backend($id);
        if ($result) {
            echo '200';
        } else {
            echo '400';
        }
    }

}
