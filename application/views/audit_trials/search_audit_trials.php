
<script>
    
$(document).ready(function(){  
	get_results();
    $("#user_name").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
	
    $("#object").change(function(){ 
		event.preventDefault();
		 get_results();
    });
    
	
    $("#action").change(function(){
		event.preventDefault();
		get_results();
    });
    
    $("#search_btn").click(function(){
		event.preventDefault();
		get_results();
                  $(".dataTable").DataTable();
    });
	
	
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('AuditTrials/search_audit_trials');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){ 
                             $("#result_test").html(result); 
                             $(".dataTable").DataTable();
        }
		});
	}
});
</script>
 

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
            <!--<a  href="<?php // echo base_url($this->router->fetch_class()."/add");?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>-->
            <a href="<?php echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>

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
                                    <label class="col-md-3 control-label">Name</label>
                                    <div class="col-md-9">                                            
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                          <?php echo form_input(array('name'=>'user_name', 'id' => 'user_name', 'class'=>'form-control','placeholder'=>'First name or last name')); ?>
                                        </div>                                            
                                        <!--<span class="help-block">This is sample of text field</span>-->
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Object</label>
                                    <div class="col-md-9">                                            
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                             <?php  echo form_dropdown('object',$module_list,set_value('object'),' class="form-control select2" id="object"');?>
                                        </div>                                             
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Actions</label>
                                    <div class="col-md-9">                                            
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                            <?php  echo form_dropdown('action[]',$action_list,set_value('action'),' class="form-control select2" multiple="multiple"  data-placeholder="Select a Action" id="action"');?>
                                        </div>                                             
                                    </div>
                                </div> 
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date From</label>
                                    <div class="col-md-9">                                            
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                          <?php echo form_input(array('name'=>'date_from', 'readonly' => 'readonly', 'id' => 'date_from', 'class'=>'datepicker form-control','placeholder'=>'Select Start Date')); ?>
                                        </div>                                             
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date to</label>
                                    <div class="col-md-9">                                            
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>

                                          <?php echo form_input(array('name'=>'date_to', 'id' => 'date_to', 'readonly' => 'readonly', 'class'=>'datepicker form-control','placeholder'=>'Select End Date ')); ?>
                                        </div>                                            
                                        <!--<span class="help-block">This is sample of text field</span>-->
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
              <h3 class="box-title">Search Result</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="result_test">
              
            </div>
            <!-- /.box-body -->
          </div>
       
     </div>
    
</div>
