<section class="content"> 
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo  lang("category_heading") ?></h3>
                </div>
                <?php echo  (isset($message)) ? $message : "" ?>
                <?php echo  showFlashMessage(); ?>
                <?php echo form_open( 'admin/'.$pageName, $blogCatForm); ?>
                <div class="box-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('blog_category') ?></label>
                                <?php echo  form_input($txtCatName) ?>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                 <label><?php echo  lang('blog_category_slug') ?></label>
                                <?php echo  form_input($txtCatSlug) ?>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                 <label><?php echo  lang('position') ?></label>
                                <?php echo  form_input($txtCatPosition) ?>
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
                                <input type="hidden" name="hidCatId" id="hidCatId" value="<?php echo  $strHidCatId ?>" />
                                
                            </div>
                        </div> 
                    </div>  
                </div>
                <?php echo  form_close() ?>
            </div> 
        </div> 
    </div>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title"><?php echo  lang('blog_category') ?></h3> 
        </div>  
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th> 
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if(!empty($blogCat)){
                    foreach ($blogCat as $blogCat) {
                        ?>  

                        <tr>
                            <td><?php echo  $i++; ?></td>
                            <td><?php echo  $blogCat['name'] ?></td> 
                            <td><?php echo  showStatus($blogCat['status']); ?></td>
                            <td><?php echo show_edit_button($blogCat)?> |  
                                <?php echo show_delete_button($blogCat)?>
                                </td>
                        </tr>

                    <?php } }else{ ?>
    <tr>
        <td colspan="4"><?php echo  lang('record_not_found')?></td>
<?php } ?>

                </tbody>
            </table>
            <?php echo form_open('admin/'.$pageName, $blogCatForm); ?>
            <?php echo form_hidden("hidDataId"); ?>
            <?php echo  form_close() ?>
            <?php echo form_open('admin/'.$pageName, $blogCatFormDel); ?>
            <?php echo form_hidden("hidDeleteId"); ?>
<?php echo  form_close() ?>
        </div>
    </div>
</section>