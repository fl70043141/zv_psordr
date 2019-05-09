<?php
	
	$result = array(
                        'id'=>"0",
                        'customer_id'=>"",
                        'sales_order_no'=>"",
                        'customer_branch_id'=>"",
                        'vehicle_number'=>"",
                        'chasis_no'=>"",
                        'description'=>"",
                        'insurance_company'=>"",
                        'delivery_address'=>"",
                        'customer_phone'=>"",
                        'customer_reference'=>"",
                        'price_type_id'=>"",
                        'location_id'=>"",
                        'memo'=>"",
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'order_date'=> strtotime(date('m/d/Y')),
                        'required_date'=> strtotime(date('m/d/Y')),
                        'item_discount'=>0,
                        'currency_code'=>$this->session->userdata(SYSTEM_CODE)['default_currency'],
                        'item_quantity'=>1,
                        'item_quantity_2'=>1,
                        );   		
	
	 $add_hide = '';
	 $del_hide = '';
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
                $add_hide       = 'hidden';
	break;
	
	case 'Edit':
		if(!empty($so_data)){$result= $so_data;} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($so_data)){$result= $so_data;} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
                $del_hide       = 'hide';
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($so_data)){$result= $so_data;} 
		$heading	= 'View';
		$view		= 'hidden';
		$dis        = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

//var_dump($result);
?> 
<!-- Main content -->

<style>
    .btn-circle.btn-lg {
        width: 50px;
        height: 50px;
        padding: 10px 16px;
        font-size: 18px;
        line-height: 1.33;
        border-radius: 25px;
      }
</style>
<?php // echo '<pre>'; print_r($so_data); die;?>

