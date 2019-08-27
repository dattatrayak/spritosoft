<!DOCTYPE html> 
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $admin_title?> | Starter</title> 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $assets_url?>bootstrap/dist/css/bootstrap.min.css"> 
  <link rel="stylesheet" href="<?php echo $assets_url?>font-awesome/css/font-awesome.min.css"> 
  <link rel="stylesheet" href="<?php echo $assets_url?>Ionicons/css/ionicons.min.css"> 
  <link rel="stylesheet" href="<?php echo $assets_url?>datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $assets_url?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $assets_url?>dist/css/spritosoft.style.css">
  <?php if($templateSkins!='login-page'){ ?>
  <link rel="stylesheet" href="<?php echo $assets_url?>dist/css/skins/<?php echo $templateSkins?>.min.css">
  <?php }?>
   <link rel="stylesheet" href="<?php echo $assets_url?>plugins/iCheck/square/blue.css">
   <?php echo  (isset($includeHeader))? $includeHeader : '';?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!--
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  <script type="text/javascript">
      var base_url = '<?php echo  base_url()?>';
      </script>
</head>  
<body class="hold-transition <?php echo $templateSkins?> <?php echo $layoutOption?>">
 <?php if(!isset($checkPage)) { ?>
<div class="wrapper"> 
    <?php } ?>

