<html>
    <head>
  <!--<meta charset="utf-8">-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>JWL POS</title>

<link rel="icon" type="image/png" sizes="16x16" href="http://localhost/nveloop_jewellery/./storage/images/favicon.ico">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/font-awesome/css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/datetimepicker/bootstrap-datetimepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- bootstrap Select 2 - text editor -->
  <link rel="stylesheet" type="text/css" id="theme" href="http://localhost/nveloop_jewellery/templates/plugins/select2/select2.min.css">
  <!--Data Table-->
  <link rel="stylesheet" type="text/css" id="theme" href="http://localhost/nveloop_jewellery/templates/plugins/datatables/dataTables.bootstrap.css">
  <!--File  upload-->
  <link rel="stylesheet" type="text/css" id="theme" href="http://localhost/nveloop_jewellery/templates/plugins/file-upload/fileinput.css">
  <!--Nice  alert-->
  <link rel="stylesheet" type="text/css" id="theme" href="http://localhost/nveloop_jewellery/templates/plugins/nice_alert/nice_alert.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/online/css/font_1.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="http://localhost/nveloop_jewellery/templates/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  
<!-- jQuery 3.1.1 -->
<script src="http://localhost/nveloop_jewellery/templates/plugins/jQuery/jquery-3.1.1.min.js"></script>
<script src="http://localhost/nveloop_jewellery/templates/plugins/jQuery/jquery.touchSwipe.min.js"></script>
<!--<script src=""></script>-->
<!-- Drag Table-->
<script src="http://localhost/nveloop_jewellery/templates/plugins/table_row_drag/tbl_row_drager.js"></script>
<!-- Nice  Alert-->
<script src="http://localhost/nveloop_jewellery/templates/plugins/nice_alert/nice_alert.js"></script>
    
<!--file uploader-->
<link href="http://localhost/nveloop_jewellery/templates/plugins/file_upload2/jquery.fileuploader.css" media="all" rel="stylesheet">
<link href="http://localhost/nveloop_jewellery/templates/plugins/file_upload2/jquery.fileuploader-theme-thumbnails.css" media="all" rel="stylesheet">
<!--end file uploader-->

        <script src="http://localhost/nveloop_jewellery/templates/plugins/select2/select2.min.js"></script>
<style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style></head>
    
    <body>
        <div>
          <select id="mySelect2" style="width:600px;" class="js-example-data-ajax"></select>
            
        </div>
    
<script>
	$(document).ready(function(){ 
		var data = [
				{
					id: 0,
					text: 'enhancement'
				},
				{
					id: 1,
					text: 'bug'
				},
				{
					id: 2,
					text: 'duplicate'
				},
				{
					id: 3,
					text: 'invalid'
				},
				{
					id: 4,
					text: 'wontfix'
				}
			];

			$(".js-example-data-ajax").select2({
			  data: data
			})

			$(".js-example-data-ajax-selected").select2({
			  data: data
			})
	});
</script>

    </body>
    
</html>