<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

    
    
        <div class="">
            <!--<a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>New Order</a>-->
            <a href="<?php echo base_url('Sales_order_items');?>" class="btn btn-app "><i class="fa fa-list"></i>Order List</a>
            <a href="<?php echo base_url('Order_ecatalog'.(($result['id']!='' && $result['id']!=0)?'/index/'.$result['id']:''));?>" class="btn btn-app "><i class="fa fa-plus-circle"></i>Add Item</a>
            <!--<a href="#" id="add_old_gold" class="btn btn-app "><i class="fa fa-chain"></i>Old Gold</a>-->
            <a href="<?php echo base_url($this->router->fetch_class().'/print_sales_order/'.$result['id']);?>" target="_blank" class=" <?php echo $add_hide; ?> btn btn-app "><i class="fa fa-print"></i>Print SO</a>
            <a href="<?php echo base_url($this->router->fetch_class().'/delete/'.$result['id']);?>" class=" <?php echo $add_hide; ?> btn btn-app "><i class="fa fa-trash"></i>Delete</a>
            <a href="<?php echo base_url('Order_ecatalog/');?>" class="pull-right btn btn-app success <?php echo $add_hide;?>"><i class="fa fa-list"></i>New Order</a>
            <a href="<?php echo base_url('Sales_invoices/add_from_order/?soid='.$result['id']);?>" class="pull-right btn btn-app success <?php echo $add_hide;?>"><i class="fa fa-truck"></i>Create Invoice</a>

        </div>
    </div>
    
 <br><hr>
    <section  class="content"> 
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
              <!-- general form elements -->
              <div class="box box-primary"> 
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open($this->router->fetch_class()."/validate", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customer <span style="color: red">*</span></label>
                                    <div class="col-md-7">    
                                         <?php  echo form_dropdown('customer_id',$customer_list,set_value('customer_id',$result['customer_id']),' class="form-control select2" data-live-search="true" id="customer_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_id');?>&nbsp;</span>-->
                                    </div> 
                                    <div class="col-md-2"> <a id="add_cust_btn" class="btn btn-primary pull-right btn-sm "><span class="fa fa-plus"></span></a></div>
                    
                                </div>
                                <div  hidden class="form-group">
                                    <label class="col-md-3 control-label">Branch <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                          <?php  echo form_dropdown('customer_branch_id',$customer_branch_list,set_value('customer_branch_id',$result['customer_branch_id']),' class="form-control select2" data-live-search="true" id="customer_branch_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_branch_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            <div <?php echo $add_hide; ?> class="col-md-4">
                                
                                <div   class="form-group">
                                    <label class="col-md-3 control-label">Order# <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('sales_order_no',set_value('sales_order_no',$result['sales_order_no']),'readonly class="form-control add_item_inpt" data-live-search="true" id="sales_order_no"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_branch_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Price List<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('price_type_id',$price_type_list,set_value('price_type_id',$result['price_type_id']),' class="form-control select2" data-live-search="true" id="price_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Order_Date<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('order_date',set_value('order_date',date('m/d/Y',$result['order_date'])),' class="form-control datepicker" readonly id="order_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('order_date');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div> 
                        </div>
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div  <?php echo $del_hide;?> class="box-group" id="accordion">
                                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->

                                    <div class="panel box box-primary">
                                      <div class="box-header with-border">
                                        <h4 class="box-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
                                            Click to Expand/Close item list selector
                                          </a>
                                        </h4>
                                      </div>
                                        <div id="collapseThree" class="panel-collapse collapse " aria-expanded="false">
                                        <div class="box-body">
                                            
                                            <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">

                                                <h4 class="">Add Item Sales Order</h4> 
                                                <div class="row col-md-12 ">
                                                    <div id="first_col_form" class="col-md-2 ">
                                                        <div class="form-group pad">
                                                            <label for="item_code">Item Code</label>
                                                            <?php  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" data-live-search="true" id="item_code"');?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group pad">
                                                            <label for="item_desc">Item Name</label>
                                                            <?php echo form_dropdown('item_desc',$item_list,set_value('item_desc'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="item_desc"');?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group pad">
                                                            <label for="description">Description</label>
                                                            <?php echo form_input('description',set_value('description'),' class="form-control add_item_inpt " style="width:100%;" id="description"');?>
                                                        </div>
                                                    </div>
                                                    <div id="uom_div">

                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group pad">
                                                            <label for="item_unit_cost">Unit Cost</label>
                                                            <input type="text" name="item_unit_cost" class="form-control add_item_inpt" id="item_unit_cost" placeholder="Unit Cost for item">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group pad"><br>
                                                            <span id="add_item_btn" class="btn-default btn add_item_inpt pad">Add</span>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                
                                <div class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped">
                                        <thead>
                                           <tr> 
                                               <th width="10%"  style="text-align: center;">Item Code</th> 
                                               <th width="6%" style="text-align: center;">Image</th> 
                                               <th width="16%" style="text-align: left;">Item Name</th> 
                                               <th width="16%" style="text-align: left;">Description</th> 
                                               <th width="10%" style="text-align: right;">Quantity</th> 
                                               <th width="15%" style="text-align: right;">Unit Cost (<?php echo $result['currency_code'];?>)</th>  
                                               <th width="15%" style="text-align: right;">Total</th> 
                                               <th  width="5%" style="text-align: center;">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody  id="tbody_list">
                                           <?php
                                                $row_count = 3;$i=1;
                                                $so_total= 0;
                                                if(isset($so_order_items)){
                                                    foreach ($so_order_items as $so_item){
//                                                        echo '<pre>';                                                    print_r($so_item); 
                                                        $invoiced = ($so_item['invoiced']==1)?'<br><span class="badge bg-green"><a style="color:white;" '.(($so_item['invoice_id']!='')? "href=".base_url('Sales_invoices/view/'.$so_item['invoice_id']):'').'>invoiced</a></span>':'';
                                                        echo '
                                                            <tr style="padding:10px" class="'.$row_count.'" id="tr_'.$row_count.'">
                                                                <td style="text-align:center;"><input hidden="" name="inv_items['.$row_count.'][item_code]" value="'.$so_item['item_code'].'">'.$so_item['item_code'].' '.$invoiced.'</td>
                                                                <td  align="center"><img class="thumbnail" style="width:30px;height:30px;" src="'. base_url(ITEM_IMAGES.$so_item['item_id'].'/'.$so_item['image']).'"></td>    
                                                                <td><input hidden="" name="inv_items['.$row_count.'][item_desc]" value="'.$so_item['item_desc'].'"><input hidden="" name="inv_items['.$row_count.'][item_id]" value="'.$so_item['item_id'].'">'.$so_item['item_desc'].'</td>
                                                                <td style="text-align:center;"><input hidden="" name="inv_items['.$row_count.'][description]" value="'.$so_item['description'].'">'.$so_item['description'].'</td>
                                                                <td  class="input_qty_td" align="right"><input class="input_qty_field" type="number" min="0" hidden="" name="inv_items['.$row_count.'][item_quantity]" value="'.$so_item['units'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_2]" value="'.$so_item['secondary_unit'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_uom_id]" value="'.$so_item['unit_uom_id'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_uom_id_2]" value="'.$so_item['secondary_unit_uom_id'].'"><span class="qty_text">'.$so_item['units'].'</span> '.$so_item['unit_abbreviation'].' '.(($so_item['secondary_unit']>0)?'| '.$so_item['units'].' '.$so_item['unit_abbreviation_2']:'').'</td> 
                                                                <td class="input_price_td" align="right"><input hidden class="input_price_field" type="number" min="0" step="0.01" name="inv_items['.$row_count.'][item_unit_cost]" value="'.$so_item['unit_price'].'"><span class="price_text">'. number_format($so_item['unit_price'],2).'</span></td>
                                                                <td class="item_tots_td" align="right"><input class="item_tots" hidden="" name="inv_items['.$row_count.'][item_total]" value="'.$so_item['sub_total'].'"><span>'. number_format($so_item['sub_total'],2).'</span></td>
                                                                <td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger '.$del_hide.'"><i class="fa fa-trash"></i></button></td>
                                                            </tr>';
                                                        $so_total += $so_item['sub_total'];
                                                        $row_count++; 
                                                    }
                                                }
                                           ?> 
                                       </tbody>
                                       
                                            <tr>
                                                <td colspan="5"></td>
                                                <td  style="text-align: right;"><b>Sub Total</b></td>
                                                <td  style="text-align: right;"><input hidden value="<?php echo (isset($so_total)?$so_total:0);?>" name="invoice_total" id="invoice_total"><b><span id="inv_total"><?php echo number_format($so_total,2);?></span></b></td>
                                                <td></td>
                                            </tr>
                                        <tbody id="og_tfoot">
                                            
                                        </tbody>
                                       <tfoot>  
                                            <tr>
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;"><b>Total</b></th>
                                                <th  style="text-align: right;"><input hidden  value="0" name="invoice_total_fin" id="invoice_total_fin"><span id="inv_total_fin"><b>0</b></span></th>
                                                <th  style="text-align: right;"></th>
                                            </tr>
                                            
                                       </tfoot>
                                        </table>
                                </div>
                                <div id="search_result_1"></div>
                            </div>    
                        </div>
                        <div class="row" id="footer_sales_form">
                            <h5>&nbsp;Order Customer Info</h5>
                            <hr>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Deliver_from<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('location_id',$location_list,set_value('location_id',$result['location_id']),' class="form-control select2" data-live-search="true" id="location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Required _Date<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('required_date',set_value('required_date',date('m/d/Y',$result['required_date'])),' class="form-control datepicker" readonly id="required_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('required_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Address<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_textarea(array('name'=>'delivery_address','rows'=>'4','id'=>'delivery_address','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter Delivery Address' ),$result['delivery_address'],$dis.' '.$o_dis.' '); ?>
                                         <!--<span class="help-block"><?php // echo form_error('delivery_address');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Contact_Phone<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_input('customer_phone', set_value('customer_phone',$result['customer_phone']), 'id="customer_phone" class="form-control" placeholder="Enter Phone Number"'.$dis.' '.$o_dis.' '); ?>
                                        <?php echo form_error('customer_phone');?>
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Reference<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_input('customer_reference', set_value('customer_reference',$result['customer_reference']), 'id="customer_reference" class="form-control" placeholder="Enter ref"'.$dis.' '.$o_dis.' '); ?>
                                        <?php echo form_error('customer_reference');?> 
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Memo<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_textarea(array('name'=>'memo','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter any comments' ),$result['memo'],$dis.' '.$o_dis.' '); ?>
                                         <!--<span class="help-block"><?php // echo form_error('delivery_address');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                <button id="place_invoice" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i><?php echo constant($action);?> Order</button>
                                <a id="cancel_so" class="btn btn-app pull-right  primary"><i class="fa fa-times"></i>Cancel Unsaved</a>
                
                            </div>
                        </div>
                    </div>
                
              </div>
    </section>      
                            
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('sales_order_no', $result['sales_order_no']); ?>
                            <?php echo form_hidden('action',$action,'id="action"'); ?>
                            <?php echo form_close(); ?>               
                                
                         
                            
    </div>
        <div class="col-md-12">
            <div class="box">
               <!-- /.box-header -->
               <!-- /.box-body -->
             </div>

        </div>
</div>
    
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
 <style>
    .modal-dialog {width:800px;}
    .thumbnail {margin-bottom:6px;}
    .modal-body {width:800px; align:center;}
    .model_img {width: 500px;}
</style>
<?php $this->load->view('sales_order_items/so_modals/add_new_customer_model'); ?>
<?php $this->load->view('sales_order_items/so_modals/add_buy_gold_modal'); ?>
<script>
    
$(document).keypress(function(e) {
    
//    fl_alert('info',e.keyCode)
        if(e.keyCode == 13) {//13 for enter
            if ($(".add_item_inpt").is(":focus")) {
                    $('#add_item_btn').trigger('click');
//                fl_alert('info',)
              }
            $('#item_code').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
            $('#place_invoice').trigger('click');
        }
    });
$(document).ready(function(){
    load_temp_order();
    input_ctrl();
    $('.thumbnail').click(function(){ 
            var title = $(this).parent('a').attr("src");
            $(".model_img").attr("src",this.src); 
            $('#myModal').modal({show:true});

    }); 
//    $("#add_old_gold").click(function(){ 
//        var cust_id = $('#customer_id').val();
//        window.open("<?php // echo base_url("Buy_gold/add_POS");?>/"+cust_id+"?type=so_og", "popupWindow", "width=1300, height=600, scrollbars=yes");
//    });
    $('#item_code').focus();
    $('.select2').on("select2:close", function () { $(this).focus(); });
    
//    get_results();
    $("#item_code").keyup(function(){ 
	get_item_dets(this.id);
    });
	 
    $("#item_desc").on("change focus",function(){
        if(event.type == "focus")
             $("#item_code").val($('#item_desc').val());
            get_item_dets(this.id);
    });
    $("#place_invoice").click(function(){
            if($('#customer_id').val()==null){
                fl_alert('info',"Customer field can not empty! Please select customer!")
                return false;
            } 
            if($('input[name^="inv_items"]').length<=0 && $('input[name^="action"]').value()=='Add'){
                fl_alert('info',"Atleast one item need to create an invoice!")
                return false;
            }
            if(!confirm("Click ok confirm your submission.")){
                return false;
            }
    });
     $("#cancel_so").click(function(){
        if(!confirm("Click ok confirm Cancel the Order")){
            return false;
        }
        cancel_open_temp_order();
    });
    get_branch_drpdwn();
    if($('[name="action"]').val()=="Add"){
         set_branch_info();
    }
     $("#customer_id").change(function(){ 
         get_branch_drpdwn();
//         set_temp_so_info();
    });
    
     $("#price_type_id").change(function(){ 
	 $('#item_code').trigger('keyup'); 
    });
     $("#customer_branch_id").change(function(){ 
         set_branch_info();
    });
    
    $("#add_item_btn").click(function(){
//        fl_alert('info',$('#item_quantity').val());
//fl_alert('info',$('#item_unit_cost').val()); return false;
         $.ajax({
			url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), customer_id:$('#customer_id').val(), price_type_id:$('#price_type_id').val()},
			success: function(result){
                                var res2 = JSON.parse(result);
//                                $("#search_result_1").html(result);
                                
                                if(res2.item_code==null){
                                    fl_alert('info','Item invalid! Please recheck before add.');
                                    return false;
                                }
                                
                                var rowCount = $('#invoice_list_tbl tr').length;
                                var counter = rowCount+1;
                                var qtyXprice = parseFloat($('#item_unit_cost').val()) * parseFloat($('#item_quantity').val());
//                                var item_total = qtyXprice - (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
                                var item_total = qtyXprice;
                                var item_desc_note = $('#description').val(); 
                                
                                var row_str = '<tr style="background:#ffc4c4;padding:10px"  id="tr_'+res2.id+rowCount+'">'+ 
                                                        '<td><input hidden name="inv_items['+res2.id+rowCount+'][item_code]" value="'+$('#item_code').val()+'">'+$('#item_code').val()+'</td>'+
                                                        '<td align="center"><img class="thumbnail" style="width:30px;height:30px;" src="<?php echo base_url(ITEM_IMAGES.'/');?>'+res2.id+'/'+res2.image+'"></td>'+
                                                        '<td><input hidden name="inv_items['+res2.id+rowCount+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+res2.id+rowCount+'][item_id]" value="'+res2.id+'">'+res2.item_name+'</td>'+
                                                        '<td><input hidden name="inv_items['+res2.id+rowCount+'][description]" value="'+item_desc_note+'">'+item_desc_note+'</td>'+
                                                        '<td align="right"><input hidden name="inv_items['+res2.id+rowCount+'][item_quantity]" value="'+$('#item_quantity').val()+'"><input hidden name="inv_items['+res2.id+rowCount+'][item_quantity_2]" value="'+(($('#item_quantity_2').val()==null)?0:$('#item_quantity_2').val())+'">'+
                                                        '<input hidden name="inv_items['+res2.id+rowCount+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="inv_items['+res2.id+rowCount+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                $('#item_quantity').val()+' '+res2.unit_abbreviation;
                                if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
                                    row_str = row_str + ' | ' + $('#item_quantity_2').val()+' '+res2.unit_abbreviation_2;
                                }                                                                                                                                                                                                                                                                        
                                row_str = row_str + '</td> <td align="right"><input hidden name="inv_items['+res2.id+rowCount+'][item_unit_cost]" value="'+$('#item_unit_cost').val()+'">'+parseFloat($('#item_unit_cost').val()).toFixed(2)+'</td>'+ 
                                                        '<td align="right"><input class="item_tots" hidden name="inv_items['+res2.id+rowCount+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>';
                                var newRow = $(row_str);
                                $('#description').val('');
                                jQuery('table#invoice_list_tbl ').prepend(newRow);
                                calc_total();

                                //delete row
                                $('.del_btn_inv_row').click(function(){
//                                    if(!confirm("click ok Confirm remove this item.")){
//                                        return false;
//                                    }
                                    var tot_amt = 0;
                                    $(this).closest('tr').remove();
                                    calc_total();
                                });
                        }
		});

        
        
    });
	
        
     //delete row
    $('.del_btn_inv_row').click(function(){
    
//                                    if(!confirm("click ok Confirm remove this item.")){
//                                        return false;
//                                    }
        var tot_amt = 0;
        $(this).closest('tr').remove(); 
        $('input[class^="item_tots"]').each(function() {
//                                        console.log(this);
            tot_amt = tot_amt + parseFloat($(this).val());
        });
        $('#invoice_total').val(tot_amt.toFixed(2));
        $('#inv_total').text(tot_amt.toFixed(2)); 
    });
    $("#item_code").val($('#item_desc').val());
    $('#item_code').trigger('keyup');
//         set_temp_so_info();
//        set_item_list_cookie()
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('Sale_orders/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
//                             $("#result_search").html(result);
//                             $(".dataTable").DataTable();
        }
		});
	}
        
         //Dynamic itemloader for select2
        $(document).on('keyup', ' .select2-search__field', function (e) {
            //do ajax call here
             $.ajax({
                    url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=get_availale_items_dropdown_json');?>",
                    type: 'post',
                    data : {function_name:"get_availale_items_dropdown_json",item_lmit:"<?php echo SELECT2_ROWS_LOAD;?>",item_search_txt:this.value},
                    success: function(result){

                        var item_obj = JSON.parse(result);
                            var tmp_html = '';
                        var test_arr = []; 
                        $.each(item_obj, function (option_id, option_text) { 
                            test_arr.push([{id:option_id,text:option_text}]); 
                            tmp_html += '<option value="'+option_id+'">'+option_text+'</option>';
                        }); 

                        $('#item_desc').html('');
                        $('#item_desc').html(tmp_html);

                        var select_opt = $('.select2-results__option.select2-results__option--highlighted').attr("id").split('-');
                        $('.select2-results__option').attr("aria-selected","false");
                        $('#item_desc').val(select_opt[4]).trigger('change.select2');
                    }
                }); 
        });
});

	function get_item_dets(id1=''){ //id1 for input element id
            $.ajax({
			url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), customer_id:$('#customer_id').val(), price_type_id:$('#price_type_id').val()},
			success: function(result){
                            
//                            $("#search_result_1").html(result);
                            var res1 = JSON.parse(result);
                            
                             $('#first_col_form').removeClass('col-md-offset-1');
                            var div_str = '<div class="col-md-1">'+
                                                    '<div class="form-group pad">'+
                                                        '<label for="item_quantity"><span id="unit_abbr">[Each]<span></label>'+
                                                        '<input type="text" name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quantity">'+
                                                    '</div>'+
                                                '</div>';
                            if(res1.item_uom_id_2!=0){
                                    div_str = div_str + '<div class="col-md-1">'+
                                                            '<div class="form-group pad">'+
                                                                '<label for="item_quantity_2"> <span id="unit_abbr_2">[Each]<span></label>'+
                                                                '<input type="text" name="item_quantity_2" class="form-control add_item_inpt" value="1" id="item_quantity_2" placeholder="Enter Quantity">'+
                                                            '</div>'+
                                                        '</div>';
                                    
                            }else{
                                $('#first_col_form').addClass('col-md-offset-1')
                            }
                            $('#uom_div').html(div_str);
                            
                            if(typeof(res1.id) != "undefined" && res1.id !== null) { 
                                if(id1!='item_desc'){

                                                var tmp_html = '<option value="'+res1.item_code+'">'+res1.item_name+'-'+res1.item_code+'</option>';

                                                $('#item_desc').html('');
                                                $('#item_desc').append(tmp_html);
                                                $('#item_desc').val(res1.item_code).trigger('change.select2');
                                            }
                                if(id1!='item_code'){ $('#item_code').val(res1.item_code);}
                                (res1.price_amount==null)? $('#item_unit_cost').val(0):$('#item_unit_cost').val(res1.price_amount);
                                $('#unit_abbr').text('['+res1.unit_abbreviation+']');
                                $('#unit_abbr_2').text('['+res1.unit_abbreviation_2+']');
//                                $('#item_discount').val(0);
                                $('#item_quantity').val(1);

                                $("#result_search").html(result);
                            }
                        }
		});
	}
        
        function get_branch_drpdwn(br_id=''){
                  var cust_id = parseInt($('#customer_id').val()); 
                  
                    $.ajax({
                           url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
                           type: 'post',
                           data : {function_name:'get_dropdown_branch_data',customer_id:$('#customer_id').val()},
                           success: function(result){
//                            $("#search_result_1").html(result);
                                var obj1 = JSON.parse(result);
                                $('#customer_branch_id').empty();
                                var $select = $('#customer_branch_id');
                                $(obj1).each(function (index, o) {   
                                     var $option = $("<option/>").attr("value", o.id).text(o.branch_name);
                                     $select.append($option);
                                 });
                                $('#customer_branch_id').select2(); 
                                 
                               
                                set_branch_info()
                                if($('#action').val()=='Add'){
//                                    fl_alert('info',)
                                    $('#customer_branch_id').trigger('change');
                                }else{ 
                                    $("#customer_branch_id option[value=<?php echo $result['customer_branch_id'];?>]").attr('selected', 'selected').change(); 
                                }
                               }
                   });
                   
            }
        
        function set_branch_info(){
                    $.ajax({
                           url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
                           type: 'post',
                           data : {function_name:'get_single_branch_info',branch_id:$('#customer_branch_id').val()},
                           success: function(result){
//                                $("#search_result_1").html(result);
                                var obj2 = JSON.parse(result);
//                                console.log(obj2);
                                $('#delivery_address').text(obj2.billing_address);
                                $('#customer_phone').val(obj2.phone); 

                               }
                   });
                   
            }
        function set_temp_so_info(){
//                                return false;
            var post_data = $('#form_search').find('select, textarea, input').serializeArray(); 
            post_data.push({name:"order_id",value:"<?php echo $result['id'];?>"}); 
            post_data.push({name:"function_name",value:'set_temp_order_info'}); 
            $.ajax({
                   url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
                   type: 'post',
                   data : post_data,
                   success: function(result){

                        $("#search_result_1").html(result); return  false;
                        var obj1 = JSON.parse(result);
//                                console.log(obj1);
                         $(obj1).each(function (index, ob) {   
                            var obj2 = JSON.parse(ob.item_det_json); 
                            set_item_list_ajax(obj2.item_code,ob.modal_price,ob.modal_qty);
                         });
//                                $("#search_result_1").html(obj1); 

                       }
           });
        }
                   
        function set_item_list_cookie(){
                                
                    $.ajax({
                           url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
                           type: 'post',
                           data : {function_name:'get_temp_so_info',order_id:'<?php echo $result['id'];?>'},
                           success: function(result){
                               
                                var obj = JSON.parse(result);
                                var obj1 = JSON.parse(obj.value);
                                $('#customer_id').val(obj.customer_id).prop('selected', true).trigger("change");
                                
                                var obj_og = '';
                                if(obj.og_data !=''){
                                    obj_og = JSON.parse(obj.og_data);
                                    $.each(obj_og,function (index1, ob1) {  
                                            var strg_og_row1 = '<tr>'+
                                                '<td colspan="3"></td>'+
                                                '<td  style="text-align: right;">Old Gold - ['+ob1['og_no']+']</td>'+
                                                '<td  style="text-align: right;"><input hidden value="'+ob1['amount']+'" class="og_amount_txt" name="og['+ob1['og_id']+'][amount]">'+
                                                                                '<input hidden value="'+ob1['og_id']+'" name="og['+ob1['og_id']+'][og_id]">'+
                                                                                '<input hidden value="'+ob1['og_no']+'" name="og['+ob1['og_id']+'][og_no]"><span id="og_amount_td">'+parseFloat(ob1['amount']).toFixed(2)+'</span></td>'+
                                                '<td  style="text-align: left;"><span style="color:red;cursor: pointer;" alt="Remove Old Gold" class="og_del_btn">X</span></td>'+
                                           '</tr>';
                                   
                                        $("#og_tfoot").append(strg_og_row1); 
                                        calc_tots_og();

                                        $('.og_del_btn').click(function(){
                                            if(!confirm("click ok Confirm remove OG.")){
                                                return false;
                                            }  
                                            $(this).closest('tr').remove();
                                            $("#customer_id").trigger('change');  
                                            calc_tots_og()
                                        }); 
                                     }); 
                                }
                                 $(obj1).each(function (index, ob) {   
                                    var obj2 = JSON.parse(ob.item_det_json); 
                                    set_item_list_ajax(obj2.item_code,ob.modal_price,ob.modal_qty);
                                 });
                                $("#search_result_1").html(obj1); 
                                $("#customer_id").trigger('change'); 

                               }
                   });
                   
            }
            
    
    function set_item_list_ajax(item_code,item_price,itm_qty,itm_qty_2=0){
//    fl_alert('info',itm_qty); return false;
        $.ajax({
                               url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
                               type: 'post',
                               data : {function_name:'get_single_item', item_code:item_code, customer_id:$('#customer_id').val(),price_type_id:$('#price_type_id').val()},
                               success: function(result){ 
                                       var res2 = JSON.parse(result);
//                                       $("#search_result_1").html(result);

                                       if(res2.item_code==null){
                                           fl_alert('info','Item invalid! Please recheck before add.');
                                           return false;
                                       }

                                       var rowCount = $('#invoice_list_tbl tr').length;
                                       var counter = rowCount+1;
                                       var qtyXprice = parseFloat(item_price) * parseFloat(itm_qty);
       //                                var item_total = qtyXprice - (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
                                       var item_total = qtyXprice;

                                       var row_str = '<tr style="padding:10px; background:#FBB8B8;" id="tr_'+res2.id+rowCount+'">'+ 
                                                               '<td><input hidden name="inv_items['+res2.id+rowCount+'][item_code]" value="'+item_code+'">'+item_code+'</td>'+
                                                               '<td><input hidden name="inv_items['+res2.id+rowCount+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+res2.id+rowCount+'][item_id]" value="'+res2.id+'">'+res2.item_name+'</td>'+
                                                               '<td align="center"><a id="minusqty_'+res2.id+rowCount+'" class="hide btn_minus btn inline btn-sm btn-warning" ><span class="fa fa-minus"></span></a>'+
                                                                                '<input readonly id="qty_'+res2.id+rowCount+'" class="hide inline form-control input-md" style="width:100px;"  type="number" min="0"  step=".001"  name="inv_items['+res2.id+rowCount+'][item_quantity]" value="'+itm_qty+'">'+
                                                                                '<a id="plusqty_'+res2.id+rowCount+'" class="hide btn_plus btn inline btn-sm btn-primary"><span class="fa fa-plus"></span></a><input hidden name="inv_items['+res2.id+rowCount+'][item_quantity_2]" value="'+((itm_qty_2==null)?0:itm_qty_2)+'">'+
                                                               '<input hidden name="inv_items['+res2.id+rowCount+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="inv_items['+res2.id+rowCount+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'"><span  >'+
                                                                                                                                                                                                                                                                                       itm_qty+' '+res2.unit_abbreviation;
                                       if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
//                                           row_str = row_str + ' | ' + itm_qty_2+' '+res2.unit_abbreviation_2;
                                       }                                                                                                                                                                                                                                                                        
                                       row_str = row_str + '</span></td> <td align="right"><input hidden name="inv_items['+res2.id+rowCount+'][item_unit_cost]" value="'+item_price+'">'+parseFloat(item_price).toFixed(2)+'</td>'+ 
                                                               '<td align="right"><input class="item_tots" hidden name="inv_items['+res2.id+rowCount+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                               '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                           '</tr>';
                                       var newRow = $(row_str);
                                       jQuery('table#invoice_list_tbl ').append(newRow); 
                                       calc_total();

                                       //delete row
                                       $('.del_btn_inv_row').click(function(){
       //                                    if(!confirm("click ok Confirm remove this item.")){
       //                                        return false;
       //                                    }
                                           var tot_amt = 0;
                                           $(this).closest('tr').remove(); 
                                           calc_total()
                                            calc_tots_og(); 
                                       });
                                        
                                       $('#minusqty_'+res2.id+rowCount).click(function(){
                                           var id1 = (this.id).split('_')[1];
//                                           fl_alert('info',$('#qty_'+id1).val())
                                           var new_val = parseFloat($('#qty_'+id1).val()) - 1;
                                           $('#qty_'+id1).val((new_val<1)?1:new_val); 
                                       });
                                       $('#plusqty_'+res2.id+rowCount).click(function(){
                                           var id1 = (this.id).split('_')[1];
//                                           fl_alert('info',$('#qty_'+id1).val())
                                           var new_val = parseFloat($('#qty_'+id1).val()) + 1;
                                           $('#qty_'+id1).val((new_val<1)?1:new_val); 
                                       });
                                        
                                        calc_tots_og();
                               }
		});

    }
    function calc_tots_og(){
        var fin_tot = parseFloat($('#invoice_total').val());
        $('input[class^="og_amount_txt"]').each(function() {
            fin_tot = fin_tot - parseFloat($(this).val());
        }); 
        $('#invoice_total_fin').val(fin_tot);
        $('#inv_total_fin').text(fin_tot.toFixed(2));
    } 
    
    function load_temp_order(){
         $.ajax({
                           url: "<?php echo site_url('Order_ecatalog/fl_ajax');?>",
                           type: 'post',
                           data : {function_name:'get_temp_so_open',order_id:"<?php echo $result['id'];?>"},
                           success: function(result){
//                                       $("#search_result_1").html(result);;
                                       var temp_res = JSON.parse(result);
                                       var apnd_html = "";
                                       var rowCount = $('#invoice_list_tbl tr').length;
                                       
//                                       console.log(temp_res);
                                        $.each(temp_res,function(itm_id,itm_obj){
                                                var item_total = parseFloat(itm_obj.temp_info.unit_price) * parseFloat(itm_obj.temp_info.units);
                                                
                                               
                                                 apnd_html = apnd_html + '<tr style="background:#ffc4c4;padding:10px" id="tr_'+itm_id+rowCount+'">'+ 
                                                                         '<td><input hidden name="inv_items['+itm_id+rowCount+'][item_code]" value="'+itm_obj.item_code+'">'+itm_obj.item_code+'</td>'+
                                                                         '<td align="center"><img class="thumbnail" style="width:30px;height:30px;" src="<?php echo base_url(ITEM_IMAGES.'/');?>'+itm_id+'/'+itm_obj.image+'"></td>'+
                                                                         '<td><input hidden name="inv_items['+itm_id+rowCount+'][item_desc]" value="'+itm_obj.item_name+'"><input hidden name="inv_items['+itm_id+rowCount+'][item_id]" value="'+itm_id+'">'+itm_obj.item_name+'</td>'+
                                                                         '<td><input hidden name="inv_items['+itm_id+rowCount+'][description]" value="'+itm_obj.description+'">'+itm_obj.description+'</td>'+
                                                                         '<td align="right"><input hidden name="inv_items['+itm_id+rowCount+'][item_quantity]" value="'+itm_obj.temp_info.units+'"><input hidden name="inv_items['+itm_id+rowCount+'][item_quantity_2]" value="0">'+
                                                                         '<input hidden name="inv_items['+itm_id+rowCount+'][item_quantity_uom_id]" value="'+itm_obj.item_uom_id+'"><input hidden name="inv_items['+itm_id+rowCount+'][item_quantity_uom_id_2]" value="'+itm_obj.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                                 itm_obj.temp_info.units+' '+itm_obj.unit_abbreviation;
                                                 if(itm_obj.unit_abbreviation_2!=null && itm_obj.unit_abbreviation_2!=0){
//                                                     apnd_html = apnd_html + ' | ' + $('#item_quantity_2').val()+' '+res2.unit_abbreviation_2;
                                                 }                                                                                                                                                                                                                                                                        
                                                 apnd_html = apnd_html + '</td> <td align="right"><input hidden name="inv_items['+itm_id+rowCount+'][item_unit_cost]" value="'+itm_obj.temp_info.unit_price+'">'+parseFloat(itm_obj.temp_info.unit_price).toFixed(2)+'</td>'+ 
                                                                         '<td align="right"><input class="item_tots" hidden name="inv_items['+itm_id+rowCount+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                                         '<td width="5%"><button id="'+itm_id+'__'+'del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                                     '</tr>';
//                                                             console.log(apnd_html);
                                            });
                                                $('#invoice_list_tbl #tbody_list').append(apnd_html);
                                                 
                                                //delete row
                                                $('.del_btn_inv_row').click(function(){
                                                    var del_itemid = (this.id).split('__')[0]; 
                                                    remove_temp_so_item(del_itemid);
                                                    $(this).closest('tr').remove();
                                                    calc_total();
                                                });
                                                calc_total();
                                        
                           }
               });
    }
    
    function remove_temp_so_item(del_itemid){
        $.ajax({
                    url: "<?php echo site_url('Order_ecatalog/fl_ajax');?>",
                    type: 'post',
                    data : {function_name:'remove_temp_so_item',del_itemid:del_itemid, order_id:'<?php echo $result['id'];?>'},
                    success: function(result){
//                        alert(result)
                    }
               });
    }
    function cancel_open_temp_order(){
        $.ajax({
                    url: "<?php echo site_url('Order_ecatalog/fl_ajax');?>",
                    type: 'post',
                    data : {function_name:'cancel_open_temp_order',order_id:'<?php echo $result['id'];?>'},
                    success: function(result){
                        if(result=='1'){
                            window.location.href = "<?php echo base_url('Sales_order_items');?>";
                        }
//                        alert(result);
                    }
               });
    }
    
    function calc_total(){
        var grand_total = 0;
        
        $('.item_tots').each(function(){
            grand_total += parseFloat(this.value);
        });
        
            //sub_total
           $('#invoice_total').val(grand_total);
           $('#inv_total').text(grand_total.toFixed(2));
           
            //Final_total
           $('#invoice_total_fin').val(grand_total);
           $('#inv_total_fin').text(grand_total.toFixed(2));
    }
    
    function input_ctrl(){
        $('.input_qty_td').click(function(){ 
            var tr_id = $(this).closest('tr').attr('class');   
    //        alert(tr_id)
            $('[name="inv_items['+tr_id+'][item_quantity]"]').addClass("form-control");
            $('[name="inv_items['+tr_id+'][item_quantity]"]').focus().select(); 
        });
        $('.input_qty_field').focusout(function(){   
            var tr_id = $(this).closest('tr').attr('id');  
            var newtot1 =  parseFloat($(this).val()) * parseFloat($('#'+tr_id+' .input_price_field').val());
            $('#'+tr_id+' .input_qty_td .qty_text').text($(this).val());
            $('#'+tr_id+' .item_tots_td span').text(newtot1.toFixed(2));
            $('#'+tr_id+' .item_tots').val(newtot1);
            $(this).removeClass('form-control');  
            calc_total();
            
        });
        
        $('.input_price_td').click(function(){  
            var tr_id = $(this).closest('tr').attr('class'); 
            $('[name="inv_items['+tr_id+'][item_unit_cost]"]').addClass("form-control");
            $('[name="inv_items['+tr_id+'][item_unit_cost]"]').show().focus().select();  
        });
        $('.input_price_field').focusout(function(){    
            var tr_id = $(this).closest('tr').attr('id');
            var newtot1 =  parseFloat($(this).val()) * parseFloat($('#'+tr_id+' .input_qty_field').val()); 
            $('#'+tr_id+' .input_price_td .price_text').text(parseFloat($(this).val()).toFixed(2));
            $('#'+tr_id+' .item_tots_td span').text(newtot1.toFixed(2));
            $('#'+tr_id+' .item_tots').val(newtot1);
            $(this).removeClass('form-control'); 
            calc_total();
//            alert(newtot1)
        });
    }
</script>
 