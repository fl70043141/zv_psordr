<?php
	
//            echo '<pre>';            print_r($_GET); die;
	$result = array(
                        'id'=>"",
                        'customer_id'=> (isset($cust_id) && $cust_id!='')?$cust_id:'',   
                        'reference'=> 'OG-'.date('Ymd-Hi'),
                        'og_date'=>date('m/d/Y'),
                        'item_discount'=>0,
                        'payment_term_id'=>0,
                        'currency_code'=>$this->session->userdata(SYSTEM_CODE)['default_currency'],
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
              
            <?php echo form_open($this->router->fetch_class()."/validate", 'id="form_search" class="form-horizontal"')?>  
                    <?php echo form_hidden('og_for',(isset($_GET['type']))?$_GET['type']:''); //OG for sales order or Invoice ?>
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customer <span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_dropdown('customer_id',$supplier_list,set_value('customer_id',$result['customer_id']),' class="form-control select2" data-live-search="true" id="customer_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div>  
                                    <div hidden class="col-md-1 pull-left">
                                        <a id="add_supp_btn" class="btn btn-sm btn-primary"><span class="fa fa-plus-circle"></span></a>
                                    </div>
                                </div>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Reference <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('reference',set_value('reference',$result['reference']),' class="form-control" id="reference"');?>
                                         <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('og_date',set_value('og_date',$result['og_date']),' class="form-control datepicker" readonly id="og_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('og_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id'),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Received_to<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('location_id',$location_list,set_value('location_id'),' class="form-control select2" data-live-search="true" id="location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div> 
                        </div>
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Add OG/BG Item</h4> 
                                    <div class="row col-md-12 ">
                                        <div id="first_col_form" class="col-md-3">
                                            <div class="form-group pad">
                                                <label for="item_category_id">Category</label>
                                                <?php echo form_dropdown('item_category_id',$item_category_list,set_value('item_category_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="item_category_id"');?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 ">
                                            <div class="form-group pad">
                                                <label for="item_desc">Item Desc</label>
                                                <?php  echo form_input('item_desc',set_value('item_desc'),' class="form-control add_item_inpt" data-live-search="true" id="item_desc"');?>
                                            </div>
                                        </div>
                                        <div id="uom_div">
                                            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group pad">
                                                <label for="item_unit_cost">Unit Cost<span id="per_amount_text"></span></label>
                                                <input type="text" name="item_unit_cost" class="form-control add_item_inpt" id="item_unit_cost" placeholder="Unit Cost for item">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="add_item_btn" class="btn-default btn add_item_inpt pad">Add</span>
                                            </div>
                                        </div>
                                    </div>
<!--                                    <table id="example1" class="table bg-gray-light table-bordered table-striped">
                                        <thead>
                                           <tr>
                                               <td><label for="item_code">Item Code</label></td>
                                               <td><label for="item_code">Item Description</label></td>
                                               <td><label for="item_code">Quantity</label></td>
                                               <td><label for="item_code">Unit Cost</label></td>
                                               <td><label for="item_code">Discount  </label></td>
                                               <td> </td>
                                           </tr>
                                           <tr>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_code">Item Code</label>
                                                        <?php //  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" data-live-search="true" id="item_code"');?>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_desc">Item Description</label>
                                                        <?php //  echo form_dropdown('item_desc',$item_list,set_value('item_desc'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="item_desc"');?>
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
                                    </table>-->
                                </div>
                                
                                <div class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped">
                                        <thead>
                                           <tr> 
                                               <th width="10%"  style="text-align: center;">Category</th> 
                                               <th width="20%" style="text-align: center;">Description</th> 
                                               <th width="10%" style="text-align: center;">Quantity</th> 
                                               <th width="15%" style="text-align: right;">Unit Cost</th>  
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
                                                <th colspan="3"></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                            </tr> 
                                       </tfoot>
                                        </table>
                                </div>
                                <div id="search_result_1"></div>
                            </div>    
                        </div>
                        <div class="row" id="footer_sales_form">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memo" class="col-sm-4 control-label">Memo</label>

                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="memo"></textarea>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-sm-8">
                                <button id="place_invoice" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i>Submit</button>
                
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
    
<?php $this->load->view('purchasing_items/purch_items_modals/add_supplier_model'); ?>
<?php $this->load->view('purchasing_items/purch_items_modals/add_dropdown_modal'); ?>
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
    $('#item_category_id').focus(); 
    $('.select2').on("select2:close", function () { $(this).focus(); });
     
    get_item_dets($('#item_category_id').val());
    $("#item_category_id").on("change",function(){ 
            get_item_dets(this.id);
    });
    
    $("#place_invoice").click(function(){
            if($('input[name^="inv_items"]').length<=0){
                fl_alert('info',"Atleast one item need to create an invoice!")
                return false;
            }
            if(!confirm("Click ok confirm your invoice submission.")){
                return false;
            }
    });
     $("#customer_id").change(function(){ 
	 $('#item_code').trigger('keyup');
    });
    
    $("#add_item_btn").click(function(){
         if($('#item_desc').val()==null || $('#item_desc').val()==""){
            fl_alert('info','Item Name Required! Please enter Item Name.');
            $('#item_desc').focus();
            return false;
        }
//        fl_alert('info',parseFloat($('#item_quantity').val()))
        if(isNaN($('#item_quantity').val()) || parseFloat($('#item_quantity').val())<=0){
            fl_alert('info','Weight Invalid! Please enter Valid Weight.');
            $('#item_quantity').focus();
            return false;
        }
        if(isNaN($('#item_quantity_2').val()) || parseFloat($('#item_quantity_2').val())<=0){
            fl_alert('info','Quantity Invalid! Please enter Valid Quantity.');
            $('#item_quantity_2').focus();
            return false;
        }
         $.ajax({
			url: "<?php echo site_url('Purchasing_items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_single_category', item_category_id:$('#item_category_id').val()},
			success: function(result){
                                var res2 = JSON.parse(result);
//                                $("#search_result_1").html(result);
                                
                                if(res2.id==null){
                                    fl_alert('info','Item category invalid! Please recheck before add.');
                                    return false;
                                }
                                res2.item_name = $('#item_desc').val();
                                var rowCount = $('#invoice_list_tbl tr').length;
                                var counter = rowCount+1;
                                var qtyXprice = parseFloat($('#item_unit_cost').val()) * parseFloat($('#item_quantity').val());
//                                var item_total = qtyXprice - (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
                                var item_total = qtyXprice;
                                
                                
                                var row_str = '<tr style="padding:10px" id="tr_'+rowCount+'">'+ 
                                                        '<td align="center"><input hidden name="inv_items['+rowCount+'][cat_id]" value="'+res2.id+'">'+res2.category_name+'</td>'+
                                                        '<td align="center"><input hidden name="inv_items['+rowCount+'][item_desc]" value="'+res2.item_name+'">'+res2.item_name+'</td>'+
                                                        '<td align="center"><input hidden name="inv_items['+rowCount+'][item_quantity]" value="'+$('#item_quantity').val()+'"><input hidden name="inv_items['+rowCount+'][item_quantity_2]" value="'+(($('#item_quantity_2').val()==null)?0:$('#item_quantity_2').val())+'">'+
                                                        '<input hidden name="inv_items['+rowCount+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="inv_items['+rowCount+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                $('#item_quantity').val()+' '+res2.unit_abbreviation;
                                if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
                                    row_str = row_str + ' | ' + $('#item_quantity_2').val()+' '+res2.unit_abbreviation_2;
                                }                                                                                                                                                                                                                                                                        
                                row_str = row_str + '</td> <td align="right"><input hidden name="inv_items['+rowCount+'][item_unit_cost]" value="'+$('#item_unit_cost').val()+'">'+parseFloat($('#item_unit_cost').val()).toFixed(2)+'</td>'+ 
                                                        '<td align="right"><input class="item_tots" hidden name="inv_items['+rowCount+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>';
                                var newRow = $(row_str);
                                jQuery('table#invoice_list_tbl ').append(newRow);
                                var inv_total = parseFloat($('#invoice_total').val()) + item_total;
                                $('#invoice_total').val(inv_total.toFixed(2));
                                $('#inv_total').text(inv_total.toFixed(2));
                                $('#item_desc').focus();
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
    
});

	function get_item_dets(id1=''){ //id1 for input element id [cat_id]
            $.ajax({
			url: "<?php echo site_url('Purchasing_items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_single_category', item_category_id:$('#item_category_id').val()},
			success: function(result){
                            
//                            $("#search_result_1").html(result);
//                            return false;
                            var res1 = JSON.parse(result);
                            
                             $('#first_col_form').removeClass('col-md-offset-1');
                            var div_str = '<div class="col-md-2">'+
                                                    '<div class="form-group pad">'+
                                                        '<label for="item_quantity">Quantity <span id="unit_abbr">[Each]<span></label>'+
                                                        '<input type="text" name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quantity">'+
                                                    '</div>'+
                                                '</div>';
                            if(res1.item_uom_id_2!=0){
                                    div_str = div_str + '<div class="col-md-2">'+
                                                            '<div class="form-group pad">'+
                                                                '<label for="item_quantity_2">Quantity <span id="unit_abbr_2">[Each]<span></label>'+
                                                                '<input type="text" name="item_quantity_2" class="form-control add_item_inpt" value="1" id="item_quantity_2" placeholder="Enter Quantity">'+
                                                            '</div>'+
                                                        '</div>';
                                    
                            }else{
                                $('#first_col_form').addClass('col-md-offset-1')
                            }
                            $('#uom_div').html(div_str);
                            
                            if(typeof(res1.id) != "undefined" && res1.id !== null) { 
//                                if(id1!='item_desc'){$('#item_desc').val(res1.item_code).trigger('change');}
//                                if(id1!='item_code'){ $('#item_code').val(res1.item_code);}
                                (res1.price_amount==null)? $('#item_unit_cost').val(0):$('#item_unit_cost').val(res1.price_amount);
                                $('#unit_abbr').text('['+res1.unit_abbreviation+']');
                                $('#unit_abbr_2').text('['+res1.unit_abbreviation_2+']');
                                $('#per_amount_text').text(' / '+res1.unit_abbreviation);
//                                $('#item_discount').val(0);
                                $('#item_quantity').val(1);

                                $("#result_search").html(result);
                            }
                        }
		});
	}
</script>
 