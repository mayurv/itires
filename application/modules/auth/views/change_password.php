

      
      
      
      <a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>

<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
              <?php
        if(isset($message)){
      ?>
         <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <?php echo $message; ?>
                  </div>
        <?php }?>
            <?php echo form_open("auth/change_password"); ?>
            <h4>Change Password</h4>
            <br>
            <div>
              <?php echo form_input($old_password);?>
                <!--<input type="text" class="form-control" placeholder="Username" required="" />-->
            </div>
            <div>
               <?php echo form_input($new_password);?>
                <!--<input type="text" class="form-control" placeholder="Username" required="" />-->
            </div>
            <div>
                 <?php echo form_input($new_password_confirm);?>
            </div>
            <?php echo form_input($user_id);?>
            <div>
                <?php echo form_submit('submit', lang('change_password_submit_btn'), array('class' => 'btn btn-default submit','style'=>'margin-left:0px')); ?>

                <a class="reset_pass" href="<?php echo base_url()?>auth/login">Login</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">


                <div class="clearfix"></div>
                <br />

                <div>
                    <h1><i class="fa fa-paw"></i> <?php echo $this->config->item('website_name'); ?></h1>
                    <p>©2017 All Rights Reserved. <?php echo $this->config->item('website_name'); ?>! is a Online tire selling & buying. Privacy and Terms</p>
                </div>
            </div>
            <?php echo form_close(); ?>
        </section>
    </div>

    <div id="register" class="animate form registration_form">
      <div id="infoMessage"></div>
   
      <?php
        if(isset($message)){
      ?>
         <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <?php echo $message; ?>
                  </div>
        <?php }?>
       
        <section class="login_content">
<!--            <form id="signupForm" method="post">-->
               

                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">Already a member ?
                        <a href="#signin" class="to_register"> Log in </a>
                    </p>
<?php echo form_close(); ?>
                    <div class="clearfix"></div>
                    <br />

                    <div>
                        <h1><i class="fa fa-paw"></i> <?php echo $this->config->item('website_name'); ?></h1>
                        <p>©2017 All Rights Reserved. <?php echo $this->config->item('website_name'); ?>! is a Online tire selling & buying. Privacy and Terms</p>
                    </div>
                </div>
       
        </section>
    </div>
</div>
