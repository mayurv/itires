<?php
//echo '<pre>', print_r($prodcut_cat_detail);
//die;
?>

<div class="clearfix">

    <div class="header-top clearfix">
        <div class="wrapper clearfix">

            <div class="logo-image">
                <span>
                    <a href="<?php echo base_url() ?>" title="Auto Trader">

                        <?php if (isset($home_section[8]['logo']) && !empty($home_section[8]['logo'])) { ?>
                            <img src="<?php echo base_url(); ?>media/backend/img/logo/<?php echo isset($home_section[8]['logo']) ? $home_section[8]['logo'] : ''; ?>" width="259" height="58" alt="<?php echo isset($home_section[8]['page_title']) ? $home_section[8]['page_title'] : '' ?>">

                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>assets/placeholders/logo.png" width="259" height="58" alt="<?php echo isset($home_section[8]['page_title']) ? $home_section[8]['page_title'] : '' ?>">
                        <?php } ?>
                        <span class="sr-only"><?php echo isset($home_section[8]['page_title']) ? $home_section[8]['page_title'] : '' ?></span>
                    </a>
                </span>
            </div>
            <!-- #logo-image -->

            <div class="login-wrapper">
                <ul>
                    <li><span>Welcome   <b><?php echo $dataHeader['first_name']; ?></b> </span></li>
                    <?php if (!$this->ion_auth->logged_in()) { ?>
                        <!--                    <li><a href="#">Sign in</a></li>-->
                                            <!--<li><span class="sepa">i</span></li>-->
                        <li> | <a href="<?php echo base_url(); ?>auth/login#signup">Register</a></li>
                    <?php } ?>
                </ul>
            </div>                
            <!-- .login-wrapper -->

            <nav class="page-nav">
                <span class="quick-link">Quick links <i class="fa fa-angle-down"></i></span>
                <ul>
                    <?php if ($this->ion_auth->logged_in()) { ?>
                        <li><a href="<?php echo base_url() ?>home/orders">My Account</a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo base_url() ?>auth/login">My Account</a></li>
                    <?php } ?>
                    <!--<li><a href="#">Wishlist</a></li>-->
                    <li><a href="<?php echo base_url(); ?>home/cart">My Cart</a></li>
                    <li><a href="<?php echo base_url(); ?>home/checkout">Checkout</a></li>
                    <?php if (!$this->ion_auth->logged_in()) { ?>
                        <li><a href="<?php echo base_url(); ?>auth/login">Log In</a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo base_url(); ?>auth/logout">Log Out</a></li>
                    <?php } ?>

                </ul>
            </nav>
            <!-- .page-top -->

        </div>
    </div>
    <!-- .header-top -->

    <div class="header-middle clearfix">
        <div class="wrapper clearfix">
            <div class="on-shoping-box row">
                <?php echo $home_section[11]['page_content'] ?>
                <div class="col-md-3">
                    <div class="item shopping-cart fa fa-shopping-cart ">
                        <a href="<?php echo base_url(); ?>home/cart" class="h6">My Cart</a>
                        <p><span id="id_cart_total"><?php echo!empty($cart_summary['total_rows']) ? $cart_summary['total_rows'] : '0' ?></span> 

                            <!--- $<span id="id_total"><?php // echo!empty($cart_summary['total']) ? $cart_summary['total'] : '0'                                                         ?></span>-->

                            <!--- $<span id="id_total"><?php // echo!empty($cart_summary['total']) ? $cart_summary['total'] : '0'                                                             ?></span>-->

                        </p>
                    </div>
                    <!--.shopping-cart-->
                </div>
            </div>
            <!--.on-shoping-box-->
        </div>
    </div>
    <!-- .header-middle -->

</div>

