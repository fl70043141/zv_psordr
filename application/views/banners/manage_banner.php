

<?php 
//$this->load->view('includes/pg_hdr');
	  	
	$result = array('id'=>"",'banner_name'=>"", 'user_name' => "", 'status' => "", "pic"=> 'default.jpg'); 
	
	 
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

$banner_data = (isset($result['data_json']))?json_decode($result['data_json'],true):'';
//echo'<pre>'; print_r($banner_data);
?>
<script>
$(document).ready(function(){
    
    $('#add_element').click(function(){
        var rowCount = $('#cms_table tr').length;
        fl_alert('info',rowCount);
        var counter = rowCount+1;
        event.preventDefault(); 
        var newRow = jQuery('<tr id="tr_'+rowCount+'">'+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][title]" id="title" class="form-control title_cms" placeholder="Slide Title"></div></td>'+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][desc]" id="desc" class="form-control" placeholder="Slide Desc"></div></td> '+'<td><div class="input-group"><input type="file" name="arr['+rowCount+'][img]" id="image" class="form-control fl_file" placeholder="Slide Desc"> '+'<img class="profile-user-img center-block img-responsive img-thumbnail" src="<?php echo base_url(USER_PROFILE_PIC."/default.jpg"); ?>" alt="User profile picture"></div></td> '+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][order]" id="order" class="form-control" placeholder="Sort Order"></div></td>  '+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][texts]" id="texts" class="form-control" placeholder="Text"></div></td> '+'<td><div class="input-group"><input type="text" name="arr['+rowCount+'][link]" id="link" class="form-control" placeholder="Enter Url"></div></td>'+'<td><div class="input-group"><label class="switch  switch-small"><input type="checkbox" name="arr['+rowCount+'][status]" id="status" value="0" checked><span></span></label></div></td> '+'<td> '+'<button id="del_btn" type="button" class="del_btn btn btn-danger"><i class="fa fa-trash"></i></button> '+'</td></tr>');
 
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
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Banner Name<span style="color: red">*</span></label>
                                            <div class="col-md-9">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                     <?php echo form_input('banner_name', set_value('banner_name',$result['banner_name']), 'id="banner_name" class="form-control" placeholder="Enter Banner Name"'.$dis.' '.$o_dis.' '); ?>

                                                </div>                                            
                                                <span class="help-block"><?php echo form_error('banner_name');?></span>
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
                                        <?php echo form_hidden('banner_entry_count',1); ?>

                                         <span class="help-block"><?php echo form_error('banner_entry_count');?></span>
                                        <table id="cms_table" class="cms_table table table-bordered">
                                            <tbody>
                                                <tr> 
                                                    <th width="15%">Title</th>
                                                    <th width="20%">Descreption</th>
                                                    <th width="20%">Image</th>
                                                    <th width="5%">Order</th>
                                                    <th width="15%">Texts</th>
                                                    <th width="15%">Link</th>
                                                    <th width="5%">Status</th>
                                                    <th width="5%">action</th>
                                                </tr>
                                                <?php
                                                    if(isset($banner_data) && !empty($banner_data)){
                                                        $j=1;
                                                        foreach ($banner_data as $banner){
                                                            $status = (isset($banner['status']))?'checked':'';
                                                            $banner['order'] = (isset($banner['order']))?$banner['order']:'';
                                                            $banner['texts'] = (isset($banner['texts']))?$banner['texts']:'';
                                                            $banner['link'] = (isset($banner['link']))?$banner['link']:'';
                                                            echo '<tr>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][title]" id="title" class="form-control title_cms" value="'.$banner['title'].'" placeholder="Slide Title"></div></td></td>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][desc]" id="desc" class="form-control title_cms" value="'.$banner['desc'].'" placeholder="Slide Desc"></div></td></td>
                                                                    <td><div class="input-group"><input type="file" name="arr['.$j.'][img]" id="image" class="form-control fl_file" placeholder="Slide Desc"><img class="profile-user-img center-block img-responsive img-thumbnail" src="'.base_url(BANNERS_PIC.$result['id'].'/'.$banner["image_name"]).'" alt="User profile picture"></div></td>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][order]" id="order" value="'.$banner['order'].'" class="form-control" placeholder="Sort Order"></div></td>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][texts]" id="texts" value="'.$banner['texts'].'" class="form-control" placeholder="texts"></div></td>
                                                                    <td><div class="input-group"><input type="text" name="arr['.$j.'][link]" id="link" value="'.$banner['link'].'" class="form-control" placeholder="Enter Url"></div></td>
                                                                    <td><div class="input-group"><label class="switch  switch-small"><input type="checkbox" name="arr['.$j.'][status]" id="status" value="1" '.$status.'><span></span></label></div></td>
                                                                    <td><button id="del_btn" type="button" class="del_btn btn btn-danger"><i class="fa fa-trash"></i></button></td>      
                                                                    
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
                                    <?php // echo form_hidden('type', $result['type']); ?>
                                    <?php echo form_hidden('id', $result['id']); ?>
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