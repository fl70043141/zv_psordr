<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SYSTEM_NAME;?> | Log in</title>
  
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(SAMPLE_PIC.'favicon.ico');?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('templates/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/font-awesome/css/font-awesome.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/ionicons/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('templates/dist/css/AdminLTE.min.css');?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('templates/plugins/iCheck/square/blue.css');?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page" style="background-image: url(<?php echo base_url(SAMPLE_PIC.'default/soft_bg.jpg');?>)">
<div class="login-box">
    <div style="margin-bottom: 0px;" class="login-logo">
    <a href="#l"><b><?PHP echo SYSTEM_NAME;?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="background: none;">
    <p class="login-box-msg">Sign in to start your session</p>

    <?php echo form_open('login/authenticate','id="signin-form_id" class="form-horizontal"'); ?>
      <div class="form-group has-feedback">
        <input  name="uname" type="text" class="form-control" placeholder="User Name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
 
       	<?php echo form_close(); ?>
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br> 
    <!--error mdg-->
        <?php  if($this->session->flashdata('error') != ''){ ?>
                <div class='alert alert-danger ' id="msg2">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
                <i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
                <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
                </div>
        <?php } ?> 
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('templates/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('templates/bootstrap/js/bootstrap.min.js');?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('templates/plugins/iCheck/icheck.min.js');?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
