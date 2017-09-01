<div class="kopa-top-slide kopa-top-slide-2">
    <div class="slide-wrapper-outer">
        <?php $this->load->view('_slider'); ?>
    </div>
    <!-- .slide-wrapper-outer -->        

    <div class="purchase-box">
        <div class="wrapper">
            <!-- <p class="h5">All the things you need to make your work easier! Design by Kopatheme </p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus accumsan sem rutrum massa porttitor euismod. Phasellus accumsan sem rutrum massa.</p>                    
            --> 


        </div>            
    </div>
    <!-- .purchase-box -->



</div>
<!-- .kopa-top-slide -->

<div class="wrapper selectprojectform">
    <?php $this->load->view('product/_filter_popup'); ?>
</div>


<div id="main-content" class="our_services">  

    <div class="widget kopa-services-widget">   
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <div class="widget kopa-services-widget">
<div class="container">
     <?=$home_section[1]['page_content']?>
<!--<div class="widget-top">
<div class="widget-title title-s3">
<h3>check out our service</h3>
<span class="red-bg"></span></div>

<p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio</p>
</div>-->

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

</div>
</div>
</div>
    </div>
    <!-- kopa services widget -->

    <div class="widget kopa-features-widget">
        <?=$home_section[2]['page_content']?>
        <?php $this->load->view('product/_feature_products'); ?>    
        <?php echo $this->pagination->create_links(); ?>    

    </div>




    <div class="widget kopa-offers-widget">                 
        <div class="wrapper clearfix">  
<!--            <div class="widget-top">
                <div class="widget-title title-s3">                        
                    <h3>Offer of the week</h3>
                    <span class="red-bg"></span>
                </div>                    
                <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
            </div>  -->
  <?=$home_section[3]['page_content']?>
        </div>     
        <div class="widget-content">
            <div class="mask"></div> 
            <div class="container">                        
                <?php $this->load->view('product/_offer_of_week'); ?>
                <!-- #owl week offer -->

            </div>
        </div> 
        <!-- widget content -->                        
    </div> 
    <!-- kopa offers widget -->

    <div class="widget kopa-testimonials-widget testi-1"> 
