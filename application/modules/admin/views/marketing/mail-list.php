<style>
    .danger, .mandatory {
        color: #BD4247;
    }
    .alert{
        padding:8px 0px;
    }
</style> 
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script src="<?php echo base_url()?>media/backend/custom-script.js"></script>
<!-- page content -->
<div class="" role="main">
    <!-- top tiles -->
    <div class="row">
        <div class="x_panel">
            <?php
            $msg = $this->session->userdata('msg');
            ?>
            <?php if ($msg != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                    <?php
                    echo $msg;
                    $this->session->unset_userdata('msg');
                    ?>
                </div>
            <?php } ?>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
<!--                        <li role="presentation"><a href="<?php echo base_url(); ?>admin/marketing-list">Push Notification</a>
                        </li>-->
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"  >Send Email</a>
                        </li>
                        <li role="presentation" class=""><a href="<?php echo base_url(); ?>admin/marketing-sms-list" >Send Sms</a>
                        </li>
                        <li role="presentation" class=""><a href="<?php echo base_url(); ?>admin/marketing-sender-list" >Sender List</a>
                        </li>

                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">





                            <div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Send a New Mail</h4>
                                        </div>
                                        <!-- Start Form -->

                                        <form id="frm_mail" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admin/marketing-mail-add"  enctype="multipart/form-data"  method="POST">

                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sender Name
                                                    </label>
                                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control col-md-7 col-xs-12" required="required" name="sender_name"   id="sender_name">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sender List
                                                    </label>
                                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                                        <select class="form-control" required="required" id="sender_list" name="sender_list">
                                                            <option value="">Choose Option</option>
                                                            <?php
                                                            if (isset($arr_sender_list) && count($arr_sender_list) > 0) {
                                                                foreach ($arr_sender_list as $list) {
                                                                    ?>
                                                                    <option value="<?php echo $list['id']; ?>"><?php echo $list['list_name']; ?></option>
    <?php }
} ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">From Email
                                                    </label>
                                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                                        <input type="email" class="form-control col-md-7 col-xs-12" required="required" name="email"   id="email">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Subject
                                                    </label>
                                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                                        <input type="text" class="form-control col-md-7 col-xs-12" required="required" name="subject"   id="subject">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
                                                    <div class="col-md-8 col-sm-6 col-xs-12" style="margin-top: 7px;">
                                                        <input  id="img_file_one"  name="img_file_one" type="file" >
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                                    </label>
                                                    <div class="col-md-8 col-sm-6 col-xs-12" style="margin-top: 7px;">
                                                        <textarea class="ckeditor form-control col-md-7 col-xs-12" required="required" data-validate-length-range="5,100" id="productdescription" name="inputPostDescription" ></textarea>
                                                        <div class="error hidden" id="labelProductError">Enter content length should be greater than 12. </div>

                                                    </div>
                                                </div>

                                                <!--div class="ln_solid"></div-->

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <!--<button type="button" class="btn btn-dark">Submit</button>-->
                                                <input type="submit" class="btn btn-dark" name="notification_submit" id="notification_submit" value="Submit" />
                                            </div>
                                        </form>

                                        <!-- End Form -->

                                    </div>
                                </div>
                            </div>

                            <!-- View notification start here  -->  
                            <div class="modal fade bs-example-modal-md-view-notification" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">View Mail</h4>
                                        </div>
                                        <!-- Start Form -->

                                        <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->
                                        <form class="form-horizontal form-label-left" name="frm_admin_edit_manager" id="frm_admin_edit_manager" action="<?php echo base_url(); ?>backend/admin/edit-profile-manager" method="post">      
                                            <div class="modal-body">

                                                <div id="manager_div">


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <!--<button type="button" class="btn btn-dark">Save changes</button>-->
                                                    <!--<input type="submit" class="btn btn-dark" name="btn_save_change" id="btn_save_changes" value="Save changes" />-->
                                                </div>


                                                <!-- End Form -->

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- View notification end here  -->


                            <form name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>admin/marketing-list" method="post">
                                <button type="button" class="btn btn btn-dark btn-round btn-sm" data-toggle="modal" data-target=".bs-example-modal-md">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New</button>


                                <?php if (count($arr_mail_list) > 0) { ?>
                                    <input type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn btn-dark btn-round btn-sm" onClick="return deleteConfirm();"  value="Delete">                                            
<?php } ?>
                                <div class="">
                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" >
                                        <thead>
                                            <tr class="headings">
                                                <th>

                                                </th>
                                                <th class="column-title">Date</th>
                                                <th class="column-title">Sender Name </th>
                                                <th class="column-title">Email </th>
                                                <th class="column-title">Suject </th>
                                                <th class="column-title">Message </th>

                                                <th class="column-title no-link last"><span class="nobr">Action</span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;"> Select Multiple rows </a>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if (isset($arr_mail_list) && count($arr_mail_list) > 0) {
                                                foreach ($arr_mail_list as $mail) {
                                                    ?> 
                                                    <tr class="even pointer">
                                                        <td class="a-center ">
                                                          <!--<input type="checkbox" class="flat" name="table_records">-->
                                                            <input name="checkbox[]" class="flat" type="checkbox" id="checkbox[]" value="<?php echo $mail['id']; ?>" />
                                                        </td>
                                                        <td class=""><?php echo date('Y-m-d', strtotime($mail['created'])); ?> </td>
                                                        <td class=" "><?php echo $mail['sender_name']; ?></td>
                                                        <td class=" "><?php echo $mail['email']; ?></td>
                                                        <td class=" "><?php echo $mail['subject']; ?></td>
                                                        <td class=" "><?php echo substr($mail['description'], 0, 100) . ((strlen($mail['description']) > 100) ? '...' : ''); ?></td>


                                                        <td class=" last"><a class="btn btn btn-dark btn-round btn-sm" onclick="viewMail('<?php echo $mail['id']; ?>')" data-toggle="modal" data-target=".bs-example-modal-md-view-notification">View</a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr class="even pointer">
                                                    <td class="" colspan="10">No data available.</td>
                                                </tr>
<?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /top tiles -->

</div>
<!-- /page content -->
<script src="<?php echo base_url(); ?>media/backend/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
                                                    function viewMail(id) {

                                                        $.ajax({
                                                            url: "<?php echo base_url() . 'admin/marketing-view-mail'; ?>", //The url where the server req would we made.
                                                            async: false,
                                                            type: "POST", //The type which you want to use: GET/POST
                                                            data: "id=" + id, //The variables which are going.
                                                            dataType: "html", //Return data type (what we expect).

                                                            //This is the function which will be called if ajax call is successful.
                                                            success: function (data) {
                                                                //data is the html of the page where the request is made.
                                                                $('#manager_div').html(data);
                                                            }
                                                        });
                                                    }




</script>
