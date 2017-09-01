<div class="modal fade id_mdl_add_year" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " style="width:95%">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Add Model</h4>
            </div>
            <form id="id_form_make" method="post" action="<?php echo base_url(); ?>master/model/add" enctype="multipart/form-data"  class="">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="control-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="" for="make_name">Make <span class="required">*</span></label>
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'id_make',
                                    'name' => 'make',
                                    'class' => 'form-control',
                                    'required' => 'required'
                                        ), $make_dropdown
                                );
                                ?>


                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="" for="yaer">year <span class="required">*</span></label>
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'id_year',
                                    'name' => 'year',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'disabled' => 'disabled',
                                        ), $year_dropdown
                                );
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <hr>
                    <br>
                    <div class="form-group model-scroll ">
                        <div class="control-group">

                            <div class="col-md-2 col-sm-3 col-xs-3">
                                <label class="" for="make_name">Model <span class="required">*</span></label>
                                <input required id="" name="model[]" type="text" class="tags form-control" value="" />
                                <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                            </div>
                            
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <label class="" for="make_name">Tire Size <span class="required">*</span></label>
                                <input required id="" name="size[]" type="text" class="tags form-control" value="" />
                                <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                            </div>
                            
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <label class="" for="yaer">Model Image Url <span class="required">*</span></label>
                                <?php
                                echo form_input(array(
                                    'type' => 'file',
                                    'id' => 'model_image_add',
                                    'name' => 'model_image[]',
                                    'placeholder' => 'Upload Images',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'accept' => 'image/*'
                                ));
                                ?>

                            </div>
                            <div class="col-sm-3">
                                <label class="" for="yaer">Model Description <span class="required">*</span></label>
                                <div class="clearfix"></div>
                                <textarea name="description[]" required=""></textarea>
                            </div>
                            <div  class="t col-md-1 col-sm-1 col-xs-1">
                                <label class="" for="make_name">Model <span class="required">Image Preview</span></label>
                                <div  id="thumb_preview" >
                                    <img class="img-responsive img-thumbnail " src="<?php echo base_url() ?>images/thumb.jpg" id="img_view">

                                    <div class="hide_preview" hidden="">
                                        <a type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target=".id_modal_preview_vehicle" id="id_modal_preview_vehicle">Rim Dimension</a>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="add_more_model">

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="control-group">
                            <input hidden="" id="model_count" value="1" name="modal_count">
                            <button type="button" class="btn btn-sm pull-right btn-primary" id="div_add_more_model">Add More</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <input step="0.1" hidden=""  type="number"  name="m_left_width[]" id="m_left_width" placeholder="width in %" max="100" value="13">                                
                    <input step="0.1"  hidden type="number" name="m_rim_left[]"  id="m_rim_left"placeholder="left in %" max="100" value="23.6">
                    <input step="0.1"  hidden type="number"  name="m_rim_left_top[]" id="m_rim_left_top"  placeholder="top in %" max="100" value="47.9">                                
                    <input step="0.1"  hidden type="number" name="m_rim_right_width[]"  id="m_rim_right_width"  placeholder="width in %" max="100" value="13">                                
                    <input step="0.1"  hidden type="number"  name="m_rim_right_right[]"  id="m_rim_right_right" placeholder="right in %" max="100" value="20.1">
                    <input step="0.1" hidden type="number"  name="m_rim_right_top[]" id="m_rim_right_top" placeholder="top in %" max="100" value="47.9">                                
                    <div class="_input">

                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#model_count").val("1");
        //On make change change year
        $("#id_make").change(function () {
//            return false;

            $('select[name="id_year"]').prop("disabled", true);

            $("#product_model").prop("selectedIndex", 0)

            var product_make_id = $("select#id_make option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/make',
                data: {'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[name="year"]').prop("disabled", false);
                    $('select[name="year"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });
        $("#div_add_more_model").click(function () {

            var model_id = $("#model_count").val();

            model_id = (parseInt(model_id) + 1);
            $("#model_count").val(model_id);

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>master/div/' + model_id,
                data: {'model_id': model_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('.add_more_model').append(parsed.content.modal_add_more_div);
                    $('._input').append(parsed.content.modal_input_div);

                }
            });
        });
    });
</script>

