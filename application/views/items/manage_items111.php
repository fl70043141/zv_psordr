<?php
//	echo '<pre>';        print_r($stock_status); die;
	$result = array(
                        'id'=>"",
                        'item_code'=>(isset($new_item_code))?$new_item_code:'',
                        'item_name'=>"",
                        'treatment'=>"",
                        'color'=>"",
                        'certification'=>"",
                        'certification_no'=>"",
                        'description'=>"",
                        'item_category_id'=>"",
                        'item_uom_id'=>"",
                        'item_uom_id_2'=>"",
                        'item_type_id'=>"",
                        'addon_type_id'=>"",
                        'sales_excluded'=>0, 
                        'purchases_excluded'=>0, 
                        'image' => 'default.jpg', 
                        'images' => array(), 
                        'status'=>"1",
            
                        'stock_unit'=>"0",
                        'stock_unit_2'=>"0",
                        'location_id'=>"0",
                        );   		
	
	 
	
	 $hide_spec='';
	 $hide_spec_add='';
	switch($action):
        case 'Add': 
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
                $hide_spec_add  = 'hidden';
                
	break;
	
	case 'Edit':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
		$hide_spec	= 'hidden'; 
                
                
	break;
	
	case 'Delete':
		if(!empty($user_data[0])){$result= $user_data[0];}  
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= 'hidden';
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

//                echo '<pre>';print_r(($result['videos']));
        
            // add files to our array with
            // made to use the correct structure of a file
            if( isset($result['images']) && $result['images'] != null && $result['images'] != 'null'){
                foreach(json_decode($result['images']) as $file) {
                        // skip if directory
                        if(is_dir($file))
                                continue; 
                        // add file to our array
                        // !important please follow the structure below
                        $appendedFiles[] = array(
                                                "name" => $file,
                                                "type" => get_mime_by_extension(ITEM_IMAGES.$result['id'].'/other/'.$file),
                                                "size" => filesize(ITEM_IMAGES.$result['id'].'/other/'.$file),
                                                "file" => base_url(ITEM_IMAGES.$result['id'].'/other/'.$file),
                                                "data" => array(  "url" => base_url(ITEM_IMAGES.$result['id'].'/other/'.$file)
                                            )
                        ); 
                }

                // convert our array into json string
                if(isset($appendedFiles))$result['images'] = json_encode($appendedFiles);
            }
//            echo '<pre>';            print_r($appendedFiles); die;
        
?> 
<style>
    .policy_tbl td, .pets_tbl  td{
        padding: 5px;
    }
