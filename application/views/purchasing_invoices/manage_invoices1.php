<?php
	
	$result = array(
                        'id'=>$invc_info['id'],
                        'customer_id'=>$invc_info['person_id'],
                        'vehicle_number'=>$invc_info['vehicle_number'],
                        'chasis_no'=>$invc_info['chasis_no'],
                        'vehicle_model'=>$invc_info['vehicle_model'],
                        'insurance_company'=>$invc_info['insurance_company'],
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'invoice_date'=>date('m/d/Y'),
                        'item_discount'=>0,
                        'item_quantity'=>1,
                        );   		
	
	 
	switch($action):
	case 'Add Invoice':
		$heading	= 'Add';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
	break;
    
	case 'Edit Invoice':
                $quoted_items = $inv_data['invoice_desc_list'];
		$heading	= 'Add';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Add':
		$heading	= 'Add';
		$dis		= 'readonly';
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

    
    
        <div class="">
            <!--<a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>-->
            <a href="<?php echo base_url($this->router->fetch_class().'/view/'.$result['id']);?>" class="btn btn-app "><i class="fa fa-backward"></i>Search</a>

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
              
            <?php echo form_open("Invoices/validate", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customer <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('customer_id',$customer_list,set_value('customer_id'),' class="form-control select2" data-live-search="true" id="customer_id" '.$dis.' ');?>
                                         <?php  echo form_hidden('invoiced_for', (isset($invoiced_for))?$invoiced_for:'');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Reference <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('reference',set_value('reference',$result['reference']),' class="form-control" id="reference" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Ins-comp <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('insurance_company',set_value('insurance_company',$result['insurance_company']),' class="form-control" id="insurance_company" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Vehicle #<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('vehicle_number',set_value('vehicle_number',$result['vehicle_number']),' class="form-control" id="vehicle_number" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('insurance_company');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Make/Model<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('vehicle_model',set_value('vehicle_model',$result['vehicle_model']),' class="form-control" id="vehicle_model" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('insurance_company');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Chasis No<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('chasis_no',set_value('chasis_no',$result['chasis_no']),' class="form-control" id="chasis_no" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('insurance_company');?>&nbsp;</span>-->
                                    </div> 
                                </div>  
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id'),' class="form-control select2" data-live-search="true" id="payment_term_id" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Sale Type <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('sales_type_id',$sales_type_list,set_value('sales_type_id'),' class="form-control select2" data-live-search="true" id="sales_type_id" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('invoice_date',set_value('invoice_date',$result['invoice_date']),' class="form-control datepicker" readonly id="invoice_date" '.$dis.' ');?>
                                         <!--<span class="help-block"><?php // echo form_error('invoice_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12">
                                    
                                    <h4 class="">Add Item sale</h4> 
                                    <table id="example1" class="table bg-gray-light table-bordered table-striped">
                                        <thead>
                                           <tr>
                                               <td hidden="">
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
                                                        <a  id="add_new_item"  data-toggle="modal" data-target="#modal_add_item"  style="cursor: pointer;"><span class="fa fa-plus"></span>Other Item</a>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_quantity">Quantity <span id="unit_abbr">[Each]<span></label>
                                                        <input type="number" name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quamtity">
                                                        <a  class="label-default text-green pull-right"><text id="added_info_item"></text></a>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_unit_cost">Unit Cost</label>
                                                        <input type="number" name="item_unit_cost" class="form-control add_item_inpt" id="item_unit_cost" placeholder="Unit Cost for item">
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_code">Discount</label>
                                                        <input type="number" name="item_discount" class="form-control add_item_inpt" id="item_discount" placeholder="Enter discount percent">
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
                                           <?php
                                                $row_count = 3;$i=1;
                                                $quoted_total= 0;
                                                if(isset($quoted_items)){
                                                    foreach ($quoted_items as $quoted_item){
//                                                        echo '<pre>';                                                    print_r($quoted_item); die;
                                                        echo '
                                                            <tr style="padding:10px" id="tr_'.$row_count.'">
                                                                <td>'.$i.'<input hidden="" name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][invoiced_for]" value="'.((isset($quoted_item['invoiced_for']))?$quoted_item['invoiced_for']:20).'"></td>
                                                                <td><input hidden="" name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][item_code]" value="'.$quoted_item['item_code'].'">'.$quoted_item['item_code'].'</td>
                                                                <td><input hidden="" name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][item_desc]" value="'.$quoted_item['item_description'].'"><input hidden="" name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][item_id]" value="'.$quoted_item['item_id'].'">'.$quoted_item['item_description'].' - '.$quoted_item['cat_name'].'</td>
                                                                <td align="right"><input type="number" class="form-control" name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][item_quantity]" value="'.$quoted_item['quantity'].'"></td>
                                                                <td align="right"><input type="number" class="form-control" name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][item_unit_cost]" value="'.$quoted_item['unit_price'].'"></td>
                                                                <td align="right"><input type="number" class="form-control" name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][item_discount]" value="'.$quoted_item['discount_persent'].'"></td>
                                                                <td align="right"><input class="item_tots" hidden name="inv_items['.$row_count.'_'.$quoted_item['item_code'].'][item_total]" value="'.$quoted_item['sub_total'].'">'. number_format($quoted_item['sub_total'],2).'</td>
                                                                <td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                                            </tr>
                                                            ';
                                                        $quoted_total += $quoted_item['sub_total'];
                                                        $row_count++; $i++;
                                                    }
                                                }
                                           ?> 
                                       </tbody>
                                       <tfoot>
