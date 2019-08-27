<section class="content"> 
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang("category_heading") ?></h3>
                </div>
                <?php echo (isset($message)) ? $message : "" ?>
                <?php echo showFlashMessage(); ?>
                <?php echo form_open_multipart('admin/' . $pageName, $blogCatForm); ?>
                <div class="box-body"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('article_title') ?></label>
                                <?php echo form_input($txtArticleName) ?>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('blog_category_slug') ?></label>
                                <?php echo form_input($txtCatSlug) ?>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('blog_category') ?></label>
                                <?php echo form_dropdown($txtBlogCat) ?>
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Article: </label>
                                <?php echo $this->ckeditor->editor("article", "article", $txtbody); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label><?php echo lang('article_image') ?></label>
                                <?php echo form_upload($fileArt) ?>
                            </div>
                            <?php
                            if ($bannerImage != '') {
                                echo '<img src="' . $this->config->item('vp_news_picture') . $bannerImage . ' " alt="Article image" width="150"/>';
                            }
                            ?>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('meta_key') ?></label>
<?php echo form_input($txtMetakey) ?>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('meta_desc') ?></label>
                                <?php echo form_textarea($txtMetaDesc) ?>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('position') ?></label>
                                <?php echo form_input($txtCatPosition) ?>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="radStatus" id="radStatus1" value="1" <?php echo ($radStatus == 1) ? 'Checked' : '' ?>> Active
                                        <input type="radio" name="radStatus" id="radStatus2" value="0" <?php echo ($radStatus == 0) ? 'Checked' : '' ?>> Inactive
                                    </label>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php echo show_submit_button($btnSubmit,$pageDetails) ?>
                                <?php echo form_reset($reSetCancle) ?>  
                                <input type="hidden" name="hidCatId" id="hidCatId" value="<?php echo $strHidCatId ?>" />

                            </div>
                        </div> 
                    </div>  
                </div>
                <?php echo form_close() ?>
            </div> 
        </div> 
    </div> 
</section>