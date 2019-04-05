<?php
	
	$result = array(
                        'id'=>"",
                        'location_id'=>"",  
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'return_date'=>date('m/d/Y'),
                        'issue_date'=>date('m/d/Y'),
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Location<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_dropdown('location_id',$location_list,set_value('location_id'),' class="form-control select2" data-live-search="true" id="location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Issue Date<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_input('issue_date',set_value('issue_date',$result['issue_date']),' class="form-control datepicker" readonly id="issue_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-3">
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Ret . Date<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_input('return_date',set_value('return_date',$result['return_date']),' class="form-control datepicker" readonly id="return_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                 
                            </div> 
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Issue Type<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_dropdown('gem_issue_type_id',$gem_issue_type_list,set_value('gem_issue_type_id'),' class="form-control select2" data-live-search="true" id="gem_issue_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                        </div>
                        <div hidden id="lapidrist_div" class="row">
                            <div class="col-md-12"><h4> Lapidarist</h4></div>
                             <div hiiden id="gem_cutter_div" class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Gem Cutter<span style="color: red">*</span></label>
                                    <div class="col-md-7">    
                                         <?php  echo form_dropdown('gem_cutter_id',$cutter_list,set_value('gem_cutter_id'),' class="form-control select2 " data-live-search="true" id="gem_cutter_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                    <div class="col-md-1" style="padding-left: 0px">  <a id="cutter_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>
                                </div>  
                            </div>
                             <div hiiden id="polishing_div" class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Polishing<span style="color: red">*</span></label>
                                    <div class="col-md-7">    
                                         <?php  echo form_dropdown('gem_polishing_id',$polishing_list,set_value('gem_polishing_id'),' class="form-control select2" data-live-search="true" id="gem_polishing_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                    <div class="col-md-1" style="padding-left: 0px">  <a id="polish_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>
                                </div>  
                            </div>
                             <div hiiden id="heater_div" class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Heater<span style="color: red">*</span></label>
                                    <div class="col-md-7">    
                                         <?php  echo form_dropdown('gem_heater_id',$heater_list,set_value('gem_heater_id'),' class="form-control select2" data-live-search="true" id="gem_heater_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                    <div class="col-md-1" style="padding-left: 0px">  <a id="heater_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>>
                                </div>  
                            </div>
                             <div hiiden id="lab_div" class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Laboratory<span style="color: red">*</span></label>
                                    <div class="col-md-7">    
                                         <?php  echo form_dropdown('gem_lab_id',$lab_list,set_value('gem_lab_id'),' class="form-control select2" data-live-search="true" id="gem_lab_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                    <div class="col-md-1" style="padding-left: 0px">  <a id="lab_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>
                                </div>  
                            </div>
                        </div>
                        <div class="row"> 
                            <div id="result_search"></div>
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Filter Gems for issue</h4> 
                                    <div class="row col-md-12 ">  
                                        
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="item_code">Code</label>
                                                    <?php  echo form_input('item_code',set_value('item_code'),' class="form-control" id="item_code" placeholder="Search by Item Code"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="category_id">Variety</label>
                                                    <?php  echo form_dropdown('category_id',$item_category_list,set_value('category_id'),' class="form-control select2" data-live-search="true" id="category_id"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="weight_from">Weight from</label>
                                                    <?php  echo form_input('weight_from',set_value('weight_from'),' class="form-control "   id="weight_from"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="weight_to">Weight to  </label>
                                                    <?php  echo form_input('weight_to',set_value('weight_to'),' class="form-control"   id="weight_to"');?>
                                                </div> 
                                        </div> 
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="supplier_id">Supplier</label>
                                                    <?php  echo form_dropdown('supplier_id',$supplier_list,set_value('supplier_id'),' class="form-control select2" data-live-search="true" id="supplier_id"');?>
                                                </div> 
                                        </div> 
                                        <div class="col-md-1">  
                                                <div class="form-group pad">
                                                    <label for="result_count">Res. Count<input checked type="checkbox" name="res_count_check" id="res_count_check" value="1"></label>
                                                    <?php  echo form_input('result_count',set_value('result_count',25),' class="form-control"   id="result_count"');?>
                                                </div> 
                                        </div> 
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="search_items_btn" class="btn-default btn add_item_inpt pad"><span class="fa fa-search"></span> Search
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped fl_scrollable">
                                        <thead>
                                           <tr> 
                                               <th width="12%"  style="text-align: center;">Variety</th> 
                                               <th width="20%"  style="text-align: center;">Item Desc</th> 
                                               <th width="15%"  style="text-align: center;">Code</th> 
                                               <th width="13%"  style="text-align: center;">Color</th> 
                                               <th width="13%" style="text-align: center;">Shape</th> 
                                               <th width="18%" style="text-align: center;">Measurement(LxWxH)</th> 
                                               <th width="16%" style="text-align: center;">Weight</th> 
                                               <th width="5%" style="text-align: center;"><input type="checkbox" value="1" id="selectall_tick">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody id="top_rows_restbl">.
                                       </tbody>
                                       <tbody id="bottom_rows_restbl" >
                                           
                                       </tbody>
<!--                                       <tfoot>  
                                            <tr>
                                                <th colspan="6"></th>
                                                <th  style="text-align: center;"><input hidden value="0" name="weight_total" id="weight_total"><span id="weight_tot">0</span></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="order_total" id="order_total"><span id="so_total">0</span></th>
                                            </tr> 
                                       </tfoot>-->
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
                                <button id="submit_gem_issue" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i>Confirm Submission</button>
                
                            </div>
                        </div>
                    </div>
                
              </div>
    </section>      
                            
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('action',$action); ?>
                            <?php if(isset($no_menu) && $no_menu==1)echo form_hidden('no_menu',$no_menu); ?>
                            <?php echo form_close(); ?>               
                                
                         
                 
<?php $this->load->view('gem_issue//gem_issue_modals/add_dropdown_modal'); ?>           
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
                    $('#search_items_btn').trigger('click');
//                fl_alert('info',)
//              }
            $('#item_code').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
            $('#submit_gem_issue').trigger('click');
        }
    });
$(document).ready(function(){ 
    $('#sales_order_no').focus();
    $('#search_items_btn').click(function(){ 
        get_inv_items_res()
    });
    
     $("#submit_gem_issue").click(function(){
         if($('#gem_issue_type_id').val()==""){
             fl_alert('warning','Please select Issue Type!');
            return false; 
         } 
          if(!confirm("click ok to Confirm the Form Submission.")){
                return false;
            }else{
                if($('input[name^="inv_items_btm"]').length<=0){
                    fl_alert('info',"Atleast one item need to create an Credit Note!")
                    return false;
                }
            }
    });
    $('#gem_issue_type_id').change(function(){ 
        var gi_type = $('#gem_issue_type_id').val();
        if(gi_type!=""){ $('#lapidrist_div').show() }
        $('#gem_cutter_div').hide();
        $('#heater_div').hide();
        $('#polishing_div').hide();
        $('#lab_div').hide();
        switch(gi_type){
            case '1': $('#gem_cutter_div').show(); break; //facetting
            case '2': $('#lab_div').show(); break; //Verbal Check
            case '3': $('#heater_div').show(); break; //Heat Process
            case '4': $('#gem_cutter_div').show(); break; //Cut Process
            case '5': $('#polishing_div').show(); break; //Polishing Process
            case '6': $('#gem_cutter_div').show(); break; //Recut
            case '7': $('#lab_div').show(); break; //Cert lab
        }
        
        $('.select2').select2();
        
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
        post_data.push({name:"function_name",value:'get_search_res_available_items'});
    
        $.ajax({
                url: "<?php echo site_url($this->router->fetch_class().'/fl_ajax');?>",
                type: 'post',
                data : post_data,
                success: function(result){ 
                                
//                                    console.log(elment); 
//                                $("#result_search").html(result); return  false;
//                                    fl_alert('info',elment.item_quantity)
                                var res2 = JSON.parse(result);  
                                $('#bottom_rows_restbl tr').remove();
                                var rowCount = $('#bottom_rows_restbl tr').length;
                                var rowCount = rowCount+1;     
                                var total = 0;

                                $(res2).each(function (index, elment) {
//                                    console.log(elment);  
                                    var measurment ='';
                                    if(elment.length!='') measurment += ' '+((elment.length!='0')?elment.length+' ':'-'); 
                                    if(elment.width!='') measurment += ' x '+((elment.width!='0')?elment.width+' ':'-');
                                    if(elment.height!='') measurment += ' x '+((elment.height!='0')?elment.height+' ':'-');
                                    measurment += 'mm';
//                                    alert(measurment)
                                    var exist_check = $("[name='inv_items_btm["+elment.id+"][item_id]']").val(); 
                                    var hid_var = ' ';
                                    if(typeof(exist_check) != "undefined"){
                                       hid_var = 'hidden'; 
                                    }
                                    var newRow = '<tr '+hid_var+' id="rowb_'+elment.id+'" style="height:10px;" >'+
                                                        '<td style="text-align: center;">'+elment.item_category_name+'<input hidden id="'+elment.id+'_cat_id" value="'+elment.item_category_id+'">'+
                                                            '<input hidden id="'+elment.id+'_cat_name" value="'+elment.item_category_name+'">'+
                                                            '<input hidden id="'+elment.id+'_item_id" value="'+elment.item_id+'">'+
                                                            '<input hidden id="'+elment.id+'_certification_no" value="'+elment.certification_no+'">'+
                                                            '<input hidden id="'+elment.id+'_certification" value="'+elment.certification+'">'+
                                                            '<input hidden id="'+elment.id+'_treatment" value="'+elment.treatment+'">'+
                                                            '<input hidden id="'+elment.id+'_origin" value="'+elment.origin+'">'+
                                                        '</td>'+
                                                        '<td style="text-align: center;">'+elment.item_name+'<input hidden  id="'+elment.id+'_item_name" value="'+elment.item_name+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.item_code+'<input hidden  id="'+elment.id+'_item_code" value="'+elment.item_code+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.color_val+'<input hidden id="'+elment.id+'_color_dd_id" value="'+elment.color+'"><input hidden id="'+elment.id+'_color_dd_val" value="'+elment.color_val+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.shape_val+'<input hidden id="'+elment.id+'_shape_dd_id" value="'+elment.shape+'"><input hidden id="'+elment.id+'_shape_dd_val" value="'+elment.shape_val+'"></td>'+
                                                        '<td style="text-align: center;">'+measurment+'<input hidden id="'+elment.id+'_measurment" value="'+measurment+'"><input hidden id="'+elment.id+'_height" value="'+elment.height+'"><input hidden id="'+elment.id+'_width" value="'+elment.width+'"><input hidden id="'+elment.id+'_length" value="'+elment.length+'"></td>'+
                                                        '<td style="text-align: right;">'+elment.units_available+' '+elment.uom_name+((elment.uom_id_2>0)?(' | '+elment.units_available_2+' '+elment.uom_name_2):'')+'<input hidden  id="'+elment.id+'_item_quantity" value="'+elment.units_available+'"><input hidden  id="'+elment.id+'_item_quantity_2" value="'+elment.units_available_2+'">'+
                                                            '<input hidden  id="'+elment.id+'_uom_id" value="'+elment.uom_id+'"><input hidden  id="'+elment.id+'_uom_abr" value="'+elment.uom_name+'">'+
                                                            '<input hidden  id="'+elment.id+'_uom_id_2" value="'+elment.uom_id_2+'"><input hidden  id="'+elment.id+'_uom_abr_2" value="'+elment.uom_name_2+'"></td>';
                                        
                                            newRow +=  '<td><span  id="'+elment.id+'" class="btn btn-success btn-sm fa fa-plus add_res_row"></span></td>'+
                                                  '</tr>';
                                    jQuery('#bottom_rows_restbl').append(newRow); 
//                                    calc_tots_osub()
                             });
                             
                                    $('.add_res_row').click(function(){
                                        
                                        var add_id = this.id;
                                        var add_cat_id = $("#"+add_id+"_cat_id").val()
                                        var add_cat_name = $("#"+add_id+"_cat_name").val()
                                        var add_item_code = $("#"+add_id+"_item_code").val()
                                        var add_item_id = $("#"+add_id+"_item_id").val()
                                        var add_item_name = $("#"+add_id+"_item_name").val() 
                                        var add_color_dd_id= $("#"+add_id+"_color_dd_id").val() 
                                        var add_color_dd_val= $("#"+add_id+"_color_dd_val").val() 
                                        var add_shape_dd_id= $("#"+add_id+"_shape_dd_id").val() 
                                        var add_shape_dd_val= $("#"+add_id+"_shape_dd_val").val() 
                                        var add_length = $("#"+add_id+"_length").val() 
                                        var add_width = $("#"+add_id+"_width").val() 
                                        var add_height = $("#"+add_id+"_height").val() 
                                        var add_measurment = $("#"+add_id+"_measurment").val(); 
                                        
                                        var add_certification_no = $("#"+add_id+"_certification_no").val() 
                                        var add_certification = $("#"+add_id+"_certification").val() 
                                        var add_treatment = $("#"+add_id+"_treatment").val() 
                                        var add_origin = $("#"+add_id+"_origin").val() 
                                        var add_unit_price = $("#"+add_id+"_unit_price").val() 
                                        var add_item_quantity = $("#"+add_id+"_item_quantity").val() 
                                        var add_item_quantity_2 = $("#"+add_id+"_item_quantity_2").val() 

                                        var add_uom_id = $("#"+add_id+"_uom_id").val();
                                        var add_uom_id_2 = (typeof $("#"+add_id+"_uom_id_2").val()!== 'undefined')?$("#"+add_id+"_uom_id_2").val():0;
 
                                        var add_uom_abr =  $("#"+add_id+"_uom_abr").val();
                                        var add_uom_abr_2 =  (typeof $("#"+add_id+"_uom_abr_2").val()!== 'undefined')?$("#"+add_id+"_uom_abr_2").val():0;
                                        
                                        
//                                     fl_alert('info',add_uom_abr_2) 
                                        var newRow = '<tr id="rowt_'+add_id+'" style="background:#adffaf;">'+
                                                        '<td style="text-align: center;">'+add_cat_name+'<input hidden name="inv_items_btm['+add_id+'][category_id]" value="'+add_cat_id+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][item_category_name]" value="'+add_cat_name+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][item_id]" value="'+add_item_id+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][certification_no]" value="'+add_certification_no+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][certification]" value="'+add_certification+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][treatment]" value="'+add_treatment+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][origin]" value="'+add_origin+'">'+
                                                        '</td>'+
                                                        
                                                        '<td style="text-align: center;">'+add_item_name+'<input hidden name="inv_items_btm['+add_id+'][item_name]" value="'+add_item_name+'"></td>'+
                                                        '<td style="text-align: center;">'+add_item_code+'<input hidden name="inv_items_btm['+add_id+'][item_code]" value="'+add_item_code+'"></td>'+
                                                        '<td style="text-align: center;">'+add_color_dd_val+'<input hidden name="inv_items_btm['+add_id+'][color_dd_id]" value="'+add_color_dd_id+'"><input hidden name="inv_items_btm['+add_id+'][color_dd_val]"  value="'+add_color_dd_val+'"></td>'+
                                                        '<td style="text-align: center;">'+add_shape_dd_val+'<input hidden name="inv_items_btm['+add_id+'][shape_dd_id]" value="'+add_shape_dd_id+'"><input hidden name="inv_items_btm['+add_id+'][shape_dd_val]" value="'+add_shape_dd_val+'"></td>'+
                                                        '<td style="text-align: center;">'+add_measurment+'<input hidden name="inv_items_btm['+add_id+'][height]" value="'+add_height+'"><input hidden name="inv_items_btm['+add_id+'][width]" value="'+add_width+'"><input hidden name="inv_items_btm['+add_id+'][length]" value="'+add_length+'"></td>'+
                                                        '<td style="text-align: right;">'+add_item_quantity+' '+add_uom_abr+((add_uom_id>0)?(' | '+add_item_quantity_2+' '+add_uom_abr_2):'')+'<input hidden name="inv_items_btm['+add_id+'][item_quantity]" value="'+add_item_quantity+'"><input hidden name="inv_items_btm['+add_id+'][item_quantity_2]" value="'+add_item_quantity_2+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][uom_id]" value="'+add_uom_id+'"><input hidden name="inv_items_btm['+add_id+'][unit_abr]" value="'+add_uom_abr+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][uom_id_2]" value="'+add_uom_id_2+'"><input hidden name="inv_items_btm['+add_id+'][unit_abr_2]" value="'+add_uom_abr_2+'"></td>'+
                                                        '<td><span  id="add_'+add_id+'" class="btn btn-danger fa fa-trash remove_res_row"></span>'+'<input hidden id="add_'+add_id+'_remove" value="'+add_id+'"></td>'+
                                                  '</tr>';
                                            jQuery('#top_rows_restbl').append(newRow); 
                                             
                                            
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
 