<!--        <div class="widget-top">
            <div class="widget-title title-s3">                        
                <h3>Testimonials</h3>
                <span class="red-bg"></span>
            </div>                    
            <p class="t-des">Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>
        </div> -->
  <?=$home_section[4]['page_content']?>
        <div class="widget-content">
            <div class="wrapper">
                <div class="owl-carousel owl-testi-1">
                    <?php
                    foreach ($testi_monial as $moial) {
                        ?>
                        <div class="item">                                
                            <p class="customer-comment"><span class="team-name"><?= $moial['name'] ?></span><?= $moial['testimonial'] ?></p>
                            <span class="customer-avatar">
                                <img src ="<?php echo base_url() ?>media/backend/img/testimonial_img/<?= $moial['image'] ?>" alt="" />
                            </span>
                            <span class="meta-info">
                                <span class="custome-name">LUIS NGUYEN</span>,
                                <span class="customer-job">Customer</span>
                            </span>  
                        </div>
                        <?php
                    }
                    ?>
                    <!--                    <div class="item">                                
                                            <p class="customer-comment"><span class="team-name">Lorem Ipsum</span>dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                            <span class="customer-avatar">
                                                <img src ="<?php echo base_url() ?>assets/placeholders/customer.png" alt="" />
                                            </span>
                                            <span class="meta-info">
                                                <span class="custome-name">LUIS NGUYEN</span>,
                                                <span class="customer-job">Customer</span>
                                            </span> 
                                        </div>
                                        <div class="item">                                
                                            <p class="customer-comment"><span class="team-name">Lorem Ipsum</span>dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                            <span class="customer-avatar">
                                                <img src ="<?php echo base_url() ?>assets/placeholders/customer.png" alt="" />
                                            </span>
                                            <span class="meta-info">
                                                <span class="custome-name">LUIS NGUYEN</span>,
                                                <span class="customer-job">Customer</span>
                                            </span> 
                                        </div>
                                        <div class="item">                                
                                            <p class="customer-comment"><span class="team-name">Lorem Ipsum</span>dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                            <span class="customer-avatar">
                                                <img src ="<?php echo base_url() ?>assets/placeholders/customer.png" alt="" />
                                            </span>
                                            <span class="meta-info">
                                                <span class="custome-name">LUIS NGUYEN</span>,
                                                <span class="customer-job">Customer</span>
                                            </span> 
                                        </div>
                                        <div class="item">                                
                                            <p class="customer-comment"><span class="team-name">Lorem Ipsum</span>dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                            <span class="customer-avatar">
                                                <img src ="<?php echo base_url() ?>assets/placeholders/customer.png" alt="" />
                                            </span>
                                            <span class="meta-info">
                                                <span class="custome-name">LUIS NGUYEN</span>,
                                                <span class="customer-job">Customer</span>
                                            </span> 
                                        </div>-->
                </div>
            </div>
        </div>            
    </div>

    <!-- kopa faqs widget -->

    <!--    <div class="widget kopa-recent-tweets-widget"> 
            <div class="mask"></div>                         
            <div class="widget-icon"><i class="fa fa-twitter"></i></div>
            <div class="owl-carousel owl-recent-tweets">
                <div class="tweet-item">
                    <p class="tweet-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p class="tweet-info"><span class="tweet-date">23 June 2014</span><span class="tweet-account">@iTiresOnline</span></p>
                </div>
                <div class="tweet-item">
                    <p class="tweet-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p class="tweet-info"><span class="tweet-date">23 June 2014</span><span class="tweet-account">@iTiresOnline</span></p>
                </div>
                <div class="tweet-item">
                    <p class="tweet-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p class="tweet-info"><span class="tweet-date">23 June 2014</span><span class="tweet-account">@iTiresOnline</span></p>
                </div>
            </div>                           
        </div>-->
    <!-- kopa recent tweet widget -->  


    <!-- kopa features widget -->    


    <!-- kopa testimonials widget --> 

    <div class="widget kopa-article-list-widget">   
        <div class="container">  

  <?=$home_section[5]['page_content']?>
            <div class="widget-content entry-box row">
                <?php
                //echo print_r($blog);
                foreach ($blog as $b) {
                    ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="entry-item">
                            <div class="entry-thumb">
                                <a href="<?php echo base_url();?>home/single_blog/<?=$b['post_id']?>" class=""><img src ="<?php echo base_url() ?>media/backend/img/blog_image/<?= $b['blog_image'] ?>" alt="" /> </a>
                            </div>
                            <div class="entry-content"> 
                                <div class="meta-box clearfix">
                                    <span class="entry-date pull-left">
                                        <?php
                                        $date = $b['posted_on'];
                                        $d = date('d', strtotime($date));
                                        $m = date('M', strtotime($date));
                                        ?>
                                        <span class="entry-day"><?= $d; ?></span>
                                        <span class="entry-month"><?= $m; ?></span>
                                    </span>
                                    <div class="meta-box-right">
                                        <h6 class="entry-title">
                                            <a href="<?php echo base_url();?>home/single_blog/<?=$b['post_id']?>"><?= $b['post_title'] ?></a>
                                        </h6>
                                        <footer>
                                            <span>Posted in:</span>
                                            <a href="#"><?= $b['suburb'] ?></a>, 
                                            <!--                                        <a href="#">car</a>-->
                                            <!--                                        <span class="comments"> 
                                                                                        <span>With:</span>
                                                                                        <a href="#">4</a>
                                                                                        <i class="fa fa-comments-o"></i>
                                                                                    </span>                                            -->
                                        </footer>
                                    </div>
                                </div>
                                <p class="entry-excerpt"><?= $b['post_content'] ?></p>
                                <a href="#" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                            </div>  
                        </div>                            
                    </div>
                    <?php
                }
                ?>
                <!--                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="entry-item">
                                        <div class="entry-thumb">
                                            <a href="#" class=""><img src ="<?php echo base_url() ?>assets/placeholders/car/bg-3-Recovered_18.jpg" alt="" /> </a>
                                        </div>
                                        <div class="entry-content"> 
                                            <div class="meta-box clearfix">
                                                <span class="entry-date pull-left">
                                                    <span class="entry-day">18</span>
                                                    <span class="entry-month">DEC</span>
                                                </span>
                                                <div class="meta-box-right">
                                                    <h6 class="entry-title">
                                                        <a href="#">MORBI NON SEM A LACUS PORTA SUSPENDISSE VITAE SAPIEN</a>
                                                    </h6>
                                                    <footer>
                                                        <span>Posted in:</span>
                                                        <a href="#">kopatheme</a>, 
                                                        <a href="#">car</a>
                                                        <span class="comments"> 
                                                            <span>With:</span>
                                                            <a href="#">4</a>
                                                            <i class="fa fa-comments-o"></i>
                                                        </span>                                            
                                                    </footer>
                                                </div>
                                            </div>
                                            <p class="entry-excerpt">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best</p>
                                            <a href="#" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                        </div>  
                                    </div>                                
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="entry-item">
                                        <div class="entry-thumb">
                                            <a href="#" class=""><img src ="<?php echo base_url() ?>assets/placeholders/car/bg-3-Recovered_20.jpg" alt="" /></a>
                                        </div>
                                        <div class="entry-content"> 
                                            <div class="meta-box clearfix">
                                                <span class="entry-date pull-left">
                                                    <span class="entry-day">18</span>
                                                    <span class="entry-month">DEC</span>
                                                </span>
                                                <div class="meta-box-right">
                                                    <h6 class="entry-title">
                                                        <a href="#">MORBI NON SEM A LACUS PORTA SUSPENDISSE VITAE SAPIEN</a>
                                                    </h6>
                                                    <footer>
                                                        <span>Posted in:</span>
                                                        <a href="#">kopatheme</a>, 
                                                        <a href="#">car</a>
                                                        <span class="comments"> 
                                                            <span>With:</span>
                                                            <a href="#">4</a>
                                                            <i class="fa fa-comments-o"></i>
                                                        </span>                                            
                                                    </footer>
                                                </div>
                                            </div>
                                            <p class="entry-excerpt">As we have come to expect from the Porsche design department, the changes to the styling of the new Cayenne can best</p>
                                            <a href="#" class="read-more">Read more<span><i class="fa fa-long-arrow-right"></i></span></a>
                                        </div>                                
                                    </div>                              
                                </div>-->
            </div>
            <!-- widget content -->
        </div>
    </div>
    <!-- kopa article list widget -->    


  <?=$home_section[6]['page_content']?>
    <!-- kopa tab 2 widget --> 
  <?=$home_section[7]['page_content']?>

    <!-- kopa clients widget --> 

</div>
<!-- main content -->
