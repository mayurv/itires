<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));
        $this->load->library('Ajax_pagination_product');
        $this->perPage = 6;

        /* Load Backend model */
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'enquiry_model', 'backend/product_category', 'backend/product_sub_category'));

        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'backend/coupon_category', 'backend/coupon_method', 'backend/coupon_method_tax', 'backend/coupon_group'));
        $this->flexi = new stdClass;

        $this->load->library('flexi_cart');

        /* PHPExcel Library */
        $this->load->library('excel');

        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));

        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details', 'demo_cart_admin_model'));

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    // redirect if needed, otherwise display the user list
    public function index() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Administrator Dashboard';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'simple_page', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product_category($action = null, $pId = null) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

//            echo '<pre>', print_r($_POST);
//            die;
            $cat_img = array();
            $targetURL = 'media/backend/img/category_img/'; // Relative to the root
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'category_img' . DIRECTORY_SEPARATOR . $slug;

            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0777, true);
            }
            $config['upload_path'] = $targetURL;
            $config['allowed_types'] = 'png|jpg|gpeg';
            $config['max_size'] = 1000;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('product_cat_image')) {
                //array_push($modal_img, $this->input->post('logo_edit'));
            } else {
                $data = array('upload_data' => $this->upload->data());
                //print_r($data);
                $file_path = $targetURL . $data['upload_data']['file_name'];
                array_push($cat_img, $file_path);
            }
