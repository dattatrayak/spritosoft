<section class="content"> 
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo  lang("category_heading") ?></h3>
                </div>
                <?php echo  (isset($message)) ? $message : "" ?>
                <?php echo form_open('admin/menu/add', $menuForm); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('menu_title') ?></label>
                                <?php echo  form_dropdown($selCategory) ?>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('menu_title') ?></label>
                                <?php echo  form_input($txtMenuTitle) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('page_heading') ?></label>
                                <?php echo  form_input($txtPageHeading) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('menu_url') ?></label>
                                <?php echo  form_input($txtMenuUrl) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('menu_icon') ?></label>
                                <?php echo  form_input($txtMenuIcon) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo  lang('Description') ?></label>
                                <?php echo  form_textarea($txtPageDes) ?>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                 <label><?php echo  lang('menu_position') ?></label>
                                <?php echo  form_input($txtMenuPosition) ?>
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
                                <input type="hidden" name="selLevel" id="selLevel" value="" />
                                <input type="hidden" name="hidMenuId" id="hidMenuId" value="<?php echo  $strHidMenuId ?>" />
                                
                            </div>
                        </div> 
                    </div>  
                </div>
                <?php echo  form_close() ?>
            </div> 
        </div> 
    </div> 
</section>