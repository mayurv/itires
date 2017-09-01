<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');

class Home extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->library('pagination');
        $this->load->library('Ajax_pagination');
        $this->perPage = 6;

        //Paypal Payment gateway
        $this->load->library('paypal_lib');
        $this->load->library('pagination');
        $this->load->model(array('users', 'common_model', 'backend/section_model', 'backend/payment'));
        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details', 'backend/review_model'));

        $this->flexi = new stdClass;

        $this->load->library('flexi_cart');
        $this->load->model(array('users', 'backend/pages_model', 'enquiry_model'));

        $this->load->helper(array('url', 'language'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category', 'backend/product', 'testimonial', 'backend/blog_category', 'backend/site_section'));
        $this->load->model(array('country', 'state', 'city'));
        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));
        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'master/mst_model_size'));
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        /* Cart Library */
        $this->load->model('demo_cart_model');

//        $this->load->model(array('flexi_cart_admin'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
//        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

//        if (!$this->ion_auth->logged_in()) {
//            // redirect them to the login page
//            redirect('auth/login', 'refresh');
//        }
    }

// redirect if needed, otherwise display the user list
    public function index() {

        $categoryOptions = array();
        $itmCnt = count($this->data['cart_items']);
        if ($itmCnt > 0)
            $this->session->set_userdata('cart_url', base_url() . 'home/cart');

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['slider'] = $this->section_model->get_slider();
        $this->data['product_feature_details'] = $this->product->get_feature_product();

        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');


        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

//        $this->data['product_details'] = $this->product->get_products();
//        foreach ($this->data['product_details'] as $key => $value)
//            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
//
//        foreach ($this->data['product_details'] as $key => $value)
//            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);


        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); //+ $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['blog'] = $this->testimonial->get_blog_home();

        $this->data['product_offer_details'] = array();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $offerDatat = $this->product->get_all_offer_product();

//        echo '<pre>', print_r($offerDatat);die;
        if (isset($offerDatat) && !empty($offerDatat)) {
            foreach ($offerDatat as $key => $value) {
                if (!empty($offerDatat[$key]['category_id'])) {
                    $offerDatat[$key]['category_id'] = $value['category_id'];
                    $offerDatat[$key]['category_name'] = $this->product_category->get_category_name_by_id($value['category_id']);
                    $offerDatat[$key]['description'] = $value['description'];
                    $offerDatat[$key]['offer_product_thumb'] = $this->product->get_product_by_category_id($value['category_id'], NULL, '0', 3, 1);
//                $offerDatat[$key]['offer_product_thumb'] = $this->product->get_all_offer_product();
                } else
                    unset($offerDatat[$key]);
            }
        } else
            $offerDatat = NULL;

        $this->data['product_offer_details'] = $offerDatat;
