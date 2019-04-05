
<script>
    
$(document).ready(function(){  
	get_results();
    $("#receive_no").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
	 
    $("#search_btn").click(function(){
		event.preventDefault();
		get_results();
    });
    $("#received_date").change(function(){
		event.preventDefault();
		get_results();
    }); 
//    $("#status").change(function(){
//		event.preventDefault();
//		get_results();
//    });
	
	
	function get_results(){
        $("#result_search").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
        $.ajax({
			url: "<?php echo site_url('Order_receivals/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
                             $(".dataTable").DataTable();
        }
		});
	}
});
</script>
 
<?php // echo '<pre>'; print_r($facility_list); die;?>

<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

    <!--Flash Error Msg-->
        <?php  if($this->session->flashdata('error') != ''){ ?>
        <div class='alert alert-danger ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
        </div>
        <?php } ?>

        <?php  if($this->session->flashdata('warn') != ''){ ?>
        <div class='alert alert-success ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('warn'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
        </div>
        <?php } ?>  
    
        <div class="">
           <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class=" btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?> 
             
        </div>
    </div>
    
 <br><hr>
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Search </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        <div class="row"> 
                            <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Receive No:<span style="color: red"></span></label>
                                        <div class="col-md-9">                                     
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <?php echo form_input('receive_no', set_value('receive_no'), 'id="receive_no" class="form-control" placeholder="Search by Invoice Number"'); ?>

                                            </div>                                             
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Order No:<span style="color: red"></span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <?php echo form_input('order_no', set_value('order_no'), 'id="order_no" class="form-control" placeholder="Search by Order No"'); ?>
                                            </div>                                             
                                        </div>
                                    </div>   
                                </div> 
                            <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Received on:<span style="color: red"></span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <?php echo form_input('received_date', set_value('received_date'), 'readonly  id="received_date" class="form-control datepicker" placeholder="Select Submitted Date"'); ?>

                                            </div>                                             
                                        </div>
                                    </div>   
                                </div> 
                        </div>
                    </div>
                <div class="panel-footer">
                    <button type="reset" class="btn btn-default">Clear Form</button>                                    
                                    <a id="search_btn" class="btn btn-primary pull-right"><span class="fa fa-search"></span>Search</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div>
     <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">item receive history</h3>
            </div>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body"> </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 