


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
                    <h2><i class="fa fa-align-left"></i>     <?= $title_s['page_alias'] ?> <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    // print_r($home_page_section);
                    
                    ?>
                    <form action="<?php echo base_url(); ?>admin/section/add_section/edit/<?= $home_page_section[0]['cms_id'] ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="page_id" value="<?= $home_page_section[0]['cms_id'] ?>">
                        <!-- start accordion -->

                        <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                            <?php
                            //$title_s['page_alias'];
                            if ($title_s['page_alias'] == 'Home') {
                                ?>
                                  
                                <div class="panel">
                                    <?php
                                } else {
                                    ?>

                                    
                                    <div class="panel" style="display:none">
                                        <?php
                                    }
                                    ?>

                                    <a class="panel-heading collapsed" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne">
                                        <h4 class="panel-title">Slider-1</h4>
                                    </a>

                                    <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                        <?php
//                                        echo '<pre>';
//                                        print_r($slider_page_section);
//                                        die();
                                        if (isset($slider_page_section)) {
                                            ?>
                                            <?php
                                            $count = 1;
                                            $i = '';
                                            foreach ($slider_page_section as $key => $secData) {
                                                ?>
                                        <input type="hidden" value="<?=$secData['id']?>" name="sid[]">
                                                <div class="panel-body">
                                                    <div id="id_add_attribute_form_<?php echo $key ?>">
                                                        <div  id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                                                            <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                                </label>                                                    
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                    <input type="text" name="title1[]" id="attribute_value" value="<?= $secData['title'] ?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                    <div class="compose-body">
                                                                        <textarea name="editor1[]" id="editor<?php echo  $i++?>" rows="10" cols="80">
                                                                            <?= $secData['description'] ?>
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Image<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                        
                                                                    <?php echo $secData['banner_image']?>
                                                                    <input type="file" name="upload1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link"  value="<?php echo $secData['banner_image']?>">
                                                                     <input type="hidden" name="file1[]" value="<?php echo $secData['banner_image']?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">indicator<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                    <?php echo $secData['small_image']?>
                                                                    <input type="file" name="upload2[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?php echo $secData['small_image']?>">
                                                                    <input type="hidden" name="file2[]" value="<?php echo $secData['small_image']?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">link<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                    <input type="text" name="link1[]" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?= $secData['link'] ?>">
                                                                </div>
                                                            </div>

                                                            <div id="file_error"></div>
                                                            <div class="ln_solid"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>

                                </div>
                                <?php if (isset($home_page_section)) { ?>
                                    <?php
                                    if ($title_s['page_alias'] == 'Home')
                                        unset($home_page_section[0])
                                        ?>
                                    <?php
                                    $count = 1;
                                    $i = '';
                                    foreach ($home_page_section as $key => $secData) {
                                        ?>
                                        <input type="hidden" name="test[]" value="<?php echo $secData['cms_val_id'] ?>" >
                                        <div class="panel">
                                            <a class="panel-heading collapsed" role="tab" id="headingTwo_<?php echo $secData['cms_val_id'] ?>" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo_<?php echo $secData['cms_val_id'] ?>" aria-expanded="false" aria-controls="collapseTwo">
                                                <h4 class="panel-title">Section-<?php echo $count++; ?></h4>
                                            </a>
                                            <div id="collapseTwo_<?php echo $secData['cms_val_id'] ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <div id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Title<span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" name="title[]" value="<?= $secData['page_title'] ?>" id="attribute_value" required="required" class="form-control col-md-7 col-xs-12" placeholder="Title">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Description<span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                                <div class="compose-body">
                                                                    <textarea name="editor[]"  id="editor<?php echo $i++; ?>" rows="10" cols="80">
                                                                        <?= $secData['page_content'] ?>
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if($secData['page_title']=='Logo')
                                                        {
                                                        ?>
                                                        <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Logo<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                   <?=$secData['logo']?>
                                                                    <input type="file" name="logo" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?=$secData['page_content']?>">
                                                                    <input type="hidden" name="logo_edit" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?=$secData['logo']?>">
                         
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if($secData['page_title']=='our_img1')
                                                        {
                                                        ?>
                                                        <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">slide-img1<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                   
                                                                    <input type="file" name="our_img_1" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="">
                                                                    <input type="hidden" name="our_img1" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?php echo $secData['our_slider_img']?>">
                                                                    <img class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() ?><?php echo $secData['our_slider_img']?>">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                          <?php
                                                        if($secData['page_title']=='our_img2')
                                                        {
                                                        ?>
                                                        <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">slide-img2<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                   
                                                                    <input type="file" name="our_img_2" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="">
                                                                    <input type="hidden" name="our_img2" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?php echo $secData['our_slider_img2']?>">
                                                                    <img class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() ?><?php echo $secData['our_slider_img2']?>">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                          <?php
                                                        if($secData['page_title']=='our_img3')
                                                        {
                                                        ?>
                                                        <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">slide-img3<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                   
                                                                    <input type="file" name="our_img_3" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="">
                                                                    <input type="hidden" name="our_img3" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?php echo $secData['our_slider_img3']?>">
                                                                    <img class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() ?><?php echo $secData['our_slider_img3']?>">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                          <?php
                                                        if($secData['page_title']=='our_img4')
                                                        {
                                                        ?>
                                                        <div class="form-group">
                                                                <label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">slide-img4<span class="required">*</span>
                                                                </label>
                                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                                   
                                                                    <input type="file" name="our_img_4" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="">
                                                                    <input type="hidden" name="our_img4" id="attribute_value"  class="form-control col-md-7 col-xs-12" placeholder="Link" value="<?php echo $secData['our_slider_img4']?>">
                                                                    <img class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() ?><?php echo $secData['our_slider_img4']?>">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <div class="ln_solid"></div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button">Reset</button>
                                    <button type="submit" name="userSubmit" class="btn btn-success">Update</button>
                                    <!--                                    <button id="btn_cancel_vw" type="button" class="btn btn-success">Cancel</button>-->
                                </div>
                            </div>
                    </form>
                    <!-- end of accordion -->


                </div>
            </div>
        </div>
    </div>     
</div>

<script type="text/javascript" >
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
//    CKEDITOR.disableAutoInline = true;

</script>
<?php //$this->load->view('modal/modal_edit_pa');   ?>

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

        $("#id_add_more_image").click(function () {
            $('#div_multiple_img').append('<div class="form-group"><input class="form-control" type="file" name="product_images[]"></div><div class="form-group"><input class="form-control" type="file" name="product_images1[]"></div>');
            $('#div_multiple_img_remove').append('<div></div><div class="col-md-1"><i class="fa fa-trash text-danger"></i></div>');
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

//    initSample();
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
//    CKEDITOR.replace('editor1');
//    CKEDITOR.replace('editor2');
//    CKEDITOR.replace('editor3');
//    CKEDITOR.replace('editor4');
//    CKEDITOR.replace('editor5');
//    CKEDITOR.replace('editor6');
//    CKEDITOR.replace('editor7');
//    CKEDITOR.replace('editor8');
//    
//    CKEDITOR.editorConfig = function( config ) {
//	config.language = 'es';
//	config.uiColor = '#F7B42C';
//	config.height = 300;
//	config.toolbarCanCollapse = true;
//};

</script>