//                print_r($cat_img);
//                die();
            $dataProductCategory = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description'),
                'is_wheel' => $this->input->post('product_is_wheel'),
                'createdby' => $user_id,
                'img_url' => $cat_img[0],
                'createddate' => date('Y-m-d H:m:s'),
            );

            $insertedPID = $this->product_category->insert($dataProductCategory);

            $productSubCatArray = array(
                'p_category_id' => $insertedPID,
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $productSubCat = $this->input->post('parent_id');


            foreach ($productSubCat as $key => $subData) {
                if ($productSubCat[$key] != 0) {
                    $productSubCatArray['p_sub_category_id'] = $productSubCat[$key];
                    $this->product_sub_category->insert($productSubCatArray);
                }
            }
            $this->session->set_flashdata("msg", "Category Added successfully!");
            redirect('admin/product_category');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

            $img_url = array();

            $config['upload_path'] = 'media/backend/img/category_img/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 1000;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('product_cat_image')) {
                array_push($img_url, $this->input->post('img_url'));
            } else {
                $data = array('upload_data' => $this->upload->data());

                if ($data['upload_data']['file_name'] == '') {
                    array_push($img_url, $this->input->post('img_url'));
                } else {

                    $file_path = 'media/backend/img/category_img/' . $data['upload_data']['file_name'];
                    array_push($img_url, $file_path);
                }
            }
            // print_r($img_url);die();

            $dataProductCategoryUpdate = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description_' . $pId),
                'is_wheel' => $this->input->post('product_is_wheel_' . $pId),
                'modifiedby' => $user_id,
                'img_url' => $img_url[0],
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->product_category->update($pId, $dataProductCategoryUpdate);

            $this->product_sub_category->delete_sub_cat($pId);

            $productSubCat = $this->input->post('parent_id');
            $productSubCat = array_unique($productSubCat);

            $productSubCatEditArray = array(
                'p_category_id' => $pId,
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            foreach ($productSubCat as $key => $subData) {
                if ($productSubCat[$key] != 0) {
                    $productSubCatEditArray['p_sub_category_id'] = $productSubCat[$key];
                    $this->product_sub_category->insert($productSubCatEditArray);
                }
            }
            $this->session->set_flashdata("msg", "Category Updated successfully!");
            redirect('admin/product_category');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {

            $this->product_category->delete_cat($pId);
            $this->product_sub_category->delete_sub_cat($pId);
//            $this->session->set_flashdata("msg", "Record Deleted successfully!");
            echo json_encode(array('content' => 'success'));
            die;
        }

        $this->data['page_title'] = 'Manage Products Category';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
//        echo '<pre>', print_r($this->data['prodcut_cat_detail']);;die;

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
//        echo '<pre>', print_r($this->data['prodcut_cat_detail']);;die;
//        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all_details();
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute->dropdown('attrubute_value');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_view_p_category', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product($action = null, $productId = null) {


        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['excel_row'] = null;
        $this->data['excel_row_data'] = null;
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);


        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//        $this->data['product_csv_category'] = array('' => 'Select Category', 'all' => 'All') + $this->product_category->dropdown('name');
        $this->data['product_csv_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);

        $this->data['product_details_count'] = $this->product->count_all();

        $this->data['product_details'] = $this->product->get_products();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        $totalRec = ($this->data['product_details_count']);

        /* Ajax Pagination */

        $config['uri_segment'] = 4;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'admin/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchProductFilter';
        $this->ajax_pagination_product->initialize($config);
        /* Ajax Pagination */

        $this->data['size1'] = array(
            "255" => "255",
            "225" => "225",
            "235" => "235",
            "P235" => "P235",
            "215" => "215",
            "275" => "275",
            "P275" => "P275",
            "265" => "265",
            "P265" => "P265",
            "175" => "175",
        );
        $this->data['size2'] = array(
            "30" => "30",
            "35" => "35",
            "45" => "45",
            "50" => "50",
            "55" => "55",
            "60" => "60",
            "65" => "65",
            "70" => "70",
            "75" => "75",
            "80" => "80",
            "85" => "85",
            "90" => "90",
            "95" => "95",
        );
        $this->data['size3'] = array(
            "10" => "10",
            "12" => "12",
            "13" => "13",
            "14" => "14",
            "15" => "15",
            "16" => "16",
            "16/XL" => "16/XL",
            "15" => "15",
            "16.5" => "16.5",
            "17" => "17",
            "17/XL" => "17/XL",
            "17.5" => "17.5",
            "18" => "18",
            "19" => "19",
            "19.5" => "19.5",
            "20" => "20",
        );

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'add') {
            $this->data['page_title'] = 'Add Products';
            $this->session->set_flashdata("msg", "Product Added successfully!");
            $this->template->write_view('content', 'mng_product/_add_product', $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'addcsv') {

            $this->data['page_title'] = 'Add Products';
//            $this->session->set_flashdata("msg", "Product CSV Added successfully!");
            $this->template->write_view('content', 'mng_product/_add_product_csv', $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'exportcsv') {


            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//        $this->data['product_csv_category'] = array('' => 'Select Category', 'all' => 'All') + $this->product_category->dropdown('name');
            $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
            $this->data['product_year'] = array('' => 'Select Year');// + $this->mst_year->dropdown('name');
            $this->data['product_model'] = array('' => 'Select Model');// + $this->mst_model->dropdown('name');

            $this->data['product_details'] = $this->product->get_products();
            foreach ($this->data['product_details'] as $key => $productData) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($productData['id']);
                $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($productData['id']);
            }

            $tireData = array();
            $wheelData = array();
            $partsData = array();
            foreach ($this->data['product_details'] as $key => $productData) {
                $this->data['product_details'][$productData['category_id']]['prodcut_cat_edit_detail'] = $this->product_attribute->get_by_id($productData['id']);
            }
//            echo '<pre>', print_r($this->data['product_details']);
//            die;

            foreach ($this->data['product_details'] as $key => $productData) {
//                if ($productData['category_id'] == 1) {
                $make = '';
                $product_year = '';
                $model_id = '';
                if (isset($this->data['product_make'][$productData['make_id']]))
                    $make = $this->data['product_make'][$productData['make_id']];
                if (isset($this->data['product_year'][$productData['year_id']]))
                    $product_year = $this->data['product_year'][$productData['year_id']];
                if (isset($this->data['product_model'][$productData['model_id']]))
                    $model_id = $this->data['product_model'][$productData['model_id']];

                $tireData[$key] = array(
                    'product_sku' => $productData['product_sku'],
                    'product_name' => $productData['product_name'],
                    'category' => $this->data['product_category'][$productData['category_id']],
                    'make' => $make,
                    'year' => $product_year,
                    'model' => $model_id,
                    'brand' => '1',
                    'description' => $productData['description'],
                    'qty' => $productData['quantity'],
                );

                foreach ($productData['product_attr_details'] as $j => $attrDetail) {
                    $tireData[$key][$j] = $attrDetail['sub_attribute_value'];
                }
//                }
//                foreach ($productData['product_images_details'] as $l => $attrImgDetail) {
//                    $tireData[$l][$key] = $attrImgDetail['url'];
//                }
            }
//            echo '<pre>', print_r($tireData);die;



            $spreadsheet = new PHPExcel();

            $filename = 'itireonline_products_' . date('d-F-Y_h:i:s') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $spreadsheet->setActiveSheetIndex(0);

            $worksheetAss = $spreadsheet->getActiveSheet();

            $CommonSheetTitles = array(
                'ITEM_NUMBER', 'ITEM_NAME', 'CATEGORY',
                'MAKE', 'YEAR', 'MODEL',
                'BRAND', 'DESCRIPTION', 'PRICE', 'QTY AVAILABLE', 'ATTR_1', 'ATTR_2', 'ATTR_3', 'ATTR_4', 'ATTR_5', 'ATTR_6',
                'ATTR_7', 'ATTR_8', 'ATTR_9', 'ATTR_10', 'ATTR_11',);

            $colTitle = 0;

            foreach ($CommonSheetTitles as $sheetData) {
                $worksheetAss->SetCellValueByColumnAndRow($colTitle, 1, strtoupper($sheetData));
                $colTitle++;
            }

            $colCnt = 0;
            $rowCnt = 2;
//        var_dump($leaveReportDataArray);die;
//                unset($assRowData['user_id']);
            foreach ($CommonSheetTitles as $productTitle) {
                foreach ($tireData as $productData) {
                    foreach ($productData as $value) {
                        $worksheetAss->SetCellValueByColumnAndRow($colCnt, $rowCnt, $value);
                        $colCnt++;
                    }
                    $colCnt = 0;
                    $rowCnt++;
                }
            }


            $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');

// This line will force the file to download
            ob_end_clean();
            $writer->save('php://output');
            exit();

            $this->data['page_title'] = 'Add Products';
            $this->template->write_view('content', 'mng_product/_add_product_csv', $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === 'addcsv') {

//            echo '<pre>', print_r($_POST);die;

            if (isset($_FILES["userfile"])) {
                $filename = $_FILES["userfile"]["tmp_name"];

                $fileTypes = array('xlsx', 'xls', 'csv'); // File extensions
                $fileParts = pathinfo($_FILES['userfile']['name']);

                if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
                    $this->session->set_flashdata('msg', 'File type not supported.');
                    redirect('admin/product/addcsv');
                }

                $objPHPExcel = PHPExcel_IOFactory::load($filename);

                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                //extract to a PHP readable array format
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = $data_value;
                    } else {
                        $arr_data[$row][$column] = $data_value;
                    }
                }
                $product_category_id = $this->input->post('product_csv_category');
                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
//                echo '<pre>', print_r($this->data['prodcut_cat_detail']);die;

                $this->data['product_categoty_id'] = $product_category_id;
                $this->data['excel_row'] = $header;
                $this->data['excel_row_data'] = $arr_data;
            }

            $this->data['page_title'] = 'Add Products';
            $this->session->set_flashdata("msg", "CSV Added successfully!");
            $this->template->write_view('content', 'mng_product/_add_product_csv', $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action === 'edit') {

            $this->data['page_title'] = 'Edit Products';
            $this->data['product_details'] = $this->product->as_array()->get($productId);
            $this->data['product_details']['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($this->data['product_details']['id']);
            $this->data['product_details']['product_images_details'] = $this->product_images->as_array()->get_by_id($this->data['product_details']['id']);
            $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');
            $this->template->write_view('content', 'mng_product/_edit_product', $this->data);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {
            // $this->pattribute_sub->delete($attrId);
            //echo json_encode(array('content' => 'success'));
            //die;
        }
        if ($action == '') {
            $this->data['page_title'] = 'Manage Products';
            $this->template->write_view('content', 'mng_product/_view_product', $this->data);
        }

        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product_history($action = null, $productId = null) {


        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['excel_row'] = null;
        $this->data['excel_row_data'] = null;
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);


        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
//        $this->data['product_csv_category'] = array('' => 'Select Category', 'all' => 'All') + $this->product_category->dropdown('name');
        $this->data['product_csv_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model') + $this->mst_model->dropdown('name');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        //$isactive=array('isactive'=>1);
        $this->data['product_details'] = $this->product->get_all_inactive_product();
//        print_r($this->data['product_details']);        die();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        $this->data['size1'] = array(
            "255" => "255",
            "225" => "225",
            "235" => "235",
            "P235" => "P235",
            "275" => "275",
            "P275" => "P275",
            "265" => "265",
            "P265" => "P265",
            "175" => "175",
        );
        $this->data['size2'] = array(
            "30" => "30",
            "35" => "35",
            "45" => "45",
            "50" => "50",
            "55" => "55",
            "60" => "60",
            "65" => "65",
            "70" => "70",
            "75" => "75",
            "80" => "80",
            "85" => "85",
            "90" => "90",
            "95" => "95",
        );
        $this->data['size3'] = array(
            "10" => "10",
            "12" => "12",
            "13" => "13",
            "14" => "14",
            "15" => "15",
            "16" => "16",
            "15" => "15",
            "16.5" => "16.5",
            "17" => "17",
            "17.5" => "17.5",
            "18" => "18",
            "19" => "19",
            "19.5" => "19.5",
            "20" => "20",
        );



        if ($action == '') {
            $this->data['page_title'] = 'Manage History';
            $this->template->write_view('content', 'mng_product/_soft_product', $this->data);
        }
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function product_delete_soft($productId) {
        // echo $productId;die();
        if ($this->product->delete($productId)) {
            redirect('admin/product');
        }
    }

    public function product_delete_hard($productId) {
        // echo $productId;die();
        if ($this->product->delete_product($productId)) {
            redirect('admin/product_history');
        }
    }

    public function attirbutes($action = null, $attrId = null) {

        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

            $dataAttributeArray = array(
                'parent_id' => $this->input->post('parent_id'),
                'attrubute_value' => $this->input->post('attribute_value'),
                'attribute_type' => $this->input->post('attribute_type'),
                'is_brand' => $this->input->post('product_is_brand'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );
            $insertAttrId = $this->pattribute->insert($dataAttributeArray);

            $dataSubAttributeArray = array(
                'attribute_id' => $insertAttrId,
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $subAttributeName = $this->input->post('sub_attribute_name');
            $subAttributeVales = $this->input->post('tags');

            $subCount = count($subAttributeName);
            if ($subCount > 0)
                for ($i = 0; $i < $subCount; $i++) {
                    if ($subAttributeName[$i] != NULL) {
                        foreach ($subAttributeName as $key => $val)
                            $dataSubAttributeArray['sub_name'] = $subAttributeName[$i];

                        foreach ($subAttributeVales as $keySub => $valSub)
                            $dataSubAttributeArray['sub_value'] = $subAttributeVales[$i];
                        $this->pattribute_sub->insert($dataSubAttributeArray);
                    }
                }
            $this->session->set_flashdata("msg", "Attribute Added successfully!");
            redirect('admin/attirbutes');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

            $subattradata = $this->pattribute_sub->get_sub_attributes_at_id($attrId);

            $updateAttributeArray = array();
            $updateAttributeArray = array();
            $data = array();
            $i = 0;

            foreach ($subattradata as $subData) {

                if (isset($this->input->post('sub_attribute_name')[$subData['id']])) {

//                    $updateAttributeArray['id'] = $subData['id'];
                    $updateAttributeArray['sub_name'] = $this->input->post('sub_attribute_name')[$subData['id']];
                    $updateAttributeArray['sub_value'] = $this->input->post('tags')[$subData['id']];
                    
                    $this->pattribute_sub->update_subattr($subData['id'], $updateAttributeArray);
                }
            }
           

            $dataAttributeUpdateArray = array(
                'parent_id' => $this->input->post('parent_id'),
                'attrubute_value' => $this->input->post('attribute_value'),
                'attribute_type' => $this->input->post('attribute_type'),
                'is_brand' => $this->input->post('product_is_brand'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->pattribute->update($attrId, $dataAttributeUpdateArray);

            $dataSubAttributeArray = array(
                'attribute_id' => $attrId,
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $subAttributeName = $this->input->post('sub_attribute_name_new');
            $subAttributeVales = $this->input->post('tags_new');

//            $this->pattribute_sub->delet_attr($attrId, $dataSubAttributeArray);
            /* insert new attrubutes */
            $subAttributeName = $this->input->post('sub_attribute_name_new');
            $subAttributeVales = $this->input->post('tags_new');
            $subCount = count($subAttributeName);
            if ($subCount > 0) {
                for ($i = 0; $i < $subCount; $i++) {
                    if ($subAttributeName[$i] != NULL) {
                        foreach ($subAttributeName as $key => $val)
                            $dataSubAttributeArray['sub_name'] = $subAttributeName[$i];

                        foreach ($subAttributeVales as $keySub => $valSub)
                            $dataSubAttributeArray['sub_value'] = $subAttributeVales[$i];
                        $this->pattribute_sub->insert($dataSubAttributeArray);
                    }
                }
            }
            /* insert new attrubutes */
            $this->session->set_flashdata("msg", "Attribute Updated successfully!");
            redirect('admin/attirbutes');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {

            $this->pattribute->delete($attrId);
            $this->pattribute_sub->delete($attrId);
            $this->session->set_flashdata("msg", "Attribute Deleted successfully!");
            echo json_encode(array('content' => 'success'));
            die;
        }


        $this->data['attribute_details'] = $this->pattribute->as_array()->get_all();
        $this->data['attt_category'] = array('' => 'Select Parent') + $this->pattribute->dropdown('attrubute_value');

        foreach ($this->data['attribute_details'] as $key => $dataAtt) {
            $this->data['attribute_details'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['id']);
        }

//        echo '<pre>', print_r($this->data['attribute_details']);;die;
//        $this->data['attribute_details'] = $this->pattribute->get_attributes_dt();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Attributes';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_view_attributes', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function ajax_product_category() {

        $options = array();
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute->dropdown('attrubute_value');
        $select = '<div class="form-group"><select class="form-control" name="parent_id[]">';
        foreach ($this->data['attt_category'] as $key => $val)
            $select .= '<option value="' . $key . '">' . $val . '</option>';
        $select .= '</select></div>';

        echo json_encode(array('content' => $select));
        die;
    }

    public function get_attributes($method = null) {
//        echo $_SERVER['REQUEST_METHOD'];die;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = $this->input->post('product_id');
            $product_category_id = $this->input->post('product_category_id');

            if ($method == 'edit') {
                $this->data['prodcut_cat_edit_detail'] = $this->product_attribute->get_by_id($product_id);


                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
//                echo '<pre>';print_r($this->data['prodcut_cat_detail']);die;
                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail'] );
//                echo '/********************************************************************************/';
//                echo '<pre>aa', print_r($this->data['prodcut_cat_edit_detail']);die;
//                die;
                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {

                    if (isset($this->data['prodcut_cat_detail'][$key]['sub_attribute_details']))
                        foreach ($this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] as $k => $subAttrData) {
//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                            foreach ($this->data['prodcut_cat_edit_detail'] as $catEdit) {
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '0' && isset($this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'])) {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_value'] = $this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id'] = $this->data['prodcut_cat_edit_detail'][$k]['id'];
                                    }
                                }

//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '1') {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_attribute_dp_id'] = $catEdit['sub_attribute_dp_id'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id'] = $catEdit['id'];
                                    }
                                }
                            }
                        }
                    if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '2') {
                        if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                            $this->data['prodcut_cat_detail'][$key]['update_id'] = $catEdit['id'];
                            $this->data['prodcut_cat_detail'][$key]['plugin_url'] = $catEdit['sub_attribute_value'];
                            $this->data['prodcut_cat_detail'][$key]['plugin_id'] = $catEdit['sub_attribute_id'];
                            $this->data['prodcut_cat_detail'][$key]['attribute_id'] = $catEdit['attribute_id'];
                        }
                    }
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail']);die;

                $attribute_edit_view = $this->load->view('mng_product/_div_edit_attributes', $this->data, TRUE);
                echo json_encode(array('content' => $attribute_edit_view));
                die;
            } if ($method == 'add') {

                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
                $this->data['prodcut_cat_detail'];
                $attribute_view = $this->load->view('mng_product/_div_attributes', $this->data, TRUE);

                echo json_encode(array('content' => $attribute_view));
                die;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = $this->input->post('product_id');
            $product_category_id = $this->input->post('product_category_id');
            $product_category_name = $this->input->post('product_category_name');
//            get_sub_attributes_at_id($product_category_id);
//            Tire Brand


            if ($method == 'edit') {

                $this->data['prodcut_cat_edit_detail'] = $this->product_attribute->get_by_id($product_id);

                echo '<pre>';
                print_r($this->data['prodcut_cat_edit_detail']);
                die;
                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail'] );
//                echo '/********************************************************************************/';
//                echo '<pre>aa', print_r($this->data['prodcut_cat_edit_detail']);die;
//                die;
                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {

                    if (isset($this->data['prodcut_cat_detail'][$key]['sub_attribute_details']))
                        foreach ($this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] as $k => $subAttrData) {
//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                            foreach ($this->data['prodcut_cat_edit_detail'] as $catEdit) {
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '0' && isset($this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'])) {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_value'] = $this->data['prodcut_cat_edit_detail'][$k]['sub_attribute_value'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id'] = $this->data['prodcut_cat_edit_detail'][$k]['id'];
                                    }
                                }

//                            if($this->data['prodcut_cat_edit_detail'][$k]['id'] == $subAttrData['id'])
                                if ($this->data['prodcut_cat_detail'][$key]['attribute_type'] == '1') {
                                    if ($catEdit['sub_attribute_id'] == $subAttrData['id']) {
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_attribute_dp_id'] = $catEdit['sub_attribute_dp_id'];
                                        $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'][$k]['sub_update_id'] = $catEdit['id'];
                                    }
                                }
                            }
                        }
                }
