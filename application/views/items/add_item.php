<?php
	
	$result = array(
                        'id'=>"",
                        'item_code'=>(isset($new_item_code))?$new_item_code:'',
                        'item_name'=>"",
                        'treatment'=>"",
                        'color'=>"",
                        'shape'=>"",
                        'length'=>"",
                        'width'=>"",
                        'height'=>"",
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

//                echo '<pre>';print_r(($result)); die;
        
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
                <?php // echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
                <!--<a class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>-->
            </div>
        </div>
 <br><hr>
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $action;?> Item - Info</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart("Items/validate",'id="form_mng"'); ?> 
   
                    <div class="box-body ">
                              
                        <div class="row"> 
                            
                            <div class="col-md-12">
                                 <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                   
                                  <div class="tab-content fl_scroll">
                                      <div class="tab-pane active"> 
                                            <div class="row">
                                                <!--<h3>Item Info</h3>-->
                                                <div class="col-md-6">
                                                <!--<div id="set_res">1111111111</div>-->
                                                <div  class="form-group">
                                                    <label class="col-md-3 control-label">Item Code<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('item_code', set_value('item_code', $result['item_code']), 'id="item_code" class="form-control" style=" text-transform:capitalize;"  placeholder="Enter Item unique code"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('item_code');?>&nbsp;
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Item Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                        <?php echo form_input('item_name', set_value('item_name', $result['item_name']), 'id="item_name" class="form-control" style=" text-transform:capitalize;" placeholder="Inte item name"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('item_name');?>&nbsp;
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Category<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_category_id',$item_category_list,set_value('item_category_id',$result['item_category_id']),' class="form-control select2" data-live-search="true" id="item_category_id" '.$o_dis.'');?> 
                                                        <?php echo form_error('item_category_id');?>&nbsp;
                                                    </div> 
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Description<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'style'=>'', 'placeholder'=>'Enter description' ), set_value('description',$result['description']),$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('description');?>&nbsp;
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Unit of Measure<span style="color: red">*</span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_uom_id',$item_uom_list,set_value('item_uom_id',$result['item_uom_id']),' class="form-control " data-live-search="true" id="item_uom_id" '.$o_dis.'');?> 
                                                        <?php echo form_error('item_uom_id');?>&nbsp;
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
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('item_type_id',$item_type_list,set_value('item_type_id',$result['item_type_id']),' class="form-control " data-live-search="true" id="item_type_id" '.$o_dis.'');?> 
                                                        <span class="help-block"><?php echo form_error('item_type_id');?>&nbsp;</span>
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Addon/Tax Type<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       <?php  echo form_dropdown('addon_type_id',$addon_type_list,set_value('addon_type_id',$result['addon_type_id']),' class="form-control " data-live-search="true" id="addon_type_id" '.$o_dis.'');?> 
                                                        <?php echo form_error('addon_type_id');?>&nbsp;
                                                    </div> 
                                                </div>
                                            </div>
                                          
                                         <div class="col-md-6">
                                             <div   class="form-group gem_field">
                                                <label class="col-md-3 control-label">Treatments<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                   <?php  echo form_dropdown('treatment',$treatments_list,set_value('treatment',$result['treatment']),' class="form-control select2" data-live-search="true" id="treatment" '.$o_dis.'');?> 
                                                    <?php echo form_error('treatment');?>&nbsp;
                                                </div> 
                                            </div>
											
                                             <div  class="form-group gem_field">
                                                    <label class="col-md-3 control-label">Color<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                             <?php  echo form_dropdown('color',$color_list,set_value('color',$result['color']),' class="form-control select2" data-live-search="true" id="color" '.$o_dis.'');?> 
                                                  <?php echo form_error('color');?>&nbsp;
                                                    </div> 
                                            </div>
											
                                                <div   class="form-group gem_field">
                                                    <label class="col-md-3 control-label">Shape<span style="color: red"></span></label>
                                                    <div class="col-md-9">    
                                                       	 <?php  echo form_dropdown('shape',$shape_list,set_value('shape',$result['shape']),' class="form-control select2" data-live-search="true" id="shape" '.$o_dis.'');?> 
														<?php echo form_error('shape');?>&nbsp;
                                                    </div> 
                                                </div>
                                             
                                                <div   class="form-group gem_field">
                                                    <label class="col-md-3 control-label">Measurement<span style="color: red"></span></label>

                                                    <div class="col-md-3">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="">L</span></span>
                                                            <?php echo form_input('length', set_value('length'), 'id="length" class="form-control" placeholder="Length mm"'); ?>
                                                            <span class="help-block"><?php echo form_error('length');?></span>
                                                        </div>     
                                                        &nbsp;                                       
                                                    </div>

                                                    <div class="col-md-3">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="">W</span></span>
                                                            <?php echo form_input('width', set_value('width'), 'id="width" class="form-control" placeholder="Width mm"'); ?>
                                                            <span class="help-block"><?php echo form_error('width');?></span>
                                                        </div> 
                                                        &nbsp;                                           
                                                    </div>

                                                    <div class="col-md-3">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="">H</span></span>
                                                            <?php echo form_input('height', set_value('height'), 'id="height" class="form-control" placeholder="Height mm"'); ?>
                                                            <span class="help-block"><?php echo form_error('height');?></span>
                                                        </div>        
                                                        &nbsp;
                                                    </div> 
                                                </div> 
                                             
                                            <div  class="form-group gem_field">
                                                <label class="col-md-3 control-label">Certification<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                   <?php  echo form_dropdown('certification',$certification_list,set_value('certification',$result['certification']),' class="form-control select2" data-live-search="true" id="certification" '.$o_dis.'');?> 
                                                    <?php echo form_error('certification');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div   class="form-group gem_field">
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
                                                            <?php echo form_checkbox('sales_excluded', set_value('sales_excluded','1'),$result['sales_excluded'], 'id="sales_excluded" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                            <span></span>
                                                        </label>
                                                     </div>                                            
                                                    <?php echo form_error('sales_excluded');?>&nbsp;
                                                </div>
                                            </div> 
                                         <div class="form-group">
                                                <label class="col-md-3 control-label">Exclude from purchased</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                         <label class="switch  switch-small">
                                                            <!--<input type="checkbox"  value="0">-->
                                                            <?php echo form_checkbox('purchases_excluded', set_value('purchases_excluded','1'),$result['purchases_excluded'], 'id="purchases_excluded" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                            <span></span>
                                                        </label>
                                                     </div>                                            
                                                    <?php echo form_error('purchases_excluded');?>&nbsp;
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
                                             <div class="form-group">
                                                <label class="col-md-3 control-label">Item Image</label>
                                                <div class="col-md-6">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                         <?php // echo form_input(array('name'=>'pic1[]', 'multiple'=>'multiple','id'=>'pic1', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                        <?php echo form_input(array('name'=>'image','id'=>'image', 'class'=>'form-control fl_file', 'type'=>'file'));?>
                                                    </div>    
                                                    <?php echo form_error('image');?>
                                                </div>
                                                <div class="col-md-3">
                                                    <img id="img_itm" class="profile-user-img img-responsive img-bordered" src="<?php echo base_url(ITEM_IMAGES.$result['id'].'/'.$result['image']); ?>" alt="User profile picture">
                                                </div>
                                            </div> 
                                               <br>
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">Other Images</label>
                                                    <div class="col-md-12">     
                                                        <div class="fl_file_uploader2">
                                                            <input type="file" name="item_images" class="fl_files" data-fileuploader-files=''> 
                                                        </div> 
                                                        <span class="help-block"><?php echo form_error('item_images');?></span>
                                                    </div>
                                                </div> 
                                             
                                         </div>
                                                <div hidden class="col-md-6">
                                                    
                                                    <div class="box-header with-border">
                                                      <h3 class="box-title"><?php // echo $action;?>Item Stock</h3>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Available Units <span style="color: red">*</span></label>
                                                        <div class="col-md-9">    
                                                            <?php echo form_input('stock_unit', set_value('stock_unit', $result['stock_unit']), 'id="stock_unit" class="form-control" placeholder="Enter Available Units"'.$dis.' '.$o_dis.' '); ?>
                                                            <?php echo form_error('stock_unit');?>&nbsp;
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Available Secondary Unit<span style="color: red">*</span></label>
                                                        <div class="col-md-9">    
                                                            <?php echo form_input('stock_unit_2', set_value('stock_unit_2', $result['stock_unit_2']), 'id="stock_unit_2" class="form-control" placeholder="Enter Available other units"'.$dis.' '.$o_dis.' '); ?>

                                                            <?php echo form_error('stock_unit_2');?>&nbsp;
                                                        </div> 
                                                    </div> 
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Location<span style="color: red"></span></label>
                                                        <div class="col-md-9">    
                                                           <?php  echo form_dropdown('location_id',$location_list,set_value('location_id',$result['location_id']),' class="form-control " data-live-search="true" id="location_id" '.$o_dis.'');?> 
                                                            <?php echo form_error('location_id');?>&nbsp;
                                                        </div> 
                                                    </div>
                                                </div>
                                                 
                                        <div class="col-md-6">
                                                <div class="box-header with-border">
                                                  <h3 class="box-title"><?php echo $action;?> Item - Sale Price</h3>
                                                </div>
                                                <div class="row">
                                                  <?php // echo form_open("", 'id="form_sales_price" class="form-horizontal"')?>      
                                                    <div class="col-md-12">
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
                                                                              <td>'.form_dropdown('prices[sales]['.$key.'][currency_id]',$currency_list,set_value('prices[sales]['.$key.'][currency_id]',(isset($sale_price_arr['currency_code'])?$sale_price_arr['currency_code']:$this->session->userdata(SYSTEM_CODE)['default_currency'])),' class="form-control" data-live-search="true" id="prices["sales"]currency_id['.$key.']" '.$o_dis.''). form_hidden('prices[sales]['.$key.'][sales_type_id]',$key).' </td> 
                                                                              <td>'.form_input('prices[sales]['.$key.'][amount]', set_value('prices[sales]['.$key.'][amount]', number_format((isset($sale_price_arr['price_amount'])?$sale_price_arr['price_amount']:0),0,'.','')), 'id="prices[sales]['.$key.'][amount]" class="form-control" placeholder="Enter Amount"'.$dis.' '.$o_dis.' ').form_error('prices[sales]['.$key.'][amount]').'</td>
                                                                            </tr>  
                                                                      ';
                                                              }
                                                              ?>

                                                          </tbody>
                                                      </table>
                                                  </div> 
                                                  </div> 
                                              </div>

                                      </div>
                                      
                                          
                                      
                                          
                                        <?php // echo form_close(); ?>   
                                      </div>
                                      <!-- /.tab-pane --> 
                                       
                                      <!-- /.tab-pane --> 
                                      <!-- /.tab-pane -->
                                      <div class="tab-pane" id="tab_5">
                                          <div class="col-md-12">
                                            
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
                                    <?php echo form_submit('submit', constant($action ),'class="btn btn-primary"'); ?>&nbsp;

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
    function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
//                fl_alert('info',input.id);

                    reader.onload = function (e) {
                        if(input.id=='image'){
                            $('#img_itm').attr('src', e.target.result);
                        } 
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".fl_file").change(function(){
                readURL(this);
            });
});

 
</script>


<script>
    
$(document).ready(function(){ 
    get_category()
    $('#item_name').focus();
    $('.select2').on("select2:close", function () { $(this).focus(); });
    set_cat_results()
    $("#item_category_id").change(function(){ 
		event.preventDefault();
		set_cat_results();
                get_category();
    }); 
    $("#item_type_id").change(function(){ 
        event.preventDefault();
        if($("#item_type_id").val()=='1'){
            $('#sales_excluded').prop('checked', false);
            $('#purchases_excluded').prop('checked', false);
            $('#item_code').val("<?php echo gen_id('1', ITEMS, 'id',5);?>");
        } 
        if($("#item_type_id").val()=='4'){
            $('#sales_excluded').prop('checked', true);
            $('#purchases_excluded').prop('checked', true);
            $('#item_code').val("<?php echo gen_id('ct', ITEMS, 'id',4);?>");
        } 
        if($("#item_type_id").val()=='2' || $("#item_type_id").val()=='3'){
            $('#sales_excluded').prop('checked', true);
            $('#purchases_excluded').prop('checked', false);
            $('#item_code').val("<?php echo gen_id('1', ITEMS, 'id',5);?>");
        } 
    }); 
	function set_cat_results(){
            var cat_id = $('#item_category_id').val();
            $.ajax({
			url: "<?php echo site_url('Items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_category', cat_id:cat_id},
			success: function(result){
                            var res1 = JSON.parse(result);
//                             $("#set_res").html(res1.sales_excluded); 
                            console.log(res1.item_uom_id);
                             $('#item_type_id').val(res1.item_type_id).trigger('change'); 
                             $('#item_uom_id').val(res1.item_uom_id).trigger('change');
                             if(res1.item_uom_id_2 != 0)
                                $('#item_uom_id_2').val(res1.item_uom_id_2).trigger('change');  
                        }
		});
	}
        
    function get_category(){ 
            var cat_id = $('#item_category_id').val();
            $.ajax({
			url: "<?php echo site_url('Items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_category', cat_id:cat_id},
			success: function(result){
                            var res1 = JSON.parse(result);
                            if(res1.is_gem==1){
                                $('.gem_field').show();
                                $('.select2').attr('style','width:100%');
                                
                            }else{
                                $('.gem_field').hide();
                            }
                        }
		}); 
    }
});
</script>