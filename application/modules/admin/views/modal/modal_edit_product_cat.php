<?php // echo '<pre>', print_r($prodcut_cat_detail);die;                                 ?>
<?php if (!empty($prodcut_cat_detail) && isset($prodcut_cat_detail))  ?>
<?php foreach ($prodcut_cat_detail as $key => $pData) { ?>
    <div class="modal fade id_pc_edit_make_<?php echo $pData['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Edit Product Category</h4>
                </div>
                <?php echo form_open_multipart('admin/product_category/edit/' . $pData['id'], array('id' => 'id_form_product_category', 'class' => 'form-horizontal form-label-left', 'data-parsley-validate')); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <?php echo form_label(lang('is_wheel'), 'is_wheel', array('for' => 'is_wheel', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="checkbox">
                                <label class="">
                                    <?php $pData['is_wheel'] == '1' ? $ischeck = "checked" : $ischeck = '' ?>

                                    <div class="icheckbox_flat-green checked" style="position: relative;">
                                        <input name="product_is_wheel_<?php echo $pData['id'] ?>" type="checkbox" value="0" id="idCheckIsWheel_<?php echo $pData['id'] ?>" <?php echo $ischeck; ?>></div> Is Wheel Category
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_name">Category Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'name' => 'category_name',
                                'placeholder' => 'Category Name',
                                'required' => 'required',
                                'class' => 'form-control',
                                'value' => html_entity_decode(set_value('name', ($pData['name']))),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_description">Category Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea maxlength="200" minlength="10" type="text" id="category_name" name="category_description_<?php echo $pData['id'] ?>" required="required" class="form-control col-md-7 col-xs-12"><?php echo $pData['description'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Img Url <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'file',
                                'id' => 'product_cat_image',
                                'name' => 'product_cat_image',
                                'placeholder' => 'Upload Images',
                                'class' => 'form-control',
                                //'required' => 'required',
                                'accept' => 'image/*'
                            ));
                            ?>

                        </div>
                        <input type="hidden" name="img_url" value="<?php echo $pData['img_url'] ?>">
                        <img class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() ?><?php echo $pData['img_url'] ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Category Attribute <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if (isset($pData['sub_attibutes']) && !empty($pData['sub_attibutes']))  ?>
                            <?php foreach ($pData['sub_attibutes'] as $subAttrData) { ?>
                                <div id="remove_cat_<?php echo $subAttrData['id'] ?>">
                                    <div class="col-sm-11" >
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'parent_id',
                                            'name' => 'parent_id[' . $subAttrData['p_sub_category_id'] . ']',
                                            'class' => 'form-control',
//                                    'required' => 'required',
                                                ), $attt_category, set_value('id', $subAttrData['p_sub_category_id'])
                                        );
                                        ?>
                                        <div class="margin-top-10"></div>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" onclick="funTest(<?php echo $subAttrData['id'] ?>)" id="remove_category_<?php echo $subAttrData['id'] ?>" class="btn btn-xs btn-default"><i class="fa fa-trash text-danger"></i></button>
                                    </div>
                                </div>
                                <script>
                                    function funTest(id) {
                                        $("#remove_cat_" + id).remove();
                                    }

                                </script>
                            <?php } ?>

                        </div>
                        <div class="col-sm-3">
                            <a  target="__blank" href="<?php echo base_url() ?>admin/attirbutes"><i class="fa fa-plus-circle"></i> Add More Category</a>
                        </div> 

                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="id_dv_add_more_attr_ed_<?php echo $pData['id'] ?>">

                            </div>

                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div id="id_remove_btn_ed_<?php echo $pData['id'] ?>">

                            </div>

                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3">
                            <a class="btn btn-default btn-xs" id="id_am_attr_edit_<?php echo $pData['id'] ?>"><i class="fa fa-plus-circle"></i> Add More Attribute</a>
                        </div>
                    </div>



                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $("#id_am_attr_edit_<?php echo $pData['id'] ?>").click(function () {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>admin/ajax_product_category',
                    success: function (data) {
                        var parsed = $.parseJSON(data);
                        $('#id_dv_add_more_attr_ed_<?php echo $pData['id'] ?>').append(parsed.content);
                        $('#id_remove_btn_ed_<?php echo $pData['id'] ?>').append('');
                    }
                });
            });
        });
    </script>
<?php }
?>
<script>
    $(document).ready(function () {
        $("#idCheckIsWheel_<?php echo $pData['id'] ?>").change(function () {
            var checkStatus = $("#idCheckIsWheel_<?php echo $pData['id'] ?>").val();
            if ($('input#idCheckIsWheel_<?php echo $pData['id'] ?>').is(':checked')) {
                $("#idCheckIsWheel_<?php echo $pData['id'] ?>").val('1');
            } else
                $("#idCheckIsWheel_<?php echo $pData['id'] ?>").val('0');


        });
    });
</script>