//        echo '<pre>', print_r($offerDatat);die;
        //cms content


        $this->data['home_section'] = $this->site_section->home_page_sction();

        //print_r( $this->data['home_section']);

        $this->data = $this->_get_all_data();

        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        $this->data['service_category'] = $this->product_category->service_category();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/main_content', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function about_us() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data = $this->_get_all_data();
        $this->data['about_section'] = $this->site_section->about_page_sction();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/about_us', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function contact_us() {
        $this->data['contact_section'] = $this->site_section->contact_page_sction();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data = $this->_get_all_data();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/contact_us', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function sell_car() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/sell_car', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function single_post() {


        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/single_post', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function news_review() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', NULL);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/news_review', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function search_car() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/search_car', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop($categoryId = NULL, $subCategoryId = NULL) {

        $this->data = '';
        $categoryOptions = array();
        $page = 1;
        $config = array();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $user_id = $this->session->userdata('user_id');
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        if (isset($categoryId)) {
            $details = $this->product_category->get_category_name_by_id($categoryId);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data = $this->_get_all_data();
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        if ($categoryId != '') {
            $this->data['product_count'] = $this->product->count_by(array('category_id' => $categoryId));

            $total_row = ($this->data['product_count']);
        } else {
            $this->data['product_count'] = $this->product->count_all();
            $total_row = ($this->data['product_count']);
        }


//        $config["total_rows"] = $total_row;
////         echo $total_row;die();
////         echo $total_row;
//        $config["total_rows"] = $total_row;
//        $config["per_page"] = 6;
//        $config['use_page_numbers'] = FALSE;
//        $config['num_links'] = $total_row;
//
//        if ($this->uri->segment(4)) {
//            $page = ($this->uri->segment(4));
//        } else {
//            $page = 0;
//        }
//
//        $start = $page;
//
//        $limit = $config['per_page'];
//        $config['num_links'] = 3;
//        $config['full_tag_open'] = '<ul class="clearfix">';
//        $config['full_tag_close'] = '</ul>';
//        $config['prev_tag_open'] = '<li>';
//        $config['prev_tag_close'] = '</li>';
//        $config['next_tag_open'] = '<li>';
//        $config['next_tag_close'] = '</li>';
//        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
//        $config['cur_tag_close'] = '</a></li>';
//        $config['num_tag_open'] = '<li>';
//        $config['num_tag_close'] = '</li>';
////        echo $categoryId;die;
//        if (isset($categoryId) && $categoryId != null)
//            $config['base_url'] = base_url() . 'home/shop_pegination/' . $categoryId;
//        else
//            $config['base_url'] = base_url() . 'home/shop_pegination/0/' . $categoryId;
//
//        $this->pagination->initialize($config);
//                $totalRec = ($this->data['product_related_count']);

        /* Ajax Pagination */

        $config['uri_segment'] = 4;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterProduct';
        $this->ajax_pagination->initialize($config);
//        echo '<pre>', print_r($config);
        /* Ajax Pagination */

        $this->data['product_details'] = $this->product->get_product_by_category_id($categoryId, $subCategoryId, $config["per_page"]);
        //count($this->data['product_details']);
        if ($categoryId != null || $subCategoryId != null)
            $config['base_url'] = base_url() . 'home/shop_pegination';
        else
            $config['base_url'] = base_url() . 'home/shop_pegination';
//        echo '<pre>', print_r($this->data['product_details']);die;

        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop_pegination($categoryId = NULL, $start = NULL) {
        $categoryOptions = array();
        $this->data = '';
        $page = 1;
        $config = array();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $user_id = $this->session->userdata('user_id');
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        if (isset($categoryId)) {
            $details = $this->product_category->get_category_name_by_id($categoryId);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data = $this->_get_all_data();
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
//        $this->data['product_details_page'] = $this->product->get_product_by_category_id();
        if ($categoryId != '') {
            $this->data['product_count'] = $this->product->count_by(array('category_id' => $categoryId));
            $total_row = ($this->data['product_count']);
        } else {
            $this->data['product_count'] = $this->product->count_all();
            $total_row = ($this->data['product_count']);
        }


        $config["total_rows"] = $total_row;
        $config["per_page"] = 6;
        $config['use_page_numbers'] = FALSE;
        $config['num_links'] = $total_row;

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 0;
        }

        $start = $page;

        $limit = $config['per_page'];
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="clearfix">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li  >';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
//        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
//        $config['last_tag_close'] = '</a></li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['base_url'] = base_url() . 'home/shop_pegination/' . $categoryId . '/';
        $this->pagination->initialize($config);



        //$this->product->get_product_by_category_page($start, $limit,$this->uri->segment(3));

        $this->data['product_details'] = $this->product->get_product_by_category_page($categoryId, $start, $config["per_page"]);
        if ($categoryId != null || $subCategoryId != null)
            $config['base_url'] = base_url() . 'home/getPage';
        else
            $config['base_url'] = base_url() . 'home/getPage';
//        echo '<pre>', print_r($this->data['product_details']);die;

        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);

        /* Tire Size Array */

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop_product($produictId = NULL, $productCategoryId = null) {
        $categoryOptions = array();
        $user_id = $this->session->userdata('user_id');
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['review'] = $this->review_model->get_review($user_id, $produictId);
        $this->data['all_review'] = $this->review_model->get_all_reiview_products($produictId);
//        echo '<pre>', print_r( $this->data['all_review']);die;
        $average_rating = null;
        foreach ($this->data['all_review'] as $rData) {
            $average_rating += $rData['review_total'];
        }
//        echo $average_rating;
        $cnt = count($this->data['all_review']);
        if ($cnt != 0) {
            $average_rating = $average_rating / ($cnt * 5) * 5;
            $this->data['average_rating'] = $average_rating;
        } else {
            $this->data['average_rating'] = 0;
        }

        $this->data['check'] = $this->review_model->check_review_product($produictId, $user_id);
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');

        $this->data['product_details'] = $this->product->get_product_by_product_id($produictId);
        $this->data['product_id'] = $produictId;

        $prodcut_cat_detail = $this->product_sub_category->get_product_sub_attribute($productCategoryId);

        $this->data['product_related_count'] = $this->product->count_by(array('category_id' => $productCategoryId)); //$this->product->get_product_by_count($productCategoryId);

        $totalRec = ($this->data['product_related_count']);

        /* Ajax Pagination */

        $config['uri_segment'] = 4;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterRel';
        $this->ajax_pagination->initialize($config);
//        echo '<pre>', print_r($config);
        /* Ajax Pagination */

        $this->data['related_product_details'] = $this->product->get_product_by_category_id($productCategoryId);

        foreach ($prodcut_cat_detail as $key => $dataAtt) {
            $prodcut_cat_detail[$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
        }

        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($produictId);
            $this->data['product_details'][$key]['product_attr_details'] = $prodcut_cat_detail;
            $this->data['product_details'][$key]['prodcut_cat_edit_detail'] = $this->product_attribute->get_details_by_id($produictId);
        }


//        echo '<pre>', print_r($this->data['product_details']);die;

        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
//        $config["total_rows"] = 10;
//        $config["per_page"] = 6;
//        $config['use_page_numbers'] = TRUE;
//        //$config['num_links'] = $total_row;
//        if ($this->uri->segment(3)) {
//            $page = ($this->uri->segment(3));
//        } else {
//            $page = 1;
//        }
//        if ($this->uri->segment(4)) {
//            $page = ($this->uri->segment(4));
//        } else {
//            $page = 1;
//        }
//
//        $start = $page;
//        $limit = $config['per_page'];
//        $config['full_tag_open'] = '<ul class="clearfix">';
//        $config['full_tag_close'] = '</ul>';
//        $config['prev_tag_open'] = '<li  >';
//        $config['prev_tag_close'] = '</li>';
//        $config['next_tag_open'] = '<li>';
//        $config['next_tag_close'] = '</li>';
//        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
//        $config['last_tag_close'] = '</a></li>';
//        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
//        $config['cur_tag_close'] = '</a></li>';
//        $config['num_tag_open'] = '<li>';
//        $config['num_tag_close'] = '</li>';
//        $config['base_url'] = base_url() . 'home/shop/' . $productCategoryId;
//        $this->pagination->initialize($config);

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */


        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/shop_product', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function element() {
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/element', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function home_search() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home_search', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function home_shop() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/home_shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function filters($productId = null) {
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['category_title'] = "Shop";
        $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/filter', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function cart() {
        $categoryOptions = array();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->data['cart_items'] = $this->flexi_cart->cart_items();
//        echo '<pre>', print_r($this->data['cart_items']);die;
        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
//        echo '<pre>', print_r($this->data['cart_items']);die;
        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }

        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'cart', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function checkout($retrunType = null) {
//        echo '<pre>', print_r($this->data['cart_summary']);die;
        if (empty($this->data['cart_items']) && $retrunType == null) {
            redirect('home/shop');
        }
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();
        $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('countryname');
        $this->data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'checkout', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function blogs($blogID = null) {

        $this->data['blog_category'] = $this->blog_category->as_array()->get_all();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        foreach ($this->data['blog_category'] as $k => $pData) {
            $this->data['blog_category'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['blog_count'] = $this->testimonial->get_blog();
        $this->data['blog_d'] = $this->testimonial->get_blog_d();
        $config = array();
        $config["base_url"] = base_url() . "home/blogs/";
        $total_row = $this->testimonial->get_blog();

        $config["total_rows"] = $total_row;
        // $config["total_rows"] = 10;
        $config["per_page"] = 3;
        $config['use_page_numbers'] = TRUE;
        //$config['num_links'] = $total_row;
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 1;
        }
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="clearfix">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li  >';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
        $config['last_tag_close'] = '</a></li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
//        $config['base_url'] = base_url() . 'home/blogs/';
        $this->pagination->initialize($config);

        if (isset($blogID))
            $this->data['blog'] = $this->testimonial->blog_details($config["per_page"], $page, $blogID);
        else
            $this->data['blog'] = $this->testimonial->blog_details($config["per_page"], $page);

//        $str_links = $this->pagination->create_links();
//        $this->data["links"] = explode('&nbsp;', $str_links);



        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        $this->data = $this->_get_all_data();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_blogs', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function blog_cat($blogID = null) {

        $this->data['blog_category'] = $this->blog_category->as_array()->get_all();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        foreach ($this->data['blog_category'] as $k => $pData) {
            $this->data['blog_category'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['blog_count'] = $this->testimonial->get_blog();
        $this->data['blog_d'] = $this->testimonial->get_blog_d();
        $config = array();

        $config["base_url"] = base_url() . "home/blogs/";
        $total_row = $this->testimonial->get_blog();

        $config["total_rows"] = $total_row;
        // $config["total_rows"] = 10;
        $config["per_page"] = 3;
        $config['use_page_numbers'] = TRUE;
        //$config['num_links'] = $total_row;
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 1;
        }
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="clearfix">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li  >';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
        $config['last_tag_close'] = '</a></li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['base_url'] = base_url() . 'home/blog_cat/';
//        $this->pagination->initialize($config);

        if (isset($blogID))
            $this->data['blog'] = $this->testimonial->blog_cat_detail($blogID);
        //else
        // $this->data['blog'] = $this->testimonial->blog_cat_detail($blogID);
//        if (isset($blogID))
//            $this->data['blog'] = $this->testimonial->blog_cat_detail($blogID);
//      
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        //$this->data = $this->_get_all_data();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_blogs', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function single_blog() {
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $blog_id = $this->uri->segment(3);

        $this->data['single_post'] = $this->testimonial->get_single_post($blog_id);
        $this->data['blog_category'] = $this->blog_category->as_array()->get_all();
        foreach ($this->data['blog_category'] as $k => $pData) {
            $this->data['blog_category'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $blog_id = $this->uri->segment(3);

        $this->data['single_post'] = $this->testimonial->get_single_post($blog_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $cid = array();
        foreach ($this->data['single_post'] as $category) {
            $cid[] = $category['category_id'];
        }

        $this->data['related_blog'] = $this->testimonial->get_relative_blog($cid[0]);
//        print_r( $this->data['related_blog']);
//        exit;
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data['home_section'] = $this->site_section->home_page_sction();


        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_blogs_single', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function productFilter($method = null) {


        $user_id = $this->session->userdata('user_id');
        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */
        $categoryOptions = array();


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'bysize') {

            $bysize = $this->input->post('size1') . '/' . $this->input->post('size2') . 'R' . $this->input->post('size3');
            $this->session->set_userdata('sess_bysize', $bysize);
            //$bysize session 
//            $make_id = null, $year_id = null, $model_id = null, $product_category_id = null, $product_sub_category = null, $searchTearm = null, $start = null, $limit = null, $filterTearm = null
            $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
            foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
                $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            }
            if (isset($product_category_id) && $product_category_id != '') {

                $details = $this->product_category->get_category_name_by_id($product_category_id);
                $this->data['category_title'] = $details['name'];
                $this->data['category_description'] = $details['description'];
                if (isset($product_sub_category) && $product_sub_category != '') {
                    $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);
                    $this->data['category_title'] = $details['name'];
                }
            } else {
                $this->data['category_title'] = "Shop";
                $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
            }

            $this->data['testi_monial'] = $this->testimonial->get_testimonial();


            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
            $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
            $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
            $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');


            $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, $bysize);
            $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);

            $this->data['testi_monial'] = $this->testimonial->get_testimonial();
            $this->data['blog'] = $this->testimonial->get_blog_home();

            $this->data['home_section'] = $this->site_section->home_page_sction();
            $this->data['testi_monial'] = $this->testimonial->get_testimonial();
            $this->data['pages'] = $this->pages_model->as_array()->get_all();
            $this->data['brand_category'] = $this->pattribute->get_brands();
            $options = array();
            foreach ($this->data['brand_category'] as $bCat) {
                $options[$bCat['brand_id']] = $bCat['attrubute_value'];
            }
            $this->data['brand_category'] = array('' => 'Select Barand Category') + $options;

            $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
            $totalRec = ($this->data['product_count']);
            $this->data['product_count'] = $totalRec;

            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'home/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $config['link_func'] = 'searchFilterSize';
            $this->ajax_pagination->initialize($config);
            /* Tire Size Array */
            $allSize = $this->mst_model_size->get_all_size();
            $sizeOption1 = array();
            $sizeOption2 = array();
            $sizeOption3 = array();
            foreach ($allSize as $sizeData) {
                $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
                $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
                $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
            }
            $this->data['size1'] = array_unique($sizeOption1);
            $this->data['size2'] = array_unique($sizeOption2);
            $this->data['size3'] = array_unique($sizeOption3);
            /* Tire Size Array */

            /* Ajax Pagination */
            $this->template->set_master_template('landing_template.php');
            $this->template->write_view('header', 'snippets/header', $this->data);
            $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
            $this->template->write_view('content', 'shop', $this->data, TRUE);
            $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
            $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
            $this->template->write_view('footer', 'snippets/footer', '', TRUE);
            $this->template->render();


//            echo '<pre>', print_r($this->data['product_filter_count']);
//            die;
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user_id = $this->session->userdata('user_id');


            $session_data = array(
                'product_year' => $this->input->post('product_year'),
                'product_model' => $this->input->post('product_model'),
                'product_category' => $this->input->post('product_category'),
            );


            if ($this->input->post('product_make'))
                $session_data['product_make'] = $this->input->post('product_make');
            else
                $session_data['product_make'] = $this->input->post('product_make_recent');

            $this->session->set_userdata('recent_product', $session_data);

            $make_id = $session_data['product_make'];
            $year_id = $this->input->post('product_year');
            $model_id = $this->input->post('product_model');


            $product_category_id = $this->input->post('product_category');
            $product_sub_category = $this->input->post('product_sub_category');

            if (strstr($product_category_id, '_')) {
                $id = explode('_', $product_category_id);
                $product_category_id = $id[0];
                $product_sub_category = $id[1];
            } else {
                $product_category_id = $product_category_id;
                $product_sub_category = null;
            }





            $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
            foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
                $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            }
            if (isset($product_category_id) && $product_category_id != '') {

                $details = $this->product_category->get_category_name_by_id($product_category_id);
                $this->data['category_title'] = $details['name'];
                $this->data['category_description'] = $details['description'];
                if (isset($product_sub_category) && $product_sub_category != '') {
                    $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);
                    $this->data['category_title'] = $details['name'];
                }
            } else {
                $this->data['category_title'] = "Shop";
                $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
            }

            $this->data['testi_monial'] = $this->testimonial->get_testimonial();


            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
            $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
            $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
            $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
            $this->data['brand_category'] = $this->pattribute->get_brands();
            $options = array();
            foreach ($this->data['brand_category'] as $bCat) {
                $options[$bCat['brand_id']] = $bCat['attrubute_value'];
            }
            $this->data['brand_category'] = array('' => 'Select Barand Category') + $options;
//            echo $product_category_id;die;


            $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, $product_sub_category);
            $this->data['product_count'] = $this->data['product_filter_count'] = $this->product->get_filter_product_count($make_id, $year_id, $model_id, $product_category_id, $product_sub_category);


            /* Product Filter category */
            foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
                foreach ($categoryDp['sub_attibutes'] as $subAttr)
                    if ($subAttr['parent_id'] > 0) {
                        $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                    }
            }
            /* Get if category is tire */
            if ($product_category_id == 1) {
                $model_temp_id = $this->input->post('product_model');
//                echo $model_temp_id;die;
                //get all available size of model
                $model_detals = $this->mst_model_size->get_model_size_detail($model_temp_id);
//                echo '<pre>', print_r($model_detals);die;
                if (isset($model_detals) && !empty($model_detals)) {
                    foreach ($model_detals as $modelData) {
                        $other_product = $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, $modelData['size']);
                        if (isset($other_product) && !empty($other_product))
                            array_push($this->data['product_details'], $other_product[0]);
                    }
                }
                $unique_array = array();
                foreach ($this->data['product_details'] as $pDta) {
                    $hash = $pDta['id'];
                    $unique_array[$hash] = $pDta;
                }
                $this->data['product_details'] = $unique_array;
                $this->data['product_count'] = count($this->data['product_details']);

//                die;
            }
            /* Get if category is tire */


//            echo $brand_attr_id;die;
            $this->data['pages'] = $this->pages_model->as_array()->get_all();
            $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
            /* Product Filter category */
//            echo '<pre>', print_r($this->data['product_details'] );die;
            $this->data['home_section'] = $this->site_section->home_page_sction();
            $this->template->set_master_template('landing_template.php');
            $this->template->write_view('header', 'snippets/header', $this->data);
            $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

            if ($method == 'brand_filter') {
//                echo '<pre>', print_r($_POST);die;
                $bid = $this->input->post('brand_id');
//                $make_id = $session_data['product_make'];
                $make_id = $this->input->post('product_make');
                $year_id = $this->input->post('product_year');
                $model_id = $this->input->post('product_model');
                $product_category_id = $this->input->post('product_category_id');

                $filterTearm['brand'] = $bid;

                $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, null, null, null, null, $filterTearm);

//               echo '<pre>',print_r($this->data['product_details']);die();
                //$product_category_id = '';
                foreach ($this->data['product_details'] as $key => $model) {

                    $this->data['plugin_image'][$key] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id, null, $model['id']);
                    $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);
                }
                $totalRec = count($this->data['product_details']);
