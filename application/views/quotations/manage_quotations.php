<?php
	
	$result = array(
                        'id'=>"",
                        'customer_id'=>"",
                        'insurance_company'=>"",
                        'vehicle_number'=>"",
                        'chasis_no'=>"",
                        'vehicle_model'=>"",
                        'reference'=> 'E-'.date('Ymd-Hi'),
                        'quoted_date'=>date('m/d/Y'),
                        'item_discount'=>0,
                        'item_quantity'=>1,
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


<?php // echo '<pre>'; print_r($facility_list); die;?>

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
              
            <?php echo form_open("Quotations/validate", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Type <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('quotation_type',$quotation_list,set_value('quotation_type'),' class="form-control select2" data-live-search="true" id="quotation_type"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customer <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('customer_id',$customer_list,set_value('customer_id'),' class="form-control select2" data-live-search="true" id="customer_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div>
                            <div  class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('quoted_date',set_value('quoted_date',$result['quoted_date']),' class="form-control datepicker" readonly id="quoted_date"');?>
                                         <span class="help-block"><?php echo form_error('quoted_date');?>&nbsp;</span>
                                    </div> 
                                </div>
                            </div>
                            <div  class="col-md-5">
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id'),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Sale Type <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('sales_type_id',$sales_type_list,set_value('sales_type_id'),' class="form-control select2" data-live-search="true" id="sales_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div>
                             
                        </div>
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12">
                                    
                                    <h4 class="">Add Item for Estimation</h4> 
                                    <table id="example1" class="table bg-gray-light table-bordered table-striped">
                                        <thead>
                                           <tr>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_code">Item Code</label>
                                                        <?php  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" data-live-search="true" id="item_code"');?>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_desc">Item Description</label>
                                                        <?php  echo form_dropdown('item_desc',$item_list,set_value('item_desc'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="item_desc"');?>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_quantity">Quantity <span id="unit_abbr">[Each]<span></label>
                                                        <input type="text" name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quamtity">
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_unit_cost">Unit Cost</label>
                                                        <input type="text" name="item_unit_cost" class="form-control add_item_inpt" id="item_unit_cost" placeholder="Unit Cost for item">
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_code">Discount</label>
                                                        <input type="text" name="item_discount" class="form-control add_item_inpt" id="item_discount" placeholder="Enter discount percent">
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group"><br>
                                                        <span id="add_item_btn" class="btn-default btn add_item_inpt">Add</span>
                                                    </div>
                                                    </div>
                                               </td>
                                           </tr>
                                       </thead>
                                    </table>
                                </div>
                                
                                <div class="box-body fl_scrollable"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped">
                                        <thead>
                                           <tr>
                                               <th width="5%">#</th>
                                               <th width="10%"  style="text-align: center;">Item Code</th> 
                                               <th width="20%" style="text-align: center;">Item Description</th> 
                                               <th width="10%" style="text-align: center;">Quantity</th> 
                                               <th width="15%" style="text-align: right;">Unit Cost</th> 
                                               <th width="15%" style="text-align: right;">Discount</th> 
                                               <th width="15%" style="text-align: right;">Total</th> 
                                               <th width="5%" style="text-align: center;">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           
                                       </tbody>
                                       <tfoot>
                                            <tr>
<!--                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Sub Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                                <th  style="text-align: right;"></th>
                                            </tr>-->
                                            
                                            <tr>
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                            </tr>
                                            <tr hidden="">
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Customer Payment</th>
                                                <th  style="text-align: right;"><input type="text" name="deposit_amount" value="0" class=" form-control"></th>
                                            </tr>
                                       </tfoot>
                                        </table>
                                </div>
                                <div id="search_result_1"></div>
                            </div>    
                        </div>
                        <div class="row" id="footer_sales_form">
                            <div class="col-md-4">
<!--                                <div class="form-group">
                                    <label for="memo" class="col-sm-4 control-label">Memo</label>

                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="memo"></textarea>
                                    </div>
                                  </div>-->
                            </div>
                            <div class="col-sm-8">
                                <button id="place_invoice" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i>Add New</button>
                
                            </div>
                        </div>
                    </div>
                
              </div>
    </section>      
                            
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('action',$action); ?>
                            <?php echo form_close(); ?>               
                                
                         
                            
    </div>
        <div class="col-md-12">
            <div class="box">
               <!-- /.box-header -->
               <!-- /.box-body -->
             </div>

        </div>
</div>
    
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
            if($('input[name^="inv_items"]').length<=0){
                fl_alert('info',"Atleast one item need to create an invoice!")
                return false;
            }
    });
    
    $("#add_item_btn").click(function(){
//        fl_alert('info','added');
         $.ajax({
			url: "<?php echo site_url('Invoices/get_single_item');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
//                                $("#search_result_1").html(result);
                                var res2 = JSON.parse(result);
                                var rowCount = $('#invoice_list_tbl tr').length;
                                var counter = rowCount+1;
                                var qtyXprice = parseFloat($('#item_unit_cost').val()) * parseFloat($('#item_quantity').val());
                                var item_total = qtyXprice - (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
                                var newRow = $('<tr style="padding:10px" id="tr_'+rowCount+'">'+
                                                        '<td>'+(rowCount-3)+'</td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'][item_code]" value="'+$('#item_code').val()+'">'+$('#item_code').val()+'</td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+rowCount+'][item_id]" value="'+res2.id+'">'+res2.item_name+'</td>'+
                                                        '<td align="right"><input hidden name="inv_items['+rowCount+'][item_quantity]" value="'+$('#item_quantity').val()+'">'+$('#item_quantity').val()+'</td>'+
                                                        '<td align="right"><input hidden name="inv_items['+rowCount+'][item_unit_cost]" value="'+$('#item_unit_cost').val()+'">'+parseFloat($('#item_unit_cost').val()).toFixed(2)+'</td>'+
                                                        '<td align="right"><input hidden name="inv_items['+rowCount+'][item_discount]" value="'+$('#item_discount').val()+'">'+parseFloat($('#item_discount').val()).toFixed(2)+'%</td>'+
                                                        '<td align="right"><input class="item_tots" hidden name="inv_items['+rowCount+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>');
                                jQuery('table#invoice_list_tbl ').append(newRow);
                                var inv_total = parseFloat($('#invoice_total').val()) + item_total;
                                $('#invoice_total').val(inv_total.toFixed(2));
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
                                    $('#invoice_total').val(tot_amt.toFixed(2));
                                    $('#inv_total').text(tot_amt.toFixed(2)); 
                                });
                        }
		});

        
        
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
});

	function get_item_dets(id1=''){ //id1 for input element id
//        fl_alert('info',id1)
            $.ajax({
			url: "<?php echo site_url('Invoices/get_single_item');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
//                                $("#search_result_1").html(result);
                            var res1 = JSON.parse(result);
                            if(typeof(res1.id) != "undefined" && res1.id !== null) {


                                if(id1!='item_desc'){
                                    var tmp_html = '<option value="'+res1.item_code+'">'+res1.item_name+'-'+res1.item_code+'</option>';

                                    $('#item_desc').html('');
                                    $('#item_desc').append(tmp_html);
                                    $('#item_desc').val(res1.item_code).trigger('change.select2');
                                }
                                if(id1!='item_code'){ $('#item_code').val(res1.item_code);}
                                $('#item_unit_cost').val(res1.price_amount);
                                $('#unit_abbr').text('['+res1.unit_abbreviation+']');
                                $('#item_discount').val(0);
                                $('#item_quantity').val(1);

                                $("#result_search").html(result);
                            }
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
 