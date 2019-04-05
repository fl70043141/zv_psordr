<?php
	
	$result = array(
                        'id'=>"",
                        'consignee_id'=>"",  
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'return_date'=>date('m/d/Y'),
                        'item_discount'=>0,
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
            <?php echo form_hidden('form_action','receive','id="form_action"');?>
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Consignee<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('consignee_id',$consignee_list,set_value('consignee_id'),' class="form-control select2" data-live-search="true" id="consignee_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Reference <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('reference',set_value('reference',$result['reference']),' class="form-control" id="reference"');?>
                                         <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id'),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
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
                                         <?php  echo form_input('return_date',set_value('return_date',$result['return_date']),' class="form-control datepicker" readonly id="return_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Return_To<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('location_id',$location_list,set_value('location_id'),' class="form-control select2" data-live-search="true" id="location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div> 
                        </div>
                        <div class="row"> 
                            <div id="result_search"></div>
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Search for Purchase return Return</h4> 
                                    <div class="row col-md-12 ">  
                                        
                                        <div class="col-md-3 col-md-offset-1">  
                                                <div class="form-group pad">
                                                    <label for="cs_no">Submission No</label>
                                                    <?php  echo form_input('cs_no',set_value('cs_no'),' class="form-control" id="cs_no" placeholder="Search by Invoice Number"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="submit_from_date">Submit from</label>
                                                    <?php  echo form_input('submit_from_date',set_value('submit_from_date',date('m/d/Y',strtotime("-1 month"))),' class="form-control datepicker" readonly  id="submit_from_date"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="cs_no">Submit To</label>
                                                    <?php  echo form_input('submit_to_date',set_value('submit_to_date',date('m/d/Y')),' class="form-control datepicker" readonly  id="submit_to_date"');?>
                                                </div> 
                                        </div>   
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="add_item_btn" class="btn-default btn add_item_inpt pad"><span class="fa fa-search"></span> Search
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped fl_scrollable">
                                        <thead>
                                           <tr> 
                                               <th width="10%"  style="text-align: center;">Invoice No</th> 
                                               <th width="10%"  style="text-align: center;">Item Code</th> 
                                               <th width="20%" style="text-align: center;">Item Description</th> 
                                               <th width="12%" style="text-align: center;">Date</th> 
                                               <th width="10%" style="text-align: right;">Qty</th>  
                                               <th width="10%" style="text-align: center;" colspan="2">Qty to Credit</th> 
                                               <th width="10%" style="text-align: center;">price</th> 
                                               <th width="15%" style="text-align: right;">Total</th> 
                                               <th width="5%" style="text-align: center;">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody id="top_rows_restbl">.
                                       </tbody>
                                       <tbody id="bottom_rows_restbl" >
                                           
                                       </tbody>
                                       <tfoot>  
                                            <tr>
                                                <th colspan="7"></th>
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
                            <hr>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memo" class="col-sm-4 control-label">Memo</label>

                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="memo"></textarea>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-sm-8">
                                <button id="place_receive" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i>Receive</button>
                                <button id="place_invoice" class="btn btn-app pull-right  primary"><i class="fa fa-file-text-o"></i>Create Invoice</button>
                
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
//            if ($(".add_item_inpt").is(":focus")) {
                    $('#add_item_btn').trigger('click');
//                fl_alert('info',)
//              }
            $('#item_code').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
            $('#place_invoice').trigger('click');
        }
    });
$(document).ready(function(){ 
    $('#add_item_btn').click(function(){ 
        get_inv_items_res()
    });
    
     $("#place_invoice").click(function(){
         $('[name="form_action"]').val('invoice'); 
            if(!confirm("click ok to Confirm the Form Submission.")){
                  return false;
              }else{
                  if($('input[name^="inv_items_btm"]').length<=0){
                      fl_alert('info',"Atleast one item need to create an Credit Note!")
                      return false;
                  }
              }
    });
     $("#place_receive").click(function(){
         $('[name="form_action"]').val('receive'); 
          if(!confirm("click ok to Confirm the Form Submission.")){
                return false;
            }else{
                if($('input[name^="inv_items_btm"]').length<=0){
                    fl_alert('info',"Atleast one item need to create an Credit Note!")
                    return false;
                }
            }
            
    });
});

function get_inv_items_res(){ 
        var post_data = jQuery('#form_search').serializeArray(); 
        post_data.push({name:"function_name",value:'get_search_res_ret_items'});
    
        $.ajax({
                url: "<?php echo site_url('Consignee_receive/fl_ajax');?>",
                type: 'post',
                data : post_data,
                success: function(result){ 
//                                $("#result_search").html(result);
                                var res2 = JSON.parse(result); 
                                $('#bottom_rows_restbl tr').remove();
                                var rowCount = $('#bottom_rows_restbl tr').length;
                                var rowCount = rowCount+1;     
                                var total = 0;

                                $(res2).each(function (index, elment) {
//                                    console.log(elment); 
//                                    fl_alert('info',elment.item_quantity)
                                    var submitted_date = timeConverter(elment.submitted_date);
                                    elment.unit_price = parseFloat(elment.unit_price)*(100-parseFloat(elment.discount_persent))*0.01 ;
                                    var sub_tot = parseFloat(elment.item_quantity)* parseFloat(elment.unit_price);
                                    var newRow = '<tr id="rowb_'+elment.sd_id+'">'+
                                                        '<td style="text-align: center;">'+elment.cs_no+'<input hidden id="'+elment.sd_id+'_cs_no" value="'+elment.cs_no+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.item_code+'<input hidden id="'+elment.sd_id+'_item_code" value="'+elment.item_code+'"><input hidden id="'+elment.sd_id+'_item_id" value="'+elment.item_id+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.item_description+'<input hidden id="'+elment.sd_id+'_item_description" value="'+elment.item_description+'"></td>'+
                                                        '<td style="text-align: center;">'+submitted_date+'<input hidden  id="'+elment.sd_id+'_cs_date" value="'+elment.submitted_date+'"></td>'+
                                                        '<td style="text-align: right;">'+elment.item_quantity+' '+elment.unit_abbreviation+((elment.item_quantity_uom_id_2>0)?(' | '+elment.item_quantity_2+' '+elment.unit_abbreviation_2):'')+'<input hidden  id="'+elment.sd_id+'_item_quantity" value="'+elment.item_quantity+'"></td>';
                                        if(elment.item_quantity_uom_id_2>0){
                                            newRow +=   '<td style="text-align: left;">'+elment.unit_abbreviation+'<input step="0.01" max="'+elment.item_quantity+'" type="number" id="'+elment.sd_id+'_unit_to_credit"  value="'+elment.item_quantity+'"><input hidden  id="'+elment.sd_id+'_uom_abr" value="'+elment.unit_abbreviation+'"><input hidden  id="'+elment.sd_id+'_uom_id" value="'+elment.item_quantity_uom_id+'"></td>'+
                                                        '<td style="text-align: left;">'+elment.unit_abbreviation_2+'<input step="1" max="'+elment.item_quantity_2+'" type="number" id="'+elment.sd_id+'_unit_to_credit_2"  value="'+elment.item_quantity_2+'"><input hidden  id="'+elment.sd_id+'_uom_abr_2" value="'+elment.unit_abbreviation_2+'"><input hidden  id="'+elment.sd_id+'_uom_id_2" value="'+elment.item_quantity_uom_id_2+'"></td>';
                                        }else{
                                             newRow +=   '<td style="text-align: left;" colspan="2">'+elment.unit_abbreviation+'<br><input  step="0.01" max="'+elment.item_quantity+'" type="number" min="0" max="'+elment.item_quantity_1+'" id="'+elment.sd_id+'_unit_to_credit"  value="'+elment.item_quantity+'"><input hidden  id="'+elment.sd_id+'_uom_abr" value="'+elment.unit_abbreviation+'"><input hidden  id="'+elment.sd_id+'_uom_id" value="'+elment.item_quantity_uom_id+'"></td>';
                                        }
                                            newRow +=  '<td style="text-align: left;">'+elment.currency_code+((parseFloat(elment.discount_persent)>0)?'['+elment.discount_persent+'% Discount inc]':'')+'<input step="1" type="number" id="'+elment.sd_id+'_unit_price"  value="'+parseFloat(elment.unit_price).toFixed(2)+'"></td>'+
                                                       '<td style="text-align: right;"><b>'+sub_tot.toFixed(2)+'<input hidden id="'+elment.sd_id+'_sub_tot" value="'+sub_tot+'"></b></td>'+
                                                       '<td><span  id="'+elment.sd_id+'" class="btn btn-success fa fa-plus add_res_row"></span></td>'+
                                                  '</tr>';
                                    jQuery('#bottom_rows_restbl').append(newRow); 
                             });
                             
                                    $('.add_res_row').click(function(){
                                        
                                        var add_id = this.id;
                                        var add_cs_no = $("#"+add_id+"_cs_no").val()
                                        var add_cs_date = $("#"+add_id+"_cs_date").val()
                                        var add_item_code = $("#"+add_id+"_item_code").val()
                                        var add_item_id = $("#"+add_id+"_item_id").val()
                                        var add_item_description = $("#"+add_id+"_item_description").val()
                                        var add_unit_price = $("#"+add_id+"_unit_price").val()
                                        var add_item_quantity = $("#"+add_id+"_item_quantity").val()
                                        var add_unit_to_credit = $("#"+add_id+"_unit_to_credit").val();
                                        var add_unit_to_credit_2 =(typeof $("#"+add_id+"_unit_to_credit_2").val()!== 'undefined')?$("#"+add_id+"_unit_to_credit_2").val():0;
                                        var add_cs_date =  timeConverter($("#"+add_id+"_cs_date").val());

                                        var add_uom_id = $("#"+add_id+"_uom_id").val();
                                        var add_uom_id_2 = (typeof $("#"+add_id+"_uom_id_2").val()!== 'undefined')?$("#"+add_id+"_uom_id_2").val():0;

                                        var add_uom_abr =  $("#"+add_id+"_uom_abr").val();
                                        var add_uom_abr_2 =  (typeof $("#"+add_id+"_uom_abr_2").val()!== 'undefined')?$("#"+add_id+"_uom_abr_2").val():0;
//                                       fl_alert('info',add_uom_abr_2)
                                        var add_sub_tot = parseFloat(add_unit_to_credit)* parseFloat(add_unit_price);
//                                     
                                        var newRow = '<tr id="rowt_'+add_id+'">'+
                                                        '<td style="text-align: center;">'+add_cs_no+'<input hidden name="inv_items_btm['+add_id+'][cs_no]" value="'+add_cs_no+'"></td>'+
                                                        '<td style="text-align: center;">'+add_item_code+'<input hidden name="inv_items_btm['+add_id+'][item_code]" value="'+add_item_code+'"><input hidden name="inv_items_btm['+add_id+'][item_id]" value="'+add_item_id+'"></td>'+
                                                        '<td style="text-align: center;">'+add_item_description+'<input hidden name="inv_items_btm['+add_id+'][item_description]" value="'+add_item_description+'"></td>'+
                                                        '<td style="text-align: center;">'+add_cs_date+'<input hidden name="inv_items_btm['+add_id+'][cs_date]" value="'+add_cs_date+'"></td>'+
                                                        '<td style="text-align: right;">'+add_item_quantity+' '+add_uom_abr+'<input hidden name="inv_items_btm['+add_id+'][item_quantity]" value="'+add_unit_price+'"></td>'+
                                                        '<td style="text-align: right;" colspan="2">'+parseFloat(add_unit_to_credit).toFixed(2)+' '+add_uom_abr+((add_uom_abr_2!=0)?'| '+add_unit_to_credit_2+' '+add_uom_abr_2:'')+'<input hidden name="inv_items_btm['+add_id+'][item_quantity]" value="'+add_unit_to_credit+'"><input hidden name="inv_items_btm['+add_id+'][item_quantity_2]" value="'+add_unit_to_credit_2+'"><input hidden name="inv_items_btm['+add_id+'][uom_id]" value="'+add_uom_id+'"><input hidden name="inv_items_btm['+add_id+'][uom_id_2]" value="'+add_uom_id_2+'"></td>'+
                                                        '<td style="text-align: right;">'+parseFloat(add_unit_price).toFixed(2)+'<input hidden name="inv_items_btm['+add_id+'][unit_price]" value="'+parseFloat(add_unit_price).toFixed(2)+'"></td>'+
                                                        '<td style="text-align: right;"><b>'+add_sub_tot.toFixed(2)+'<input hidden name="inv_items_btm['+add_id+'][sub_tot]" id="remove_subtot_'+add_id+'" value="'+add_sub_tot+'"></b></td>'+
                                                        '<td><span  id="add_'+add_id+'" class="btn btn-danger fa fa-trash remove_res_row"></span>'+'<input hidden id="add_'+add_id+'_remove" value="'+add_id+'"></td>'+
                                                  '</tr>';
                                            jQuery('#top_rows_restbl').append(newRow); 
                                            
                                            var add_total = parseFloat($("#invoice_total").val()) + add_sub_tot; 
                                            $('#invoice_total').val(add_total);
                                            $('#inv_total').text(add_total.toFixed(2));
                                            
                                            $('#rowb_'+add_id).hide();
                                              
                                            $('.remove_res_row').click(function(){
                                                var rmv_id = $('#'+this.id+"_remove").val();
                                                
                                            
                                                    var remove_total = parseFloat($("#invoice_total").val()) - parseFloat( $('#remove_subtot_'+rmv_id).val()); 
                                                    remove_total = (isNaN(remove_total))?0:remove_total;
                                                    $('#invoice_total').val(remove_total);
                                                    $('#inv_total').text(remove_total.toFixed(2));

                                                    $('#rowt_'+rmv_id).remove();
                                                    $('#rowb_'+rmv_id).show();
                                            });
                                               
                                    });
                    }
        });
}
function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = date + ' ' + month + ' ' + year ;
  return time;
}
</script>
 