//                echo $totalRec;
//                echo '<pre>',print_r($this->data['plugin_image']);die();

                $config['target'] = '#postList';
                $connfig['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */

                $content = $this->load->view('product/_filter_result', $this->data, TRUE);
                if (isset($content)) {
                    echo json_encode($content);
                }
                die;
            }
            if ($method == 'price_filter') {

                $price_range = $this->input->post('price_range');
//                echo $price_range;
                $make_id = $this->input->post('product_make');
                $year_id = $this->input->post('product_year');
                $model_id = $this->input->post('product_model');
                $product_category_id = $this->input->post('product_category_id');

                $filterTearm['price'] = $price_range;
                $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, null, null, null, null, $filterTearm);
//               echo '<pre>',print_r($this->data['product_details']);die();
                foreach ($this->data['product_details'] as $model) {

                    $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id, $filterTearm);
                    $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);
                }

//                $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id);
//                $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);
                $totalRec = count($this->data['product_details']);
                $config['target'] = '#postList';
                $config['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */
                $content = $this->load->view('product/_filter_result', $this->data, TRUE);
                if (isset($content)) {
                    echo json_encode($content);
                }
//
                die;
            }
            if ($method == 'view_on_vehicle') {

                //echo 'KK';DIE;
//                $make_id  $year_id $model_id $product_category_id 
//                $this->data['model_name'] = $this->data['product_year'][$session_data['product_year']] . ' ' . $this->data['product_make'][$session_data['product_make']] . '  ' . $this->data['product_year'][$session_data['product_make']];
                /* Ajax Pagination */

                //echo $product_category_id;
                $brand_attr_id = null;
//            echo '<pre>', print_r($this->data['prodcut_cat_detail']);die;
                foreach ($this->data['prodcut_cat_detail'] as $subattr) {
                    if ($subattr['id'] == $product_category_id) {
                        foreach ($subattr['sub_attibutes'] as $subData) {
                            if ($subData['is_brand'] == 1) {
                                $brand_attr_id = $subData['p_sub_category_id'];
                            }
                        }
                    }
                }
                if ($brand_attr_id != null)
                    $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id($brand_attr_id);
                else
                    $this->data['brands_dtails'] = null;
//                echo '<pre>', print_r($this->data['brands_dtails']);die;

                $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, $product_sub_category, null, null, null);
