
<script src="<?php echo base_url('templates/plugins/barcode_scan_detector/jquery.scannerdetection.compatibility.js')?>"></script>
<script src="<?php echo base_url('templates/plugins/barcode_scan_detector/jquery.scannerdetection.js')?>"></script>

<?php
	
	$result = array(
                        'id'=>"",
//                        'customer_id'=>(isset($so_data['customer_id'])?$so_data['customer_id']:""), 
                        'customer_id'=> 1, //regular Pos
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

<?php // echo '<pre>'; print_r($so_data); die;?>
  
<div class="col-md-12">
    <br>    
    
 <!--<br><hr>-->
    <section  class="content"> 
        <!--Flash Error Msg-->
        <?php  if($this->session->flashdata('error') != ''){ ?>
        <div class='alert alert-danger ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1000).slideUp(750);});</script>
        </div>
        <?php } ?>

        <?php  if($this->session->flashdata('warn') != ''){ ?>
        <div class='alert alert-success ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('warn'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1000).slideUp(750);});</script>
        </div>
        <?php } ?>  
        
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary"> 
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open($this->router->fetch_class()."/validate", 'id="form_search" class="form-horizontal"')?>  
             
            <?php echo form_hidden('invoice_date', $result['invoice_date']); ?>
            <?php echo form_dropdown('customer_id',$customer_list2 , set_value('customer_id',$result['customer_id']),'id="customer_id" hidden'); ?>
            <?php // echo form_hidden('customer_id', $result['customer_id']); ?>
            <?php echo form_hidden('payment_term_id', $result['payment_term_id']); ?>
            <?php echo form_hidden('currency_code', $result['currency_code']); ?>
               
            <?php  $print_inv_id = $this->session->flashdata('prn_id'); echo form_hidden('prn_id', (isset($print_inv_id))?$print_inv_id:''); ?>
            <?php  $temp_inv_id_recall = $this->session->flashdata('temp_inv_id_recall'); echo form_hidden('temp_inv_id_recall', (isset($temp_inv_id_recall))?$temp_inv_id_recall:''); ?>
                    <div class="box-body">  
                        <div class="row header_form_sales">  
                            
                            <div hidden class="col-md-9">   
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Price List<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('price_type_id',$price_type_list,set_value('price_type_id',$result['price_type_id']),' class="form-control select2" data-live-search="true" id="price_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            
                            <div hidden class="form-group">
                              <label for="payment_term_id2" class="col-sm-3 control-label">Payment Terms</label>
                              <div class="col-sm-9">
                                <?php echo form_dropdown('payment_term_id2',$payment_term_list,set_value('payment_term_id2'),' class="form-control  checkout_input select2" style="width:100%;" data-live-search="true" id="payment_term_id2"');?>
                              </div>
                            </div> 
                            <div hidden class="form-group">
                              <label for="payment_term_id2" class="col-sm-3 control-label">Payment Terms</label>
                              <div class="col-sm-9">
                                <?php echo form_dropdown('payment_term_id2',$payment_term_list,set_value('payment_term_id2'),' class="form-control  checkout_input select2" style="width:100%;" data-live-search="true" id="payment_term_id2"');?>
                              </div>
                            </div> 
                            <div hidden class="form-group">
                              <label for="payment_term_id2" class="col-sm-3 control-label">Location </label>
                              <div class="col-sm-9">
                                <?php echo form_dropdown('location_id',$location_list,set_value('location_id'),' class="form-control  checkout_input select2" style="width:100%;" data-live-search="true" id="location_id"');?>
                              </div>
                            </div> 
                            <table border="0" style="width: 104%;">
                                <tr>
                                    <td width="78%"> 
                                        <?php $this->load->view('sales_pos/pos_layout/left_top_functional_btns'); ?>
                                        <?php $this->load->view('sales_pos/pos_layout/left_item_control'); ?>
                                        
                                    </td>
                                    <td style="padding: 0;padding-left: 5px; font-family: arial; " width=" "> 
                                        <!-- Call  Num pads view-->
                                        <?php $this->load->view('sales_pos/pos_layout/invoice_functions'); ?>
                                        <?php $this->load->view('sales_pos/pos_layout/numpad'); ?>
                                    </td>
                                </tr>
                            </table>  
                            
                        </div>  
                    </div>
                
              </div>
    </section>      
 
                 
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('so_id', isset($so_data['id'])?$so_data['id']:""); ?>
                            <?php echo form_hidden('action',$action); ?>
                            <?php $this->load->view('sales_pos/pos_modals_pop'); ?> 
                            <?php echo form_close(); ?>               
                  
       
                            
    </div>   
<div hidden id="item_data_json_storage"><?php // echo json_encode($item_data); ?></div>
<script type="text/javascript">
//  $('tbody').sortable();
</script>
<script>
    
$(document).keypress(function(e) {
//    fl_alert('info',e.keyCode)
        if(e.keyCode == 13) {//13 for enter
            if ($(".add_item_inpt").is(":focus")) {
                    $('#add_item_btn').trigger('click');
//                fl_alert('info',)
              }
            $('#barcode_input').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
         
          return false;
//                $('#place_invoice').trigger('click');
            if (($("#checkout_modal").data('bs.modal') || {isShown: false}).isShown) {
                $('#confirm_checkout').trigger('click');    
            }else{
                $('#place_invoice').trigger('click');
            }
        }
    });
$(document).ready(function(){
    if($('input[name=prn_id]').val()!=''){
        var prn_id = $('input[name=prn_id]').val();
        $('input[name=prn_id]').val('');
        window.open("<?php echo base_url("Sales_invoices");?>/sales_invoice_print/"+prn_id,'ZV VINDOW',width=600,height=300)
    }
    
        get_load_temp_invoice_open(); // Load temp invoice Open status for current user
//  $('tbody').sortable();
    $("#sales_return").click(function(){ 
        window.open("<?php echo base_url("Sales_returns/add_POS");?>", "popupWindow", "width=1300, height=600, scrollbars=yes");
    });
    $("#payment_term_id2").change(function(){
        var pay_term = $('#payment_term_id2').val();
        if(pay_term==1){//cash payment
            $('.checkout_form').show()
        }else{
            $('.checkout_form').hide();
        }
    });
    $('#barcode_input').focus();
    $('.select2').on("select2:close", function () { $(this).focus(); });
    
//    get_results();
    $("#barcode_input").on("change",function(){    
       $('#item_code').val($(this).val()).trigger('keyup');  
//        $('#add_item_btn').trigger('click');
    }); 
    $("#item_code").keyup(function(){ 
	get_item_dets_2(this.id);
    });
	 
    $("#item_desc").on("change focus",function(){
        if(event.type == "focus"){
             $("#item_code").val($('#item_desc').val());
            get_item_dets_2(this.id);
        }
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
    
    
    $('#inv_total').on('DOMSubtreeModified',function(){ //on change span text
        get_customers_addons();
    });
    
	
	
    $("#item_code").val($('#item_desc').val());
    $('#item_code').trigger('keyup'); 
    
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

    $("#add_item_btn").click(function(){
//        fl_alert('info','added');
         $.ajax({
			url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), price_type_id:$('#price_type_id').val()},
			success: function(result){
                            
                            set_list_items(result);
                            set_temp_invoice();
                            
                            $('#barcode_input').focus(); 
                        }
		});
    });
    
        function get_item_dets_2(id1=''){ 
//                            var reslt = $('#item_data_json_storage').text();
//                            $("#search_result_1").html(reslt); return false;
//                            var all_res1 = JSON.parse(reslt); 
                             $.ajax({
                                    url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=get_single_item');?>",
                                    type: 'post',
                                    data : {function_name:'get_single_item', item_code:$('#item_code').val(), price_type_id:$('#price_type_id').val()},
                                    success: function(result){
                                        var res1 = JSON.parse(result);
                                    
//                                        var res1 = all_res1[$('#item_code').val()];

                                        $('#first_col_form').removeClass('col-md-offset-1');
                                        var div_str = '<div class="col-md-2">'+
                                                                '<div class="form-group pad">'+
                                                                    '<label for="item_quantity">Weight<span id="unit_abbr"></span> <span>&nbsp;&nbsp;&nbsp;C/S<input id="item_quantity_partial" name="item_quantity_partial" type="checkbox" value="1"></span></label>'+
                                                                    '<input  readonly name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quantity">'+
                                                                '</div>'+
                                                            '</div>';
                                        if(res1.item_uom_id_2!=0){
                                                div_str = div_str + '<div class="col-md-1">'+
                                                                        '<div class="form-group pad">'+
                                                                            '<label for="item_quantity_2"><span id="unit_abbr_2"></span></label>'+
                                                                            '<input readonly  name="item_quantity_2" class="form-control add_item_inpt" value="1" id="item_quantity_2" placeholder="Enter Quantity">'+
                                                                        '</div>'+
                                                                    '</div>';

                                        }else{
                                            $('#first_col_form').addClass('col-md-offset-1')
                                        }
                                        $('#uom_div').html(div_str);

                                        if(typeof(res1.id) != "undefined" && res1.id !== null) {   
            //                                console.log(res1)
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
                                            var units2 = (parseFloat(res1.stock.units_available_2)==0)?1:parseFloat(res1.stock.units_available_2);
                                            var calc_qty = parseFloat(res1.stock.units_available)/units2;
                                            $('#item_quantity').val(calc_qty);

            //                                $("#result_search").html(result);
            //                                $('#add_item_btn').trigger('click');
                                        }
                                        $('#item_quantity_partial').click(function(){
                                            if(this.checked)
                                                $('#item_quantity').attr('readonly',false)
                                            else
                                                $('#item_quantity').attr('readonly',true);
                                        });
                                    }
                            });
        }
	function get_item_dets(id1=''){ //id1 for input element id
            $.ajax({
			url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(), price_type_id:$('#price_type_id').val()},
			success: function(result){
                            
//                            $("#search_result_1").html(result);
                            var res1 = JSON.parse(result);
                            
                             $('#first_col_form').removeClass('col-md-offset-1');
                            var div_str = '<div class="col-md-2">'+
                                                    '<div class="form-group pad">'+
                                                        '<label for="item_quantity">Weight <span id="unit_abbr">[Each]<span> <input id="item_quantity_partial" name="item_quantity_partial" type="checkbox" value="1"></label>'+
                                                        '<input readonly name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quantity">'+
                                                    '</div>'+
                                                '</div>';
                            if(res1.item_uom_id_2!=0){
                                    div_str = div_str + '<div class="col-md-2">'+
                                                            '<div class="form-group pad">'+
                                                                '<label for="item_quantity_2"> <span id="unit_abbr_2">[Each]<span></label>'+
                                                                '<input readonly name="item_quantity_2" class="form-control add_item_inpt" value="1" id="item_quantity_2" placeholder="Enter Quantity">'+
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
                                $('#item_quantity').val(1);

                                $("#result_search").html(result);
//                                $('#add_item_btn').trigger('click');
                            }
                        }
		});
	}
        
        function set_list_items(result,temp_inv_data=''){
        
                        if(temp_inv_data==''){ 
//                            $("#search_result_1").html(result);
                                    var res2 = JSON.parse(result);
                                    var unit_cost1 = $('#item_unit_cost').val();
                                    var item_qty1 = $('#item_quantity').val();
                                    var item_qty2 = $('#item_quantity_2').val();
                                    var item_code1 = $('#item_code').val();
                                    var item_discount1 = $('#item_discount').val();
                                    var invs_total1 = $('#invoice_total').val();
                            }else{ 
                                    var unit_cost1 = temp_inv_data.item_unit_cost;
                                    var item_qty1 = temp_inv_data.item_quantity;
                                    var item_qty2 = temp_inv_data.item_quantity_2;
                                    var item_code1 = temp_inv_data.item_code;
                                    var item_desc1 = temp_inv_data.item_desc;
                                    var item_discount1 = temp_inv_data.item_line_discount;
                                    var invs_total1 = $('#invoice_total').val();
                                    var res2 = {item_code: item_code1,
                                                item_name:item_desc1,
                                                id:temp_inv_data.item_id,
                                                item_uom_id:temp_inv_data.item_quantity_uom_id,
                                                item_uom_id_2:temp_inv_data.item_quantity_uom_id_2,
                                                unit_abbreviation:temp_inv_data.unit_abbreviation,
                                                unit_abbreviation_2:temp_inv_data.unit_abbreviation_2,
                                                }; 
                                    res2.stock = temp_inv_data.stock;
                                }
                                
//                                fl_alert('info',isNaN(parseFloat(unit_cost1)));
                                if(parseFloat(unit_cost1)<=0 || isNaN(parseFloat(unit_cost1)) ){
                                    unit_cost1 =0;
                                    fl_alert('info','Item Price invalid! Please recheck before add.');
//                                    return false;
                                } 
                                if(parseFloat(item_discount1) > (parseFloat(unit_cost1) * parseFloat(item_qty1))){
                                    fl_alert('info','Discount amount can not be overtaken the item price!');
                                    return false;
                                }
                                
                                var cur_req_qty = parseFloat(item_qty1);
                                $('.qty_'+item_code1).each(function() { 
                                    cur_req_qty = cur_req_qty +  parseFloat(this.value)
                                });
                                     
                                if(parseFloat(item_qty1)<=0 || isNaN(parseFloat(item_qty1)) || parseFloat(res2.stock.units_available)<parseFloat(cur_req_qty)){
                                    fl_alert('info','Please check the Item line Quantity.');
                                    return false;
                                }
//                                $('#unit_abbr').text('['+(res2.stock.units_available - cur_req_qty)+']');
                                
                                if(res2.item_code==null){
                                    fl_alert('info','Item invalid! Please recheck before add.');
                                    return false;
                                }
                                var rowCount = $('#invoice_list_tbl tr').length;
                                var counter = rowCount+1;
                                var qtyXprice = parseFloat(unit_cost1) * parseFloat(item_qty1);
//                                var line_disc_amount = (parseFloat($('#item_discount').val())* 0.01 * qtyXprice); //discount percentage
                                var line_disc_amount = parseFloat(item_discount1);
                                var item_total = qtyXprice - line_disc_amount;
//                                var item_total = qtyXprice;
                                var partial_itm_stat = 0;
                                if($('#item_quantity_partial').is(':checked')){
                                    partial_itm_stat = 1;  
                                }
                                
                                var row_str = '<tr style="padding:10px" id="'+rowCount+'_'+item_code1+'">'+ 
                                                        '<td><input hidden name="inv_items['+rowCount+'_'+item_code1+'][item_code]" value="'+item_code1+'">'+item_code1+'</td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'_'+item_code1+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+rowCount+'_'+item_code1+'][item_id]" value="'+res2.id+'">'+res2.item_name+'</td>'+
                                                        '<td id="qty__'+rowCount+'_'+item_code1+'" class="input_qty_td" align="center">'+
                                                            '<input hidden name="inv_items['+rowCount+'_'+item_code1+'][item_quantity_partial]" value="'+partial_itm_stat+'">'+
                                                            '<input hidden class="input_qty_field qty_'+item_code1+'" name="inv_items['+rowCount+'_'+item_code1+'][item_quantity]" value="'+item_qty1+'"><input hidden name="inv_items['+rowCount+'_'+item_code1+'][item_quantity_2]" value="'+((item_qty2==null)?0:item_qty2)+'">'+
                                                            '<input hidden name="inv_items['+rowCount+'_'+item_code1+'][unit_abbreviation]" value="'+res2.unit_abbreviation+'"><input hidden name="inv_items['+rowCount+'_'+item_code1+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="inv_items['+rowCount+'_'+item_code1+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                '<span class="qty_text">'+item_qty1+'</span> '+res2.unit_abbreviation;
                                if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
                                    row_str = row_str + ' | ' + item_qty2+' '+res2.unit_abbreviation_2+'<input hidden name="inv_items['+rowCount+'_'+item_code1+'][unit_abbreviation_2]" value="'+res2.unit_abbreviation_2+'">';
                                }                                                                                                                                                                                                                                                                        
                                row_str = row_str + '</td> <td  id="price__'+rowCount+'_'+item_code1+'" class="input_price_td" align="right"><input  class="input_price_field" hidden name="inv_items['+rowCount+'_'+item_code1+'][item_unit_cost]" value="'+unit_cost1+'"><span class="price_text">'+parseFloat(unit_cost1).toFixed(2)+'</span></td>'+ 
                                                        '<td  id="dscnt__'+rowCount+'_'+item_code1+'" class="input_dscnt_td" align="right"><input  class="input_dscnt_field" class="item_line_discount" hidden name="inv_items['+rowCount+'_'+item_code1+'][item_line_discount]" value="'+item_discount1+'"><span class="dscnt_text">'+line_disc_amount.toFixed(2)+'</span></td>'+
                                                        '<td align="right"><input class="item_tots" hidden name="inv_items['+rowCount+'_'+item_code1+'][item_total]" value="'+item_total+'"><span class="item_total_txt">'+item_total.toFixed(2)+'</span></td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>';
                                var newRow = $(row_str);
                                jQuery('table#invoice_list_tbl ').append(newRow);
                                
                                var inv_total = parseFloat(invs_total1) + item_total;
                                $('#invoice_total').val(inv_total.toFixed(2));
                                $('#total_amount').val(inv_total.toFixed(2));
                                $('#inv_total').text(inv_total.toFixed(2)); 
                                recalculate_totals(inv_total.toFixed(2)); 

                               
                                $('.input_qty_td').click(function(){  
                                    var tr_id = $(this).closest('tr').attr('id');   
                                    $('[name="inv_items['+tr_id+'][item_quantity]"]').addClass("form-control");
                                    $('[name="inv_items['+tr_id+'][item_quantity]"]').focus().select(); 
                                });
                                $('.input_qty_field').focusout(function(){   
                                    var tr_id = $(this).closest('tr').attr('id');  
                                    $('#'+tr_id+' .input_qty_td .qty_text').text($(this).val());
                                    $(this).removeClass('form-control');
                                    recalculate_line(tr_id)
                                });
//                                
                                $('.input_price_td').click(function(){  
                                    var tr_id = $(this).closest('tr').attr('id'); 
                                    $('[name="inv_items['+tr_id+'][item_unit_cost]"]').addClass("form-control");
                                    $('[name="inv_items['+tr_id+'][item_unit_cost]"]').show().focus().select();  
                                });
                                $('.input_price_field').focusout(function(){    
                                    var tr_id = $(this).closest('tr').attr('id'); 
                                    $('#'+tr_id+' .input_price_td .price_text').text(parseFloat($(this).val()).toFixed(2));
                                    $(this).removeClass('form-control');
                                    recalculate_line(tr_id)
                                });
//                                
                                $('.input_dscnt_td').click(function(){  
                                    var tr_id = $(this).closest('tr').attr('id'); 
                                    $('[name="inv_items['+tr_id+'][item_line_discount]"]').addClass("form-control");
                                    $('[name="inv_items['+tr_id+'][item_line_discount]"]').show().focus().select();  
                                });
                                $('.input_dscnt_field').focusout(function(){ 
                                    var tr_id = $(this).closest('tr').attr('id');  
                                     
                                    $('#'+tr_id+' .input_dscnt_td .dscnt_text').text(parseFloat($(this).val()).toFixed(2));
                                    $(this).removeClass('form-control');
                                    recalculate_line(tr_id)
                                });
                                
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
                                    recalculate_totals(tot_amt.toFixed(2));  
                                    set_temp_invoice();
                                });    
                                
        }
        
        function recalculate_line(line_id){
            var qty = parseFloat($('#'+line_id+' .input_qty_field').val());
            var price = parseFloat($('#'+line_id+' .input_price_field').val());
            var dcnt = parseFloat($('#'+line_id+' .input_dscnt_field').val());
            var line_tot  = parseFloat($('#'+line_id+' .item_tots').val());
             
            if((price*qty)<dcnt || dcnt<0){
                fl_alert('info','Dicount amount can not be overtaken the item price!');
                $('#'+line_id+' .input_dscnt_field').val((0))
                $('#'+line_id+' .dscnt_text').text((0).toFixed(2))
                dcnt =0; 
            }
            var tot = (price*qty)-dcnt;
            
            $('#'+line_id+' .item_tots').val(tot);
            $('#'+line_id+' .item_total_txt').text(tot.toFixed(2));
            
            var inv_tot = parseFloat($('#invoice_total').val()); 
            $('#invoice_total').val((inv_tot-line_tot)+tot);
            $('#inv_total').text(parseFloat((inv_tot-line_tot)+tot).toFixed(2));
            recalculate_totals(parseFloat((inv_tot-line_tot)+tot).toFixed(2)); 
            set_temp_invoice();
        }
        
        
        function set_temp_invoice(){
            var post_data = jQuery('#form_search').serializeArray(); 
            post_data.push({name:"function_name",value:'set_temp_invoice'}); 
                
            $.ajax({
                url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=set_temp_invoice');?>",
                type: 'post',
                data : post_data,
                success: function(result){
                        $("#search_result_1").html(result); 
                }
            });
        }
        
        function get_load_temp_invoice_open(){
            $.ajax({
                url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=get_temp_invoice_data');?>",
                type: 'post',
                data : {function_name:"get_temp_invoice_data",customer_id:$('#customer_id').val()},
                success: function(result){ 
                            var obj1 = JSON.parse(result);
//                            var trans1 = JSON.parse(obj1);
//                                console.log(obj1.cust_addons);
                            $.each(obj1.items,function(index,item){
                                    set_list_items('',item); 
                            });
                            if(typeof(obj1.open_temp_data.customer_id)!='undefined'){
                                $('#customer_id').val(obj1.open_temp_data.customer_id); 
                                $('#cust_refname').text($( "#customer_id option:selected" ).text()); 
                                
                                get_customers_addons();
//                                fl_alert('info',obj1.open_temp_data.customer_id)
                            }
                            var obj2 = JSON.parse(obj1.open_temp_data.payments);
                            $.each(obj2.cash,function(pay_mtd,pay_amount){  
                                var rowCount = $('table #fin_total_tbl_body tr').length;
                                var new_cash_trns_row_str = '<tr>'+
                                                                    '<td align="left"><span class="cash_pay_remove fa fa-trash fa-x"> Cash Payment</span></td>'+
                                                                    '<td align="right"><input class="cash_pay_inputs" name="trans[cash]['+rowCount+']" value="'+pay_amount+'" hidden><span>'+parseFloat(pay_amount).toFixed(2)+'</span></td>'+
                                                               '</tr>';

                                var new_cash_trns_row = $(new_cash_trns_row_str);
                                $('table #fin_total_tbl_body').append(new_cash_trns_row);
                                
                                $('.cash_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
                                recalculate_totals();
                            });
                            $.each(obj2.card,function(pay_mtd,pay_amount){  
                                var rowCount = $('table #fin_total_tbl_body tr').length;
                                var new_card_trns_row_str = '<tr>'+
                                                                    '<td align="left"><span class="card_pay_remove fa fa-trash fa-x"> Card Payment</span></td>'+
                                                                    '<td align="right"><input class="card_pay_inputs" name="trans[card]['+rowCount+']" value="'+pay_amount+'" hidden><span>'+parseFloat(pay_amount).toFixed(2)+'</span></td>'+
                                                               '</tr>';

                                var new_card_trns_row = $(new_card_trns_row_str);
                                $('table #fin_total_tbl_body').append(new_card_trns_row);
                                
                                $('.card_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
                                recalculate_totals();
                            });
                            $.each(obj2.return_refund,function(pay_mtd,pay_amount){  
                                var rowCount = $('table #fin_total_tbl_body tr').length;
                                var new_return_refund_trns_row_str = '<tr>'+
                                                                    '<td align="left"><span class="return_refund_pay_remove fa fa-trash fa-x"> Return Refund</span></td>'+
                                                                    '<td align="right"><input class="return_refundpay_inputs" name="trans[return_refund]['+rowCount+']" value="'+pay_amount+'" hidden><span>'+parseFloat(pay_amount).toFixed(2)+'</span></td>'+
                                                               '</tr>';

                                var new_return_refund_trns_row = $(new_return_refund_trns_row_str);
                                $('table #fin_total_tbl_body').append(new_return_refund_trns_row);
                                
                                $('.return_refund_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
                                recalculate_totals();
                            });
                            
                            $.each(obj2.voucher,function(pay_mtd,pay_amount){
                                var rowCount = $('table #fin_total_tbl_body tr').length;
                                var new_voucher_trns_row_str = '<tr>'+
                                                                    '<td align="left"><span class="voucher_pay_remove fa fa-trash fa-x"> Voucher Payment</span></td>'+
                                                                    '<td align="right"><input class="voucher_pay_inputs" name="trans[voucher]['+rowCount+']" value="'+pay_amount+'" hidden><span>'+parseFloat(pay_amount).toFixed(2)+'</span></td>'+
                                                               '</tr>';

                                var new_voucher_trns_row = $(new_voucher_trns_row_str);
                                $('table #fin_total_tbl_body').append(new_voucher_trns_row);
                                
                                $('.voucher_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
                                recalculate_totals();
                            });
                }
            });
        }
         
            
            function recalculate_totals(subtotal=''){
                var total_fin = 0;
                $('input[class^="item_tots"]').each(function() {
//                                        console.log(this);
                    total_fin += parseFloat($(this).val());
                });
//                var total_fin =  $('#invoice_total').val();
                $('#invoice_total').val(total_fin);
                //calculate_tostal line disc
                var disc_tot = 0;
                $('.input_dscnt_field').each(function() { 
                    disc_tot = disc_tot + parseFloat($(this).val()); 
                });
                if(parseFloat(disc_tot)>0){
                  $('#fin_total_line_discount_row').show();  
                }else{
                    $('#fin_total_line_discount_row').hide()
                }
                $('#fin_total_line_discount_val').val(disc_tot);
                $('#fin_total_line_discount_text').text('-'+disc_tot.toFixed(2));
                
                var gross_total = parseFloat(disc_tot)+parseFloat(total_fin);
                $('#fin_subtotal').text(gross_total.toFixed(2)); 
                
                //cash pay amount
                var cash_tot = 0;
                $('.cash_pay_inputs').each(function() { 
                    cash_tot = cash_tot + parseFloat($(this).val()); 
                });
                total_fin -= cash_tot;
                
                //caRD pay amount
                var card_tot = 0;
                $('.card_pay_inputs').each(function() { 
                    card_tot = card_tot + parseFloat($(this).val()); 
                });
                total_fin -= card_tot;
                
                //return_refund pay amount
                var return_refund_tot = 0;
                $('.return_refund_inputs').each(function() { 
                    return_refund_tot = return_refund_tot + parseFloat($(this).val()); 
                });
                total_fin -= return_refund_tot;
                
                //caRD pay amount
                var voucher_tot = 0;
                $('.voucher_pay_inputs').each(function() { 
                    voucher_tot = voucher_tot + parseFloat($(this).val()); 
                });
                total_fin -= voucher_tot;
                
                //OLD GOLD pay amount
                var og_tot = 0;
                $('.og_pay_inputs').each(function() { 
                    og_tot = og_tot + parseFloat($(this).val()); 
                });
                total_fin -= og_tot;
                
                //addons
                var addon_tot = 0;
                $('.addon_inputs').each(function() {  
                    addon_tot = addon_tot + parseFloat($(this).val()); 
                });
                total_fin += addon_tot;
                
                $('#fin_total').text(total_fin.toFixed(2)); 
                $('#total_amount').val(total_fin.toFixed(2));
            } 
            
            function get_customers_addons(){ 
                $('#search_customer_id').val($('#customer_id').val());
                $('#top_customer_search').attr('title',$("#search_customer_id option:selected").text());
                 $.ajax({
                        url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=get_customer_addons');?>",
                        type: 'post',
                        data : {function_name:"get_customer_addons",customer_id:$('#customer_id').val()},
                        success: function(result){ 
//                            fl_alert('info',$('#customer_id').val())
                                var obj1 = JSON.parse(result);
                                
                                $('.addon_rows').remove();
                                $.each(obj1,function(index,addon){ 
//                                    fl_alert('info',addon['calculation_type'])
                                    var inv_line_tot = parseFloat($('#invoice_total').val());
//                                    fl_alert('info',addon['calculation_type']); 
                                    var addon_amount = 0;
                                    if(addon['calculation_type']==1){//fxd amnt:1 percentage :2
                                        addon_amount = parseFloat(addon['addon_value']);
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
                                    var new_trns_row_str = '<tr class="addon_rows">'+
                                                                '<td align="left">'+addon['addon_name']+' '+perc_txt+'</span></td>'+
                                                                '<td align="right"><input class="addon_inputs" name="addons['+addon['id']+']" value="'+addon_amount+'" hidden><span>'+(addon_amount).toFixed(2)+'</span></td>'+
                                                           '</tr>';
                                    var new_trns_row = $(new_trns_row_str);
                                    $('table #fin_total_tbl_body').append(new_trns_row);  
//                                    fl_alert('info',addon_amount)
//                                    return false;
                                });
                                    recalculate_totals() 
                            }
                    });
            }
</script>
 
                                        <?php // $this->load->view('sales_pos/pos_layout/float_keyboard'); ?>