</style>
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
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-search"></i>Search</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$result['id']).'" class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>':''; ?>
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
              
             <?php echo form_open_multipart("Items/validate",'id="form_mng"'); ?> 
   
                    <div class="box-body ">
                              
                        <div class="row"> 
                            
                            <div class="col-md-12">
                                 <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                  <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab">Information</a></li>  
                                    <li><a href="#tab_2" data-toggle="tab">Sales Pricing</a></li> 
                                    <li><a href="#tab_3" data-toggle="tab">Purchasing Pricing</a></li> 
                                    <li><a href="#tab_4" data-toggle="tab">Images</a></li> 
                                    <!--<li><a href="#tab_5" data-toggle="tab">Transection</a></li>--> 
                                    <li><a href="#tab_6" data-toggle="tab">Status</a></li> 

                                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                                  </ul>
                                  <div class="tab-content fl_scroll">
                                      <div class="tab-pane active" id="tab_1"> 
                                              <div class="row"> 
                                                  <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Item Code<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('item_code', set_value('item_code', $result['item_code']), 'id="item_code" class="form-control" placeholder="Enter Item unique code"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('item_code');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Item Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('item_name', set_value('item_name', $result['item_name']), 'id="item_name" class="form-control" placeholder="Inte item name"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('item_name');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Description<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter description' ), set_value('description',$result['description']),$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('description');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Category<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_category_id',$item_category_list,set_value('item_category_id',$result['item_category_id']),' class="form-control select2" data-live-search="true" id="item_category_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_category_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div  hidden class="form-group">
                                                    <label class="col-md-3 control-label">Color<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('color', set_value('color', $result['color']), 'id="color" class="form-control" style=" text-transform:capitalize;"  placeholder="Enter Stone Color"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('color');?>&nbsp;
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Unit of Measure<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_uom_id',$item_uom_list,set_value('item_uom_id',$result['item_uom_id']),' class="form-control " data-live-search="true" id="item_uom_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_uom_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Secondary UOM<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_uom_id_2',$item_uom_list_2,set_value('item_uom_id_2',$result['item_uom_id_2']),' class="form-control " data-live-search="true" id="item_uom_id_2" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_uom_id_2');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Item Type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    item_ty
                                                       <?php  echo form_dropdown('item_type_id',$item_type_list,set_value('item_type_id',$result['item_type_id']),' class="form-control " data-live-search="true" id="item_type_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_type_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div hidden class="form-group">
                                                    <label class="col-md-3 control-label">Addon/Tax Type<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('addon_type_id',$addon_type_list,set_value('addon_type_id',$result['addon_type_id']),' class="form-control " data-live-search="true" id="addon_type_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('addon_type_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                      
                                             <div class="form-group">
                                                    <label class="col-md-3 control-label">Exclude from sales</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('sales_excluded', set_value('sales_excluded','1'),$result['sales_excluded'], 'id="sales_excluded" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('sales_excluded');?>&nbsp;</span>
                                                    </div>
                                                </div> 
                                            </div>
                                          
                                         <div hidden class="col-md-6">
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Treatments<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                   <?php  echo form_dropdown('treatment',$treatments_list,set_value('treatment',$result['treatment']),' class="form-control select2" data-live-search="true" id="treatment" '.$o_dis.'');?> 
                                                    <?php echo form_error('treatment');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div hidden class="form-group">
                                                <label class="col-md-3 control-label">Certification<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                   <?php  echo form_dropdown('certification',$certification_list,set_value('certification',$result['certification']),' class="form-control select2" data-live-search="true" id="certification" '.$o_dis.'');?> 
                                                    <?php echo form_error('certification');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div  hidden class="form-group">
                                                <label class="col-md-3 control-label">Certification No<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('certification_no', set_value('certification_no', $result['certification_no']), 'id="certification_no" class="form-control" style=" text-transform:capitalize;"  placeholder="Enter Certification Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('certification_no');?>&nbsp;
                                                </div> 
                                            </div> 
                                             <div class="form-group">
                                                    <label class="col-md-3 control-label">Exclude from sales</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('purchases_excluded', set_value('purchases_excluded','1'),$result['purchases_excluded'], 'id="purchases_excluded" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('purchases_excluded');?>&nbsp;</span>
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
                                             
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Item Image</label>
                                                <div class="col-md-6">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php // echo form_input(array('name'=>'pic1[]', 'multiple'=>'multiple','id'=>'pic1', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                        <?php echo form_input(array('name'=>'image','id'=>'image', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                    </div>    
                                                    <span class="help-block"><?php echo form_error('image');?></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(ITEM_IMAGES.(($result['image']!="")?$result['id'].'/'.$result['image']:'default.jpg')); ?>" alt="User profile picture">
                                                </div>
                                            </div>
                                          
                                         </div>
                                              </div>

                                      </div>
                                      
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_2">
                                        <?php // echo form_open("", 'id="form_sales_price" class="form-horizontal"')?>      
                                          <div class="col-md-9">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Sales Type</th>
                                                        <th>Currency</th>
                                                        <th>Price</th> 
                                                    </tr>
                                                    <?php
                                                    foreach ($sales_type_list as $key=>$sale_type){
                                                        $sale_price_arr = array();
                                                        if(isset($item_prices['sales'])){
                                                            foreach ($item_prices['sales'] as $sale_price){
                                                                if($sale_price['sales_type_id']==$key){
                                                                    $sale_price_arr = $sale_price;
                                                                    break;
                                                                }else{
                                                                    $sale_price_arr=0;
                                                                }
                                                            }
                                                        }
                                                        
                                                        echo '
                                                                <tr>
                                                                    <td>'.$sale_type.'</td>
                                                                    <td>'.form_dropdown('prices[sales]['.$key.'][currency_id]',$currency_list,set_value('prices["sales"]currency_id['.$key.']',(isset($sale_price_arr['currency_code'])?$sale_price_arr['currency_code']:0)),' class="form-control" data-live-search="true" id="prices["sales"]currency_id['.$key.']" '.$o_dis.''). form_hidden('prices[sales]['.$key.'][sales_type_id]',$key).' </td> 
                                                                    <td>'.form_input('prices[sales]['.$key.'][amount]', set_value('prices["sales"]amount['.$key.']', number_format((isset($sale_price_arr['price_amount'])?$sale_price_arr['price_amount']:0),2,'.','')), 'id="prices["sales"]amount['.$key.']" class="form-control" placeholder="Enter Short name"'.$dis.' '.$o_dis.' ').'</td>
                                                                  </tr>  
                                                            ';
                                                    }
                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div> 
                                          
                                          <div <?php echo $view;?> class="col-md-12">
                                            <a id="sp_submit_btn" class="btn btn-default">Update</a>
                                            <div id="sp_result"></div>
                                            <hr>
                                        </div>
                                          
                                        <?php // echo form_close(); ?>   
                                      </div>
                                      <!-- /.tab-pane --> 
                                      
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_3">
                                          <div  <?php echo $view;?> class="col-md-12">
                                              <h4>Purchasing price add</h4><hr>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Supplier<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('prices[purchasing][supplier_id]',$supplier_list,set_value('customer_type_id'),' class="form-control select2" data-live-search="true" style="width:100%;" id="prices[purchasing][supplier_id]" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('prices[purchasing][supplier_id]');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label">Price<span style="color: red"></span></label>
                                                  <div class="col-md-9">    
                                                       <?php echo form_input('prices[purchasing][purchasing_amount]', set_value('prices[purchasing][purchasing_amount]'), 'id="prices[purchasing][purchasing_amount]" class="form-control" placeholder="Enter prices"'.$dis.' '.$o_dis.' '); ?>
                                                      <span class="help-block"><?php echo form_error('prices[purchasing][purchasing_amount]');?>&nbsp;</span>
                                                  </div> 
                                                </div>
                                                  <div class="form-group">
                                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                         <?php  echo form_dropdown('prices[purchasing][purchasing_currency]',$currency_list,set_value('prices[purchasing][purchasing_currency]'),' class="form-control select2"  style="width:100%;" data-live-search="true" id="prices[purchasing][purchasing_currency]" '.$o_dis.'');?> 
                                                         <span class="help-block"><?php echo form_error('prices[purchasing][purchasing_currency]');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Supplier Unit<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('prices[purchasing][supplier_unit]', set_value('prices[purchasing][supplier_unit]'), 'id="prices[purchasing][supplier_unit]" class="form-control" placeholder="Enter supplier_unit "'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('prices[purchasing][supplier_unit]');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Unit conversation<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('prices[purchasing][unit_conversation]', set_value('prices[purchasing][unit_conversation]'), 'id="prices[purchasing][unit_conversation]" class="form-control" placeholder="Enter unit_conversation "'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('prices[purchasing][unit_conversation]');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Note<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('prices[purchasing][description]', set_value('prices[purchasing][description]'), 'id="prices[purchasing][description]" class="form-control" placeholder="Enter description "'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('prices[purchasing][description]');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                  <a id="pp_submit_btn" class="btn btn-default">Add New</a>
                                                  <hr>
                                                  <!--<div id="pp_result"></div>-->
                                              </div> 
                                        </div>
                                          <div class="col-md-12">
                                                <div id="pp_result" class="col-md-12">

                                              </div> 
                                          </div>
                                    </div>
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_4">
                                           <div class="col-md-12">
                                               <br>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">All Images</label>
                                                    <div class="col-md-9">                                            
                                                           
                                                        <div class="fl_file_uploader2">
                                                            <input type="file" name="item_images" class="fl_files" data-fileuploader-files='<?php echo $result['images'];?>'> 
                                                        </div> 
                                                        <span class="help-block"><?php echo form_error('item_images');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="col-md-12">
                                               <br>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Videos</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="row no-pad-top">
                                                            <div class="fl_file_uploader2">
                                                                <input type="file" name="item_videos" class="fl_files" data-fileuploader-files=''> 
                                                            </div> 
                                                            <span class="help-block"><?php echo form_error('item_videos');?></span>
                                                        </div>
                                                        <div class="row">    
                                                            <?php
                                                            if(isset($result['videos'])){
                                                                $vdos = json_decode($result['videos']);
                                                                if(!empty($vdos)){
                                                                    foreach ($vdos as $key=>$vdo){
                                                                        echo '<div class="col-md-4  '.$key.'_vdo">
                                                                                <video width="100%" controls>
                                                                                    <source src="'.base_url(ITEM_IMAGES.$result['id'].'/videos/'.$vdo).'" id="video_here">
                                                                                      Your browser does not support HTML5 video.
                                                                                </video>
                                                                                <a id="'.$key.'_vdo" class="btn-sm btn-danger center fa fa-trash remove_img_inv"></a> '.$vdo.'
                                                                                <input hidden value="'.$vdo.'" name="exist_vdos['.$key.']" >
                                                                            </div>';
                                                                    }
                                                                }
                                                            }
                                                            ?> 

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_5">
                                          <div class="col-md-12">
                                            
                                        </div> 
                                      </div>
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_6">
                                          <div class="col-md-12">
                                             <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Location</th>
                                                        <th>Quantity on Hand</th> 
                                                        <th>On Order</th> 
                                                        <th>Available</th> 
                                                    </tr>
                                                    <?php
                                                        foreach ($stock_status as $stock_loc){
//                                                            echo '<pre>';   print_r($stock_loc);
                                                            echo '<tr>
                                                                        <td>'.$stock_loc['location_name'].'</td>
                                                                        <td>'.$stock_loc['units_available'].' '.$stock_loc['uom_name'].(($stock_loc['uom_id_2']!=0)?' | '.$stock_loc['units_available_2'].' '.$stock_loc['uom_name_2']:'').'</td>
                                                                        <td>'.$stock_loc['units_on_order'].' '.$stock_loc['uom_name'].'</td>
                                                                        <td>'.($stock_loc['units_available']-$stock_loc['units_on_consignee'] - $stock_loc['units_on_order']).' '.$stock_loc['uom_name'].'</td>
                                                                      
                                                                      </tr>  ';
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                        </div> 
                                      </div>
                                      <!-- /.tab-pane --> 
                                  </div>
                                  <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
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

    $('#icon_view').addClass($('#icon').val());
    $("#icon").keyup(function(){ 
//		fl_alert('info',);
                $('#icon_view').removeClass();
                $('#icon_view').addClass($('#icon').val());
    });
    
    
    load_purchasing_price()
     $("#sp_submit_btn").click(function(){
         if(confirm("Click Ok to confirm Sales price update.")){
		update_sale_price();
         }else{
             return false;
         }   
    });
     $("#pp_submit_btn").click(function(){ 
         if(confirm("Click Ok to confirm Purchasing price update.")){
		update_purchasing_price();
         }else{
             return false;
         } 
    });
    
    
    $('.remove_img_inv').click(function(){
            fl_alert('info',this.id);
        var id = this.id;
        $('.'+id).remove();
    });
    
    function update_sale_price(){
//        fl_alert('info',)
        $.ajax({
			url: "<?php echo site_url('Items/update_sales_price');?>",
			type: 'post',
			data : jQuery('#form_mng').serializeArray(),
			success: function(result){
                             $("#sp_result").html(result);
                        }
		});
    }
    function update_purchasing_price(){ 
        $.ajax({
			url: "<?php echo site_url('Items/update_purchasing_price');?>",
			type: 'post',
			data : jQuery('#form_mng').serializeArray(),
			success: function(result){
                             $("#pp_result").html(result);
                        }
		});
    }  
    function load_purchasing_price(){ 
        $.ajax({
			url: "<?php echo site_url('Items/load_purchasing_price');?>",
			type: 'post',
			data : jQuery('#form_mng').serializeArray(),
			success: function(result){
                             $("#pp_result").html(result);
                        }
		});
    }  
});

 
</script>