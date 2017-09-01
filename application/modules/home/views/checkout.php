<?php $status = '' ?>
<?php $Astatus = '' ?>
<!--<div id="kopa-top-page">        
    <div class="top-page-above">
        <div class="mask"></div>            
        <div class="page-title">
            <h1>Checkout</h1>  
            <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
        </div> 
    </div>  
     top page above 
</div>-->
<!-- kopa top page -->

<div class="kopa-shop-product-page pt-40 mb-40 checkOutSteps">
    <div class="container">
        <div class="row">
            <div id="main-col" class="col-md-9">    
                <div class="kopa-tab-1">              
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php if ($this->uri->segment(3) == 'success' || $this->uri->segment(3) == 'cancel') { ?>
                            <li role="presentation" class="member_details disabled"><a aria-controls="memberDetails" role="tab"><i class="fa fa-edit"></i> Member Details</a></li>

                            <?php
                            $status = "active";
                        } else {
                            ?>
                            <li role="presentation" class="member_details active"><a aria-controls="memberDetails" role="tab"><i class="fa fa-edit"></i> Member Details</a></li>
                            <?php
                            $Astatus = "active";
                        }
                        ?>
                        <li role="presentation" class="payment_details disabled"><a aria-controls="payment" role="tab"><i class="fa fa-money"></i> Payment</a></li>
                        <?php if ($this->uri->segment(3) == 'success' || $this->uri->segment(3) == 'cancel') { ?>
                            <li role="presentation" class="status_details active"><a aria-controls="status" role="tab"><i class="fa fa-check"></i> Status</a></li>
                        <?php } else { ?>
                            <li role="presentation" class="status_details disabled"><a aria-controls="status" role="tab"><i class="fa fa-check"></i> Status</a></li>
                        <?php } ?>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content mb-40">
                        <div role="tabpanel" class="tab-pane member_details <?php echo $Astatus ?>" id="memberDetails">
                            <form id="memberDetailsForm" role="form" action="" method="post" novalidate="novalidate">
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <h4>STEP #1: Tell us about yourself</h4>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <?php echo form_label(lang('first_name'), 'first_name', array('for' => 'first_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                        <?php
                                        echo form_input(array(
                                            'type' => 'text',
                                            'id' => 'first_name',
                                            'name' => 'first_name',
                                            'placeholder' => 'Last Name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('first_name', $dataHeader['first_name'])
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <?php echo form_label(lang('last_name'), 'last_name', array('for' => 'last_name', 'class' => 'control-label col-md-3 col-sm-3 col-xs-12')); ?>
                                        <?php
                                        echo form_input(array(
                                            'type' => 'text',
                                            'id' => 'last_name',
                                            'name' => 'last_name',
                                            'placeholder' => 'Last Name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('last_name', $dataHeader['last_name'])
                                        ));
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Country code</label>
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'billing_country1',
                                            'name' => 'billing_country',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'class' => 'form-control'
                                                ), $country_list
                                        );
                                        ?>

                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>Phone Number</label>
                                        <?php
                                        echo form_input(array(
                                            'type' => 'number',
                                            'id' => 'phone',
                                            'name' => 'phone',
                                            'placeholder' => 'Phone',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('phone', $dataHeader['phone'])
                                        ));
                                        ?>
                                        <!--<input name="phone" class="form-control" id="phone" required="required" type="text" maxlength="10" onkeydown="return isNumberKey(event);" placeholder="Phone Number" value="">-->
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Email</label>
                                        <?php
                                        echo form_input(array(
                                            'type' => 'email',
                                            'id' => 'email',
                                            'name' => 'email',
                                            'placeholder' => 'Last Name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'value' => set_value('email', $dataHeader['email'])
                                        ));
                                        ?>
                                    </div>

                                    <?php if (!$this->ion_auth->logged_in()) { ?>
                                        <div class="col-sm-6 form-group">
                                            <label>Password</label>
                                            <input name="password" id="password" class="form-control" required="required" type="password" placeholder="Password" >
                                        </div>
                                    <?php } ?>

                                </div>
                                <?php if (!$this->ion_auth->logged_in()) { ?>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Confirm Password</label>
                                            <input name="confirmpassword" id="confirmpassword" class="form-control" required="required" type="password" placeholder="Confirm Password" >
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <hr>
                                        <h4>STEP #2: Billing Address</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Address</label>
                                        <input name="address" class="form-control" id="billing_address" required="required" type="text" placeholder="Address" value="">
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>City</label>
                                        <input name="billing_city" class="form-control" id="billing_city" required="required" type="text" placeholder="City" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Country</label>

                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'billing_country',
                                            'name' => 'billing_country',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'class' => 'form-control'
                                                ), $country_list
                                        );
                                        ?>


                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label>State</label>
                                        <?php
                                        echo form_dropdown(array(
                                            'id' => 'billing_state',
                                            'name' => 'billing_state',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled'
                                                ), $state_list
                                        );
                                        ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label>Zip</label>
                                        <input name="zip" class="form-control" id="billing_zip" required="required" type="text" onkeydown="return isNumberKey(event);" placeholder="Zip" value="">
                                    </div>
                                </div>
                                <ul class="list-inline">
                                    <li><button type="submit" class="btn kopaBtn" >Next</button></li>
                                </ul>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane payment_details" id="payment">
                            <div class="row">
                                <form id="paymentDetailsForm" role="form" action="" method="post" novalidate="novalidate" class="">
                                    <div class="col-sm-12 form-group">
                                        <h4>STEP #3: Enter payment details</h4>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <ul class="list-inline">
                                            <li>
                                                <label class="radio-inline">
                                                    <input type="radio" id="id_visa" name="paymentOption" data-payment-type="card" class="paymentOpt" checked> 
                                                    <img src="<?php echo base_url() ?>assets/images/visa.png" width="40">
                                                    <img src="<?php echo base_url() ?>assets/images/mastercard.png" width="40">
                                                    <img src="<?php echo base_url() ?>assets/images/american-express.png" width="40">
                                                    <img src="<?php echo base_url() ?>assets/images/discover.png" width="40">
                                                </label>
                                            </li>
                                            <li>
                                                <label class="radio-inline">
                                                    <input type="radio" id="id_paypal" name="paymentOption" data-payment-type="paypal" class="paymentOpt">
                                                    <img src="<?php echo base_url() ?>assets/images/paypal.png" width="40">
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6 form-group creaditCardInfo">
                                        <label>Card Number</label>
                                        <input name="credit_number" id="credit_number" class="form-control"  size="20" data-stripe="number" required="required" type="number" onkeydown="return isNumberKey(event);" placeholder="Card Number">
                                    </div>
                                    <div class="col-sm-6 form-group securityCode creaditCardInfo">
                                        <label>Security Code 
                                            <span data-toggle="popover" data-trigger="hover" data-html="true" title="CVV" data-content="
                                                  <p>Your card code is a 3 or 4 digit number that is found in these locations:</p>
                                                  <div class='clearfix'>
                                                  <div class='contents'>
                                                  <p><strong>Visa/Mastercard</strong></p>
                                                  <p>The security code is a 3 digit number on the back of your credit card. It immediately follows your main card number.</p>
                                                  <p><strong>American Express</strong></p>
                                                  <p>The security code is a 4 digit number on the front of your card, just above and to the right of your main card number.</p>
                                                  </div>
                                                  <div class='imgBlock'>
                                                  <img src='<?php echo base_url() ?>assets/images/cvv.png' class=''>
                                                  </div>
                                                  </div>
                                                  ">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        </label>
                                        <input name="security_code" class="form-control" id="cvc" required="required" type="text" data-stripe="cvc" onkeydown="return isNumberKey(event);" placeholder="Security Code">
                                    </div>
                                    <div class="col-sm-6 form-group creaditCardInfo">
                                        <label>Expiration Date</label>
                                        <input name="exp_month" size="2" data-stripe="exp_month" id="exp_month" class="form-control" required="required" type="text" placeholder="MM">
                                        <input name="exp_year" size="2" data-stripe="exp_year" id="exp_year" class="form-control" required="required" type="text" placeholder="YY">
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="terms" checked> I accept <a href="" target="_blank">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <span id="paystatus"></span>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="text-center">

                                            <a class="btn kopaBtn paypal-btn" style="display:none" href="<?php echo base_url() . 'home/buy/'; ?>">Place Order</a>
                                            <button type="submit" class="btn kopaBtn strip-btn" >Place Order</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ul class="list-inline">
                                <li>
                                    <form method="POST" action="http://localhost/RPDigitel/frontend/multi_plan_checkout/SetExpressCheckout">

                                        <div class="center padding-bottom-25">
                                            <input type="hidden" value="" name="amount">
                                            <input type="hidden" value="1" name="plan_id">
                                            <input type="hidden" value="" name="user_id">

                                            <input type="hidden" value="http://localhost/RPDigitel/subscription" name="success_url">

                                            <input type="hidden" value="http://localhost/RPDigitel/subscription" name="fail_url">

                                            <input type="submit" class="btn kopaBtn" value="Submit">

                                        </div>

                                    </form>

                                </li>

                            </ul>

                        </div>

                        <div role="tabpanel" class="tab-pane status_details <?php echo $status ?>" id="status" >
                            <?php if ($this->uri->segment(3) == 'success') { ?>
                                <?php $this->load->view('product/success'); ?>
                            <?php } ?>
                            <?php if ($this->uri->segment(3) == 'cancel') { ?>
                                <?php $this->load->view('product/cancel'); ?>
                            <?php } ?>
                            <!-- <ul class="list-inline">
                                <li><button type="button" class="btn btnRed prev-step">Previous</button></li>
                            </ul> -->
                        </div>
                    </div>
                </div>  
            </div>
            <!-- main column -->

            <div id="sidebar" class="col-md-3">  
                <div class="widget kopa-product-list-widget checkoutOrderWrap">
                    <div class="widget-title title-s2">
                        <h3>ORDER SUMMARY</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table checkoutOrdertable">
                            <tbody>
                                <?php //  echo '<pre>', print_r($discounts);die;   ?>
                                <tr>
                                    <th>Subtotal<span class="text-danger"> (<?php echo!empty($cart_summary['total_items']) ? $cart_summary['total_items'] : '0' ?> items) </span></th>
                                    <td class="text-right">$<?php
                                        if (!empty($discounts['total']['value'])) {
                                            echo ($cart_summary['item_summary_total']) - str_replace('US $', ' ', $discounts['total']['value']);
                                        } else {
                                            echo ($cart_summary['item_summary_total']);
                                        }