<!--                                            <tr>
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Sub Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                                <th  style="text-align: right;"></th>
                                            </tr>-->
                                            
                                            <tr>
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="<?php echo $quoted_total; ?>" name="invoice_total" id="invoice_total"><span id="inv_total"><?php echo number_format($quoted_total,2); ?></span></th>
                                            </tr>
<!--                                            <tr>
                                                <th colspan="5"></th>
                                                <th  style="text-align: right;">Customer Payment</th>
                                                <th  style="text-align: right;"><input type="text" name="deposit_amount" value="0" class=" form-control"></th>
                                            </tr>-->
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
                                <button id="place_invoice" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i><?php echo ($action=='Edit Invoice')?'Update':'Place';?> Invoice</button>
                
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
    <!-- /.MODEL FOR DATE -->
<div class="modal fade" id="modal_add_item" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create New Item</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">Item Name<span style="color: red">*</span></label>
                  <div class="col-md-9">    
                      <?php echo form_input('item_name_inv', set_value('item_name_inv'), 'id="item_name_inv" class="form-control modal_input_1" placeholder="Enter item name" '); ?>
                      <span class="help-block"><?php echo form_error('item_name_inv');?>&nbsp;</span>
                  </div> 
              </div> 

              <div class="form-group">
                  <label class="col-md-3 control-label">Category<span style="color: red">*</span></label>
                  <div class="col-md-9">    
                     <?php echo form_dropdown('item_category_id_inv',$item_category_list,set_value('item_category_id_inv'),' class="form-control modal_input_1" id="item_category_id_inv" ');?> 
                      <span class="help-block"><?php echo form_error('item_category_id_inv');?>&nbsp;</span>
                  </div> 
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <a id="create_item" class="btn btn-default modal_input_1" >Create Item</a>
        </div>
      </div>

    </div>
  </div>
<!-- /.END MODEL FOR DATE -->
<script>
    
$(document).keypress(function(e) {
//    fl_alert('info',e.keyCode)
        if(e.keyCode == 13) {//13 for enter
            if ($(".add_item_inpt").is(":focus")) { //check the form focused in item add
                    $('#add_item_btn').trigger('click');
//                fl_alert('info',)
              }
            if ($(".modal_input_1").is(":focus")) { //check the form focused in Modal
                    $('#create_item').trigger('click');
                    return false;
              }
            $('#item_desc').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
            $('#place_invoice').trigger('click');
        }
        if(e.keyCode == 78) {//submit for  shift+ n
            $('#add_new_item').trigger('click');
        }
    });
