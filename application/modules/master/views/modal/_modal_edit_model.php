<?php // echo '<pre>', print_r($model_detail);die;                                                                            ?>
<?php if (isset($model_detail))  ?>
<?php foreach ($model_detail as $mdlData) { ?>
    <div class="modal fade id_md_edit_make_<?php echo $mdlData['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Model</h4>
                </div>
                <form id="id_form_make" method="post" action="<?php echo base_url(); ?>master/model/edit/<?php echo $mdlData['id']; ?>"  enctype="multipart/form-data" class="">
                    <div class="modal-body model-scroll-450">
                        <div class="form-group">
                            <div class="control-group">
                                <div class="col-md-6 col-sm6 col-xs-6">
                                    <label class="" for="make_name">Make <span class="required">*</span></label>
                                    <?php
                                    echo form_dropdown(array(
                                        'id' => 'id_make',
                                        'name' => 'make',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'disabled' => 'disabled'
                                            ), $make_dropdown, set_value('make_id', $mdlData['make_id'])
                                    );
                                    ?>


                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <label class="" for="yaer">year <span class="required">*</span></label>
                                    <?php
                                    echo form_dropdown(array(
                                        'id' => 'id_year',
                                        'name' => 'year',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'disabled' => 'disabled'
                                            ), $year_dropdown, set_value('year_id', $mdlData['year_id'])
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($mdlData['model_detail_size']) && !empty($mdlData['model_detail_size'])) { ?>

                            <div class="form-group">
                                <div class="control-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="" for="model">Tire Size <span class="required">*</span></label>
                                        <div class="clearfix"></div>
                                        <?php foreach ($mdlData['model_detail_size'] as $sizeData) { ?>
                                            <div class="col-sm-6">
                                                <label class="text-danger" value="">                                                    
                                                    <?php echo $sizeData['size']; ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>

                        <?php } else { ?>
                            <br>
                            <div class="col-sm-12">
                                <label class="" for="model">Tire Size <span class="required">*</span></label>
                                <?php
                                echo form_input(array(
                                    'type' => 'text',
                                    'id' => 'model_size',
                                    'name' => 'model_' . $mdlData['id'],
                                    'placeholder' => 'Tire Size Seperated by ;',
                                    'class' => 'form-control',
                                    'value' => '',
                                    'data-error' => '.errorTxtOff3'
                                ));
                                ?>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <div class="control-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="" for="model">Model <span class="required">*</span></label>
                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'id' => 'tags_1',
                                        'name' => 'model',
                                        'placeholder' => 'Model Name',
                                        'class' => 'form-control',
                                        'value' => set_value('name', $mdlData['name']),
                                        'data-error' => '.errorTxtOff3'
                                    ));
                                    ?>
                                    <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="" for="yaer">Model Image Url <span class="required">*</span></label>
                                    <?php //echo $mdlData['modal_img_url']?>
                                    <?php
                                    echo form_input(array(
                                        'type' => 'file',
                                        'id' => 'model_image_' . $mdlData['id'],
                                        'name' => 'model_image',
                                        'placeholder' => 'Upload Images',
                                        'class' => 'form-control',
                                        //'required' => 'required',
                                        'accept' => 'image/*'
                                    ));
                                    ?>
                                    <?php
                                    $hidden = ' ';
                                    if (!empty($mdlData['model_img_url'])) {
                                        ?>
                                        <div id="p_<?php echo $mdlData['id']; ?>">
                                            <input type="hidden" name="model_image_1" value="<?php echo $mdlData['model_img_url'] ?>"> 
                                            <img class="img-responsive img-thumbnail  " src="<?php echo base_url() . $mdlData['model_img_url'] ?>">

                                            <a type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target=".id_modal_preview_vehicle_<?php echo $mdlData['id']; ?>" id="id_modal_preview_vehicle_<?php echo $mdlData['id']; ?>">Rim Dimension</a>
                                        </div>
                                        <?php
                                        $hidden = "hidden";
                                    }
                                    ?>
                                    <div  style="display: none" class="t_<?php echo $mdlData['id']; ?>">
                                        <div  id="thumb_preview" >
                                            <img class="img-responsive img-thumbnail  " src="" id="img_view_<?php echo $mdlData['id']; ?>">
                                            <a type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target=".id_modal_preview_vehicle_<?php echo $mdlData['id']; ?>" id="id_modal_preview_vehicle_<?php echo $mdlData['id']; ?>">Rim Dimension</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="form-group">

                            <div class="control-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label class="" for="status">Status <span class="required">*</span></label>
                                    <?php
                                    echo form_dropdown(array('id' => 'isactive', 'name' => 'isactive'), $isactive, set_value('isactive', $mdlData['isactive']), array('class' => 'form-control'));
                                    ?>
                                    <div id="suggestions-container" style="position: relative; float: left; width: 20px; margin: 10px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <input hidden id="test_<?php echo $mdlData['id']; ?>">

                        <input step="0.1" hidden=""  type="number"  name="m_left_width_<?php echo $mdlData['id']; ?>" id="m_left_width_<?php echo $mdlData['id']; ?>" placeholder="width in %" max="100" value="13">                                
                        <input step="0.1"  hidden type="number" name="m_rim_left_<?php echo $mdlData['id']; ?>"  id="m_rim_left_<?php echo $mdlData['id']; ?>"placeholder="left in %" max="100" value="23.6">
                        <input step="0.1"  hidden type="number"  name="m_rim_left_top_<?php echo $mdlData['id']; ?>" id="m_rim_left_top_<?php echo $mdlData['id']; ?>"  placeholder="top in %" max="100" value="47.9">                                
                        <input step="0.1"  hidden type="number" name="m_rim_right_width_<?php echo $mdlData['id']; ?>"  id="m_rim_right_width_<?php echo $mdlData['id']; ?>"  placeholder="width in %" max="100" value="13">                                
                        <input step="0.1"  hidden type="number"  name="m_rim_right_right_<?php echo $mdlData['id']; ?>"  id="m_rim_right_right_<?php echo $mdlData['id']; ?>" placeholder="right in %" max="100" value="20.1">
                        <input step="0.1" hidden type="number"  name="m_rim_right_top_<?php echo $mdlData['id']; ?>" id="m_rim_right_top_<?php echo $mdlData['id']; ?>" placeholder="top in %" max="100" value="47.9">                                
                        <div class="clearfix"></div>
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
    </div>
<?php }
?>
<?php if (isset($model_detail)) { ?>
    <?php foreach ($model_detail as $mdlData) { ?>
        <div class="modal fade id_modal_preview_vehicle_<?php echo $mdlData['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width: 80%" >
                <div class="modal-content">


                    <form novalidate>
                        <div class="modal-body">
                            <div class="clearfix"></div>
                            <!--<div class="text-center col-md-2"></div>-->                                
                            <div id="" class="">



                                <div style="margin-bottom: 20px;border: 1px solid #e6e6e6;border-radius: 2px; position: relative;">

                                    <img class="img-center" id="main_car_image_<?php echo $mdlData['id']; ?>" src="<?php echo base_url() . $mdlData['model_img_url'] ?>" width="100%">


                                    <img src="<?php echo base_url(); ?>parts/rim1.png" class="set-image left-tire-vehicle" style="width:<?php echo $mdlData['rim_left_w'] ? $mdlData['rim_left_w'] : '13'; ?>%;left:<?php echo $mdlData['rim_left_l'] ? $mdlData['rim_left_l'] : '23.6'; ?>%; top: <?php echo $mdlData['rim_left_t'] ? $mdlData['rim_left_t'] : '49.9'; ?>%;position: absolute">
                                    <img src="<?php echo base_url(); ?>parts/rim1.png" class="set-image right-tire-vehicle" style="width:<?php echo $mdlData['rim_right_w'] ? $mdlData['rim_right_w'] : '13'; ?>%;right:<?php echo $mdlData['rim_right_l'] ? $mdlData['rim_right_l'] : '20.1'; ?>%; top: <?php echo $mdlData['rim_right_t'] ? $mdlData['rim_right_t'] : '49.9'; ?>%;position: absolute">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!--                            <div>
                                                            Select Rim<input type="file" id="preview_<?php echo $mdlData['id']; ?>" >
                                                        </div>-->
                            <div class="col-sm-6">
                                Left Rim Dimension
                                <div class="row">

                                    <div class="col-sm-4">
                                        Width
                                        <input step="0.1" type="number" class="form-control"  name="width" id="left_width_<?php echo $mdlData['id']; ?>" placeholder="width in %" max="100" value="<?php echo $mdlData['rim_left_w'] ? $mdlData['rim_left_w'] : '13'; ?>">                                
                                    </div>
                                    <div class="col-sm-4">
                                        Left
                                        <input step="0.1" type="number" class="form-control"  name="rim_left_<?php echo $mdlData['id']; ?>"  id="rim_left_<?php echo $mdlData['id']; ?>"placeholder="left in %" max="100" value="<?php echo $mdlData['rim_left_l'] ? $mdlData['rim_left_l'] : '23.6'; ?>">
                                    </div>

                                    <div class="col-sm-4">
                                        Top
                                        <input step="0.1" type="number"  name="rim_left_top_<?php echo $mdlData['id']; ?>" id="rim_left_top_<?php echo $mdlData['id']; ?>"  placeholder="top in %" max="100" value="<?php echo $mdlData['rim_left_t'] ? $mdlData['rim_left_t'] : '49.9'; ?>" class="form-control" >                                
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                Right Rim Dimension
                                <div class="row">

                                    <div class="col-sm-4">
                                        With
                                        <input step="0.1" type="number" class="form-control" name="width"  id="rim_right_width_<?php echo $mdlData['id']; ?>"  placeholder="width in %" max="100" value="<?php echo $mdlData['rim_right_w'] ? $mdlData['rim_right_w'] : '13'; ?>">                                
                                    </div>

                                    <div class="col-sm-4">
                                        Right
                                        <input step="0.1" type="number" class="form-control" name="right"  id="rim_right_right_<?php echo $mdlData['id']; ?>" placeholder="right in %" max="100" value="<?php echo $mdlData['rim_right_l'] ? $mdlData['rim_right_l'] : '20.1'; ?>">

                                    </div>
                                    <div class="col-sm-4">
                                        Top
                                        <input step="0.1" type="number" class="form-control" name="top" id="rim_right_top_<?php echo $mdlData['id']; ?>" placeholder="top in %" max="100" value="<?php echo $mdlData['rim_right_t'] ? $mdlData['rim_right_t'] : '47.9'; ?>">                                
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
                $("#preview_<?php echo $mdlData['id']; ?>").change(function () {

                    $('.set-image').show();
                    var imgsrc = $(this).attr('src');
                    $(".set-image").attr('src', imgsrc);
                });

                $("#left_width_<?php echo $mdlData['id']; ?>").on('keyup mouseup', function (e) {
                    $('.left-tire-vehicle').css("width", $(this).val() + '%');
                    $('#m_left_width_<?php echo $mdlData['id']; ?>').val($(this).val());
                });
                $("#rim_left_<?php echo $mdlData['id']; ?>").on('keyup mouseup', function (e) {
                    $('.left-tire-vehicle').css("left", $(this).val() + '%');
                    $('#m_rim_left_<?php echo $mdlData['id']; ?>').val($(this).val());

                });
                $("#rim_left_top_<?php echo $mdlData['id']; ?>").on('keyup mouseup', function (e) {
                    $('.left-tire-vehicle').css("top", $(this).val() + '%');
                    $('#m_rim_left_top_<?php echo $mdlData['id']; ?>').val($(this).val());
                });

                $("#rim_right_width_<?php echo $mdlData['id']; ?>").on('keyup mouseup', function (e) {
                    $('.right-tire-vehicle').css("width", $(this).val() + '%');
                    $('#m_rim_right_width_<?php echo $mdlData['id']; ?>').val($(this).val());
                });
                $("#rim_right_right_<?php echo $mdlData['id']; ?>").on('keyup mouseup', function (e) {
                    $('.right-tire-vehicle').css("right", $(this).val() + '%');
                    $('#m_rim_right_right_<?php echo $mdlData['id']; ?>').val($(this).val());
                });
                $("#rim_right_top_<?php echo $mdlData['id']; ?>").on('keyup mouseup', function (e) {
                    $('.right-tire-vehicle').css("top", $(this).val() + '%');
                    $('#m_rim_right_top_<?php echo $mdlData['id']; ?>').val($(this).val());
                });
                $("#model_image_<?php echo $mdlData['id']; ?>").on('change', function (e) {
                    $(".t_<?php echo $mdlData['id']; ?>").show();
                    readURL(this);
                    $('#p_<?php echo $mdlData['id']; ?>').hide();

                    var temp_image = $('#model_image_<?php echo $mdlData['id']; ?>').val();
                    var thumb_preview = '<img class="img-responsive img-thumbnail  " src="' + temp_image + '">';

                    //                    $("#thumb_preview").html('');
                    //                    $("#thumb_preview").html(thumb_preview);
                });
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#img_view_<?php echo $mdlData['id']; ?>').attr('src', e.target.result);
                            $('#main_car_image_<?php echo $mdlData['id']; ?>').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }



            });
        </script>

    <?php } ?>
<?php } ?>
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
