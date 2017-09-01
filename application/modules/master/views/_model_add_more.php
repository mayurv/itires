
<div class="remove_id_<?php echo $modal_id; ?>">
    <hr>
    <div class="control-group" >

        <div class="col-md-2 col-sm-3 col-xs-3">
            <label class="" for="make_name">Model <span class="required">*</span></label>
            <input id="" name="model[]" type="text" class="tags form-control" value="" required=""/>
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
                'id' => 'model_image_add_' . $modal_id,
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
        <div   class="t col-md-1 col-sm-2 col-xs-2">
            <label class="" for="make_name">Model <span class="required">Image Preview</span></label>
            
            <div  id="thumb_preview" >
                <img  class="img-responsive img-thumbnail " src="<?php echo base_url() ?>images/thumb.jpg" id="img_view_<?php echo $modal_id; ?>">
                <div class="hide_preview_<?php echo $modal_id; ?>" hidden="">
                    <a hidden="" type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target=".id_modal_preview_vehicle_add_<?php echo $modal_id; ?>" id="id_modal_close_<?php echo $modal_id; ?>" >Rim Dimension</a>
                </div>
            </div>
        </div>
        <div  class="col-md-1 col-sm-1 col-xs-3">
            <label class="" for="action"> <span class="required">#</span></label>
            <div class="clearfix"></div>
            <button type="button" class="btn btn-danger" id="btn_remove_<?php echo $modal_id; ?>"><i class="fa fa-trash"></i> </button>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<script>
    $(document).ready(function () {
        //On make change change year
        $("#btn_remove_<?php echo $modal_id; ?>").click(function () {
            var cnt = parseInt($("#model_count").val());
//            $("#model_count").val(cnt - 1);
            $(".remove_id_<?php echo $modal_id; ?>").remove();
            $(".remove_imput_<?php echo $modal_id; ?>").remove();
        });

        $("#model_image_add_<?php echo $modal_id; ?>").on('change', function (e) {

            $(".t").show();
            readURLAdd(this);
            $('#p').hide();

            var temp_image = $('#_<?php echo $modal_id; ?>').val();
            var thumb_preview = '<img class="img-responsive img-thumbnail  " src="' + temp_image + '">';

//                    $("#thumb_preview").html('');
//                    $("#thumb_preview").html(thumb_preview);
        });
        function readURLAdd(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {

                    $('.hide_preview_<?php echo $modal_id; ?>').show();
                    $('#img_view_<?php echo $modal_id; ?>').attr('src', e.target.result);
                    $('#main_car_image_<?php echo $modal_id; ?>').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
<div class="modal fade id_modal_preview_vehicle_add_<?php echo $modal_id; ?>" tabindex="-1" role="dialog" aria-hidden="true" id="id_modal_preview_vehicle_add_<?php echo $modal_id; ?>">
    <div class="modal-dialog" style="width: 80%" >
        <div class="modal-content">


            <form novalidate>
                <div class="modal-body">
                    <div class="clearfix"></div>
                    <!--<div class="text-center col-md-2"></div>-->                                
                    <div id="" class="">



                        <div style="margin-bottom: 20px;border: 1px solid #e6e6e6;border-radius: 2px; position: relative;">

                            <img class="img-center" id="main_car_image_<?php echo $modal_id; ?>" src="" width="100%">


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
                                <input step="0.1" type="number" class="form-control"  name="left_width" id="left_width_<?php echo $modal_id; ?>" placeholder="width in %" max="100" value="13">                                
                            </div>
                            <div class="col-sm-4">
                                Left
                                <input step="0.1" type="number" class="form-control"  name="rim_left"  id="rim_left_<?php echo $modal_id; ?>" placeholder="left in %" max="100" value="23.6">
                            </div>

                            <div class="col-sm-4">
                                Top
                                <input step="0.1" type="number"  name="rim_left_top" id="rim_left_top_<?php echo $modal_id; ?>"  placeholder="top in %" max="100" value="49.9" class="form-control" >                                
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        Right Rim Dimension
                        <div class="row">

                            <div class="col-sm-4">
                                With
                                <input step="0.1" type="number" class="form-control" name="width"  id="rim_right_width_<?php echo $modal_id; ?>"  placeholder="width in %" max="100" value="13">                                
                            </div>

                            <div class="col-sm-4">
                                Right
                                <input step="0.1" type="number" class="form-control" name="right"  id="rim_right_right_<?php echo $modal_id; ?>" placeholder="right in %" max="100" value="20.1">

                            </div>
                            <div class="col-sm-4">
                                Top
                                <input step="0.1" type="number" class="form-control" name="top" id="rim_right_top_<?php echo $modal_id; ?>" placeholder="top in %" max="100" value="47.9">                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="modal-footer">


                    <button type="button" class="btn btn-default btn-sm "  id="id_close_modal_<?php echo $modal_id; ?>">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {


        $("#left_width_<?php echo $modal_id; ?>").on('keyup mouseup', function (e) {
            $('.left-tire-vehicle').css("width", $(this).val() + '%');
            $('#m_left_width_<?php echo $modal_id; ?>').val($(this).val());
        });
        $("#rim_left_<?php echo $modal_id; ?>").on('keyup mouseup', function (e) {
            $('.left-tire-vehicle').css("left", $(this).val() + '%');
            $('#m_rim_left_<?php echo $modal_id; ?>').val($(this).val());

        });
        $("#rim_left_top_<?php echo $modal_id; ?>").on('keyup mouseup', function (e) {
            $('.left-tire-vehicle').css("top", $(this).val() + '%');
            $('#m_rim_left_top_<?php echo $modal_id; ?>').val($(this).val());
        });

        $("#rim_right_width_<?php echo $modal_id; ?>").on('keyup mouseup', function (e) {
            $('.right-tire-vehicle').css("width", $(this).val() + '%');
            $('#m_rim_right_width_<?php echo $modal_id; ?>').val($(this).val());
        });
        $("#rim_right_right_<?php echo $modal_id; ?>").on('keyup mouseup', function (e) {
            $('.right-tire-vehicle').css("right", $(this).val() + '%');
            $('#m_rim_right_right_<?php echo $modal_id; ?>').val($(this).val());
        });
        $("#rim_right_top_<?php echo $modal_id; ?>").on('keyup mouseup', function (e) {
            $('.right-tire-vehicle').css("top", $(this).val() + '%');
            $('#m_rim_right_top_<?php echo $modal_id; ?>').val($(this).val());
        });
        $("#id_close_modal_<?php echo $modal_id; ?>").on('click', function (e) {
            $('#id_modal_preview_vehicle_add_<?php echo $modal_id; ?>').modal('hide');
        });
    });
</script>