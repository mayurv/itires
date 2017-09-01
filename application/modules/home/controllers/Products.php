<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('paypal_lib');
        $this->load->model('backend/product','users');
    }

    function index() {
//        $data = array();
        //get products data from database
//        $data['products'] = $this->product->getRows();
        //pass the products data to view
//        $this->load->view('products/index', $data);
    }

    

}
