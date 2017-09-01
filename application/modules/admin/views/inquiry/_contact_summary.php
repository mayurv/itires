<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $page_title; ?></h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            
            <div class="x_panel">
                <div class="x_title">
                    <h2>Inquiry Summary</h2>
                    <!--<button id="btn_toggl_vw" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add New Page</button>-->
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <div id="id_list_attribute_form">
                        <table id="attr_datatable" class="table">
                            <thead>
                                <tr>
                                    <!--<th>#</th>-->
                                    <th>Sr No</th>

                                    <th>Name </th>
                                    <th>Email </th>
                                    <th>Message </th>

                                    <th>Date </th>
                                    <th>Action </th>

                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($inquiry_conatact as $inq) {
                                ?>
                                <tbody>

                                    <tr id="attr_<?php echo $inq['id']; ?>">
                                            <!--<td>1</td>-->
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $inq['name']; ?></td>
                                        <td><?php echo $inq['email']; ?></td>
                                        <td><?php echo $inq['message']; ?></td>


                                        <td >
    <?php echo $inq['created_date']; ?>
                                        </td>
                                        <td>
                                            <!--<a href="" class="btn btn-round btn-xs btn-default" ><i class="fa fa-pencil"></i></a>-->
                                            <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteAttribute(<?php echo $inq['id']; ?>)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>

                                </tbody>
                                <?php
                            }
                            ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>     
</div>
<?php //$this->load->view('modal/modal_edit_pa');  ?>
<script src="<?php echo base_url() ?>backend/vendors/ckeditor/ckeditor.js"></script>
<script>
                                                CKEDITOR.replace('desc');
</script>
<script>
    $(document).ready(function () {
        $("#attr_datatable").dataTable();

        $("#id_add_tags").click(function () {
            var count = parseInt($("#tag_count").val());
            var count = count + 1;
            $("#tag_count").val(count);
            $('#div_add_more').append('<label for="sub_attribute_name" class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-3 col-sm-3 col-xs-12"> <input id="sub_attribute_name" class="form-control col-md-3 col-xs-12" type="text" name="sub_attribute_name[]" placeholder="Name">    </div>                            <div class="col-md-3 col-sm-3 col-xs-12">                                <div class="control-group">                                    <div class="col-md-12 col-sm-12 col-xs-12">                                        <input id="tags_' + count + '" name="tags[]" type="text" class="tags form-control" value="" />                                        <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>                                    </div>                                </div>                            </div><div class="clearfix"></div>');
            $('#tags_' + count).tagsInput({
                width: 'auto'
            });
        });
        $("#btn_toggl_vw").click(function () {
            $("#id_list_attribute_form").toggle();
            $("#id_add_attribute_form").toggle();
            $("#btn_toggl_vw").toggle();
        });
//        $("#btn_cancel_vw").click(function () {
//            $("#id_list_attribute_form").toggle();
//            $("#id_add_attribute_form").hide();
//            $("#btn_toggl_vw").toggle();
//        });

    });

</script>

<script>
    function deleteAttribute(id) {
//        alert(id);
        var dataString = {
            'id': id,
            'method': 'delete'
        };
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/contact_info/delete',
            data: dataString,
            success: function (data) {
                   $("#attr_" + id).remove();
//                     window.location.reload();
                    new PNotify({
                        title: 'Success',
                        text: 'Inquiry deleted successfully',
                        type: 'error',
                        styling: 'bootstrap3',
                        nonblock: {
                            nonblock: false
                        }
                    });
               
            }
        });
    }
    function validate() {
        //alert('test');
        $("#file_error").html("");
        $(".demoInputBox").css("border-color", "#F0F0F0");
        var file_size = $('#file1')[0].files[0].size;
        console.log(file_size);
        if (file_size > 123981) {
            //$('#file1')[0].val('');
            $("#file1").val("");
            alert('File size is greater than 2MB');
            $("#file_error").html("File size is greater than 2MB");
            $(".demoInputBox").css("border-color", "#FF0000");
            return false;
        }
        return true;
    }
</script>