//                echo '<pre>aa', print_r($this->data['prodcut_cat_detail']);die;

                $attribute_edit_view = $this->load->view('mng_product/_div_edit_attributes', $this->data, TRUE);
                echo json_encode(array('content' => $attribute_edit_view));
                die;
            }
            if ($method == 'add') {

                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
                $this->data['prodcut_cat_detail'];
                $attribute_view = $this->load->view('mng_product/_div_attributes', $this->data, TRUE);

                echo json_encode(array('content' => $attribute_view));
                die;
                die;
            }
            if ($method = 'add_cvs') {

                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }
                $this->data['prodcut_cat_detail'];
                $attribute_view = $this->load->view('mng_product/_div_attributes', $this->data, TRUE);

                echo json_encode(array('content' => $attribute_view));
                die;
                die;
            }
        }
    }

    public function dpFilter($dpType = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'make') {

            $make_id = $this->input->post('product_make_id');
            $this->data['year_category'] = $this->mst_year->get_all_year_by_make_id($make_id);

//echo '<pre>', print_r($this->data['year_category'] );die;
            $st = '<option value="">Select Year</option>';
            foreach ($this->data['year_category'] as $key => $val)
                $st .= ' <option value="' . $val['id'] . '">' . $val['name'] . '</option>';
            echo json_encode(array('content' => $st));
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'year') {

            $year_id = $this->input->post('product_year_id');
            $make_id = $this->input->post('product_make_id');
            $this->data['model_category'] = $this->mst_model->get_all_model_by_id($year_id, $make_id);

            $st = '<option value="">Select Model</option>';
            foreach ($this->data['model_category'] as $key => $val)
                $st .= ' <option value="' . $val['id'] . '">' . $val['name'] . '</option>';
            echo json_encode(array('content' => $st));
            die;
        }
    }

    public function manage_product($method, $productId = null) {

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        $flag = '0';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'add') {
//            echo "<pre>";
//            print_r($_POST);
//            echo "<pre>";
//            print_r($_FILES);
//            die;
            /* End of file upload */

            $from_date = $this->input->post('from_date');
            $from_date = str_replace('-', '', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));

            $to_date = $this->input->post('to_date');
            $to_date = str_replace('-', '', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));

            if ($this->input->post('is_applicable') == 0) {
                $make_id = $this->input->post('product_make');
                $year_id = $this->input->post('product_year');
                $model_id = $this->input->post('product_model');
            } else {
                $make_id = 0;
                $year_id = 0;
                $model_id = 0;
            }



            $dataProductArray = array(
                'product_name' => $this->input->post('product_name'),
                'product_is_feature' => $this->input->post('product_is_feature'),
                'discounted_price' => $this->input->post('discounted_price'),
                'publish_from' => $from_date,
                'publish_to' => $to_date,
                'is_offer_publish' => $this->input->post('is_offer_product'),
                'is_na' => $this->input->post('is_applicable'),
                'category_id' => $this->input->post('product_category'),
                'make_id' => $make_id,
                'year_id' => $year_id,
                'model_id' => $model_id,
                'quantity' => $this->input->post('product_quantity'),
                'price' => $this->input->post('product_price'),
                'product_sku' => $this->input->post('product_sku'),
                'shipping_region' => $this->input->post('product_shipping_region'),
                'description' => $this->input->post('product_desc'),
                'sheeping_fees' => $this->input->post('product_shipping_fees'),
                'warrenty' => $this->input->post('product_warr'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $productId = $this->product->insert($dataProductArray);

            $productSlug = $productId; //. '_' . $this->input->post('product_category');
            /* file upload */
            if (isset($_FILES['product_images']) && !empty($_FILES['product_images'])) {

                $totalImageUploadCnt = count($_FILES['product_images']['name']);

                $targetDir = "backend/uploads/";
                for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                    $fileName = $_FILES['product_images']['name'][$i];
                    $targetFile = $targetDir . $fileName;

                    $uploded_file_path = $this->handleUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);
                    if ($uploded_file_path != '') {
                        $dataProductImagesArray = array(
                            'product_id' => $productId,
                            'uploded_by' => $user_id,
                            'url' => $uploded_file_path,
                            'type' => $_FILES['product_images']['type'][$i],
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                        $this->product_images->insert($dataProductImagesArray);
                    }
                }
            }

            /* End of file upload */


            /* Prodcut Attributes & Sub Attributes */

            $product_category_id = $this->input->post('product_category');
            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            }

            if (isset($this->data['prodcut_cat_detail'])) {
                foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {
                    //upload png plugin image
                    if ($attr_data['attribute_type'] == '2') {
//                        echo $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
//                        die;

                        if (isset($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name']) && !empty($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'])) {
                            $targetDir = "backend/uploads/";

                            $fileName = $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
                            $targetFile = $targetDir . $fileName;

                            $uploded_file_path = $this->handleUpload($productSlug, $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'], $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['tmp_name']);

                            $dataProductAttributeArray = array(
                                'product_id' => $productId,
                                'attribute_id' => $attr_sub_data['attribute_id'],
                                'attribute_type' => '2',
                                'attribute_value' => $attr_data['attrubute_value'],
                                'sub_attribute_id' => $attr_sub_data['id'],
                                'sub_attribute_value' => $uploded_file_path,
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );

                            if ($uploded_file_path != '') {
                                $dataProductImagesArray = array(
                                    'product_id' => $productId,
                                    'uploded_by' => $user_id,
                                    'url' => $uploded_file_path,
                                    'type' => $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['type'],
                                    'is_wheel_plugin' => 1,
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );
                                $this->product_images->insert($dataProductImagesArray);
                            }
                        }
                        $this->product_attribute->insert($dataProductAttributeArray);
                    }
                    //end upload png plugin image

                    if (isset($attr_data['sub_attribute_details']))
                        foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {
                            if ($this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']) || $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {

                                if ($attr_data['attribute_type'] == '0') {
                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '0',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
                                    $this->product_attribute->insert($dataProductAttributeArray);
                                } else if ($this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {

                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '1',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                        'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
                                    $this->product_attribute->insert($dataProductAttributeArray);
                                }
                            }
                        }
                }
            }
//            die;
            /* Prodcut Attributes & Sub Attributes */
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'addcsvdata') {

            $csv_data_count = $this->input->post('csv_data_count');
            if ($csv_data_count < 1) {
                redirect('admin/product/addcsv');
            }

//            echo '<pre>', print_r($this->input->post('attr_input_1_11'));die;

            /* End of file upload */

            $make_id = 0; //$this->input->post('product_make');
            $year_id = 0; //$this->input->post('product_year');
            $model_id = 0; //$this->input->post('product_model');

            $dataProductArray = array(
                'category_id' => $this->input->post('product_categoty_id'),
                'make_id' => $make_id,
                'year_id' => $year_id,
                'model_id' => $model_id,
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );


//            echo $csv_data_count;die;
            for ($i = 0; $i < $csv_data_count; $i++) {
//                $size1 = isset($this->input->post('size1')[$i]) ? $this->input->post('size1')[$i] : '';
//                $size2 = isset($this->input->post('size2')[$i]) ? $this->input->post('size1')[$i] : '';
//                $size3 = isset($this->input->post('size3')[$i]) ? $this->input->post('size1')[$i] : '';
//                echo '<pre>', print_r($this->input->post('product_sku')[$i]);
                $dataProductArray['product_sku'] = $this->input->post('product_sku')[$i];
                $dataProductArray['product_name'] = $this->input->post('product_name')[$i];
                $dataProductArray['make_id'] = $make_id;
                $dataProductArray['year_id'] = $year_id;
                $dataProductArray['model_id'] = $model_id;
                $dataProductArray['description'] = $this->input->post('product_description')[$i];
                $dataProductArray['quantity'] = $this->input->post('product_quantity')[$i];
                $dataProductArray['price'] = $this->input->post('product_price')[$i];
//                $dataProductArray['size1'] = $size1;
//                $dataProductArray['size2'] = $size2;
//                $dataProductArray['size3'] = $size3;


                $productId = $this->product->insert($dataProductArray);
                /* file upload */
                $productSlug = $productId; //. '_' . $this->input->post('product_category');
//                $image_count = count($this->input->post('image1'));
//                for ($i = 0; $i < $image_count; $i++) {
                $dataProductImagesArray1 = array(
                    'product_id' => $productId,
                    'uploded_by' => $user_id,
                    'url' => $this->input->post('image1')[$i],
                    'type' => 'png',
                    'createdby' => $user_id,
                    'createddate' => date('Y-m-d H:m:s'),
                );
                $this->product_images->insert($dataProductImagesArray1);
                $dataProductImagesArray2 = array(
                    'product_id' => $productId,
                    'uploded_by' => $user_id,
                    'url' => $this->input->post('image2')[$i],
                    'type' => 'png',
                    'createdby' => $user_id,
                    'createddate' => date('Y-m-d H:m:s'),
                );
                $this->product_images->insert($dataProductImagesArray2);
                $dataProductImagesArray3 = array(
                    'product_id' => $productId,
                    'uploded_by' => $user_id,
                    'url' => $this->input->post('image3')[$i],
                    'type' => 'png',
                    'createdby' => $user_id,
                    'createddate' => date('Y-m-d H:m:s'),
                );
                $this->product_images->insert($dataProductImagesArray3);


                /* End of file upload */


                /* Prodcut Attributes & Sub Attributes */
//                $subCnt = $attr_data['sub_attribute_details'];
                $j = 0;
                $product_category_id = $this->input->post('product_categoty_id');
                $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
                foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                    $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
                }

                if (isset($this->data['prodcut_cat_detail'])) {
                    foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {

                        if (isset($attr_data['sub_attribute_details']))
                            foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {
                                if ($this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])[$i] || $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])[$i]) {

                                    if ($attr_data['attribute_type'] == '0') {
                                        $dataProductAttributeArray = array(
                                            'product_id' => $productId,
                                            'attribute_id' => $attr_sub_data['attribute_id'],
                                            'attribute_type' => '0',
                                            'attribute_value' => $attr_data['attrubute_value'],
                                            'sub_attribute_id' => $attr_sub_data['id'],
                                            'sub_attribute_value' => $this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])[$i],
                                            'createdby' => $user_id,
                                            'createddate' => date('Y-m-d H:m:s'),
                                        );
                                        $this->product_attribute->insert($dataProductAttributeArray);
                                    } else if ($this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])[$i]) {

                                        $dataProductAttributeArray = array(
                                            'product_id' => $productId,
                                            'attribute_id' => $attr_sub_data['attribute_id'],
                                            'attribute_type' => '1',
                                            'attribute_value' => $attr_data['attrubute_value'],
                                            'sub_attribute_id' => $attr_sub_data['id'],
                                            'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])[$i],
                                            'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])[$i],
                                            'createdby' => $user_id,
                                            'createddate' => date('Y-m-d H:m:s'),
                                        );
                                        $this->product_attribute->insert($dataProductAttributeArray);
                                    }
                                }
                            }
                    }
                }
            }
            $this->session->set_flashdata('msg', 'Product Added successfully.');
            redirect('admin/product');
