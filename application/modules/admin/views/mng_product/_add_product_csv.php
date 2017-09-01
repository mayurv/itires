<?php // echo '<pre>', print_r($prodcut_cat_detail);die;                                                         ?>
<?php // echo '<pre>', print_r($prodcut_cat_detail);die;                                                         ?>
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
                    <h2>Products</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?php echo site_url(); ?>admin/product/addcsv" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
                        <div class="form-group">
                            <?php echo form_label(lang('product_category'), 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_csv_category',
                                    'name' => 'product_csv_category',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select Category'
                                        ), $product_csv_category
                                );
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <br>
                        <div class="form-group">
                            <?php echo form_label(lang('product_csv'), 'product_csv', array('for' => 'product_csv', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <table>
                                    <tr>


                                    </tr>
                                    <tr>

                                        <td>
                                            <input type="file" class="form-control" name="userfile" id="userfile"  align="center" required=""eq />
                                            <p class="text-danger"><?php echo $this->session->flashdata('msg'); ?></p>
                                        </td>
                                        <td>
                                            <div class="col-lg-offset-3 col-lg-9">
                                                <button type="submit" name="submit" class="btn btn-info">Upload CSV File</button>
                                            </div>
                                        </td>
                                    </tr>

                                </table> 

                            </div>
                            <div class="clearfix"></div>

                        </div>
                    </form>
                    <div id="_div_attr_view">

                    </div>

                    <div class="clearfix"></div>
                    <?php if (($excel_row_data) && !empty($excel_row_data)) { ?>
                        <div>
                            <div class="ln_solid"></div> 
                            <form action="<?php echo site_url(); ?>admin/manage_product/addcsvdata" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
                                <!--                                <div class="form-group">
                                <?php echo form_label(lang('product_category'), 'product_category', array('for' => 'product_category', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
//                                        echo form_dropdown(array(
//                                            'id' => 'product_category',
//                                            'name' => 'product_category',
//                                            'class' => 'form-control',
//                                            'required' => 'required',
//                                            'placeholder' => 'Select Category'
//                                                ), $product_category
//                                        );
                                ?>
                                                                    </div>
                                                                </div>-->


                                <div class="clearfix"></div>



                                <!--<div class="ln_solid"></div>-->
                                <div class="clearfix"></div>
                                <div class="ln_solid"></div>

                                <?php echo form_label(lang('csv_data'), 'csv_data', array('for' => 'csv_data', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                <button type="submit" class=" pull-right btn btn-success ">Import (<?php echo count($excel_row_data)?>) Products</button>
                                <div class="col-sm-12">


                                    <div class="table-responsive">
                                        <table class="table" id=""><!-- product_datatable_csv -->
                                            <thead>
                                                <tr>
                                                    <?php
//                                                    $i = 1;
                                                    foreach ($excel_row as $rowtitle) {
                                                        ?>
                                                        <?php // if (isset($attr_data['sub_attribute_details']))  ?>
                                                        <?php foreach ($rowtitle as $t) { ?>
                                                            <th >
                                                                <?php echo $t ?>
                                                            </th>
                                                            <?php
//                                                            $i++;
                                                        }
                                                        ?>
                                                    <?php } ?>
    <!--<th>Description</th>-->
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php if (!empty($excel_row_data)) { ?>
                                                    <?php foreach ($excel_row_data as $rowData) { ?>

                                                        <tr>
                                                            <td >
                                                                <input hidden="" value="<?php echo count($excel_row_data) ?>" name="csv_data_count">
                                                                <input  hidden value="<?php echo $product_categoty_id ?>" name="product_categoty_id">
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_sku',
                                                                    'name' => 'product_sku[]',
                                                                    'placeholder' => 'SKU',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('A', $rowData['A'])
                                                                ));
                                                                ?>
                                                            </td>
                                                            <td >
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_name',
                                                                    'name' => 'product_name[]',
                                                                    'placeholder' => 'Product Name',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('B', isset($rowData['B'])?$rowData['B']:'no title')
                                                                ));
                                                                ?>
                                                                <textarea hidden name="product_description[]"><?php echo isset($rowData['B'])?$rowData['B']:'no title'; ?></textarea>
                                                            </td>
                                                            <td >
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_price',
                                                                    'name' => 'product_price[]',
                                                                    'placeholder' => 'Price',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('C', $rowData['C'])
                                                                ));
                                                                ?>
                                                            </td>

                                                            <?php // if ($product_categoty_id == 1) { ?>
                                                                                                                                                                                                                                                            <!--                                                                <td width="%">
                                                                                                                                                                                                                                                                                                                                <input class="form-control" value="<?php echo $rowData['C'] ?>">
                                                                                                                                                                                                                                                                                                                            </td>-->
                                                            <?php // } ?>


                                                            <td>
                                                                <?php
                                                                echo form_input(array(
                                                                    'type' => 'text',
                                                                    'id' => 'product_quantity',
                                                                    'name' => 'product_quantity[]',
                                                                    'placeholder' => 'Quantity',
                                                                    'class' => 'form-control',
                                                                    'required' => 'required',
                                                                    'value' => set_value('D', $rowData['D'])
                                                                ));
                                                                ?>
                                                            </td>




                                                            <?php
                                                            $flag = '0';
                                                            $options = '';
                                                            ?>
                                                            <?php
//                                                    echo '<pre>', print_r($prodcut_cat_detail);
//                                                    die;
                                                            ?>

                                                            <?php foreach ($prodcut_cat_detail as $attr_data) { ?>
                                                                <?php $i = 'E'; ?>
                                                                <?php if (isset($attr_data['sub_attribute_details']))  ?>
                                                                <?php foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) { ?>


                                                                    <?php // echo '<pre>', print_r($attr_sub_data );?>
                                                                    <?php if ($attr_data['attribute_type'] == 0) { ?>
                                                                        <td width="">
                                                                            <?php
                                                                            echo form_input(array(
                                                                                'type' => 'text',
                                                                                'id' => 'id_tags_' . $attr_sub_data['id'],
                                                                                'name' => 'attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '[]',
                                                                                'placeholder' => $attr_sub_data['sub_name'],
                                                                                //'required' => 'required',
                                                                                'class' => 'tags form-control',
                                                                                'value' => set_value('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'], isset($rowData[$i]) ? $rowData[$i] : '')
                                                                            ));
//                                                                            echo isset($rowData[$i])?$rowData[$i]:'';
                                                                            ?>
                                                                        </td>
                                                                    <?php } else if ($flag == '0') {
                                                                        ?>

                                                                        <td width="">
                                                                            <?php
                                                                            $options = array();
//                                                                            echo '<pre>', print_r($attr_data['sub_attribute_details']);
                                                                            foreach ($attr_data['sub_attribute_details'] as $key => $val)
                                                                                $options[$val['id']] = $val['sub_name'];
                                                                            ?>

                                                                            <?php
                                                                            // 'required' => 'required'
                                                                            echo form_dropdown(array('id' => '', 'name' => 'attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'] . '[]', 'class' => 'form-control'), $options, set_value('id', array_search($rowData['J'], $options)));
                                                                            ?>
                                                                        </td>

                                                                        <?php
                                                                        $flag = '1';
                                                                    }
                                                                    ?>

                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                            <?php } ?>


                                                            <td>
                                                                <?php if (isset($rowData['K']) && $rowData['K'] != '') { ?>
                                                                    <image class="img-responsive img-thumbnail  " src="<?php echo base_url() . $rowData['K'] ?>" style="width:50%"/>
                                                                <?php } else { ?>
                                                                    <image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>media/no-image-box.png" style="width:50%"/>
                                                                <?php } ?>
                                                                    
                                                                <!--<image class="img-responsive img-thumbnail p_img_50 " src="<?php // echo base_url() . $rowData['K'] ?>"/>-->
                                                                <input hidden="" value="<?php echo isset($rowData['K']) ? $rowData['K'] : 'media/no-image-box.png'; ?>" name="image1[]">
                                                                <?php // echo isset($rowData['K']) ? $rowData['K'] : '' ?></td>
                                                            <td>
                                                                <?php if (isset($rowData['L']) && $rowData['L'] != '') { ?>
                                                                    <image class="img-responsive img-thumbnail  " src="<?php echo base_url() . $rowData['L'] ?>" style="width:50%"/>
                                                                <?php } else { ?>
                                                                    <image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>media/no-image-box.png" style="width:50%"/>
                                                                <?php } ?>
                                                                    
                                                                <!--<image class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() . $rowData['L'] ?>"/>-->
                                                                <input hidden value="<?php echo isset($rowData['L']) ? $rowData['L'] : 'media/no-image-box.png' ?>" name="image2[]">
                                                                <?php // echo isset($rowData['L']) ? $rowData['L'] : '' ?>
                                                            </td>
                                                            <td >
                                                                <?php if (isset($rowData['M']) && $rowData['M'] != '') { ?>
                                                                    <image class="img-responsive img-thumbnail  " src="<?php echo base_url() . $rowData['M'] ?>" style="width:50%"/>
                                                                <?php } else { ?>
                                                                    <image class="img-responsive img-thumbnail  " src="<?php echo base_url() ?>media/no-image-box.png" style="width:50%"/>
                                                                <?php } ?>
                                                                
                                                                <!--<image class="img-responsive img-thumbnail p_img_50 " src="<?php echo base_url() . $rowData['M'] ?>"/>-->
                                                                <input hidden value="<?php echo isset($rowData['M']) ? $rowData['M'] : 'media/no-image-box.png' ?>" name="image3[]">
                                                                <?php // echo isset($rowData['M']) ? $rowData['M'] : '' ?>
                                                            </td>
                                                            <!--</td>-->
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-sm-12">
                                    <button type="submit" class=" pull-right btn btn-success ">Import Products</button>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>     
</div>


<script>
    $(document).ready(function () {
        $("#product_csv_category").change(function () {
            //            return false;
            var product_category_id = $("select#product_csv_category option:selected").val();
            var product_category_name = $("select#product_csv_category option:selected").text();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/get_attributes/add_cvs',
                data: {'product_category_id': product_category_id, 'product_category_name': product_category_name},
                success: function (data) {
                    var parsed = $.parseJSON(data);
//                    alert(parsed.content);
//                    $('#_div_attr_view').html('')
//                    $('#_div_attr_view').html(parsed.content)
                    //                    $('select[name="product_category"]').prop("disabled", false);
                    //                    $('select[name="product_category"]').html(data.content).trigger('liszt:updated').val(product_category);
                    //                    $("#product_category").val($("#product_category option:first").val());
                }
            });
        });

        //On make change change year
        $("#idCheckStatus").change(function () {
            var checkStatus = $("#idCheckStatus").val();
            if ($('input#idCheckStatus').is(':checked')) {
                $("#idCheckStatus").val('1');
            } else
                $("#idCheckStatus").val('0');


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
        $("#is_offer_product_a").click(function () {
            if ($("#is_offer_product_a").is(":checked"))
                $("#is_offer_product_a").val("1");
            else
                $("#is_offer_product_a").val("0");
        });

    });

</script>
<script>
    $(document).ready(function () {

        $("#product_datatable_csv").dataTable();
    });
</script>