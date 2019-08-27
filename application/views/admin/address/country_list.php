<section class="content"> 
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo  lang("user_type_page_heading") ?></h3>
                </div>
                <?php echo  (isset($message)) ? $message : "" ?>
                <?php echo  showFlashMessage(); ?>
                <?php echo form_open(ADMIN.$pageName, $countryForm); ?>
                <div class="box-body"> 
                    <div class="row"> 
                       <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo  lang('country_name') ?></label>
                                <?php echo  form_input($txtCountryName) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo  lang('country_sort_name') ?></label>
                                <?php echo  form_input($txtCountrySortName) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo  lang('country_phone_code') ?></label>
                                <?php echo  form_input($txtCountryPhoneCode) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                       
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="radStatus" id="radStatus1" value="1" <?php echo  ($radStatus == 1) ? 'Checked' : '' ?>> Active
                                        <input type="radio" name="radStatus" id="radStatus2" value="0" <?php echo  ($radStatus == 0) ? 'Checked' : '' ?>> Inactive
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
                                <input type="hidden" name="hidCountryId" id="hidUserGroupId" value="<?php echo  $hidCountryId ?>" /> 
                            </div>
                        </div> 
                    </div>  
                </div>
                <?php echo  form_close() ?>
            </div> 
        </div> 
    </div> 
</section>
<section class="content"> 
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">  <?php echo  (isset($pageDetails['page_heading'])) ? $pageDetails['page_heading'] : 'Title'; ?></h3> 
        </div> 
        <?php //p($menuListing); ?>
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Country Name</th>
                        <th>Phone Code</th> 
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($countryList as $country) {
                        ?>  

                        <tr>
                            <td><?php echo  $i++; ?></td>
                            <td><?php echo  $country['name'] ?></td>
                            <td><?php echo  $country['phonecode'] ?></td> 
                            <td><?php echo show_edit_button($country)?> |  
                                <?php echo show_delete_button($country)?>
                                 </td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
            <?php echo form_open(ADMIN.$pageName, $menuForm); ?>
            <?php echo form_hidden("hidDataId"); ?>
            <?php echo  form_close() ?>
            <?php echo form_open(ADMIN.$pageName, $menuFormDel); ?>
            <?php echo form_hidden("hidDeleteId"); ?>
            <?php echo  form_close() ?>
        </div>
    </div> 
</section> 