<?php
	
	$result = array(
                        'id'=>"",
                        'addon_name'=>"",
                        'description'=>"",
                        'active_from'=>strtotime(date('m/d/Y')),
                        'active_to'=>strtotime('+1 months',strtotime(date('m/d/Y'))),
                        'currency_code'=>"LKR",
                        'ignore_end_date'=>"",
                        'status'=>"",
                        'addon_value'=>"",
                        'addon_type'=>"",
                        'calculation_type'=>"",
                        'calculation_included'=>"",
                        'calculation_included_addons'=>"",
                        'debit_gl_code'=>"", 
                        'credit_gl_code'=>"", 
            
                        'status'=>""
                        );   		
	
	 
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
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
            <div class="">
                <a href="<?php echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
                <a href="<?php echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>
                <!--<a class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>-->
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
              
             <?php echo form_open_multipart("Addons/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                        
                                            <div class="col-md-12">
                                                <h5>Addon Info</h5>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Addon Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('addon_name', set_value('addon_name',$result['addon_name']), 'id="addon_name" class="form-control" placeholder="Enter Business Agent Name"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('addon_name');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group"> 

                                                             <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter description' ),$result['description'],$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('description');?><br></span>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Date from<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                             <?php echo form_input('active_from', set_value('active_from',date('m/d/Y',$result['active_from'])), 'id="active_from" class="form-control datepicker" readonly placeholder="Select Date"'.$dis.' '.$o_dis.' '); ?>
                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('active_from');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Date to<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                             <?php echo form_input('active_to', set_value('active_to',date('m/d/Y',$result['active_to'])), 'id="active_to" class="form-control datepicker" readonly placeholder="Select Date"'.$dis.' '.$o_dis.' '); ?>
                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('active_to');?></span>
                                                    </div>
                                                </div>
                                            </div>
                            
                                         <div class="col-md-4">
                                             <div class="form-group">
                                                    <label class="col-md-3 control-label">Ignore End Date</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('ignore_end_date', set_value('ignore_end_date','1'),$result['ignore_end_date'], 'id="ignore_end_date" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('ignore_end_date');?>&nbsp;</span>
                                                    </div>
                                                </div> 
                                         </div>
                                         <div class="col-md-6">
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
                                         
                                            <div class="col-md-12">
                                                <h5>Addon Calculations</h5>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Addon Value<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('addon_value', set_value('addon_value',$result['addon_value']), 'id="addon_value" class="form-control" placeholder="Enter Business Agent Name"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('addon_value');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-12">  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Addon Type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('addon_type',$addon_type_list,set_value('addon_type',$result['addon_type']),' class="form-control select2" data-live-search="true" id="addon_type" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('addon_type');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Calculation Type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('calculation_type',$calculation_type_list,set_value('calculation_type',$result['calculation_type']),' class="form-control select2" data-live-search="true" id="calculation_type" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('calculation_type');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="included_div">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Calculation Included<span style="color: red">*</span></label>
                                                    <div class="col-md-4">    
                                                         <?php  echo form_dropdown('calculation_included[]',$calculation_included_list,set_value('calculation_included', json_decode($result['calculation_included'])),' class="form-control select2" multiple="multiple"   data-live-search="true" id="calculation_included" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('calculation_included');?>&nbsp;</span>
                                                    </div> 
                                                    <div class="col-md-4 col-md-offset-1">    
                                                         <?php  echo form_dropdown('calculation_included_addons[]',$calculation_included_addons_list,set_value('calculation_included_addons',json_decode($result['calculation_included_addons'])),' class="form-control select2" multiple="multiple"   data-live-search="true" id="calculation_type" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('calculation_included_addons');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="currency_div">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Calculation Included<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('currency_code');?>&nbsp;</span>
                                                    </div>  
                                                </div>
                                            </div>
                                            
                                          
                            
                            
                                            <div class="col-md-12">
                                                <br>
                                                <h5>GL SETTINGS</h5>
                                                <hr>
                                            </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Debit Account<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('debit_gl_code',$gl_acc_list,set_value('debit_gl_code',$result['debit_gl_code']),' class="form-control select2" data-live-search="true" id="debit_gl_code" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('debit_gl_code');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Credit Account<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('credit_gl_code',$gl_acc_list,set_value('credit_gl_code',$result['credit_gl_code']),' class="form-control select2" data-live-search="true" id="credit_gl_code" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('credit_gl_code');?>&nbsp;</span>
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
 
<script>
    
$(document).ready(function(){  
    included_show();
    $('#calculation_type').change(function(){
        included_show();
    });
    function included_show(){
        var cal_type_val = $('#calculation_type').val(); 
        if(cal_type_val==2){ 
            $('#included_div').show(); 
            $('#currency_div').hide(); 
        }else{
            if(cal_type_val==1){
                $('#currency_div').show(); 
            }
            $('#included_div').hide(); 
        }
    }
});
</script>