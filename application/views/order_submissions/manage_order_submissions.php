<?php
	
	$result = array(
                        'id'=>"",
                        'craftman_id'=>"",  
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'return_date'=>date('m/d/Y'),
                        'submission_date'=>date('m/d/Y'),
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
   
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Craftman<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('craftman_id',$craftman_list,set_value('craftman_id'),' class="form-control select2" data-live-search="true" id="craftman_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Subm Date<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('submission_date',set_value('submission_date',$result['submission_date']),' class="form-control datepicker" readonly id="submission_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Ret . Date<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('return_date',set_value('return_date',$result['return_date']),' class="form-control datepicker" readonly id="return_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                 
                            </div> 
                        </div>
                        <div class="row"> 
                            <div id="result_search"></div>
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Filter Order Items</h4> 
                                    <div class="row col-md-12 ">  
                                        
                                        <div class="col-md-3 col-md-offset-1">  
                                                <div class="form-group pad">
                                                    <label for="sales_order_no">Order No</label>
                                                    <?php  echo form_input('sales_order_no',set_value('sales_order_no'),' class="form-control" id="sales_order_no" placeholder="Search by Order Number"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="category_id">Category</label>
                                                    <?php  echo form_dropdown('category_id',$item_category_list,set_value('category_id'),' class="form-control select2" data-live-search="true" id="category_id"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="so_from_date">Order delivery from<input type="checkbox" name="so_from_date_check" id="so_from_date_check" value="1"></label>
                                                    <?php  echo form_input('so_from_date',set_value('so_from_date',date('m/d/Y',strtotime("-40 day"))),' class="form-control datepicker" readonly  id="so_from_date"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="sales_order_no">Order delivery to <input type="checkbox" name="so_to_date_check" id="so_to_date_check" value="1"></label>
                                                    <?php  echo form_input('so_to_date',set_value('so_to_date',date('m/d/Y',strtotime("+10 day"))),' class="form-control datepicker" readonly  id="so_to_date"');?>
                                                </div> 
                                        </div>   
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="search_order_btn" class="btn-default btn add_item_inpt pad"><span class="fa fa-search"></span> Search
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped fl_scrollable">
                                        <thead>
                                           <tr> 
                                               <th width="12%"  style="text-align: center;">Order No</th> 
                                               <th width="9%"  style="text-align: center;">Order Date</th> 
                                               <th width="9%"  style="text-align: center;">Required Date</th> 
                                               <th width="9%"  style="text-align: center;">Order ItemCode</th> 
                                               <th width="15%" style="text-align: center;">Item Desc</th> 
                                               <th width="20%" style="text-align: center;">Description</th> 
                                               <th width="8%" style="text-align: center;">Weight</th> 
                                               <th width="10%" style="text-align: right;">Amount</th>   
                                               <th width="15%" style="text-align: right;">Total</th> 
                                               <th width="5%" style="text-align: center;"><input type="checkbox" value="1" id="selectall_tick">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody id="top_rows_restbl">.
                                       </tbody>
                                       <tbody id="bottom_rows_restbl" >
                                           
                                       </tbody>
                                       <tfoot>  
                                            <tr>
                                                <th colspan="6"></th>
                                                <th  style="text-align: center;"><input hidden value="0" name="weight_total" id="weight_total"><span id="weight_tot">0</span></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="order_total" id="order_total"><span id="so_total">0</span></th>
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
                                <button id="place_invoice" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i>Confirm Submission</button>
                
                            </div>
                        </div>
                    </div>
                
              </div>
    </section>      
                            
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('action',$action); ?>
                            <?php if(isset($no_menu) && $no_menu==1)echo form_hidden('no_menu',$no_menu); ?>
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
                    $('#search_order_btn').trigger('click');
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
    $('#sales_order_no').focus();
    $('#search_order_btn').click(function(){ 
        get_inv_items_res()
    });
    
     $("#place_invoice").click(function(){
          if(!confirm("click ok to Confirm the Form Submission.")){
                return false;
            }else{
                if($('input[name^="inv_items_btm"]').length<=0){
                    fl_alert('info',"Atleast one item need to create an Credit Note!")
                    return false;
                }
            }
    });
    $('#selectall_tick').change(function(){ 
       
            if($('#selectall_tick').prop('checked')==true){ 
                $('.add_res_row').each(function() {
                    if($(this).is(":visible")){ 
                        $(this).trigger('click'); 
                    }
                }); 
            }else{
                $('.remove_res_row').trigger('click');
            }
        });
});

function get_inv_items_res(){
    
        var post_data = jQuery('#form_search').serializeArray(); 
        post_data.push({name:"function_name",value:'get_search_res_order_items'});
    
        $.ajax({
                url: "<?php echo site_url($this->router->fetch_class().'/fl_ajax');?>",
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
                                    console.log(elment); 
//                                    fl_alert('info',elment.item_quantity)
                                    var order_date = timeConverter(elment.order_date); 
                                    var required_date = timeConverter(elment.required_date); 
                                    var sub_tot = parseFloat(elment.units)* parseFloat(elment.unit_price);
                                    
                                    var exist_check = $("[name='inv_items_btm["+elment.id+"][order_no]']").val();
                                    var hid_var = ' ';
                                    if(typeof(exist_check) != "undefined"){
                                       hid_var = 'hidden'; 
                                    }
                                    var newRow = '<tr '+hid_var+' id="rowb_'+elment.id+'">'+
                                                        '<td style="text-align: center;">'+elment.sales_order_no+'<input hidden id="'+elment.id+'_order_no" value="'+elment.sales_order_no+'"><input hidden id="'+elment.id+'_order_id" value="'+elment.sales_order_id+'"></td>'+
                                                        '<td style="text-align: center;">'+order_date+'<input hidden  id="'+elment.id+'_sales_order_date" value="'+elment.order_date+'"></td>'+
                                                        '<td style="text-align: center;">'+required_date+'<input hidden  id="'+elment.id+'_required_date" value="'+elment.required_date+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.item_code+'<input hidden id="'+elment.id+'_item_code" value="'+elment.item_code+'"><input hidden id="'+elment.id+'_item_id" value="'+elment.item_id+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.item_desc+'<input hidden id="'+elment.id+'_item_description" value="'+elment.item_desc+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.description+'<input hidden id="'+elment.id+'_item_description_note" value="'+elment.description+'"></td>'+
                                                        '<td style="text-align: right;">'+elment.units+' '+elment.unit_abbreviation+((elment.secondary_unit_uom_id<0)?(' | '+elment.secondary_unit+' '+elment.unit_abbreviation_2):'')+'<input hidden  id="'+elment.id+'_item_quantity" value="'+elment.units+'">'+
                                                        '<input hidden  id="'+elment.id+'_uom_id" value="'+elment.unit_uom_id+'"><input hidden  id="'+elment.id+'_uom_abr" value="'+elment.unit_abbreviation+'">'+
                                                        '<input hidden  id="'+elment.id+'_uom_id_2" value="'+elment.secondary_unit_uom_id+'"><input hidden  id="'+elment.id+'_uom_abr_2" value="'+elment.unit_abbreviation_2+'"></td>';
                                        
                                            newRow +=  '<td style="text-align: right;">'+parseFloat(elment.unit_price).toFixed(2)+'<input hidden  step=".001"  type="number" id="'+elment.id+'_unit_price"  value="'+parseFloat(elment.unit_price).toFixed(2)+'"></td>'+
                                                       '<td style="text-align: right;"><b>'+sub_tot.toFixed(2)+'<input hidden id="'+elment.id+'_sub_tot" value="'+sub_tot+'"></b></td>'+
                                                       '<td><span  id="'+elment.id+'" class="btn btn-success fa fa-plus add_res_row"></span></td>'+
                                                  '</tr>';
                                    jQuery('#bottom_rows_restbl').append(newRow); 
                                    calc_tots_osub()
                             });
                             
                                    $('.add_res_row').click(function(){
                                        
                                        var add_id = this.id;
                                        var add_order_no = $("#"+add_id+"_order_no").val()
                                        var add_order_id = $("#"+add_id+"_order_id").val()
                                        var add_order_date = $("#"+add_id+"_sales_order_date").val()
                                        var add_required_date = $("#"+add_id+"_required_date").val()
                                        var add_item_code = $("#"+add_id+"_item_code").val()
                                        var add_item_id = $("#"+add_id+"_item_id").val()
                                        var add_item_description = $("#"+add_id+"_item_description").val()
                                        var add_item_description_note = $("#"+add_id+"_item_description_note").val()
                                        var add_unit_price = $("#"+add_id+"_unit_price").val() 
                                        var add_item_quantity = $("#"+add_id+"_item_quantity").val()
                                        var add_sales_order_date =  timeConverter($("#"+add_id+"_sales_order_date").val());

                                        var add_uom_id = $("#"+add_id+"_uom_id").val();
                                        var add_uom_id_2 = (typeof $("#"+add_id+"_uom_id_2").val()!== 'undefined')?$("#"+add_id+"_uom_id_2").val():0;
 
                                        var add_uom_abr =  $("#"+add_id+"_uom_abr").val();
                                        var add_uom_abr_2 =  (typeof $("#"+add_id+"_uom_abr_2").val()!== 'undefined')?$("#"+add_id+"_uom_abr_2").val():0;
                                       
                                        var add_sub_tot = parseFloat(add_item_quantity)* (parseFloat(add_unit_price));
//                                     fl_alert('info',add_uom_abr_2) 
                                        var newRow = '<tr id="rowt_'+add_id+'">'+
                                                        '<td style="text-align: center;">'+add_order_no+'<input hidden name="inv_items_btm['+add_id+'][order_no]" value="'+add_order_no+'"><input hidden name="inv_items_btm['+add_id+'][order_id]" value="'+add_order_id+'"></td>'+
                                                        '<td style="text-align: center;">'+add_sales_order_date+'<input hidden name="inv_items_btm['+add_id+'][sales_order_date]" value="'+add_order_date+'"></td>'+
                                                        '<td style="text-align: center;">'+add_required_date+'<input hidden name="inv_items_btm['+add_id+'][required_date]" value="'+add_required_date+'"></td>'+
                                                        '<td style="text-align: center;">'+add_item_code+'<input hidden name="inv_items_btm['+add_id+'][item_code]" value="'+add_item_code+'"><input hidden name="inv_items_btm['+add_id+'][item_id]" value="'+add_item_id+'"></td>'+
                                                        '<td style="text-align: center;">'+add_item_description+'<input hidden name="inv_items_btm['+add_id+'][item_description]" value="'+add_item_description+'"></td>'+
                                                        '<td style="text-align: center;">'+add_item_description_note+'<input hidden name="inv_items_btm['+add_id+'][item_description_note]" value="'+add_item_description_note+'"></td>'+
                                                        '<td style="text-align: right;">'+add_item_quantity+' '+add_uom_abr+'<input hidden id="qty_'+add_id+'" class="tot_weight1" name="inv_items_btm['+add_id+'][item_quantity]" value="'+add_item_quantity+'"></td>'+
                                                        '<td style="text-align: right;">'+parseFloat(add_unit_price).toFixed(2)+'<input hidden name="inv_items_btm['+add_id+'][unit_price]" value="'+parseFloat(add_unit_price).toFixed(2)+'"></td>'+
                                                        '<td style="text-align: right;"><b>'+add_sub_tot.toFixed(2)+'<input hidden name="inv_items_btm['+add_id+'][sub_tot]" class="tot_amount1" id="remove_subtot_'+add_id+'" value="'+add_sub_tot+'"></b></td>'+
                                                        '<td><span  id="add_'+add_id+'" class="btn btn-danger fa fa-trash remove_res_row"></span>'+'<input hidden id="add_'+add_id+'_remove" value="'+add_id+'"></td>'+
                                                  '</tr>';
                                            jQuery('#top_rows_restbl').append(newRow); 
                                            
                                                    calc_tots_osub()
                                            
                                            $('#rowb_'+add_id).hide();
                                              
                                            $('.remove_res_row').click(function(){
                                                var rmv_id = $('#'+this.id+"_remove").val();
                                                 
                                                    $('#rowt_'+rmv_id).remove();
                                                    $('#rowb_'+rmv_id).show();
                                                    
                                                    calc_tots_osub()
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

function calc_tots_osub(){
    var fin_tot = 0;
    var weight_tot = 0;
    $('input[class^="tot_amount1"]').each(function() {
        fin_tot = fin_tot + parseFloat($(this).val());
    }); 
    $('#order_total').val(fin_tot);
    $('#so_total').text(fin_tot.toFixed(2));
    
    $('.tot_weight1').each(function() {
//        fl_alert('info',this.id)
        weight_tot = weight_tot + parseFloat($(this).val());
    }); 
    $('#weight_total').val(weight_tot);
    $('#weight_tot').text(weight_tot.toFixed(2)+" g");
} 
</script>
 