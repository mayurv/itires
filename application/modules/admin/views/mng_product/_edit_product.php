<!--<pre><?php // print_r($product_details)                                              ?></pre>-->
<?php $ischeck = ''; ?>
<?php $val = ''; ?>
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
                    <h2>Product</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    echo form_open_multipart('admin/manage_product/edit/' . $product_details['id'], array('id' => 'form_add_product', 'class' => 'form-horizontal ', 'data-parsley-validate'));
                    ?>

                    <div class="form-group">
                        <?php echo form_label(lang('product_name'), 'product_name', array('for' => 'product_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">

                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_name',
                                'name' => 'product_name',
                                'placeholder' => 'Product Name',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('product_name', $product_details['product_name'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?php echo form_label(lang('is_feature'), 'is_feature', array('for' => 'is_feature', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="checkbox">
                                <label class="">
                                    <?php // /echo $product_details['product_is_feature'];?>
                                    <?php $product_details['product_is_feature'] == '1' ? $ischeck = "checked" : $ischeck = '' ?>
                                    <?php $product_details['product_is_feature'] == '1' ? $val = "1" : $val = '0' ?>
                                    <div class="icheckbox_flat-green checked" style="position: relative;">
                                        <input name="product_is_feature" type="checkbox" value="<?php echo $val ?>" id="idCheckEditStatus" <?php echo $ischeck; ?>></div> Is Feature
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_category'), 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'product_category',
                                'name' => 'product_category',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category'
                                    ), $product_category, set_value('product_category', $product_details['category_id'])
                            );
                            ?>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <?php echo form_label(lang('is_na'), 'is_na', array('for' => 'is_na', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="checkbox">
                                <label class="">
                                    <div class="icheckbox_flat-green checked" style="position: relative;">
                                        <?php $product_details['is_na'] == '1' ? $is_na = "1" : $is_na = '0' ?>
                                        <?php $product_details['is_na'] == '1' ? $idnacheck = "checked" : $idnacheck = "" ?>
                                        <?php $product_details['is_na'] == '1' ? $isrequired = "" : $isrequired = "required" ?>
                                        <input name="is_applicable" type="checkbox" value="<?php echo $is_na; ?>" <?php echo $idnacheck; ?> id="is_applicable"  ></div> <span class="text-danger">Sub category</span> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="na_category" <?php echo $idnacheck != '' ? 'hidden' : ''; ?>>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-12 col-xs-12"></div>
                            <div class="col-md-2 col-sm-12 col-xs-12"><?php echo form_label(lang('product_make'), 'product_make', array('for' => 'product_make', 'class' => 'control-label ')); ?></div>
                            <div class="col-md-2 col-sm-12 col-xs-12"><?php echo form_label(lang('product_year'), 'product_year', array('for' => 'product_year', 'class' => 'control-label ')); ?></div>
                            <div class="col-md-2 col-sm-12 col-xs-12"><?php echo form_label(lang('product_model'), 'product_model', array('for' => 'product_model', 'class' => 'control-label ')); ?></div>
                        </div>
                        <div class="form-group">

                            <?php echo form_label(lang('product_sub_category'), 'product_sub_category', array('for' => 'product_sub_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_make',
                                    'name' => 'product_make',
                                    'class' => 'form-control',
                                    $isrequired => $isrequired,
                                    'placeholder' => 'Select Category'
                                        ), $product_make, set_value('make_id', $product_details['make_id'])
                                );
                                ?>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_year',
                                    'name' => 'product_year',
                                    'class' => 'form-control',
                                    $isrequired => $isrequired,
                                    'placeholder' => 'Select Category',
                                    'disabled' => 'disabled',
                                        ), $product_year, set_value('year_id', $product_details['year_id'])
                                );
                                ?>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_model',
                                    'name' => 'product_model',
                                    'class' => 'form-control',
                                    $isrequired => $isrequired,
                                    'placeholder' => 'Select Category',
                                    'disabled' => 'disabled',
                                        ), $product_model, set_value('model_id', $product_details['model_id'])
                                );
                                ?>
                            </div>
                        </div>
                    </div>



                    <div class="ln_solid"></div>
                    <div class="clearfix"></div>

                    <div class="div_attribut">
                        <div class="form-group">
                            <?php echo form_label(lang('attributes'), 'attributes', array('for' => 'attributes', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div id="_div_attr_view">

                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                    </div>

                    <div class="clearfix"></div>



                    <div class="form-group">
                        <?php echo form_label(lang('product_quantity'), 'product_quantity', array('for' => 'product_quantity', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'number',
                                'id' => 'product_quantity',
                                'name' => 'product_quantity',
                                'placeholder' => 'Quantity',
                                'class' => 'form-control',
                                'required' => 'required',
                                'min' => '0',
                                'value' => set_value('quantity', $product_details['quantity'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_price'), 'product_price', array('for' => 'product_price', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_price',
                                'name' => 'product_price',
                                'placeholder' => 'Price',
                                'class' => 'form-control',
                                'required' => 'required',
                                'min' => '0',
                                'value' => set_value('price', $product_details['price'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <?php echo form_label(lang('product_discount'), 'product_discount', array('for' => 'product_discount', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Discounted Price</th>
                                        <td><input class="form-control" name="discounted_price" value="<?php echo $product_details['discounted_price'] ?>"></td>                                        
                                    </tr>
                                    <tr>

                                        <th>Offer period</th>
                                        <td>From <input  type="date" name="from_date" class="form-control" value="<?php echo date('Y-m-d', strtotime($product_details['publish_from'])) ?>"> 
                                            T0 <input type="date" class="form-control" name="to_date" value="<?php echo date('Y-m-d', strtotime($product_details['publish_to'])) ?>"></td>                                       
                                    </tr>
                                    <tr>                                        
                                        <th>Publish as Offer</th>
                                        <?php
                                        $checked = '';
                                        $product_details['is_offer_publish'] == 0 ? $checked = '' : $checked = 'checked'
                                        ?>
                                        <td><input type="checkbox" name="is_offer_product" id="is_offer_product" value="<?php echo $product_details['is_offer_publish'] ?>" <?php echo $checked ?>></td>                                         
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_sku'), 'product_sku', array('for' => 'product_sku', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_sku',
                                'name' => 'product_sku',
                                'placeholder' => 'SKU',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('product_sku', $product_details['product_sku'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_shipping_region'), 'product_shipping_region', array('for' => 'product_shipping_region', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'type' => 'text',
                                'id' => 'product_shipping_region',
                                'name' => 'product_shipping_region',
                                'placeholder' => 'Shipping Region',
                                'class' => 'form-control',
                                'required' => 'required',
                                'min' => '0',
                                'value' => set_value('shipping_region', $product_details['shipping_region'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <?php $imgCnt = count($product_details['product_images_details']); ?>
                    <?php if ($imgCnt > 0) { ?>
                        <?php for ($i = 0; $i < $imgCnt; $i++) { ?>
                            <div class="form-group">
                                <?php echo form_label(lang(''), '', array('for' => 'product_images', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!--<input name="" value="<?php echo $product_details['product_images_details'][$i]['id']; ?>">-->
                                    <div id="imgDiv_<?php echo $product_details['product_images_details'][$i]['id']; ?>">
                                        <a class="btn btn-xs btn-default" id="remove_image" onclick="deleteProductImg(<?php echo $product_details['product_images_details'][$i]['id']; ?>)"><i class="fa fa-remove text-danger "></i></a>
                                        <image class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() . $product_details['product_images_details'][$i]['url']; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <script>
                                function deleteProductImg(imageId)
                                {
                                    $('#imgDiv_' + imageId).remove();
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url(); ?>admin/delete/images',
                                        data: {'imageId': imageId},
                                        success: function (data) {

                                        }
                                    });
                                }




                            </script>
                        <?php } ?>
                    <?php } ?>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_images'), 'product_images', array('for' => 'product_images', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php
                            echo form_input(array(
                                'type' => 'file',
                                'id' => 'product_images',
                                'name' => 'product_images[]',
                                'placeholder' => 'Upload Images',
                                'class' => 'form-control',
//                                'required' => 'required',
                                'accept' => 'image/*',
//                                'value' => set_value('shipping_region', $product_details['product_images_details'][$i]['url'])
                            ));
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12">

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="div_multiple_img"></div>
                            <a id="id_add_more_image" class=""><i class="fa fa-plus-circle"></i> Add  more</a>
                        </div>
                        <div class="col-md-1">
                            <div id="div_multiple_img_remove"></div>

                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_desc'), 'product_desc', array('for' => 'product_desc', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_textarea(array(
                                'id' => 'product_desc',
                                'name' => 'product_desc',
                                'placeholder' => 'Description',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('description', $product_details['description'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_shipping_fees'), 'product_shipping_fees', array('for' => 'product_shipping_fees', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'product_shipping_fees',
                                'name' => 'product_shipping_fees',
                                'placeholder' => 'Shipping Fees',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('sheeping_fees', $product_details['sheeping_fees'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_warr'), 'product_warr', array('for' => 'product_shipping_fees', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_input(array(
                                'id' => 'product_warr',
                                'name' => 'product_warr',
                                'placeholder' => 'Product Warranty',
                                'class' => 'form-control',
                                'required' => 'required',
                                'value' => set_value('warrenty', $product_details['warrenty'])
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo form_label(lang('product_status'), 'product_status', array('for' => 'product_status', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            echo form_dropdown(array('id' => 'isactive', 'name' => 'isactive'), $isactive, set_value('isactive', $product_details['isactive']), array('class' => 'form-control'));
                            ?>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-success ">Submit</button>
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <a href="<?php echo base_url(); ?>admin/product" class="btn btn-primary">Cancel</a>
                        </div>
                    </div>



                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
    $(document).ready(function () {
//            return false;
        var product_category_id = $("select#product_category option:selected").val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/get_attributes/edit',
            data: {'product_category_id': product_category_id, 'product_id':<?php echo $product_details['id'] ?>},
            success: function (data) {
                var parsed = $.parseJSON(data);
                $('#_div_attr_view').html('')
                $('#_div_attr_view').html(parsed.content)
//                    $('select[name="product_category"]').prop("disabled", false);
//                    $('select[name="product_category"]').html(data.content).trigger('liszt:updated').val(product_category);
//                    $("#product_category").val($("#product_category option:first").val());
            }
        });

        $("#idCheckEditStatus").change(function () {

            var checkStatus = $("#idCheckEditStatus").val();
            if ($('input#idCheckEditStatus').is(':checked')) {
                $("#idCheckEditStatus").val('1');
            } else {

                $("#idCheckEditStatus").val('0');
            }

        });

        $("#product_make").change(function () {
//            return false;

            $('select[name="product_model"]').prop("disabled", true);
            $("#product_model").prop("selectedIndex", 0)

            var product_make_id = $("select#product_make option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/make',
                data: {'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[name="product_year"]').prop("disabled", false);
                    $('select[name="product_year"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });

        //On make change change year
        $("#product_year").change(function () {
//            return false;
            var product_make_id = $("select#product_make option:selected").val();
            var product_year_id = $("select#product_year option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/year',
                data: {'product_year_id': product_year_id, 'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[name="product_model"]').prop("disabled", false);
                    $('select[name="product_model"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });

        $("#id_add_more_image").click(function () {
            $('#div_multiple_img').append('<div class="form-group"><input class="form-control" type="file" name="product_images[]"></div>');
            $('#div_multiple_img_remove').append('<div></div><div class="col-md-1"><i class="fa fa-trash text-danger"></i></div>');
        });
        $("#is_offer_product").click(function () {
            if ($("#is_offer_product").is(":checked"))
                $("#is_offer_product").val("1");
            else
                $("#is_offer_product").val("0");
        });
        $("#is_applicable").click(function () {
            $('.na_category').toggle();
            if ($("#is_applicable").is(":checked")) {
                $('#product_make').removeAttr('required');
                $('#product_year').removeAttr('required');
                $('#product_model').removeAttr('required');
                $("#is_applicable").val("1");
            } else {
                $('#product_make').attr('required', true);
                $('#product_year').attr('required', true);
                $('#product_model').attr('required', true);
                $("#is_applicable").val("0");
            }
        });

    });

</script>