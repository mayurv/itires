<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->library('Ajax_pagination_product');
        $this->perPage = 10;

        $this->load->model(array('users', 'backend/group_model'));
        /* Load Backend model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'master/mst_model_size'));

        /* PHPExcel Library */
        $this->load->library('excel');

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->language(array('master_lang'));

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
    }

    // redirect if needed, otherwise display the user list
    public function index() {
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

    public function make($action = NULL, $makeId = null) {

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === "add") {

            $dataMakeArray = array(
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:i:s'),
            );
            $makeName = $this->input->post('make_name');
            $makeDesc = $this->input->post('make_description');

            $makeCount = count($makeName);
            if ($makeCount > 0)
                for ($i = 0; $i < $makeCount; $i++) {

                    foreach ($makeName as $key => $val)
                        $dataMakeArray['name'] = $makeName[$i];

                    foreach ($makeDesc as $keySub => $valSub)
                        $dataMakeArray['description'] = $makeDesc[$i];

                    $this->mst_make->insert($dataMakeArray);
                }
            $this->session->set_flashdata("msg", "Make Added successfully!");
            redirect('master/make');
        }
        //End of add make

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === "edit") {


            $dataMakeArrayUpdate = array(
                'name' => $this->input->post('make_name'),
                'description' => $this->input->post('make_description'),
                'isactive' => $this->input->post('isactive'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->mst_make->update($makeId, $dataMakeArrayUpdate);
            $this->session->set_flashdata("msg", "Make Updated successfully!");

            redirect('master/make');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === "delete") {

            $this->mst_make->delete($makeId);
            $this->mst_model->delete($makeId);
            $this->session->set_flashdata("msg", "Make Deleted successfully!");

            redirect('master/make');
        }


        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Manage Make';

        $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');
        $this->data['make_detail'] = $this->mst_make->as_array()->get_all();



        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'master/_make', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function year($action = null, $yearId = null) {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {

//            echo '<pre>', print_r($_POST);
//            die;

            $dataMakeArray = array(
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:i:s'),
            );

            $yr = $this->input->post('year');
            $yearData = explode(',', $yr);
            $yearCount = count($yearData);
            $dataYearArray['make_id'] = $this->input->post('make_id');
            foreach ($yearData as $key => $val) {

                $dataYearArray['name'] = $yearData[$key];
                $this->mst_year->insert($dataYearArray);
            }
            $this->session->set_flashdata("msg", "Year Added successfully!");

            redirect('master/year');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

            $make_id = $this->input->post('make_id');
//            $this->mst_year->delete_make($make_id);
            $existingYear = $this->mst_year->get_all_year_by_make_id($make_id);
            $yr = $this->input->post('year');

            $yearData = explode(',', $yr[0]);

            $existingArrayData = array();
            foreach ($existingYear as $key => $val) {
                $existingArrayData[$key] = $val['name'];
            }
            /* Delete years */

            $deleteData = array_diff($existingArrayData, $yearData);

            foreach ($deleteData as $key => $val)
                $this->mst_year->delete_year($make_id, $val);

            /* Delete years */

            $yearArrayDataToInsert = array_diff($yearData, $existingArrayData);
            $yearCount = count($yearArrayDataToInsert);

            $dataMakeArray = array(
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:i:s'),
            );

            $dataYearArray['make_id'] = $this->input->post('make_id');

            foreach ($yearArrayDataToInsert as $key => $val) {
                $dataYearArray['name'] = $val;
                $this->mst_year->insert($dataYearArray);
            }
            $this->session->set_flashdata("msg", "Year Updated successfully!");

            redirect('master/year');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action === "delete") {

            $this->mst_year->delete_year_by_make($yearId);
            $this->session->set_userdata("msg", "<span class='success'>Make Deleted successfully!</span>");

            redirect('master/make');
        }

        $this->data['product_make'] = array('' => 'Select Category') + $this->mst_make->dropdown('name');
        $this->data['page_title'] = 'Manage Year';

        $this->data['years_detail'] = $this->mst_make->as_array()->get_all();
        foreach ($this->data['years_detail'] as $key => $mkData) {
            $this->data['years_detail'][$key]['make_year_details'] = $this->mst_year->get_all_year_by_make_id($mkData['id']);
        }
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'master/_year', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function model($action = null, $modelId = null) {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {


            $total_models = count($_POST['size']);

            for ($c = 0; $c < $total_models; $c++) {
                if (strpos($this->input->post('size')[$c], ';'))
                    $model_size[$c] = preg_split('/;/', $this->input->post('size')[$c]);
                else
                    $model_size[$c] = $this->input->post('size')[$c];
            }
//            echo '<pre>', print_r($model_size);die
            $i = 0;
            $j = 0;

//            echo '<pre>', print_r($spldata);
//            die;
//            $modal_img = array();
//            $config['upload_path'] = 'media/backend/img/model_img/';
//            $config['allowed_types'] = 'png|jpg|gpeg';
//            $config['max_size'] = 1000;
//            $config['max_width'] = 1024;
//            $config['max_height'] = 768;
//            $this->load->library('upload', $config);
//            if (!$this->upload->do_upload('model_image')) {
//                //array_push($modal_img, $this->input->post('logo_edit'));
//            } else {
//                $data = array('upload_data' => $this->upload->data());
//                //print_r($data);
//                $file_path = 'media/backend/img/model_img/' . $data['upload_data']['file_name'];
//                array_push($modal_img, $file_path);
//            }

            $modelCnt = count($this->input->post('model'));
//            echo $modelCnt;die;

            $dataModelArray = array(
                'make_id' => $this->input->post('make'),
                'year_id' => $this->input->post('year'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:i:s'),
            );
            $inCnt = 0;

            for ($i = 0; $i < $modelCnt; $i++) {


                $dataModelArray['name'] = $this->input->post('model')[$i];
                $dataModelArray['description'] = $this->input->post('description')[$i];

                $dataModelArray['rim_left_w'] = $this->input->post('m_left_width')[$i];
                $dataModelArray['rim_left_l'] = $this->input->post('m_rim_left')[$i];
                $dataModelArray['rim_left_t'] = $this->input->post('m_rim_left_top')[$i];

                $dataModelArray['rim_right_w'] = $this->input->post('m_rim_right_width')[$i];
                $dataModelArray['rim_right_l'] = $this->input->post('m_rim_right_right')[$i];
                $dataModelArray['rim_right_t'] = $this->input->post('m_rim_right_top')[$i];

                /* file upload */
                if (isset($_FILES['model_image']) && !empty($_FILES['model_image'])) {
                    $targetDir = "media/backend/img/model_img/";
                    $fileName = $_FILES['model_image']['name'][$i];
                    $targetFile = $targetDir . $fileName;
                    $uploded_file_path = $this->handleUpload($this->input->post('model_image')[$i], $_FILES['model_image']['name'][$i], $_FILES['model_image']['tmp_name'][$i]);
                    $dataModelArray['model_img_url'] = $uploded_file_path;
                }
                /* End of file upload */
                $model_id = $this->mst_model->insert($dataModelArray);
                $cnt = count($model_size[$i]);
                if ($cnt > 1) {

                    foreach ($model_size[$i] as $subData) {
                        $size[$model_id][$inCnt] = trim($subData);
                        $split_strings = preg_split('/R/', trim($subData));
                        $strSpl = explode('/', $split_strings[0]);
                        $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                        $spldata[$model_id][$inCnt][4] = "R";
                        $inCnt++;
                    }
                } else {
                    $data = trim($model_size[$i]);
                    $split_strings = preg_split('/R/', trim($data));
                    $strSpl = explode('/', $split_strings[0]);
                    $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                    $spldata[$model_id][$inCnt][4] = "R";
                    $inCnt++;
                }
            }

            /* Insert Model Size Data */
            foreach ($spldata as $key => $sizeData) {
                foreach ($sizeData as $sD) {
                    $dataModel_SizeArray = array(
                        'model_id' => $key,
                        'tire_type' => $sD[4],
                        'size' => $sD[0] . '/' . $sD[1] . $sD[4] . $sD[3],
                        'size1' => $sD[0],
                        'size2' => $sD[1],
                        'size3' => $sD[3],
//                            'createdby' => $user_id,
//                            'createddate' => date('Y-m-d H:m:s'),
                    );
                    $this->mst_model_size->insert($dataModel_SizeArray);
                }
            }
            /* Insert Model Size Data */



//            $md = $this->input->post('model');
//            $modelData = explode(',', $md);
//
//            foreach ($modelData as $key => $val) {
//
//                $dataModelArray['name'] = $modelData[$key];
//                
//            }

            $this->session->set_flashdata("msg", "Model Added successfully!");

            redirect('master/model');
        }
        //End of add model

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

//            echo '<pre>', print_r($_POST);
//            die;



            $modal_img = array();

            $config['upload_path'] = 'media/backend/img/model_img/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 1000;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('model_image')) {
                array_push($modal_img, $this->input->post('model_image_1'));
            } else {
                $data = array('upload_data' => $this->upload->data());

                if ($data['upload_data']['file_name'] == '') {
                    array_push($modal_img, $this->input->post('model_image_1'));
                } else {

                    $file_path = 'media/backend/img/model_img/' . $data['upload_data']['file_name'];
                    array_push($modal_img, $file_path);
                }
            }

            $dataModelArrayUpdate = array(
//                'make_id' => $this->input->post('make'),
//                'year_id' => $this->input->post('year'),
                'name' => $this->input->post('model'),
                'isactive' => $this->input->post('isactive'),
                'model_img_url' => $modal_img[0],
                'rim_left_w' => $this->input->post('m_left_width_' . $modelId),
                'rim_left_l' => $this->input->post('m_rim_left_' . $modelId),
                'rim_left_t' => $this->input->post('m_rim_left_top_' . $modelId),
                'rim_right_w' => $this->input->post('m_rim_right_width_' . $modelId),
                'rim_right_l' => $this->input->post('m_rim_right_right_' . $modelId),
                'rim_right_t' => $this->input->post('m_rim_right_top_' . $modelId),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );



            $this->mst_model->update_model($modelId, $dataModelArrayUpdate);

            /* Tire Size */
            if ($this->input->post('model_' . $modelId) != '') {
                if (strpos($this->input->post('model_' . $modelId), ';'))
                    $model_size[0] = preg_split('/;/', $this->input->post('model_' . $modelId));
                else
                    $model_size[0] = $this->input->post('model_' . $modelId);


                $cnt = count($model_size[0]);
                $model_id = $modelId;
                $inCnt = 0;
                if ($cnt > 1) {

                    foreach ($model_size[0] as $subData) {
                        $size[$model_id][$inCnt] = trim($subData);
                        $split_strings = preg_split('/R/', trim($subData));
                        $strSpl = explode('/', $split_strings[0]);
                        $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                        $spldata[$model_id][$inCnt][4] = "R";
                        $inCnt++;
                    }
                } else {
                    $data = trim($model_size[0]);
                    $split_strings = preg_split('/R/', trim($data));
                    $strSpl = explode('/', $split_strings[0]);
                    $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                    $spldata[$model_id][$inCnt][4] = "R";
                    $inCnt++;
                }
                /* Insert Model Size Data */
//            echo '<pre>', print_r($spldata);die;
                if (isset($spldata) && !empty($spldata)) {
                    foreach ($spldata as $key => $sizeData) {
                        foreach ($sizeData as $sD) {
                            $dataModel_SizeArray = array(
                                'model_id' => $key,
                                'tire_type' => $sD[4],
                                'size' => $sD[0] . '/' . $sD[1] . $sD[4] . $sD[3],
                                'size1' => $sD[0],
                                'size2' => $sD[1],
                                'size3' => $sD[3],
//                            'createdby' => $user_id,
//                            'createddate' => date('Y-m-d H:m:s'),
                            );
                            $this->mst_model_size->insert($dataModel_SizeArray);
                        }
                    }
                }
            }
            /* Insert Model Size Data */

            $this->session->set_flashdata("msg", "Model Updated successfully!");
            redirect('master/model');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {

            $this->mst_model->delete_model($modelId);
            redirect('master/model');
        }

        $this->data['excel_row'] = null;
        $this->data['excel_row_data'] = null;

        $this->data['model_detail'] = $this->mst_model->get_make_detail();
        $this->data['model_count'] = $this->mst_model->count_all();
        
        foreach ($this->data['model_detail'] as $key => $modelData) {
            $this->data['model_detail'][$key]['model_detail_size'] = $this->mst_model_size->get_model_size_detail($modelData['id']);
        }
        $totalRec = $this->mst_model->count_all();
        /* Ajax Pagination */

        $config['uri_segment'] = 4;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'master/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchModelFilter';
        $this->ajax_pagination_product->initialize($config);
        /* Ajax Pagination */
//        $this->data['model_detail_size'] = $this->mst_model->get_make_detail();
//        echo '<pre>', print_r($this->data['model_detail']);die;
        $this->data['make_dropdown'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['year_dropdown'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); //+ $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "upload_csv") {

            if (isset($_FILES["sizecsv"])) {
                $filename = $_FILES["sizecsv"]["tmp_name"];


                $fileTypes = array('xlsx', 'xls', 'csv'); // File extensions
                $fileParts = pathinfo($_FILES['sizecsv']['name']);

                if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
                    $this->session->set_flashdata('msg', 'File type not supported.');
                    redirect('master/model/addcsv');
                }

                $objPHPExcel = PHPExcel_IOFactory::load($filename);

                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                //extract to a PHP readable array format
                $arr_data = null;
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = $data_value;
                        $header[$row]['H'] = 'image';
                    } else {
                        $arr_data[$row][$column] = $data_value;
                    }
                }

                $this->data['excel_row'] = $header;
//                $this->data['excel_row'][1]['H'] = 'image';                
                $this->data['excel_row_data'] = $arr_data;

                /* import data */
                $sizeCnt = count($this->data['excel_row_data']);
                $inCnt = 0;
                $dataSize = array();


                $c = 0;
                $makeid = null;
                

                foreach ($this->data['excel_row_data'] as $key => $model) {
                    /* check model exist or no */
                    $makeid = $this->mst_make->checkIsExist($model['A']);

                    if ($makeid < 1) {

                        $dataMakeArray = array(
                            'name' => $model['A'],
                            'description' => $model['A'],
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:i:s'),
                        );
                        $makeid = $this->mst_make->insert($dataMakeArray);
                    }

                    /* check model exist or no */
//                    $this->data['excel_row_data'][$key]['H'] = 'media/backend/img/model_img' . strtolower($model['A'] . $model['B'] . $model['C'] . $model['D']) . '.png';
                    if ($model['E'] != '-') {
                        if (strpos($model['E'], '; ') == TRUE) {
                            $model_size[$c] = explode('; ', $model['E']);
//                        $c++;
                        } else {
                            $model_size[$c] = $model['E'];
//                        $c++;
                        }
                    } else {
                        $model_size[$c] = NULL;
                    }


                    $dataSize = array(
                        'make_id' => $makeid,
                        'model_img_url' => 'media/backend/img/model_img' . strtolower($model['A'] . $model['B'] . $model['C'] . $model['D']) . '.png',
//                'model_id' => array_search($this->input->post('model')[$i], $product_model),
//                'year_id' => array_search($this->input->post('year')[$i], $product_year),
                        'tire_size' => $model['E'],
                    );
                    $make_id = $makeid;
                    $year_id = $this->checkYsYearExist($makeid, $model['C']);
                    //add new year
                    if ($year_id == 0) {
                        $dataYearArray = array(
                            'name' => $model['C'],
                            'make_id' => $make_id,
                        );
                        $new_year = $this->mst_year->insert($dataYearArray);
                        /* add model agisnt year */
                        $dataSize['year_id'] = $new_year;
                    } else
                        $dataSize['year_id'] = $year_id;

                    $res = $this->checkIsModelExist($model['B'] . ' ' . $model['D'], $make_id, $dataSize['year_id']);

                    if ($res != 0) {
                        $dataSize['model_id'] = $res;
                    } else {
                        $model_id = $this->createModel($make_id, $dataSize['year_id'], $user_id, $model['B'] . ' ' . $model['D'], $dataSize['model_img_url']);
                        $dataSize['model_id'] = $model_id;
                    }
                    /* Calculation size */

                    $model_id = $dataSize['model_id'];
                    if (isset($model_size[$c]) && $model_size[$c] != null)
                        $cnt = count($model_size[$c]);
                    else
                        $cnt = 0;
//            echo $cnt;die;
                    if ($cnt > 1) {

                        foreach ($model_size[$c] as $subData) {
                            $size[$model_id][$inCnt] = trim($subData);
                            $split_strings = preg_split('/R/', trim($subData));
                            $strSpl = explode('/', $split_strings[0]);
                            $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                            $spldata[$model_id][$inCnt][4] = "R";
                            $inCnt++;
                        }
                    } else {
                        $data = trim($model_size[$c]);
                        $split_strings = preg_split('/R/', trim($data));
                        $strSpl = explode('/', $split_strings[0]);
                        $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                        $spldata[$model_id][$inCnt][4] = "R";
                        $inCnt++;
                    }
                    /* Calculation size */
                    $c++;
                }


                /* Insert Model Size Data */

                foreach ($spldata as $key => $sizeData) {
                    foreach ($sizeData as $sD) {



                        if (isset($sD[0]) && $sD[0] != '') {

                            if (!isset($sD[3])) {
                                $size = $sD[0] . $sD[4] . $sD[2];
                                $size2 = '-';
                            } else {
                                $size = $sD[0] . '/' . $sD[1] . $sD[4] . $sD[3];
                                $size2 = $sD[1];
                            }

                            $dataModel_SizeArray = array(
                                'model_id' => $key,
                                'tire_type' => $sD[4],
                                'size' => $size,
                                'size1' => $sD[0],
                                'size2' => $size2,
                                'size3' => isset($sD[3]) ? $sD[3] : $sD[2],
                            );
                            $this->mst_model_size->insert($dataModel_SizeArray);
                        } else {
                            $dataModel_SizeArray = array(
                                'model_id' => $key,
                                'tire_type' => '-',
                                'size' => '-/--',
                                'size1' => '-',
                                'size2' => '-',
                                'size3' => '-',
                            );
                            $this->mst_model_size->insert($dataModel_SizeArray);
                        }
                    }
                }
                /* Insert Model Size Data */
                /* import data */
            }
            $this->data['page_title'] = 'Upload Tire Size';
            redirect('master/model');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "upload_csv") {
            $this->template->write_view('content', 'master/_import_tire_size_view', $this->data);
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == "addcsv") {
            $this->data['page_title'] = 'Manage Tire Size';
            $this->template->write_view('content', 'master/_import_tire_size', $this->data);
        } else {
            $this->data['page_title'] = 'Manage Model';
            $this->template->write_view('content', 'master/_model', $this->data);
        }
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function upload_tire_csv() {

//        $years = $this->mst_year->get_all_year_by_make_id(7);
//        $model_data = $this->mst_model->get_all_model_by_id(75, 7);
//        print_r($years);

        $user_id = $this->session->userdata('user_id');

//        $product_make = array('' => 'Select Make') + $this->mst_make->dropdown('name');
//        $product_year = array('' => 'Select Year') + $this->mst_year->dropdown('name');
//        $product_model = array('' => 'Select Model') + $this->mst_model->dropdown('name');


        /* import data */
        $sizeCnt = count($this->input->post('make'));
        $inCnt = 0;
        $dataSize = array();

        for ($c = 0; $c < $sizeCnt; $c++) {

            if (strpos($this->input->post('tire_size')[$c], '; ') == TRUE && $this->input->post('tire_size')[$c] != '-') {
                $model_size[$c] = explode('; ', $this->input->post('tire_size')[$c]);
            } else
                $model_size[$c] = $this->input->post('tire_size')[$c];
        }
//        echo '<pre>', print_r($model_size);die;

        for ($i = 0; $i < $sizeCnt; $i++) {
            $dataSize = array(
                'make_id' => $this->input->post('make')[$i],
//                'model_id' => array_search($this->input->post('model')[$i], $product_model),
//                'year_id' => array_search($this->input->post('year')[$i], $product_year),
                'tire_size' => $this->input->post('tire_size')[$i],
            );

            //get year by make
            $make_id = $this->input->post('make')[$i];
            //get all existing years
            $years = $this->mst_year->get_all_year_by_make_id($make_id);

            $yearArary = array();
            foreach ($years as $d) {
                array_push($yearArary, $d['name']);
            }
            $yearArary = array($yearArary);

            echo '<pre>', print_r($yearArary);
            die;
            if ($yearArary != '') {
                if (in_array($this->input->post('year')[$i], $yearArary[0])) {

                    foreach ($years as $d) {
                        if ($this->input->post('year')[$i] == $d['name'])
                            $dataSize['year_id'] = $d['id'];
                    }

                    $res = $this->checkIsModelExist($this->input->post('model')[$i], $make_id, $dataSize['year_id']);

                    if ($res != 0) {
                        $dataSize['model_id'] = $res;
                    } else {
                        $model_id = $this->createModel($make_id, $dataSize['year_id'], $user_id, $this->input->post('model')[$i], $this->input->post('modal_image_csv')[$i]);
                        $dataSize['model_id'] = $model_id;
                    }
                } else {

                    //add new year
                    $dataYearArray = array(
                        'name' => $this->input->post('year')[$i],
                        'make_id' => $make_id,
                    );
                    $new_year = $this->mst_year->insert($dataYearArray);

                    /* add model agisnt year */
                    $dataSize['year_id'] = $new_year;

                    $res = $this->checkIsModelExist($this->input->post('model')[$i], $make_id, $dataSize['year_id']);

                    if ($res != 0) {
                        $dataSize['model_id'] = $res;
                    } else {
                        $model_id = $this->createModel($make_id, $dataSize['year_id'], $user_id, $this->input->post('model')[$i], $this->input->post('modal_image_csv')[$i]);
                        $dataSize['model_id'] = $model_id;
                    }
                }
            } else {

                $dataYearArray = array(
                    'name' => $this->input->post('year')[$i],
                    'make_id' => $make_id,
                );
                $new_year = $this->mst_year->insert($dataYearArray);

                /* add model agisnt year */
                $dataSize['year_id'] = $new_year;

                if ($res != 0) {
                    $dataSize['model_id'] = $res;
                } else {
                    $model_id = $this->createModel($make_id, $dataSize['year_id'], $user_id, $this->input->post('model')[$i], $user_id, $this->input->post('modal_image_csv')[$i]);
                    $dataSize['model_id'] = $model_id;
                }
            }
            /* Calculation size */

            $model_id = $dataSize['model_id'];
            if (isset($model_size[$i]))
                $cnt = count($model_size[$i]);
            else
                $cnt = 0;
//            echo $cnt;die;
            if ($cnt > 1) {

                foreach ($model_size[$i] as $subData) {
                    $size[$model_id][$inCnt] = trim($subData);
                    $split_strings = preg_split('/R/', trim($subData));
                    $strSpl = explode('/', $split_strings[0]);
                    $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                    $spldata[$model_id][$inCnt][4] = "R";
                    $inCnt++;
                }
            } else {
                $data = trim($model_size[$i]);
                $split_strings = preg_split('/R/', trim($data));
                $strSpl = explode('/', $split_strings[0]);
                $spldata[$model_id][$inCnt] = array_merge($strSpl, $split_strings);
                $spldata[$model_id][$inCnt][4] = "R";
                $inCnt++;
            }
            /* Calculation size */
        }

        /* Insert Model Size Data */
        foreach ($spldata as $key => $sizeData) {
            foreach ($sizeData as $sD) {
                $dataModel_SizeArray = array(
                    'model_id' => $key,
                    'tire_type' => $sD[4],
                    'size' => $sD[0] . '/' . $sD[1] . $sD[4] . $sD[3],
                    'size1' => $sD[0],
                    'size2' => $sD[1],
                    'size3' => $sD[3],
                );
                $this->mst_model_size->insert($dataModel_SizeArray);
            }
        }
        /* Insert Model Size Data */
        /* import data */


        redirect('master/model');
    }

    public function diameter($action = null, $sizeId = null) {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "add") {


            $dataModelArray = array(
                'make_id' => $this->input->post('make'),
                'year_id' => $this->input->post('year'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:i:s'),
            );
            $md = $this->input->post('model');
            $modelData = explode(',', $md);

            foreach ($modelData as $key => $val) {

                $dataModelArray['name'] = $modelData[$key];
                $this->mst_model->insert($dataModelArray);
            }

            $this->session->set_flashdata("msg", "Diameter Added successfully!");
            redirect('master/model');
        }
        //End of add model

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "edit") {

//            echo '<pre>', print_r($_POST);die;

            $dataModelArrayUpdate = array(
                'make_id' => $this->input->post('make'),
                'year_id' => $this->input->post('year'),
                'name' => $this->input->post('model'),
                'isactive' => $this->input->post('isactive'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->mst_model->update_model($modelId, $dataModelArrayUpdate);
            $this->session->set_flashdata("msg", "Diameter Updated successfully!");
            redirect('master/model');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == "delete") {

            $this->mst_model->delete_model($modelId);
            $this->session->set_flashdata("msg", "Diameter Deleted successfully!");
            redirect('master/model');
        }

        $this->data['page_title'] = 'Manage Model';

        $this->data['model_detail'] = $this->mst_model->get_make_detail();
        $this->data['make_dropdown'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['year_dropdown'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');

        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'master/_model', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function div($modal_div) {

        $this->data['modal_id'] = $modal_div;
        $div['modal_add_more_div'] = $this->load->view('_model_add_more', $this->data, TRUE);
        $div['modal_input_div'] = $this->load->view('_input_div', $this->data, TRUE);
        echo json_encode(array('content' => $div));
        die;
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

    public function createYear($param) {
        
    }

    public function createModel($make_id, $yearId, $user_id, $name, $model_url) {

        /* Insert new model */
        $dataModelArray = array(
            'name' => $name,
            'description' => $name,
            'model_img_url' => $model_url,
            'make_id' => $make_id,
            'year_id' => $yearId,
            'rim_left_w' => '13.9',
            'rim_left_l' => '22.3',
            'rim_left_t' => '48.4',
            'rim_right_w' => '13.9',
            'rim_right_l' => '18.5',
            'rim_right_t' => '48.4',
            'createdby' => $user_id,
            'createddate' => date('Y-m-d H:i:s'),
        );
        $model_id = $this->mst_model->insert($dataModelArray);
        return $model_id;
    }

    public function checkIsModelExist($modelName, $make_id, $year_id) {
        return $this->mst_model->checkIsExist($modelName, $make_id, $year_id);
    }

    public function checkYsYearExist($make_id, $year_id) {
        return $this->mst_year->checkYsYearExist($make_id, $year_id);
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
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        $this->data['model_count'] = $this->mst_model->count_all();
        $this->data['model_detail'] = $this->mst_model->get_make_detail($offset, $this->perPage);
        foreach ($this->data['model_detail'] as $key => $modelData) {
            $this->data['model_detail'][$key]['model_detail_size'] = $this->mst_model_size->get_model_size_detail($modelData['id']);
        }
        $this->data['make_dropdown'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['year_dropdown'] = array('' => 'Select Year') + $this->mst_year->dropdown('name');
        $this->data['isactive'] = array('' => 'Select Status', '0' => 'Active', '1' => 'In-Active');

//        echo '<pre>', print_r($this->data['product_details']);die;
        $totalRec = ($this->data['model_count']);
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'master/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchModelFilter';
        $this->ajax_pagination_product->initialize($config);

        $this->load->view('_ajax_model_view', $this->data, false);
    }

}
