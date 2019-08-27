<section class="content"> 
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo  lang("category_heading") ?></h3>
                </div>
                <?php echo  (isset($message)) ? $message : "" ?>
                <?php echo form_open('admin/user/add', $userForm); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('user_first_name') ?></label>
                                <?php echo  form_input($txtFirstName) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('user_first_name') ?></label>
                                <?php echo  form_input($txtLastName) ?>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('user_name') ?></label>
                                <?php echo  form_input($txtUserName) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('user_email') ?></label>
                                <?php echo  form_input($txtEmail) ?>
                            </div>
                        </div>
                       
                    </div>
                    <?php if(!$strHidUserId){ ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('password') ?></label>
                                <?php echo  form_password($txtPasword) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('confirm_password') ?></label>
                                <?php echo  form_password($txtConfirmPasword) ?>
                            </div>
                        </div> 
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('user_type_label') ?></label>
                                <?php echo  form_dropdown($txtUserType) ?>
                            </div>
                        </div> 
                        
                    </div>
                     
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="radStatus" id="radStatus1" value="1" <?php echo  ($radStatus == 1)? 'Checked' : ''?>> Active
                                        <input type="radio" name="radStatus" id="radStatus2" value="0" <?php echo  ($radStatus == 0)? 'Checked' : ''?>> Inactive
                                    </label>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo show_submit_button($btnSubmit,$pageDetails) ?>
                                <?php echo  form_reset($reSetCancle) ?>  
                                <input type="hidden" name="hidUserId" id="hidUserId" value="<?php echo  $strHidUserId ?>" />
                                
                            </div>
                        </div> 
                    </div>  
                </div>
                <?php echo  form_close() ?>
            </div> 
        </div> 
    </div> 
</section>