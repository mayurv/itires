<div id="kopa-top-page">  
    <div class="top-page-above">            
<?php echo $ourservices_section[0]['page_content'];?>
    </div>  
    <!-- top page above -->
    <div class="top-page-bottom clearfix">
        <div class="container">
            <?php // echo $ourservices_section[1]['page_content'];?>
            <div class="widget kopa-services-widget">
<div class="container">
<!--<div class="widget-top">
<div class="widget-title title-s3">
<h3>check out our service</h3>
<span class="red-bg"></span></div>

<p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio</p>
</div>-->
 <?php echo $ourservices_section[1]['page_content'];?>
<div class="widget-content row">
    <?php if(isset($service_category)) foreach ($service_category as $service) {?>
        <div class="col-md-4 col-sm-6">
        <div class="item">
                <div class="service-thumb"><a href="#"><img alt="" src="<?php echo base_url() ?><?php echo $service['img_url']?>" /></a></div>

                <div class="service-name">
                <h6><a href="#"><?php echo $service['name'];?></a></h6>
                <span class="white-bg"></span> <a class="arrow-right" href="<?php base_url()?>home/shop/<?php echo $service['id'];?>"><i class="fa fa-long-arrow-right"></i></a> <span class="service-icon"> <span class="icon-wrap"><i class="fa fa-comments-o"></i></span> <span class="triangle"></span> </span></div>

                <p class="service-des"><?php echo $service['description']?></p>
        </div>
</div>
    <?php }?>
<!--<div class="col-md-4 col-sm-6">
<div class="item">
<div class="service-thumb"><a href="#"><img alt="" src="http://ittires.com/assets/placeholders/car/bg-3-Recovered_05.jpg" /></a></div>

<div class="service-name">
<h6><a href="#">Wheels</a></h6>
<span class="white-bg"></span> <a class="arrow-right" href="#"><i class="fa fa-long-arrow-right"></i></a> <span class="service-icon"> <span class="icon-wrap"><i class="fa fa-automobile"></i></span> <span class="triangle"></span> </span></div>

<p class="service-des">Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo</p>
</div>
</div>

<div class="col-md-4 col-sm-6">
<div class="item">
<div class="service-thumb"><a href="#"><img alt="" src="http://ittires.com/assets/placeholders/car/bg-3-Recovered_07.jpg" /></a></div>

<div class="service-name">
<h6><a href="#">Accessory</a></h6>
<span class="white-bg"></span> <a class="arrow-right" href="#"><i class="fa fa-long-arrow-right"></i></a> <span class="service-icon"> <span class="icon-wrap"><i class="fa fa-cog"></i></span> <span class="triangle"></span> </span></div>

<p class="service-des">Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo</p>
</div>
</div>-->
</div>
</div>
</div>

        </div>
    </div>    
    <!-- top page bottom -->
       
</div>

<!-- kopa top page -->
<div class="widget kopa-offer-2-widget">
            <div class="wrapper">
<!--                <div class="widget-top">
                    <div class="widget-title title-s3">                        
                        <h3>promotions &amp; offers</h3>
                        <span class="red-bg"></span>
                    </div>                    
                    <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
                </div>       -->
   <?php //echo '<pre>',print_r($ourservices_section);?>
   <?php echo $ourservices_section[2]['page_content'];?>
                <div class="widget-content row">  

                    <div class="col-md-6 col-sm-6">
                        <div class="offer-thumb">
                            <a href="" class="mask"></a>
                            <img src="<?php echo base_url()?><?php echo $ourservices_section[5]['our_slider_img']; ?>" alt="">
                            <div class="offer-caption">
                                <a href="">
                                    <p>best sellers</p>
                                    <h3><?php echo strip_tags($ourservices_section[5]['page_content']) ; ?></h3>
                                </a>                                
                            </div>
                        </div>
                    </div>
					
                    <div class="col-md-6 col-sm-6">
                        <div class="offer-thumb">
                            <a href="" class="mask"></a>
                            <img src="<?php echo base_url()?><?php echo $ourservices_section[6]['our_slider_img2']; ?>" alt="">
                            <div class="offer-caption">
                                <a href="">
                                    <p>best sellers</p>
                                    <h3><?php echo strip_tags($ourservices_section[6]['page_content']) ; ?></h3>
                                </a>                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="offer-thumb">
                            <a href="" class="mask"></a>
                            <img src="<?php echo base_url()?><?php echo $ourservices_section[7]['our_slider_img3']; ?>" alt="">
                            <div class="offer-caption">
                                <a href="">
                                    <p>best sellers</p>
                                    <h3><?php echo strip_tags($ourservices_section[7]['page_content']) ; ?></h3>
                                </a>                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="offer-thumb">
                            <a href="" class="mask"></a>
                            <img src="<?php echo base_url()?><?php echo $ourservices_section[8]['our_slider_img4']; ?>" alt="">
                            <div class="offer-caption">
                                <a href="">
                                    <p>best sellers</p>
                                   <h3><?php echo strip_tags($ourservices_section[8]['page_content']) ; ?></h3>
                                </a>                                
                            </div>
                        </div>
                    </div>

                </div> 
            </div>   
        </div>
<?php echo $ourservices_section[3]['page_content'];?>
<?php echo $ourservices_section[4]['page_content'];?>
<!--<div id="main-content" class="pt-50">
    <div class="container">

        <div class="row">
  <?php// echo $ourservices_section[2]['page_content'];?>

        </div>

    </div>   
     container     

</div>-->
<!-- main content -->

