<?php
	
	$result = array(
                        'id'=>"",
                        'customer_id'=>(isset($so_data['customer_id'])?$so_data['customer_id']:""), 
                        'customer_branch_id'=>(isset($so_data['customer_id'])?$so_data['customer_id']:""), 
                        'price_type_id'=>(isset($so_data['price_type_id'])?$so_data['price_type_id']:"15"),
                        'payment_term_id'=>"1",
                        'reference'=> (isset($so_data['id'])?'SO-'.$so_data['sales_order_no']:date('Ymd-Hi')),
                        'invoice_date'=>date('m/d/Y'),
                        'delivery_address'=>"",
                        'customer_phone'=>"",
                        'customer_reference'=>"", 
                        'location_id'=>"",
                        'memo'=>"",
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'order_date'=> strtotime(date('m/d/Y')), 
                        'item_discount'=>0,
                        'currency_code'=>(isset($so_data['currency_code'])?$so_data['currency_code']:$this->session->userdata(SYSTEM_CODE)['default_currency']),
                        'item_quantity'=>1,
                        'item_quantity_2'=>1,
                        );   		
	
	 
	 $add_hide ='';
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
		$add_hide       = 'hidden'; 
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

$so_hide = (isset($so_data['id'])?'hidden':""); //hid in Order to Invoice
//var_dump($result);
?> 
<!-- Main content -->


<?php // echo '<pre>'; print_r($so_data); die;?>