$(document).ready(function(){
    $('#item_code').focus();
    $('.select2').on("select2:close", function () { $(this).focus(); });
    
    $('#modal_add_item').on('shown.bs.modal', function () {
        $('#item_name_inv').focus();
    })  
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
            if(!confirm("click ok to Confirm Create New.")){
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
//                                fl_alert('info',rowCount); 
                                var rowCount = rowCount+1;
                                var qtyXprice = parseFloat($('#item_unit_cost').val()) * parseFloat($('#item_quantity').val());
                                var item_total = qtyXprice - (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
                                var newRow = $('<tr style="padding:10px" id="tr_'+rowCount+'">'+
                                                        '<td>'+(rowCount-3)+'<input hidden name="inv_items['+rowCount+'_'+res2.item_code+'][invoiced_for]" value="<?php echo (isset($invoiced_for))?$invoiced_for:'10';?>"></td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'_'+res2.item_code+'][item_code]" value="'+$('#item_code').val()+'">'+$('#item_code').val()+'</td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'_'+res2.item_code+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+rowCount+'_'+res2.item_code+'][item_id]" value="'+res2.id+'">'+res2.item_name+' - '+res2.item_cat_name+'</td>'+
                                                        '<td align="right"><input class="form-control" type="number" name="inv_items['+rowCount+'_'+res2.item_code+'][item_quantity]" value="'+$('#item_quantity').val()+'"></td>'+
                                                        '<td align="right"><input class="form-control" type="number" name="inv_items['+rowCount+'_'+res2.item_code+'][item_unit_cost]" value="'+$('#item_unit_cost').val()+'"></td>'+
                                                        '<td align="right"><input class="form-control" type="number" name="inv_items['+rowCount+'_'+res2.item_code+'][item_discount]" value="'+$('#item_discount').val()+'"></td>'+
                                                        '<td align="right"><input class="item_tots" hidden name="inv_items['+rowCount+'_'+res2.item_code+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>');
                                jQuery('table#invoice_list_tbl ').append(newRow);
                                var inv_total = parseFloat($('#invoice_total').val()) + item_total;
                                $('#invoice_total').val(inv_total.toFixed(2));
                                $('#inv_total').text(inv_total.toFixed(2));
                                $('#item_code').focus();

                                //added Notification
                                $('#added_info_item').text(res2.item_name+' added to list');
                                $('#added_info_item').delay(2000).hide(function(){
                                    $('#added_info_item').show().text("");
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
                        }
		});

        
        
    });
	//delete row autolode
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
        
        $('#create_item').click(function(){
            if(!confirm("click ok Confirm Add this item.")){
                                            return false;
            }else{
                add_item_invoice()  
            }
        });
        
        function add_item_invoice(){
            var item_name = $('#item_name_inv').val(); 
            var item_cat_id = $('#item_category_id_inv').val(); 
            if(item_name==""){
                fl_alert('info',"Please Enter New Item Name");
                return false;
            }
            $.ajax({
			url: "<?php echo site_url('Items/create_item_invoice');?>",
			type: 'POST',
			data : {item_name:item_name,item_cat:item_cat_id},
//			type: 'GET',
//			data : 'item_name='+item_name+'&item_cat='+item_cat_id,
			success: function(result1){
//                            $("#search_result_1").html(result1); 
                            $('#modal_add_item').modal('toggle');
                            var new_itm = JSON.parse(result1);  
                            $('#item_desc').append($('<option>', { 
                                    value: new_itm.item_code,
                                    text : new_itm.name+' - '+new_itm.item_cat
                                }));
                            
                            $('#item_name_inv').val('');//set empty modal textbox
                            $("#item_code").val(new_itm.item_code);
                            $('#item_code').trigger('keyup'); 
                            $('#item_quantity').focus();
                            
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


                                if(id1!='item_desc'){$('#item_desc').val(res1.item_code).trigger('change');}
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
        
        
</script>
 