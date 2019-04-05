<?php
	
	$result = array(
                        'id'=>"",
                        'title'=>"",
                        'code'=>"",
                        'symbol_left'=>"1",
                        'symbol_right'=>"1",
                        'decimal_place'=>"4",
                        'value'=>0,
                        'status'=>"1"
                        );   		
	
	 
	switch($action):
	case 'Add':
                $result['curr_rate'] = $result['value'];
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
                  <h3 class="box-title"><?php echo $action;?> Customer Type</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart($this->router->fetch_class()."/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label class="col-md-3 control-label">Rate: <span style="color: red">*</span></label>
                                <div class="col-md-9">    
                                    <?php echo form_input('value', set_value('value', round($result['curr_rate'],4)), 'id="value" class="form-control" placeholder="Enter Customer Type Name"'.$dis.' '.$o_dis.' '); ?>
                                    <?php echo form_error('value');?>&nbsp;  
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <hr>
                        <div class="row"> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency Name<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_input('title', set_value('title', $result['title']), 'id="value" class="form-control" placeholder="Enter Currency Name"'.$dis.' '.$o_dis.' '); ?>
                                        <?php echo form_error('title');?>&nbsp;  
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Left Symbol<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_input('symbol_left', set_value('symbol_left', $result['symbol_left'],true), 'id="symbol_left" class="form-control" placeholder="Enter Curency Symbol.."'.$dis.' '.$o_dis.' '); ?>
                                        <?php echo form_error('symbol_left');?>&nbsp;  
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
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Code<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_input('code', set_value('code', $result['code']), 'id="code" class="form-control" placeholder="Enter Currency Code.."'.$dis.' '.$o_dis.' '); ?>
                                        <?php echo form_error('code');?>&nbsp;  
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Right Symbol<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_input('symbol_right', set_value('symbol_right', $result['symbol_right'],true), 'id="symbol_right" class="form-control" placeholder="Enter Curency Symbol.."'.$dis.' '.$o_dis.' '); ?>
                                        <?php echo form_error('symbol_right');?>&nbsp;  
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
                                    <?php echo form_submit('submit',constant($action) ,'class="btn btn-primary"'); ?>&nbsp;

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
        $("form").submit(function(){ 
            if(!confirm("Click Ok to Confirm form Submition.")){
                   return false;
            }
        });
    
    });
</script>