//                                    echo!empty($cart_summary['item_summary_total']) 
//                                    ? $cart_summary['item_summary_total']-str_replace('US $', ' ', $discounts['total']['value']) : '0' 
                                        ?> </td>
                                </tr>
<!--                                <tr>
                                    <th>Shipping</th>
                                    <td class="text-right">$<?php echo!empty($cart_summary['shipping_total']) ? $cart_summary['shipping_total'] : '0' ?></td>
                                </tr>
                                <tr>
                                    <th>Estimated Tax</th>
                                    <td class="text-right">$<?php echo!empty($cart_summary['tax_total']) ? round($cart_summary['tax_total']) : '0' ?></td>
                                </tr>-->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Price:</th>
                                    <td class="text-right">$<?php
                                        if (!empty($discounts['total']['value'])) {
                                            echo ($cart_summary['item_summary_total']) - str_replace('US $', ' ', $discounts['total']['value']);
                                        } else {
                                            echo ($cart_summary['item_summary_total']);
                                        }
                                        ?>
                                    </td>
                                    <!--<td class="text-right">$<?php // echo ($cart_summary['shipping_total']) + round($cart_summary['tax_total']) + ($cart_summary['total'])                                            ?></td>-->
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                <!-- kopa product list widget -->
            </div>
            <!-- sidebar -->

        </div>
        <!-- row -->
    </div>   
    <!-- container -->    
