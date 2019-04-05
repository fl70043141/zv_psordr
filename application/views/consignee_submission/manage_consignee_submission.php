<?php
	
	$result = array(
                        'id'=>"",
                        'consignee_id'=>(isset($so_data['consignee_id'])?$so_data['consignee_id']:""),  
                        'price_type_id'=>(isset($so_data['price_type_id'])?$so_data['price_type_id']:"15"),
                        'payment_term_id'=>"1",
                        'reference'=> (isset($so_data['id'])?'SO-'.$so_data['sales_order_no']:date('Ymd-Hi')),
                        'submitted_date'=>date('m/d/Y'),
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

//var_dump($result);
?> 
<!-- Main content -->


<?php // echo '<pre>'; print_r($so_data); die;?>

<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

    
<!--    
        <div class="">
            <a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
            <a href="<?php // echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>

        </div>-->
    </div>
    
 <!--<br><hr>-->
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
            <?php  echo form_hidden('commission_plan',0);?>
            <?php  echo form_hidden('commission_amount',0);?>
                                         
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Consignee<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('consignee_id',$customer_list,set_value('consignee_id',$result['consignee_id']),' class="form-control select2" data-live-search="true" id="consignee_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Price List<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('price_type_id',$price_type_list,set_value('price_type_id',$result['price_type_id']),' class="form-control select2" data-live-search="true" id="price_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            <div class="col-md-4">
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
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('submitted_date',set_value('submitted_date',$result['submitted_date']),' class="form-control datepicker" readonly id="submitted_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('submitted_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div> 
                        </div>
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Add Item for Consignee Submission</h4> 
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
                                                <?php echo form_dropdown('item_desc',$item_list,set_value('item_desc'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="item_desc"');?>
                                            </div>
                                        </div>
                                        <div id="uom_div">
                                            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group pad">
                                                <label for="item_unit_cost">Unit Cost</label>
                                                <input type="number" min="0"  step=".001"  name="item_unit_cost" class="form-control add_item_inpt" id="item_unit_cost" placeholder="Unit Cost for item">
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
//                                                        echo '<pre>';print_r($so_item);  
                                                        echo '
                                                            <tr style="padding:10px" id="tr_3">
                                                                <td><input hidden="" name="inv_items['.$row_count.'][item_code]" value="'.$so_item['item_code'].'">'.$so_item['item_code'].'</td>
                                                                <td><input hidden="" name="inv_items['.$row_count.'][item_desc]" value="'.$so_item['item_desc'].'"><input hidden="" name="inv_items['.$row_count.'][item_id]" value="'.$so_item['item_id'].'">'.$so_item['item_desc'].'</td>
                                                                <td align="right"><input hidden="" name="inv_items['.$row_count.'][item_quantity]" value="'.$so_item['units'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_2]" value="'.$so_item['secondary_unit'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_uom_id]" value="'.$so_item['unit_uom_id'].'"><input hidden="" name="inv_items['.$row_count.'][item_quantity_uom_id_2]" value="'.$so_item['secondary_unit_uom_id'].'">'.$so_item['units'].' '.$so_item['unit_abbreviation'].' '.(($so_item['secondary_unit']>0)?'| '.$so_item['units'].' '.$so_item['unit_abbreviation_2']:'').'</td> 
                                                                <td align="right"><input hidden="" name="inv_items['.$row_count.'][item_unit_cost]" value="'.$so_item['unit_price'].'">'. number_format($so_item['unit_price']).'</td>
                                                                <td align="right"><input class="item_tots" hidden="" name="inv_items['.$row_count.'][item_total]" value="'.$so_item['sub_total'].'">'. number_format($so_item['sub_total'],2).'</td>
                                                                <td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                                            </tr>';
                                                        $so_total += $so_item['sub_total'];
                                                        $row_count++; 
                                                    }
                                                }
                                           ?> 
                                       </tbody>
                                       <tfoot>
                                            <tr>
<!--                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Sub Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                                <th  style="text-align: right;"></th>
                                            </tr>-->
                                            
                                            <tr>
                                                <th colspan="4"></th>
                                                <th  style="text-align: right;">Sub Total</th>
                                                <th  style="text-align: right;"><input hidden value="<?php echo (isset($so_total)?$so_total:0);?>" name="invoice_sub_total" id="invoice_sub_total"><span id="inv_sub_tot"><?php echo number_format($so_total,2);?></span></th>
                                            </tr>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th colspan="2" style="text-align: right;">Consignee Commission <span id="commiss_val"></span></th>
                                                <th  style="text-align: right;"><input hidden value="<?php echo (isset($so_total)?$so_total:0);?>" name="total_commission" id="total_commission"><span id="total_commiss"><?php echo number_format($so_total,2);?></span></th>
                                            </tr> 
                                            <tr>
                                                <th colspan="4"></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="<?php echo (isset($so_total)?$so_total:0);?>" name="invoice_total" id="invoice_total"><span id="inv_total"><?php echo number_format($so_total,2);?></span></th>
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
                                    <label class="col-md-3 control-label">Memo<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                        <?php echo form_textarea(array('name'=>'memo','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter any comments' ),$result['memo'],$dis.' '.$o_dis.' '); ?>
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
                                
                            </div>
                            <div class="col-md-12">
                                <button id="place_invoice" class="btn btn-app pull-right  primary <?php echo $view;?>"><i class="fa fa-check"></i><?php echo constant($action);?>  Order</button>
                
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
    
<script type="text/javascript">
  $('tbody').sortable();
</script>
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
    get_consignee_info()
    $("#consignee_id").change(function(){ 
	get_consignee_info();
    });
	 
    $("#item_desc").on("change focus",function(){
        if(event.type == "focus")
             $("#item_code").val($('#item_desc').val());
            get_item_dets(this.id);
    });
    $("#place_invoice").click(function(){
        if($('input[name^="inv_items"]').length<=0){
            fl_alert('info',"Atleast one item need to create an invoice!")
            return false;
        }else{
            if(!confirm("Click ok confirm your invoice submission.")){
            return false;
        }
        }
//            return false;
    });
     
    
    $("#price_type_id").change(function(){ 
	 $('#item_code').trigger('keyup'); 
    });
    
    $('#checkout_modal').on('shown.bs.modal', function () {
        $('#amount_tendered').focus();
    })    
    
    $("#add_item_btn").click(function(){
//        fl_alert('info','added');
         $.ajax({
			url: "<?php echo site_url('Consignee_submission/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), price_type_id:$('#price_type_id').val()},
			success: function(result){
                            set_list_items(result);
                        }
		});
    });
	
	
    $("#item_code").val($('#item_desc').val());
    $('#item_code').trigger('keyup');
//    get_load_cookie_data();
    
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
        $('#invoice_total').val(tot_amt.toFixed(2));
        $('#inv_total').text(tot_amt.toFixed(2)); 
    });
});

	function get_item_dets(id1=''){ //id1 for input element id
            $.ajax({
			url: "<?php echo site_url('Consignee_submission/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), price_type_id:$('#price_type_id').val(),location_id:$('#location_id').val()},
			success: function(result){
                            
//                            $("#search_result_1").html(result);
                            var res1 = JSON.parse(result);
                            
                             $('#first_col_form').removeClass('col-md-offset-1');
                            var div_str = '<div class="col-md-2">'+
                                                    '<div class="form-group pad">'+
                                                        '<label for="item_quantity">Quantity <span id="unit_abbr">[Each]<span></label>'+
                                                        '<input type="number" min="0"  step=".001"  name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quantity">'+
                                                    '</div>'+
                                                '</div>';
                            if(res1.item_uom_id_2!=0){
                                    div_str = div_str + '<div class="col-md-2">'+
                                                            '<div class="form-group pad">'+
                                                                '<label for="item_quantity_2">Quantity <span id="unit_abbr_2">[Each]<span></label>'+
                                                                '<input type="number" min="0"  step=".001"  name="item_quantity_2" class="form-control add_item_inpt" value="1" id="item_quantity_2" placeholder="Enter Quantity">'+
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
                                $('#unit_abbr').text('['+res1.stock.units_available+' '+res1.unit_abbreviation+']');
                                $('#unit_abbr_2').text('['+res1.stock.units_available_2+' '+res1.unit_abbreviation_2+']');
//                                $('#item_discount').val(0);
                                $('#item_quantity').val(res1.stock.units_available);
                                $('#item_quantity_2').val(res1.stock.units_available_2);

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
                                    var item_qty1 = $('#item_quantity').val();
                                    var item_qty2 = $('#item_quantity_2').val();
                                    var item_code1 = $('#item_code').val();
                                    var item_discount1 = $('#item_discount').val();
                                    var invs_total1 = $('#invoice_sub_total').val();
                                    var commiss_plan1 = $('input[name=commission_plan]').val();
                                    var commiss_amount1 = $('input[name=commission_amount]').val();
                                }else{ 
                                    var unit_cost1 = set_cookie_data.item_unit_cost;
                                    var item_qty1 = set_cookie_data.item_quantity;
                                    var item_qty2 = set_cookie_data.item_quantity_2;
                                    var item_code1 = set_cookie_data.item_code;
                                    var item_desc1 = set_cookie_data.item_desc;
                                    var item_discount1 = $('#item_discount').val();
                                    var invs_total1 = set_cookie_data.inv_tot;
                                    var commiss_plan1 = $('input[name=commission_plan]').val();
                                    var commiss_amount1 = $('input[name=commission_amount]').val();
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
                                if((parseFloat(res2.stock.units_available)<parseFloat(item_qty1) || parseFloat(res2.stock.units_available_2)<parseFloat(item_qty2)) || parseFloat(item_qty2)<=0){
                                    fl_alert('info','Please check the Item line Quantity.');
                                    return false;
                                }
                                
                                if(res2.item_code==null){
                                    fl_alert('info','Item invalid! Please recheck before add.');
                                    return false;
                                }
                                var rowCount = $('#invoice_list_tbl tr').length;
                                var counter = rowCount+1;
                                var qtyXprice = parseFloat(unit_cost1) * parseFloat(item_qty1);
                                var line_disc_amount = (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
                                var item_total = qtyXprice - (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
//                                var item_total = qtyXprice;
                                
                                
                                var row_str = '<tr style="padding:10px" id="tr_'+rowCount+'">'+ 
                                                        '<td><input hidden name="inv_items['+rowCount+'][item_code]" value="'+item_code1+'">'+item_code1+'</td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+rowCount+'][item_id]" value="'+res2.id+'">'+res2.item_name+'</td>'+
                                                        '<td align="center"><input hidden name="inv_items['+rowCount+'][item_quantity]" value="'+item_qty1+'"><input hidden name="inv_items['+rowCount+'][item_quantity_2]" value="'+((item_qty2==null)?0:item_qty2)+'">'+
                                                        '<input hidden name="inv_items['+rowCount+'][unit_abbreviation]" value="'+res2.unit_abbreviation+'"><input hidden name="inv_items['+rowCount+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="inv_items['+rowCount+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                item_qty1+' '+res2.unit_abbreviation;
                                if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
                                    row_str = row_str + ' | ' + item_qty2+' '+res2.unit_abbreviation_2+'<input hidden name="inv_items['+rowCount+'][unit_abbreviation_2]" value="'+res2.unit_abbreviation_2+'">';
                                }                                                                                                                                                                                                                                                                        
                                row_str = row_str + '</td> <td align="right"><input hidden name="inv_items['+rowCount+'][item_unit_cost]" value="'+unit_cost1+'">'+parseFloat(unit_cost1).toFixed(2)+'</td>'+ 
                                                        '<td align="right"><input class="item_line_discount" hidden name="inv_items['+rowCount+'][item_line_discount]" value="'+item_discount1+'">'+line_disc_amount.toFixed(2)+' ('+item_discount1+' %)</td>'+
                                                        '<td align="right"><input class="item_tots" hidden name="inv_items['+rowCount+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>';
                                var newRow = $(row_str);
                                jQuery('table#invoice_list_tbl ').append(newRow);
                                var inv_sub_total = parseFloat(invs_total1) + ((set_cookie_data=='')?item_total:0);
                                var consignee_commiss = 0; 
                                if(commiss_plan1=="1"){//percentage
                                    consignee_commiss = parseFloat(commiss_amount1)*0.01*parseFloat(inv_sub_total) ;
                                }
                                if(commiss_plan1=="2"){//fixed
                                    consignee_commiss = parseFloat(commiss_amount1) ;
                                }    
                                
//                                fl_alert('info',consignee_commiss)
                                var inv_total = inv_sub_total - consignee_commiss;
                                
                                $('#invoice_sub_total').val(parseFloat(inv_sub_total).toFixed(2));
                                $('#inv_sub_tot').text(parseFloat(inv_sub_total).toFixed(2));
                                $('#total_commission').val(consignee_commiss.toFixed(2));
                                $('#total_commiss').text(consignee_commiss.toFixed(2));
                                $('#invoice_total').val(inv_total.toFixed(2));
                                $('#total_amount').val(inv_total.toFixed(2));
                                $('#inv_total').text(inv_total.toFixed(2));

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
                                     if(commiss_plan1=="1"){//percentage
                                        consignee_commiss = parseFloat(commiss_amount1)*0.01*parseFloat(tot_amt) ;
                                    }
                                    if(commiss_plan1=="2"){//fixed
                                        consignee_commiss = parseFloat(commiss_amount1) ;
                                    }  
                                     $('#inv_sub_tot').text(parseFloat(tot_amt).toFixed(2));
                                    $('#total_commission').val(consignee_commiss.toFixed(2));
                                    $('#total_commiss').text(consignee_commiss.toFixed(2));
                                    
                                    $('#invoice_total').val(tot_amt.toFixed(2));
                                    $('#total_amount').val(tot_amt.toFixed(2));
                                    $('#inv_total').text(tot_amt.toFixed(2)); 
                                    set_list_cookies();
                                });
                                set_list_cookies();
                                
        }
        function set_list_cookies(){
            var tabl_data = jQuery('#form_search').serializeArray(); 
            var myArray = [];
             myArray['formdata'] = tabl_data;
             myArray['test'] = 'fahry lafir';
//            tabl_data.push(1000);
//            tabl_data.push("asasasas");
//            fl_alert('info',JSON.stringify(tabl_data));
//            return false;
                
            $.ajax({
			url: "<?php echo site_url('Consignee_submission/fl_ajax?function_name=item_list_set_cookies');?>",
			type: 'post',
			data : myArray['formdata'],
			success: function(result){
//                                $("#search_result_1").html(result); 
                        }
            });
        }
        
        function get_load_cookie_data(){ 
    //        fl_alert('info','loading');
             $.ajax({
                            url: "<?php echo site_url('Consignee_submission/fl_ajax?function_name=get_cookie_data_itms');?>",
                            type: 'post',
                            data : {function_name:'get_cookie_data_itms'},
                            success: function(result){

                                         res2 = JSON.parse(result);
//                                             console.log(res2.consignee_id);return false;
    //                                $("#search_result_1").html(res2.inv_items);
                                        total = 0;
                                        $('#consignee_id').val((res2.consignee_id!=null)?res2.consignee_id:'').trigger('change');
                                        $('#sales_type_id').val((res2.sales_type_id!=null)?res2.sales_type_id:'').trigger('change');
                                        $('#payment_term_id').val((res2.payment_term_id!=null)?res2.payment_term_id:'').trigger('change');
                                        $('#currency_code').val((res2.currency_code!=null)?res2.currency_code:'').trigger('change');
                                        $('#location_id').val((res2.location_id!=null)?res2.location_id:'').trigger('change');
                                        $('#submitted_date').val((res2.submitted_date!=null)?res2.submitted_date:'').trigger('change');
                                        
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
        
        function get_consignee_info(){ 
             $.ajax({
                            url: "<?php echo site_url('Consignee_submission/fl_ajax?function_name=get_consignee_info');?>",
                            type: 'post',
                            data : {function_name:'get_cookie_data_itms', consignee_id:$('#consignee_id').val()},
                            success: function(result){ 
//                                    $("#search_result_1").html(result); 
                                    res2 = JSON.parse(result);
//                                    console.log(res2);
//                                    fl_alert('info',res2.id);
                                    $('input[name=commission_plan]').val(res2.commission_plan);
                                    $('input[name=commission_amount]').val(res2.commission_amount);
                                        if(res2.commission_plan ==1){
                                            $('#commiss_val').text(' ('+parseFloat(res2.commission_amount).toFixed(2)+' %)');
                                        }
                                        if(res2.commission_plan ==2){
                                            $('#commiss_val').text(' ('+parseFloat(res2.commission_amount).toFixed(2)+')');
                                        }
//                                             console.log(res2.consignee_id);return false; 
                                        
                            }
                    }); 
        }
        
         $(document).ready(function(){
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
</script>
 