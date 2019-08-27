<?php if (!isset($checkPage)) { ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo (isset($pageDetails['page_heading'])) ? $pageDetails['page_heading'] : 'Spritosoft';
      if(isset($pageDetails['description'])){
          echo " <small>".$pageDetails['description']."</small>";
      }
      ?> 
      </h1>
      <ol class="breadcrumb">
           <li>
               <a href="<?php echo  base_url('admin/dashboard')  ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <?php if(!empty($breadcrumb)){ foreach($breadcrumb as $bred){
              echo '<li><a href="' . base_url('admin/' . $bred['url']) . '"><i class="'.$bred['icon'].'"></i> '.$bred['title'].'</a></li>';
          } }
          if(isset($pageDetails['title'])){
              echo ' <li class="active">'.$pageDetails['title'].'</li>';
          }
          ?> 
       
      </ol>
    </section> 
    <!-- Main content -->
    <section class="content container-fluid">

       <?php echo  $main_content ?>

    </section>
    <!-- /.content -->
  </div>
<?php }else{
    echo $main_content;
} ?>