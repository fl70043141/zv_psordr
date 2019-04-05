<?php
	
	$result = array(
                        'id'=>"",
                        'account_name'=>"", 
                        'amount'=>"", 
                        'quick_entry_account_id'=>"", 
                        'credit_gl_code'=>"", 
                        'status'=>"1",
                        );   		
	
	 
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Edit':
		if(!empty($user_data)){$result= $user_data;} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($user_data)){$result= $user_data;} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($user_data)){$result= $user_data;} 
		$heading	= 'View';
		$view		= 'hidden';
		$dis        = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

//            echo '<pre>'; print_r($result);  
?> 

<script>
    $(document).ready(function(){   
        $("form").submit(function(){ 
            if(!confirm("Click Ok to Confirm form Submition.")){
                   return false;
            }
        });
    
    });
</script>
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
                  <h3 class="box-title"><?php echo $action;?> Quick Entry Account</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart($this->router->fetch_class()."/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                        
                                            <div class="col-md-6"> 
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Entry Name<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('account_name', set_value('account_name', $result['account_name']), 'id="account_name" class="form-control" placeholder="Ledger Account Name"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_hidden('quick_entry_account_id',$result['quick_entry_account_id']);?>
                                                        <span class="help-block"><?php echo form_error('account_name');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                            </div> 
                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Amount<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('amount', set_value('amount', $result['amount']), 'id="amount" class="form-control" placeholder="Eg Code"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('amount');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Currency<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('currency_code', set_value('currency_code', $result['currency_code']), 'id="currency_code" class="form-control" placeholder="Eg Currency Code"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('currency_code');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Memo<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('memo', set_value('memo', $result['memo']), 'id="currency_code" class="form-control" placeholder="-"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('memo');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                            </div> 
                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Entry Date<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('entry_date', set_value('entry_date', date(SYS_DATE_FORMAT,$result['entry_date'])), 'id="entry_date" class="form-control" placeholder="Eg Date"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('entry_date');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                            </div> 
                                                  
                                          
                                          
                        </div>
                    </div> 
                    <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',constant($action),'class="btn btn-primary"'); ?>&nbsp;

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
  