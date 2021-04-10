
<script>
    
$(document).ready(function(){  
	get_results();
    $("#item_name").keyup(function(){ 
		event.preventDefault();
//		get_results();
    }); 
    $("#item_code").keyup(function(){ 
		event.preventDefault();
//		get_results();
    }); 
    $("#status").change(function(){ 
		event.preventDefault();
//		get_results();
    }); 
    $("#item_category_id").change(function(){ 
		event.preventDefault();
//		get_results();
    }); 
    $("#search_btn").click(function(){ 
		event.preventDefault();
		get_results();
    }); 
    $("#clear_itmserch").click(function(){
        $('#item_category_id').val(2).prop('selected', true);
//        fl_alert('info',)
    }); 
	function get_results(){
        $("#result_search").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');  
        $.ajax({
			url: "<?php echo site_url('Items/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
//                             $(".dataTable").DataTable();
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
             <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
            <?php // echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-search"></i>Search</a>':''; ?>

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
                            <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Search by Name<span style="color: red"></span></label>
                                        <div class="col-md-7">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                <?php echo form_input('item_name', set_value('item_name'), 'id="item_name" class="form-control" placeholder="Search by Item Name"'); ?>
 
                                            </div>                                            
                                        </div>
                                    </div> 
                                </div> 
                            
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Search by Code<span style="color: red"></span></label>
                                        <div class="col-md-7">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                <?php echo form_input('item_code', set_value('item_code'), 'id="item_code" class="form-control" placeholder="Search by Item Code"'); ?>

                                            </div>                                             
                                        </div>
                                    </div> 
                                </div>  
                            
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Category<span style="color: red"></span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                          <?php  echo form_dropdown('item_category_id',$item_category_list,set_value('item_category_id'),' class="form-control select2" data-live-search="true" id="item_category_id"');?> 

                                                    </div>                                            
                                                </div>
                                        </div>  
                                    </div>
                            <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Rows<span style="color: red"></span></label>
                                        <div class="col-md-7">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                <?php echo form_input('row_limit', set_value('row_limit',100), 'id="row_limit" class="form-control" placeholder="row_limit"'); ?>

                                            </div>                                             
                                        </div>
                                    </div> 
                                </div>
                            
                                <div class="col-md-4"> 
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Active</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                         <label class="switch  switch-small">
                                                            <!--<input type="checkbox"  value="0">-->
                                                            <?php echo form_checkbox('status', set_value('status'),1, 'id="status" '); ?>
                                                            <span></span>
                                                        </label>
                                                     </div>                                            
                                                </div>
                                            </div>  
                                         </div>
                             
                        </div>
                    </div>
                <div   class="panel-footer">
                    <button id="clear_itmserch" type="reset" class="btn btn-default">Clear Form</button>                                    
                                    <a id="search_btn" class="btn btn-primary pull-right"><span class="fa fa-search"></span>Search</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div>
     <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Item List</h3>
            </div>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body"> </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 