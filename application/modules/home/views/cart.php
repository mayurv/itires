<?php // echo '<pre>',print_r($cart_items);?>
<?php // echo '<pre>',print_r($discounts);?>
<?php // echo '<pre>',print_r($this->flexi_cart->item_summary_savings_total());die();?>
<link href="<?php echo base_url() ?>assets/frontend/login_modal.css" rel="stylesheet">

<div id="kopa-top-page">        
    <div class="top-page-above">
        <div class="mask"></div>            
        <div class="page-title">
            <h1>Shopping Cart</h1>  
            <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
        </div> 
    </div>  
    <!-- top page above -->
</div>
<!-- kopa top page -->

<div class="shoppingCartWrap pt-40 mb-40">
    <div class="container">
        <div class="row">
            <div class="col-md-9"> 
                <?php if (isset($cart_items) && !empty($cart_items)) { ?>
                    <div>
                        <a href="<?php echo base_url() ?>home/clear_cart_all" class="pull-right btn btn-xs btn-danger" title="Empty | Clear your cart" ><i class="fa fa-shopping-cart"> </i> Empty </a>

                    </div>
                <div class="clearfix"></div>
                    <?php // if (isset($cart_items) && !empty($cart_items)) { ?>
                    <div class="table-responsive">    


                        <?php
                        echo form_open('home/update_cart', array('id' => 'form_filter_product', 'class' => ' ', 'data-parsley-validate', 'method' => 'post'));
                        ?>
                        <table class="table table-hover cartTable">
                            <thead>
                                <tr>
                                    <th width="100">Image</th>
                                    <th>Product Name</th>
                                    <th width="75">Quantity</th>
                                    <th class="text-center" width="100">Unit Price</th>
                                    <th class="text-center" width="100">Total</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php // echo '<pre>',print_r($cart_items);die; ?>

                                <?php foreach ($cart_items as $sid => $cData) { ?>
                                    <tr>
                                        <td>
                                            <img class="img-responsive" src="<?php echo base_url() . $cData['item_url'] ?>"> 
                                        </td>
                                        <td>
                                            <?php echo $cData['stock_quantity'] > 1 ? 'In Stock' : '' ?>
                                            <a href="<?php echo base_url() . 'home/shop_product/' . $cData['id'] . '/'.$cData['category_id'] ?>" class="h5"><?php echo $cData['name'] ?></a>
                                            <p class="text-success"><?php echo $cData['stock_quantity'] > 1 ? 'In Stock' : '' ?></p>
                                            <!--<span>Status: </span>-->
                                            <!--<strong class="text-success">In Stock</strong>-->
                                        </td>
                                        <td class="text-center">
                                            <input type="number" name="quantity_<?php echo $cData['id']; ?>" class="form-control" id="" value="<?php echo $cData['quantity'] ?>" min="1" required="">
                                            <input hidden value="<?php echo $sid; ?>" id="session_id" name="session_id_<?php echo $cData['id']; ?>">
                                            <input hidden value="<?php echo $cData['id']; ?>" id="item_id" name="item_id[]" >
                                        </td>
                                        <td class="text-center"><strong>$<?php echo $cData['internal_price'] ?></strong></td>
                                        <td class="text-center"><strong>$<?php echo (floatval($cData['internal_price']) * floatval($cData['quantity'])) ?> </strong></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="funDeleteCartProduct('<?php echo $sid; ?>');">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <?php foreach ($discounts as $discount) { ?>
                                    
                                        <tr>
                                            <td colspan="3">

                                                &raquo; <?php echo $discount['description']; ?>
                                            </td>
                                            <td colspan="2"><b><?php echo $discount['value']; ?></b></td>
                                            <td>
                                                <?php if (!empty($discount['id'])) { ?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>standard_library/unset_discount/<?php echo $discount['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                                <?php } ?>

                                            </td>

                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button  type="submit" class="pull-right btn btn-xs btn-primary" title="Update" ><i class="fa fa-shopping-cart"> </i> Update Cart </button>
                        <br>
                        <?php if (!empty($message)) { ?>
                            <div id="message">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <?php echo form_close(); ?>
                        <fieldset>
                            <?php echo form_open('standard_library/view_cart'); ?>
                            <?php ?>
                            <hr>
                            <h5>Discount / Reward Voucher Codes</h5>
    <!--							<small>Examples: 'FREE-UK-SHIPPING', '10-PERCENT', '10-FIXED-RATE'</small>-->


                            <?php
                            // Get an array of all discount codes. The returned array keys are 'id', 'code' and 'description'.
                            if ($discount_data = $this->flexi_cart->discount_codes()) {
                                foreach ($discount_data as $discount_codes) {
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input type="text" name="discount[<?php echo $discount_codes['code']; ?>]" value="<?php echo $discount_codes['code']; ?>"/> 
                                            <small class="inline">* <?php echo $discount_codes['description']; ?></small>
                                        </div>
                                        <div class="col-sm-1">
                                            <button  type="submit" name="update_discount" value="Update" class="btn btn-primary">Update</button>
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="submit" name="remove_discount_code[<?php echo $discount_codes['code']; ?>]" value="" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="discount[0]" class="form-control" value=""/>
                                </div>
                                <div class="col-sm-3 col-sm-offset-1">
                                    <input type="submit" class="link_button btn btn-success"  name="update_discount" value="Add Coupon Code">
                                </div>
                                <div class="col-sm-3">
                                    <input  type="submit" name="remove_all_discounts" class="link_button btn btn-success tooltip_trigger" title="Remove all discount codes and all manually set discounts." value="Remove all Coupons">
                                </div>
                            </div>  

            <!--							<a href="<?php echo $base_url; ?>lite_library/item_discount_examples">View item based discount examples</a>-->
                        </fieldset>
                    </div>                    
                    <?php echo form_close(); ?>
                <?php } else { ?>
                    <div class="text-center">
                        <p><i class="fa fa-5x fa-shopping-cart text-danger"></i></p>
                        <p>Your cart is empty</p>
                    </div>
                <?php } ?>
            </div>
            <div id="sidebar" class="col-md-4">
                <div class="widget kopa-product-list-widget checkoutOrderWrap">
                    <div class="widget-title title-s2">
                        <h3>ORDER SUMMARY</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table checkoutOrdertable">
                            <tbody>
                                <tr>

                                    <th>Subtotal<span class="text-danger"> (<?php echo!empty($cart_summary['total_items']) ? $cart_summary['total_items'] : '0' ?> items) </span></th>
                                    <td class="text-right"><b>$<?php
                                            if (!empty($cart_summary['item_summary_total'])) {
                                                if (!empty($discounts['total']['value'])) {
                                                    echo $cart_summary['item_summary_total'] - str_replace('US $', ' ', $discounts['total']['value']);
                                                } else {
                                                    echo $cart_summary['item_summary_total'];
                                                }
                                            }
                                            ?></b> 
                                        <?php //echo $cart_summary['total_items'] -$discounts['shipping_total']['value']; ?>
                                    </td>
                                </tr>
<!--                                <tr>
                                    <th>Shipping</th>
                                    <td class="text-right">Free</td>
                                </tr>-->
<!--                                <tr>
                                    <th>Estimated Tax</th>
                                    <td class="text-right">$24.59</td>
                                </tr>-->
                            </tbody>
                            <tfoot>
<!--                                <tr>
                                    <th>Total Price:</th>
                                    <td class="text-right">$50</td>
                                </tr>-->
                            </tfoot>
                        </table>
                        <div class="text-center">
                            <a href="<?php echo base_url(); ?>home/shop" class="btn kopaBtn">  
                                Continue Shopping      
                            </a><br><br>

                            <?php if ($this->ion_auth->logged_in() && !empty($cart_summary['total_items'])) { ?>
                                <a href="<?php echo base_url(); ?>home/checkout" class="btn kopaBtn">Checkout</a>
                            <?php } else { ?>
                                <a class="btn kopaBtn" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#myModal">Checkout</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>   
    <!-- container -->    
</div>

<!-- Large modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    x</button>
                <h4 class="modal-title" id="myModalLabel">
                    Login to continue</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span id="st_message"></span>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#Login" data-toggle="tab">Login</a></li>
                            <li><a href="#Registration" data-toggle="tab">Registration</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="Login">

                                <form  id="loginForm" method="post"  class="form-horizontal">
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">
                                            Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="username" required class="form-control" id="email1" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1" class="col-sm-2 control-label">
                                            Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password" required class="form-control" id="exampleInputPassword1" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn kopaBtn">
                                                Submit</button>
                                            <!--<a href="javascript:;">Forgot your password?</a>-->
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="Registration">
                                <form role="form" id="signupForm" class="form-horizontal">

                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">
                                            First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" required name="first_name" class="form-control" id="email" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">
                                            Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" required name="last_name" class="form-control" id="email" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">
                                            Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" required class="form-control" id="email" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-sm-2 control-label">
                                            Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="phone" required class="form-control" id="mobile" placeholder="Mobile" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">
                                            Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password" required class="form-control" id="password" placeholder="Password" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">
                                            Confirm Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password_confirm" class="form-control" id="password" placeholder="Password" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn kopaBtn">
                                                Register</button>
                                            <button type="button"  data-dismiss="modal" aria-hidden="true" class="btn kopaBtn">
                                                Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- main content -->
<script type="text/javascript">
    function funDeleteCartProduct(itemId) {
        //    var itemId = $(this).find('#item_session_id').val();
//        var itemId = $(this).closest('tbody tr input').next('').val();
        $.ajax(
                {
                    method: "POST",
                    data: {'item_id': itemId},
                    url: href = "<?php echo base_url(); ?>standard_library/delete_item/" + itemId,
                    success: function (data)
                    {
                        $.toaster({priority: 'danger', title: 'Cart', message: 'Item Remove from cart.'});

                    }
                }
        );
    }

    $(document).ready(function () {
        $("#loginForm").submit(function (e) {
            e.preventDefault();
            var datastring = $("#loginForm").serialize();
            $.ajax({
                url: base_url + 'auth/auth/ajaxLoginSubmit',
                data: datastring,
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status === '1') {
                        $("#st_message").html('<div class="alert alert-success"><strong>Success! </strong>' + response.msg + '</div>');
                        window.setTimeout(function () {
                            location.reload()
                        }, 3000);
                    } else {
                        $("#st_message").html('<div class="alert alert-danger"><strong>Fail! </strong>' + response.msg + '</div>');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
    $(document).ready(function () {
        $("#signupForm").submit(function (e) {
            e.preventDefault();
            var datastring = $("#signupForm").serialize();
            $.ajax({
                url: base_url + 'auth/auth/ajaxUserRegisterSubmit',
                data: datastring,
                type: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status === '1') {
                        $("#st_message").html('<div class="alert alert-success"><strong>Success! </strong>' + response.msg + '</div>');
                        window.setTimeout(function () {
                            location.reload()
                        }, 3000);
                    } else {
                        $("#st_message").html('<div class="alert alert-danger"><strong>Fail! </strong>' + response.msg + '</div>');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });
</script>