<div class="header-bottom">
    <div class="wrapper clearfix">
        <div class="waypoint">
            <nav id="main-nav" class="clearfix">

                <ul id="main-menu">
                    <li class="current-menu-item">
                        <a href="<?php echo base_url(); ?>"><span>Home</span></a>
                    </li>

                    <?php if (isset($prodcut_cat_detail)) { ?>
                        <?php foreach ($prodcut_cat_detail as $key => $dataAtt) { ?>
                            <li>

                                <a href="<?php echo base_url() ?>home/shop/<?php echo $dataAtt['id'] ?>"><span><?php echo $dataAtt['name']; ?></span></a>
                                <?php if (isset($dataAtt['sub_attibutes'])) { ?>
                                    <div class="sub-main-menu-o sf-mega">
                                        <ul class="sub-menu">
                                            <?php foreach ($dataAtt['sub_attibutes'] as $dataSubAtt) { ?>
                                                <?php if ($dataSubAtt['attribute_type'] != 2) { ?>
                                                    <li>
                                                        <?php if (isset($dataSubAtt['is_brand']) && $dataSubAtt['is_brand'] == 1) { ?>
                                                            <a href="" id="id_filter_term_<?php echo $dataSubAtt['id'] ?>" onclick="seartchFilterByBrand(<?php echo $dataSubAtt['id'] ?>,<?php echo $dataSubAtt['p_sub_category_id'] ?>)"data-toggle="modal" data-target="#searchFilterModal">
                                                                <?php echo $dataSubAtt['attrubute_value']; ?>
                                                            </a>
                                                            <input hidden value="<?php echo $dataSubAtt['id'] ?>">
                                                            <input hidden id="brand_subdp_id_<?php echo $dataSubAtt['id'] ?>" value="<?php echo $dataSubAtt['p_sub_category_id'] ?>">
                                                            <?php // } ?>
                                                        <?php } else if (isset($dataSubAtt['parent_id']) && $dataSubAtt['parent_id'] > 0) { ?>
                                                            <a href="" id="id_filter_term_<?php echo $dataSubAtt['id'] ?>" onclick="seartchFilterByTermH(<?php echo $dataSubAtt['id'] ?>,<?php echo $dataSubAtt['p_sub_category_id'] ?>)"data-toggle="modal" data-target="#searchFilterModal">
                                                                <?php echo $dataSubAtt['attrubute_value']; ?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a href="" id="id_filter_term_<?php echo $dataAtt['id'] ?>" onclick="seartchFilterByTermH(<?php echo $dataAtt['id'] ?>,<?php echo $dataSubAtt['p_sub_category_id'] ?>, 'sub')"data-toggle="modal" data-target="#searchFilterModal">
                                                                <?php echo $dataSubAtt['attrubute_value']; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($dataSubAtt['is_wheel'] == 1) { ?>
                                                <li>
                                                    <a href="" data-toggle="modal" data-target="#searchFilterModalVehicleView">
                                                        View On My Vehicle
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>

                            </li>
                        <?php } ?>
                    <?php } ?>

                    <li><a href="<?php echo base_url() ?>home/blogs" class="<?php echo $this->uri->segment(2) == 'blogs' ? 'current-menu-item' : '' ?>"><span>Blogs</span></a>
                    </li>
                    <li><a href="<?php echo base_url(); ?>home/about_us"><span>About</span></a></li>
                    <li><a href="<?php echo base_url(); ?>home/contact_us"><span>Contact Us</span></a>
                    </li>
                    <li>
                        <a href="#"><span>Other</span></a>
                        <div class="sub-main-menu-o sf-mega">
                            <?php // echo print_r($pages);die();   ?>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url(); ?>home/our_services"><span>Our Service</span></a></li>
                                <?php if (isset($pages)) { ?>
                                    <?php foreach ($pages as $data) { ?>
                                        <li><a href="<?php echo base_url() ?>home/page/<?php echo $data['id'] ?>"><span><?php echo $data['title_menu'] ?></span></a></li>
                                    <?php } ?> 
                                <?php } ?> 
                            </ul>

                        </div>

                    </li>


                </ul>

                <i class='fa fa-align-justify show_mobile_menu'></i>
                <!-- mobile-menu-wrapper -->
                <div class="mobile-menu-wrapper">
                    <ul id="mobile-menu">
                        <li class="current-menu-item">
                            <a href="<?php echo base_url(); ?>"><span>Home</span></a>
                        </li>

                        <?php if (isset($prodcut_cat_detail)) { ?>
                            <?php foreach ($prodcut_cat_detail as $key => $dataAtt) { ?>
                                <li>

                                    <a class="toggle" href="<?php echo base_url() ?>home/shop/<?php echo $dataAtt['id'] ?>"><span><?php echo $dataAtt['name']; ?></span></a>
                                    <?php if (isset($dataAtt['sub_attibutes'])) { ?>

                                        <ul class="inner">
                                            <?php foreach ($dataAtt['sub_attibutes'] as $dataSubAtt) { ?>
                                                <?php if ($dataSubAtt['attribute_type'] != 2) { ?>
                                                    <li>
                                                        <?php if (isset($dataSubAtt['is_brand']) && $dataSubAtt['is_brand'] == 1) { ?>
                                                            <a href="" id="id_filter_term_<?php echo $dataSubAtt['id'] ?>" onclick="seartchFilterByBrand(<?php echo $dataSubAtt['id'] ?>,<?php echo $dataSubAtt['p_sub_category_id'] ?>)"data-toggle="modal" data-target="#searchFilterModal">
                                                                <?php echo $dataSubAtt['attrubute_value']; ?>
                                                            </a>
                                                            <input hidden value="<?php echo $dataSubAtt['id'] ?>">
                                                            <input hidden id="brand_subdp_id_<?php echo $dataSubAtt['id'] ?>" value="<?php echo $dataSubAtt['p_sub_category_id'] ?>">
                                                            <?php // } ?>
                                                        <?php } else if (isset($dataSubAtt['parent_id']) && $dataSubAtt['parent_id'] > 0) { ?>
                                                            <a href="" id="id_filter_term_<?php echo $dataSubAtt['id'] ?>" onclick="seartchFilterByTermH(<?php echo $dataSubAtt['id'] ?>,<?php echo $dataSubAtt['p_sub_category_id'] ?>)"data-toggle="modal" data-target="#searchFilterModal">
                                                                <?php echo $dataSubAtt['attrubute_value']; ?>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a href="" id="id_filter_term_<?php echo $dataAtt['id'] ?>" onclick="seartchFilterByTermH(<?php echo $dataAtt['id'] ?>,<?php echo $dataSubAtt['p_sub_category_id'] ?>, 'sub')"data-toggle="modal" data-target="#searchFilterModal">
                                                                <?php echo $dataSubAtt['attrubute_value']; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($dataSubAtt['is_wheel'] == 1) { ?>
                                                <li>
                                                    <a href="" data-toggle="modal" data-target="#searchFilterModalVehicleView">
                                                        View On My Vehicle
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>

                                    <?php } ?>

                                </li>
                            <?php } ?>
                        <?php } ?>

                        <li><a href="<?php echo base_url() ?>home/blogs" class="<?php echo $this->uri->segment(2) == 'blogs' ? 'current-menu-item' : '' ?>"><span>Blogs</span></a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>home/about_us"><span>About</span></a></li>
                        <li><a href="<?php echo base_url(); ?>home/contact_us"><span>Contact Us</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Other</span></a>
                            <ul class="inner">
                                <li><a href="<?php echo base_url(); ?>home/our_services"><span>Our Service</span></a></li>
                                <?php if (isset($pages)) { ?>
                                    <?php foreach ($pages as $data) { ?>
                                        <li><a href="<?php echo base_url() ?>home/page/<?php echo $data['id'] ?>"><span><?php echo $data['title_menu'] ?></span></a></li>
                                    <?php } ?> 
                                <?php } ?> 
                            </ul>
                        </li>

                    </ul>
                    <!-- mobile-menu -->
                </div>
                <!-- mobile-menu-wrapper -->

            </nav>

            <div class="search-top">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" value="" name="search">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" type="button"><i class="fa fa-search" ></i></button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div>
            <!-- .search-wrapper -->
        </div>
        <!-- .waypoint -->
    </div>
</div>
<!-- .header-bottom -->
<script src="<?php echo base_url() ?>backend/vendors/jquery/dist/jquery.min.js"></script>
<script>

                                        $(document).ready(function () {
                                            $('select[id="product_category_filter"]').change(function () {
                                                $('select[id="billing_state"]').prop("disabled", false);
                                                var country_id = $(this).val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: '<?php echo base_url(); ?>home/getStateList',
                                                    data: {'country_id': country_id},
                                                    success: function (data) {
                                                        if (data) {
                                                            $('select[name="billing_state"]').html(data.content).trigger('liszt:updated').val(country_id);
                                                        }
                                                    }
                                                });
                                            });
                                        });

                                        $(document).ready(function () {
                                            $('select[id="product_category_filter"]').change(function () {
                                                $('select[id="billing_state"]').prop("disabled", false);
                                                var country_id = $(this).val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: '<?php echo base_url(); ?>home/getStateList',
                                                    data: {'country_id': country_id},
                                                    success: function (data) {
                                                        if (data) {
                                                            $('select[name="billing_state"]').html(data.content).trigger('liszt:updated').val(country_id);
                                                        }
                                                    }
                                                });
                                            });
                                        });

</script>
<script>
    //header script
    function seartchFilterByTermH(id, subid = '', sub = '') {

//        $('.shopSearchFilter').hide();

//    $('#form_filter_product').hide();

        //    $('#form_filter_product').hide();
        $('#id_modal_vehicle').addClass("active");
        $('#id_modal_size').removeClass("active");
        $('#modalVehicleTab').addClass("active");
        $('#modalSizeTab').removeClass("active in");
        $('#modalBrandTab').removeClass("active in");
        $('#brand_label').html('');
        $('#id_view_brand').html('');

        $("#product_make").prop("selectedIndex", 0);
        $("#product_model").prop("selectedIndex", 0);
        $("#product_year").prop("selectedIndex", 0);
        $('#product_category_filter').val(id);
        var val = $("#product_category_filter option:selected").text();
        var brand_dp_id = $('#brand_subdp_id_' + id).val();
        $('#brand_dp').val();
        $('#brand_dp').val(brand_dp_id);

//        alert(val);

        //        alert(val);

        if (subid != '' && sub == '') {

            $("#product_category_filter").val(id + '_' + subid);
            $("#product_sub_category").val(subid);
        } else {

//            alert(subid);

            //            alert(subid);

            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>home/getSubDropdwon',
                data: {'sub_attribute_id': subid},
                success: function (data) {
                    if (data) {
                        var parsed = $.parseJSON(data);
//                        $('#tireDiv').show();
                        $('#tire_brand').append(parsed.content);

                        var parsed = $.parseJSON(data);
//                        $('#tireDiv').show();
                        $('#tire_brand').append(parsed.content);

//                        $('select[name="billing_state"]').html(data.content).trigger('liszt:updated').val(country_id);
                    }
                }
            });
            $("#product_sub_category").val('');
        }
        $('#modalVehicleTab').addClass("active in");
        $('#id_modal_vehicle').show();
        $('#id_modal_brand').removeClass("active");
//        $('#id_modal_size').hide();
        if (val == "Tires" || val == "Tire" || val == "tires") {
            $('#id_modal_size').show();
//            $('#id_modal_brand').hide();
        } else
            $('#id_modal_size').hide();
    }

    function seartchFilterByBrand(id, subid = '', sub = '') {
//        $('#id_modal_vehicle').hide();
        $('#id_modal_size').hide();
        $('#id_modal_brand').show();
        $('#id_modal_vehicle').removeClass("active");
        $('#id_modal_brand').addClass("active");
        $('#modalVehicleTab').removeClass("active");
        $('#modalBrandTab').addClass("active in");
        $('#brand_label').html('');
        $('#id_view_brand').html('');

        var brand_by = $('#id_filter_term_' + id).text();
        var brand_dp_id = $('#brand_subdp_id_' + id).val();


        $('#brand_by').val('');
        $('#brand_by').val(brand_by);
        $('#brand_dp').val('');
        $('#brand_dp').val(brand_dp_id);
        $('#brand_id').val('');
        $('#brand_id').val(id);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>home/getBrands',
            data: {'sub_attribute_id': subid},
            success: function (data) {
                if (data) {
                    var parsed = $.parseJSON(data);
                    $('#loading-id').hide();
//                        $('#tireDiv').show();
                    $('#brand_label').html(brand_by + ' Brands');
                    $('#id_view_brand').append(parsed.content);

                }
            }
        });
    }




</script>