<?php
	
	$result = array(
                        'id'=>"",
                        'customer_name'=>"",
                        'short_name'=>"",
                        'customer_type_id'=>"",
                        'description'=>"",
                        'reg_no'=>"",
                        'nic_no'=>"",
                        'license_no'=>"",
                        'hotel_representative'=>"",
                        'address'=>"",
                        'city'=>"",
                        'state'=>"10",
                        'postal_code'=>"",
                        'country'=>"LK",
                        'contact_person'=>"",
                        'phone'=>"",
                        'fax'=>"",
                        'email'=>"",
                        'website'=>"",
                        'commision_plan'=>"1",
                        'commission_value'=>"0",
                        'credit_limit'=>"0",
                        'customer_image'=>"default.jpg",
                        'status'=>1
                        );   		
	
	 $add_hide = "";
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
              
             <?php echo form_open_multipart("Customers/validate"); ?> 
                 <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Customer Information</a></li>
                    <li class="<?php echo ($action=='Add')?'hidden':'';?>"><a href="#tab_2" data-toggle="tab">Branches</a></li>  
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        
                        <div class="box-body fl_scroll">

                            <div class="row"> 
                                        <div class="col-md-6">

                                             <h5>Customer Information</h5>
                                             <div id="ajax_res"></div>
                                             <hr> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Customer Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('customer_name', set_value('customer_name',$result['customer_name']), 'id="customer_name" style=" text-transform:capitalize;"  class="form-control" placeholder="Enter Business Customer Name"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('customer_name');?>&nbsp;
                                                    </div> 
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Short Name<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('short_name', set_value('short_name',$result['short_name']), 'id="short_name" class="form-control" placeholder="Enter Short name"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('short_name');?>&nbsp;
                                                    </div> 
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Customer Type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('customer_type_id',$customer_type_list,set_value('customer_type_id',$result['customer_type_id']),' class="form-control select2" data-live-search="true" id="customer_type_id" '.$o_dis.'');?> 
                                                         <?php echo form_error('customer_type_id');?>&nbsp;
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
                                                    <label class="col-md-3 control-label">Street Address<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('address', set_value('address',$result['address']), 'id="address" class="form-control" style=" text-transform:capitalize;"  placeholder="Enter Street Address"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('address');?>&nbsp;
                                                    </div> 
                                                </div>


                                                <!--<div class="form-group col-md-12">-->
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">City<span style="color: red">*</span></label>
                                                        <div class="col-md-9">    
                                                             <?php echo form_input('city', set_value('city',$result['city']), 'id="city" class="form-control" style=" text-transform:capitalize;" placeholder="Enter City"'.$dis.' '.$o_dis.' '); ?>
                                                            <?php echo form_error('city');?>&nbsp;
                                                        </div> 
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Postcode</label>
                                                        <div class="col-md-9">    
                                                             <?php echo form_input('postal_code', set_value('postal_code',$result['postal_code']), 'id="postal_code" class="form-control"style=" text-transform:capitalize;"  placeholder="Enter Postal Code"'.$dis.' '.$o_dis.' '); ?>
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
                                           <h5>Discount & Credit Limit </h5>
                                           <hr>         
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Discount type</label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('commision_plan',array(''=>'Select Commission Plan','1'=>'% Percentage','2'=>'Fixed Amount'),set_value('commision_plan',$result['commision_plan']),' class="form-control select" data-live-search="true" id="commision_plan"'.$o_dis.'');?> 
                                                         <?php echo form_error('commision_plan');?>&nbsp;
                                                    </div> 
                                                </div>

                                                <div class="form-group">
                                                        <label class="col-md-3 control-label">Discount Value</label>
                                                        <div class="col-md-9">    
                                                             <?php echo form_input('commission_value', set_value('commission_value',$result['commission_value']), 'id="commission_value" class="form-control" placeholder="Enter Commission Amount or Value"'.$dis.' '.$o_dis.' '); ?>
                                                            <?php echo form_error('commission_value');?>&nbsp;
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                        <label class="col-md-3 control-label">Credit Limit</label>
                                                        <div class="col-md-9">    
                                                             <?php echo form_input('credit_limit', set_value('credit_limit',$result['credit_limit']), 'id="credit_limit" class="form-control" placeholder="Enter Credit Limit"'.$dis.' '.$o_dis.' '); ?>
                                                            <?php echo form_error('credit_limit');?>&nbsp;
                                                        </div>
                                                </div>


                                    </div> <div class="col-md-6 ">
                                       <h5>Attachment </h5>
                                       <hr>         
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Customer (Image)</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input(array('name'=>'customer_image', 'id'=>'customer_image', 'class'=>'form-control', 'type'=>'file'));?>
                                                         </div>    
                                                        <div><img class="thumbnail" style="size: 100%; width:100px;"  src="<?php echo base_url().CUSTOMER_IMAGES.$result['id'].'/'.(($result['customer_image']!='')?$result['customer_image']:'../default.jpg');?>"></div>
                                                        <span class="help-block"><?php echo form_error('customer_image');?></span>
                                                    </div>
                                                </div>
                                        

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2"> 
                        <div class="tab-content">
                            <div class="">
                                <a href="<?php echo base_url($this->router->fetch_class().'/add_branch/'.$result['id']);?>" class="btn btn-success pull-right"><span class="fa fa-plus-square"></span> New Branch</a>
                            </div>
                            <div>
                                     <table class="table table-striped">
                                            <tr>
                                              <th>Branch</th>
                                              <th>Short Name</th>
                                              <th>Contact Person</th> 
                                              <th>Sales Person</th> 
                                              <th>Phone</th> 
                                              <th>Action</th> 
                                            </tr>
                                            <?php
                                            if(isset($customer_branches)){
                                                foreach ($customer_branches as $branch){
                                                    echo '
                                                        <tr>
                                                            <td>'.$branch['branch_name'].'</td>
                                                            <td>'.$branch['branch_short_name'].'</td>
                                                            <td>'.$branch['contact_person'].'</td>
                                                            <td>'.$branch['contact_person'].'</td>
                                                            <td>'.$branch['phone'].'</td>
                                                            <td>
                                                                <a href="'. base_url($this->router->fetch_class().'/view_branch/'.$branch['customer_id'].'/'.$branch['id']).'" title="View" class="btn btn-primary btn-sm" target="blank" href="#"><span class="fa fa-eye"></span></a>
                                                                <a href="'. base_url($this->router->fetch_class().'/edit_branch/'.$branch['customer_id'].'/'.$branch['id']).'" title="Edit" class="btn btn-info btn-sm" target="blank" href="#"><span class="fa fa-edit"></span></a>
                                                                <a href="'. base_url($this->router->fetch_class().'/deletes_branch/'.$branch['customer_id'].'/'.$branch['id']).'" title="Remove" class="btn btn-danger btn-sm" target="blank" href="#"><span class="fa fa-trash"></span></a>
                                                            </td>
                                                        </tr>
                                                        ';

                                                }
                                            }
                                                
                                            ?> 
                                          </table>
                            </div>
                        </div>
                    </div> 
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
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
        if($('input[name=action]').val()=='Add' || $('input[name=action]').val()=='Edit'){
            if(!confirm("Click Ok to Confirm leave from here. This form may have unsaved data.")){
                   return false;
            }
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
              
//              $('#country').change(function(){
//                  $.ajax({
//			url: "<?php // echo site_url('Customers/fl_ajax');?>",
//			type: 'post',
//			data : {function_name:'get_states',country_id:$('#country').val()},
//			success: function(result){
//                             $("#ajax_res").html(result); 
//                             $.each(result, function(key, value) { 
//                             console.log(value) 
//                                    
//                                    $('#state').append($("<option></option>").attr("value",key).text(value)); 
//                               });
//                        }
//                    });
//                  fl_alert('info',)
//              });
              
//    $('#country').trigger('change');
});
</script>