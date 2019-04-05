<?php
	
	$result = array(
                        'id'=>"",   
                        'to_location_id'=>"", 
                        'from_location_id'=>"",
                        'transfer_date'=>date('m/d/Y'),
                        'memo'=>"",
                        'reference'=> 'TR-'.date('Ymd-Hi'),
                        'item_quantity'=>1,
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


<?php // echo '<pre>'; print_r($loca); die;?>

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
                                    <label class="col-md-3 control-label">From <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('from_location_id',$location_list,set_value('from_location_id',$result['from_location_id']),' class="form-control select2" data-live-search="true" id="from_location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>   
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">To<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('to_location_id',$location_list,set_value('to_location_id',$result['to_location_id']),' class="form-control select2" data-live-search="true" id="to_location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div>
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('transfer_date',set_value('transfer_date',$result['transfer_date']),' class="form-control datepicker" readonly id="transfer_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('transfer_date');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                        <div class="row"> 
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Add Item to Transfer</h4> 
                                    <div class="row col-md-12 ">
                                        <div id="first_col_form" class="col-md-1 col-md-offset-2">
                                            <div class="form-group pad">
                                                <label for="item_code">Item Code</label>
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
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="add_item_btn" class="btn-default btn add_item_inpt pad">Add</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div id="list_table" class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped">
                                        <thead>
                                           <tr> 
                                               <th width="5%"  style="text-align: center;">#</th> 
                                               <th width="15%"  style="text-align: center;">Item Code</th> 
                                               <th width="40%" style="text-align: center;">Item Description</th> 
                                               <th width="20%" style="text-align: center;">Quantity</th>  
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
                                                <th colspan="1"></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="" name="invoice_total" id="invoice_total"><span id="inv_total"><?php echo number_format(0,2);?></span></th>
                                            </tr> 
                                       </tfoot>
                                        </table>
                                </div>
                                <div id="search_result_1"></div>
                            </div>
                            
                            <div class="col-md-12">
                                <br>
                                <button id="confirm_transfer" class="btn btn-app pull-right  primary <?php echo $view;?>"><i class="fa fa-check"></i><?php echo constant($action);?>  Transfer</button>
                
                            </div>
                        </div>
                        
                    </div>
                
              </div>
    </section>      
 
                 
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('so_id', isset($so_data['id'])?$so_data['id']:""); ?>
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
            $('#item_code').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
          
//                $('#confirm_transfer').trigger('click');
            if (($("#checkout_modal").data('bs.modal') || {isShown: false}).isShown) {
                $('#confirm_checkout').trigger('click');    
            }else{
                $('#confirm_transfer').trigger('click');
            }
        }
    });
