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
            <?php
            $msg = $this->session->flashdata('msg');
            if ($msg != '') {
                ?>
                <script>
                    $(document).ready(function () {
                        new PNotify({
                            title: 'Success',
                            text: '<?php echo $msg; ?>',
                            type: 'success',
                            styling: 'bootstrap3',
                            nonblock: {
                                nonblock: false
                            }
                        });
                    });
                </script>
            <?php } ?>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Blog Category</h2>
                    <button id="btn_toggl_vw" type="button" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus-circle" ></i> Add Category</button>
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
                                    <th>Category Name </th>

                                    <th>#</th>
                                </tr>
                            </thead>
                            <?php
                            // print_r($slider);
                            $count = 1;
                            foreach ($bcategory as $cat) {
                                ?>
                                <tbody>

                                    <tr id="attr_<?= $cat['id']; ?>">
                                            <!--<td>1</td>-->
                                        <td><?= $count++ ?></td>
                                        <td>
                                            <?= $cat['category_name']; ?>
                                        </td>

                                        <td>
                                            <a  href="<?= base_url() ?>admin/blog/category/<?= $cat['id']; ?>" class="btn btn-round btn-xs btn-default" data-toggle="modal" d><i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-round btn-xs btn-danger" data-toggle="modal" onclick="deleteAttribute(<?= $cat['id']; ?>)"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>

                                </tbody>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div id="id_add_attribute_form" hidden="">
                        <form action="<?php echo base_url(); ?>admin/blog/add_cat/add" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="category_name" id="attribute_value" required="required" class="form-control col-md-7 col-xs-12" placeholder="Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="status" name="status" class="form-control">
                                        <option value="0">Active</option>
                                        <option value="1">InActive</option>
                                    </select>
                                </div>
                            </div>


                            <div class="clearfix"></div>



                            <div id="file_error"></div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" name="userSubmit" class="btn btn-success">Submit</button>
                                    <button id="btn_cancel_vw" type="button" class="btn btn-success">Cancel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>
<?php //$this->load->view('modal/modal_edit_pa');  ?>

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
        $("#btn_cancel_vw").click(function () {
            $("#id_list_attribute_form").toggle();
            $("#id_add_attribute_form").hide();
            $("#btn_toggl_vw").toggle();
        });

    });

</script>

<script>
    function deleteAttribute(id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/blog/delete/' + id,
            success: function (data) {
              $("#attr_" + id).remove();
//                     window.location.reload();
                    new PNotify({
                        title: 'Success',
                        text: 'category deleted successfully',
                        type: 'error',
                        styling: 'bootstrap3',
                        nonblock: {
                            nonblock: false
                        }
                    });
                    //window.location.href = '<?= base_url() ?>/admin/blog/category';
                   
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

