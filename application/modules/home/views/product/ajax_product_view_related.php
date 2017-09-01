<div class="product-list-1">
    <div class="row">
        <h2>
                    <span class="text-danger">(<?php echo $product_count ?>)</span>
                    SEARCH RESULT FOR 
                    <span class="text-danger"><?php echo $category_title ?></span>
                    
                </h2>
        <?php $i = 1; ?>
        <?php foreach ($product_details as $pk => $pkData) { ?>
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
<div class="clearfix"></div><br>