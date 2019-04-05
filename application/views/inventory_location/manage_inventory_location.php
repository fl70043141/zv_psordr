<?php
	
	$result = array(
                        'id'=>"",
                        'location_name'=>"",
                        'location_code'=>"",
                        'description'=>"",
                        'contact_person'=>"",
                        'address'=>"",
                        'phone'=>"",
                        'phone2'=>'', 
                        'email'=>'',  
                        'status'=>"1",
                        );   		
	
	 
	 $add_hide ='';
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
		$add_hide       = 'hidden'; 
	break;
	
	case 'Edit':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'View';
		$view		= 'hidden';
		$dis        = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

//var_dump($result);
?> 
<!-- Main content -->
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
            <div class="top_links">
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
               <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="'.$add_hide.' btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?> 
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'.base_url($this->router->fetch_class().'/edit/'.$result['id']).'" class="'.$add_hide.' btn btn-app "><i class="fa fa-pencil"></i>Edit</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$result['id']).'" class="'.$add_hide.' btn btn-app  '.(($action=='Delete')?'hide ':'').' "><i class="fa fa-trash"></i>Delete</a>':''; ?>
                 
            </div>
        </div>
 <br><hr>
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $action;?> Inventory Location</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart($this->router->fetch_class()."/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                        
                                            
                                            
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h5>Location Info</h5>
                                                    <hr>
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Location<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('location_name', set_value('location_name', $result['location_name']), 'id="location_name" class="form-control" placeholder="Enter Location name"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('location_name');?>&nbsp;  
                                                    </div> 
                                                </div> 
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Code/Short Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('location_code', set_value('location_code', $result['location_code']), 'id="location_name" class="form-control" placeholder="Enter Short Name or code for Location"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('location_code');?>&nbsp;  
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Description<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter description' ), set_value('description',$result['description']),$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('description');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Active</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('status', set_value('status','1'),$result['status'], 'id="status" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('status');?>&nbsp;</span>
                                                    </div>
                                                </div> 
                                                
                                            </div>
                                          
                                         <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <h5>Contact Info</h5>
                                                    <hr>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Contact Person<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('contact_person', set_value('contact_person', $result['contact_person']), 'id="contact_person" class="form-control" placeholder="Person for contact"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('contact_person');?>&nbsp;  
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Address<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('address', set_value('address', $result['address']), 'id="address" class="form-control" placeholder="Adress"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('address');?>&nbsp;  
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Contact No<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('phone', set_value('phone', $result['phone']), 'id="phone" class="form-control" placeholder="Contact Number"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('phone');?>&nbsp;  
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Other Contact <span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('phone2', set_value('phone2', $result['phone2']), 'id="phone2" class="form-control" placeholder="Contact other "'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('phone2');?>&nbsp;  
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Email <span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('email', set_value('email', $result['email']), 'id="email" class="form-control" placeholder="Enter email address "'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('email');?>&nbsp;  
                                                    </div> 
                                                </div> 
                                          
                                         </div>
                                             
                        </div>
                    </div>
                          <!-- /.box-body -->

                    <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',constant($action) ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url($this->router->fetch_class()),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php // echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url($this->router->fetch_class()),'OK','class="btn btn-primary"');
                                    } ?>
                      <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                    </div>
                  </form>
                </div>
                <!-- /.box -->
          </div> 
    </section> 
  
<script>
$(document).ready(function(){   
        $("form").submit(function(){ 
            if(!confirm("Click Ok to Confirm form Submition.")){
                   return false;
            }
        });
        
 
    $(".top_links a").click(function(){ 
        if($('input[name=action]').val()=='Add' || $('input[name=action]').val()=='Edit'){
            if(!confirm("Click Ok to Confirm leave from here. This form may have unsaved data.")){
                   return false;
            }
        }
    });
    
    });
</script>