//            $productId = $this->product->insert($dataProductArray);


            /* Prodcut Attributes & Sub Attributes */
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'edit') {
//            echo '<pre>', print_r($_POST);
//            echo '<pre>', print_r($_FILES);
//            die;

            $from_date = $this->input->post('from_date');
            $from_date = str_replace('-', '', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));

            $to_date = $this->input->post('to_date');
            $to_date = str_replace('-', '', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));


            if ($this->input->post('is_applicable') == 0) {
                $make_id = $this->input->post('product_make');
                $year_id = $this->input->post('product_year');
                $model_id = $this->input->post('product_model');
            } else {
                $make_id = 0;
                $year_id = 0;
                $model_id = 0;
            }


            $dataProductUpdateArray = array(
                'product_name' => $this->input->post('product_name'),
                'product_is_feature' => $this->input->post('product_is_feature'),
                'discounted_price' => $this->input->post('discounted_price'),
                'publish_from' => $from_date,
                'publish_to' => $to_date,
                'is_na' => $this->input->post('is_applicable'),
                'is_offer_publish' => $this->input->post('is_offer_product'),
                'category_id' => $this->input->post('product_category'),
//                'make_id' => $make_id,
//                'year_id' => $year_id,
//                'model_id' => $model_id,
                'quantity' => $this->input->post('product_quantity'),
                'price' => $this->input->post('product_price'),
                'product_sku' => $this->input->post('product_sku'),
                'shipping_region' => $this->input->post('product_shipping_region'),
                'description' => $this->input->post('product_desc'),
                'sheeping_fees' => $this->input->post('product_shipping_fees'),
                'warrenty' => $this->input->post('product_warr'),
                'isactive' => $this->input->post('isactive'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->product->update($productId, $dataProductUpdateArray);

            $productSlug = $productId; //. '_' . $this->input->post('product_category');
            /* file upload */
            if (!empty($_FILES['product_images']['name'][0]))
                if (isset($_FILES['product_images']) && !empty($_FILES['product_images'])) {

                    $totalImageUploadCnt = count($_FILES['product_images']['name'][0]);
                    echo $totalImageUploadCnt;
                    $targetDir = "backend/uploads/";
                    for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                        $fileName = $_FILES['product_images']['name'][$i];
                        $targetFile = $targetDir . $fileName;

                        $uploded_file_path = $this->handleUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);
                        if ($uploded_file_path != '') {
                            $dataProductImagesArray = array(
                                'product_id' => $productId,
                                'uploded_by' => $user_id,
                                'url' => $uploded_file_path,
                                'type' => $_FILES['product_images']['type'][$i],
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );
                            $this->product_images->insert($dataProductImagesArray);
                        }
                    }
                }

            /* End of file upload */


            /* Prodcut Attributes & Sub Attributes */


            $product_category_id = $this->input->post('product_category');
            $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

            foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
                $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
            }
