<?php if (isset($product_details) && !empty($product_details)) { ?>
    <div id="main-col" class="col-md-9 col-sm-12">
        <div style="margin-bottom: 20px;border: 1px solid #e6e6e6;border-radius: 2px; position: relative;">
            <?php // echo '<pre>', print_r($cover_image);die; ?>
            <?php if (isset($cover_image)) { ?>
                <?php if (!empty($cover_image['model_img_url'])) { ?>
                    <img src="<?php echo base_url() . $cover_image['model_img_url']; ?>">

                    <img src="<?php echo base_url(); ?>parts/rim1.png" class="set-image " style="width:<?php echo $cover_image['rim_left_w'] ?>%;left:<?php echo $cover_image['rim_left_l'] ?>%; top: <?php echo $cover_image['rim_left_t'] ?>%;position: absolute" >

                    <img src="<?php echo base_url(); ?>parts/rim1.png" class="set-image "  style="width:<?php echo $cover_image['rim_right_w'] ?>%;right:<?php echo $cover_image['rim_right_l'] ?>%; top: <?php echo $cover_image['rim_right_t'] ?>%;position: absolute">
                <?php } else { ?>
                    <div class="col-sm-12">
                        <br>
                        <h4 class="text-danger">Vehicle Photography Not Available</h4>
                        <p><span class="redTitle">Vehicle Photography Not Available</span><br>We're sorry. A high quality photo of your vehicle is not available in our library of images. We photograph vehicles as they become available to us in our area, but some older or hard-to-find models may not be represented within this tool on our site due to availability.</p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <img src="<?php echo base_url() . $cover_image['model_img_url']; ?>">
            <?php } ?>
        </div>
        <?php // echo '<pre>', print_r($plugin_image);die;?>
        <?php
        $imagearray = array();
        $cnt = count($plugin_image);
        $i = 1;
        $j = 1;
        foreach ($plugin_image as $image) {

            $imagearray[$j][$i] = $image['sub_attribute_value'];
            if ($i == 6) {
                $j++;
                $i = 1;
            }
            $i++;
        }
        ?>
        <?php // echo '<pre>', print_r($plugin_image);die;?>
        <div class="image-slides">
            <div class="carousel slide media-carousel" data-interval="false" id="media">
                <div class="carousel-inner">
                    <?php if (isset($plugin_image)) { ?>
                        <?php
                        $i = 1;
                        $active = 'active';
                        foreach ($imagearray as $key => $image) {
                            ?>
                            <div class="item  <?php echo $active; ?>">
                                <div class="row">
                                    <?php
                                    foreach ($image as $val) {
                                        ?>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <a class="thumbnail" href="javascript:;">
                                                <?php if (!empty($cover_image['model_img_url'])) { ?>
                                                <img alt="" class="append-part-image" src="<?php echo base_url() . $val; ?>" style="width: auto"></a>
                                                <?php } ?>
                                        </div>
                                        <?php
                                        $active = '';
                                    }
                                    ?>
                                </div>
                            </div>                            
                        <?php } ?>
                    <?php } ?>
                </div>
                <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
                <a data-slide="next" href="#media" class="right carousel-control">›</a>
            </div> 

        </div>                     




        <div class="ajax-view-product">
            <?php $this->load->view('ajax_product_view'); ?>

        </div>

        <!-- kopa pagination -->  



    </div>
<?php } else { ?>
    <div id="main-col" class="col-md-9">
        <div class="product-list-1">

            <div class="row">
                <div class="text-center">
                    <h4>WE'RE SORRY.</h4>
                    <h6>There are no <span class="text-danger"><?php echo $category_title ?></span> available for your vehicle.</h6>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>

    $('.set-image').hide();
    $('.append-part-image').on('click', function () {

        $('.set-image').show();
        var imgsrc = $(this).attr('src');
        $(".set-image").attr('src', imgsrc);
    });
</script> 
<script>

//    $(document).ready(function () {
//        
//    });
// Example of adding a item to the cart via a link.
    function funAddToCartFilter(id)
    {

        var item_id = $('#item_id_' + id).val();
        var name = $('#name_' + id).val();
        var price = $('#price_' + id).val();
        var item_url = $('#img_url_' + id).val();
        var stock_quantity = $('#stock_' + id).val();


        event.preventDefault();

        $.ajax(
                {
                    method: "POST",
                    data: {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url, 'stock_quantity': stock_quantity},
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
<script>
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var keywords = 'view_on_vehicle_product';
        var sortBy = $('#sortBy').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/ajaxPaginationData/' + page_num,
            data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy,
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (html) {
                $('.ajax-view-product').html('');
                $('.ajax-view-product').html('');
                $('.ajax-view-product').html(html);
                $('.loading').fadeOut("slow");
            }
        });
    }
</script>