<?php // echo '<pre>', print_r($product_details);die;                                                                                         ?>
<?php if (isset($product_details))  ?>
<?php foreach ($product_details as $productData) { ?>
    <div class="shop-product-single">
        <h1><?php echo isset($productData['product_name']) ? $productData['product_name'] : '' ?></h1>
        <div class="kopa-divider divider-1"></div>

        <div class="product-content clearfix">
            <div class="row">

                <div class="product-thumbnail col-sm-12 col-xs-12">
                    <div id="productSliderFor" class="slider big-thumb">
                        <?php if (isset($productData['product_images_details']))  ?>
                        <?php foreach ($productData['product_images_details'] as $imgData) { ?>
                            <div>
                                <img class="img-re" src="<?php echo base_url() . $imgData['url'] ?>" height="488" width="470" alt="">
                            </div>
                        <?php } ?>
    <!--<img src="<?php echo base_url() ?>assets/placeholders/car/Shop-Product_470-488.jpg" height="488" width="470" alt="">-->
                    </div>

                    <div id="productSliderNav" class="slider small-thumb">
                        <?php if (isset($productData['product_images_details']))  ?>
                        <?php foreach ($productData['product_images_details'] as $imgData) { ?>
                            <div>
                                <img src="<?php echo base_url() . $imgData['url']; ?>" height="110" width="150" alt="">
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="product-detail col-sm-12 col-xs-12">
                    <div class="product-price-wrap">
                        <?php if (isset($productData['discounted_price']) && !empty($productData['discounted_price'])) { ?>
                            <p class="product-price"><strike>$<?php echo $productData['price'] ?></strike> <span class="new-price">$<?php echo floatval($productData['price']) - floatval($productData['discounted_price']) ?></span></p>
                        <?php } else { ?>
                            <p class="product-price"><span>$<?php echo isset($productData['price']) ? $productData['price'] : '' ?></span></p>
                        <?php } ?>

                    </div>                                    

                    <p class="meta-info clearfix">
                        <span class="kopa-rating">
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <?php if ($i < $average_rating) { ?>
                                    <span class="fa fa-star"></span>                                   
                                <?php } else { ?>
                                    <span class="fa fa-star-o"></span>
                                <?php } ?>
                            <?php } ?>


                        </span>
                        <span class="review"><?php echo count($all_review) ?> Review</span>
                        <?php if ($this->ion_auth->logged_in()) { ?>
                            <?php if (isset($check)) ; ?> 
                            <?php
                            if ($check == true) {
                                $user_id = $this->session->userdata('user_id');
                                foreach ($product_details as $d) {
                                    ?> 
                                    <a href="#" class="add-review" onclick="edit(<?php echo $d['id']; ?>,<?php echo $user_id; ?>)" data-toggle="modal" data-target="#reviewModal">Edit Review</a>
                                    <?php
                                }
                            }
                            ?> 
                            <?php if ($check == false) { ?> 

                                <a href="#" class="add-review" data-toggle="modal" data-target="#reviewModal">Add your review</a>
                            <?php } ?> 
                        <?php } ?>
                    </p>

                    <p class="intro"><?php echo html_entity_decode(isset($productData['description']) ? ($productData['description']) : '') ?></p>
                    <div class="features">
                        <?php if (isset($product_make[$productData['make_id']])) { ?>
                            <p><span>car make</span><?php echo isset($product_make[$productData['make_id']]) ? $product_make[$productData['make_id']] : '-' ?> |
                                <?php echo isset($product_model[$productData['model_id']]) ? $product_model[$productData['model_id']] : '-'; ?> |
                                <?php echo isset($product_year[$productData['year_id']]) ? $product_year[$productData['year_id']] : ''; ?>
                            </p>
                        <?php } ?>
                        <?php ?>
                        <?php if (isset($productData['prodcut_cat_edit_detail']))  ?>
                        <?php foreach ($productData['prodcut_cat_edit_detail'] as $productSD) { ?>
                            
                            <?php // echo '<pre>', print_r($productSD);?>
                            <?php if ($productSD['attribute_type'] == '1') { ?>
                                <?php foreach ($product_details[0]['product_attr_details'] as $attrdatas) { ?>
                                    <?php if ($attrdatas['attribute_type'] == '1') { ?>
                                        <?php
                                        $sub_attribute_dp_id = '';
                                        $options = array();
//                                       echo '<pre>', print_r($attrdatas);
                                        foreach ($attrdatas['sub_attribute_details'] as $key => $val) {

                                            $options[$val['id']] = $val['sub_name'];
                                            if (isset($productSD['sub_attribute_dp_id']))
                                                $sub_attribute_dp_id = $productSD['sub_attribute_dp_id'];
                                        }
                                        ?>
                                    <?php } ?>
                                <?php } ?>
                            
                            
                                <?php if ($productSD['attribute_type'] != '2' && isset($options[$sub_attribute_dp_id])) { ?>
                                    <p><span><?php echo $productSD['attribute_value'] ?></span><?php echo isset($options[$sub_attribute_dp_id]) ? $options[$sub_attribute_dp_id] : '' ?></p>
                                <?php } ?>
                            <?php } else { ?>                                    
                                <?php // echo $productSD['attribute_type']; ?>
                                <?php if ($productSD['attribute_type'] != '2') { ?>
                                    <?php if (isset($productSD['sub_attribute_value']) && $productSD['sub_attribute_value'] != 'NA') { ?>
                                        <p><span><?php echo $productSD['subattribute_name'] ?> </span> <?php echo $productSD['sub_attribute_value'] ?></p>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                        <?php } ?>

                    </div>
                    <p class="add-to-cart-wrap">
                        <input type="hidden" id="item_id_<?php echo $productData['id'] ?>" name="item_id" value="<?php echo $productData['id'] ?>"/>
                        <input type="hidden" id="name_<?php echo $productData['id'] ?>" name="name" value="<?php echo $productData['product_name'] ?>"/>
                        <?php if (isset($productData['discounted_price']) && !empty($productData['discounted_price'])) { ?>
                            <input type="hidden" id="price_<?php echo $productData['id'] ?>" name="price" value="<?php echo floatval($productData['price']) - floatval($productData['discounted_price']) ?>"/>    

                        <?php } else { ?>
                            <input type="hidden" id="price_<?php echo $productData['id'] ?>" name="price" value="<?php echo $productData['price'] ?>"/>
                        <?php } ?>
                        <input type="hidden" id="img_url_<?php echo $productData['id'] ?>" name="img_url" value="<?php echo $productData['url'] ?>"/>
                        <input type="hidden" id="stock_<?php echo $productData['id'] ?>" name="stock" value="<?php echo $productData['quantity'] ?>"/>
                        <input type="number" class="amount" title="Qty" value="1" id="quantity_<?php echo $productData['id'] ?>" name="quantity" min="1" step="1">
                        <button  class="add-to-cart" onclick="funAddToCart(<?php echo $productData['id'] ?>)" ><span><i class="fa fa-plus"></i>add to cart</span></button>
                    </p>

                    <?php if ($this->uri->segment(4) == 2) { ?>
                        <p>
                            <a href="" data-toggle="modal" data-target="#searchFilterModalVehicleView">
                                View On My Vehicle
                            </a>
                        </p>
                    <?php } ?>
    <!--                    <p class="categories">
    <span class="title">Categories:</span>
    <a href="#"></a>,
    </p>-->
                </div>
            </div>

        </div>

        <div role="tabpanel" class="kopa-tab-2 mb-40 clearfix">

            <ul class="nav nav-tabs product-nav-tab" style="padding:0px">
                <li class="active"><a href="#tab1-1" data-toggle="tab">Description</a></li>
                <!--<li><a href="#tab1-2" data-toggle="tab">product tags</a></li>-->
                <li><a href="#tab1-3" data-toggle="tab">review <span>(<?php echo count($all_review) ?>)</span></a></li>
            </ul>
            <!-- Nav tabs -->

            <div class="tab-content product-tab-content">
                <div class="tab-pane active" id="tab1-1">
                    <p><?php echo html_entity_decode(isset($productData['description']) ? ($productData['description']) : '') ?></p>
                </div>
                <!--<div class="tab-pane" id="tab1-2">-->
                    <!--<p>2A 2014 LP700 Roadster in a dazzling Grigio Telesto with Nero leather and Giallo Contrast Stitch, this stand out Lamborghini makes a powerful statement without saying a word. The new LP700 Roadster boasts breath taking performance, with acceleration from 0-100 km/hr in only 3 second flat and a maximum speed of 350 km/hr. Lamborghini made changes to the engine hood on the with two pairs of hexagonal windows connected at the sides, separated with a central spinal column.</p>-->
                    <!--<p>Extensive factory options include Out of Range Paint, T Engine Cover in Carbon Fiber, Carbon Fiber Engine Bay, Front Exterior Carbon Fiber Package, Rear Exterior Carbon Fiber Package, Exterior Details in Carbon Fiber Small, Transparent Engine Bonnet, Yellow Brake Callipers, Yellow Rear Suspension Springs, Lamborghini Sound System, Park Assist Front and Rear with Rear Camera, Multifunction Steering Wheel with Perforated Leather, Branding Package, Homelink and Unicolour Interior with Giallo Contrast Stitch. Additional factory options include an Ad Personum Element with Q-Citura Stitching throughout the </p>-->
                <!--</div>-->
                <div class="tab-pane mCustomScrollbar review-tab" id="tab1-3">
                    <?php
//                    echo '<pre>', print_r($all_review);
//                    die;
                    ?>
                    <?php if (isset($all_review)) { ?>
                        <table class="">
                            <tbody style="height:100px;">
                                <?php foreach ($all_review as $rw) { ?>
                                    <tr>
                                        <td width="20%">
                                            <div style="width: 30%" >
                                                <?php if (isset($rw['profileimg']) && $rw['profileimg'] != '') { ?>
                                                    <image class="img-circle img-center" src="<?php echo base_url() . $rw['profileimg']; ?>"/> 
                                                <?php } else { ?>
                                                    <image class="img-circle img-center" src="<?php echo base_url() ?>media/default-user.png"/> 
                                                <?php } ?>
                                            </div>
                                            <p title="<?php echo $rw['first_name'] . ' ' . $rw['last_name'] ?>"> <?php echo $rw['first_name'] ?></p>

                                        </td>


                                        <td class="meta-info">
                                            <span class="kopa-rating">
                                                <?php for ($i = 0; $i < 5; $i++) { ?>
                                                    <?php if ($i < $rw['review_total']) { ?>
                                                        <span class="fa fa-star"></span>                                   
                                                    <?php } else { ?>
                                                        <span class="fa fa-star-o"></span>
                                                    <?php } ?>
                                                <?php } ?>
                                            </span>
                                            <small><span class="pull-right text-ccc"> <?php echo date('d F y', strtotime($rw['created_date'])) ?></span></small>

                                            <p><?php echo $rw['discription'] ?></p>
                                            <hr>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    <?php } ?>
                                                                                                                    <!--<p>3A 2014 LP700 Roadster in a dazzling Grigio Telesto with Nero leather and Giallo Contrast Stitch, this stand out Lamborghini makes a powerful statement without saying a word. The new LP700 Roadster boasts breath taking performance, with acceleration from 0-100 km/hr in only 3 second flat and a maximum speed of 350 km/hr. Lamborghini made changes to the engine hood on the with two pairs of hexagonal windows connected at the sides, separated with a central spinal column.</p>-->
                                                                                                                    <!--<p>Extensive factory options include Out of Range Paint, T Engine Cover in Carbon Fiber, Carbon Fiber Engine Bay, Front Exterior Carbon Fiber Package, Rear Exterior Carbon Fiber Package, Exterior Details in Carbon Fiber Small, Transparent Engine Bonnet, Yellow Brake Callipers, Yellow Rear Suspension Springs, Lamborghini Sound System, Park Assist Front and Rear with Rear Camera, Multifunction Steering Wheel with Perforated Leather, Branding Package, Homelink and Unicolour Interior with Giallo Contrast Stitch. Additional factory options include an Ad Personum Element with Q-Citura Stitching throughout the </p>-->
                </div>
            </div>
            <!-- Tab panes -->

        </div>

    </div> 
<?php } ?>
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="searchFilterModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" id="modal_id" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="searchFilterModalLabel">Review</h4>
            </div>
            <div class="modal-body">


                <form method="post">
                    <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ratting:</label>
                                <!--<div rating_star></div>-->

                                <input type="hidden" class="form-control" id="rating_star" postId="1" value="1">

                                <input type="hidden" class="form-control" id="rating_star" postId="1">
                                <input type="hidden" class="form-control" id="editid" value="">

                                <div class="clearfix"></div>
                                <div class="overall-rating"> <span id="avgrat"><?php // echo  $review[0]['review_total']                                                    ?></span>
                                    <span id="totalrat"><?php // echo $review[0]['review_total'];                                                    ?></span>  </span></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <label>Description:</label>
                            <div class="form-group">
                                <textarea  class="form-control" placeholder="Description" name="dis" id="dis" required="" rows="5"></textarea>

                            </div>
                        </div>

                        <div class="col-md-12 text-center">

                            <button type="submit" class="kopaBtn editReview" id="rating" >Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>


    $(document).ready(function () {
// edit(pid, uid);

        $("#rating_star").spaceo_rating_widget({
            starLength: 5,
            initialValue: <?php echo isset($review[0]['review_total']) ? $review[0]['review_total'] : '1'; ?>,
//        callbackFunctionName: 'processRating',
            imageDirectory: 'http://ittires.com/assets/img/',
            inputAttr: 'postID'
        });

        $('.editReview').click(function () {

            var id = $('#rating_star').val();
            var pid = $('#product_id').val();
            var dis = $('#dis').val();
            var editid = $('#editid').val();
            if (dis == '') {
                $('#dis').focus();

                return false;
            } else {
                $('#rating').prop("disabled", true);
            }



//        console.log(id);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>home/review_rating/review',
                data: 'product_id=' + pid + '&points=' + id + '&dis=' + dis + '&editid=' + editid,
                dataType: 'json',
                success: function (data) {
                    if (data)
                    {
                        window.location.reload();
                    }
                }
            });
        });
    });
    function edit(pid, uid) {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>home/review_rating/edit',
            data: 'pid=' + pid + '&uid=' + uid,
            dataType: 'json',
            success: function (data) {

//                var obj=JSON.parse(data);
//                console.log(data);
                $.each(data, function (key, val) {
//            alert(key+val);
//                    console.log(val.id);
//a(this).next("ul").children("li").slice(0,val.review_total).css('background-position','0px -28px')
                    $('#rating_star').val(val.review_total);
                    $('#product_id').val(val.product_id);
                    $('#dis').val(val.discription);
                    $('#editid').val(val.id);
                });
//                $('#avgrat').text(data.average_rating);
//                $('#totalrat').text(data.rating_number);

            }
        });
    }