//               echo '<pre>',print_r($this->data['product_details']);die();
                foreach ($this->data['product_details'] as $model) {
                    $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($model['make_id'], $model['year_id'], $model['model_id'], $model['category_id']);
                    $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model['model_id']);
                }

                $totalRec = ($this->data['product_filter_count']);
                $config['target'] = '#postList';
                $config['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */

                /* Best seller product */
                $this->data['best_seller_details'] = $this->product->get_best_seller_products();
//                echo '<pre>', print_r($this->data['best_seller_details']);die;
                /* Best seller product */

                $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id);
                $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);

                $this->template->write_view('content', 'filter', $this->data, TRUE);
            } else
                $this->template->write_view('content', 'shop', $this->data, TRUE);

//            $this->template->write_view('content', 'shop', NULL, TRUE);
            $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
            $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
            $this->template->write_view('footer', 'snippets/footer', '', TRUE);
            $this->template->render();
        } else {
            redirect('/home');
        }
    }

    public function search_by_brand($product_category_id = null, $product_sub_category = null) {



        if (isset($product_category_id) && $product_category_id != '') {
            $details = $this->product_category->get_category_name_by_id($product_category_id);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
            if (isset($product_sub_category) && $product_sub_category != '') {
                $details = $this->product_sub_category->get_sub_category_name_by_id($product_category_id);
                $this->data['category_title'] = $details['name'];
            }
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        $this->data = $this->_get_all_data();
        $this->data['brand_id']= $product_sub_category;
        $this->data['product_details'] = $this->product->get_filter_product(NULL, NULL, NULL, $product_category_id, $product_sub_category, 'brand');
        $this->data['product_count'] = $this->product_attribute->count_by(array('sub_attribute_dp_id'=>$product_sub_category));
        

        $totalRec = $this->data['product_count'];
        /* Ajax Pagination */

        $config['uri_segment'] = 3;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterBrand';
        $this->ajax_pagination->initialize($config);
//        echo '<pre>', print_r($config);
        /* Ajax Pagination */

        /* Product Filter category */
//            echo '<pre>', print_r($this->data['product_details'] );die;
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    function clear_cart() {
// The 'empty_cart()' function allows an argument to be submitted that will also reset all shipping data if 'TRUE'.
        $this->flexi_cart->empty_cart(TRUE);

// Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
//        redirect('/home/cart');
        return true;


//        redirect('standard_library/view_cart');
    }

    function clear_cart_all() {
        $this->flexi_cart->empty_cart(TRUE);

        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
        redirect('/home/cart');
        return true;


//        redirect('standard_library/view_cart');
    }

    function update_cart() {


        $this->data['cart_items'] = $this->flexi_cart->cart_items();

// Load custom demo function to retrieve data from the submitted POST data and update the cart.
        $this->demo_cart_model->demo_update_cart();

// If the cart update was posted by an ajax request, do not perform a redirect.
        if (!$this->input->is_ajax_request()) {
// Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            redirect('home/cart');
        }
    }

    function delete_item($row_id = FALSE) {
// The 'delete_items()' function can accept an array of row_ids to delete more than one row at a time.
// However, this example only uses the 1 row_id that was supplied via the url link.
        $this->flexi_cart->delete_items($row_id);

// Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

//        redirect('standard_library/view_cart');
    }

    function _get_all_data() {
        $categoryOptions = array();
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['slider'] = $this->section_model->get_slider();
        $this->data['product_feature_details'] = $this->product->get_feature_product();

        /**/
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');


        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

//        $this->data['product_details'] = $this->product->get_products();
//        foreach ($this->data['product_details'] as $key => $value)
//            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
//
//        foreach ($this->data['product_details'] as $key => $value)
//            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);


        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); //+ $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');



        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['blog'] = $this->testimonial->get_blog_home();

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['brand_category'] = $this->pattribute->get_brands();
        $options = array();
        foreach ($this->data['brand_category'] as $bCat) {
            $options[$bCat['brand_id']] = $bCat['attrubute_value'];
        }
        $this->data['brand_category'] = array('' => 'Select Barand Category') + $options;

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */


//        $this->data['flexi_cart'] = $this->session->userdata('flexi_cart');
//        $this->data['product_offer_details'] = $this->product->get_offer_product();
//        echo '<pre>',print_r($this->data['product_offer_details']);die;
        return $this->data;
    }

    function user() {

        $orderData = array();
        $orderData['checkout']['billing'] = array(
            'name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
            'company' => '',
            'add_01' => $this->input->post('billing_address'),
            'add_02' => '',
            'city' => $this->input->post('billing_city'),
            'state' => $this->input->post('billing_state'),
            'post_code' => $this->input->post('billing_zip'),
            'country' => $this->input->post('billing_country'),
        );
        $orderData['checkout']['shipping'] = array(
            'name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
            'company' => '',
            'add_01' => $this->input->post('billing_address'),
            'add_02' => '',
            'city' => $this->input->post('billing_city'),
            'state' => $this->input->post('billing_state'),
            'post_code' => $this->input->post('billing_zip'),
            'country' => $this->input->post('billing_country'),
        );
        $orderData['checkout']['email'] = $this->input->post('email');
        $orderData['checkout']['phone'] = $this->input->post('phone');
        $orderData['checkout']['comments'] = '';

        $response = $this->demo_cart_model->demo_save_order($orderData);

        echo '<pre>', print_r($response);
        die;
    }

    function getState() {
        $data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');
        return $data['state_list'];
    }

    function getCityList() {

        if (isset($_POST)) {


            $state_id = $_POST['state_id'];


            $cities = $this->city->get_CityListById($state_id);
            $st = '<option>Select</option>';
            foreach ($cities as $city) {
                $st .= '<option value="' . $city['id'] . '">' . $city['cityname'] . '</option>';
            }
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => $st));
        } else {
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => ''));
        }
    }

    function getStateList() {

        if (isset($_POST)) {

            $country_id = $_POST['country_id'];


            $states = $this->state->get_StateListById($country_id);
            $st = '';
            foreach ($states as $state) {
                $st .= '<option value="' . $state['id'] . '">' . $state['statename'] . '</option>';
            }
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => $st));
        } else {
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => ''));
        }
    }

    public function getSubDropdwon() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subAttrId = $this->input->post('sub_attribute_id');
            $data = $this->pattribute_sub->get_sub_attributes_at_id($subAttrId);
            $options = array();
