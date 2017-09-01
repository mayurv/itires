<div id="kopa-top-page">        
    <div class="top-page-above">
        <div class="mask"></div>            

        <div class="page-title shopPageTitle">
            <h1><?php echo $category_title ?></h1>    

            <p><?php echo $category_description ?> </p>                  
            <!-- <div class="kopa-breadcrumb clearfix">
                <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a itemprop="url" href="index-2.html">
                        <span itemprop="title">Home</span>
                    </a>
                </span>
                <span>&nbsp;&rsaquo;&nbsp;</span>
                <span class="current-page" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">Shop</span></span>
                <span class="bottom-line"></span>
            </div>  -->
        </div>  
        <!-- top page above -->
        <div class="wrapper selectprojectform shopSearchFilter">
            <?php $this->load->view('product/_filter_popup'); ?>
        </div>
        <div class="top-page-bottom clearfix">
            <div class="container">
                <!--                <div class="top-link">
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
                <a href="<?php echo base_url(); ?>home" class="pre-page">Back to Previous Page</a>
            </div>
        </div>    
        <!-- top page bottom -->
    </div>
    <!-- kopa top page -->

    <div id="main-content" class="kopa-shop-page pt-50">
        <div class="container">
            <div class="row">
                <!--Product div tab-->
                <div class="text-center pos-rel">
                    <div class="loader" hidden></div>
                </div>
                <?php if(isset($brand_id)){?>
                <input hidden="" value="<?php echo $brand_id ?>" id="product_sub_category">
                <?php }?>
                <?php echo $this->load->view('product/_products'); ?>
                <!--Product div tab-->
                <!-- main column -->

                <div id="sidebar" class="col-md-3">

                    <div class="widget kopa-product-categories-widget">

                        <div class="widget-title title-s2">
                            <h3>Categories</h3>
                        </div>



                        <ul id="menu_list" class="widget-content sf-menu sf-vertical">							
                            <?php if (isset($prodcut_cat_detail)) { ?>
                                <?php foreach ($prodcut_cat_detail as $key => $dataAtt) { ?>
                                    <li>
                                        <a href="<?php echo base_url() ?>home/shop/<?php echo $dataAtt['id'] ?>" title=""><?php echo $dataAtt['name']; ?></a>
                                        <div class="accordion-icon" data-target="menu<?php echo $key; ?>"></div>
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

                    <!--                    <div class="widget kopa-product-list-widget">
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
</div>

<script>
    function searchFilterProduct(page_num) {
        $('.loader').show();
//        $('html, body').animate({
//            scrollTop: $(".kopa-area").offset().top
//        }, 200);

        page_num = page_num ? page_num : 0;
        var keywords = 'by_product';
        var sortBy = $('#sortBy').val();
        var category_id = $('#category_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/ajaxPaginationData/' + page_num,
            data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy + '&product_category=' + category_id,
            beforeSend: function () {
                $('.loading').show();
                $('.product-list-1').html('');
            },
            success: function (html) {
                $('.loader').hide();
                $('.product-list-1').show();
                $('.product-list-1').html('');
                $('.kopa-pagination').html('');
                $('.widget-title').show();
                $('.product-list-1').html(html);

                $('.loading').fadeOut("slow");
            }
        });
    }
    function searchFilterSize(page_num) {
        $('.loader').show();
//        $('html, body').animate({
//            scrollTop: $(".kopa-area").offset().top
//        }, 200);
        page_num = page_num ? page_num : 0;
        var keywords = 'by_size';
        var sortBy = $('#sortBy').val();
        var category_id = $('#category_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/ajaxPaginationData/' + page_num,
            data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy + '&product_category=' + category_id,
            beforeSend: function () {
                $('.loading').show();
                $('.product-list-1').html('');
            },
            success: function (html) {
                $('.loader').hide();
                $('.product-list-1').show();
                $('.product-list-1').html('');
                $('.kopa-pagination').html('');
                $('.widget-title').show();
                $('.product-list-1').html(html);

                $('.loading').fadeOut("slow");
            }
        });
    }
    function searchFilterBrand(page_num) {
        $('.loader').show();
//        $('html, body').animate({
//            scrollTop: $(".kopa-area").offset().top
//        }, 200);

        page_num = page_num ? page_num : 0;
        var keywords = 'by_brand';
        var sortBy = $('#sortBy').val();
        var category_id = $('#category_id').val();
        var product_sub_category = $('#product_sub_category').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>home/ajaxPaginationData/' + page_num,
            data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy + '&product_category=' + category_id+'&product_sub_category='+product_sub_category,
            beforeSend: function () {
                $('.loading').show();
                $('.product-list-1').html('');
            },
            success: function (html) {
                $('.loader').hide();
                $('.product-list-1').show();
                $('.product-list-1').html('');
                $('.kopa-pagination').html('');
                $('.widget-title').show();
                $('.product-list-1').html(html);

                $('.loading').fadeOut("slow");
            }
        });
    }
</script>