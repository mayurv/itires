<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="<?php echo base_url()?>assets/js/gmaps.js"></script>
<div id="kopa-top-page">  
    <div class="top-page-above">            
<!--        <div class="page-title"> 
            <div class="mask"></div>               
            <h1>Contact Us</h1> 
            <p>Lorem ipsum dolor sit amet, consecte adipiscing elit. Suspendisse condimentum porttitor cursumus. Duis nec nulla turpis. Nulla lacinia laoreet odio </p>               
        </div> -->
<?=$contact_section[0]['page_content']?>
<!--        <div class="kopa-breadcrumb clearfix">
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a itemprop="url" href="index-2.html">
                    <span itemprop="title">Home</span>
                </a>
            </span>
            <span>&nbsp;&rsaquo;&nbsp;</span>
            <span class="current-page" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">Contact Us</span></span>
            <span class="bottom-line"></span>
        </div>   -->
    </div>  
    <!-- top page above -->
    <div class="top-page-bottom clearfix">
        <div class="container">

<!--            <a href="#" class="pre-page">Back to Previous Page</a>-->
        </div>
    </div>    
    <!-- top page bottom -->
</div>
<!-- kopa top page -->

<div id="main-content" class="pt-50">
    <div class="container">

        <div class="row">
            
            <div class="col-md-6 col-sm-6">                    
                <?=$contact_section[2]['page_content']?>
                <div id="msg"></div>
                <div id="contact-box">
                      <?php
                        if (!empty($this->session->flashdata('message'))) {
                            ?>
                            <p class="call-us"><?php echo $this->session->flashdata('message') ?></p>
                            <?php
                        }
                        ?>
                    <form novalidate="novalidate" method="post" action="<?php echo base_url()?>home/contact/con" class="contact-form clearfix">                                
                        <p class="input-block">
                            <label for="contact_name" class="required">Name <span>(*)</span></label>
                            <input type="text" value="" onfocus="if (this.value == 'Name (*)')
                                        this.value = '';" onblur="if (this.value == '')
                                        this.value = 'Name (*)';" id="contact_name" name="name" class="valid" placeholder="Name (*)">
                        </p>

                        <p class="input-block">
                            <label for="contact_email" class="required">Email <span>(*)</span></label>
                            <input type="text" value="" onfocus="if (this.value == 'Email (*)')
                                        this.value = '';" onblur="if (this.value == '')
                                                    this.value = 'Email (*)';" id="contact_email" name="email" class="valid" placeholder="Email (*)">
                        </p>

                        <p class="input-block">                                                
                            <label for="contact_url" class="required">Website</label>
                            <input type="text" name="url" class="valid" value="" onfocus="if (this.value == 'Website')
                                        this.value = '';" onblur="if (this.value == '')
                                                    this.value = 'Website';" id="contact_url" placeholder="Website">                                                
                        </p>            

                        <p class="textarea-block">                        
                            <label for="contact_message" class="required">Your comment <span>(*)</span></label>
                            <textarea class="valid" onfocus="if (this.value == 'Your comments (*)')
                                        this.value = '';" onblur="if (this.value == '')
                                                    this.value = 'Your comments (*)';" name="message" id="contact_message" cols="88" rows="6" placeholder="Your comments (*)"></textarea>
                        </p>

                        <p class="contact-button clearfix">                    
                            <input type="submit" value="Send" id="submit-contact" class="input-submit">
                        </p>

                    </form>                        

                </div>
                <!-- contact-box -->                           
            </div>

            <div class="col-md-6 col-sm-6">
               <?php // echo $contact_section[1]['page_content']?>
                <div class="kopa-map-widget">
                    <div class="kp-map-wrapper">
                        <div id="kp-map" >
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3782.277057998053!2d73.9254972147761!3d18.5615438873851!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c15daa022505%3A0x65ee641ae696edbb!2sRebelute+Digital+Solutions!5e0!3m2!1sen!2sin!4v1502893538289" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
<!--                        <div class="contact-info-wrapper">
                            <div class="contact-info">
                                <div>
                                    <h6>say hello!</h6>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc interdum consectetur cursus. Pellentesque non lobortis mauris, quis volutpat lorem.</p>
                                </div>                                
                                <div>
                                    <h6>contact info</h6>
                                    <p><span>Address:</span>Elizabeth St, Melbourne, Victoria 3000 Australi</p>
                                    <p><span>Phone:</span>+84 1234 5678</p>
                                    <p><span>Email:</span>info@iTiresOnline.com</p>
                                </div>                                
                            </div>
                        </div>                            -->
                    </div>
                                              
                </div>
                <!-- kopa-map-widget -->
            </div>
        </div>

    </div>   
    <!-- container -->    

</div>
<!-- main content -->