//<<<<<<< HEAD
//            
//            $select = '<div class="form-group"><select class="form-control" name="parent_id[]">';
//            if (!empty($data)){
//            foreach ($data as $subData) 
//                $select .= '<option value="' . $subData['id'] . '">' . $subData['sub_name'] . '</option>';
//            
//            $select .= '</select></div>';
//            
//                }
//            echo json_encode(array('content' => $select));die;
//        }
//    }
//
//=======

            $select = '<div class="form-group"><select class="form-control" name="parent_id[]">';
            if (!empty($data)) {
                foreach ($data as $subData)
                    $select .= '<option value="' . $subData['id'] . '">' . $subData['sub_name'] . '</option>';

                $select .= '</select></div>';
            }
            echo json_encode(array('content' => $select));
            die;
        }
    }

    public function getBrands() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $subAttrId = $this->input->post('sub_attribute_id');
            $data = $this->pattribute_sub->get_sub_attributes_at_id($subAttrId);

            $options = array();

            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttrId);

            $attribute_brand_view = $this->load->view('product/_view_brand_list', $this->data, TRUE);
            echo json_encode(array('content' => $attribute_brand_view));
            die;
        }
    }

    function buy() {
        //Set variables for paypal form
        $productname = '';
        $user_id = $this->session->userdata('user_id');
        $returnURL = base_url() . 'home/success'; //payment success url
        $cancelURL = base_url() . 'home/cancel'; //payment cancel url
        $notifyURL = base_url() . 'paypal/ipn'; //ipn url

        $logo = base_url() . 'assets/images/codexworld-logo.png';

        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('custom', $user_id);

        foreach ($this->data['cart_items'] as $key => $cartData) {
            $productname .= $cartData['name'] . ',';
        }
        $this->paypal_lib->add_field('item_number', $this->data['cart_summary']['total_items']);
        $this->paypal_lib->add_field('item_name', $productname);
        $this->paypal_lib->add_field('amount', $this->data['cart_summary']['item_summary_total']);
        $this->paypal_lib->image($logo);

        $this->paypal_lib->paypal_auto_form();
    }

    function stripePay() {
        $this->load->view('stripe_payment');
    }

    function stripePaySubmit() {

        try {
            Stripe::setApiKey('sk_test_TSinCwEc7vZNsRCqozPQ5DmE');
            $charge = Stripe_Charge::create(array(
                        "amount" => $this->data['cart_summary']['item_summary_total'],
                        "currency" => "USD",
                        "card" => $this->input->post('access_token'),
                        "description" => "Stripe Payment"
            ));

            // this line will be reached if no error was thrown above
            $user_id = $this->session->userdata('user_id');

            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $charge->id,
                'payment_gross' => $charge->amount,
                'currency_code' => $charge->currency,
                'payment_status' => 'Completed',
            );

            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['row_id'] = $cartData['row_id'];
                $dataPayment['product_id'] = $cartData['id'];
//                $dataPayment['payment_gross'] = $cartData['internal_price'];
//                $dataPayment['payment_gross'] = $charge->amount;
                $this->payment->insert($dataPayment);
            }

            /* Best Seller Count */
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['product_sale_count'] = $cartData['quantity'];
                $dataPayment['product_quantity'] = $cartData['quantity'];
                $this->product->update_sale_count($cartData['id'], $dataPayment);
            }
            /* Best Seller Count */

