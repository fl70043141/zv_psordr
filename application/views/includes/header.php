<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<!DOCTYPE html>
<html lang="en">
    
<head>
  <!--<meta charset="utf-8">-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SYSTEM_NAME; ?></title>

<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(SAMPLE_PIC.'favicon.ico');?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('templates/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/font-awesome/css/font-awesome.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/ionicons/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('templates/dist/css/AdminLTE.min.css');?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('templates/dist/css/skins/_all-skins.min.css');?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/morris/morris.css');?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/datepicker/datepicker3.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/datetimepicker/bootstrap-datetimepicker.min.css');?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/daterangepicker/daterangepicker.css');?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">
  <!-- bootstrap Select 2 - text editor -->
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('templates/plugins/select2/select2.min.css'); ?>"/>
  <!--Data Table-->
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('templates/plugins/datatables/dataTables.bootstrap.css'); ?>"/>
  <!--File  upload-->
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('templates/plugins/file-upload/fileinput.css'); ?>"/>
  <!--Nice  alert-->
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url('templates/plugins/nice_alert/nice_alert.css'); ?>"/>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/online/css/font_1.css');?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">

  
<!-- jQuery 3.1.1 -->
<script src="<?php echo base_url('templates/plugins/jQuery/jquery-3.1.1.min.js');?>"></script>
<script src="<?php echo base_url('templates/plugins/jQuery/jquery.touchSwipe.min.js');?>"></script>
<!--<script src="<?php // echo base_url('templates/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>-->
<!-- Drag Table-->
<script src="<?php echo base_url('templates/plugins/table_row_drag/tbl_row_drager.js')?>"></script>
<!-- Nice  Alert-->
<script src="<?php echo base_url('templates/plugins/nice_alert/nice_alert.js')?>"></script>
    
<!--file uploader-->
<link href="<?php echo base_url('templates/plugins/file_upload2/jquery.fileuploader.css')?>" media="all" rel="stylesheet">
<link href="<?php echo base_url('templates/plugins/file_upload2/jquery.fileuploader-theme-thumbnails.css')?>" media="all" rel="stylesheet">
<!--end file uploader-->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url('templates/dist/js/pages/dashboard.js');?>"></script>
</head>
 

<body class="hold-transition fixed skin-blue sidebar-mini sidebar-mini-expand-feature sidebar-collapse">
    
<div id="fl_alert_container"></div>
<div class="wrapper">
