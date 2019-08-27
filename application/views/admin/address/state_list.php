<section class="content"> 
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo  lang("user_type_page_heading") ?></h3>
                </div>
                <?php echo  (isset($message)) ? $message : "" ?>
                <?php echo  showFlashMessage(); ?>
                <?php echo form_open(ADMIN.$pageName, $stateForm); ?>
                <div class="box-body"> 
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('states') ?></label>
                                <?php echo  form_input($txtStateName) ?>
                            </div>
                        </div>                     
                    </div>

                    <div class="row"> 
                        <div class="col-md-6"> 
                                <div class="form-group">
                                    <label><?php echo  lang('country_name') ?></label>
                                    <?php echo  form_dropdown($selCountry) ?>
                                </div> 
                        </div>    
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
                                <input type="hidden" name="hidStateId" id="hidStateId" value="<?php echo  $hidStateId ?>" /> 
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
            <h3 class="box-title">Data Table With Full Features</h3> 
        </div> 
        <?php //p($menuListing); ?>
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>State Name</th> 
                        <th>Country Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($statelist as $state) {
                        ?>  

                        <tr>
                            <td><?php echo  $i++; ?></td>
                            <td><?php echo  $state['name'] ?></td>
                            <td><?php echo  $state['countryName'] ?></td>
                            <td>
                                <?php echo show_edit_button($state); ?> |  
                                <?php echo show_delete_button($state); ?>
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
            <?php echo form_open(ADMIN.$pageName, $stateForm); ?>
            <?php echo form_hidden("hidDataId"); ?>
            <?php echo  form_close() ?>
            <?php echo form_open(ADMIN.$pageName, $stateFormDel); ?>
            <?php echo form_hidden("hidDeleteId"); ?>
            <?php echo  form_close() ?>
        </div>
    </div> 
</section> 