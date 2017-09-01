<a class="hiddenanchor" id="signup"></a>
<a class="hiddenanchor" id="signin"></a>

<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            
            <?php echo form_open("auth/login"); ?>
            <h1>ITTires Login</h1>
            <div id="infoMessage" class=" text-warning"><?php echo $message; ?></div>
            <div>
                <?php echo form_input($identity); ?>
                <!--<input type="text" class="form-control" placeholder="Username" required="" />-->
            </div>
            <div>
                <?php echo form_input($password); ?>
                <!--<input type="password" class="form-control" placeholder="Password" required="" />-->
            </div>
            <div>
                <?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn btn-default submit')); ?>

                <a class="reset_pass" href="<?php echo base_url()?>auth/forgot_password">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
                <p class="change_link">New to site?
                    <a href="#signup" class="to_register"> Create Account </a>
                </p>

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
                <?php echo form_open_multipart("auth/register_user", array('id' => 'reg_form')); ?>
                <h1>Create Account</h1>
               
                <div>
                    <?php echo form_input($first_name); ?>  
                </div>
                
                 <div>
                     <?php echo form_input($last_name); ?>  
                </div>
                <div>
                   <?php echo form_input($email); ?>  
                </div>
                <div>
                    <?php echo form_input($phone); ?>  
                </div>
                <div>
                   <?php echo form_input($password); ?>
                </div>
                <div>
                    <?php echo form_input($password_confirm); ?>
                </div>
                <div>
<!--                    <button  type="submit" class="btn btn-default submit">Submit</button>-->
                     <?php echo form_submit('submit', lang('create_user_submit_btn'), array('class' => 'btn btn-default submit','style'=>'margin-left: 0px')); ?>
                </div>

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
