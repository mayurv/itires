<style>

    .modal-dialog.modal-md {
        width: 60%;
    }
</style>
<script src="<?php echo base_url() ?>media/backend/custom-script.js"></script>
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
                        <li role="presentation" ><a href="<?php echo base_url(); ?>admin/marketing-mail-list">Send Email</a>
                        </li>
                        <li role="presentation" class=""><a href="<?php echo base_url(); ?>admin/marketing-sms-list" >Send Sms</a>
                        </li>
                        <li role="presentation" class="active"><a href="#" >Sender List</a>
                        </li>

                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">





                            <div class="modal fade bs-example-modal-md addSenderModal addSenderModalAdd" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Add New Sender List</h4>
                                        </div>
                                        <!-- Start Form -->
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-2 form-group"><button class="btn btn-dark addContactBtn" onclick="totalUser();">Add New Contact</button></div>
                                                <div class="col-sm-1 form-group"><button class="btn btn-dark" onclick="deleteSaveList();">Delete</button></div>
                                                <div class="col-sm-6 form-group"><form id="frm_upload_csv" name="frm_upload_csv" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admin/uploadCSV"  enctype="multipart/form-data"  method="POST">
                                                        <p class="pull-left"><input type="file" id="file" name="file" class="addSenderUploadFile form-control" ><small style="color:red;">Upload only csv file*.</small> </p>
                                                        <input type="button" name="upload_csv" id="upload_csv" class="btn btn-dark pull-left"  value="Upload" onclick="uploadCSV();"><br/>


                                                    </form></div>
                                            </div>

                                            <form id="frm_add_Sender_list" name="frm_add_Sender_list" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admin/marketing-sender-add"  enctype="multipart/form-data"  method="POST">
                                                <input type="hidden" name="total_user" id="total_user" value="0" /> 

                                                <div class="form-group">
                                                    <strong>List Name</strong>
                                                    <input type="text"  required="required" name="list_name" class="form-control" style="width:50%" id="list_name">
                                                </div>
                                                <div class="form-group">
                                                    <table class="table table-bordered"  id="savelistDivTable" style="display:none;">
                                                        <thead>
                                                            <tr>
                                                                <th>Select</th>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Email</th>
                          <!--                                      <th>Country Code</th>-->
                                                                <th>Number</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="savelistDiv">




                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="addNewContactWrap">
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
                                                        <button type="button" class="btn btn-dark" onclick="saveList();">Save</button>
                                                        <button type="" class="btn cancelNewConatct">Cancel</button>
                                                    </div>
                                                </div>

                                                <!--                              <div class="form-group">
                                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Name
                                                                                </label>
                                                                                <div class="col-md-8 col-sm-6 col-xs-12">
                                                                                  <div class="mCustomScrollbar userNameList">
                                                <?php
                                                if (isset($arr_users_list) && count($arr_users_list) > 0) {
                                                    foreach ($arr_users_list as $user) {
                                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                       <label class="inline-checkbox">
                                                                                                                                                                                                                                                                                                                                                                                                                                        <input name="checkbox[]"  class="flat" type="checkbox" id="checkbox[]" value="<?php echo $user['id']; ?>" /> &nbsp;&nbsp;<?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                       </label><br>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                                                  </div>
                                                                                </div>
                                                                              </div>     -->
                                                <!--div class="ln_solid"></div-->

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <!--<button type="button" class="btn btn-dark">Submit</button>-->
                                                    <input type="submit" class="btn btn-dark" name="notification_submit" id="notification_submit" value="Submit" />
                                                </div>
                                            </form>
                                        </div>



                                        <!-- End Form -->

                                    </div>
                                </div>
                            </div>

                            <!-- View notification start here  -->  
                            <div class="modal fade bs-example-modal-md-view-notification addSenderModal addSenderModaledit " tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Edit sender list</h4>
                                        </div>
                                        <!-- Start Form -->
                                        <br>

                                        <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->
                                        <div class="col-sm-12"> 
                                            <div class="row">
                                            <div class="col-sm-2 form-group"><button type="button" onclick="totalUserEdit();" class="btn btn-dark addContactBtn">Add New Contact</button></div>
                                            <div class="col-sm-1 form-group"><button type="button" onclick="deleteSaveListEdit();" class="btn btn-dark">Delete</button></div>
                                            <div class="col-sm-6 form-group">
                                                <form id="frm_upload_csv_edit" name="frm_upload_csv_edit" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>admin/uploadCSV"  enctype="multipart/form-data"  method="POST">
                                                    <p class="pull-left"><input type="file" id="file_edit" name="file_edit" class="addSenderUploadFile form-control" > <small style="color:red;">Upload only csv file*.</small></p>
                                                    <input type="button" name="upload_csv" id="upload_csv" class="btn btn-dark"  value="Upload" onclick="uploadCSVEdit();">

                                                </form>
                                            </div>
                                        </div>
                                        </div>





                                        <form class="form-horizontal form-label-left" name="frm_admin_edit_sender" id="frm_admin_edit_sender" action="<?php echo base_url(); ?>backend/admin/edit-sender-list" method="post">      
                                            <input type="hidden" name="from_edit" id="from_edit" value="10" />
                                            <div class="modal-body">

                                                <div id="manager_div">


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <!--<button type="button" class="btn btn-dark">Save changes</button>-->
                                                    <input type="submit" class="btn btn-dark" name="btn_save_change" id="btn_save_changes" value="Save changes" />
                                                </div>


                                                <!-- End Form -->

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- View notification end here  -->


                            <form name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>admin/marketing-sender-list" method="post">

                                <button type="button" class="btn btn btn-dark btn-round btn-sm" data-toggle="modal" data-target=".bs-example-modal-md">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New</button>

                                <?php if (count($arr_sender_list) > 0) { ?>
                                    <input type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn btn-dark btn-round btn-sm" onClick="return deleteConfirm();"  value="Delete">                                            
                                <?php } ?>
                                <div class="">
                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" >
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                  <!--<th class="column-title">Select</th>-->
                                                </th>
                                                <th class="column-title">List Name</th>
                                                <!--<th class="column-title">Total User </th>-->
                                                <th class="column-title">Created on </th>

                                                <th class="column-title no-link last"><span class="nobr">Action</span>
                                                </th>
                                                <th class="bulk-actions" colspan="7">
                                                    <a class="antoo" style="color:#fff; font-weight:500;"> Select Multiple rows </a>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if (isset($arr_sender_list) && count($arr_sender_list) > 0) {
                                                foreach ($arr_sender_list as $list) {
                                                    ?> 
                                                    <tr class="even pointer">
                                                        <td class="a-center ">
                                                          <!--<input type="checkbox" class="flat" name="table_records">-->
                                                            <input name="checkbox[]" class="flat" type="checkbox" id="checkbox[]" value="<?php echo $list['id']; ?>" />
                                                        </td>
                                                        <td class=" "><?php echo $list['list_name']; ?></td>
                                                        <!--<td class=" "><?php echo $list['total_user']; ?></td>-->
                                                        <td class=""><?php echo date('Y-m-d H:i:s', strtotime($list['created'])); ?> </td>
                                                        <td class="last"><a class="btn btn btn-dark btn-round btn-sm" onclick="editSenderList('<?php echo $list['id']; ?>')" data-toggle="modal" data-target=".bs-example-modal-md-view-notification">Edit</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
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
                                                            function editSenderList(id) {


                                                                $.ajax({
                                                                    url: "<?php echo base_url() . 'admin/marketing-edit-senderList'; ?>", //The url where the server req would we made.
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

                                                            function totalUser() {
                                                                var total_user = $('#total_user').val();
                                                                var a = 1;
                                                                var x = parseInt(total_user) + parseInt(a);
                                                                $('#total_user').val(x);
                                                            }

                                                            function totalUserEdit() {
                                                                var total_user = $('#total_user_edit').val();
                                                                var a = 1;
                                                                var x = parseInt(total_user) + parseInt(a);
                                                                $('#total_user_edit').val(x);
                                                            }


                                                            function saveList() {

                                                                $('#savelistDivTable').css('display', '');

                                                                var total_user_latest = $('#total_user').val();



                                                                // var first_name = $('input[name="first_name[]"]').val();
                                                                var first_name = $("input[name='first_name[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                var last_name = $("input[name='last_name[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                var email = $("input[name='email[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                var mobile = $("input[name='mobile[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                var country_code = $('select[name=country_code]').val();

                                                                var formData = new FormData($("#frm_add_Sender_list")[0]);

                                                                var country_code = new Array();//storing the selected values inside an array
                                                                $('select[name=country_code] :selected').each(function (i, selected) {
                                                                    country_code[i] = $(selected).val();
                                                                });


                                                                //var first_name=$('#first_name').val();

                                                                var i = 0;
                                                                if (first_name != '' && last_name != '' && email != '' && mobile != '') {
                                                                    var i = 1;
                                                                    $.ajax({
                                                                        url: "<?php echo base_url() . 'admin/marketing-add-savelist'; ?>", //The url where the server req would we made.
                                                                        async: false,
                                                                        type: "POST",
//                      data: {
//                            first_name: first_name,
//                            last_name: last_name,
//                            email: email,
//                            mobile: mobile,
//                            total_user_latest: total_user_latest,
//                            country_code: country_code,
//                        },
//                       dataType: "html", 


                                                                        data: formData,
                                                                        cache: false,
                                                                        contentType: false,
                                                                        processData: false,
                                                                        mimeType: "multipart/form-data",
                                                                        dataType: 'html',
                                                                        success: function (data) {
                                                                            //data is the html of the page where the request is made.
                                                                            //$('#manager_div').html(data);
                                                                            $('#savelistDiv').append(data);


                                                                            var total_user = $('#total_user').val();

                                                                            for (i = 0; i <= 30; i++) {
                                                                                $('#first_name' + i).val('');
                                                                                $('#last_name' + i).val('');
                                                                                $('#email' + i).val('');
                                                                                $('#mobile' + i).val('');
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                                if (i == 0) {
                                                                    if (first_name == '') {
                                                                        alert('Please enter first name');
                                                                    } else if (last_name == '') {
                                                                        alert('Please enter last name');
                                                                    } else if (email == '') {
                                                                        alert('Please enter email');
                                                                    } else if (mobile == '') {
                                                                        alert('Please enter mobile');
                                                                    }
                                                                }

                                                            }
















                                                            function deleteSaveList() {
                                                                $('input[name="locationthemes[]"]:checked').each(function () {
                                                                    var id = '';
                                                                    id = this.value;
                                                                    $('#addListTR' + id).css('display', 'none');
                                                                    $('#first_name_list' + id).val('');
                                                                    $('#last_name_list' + id).val('');
                                                                    $('#email_list' + id).val('');
                                                                    $('#mobile_list' + id).val('');

                                                                });
                                                            }



                                                            function deleteSaveListEdit() {
                                                                $('input[name="locationthemesedit[]"]:checked').each(function () {
                                                                    var id = '';
                                                                    id = this.value;
                                                                    $('#addListTREdit' + id).css('display', 'none');
                                                                    $('#first_name_list' + id).val('');
                                                                    $('#last_name_list' + id).val('');
                                                                    $('#email_list' + id).val('');
                                                                    $('#mobile_list' + id).val('');

                                                                });
                                                            }






                                                            function saveListEdit() {
                                                                var total_user_latest = $('#total_user_edit').val();



                                                                // var first_name = $('input[name="first_name[]"]').val();
                                                                var first_name = $("input[name='first_name_edit[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                var last_name = $("input[name='last_name_edit[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                var email = $("input[name='email_edit[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                var mobile = $("input[name='mobile_edit[]']").map(function () {
                                                                    return $(this).val();
                                                                }).get();
                                                                // var country_code = $("select").map(function() { return this.value; });
                                                                var formData = new FormData($("#frm_admin_edit_sender")[0]);


                                                                var i = 0;
                                                                if (first_name != '' && last_name != '' && email != '' && mobile != '') {
                                                                    var i = 1;
                                                                    $.ajax({
                                                                        url: "<?php echo base_url() . 'admin/marketing-add-savelist'; ?>", //The url where the server req would we made.
                                                                        async: false,
                                                                        type: "POST",
                                                                        data: formData,
                                                                        cache: false,
                                                                        contentType: false,
                                                                        processData: false,
                                                                        mimeType: "multipart/form-data",
                                                                        dataType: 'html',
                                                                        //This is the function which will be called if ajax call is successful.
                                                                        success: function (data) {
                                                                            //data is the html of the page where the request is made.
                                                                            //$('#manager_div').html(data);
                                                                            $('#savelistDivEdit').append(data);


                                                                            var total_user = $('#total_user_edit').val();

                                                                            for (i = 0; i <= 30; i++) {
                                                                                $('#first_name_edit' + i).val('');
                                                                                $('#last_name_edit' + i).val('');
                                                                                $('#email_edit' + i).val('');
                                                                                $('#mobile_edit' + i).val('');
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                                if (i == 0) {
                                                                    if (first_name == '') {
                                                                        alert('Please enter first name');
                                                                    } else if (last_name == '') {
                                                                        alert('Please enter last name');
                                                                    } else if (email == '') {
                                                                        alert('Please enter email');
                                                                    } else if (mobile == '') {
                                                                        alert('Please enter mobile');
                                                                    }
                                                                }

                                                            }

                                                            function deleterow(id) {
                                                                $('#deleteTR' + id).remove();

                                                            }

                                                            function cancelList() {
                                                                $('.addNewContactWrapedit').css('display', 'none');

                                                            }

</script>


<script type="text/javascript">


    // $( document ).ready(function() {
    // $('#upload_csv').on('click', function (e) {

    function uploadCSV() {
        var text = $('#file').val(),
                ext = text.split('.')[1];
        if (ext == 'csv') {
            $('#savelistDivTable').css('display', '');
            var formData = new FormData($("#frm_upload_csv")[0]);
            //alert(formData);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/uploadCSV'; ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                dataType: 'html',
                success: function (data)
                {
                    //alert(data);
                    $('#savelistDiv').append(data);
                }
            });
        } else {
            // alert('Please upload only csv file.')

            $('#my_message').html('Please upload only csv file.');
            $('#myModal').modal('show');
        }

    }





    function uploadCSVEdit() {

        var text = $('#file_edit').val(),
                ext = text.split('.')[1];
        if (ext == 'csv') {
            //$('#savelistDivTable').css('display','');  
            var formData = new FormData($("#frm_upload_csv_edit")[0]);
            //alert(formData);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/uploadCSVEdit'; ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                dataType: 'html',
                success: function (data)
                {
                    //alert(data);
                    $('#savelistDivEdit').append(data);
                }
            });
        } else {

            $('#my_message').html('Please upload only csv file.');

            $('#myModal').modal('show');
            //alert('Please upload only csv file.')
        }
    }

    // });


// });

</script>		