<?php // echo '<pre>', print_r($this->data['cart_items']);die;      ?>
<style type="text/css">
    .full-width {
        width: 100%;
    }

    .btn-filter {
        margin-left: 20px;
        background: #e5091c;
        color: #fff;
        padding: 9px 10px;
        font-family: "Raleway", sans-serif;
    }

    .bg-light {
        background-color: #f9f8f8;
        padding: 28px 10px;
        border: 1px solid #eceaea;
        margin-top: 30px;
        font-family: "Raleway", sans-serif;
    }

    .social-links a {
        float: left;
        padding: 0px 7px;
        color: #b5b4b4;
        font-size: 20px;
        line-height: 30px;
    }

    .custom-sidebar-left .kopa-product-categories-widget .widget-content ul {
        top: 0;
        left: 101%;
        width: 100%;
        margin-left: 0px;
        margin-top: 1px;
    }

    .social-divider {
        background: #b5b4b4;
        height: 14px;
        float: left;
        width: 2px;
        margin: 8px 10px;
    }

    .image-slides .carousel-control {
        width: 30px;
        height: 28px;
        top: 50px;
    }

    .image-slides {
        margin-bottom: 30px;
    }

</style>
<?php
//echo '<pre>', print_r($plugin_image);
//echo '<pre>', print_r($cover_image);
//die;
?>
<div class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <!--                <div class="social-links">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <div class="social-divider"></div>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                    <div class="social-divider"></div>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <div class="social-divider"></div>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </div>-->
            </div>

            <div class="col-md-2">
            </div>
            <div class="col-md-7">

                <?php if (isset($product_details) && !empty($product_details)) { ?>
                    <p>
                        We found <b>(<?php echo count($product_details) ?>)</b> wheels for:

                    </p>
                    <?php $recentVehicle = $this->session->userdata('recent_product'); ?>
                    <p><b><?php echo $product_make[$recentVehicle['product_make']]; ?> 
                            <?php echo $product_model[$recentVehicle['product_model']]; ?> 
                            <?php echo $product_year[$recentVehicle['product_year']]; ?> </b>
                        (<a href="" data-toggle="modal" data-target="#searchFilterModalVehicleView">
                            New Search
                        </a>)
                    </p>
                <?php } ?>

                <!--                <form class="form-inline">
                                    <div class="form-group">
                                        <label class="" style="padding: 0px 10px">SORT BY </label>
                                        <select class="form-control" style="width: 200px">
                                            <option>PRODUCT NAME</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-left: 20px;">
                                        <label class="" style="padding: 0px 10px">PRODUCT</label>
                                        <select class="form-control" style="width: 200px">
                                            <option>TYRE</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    
                
                                    <button type="submit" class="btn btn-filter" style="margin-left: 20px;">
                                        <i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
                                </form>-->
            </div>
        </div>
    </div>
</div>

<!-- main content -->

