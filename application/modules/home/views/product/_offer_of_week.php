<div class="owl-carousel owl-week-offer">
    <?php if (isset($product_offer_details) && $product_offer_details != '') { ?>
        <?php foreach ($product_offer_details as $key => $odata) { ?>
            <div class="offer-item">    
                <div class="tab-content offer-review">
                    <div class="tab-pane fade in active review-item" id="tab4-1">
                        <div class="product-thumb">
                            <img src="<?php echo base_url() ?>assets/placeholders/car/product-review-660-360-2.jpg" alt="" />
                            <div class="caption">
                                <h6 class="product-title"><a href="#"><span><?php echo isset($product_make[$odata['make_id']]) ? $product_make[$odata['make_id']] : ''; ?></span>
                                        <br>                                     
                                        <?php echo isset($product_model[$odata['model_id']]) ? $product_model[$odata['model_id']] : ''; ?> 
                                    </a></h6>
                                <span class="date-info">

                                    <span class="day-info"><span>$</span><?php echo $odata['price']; ?></span>
                                    <span class="month-info"><?php echo $odata['category_name']['name']; ?> </span>
                                </span>
                            </div>
                            <span class="corner"></span>
                        </div>

                        <p class="product-intro"><?php echo $odata['category_name']['description']; ?></p>
                        <div class="view-more">  
                            <span class="bg-1"></span>              
                            <span class="bg-2"></span>
                            <span class="bg-3"></span>
                            <a href="<?php echo base_url(); ?>home/shop/<?php echo $odata['category_id']; ?>" class="link">read more</a>                  
                        </div> 
                    </div>
                   
                </div>
                <!-- tab-content -->                              
                <ul class="nav nav-tabs offer-tabs">
                    <?php if (isset($odata['offer_product_thumb']) && !empty($odata['offer_product_thumb'])) { ?>
                        <?php foreach ($odata['offer_product_thumb'] as $key => $thumbData) { ?>
                            <li class="active">
                                <a href="#tab4-<?php echo $key ?>" data-toggle="tab" class="review-thumb image-wrapper">
                                    <img class="image" src="<?php echo base_url() . $thumbData['url'] ?>" alt=""/>
                                    <span class="mask"></span>
                                </a>                                   
                                <div class="meta-box">
                                    <h6 class="product-title"><a href="<?php echo base_url() . 'home/shop_product/' . $thumbData['id'] . '/' . $thumbData['category_id'] ?>" data-toggle="tab"><?php echo $thumbData['product_name'] ?></a> </h6>
                                    <footer>
                                        <?php if (isset($thumbData['discounted_price']) && !empty($thumbData['discounted_price'])) { ?>
                                            <strike><span class="old-price">$<?php echo $thumbData['price'] ?></span></strike>
                                            <span class="new-price">$<?php echo floatval($thumbData['price']) - floatval($thumbData['discounted_price']) ?></span>

                                        <?php } else { ?>
                                            <span class="new-price">$<?php echo $thumbData['price'] ?></span>
                                        <?php } ?>
                                        <span class="kopa-rating">
                                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                                <?php if ($i < $thumbData['review_total']) { ?>
                                                    <span class="fa fa-star"></span>                                   
                                                <?php } else { ?>
                                                    <span class="fa fa-star-o"></span>
                                                <?php } ?>
                                            <?php } ?>

                                        </span>
                                    </footer>
                                </div>
                            </li>
                        <?php } ?>
                        <li class="view-all-offers"><a href="<?php echo base_url(); ?>home/shop/<?php echo $odata['category_id']; ?>" class="view-all">View all New products OFFER OF THE WEEK</a></li>  
                        <?php } ?>
                </ul>
                <!-- nav-tabs -->          
            </div>
        <?php } ?>
    <?php } ?>
</div>