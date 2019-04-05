<?php
//	echo '<pre>';        print_r($this->session->userdata(SYSTEM_CODE)['default_currency']); die;
	$result = array(
                        'id'=>"",
                        'entry_date'=>date('m/d/Y'),
                        'quick_entry_account_id'=>'',
                        'memo'=>'', 
                        'amount'=>0, 
                        'currency_code'=>$this->session->userdata(SYSTEM_CODE)['default_currency'], 
                        'status'=>1,
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
              
            <?php echo form_open("Quick_entries/validate", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12">
                                    
                                    <h4 class="">Add Expense entry</h4> 
                                    <table id="example1" class="table bg-gray-light table-bordered table-striped">
                                        <thead>
                                           <tr>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="entry_date">Date</label>
                                                        <?php  echo form_input('entry_date',set_value('entry_date',$result['entry_date']),'readonly class="form-control datepicker add_item_inpt" data-live-search="true" id="entry_date"');?>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="quick_entry_account_id">Account</label>
                                                        <?php  echo form_dropdown('quick_entry_account_id',$quick_entry_acc_list,set_value('quick_entry_account_id'),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="quick_entry_account_id"');?>
                                                    </div>
                                                    </div>
                                               </td> 
                                               
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="memo">Memo</label>
                                                        <?php  echo form_input('memo',set_value('memo',$result['memo']),' class="form-control  add_item_inpt"  id="memo" placeholder="Have any note"');?>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="currency_code">Currency</label>
                                                        <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control add_item_inpt select2" style="width:100%;" data-live-search="true" id="currency_code"');?>
                                                    </div>
                                                    </div>
                                               </td> 
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="amount">Amount</label>
                                                        <input type="number" min="0"  step=".001" name="amount" class="form-control add_item_inpt" id="amount" value="<?php echo $result['amount'];?>" placeholder="Enter Amount ">
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
                                               <th width="10%"  style="text-align: center;">Date</th> 
                                               <th width="20%" style="text-align: left;">Entry Account</th>  
                                               <th width="15%" style="text-align: left;">Memo</th> 
                                               <th width="15%" style="text-align: center;">Currency</th> 
                                               <th width="15%" style="text-align: right;">Amount</th> 
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
                                            
                                            <tr hidden>
                                                <th colspan="2"></th>
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
//            $('#entry_date').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
            $('#place_invoice').trigger('click');
        }
    });
$(document).ready(function(){
//    $('#entry_date').focus();
    $('.select2').on("select2:close", function () { $(this).focus(); });
    
//    get_results();  
        $("form").submit(function(){ 
                    if(!confirm("Click Ok to Confirm form Submition.")){
                           return false;
            }
        });
    $("#place_invoice").click(function(){
            if($('.itm_rows').length<=0){
                fl_alert('info',"Atleast one Entry need to initiate a transectons!")
                return false;
            }
    });
    
    $("#add_item_btn").click(function(){
        var rowCount = $('.itm_rows').length;
        var qe_id = $('#quick_entry_account_id').val();
        
        if(qe_id==""){
            fl_alert('info',"Please Select Quick Entry Account");
            return false;
        }
        if(parseFloat($('#amount').val())<=0){
            fl_alert('info',"Invalid amount");
            return false;
        } 
        
        var newRow = $('<tr class="itm_rows" style="padding:10px" id="tr_'+rowCount+'">'+
                            '<td>'+(rowCount)+'</td>'+
                            '<td><input hidden name="inv_items['+rowCount+'_'+qe_id+'][entry_date]" value="'+$('#entry_date').val()+'">'+$('#entry_date').val()+'</td>'+
                            '<td><input hidden name="inv_items['+rowCount+'_'+qe_id+'][quick_entry_account_id]" value="'+$('#quick_entry_account_id').val()+'">'+$('#quick_entry_account_id option:selected').text()+'</td>'+
                            '<td><input hidden name="inv_items['+rowCount+'_'+qe_id+'][memo]" value="'+$('#memo').val()+'">'+$('#memo').val()+'</td>'+
                            '<td align="center"><input  hidden name="inv_items['+rowCount+'_'+qe_id+'][currency_code]" value="'+$('#currency_code').val()+'">'+$('#currency_code').val()+'</td>'+
                            '<td align="right"><input class="item_tots" hidden name="inv_items['+rowCount+'_'+qe_id+'][amount]" value="'+$('#amount').val()+'">'+parseFloat($('#amount').val()).toFixed(2)+'</td>'+
                            '<td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                        '</tr>'); 
        jQuery('table#invoice_list_tbl ').append(newRow);
        var inv_total = parseFloat($('#invoice_total').val()) + parseFloat($('#amount').val());
        $('#amount').val(0);
        $('#invoice_total').val(inv_total.toFixed(2));
        $('#inv_total').text(inv_total.toFixed(2));
        
          
        //delete row
        $('.del_btn_inv_row').click(function(){
//            if(!confirm("click ok Confirm remove this Entry.")){
//                return false;
//            }
            var tot_amt = 0;
            $(this).closest('tr').remove(); 
            $('input[class^="item_tots"]').each(function() {
//                                        console.log(this);
                tot_amt = tot_amt + parseFloat($(this).val());
            });
            $('#invoice_total').val(tot_amt.toFixed(2));
            $('#inv_total').text(tot_amt.toFixed(2)); 
        }); 

        
        
    });
	 
});
 
</script>
 