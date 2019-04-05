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
<div class="modal fade" id="so_checkout_cash_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <label for="payment_method_id" class="col-sm-3 control-label">Method</label>
                <div class="col-sm-9">
                     <?php  echo form_dropdown('payment_method_id',array('1'=>'Cash', '2'=>'Card'),set_value('payment_method_id'),' class="form-control input-lg " data-live-search="true" id="payment_method_id"');?>
                     <?php //  echo form_dropdown('payment_method_id',$payment_method_list,set_value('payment_method_id'),' class="form-control input-lg " data-live-search="true" id="payment_method_id"');?>
                 </div>
              </div>  
              <div class="form-group return_refund_hide">
                <label for="pos_return_note_no" class="col-sm-3 control-label">Return Note No</label>
                <div class="col-sm-9">
                    <input type="text" name="pos_return_note_no"  autocomplete="off" class="form-control input-lg checkout_input" id="pos_return_note_no" placeholder="Eg: CN180800001">
                </div>
              </div>  
              <div class="form-group">
                <label for="total_amount" class="col-sm-3 control-label">Balance Amount</label>
                <div class="col-sm-9">
                    <input readonly type="text" name="total_amount" class="form-control input-lg checkout_input" id="total_amount" placeholder="Total" value="<?php echo $inv_data['invoice_total'];?>">
                </div>
              </div>  
              <div class="form-group checkout_form">
                <label for="amount_tendered_cash" class="col-sm-3 control-label">Amount Tendered</label>

                <div class="col-sm-9">
                    <input type="text" autocomplete="off" class="form-control input-lg checkout_input" value="0" id="amount_tendered_cash" name="amount_tendered_cash" placeholder="Total">
                </div>
              </div> 
                <div id="amount_tendered_release_div" class="form-group checkout_form">
                <label for="amount_tendered_release" class="col-sm-3 control-label">Release from order</label>

                <div class="col-sm-9">
                    <input type="text" autocomplete="off" class="form-control input-lg checkout_input" value="0" id="amount_tendered_release" name="amount_tendered_release" placeholder="Total release">
                </div>
              </div> 
              <div readonly class="form-group checkout_form card_hide">
                <label for="change_amount" class="col-sm-3 control-label checkout_input">Change</label>
                <div class="col-sm-9">
                    <input readonly type="change_amount" class="form-control input-lg " name="change_amount" id="change_amount" value="0.00" placeholder="Change">
                </div>
              </div>  
                <hr class="card_hide">
                <div class="row card_hide">
                    <div id="checkotcash_0" class="col-md-3"><a type="button" class="pull-right btn btn-danger btn-circle btn-xl"><i class="glyphicon glyphicon-erase"></i></a></div>
                    <div id="checkotcash_500" class="col-md-3"><a class="btn btn-lg btn-default btn-block btn-huge " style="font-size: 25px; padding-top: 12px;" ><span class="fa fa-money"></span><b> 500</b></a></div>
                    <div id="checkotcash_1000"  class="col-md-3"><a class="btn btn-lg btn-primary btn-block btn-huge" style="font-size: 25px; padding-top: 12px;"><span class="fa fa-money"></span><b>  1000</b></a></div>
                    <div id="checkotcash_5000"  class="col-md-3"><a class="btn btn-lg btn-success btn-block btn-huge" style="font-size: 25px; padding-top: 12px;"><span class="fa fa-money"></span> <b> 5000</b></a></div>
                </div>
                <hr class="card_hide">
              <div  class="form-group"> 
                <div id="release_amount_div" class="col-sm-12">  
                </div>
              </div>  
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="row">
              <div hidden class="col-md-12"><button id="complete_invoice_checkout" class="col-md-6 btn btn-block btn-success btn-lg">Complete Invoice</button><br><br><br></div>
              <div class="col-md-6"><a id="back_checkout_cash"  class="col-md-6 btn btn-block btn-primary btn-lg">Back </a></div>
              <div id="confirm_checkout_cash_div" class="col-md-6"><a id="confirm_checkout_cash"  class="col-md-6 btn btn-block btn-primary btn-lg"><span class="confirm_btn">Proceed</span></a></div>
              <div id="confirm_checkout_card_div" class="col-md-6"><a id="confirm_checkout_card"  class="col-md-6 btn btn-block btn-primary btn-lg"><span class="confirm_btn">Proceed</span></a></div>
              <div id="confirm_checkout_voucher_div" class="col-md-6"><a id="confirm_checkout_voucher"  class="col-md-6 btn btn-block btn-primary btn-lg"><span class="confirm_btn">Proceed</span></a></div> 
              <div id="confirm_checkout_ret_refund_div" class="col-md-6"><a id="confirm_checkout_ret_refund"  class="col-md-6 btn btn-block btn-primary btn-lg"><span class="confirm_btn">Proceed</span></a></div> 
             
          </div>
      </div> 
    </div>
  </div>
