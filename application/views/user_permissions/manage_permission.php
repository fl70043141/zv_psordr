
<script>
    
    $(document).ready(function(){ 
		event.preventDefault();
        $('.select_field').click(function(){ 
       
        });
    }); 
</script>
<?php
	
	$result = array(
                        'id'=>"",
                        'agent_name'=>"",
                        'short_name'=>"",
                        'agent_type_id'=>"",
                        'description'=>"",
                        'reg_no'=>"",
                        'hotel_representative'=>"",
                        'address'=>"",
                        'city'=>"",
                        'state'=>"",
                        'postal_code'=>"",
                        'country'=>"",
                        'contact_person'=>"",
                        'phone'=>"",
                        'fax'=>"",
                        'email'=>"",
                        'website'=>"",
                        'commision_plan'=>"1",
                        'commission_value'=>"0",
                        'credit_limit'=>"0",
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
		if(!empty($property_data[0])){$result= $property_data[0];} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($property_data[0])){$result= $property_data[0];} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($property_data[0])){$result= $property_data[0];} 
		$heading	= 'View';
		$view		= 'hidden';
		$dis        = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

//echo '<pre>'; print_r($permission_data); 
?>
 <div class="row">
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
                            
                            
                            <br>
                            <?php echo form_open_multipart("userPermission/validate/".$urole_id.""); ?> 
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?=$action?></strong> User Permissions</h3>
                                </div>
                                 
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                     <div class="col-md-6">
 
            
                            <!-- START ACCORDION -->        
                            <div class="panel-group accordion accordion-dc"> 
                                <?php
                                foreach ($permission_data as $permission){
                              ?>
                                
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                      <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#accTwoColOne_<?php echo $permission['id']; ?>">
                                            <?php echo $permission['name']; ?>
                                        </a>
                                      </h4>
                                        <input id="selectall_<?php echo $permission['id']; ?>" type="checkbox" class="checkbox selectall">
                                    </div>
                                    
                                    <div  id="accTwoColOne_<?php echo $permission['id']; ?>"  class="panel-collapse collapse in">
                                        <div class="box-body">
                                            <table class="table table-striped">
                                        
                                                <tbody>
                                                    <?php
                                                        foreach ($permission['p_data'] as $p_data){
                                                            $checked = '';
                                                            if($p_data['ur_status'] == 1){
                                                                $checked = 'checked';
                                                            }
                                                            echo '<tr>
                                                                        <td width="90%">'.$p_data['name'].'</td>
                                                                        <td width="10%"><input '.$checked.' class="permissioncb_'.$permission['id'].'" type="checkbox" name="permission_cb['.$permission['id'].']['.$p_data['id'].']"></td> 
                                                                    </tr>';
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                            
                                   
                              <?php     
                                }
                                ?>
                              
                                
                            </div>
                            <!-- END ACCORDION -->

                        </div>
                                <div class="panel-footer">
                                    <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('user_role_id', $urole_id); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('userPermission'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('agents'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    
                            
<script>
    $(document).ready(function(){
        $('.selectall').change(function(){
            var cur_id = this.id;
            var p_id = (this.id).split("_")[1];
            if($('#'+cur_id).prop('checked')==true){
//        fl_alert('info',p_id)
                $('.permissioncb_'+p_id).prop('checked',true);
            }else{
                $('.permissioncb_'+p_id).prop('checked',false)
            }
        });
        
    });
    
</script>