<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Sprito</b>soft</a>
    </div> 
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your dashboard</p> 
        <?php echo (isset($message)) ? $message : "" ?>
       <?php echo form_open('admin/login',$loginForm);?>
            <div class="form-group has-feedback">
                <?php echo form_input($txtEmail)?>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo form_input($txtpassword)?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                             <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?><?php echo lang('remember_me'); ?> 
                        </label>
                    </div>
                </div> 
                <div class="col-xs-4">
                     <?php echo form_submit($btnSubmit)?>
                </div> 
            </div>
            <?php echo form_close()?>
        <a href="#"><?php echo lang("forgot_password") ?></a><br>
    </div> 
</div>