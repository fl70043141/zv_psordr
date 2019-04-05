 
<script>
    
$(document).ready(function(){  
	get_results();
    $("#dropdown_val").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
    $("#dropdown_type").change(function(){ 
		event.preventDefault();
		get_results();
    }); 
    $("#status").click(function(){  
//		event.preventDefault();
		get_results();
    });
	  
	
	function get_results(){
                 $.ajax({
			url: "<?php echo site_url('DropDownList/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
                             
                              $('.datatable').DataTable();
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
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-search"></i>Search</a>':''; ?>

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
                                        <label class="col-md-3 control-label">Name<span style="color: red"></span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <?php // echo form_input('name', set_value('name'), 'id="name" class="form-control" placeholder="Search by Facility Name"'); ?>
                                                <?php echo form_input(array('name'=>'dropdown_val', 'id' => 'dropdown_val', 'class'=>'form-control','placeholder'=>'serach by Agent Name')); ?>
                                            </div>                                            
                                            <span class="help-block"><?php echo form_error('name');?></span>
                                        </div>
                                    </div>  
                                 <div class="form-group">
                                        <label class="col-md-3 control-label">Active</label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                 <label class="switch  switch-small">
                                                    <!--<input type="checkbox"  value="0">-->
                                                    <?php echo form_checkbox('status', set_value('status','1'),'1', 'id="status" placeholder="" '); ?>
                                                    <span></span>
                                                </label>
                                             </div>                                            
                                            <span class="help-block"><?php echo form_error('status');?>&nbsp;</span>
                                        </div>
                                    </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                       <label class="col-md-3 control-label">Type </label>
                                           <div class="col-md-9">                                            
                                               <div class="input-group">
                                                   <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                   <?php  echo form_dropdown('dropdown_type',$dropdown_list,set_value('dropdown_type'),' class="form-control select2" data-live-search="true" id="dropdown_type"');?>
                                                </div>                                             
                                           </div>
                                       </div> 
                                </div> 
                             
                        </div>
                    </div>
                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <a id="search_btn" class="btn btn-primary pull-right"><span class="fa fa-search"></span>Search</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div>
     <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Drop down list</h3>
            </div>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body"> </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 








