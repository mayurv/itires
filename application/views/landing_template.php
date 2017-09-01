<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title><?php echo $this->config->item('website_name'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="shortcut icon" href="<?php // echo base_url('assets/images/favicon.png')          ?>" type="image/x-icon" />    <!-- Favicon -->

        <!-- CORE CSS Bootstrap FRAMEWORK - START -->

        <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/superfish.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/owl.carousel.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/owl.theme.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/slick.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/slick-theme.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/jquery.navgoco.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/rating.css'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/vendor/custom-scrollbar/jquery.mCustomScrollbar.min.css'); ?>" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css"/>        
        <script src="<?php echo base_url('assets/js/modernizr.custom.js'); ?>"></script>

        <link href="<?php echo base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon" type="text/css"/>
        <link href="<?php echo base_url('assets/img/apple-touch-icon-72x72.png'); ?>" rel="apple-touch-icon" type="text/css"/>
        <link href="<?php echo base_url('img/apple-touch-icon-114x114.png'); ?>" rel="apple-touch-icon" type="text/css"/>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="kopa-home">

        <header id="kopa-page-header" class="hidden-print">
            {header}
        </header> 


        <!--Main Content Here-->
        <div id="main-content" class="our_services "> 
            {content}
        </div>
        <!--Main Content Here-->

        <div class="above-bottom-sidebar hidden-print">  
            {ab_btm_sidebar}
        </div>

        <div id="bottom-sidebar" class="hidden-print">
            {btm_sidebar}
        </div>

        <footer id="kopa-page-footer" class="hidden-print">
            {footer}
        </footer>

        <?php $this->load->view('_modal_filter'); ?>
        <?php $this->load->view('_modal_filter_view_vehicle'); ?>

        <!-- CORE JS Jquery Validation - START -->
        <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script> 
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>" type="text/javascript"></script> 
        <script src="<?php echo base_url() ?>assets/js/jquery.toaster.js" charset="utf-8"></script>
        <script src="<?php echo base_url() ?>assets/js/slick.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/product.js" charset="utf-8"></script>
        <script src="<?php echo base_url() ?>assets/js/rating.js"></script>
        <script src="<?php echo base_url('assets/vendor/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js'); ?>" charset="utf-8"></script>
        <script src="<?php echo base_url() ?>assets/js/custom.js" charset="utf-8"></script>
    </body>

</html>