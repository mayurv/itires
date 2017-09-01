<!-- Search filter Modal -->

<?php $isWheelId = ''; ?>
<?php foreach ($prodcut_cat_detail as $data) { ?>
    <?php
    if ($data['is_wheel'] == 1) {
        $isWheelId = $data['id'];
    }
    ?>
<?php } ?>
<div class="modal fade" id="searchFilterModalVehicleView" tabindex="-1" role="dialog" aria-labelledby="searchFilterModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="modal_id" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="searchFilterModalLabel">Search Filter</h4>
            </div>
            <div class="modal-body">
                <div class="kopa-tab-1">
                    <ul class="nav nav-tabs">
                        <li id="id_modal_vehicle" class="active"><a href="#modalVehicleTab" data-toggle="tab">Shop by Vehicle</a></li>
                        <!--<li id="id_modal_size"><a  href="#modalSizeTab" data-toggle="tab">Shop by SIZE</a></li>-->

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="modalVehicleTab">
                            <?php
                            echo form_open_multipart('home/productFilter/view_on_vehicle', array('id' => 'form_filter_product', 'style' => 'display: block !important;', 'data-parsley-validate'));
                            ?>
                            <?php
                            $recentVehicle = $this->session->userdata('recent_product');
                            $required = "'required'=>'required'";
                            $disabled = "'disabled'=>'disabled'";
                            ?>
                            <?php if (isset($recentVehicle)) { ?>
                                <input hidden id="flag" value="0">
                                <div class="row">
                                    <div  class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group selectWrap">

                                            <select class="form-control" id="recent_vehicle" required="">
                                                <option value="">Select a Recent Vehicle</option>
                                                <option selected="">
                                                <option selected="">
                                                    <?php echo $product_make[$recentVehicle['product_make']]; ?> |
                                                    <?php echo $this->mst_model->get_model_name($recentVehicle['product_model']); ?> |
                                                    <?php echo $this->mst_year->get_year_name($recentVehicle['product_year']); ?>
                                                </option>
                                                </option>
                                            </select>
                                            <input hidden value="<?php echo $recentVehicle['product_make']; ?>" name="product_make_recent">
                                            <input hidden  value="<?php echo $recentVehicle['product_model']; ?>" name="product_model">
                                            <input hidden value="<?php echo $recentVehicle['product_year']; ?>" name="product_year">
                                            <input hidden value="<?php echo $recentVehicle['product_category']; ?>" name="product_category">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="text-center">OR</div>
                                    </div>
                                </div>
                                <?php
                                $required = "";
                                $disabled = "";
                            } else {
                                ?>
                                <input hidden="" id="flag" value="1">
                            <?php } ?>

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group selectWrap">
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'product_make_vehicle',
                                            'name' => 'product_make',
                                            'class' => 'form-control',
                                            $required,
                                            'placeholder' => 'Select Category'
                                                ), $product_make
                                        );
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group selectWrap">
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'product_year_vehicle',
                                            'name' => 'product_year',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select Category',
                                            $disabled
                                                ), $product_year
                                        );
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group selectWrap">
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'product_model_vehicle',
                                            'name' => 'product_model',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select Category',
                                            $disabled,
                                                ), $product_model
                                        );
                                        ?>
                                    </div>
                                </div>
                                <div hidden class="col-xs-6 col-sm-6 col-md-6">
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
                                <!--                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>To View Shipping and Installer Options:</label>
                                                                        <input type="text" class="form-control" placeholder="Zip/Postal Code(Optional)">
                                                                    </div>
                                                                </div>-->
                                <div class="col-md-12">
                                    <label>I'm Shopping For:</label>
                                    <div class="form-group selectWrap">
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'product_category_filter_vehicle',
                                            'name' => 'product_category',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Select Category',
                                            'readonly' => 'readonly',
                                                ), $product_filter_category, set_value('product_category', $isWheelId)
                                        );
                                        ?>
                                        <!--<input hidden id="product_category" name="product_category" value="<?php // $product_filter_category[$isWheelId] ?>">-->
                                        <input hidden id="product_sub_category" name="product_sub_category" value="">
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">

                                    <button type="submit" class="kopaBtn">View Results</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="tab-pane fade" id="modalBrandTab">
                            <span id="loading-id" hidden=""><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>   Please Wait..</span> 
                            <form role="form">
                                <label id="brand_label"></label>

                                <div id="id_view_brand">

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<script src="<?php // echo base_url('assets/js/jquery-1.11.1.min.js');         ?>" type="text/javascript"></script>--> 
<script>

    $(document).ready(function () {
        $("#product_make_vehicle").prop("selectedIndex", 0);
        $("#product_model_vehicle").prop("selectedIndex", 0);
        $("#product_year_vehicle").prop("selectedIndex", 0);
        if ($('#flag').val() == 0) {
            $('select[id="product_model_vehicle"]').prop("disabled", true);
            $('select[id="product_year_vehicle"]').prop("disabled", true);
        } else {
            $('select[id="product_make_vehicle"]').prop("required", true);
            $('select[id="product_model_vehicle"]').prop("disabled", true);
            $('select[id="product_year_vehicle"]').prop("disabled", true);
        }
//
//        $("#reset_dropdown").click(function () {
//            $("#product_make").prop("selectedIndex", 0);
//            $("#product_model").prop("selectedIndex", 0);
//            $("#product_year").prop("selectedIndex", 0);
//        });


        $("#recent_vehicle_vehicle").change(function () {
            $("#product_make_vehicle").prop("selectedIndex", 0);
            $('select[id="product_model_vehicle"]').prop("disabled", true);
            $('select[id="product_year_vehicle"]').prop("disabled", true);
            $("#product_model_vehicle").prop("selectedIndex", 0);
            $("#product_year_vehicle").prop("selectedIndex", 0);
        });
        $("#product_make_vehicle").change(function () {
//            return false;
            $('select[id="recent_vehicle_vehicle"]').prop("required", false);
            $("#recent_vehicle_vehicle").prop("selectedIndex", 0);
            $('select[name="product_model_vehicle"]').prop("disabled", true);
            $("#product_model_vehicle").prop("selectedIndex", 0)

            var product_make_id = $("select#product_make_vehicle option:selected").val();
//            alert(product_make_id);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/make',
                data: {'product_make_id': product_make_id},
                success: function (data) {
//                    alert(data);
                    var parsed = $.parseJSON(data);
                    $('select[id="product_year_vehicle"]').prop("disabled", false);
                    $('select[id="product_year_vehicle"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });
        //On make change change year
        $("#product_year_vehicle").change(function () {
//            return false;
            var product_make_id = $("select#product_make_vehicle option:selected").val();
            var product_year_id = $("select#product_year_vehicle option:selected").val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>admin/dpFilter/year',
                data: {'product_year_id': product_year_id, 'product_make_id': product_make_id},
                success: function (data) {
                    var parsed = $.parseJSON(data);
                    $('select[id="product_model_vehicle"]').prop("disabled", false);
                    $('select[id="product_model_vehicle"]').html(parsed.content).trigger('liszt:updated').val();
                }
            });
        });

        $("#modal_id").click(function () {
            $('.shopSearchFilter').show();
        });


    });

</script>
<script>
    function checkValidation() {
        alert('hello');
    }
</script>
