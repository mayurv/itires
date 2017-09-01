<div id="kopa-top-page">        
    <div class="top-page-above">
        <div class="mask"></div>            
        <!--        <div class="page-title">
                    <h1>About Us</h1>  
                    <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
                </div> -->
        <?= $about_section[0]['page_content'] ?>

<!--        <div class="kopa-breadcrumb clearfix">
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a itemprop="url" href="index-2.html">
                    <span itemprop="title">Home</span>
                </a>
            </span>                    
            <span>&nbsp;&rsaquo;&nbsp;</span>
            <span class="current-page" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">About Us</span></span>
            <span class="bottom-line"></span>
        </div>  -->
    </div>  
    <!-- top page above -->

    <!-- top page bottom -->
</div>
<!-- kopa top page -->
<?= $about_section[1]['page_content'] ?>
<!--<div id="main-content" class="pt-40">
    <div class="container">
        <div class="row border_bottom_padding">
            <div id="" class="kopa-about-page"> 

                <div class="about-content">

                    <div class="about_itireonline">
                        <div class="col-md-4 about_side_img">
                            <img src="<?php echo base_url(); ?>assets/img/About_side_Image.jpg">
                        </div>
                        <div class="col-md-8 top_spacing_div">
                            <div class="widget-title title-s3">                        
                                <h3>COMPLETELY FREE</h3>

                                <span class="red-bg"></span>
                            </div> 

                            <h2 class="header_about">TIRE ROAD <span>HAZARD</span> PROTECTION. </h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>


                        </div>

                    </div>



                </div>
                 main column 


                 sidebar 

            </div>
             row 

        </div>   


         container     

    </div>
</div>-->
<?= $about_section[2]['page_content'] ?>

<!--<div id="main-content" class="widget itiresonline_discription">

    <div class="widget-top">
        <div class="widget-title title-s3">                        
            <h3>About iTiresOnline</h3>
            <span class="red-bg"></span>
        </div>                    
        <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
    </div> 

    <div class="background_color_grey">
        <div class="container">


            <div class="row ">



                <div class="col-md-6 discription_left_text">
                    <h6>A bit of iTiresOnline History...</h6>
                    <p>Auto Traderis a professional publisher who is </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum. Etiam at risus et justo dignissim congue. Donec congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus. In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor. Nulla facilisi dolor sit amet absidum felisiti.</p>
                </div>
                <div class="col-md-6 discription_side_img">
                    <img src="<?php echo base_url(); ?>assets/placeholders/post-image/About-us.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="featured_product_about">
    <div class="widget kopa-features-widget">  
        <!--        <div class="widget-top">
                    <div class="widget-title title-s3">                        
                        <h3>Featured Product</h3>
                        <span class="red-bg"></span>
                    </div>                    
                    <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
                </div>  -->
        <?= $about_section[3]['page_content'] ?>
        <?php $this->load->view('product/_feature_products'); ?>        
    </div>
</div>


<div class="widget kopa-clients-widget">
    <?= $about_section[4]['page_content'] ?>
</div>


<!-- main content -->