//            echo '<pre>', print_r($this->data['prodcut_cat_detail']);
//            die;

            if (isset($this->data['prodcut_cat_detail'])) {
                foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {
                    if ($attr_data['attribute_type'] == '2') {
//                        echo '<pre>', print_r($attr_data);die;
//                        echo $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
//                        die;
                        if (isset($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name']) && !empty($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'])) {
                            $targetDir = "backend/uploads/";

                            $fileName = $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
                            $targetFile = $targetDir . $fileName;

                            $uploded_file_path = $this->handleUpload($productSlug, $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'], $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['tmp_name']);

                            $dataProductAttributeArray = array(
                                'product_id' => $productId,
                                'attribute_id' => $attr_sub_data['attribute_id'],
                                'attribute_type' => '2d',
                                'attribute_value' => $attr_data['attrubute_value'],
                                'sub_attribute_id' => $attr_sub_data['id'],
                                'sub_attribute_value' => $uploded_file_path,
                                'createdby' => $user_id,
                                'createddate' => date('Y-m-d H:m:s'),
                            );

//                            if ($uploded_file_path != '') {
//                                $dataProductImagesArray = array(
//                                    'product_id' => $productId,
//                                    'uploded_by' => $user_id,
//                                    'url' => $uploded_file_path,
//                                    'type' => $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['type'],
//                                    'is_wheel_plugin' => 1,
//                                    'createdby' => $user_id,
//                                    'createddate' => date('Y-m-d H:m:s'),
//                                );
//                                $this->product_images->insert($dataProductImagesArray);
//                            }
                        }

                        $updateId = $this->input->post('attr_file_' . $attr_data['p_sub_category_id'] . '_' . $attr_data['p_category_id'] . '_file');
//                        echo $updateId;die;
                        if ($updateId != null && $uploded_file_path != null)
                            $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
                        else if ($uploded_file_path != null)
                            $this->product_attribute->insert($dataProductAttributeArray);
                    }

                    if (isset($attr_data['sub_attribute_details']))
                        foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {
                            if ($this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']) || $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'])) {
                                if ($attr_data['attribute_type'] == '0' && $attr_data['attribute_type'] != '2') {
                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '0',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
//                                    echo '<pre>', print_r($dataProductAttributeArray);

                                    $updateId = $this->input->post('attr_input_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'] . '_input');
                                    $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
//                                     echo $this->db->last_query();
//                                     echo '<br>';
                                } else if ($this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'])) {

                                    $dataProductAttributeArray = array(
                                        'product_id' => $productId,
                                        'attribute_id' => $attr_sub_data['attribute_id'],
                                        'attribute_type' => '1',
                                        'attribute_value' => $attr_data['attrubute_value'],
                                        'sub_attribute_id' => $attr_sub_data['id'],
                                        'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
                                        'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id']),
                                        'createdby' => $user_id,
                                        'createddate' => date('Y-m-d H:m:s'),
                                    );
