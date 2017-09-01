<?php
echo form_open_multipart('home/productFilter/', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate'));
?>
<?php
$recentVehicle = $this->session->userdata('recent_product');
$required = "'required'=>'required'";
$disabled = "'disabled'=>'disabled'";
?>
<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#shopByVehicleTab" data-toggle="tab">Shop by Vehicle</a></li>
            <li><a href="#shopBySizeTab" data-toggle="tab">Shop by Size</a></li>
            <li><a href="#shopByBrandTab" data-toggle="tab">Shop by Brand</a></li>


        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="shopByVehicleTab">
                <form role="form">
                    <?php if (isset($recentVehicle)) { ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group selectWrap">
                                    <select class="form-control" id="recent_vehicle" required="">
                                        <option value="">Select a Recent Vehicle</option>
                                        <option selected="">
                                            <?php echo $product_make[$recentVehicle['product_make']]; ?> |
                                            <?php echo $this->mst_model->get_model_name($recentVehicle['product_model']); ?> |
                                            <?php echo $this->mst_year->get_year_name($recentVehicle['product_year']); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="text-center text-danger">OR</div>
                        </div>

                        <input hidden value="<?php echo $recentVehicle['product_make']; ?>" name="product_make_recent">
                        <input hidden value="<?php echo $recentVehicle['product_model']; ?>" name="product_model">
                        <input hidden value="<?php echo $recentVehicle['product_year']; ?>" name="product_year">
                        <input hidden value="<?php echo $recentVehicle['product_category']; ?>" name="product_category">

                        <?php
                        $required = "";
                        $disabled = "";
                        ?>
                    <?php } else {
                        ?>
                        <input hidden="" id="flag" value="1">
                    <?php } ?>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group selectWrap">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_make_f',
                                    'name' => 'product_make',
                                    'class' => 'form-control',
                                    $required,
                                    'placeholder' => 'Select Make'
                                        ), $product_make
                                );
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group selectWrap">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_year_f',
                                    'name' => 'product_year',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select Year',
                                    $disabled
                                        ), $product_year
                                );
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group selectWrap">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_model_f',
                                    'name' => 'product_model',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select Model',
                                    $disabled,
                                        ), $product_model
                                );
                                ?>
                            </div>
                        </div>
                        <div hidden class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group selectWrap">
                                <select class="form-control">
                                    <option>RECENT SELECTED</option>

                                    <option>Lorem Ipsum</option>

                                    <option>Lorem Ipsum</option>

                                    <option>Lorem Ipsum</option>
                                    <option>Lorem Ipsum</option>
                                    <option>Lorem Ipsum</option>


                                </select>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">

                        <!--                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label>To View Shipping and Installer Options:</label>
                                                        <input type="text" class="form-control" placeholder="Zip/Postal Code(Optional)">
                                                    </div>
                                                </div>-->

                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <label>I'm Shopping For:</label>
                            <div class="form-group selectWrap">
                                <?php
                                echo form_dropdown(array(
                                    'id' => 'product_category_f',
                                    'name' => 'product_category',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Select Category'
                                        ), $product_filter_category
                                );
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <label>&nbsp;</label>
                            <button class="search_result">View Results</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="shopBySizeTab">
                <?php
                echo form_open_multipart('home/productFilter/bysize', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate'));
                ?>
                
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group selectWrap">
                                <?php
                                echo form_dropdown(array('id' => 'size1', 'name' => 'size1', 'class' => 'form-control'), $size1);
                                ?> 
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group selectWrap">
                                <?php
                                echo form_dropdown(array('id' => 'size2', 'name' => 'size2', 'class' => 'form-control'), $size2);
                                ?> 
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group selectWrap">
                                <?php
                                echo form_dropdown(array('id' => 'size3', 'name' => 'size3', 'class' => 'form-control'), $size3);
                                ?>                                
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="row">
                                            <div class="col-md-12">
                                                <a class="addRearTireCollapse collapsed" role="button" data-toggle="collapse" href="#addRearTireCollapse" aria-expanded="false" aria-controls="addRearTireCollapse">
                                                    Add a Different Rear Tire Size
                                                    <i class="fa fa-plus-square-o"></i>
                                                    <i class="fa fa-minus-square-o"></i>
                                                </a>
                                                <div class="collapse" id="addRearTireCollapse">
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-3">
                                                            <div class="form-group selectWrap">
                                                                <select class="form-control">
                                                                    <option>225 <span class="caret"></span></option>
                                                                    <option>105</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-3">
                                                            <div class="form-group selectWrap">
                                                                <select class="form-control">
                                                                    <option>45</option>
                                                                    <option>None</option>
                                                                    <option>20</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-3">
                                                            <div class="form-group selectWrap">
                                                                <select class="form-control">
                                                                    <option>17</option>
                                                                    <option>10</option>
                                                                    <option>12</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                    <hr>
                    <div class="row">
                        <!--                        <div class="col-xs-6 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label>To View Shipping and Installer Options:</label>
                                                        <input type="text" class="form-control" placeholder="Zip/Postal Code(Optional)">
                                                    </div>
                                                </div>-->
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <label></label>
                            <button class="search_result">View Results</button>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
            <div class="tab-pane fade" id="shopByBrandTab">
                <form role="form">

                    <div class="col-xs-6 col-sm-6 col-md-3">
                        <label>Select Brand Category</label>
                        <div class="form-group selectWrap">
                            <?php
                            echo form_dropdown(array(
                                'id' => 'brand_category',
                                'name' => 'brand_category',
                                'class' => 'form-control',
                                'required' => 'required',
                                'placeholder' => 'Select Category',
                                    ), $brand_category
                            );
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-9" class="">
                        <span id="loading-id-filter" hidden=""><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>   Please Wait..</span> 
                        <div id="id_view_brand_filter" >

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<!--<script src="<?php // echo base_url('assets/js/jquery-1.11.1.min.js');     ?>" type="text/javascript"></script>--> 
<script>
    $(document).ready(function () {

        $("#product_make_f").prop("selectedIndex", 0);
        $("#product_model_f").prop("selectedIndex", 0);
        $("#product_year_f").prop("selectedIndex", 0);
        if ($('#flag').val() == 0) {
            $('select[id="product_model_f"]').prop("disabled", true);
            $('select[id="product_year_f"]').prop("disabled", true);
        } else {
            $('select[id="product_make_f"]').prop("required", true);
            $('select[id="product_model_f"]').prop("disabled", true);
            $('select[id="product_year_f"]').prop("disabled", true);
        }
//
//        $("#reset_dropdown").click(function () {
//            $("#product_make").prop("selectedIndex", 0);
//            $("#product_model").prop("selectedIndex", 0);
//            $("#product_year").prop("selectedIndex", 0);
//        });


        $("#recent_vehicle").change(function () {
            $("#product_make").prop("selectedIndex", 0);
            $('s elect[id="product_model_f"]').prop("disabled", true);
            $('select[id="product_year_f"]').prop("disabled", true);
            $("#product_model_f").prop("selectedIndex", 0);
            $("#product_year_f").prop("selectedIndex", 0);
        });
        $("#product_make_f").change(function () {
//            return false;
            $('select[id="recent_vehicle"]').prop("required", false);
            $("#recent_vehicle").prop("selectedIndex", 0);
            $('select[id="product_model_f"]').prop("disabled", true);
            $("#product_model_f").prop("selectedIndex", 0)

            var product_make_id = $("select#product_make_f option:selected").val();
//            alert(product_make_id);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/make',
                data: {'product_make_id': product_make_id},
                success: function (data) {
//                    alert(data);
                    var parsed = $.parseJSON(data);
                    $('select[id="product_year_f"]').prop("disabled", false);
                    $('select[id="product_year_f"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });
        //On make change change year
        $("#product_year_f").change(function () {
//            return false;
            var product_make_id = $("select#product_make_f option:selected").val();
            var product_year_id = $("select#product_year_f option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/year',
                data: {'product_year_id': product_year_id, 'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[id="product_model_f"]').prop("disabled", false);
                    $('select[id="product_model_f"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });

        /*Seach By brand Fucntionality*/
        $("#brand_category").change(function () {

//            var id = $('#brand_category').val();
            var subid = $('#brand_category').val();
            $('#brand_label').html('');
            $('#id_view_brand_filter').html('');

            var brand_by = $('#brand_by').val();
            $('#loading-id-filter').show();
//                                                    alert(brand_by);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>home/getBrands',
                data: {'sub_attribute_id': subid},
                success: function (data) {
                    if (data) {
                        var parsed = $.parseJSON(data);
                        $('#loading-id-filter').hide();
//                        $('#tireDiv').show(); alert();
                        $('#brand_label').html(brand_by + ' Brands');
                        $('#id_view_brand_filter').append(parsed.content);

                    }
                }
            });
        });


    });

</script>