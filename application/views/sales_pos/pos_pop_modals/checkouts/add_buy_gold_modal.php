<style>
.btn-huge{
    height: 60px;
    padding-top:18px; 
}     
.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
} 
.btn-circle.btn-xl {
  width: 60px;
  height: 60px;
  padding: 15px 16px;
  font-size: 24px;
  line-height: 1.33;
  border-radius: 35px;
}

</style>
 <!-- Modal Checkout-->
   <?php echo form_open("", 'id="form_add_buy_gold" class="form-horizontal"')?>  
   
<div class="modal fade" id="add_buy_gold_modal_pop"   role="dialog" aria-labelledby="buy_gold_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 800px;"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="buy_gold_modal_label">Add Buy Gold
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h5>

      </div> 
      <div class="modal-body form-horizontal">
         <?php
	
//            echo '<pre>';            print_r($_GET); die;
	$result = array(
                        'id'=>"",
                        'og_customer_id'=> (isset($cust_id) && $cust_id!='')?$cust_id:'',   
                        'og_reference'=> 'OG-'.date('Ymd-Hi'),
                        'og_date'=>date('m/d/Y'),
                        'og_item_discount'=>0,
                        'og_payment_term_id'=>0,
                        'og_currency_code'=>$this->session->userdata(SYSTEM_CODE)['default_currency'],
                        'og_item_quantity'=>1,
                        'og_item_quantity_2'=>1,
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
              <div id="og_form_div" class="box box-primary"> 
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open('', 'id="form_old_gold" class="form-horizontal"')?>  
                    <?php echo form_hidden('og_for',(isset($_GET['type']))?$_GET['type']:''); //OG for sales order or Invoice ?>
                    <div class="box-body">
                        
                        <div class="row header_form_sales">  
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">OG Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('og_date',set_value('og_date',$result['og_date']),' class="form-control datepicker" readonly id="og_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('og_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('og_payment_term_id',$payment_term_list,set_value('og_payment_term_id'),' class="form-control select2" data-live-search="true" id="og_payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Reference <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('og_reference',set_value('og_reference',$result['og_reference']),' class="form-control" id="og_reference"');?>
                                         <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                    </div> 
                                </div>  
                            </div>
                            <div class="col-md-6">
                                
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('og_currency_code',$currency_list,set_value('og_currency_code',$result['og_currency_code']),' class="form-control select2" data-live-search="true" id="og_currency_code"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Received_to<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('og_location_id',$location_list,set_value('og_location_id'),' class="form-control  " data-live-search="true" id="og_location_id"');?>
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
                                        <div id="og_first_col_form" class="col-md-3">
                                            <div class="form-group pad">
                                                <label for="og_item_category_id">Category</label>
                                                <?php echo form_dropdown('og_item_category_id',$item_category_list,set_value('og_item_category_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="og_item_category_id"');?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 ">
                                            <div class="form-group pad">
                                                <label for="og_item_desc">Item Desc</label>
                                                <?php  echo form_input('og_item_desc',set_value('og_item_desc'),' class="form-control add_item_inpt" data-live-search="true" id="og_item_desc"');?>
                                            </div>
                                        </div>
                                        <div id="og_uom_div">
                                            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group pad">
                                                <label for="og_item_unit_cost">Unit Cost<span id="per_amount_text"></span></label>
                                                <input type="text" name="og_item_unit_cost" value="0" class="form-control add_item_inpt" id="og_item_unit_cost" placeholder="Unit Cost for item">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="og_add_item_btn" class="btn-default btn add_item_inpt pad">Add</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="box-body fl_scrollable_x_y"> 
                                    <table id="og_invoice_list_tbl" class="table table-bordered table-striped">
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
                                                <th  style="text-align: right;"><input hidden value="0" name="og_invoice_total" id="og_invoice_total"><span id="og_inv_total">0</span></th>
                                            </tr> 
                                       </tfoot>
                                        </table>
                                </div>
                                <div id="og_search_result_1"></div>
                            </div>    
                        </div>
                        <div class="row" id="og_footer_sales_form">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="og_memo" class="col-sm-4 control-label">Memo</label>

                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="og_memo"></textarea>
                                    </div>
                                  </div>
                            </div>
                            <div hidden class="col-sm-8">
                                <a id="place_old_gold" class="btn btn-app pull-right  btn-primary"><i class="fa fa-check"></i>Submit</a>
                
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
     
      </div>
      <div class="modal-footer"> 
          <div class="row">
              <div class="col-md-6"><a id="back_add_buy_gold"  class="col-md-6 btn btn-block btn-primary btn-lg">Back </a></div>
              <div class="col-md-6"><a id="confirm_add_buy_gold"  class="col-md-6 btn btn-block btn-primary btn-lg">Confirm Submit</a></div>
          </div>
      </div> 
    </div>
  </div>
</div>  
<?php echo form_close();?>
<script>
    
    $(document).ready(function(){
        $('#og_item_category_id').focus(); 
        $('.select2').on("select2:close", function () { $(this).focus(); });

        get_item_dets($('#og_item_category_id').val());
        $("#og_item_category_id").on("change",function(){ 
                get_item_dets(this.id);
        });
        
    $("#og_add_item_btn").click(function(){
         if($('#og_item_desc').val()==null || $('#og_item_desc').val()==""){
            fl_alert('info','Item Name Required! Please enter Item Name.');
            $('#item_desc').focus();
            return false;
        }
//        fl_alert('info',parseFloat($('#item_quantity').val()))
        if(isNaN($('#og_item_quantity').val()) || parseFloat($('#og_item_quantity').val())<=0){
            fl_alert('info','Weight Invalid! Please enter Valid Weight.');
            $('#og_item_quantity').focus();
            return false;
        }
        if(isNaN($('#og_item_quantity_2').val()) || parseFloat($('#og_item_quantity_2').val())<=0){
            fl_alert('info','Quantity Invalid! Please enter Valid Quantity.');
            $('#og_item_quantity_2').focus();
            return false;
        }
         $.ajax({
			url: "<?php echo site_url('Purchasing_items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_single_category', item_category_id:$('#og_item_category_id').val()},
			success: function(result){
                                var res2 = JSON.parse(result);
//                                $("#search_result_1").html(result);
                                
                                if(res2.id==null){
                                    fl_alert('info','Item category invalid! Please recheck before add.');
                                    return false;
                                }
                                res2.item_name = $('#og_item_desc').val();
                                var rowCount = $('#og_invoice_list_tbl tr').length;
                                var counter = rowCount+1;
                                var qtyXprice = parseFloat($('#og_item_unit_cost').val()) * parseFloat($('#og_item_quantity').val());
//                                var item_total = qtyXprice - (parseFloat($('#item_discount').val())* 0.01 * qtyXprice);
                                var item_total = qtyXprice;
                                
                                
                                var row_str = '<tr style="padding:10px" id="tr_'+rowCount+'">'+ 
                                                        '<td align="center"><input hidden name="og_items['+rowCount+'][cat_id]" value="'+res2.id+'">'+res2.category_name+'</td>'+
                                                        '<td align="center"><input hidden name="og_items['+rowCount+'][item_desc]" value="'+res2.item_name+'">'+res2.item_name+'</td>'+
                                                        '<td align="center"><input hidden name="og_items['+rowCount+'][item_quantity]" value="'+$('#og_item_quantity').val()+'"><input hidden name="og_items['+rowCount+'][item_quantity_2]" value="'+(($('#og_item_quantity_2').val()==null)?0:$('#og_item_quantity_2').val())+'">'+
                                                        '<input hidden name="og_items['+rowCount+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="og_items['+rowCount+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                $('#og_item_quantity').val()+' '+res2.unit_abbreviation;
                                if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
                                    row_str = row_str + ' | ' + $('#og_item_quantity_2').val()+' '+res2.unit_abbreviation_2;
                                }                                                                                                                                                                                                                                                                        
                                row_str = row_str + '</td> <td align="right"><input hidden name="og_items['+rowCount+'][item_unit_cost]" value="'+$('#og_item_unit_cost').val()+'">'+parseFloat($('#og_item_unit_cost').val()).toFixed(2)+'</td>'+ 
                                                        '<td align="right"><input class="og_item_tots" hidden name="og_items['+rowCount+'][item_total]" value="'+item_total+'">'+item_total.toFixed(2)+'</td>'+
                                                        '<td width="5%"><button id="del_btn" type="button" class="og_del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>';
                                var newRow = $(row_str);
                                jQuery('table#og_invoice_list_tbl ').append(newRow);
                                var inv_total = parseFloat($('#og_invoice_total').val()) + item_total;
                                $('#og_invoice_total').val(inv_total.toFixed(2));
                                $('#og_inv_total').text(inv_total.toFixed(2));
                                $('#og_item_desc').focus();
                                //delete row
                                $('.og_del_btn_inv_row').click(function(){
//                                    if(!confirm("click ok Confirm remove this item.")){
//                                        return false;
//                                    }
                                    var tot_amt = 0;
                                    $(this).closest('tr').remove(); 
                                    $('input[class^="og_item_tots"]').each(function() {
//                                        console.log(this);
                                        tot_amt = tot_amt + parseFloat($(this).val());
                                    });
                                    $('#og_invoice_total').val(tot_amt.toFixed(2));
                                    $('#og_inv_total').text(tot_amt.toFixed(2)); 
                                });
                        }
		});

        
        
    });
    
        function get_item_dets(id1=''){ //id1 for input element id [cat_id] 
                $.ajax({
                            url: "<?php echo site_url('Purchasing_items/fl_ajax');?>",
                            type: 'post',
                            data : {function_name:'get_single_category', item_category_id:$('#og_item_category_id').val()},
                            success: function(result){

//                                $("#og_search_result_1").html(result);
    //                            return false;
                                var res1 = JSON.parse(result);

                                 $('#og_first_col_form').removeClass('col-md-offset-1');
                                var div_str = '<div class="col-md-2">'+
                                                        '<div class="form-group pad">'+
                                                            '<label for="og_item_quantity">Qty <span id="og_unit_abbr">[Each]<span></label>'+
                                                            '<input type="text" name="og_item_quantity" class="form-control add_item_inpt" id="og_item_quantity" placeholder="Enter Quantity">'+
                                                        '</div>'+
                                                    '</div>';
                                if(res1.item_uom_id_2!=0){
                                        div_str = div_str + '<div class="col-md-2">'+
                                                                '<div class="form-group pad">'+
                                                                    '<label for="og_item_quantity_2">Qty <span id="og_unit_abbr_2">[Each]<span></label>'+
                                                                    '<input type="text" name="og_item_quantity_2" class="form-control add_item_inpt" value="1" id="og_item_quantity_2" placeholder="Enter Quantity">'+
                                                                '</div>'+
                                                            '</div>';

                                }else{
                                    $('#og_first_col_form').addClass('col-md-offset-1')
                                }
                                $('#og_uom_div').html(div_str);

                                if(typeof(res1.id) != "undefined" && res1.id !== null) { 
    //                                if(id1!='item_desc'){$('#item_desc').val(res1.item_code).trigger('change');}
    //                                if(id1!='item_code'){ $('#item_code').val(res1.item_code);}
                                    (res1.price_amount==null)? $('#og_item_unit_cost').val(0):$('#og_item_unit_cost').val(res1.price_amount);
                                    $('#og_unit_abbr').text('['+res1.unit_abbreviation+']');
                                    $('#og_unit_abbr_2').text('['+res1.unit_abbreviation_2+']');
                                    $('#og_per_amount_text').text(' / '+res1.unit_abbreviation);
    //                                $('#item_discount').val(0);
                                    $('#og_item_quantity').val(1);

//                                    $("#og_result_search").html(result);
                                }
                            }
                    });
            }
    });
    
    
    
    
    
    
    
    
    
    
    $(document).ready(function(){ 
        $('#old_gold_add_btn').click(function(){ 
           $('#add_buy_gold_modal_pop').modal({backdrop: 'static', keyboard: false }); 
        });
        $('#add_buy_gold_modal_pop').on('shown.bs.modal', function () {
//            $('#new_customer_name').focus();
        })  
  
        $('#back_add_buy_gold').click(function(){
            $('#add_buy_gold_modal_pop').modal('toggle'); 
        }); 
        $('#confirm_add_buy_gold').click(function(){  
            if($('input[name^="og_items"]').length<=0){
                fl_alert('info',"Atleast one item need for Old Gold Submision!")
                return false;
            } 
             if(!confirm("Click ok to confirm Buy Gold Submission.")){
                 return false;
             }
             add_og_modal();
        });
        
    function add_og_modal(){
        var ret_val = 0;
        var post_data = $('#og_form_div').find('select, textarea, input').serializeArray(); 
            post_data.push({name:"og_customer_id",value:$('#customer_id').val()}); 
            post_data.push({name:"function_name",value:'create_old_gold_ajax'}); 
            $.ajax({
                url: "<?php echo site_url('Buy_gold/fl_ajax/');?>",
                type: 'post',
                data : post_data,
                success: function(result_og){
                    var og_data = JSON.parse(result_og);
                    
                    console.log(og_data);

                    var rowCount = $('table #fin_total_tbl_body tr').length; 
                        var new_trns_row_str = '<tr>'+
                                                    '<td align="left"><span class="cash_pay_remove fa fa-trash fa-x"> Old Gold</span><input hidden type="text" name="og_nos[]" value="'+og_data.og_id+'"> </td>'+
                                                    '<td align="right"><input class="og_pay_inputs" name="trans[og]['+rowCount+']" value="'+og_data.og_total+'" hidden><span>'+(og_data.og_total).toFixed(2)+'</span></td>'+
                                               '</tr>'; 
                    var new_trns_row = $(new_trns_row_str);
                    $('table #fin_total_tbl_body').append(new_trns_row); 
                    $('.cash_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
                                
                    set_temp_invoice();
                    recalculate_totals(); 
                    var bal_ckeck = parseFloat($('#total_amount').val()); 
                    if(bal_ckeck<=0){
                        $('#complete_invoice_checkout').trigger('click');
                    }
                    $('#add_buy_gold_modal_pop').modal('toggle'); 
                    
                }
            }); 
    }
     
    });
    
    
</script>