//                                    echo '<pre>', print_r($dataProductAttributeArray);
//                                    echo '<pre>', 'attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'];
                                    $updateId = $this->input->post('attr_dropdown_' . $attr_data['p_sub_category_id'] . '_' . $attr_sub_data['id'] . '_input');

                                    $this->product_attribute->update_attr($updateId, $dataProductAttributeArray);
//                                    echo $this->db->last_query();
//                                    echo '<br>';
                                }
                            }
                        }
                }
            }
            $this->session->set_flashdata('msg', 'Product updated successfully.');
//            die;
            /* Prodcut Attributes & Sub Attributes */
        }

        redirect('admin/product');
    }

    function handleUpload($slug, $upFileName, $upFileTmpName) {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
            return false;
        }

        $ext = pathinfo($upFileName, PATHINFO_EXTENSION);
        $targetURL = '/backend/uploads/product/'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR . $slug;

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $upFileTmpName;
        $fileName = $upFileName;
        $fileName = $slug . '_' . $fileName;
        $path = $targetURL . $slug . '/' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $path;
    }

    public function delete($attr = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $attr === 'images') {
            $imgId = $this->input->post('imageId');
            $this->product_images->delet_img($imgId);
            return true;
        }
    }

    public function offer($method = null) {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'modify') {
            $this->data['product_details'] = $this->product->get_products();
            foreach ($this->data['product_details'] as $key => $pData) {
                if ($this->input->post('discount_' . $pData['id'])) {

                    $updateProductData = array(
                        'discounted_price' => $this->input->post('discount_' . $pData['id']),
                        'is_offer_publish' => '1'
                    );
                    $this->product->update($pData['id'], $updateProductData);
                }
            }
        }

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
        $this->data['product_details'] = $this->product->get_products();
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);

        $pageTitle = "Manage Offer";
        $renderTo = "mng_product/_offer";
        $viewData = $this->data;
        $this->_render_view($pageTitle, $renderTo, $viewData);
    }

    public function _render_view($pageTitle, $renderTo, $viewData) {
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = $pageTitle;
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function orders() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Orders';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['all_orders'] = $this->orders_summary->get_all_orders();

        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); //+ $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