<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

    
    
        <div class="">
            <a href="<?php echo base_url('Sales_orders/view/'.((isset($so_data['id'])?$so_data['id']:"")));?>" class="btn btn-app  <?php echo (isset($so_data['id'])?"":"hide");?>"><i class="fa fa-backward"></i>Back to Order</a>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app '.(isset($so_data['id'])?"hide":"").'"><i class="fa fa-backward"></i>Back</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="'.$add_hide.' btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?> 
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'.base_url($this->router->fetch_class().'/edit/'.$result['id']).'" class="'.$add_hide.' btn btn-app "><i class="fa fa-pencil"></i>Edit</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$result['id']).'" class="'.$add_hide.' btn btn-app  '.(($action=='Delete')?'hide ':'').' "><i class="fa fa-trash"></i>Delete</a>':''; ?>
                 
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
                                    <label class="col-md-3 control-label">Customers<span style="color: red">*</span></label>
                                    <div class="col-md-7">    
                                         <?php  echo form_dropdown('customer_id',$customer_list,set_value('customer_id',$result['customer_id']),' class="form-control select2" data-live-search="true" id="customer_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                     <div class="col-md-2"> <a id="add_cust_btn" class="btn btn-primary pull-right btn-sm "><span class="fa fa-plus"></span></a></div>
                    
                                </div>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Branch <span style="color: red">*</span></label>
                                    <div id="select91_div" class="col-md-9">    
                                        <!--<select id="select91" class="js-example-templating select2" style="width: 50%"></select>-->
                                          <?php  echo form_dropdown('customer_branch_id',$customer_branch_list,set_value('customer_branch_id',$result['customer_branch_id']),' class="form-control select2" data-live-search="true" id="customer_branch_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_branch_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Sales Type<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('sales_type_id',$sales_type_list,set_value('sales_type_id',$result['sales_type_id']),' class="form-control select2" data-live-search="true" id="sales_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                 
                                
                            </div>
                            <div <?php echo $so_hide;?> class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id',$result['payment_term_id']),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"');?>
                                        <input  id="currency_value" name="currency_value" value="1" hidden>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('invoice_date',set_value('invoice_date',$result['invoice_date']),' class="form-control datepicker" readonly id="invoice_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('invoice_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                                <div <?php echo $so_hide;?>  class="form-group">
                                    <label class="col-md-3 control-label">Price List<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('price_type_id',$price_type_list,set_value('price_type_id',$result['price_type_id']),' class="form-control select2" data-live-search="true" id="price_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div> 
                        </div>
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Add Item Invoice</h4> 
                                    <div class="row col-md-12 ">
                                        <div id="first_col_form" class="col-md-2">
                                            <div class="form-group pad">
                                                <label for="item_code">Item Code</label>
                                                <?php  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" data-live-search="true" id="item_code"');?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group pad">
                                                <label for="item_desc">Item Description</label>
                                                <?php echo form_dropdown('item_desc',$item_list,set_value('item_desc'),' class="form-control add_item_inpt js-example-templating select2" style="width:100%;" data-live-search="true" id="item_desc"');?>
                                            </div>
                                        </div>
                                        <div id="uom_div">
                                            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group pad">
                                                <label for="item_unit_cost">Unit Cost <span id="cur_code_lineform"></span>/<span id="prce_unit_name"></span> <input type="checkbox" name="is_price_per_unit" id="is_price_per_unit" value="1" checked></label>
                                                <input type="number" min="0" name="item_unit_cost" step=".001"  class="form-control add_item_inpt" id="item_unit_cost" placeholder="Unit Cost for item">
                                            </div>
                                        </div>
                                        <div hidden class="col-md-1">
                                            <div class="form-group pad">
                                                <label for="item_unit_cost">Discount(%)</label>
                                                <input type="number" name="item_discount" step="5" min="0" max="100"  class="form-control add_item_inpt" id="item_discount" value="0" placeholder="Enter Line Discount">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="add_item_btn" class="btn-default btn add_item_inpt pad">Add</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div id="list_table" class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped">
                                        <thead>
                                           <tr> 
                                               <th width="5%"  style="text-align: center;">#</th> 
                                               <th width="10%"  style="text-align: center;">Item Code</th> 
                                               <th width="20%" style="text-align: center;">Item Description</th> 
                                               <th width="10%" style="text-align: center;">Quantity</th> 
                                               <th width="10%" style="text-align: right;">Unit Cost</th>  
                                               <th width="10%" style="text-align: right;">Discount</th>  
                                               <th width="10%" style="text-align: right;">Total</th> 
                                               <th width="5%" style="text-align: center;">Action</th>
                                           </tr>
                                       </thead>
                                       
                                       <tbody>
                                           <?php
//                                            echo '<pre>';                                                    print_r($so_order_items); die;
                                                    
                                                $row_count = 3;$i=1;
                                                $so_total= 0;
                                                if(isset($so_order_items)){
                                                    foreach ($so_order_items as $so_item){
                                                        if($so_item['invoiced'] == 0 && $so_item['craftman_status']==2){
                                                            $sub_tot_actual = $so_item['sale_unit_price'] * $so_item['actual_units'];
//                                                            echo '<pre>';print_r($so_item);  
                                                            echo '
                                                                <tr style="padding:10px" id="trso_'.$so_item['id'].'">
                                                                    <td><input hidden="" name="inv_items['.$row_count.'][item_code]" value="'.$so_item['new_itemcode'].'">'.$so_item['new_itemcode'].'</td>
                                                                    <td><input hidden="" name="inv_items['.$row_count.'][item_desc]" value="'.$so_item['item_desc'].'"><input hidden="" name="inv_items['.$row_count.'][item_id]" value="'.$so_item['new_item_id'].'">'.$so_item['item_desc'].'</td>
                                                                    <td align="right"><input hidden="" name="inv_items['.$row_count.'][item_quantity]" value="'.$so_item['actual_units'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_2]" value="'.$so_item['secondary_unit'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_uom_id]" value="'.$so_item['unit_uom_id'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_uom_id_2]" value="'.$so_item['secondary_unit_uom_id'].'">'.$so_item['actual_units'].' '.$so_item['unit_abbreviation'].' '.(($so_item['secondary_unit']>0)?'| '.$so_item['secondary_unit'].' '.$so_item['unit_abbreviation_2']:'').'</td> 
                                                                    <td align="right"><input hidden="" name="inv_items['.$row_count.'][item_unit_cost]" value="'.$so_item['sale_unit_price'].'">'. number_format($so_item['sale_unit_price'],2).'</td>
                                                                    <td align="right"><input class="item_line_discount" hidden="" name="inv_items['.$row_count.'][item_line_discount]" value="'.$so_item['discount_percent'].'">'. number_format($so_item['discount_percent'],2).'%</td>
                                                                    <td align="right"><input class="item_tots" hidden="" name="inv_items['.$row_count.'][item_total]" value="'.$sub_tot_actual.'">'. number_format($sub_tot_actual,2).'</td>
                                                                    <td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                                                </tr>';
                                                            $so_total += $sub_tot_actual;
                                                            $row_count++; 
                                                        }
                                                    }
                                                }
        
                                           ?> 
                                       </tbody>
                                       <tfoot id="inv_tbl_footer">
                                       </tfoot>
                                       <tfoot>
                                            <tr>
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Sub Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_sub_total"><span id="inv_sub_total">0.00</span></th>
                                                
                                            </tr>
                                       </tfoot>
                                       
                                       <tfoot id="inv_tbl_footer_addons"> 
                                       </tfoot>
                                       <tfoot>
                                            <tr>
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="<?php echo (isset($so_total)?$so_total:0);?>" name="invoice_total"  id="invoice_total"><span id="inv_total"><?php echo number_format($so_total,2);?></span></th>
                                            </tr> 
                                       </tfoot>
                                       
                                        </table>
                                </div>
                                <div id="search_result_1"></div>
                            </div>    
                        </div>
                        
                        <div class="row" id="footer_sales_form">
                            <h5>Order Delivery Info</h5>
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
                                    <label class="col-md-3 control-label">Deliver_Address<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_textarea(array('name'=>'delivery_address','rows'=>'4','id'=>'delivery_address','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter Delivery Address' ),$result['delivery_address'],$dis.' '.$o_dis.' '); ?>
                                         <!--<span class="help-block"><?php // echo form_error('delivery_address');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <hr>
                                <?php
//                                echo '<pre>';print_r($cr_data);
                                ?>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Consignee<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                        <?php  echo form_dropdown('consignee_id',$consignee_list,set_value('consignee_id',(isset($cr_data['consignee_id']))?$cr_data['consignee_id']:''),' class="form-control select2" data-live-search="true" id="consignee_id"');?>
                                        <?php  echo form_hidden('cr_id', (isset($cr_data['cr_id']))?$cr_data['cr_id']:'');?>
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
                                <button id="place_invoice" class="btn btn-app pull-right  primary <?php echo $view;?>"><i class="fa fa-check"></i><?php echo constant($action);?>  Invoice</button>
                
                            </div>
                        </div> 
                    </div>
                
              </div>
    </section>      
 
                 
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('so_id', isset($so_data['id'])?$so_data['id']:""); ?>
                            <?php echo form_hidden('action',$action); ?>
                            <?php echo form_close(); ?>               
                  
       
                            
    </div>
        <div class="col-md-12">
            <div class="box">
               <!-- /.box-header -->
               <!-- /.box-body -->
             </div>

        </div>
        
                    <!-- Modal -->
                    <div class="modal fade" id="checkout_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Invoice Checkout
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </h5>
                            
                          </div> 
                          <div class="modal-body form-horizontal">
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="total_amount" class="col-sm-3 control-label">Total Amount</label>
                                    <div class="col-sm-9">
                                        <input readonly type="total_amount" name="total_amount" class="form-control checkout_input" id="total_amount" placeholder="Total">
                                    </div>
                                  </div> 
                                    <hr>
                                  <div class="form-group">
                                    <label for="payment_term_id2" class="col-sm-3 control-label">Payment Terms</label>
                                    <div class="col-sm-9">
                                      <?php echo form_dropdown('payment_term_id2',$payment_term_list,set_value('payment_term_id2'),' class="form-control  checkout_input select2" style="width:100%;" data-live-search="true" id="payment_term_id2"');?>
                                    </div>
                                  </div> 
                                  <div class="form-group checkout_form">
                                    <label for="amount_tendered" class="col-sm-3 control-label">Amount Tendered</label>

                                    <div class="col-sm-9">
                                        <input type="amount_tendered" class="form-control checkout_input" id="amount_tendered" name="amount_tendered" placeholder="Total">
                                    </div>
                                  </div> 
                                  <div readonly class="form-group checkout_form">
                                    <label for="change_amount" class="col-sm-3 control-label checkout_input">Change</label>
                                    <div class="col-sm-9">
                                        <input readonly type="change_amount" class="form-control" name="change_amount" id="change_amount" value="0.00" placeholder="Change">
                                    </div>
                                  </div> 
                                    <hr>
                                  <div class="form-group"> 
                                    <div class="col-sm-12">
                                        <textarea class="form-control checkout_input" id="memo" name="memo" placeholder="Order Note.."></textarea>
                                    </div>
                                  </div>  
                                </div> 
                          </div>
                          <div class="modal-footer"> 
                              <button id="confirm_checkout"  class="btn btn-block btn-primary btn-lg">Place Invoice</button>
                          </div> 
                        </div>
                      </div>
                    </div> 
                           
</div>
    
<?php $this->load->view('sales_invoices/inv_modals/add_new_customer_model'); ?>
    
<script type="text/javascript">
  $('tbody').sortable();
</script>
<script>
    
$(document).keypress(function(e) {
//    fl_alert('warning',e.keyCode)
        if(e.keyCode == 13) {//13 for enter
            if ($(".add_item_inpt").is(":focus")) {
                    $('#add_item_btn').trigger('click');
//                fl_alert('warning',)
              }
            $('#item_code').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
          
//                $('#place_invoice').trigger('click');
            if (($("#checkout_modal").data('bs.modal') || {isShown: false}).isShown) {
                $('#confirm_checkout').trigger('click');    
            }else{
                $('#place_invoice').trigger('click');
            }
        }
    });
$(document).ready(function(){
    $("#amount_tendered").keyup(function(){ 
	var tot = $('#total_amount').val();
	var tndr = $('#amount_tendered').val();
        var change_bal = parseFloat(tndr) - parseFloat(tot);
        
        $('#change_amount').val((isNaN(change_bal.toFixed(2))?0.00:change_bal.toFixed(2)));
    });
    
    currency_calculation();
    $('#currency_code').change(function(){
        currency_calculation();
    }); 
    $("#payment_term_id2").change(function(){
        var pay_term = $('#payment_term_id2').val();
        if(pay_term==1){//cash payment
            $('.checkout_form').show()
        }else{
            $('.checkout_form').hide();
        }
    });
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
            $('#item_code').val('');
        if($('input[name^="inv_items"]').length<=0){
            fl_alert('warning',"Atleast one item need to create an invoice!")
            return false;
        }else{ 
            if(!confirm("Click ok confirm your invoice submission.")){
                return false;
            }
        }
//            return false;
    });
    
    //branch dropdown
    get_branch_drpdwn(); calc_total_invoice()
    $("#customer_id").change(function(){ 
//        fl_alert('warning',)
         get_branch_drpdwn();
    });
    $("#customer_branch_id").change(function(){ 
         set_cust_info();
    });
    $("#price_type_id").change(function(){ 
	 $('#item_code').trigger('keyup');
         get_branch_drpdwn();
    });
    
    $("#location_id").change(function(){ 
	 $('#item_code').trigger('keyup'); 
    });
    
    $('#checkout_modal').on('shown.bs.modal', function () {
        $('#amount_tendered').focus();
    })    
    
    $("#add_item_btn").click(function(){
//        fl_alert('warning','added');
         $.ajax({
			url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), location_id:$('#location_id').val(), price_type_id:$('#price_type_id').val()},
			success: function(result){
                            set_list_items(result);
                        }
		});
    });
	
	
    $("#item_code").val($('#item_desc').val());
    $('#item_code').trigger('keyup');
//    get_load_cookie_data();
    
//    $('#inv_total').on('DOMSubtreeModified',function(){ //on change span text
//        get_customers_addons();
//    });
    
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('Invoices/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
//                             $("#result_search").html(result);
//                             $(".dataTable").DataTable();
        }
		});
	}
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
        calc_total_invoice()
        $('#invoice_total').val(tot_amt.toFixed(2));
        $('#inv_total').text(tot_amt.toFixed(2)); 
    });
});

	function get_item_dets(id1=''){ //id1 for input element id
            $.ajax({
			url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), location_id:$('#location_id').val(), price_type_id:$('#price_type_id').val()},
			success: function(result){
//                            alert(result)
//                            $("#search_result_1").html(result);
                            var res1 = JSON.parse(result); 
                            var price_converted = 0;
                            if(typeof(res1.price_amount) != 'undefined'){
                                price_converted = (parseFloat(res1.price_amount)/res1.currency_value) * parseFloat($('#currency_value').val());
                            }
                            $('#cur_code_lineform').text('('+$('#currency_code').val()+')');
                            
                             $('#first_col_form').removeClass('col-md-offset-1');
                            var div_str = '<div class="col-md-2">'+
                                                    '<div class="form-group pad">'+
                                                        '<label for="item_quantity">Quantity <span id="unit_abbr">[Each]<span></label>'+
                                                        '<input type="number" min="0" step=".001" name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quantity">'+
                                                    '</div>'+
                                                '</div>';
                            if(res1.item_uom_id_2!=0){
                                    div_str = div_str + '<div class="col-md-2">'+
                                                            '<div class="form-group pad">'+
                                                                '<label for="item_quantity_2">Quantity <span id="unit_abbr_2">[Each]<span></label>'+
                                                                '<input type="number" min="0"  step=".001" name="item_quantity_2" class="form-control add_item_inpt" value="1" id="item_quantity_2" placeholder="Enter Quantity">'+
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
                                $('#item_unit_cost').val(price_converted.toFixed());
                                $('#unit_abbr').text('['+((res1.stock!="")?res1.stock.units_available:0)+' '+res1.unit_abbreviation+']');
                                $('#prce_unit_name').text(res1.unit_abbreviation);
                                
                                $('#item_quantity').val(((res1.stock!="")?res1.stock.units_available:0));
                                $('#item_quantity_2').val(((res1.stock!="")?res1.stock.units_available_2:0));
//                                if(res1.stock.units_available_2=='1'){
//                                    $('#item_quantity').val(res1.stock.units_available);
//                                }else{
//                                    $('#item_quantity').val(1);
//                                }
                                $('#unit_abbr_2').text('['+((res1.stock!="")?res1.stock.units_available_2:0)+' '+res1.unit_abbreviation_2+']');
//                                $('#item_discount').val(0);

                                $("#result_search").html(result);
                            }
                        }
		});
	}
        
        function set_list_items(result,set_cookie_data=''){
        
                                if(set_cookie_data==''){
                                    
//                            $("#search_result_1").html(result);
                                    var res2 = JSON.parse(result);
                                    var unit_cost1 = $('#item_unit_cost').val();
                                    if (!$('#is_price_per_unit').is(":checked")) unit_cost1 = parseFloat($('#item_unit_cost').val()) / parseFloat($('#item_quantity').val());
                                    var item_qty1 = $('#item_quantity').val();
                                    var item_qty2 = $('#item_quantity_2').val();
                                    var item_code1 = $('#item_code').val();
                                    var item_discount1 = (isNaN(parseFloat($('#item_discount').val())))?0:$('#item_discount').val();
                                    var invs_total1 = $('#invoice_total').val();
                                }else{ 
                                    var unit_cost1 = set_cookie_data.item_unit_cost;
                                    if (!$('#is_price_per_unit').is(":checked")) unit_cost1 = parseFloat(set_cookie_data.item_unit_cost)/parseFloat(set_cookie_data.item_quantity);
                                    var unit_cost1 = set_cookie_data.item_unit_cost;
                                    var item_qty1 = set_cookie_data.item_quantity;
                                    var item_qty2 = set_cookie_data.item_quantity_2;
                                    var item_code1 = set_cookie_data.item_code;
                                    var item_desc1 = set_cookie_data.item_desc;
                                    var item_discount1 = $('#item_discount').val();
                                    var invs_total1 = set_cookie_data.inv_tot;
                                    var res2 = {item_code: item_code1,
                                                item_name:item_desc1,
                                                id:set_cookie_data.item_id,
                                                item_uom_id:set_cookie_data.item_quantity_uom_id,
                                                item_uom_id_2:set_cookie_data.item_quantity_uom_id_2,
                                                unit_abbreviation:set_cookie_data.unit_abbreviation,
                                                unit_abbreviation_2:set_cookie_data.unit_abbreviation_2,
                                                }; 
                                }
                                  
//                                    return false;
//                                $("#search_result_1").html(result); 

                                if(parseFloat(unit_cost1)<=0 || isNaN(parseFloat(unit_cost1)) ){
                                    unit_cost1 =0;
                                    
//                                    fl_fl_alert('warning','warning','Item Price invalid! Please recheck before add.');
                                    fl_alert('warning','Item Price invalid! Please recheck before add.');
                                    return false;
                                } 
                                if(parseFloat(item_discount1) > (parseFloat(unit_cost1) * parseFloat(item_qty1))){
                                    fl_alert('warning','Discount amount can not be overtaken the item price!');
                                    return false;
                                }
                                
                                var cur_req_qty = parseFloat(item_qty1);
                                $('.qty_'+item_code1).each(function() { 
                                    cur_req_qty = cur_req_qty +  parseFloat(this.value)
                                });
                                
                                if(parseFloat(res2.stock.units_available)<parseFloat(item_qty1) || parseFloat(res2.stock.units_available_2)<parseFloat(item_qty2) ){
                                    fl_alert('warning','Please check the Item line Quantity.');
                                    return false;
                                }  
                                
                                if(res2.item_code==null){
                                    fl_alert('warning','Item invalid! Please recheck before add.');
                                    return false;
                                }
                                
                                var rowCount = $('#invoice_list_tbl tr').length;
                                var counter = rowCount+1;
                                var qtyXprice = parseFloat(unit_cost1) * parseFloat(item_qty1);
                                var line_disc_amount = (parseFloat(item_discount1)* 0.01 * qtyXprice);
                                var item_total = qtyXprice - (parseFloat(item_discount1)* 0.01 * qtyXprice);
//                                var item_total = qtyXprice;
                                
                                
                                var row_str = '<tr style="padding:10px" id="tr_'+rowCount+'">'+ 
                                                        '<td><span id="'+rowCount+'_row_cntr" class="row_counter_cls"></span></td>'+
                                                        '<td><input class="itemcode_cls"  hidden name="inv_items['+rowCount+'][item_code]" value="'+item_code1+'">'+item_code1+'</td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+rowCount+'][item_id]" value="'+res2.id+'">'+res2.item_name+'</td>'+
                                                        '<td align="center"><input hidden name="inv_items['+rowCount+'][item_quantity]" value="'+item_qty1+'"><input hidden name="inv_items['+rowCount+'][item_quantity_2]" value="'+((item_qty2==null)?0:item_qty2)+'">'+
                                                        '<input hidden name="inv_items['+rowCount+'][unit_abbreviation]" value="'+res2.unit_abbreviation+'"><input hidden name="inv_items['+rowCount+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="inv_items['+rowCount+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                item_qty1+' '+res2.unit_abbreviation;
                                if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
                                    row_str = row_str + ' | ' + item_qty2+' '+res2.unit_abbreviation_2+'<input hidden name="inv_items['+rowCount+'][unit_abbreviation_2]" value="'+res2.unit_abbreviation_2+'">';
                                }                                                                                                                                                                                                                                                                        
                                row_str = row_str + '</td> <td id="td_unitcost_'+rowCount+'"  align="right"><input class="cell_cur_value"  value="'+$('#currency_value').val()+'" hidden><input hidden class="cell_price" name="inv_items['+rowCount+'][item_unit_cost]" value="'+unit_cost1+'"><span class="cell_price_text">'+parseFloat(unit_cost1).toFixed(2)+'</span></td>'+ 
                                                        '<td align="right"><input class="item_line_discount" hidden name="inv_items['+rowCount+'][item_line_discount]" value="'+item_discount1+'">'+line_disc_amount.toFixed(2)+' ('+item_discount1+' %)</td>'+
                                                        '<td id="td_to_'+rowCount+'" align="right"><input class="cell_cur_value" hidden name="inv_items['+rowCount+'][item_cur_value]" value="'+$('#currency_value').val()+'"><input class="item_tots cell_price" hidden name="inv_items['+rowCount+'][item_total]" value="'+item_total+'"><span class="cell_price_text">'+item_total.toFixed(2)+'</span></td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>';
                                var newRow = $(row_str);var exist_item=0;
                                $('.itemcode_cls').each(function(){
                                    if(this.value == item_code1){
                                        fl_alert('warning',"This Item already added to list!")
                                        exist_item = 1;
                                    }
                                });
                                if(exist_item==0){
                                    jQuery('table#invoice_list_tbl ').prepend(newRow);
                                }
                                
                                //set row sew no
                                var seq_no=1;
                                $($('.row_counter_cls').get().reverse()).each(function(){
                                  $('#'+(this.id)).text(seq_no); seq_no++;
                                }); 
