<div id="kopa-top-page">        
    <!--    <div class="top-page-above">
            <div class="mask"></div>
            <div class="page-title">
                <h1>Shop Product</h1>
                <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>                      
            </div> 
            <div class="kopa-breadcrumb clearfix">
                <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a itemprop="url" href="index-2.html">
                        <span itemprop="title">Home</span>
                    </a>
                </span>
                <span>&nbsp;&rsaquo;&nbsp;</span>
                <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a itemprop="url" href="index-2.html">
                        <span itemprop="title">Shop Page</span>
                    </a>
                </span>
                <span>&nbsp;&rsaquo;&nbsp;</span>
                <span class="current-page" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">Shop Product</span></span>
                <span class="bottom-line"></span>
            </div>
        </div>  -->
    <!-- top page above -->
    <div class="top-page-bottom clearfix">
        <div class="container">
            <!--            <div class="top-link">
                            <a href="#" class="print"><i class="fa fa-print"></i>Print this page</a>
                            <a href="#"><i class="fa fa-star"></i>Add to favourites</a>
                            <div class="share-vehice">
                                <a href="#" class="share">
                                    <i class="fa fa-share-alt"></i>Share Vehice                        
                                </a>
                                <div class="kopa-social-links">
                                    <ul>
                                        <li><a href="#" rel="nofollow" class="fa fa-facebook"></a></li>
                                        <li><a href="#" rel="nofollow" class="fa fa-twitter"></a></li>
                                        <li><a href="#" rel="nofollow" class="fa fa-google-plus"></a></li>
                                        <li><a href="#" rel="nofollow" class="fa fa-pinterest"></a></li>
                                    </ul>
                                </div> 
                            </div>     
                        </div>-->
            <a href="<?php echo base_url() ?>home/shop" class="pre-page">Back to Previous Page</a>
        </div>
    </div>    
    <!-- top page bottom -->
</div>
<!-- kopa top page -->

