<div class="wrapper clearfix">                        
    <p class="copyright">&copy; Copyright 2015. iTiresOnline By Rebelute Digital</p>       
    <nav id="footer-nav">                        
        <!--        <ul id="footer-menu">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Wishlist</a></li>
                    <li><a href="#">My Cart</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">Log In</a></li>
                </ul>-->
        <ul id="footer-menu">
            <?php if ($this->ion_auth->logged_in()) { ?>
                <li><a href="<?php echo base_url() ?>home/orders">My Account</a></li>
            <?php } else { ?>
                <li><a href="<?php echo base_url() ?>auth/login">My Account</a></li>
            <?php } ?>
            <!--<li><a href="#">Wishlist</a></li>-->
            <li><a href="<?php echo base_url() ?>home/cart">My Cart</a></li>
            <li><a href="<?php echo base_url(); ?>home/checkout">Checkout</a></li>
            <?php if (!$this->ion_auth->logged_in()) { ?>
                <li><a href="<?php echo base_url(); ?>auth/login">Log In</a></li>
            <?php } else { ?>
                <li><a href="<?php echo base_url(); ?>auth/logout">Log Out</a></li>
            <?php } ?>

        </ul>
        <select id="footer-responsive-menu">
            <?php if ($this->ion_auth->logged_in()) { ?>
                <option value="<?php echo base_url() ?>home/orders">My Account</option>
            <?php } else { ?>
                <option value="#">My Account</option>
            <?php } ?>
            <option value="#">My Account</option>
            <option value="#">My Cart</option>
            <option value="#">Checkout</option>
            <?php if (!$this->ion_auth->logged_in()) { ?>
                <option value="<?php echo base_url() ?>auth/login">Log In</option>

            <?php } else { ?>
                <!--<option value="#">Log In</option>-->
            <?php } ?>


        </select>
    </nav>  
</div>
<div class="back-to-top"><span>Back to top</span><i class="fa fa-chevron-up"></i></div> 