</div>  
 
<script>
    $(document).ready(function(){
        $('#add_payment_inv').click(function(){
            $('#so_checkout_cash_modal').modal({backdrop: 'static', keyboard: false });  
            $('#payment_method_id').trigger('change');
            get_balance_amount()
            if($('input[name=so_id]').val()!=""){
                $('#amount_tendered_release_div').show();
            }else{
                $('#amount_tendered_release_div').hide();
            }
        });
        $('#so_checkout_cash_modal').on('shown.bs.modal', function () {
            $('#amount_tendered_cash').focus().select();
            check_tender_amount()
            if ( $('#amount_tendered_cash').is('[readonly]') ) { 
                $('#pos_return_note_no').focus().select();
            }
            
        });  

        $("#amount_tendered_cash,#amount_tendered_release").keyup(function(){ 
            var tot = $('#total_amount').val();
            var tndr = $('#amount_tendered_cash').val();
            var order_release = $('#amount_tendered_release').val();
            var change_bal = parseFloat(tndr) + parseFloat(order_release) - parseFloat(tot);
            check_tender_amount()

            $('#change_amount').val((isNaN(change_bal.toFixed(2))?0.00:change_bal.toFixed(2)));
        });
        
        $('#back_checkout_cash').click(function(){
            $('#so_checkout_cash_modal').modal('toggle'); 
        });
        $('#checkotcash_500').click(function(){
            var amount = parseFloat((isNaN($("#amount_tendered_cash").val()) || $("#amount_tendered_cash").val()=='')?0:$("#amount_tendered_cash").val()) + 500;
//            var amount = parseFloat($("#amount_tendered_cash").val()) + 500;
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup');
        });
        $('#checkotcash_1000').click(function(){
            var amount = parseFloat((isNaN($("#amount_tendered_cash").val()) || $("#amount_tendered_cash").val()=='')?0:$("#amount_tendered_cash").val()) + 1000;
//            var amount = parseFloat($("#amount_tendered_cash").val()) + 1000;
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup');
        });
        $('#checkotcash_5000').click(function(){
            var amount = parseFloat((isNaN($("#amount_tendered_cash").val()) || $("#amount_tendered_cash").val()=='')?0:$("#amount_tendered_cash").val()) + 5000;
                        
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup');
        });
        $('#checkotcash_0').click(function(){ 
            $("#amount_tendered_cash").val(0);
             $("#amount_tendered_cash").trigger('keyup');
        });
        
        $('#confirm_checkout_cash,#confirm_checkout_card').click(function(){
            var amount_tendered = parseFloat($("#amount_tendered_cash").val());
            var amount_tendered_release = parseFloat($("#amount_tendered_release").val());
            var total_amount = parseFloat($("#total_amount").val());
            var rowCount = $('table #og_tfoot tr').length;
            var amount = 0;
            if(total_amount > amount_tendered){ amount = amount_tendered + amount_tendered_release; }
            else{amount = total_amount; }
            if(amount==0){
                fl_alert('info',"Amount can not be Zero!"); return false;
            }
            
            if(isNaN(amount_tendered || isNaN(amount_tendered_release))){
                fl_alert('info',"Amount Should be Number!"); return false;
            }
            if(this.id=='confirm_checkout_cash'){ 
                var pay_res = make_inv_payments(amount_tendered,$('#payment_method_id').val(),amount_tendered_release);
//                return false;
                if(pay_res !='0'){
                    location.reload()
                    var new_trns_row_str = '<tr>'+
                                             '<td colspan="8"></td>'+
                                              '<td align="left"><span class=" fa fa-trash fa-x"> Cash Payment</span> </td>'+
                                              '<td  style="text-align: right;"><input class="calc_amount cash_pay_inputs" name="trans[cash]['+rowCount+']" value="'+amount+'" hidden><span>'+amount.toFixed(2)+'</span></td>'+
                                             '<td  style="text-align: left;"><span style="color:red;cursor: pointer;" alt="Remove Payment" class="cash_pay_remove">X</span></td>'+
                                        '</tr>'; 
                }
            }
            if(this.id=='confirm_checkout_card'){ 
                var pay_res = make_inv_payments(amount_tendered,$('#payment_method_id').val(),amount_tendered_release);
//                fl_alert('info',); return false;
                if(pay_res !='0'){
                    location.reload()
                }
                var new_trns_row_str = '<tr>'+
                                            '<td align="left"><span class="cash_pay_remove fa fa-trash fa-x"> Card Payment</span> </td>'+
                                            '<td align="right"><input class="card_pay_inputs" name="trans[card]['+rowCount+']" value="'+amount+'" hidden><span>'+amount.toFixed(2)+'</span></td>'+
                                       '</tr>';
            }
            if(this.id=='confirm_checkout_voucher'){
                var new_trns_row_str = '<tr>'+
                                            '<td align="left"><span class="cash_pay_remove fa fa-trash fa-x"> Voucher Payment</span> </td>'+
                                            '<td align="right"><input class="voucher_pay_inputs" name="trans[voucher]['+rowCount+']" value="'+amount+'" hidden><span>'+amount.toFixed(2)+'</span></td>'+
                                       '</tr>';
            }
            if(this.id=='confirm_checkout_ret_refund'){
                var new_trns_row_str = '<tr>'+
                                            '<td align="left"><span class="cash_pay_remove fa fa-trash fa-x"> Return Refund</span><input hidden type="text" name="return_note_nos[]" value="'+$('#pos_return_note_no').val()+'"> </td>'+
                                            '<td align="right"><input class="voucher_pay_inputs" name="trans[return_refund]['+rowCount+']" value="'+amount+'" hidden><span>'+amount.toFixed(2)+'</span></td>'+
                                       '</tr>';
            }
                       
            var new_trns_row = $(new_trns_row_str);
            $('table #og_tfoot').append(new_trns_row); 
             $('.cash_pay_remove').click(function(){ $(this).closest('tr').remove(); calc_tots_og();});
            calc_tots_og()
//            fl_alert('info',amount_tendered); return false; 
            $('#so_checkout_cash_modal').modal('toggle'); 
            var bal_ckeck = parseFloat($('#total_amount').val()); 
            if(bal_ckeck<=0){
                $('#complete_invoice_checkout').trigger('click');
            }
        });
        
        
        //voucher paymenst
        
        $('.voucher_click').click(function(){
            var vamount = parseFloat($("#"+this.id+" text").text());
            var v_id = this.id.split('_');  
            
            var amount = parseFloat($("#amount_tendered_cash").val()) + vamount;
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup'); 
              
//             var new_vlist_row = $('<tr>'+
//                                        '<td>'+$('#vouchername_'+v_id[1]).val()+'</td>'+
//                                        '<td align="center"><span class="btn-sm fa fa-trash"></span></td>'+
//                                    '</tr>');
//            $('#voucher_list').append(new_vlist_row);  
//             $('.cash_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
               
//            fl_alert('info',amount)
        });
        $('#pos_return_note_no').keyup(function(){
            get_return_refund_amount();
        });
        $('#pos_return_note_no').change(function(){
            get_return_refund_amount();
        });
        
        function get_return_refund_amount(){ 
            $.ajax({
                        url: "<?php echo site_url('Sales_pos/fl_ajax');?>",
                        type: 'post',
                        data : {function_name:'get_return_refund',pos_return_note_no:$('#pos_return_note_no').val()},
                        success: function(result1){
//                            console.log(result1);
                            $('#amount_tendered_cash').val(result1);
                            check_tender_amount();
                    }
                    
		});
        }
        
        
        function check_tender_amount(){
            var tendr_amount = parseFloat($('#amount_tendered_cash').val());
            var bal_amount = parseFloat($('#total_amount').val()); 
            if(tendr_amount >= bal_amount){
                $('.confirm_btn').text("Complete");
                 $('.confirm_btn').parent().removeClass('btn-primary');
                 $('.confirm_btn').parent().addClass('btn-success');
            }
            if(tendr_amount < bal_amount){ 
                $('.confirm_btn').text("Proceed"); 
                 $('.confirm_btn').parent().removeClass('btn-success');
                 $('.confirm_btn').parent().addClass('btn-primary');
            }
        }
        
        function make_inv_payments(amount,pay_method,amount_release=0){
//            fl_alert('info',$('input[name=id]').val())
            var tot_payment = amount +amount_release;
            $.ajax({
                           url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=add_inv_payments');?>",
                           type: 'post',
                           data : {function_name:'add_inv_payments', amount:amount, amount_release:amount_release, pay_method:pay_method,tot_amount:tot_payment, invoice_id:$('input[name=id]').val(), order_id:$('input[name=so_id]').val()},
                           success: function(result){  
                                        return result;

                            }
                   });
        }
        
        function get_balance_amount(){
            if($('input[name=so_id]').val()!=''){ 
                $.ajax({
                              url: "<?php echo site_url('Sales_invoices/fl_ajax?function_name=get_calculate_required_payment');?>",
                              type: 'post',
                              data : {function_name:'get_calculate_required_payment',total_amount:0,order_id:$('input[name=so_id]').val()},
                              success: function(result){ 
//                               $("#search_result_1").html(result);
                                   var obj2 = JSON.parse(result);
                                   console.log(obj2);
//                                   return  false;  
                                    var releasable_amount= parseFloat(obj2.releasable_amount);
//                                    fl_alert('info',required_payment)
                                    
                                    $('#release_amount_div').html('');
                                    if(releasable_amount>0){  
                                        var row_str1 = ''; 
                                             row_str1 = '<p style="color:#FC6750;">Releasable Amount: '+Math.abs(releasable_amount).toFixed(2)+'</p>';
                                             $('#release_amount_div').html(row_str1);
                                        }
                                  }
                      });
                }
        }
        
        
        
        $('#payment_method_id').change(function(){
            switch($(this).val()){
                case '1': 
                        $('#checkout_cash_modal').modal({backdrop: 'static', keyboard: false }); 
                        $('#confirm_checkout_cash_div').show();      
                        $('#confirm_checkout_card_div').hide();  
                        $('#add_voucher_payment_div').hide();  
                        $('#confirm_checkout_voucher_div').hide(); 
                        $('#confirm_checkout_ret_refund_div').hide(); 

                        $('.card_hide').show(); 
                        $('.voucher_hide').hide(); 
                        $('.return_refund_hide').hide(); 
                        $('#amount_tendered_cash').prop("readonly", false); 
                        $('#amount_tendered_cash').val(0).select();  
                        break;
                case '2': 
                        $('#checkout_cash_modal').modal({backdrop: 'static', keyboard: false });  
                        $('#confirm_checkout_card_div').show(); 
                        $('#confirm_checkout_cash_div').hide(); 
                        $('#confirm_checkout_voucher_div').hide(); 
                        $('#add_voucher_payment_dev').hide(); 
                        $('#confirm_checkout_ret_refund_div').hide(); 

                        $('.card_hide').hide(); 
                        $('.voucher_hide').hide(); 
                        $('.return_refund_hide').hide(); 
                        $('#amount_tendered_cash').prop("readonly", false); 
                        $('#amount_tendered_cash').val($('#total_amount').val()).select(); 
                        break;
                case '4': 
                        $('#checkout_cash_modal').modal({backdrop: 'static', keyboard: false });  
                        $('#confirm_checkout_ret_refund_div').show(); 
                        $('#confirm_checkout_card_div').hide(); 
                        $('#confirm_checkout_cash_div').hide(); 
                        $('#confirm_checkout_voucher_div').hide(); 
                        $('#add_voucher_payment_dev').hide(); 

                        $('.return_refund_hide').show(); 
                        $('.card_hide').hide(); 
                        $('.voucher_hide').hide(); 
                        $('#amount_tendered_cash').prop("readonly", true); 
                        $('#amount_tendered_cash').val(0); 
                        break; 
            }
        }); 
         
    });
</script>