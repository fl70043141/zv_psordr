<?php
	
	$result = array(
                        'id'=>"",
                        'supplier_name'=>"",
                        'supplier_ref'=>"",
                        'description'=>"",
                        'reg_no'=>"", 
                        'address'=>"",
                        'city'=>"",
                        'state'=>"3",
                        'postal_code'=>"",
                        'country'=>"LK",
                        'contact_person'=>"",
                        'phone'=>"",
                        'fax'=>"",
                        'email'=>"",
                        'website'=>"",
                        'supp_account_no'=>"",
                        'bank_account_no'=>"",
                        'bank_account_name'=>"",
                        'bank_account_branch'=>"",
                        'currency_code'=>"LKR", 
                        'payment_terms'=>"", 
                        'credit_limit'=>"1000000", 
                        'status'=>1
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
                  <h3 class="box-title"><?php echo $action;?> </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart($this->router->fetch_class()."/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                            <div class="col-md-6">
                                        
                                         <h5>Supplier Information</h5>
                                         <hr> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Supplier Name<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('supplier_name', set_value('supplier_name',$result['supplier_name']), 'id="supplier_name" class="form-control" placeholder="Enter Supplier Name"'.$dis.' '.$o_dis.' '); ?>
                                                   <?php echo form_error('supplier_name');?>&nbsp;
                                                </div> 
                                            </div>
                                            
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Supplier Code<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('supplier_ref', set_value('supplier_ref',$result['supplier_ref']), 'id="supplier_ref" class="form-control" placeholder="Enter any Reference"'.$dis.' '.$o_dis.' '); ?>
                                                   <?php echo form_error('supplier_ref');?>&nbsp;
                                                </div> 
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group"> 
                                                        
                                                         <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter description' ),$result['description'],$dis.' '.$o_dis.' '); ?>

                                                    </div>                                            
                                                   <?php echo form_error('description');?><br>
                                                </div>
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Registration Number</label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('reg_no', set_value('reg_no',$result['reg_no']), 'id="license_no" class="form-control" placeholder="Enter Registration  Number"'.$dis.' '.$o_dis.' '); ?>
                                                   <?php echo form_error('reg_no');?>&nbsp;
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
                                                        <?php echo form_error('status');?>&nbsp;
                                                    </div>
                                                </div> 
                                         
                                          <h5>Contact Information</h5>
                                         <hr> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Contact Person<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('contact_person', set_value('contact_person',$result['contact_person']), 'id="contact_person" class="form-control" placeholder="Enter Contact Person  Name"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('contact_person');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('phone', set_value('phone',$result['phone']), 'id="phone" class="form-control" placeholder="Enter Phone Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('phone');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Fax</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('fax', set_value('fax',$result['fax']), 'id="fax" class="form-control" placeholder="Enter Fax Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('fax');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('email', set_value('email',$result['email']), 'id="email" class="form-control" placeholder="Enter Email Address"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('email');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Website</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('website', set_value('website',$result['website']), 'id="website" class="form-control" placeholder="Enter Website URL"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('website');?>&nbsp;
                                                </div> 
                                            </div>
                                             
                                     </div>
                                        
                                        
                                    <div class="col-md-6">
                                       <h5>Address Information </h5>
                                       <hr>    
                                             
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Street Address<span style="color: red"> </span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('address', set_value('address',$result['address']), 'id="address" class="form-control" placeholder="Enter Street Address"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('address');?>&nbsp;
                                                </div> 
                                            </div>
                                             
                                            
                                            <!--<div class="form-group col-md-12">-->
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">City<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('city', set_value('city',$result['city']), 'id="city" class="form-control" placeholder="Enter City"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('city');?>&nbsp;
                                                    </div> 
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Postcode</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('postal_code', set_value('postal_code',$result['postal_code']), 'id="postal_code" class="form-control" placeholder="Enter Postal Code"'.$dis.' '.$o_dis.' '); ?>
                                                       <?php echo form_error('postal_code');?>&nbsp;
                                                    </div> 
                                                </div>
                                            <!--</div>-->
                                       
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Country</label>
                                                <div class="col-md-9">    
                                                     <?php  echo form_dropdown('country',$country_list,set_value('country',$result['country']),' class="form-control select2" data-live-search="true" id="country"'.$o_dis.'');?> 
                                                    <?php echo form_error('country');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">State</label>
                                                    <div class="col-md-9">    
                                                        <?php  echo form_dropdown('state',$country_state_list,set_value('state',$result['state']),' class="form-control select2" data-live-search="true" id="state"'.$o_dis.'');?> 
                                                        <?php echo form_error('state');?>&nbsp;
                                                    </div>
                                            </div>
                                           
                                       
                                    </div>
                                            
                                       
                                    <div class="col-md-6 ">
                                       <h5>Supplier Payments Info </h5>
                                       <hr>          
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C No</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_no', set_value('bank_account_no',$result['bank_account_no']), 'id="bank_account_no" class="form-control" placeholder="Enter Bank Account No"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('bank_account_no');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C Name</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_name', set_value('bank_account_name',$result['bank_account_name']), 'id="bank_account_name" class="form-control" placeholder="Enter Bank Account name"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_account_name');?>&nbsp; 
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C Branch</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_branch', set_value('bank_account_branch',$result['bank_account_branch']), 'id="bank_account_name" class="form-control" placeholder="Enter Bank Account Branch"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_account_branch');?>&nbsp; 
                                                    </div>
                                            </div>
                                       
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Credit Limit</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('credit_limit', set_value('credit_limit',$result['credit_limit']), 'id="credit_limit" class="form-control" placeholder="Enter Credit Limit"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('credit_limit');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Currency</label>
                                                    <div class="col-md-9">    
                                                        <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"'.$o_dis.'');?> 
                                                        <?php echo form_error('currency_code');?>&nbsp;
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
                                    <?php echo form_submit('submit', constant($action) ,'class="btn btn-primary"'); ?>&nbsp;

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
 
 
<!--     //image Lightbox-->
     <div tabindex="-1" class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content"> 
                  <div align="" class="modal-body">
                      <div><center><img class="model_img"   src=""></center> </div>
                  </div>
                  <div class="modal-footer">
                          <button class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
             </div>
            </div>
          </div>
 <style>
    .modal-dialog {width:800px;}
    .thumbnail {margin-bottom:6px;}
    .modal-body {width:800px; align:center;}
    .model_img {width: 500px;}
</style>
<script>
    
$(document).ready(function(){  
    $("form").submit(function(){ 
        if(!confirm("Click Ok to Confirm form Submition.")){
               return false;
        }
    });
    $(".top_links a").click(function(){ 
        if(!confirm("Click Ok to Confirm leave from here. This form may have unsaved data.")){
               return false;
        }
    });
    
    $('#icon_view').addClass($('#icon').val());
    $("#icon").keyup(function(){ 
//		fl_alert('info',);
                $('#icon_view').removeClass();
                $('#icon_view').addClass($('#icon').val());
    });
     $('.thumbnail').click(function(){ 
                      var title = $(this).parent('a').attr("src");
                      $(".model_img").attr("src",this.src); 
                      $('#myModal').modal({show:true});
                      
              }); 
});
</script>