//        echo '<pre>', print_r($this->data['all_orders']);die;

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_all_orders_summary', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function order_details($orderId) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Orders';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['all_orders'] = $this->admin_library->demo_update_order_details($orderId);


        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); //+ $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); //+ $this->mst_model->dropdown('name');
//        echo '<pre>', print_r($this->data['all_orders']);die;

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'mng_product/_all_orders', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function coupon($method = null) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Administrator Dashboard';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'coupon/_view_coupon', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function add_coupon($method = null) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Administrator Dashboard';
        $this->data['total_users'] = count($this->users->get_all());
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['coupon_type'] = array('' => 'Select Type') + $this->coupon_category->dropdown('disc_type');
        $this->data['coupon_method'] = array('' => 'Select method') + $this->coupon_method->dropdown('disc_method');
        $this->data['coupon_method_tax'] = array('' => 'Select method tax') + $this->coupon_method_tax->dropdown('disc_tax_method');
        $this->data['coupon_group'] = array('' => 'Select group') + $this->coupon_group->dropdown('disc_group');
        //$this->data['product'] = array('' => 'Select product') + $this->product->dropdown('product_name');
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'coupon/_add_coupon', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function couponFilter($dpType = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'type') {

            $type_id = $this->input->post('type_id');

            $this->data['coupon_method'] = $this->coupon_method->get_all_method_by_type_id($type_id);


            $st = '<option value="">Select Method</option>';
            foreach ($this->data['coupon_method'] as $key => $val)
                $st .= ' <option value="' . $val['disc_method_id'] . '">' . $val['disc_method'] . '</option>';
            echo json_encode(array('content' => $st));
            die;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $dpType === 'product') {

            //$year_id = $this->input->post('product_year_id');
            $p_id = $this->input->post('p_id');
            $this->data['product_name'] = $this->product->get_product_by_cat_id($p_id);

            $st = '';
            foreach ($this->data['product_name'] as $key => $val)
                $st .= ' <option value="' . $val['id'] . '">' . $val['product_name'] . '</option>';
            echo json_encode(array('content' => $st));
            die;
        }
    }

    public function inquiry($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'delete') {
            $id = $this->input->post('id');
            if ($this->enquiry_model->delete_inq($id)) {
                $this->session->set_flashdata('msg', 'Inquiry deleted successfully.');
                redirect('admin/inquiry');
            }
        } else {
            $user_id = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);

            $this->data['page_title'] = 'Manage Inquiry';
            $this->data['inquiry'] = $this->enquiry_model->as_array()->get_all();
