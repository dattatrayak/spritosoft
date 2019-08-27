<section class="content"> 
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Table With Full Features</h3>
            <?php echo  showFlashMessage();?>
        </div> 
        <?php //p($menuListing); ?>
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Manu Name</th>
                        <th>Url</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    foreach($menuListing as $menu) { 
                         
                        ?>  

                        <tr>
                            <td><?php echo  $i++; ?></td>
                            <td><?php echo $menu['title']?></td>
                            <td><?php echo $menu['title']?></td>
                            <td><?php echo showStatus($menu['status'])?></td>
                            <td>
                                <?php echo show_edit_button($menu)?> |  
                                <?php echo show_delete_button($menu)?>
                            </td> 
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
            <?php echo form_open('admin/menu/add', $menuForm); ?>
                <?php echo form_hidden("hidDataId");?>
             <?php echo  form_close() ?>
            <?php echo form_open('admin/menu', $menuFormDel); ?>
                <?php echo form_hidden("hidDeleteId");?>
             <?php echo  form_close() ?>
        </div>
    </div> 
</section> 