<section class="content"> 
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title"><?php echo lang('article_list') ?></h3> 
        </div> 
        <?php echo (isset($message)) ? $message : "" ?>
        <?php echo showFlashMessage(); ?>
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th> 
                        <th>Banner</th> 
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    if (!empty($blogCat)) {
                        foreach ($blogCat as $blogCat) { 
                            ?>  

                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $blogCat['title'] ?></td> 
                                <td><?php $image = (isset($blogCat['banner'])) ?  $vp_news_picture.$blogCat['banner'] : $assets_url.'dist/img/no-banner.jpg' ;?>
                                    <img src="<?php echo$image?>" alt="<?php echo $blogCat['title'] ?>" width="50"/></td> 
                                <td><?php echo showStatus($blogCat['status']); ?></td>
                                <td>
                                    <?php echo show_edit_button($blogCat)?>  | 
                                    <?php echo show_delete_button($blogCat)?>
                                </td>
                            </tr>

                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="4"><?php echo lang('record_not_found') ?></td>
<?php } ?>

                </tbody>
            </table>
            <?php echo form_open('admin/' . 'articles/add', $blogArticleForm); ?>
            <?php echo form_hidden("hidDataId"); ?>
            <?php echo form_close() ?>
            <?php echo form_open('admin/' . $pageName, $blogArticleFormDel); ?>
            <?php echo form_hidden("hidDeleteId"); ?>
            <?php echo form_close() ?>
        </div>
    </div>
</section>