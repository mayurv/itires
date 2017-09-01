<div class="modal fade id_mdl_add_prodcut_cat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Add Make</h4>
            </div>

            <form action="<?php echo base_url(); ?>admin/product_category/add" id="id_form_product_category" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <?php echo form_label(lang('is_wheel'), 'is_wheel', array('for' => 'is_wheel', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="checkbox">
                                <label class="">
                                    <?php // $attr_data['is_wheel'] == '1' ? $ischeck = "checked" : $ischeck = '' ?>
                                    <?php // $attr_data['is_wheel'] == '1' ? $val = "1" : $val = '0' ?>
                                    <div class="icheckbox_flat-green checked" style="position: relative;">
                                        <input name="product_is_wheel" type="checkbox" value="0" id="idCheckIsWheel"></div> Is Wheel Category
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_name">Category Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="category_name" name="category_name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_description">Category Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea maxlength="200" minlength="10" type="text" id="category_name" name="category_description" required="required" class="form-control col-md-7 col-xs-12"></textarea>
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
                                'required' => 'required',
                                'accept' => 'image/*'
                            ));
                            ?>

                        </div>


                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Category Attribute <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'parent_id',
                                'name' => 'parent_id[]',
                                'class' => 'form-control',
                                'required' => 'required'
                                    ), $attt_category
                            );
                            ?>

                        </div>
                        <div class="col-sm-3">
                            <a  target="__blank" href="<?php echo base_url() ?>admin/attirbutes"><i class="fa fa-plus-circle"></i> Add More Category</a>
                        </div> 

                    </div>

                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="id_dv_add_more_attr">

                            </div>

                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div id="id_remove_btn">

                            </div>

                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3">
                            <a class="btn btn-default btn-xs" id="id_am_attr"><i class="fa fa-plus-circle"></i> Add More Attribute</a>
                        </div>
                    </div>



                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#idCheckIsWheel").change(function () {
            var checkStatus = $("#idCheckIsWheel").val();
            if ($('input#idCheckIsWheel').is(':checked')) {
                $("#idCheckIsWheel").val('1');
            } else
                $("#idCheckIsWheel").val('0');


        });
    });
</script>