<div class="modal fade id_modal_preview_vehicle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">


            <form novalidate>
                <div class="modal-body">
                    <div class="clearfix"></div>
                    <!--<div class="text-center col-md-2"></div>-->                                
                    <div id="" class="">



                        <div style="margin-bottom: 20px;border: 1px solid #e6e6e6;border-radius: 2px; position: relative;">

                            <img class="img-center" id="main_car_image" src="" width="100%">


                            <img src="<?php echo base_url(); ?>parts/rim1.png" class="set-image left-tire-vehicle" style="width:13%;left:23.6%; top: 49.9%;position: absolute">
                            <img src="<?php echo base_url(); ?>parts/rim1.png" class="set-image right-tire-vehicle" style="width:13%;right:20.1%; top: 49.9%;position: absolute">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!--                            <div>
                                                    Select Rim<input type="file" id="preview" >
                                                </div>-->
                    <div class="col-sm-6">
                        Left Rim Dimension
                        <div class="row">

                            <div class="col-sm-4">
                                Width
                                <input step="0.1" type="number" class="form-control"  name="width" id="left_width" placeholder="width in %" max="100" value="13">                                
                            </div>
                            <div class="col-sm-4">
                                Left
                                <input step="0.1" type="number" class="form-control"  name="rim_left"  id="rim_left"placeholder="left in %" max="100" value="23.6">
                            </div>

                            <div class="col-sm-4">
                                Top
                                <input step="0.1" type="number"  name="rim_left_top" id="rim_left_top"  placeholder="top in %" max="100" value="49.9" class="form-control" >                                
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        Right Rim Dimension
                        <div class="row">

                            <div class="col-sm-4">
                                With
                                <input step="0.1" type="number" class="form-control" name="width"  id="rim_right_width"  placeholder="width in %" max="100" value="13">                                
                            </div>

                            <div class="col-sm-4">
                                Right
                                <input step="0.1" type="number" class="form-control" name="right"  id="rim_right_right" placeholder="right in %" max="100" value="20.1">

                            </div>
                            <div class="col-sm-4">
                                Top
                                <input step="0.1" type="number" class="form-control" name="top" id="rim_right_top" placeholder="top in %" max="100" value="47.9">                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        $("#preview").change(function () {

            $('.set-image').show();
            var imgsrc = $(this).attr('src');
            $(".set-image").attr('src', imgsrc);
        });

        $("#left_width").on('keyup mouseup', function (e) {
            $('.left-tire-vehicle').css("width", $(this).val() + '%');
            $('#m_left_width').val($(this).val());
        });
        $("#rim_left").on('keyup mouseup', function (e) {
            $('.left-tire-vehicle').css("left", $(this).val() + '%');
            $('#m_rim_left').val($(this).val());

        });
        $("#rim_left_top").on('keyup mouseup', function (e) {
            $('.left-tire-vehicle').css("top", $(this).val() + '%');
            $('#m_rim_left_top').val($(this).val());
        });

        $("#rim_right_width").on('keyup mouseup', function (e) {
            $('.right-tire-vehicle').css("width", $(this).val() + '%');
            $('#m_rim_right_width').val($(this).val());
        });
        $("#rim_right_right").on('keyup mouseup', function (e) {
            $('.right-tire-vehicle').css("right", $(this).val() + '%');
            $('#m_rim_right_right').val($(this).val());
        });
        $("#rim_right_top").on('keyup mouseup', function (e) {
            $('.right-tire-vehicle').css("top", $(this).val() + '%');
            $('#m_rim_right_top').val($(this).val());
        });
        $("#model_image_add").on('change', function (e) {

            $(".t").show();
            readURLAdd(this);
            $('#p').hide();

            var temp_image = $('#model_image_add').val();
            var thumb_preview = '<img class="img-responsive img-thumbnail " src="' + temp_image + '">';

//                    $("#thumb_preview").html('');
//                    $("#thumb_preview").html(thumb_preview);
        });
        function readURLAdd(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.hide_preview').show();
                    $('#img_view').attr('src', e.target.result);
                    $('#main_car_image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }



    });
</script>

<style>
    .left-tire-vehicle {
        position: absolute;
        top: 47.9%;
        left: 23.6%;
        width: 13%;

    }
    .right-tire-vehicle {
        position: absolute;
        top: 47.9%;
        right: 20.1%;
        width: 13%;
    }
</style>