//require_once(APPPATH.'third_party/fedex-common.php5');
//            require_once(APPPATH . 'third_party/ShipWebServiceClient.php5');
            //require_once(APPPATH.'third_party/TrackWebServiceClient.php5'); 
            $this->clear_cart();
            //$response = $this->payment->insert($data);
            if ($dataPayment) {
                echo json_encode(array('status' => 200, 'success' => 'Payment successfully completed.'));
                exit();
            } else {
                echo json_encode(array('status' => 500, 'error' => 'Something went wrong. Try after some time.'));
                exit();
            }
        } catch (Stripe_CardError $e) {
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
            echo json_encode(array('status' => 500, 'error' => $e->getMessage()));
            exit();
        } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
            echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));
            exit();
        } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
            echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));
            exit();
        } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        }
    }

    public function success() {

        //require_once(APPPATH.'third_party/fedex-common.php5');
//        require_once(APPPATH . 'third_party/ShipWebServiceClient.php5');
        //require_once(APPPATH.'third_party/TrackWebServiceClient.php5'); 

        $user_id = $this->session->userdata('user_id');
//        echo '<pre>', print_r($_POST);die;
        $dataPayment = array(
            'user_id' => $user_id,
            'txn_id' => $this->input->post('txn_id'),
            'payment_gross' => $this->input->post('payment_gross'),
            'currency_code' => $this->input->post('mc_currency'),
            'payer_email' => $this->input->post('payer_email'),
            'payment_status' => $this->input->post('payment_status'),
        );
        foreach ($this->data['cart_items'] as $key => $cartData) {
            $dataPayment['row_id'] = $cartData['row_id'];
            $dataPayment['product_id'] = $cartData['id'];
//            $dataPayment['payment_gross'] = $cartData['internal_price'];
            $dataPayment['payment_via'] = 'paypal';
            $this->payment->insert($dataPayment);
        }

        /* Best Seller Count */
        foreach ($this->data['cart_items'] as $key => $cartData) {
            $dataPayment['product_sale_count'] = $cartData['quantity'];
            $this->product->update_sale_count($cartData['id'], $dataPayment);
        }
        /* Best Seller Count */

        $this->clear_cart();
        redirect('home/checkout/success');
//        echo json_encode(array('content' => $_POST));
//        die;
    }

    public function cancel() {
        redirect('home/checkout/cancel');
    }

    public function orders() {

        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('countryname');
        $this->data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');
        $this->data['my_orders'] = $this->orders_summary->get_by_id($user_id);

//        echo '<pre>', print_r($this->data['my_orders']);die;
        $this->data = $this->_get_all_data();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'orders', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function page($id) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['pages1'] = $this->pages_model->get_record($id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
//        echo '<pre>', print_r($this->data['my_orders']);die;
        $this->data = $this->_get_all_data();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_simple_page', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function invoice($orderId) {


        $this->load->helper(array('dompdf', 'file'));
//        $admin_library/order_details order_invoice
        $this->admin_library->order_details($orderId);
//        $html = $this->load->view('invoice/invoice', $data, true, array(0, 0, 595, 841), 'a4', 'portrait');
        $html = $this->load->view('mng_product/_invoice', $data, true, array(0, 0, 595, 841), 'a4', 'portrait');

//        echo $html;die;
        // Uncomment

        pdf_create($html, 'invoice_' . $orderId, 'a4', 'lanscape');

        file_put_contents('assets/invoice/invoice_' . $orderId . ".pdf", pdf_create($html, 'invoice_' . $orderId, 0, 'a4', 'lanscape'));
    }

    public function our_services() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data = $this->_get_all_data();
        $this->data['ourservices_section'] = $this->site_section->ourservices_page_sction();
        $this->data['home_section'] = $this->site_section->home_page_sction();

        $this->data['service_category'] = $this->product_category->service_category();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/our_services', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function ajaxPaginationTest() {

        $this->data = $this->_get_all_data();

        //pagination configuration
        $data['posts'] = $this->data['product_details'] = $this->product->get_products();
        $totalRec = $this->product->count_all();

        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
//        $this->data = $this->_get_all_data();
        //get the posts data
        //load the view
        $this->load->view('post/index', $data);
    }

    public function product_enquiry($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "enquiry") {
            $pro_id = $this->input->post('product_id');
            $cat_id = $this->input->post('category_id');
            $enquiry = array(
                'product_name' => $this->input->post('product_name'),
                'product_id' => $this->input->post('product_id'),
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'description' => $this->input->post('message'),
                'phone' => $this->input->post('phone')
            );
            $message = 'Hi,<br><br>';
            $message .= 'Name :-' . $this->input->post('name') . '<br><br>';
            $message .= 'Product Name :-' . $this->input->post('product_name') . '<br><br>';
            $message .= 'Message :-' . $this->input->post('message') . '<br><br><br>';
            $message .= 'Thank You';
            $subject = 'Enquiry';
            $email = $this->input->post('email');

            $this->email($email, $message, $subject);

            $this->enquiry_model->insert($enquiry);
            $this->session->set_flashdata('message', 'Enquiry has been send');
        }

        redirect('home/shop_product/' . $pro_id . '/' . $cat_id);
    }

    public function review_rating($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "review") {
            $user_id = $this->session->userdata('user_id');
            $rate = $this->input->post('points');
            $product_id = $this->input->post('product_id');
            $dis = $this->input->post('dis');
            $id = $this->input->post('editid');
            $che = $this->review_model->check_review_product($product_id, $user_id);
            if ($che == true) {

                $arr = array(
//                    'product_id' => $product_id,
                    'discription' => $dis,
                    'review_total' => $rate,
//                    'user_id' => $user_id
                );
//           echo $id;           die()
                $this->review_model->update($id, $arr);
            } else {
                $arr = array(
                    'product_id' => $product_id,
                    'discription' => $dis,
                    'review_total' => $rate,
                    'user_id' => $user_id
                );
                $this->review_model->insert($arr);
            }
            echo json_encode(TRUE);
            //die();
            //redirect('')
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "edit" || $this->input->post('editid') != '') {

            $pid = $this->input->post('pid');
            $uid = $this->input->post('uid');

            $result = $this->review_model->get_review_edit($uid, $pid);
            if ($result) {
                echo json_encode($result);
            }
        }