<div id="main-content" class="kopa-shop-product-page pt-40">
    <div class="container">
        <div class="row">
            <div id="main-col" class="col-md-9">                    
                <?php echo $this->load->view('product/_product_detail'); ?>

                <div class="kopa-divider divider-1"></div>

                <div class="kopa-area">
                    <div class="widget kopa-related-product-widget">
                        <div class="widget-title title-s3">                        
                            <h3>related products</h3>
                            <span class="red-bg"></span>
                        </div>
                        <div class="text-center pos-rel">
                            <div class="loader" hidden></div>
                        </div>
                        <div class="widget-content">
                            <div class="ajax-view-product-related">
                                <div class="product-list-1">
                                    <div class="row">

                                        <?php $i = 1; ?>
                                        <?php foreach ($related_product_details as $pk => $pkData) { ?>
                                            <div class="col-sm-6 col-md-4">
                                                <article class="item">
                                                    <div class="item-top">
                                                        <a class="thumbnail" href="<?php echo base_url() . 'home/shop_product/' . $pkData['id'] . '/' . $pkData['category_id'] ?>">
                                                            <span><img src="<?php echo base_url() . $pkData['url'] ?>" height="219" width="280" alt=""></span>
                                                            <span class="hexagon-1">
                                                                <span><i class="fa fa-mail-forward"></i></span>
                                                            </span>
                                                            <?php if (isset($pkData['discounted_price']) && !empty($pkData['discounted_price'])) { ?>
                                                                <span class="flag sale"><i>Sale</i></span>
                                                            <?php } ?>
                                                        </a>    
                                                        <h6 class="product-title">
                                                            <input hidden="" value="<?php echo $pkData['category_id'] ?>" id="category_id">
                                                            <a href="<?php echo base_url() . 'home/shop_product/' . $pkData['id'] . '/' . $pkData['category_id'] ?>" title="<?php echo $pkData['product_name'] ?>">
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
                                    <!--                                                    <span class="kopa-rating">
                                                                                        <span class="fa fa-star"></span>
                                                                                        <span class="fa fa-star"></span>
                                                                                        <span class="fa fa-star"></span>
                                                                                        <span class="fa fa-star"></span>
                                                                                        <span class="fa fa-star-half-o"></span>
                                                                                    </span>-->
                                                    </div>

                                                    <div class="price-box">                                    
                                                        <footer>
                                                            <!--<span class="old-price"><?php echo $pkData['price'] ?></span>-->
                                                            <!--<span class="new-price">$<?php echo $pkData['price'] ?></span>-->
                                                            <?php if (isset($pkData['discounted_price']) && !empty($pkData['discounted_price'])) { ?>
                                                                <span class="old-price">$<?php echo $pkData['price'] ?></span>
                                                                <span class="new-price">$<?php echo floatval($pkData['price']) - floatval($pkData['discounted_price']) ?></span>

                                                            <?php } else { ?>
                                                                <span class="new-price">$<?php echo $pkData['price'] ?></span>
                                                            <?php } ?>
                                                        </footer>
                                                        <span class="white-bg"></span>
                                                        <a  onclick="funAddToCartRelated(<?php echo $pkData['id'] ?>)"  class="add_item_via_ajax_link cart-icon"><i class="fa fa-shopping-cart"></i></a>  
                                                        <input type="hidden" id="item_id_<?php echo $pkData['id'] ?>" name="item_id" value="<?php echo $pkData['id'] ?>"/>
                                                        <input type="hidden" id="name_<?php echo $pkData['id'] ?>" name="name" value="<?php echo $pkData['product_name'] ?>"/>
                                                        <?php if (isset($pkData['discounted_price']) && !empty($pkData['discounted_price'])) { ?>
                                                            <input type="hidden" id="price_<?php echo $pkData['id'] ?>" name="price" value="<?php echo floatval($pkData['price']) - floatval($pkData['discounted_price']) ?>"/>
                                                        <?php } else { ?>
                                                            <input type="hidden" id="price_<?php echo $pkData['id'] ?>" name="price" value="<?php echo $pkData['price'] ?>"/>
                                                        <?php } ?>
                                                        <input type="hidden" id="img_url_<?php echo $pkData['id'] ?>" name="img_url" value="<?php echo $pkData['url'] ?>"/>
                                                        <input type="hidden" id="stock_<?php echo $pkData['id'] ?>" name="quantity" value="<?php echo $pkData['quantity'] ?>"/>
                                                    </div>                            
                                                </article>
                                            </div>
                                            <?php if ($i == 3) { ?>
                                                <div class="clearfix"></div>

                                                <?php
                                                $i = 0;
                                            }
                                            ?>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                        <?php echo ''; ?>
                                        <div class="clearfix"></div>
                                        <div class="kopa-divide"></div>  

                                        <div class="kopa-pagination clearfix">
                                            <ul class="clearfix">
                                                <?php echo $this->ajax_pagination->create_links(); ?>
                                            </ul>
                                        </div>
                                    </div>                                   
                                </div> 
                            </div>
                            <!-- product list 1 -->
                        </div>  
                        <!-- widget content -->                       
                    </div>
                    <!-- kopa related products -->
                </div>
                <!-- kopa area -->
            </div>
            <!-- main column -->

            <div id="sidebar" class="col-md-3">  

                <div class="widget kopa-inquire-vehicle-widget">
                    <h3 class="widget-title">inquire about this vehicle</h3>
                    <div class="widget-content">
                        <p class="call-us">Call us at: <span>1 800 887 869</span></p>
                        <?php
//                        if (!empty($this->session->flashdata('message'))) {
                        ?>
                            <!--<p class="call-us" id="msg"><?php // echo $this->session->flashdata('message')     ?></p>-->
                        <?php
                        //}
                        ?>
                        <form  method="post" action="#" class="inquire-form clearfix">   

                            <?php if (isset($product_details))  ?>
                            <?php foreach ($product_details as $prd) { ?>
                                              <!--<input type="text" value="Name"  id="productname" name="productname" class="valid" >-->
                                <input type="hidden" value="<?php echo $prd['product_name'] ?>"  id="productname" name="product_name" class="valid" >
                                <input type="hidden" value="<?php echo $prd['product_id'] ?>"  id="product_id" name="product_id" class="valid" >
                                <input type="hidden" value="<?php echo $prd['category_id'] ?>"  id="category_id" name="category_id" class="valid" >

                            <?php } ?>

                            <p class="input-block">
                                <input type="text" placeholder="Name"  id="inquire_name" name="name" class="valid" required>
                            </p>
                            <p class="input-block">
                                <input type="email" placeholder="Email"  id="inquire_email" name="email" class="valid" required style="width: 100%;height: 45px;">
                            </p>
                            <p class="input-block">   
                                <input type="text" placeholder="Phone" class="valid" name="phone" id="inquire_phone" required />       
                            </p>  
                            <p class="textarea-block">    
                                <textarea rows="6" cols="88" id="inquire_message" name="message"   required placeholder="Enter your Message"></textarea>
                            </p>  
                            <div class="button-wrapper">
                                <p class="send-message">  
<!--                                    <span class="bg-1"></span>              -->
                                    <!--<span class="bg-2"></span>-->
                                    <!--<span class="bg-3"></span>-->
                                    <button type="button" id="enquiry" class="kopaBtn">Send Message</button>
                                    <!--                                </p>  -->
                            </div>                                
                        </form> 
                    </div>
                </div>                  

                <div class="widget kopa-product-categories-widget">

                    <div class="widget-title title-s2">
                        <h3>Categories</h3>
                    </div>

                    <ul id="menu_list" class="widget-content sf-menu sf-vertical">							
                        <?php if (isset($prodcut_cat_detail)) { ?>
                            <?php foreach ($prodcut_cat_detail as $key => $dataAtt) { ?>
                                <li >
                                    <a href="<?php echo base_url() ?>home/shop/<?php echo $dataAtt['id'] ?>" title=""><?php echo $dataAtt['name']; ?></a>
                                    <div class="accordion-icon" data-target="menu<?php echo $key; ?>">></div>
                                    <?php if (isset($dataAtt['sub_attibutes'])) { ?>
                                        <ul id="divmenu<?php echo $key; ?>">
                                            <?php foreach ($dataAtt['sub_attibutes'] as $dataSubAtt) { ?>
                                                <li ><a href="<?php echo base_url() ?>home/shop/<?php echo $dataAtt['id'] ?>/<?php echo $dataSubAtt['p_sub_category_id'] ?>"><?php echo $dataSubAtt['attrubute_value']; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        <?php } ?>

                    </ul>

                </div>
                <!-- .kopa-product-categories-widget -->

                <!--                <div class="widget kopa-product-list-widget">
                                    <div class="widget-title title-s2   ">
                                        <h3>Best Sellers</h3>
                                    </div>
                                    <div class="widget-content">
                                        <ul>
                                            <li class="product-item">                                    
                                                <a href="#" class="product-thumb"><img src="http://placehold.it/90x80" alt="" /></a>
                                                <div class="product-caption">
                                                    <h4 class="product-title"><a href="#">Lamborghini AventadorJ</a></h4> 
                                                    <div class="price-info">
                                                        <span class="old-price">$40,000</span>
                                                        <span class="new-price">$39,800</span>
                                                    </div> 
                                                </div>  
                                            </li>
                                            <li class="product-item">                                    
                                                <a href="#" class="product-thumb"><img src="http://placehold.it/90x80" alt="" /></a>
                                                <div class="product-caption">
                                                    <h4 class="product-title"><a href="#">Lamborghini AventadorJ</a></h4>
                                                    <div class="price-info">
                                                        <span class="old-price">$40,000</span>
                                                        <span class="new-price">$39,800</span>
                                                    </div> 
                                                </div>  
                                            </li>
                                            <li class="product-item">                                    
                                                <a href="#" class="product-thumb"><img src="http://placehold.it/90x80" alt="" /></a>
                                                <div class="product-caption">
                                                    <h4 class="product-title"><a href="#">Lamborghini AventadorJ</a></h4>
                                                    <div class="price-info">
                                                        <span class="old-price">$40,000</span>
                                                        <span class="new-price">$39,800</span>
                                                    </div> 
                                                </div>  
                                            </li>
                                        </ul>
                                    </div>
                                </div>-->
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
            <!-- sidebar -->

        </div>
        <!-- row -->

    </div>   
    <!-- container -->    

</div>
<!-- main content -->

<script>
    $(document).ready(function () {
        $('#enquiry').click(function () {
            var dataS = {
                'product_name': $('#productname').val(),
                'product_id': $('#product_id').val(),
                'name': $('#inquire_name').val(),
                'phone': $('#inquire_phone').val(),
                'email': $('#inquire_email').val(),
//            'subject': $('#subject').val(),
                'message': $('#inquire_message').val()

            };
            //console.log(dataS);
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if ($('#inquire_name').val() == '')
            {
                $.toaster({priority: 'danger', title: 'Notification', message: 'Enter Name'});
                $('#inquire_name').focus();
                return false;
            } else if ($('#inquire_email').val() == '')
            {
                $.toaster({priority: 'danger', title: 'Notification', message: 'Enter Email'});
                $('#inquire_email').focus();
                return false;
            } else if (!re.test($('#inquire_email').val()))
            {
                $.toaster({priority: 'danger', title: 'Notification', message: 'Enter valid email'});
                $('#inquire_email').focus();
                return false;
            } else if ($('#inquire_phone').val() == '')
            {
                $.toaster({priority: 'danger', title: 'Notification', message: 'Enter Phone'});
                $('#inquire_phone').focus();
                return false;
            } else if ($('#inquire_message').val() == '')
            {
                $.toaster({priority: 'danger', title: 'Notification', message: 'Enter Message'});
                $('#inquire_message').focus();
                return false;
            } else
            {
                $.ajax(
                        {
                            url: '<?php echo base_url() ?>home/product_enquiry/enquiry',
                            type: "POST",
                            data: dataS,
                            success: function (data)
                            {
//                            console.log(data);  //data: return data from server
                                if (data)
                                {
                                    $.toaster({priority: 'success', title: 'Inquiry', message: 'Inquiry has been submited.'});
//                                    $('#msg').html('Message has been send successfully...!');
                                    $('#inquire_name').val('');
                                    $('#inquire_phone').val('');
                                    $('#inquire_email').val('');
                                    $('#inquire_message').val('');

                                }
                            }

                        });
            }
        });
    });
</script>
<script>

//    $(document).ready(function () {
//        
//    });
// Example of adding a item to the cart via a link.
    function funAddToCartRelated(id)
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
    function searchFilterRel(page_num) {
        $('.loader').show();
//        $('html, body').animate({
//                    scrollTop: $(".kopa-area").offset().top
//                }, 200);
        page_num = page_num ? page_num : 0;
        var keywords = 'related_product';
        var sortBy = $('#sortBy').val();
        var category_id = $('#category_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/ajaxPaginationData/' + page_num,
            data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy + '&product_category=' + category_id,
            beforeSend: function () {
                $('.loading').show();
                $('.ajax-view-product-related').html('');
            },
            success: function (html) {
                
                $('.ajax-view-product-related').show();
                $('.ajax-view-product-related').html('');
                $('.widget-title').show();
                $('.ajax-view-product-related').html(html);

                $('.loading').fadeOut("slow");
            }
        });
    }
</script>