</div>
<!-- main content -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
                                            $(document).ready(function () {


                                                $('#id_paypal').click(function () {

                                                    $('.paypal-btn').show();
                                                    $('.strip-btn').hide();
                                                });
                                                $('#id_visa').click(function () {

                                                    $('.strip-btn').show();
                                                    $('.paypal-btn').hide();
                                                });
                                                $('select[id="billing_country"]').change(function () {
                                                    $('select[id="billing_state"]').prop("disabled", false);
                                                    var country_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>home/getStateList',
                                                        data: {'country_id': country_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="billing_state"]').html(data.content).trigger('liszt:updated').val(country_id);
                                                            }
                                                        }
                                                    });
                                                });

                                                $('select[name="state_id"]').change(function () {
                                                    var state_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>employee/getCityList',
                                                        data: {'state_id': state_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="city_id"]').html(data.content).trigger('liszt:updated').val(state_id);
                                                            }
                                                        }
                                                    });
                                                });

                                                $('select[name="c_country_id"]').change(function () {
                                                    var country_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>employee/getStateList',
                                                        data: {'country_id': country_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="c_state_id"]').html(data.content).trigger('liszt:updated').val(country_id);
                                                            }
                                                        }
                                                    });
                                                });
                                                $('select[name="c_state_id"]').change(function () {
                                                    var state_id = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url(); ?>employee/getCityList',
                                                        data: {'state_id': state_id},
                                                        success: function (data) {
                                                            if (data) {
                                                                $('select[name="c_city_id"]').html(data.content).trigger('liszt:updated').val(state_id);
                                                            }
                                                        }
                                                    });
                                                });
                                            });


</script>