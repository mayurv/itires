<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $page_title; ?></h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>All Orders</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php if (isset($all_orders) && !empty($all_orders)) { ?>

                        <?php // if (isset($cart_items) && !empty($cart_items)) {    ?>
                        <div class="table-responsive">    


                            <?php
//                        echo form_open('home/update_cart', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate', 'method' => 'post'));
                            ?>
                            <table class="table table-hover cartTable">
                                <thead>
                                    <tr>
                                        <th >Order ID</th>
                                        <!--<th>Product Name</th>-->
                                        <th >Quantity</th>
                                        <!--<th class="text-center" width="100">Unit Price</th>-->
                                        <th >Total</th>
                                        <th >Order Date</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach ($all_orders as $sid => $odata) { ?>
                                        <tr>
                    <!--                                <td width="10%">
                                                <img class="img-responsive" src="<?php echo base_url() . $odata['url'] ?>"> 
                                            </td>-->
                                            <td>
                                                <a href="<?php echo base_url() ?>admin_library/all_order_details/<?php echo $odata['ord_order_number']; ?>">
                                                    #<?php echo $odata['ord_order_number'] ?>
                                                </a>
                                            </td>
                                            <!--<td width="50%">-->
                    <!--                                    <p>
                                                    
            
                                                </p>
                                                <p>
                                                    <a href="<?php // echo base_url() . 'home/shop_product/' . $odata['id'] . '/' . $odata['category_id']    ?>" title="<?php echo $odata['product_name'] ?>">
                                            <?php // echo $odata['product_name'] ?>
                                                    </a>
                                                </p>
                                                <p><?php // echo $product_make[$odata['make_id']]    ?> |
                                            <?php // echo $product_model[$odata['model_id']]; ?> |
                                            <?php // echo $product_year[$odata['year_id']]; ?></p>-->
                                            <!--</td>-->
                                            <td><?php echo floatval($odata['ord_total_rows']) ?></td>
                                            <!--<td>$<?php // echo ($odata['ord_det_price'])    ?></td>-->
                                            <td>$<?php echo ($odata['ord_total']) ?></td>
                                            <td>
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
        </div>
    </div>
</div>

