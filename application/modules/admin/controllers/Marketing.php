<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Marketing extends MY_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->library('form_validation');

        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category', 'backend/blog_category'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->load->config('Twilio', TRUE);
        $this->number = $this->config->item('number', 'Twilio');



        $this->load->model('Common_model_marketing');
        $this->load->model('global_setting_model');
    }

    /* Frontend : Manage Blog Start */

    public function marketingList() {


        if (count($this->input->post()) > 0) {
            if (count($this->input->post('checkbox')) > 0) {
                /* getting all ides selected */
                $arr_ids = $this->input->post('checkbox');
                //echo '<pre>';print_r($arr_ids);die;
                if (count($arr_ids) > 0) {
                    if (count($arr_ids) > 0) {
                        /* deleting the admin selected */
                        $this->Common_model_marketing->deleteRows($arr_ids, "mst_notification", "id");
                    }
                    $msg = lang('Notification deleted successfully!');
                    $this->session->set_userdata("msg", "<span class='success'>$msg</span>");
                }
            }
        }

        #START Action :: Fetch all active Blog added by admin :   
        $this->data['arr_notification_list'] = $this->Common_model_marketing->getRecords(TABLES::$NOTIFICATION, '*', '');
//        echo '<pre>';print_r( $this->data['arr_notification_list']);die;
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['page_title'] = 'Administrator Dashboard';
        $this->data['site_title'] = 'Blog';
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'marketing/list', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    /* Function to add user */

    public function marketingAdd() {

        /* checking admin is logged in or not */
        if (!$this->Common_model_marketing->isLoggedIn()) {
            redirect(base_url() . "backend/login");
        }

        if ($this->session->userdata('language_id') == '17' || $this->session->userdata('language_id') == '') {
            $lang_id = 17;
        } else if ($this->session->userdata('language_id') == '4') {
            $lang_id = 4;
        }

        $data = $this->Common_model_marketing->commonFunction();
        $data['global'] = $this->global_setting_model->getGlobalSettingsGlobal('');
        if ($data['user_account']['role_id'] == 3) {
            /* an admin which is not super admin not privileges to access Manage Role */
            /* setting session for displaying notiication message. */
            $this->session->set_userdata("msg", "<span class='error'>You doesn't have priviliges to  manage marketing!</span>");
            redirect(base_url() . "backend/login");
        }

        /* getting common data */
        $data = $this->Common_model_marketing->commonFunction();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
        $this->form_validation->set_rules('notification_title', 'user name', 'required');
        $this->form_validation->set_rules('description', 'first name', 'required');

        if ($this->input->post('notification_title') != '') {

            if ($this->form_validation->run() == true && $this->input->post('notification_title') != "") {


                if ($_FILES['img_file']['name'] != '') {
                    $_FILES['img_file']['name'];
                    $_FILES['img_file']['type'];
                    $_FILES['img_file']['tmp_name'];
                    $_FILES['img_file']['error'];
                    $_FILES['img_file']['size'];
                    $config['file_name'] = time() . rand();
                    $config['upload_path'] = FCPATH . 'uploads/notification/';
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '9000000';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('img_file')) {
                        $data['upload_data'] = $this->upload->data();
                        //$ar = list($width, $height) = getimagesize($data['full_path']);
                        $upload_result = $this->upload->data();
                        /* for image */
                        $image_config = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/notification/233x155/",
                            'maintain_ratio' => false,
                            'width' => 233,
                            'height' => 155
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config);
                        $resize_rc = $this->image_lib->resize();
                        /* for image  540x360 */
                        $image_config1 = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/notification/540x360/",
                            'maintain_ratio' => false,
                            'width' => 540,
                            'height' => 360
                        );
                        $this->image_lib->initialize($image_config1);
                        $resize_rc1 = $this->image_lib->resize();
                        /* for image  670x470 */
                        $image_config2 = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/notification/670x470/",
                            'maintain_ratio' => false,
                            'width' => 670,
                            'height' => 470
                        );

                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config2);
                        $resize_rc2 = $this->image_lib->resize();


                        $img_path = $upload_result['file_name'];
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                    }
                } else {
                    $img_path = '';
                }


                if ($_FILES['img_file_one']['name'] != '') {
                    $_FILES['img_file_one']['name'];
                    $_FILES['img_file_one']['type'];
                    $_FILES['img_file_one']['tmp_name'];
                    $_FILES['img_file_one']['error'];
                    $_FILES['img_file_one']['size'];
                    $config['file_name'] = time() . rand();
                    $config['upload_path'] = FCPATH . 'uploads/notification/';
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '9000000';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('img_file_one')) {
                        $data['upload_data'] = $this->upload->data();
                        //$ar = list($width, $height) = getimagesize($data['full_path']);
                        $upload_result = $this->upload->data();
                        /* for image */
                        $image_config = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/notification/233x155/",
                            'maintain_ratio' => false,
                            'width' => 233,
                            'height' => 155
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config);
                        $resize_rc = $this->image_lib->resize();
                        /* for image  540x360 */
                        $image_config1 = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/notification/540x360/",
                            'maintain_ratio' => false,
                            'width' => 540,
                            'height' => 360
                        );
                        $this->image_lib->initialize($image_config1);
                        $resize_rc1 = $this->image_lib->resize();
                        /* for image  670x470 */
                        $image_config2 = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/notification/670x470/",
                            'maintain_ratio' => false,
                            'width' => 670,
                            'height' => 470
                        );

                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config2);
                        $resize_rc2 = $this->image_lib->resize();


                        $img_path_one = $upload_result['file_name'];
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                    }
                } else {
                    $img_path_one = '';
                }


                /* user record to add */
                $arr_to_insert = array(
                    "notification_title" => ($this->input->post('notification_title')),
                    "description" => ($this->input->post('description')),
                    "app_icon_url" => $img_path,
                    "image_url" => $img_path_one,
                    'created' => date("Y-m-d H:i:s"),
                );
                //echo '<pre>';print_R($arr_to_insert);die;
                /* inserting admin details into the dabase */
                $last_insert_id = $this->Common_model_marketing->insertRow($arr_to_insert, "mst_notification");
                /* Activation link  */
                $description = $this->input->post('description');
                $notification_title = $this->input->post('notification_title');
                $img_path_complete = base_url() . 'uploads/notification/233x155/' . $img_path;
                $img_path_one_complete = base_url() . 'uploads/notification/233x155/' . $img_path_one;
                $arr_notification_user = $this->Common_model_marketing->getRecords(TABLES::$ADMIN_USER, '*', array('role_id' => '3'));
                //echo '<pre>';print_r($arr_notification_user);
                foreach ($arr_notification_user as $key => $notification) {
                    $registration_id = $notification['registration_id'];
                    $device_type = $notification['device_type'];

                    if ($registration_id != '') {
                        $send_notification_id = $this->send_notification($registration_id, $notification_title, $description, $device_type, $img_path_complete, $img_path_one_complete);
                    }
                }

                /* sending admin added mail to added admin mail id. */
                /* 1.recipient array. 2.From array containing email and name, 3.Mail subject 4.Mail Body */
                // $mail = $this->Common_model_marketing->sendEmail(array($this->input->post('user_email')), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], $email_content['content']);
                $msg = lang('Notification added successfully');
                $this->session->set_userdata("msg", "<span class='success'>$msg </span>");
                redirect(base_url() . "admin/marketing-list");
            }
        }
        redirect(base_url() . "admin/marketing-list");
    }

    //public function send_notification($registration_id, $message, $flag) {
    public function send_notification($registration_id, $notification_title, $description, $device_type, $img_path, $img_path_one) {
//    public function send_notification() {
        // $registration_id = 'cSe5YZwl0E4:APA91bHcZv3mT9GCdytv4cqAT6gnObcaXfJDFpOHri3WNpHdm_AkNnxOjL4LVZwOiw7M9kvVvPt_k6SoMY9k0aQqM5maiDF2Tm8-Mf_0k2u-lCtNwXU27s3PVeULLZ67IXQV0Yx_fwaK';
        //$url = 'https://android.googleapis.com/gcm/send';
        $url = 'https://fcm.googleapis.com/fcm/send';
//        $registration_id = 'e88jAnawiK0:APA91bGyf0_UDWJp180bhU7aSRg3VxWtMlxxynIkHnlEvF0_eMkCnct2V5ehH4uoMZtHFEXyIFWVjoLdBAUivDemJqsZxVCP5muIJQWfzQByQVpD3oKN2nZqXu1I1IfsXfLcdP7PkDVx';
//        $message = "This is a test message.";
        $fields = array(
            'registration_ids' => array($registration_id),
            'data' => array("description" => $description, 'body' => 'Body  Of Notification', 'title' => 'Title Of Notification', 'device_type' => $device_type, 'notification_title' => $notification_title, 'app_icon' => $img_path, 'image' => $img_path_one),
                //'flag' => $flag
        );
        // echo '<pre>';print_r($fields);
        $headers = array(
//            'Authorization: key=' . $api_key,
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        //echo '<pre>';print_r($headers);
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        // echo '<pre>';print_r($result);die;
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }

    /* Function to add user */

    public function notificationView() {

        $id = $this->input->post('id');
        $arr_marketing_data = ($this->Common_model_marketing->getRecords("mst_notification", "*", array("id" => $id)));

        //echo '<pre>';print_R($arr_marketing_data);die;
        if ($id != '' && count($arr_marketing_data) > 0) {
            ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">App Icon
                </label>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <span class="formLabelInfo">
                        <?php if ($arr_marketing_data[0]['app_icon_url'] != '') { ?>
                            <img src="<?php echo base_url(); ?>uploads/notification/233x155/<?php echo $arr_marketing_data[0]['app_icon_url']; ?>">
                        <?php } else { ?>
                            Not uploaded yet.
                        <?php } ?>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Notification Title
                </label>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <span class="formLabelInfo">
                        <?php echo $arr_marketing_data[0]['notification_title']; ?>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                </label>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <span class="formLabelInfo">
                        <?php echo $arr_marketing_data[0]['description']; ?>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <span class="formLabelInfo">
                        <?php if ($arr_marketing_data[0]['image_url'] != '') { ?>
                            <img src="<?php echo base_url() ?>uploads/notification/233x155/<?php echo $arr_marketing_data[0]['image_url']; ?>">
                        <?php } else { ?>
                            Not uploaded yet.
                        <?php } ?>
                    </span>
                </div>
            </div>
            <?php
        }
    }

    public function marketingMailList() {

        if (count($this->input->post()) > 0) {
            if (count($this->input->post('checkbox')) > 0) {
                /* getting all ides selected */
                $arr_ids = $this->input->post('checkbox');
                //echo '<pre>';print_r($arr_ids);die;
                if (count($arr_ids) > 0) {
                    if (count($arr_ids) > 0) {
                        /* deleting the admin selected */
                        $this->Common_model_marketing->deleteRows($arr_ids, "mst_email", "id");
                    }

                    $msg = 'Mail deleted successfully!';
                    $this->session->set_userdata("msg", "<span class='success'>$msg</span>");
                }
            }
        }
        $this->data['arr_sender_list'] = $this->Common_model_marketing->getRecords(TABLES::$SENDER, '*', '');

        #START Action :: Fetch all active Blog added by admin :   
        $this->data['arr_mail_list'] = $this->Common_model_marketing->getRecords(TABLES::$EMAIL, '*', '', 'id desc');
        // echo '<pre>';print_r($data['arr_mail_list']);die;


        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['page_title'] = 'Mail List';
        $this->data['site_title'] = 'Blog';
        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', $this->data);
        $this->template->write_view('sidebar', 'backend/sidebar', NULL);
        $this->template->write_view('content', 'marketing/mail-list', $this->data);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();
    }

    public function marketingMailAdd() {


        /* getting common data */
      
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
        $this->form_validation->set_rules('sender_name', 'sender name', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');

        if ($this->input->post('sender_name') != '') {

            if ($this->form_validation->run() == true && $this->input->post('sender_name') != "") {

                if ($_FILES['img_file_one']['name'] != '') {
                    $_FILES['img_file_one']['name'];
                    $_FILES['img_file_one']['type'];
                    $_FILES['img_file_one']['tmp_name'];
                    $_FILES['img_file_one']['error'];
                    $_FILES['img_file_one']['size'];
                    $config['file_name'] = time() . rand();
                    $config['upload_path'] = FCPATH . 'uploads/mail/';
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '9000000';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('img_file_one')) {
                        $data['upload_data'] = $this->upload->data();
                        //$ar = list($width, $height) = getimagesize($data['full_path']);
                        $upload_result = $this->upload->data();
                        /* for image */
                        $image_config = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/mail/233x155/",
                            'maintain_ratio' => false,
                            'width' => 233,
                            'height' => 155
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config);
                        $resize_rc = $this->image_lib->resize();
                        /* for image  540x360 */
                        $image_config1 = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/mail/540x360/",
                            'maintain_ratio' => false,
                            'width' => 540,
                            'height' => 360
                        );
                        $this->image_lib->initialize($image_config1);
                        $resize_rc1 = $this->image_lib->resize();
                        /* for image  670x470 */
                        $image_config2 = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' => FCPATH . "uploads/mail/670x470/",
                            'maintain_ratio' => false,
                            'width' => 670,
                            'height' => 470
                        );

                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config2);
                        $resize_rc2 = $this->image_lib->resize();


                        $img_path_one = $upload_result['file_name'];
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                    }
                } else {
                    $img_path_one = '';
                }


                /* user record to add */
                $arr_to_insert = array(
                    "sender_name" => ($this->input->post('sender_name')),
                    "description" => $this->input->post('inputPostDescription'),
                    "subject" => $this->input->post('subject'),
                    "email" => $this->input->post('email'),
                    "sender_list" => $this->input->post('sender_list'),
                    "image_url" => $img_path_one,
                    'created' => date("Y-m-d H:i:s"),
                );
                //echo '<pre>';print_R($arr_to_insert);die;
                /* inserting admin details into the dabase */
                $last_insert_id = $this->Common_model_marketing->insertRow($arr_to_insert, "mst_email");
                /* Activation link  */

                $list_id = $this->input->post('sender_list');
                $arr_sender_lists = $this->Common_model_marketing->getRecords(TABLES::$SENDER_TRANS, '*', array('list_id' => $list_id));
                //echo '<pre>';print_R($arr_sender_lists);
                if ($img_path_one != '') {
                    $download_link = '<a href="' . base_url() . 'uploads/mail/' . $img_path_one . '">Click here to download attachment.</a>';
                }
                if (isset($arr_sender_lists) && count($arr_sender_lists) > 0) {
                    foreach ($arr_sender_lists as $list) {
                        $arr_user_details = $this->Common_model_marketing->getRecords(TABLES::$ADMIN_USER, 'email', array('id' => $list['user_id']));
                        //echo '<pre>';print_r($arr_user_details);
                        $recipeinets2 = $arr_user_details[0]['email'];

                        $from_name = $this->input->post('sender_name');
                        if ($from_name == '') {
                            $from_name = $data['global']['site_title'];
                        }
                        $from2 = array("email" => $this->input->post('email'), "name" => $from_name);
                        $subject2 = $this->input->post('subject');
                        $message2 = $this->input->post('inputPostDescription');
                        if ($img_path_one != '') {
                            $message2 .='<br/>';
                            $message2 .=$download_link;
                        }
                        $mail2 = $this->Common_model_marketing->sendEmailNew($recipeinets2, $from2, $subject2, $message2);
                    }
                }

                /* sending admin added mail to added admin mail id. */
                /* 1.recipient array. 2.From array containing email and name, 3.Mail subject 4.Mail Body */
                // $mail = $this->Common_model_marketing->sendEmail(array($this->input->post('user_email')), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], $email_content['content']);

                $msg = 'Mail added successfully';
                $this->session->set_userdata("msg", "<span class='success'> $msg</span>");
                redirect(base_url() . "admin/marketing-mail-list");
            }
        }
        redirect(base_url() . "admin/marketing-mail-list");
    }

    public function mailView() {

        $id = $this->input->post('id');
        $arr_marketing_data = ($this->Common_model_marketing->getRecords("mst_email", "*", array("id" => $id)));

        //echo '<pre>';print_R($arr_marketing_data);die;
        if ($id != '' && count($arr_marketing_data) > 0) {
            $list_id = $arr_marketing_data[0]['list_id'];
            $arr_list_data = ($this->Common_model_marketing->getRecords("mst_sender_list", "*", array("id" => $list_id)));
            ?>
            <div class="form-group">


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sender Name
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_marketing_data[0]['sender_name']; ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sender List
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_list_data[0]['list_name']; ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_marketing_data[0]['email']; ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">subject
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_marketing_data[0]['subject']; ?>
                        </span>
                    </div>
                </div>   

                <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php if ($arr_marketing_data[0]['image_url'] != '') { ?>
                                <img src="<?php echo base_url() ?>uploads/mail/233x155/<?php echo $arr_marketing_data[0]['image_url']; ?>">
                            <?php } else { ?>
                                Not uploaded yet.
                            <?php } ?>
                        </span>
                    </div> 
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_marketing_data[0]['description']; ?>
                        </span>
                    </div>
                </div>

                <?php
            }
        }

        public function marketingSmsList() {

            if (count($this->input->post()) > 0) {
                if (count($this->input->post('checkbox')) > 0) {
                    /* getting all ides selected */
                    $arr_ids = $this->input->post('checkbox');
                    //echo '<pre>';print_r($arr_ids);die;
                    if (count($arr_ids) > 0) {
                        if (count($arr_ids) > 0) {
                            /* deleting the admin selected */
                            $this->Common_model_marketing->deleteRows($arr_ids, "mst_sms", "id");
                        }

                        $msg = 'SMS deleted successfully!';
                        $this->session->set_userdata("msg", "<span class='success'>$msg</span>");
                    }
                }
            }
            $this->data['arr_sender_list'] = $this->Common_model_marketing->getRecords(TABLES::$SENDER, '*', '');
//            echo '<pre>';print_r($this->data['arr_sender_list']);die;
            #START Action :: Fetch all active Blog added by admin :   
            $this->data['arr_sms_list'] = $this->Common_model_marketing->getRecords(TABLES::$SMS, '*', '', 'id desc');


            $user_id = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['page_title'] = 'SMS List';
            $this->data['site_title'] = 'Blog';

            $this->template->set_master_template('template.php');

            $this->template->write_view('header', 'backend/header', $this->data);
            $this->template->write_view('sidebar', 'backend/sidebar', NULL);
            $this->template->write_view('content', 'marketing/sms-list', $this->data);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }

        public function marketingSmsAdd() {

            /* getting common data */
//            $data = $this->Common_model_marketing->commonFunction();
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
            $this->form_validation->set_rules('description', 'sender name', 'required');
            $this->form_validation->set_rules('sender_list', 'email', 'required');

            if ($this->input->post('sender_list') != '') {

                if ($this->form_validation->run() == true && $this->input->post('sender_list') != "") {
                    /* user record to add */
                    $arr_to_insert = array(
                        "list_id" => ($this->input->post('sender_list')),
                        "description" => $this->input->post('description'),
                        "email" => $this->input->post('email'),
                        "sender_name" => $this->input->post('sender_name'),
                        "short_code" => $this->input->post('short_code'),
                        'created' => date("Y-m-d H:i:s"),
                    );
                    //echo '<pre>';print_R($arr_to_insert);die;
                    /* inserting admin details into the dabase */
                    $last_insert_id = $this->Common_model_marketing->insertRow($arr_to_insert, "mst_sms");
                    /* Activation link  */

                    $list_id = $this->input->post('sender_list');
                    $msg = $this->input->post('description');
                    $arr_sender_lists = $this->Common_model_marketing->getRecords(TABLES::$SENDER_TRANS, '*', array('list_id' => $list_id));
                    //echo '<pre>';print_R($arr_sender_lists);

                    if (isset($arr_sender_lists) && count($arr_sender_lists) > 0) {
                        foreach ($arr_sender_lists as $list) {
                            $arr_user_details = $this->Common_model_marketing->getRecords(TABLES::$ADMIN_USER, 'email,phone', array('id' => $list['user_id']));
                            //$to_number = $arr_user_details[0]['mobile'];
                            $to_number = $arr_user_details[0]['phone'];
                            //$from = '9175704935';
                            $from2 = array("email" => $this->input->post('email'), "name" => $data['global']['site_title']);
                            if ($to_number != '') {
                                //$send_sms = $this->twilioSms($from, $to, $msg);
                                // $response = $this->Common_model_marketing->twilioSms($this->number, $to_number, $msg);
                                //require "Services/Twilio.php";
                                require_once('Services/Twilio.php');
                                $AccountSid = "AC9669a3184cf1925be54f5164e00261ae"; //client
                                $AuthToken = "819cfcddfc9e9bd073b2b562bd45a4bc"; //client
                                $client = new Services_Twilio($AccountSid, $AuthToken);
                                //$fromNumber = "+12018856402 "; //client
                                $fromNumber = $this->number; //client
                                //$toNumber = '+' . $only_code . $only_phone;
                                $toNumber = $arr_user_details[0]['phone'];
                                //$txt_msg = lang('your_mobile_number') . $toNumber . lang('mobile_number_verified') . $data['global']['site_title'];
                                $message = strip_tags($msg);
                                try {
                                    $sms = $client->account->messages->sendMessage($fromNumber, $toNumber, $message);
                                } catch (Services_Twilio_RestException $e) {
                                    $result = $e->getMessage();
                                }
                            }
                        }
                    }

                    /* sending admin added mail to added admin mail id. */
                    /* 1.recipient array. 2.From array containing email and name, 3.Mail subject 4.Mail Body */
                    // $mail = $this->Common_model_marketing->sendEmail(array($this->input->post('user_email')), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], $email_content['content']);
                    $this->session->set_userdata("msg", "<span class='success'>SMS sent successfully </span>");
                    redirect(base_url() . "admin/marketing-sms-list");
                }
            }
            redirect(base_url() . "admin/marketing-sms-list");
        }

        public function smsView() {

            $id = $this->input->post('id');
            $arr_marketing_data = ($this->Common_model_marketing->getRecords("mst_sms", "*", array("id" => $id)));

            //echo '<pre>';print_R($arr_marketing_data);die;
            if ($id != '' && count($arr_marketing_data) > 0) {
                $list_id = $arr_marketing_data[0]['list_id'];
                $arr_list_data = ($this->Common_model_marketing->getRecords("mst_sender_list", "*", array("id" => $list_id)));
                ?>



                <!--                      <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sender Name
                                        </label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                <?php echo $arr_marketing_data[0]['sender_name']; ?>
                                           
                                        </div>
                                      </div>-->

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sender List
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_list_data[0]['list_name']; ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Short Code
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_marketing_data[0]['short_code']; ?>
                        </span>
                    </div>
                </div>



                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <span class="formLabelInfo">
                            <?php echo $arr_marketing_data[0]['description']; ?>
                        </span>
                    </div>
                </div>

                <?php
            }
        }

        public function marketingSenderList() {

            if (count($this->input->post()) > 0) {
                if (count($this->input->post('checkbox')) > 0) {
                    /* getting all ides selected */
                    $arr_ids = $this->input->post('checkbox');
                    //echo '<pre>';print_r($arr_ids);die;
                    if (count($arr_ids) > 0) {
                        if (count($arr_ids) > 0) {
                            /* deleting the admin selected */
                            $this->Common_model_marketing->deleteRows($arr_ids, "mst_sender_list", "id");
                            $this->Common_model_marketing->deleteRows($arr_ids, "trans_sender_list", "list_id");
                        }
                        $msg = 'Sender list deleted successfully!';

                        $this->session->set_userdata("msg", "<span class='success'>$msg</span>");
                    }
                }
            }

            #START Action :: Fetch all active Blog added by admin :   
            $this->data['arr_sender_list'] = $this->Common_model_marketing->getRecords(TABLES::$SENDER, '*', '');
            if (isset($this->data['arr_sender_list']) && count($this->data['arr_sender_list']) > 0) {
                foreach ($this->data['arr_sender_list'] as $key => $list) {

                    $arr_list_details = $this->Common_model_marketing->getRecords(TABLES::$SENDER_TRANS, '*', array('list_id' => $list[$key]));

                    $this->data['arr_sender_list'][$key]['total_user'] = count($arr_list_details);
                }
            }


            //echo '<pre>';print_r($data['arr_sender_list']);die;
            $this->data['arr_sender_list'] = $this->Common_model_marketing->getRecords(TABLES::$SENDER, '*', '');
            $user_id = $this->session->userdata('user_id');
            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['page_title'] = 'Sender List';
            $this->data['site_title'] = 'Blog';

            $this->template->set_master_template('template.php');

            $this->template->write_view('header', 'backend/header', $this->data);
            $this->template->write_view('sidebar', 'backend/sidebar', NULL);
            $this->template->write_view('content', 'marketing/sender-list', $this->data);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }

        public function marketingSenderAdd() {
            error_reporting(0);
            /* getting common data */
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<p class="validationError">', '</p>');
            $this->form_validation->set_rules('list_name', 'list name', 'required');

            if ($this->input->post() && $this->input->post('list_name') != '') {

                if ($this->form_validation->run() == true && $this->input->post('list_name') != "") {
                    $arr_first_name = $this->input->post('first_name_list');
                    $arr_last_name = $this->input->post('last_name_list');
                    $arr_email = $this->input->post('email_list');
                    $arr_mobile = $this->input->post('mobile_list');
                    $arr_country_code = $this->input->post('country_code_list');

                    $k = 0;
                    for ($i = 0; $i <= count($arr_first_name); $i++) {
                        $first_name = $arr_first_name[$i];
                        $last_name = $arr_last_name[$i];
                        $email = $arr_email[$i];
                        $mobile = $arr_mobile[$i];

                        $mobile_new = $arr_country_code[$i] . $mobile;

                        if ($first_name != '' && $last_name != '' && $mobile != '' && $arr_country_code[$i] != '') {
                            $arr_to_insert = array(
                                "last_name" => $last_name,
                                "first_name" => $first_name,
                                "email" => $email,
                                "phone" => $mobile_new,
                                'created_on' => strtotime("Y-m-d H:i:s"),
                            ); //echo '<pre>';print_r($arr_to_insert);die;
                            $last_user_id = $this->Common_model_marketing->insertRow($arr_to_insert, "users");
                            $this->Common_model_marketing->insertRow(array('user_id' => $last_user_id, 'group_id' => '4'), "users_groups");

                            if ($k < 1) {
                                $arr_to_insert = array(
                                    "list_name" => $this->input->post('list_name'),
                                    'created' => date("Y-m-d H:i:s"),
                                );
                                $last_insert_id = $this->Common_model_marketing->insertRow($arr_to_insert, "mst_sender_list");
                            }
                            $k = 1;

                            $arr_to_insert = array(
                                "list_id" => $last_insert_id,
                                "user_id" => $last_user_id,
                                'created' => date("Y-m-d H:i:s"),
                            );

                            //echo '<pre>';print_R($arr_to_insert);die;
                            $last_insert = $this->Common_model_marketing->insertRow($arr_to_insert, "trans_sender_list");
                        }
                    }

                    /* sending admin added mail to added admin mail id. */
                    /* 1.recipient array. 2.From array containing email and name, 3.Mail subject 4.Mail Body */
                    // $mail = $this->Common_model_marketing->sendEmail(array($this->input->post('user_email')), array("email" => $data['global']['site_email'], "name" => stripslashes($data['global']['site_title'])), $email_content['subject'], $email_content['content']);
                    $msg = 'Sender list added successfully';
                    $this->session->set_userdata("msg", "<span class='success'>$msg </span>");
                    redirect(base_url() . "admin/marketing-sender-list");
                }
            }
            redirect(base_url() . "admin/marketing-sender-list");
        }

        public function editSenderList() {


            $id = $this->input->post('id');
//        $arr_sender_data = ($this->Common_model_marketing->getRecords("trans_sender_list", "user_id", array("list_id" =>$id)));
//        $list_ids = $arr_sender_data[0]['list_id'];
//       
//        foreach($arr_sender_data as $list){
//            $list_id[]=$list['user_id'];
//        }
            //$arr_list_datails= ($this->Common_model_marketing->getRecords("mst_sender_list", "*", array("id" =>$list_ids)));
            $condition = array("ms.id" => $id);
            $arr_list_datails = $this->Common_model_marketing->getSenderList($condition);

            // echo '<pre>';print_R($arr_list_datails);die;
            if ($id != '' && count($arr_list_datails) > 0) {
                ?>


                <input type="hidden"  name="list_id_edit" id="list_id_edit" value="<?php echo $id; ?>" />
                <!--                <div class="form-group">
                                  <button type="button" onclick="totalUserEdit();" class="btn btn-dark addContactBtn">Add New Contact</button>
                                  <button type="button" onclick="deleteSaveListEdit();" class="btn btn-dark">Delete</button>
                                 
                                </div>
                -->
                <input type="hidden" name="total_user_edit" id="total_user_edit" value="<?php echo count($arr_list_datails); ?>" /> 

                <div class="form-group">
                    <strong>List Name</strong>
                    <input type="text" value="<?php echo $arr_list_datails[0]['list_name']; ?>" readonly="readonly" required="required" name="list_name" class="form-control" style="width:50%" id="list_name">
                </div>

                <div class="form-group">
                    <table class="table table-bordered" id="savelistDivTableEdit">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Number</th>
                            </tr>
                        </thead>
                        <tbody id="savelistDivEdit">
                            <?php foreach ($arr_list_datails as $key => $list) { ?> 
                                <tr id="addListTREdit<?php echo $key; ?>">
                                    <td>
                                        <label class="inline-checkbox">
                                            <input class="flat" type="checkbox" id="locationthemesedit" name="locationthemesedit[]" value="<?php echo $key; ?>" />
                                        </label>
                                    </td>
                                    <td>
                                        <?php echo $list['first_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $list['last_name']; ?>
                                    </td>
                                    <td><?php echo $list['email']; ?></td>
                                    <td>
                                        <?php echo $list['phone']; ?>
                                    </td>
                            <input type="hidden" id="first_name_list<?php echo $key; ?>" name="first_name_list[]" value="<?php echo $list['first_name']; ?>" />
                            <input type="hidden" id="last_name_list<?php echo $key; ?>" name="last_name_list[]" value="<?php echo $list['last_name']; ?>" />
                            <input type="hidden" id="email_list<?php echo $key; ?>" name="email_list[]" value="<?php echo $list['email']; ?>" />
                            <input type="hidden" id="mobile_list<?php echo $key; ?>" name="mobile_list[]" value=" <?php echo $list['phone']; ?>" />
                            </tr>
                        <?php } ?>   


                        </tbody>
                    </table>
                </div>
                <div class="addNewContactWrap addNewContactWrapedit">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Country Code</th>
                                <th>Number</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="form-group text-center">
                        <button type="button" class="btn btn-dark" onclick="saveListEdit();">Save</button>
                        <button type="button" class="btn " onclick="cancelList();">Cancel</button>
                    </div>
                </div>



                <?php
            }
        }

        public function editSenderListMain() {
            $list_id = $this->input->post('list_id_edit');
            if ($list_id != '') {
                $arr_first_name = $this->input->post('first_name_list');
                $arr_last_name = $this->input->post('last_name_list');
                $arr_email = $this->input->post('email_list');
                
                $arr_mobile = $this->input->post('mobile_list');
                //echo '<pre>';print_r($arr_first_name);die;
                $arr_sender_data = $this->Common_model_marketing->getRecords("mst_sender_list", "*", array("id" => $list_id));

                $arr_list_ids[] = $list_id;
                
                $this->Common_model_marketing->deleteRows($arr_list_ids, "trans_sender_list", "list_id");

                if (count($arr_email) > 0) {
                    for ($i = 0; $i <= count($arr_email); $i++) {

                        $arr_users_data = ($this->Common_model_marketing->getRecords("users", "*", array("email" => $arr_email[$i])));
                       
//                        $user_id = $arr_users_data[0]['id'];
//                        $user_ids[] = $user_id;
//                        $this->Common_model_marketing->deleteRows($user_ids, "users", "id");

                       
//                        if (count($arr_users_data) < 1) {
                            $first_name = $arr_first_name[$i];
                            $last_name = $arr_last_name[$i];
                            $email = $arr_email[$i];
                            $mobile = $arr_mobile[$i];

                            if ($first_name != '' && $last_name != '' && $mobile != '') {
                                $arr_to_insert = array(
                                    "last_name" => $last_name,
                                    "first_name" => $first_name,
                                    "email" => $email,
                                    "phone" => $mobile,
                                    'created_on' => strtotime("Y-m-d H:i:s"),
                                );
                                $last_user_id = $this->Common_model_marketing->insertRow($arr_to_insert, "users");
                                 $this->Common_model_marketing->insertRow(array('user_id' => $last_user_id, 'group_id' => '4'), "users_groups");

                                $arr_to_insert = array(
                                    "list_id" => $list_id,
                                    "user_id" => $last_user_id,
                                    'created' => date("Y-m-d H:i:s"),
                                );

                                $last_insert = $this->Common_model_marketing->insertRow($arr_to_insert, "trans_sender_list");
                            }
//                        }
                    }
                    
                    $msg = 'Sender list updated successfully';
                    $this->session->set_userdata("msg", "<span class='success'>$msg </span>");
                    redirect(base_url() . "admin/marketing-sender-list");
                } else {
                    $msg = 'Some error occure';
                    $this->session->set_userdata("msg", "<span class='success'>$msg </span>");
                    redirect(base_url() . "admin/marketing-sender-list");
                }
            }
        }

        /* function to change job Status */

        public function changeStatus() {
            if ($this->input->post('post_id') != "") {
                #updating the user status.
                $arr_to_update = array(
                    "status" => $this->input->post('post_status')
                );
                #condition to update record	for the user status
                $condition_array = array('id' => intval($this->input->post('post_id')));
                $this->Common_model_marketing->updateRow(TABLES::$MST_JOBS, $arr_to_update, $condition_array);
                echo json_encode(array("error" => "0", "error_message" => "Status has changed successflly."));
            } else {
                #if something going wrong providing error message. 
                echo json_encode(array("error" => "1", "error_message" => "Sorry, your request can not be fulfilled this time. Please try again later"));
            }
        }

        public function uploadCSV() {
            $this->input->post('first_name');

            $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $total_user_latest = 600;
                $i = 0;
                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($i > 0) {
                        if ($importdata[0] != '' && $importdata[3] != '' && $importdata[4] != '') {
                            ?>
                            <tr id="addListTR<?php echo $total_user_latest; ?>">
                                <td>
                                    <label class="inline-checkbox">
                                        <input class="flat" type="checkbox" id="locationthemes" name="locationthemes[]" value="<?php echo $total_user_latest; ?>" />
                                    </label>
                                </td>
                                <td>
                                    <?php echo $importdata[0]; ?>
                                </td>
                                <td>
                                    <?php echo $importdata[1]; ?>
                                </td>
                                <td><?php echo $importdata[2]; ?></td>
                                <td>
                                    <?php //echo $country_code[$i];  ?>
                                    <?php echo '+' . $importdata[3] . $importdata[4]; ?>
                                </td>
                            <input type="hidden" id="first_name_list<?php echo $total_user_latest; ?>" name="first_name_list[]" value="<?php echo $importdata[0]; ?>" />
                            <input type="hidden" id="last_name_list<?php echo $total_user_latest; ?>" name="last_name_list[]" value="<?php echo $importdata[1]; ?>" />
                            <input type="hidden" id="email_list<?php echo $total_user_latest; ?>" name="email_list[]" value="<?php echo $importdata[2]; ?>" />
                            <input type="hidden" id="mobile_list<?php echo $total_user_latest; ?>" name="mobile_list[]" value="<?php echo $importdata[4]; ?>" />
                            <input type="hidden" id="country_code<?php echo $total_user_latest; ?>" name="country_code_list[]" value="<?php echo '+' . $importdata[3]; ?>" />

                        </tr>
                        <?php
                        $total_user_latest = $total_user_latest + 1;
                    }
                }$i = $i + 1;
            }
            fclose($file);
        }
    }

    public function uploadCSVEdit() {
        $this->input->post('first_name');
        $i = 0;
        $filename = $_FILES["file_edit"]["tmp_name"];
        if ($_FILES["file_edit"]["size"] > 0) {
            $file = fopen($filename, "r");
            $total_user_latest = 600;
            while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($i > 0) {
                    if ($importdata[0] != '' && $importdata[3] != '') {
                        ?>
                        <tr id="addListTR<?php echo $total_user_latest; ?>">
                            <td>
                                <label class="inline-checkbox">
                                    <input class="flat" type="checkbox" id="locationthemes" name="locationthemes[]" value="<?php echo $total_user_latest; ?>" />
                                </label>
                            </td>
                            <td>
                                <?php echo $importdata[0]; ?>
                            </td>
                            <td>
                                <?php echo $importdata[1]; ?>
                            </td>
                            <td><?php echo $importdata[2]; ?></td>
                            <td>

                                <?php echo '+' . $importdata[3] . $importdata[4]; ?>
                            </td>
                        <input type="hidden" id="first_name_list<?php echo $total_user_latest; ?>" name="first_name_list[]" value="<?php echo $importdata[0]; ?>" />
                        <input type="hidden" id="last_name_list<?php echo $total_user_latest; ?>" name="last_name_list[]" value="<?php echo $importdata[1]; ?>" />
                        <input type="hidden" id="email_list<?php echo $total_user_latest; ?>" name="email_list[]" value="<?php echo $importdata[2]; ?>" />
                        <input type="hidden" id="mobile_list<?php echo $total_user_latest; ?>" name="mobile_list[]" value="<?php echo '+' . $importdata[3] . $importdata[4]; ?>" />
                        <!--<input type="hidden" id="mobile_list<?php echo $total_user_latest; ?>" name="country_code_list[]" value="<?php echo '+' . $importdata[3] . $importdata[4]; ?>" />-->
                        </tr>
                        <?php
                        $total_user_latest = $total_user_latest + 1;
                    }
                } $i = $i + 1;
            }

            fclose($file);
        }
    }

    public function addToSaveList() {
        $from_edit = $this->input->post('from_edit');
        if ($from_edit == '10') {
            $first_name = $this->input->post('first_name_edit');
            // echo '<pre>';print_R($first_name);die;
            $last_name = $this->input->post('last_name_edit');
            $email = $this->input->post('email_edit');
            $mobile = $this->input->post('mobile_edit');
            $country_code = $this->input->post('country_code_edit');
            $total_user_latest = $this->input->post('total_user_edit');
        } else {
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');
            $country_code = $this->input->post('country_code');
            $total_user_latest = $this->input->post('total_user_latest');
        }

        if ($total_user_latest < 10) {
            $total_user_latest = ($total_user_latest % 10);
        }
        //echo '<pre>';print_R($first_name);die;
        if (count($first_name) > 0 && count($mobile) > 0) {
            for ($i = 0; $i < count($first_name); $i++) {
                if ($first_name[$i] != '' && $mobile[$i] != '' && $country_code[$i] != '') {
                    ?>
                    <tr id="addListTR<?php echo $total_user_latest; ?>">
                        <td>
                            <label class="inline-checkbox">
                                <input class="flat" type="checkbox" id="locationthemes" name="locationthemes[]" value="<?php echo $total_user_latest; ?>" />
                            </label>
                        </td>
                        <td>
                            <?php echo $first_name[$i]; ?>
                        </td>
                        <td>
                            <?php echo $last_name[$i]; ?>
                        </td>
                        <td><?php echo $email[$i]; ?></td>

                        <td>

                            <?php echo $country_code[$i] . $mobile[$i]; ?>
                        </td>
                    <input type="hidden" id="first_name_list<?php echo $total_user_latest; ?>" name="first_name_list[]" value="<?php echo $first_name[$i]; ?>" />
                    <input type="hidden" id="last_name_list<?php echo $total_user_latest; ?>" name="last_name_list[]" value="<?php echo $last_name[$i]; ?>" />
                    <input type="hidden" id="email_list<?php echo $total_user_latest; ?>" name="email_list[]" value="<?php echo $email[$i]; ?>" />
                    <input type="hidden" id="mobile_list<?php echo $total_user_latest; ?>" name="mobile_list[]" value="<?php echo $mobile[$i]; ?>" />
                    <input type="hidden" id="country_code_list<?php echo $total_user_latest; ?>" name="country_code_list[]" value="<?php echo $country_code[$i]; ?>" />

                    </tr>
                    <?php
                    $total_user_latest = $total_user_latest + 1;
                }
            }
        }
    }

}

/* End of file home.php */
    /* Location: ./application/controllers/home.php */
    