<?php
	
//                        echo '<pre>';            print_r($customer_branch_det['']); die;
	$result = array(
                        'id'=>"",
                        'branch_name'=>"",
                        'branch_short_name'=>"",
                        'sales_person_id'=>"",
                        'contact_person'=>"",
                        'description'=>"", 
                        'mailing_address'=>"",
                        'billing_address'=>"",
                        'phone'=>"",
                        'fax'=>"",
                        'email'=>"", 
                        'licence_image'=>"default.jpg",
                        'status'=>1
                        );   		
	
	 
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Edit':
		if(!empty($customer_branch_det)){$result= $customer_branch_det;} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($customer_branch_det)){$result= $customer_branch_det;} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($customer_branch_det)){$result= $customer_branch_det;} 
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
            <div class="">
                <a href="<?php echo base_url($this->router->fetch_class().'/edit/'. $customer_det['id']);?>" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>
                <!--<a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>-->
                <!--<a href="<?php // echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>-->
                <!--<a class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>-->
            </div>
        </div>
 <br><hr>
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $action;?> Branch for <?php echo $customer_det['customer_name'];?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart("Customers/validate_branch"); ?> 
                  
                        <div class="box-body fl_scroll">

                            <div class="row"> 
                                        <div class="col-md-6">

                                             <h5> Information</h5>
                                             <hr> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Branch Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('branch_name', set_value('branch_name',$result['branch_name']), 'id="branch_name" class="form-control" placeholder="Enter Business Customer Name"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_hidden('customer_id', $customer_det['id']); ?>
                                                        <?php echo form_error('branch_name');?>&nbsp;
                                                    </div> 
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Short Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('branch_short_name', set_value('branch_short_name',$result['branch_short_name']), 'id="branch_short_name" class="form-control" placeholder="Enter Short name"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('branch_short_name');?>&nbsp;
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
                                                    <label class="col-md-3 control-label">Sales Person<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('sales_person_id',$sales_person_list,set_value('sales_person_id',$result['sales_person_id']),' class="form-control select" data-live-search="true" id="sales_person_id"'.$o_dis.'');?> 
                                                         <?php echo form_error('sales_person_id');?>&nbsp;
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


                                         </div>


                                        <div class="col-md-6">
                                            
                                              <h5>Contact Information</h5>
                                             <hr> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Contact Person<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('contact_person', set_value('contact_person',$result['contact_person']), 'id="contact_person" class="form-control" placeholder="Enter contact person name"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('contact_person');?>&nbsp;
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Mailing Address<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_textarea(array('name'=>'mailing_address','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter mailing address' ), set_value('mailing_address', $result['mailing_address']),$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('mailing_address');?>&nbsp;
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Billing Address<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_textarea(array('name'=>'billing_address','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter billing address' ),set_value('billing_address', $result['billing_address']),$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('billing_address');?>&nbsp;
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
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url($this->router->fetch_class()),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

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