//        echo json_encode(TRUE);
//        die();
    }

    public function contact($method = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "con") {

            $contact = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'message' => $this->input->post('message'),
                'url' => $this->input->post('url')
            );
            $message = 'Hi,<br><br>';
            $message .= 'Name :-' . $this->input->post('name') . '<br><br>';
            $message .= $this->input->post('message') . '<br><br><br>';
            $message .= 'Thank You';
            $email = $this->input->post('email');
            $subject = 'Contact US';
//
//            $this->common_model->sendEmail($message, $email, $subject);
            if ($this->enquiry_model->contact_us($contact)) {
                $this->email($email, $message, $subject);
                $this->session->set_flashdata('message', 'Message has been send');
                redirect('home/contact_us');
            }
        }
    }

    public function email($email, $message, $subject) {

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com'; //smtp host name
        $config['smtp_port'] = '465'; //smtp port number
        $config['smtp_user'] = 'ttire688';
        $config['smtp_pass'] = 'email1234'; //$from_email password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
        $this->email->from('ttire688'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }

    function ajaxPaginationData() {

        $conditions = array();

        //calc offset number
        $page = $this->input->post('page');

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $session_data = $this->session->userdata('recent_product');


        if ($this->input->post('product_make'))
            $session_data['product_make'] = $this->input->post('product_make');
        else
            $session_data['product_make'] = $this->input->post('product_make_recent');

        //total rows count
//        $data['posts'] = $this->data['product_details'] = $this->product->get_products();
//        $totalRec = $this->product->count_all();

        if ($this->input->post('keywords') != 'related_product' && $this->input->post('keywords') != 'by_size' && $this->input->post('keywords') != 'by_brand' && $this->input->post('keywords') != 'by_product') {

            $make_id = $session_data['product_make'];
            $year_id = $session_data['product_year'];
            $model_id = $session_data['product_model'];
        } else {
            $make_id = null;
            $year_id = null;
            $model_id = null;
        }


        $product_category_id = $this->input->post('product_category');
        $product_sub_category = $this->input->post('product_sub_category');
        if (isset($product_category_id) && $product_category_id != '') {

            $details = $this->product_category->get_category_name_by_id($product_category_id);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
            if (isset($product_sub_category) && $product_sub_category != '') {
                $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);
                $this->data['category_title'] = $details['name'];
            }
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at Tire Rack. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

//        echo $this->input->post('keywords');
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

//        $this->data['product_filter_count'] = $this->product->get_filter_product_count($make_id, $year_id, $model_id, $product_category_id, $product_sub_category);
        if ($this->input->post('keywords') == 'by_size') {
            $bysize = $this->session->userdata('sess_bysize');
            $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, $bysize);

            $this->data['product_count'] = $this->data['product_filter_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);
            $totalRec = ($this->data['product_count']);
        } else if ($this->input->post('keywords') == 'by_brand') {
            $this->data['product_details'] = $this->product->get_filter_product(NULL, NULL, NULL, $product_category_id, $product_sub_category, 'brand', $this->perPage, $offset);
            $this->data['product_count'] = $this->product_attribute->count_by(array('sub_attribute_dp_id'=>$product_sub_category));
//            $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);
            $totalRec = ($this->data['product_count']);
        } else if ($this->input->post('keywords') == 'by_product') {
            $this->data['product_details'] = $this->product->get_filter_product(NULL, NULL, NULL, $product_category_id, null, null, $this->perPage, $offset);
            $this->data['product_count'] = $this->product->count_by(array('category_id' => $product_category_id));
            $totalRec = ($this->data['product_count']);
        } else {
            $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, null, null, $this->perPage, $offset);
//        echo '<pre>', print_r($this->data['product_details']);die;
            $totalRec = $this->product->count_by(array('category_id' => $product_category_id)); //count($this->data['product_filter_count']);
        }
        $this->data['product_count'] = $totalRec;
        //pagination configuration
        $config['uri_segment'] = 3;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        if ($this->input->post('keywords') == 'related_product')
            $config['link_func'] = 'searchFilterRel';
        else if ($this->input->post('keywords') == 'by_brand')
            $config['link_func'] = 'searchFilterBrand';
        else if ($this->input->post('keywords') == 'by_size')
            $config['link_func'] = 'searchFilterBrand';
        else if ($this->input->post('keywords') == 'by_product')
            $config['link_func'] = 'searchFilterProduct';
        else
            $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get posts data
        //load the view
        if ($this->input->post('keywords') == 'related_product' || $this->input->post('keywords') == 'by_size' || $this->input->post('keywords') == 'by_brand')
            $this->load->view('product/ajax_product_view_related', $this->data, false);
        else
            $this->load->view('product/ajax_product_view', $this->data, false);
    }


    public function createShip() {
        $_POST['test'] = 'data';
        require_once(APPPATH . 'third_party/ShipWebServiceClient.php5');
    }

    public function trackShip($tackId) {
        $_POST['tackId'] = $tackId;
        $_SESSION['trackId'] = $tackId;

        require_once(APPPATH . 'third_party/TrackWebServiceClient.php5');
    }

}
