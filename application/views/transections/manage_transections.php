<?php
$get_inpt = $this->input->get();
$so_del_hide='';
if(isset($get_inpt['sodel'])){
    $so_del_hide = 'hidden';
//     echo "<script>window.close();</script>";
} 
	
	$result = array(
                        'id'=>"",
                        'tt_name'=>"",
                        'trans_memo'=>"",
                        'trans_date'=>strtotime(date('m/d/Y')),
                        'active_to'=>strtotime('+1 months',strtotime(date('m/d/Y'))),
                        'currency_code'=>"LKR",
                        'status'=>"",
                        'addon_value'=>"",
                        'addon_type'=>"",
                        'calculation_type'=>"",
                        'calculation_included'=>"",
                        'calculation_included_addons'=>"",
            
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

//echo '<pre>';print_r($result);
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
            <div <?php echo $so_del_hide;?> class="">
                <!--<a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>-->
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
              
             <?php echo form_open_multipart("Transections/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                        
                                            <div class="col-md-12">
                                                <h5>Transection Info</h5>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Trans Name<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('tt_name', set_value('tt_name',$result['tt_name']), 'id="tt_name" class="form-control" placeholder="Transection Typw"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('tt_name');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Reference <span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('trans_reference', set_value('trans_reference',(($result['person_type']==10)?$result['trans_reference']:$result['trans_reference'])), 'id="trans_reference" class="form-control" placeholder="Transection Typw"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('trans_reference');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Amount <span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('transection_amount', set_value('transection_amount', number_format($result['transection_amount'],2)), 'id="transection_amount" class="form-control" placeholder="Transection Typw"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('transection_amount');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="col-md-3 control-label">Memo/note</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group"> 

                                                             <?php echo form_textarea(array('name'=>'trans_memo','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter trans_memo' ),$result['trans_memo'],$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('trans_memo');?><br></span>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Date<span style="color: red"></span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                             <?php echo form_input('trans_date', set_value('trans_date',date('m/d/Y',$result['trans_date'])), 'id="trans_date" class="form-control " readonly placeholder="Select Date"'.$dis.' '.$o_dis.' '); ?>
                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('trans_date');?></span>
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
                                    <?php echo form_hidden('sodel',((isset($get_inpt['sodel']))?'1':'')); ?>
                                    <?php echo form_submit('submit','Void Transection','class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url($this->router->fetch_class()),'Back','class="btn btn-info  '.((isset($get_inpt['sodel']))?'hide':'').' "');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default hide"  '); ?>

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
     $("input[name = 'submit']").click(function(){
         if(confirm("Click Ok to void confirmation")){
             return true;
         }else{
             return false;
         }
    });
});
</script>