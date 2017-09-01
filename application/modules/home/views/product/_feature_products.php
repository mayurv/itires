<!--<div class="widget-top">
    <div class="widget-title title-s3">                        
        <h3>Featured Product</h3>
        <span class="red-bg"></span>
    </div>                    
    <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
</div>  -->
<div class="widget-content parallax clearfix">
    <div class="mask"></div>
    <div class="container product-list-1">
        <div class="content-inner row">
            <?php $i = 1; ?>
            <?php foreach ($product_feature_details as $pk => $pkData) { ?>
                <div class="col-sm-6 col-md-3">
                    <article class="item">
                        <div class="item-top">
                            <a class="thumbnail" href="<?php echo base_url() . 'home/shop_product/' . $pkData['id'] . '/' . $pkData['category_id'] ?>">
                                <span class="span-related-product"><img class="img-feature img-responsive" src="<?php echo base_url() . $pkData['url'] ?>" height="219" width="280" alt=""></span>
                                <span class="hexagon-1">
                                    <span><i class="fa fa-mail-forward"></i></span>
                                </span>
                                <?php if (isset($pkData['discounted_price']) && !empty($pkData['discounted_price'])) { ?>
                                    <span class="flag sale"><i>Sale</i></span>
                                <?php } ?>

                            </a>    
                            <h6 class="product-title"><a href="<?php echo base_url() . 'home/shop_product/' . $pkData['id'] . '/' . $pkData['category_id'] ?>" title="<?php echo $pkData['product_name'] ?>">
                                    <?php if (strlen($pkData['product_name']) > 20) { ?>
                                        <?php echo substr($pkData['product_name'], 0, 18) . '..'; ?>
                                    <?php } else { ?>
                                        <?php echo $pkData['product_name'] ?>
                                    <?php } ?>

                                </a></h6>

                            <span class="kopa-rating">
                                <?php for ($i = 0; $i < 5; $i++) { ?>
                                    <?php if ($i < $pkData['review_total']) { ?>
                                        <span class="fa fa-star"></span>                                   
                                    <?php } else { ?>
                                        <span class="fa fa-star-o"></span>
                                    <?php } ?>
                                <?php } ?>
                            </span>
                        </div>

                        <div class="price-box">                                    
                            <footer>
                                <?php if (isset($pkData['discounted_price']) && !empty($pkData['discounted_price'])) { ?>
                                    <span class="old-price">$<?php echo $pkData['price'] ?></span>
                                    <span class="new-price">$<?php echo floatval($pkData['price']) - floatval($pkData['discounted_price']) ?></span>

                                <?php } else { ?>
                                    <span class="new-price">$<?php echo $pkData['price'] ?></span>
                                <?php } ?>
                            <!--<span class="old-price"><?php echo $pkData['price'] ?></span>-->
                            <!--<span class="new-price">$<?php echo $pkData['price'] ?></span>-->
                            </footer>
                            <span class="white-bg"></span>
                            <!--<a  onclick="funAddToFeatCart(<?php echo $pkData['id'] ?>)"  class="add_item_via_ajax_link cart-icon"><i class="fa fa-shopping-cart"></i></a>-->  
                            <a  href="<?php echo base_url() . 'home/shop_product/' . $pkData['id'] . '/' . $pkData['category_id'] ?>"  class="add_item_via_ajax_link cart-icon"><i class="fa fa-eye"></i></a>  
                        </div>                            
                    </article>
                </div>
                <?php // if ($i == 3) { ?>
                <!--<div class="clearfix"></div>-->

                <?php
//                    $i = 1;
//                }
                ?>
                <?php
                $i++;
            }
            ?>
        </div>

        <div class="clear"></div>

        <div class="read-more">  
            <span class="bg-1"></span>              
            <span class="bg-2"></span>
            <span class="bg-3"></span>
            <a href="<?php echo base_url() ?>home/shop/" class="link">view all new products</a>                  
        </div> 
    </div>                           
</div>  
<script>

//    $(document).ready(function () {
//        
//    });
// Example of adding a item to the cart via a link.
    function funAddToFeatCart(id)
    {

        var item_id = $('#item_id_' + id).val();
        var name = $('#name_' + id).val();
        var price = $('#price_' + id).val();
        var item_url = $('#img_url_' + id).val();


        event.preventDefault();

        $.ajax(
                {
                    method: "POST",
                    data: {'item_id': item_id, 'price': price, 'name': name, 'item_url': item_url},
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