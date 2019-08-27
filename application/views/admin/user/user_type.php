<section class="content"> 
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo  lang("user_type_page_heading") ?></h3>
                </div>
                <?php echo  (isset($message)) ? $message : "" ?>
                <?php echo  showFlashMessage(); ?>
                <?php echo form_open('admin/user/type', $userTypeForm); ?>
                <div class="box-body"> 
                    <div class="row"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo  lang('user_type') ?></label>
                                <?php echo  form_input($txtUserType) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> 
                            <div>
                                <input type="checkbox" name="menuAll" value="" id="check-all" /> Select All
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <?php
                        $i = 0;
                        foreach ($menuListingAccess as $access) {
                            if ($i % 4 == 0 && count($menuListingAccess) != $i) {
                                echo"</div><div class='row'>";
                            }
                            ?>
                            <div class="col-sm-3"> 
                                <div class="menu-accesss">
                                    <h3><input type="checkbox" name="menuid[<?php echo  $access['id'] ?>]" class="menuAccessLevelHead" value="<?php echo  $access['id'] ?>" /> <?php echo  $access['title'] ?></h3>
                                    <ul class="menu-level">
                                        <li><input type="checkbox" name="is_add[<?php echo  $access['id'] ?>]" id="is_add<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Add Records</li>
                                        <li><input type="checkbox" name="is_edit[<?php echo  $access['id'] ?>]" id="is_edit<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Edit Records</li>
                                        <li><input type="checkbox" name="is_delete[<?php echo  $access['id'] ?>]" id="is_delete<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Is Delete</li>
                                        <li><input type="checkbox" name="is_his_view[<?php echo  $access['id'] ?>]" id="is_his_view<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Is His View</li>
                                        <li><input type="checkbox" name="is_his_edit[<?php echo  $access['id'] ?>]" id="is_his_edit<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Is His Edit</li>
                                        <li><input type="checkbox" name="is_his_delete[<?php echo  $access['id'] ?>]" id="is_his_delete<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Is His Delete</li>
                                        <li><input type="checkbox" name="is_other_view[<?php echo  $access['id'] ?>]" id="is_other_view<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Is Other View</li>
                                        <li><input type="checkbox" name="is_other_edit[<?php echo  $access['id'] ?>]" id="is_other_edit<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Is Other Edit</li>
                                        <li><input type="checkbox" name="is_other_delete[<?php echo  $access['id'] ?>]" id="is_other_delete<?php echo  $access['id'] ?>" class="menuAccessLevel" value="1" /> Is Other Delete</li>
                                    </ul>
                                    <input type="hidden" name="hidMenuId[]" value="<?php echo  $access['id'] ?>" />
                                </div>
                            </div>
                            <?php $i++;
                        }
                        ?>
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
                                <input type="hidden" name="selLevel" id="selLevel" value="" />
                                <input type="hidden" name="hidUserGroupId" id="hidUserGroupId" value="<?php echo  $strhidUserGroupId ?>" />

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
            <h3 class="box-title"><?php echo  lang('user_type_heading') ?></h3> 
        </div>  
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>user Group Name</th> 
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($userTypeList as $userType) {
                        ?>  

                        <tr>
                            <td><?php echo  $i++; ?></td>
                            <td><?php echo  $userType['group_name'] ?></td> 
                            <td><?php echo  showStatus($userType['status']); ?></td>
                            <td><button class="btn btn-success btn-xs" onclick="fnEdit('<?php echo  $userType['id'] ?>')">Edit</button> | <button class="btn btn-danger btn-xs" onclick="fnDelete('<?php echo  $userType['id'] ?>')">Delete</button></td>
                        </tr>

<?php } ?>

                </tbody>
            </table>
            <?php echo form_open('admin/user/type', $userForm); ?>
            <?php echo form_hidden("hidDataId"); ?>
            <?php echo  form_close() ?>
            <?php echo form_open('admin/user/type', $userFormDel); ?>
            <?php echo form_hidden("hidDeleteId"); ?>
<?php echo  form_close() ?>
        </div>
    </div> 
</section> 