$(document).ready(function(){
     
    $('#item_code').focus();
    $('.select2').on("select2:close", function () { $(this).focus(); });
     
    $("#item_code").keyup(function(){ 
	get_item_dets(this.id);
    });
    $("#from_location_id").change(function(){ 
	get_item_dets($("#item_code").val());
    });
	 
    $("#item_desc").on("change focus",function(){
        if(event.type == "focus")
             $("#item_code").val($('#item_desc').val());
            get_item_dets(this.id);
    });
    $("#confirm_transfer").click(function(){
        if($('#from_location_id').val() == $('#to_location_id').val()){
            fl_alert('info',"Destinations should be differ from from Location!");
            return false;
        }
//        fl_alert('info',)
        if($('input[name^="inv_items"]').length<=0){
            fl_alert('info',"Atleast one item need to create an invoice!")
            return false;
        }else{
            if(!confirm("Click ok confirm your from submission.")){
            return false;
        }
        }
//            return false;
    });
      
    $("#add_item_btn").click(function(){
         $.ajax({
			url: "<?php echo site_url('Location_transfer/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(),location_id:$('#from_location_id').val()},
			success: function(result){
                            set_list_items(result);
                        }
		});
    });
	
	
    $("#item_code").val($('#item_desc').val());
    $('#item_code').trigger('keyup'); 
     
          //delete row
    $('.del_btn_inv_row').click(function(){
    
//                                    if(!confirm("click ok Confirm remove this item.")){
//                                        return false;
//                                    }
        var tot_amt = 0;
        $(this).closest('tr').remove();  
    });
});

	function get_item_dets(id1=''){ //id1 for input element id
            $.ajax({
			url: "<?php echo site_url('Location_transfer/fl_ajax?function_name=get_single_item');?>",
			type: 'post',
			data : {function_name:'get_single_item', item_code:$('#item_code').val(),location_id:$('#from_location_id').val()},
			success: function(result){
//                            $("#search_result_1").html(result);
                            var res1 = JSON.parse(result);
                            
                            $('#first_col_form').removeClass('col-md-offset-3');
                            var div_str = '<div class="col-md-2">'+
                                                    '<div class="form-group pad">'+
                                                        '<label for="item_quantity">Units <span id="unit_abbr">[Each]<span></label>'+
                                                        '<input type="number" min="0"  step=".001" name="item_quantity" class="form-control add_item_inpt" id="item_quantity" placeholder="Enter Quantity">'+
                                                    '</div>'+
                                                '</div>';
                            if(res1.item_uom_id_2!=0){
                                    div_str = div_str + '<div class="col-md-2">'+
                                                            '<div class="form-group pad">'+
                                                                '<label for="item_quantity_2">Units 2 <span id="unit_abbr_2">[Each]<span></label>'+
                                                                '<input type="number" min="0"  step=".001" name="item_quantity_2" class="form-control add_item_inpt" value="1" id="item_quantity_2" placeholder="Enter Quantity">'+
                                                            '</div>'+
                                                        '</div>';
                                    
                            }else{
                                $('#first_col_form').addClass('col-md-offset-3')
                            }
                            $('#uom_div').html(div_str);
                            if(typeof(res1.id) != "undefined" && res1.id !== null) { 
                                if(id1!='item_desc'){$('#item_desc').val(res1.item_code).trigger('change');}
                                if(id1!='item_code'){ $('#item_code').val(res1.item_code);}
                                (res1.price_amount==null)? $('#item_unit_cost').val(0):$('#item_unit_cost').val(res1.price_amount);
                                $('#unit_abbr').text('['+res1.stock.units_available+' '+res1.unit_abbreviation+']');
                                $('#unit_abbr_2').text('['+res1.stock.units_available_2+' '+res1.unit_abbreviation_2+']');
//                                $('#item_discount').val(0);
                                $('#item_quantity').val(res1.stock.units_available);
                                $('#item_quantity_2').val(res1.stock.units_available_2);
                                if(parseFloat(res1.stock.units_available)<=0){
                                    fl_alert("warning","This item has not in stock at current location!");
                                }
                                $("#result_search").html(result);
                            }
                        }
		});
	}
        
        function set_list_items(result){ 
//                            $("#search_result_1").html(result);
                                    var res2 = JSON.parse(result); 
                                    var item_qty1 = $('#item_quantity').val();
                                    var item_qty2 = $('#item_quantity_2').val();
                                    var item_code1 = $('#item_code').val();  
                                 
                                
//                                    return false;
//                                $("#search_result_1").html(result); 
                                if(parseFloat(res2.stock.units_available)<parseFloat(item_qty1) || parseFloat(res2.stock.units_available_2)<parseFloat(item_qty2) ){
                                    fl_alert('info','Please check the Item line Quantity.');
                                    return false;
                                }
                                
                                if(res2.item_code==null){
                                    fl_alert('info','Item invalid! Please recheck before add.');
                                    return false;
                                }
                                var rowCount = $('#invoice_list_tbl tr').length+'_'+item_code1; 
                                
//                                var item_total = qtyXprice;
                                
                                
                                var row_str = '<tr style="padding:10px" id="tr_'+rowCount+'">'+ 
                                                        '<td><span id="'+rowCount+'_row_cntr" class="row_counter_cls"></span></td>'+
                                                        '<td><input class="itemcode_cls" hidden name="inv_items['+rowCount+'][item_code]" value="'+item_code1+'">'+item_code1+'</td>'+
                                                        '<td><input hidden name="inv_items['+rowCount+'][item_desc]" value="'+res2.item_name+'"><input hidden name="inv_items['+rowCount+'][item_id]" value="'+res2.id+'">'+res2.item_name+'</td>'+
                                                        '<td align="center"><input hidden name="inv_items['+rowCount+'][item_quantity]" value="'+item_qty1+'"><input hidden name="inv_items['+rowCount+'][item_quantity_2]" value="'+((item_qty2==null)?0:item_qty2)+'">'+
                                                        '<input hidden name="inv_items['+rowCount+'][unit_abbreviation]" value="'+res2.unit_abbreviation+'"><input hidden name="inv_items['+rowCount+'][item_quantity_uom_id]" value="'+res2.item_uom_id+'"><input hidden name="inv_items['+rowCount+'][item_quantity_uom_id_2]" value="'+res2.item_uom_id_2+'">'+
                                                                                                                                                                                                                                                                                item_qty1+' '+res2.unit_abbreviation;
                                if(res2.unit_abbreviation_2!=null && res2.unit_abbreviation_2!=0){
                                    row_str = row_str + ' | ' + item_qty2+' '+res2.unit_abbreviation_2+'<input hidden name="inv_items['+rowCount+'][unit_abbreviation_2]" value="'+res2.unit_abbreviation_2+'">';
                                }                                                                                                                                                                                                                                                                        
                                row_str = row_str + '</td><td width="5%"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
                                                    '</tr>';
                                var newRow = $(row_str);
                                
                                var exist_item=0;
                                $('.itemcode_cls').each(function(){
                                    if(this.value == item_code1){
                                        fl_alert('warning',"This Item already added to list!")
                                        exist_item = 1;
                                    }
                                });
                                if(exist_item==0){
                                    jQuery('table#invoice_list_tbl ').prepend(newRow);
                                }
                                
                                //set row sew no
                                var seq_no=1;
                                $($('.row_counter_cls').get().reverse()).each(function(){
                                  $('#'+(this.id)).text(seq_no); seq_no++;
                                }); 

                                //delete row
                                $('.del_btn_inv_row').click(function(){ 
                                    $(this).closest('tr').remove();   
                                }); 
                                
        } 
</script>
 