//         $this->data['page_category'] = $this->page_category->dropdown('category_name');
            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', $this->data);
            $this->template->write_view('sidebar', 'backend/sidebar', NULL);
            $this->template->write_view('content', 'inquiry/_inquiry_summary', $this->data);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }
    }

    public function contact_info($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method === 'delete') {
            $id = $this->input->post('id');
            if ($this->enquiry_model->delete_contact($id)) {
                $this->session->set_flashdata('msg', 'Inquiry deleted successfully.');
                redirect('admin/inquiry');
            }
        } else {
            $user_id = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);

            $this->data['page_title'] = 'Manage ContactUs Inquiry';
            $this->data['inquiry_conatact'] = $this->enquiry_model->get_conatact();
//         $this->data['page_category'] = $this->page_category->dropdown('category_name');
            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', $this->data);
            $this->template->write_view('sidebar', 'backend/sidebar', NULL);
            $this->template->write_view('content', 'inquiry/_contact_summary', $this->data);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }
    }

    function ajaxPaginationData() {
        $conditions = array();
//        echo '<pre>', print_r($_POST);die;
        //calc offset number
        $page = $this->input->post('page');

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $session_data = $this->session->userdata('recent_product');



        //total rows count
        $data['posts'] = $this->data['product_details'] = $this->product->get_products();
        $totalRec = $this->product->count_all();

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        $this->data['product_details_count'] = $this->product->count_all();
        $this->data['product_details'] = $this->product->get_products($offset, $this->perPage);
        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);
//        echo '<pre>', print_r($this->data['product_details']);die;
        $totalRec = ($this->data['product_details_count']);
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'admin/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchProductFilter';
        $this->ajax_pagination_product->initialize($config);

        $this->load->view('mng_product/_ajax_product_view', $this->data, false);
    }

}
