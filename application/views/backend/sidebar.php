<div class="menu_section clearfix">
    <h3>ITTires management</h3>

    <ul class="nav side-menu">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>
        <?php if ($this->ion_auth->is_admin()) { ?>
            <li ><a><i class="fa fa-user"></i> Manage User <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>auth">All Users</a></li>
                    <li><a href="<?php echo base_url(); ?>auth/create_user">Create User</a></li>
                    <li><a href="<?php echo base_url(); ?>auth/create_group">Create Group</a></li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</div>
<?php if ($this->ion_auth->is_admin()) { ?>
    <div class="menu_section clearfix">
        <h3>Manage Product</h3>

        <ul class="nav side-menu">

            <li ><a href="#"><i class="fa fa-shopping-bag "></i> Products <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/product">Manage Products </a></li>
                    <li><a href="<?php echo base_url(); ?>admin_library/summary_discounts">Manage Coupon </a></li>
                    <li><a href="<?php echo base_url(); ?>admin/product_history">Manage Product History </a></li>
                    <!--<li><a href="<?php // echo base_url();    ?>admin/attirbutes">Product Level</a></li>-->
                </ul>
            </li>
            <li ><a href="<?php echo base_url(); ?>admin/orders"><i class="fa fa-shopping-bag "></i> Orders </a>

            </li>
           

            <li><a href="<?php echo base_url(); ?>admin/product_category"><i class="fa fa-tags"></i> Product Category </a>
<!--                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>master/diameter">Tire Diameter</a></li>
                </ul>-->
            </li>
            <li ><a><i class="fa fa-hashtag"></i> Manage Attributes <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/attirbutes">Category Level</a></li>
                    <!--<li><a href="<?php // echo base_url();    ?>admin/attirbutes">Product Level</a></li>-->
                </ul>
            </li>
            <li ><a><i class="fa fa-hashtag"></i> Master Tables <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>master/make">Add Make</a></li>
                    <li><a href="<?php echo base_url(); ?>master/year">Add Year</a></li>
                    <li><a href="<?php echo base_url(); ?>master/model">Add Model</a></li>
                    <!--<li><a href="<?php echo base_url(); ?>master/model">Add Tires Brand</a></li>-->
                    <!--<li><a href="<?php echo base_url(); ?>master/model">Add Wheel Brand</a></li>-->
                    <!--<li><a href="<?php echo base_url(); ?>master/model">Add Parts & Accessories Brand</a></li>-->

                </ul>
            </li>
            <li ><a><i class="fa fa-gift"></i> Manage Offers <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/offer">Offer of the week</a></li>
                </ul>
            </li>
            <li ><a><i class="fa fa-hashtag"></i> Blog Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/blog/category">Add Category</a></li>
                    <li><a href="<?php echo base_url(); ?>admin/blog">Add Blog</a></li>
                    <li><a href="<?php echo base_url(); ?>admin/testimonial/list">Add Testimonial</a></li><!--
                    <li><a href="<?php echo base_url(); ?>master/model">Add Model</a></li>-->
                </ul>
            </li>
            <li><a><i class="fa fa-hashtag"></i> CMS <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/section">Manage Section</a></li>
                    <li><a href="<?php echo base_url(); ?>admin/pages/page">Manage Page</a></li>
                </ul>
            </li>
             <li><a href="<?php echo base_url(); ?>admin/marketing-sender-list"><i class="fa fa-shopping-bag "></i> Marketing </a>

            </li>
 <li><a><i class="fa fa-hashtag"></i> Inquiry <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url(); ?>admin/inquiry">Product inquiry</a></li>
                    <li><a href="<?php echo base_url(); ?>admin/contact_info">Contact</a></li>
                </ul>
            </li>
        </ul>
    </div>
<?php } ?>