//                                jQuery('table#invoice_list_tbl').append(newRow);
                                var inv_total = parseFloat(invs_total1) + ((set_cookie_data=='')?item_total:0);
                                $('#invoice_total').val(inv_total.toFixed(2));
                                $('#total_amount').val(inv_total.toFixed(2));
                                $('#inv_total').text(inv_total.toFixed(2));

                                $('#item_code').val('');
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
                                    set_list_cookies();
                                    calc_total_invoice()
                                    get_customers_addons();
                                    
                                });
                                set_list_cookies();
                                calc_total_invoice();
                                get_customers_addons();
                                
        }
        function set_list_cookies(){
            var tabl_data = jQuery('#form_search').serializeArray(); 
            var myArray = [];
             myArray['formdata'] = tabl_data;
             myArray['test'] = 'fahry lafir';
//            tabl_data.push(1000);
//            tabl_data.push("asasasas");
//            fl_alert('warning',JSON.stringify(tabl_data));
//            return false;
                
            $.ajax({
			url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=item_list_set_cookies');?>",
			type: 'post',
			data : myArray['formdata'],
			success: function(result){
//                                $("#search_result_1").html(result); 
                        }
            });
        }
        
        function get_load_cookie_data(){ 
    //        fl_alert('warning','loading');
             $.ajax({
                            url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_cookie_data_itms');?>",
                            type: 'post',
                            data : {function_name:'get_cookie_data_itms'},
                            success: function(result){

                                         var res2 = JSON.parse(result);
//                                             console.log(res2.customer_id);return false;
    //                                $("#search_result_1").html(res2.inv_items);
                                        total = 0;
                                        $('#customer_id').val((res2.customer_id!=null)?res2.customer_id:'').trigger('change');
                                        $('#sales_type_id').val((res2.sales_type_id!=null)?res2.sales_type_id:'').trigger('change');
                                        $('#payment_term_id').val((res2.payment_term_id!=null)?res2.payment_term_id:'').trigger('change');
                                        $('#currency_code').val((res2.currency_code!=null)?res2.currency_code:'').trigger('change');
                                        $('#location_id').val((res2.location_id!=null)?res2.location_id:'').trigger('change');
                                        $('#invoice_date').val((res2.invoice_date!=null)?res2.invoice_date:'').trigger('change');
                                        
                                        if(res2.inv_items!=null){
                                            $.each(res2.inv_items, function (index, value) { 
                                                total = parseFloat(total) + parseFloat(value.item_total);
                                                value.inv_tot = total;
//                                                console.log(value );
                                                set_list_items('',value)

                                              }); 
                                          }
                            }
                    }); 
        }
        
        
        function get_branch_drpdwn(br_id=''){
                  var cust_id = parseInt($('#customer_id').val()); 
                  
                    $.ajax({
                           url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_dropdown_branch_data');?>",
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
                                 
                                if($('#action').val()=='Add'){
//                                    fl_alert('warning',)
                                    $('#customer_branch_id').trigger('change');
                                }else{ 
                                    $("#customer_branch_id option[value=<?php echo $result['customer_branch_id'];?>]").attr('selected', 'selected').change(); 
                                }
                               }
                   });
                    
                   if($('input[name=action]').val()=='Add'){
                    set_cust_info()
                   }
                   
                get_customers_addons();
            }
        
        function set_cust_info(){
                                
                    $.ajax({
                           url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_single_customer');?>",
                           type: 'post',
                           data : {function_name:'get_single_customer',customer_id:$('#customer_id').val()},
                           success: function(result){
//                            $("#search_result_1").html(result);return false;
//                                console.log(result);return  false;
                                var obj2 = JSON.parse(result);
                                $('#delivery_address').text(obj2.address+((obj2.city!="")?', '+obj2.city:'')+((obj2.country_name!="")?', '+obj2.country_name:''));
                                $('#customer_phone').val(obj2.phone); 

                               }
                   });
                   
            }
            function calc_total_invoice(){
                var tot_amt = 0;
                $('input[class^="item_tots"]').each(function() { 
                    tot_amt = tot_amt + parseFloat($(this).val());
                   
                }); 
                if($('input[name=so_id]').val()!=''){
                    $.ajax({
                              url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_calculate_required_payment');?>",
                              type: 'post',
                              data : {function_name:'get_calculate_required_payment',total_amount:tot_amt,order_id:$('input[name=so_id]').val()},
                              success: function(result){
   //                               fl_alert('warning',)
   //                            $("#search_result_1").html(result);
                                   var obj2 = JSON.parse(result);
                                   console.log(obj2);
//                                   return  false; 
                                    var required_payment = parseFloat(obj2.required_calculated);
                                    var locked_amount= parseFloat(obj2.locked_amount);
//                                    fl_alert('warning',required_payment)
                                    
                                    $('#inv_tbl_footer').html('');
                                    if(required_payment>0){
                                        var row_str = '<tr>'+
                                                            '<td style="color:red" colspan="5" align="right">Need to pay for settle invoice</td>'+
                                                            '<td align="right">'+Math.abs(required_payment).toFixed(2)+'</td>'+
                                                        '</tr>';
                                               var row_str1 = '';
                                        if(parseFloat(obj2.releasable_amount)>0){
                                             row_str1 = '<tr>'+
                                                                '<td style="color:blue" colspan="5" align="right">releasable Order Advance</td>'+
                                                                '<td align="right">'+Math.abs(obj2.releasable_amount).toFixed(2)+'</td>'+
                                                            '</tr>';
                                                }
                                                $('#inv_tbl_footer').html(row_str1+row_str);
                                        }
                                  }
                      });
                }
            }
            
            function get_customers_addons(){ 
            
                recalculate_totals();
                 $.ajax({
                        url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=get_customer_addons');?>",
                        type: 'post',
                        data : {function_name:"get_customer_addons",customer_id:$('#customer_id').val()},
                        success: function(result){ 
//                            fl_alert('info',$('#customer_id').val())
                                var obj1 = JSON.parse(result);
                                $('.addon_rows').remove();
                                $.each(obj1,function(index,addon){ 
//                                    fl_alert('info',addon['currency_value'])
                                    var inv_line_tot = parseFloat($('#invoice_sub_total').val());
//                                    fl_alert('info',addon['calculation_type']); 
                                    var addon_amount = 0;
                                    if(addon['calculation_type']==1){//fxd amnt:1 percentage :2
                                        addon_amount = parseFloat(addon['addon_value']) * (parseFloat($('#currency_value').val())/parseFloat(addon['currency_value']));
                                        if(addon['addon_type']==2){//substract
                                            addon_amount = -addon_amount;
                                        }
                                    }
                                    
                                    var perc_txt = '';
                                    if(addon['calculation_type']==2){//fxd amnt:1 percentage :2
                                        
                                        var percnt = parseFloat(addon['addon_value']);
                                        perc_txt = '('+percnt+'%)'
//                                        fl_alert('info',percnt+'-percentage')
                                        addon_amount = (percnt/100)*inv_line_tot;
                                        if(addon['addon_type']==2){//substract
                                            addon_amount = -addon_amount;
                                        }
                                    }
                                    
                                    var new_trns_row_str = '<tr class="addon_rows" id="addon_tr_'+addon['id']+'">'+
                                                                '<td colspan="4"></td>'+
                                                                '<td align="right">'+addon['addon_name']+' '+perc_txt+'</span></td>'+
                                                                '<td id="addon_tdv_'+addon['id']+'" align="right"><input class="cell_cur_value"  value="'+$('#currency_value').val()+'" hidden><input class="addon_inputs cell_price" name="addons['+addon['id']+']" value="'+addon_amount+'" hidden><span class="cell_price_text">'+(addon_amount).toFixed(2)+'</span></td>'+
                                                             '</tr>';

                                    var new_trns_row = $(new_trns_row_str);
                                    $('table #inv_tbl_footer_addons').append(new_trns_row);  
//                                    fl_alert('info',addon_amount)
//                                    return false;
                                });
                                    recalculate_totals() 
                            }
                    });
            }
            function currency_calculation(){
                $.ajax({
                        url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_cur_det_code_json');?>",
                        type: 'post',
                        data : {function_name:"get_cur_det_code_json",currency_code:$('#currency_code').val()},
                        success: function(result){ 
                            var cur_obj = JSON.parse(result);
                            $('#currency_value').val(cur_obj.value);
                            get_item_dets();
                            
                            $('.cell_price').each(function(){ 
                                var td_id = $(this).closest('td').attr('id');
                                
                                var exist_amount = parseFloat(this.value);
                                var exist_curval = parseFloat($('#'+td_id+' .cell_cur_value').val());
                                var new_curval = parseFloat($('#currency_value').val());
                                
                                var converted_amount =  (new_curval/exist_curval) * exist_amount;
                                
                                $('input[name="'+this.name+'"]').val(converted_amount);
                                
//                                alert( exist_curval)
                                $('#'+td_id+' .cell_price_text').text(converted_amount.toFixed(2));
                                $('#'+td_id+' .cell_cur_value').val(new_curval);
//                                alert($(this).closest('td').attr('id'))
                                recalculate_totals();
                            });
//                            alert(cur_obj.value)
                        }
                });
            
            }
            function recalculate_totals(){ 
//            alert();
                var tot_amt = 0;
                var subtot= 0;
                $('input[class^="item_tots"]').each(function() { 
                    subtot = subtot + parseFloat($(this).val());
                   
                });  
                tot_amt += subtot;
               
                //addons
               var addon_tot = 0;
               $('.addon_inputs').each(function() {  
                   addon_tot = addon_tot + parseFloat($(this).val());
               });
//                   alert(addon_tot)
               tot_amt += addon_tot;
               
                $('#invoice_total').val(tot_amt.toFixed(2));
                $('#inv_total').text(tot_amt.toFixed(2)); 
                
                $('#invoice_sub_total').val(subtot.toFixed(2));
                $('#inv_sub_total').text(subtot.toFixed(2)); 
                
            }
            $(document).ready(function(){//Dynamic itemloader for select2
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
</script> 