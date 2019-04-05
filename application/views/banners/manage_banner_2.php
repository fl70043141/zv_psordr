

<?php 
//$this->load->view('includes/pg_hdr');
	  	
	$result = array('type'=>"",'first_name'=>"", 'last_name' => "", 'email' => "", 'tel' => "", 'user_name' => "", 'password' => "",  'confirm_password' => "", 'user_role_id' => "", 'status' => "", "pic"=> 'default.jpg'); 
	
	 
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

//echo'<pre>'; print_r($banner_data);die;
?>
<script>
$(document).ready(function(){
    
    $('#add_element').click(function(){
        var rowCount = $('#cms_table tr').length;
//        fl_alert('info',rowCount);
        var counter = rowCount+1;
        event.preventDefault(); 
        var newRow = jQuery('<tr id="tr_'+rowCount+'">'+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][title]" id="title" class="form-control title_cms" placeholder="Slide Title"></div></td>'+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][desc]" id="desc" class="form-control" placeholder="Slide Desc"></div></td> '+'<td><div class="input-group"><input type="file" name="arr['+rowCount+'][img]" id="image" class="form-control fl_file" placeholder="Slide Desc"> '+'<img class="profile-user-img center-block img-responsive img-thumbnail" src="<?php echo base_url(USER_PROFILE_PIC.$result["user_name"]."/".$result["pic"]); ?>" alt="User profile picture"></div></td> '+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][order]" id="order" class="form-control" placeholder="Sort Order"></div></td> '+'<td><div class="input-group"><label class="switch  switch-small"><input type="checkbox" name="arr['+rowCount+'][status]" id="status" value="0" checked><span></span></label></div></td> '+'<td> '+'<button id="del_btn" type="button" class="del_btn btn btn-danger"><i class="fa fa-trash"></i></button> '+'</td></tr>');
 
        jQuery('table.cms_table').append(newRow);
        
        
        $('.del_btn').click(function(){      
            $(this).closest('tr').remove(); 
        });
    });
  
});
</script>
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
                <a href="<?php echo base_url('Banners/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
                <a href="<?php echo base_url('Banners');?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>
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
                  <button id="add_element" type="button" class="btn btn-info pull-right"><i class="fa fa-plus"></i></button>
                </div>
                            <?php echo form_open_multipart("Banners/validate"); ?> 
                           <div class="box-body fl_scroll">
                              
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <table id="cms_table" class="cms_table table table-bordered">
                                            <tbody>
                                                <tr> 
                                                    <th width="20%">Title</th>
                                                    <th width="25%">Descreption</th>
                                                    <th width="30%">Image</th>
                                                    <th width="10%">Order</th>
                                                    <th width="7%">Staus</th>
                                                    <th width="8%">action</th>
                                                </tr>
                                                <?php
                                                    if(isset($banner_data) && !empty($banner_data)){
                                                        $j=1;
                                                        foreach ($banner_data as $banner){
                                                            $status = ($banner['status'])?'checked':'';
                                                            echo '<tr>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][title]" id="title" class="form-control title_cms" value="'.$banner['text1'].'" placeholder="Slide Title"></div></td></td>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][desc]" id="desc" class="form-control title_cms" value="'.$banner['text2'].'" placeholder="Slide Desc"></div></td></td>
                                                                    <td><div class="input-group"><input type="file" name="arr['.$j.'][img]" id="image" class="form-control fl_file" placeholder="Slide Desc"><img class="profile-user-img center-block img-responsive img-thumbnail" src="'.base_url(BANNERS_PIC.$banner["image"]).'" alt="User profile picture"></div></td>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][order]" id="order" value="'.$banner['sort_order'].'" class="form-control" placeholder="Sort Order"></div></td>
                                                                    <td><div class="input-group"><label class="switch  switch-small"><input type="checkbox" name="arr['.$j.'][status]" id="status" value="1" '.$status.'><span></span></label></div></td>
                                                                    <td><button id="del_btn" type="button" class="del_btn btn btn-danger"><i class="fa fa-trash"></i></button></td>      
                                                                    
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>    
                                                                ';
                                                            $j++;
                                                        }
                                                    }
                                                ?>
                                                   
                                          </tbody></table>
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('type', $result['type']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('Banners'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url('Banners'),'OK','class="btn btn-primary"');
                                    } ?>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                        </div>
                    </div>    