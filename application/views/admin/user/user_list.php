<section class="content"> 
    <div class="box">
        <div class="box-header">
            <input type="button" value="Add user" name="addUser" id="adduser" onclick="showDataLink('user/add')" class="btn btn-success btn-xs"/>
        </div>
    </div>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                     
                    foreach($userListing as $user) { ?>   
                        <tr>
                            <td><?php echo  $i++; ?></td>
                            <td><?php echo $user['firstName']." ".$user['lastName']?></td>
                            <td><?php echo $user['email']?></td>
                            <td><?php echo  showStatus($user['status'])?></td>
                            <td>
                                <?php echo show_edit_button($user)?> |  
                                <?php echo show_delete_button($user)?>
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
            <?php echo form_open('admin/user/add', $userForm); ?>
                <?php echo form_hidden("hidDataId");?>
             <?php echo  form_close() ?>
            <?php echo form_open('admin/user', $userFormDel); ?>
                <?php echo form_hidden("hidDeleteId");?>
             <?php echo  form_close() ?>
        </div>
    </div> 
</section> 