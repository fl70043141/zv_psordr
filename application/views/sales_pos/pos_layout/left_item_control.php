<style>
    .container1{
        position: relative;
        /*font-family: Arial;*/
    }

    .text-block {
        position: absolute;
        top: 24px;
        left: 10px;
        background:rgba(0,0,0,0.5); 
        color: white; 
        width: 132px;
        height: 20px;
        text-align: center;
    }
</style> 
<div style="padding-top:4px; " class="row">  
                                                <div class="">
                                                    <div id='add_item_form' style="height: 80px;" class="col-md-12  bg-light-blue-gradient">

                                                        <div class="row col-md-12 ">
                                                            <div id="first_col_form" class="col-md-2">
                                                                <div class="form-group pad">
                                                                    <label for="item_code"> Code</label>
                                                                    <?php  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" data-live-search="true" id="item_code"');?>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group pad">
                                                                    <label for="item_desc">Item Description</label>
                                                                    <?php echo form_dropdown('item_desc',$item_list,set_value('item_desc'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="item_desc"');?>
                                                                </div>
                                                            </div>
                                                            <div id="uom_div">

                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group pad">
                                                                    <label for="item_unit_cost">Unit Price/g</label>
                                                                    <input  name="item_unit_cost" class="form-control add_item_inpt" id="item_unit_cost" value="0" placeholder="Unit Cost for item">
                                                                </div>
                                                            </div>
                                                            <div  class="col-md-1">
                                                                <div class="form-group pad">
                                                                    <label for="item_unit_cost">Discount</label>
                                                                    <input  name="item_discount"    class="form-control add_item_inpt" id="item_discount" value="0" placeholder="Enter Line Discount">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-group pad"><br>
                                                                    <span id="add_item_btn" class="btn-default btn add_item_inpt pad">Add</span>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
 
                                                        
                                                        <div  style="height:300px; overflow-y: scroll;" id="list_table" class="box-body col-md-8 "> 
                                                            <table id="invoice_list_tbl" class="table table-bordered table-striped">
                                                                <thead>
                                                                   <tr> 
                                                                       <th width="10%"  style="text-align: center;">Item Code</th> 
                                                                       <th width="20%" style="text-align: center;">Item Description</th> 
                                                                       <th width="10%" style="text-align: center;">Quantity</th> 
                                                                       <th width="10%" style="text-align: right;">Unit Cost</th>  
                                                                       <th width="10%" style="text-align: right;">Discount</th>  
                                                                       <th width="10%" style="text-align: right;">Total</th> 
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
                                                                        <th colspan="4"></th>
                                                                        <th  style="text-align: right;">Total</th>
                                                                        <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total"></span></th>
                                                                    </tr> 
                                                               </tfoot>
                                                                </table>
                                                        </div> 
                                                    <div style="height:200px;;" class="col-md-4  fl_scroll"> 
                                                        <br>
                                                            <table id="fin_total_table" class="table table-line">
                                                                <thead>
                                                                    <tr>
                                                                        <td align="left"><b>Gross Total </b></td>
                                                                        <td align="right"><b><span id="fin_subtotal">0.00</span></b></td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="fin_total_tbl_body">
                                                                    <tr hidden id="fin_total_line_discount_row">
                                                                        <td align="left">Total Line Discount </td>
                                                                        <td align="right"><input id="fin_total_line_discount_val" value="0" hidden><span id="fin_total_line_discount_text">0.00</span></td>
                                                                    </tr> 
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td align="left"><b>Balance </b></td>
                                                                        <td align="right"><b><span id="fin_total">0.00</span></b></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table> 
                                                        </div>
                                                    
                                                        <div style="height:80px;;" class="col-md-4 "> 
                                                            <div class="row">
                                                                <a id="add_cash_payment" style="width:45%; height: 90px;font: arial; font-size: 30px;padding-top: 20px; margin: 5px; background-color: #f73e3ede;" class="btn   btn-primary col-md-6"><i class="fa fa-money"></i> <b>CASH</b></a>
                                                                <a id="add_card_payment" style="width:45%; height: 43px;font: arial; font-size: 19px; margin: 5px 0 0 0;" class="btn  btn-primary col-md-6"><i class="fa fa-credit-card"></i> <b>CARD</b></a>
                                                                <a id="add_voucher_payment" style="width:45%; height: 43px;font: arial; font-size: 19px; margin: 3px 0 0 0;" class="btn  btn-primary col-md-6"><i class="fa fa-file-text-o"></i> <b>VOUCHER</b></a>
                                                            </div>
                                                        </div>
                                                    <div  id="search_result_1"></div>
                                                    <div class="col-md-12">
                                                    <hr>
                                                    <?php
//                                                        echo '<pre>';print_r($item_categories);
                                                        foreach ($item_categories as $item_category){
                                                            echo '<div class="container1 inline">
                                                                    <img id="catimg_'.$item_category['id'].'" title="'.$item_category['category_name'].'" style="width: 138px; margin:0 0 7px 7px; height: 80px" class="img-bordered1 pos_img_cat" src="'.base_url(CAT_IMAGES.$item_category['id']."/".$item_category['cat_image']).'">
                                                                    <div class="text-block">  
                                                                        <p>'.$item_category['category_name'].'</p>
                                                                      </div>
                                                                </div>  ';
                                                        }
                                                    ?>
                                                        
                                                    </div>    
                                                </div>     
    
                                            </div>
 
<script>
    $(document).ready(function(){
        $('#add_cash_payment').click(function(){
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
            $('#amount_tendered_cash').val(0); 
        });
        
        $('#add_card_payment').click(function(){
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
            $('#amount_tendered_cash').val($('#total_amount').val()); 
            
            
        });
        
        $('#return_refund_btn').click(function(){
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
            
            
        });
        
        $('#add_voucher_payment').click(function(){
            $('#checkout_cash_modal').modal({backdrop: 'static', keyboard: false });  
            $('#add_voucher_payment_div').show(); 
            $('#confirm_checkout_voucher_div').show(); 
            $('#confirm_checkout_card_div').hide(); 
            $('#confirm_checkout_cash_div').hide(); 
            $('#confirm_checkout_ret_refund_div').hide(); 
             
            $('.voucher_hide').show(); 
            $('.card_hide').hide(); 
            $('.return_refund_hide').hide(); 
            $('#amount_tendered_cash').prop("readonly", true); 
            $('#amount_tendered_cash').val(0); 
            
            
        });
          
        $('.pos_img_cat').click(function(){
            var catid = (this.id).split('_')[1]; 
            $('#search_item_category_id').val(catid);
            $('#search_submit_btn').trigger('click');
            $('#item_search_modal').modal({backdrop: 'static', keyboard: false });  
        });
        
        
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