


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
                    <h2><i class="fa fa-align-left"></i> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    
                    <!-- start accordion -->
                    <form action="<?php echo base_url(); ?>admin/section/add_section/add" method="post" enctype="multipart/form-data">
                        <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                            <!--                      <div class="panel">-->
                            <input type="hidden" name="page_id" value="<?= $this->uri->segment(4) ?>">
                            <?php if ($title_s['page_alias'] == 'Home') { ?>
                                <div class="panel" style="display:block">
                                <?php } else { ?>

                                    <div class="panel" style="display:none">
                                    <?php } ?>
                                    <a class="panel-heading collapsed" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne">
                                        <h4 class="panel-title">Section-1</h4>
                                    </a>

                                    <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="id_add_attribute_form" hidden="">
                                                <a id="id_add_more_image" class="" style="float: right;margin-right: 76px;"><i class="fa fa-plus-circle" ></i> Add  more</a>
                                                <div  id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                                                    <div class="form-group">
                                                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="text" name="title1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <div class="compose-body">
                                                                <textarea name="editor1[]" id="editor" rows="10" cols="80">
                    
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Image<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="file" name="upload1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">indicator<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="file" name="upload2[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">link<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                            <input type="text" name="link1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link">
                                                        </div>
                                                    </div>




                                                    <div id="file_error"></div>
                                                    <div class="ln_solid"></div>


                                                </div>
                                            </div>
                                        </div>
                                        <input hidden id="cnt" value="0">
                                        <div id="slider">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo">
                                        <h4 class="panel-title">Section-2</h4>
                                    </a>
                                    <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="title[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="compose-body">
                                                            <textarea name="editor[]" id="editor1" rows="10" cols="80">
                    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Section-3</h4>
                                    </a>
                                    <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="title[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="compose-body">
                                                            <textarea name="editor[]" id="editor2" rows="10" cols="80">
                    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingFive1" data-toggle="collapse" data-parent="#accordion1" href="#collapseFive1" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Section-4</h4>
                                    </a>
                                    <div id="collapseFive1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="title[]" id="attribute_value" class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="compose-body">
                                                            <textarea name="editor[]" id="editor3" rows="10" cols="80">
                    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Section-5-->
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingFour1" data-toggle="collapse" data-parent="#accordion1" href="#collapseFour1" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Section-5</h4>
                                    </a>
                                    <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="title[]" id="attribute_value" class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="compose-body">
                                                            <textarea name="editor[]" id="editor4" rows="10" cols="80">
                    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Section-6-->
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingSix1" data-toggle="collapse" data-parent="#accordion1" href="#collapseSix1" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Section-6</h4>
                                    </a>
                                    <div id="collapseSix1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="title[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="compose-body">
                                                            <textarea name="editor[]" id="editor5" rows="10" cols="80">
                    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Section-->
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingSeven1" data-toggle="collapse" data-parent="#accordion1" href="#collapseSeven1" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Section-7</h4>
                                    </a>
                                    <div id="collapseSeven1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="title[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="compose-body">
                                                            <textarea name="editor[]" id="editor6" rows="10" cols="80">
                    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Section-->
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingEight1" data-toggle="collapse" data-parent="#accordion1" href="#collapseEight1" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Section-8</h4>
                                    </a>
                                    <div id="collapseEight1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="title[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="compose-body">
                                                            <textarea name="editor[]" id="editor7" rows="10" cols="80">
                    
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button">Reset</button>
                                    <button type="submit" name="userSubmit" class="btn btn-success">Submit</button>
                                    <!--                                    <button id="btn_cancel_vw" type="button" class="btn btn-success">Cancel</button>-->
                                </div>
                            </div>

                            <!-- end of accordion -->


                        </div>
                    </form>
                </div>
            </div>
        </div>     
    </div>
    <?php //$this->load->view('modal/modal_edit_pa');   ?>
    <script src="<?php echo base_url() ?>backend/vendors/ckeditor/ckeditor.js"></script>
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
            //  $("#btn_toggl_vw").click(function () {
            $("#id_list_attribute_form").toggle();
            $("#id_add_attribute_form").toggle();
            $("#btn_toggl_vw").toggle();
            //  });
            $("#btn_cancel_vw").click(function () {
                $("#id_list_attribute_form").toggle();
                $("#id_add_attribute_form").hide();
                $("#btn_toggl_vw").toggle();
            });
            //          var i=1;
            $("#id_add_more_image").click(function () {
                // alert('hi');
                var i = $('#cnt').val();
                i++;

                $('#cnt').val(i)
                if (i == 5) {
                    alert('You can add only upto 5 slider');
                    return false;
                }
                $('#slider').append('<div class="panel-body">' +
                        '<div id="id_add_attribute_form" >' +
                        '<div  id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">' +
                        '<div class="form-group">' +
                        '<label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-9 col-sm-9 col-xs-12">' +
                        '<input type="text" name="title1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Title">' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-9 col-sm-9 col-xs-12">' +
                        '<div class="compose-body">' +
                        '<textarea name="editor1[]" id="desc' + i + '" rows="10" cols="80">' +
                        '</textarea>' +
                        '</div>' +
                        '</div>' +
                        ' </div>' +
                        '<div class="form-group">' +
                        '<label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Image<span class="required">*</span>' +
                        '</label>' +
                        '<div class="col-md-9 col-sm-9 col-xs-12">' +
                        '<input type="file" name="upload1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link">' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">indicator<span class="required">*</span>' +
                        ' </label>' +
                        '<div class="col-md-9 col-sm-9 col-xs-12">' +
                        '<input type="file" name="upload2[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link">' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">link<span class="required">*</span>' +
                        ' </label>' +
                        ' <div class="col-md-9 col-sm-9 col-xs-12">' +
                        '  <input type="text" name="link1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link">' +
                        '</div>' +
                        ' </div>' +
                        '<div id="file_error"></div>' +
                        '<div class="ln_solid"></div>' +
                        '</div>' +
                        '</div>' +
                        ' </div>'

                        );

                //  CKEDITOR.replace(this.get(0));
                //console.log(i);
                //           for(j=1;j<=i;j++)
                //           {
                CKEDITOR.replace('desc' + i);
                console.log(CKEDITOR.replace('desc' + i));
                //           }
                //CKEDITOR.replace('desc1');
                $('#slider1').append('<div></div><div class="col-md-1"><i class="fa fa-trash text-danger"></i></div>');

            });
        });

    </script>

    <script>
        function deleteAttribute(id) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/slider/delete/' + id,
                success: function (data) {
                    // alert(data);
                    if (data == '200')
                    {
                        window.location.reload();
                    }
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
