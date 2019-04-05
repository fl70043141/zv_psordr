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
<div class="modal fade" id="checkout_cash_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <div class="form-group return_refund_hide">
                <label for="pos_return_note_no" class="col-sm-3 control-label">Return Note No</label>
                <div class="col-sm-9">
                    <input type="text" name="pos_return_note_no"  autocomplete="off" class="form-control input-lg checkout_input" id="pos_return_note_no" placeholder="Eg: CN180800001">
                </div>
              </div>  
              <div class="form-group">
                <label for="total_amount" class="col-sm-3 control-label">Balance Amount</label>
                <div class="col-sm-9">
                    <input readonly type="text" name="total_amount" class="form-control input-lg checkout_input" id="total_amount" placeholder="Total">
                </div>
              </div>  
              <div class="form-group checkout_form">
                <label for="amount_tendered_cash" class="col-sm-3 control-label">Amount Tendered</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control input-lg checkout_input" value="0" id="amount_tendered_cash" name="amount_tendered_cash" placeholder="Total">
                </div>
              </div> 
              <div readonly class="form-group checkout_form card_hide">
                <label for="change_amount" class="col-sm-3 control-label checkout_input">Change</label>
                <div class="col-sm-9">
                    <input readonly type="change_amount" class="form-control input-lg " name="change_amount" id="change_amount" value="0.00" placeholder="Change">
                </div>
              </div> 
                
                <div id="add_voucher_payment_div" class="row voucher_hide" >
                    <div class="col-md-12">
                    <hr>
                    <?php
//                        echo '<pre>';                        print_r($sales_vouchers);
                        foreach ($sales_vouchers as $sales_voucher){
                            echo '<div  style="text-align:center;" class="col-md-3"><a id="checkoutvoucher_'.$sales_voucher['id'].'" class=" voucher_click btn btn-lg btn-default btn-block btn-huge "><span class="fa fa-gift"></span><text>'.$sales_voucher['voucher_amount'].'</text></a><span class="voucher_name_span" >'.$sales_voucher['voucher_name'].'</span><input hidden type="text" id="vouchername_'.$sales_voucher['id'].'"   value="'.$sales_voucher['voucher_name'].'"> </div>';
                        }
                    ?>
                    </div>
                    <div class="col-md-12">
                        <table id="voucher_list" class="table table-bordered">
                             
                        </table>
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
              <div class="form-group card_hide"> 
                <div class="col-sm-12">
                    <textarea class="form-control checkout_input" id="memo" name="memo" placeholder="Order Note.."></textarea>
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
        $('#checkout_cash_modal').on('shown.bs.modal', function () {
            $('#amount_tendered_cash').focus().select();
            check_tender_amount()
            if ( $('#amount_tendered_cash').is('[readonly]') ) { 
                $('#pos_return_note_no').focus().select();
            }
            
        });  

        $("#amount_tendered_cash").keyup(function(){ 
            var tot = $('#total_amount').val();
            var tndr = $('#amount_tendered_cash').val();
            var change_bal = parseFloat(tndr) - parseFloat(tot);
            check_tender_amount()

            $('#change_amount').val((isNaN(change_bal.toFixed(2))?0.00:change_bal.toFixed(2)));
        });
        
        $('#back_checkout_cash').click(function(){
            $('#checkout_cash_modal').modal('toggle'); 
        });
        $('#checkotcash_500').click(function(){
            var amount = parseFloat((isNaN($("#amount_tendered_cash").val()) || $("#amount_tendered_cash").val()=='')?0:$("#amount_tendered_cash").val()) + 500;
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup');
        });
        $('#checkotcash_1000').click(function(){
            var amount = parseFloat((isNaN($("#amount_tendered_cash").val()) || $("#amount_tendered_cash").val()=='')?0:$("#amount_tendered_cash").val()) + 1000;
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
        
        $('#confirm_checkout_cash,#confirm_checkout_card,#confirm_checkout_voucher,#confirm_checkout_ret_refund').click(function(){  
            if($('#customer_id').val()==null){ 
                fl_alert('info',"Please Select the Customer before Completing Invoice"); return false;
            }
            var amount_tendered = parseFloat($("#amount_tendered_cash").val());
            var total_amount = parseFloat($("#total_amount").val());
            var rowCount = $('table #fin_total_tbl_body tr').length;
            var amount = 0;
            if(total_amount > amount_tendered){ amount = amount_tendered; }
            else{amount = total_amount; }
            if(amount==0){
                fl_alert('info',"Amount can not be Zero!"); return false;
            }
//            fl_alert('info',rowCount);
            if(this.id=='confirm_checkout_cash'){
                var new_trns_row_str = '<tr>'+
                                            '<td align="left"><span class="cash_pay_remove fa fa-trash fa-x"> Cash Payment</span> </td>'+
                                            '<td align="right"><input class="cash_pay_inputs" name="trans[cash]['+rowCount+']" value="'+amount+'" hidden><span>'+amount.toFixed(2)+'</span></td>'+
                                       '</tr>';
            }
            if(this.id=='confirm_checkout_card'){
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
            $('table #fin_total_tbl_body').append(new_trns_row);  
             $('.cash_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
                                
            set_temp_invoice();
            recalculate_totals();
            $('#checkout_cash_modal').modal('toggle'); 
            var bal_ckeck = parseFloat($('#total_amount').val()); 
            if(bal_ckeck<=0){
                $('#complete_invoice_checkout').trigger('click');
            }
        });
        
        
        //voucher paymenst
        
        $('.voucher_click').click(function(){
            var vamount = parseFloat($("#"+this.id+" text").text());
            var v_id = this.id.split('_');  
            
            var amount = parseFloat((isNaN($("#amount_tendered_cash").val()))?0:$("#amount_tendered_cash").val()) + vamount;
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
    });
</script>