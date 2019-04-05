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
<div class="modal fade" id="checkout_card_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invoice Checkout Card
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h5>

      </div> 
      <div class="modal-body form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="total_amount" class="col-sm-3 control-label">Balance Amount</label>
                <div class="col-sm-9">
                    <input readonly type="total_amount" name="total_amount" class="form-control input-lg checkout_input" id="total_amount" placeholder="Total">
                </div>
              </div>  
               
              <div class="form-group checkout_form">
                <label for="amount_tendered_cash" class="col-sm-3 control-label">Amount Tendered</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control input-lg checkout_input" value="0" id="amount_tendered_cash" name="amount_tendered_cash" placeholder="Total">
                </div>
              </div> 
              <div readonly class="form-group checkout_form">
                <label for="change_amount" class="col-sm-3 control-label checkout_input">Change</label>
                <div class="col-sm-9">
                    <input readonly type="change_amount" class="form-control input-lg " name="change_amount" id="change_amount" value="0.00" placeholder="Change">
                </div>
              </div> 
                <hr>
                <div class="row">
                    <div id="checkotcash_0" class="col-md-3"><a type="button" class="pull-right btn btn-danger btn-circle btn-xl"><i class="glyphicon glyphicon-erase"></i></a></div>
                    <div id="checkotcash_500" class="col-md-3"><a class="btn btn-lg btn-default btn-block btn-huge "><span class="fa fa-money"></span> 500</a></div>
                    <div id="checkotcash_1000"  class="col-md-3"><a class="btn btn-lg btn-primary btn-block btn-huge"><span class="fa fa-money"></span> 1000</a></div>
                    <div id="checkotcash_5000"  class="col-md-3"><a class="btn btn-lg btn-success btn-block btn-huge"><span class="fa fa-money"></span> 5000</a></div>
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
          <div class="row">
              <div class="col-md-6"><a id="back_checkout_cash"  class="col-md-6 btn btn-block btn-primary btn-lg">Back </a></div>
              <div class="col-md-6"><a id="confirm_checkout_cash"  class="col-md-6 btn btn-block btn-primary btn-lg">Add Payment</a></div>
          </div>
      </div> 
    </div>
  </div>
</div>  
 
<script>
    $(document).ready(function(){ 
        $('#checkout_card_modal').on('shown.bs.modal', function () {
            $('#amount_tendered_cash').focus().select();
        })  

        $("#amount_tendered_cash").keyup(function(){ 
            var tot = $('#total_amount').val();
            var tndr = $('#amount_tendered_cash').val();
            var change_bal = parseFloat(tndr) - parseFloat(tot);

            $('#change_amount').val((isNaN(change_bal.toFixed(2))?0.00:change_bal.toFixed(2)));
        });
        
        $('#back_checkout_cash').click(function(){
            $('#checkout_card_modal').modal('toggle'); 
        });
        $('#checkotcash_500').click(function(){
            var amount = parseFloat($("#amount_tendered_cash").val()) + 500;
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup');
        });
        $('#checkotcash_1000').click(function(){
            var amount = parseFloat($("#amount_tendered_cash").val()) + 1000;
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup');
        });
        $('#checkotcash_5000').click(function(){
            var amount = parseFloat($("#amount_tendered_cash").val()) + 5000;
            $("#amount_tendered_cash").val(amount);
             $("#amount_tendered_cash").trigger('keyup');
        });
        $('#checkotcash_0').click(function(){ 
            $("#amount_tendered_cash").val(0);
             $("#amount_tendered_cash").trigger('keyup');
        });
        
        $('#confirm_checkout_cash').click(function(){ 
            var amount_tendered = parseFloat($("#amount_tendered_cash").val());
            var total_amount = parseFloat($("#total_amount").val());
            var rowCount = $('table #fin_total_tbl_body tr').length;
            var amount = 0;
            if(total_amount > amount_tendered){ amount = amount_tendered; }
            else{amount = total_amount; }
//            fl_alert('info',rowCount);
            var new_trns_row_str = '<tr>'+
                                        '<td align="left"><span class="cash_pay_remove fa fa-trash fa-x"> Cash</span> </td>'+
                                        '<td align="right"><input name="trans[cash]['+rowCount+']" value="'+amount+'" hidden><span>'+amount.toFixed(2)+'</span></td>'+
                                   '</tr>';
                       
            var new_trns_row = $(new_trns_row_str);
            $('table #fin_total_tbl_body').append(new_trns_row);  
             $('.cash_pay_remove').click(function(){ $(this).closest('tr').remove(); set_temp_invoice(); recalculate_totals();});
                                
            set_temp_invoice();
            
            $('#checkout_card_modal').modal('toggle'); 
        });
        
    });
</script>