<div id="main-content" class="kopa-shop-page pt-50">
    <div class="container">
        <div class="row">
            <!-- Start Sidebar-->
            <div id="sidebar" class="col-md-3 custom-sidebar-left">
                <div class="widget kopa-product-categories-widget">
                    <div class="widget-title title-s2">
                        <h3>Filters</h3>
                    </div>
                    <div data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
                        <h3>Price <small style="border:0; color:#f6931f; font-weight:bold;">(0$-500$)</small> <i class="fa fa-caret-down pull-right"></i></h3>
                    </div>
                    <div class="list-checkbox collapse" id="collapseExample1" style="margin-bottom: 30px">
                        <input hidden="" type="text" id="max-price" value="500">                                                  
                        <input type="text" class="amount" id="min-price" readonly style="border:0; color:#f6931f; font-weight:bold;">
                        <div id="slider-range-max"></div>
                    </div>

                    <div data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                        <h3>Brand(<?php echo count($brands_dtails); ?>) <i class="fa fa-caret-down pull-right"></i></h3>
                    </div>
                    <div class="list-checkbox collapse" id="collapseExample2">

                        <?php if (isset($brands_dtails))  ?>
                        <?php foreach ($brands_dtails as $brand) { ?>
                            <div class="checkbox">

                                <label>

                                    <input type="checkbox" value="<?php echo $brand['id'] ?>" class="brand_cat"> <?php echo $brand['sub_name'] ?>

                                </label>

                            </div>

                        <?php } ?>


                    </div>



                </div>

                <!-- .kopa-product-categories-widget -->



                <div class="widget kopa-product-list-widget">

                    <div class="widget-title title-s2   ">

                        <h3>Best Sellers</h3>

                    </div>

                    <div class="widget-content">

                        <ul>
                            <?php if (isset($best_seller_details)) { ?>
                                <?php foreach ($best_seller_details as $bData) { ?>

                                    <li class="product-item">                                    

                                        <a href="#" class="product-thumb"><img src="<?php echo base_url() . $bData['url'] ?>" alt="" /></a>

                                        <div class="product-caption">

                                            <h4 class="product-title"><a href="<?php echo base_url() . 'home/shop_product/' . $bData['id'] . '/' . $bData['category_id'] ?>"><?php echo $bData['product_name'] ?></a></h4> 

                                            <div class="price-info">
                                                <?php if (isset($bData['discounted_price']) && !empty($bData['discounted_price'])) { ?>
                                                    <span class="old-price">$<?php echo $bData['price'] ?></span>
                                                    <span class="new-price">$<?php echo floatval($bData['price']) - floatval($bData['discounted_price']) ?></span>

                                                <?php } else { ?>
                                                    <span class="new-price">$<?php echo $bData['price'] ?></span>
                                                <?php } ?>

                                            </div> 

                                        </div>  

                                    </li>
                                <?php } ?>
                            <?php } ?>


                        </ul>

                    </div>

                </div>

                <!-- kopa product list widget -->


                <div class="widget kopa-testimonials-widget testi-1"> 
                    <div class="widget-top">
                        <div class="widget-title title-s3">                        
                            <h3>Testimonials</h3>
                            <span class="red-bg"></span>
                        </div>                    
                        <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
                    </div> 
                    <div class="widget-content">
                        <div class="wrapper">
                            <div class="owl-carousel owl-testi-1">

                                <?php if (isset($testi_monial))  ?>
                                <?php foreach ($testi_monial as $tData) { ?>
                                    <div class="item">                                
                                        <p class="customer-comment"><span class="team-name"></span><?php echo $tData['testimonial'] ?></p>
                                        <span class="customer-avatar">
                                            <img src ="<?php echo base_url() ?>media/backend/img/testimonial_img/<?php echo $tData['image'] ?>" alt="" />

                                        </span>
                                        <span class="meta-info">
                                            <span class="custome-name"><?php echo $tData['name'] ?></span>,
                                            <span class="customer-job">Customer</span>
                                        </span>  
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>            
                </div>

                <!-- kopa testimonials widget --> 
            </div>





            <!-- End sidebar -->




            <div id="filter_section">
                <?php $this->load->view('product/_filter_result'); ?>
            </div>

            <!-- main column -->







        </div>

        <!-- row -->



    </div>   

    <!-- container -->    
</div>
<!-- main content -->


<script>

    $('.set-image').hide();
    $('.append-part-image').on('click', function () {

        $('.set-image').show();
        var imgsrc = $(this).attr('src');
        $(".set-image").attr('src', imgsrc);
    });
</script> 
<script>
    $(document).ready(function () {
        $('.brand_cat').change(function () {
            var arr = [];

            $("input[type=checkbox]:checked").each(function () {
                //alert( $(this).val() );

                arr.push($(this).val());

            });
//console.log(arr);
            var jsonString = JSON.stringify(arr);
            var product_make = <?php echo $recentVehicle['product_make'] ?>;
            var product_year = <?php echo $recentVehicle['product_year'] ?>;
            var product_model = <?php echo $recentVehicle['product_model'] ?>;
            var cat_id = '<?php echo $recentVehicle['product_category']; ?>';
//console.log(jsonString);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>home/productFilter/brand_filter",

                data: "brand_id=" + arr + "&method=brand_filter&product_make=" + product_make + "&product_year=" + product_year + "&product_model=" + product_model + "&product_category_id=" + cat_id,
                success: function (data) {
                    //console.log(data);
                    var obj = JSON.parse(data);
                    $("#filter_section").html(obj);


                }
            });
        });

        $('#min-price').change(function () {


        });
    });
</script>

<script>
    $(function () {
        $("#slider-range-max").slider({
            range: "max",
            min: 0,
            max: 500,
            value: 0,
            slide: function (event, ui) {
                $(".amount").val(ui.value + '$');
                var arr = [];
//            $("input[type=checkbox]:checked").each(function () {
                var minp = $("#slider-range-max").slider("value");
                var maxp = $('#max-price').val();
                arr.push(minp);
                arr.push(maxp);
//            });
//console.log(arr);
                var product_make = <?php echo $recentVehicle['product_make'] ?>;
                var product_year = <?php echo $recentVehicle['product_year'] ?>;
                var product_model = <?php echo $recentVehicle['product_model'] ?>;
                var cat_id = '<?php echo $recentVehicle['product_category']; ?>';
                var jsonString = JSON.stringify(arr);
                console.log(jsonString);
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>home/productFilter/price_filter",
                    data: "price_range=" + arr + "&method=price_filter&product_make=" + product_make + "&product_year=" + product_year + "&product_model=" + product_model + "&product_category_id=" + cat_id,
                    success: function (data) {
                        console.log(data);
                        if (data != '')
                        {

                            var obj = JSON.parse(data);
                            $("#filter_section").html(obj);
                        } else
                        {
                            window.location.href = '<?php echo base_url() ?>home/productFilter/view_on_vehicle'
                        }
                    }
                });
            }
        });
        $(".amount").val($("#slider-range-max").slider("value") + '$');


    });
</script>
<!--<style>
.left-tire{
  position: absolute;
  top: 30.5%;
  right: 21%;
  width: 14%;
}
.right-tire{
  position: absolute;
  top: 30.5%;
  left: 21%;
  width: 14%;
}
</style>-->
