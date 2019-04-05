
  <header class="main-header">
      <?php // echo '<pre>';      print_r($_SESSION);?>
    <!-- Logo -->
    <a href="<?php echo base_url('dashboard');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo SYSTEM_SHOTR_NAME;?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo SYSTEM_NAME;?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top ">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav"> 
          <!-- User Account: style can be found in dropdown.less -->
          <li id="temp_so_order_list_res" class="dropdown notifications-menu">
            
          </li>
          <li id="temp_invoice_top_list_res" class="dropdown notifications-menu">
            
          </li>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url(USER_PROFILE_PIC.$_SESSION[SYSTEM_CODE]['user_name'].'/'.$_SESSION[SYSTEM_CODE]['profile_pix'])?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION[SYSTEM_CODE]['user_first_name'].' '.$_SESSION[SYSTEM_CODE]['user_last_name'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                  <img src="<?php echo base_url(USER_PROFILE_PIC.$_SESSION[SYSTEM_CODE]['user_name'].'/'.$_SESSION[SYSTEM_CODE]['profile_pix'])?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION[SYSTEM_CODE]['user_first_name'].' '.$_SESSION[SYSTEM_CODE]['user_last_name'].' - '.$_SESSION[SYSTEM_CODE]['user_role'];?>
                    <small>-<?php echo $_SESSION[SYSTEM_CODE]['user_name'];?>-</small>
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                    <a href="<?php echo base_url("Users/edit/".$_SESSION[SYSTEM_CODE]['ID']);?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div hidden class="pull-left">
                    <a id="show_second_display" href="#" class="btn btn-default btn-flat">Second Display</a>
                </div>
                <div class="pull-right">
                    <a href="<?php echo base_url('logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
<script>
    $(document).ready(function(){    
        $.ajax({
			url: "<?php echo site_url('Dashboard/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_temp_salesorder_user'},
			success: function(result){
//                            console.log(result)
                            $('#temp_so_order_list_res').html(result);
                        }
        });
        
       
        $('#show_second_display').click(function(){ 
            fl_alert('info',)
             myWindow = window.open('<?php echo base_url("Banners/extended_display");?>', '', 'width=200, height=100');    // Opens a new window
//            myWindow.document.write("<p>This is 'myWindow'</p>");       // Some text in the new window
            
            myWindow.moveTo(2500, 600);                                  // Moves the new window    
            myWindow.focus(); 
        });
    });
</script>
        