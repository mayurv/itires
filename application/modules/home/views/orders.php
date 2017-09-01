<?php // echo '<pre>', print_r($my_orders);die;    ?>
<div class="shoppingCartWrap pt-40 mb-40">
    <div class="container">
        <div class="row">

            <div class="col-md-8"> 
                <div class="widget-title title-s2">
                    <h3>MY ORDERS</h3>
                </div>
                <div class="widget-content">
                    <?php if (isset($my_orders) && !empty($my_orders)) { ?>

                        <?php // if (isset($cart_items) && !empty($cart_items)) {    ?>
                        <div class="table-responsive">    


                            <?php
//                        echo form_open('home/update_cart', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate', 'method' => 'post'));
                            ?>
                            <table class="table table-hover cartTable">
                                <thead>
                                    <tr>
                                        <th >Order id</th>
                                        <!--<th>Product Name</th>-->
                                        <th >Quantity</th>
                                        <!--<th class="text-center" width="100">Unit Price</th>-->
                                        <th >Total</th>
                                        <th >Order Date</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach ($my_orders as $sid => $odata) { ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo base_url() ?>admin_library/order_details/<?php echo $odata['ord_order_number']; ?>">
                                                    #<?php echo $odata['ord_order_number'] ?>
                                                </a>
                                            <!--<img class="img-responsive" src="<?php echo base_url() . $odata['url'] ?>">--> 
                                            </td>
        <!--                                            <td width="50%">
                                                <p>
                                                    

                                                </p>
                                                <p>
                                                    <a href="<?php echo base_url() . 'home/shop_product/' . $odata['id'] . '/' . $odata['category_id'] ?>" title="<?php echo $odata['product_name'] ?>">
                                            <?php echo $odata['product_name'] ?>
                                                    </a>
                                                </p>
                                                <p><?php echo $product_make[$odata['make_id']] ?> |
                                            <?php echo $product_model[$odata['model_id']]; ?> |
                                            <?php echo $product_year[$odata['year_id']]; ?></p>
                                            </td>-->
                                            <td><?php echo floatval($odata['ord_total_rows']) ?></td>
                                            <!--<td>$<?php // echo ($odata['ord_det_price'])     ?></td>-->
                                            <td>$<?php echo ($odata['ord_total']) ?></td>
                                            <td width="20%">
                                                <p><?php echo date('d F y', strtotime($odata['ord_date'])); ?>
                                                    <?php echo date('H:i A', strtotime($odata['ord_date'])); ?></p>
                                            </td>


                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php // echo form_close();    ?>

                        </div>
                    <?php } else { ?>
                        <div class="text-center">
                            <p><i class="fa fa-5x fa-shopping-cart text-danger"></i></p>
                            <p>Your cart is empty</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div id="sidebar" class="col-md-4">
                <div class="widget kopa-product-list-widget checkoutOrderWrap">
                    <div class="widget-title title-s2">
                        <h3>My Account</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table checkoutOrdertable">
                            <tr>
                                <td class="active">
                                    <a class="active">My Orders</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url(); ?>home/cart" >My Cart</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url(); ?>home/checkout">Checkout</a>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>   
    <!-- container -->    
</div>
<!-- main content -->
<div class="table-responsive">    


    <?php
//    echo form_open('home/update_cart', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate', 'method' => 'post'));
    ?>

    <button  type="submit" class="pull-right btn btn-xs btn-primary" title="Update" ><i class="fa fa-shopping-cart"> </i> Update Cart </button>
    <?php // echo form_close();    ?>

</div>