<?php
	
	$result = array(
                        'id'=>"",
                        'category_name'=>"",
                        'category_code'=>"",
                        'item_uom_id'=>"",
                        'item_uom_id_2'=>"",
                        'parent_cat_id'=>"",
                        'order_by'=>"",
                        'cat_link_list'=>"",
                        'item_type_id'=>"",
                        'description'=>"",
                        'addon_type_id'=>"",
                        'sales_excluded'=>0, 
                        'purchases_excluded'=>0, 
                        'cat_image' => 'default.jpg', 
                        'show_pos'=>0,
                        'is_gem'=>0,
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

$result['cat_link_list'] = (isset($result['cat_link_list'])?$result['cat_link_list']:'');
//var_dump($result);
?> 

<script>
    $(document).ready(function(){ 
         function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
//                fl_alert('info',input.id);

                    reader.onload = function (e) {
                        if(input.id=='cat_image'){
                            $('#img_1').attr('src', e.target.result);
                        } 
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".fl_file").change(function(){
                
                readURL(this);
            });
            
            $('.thumbnail').click(function(){ 
                      var title = $(this).parent('a').attr("src");
                      $(".model_img").attr("src",this.src); 
                      $('#myModal').modal({show:true});
                      
              }); 
    
        $("form").submit(function(){ 
            if(!confirm("Click Ok to Confirm form Submition.")){
                   return false;
            }
        });
        
        $(".top_links a").click(function(){ 
            if(!confirm("Click Ok to Confirm leave from here. This form may have unsaved data.")){
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
            <div class="top_links">
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="btn btn-app '.(($action=='Add')?'hide':'').'"><i class="fa fa-plus"></i>Create New</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'.base_url($this->router->fetch_class().'/edit/'.$result['id']).'" class="btn btn-app '.(($action=='Edit')?'hide':'').'"><i class="fa fa-pencil"></i>Edit</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$result['id']).'" class="btn btn-app  '.(($action=='Delete')?'hide ':'').' "><i class="fa fa-trash"></i>Delete</a>':''; ?>
                 
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
              
             <?php echo form_open_multipart("Item_categories/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                        
                                            <div class="col-md-12">
                                                <h5>Item Categories</h5>
                                                <hr>
                                            </div> 
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Category Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('category_name', set_value('category_name', $result['category_name']), 'id="category_name" class="form-control" placeholder="Category Name"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('category_name');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Category Code<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('category_code', set_value('category_code', $result['category_code']), 'id="category_code" class="form-control" placeholder="Category Code"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('category_code');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Parent Category<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('parent_cat_id',$item_cat_list,set_value('parent_cat_id',$result['parent_cat_id']),' class="form-control select2" data-live-search="true" id="parent_cat_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('parent_cat_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                
                                                <div hidden class="form-group">
                                                    <label class="col-md-3 control-label">Linked Categories<span style="color: red"></span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group"> <span class="input-group-addon"><span class="fa fa-list"></span></span>
                                                           <?php  echo form_dropdown('cat_link_list[]',$item_cat_list,set_value('cat_link_list[]', json_decode($result['cat_link_list'])),' class="form-control  select2"  multiple="multiple"  data-live-search="true" id="cat_link_list"'.$o_dis.'');?>
                                                             
                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('cat_link_list');?></span>
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
                                                    <label class="col-md-3 control-label">Secondary UOM<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_uom_id_2',$item_uom_list_2,set_value('item_uom_id_2',$result['item_uom_id_2']),' class="form-control " data-live-search="true" id="item_uom_id_2" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_uom_id_2');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_type_id',$item_type_list,set_value('item_type_id',$result['item_type_id']),' class="form-control " data-live-search="true" id="item_type_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_type_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Description<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('description', set_value('description',$result['description']), 'id="description" class="form-control" placeholder="Enter name or descreption"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('description');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Addon/Tax Type<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('addon_type_id',$addon_type_list,set_value('addon_type_id',$result['addon_type_id']),' class="form-control " data-live-search="true" id="addon_type_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('addon_type_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                            </div>
                                          
                                         <div class="col-md-6">
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
                                             <div class="form-group">
                                                    <label class="col-md-3 control-label">Exclude from Purchases</label>
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
                                                    <label class="col-md-3 control-label">Show On POS</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('show_pos', set_value('show_pos','1'),$result['show_pos'], 'id="show_pos" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('show_pos');?>&nbsp;</span>
                                                    </div>
                                                </div> 
                                             
                                             <div <?php echo (NO_GEM=='1')?'hidden':'';?> class="form-group">
                                                    <label class="col-md-3 control-label">Is Gem</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('is_gem', set_value('is_gem','1'),$result['is_gem'], 'id="is_gem" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('is_gem');?>&nbsp;</span>
                                                    </div>
                                                </div> 
                                             
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Sort Order <span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('order_by', set_value('order_by', $result['order_by']), 'id="order_by"  class="form-control" placeholder="Sort Order"'.$dis.' '.$o_dis.' '); ?>
                                                        <span class="help-block"><?php echo form_error('order_by');?>&nbsp;</span>
                                                    </div> 
                                                </div> 
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Category Image</label>
                                                <div class="col-md-6">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php // echo form_input(array('name'=>'pic1[]', 'multiple'=>'multiple','id'=>'pic1', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                        <?php echo form_input(array('name'=>'cat_image','id'=>'cat_image', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                    </div>    
                                                    <span class="help-block"><?php echo form_error('cat_image');?></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <img  id="img_1"  class="thumbnail profile-user-img img-responsive img-circle" src="<?php echo base_url((CAT_IMAGES.$result['id'].'/'.$result['cat_image'])); ?>" alt="Category picture">
                                                </div>
                                            </div>  
                                          
                                         </div>
                                             
                        </div>
                    </div>
                          <!-- /.box-body -->
                          
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
                <!--   END  //image Lightbox-->
                
                    <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',constant($action),'class="btn btn-primary"'); ?>&nbsp;

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
  