// function processRating(val, attrVal){
//    
//}
// Example of adding a item to the cart via a link.
    function funAddToCart(id)
    {

        var item_id = $('#item_id_' + id).val();
        var name = $('#name_' + id).val();
        var price = $('#price_' + id).val();
        var item_url = $('#img_url_' + id).val();
        var quantity = $('#quantity_' + id).val();
        var stock_quantity = $('#stock_' + id).val();


        event.preventDefault();

        $.ajax(
                {
                    method: "POST",
                    data: {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url, 'quantity': quantity, 'stock_quantity': stock_quantity},
                    url: href = "<?php echo base_url(); ?>standard_library/insert_ajax_link_item_to_cart/" + id,
                    success: function (data)
                    {
                        var parsed = $.parseJSON(data);

//                        alert(JSON.stringify(parsed.content));
                        $.toaster({priority: 'info', title: 'Cart', message: 'Product has been added to the cart.'});
                        var cart_count = JSON.stringify(parsed.content['summary']['total_rows']);
                        var cart_total = JSON.stringify(parsed.content['summary']['total']);
                        $('#id_cart_total').text('');
                        $('#id_total').text('');
                        $('#id_cart_total').text(cart_count);
                        $('#id_total').text(cart_total);
                        $(".item shopping-cart").show();
                        $(window).scrollTop(0);
                        return false;
//                        ajax_update_mini_cart(data);
                    }
                }
        );
    }

    function ajax_update_mini_cart(data)
    {

        // Replace the current mini cart with the ajax loaded mini cart data. 
        var ajax_mini_cart = $(data).find('#mini_cart');
        $('#mini_cart').replaceWith(ajax_mini_cart);

        // Display a status within the mini cart stating the cart has been updated.
        $('#mini_cart_status').show();

        // Set the new height of the menu for animation purposes.
        var min_cart_height = $('#mini_cart ul:first').height();
        $('#mini_cart').attr('data-menu-height', min_cart_height);
        $('#mini_cart').attr('class', 'js_nav_dropmenu');

        // Scroll to the top of the page.
        $('body').animate({'scrollTop': 0}, 250, function ()
        {
            // Notify the user that the cart has been updated by showing the mini cart.
            $('#mini_cart ul:first').stop().animate({'height': min_cart_height}, 400).delay(3000).animate({'height': '0'}, 400, function ()
            {
                $('#mini_cart_status').hide();
            });
        });
    }
//    function fun_success_message(msg) {

//    }
</script>

