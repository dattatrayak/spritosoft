<section class="content">
    <?php echo  (isset($message)) ? $message : "" ?>
    <?php echo form_open('admin/user/accesslevel', $menuForm); ?>
    <div class="row">
        <div class="col-md-12"> 
            <div>
                <label for="userId">User Name</label><br/>
                <select name="userId" id="userId" class="form-group" onchange="giveAccess(this.value)">
                    <option value="" >---Select User---</option>
               
               <?php foreach($userList as $user){
                   $selected = '';
                   if($user['id'] == $selUserId ){
                       $selected = 'selected';
                   } ?>
                    <option value="<?php echo $user['id']?>" ><?php echo $user['userName']."(".$user['email'].")";?></option>
               <?php }?>
                     </select>
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
            <?php $i=0;
            foreach ($menuListingAccess as $access) {
                if($i%4 == 0 && count($menuListingAccess)!=$i){
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
            <?php $i++; } ?>
    </div> 
    <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo show_submit_button($btnSubmit) ?>
                        <?php echo  form_reset($reSetCancle) ?>  
                    </div>
                </div> 
            </div> 
    </div> 
    <?php echo  form_close() ?>
</section> 
