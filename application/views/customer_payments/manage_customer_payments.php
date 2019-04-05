<?php
	
	$result = array(
                        'id'=>"",
                        'transection_type_id'=>"",
                        'reference'=>"CP-".date("ymd-his"),
                        'person_type'=>0, //10: cust, 20:sup, 30: consignee
                        'person_id'=>"", //customer/suplier/consignee
                        'transection_amount'=>0, //customer/suplier/consignee
                        'trans_date'=>date('m/d/Y'), 
                        'trans_memo'=>'',
                        'description'=>'',
                        'status'=>"1",
                        'bank_account_id'=>"0", 
            
                        'ref_id'=>0, //Eg: invoice_id 
                        'trans_reference'=>0,//Eg: Invoice_no
                        'currency_code'=>"LKR",
                        );   		
	
	 
	switch($action):
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
                 <a href="<?php // echo ($res_det['person_type']==20)?base_url('Invoices/view/'.$res_det['id']):base_url('Bookings/edit/'.$res_det['id']);?>" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>
                <!--<a class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>-->
            </div>
        </div>
 <br><hr>
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $action;?> </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart("Customer_payments/validate",'id="form_search" class="form-horizontal"'); ?> 
             <?php echo form_hidden('person_type',$person_type)?> 
                
                    <div class="box-body fl_scroll">
                              
                        <div class="row form-horizontal"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo $person;?><span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('person_id',$person_list,set_value('person_id'),' class="form-control select2" data-live-search="true" id="person_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Trns Type<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('transection_type_id',$transection_type_list,set_value('transection_type_id',$trans_type_id),' class="form-control select2" data-live-search="true" id="transection_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div>
                            
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('trans_date',set_value('trans_date',$result['trans_date']),' class="form-control datepicker" readonly id="trans_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('trans_date');?>&nbsp;</span>-->
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
                                    <label class="col-md-3 control-label">Bank <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('bank_account_id',$bank_account_list,set_value('bank_account_id'),' class="form-control select2" data-live-search="true" id="bank_account_id"');?>
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
                        </div>
                                           
                             <hr>
                                 
                             <div id="search_result_1"></div>
                        <div class="box-body fl_scrollable_x_y"> 
                            
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped fl_scrollable">
                                        <thead>
                                           <tr> 
                                               <th width="10%"  style="text-align: center;">Transection</th> 
                                               <th width="15%"  style="text-align: center;">Ref</th> 
                                               <th width="10%" style="text-align: center;">Date</th> 
                                               <th width="10%" style="text-align: center;">Date Due</th> 
                                               <th width="10%" style="text-align: right;">Amount</th>  
                                               <th width="10%" style="text-align: right;">Other Allocations</th> 
                                               <th width="10%" style="text-align: right;">Left to Allocate</th> 
                                               <th width="15%" style="text-align: right;">This Allocation</th> 
                                               <th width="5%" style="text-align: center;">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody id="rows_res_tbl">
                                           
                                       </tbody>
                                       <tbody id="bottom_rows_restbl" >
                                           
                                       </tbody>
                                       <tfoot>  
                                            <tr>
                                                <th colspan="9"></th></tr> 
                                       </tfoot>
                                        </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Total Amount <span style="color: red">*</span></label>
                                            <div class="col-md-9">    
                                                <input type="number" name="transection_amount" min="0" step=".001"  id="transection_amount" value="<?php echo set_value('transection_amount',$result['transection_amount']);?>" class="form-control">
                                                 <?php //  echo form_('transection_amount',set_value('transection_amount',$result['transection_amount']),' class="form-control"  id="transection_amount"');?>
                                                 <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="col-md-6 col-md-offset-3"> 
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Memo <span style="color: red"></span></label>
                                            <div class="col-md-9">    
                                                   <textarea class="form-control checkout_input" id="memo" name="memo" placeholder="Payment Note.."></textarea>
                                                 <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                            </div> 
                                        </div> 
                                    </div>
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
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php // echo anchor(site_url('Bookings/edit/'.$result['id']),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url($this->router->fetch_class()),'OK','class="btn btn-primary"');
                                    } ?>
                      <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                    </div>
                  <?php echo form_close();?>
                </div>
                <!-- /.box -->
          </div> 
    </section> 
 
<script>
    
$(document).ready(function(){  
    get_due_list();
    $('#person_id').change(function(){
        get_due_list(); 
    });
    
    
    $("input[name=submit]").click(function(){
        if($('input[name=transection_amount]').val()<=0){
            fl_alert('info',"Transection amount required for make payment!")
            return false;
        }else{
            if(!confirm("Click ok confirm your form submission.")){
            return false;
        }
        }
//            return false;
    });
    
    function get_due_list(){
        var post_data = jQuery('#form_search').serializeArray(); 
        post_data.push({name:"function_name",value:'get_dues'});
    
        $.ajax({
                url: "<?php echo site_url('Customer_payments/fl_ajax');?>",
                type: 'post',
                data : post_data,
                success: function(result){ 
//                                $("#search_result_1").html(result);
                                var res2 = JSON.parse(result);  
                                $('#rows_res_tbl tr').remove();
                                var rowCount = $('#rows_res_tbl tr').length;
                                var rowCount = rowCount+1;     
                                var total = 0;
                                
//                                fl_alert('info',rowCount)
                                $(res2).each(function (index, elment) {
                                    console.log(elment.invoice_dets.invoice_no); 
                                    var trans_date = timeConverter(elment.invoice_dets.invoice_date);
                                    var due_date =  parseFloat(elment.invoice_dets.invoice_date)+(parseFloat(elment.invoice_dets.days_after)*60*60*24);
                                    var newRow = '<tr>'+
                                                        '<td align="center">'+elment.trans_type+'<input hidden name="allocation['+elment.invoice_dets.id+'][inv_id]" value="'+elment.invoice_dets.id+'"></td>'+
                                                        '<td align="center">'+elment.invoice_dets.invoice_no+'</td>'+ 
                                                        '<td align="center">'+trans_date+'</td>'+
                                                        '<td align="center">'+timeConverter(due_date)+'</td>'+ 
                                                        '<td align="right">'+parseFloat(elment.invoice_desc_total).toFixed(2)+'</td>'+
                                                        '<td align="right">'+parseFloat(Math.abs(elment.transection_total)).toFixed(2)+'</td>'+
                                                        '<td align="right">'+parseFloat(elment.invoice_total).toFixed(2)+'<input hidden name="allocation['+elment.invoice_dets.id+'][amount_due]"  id="amount_due_'+elment.invoice_dets.id+'" value="'+elment.invoice_total+'"></td>'+
                                                        '<td><input name="allocation['+elment.invoice_dets.id+'][amount]" type="number"  step=".001" id="amount_'+elment.invoice_dets.id+'" value="0" class="inv_amount"></td>'+
                                                        '<td><span id="'+elment.invoice_dets.id+'_all" title="All Amount" class="fa fa-check-circle all_amount_btn"></span> | <span id="'+elment.invoice_dets.id+'_zero" title="Zero Amount" class="fa fa-times-circle zero_amount_btn"></span></td>'+
                                                    '</tr>';
                                            
                                    jQuery('#rows_res_tbl').append(newRow); 
                                });
                                
                                $('.all_amount_btn').click(function(){
                                    var id = this.id.split('_');
                                    $('#amount_'+id).val(parseFloat($('#amount_due_'+id).val()).toFixed(2)); 
                                    var new_trans_amount = parseFloat(($('#transection_amount').val()=='')?0:$('#transection_amount').val()) + parseFloat($('#amount_due_'+id).val());
                                    $('#transection_amount').val(new_trans_amount.toFixed(2));
//                                    fl_alert('info',id[0])
                                });
                                $('.zero_amount_btn').click(function(){
                                    var id2 = this.id.split('_');
                                    var new_trans_amount2 = parseFloat( $('#transection_amount').val()) - parseFloat($('#amount_'+id2).val());
                                    $('#transection_amount').val((new_trans_amount2>=0)?new_trans_amount2.toFixed(2):0);
                                    $('#amount_'+id2).val(0);
                                });
                                
                                $('.inv_amount').blur(function(){ 
                                    var new_trans_amount = parseFloat(($('#transection_amount').val()=='')?0:$('#transection_amount').val()) + parseFloat($('#'+this.id).val());
                                    $('#transection_amount').val(new_trans_amount.toFixed(2));
                                });
                                $('.inv_amount').focusin(function(){ 
                                    var new_trans_amount = parseFloat(($('#transection_amount').val()=='')?0:$('#transection_amount').val()) - parseFloat($('#'+this.id).val());
                                    $('#transection_amount').val(new_trans_amount.toFixed(2));
                                });
                            }
            });
        
    }
    
    
    included_show();
    $('#calculation_type').change(function(){
        included_show();
    });
    function included_show(){
        var cal_type_val = $('#calculation_type').val(); 
        if(cal_type_val==2){ 
            $('#included_div').show(); 
            $('#currency_div').hide(); 
        }else{
            if(cal_type_val==1){
                $('#currency_div').show(); 
            }
            $('#included_div').hide(); 
        }
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
});
</script>