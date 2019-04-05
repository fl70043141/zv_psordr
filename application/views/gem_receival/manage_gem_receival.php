<?php
	
	$result = array(
                        'id'=>"",
                        'location_id'=>"",  
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'recieve_date'=>date(SYS_DATE_FORMAT),  
                        'currency_code'=>$this->session->userdata(SYSTEM_CODE)['default_currency'],
                        'payment_term_id'=>1, //cash
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
                                    <label class="col-md-4 control-label">Rec Location<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_dropdown('location_id',$location_list,set_value('location_id'),' class="form-control select2" data-live-search="true" id="location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Date<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_input('recieve_date',set_value('recieve_date',$result['recieve_date']),' class="form-control datepicker" readonly id="recieve_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div> 
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Currency<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Payment Term<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id',$result['payment_term_id']),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12"><h4> Lapidarist</h4></div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Issue Type<span style="color: red">*</span></label>
                                    <div class="col-md-8">    
                                         <?php  echo form_dropdown('gem_issue_type_id',$gem_issue_type_list,set_value('gem_issue_type_id'),' class="form-control select2" data-live-search="true" id="gem_issue_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>  
                                 
                            </div>
                            <div  hidden id="lapidrist_div"  class="col-md-9">
                                <div hidden id="gem_cutter_div" class="col-md-6">
                                   <div class="form-group">
                                       <label class="col-md-4 control-label">Gem Cutter<span style="color: red">*</span></label>
                                       <div class="col-md-7">    
                                            <?php  echo form_dropdown('gem_cutter_id',$cutter_list,set_value('gem_cutter_id'),' class="form-control select2 " data-live-search="true" id="gem_cutter_id"');?>
                                            <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                       </div> 
                                       <!--<div class="col-md-1" style="padding-left: 0px">  <a id="cutter_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>-->
                                   </div>  
                               </div>
                                <div hidden id="polishing_div" class="col-md-6">
                                   <div class="form-group">
                                       <label class="col-md-4 control-label">Polishing<span style="color: red">*</span></label>
                                       <div class="col-md-7">    
                                            <?php  echo form_dropdown('gem_polishing_id',$polishing_list,set_value('gem_polishing_id'),' class="form-control select2" data-live-search="true" id="gem_polishing_id"');?>
                                            <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                       </div> 
                                       <!--<div class="col-md-1" style="padding-left: 0px">  <a id="polish_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>-->
                                   </div>  
                               </div>
                                <div hidden id="heater_div" class="col-md-6">
                                   <div class="form-group">
                                       <label class="col-md-4 control-label">Heater<span style="color: red">*</span></label>
                                       <div class="col-md-7">    
                                            <?php  echo form_dropdown('gem_heater_id',$heater_list,set_value('gem_heater_id'),' class="form-control select2" data-live-search="true" id="gem_heater_id"');?>
                                            <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                       </div> 
                                       <!--<div class="col-md-1" style="padding-left: 0px">  <a id="heater_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>>-->
                                   </div>  
                               </div>
                                <div hidden id="lab_div" class="col-md-6">
                                   <div class="form-group">
                                       <label class="col-md-4 control-label">Laboratory<span style="color: red">*</span></label>
                                       <div class="col-md-7">    
                                            <?php  echo form_dropdown('gem_lab_id',$lab_list,set_value('gem_lab_id'),' class="form-control select2" data-live-search="true" id="gem_lab_id"');?>
                                            <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                       </div> 
                                       <!--<div class="col-md-1" style="padding-left: 0px">  <a id="lab_add_new" class="btn btn-default add_new_btn"><span class="fa fa-plus-circle"></span></a>   </div>-->
                                   </div>  
                               </div>
                           </div>
                        </div>
                        <div class="row"> 
                            <div id="result_search"></div>
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Filter Gems for Receival from Lapidary</h4> 
                                    <div class="row col-md-12 ">  
                                        
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="gem_issue_no">Issue #</label>
                                                    <?php  echo form_input('gem_issue_no',set_value('gem_issue_no'),' class="form-control" id="gem_issue_no" placeholder="Search by Gem Issue No."');?>
                                                </div> 
                                        </div>  
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
                                        <div class="col-md-1">  
                                                <div class="form-group pad">
                                                    <label for="weight_from">Weight from</label>
                                                    <?php  echo form_input('weight_from',set_value('weight_from'),' class="form-control "   id="weight_from"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-1">  
                                                <div class="form-group pad">
                                                    <label for="weight_to">Weight to  </label>
                                                    <?php  echo form_input('weight_to',set_value('weight_to'),' class="form-control"   id="weight_to"');?>
                                                </div> 
                                        </div> 
                                        <div class="col-md-2" >  
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
                                               <th width="5%"  style="text-align: center;">Issue#</th> 
                                               <th width="8%"  style="text-align: center;">Issued Date</th> 
                                               <th width="10%"  style="text-align: left;">Lapidarist</th> 
                                               <th width="10%"  style="text-align: center;">Variety</th> 
                                               <th width="15%"  style="text-align: left;">Item Desc</th> 
                                               <th width="8%"  style="text-align: center;">Code</th> 
                                               <th width="8%"  style="text-align: center;">Color</th> 
                                               <th width="8%" style="text-align: center;">Shape</th> 
                                               <th width="16%" style="text-align: center;">Measurement(LxWxH)</th> 
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
                                <button id="submit_gem_receival" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i>Confirm Submission</button>
                
                            </div>
                        </div>
                    </div>
                
              </div>
    </section>      
                            
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('action',$action); ?>
                            <?php if(isset($no_menu) && $no_menu==1)echo form_hidden('no_menu',$no_menu); ?>
                            <?php echo form_close(); ?>               
                                
                         
                 
<?php $this->load->view('gem_receival//gem_receival_modals/add_dropdown_modal'); ?>           
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
            $('#submit_gem_receival').trigger('click');
        }
    });
$(document).ready(function(){ 
    $('#sales_order_no').focus();
    $('#lapidrist_div select, #gem_issue_type_id').change(function(){
        $('#search_items_btn').trigger('click');
    })
    $('#search_items_btn').click(function(){ 
        if($('#gem_issue_type_id').val()==''){
            fl_alert('warning', 'Please Select Issue Type!');
            return false;
        }
        get_issued_items_res()
    });
    
     $("#submit_gem_receival").click(function(){
         $('.selected_toprows').each(function(){
             if($('#'+(this.id)).is(":hidden")){
//                 $('#'+(this.id)).remove();
             } 
         });  
         if($('#gem_issue_type_id').val()==""){
             fl_alert('warning','Please select Issue Type!');
            return false; 
         } 
        if(!confirm("click ok to Confirm the Form Submission.")){
              return false;
          }else{
              if($('input[name^="inv_items_btm"]').length<=0){
                  fl_alert('warning',"Atleast one item need to create an Credit Note!")
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

function get_issued_items_res(){
    
        var post_data = jQuery('#form_search').serializeArray(); 
        post_data.push({name:"function_name",value:'get_search_res_issued_items'});
    
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
                                
                                $('.selected_toprows').hide(); //hide all top row selected
                                
                                $(res2).each(function (index, elment) {
//                                    console.log(elment);  
                                    var measurment ='';
                                    if(elment.length!='') measurment += ' '+((elment.length!='0')?elment.length+' ':'-'); 
                                    if(elment.width!='') measurment += ' x '+((elment.width!='0')?elment.width+' ':'-');
                                    if(elment.height!='') measurment += ' x '+((elment.height!='0')?elment.height+' ':'-');
//                                    alert(elment.issue_date)
                                    var issued_date = timeConverter(parseInt(elment.issue_date));
                                    var ret_date = timeConverter(parseInt(elment.return_date));
                                    measurment += 'mm';
//                                    alert(measurment)
                                    var exist_check = $("[name='inv_items_btm["+elment.id+"][item_id]']").val(); 
                                    var hid_var = ' ';
                                    if(typeof(exist_check) != "undefined"){
                                       hid_var = 'hidden'; 
                                    }
                                    var newRow = '<tr '+hid_var+' id="rowb_'+elment.id+'" style="height:10px;font-size:13px;" >'+
                                                        '<td style="text-align: center;">'+elment.gem_issue_no+'<input hidden  id="'+elment.id+'_gem_issue_no" value="'+elment.gem_issue_no+'"><input hidden  id="'+elment.id+'_gem_issue_id" value="'+elment.gem_issue_id+'"></td>'+
                                                        '<td style="text-align: center;">'+ret_date+'<input hidden  id="'+elment.id+'_return_date" value="'+ret_date+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.lapidarist_name+'<input hidden  id="'+elment.id+'_lapidarist_name" value="'+elment.lapidarist_name+'"><input hidden  id="'+elment.id+'_receiver_id" value="'+elment.receiver_id+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.item_category_name+'<input hidden id="'+elment.id+'_cat_id" value="'+elment.item_category_id+'">'+
                                                            '<input hidden id="'+elment.id+'_cat_name" value="'+elment.item_category_name+'">'+
                                                            '<input hidden id="'+elment.id+'_item_id" value="'+elment.item_id+'">'+
                                                            '<input hidden id="'+elment.id+'_certification_no" value="'+elment.certification_no+'">'+
                                                            '<input hidden id="'+elment.id+'_certification" value="'+elment.certification+'"><input hidden id="'+elment.id+'_certification_val" value="'+elment.certification_val+'">'+
                                                            '<input hidden id="'+elment.id+'_treatment" value="'+elment.treatment+'"><input hidden id="'+elment.id+'_treatment_val" value="'+elment.treatment_val+'">'+
                                                            '<input hidden id="'+elment.id+'_origin" value="'+elment.origin+'"><input hidden id="'+elment.id+'_origin_val" value="'+elment.origin_val+'">'+
                                                        '</td>'+
                                                        '<td style="text-align: center;">'+elment.item_name+'<input hidden  id="'+elment.id+'_item_name" value="'+elment.item_name+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.item_code+'<input hidden  id="'+elment.id+'_item_code" value="'+elment.item_code+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.color_val+'<input hidden id="'+elment.id+'_color_dd_id" value="'+elment.color+'"><input hidden id="'+elment.id+'_color_dd_val" value="'+elment.color_val+'"></td>'+
                                                        '<td style="text-align: center;">'+elment.shape_val+'<input hidden id="'+elment.id+'_shape_dd_id" value="'+elment.shape+'"><input hidden id="'+elment.id+'_shape_dd_val" value="'+elment.shape_val+'"></td>'+
                                                        '<td style="text-align: center;">'+measurment+'<input hidden id="'+elment.id+'_measurment" value="'+measurment+'"><input hidden id="'+elment.id+'_height" value="'+elment.height+'"><input hidden id="'+elment.id+'_width" value="'+elment.width+'"><input hidden id="'+elment.id+'_length" value="'+elment.length+'"></td>'+
                                                        '<td style="text-align: right;">'+elment.units_on_workshop+' '+elment.uom_name+((elment.uom_id_2>0)?(' | '+elment.units_on_workshop_2+' '+elment.uom_name_2):'')+'<input hidden  id="'+elment.id+'_item_quantity" value="'+elment.units_on_workshop+'"><input hidden  id="'+elment.id+'_item_quantity_2" value="'+elment.units_on_workshop_2+'">'+
                                                            '<input hidden  id="'+elment.id+'_uom_id" value="'+elment.uom_id+'"><input hidden  id="'+elment.id+'_uom_abr" value="'+elment.uom_name+'">'+
                                                            '<input hidden  id="'+elment.id+'_uom_id_2" value="'+elment.uom_id_2+'"><input hidden  id="'+elment.id+'_uom_abr_2" value="'+elment.uom_name_2+'"></td>';
                                        
                                            newRow +=  '<td><span  id="'+elment.id+'" class="btn btn-success btn-sm fa fa-plus add_res_row"></span></td>'+
                                                  '</tr>';
                                    jQuery('#bottom_rows_restbl').append(newRow); 
//                                    calc_tots_osub()

                                    //remove already selected item if not in new search result
                                    $('.selected_toprows').each(function(){
                                        if('rowt_'+(elment.id) == this.id){
                                            $('#'+(this.id)).show();
                                        }
                                    });
                             });
                             
                                    $('.add_res_row').click(function(){
                                        
                                        var add_id = this.id;
                                        var add_gem_issue_no = $("#"+add_id+"_gem_issue_no").val()
                                        var add_gem_issue_id = $("#"+add_id+"_gem_issue_id").val()
                                        var add_return_date = $("#"+add_id+"_return_date").val()
                                        var add_lapidarist_id = $("#"+add_id+"_receiver_id").val()
                                        var add_lapidarist_name = $("#"+add_id+"_lapidarist_name").val()
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
                                        var add_certification_val = $("#"+add_id+"_certification_val").val() 
                                        var add_treatment = $("#"+add_id+"_treatment").val() 
                                        var add_treatment_val = $("#"+add_id+"_treatment_val").val() 
                                        var add_origin = $("#"+add_id+"_origin").val() 
                                        var add_origin_val = $("#"+add_id+"_origin_val").val() 
                                        var add_unit_price = $("#"+add_id+"_unit_price").val() 
                                        var add_item_quantity = $("#"+add_id+"_item_quantity").val() 
                                        var add_item_quantity_2 = $("#"+add_id+"_item_quantity_2").val() 

                                        var add_uom_id = $("#"+add_id+"_uom_id").val();
                                        var add_uom_id_2 = (typeof $("#"+add_id+"_uom_id_2").val()!== 'undefined')?$("#"+add_id+"_uom_id_2").val():0;
 
                                        var add_uom_abr =  $("#"+add_id+"_uom_abr").val();
                                        var add_uom_abr_2 =  (typeof $("#"+add_id+"_uom_abr_2").val()!== 'undefined')?$("#"+add_id+"_uom_abr_2").val():0;
                                        
                                        
//                                     fl_alert('info',add_uom_abr_2) 
                                        var newRow = '<tr class="selected_toprows" id="rowt_'+add_id+'" style="background:#adffaf; height:10px;font-size:13px;">'+
                                                        '<td style="text-align: center;">'+add_gem_issue_no+'<input hidden name="inv_items_btm['+add_id+'][gem_issue_no]" value="'+add_gem_issue_no+'"><input hidden name="inv_items_btm['+add_id+'][gem_issue_id]" value="'+add_gem_issue_id+'"></td>'+
                                                        '<td style="text-align: center;">'+add_return_date+'<input hidden name="inv_items_btm['+add_id+'][return_date]" value="'+add_return_date+'"></td>'+
                                                        '<td style="text-align: center;">'+add_lapidarist_name+'<input hidden name="inv_items_btm['+add_id+'][lapidarist_id]" value="'+add_lapidarist_id+'"></td>'+
                                                        '<td style="text-align: center;"><span class="'+add_id+'_cat_select_txt">'+add_cat_name+'</span> <input hidden name="inv_items_btm['+add_id+'][category_id]" value="'+add_cat_id+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][item_category_name]" value="'+add_cat_name+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][item_id]" value="'+add_item_id+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][certification_no]" value="'+add_certification_no+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][certification]" value="'+add_certification+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][treatment]" value="'+add_treatment+'">'+
                                                            '<input hidden name="inv_items_btm['+add_id+'][origin]" value="'+add_origin+'">'+
                                                        '</td>'+
                                                        '<td style="text-align: center;">'+add_item_name+'<input hidden name="inv_items_btm['+add_id+'][item_name]" value="'+add_item_name+'"></td>'+
                                                        '<td style="text-align: center;">'+add_item_code+'<input hidden name="inv_items_btm['+add_id+'][item_code]" value="'+add_item_code+'"></td>'+
                                                        '<td colspan="2">'+
                                                               '<table style="margin-bottom:0px;" class="table table-condensed">'+
                                                               ' <tr>'+
                                                                    '<th></th>'+
                                                                    '<th style="text-align:left;">Previous</th>'+
                                                                    '<th style="text-align:left;">New</th>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td>Treatment</td>'+
                                                                    '<td><span class="'+add_id+'_treatment_select_txt">'+((add_treatment_val!='null')?add_treatment_val:'--')+'</span> </td>'+
                                                                    '<td><select name="inv_items_btm['+add_id+'][treatment_select]"  id="'+add_id+'_treatment_select"><option val="">No Treatments</option></select> <a id="'+add_id+'_treatment_new" class="add_new_btn btn btn-sm"><span class="fa fa-plus"></span></a><input hidden name="inv_items_btm['+add_id+'][treatment_id]" value="'+add_treatment+'"><input hidden name="inv_items_btm['+add_id+'][treatment_val]"  value="'+add_treatment_val+'"></td>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td>Color</td>'+
                                                                    '<td><span class="'+add_id+'_color_select_txt">'+((add_color_dd_val!='null')?add_color_dd_val:'--')+'</span> </td>'+
                                                                    '<td><select <select name="inv_items_btm['+add_id+'][treatment_color]" id="'+add_id+'_color_select"><option val="">No Color</option></select><a id="'+add_id+'_color_new" class="add_new_btn btn btn-sm"><span class="fa fa-plus"></span></a> <input hidden name="inv_items_btm['+add_id+'][color_dd_id]" value="'+add_color_dd_id+'"><input hidden name="inv_items_btm['+add_id+'][color_dd_val]"  value="'+add_color_dd_val+'"></td>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td>Shape</td>'+
                                                                    '<td><span class="'+add_id+'_shape_select_txt">'+((add_shape_dd_val!='null')?add_shape_dd_val:'--')+'</span> </td>'+
                                                                    '<td><select <select name="inv_items_btm['+add_id+'][shape_select]" id="'+add_id+'_shape_select"><option val="">No shape</option></select> <a id="'+add_id+'_shape_new" class="add_new_btn btn btn-sm"><span class="fa fa-plus"></span></a><input hidden name="inv_items_btm['+add_id+'][shape_dd_id]" value="'+add_shape_dd_id+'"><input hidden name="inv_items_btm['+add_id+'][shape_dd_val]"  value="'+add_shape_dd_val+'"></td>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td>Certification</td>'+
                                                                    '<td><span class="'+add_id+'_certification_select_txt">'+((add_certification_val!='null')?add_certification_val:'--')+'</span> </td>'+
                                                                    '<td><select <select name="inv_items_btm['+add_id+'][certification_select]" id="'+add_id+'_certification_select"><option val="">No certification</option></select> <input hidden name="inv_items_btm['+add_id+'][certification_id]" value="'+add_certification+'"><input hidden name="inv_items_btm['+add_id+'][certification_val]"  value="'+add_certification+'"></td>'+
                                                                '</tr>'+ 
                                                               ' <tr>'+
                                                                    '<td>Certification#</td>'+
                                                                    '<td>'+add_certification_no+'</td>'+
                                                                    '<td><input type="text" name="inv_items_btm['+add_id+'][certification_no]" value="'+add_certification_no+'"></td>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td>Origin</td>'+
                                                                    '<td><span class="'+add_id+'_origin_select_txt">'+((add_origin_val!='null')?add_origin_val:'--')+'</span> </td>'+
                                                                    '<td><select  name="inv_items_btm['+add_id+'][origin_select]"  id="'+add_id+'_origin_select"><option val="">No Origin</option></select> <a id="'+add_id+'_origin_new" class="add_new_btn btn btn-sm"><span class="fa fa-plus"></span></a><input hidden name="inv_items_btm['+add_id+'][origin_id]" value="'+add_origin+'"><input hidden name="inv_items_btm['+add_id+'][origin_val]"  value="'+add_origin_val+'"></td>'+
                                                                '</tr>'+ 
                                                               ' <tr>'+
                                                                    '<td>Measurement</td>'+
                                                                    '<td>'+add_length+'x'+add_width+'x'+add_height+' mm</td>'+
                                                                    '<td><label style="width:30%"> Length: </label><input name="inv_items_btm['+add_id+'][length]" value="'+add_length+'"  style="margin-left:10px; width:60%"  type="text">'+
                                                                         '<label style="width:30%">Width: </label> <input  name="inv_items_btm['+add_id+'][width]" value="'+add_width+'" style="margin-left:10px; width:60%"  type="text">'+
                                                                         '<label style="width:30%">Height: </label> <input  name="inv_items_btm['+add_id+'][height]" value="'+add_height+'" style="margin-left:10px; width:60%"  type="text"></td>'+
                                                                '</tr>'+
                                                            '</table>'+
                                                        '</td>'+
                                                        '<td colspan="2">'+
                                                               '<table style="margin-bottom:0px;" class="table table-condensed">'+
                                                               ' <tr>'+
                                                                    '<th></th>'+
                                                                    '<th style="text-align:left;">Previous</th>'+
                                                                    '<th style="text-align:left;">New</th>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td>Weight</td>'+
                                                                    '<td>'+add_item_quantity+' '+add_uom_abr+'</td>'+
                                                                    '<td><input name="inv_items_btm['+add_id+'][item_quantity]"  value="'+add_item_quantity+'" type="text"><input  hidden name="inv_items_btm['+add_id+'][uom_id]"  value="'+add_uom_id+'" type="text"></td>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td>Pieces</td>'+
                                                                    '<td>'+add_item_quantity_2+' '+add_uom_abr_2+'</td>'+
                                                                    '<td><input name="inv_items_btm['+add_id+'][item_quantity_2]"  value="'+add_item_quantity_2+'" type="text"><input hidden name="inv_items_btm['+add_id+'][uom_id_2]"  value="'+add_uom_id_2+'" type="text"></td>'+
                                                                '</tr>'+
                                                               ' <tr>'+
                                                                    '<td colspan="2" style="border-top:1pt solid grey;">Lapidary Cost</td>'+
                                                                    '<td style="border-top:1pt solid grey;"><input style="width:50%" type="text" name="inv_items_btm['+add_id+'][lapidary_cost]" value="0"></td>'+
                                                                '</tr>'+
                                                            '</table>'+
                                                        '</td>'+
                                                        '<td><span  id="add_'+add_id+'" class="btn btn-danger fa fa-trash remove_res_row"></span>'+'<input hidden id="add_'+add_id+'_remove" value="'+add_id+'"></td>'+
                                                  '</tr>';
                                            jQuery('#top_rows_restbl').append(newRow); 
                                             
                                            set_dropdown_list(add_id+'_color_select', 17,add_color_dd_id); //17 for oolor dropdown_list_name_id
                                            $('#'+add_id+'_color_select').change(function(){ 
                                                var txt_id = this.id; 
//                                                $('.'+txt_id+'_txt').text($('#'+add_id+'_color_select').find(":selected").text()); 
                                                $('[name="inv_items_btm['+add_id+'][color_dd_id]"]').val(($('#'+add_id+'_color_select').val()=='null')?0:$('#'+add_id+'_color_select').val());
                                            });
                                            set_dropdown_list(add_id+'_treatment_select', 5,add_treatment); //5 for treatment dropdown_list_name_id
                                            $('#'+add_id+'_treatment_select').change(function(){ 
                                                var txt_id = this.id; 
                                                $('[name="inv_items_btm['+add_id+'][treatment_id]"]').val(($('#'+add_id+'_treatment_select').val()=='null')?0:$('#'+add_id+'_treatment_select').val());
                                            });
                                            
                                            set_dropdown_list(add_id+'_shape_select', 16,add_shape_dd_id); //16 for shape dropdown_list_name_id
                                            $('#'+add_id+'_shape_select').change(function(){ 
                                                var txt_id = this.id; 
                                                $('[name="inv_items_btm['+add_id+'][shape_id]"]').val(($('#'+add_id+'_shape_select').val()=='null')?0:$('#'+add_id+'_shape_select').val());
                                            });
                                            set_dropdown_list(add_id+'_certification_select', 4,add_certification); //4 for certification dropdown_list_name_id
                                            $('#'+add_id+'_certification_select').change(function(){ 
                                                var txt_id = this.id; 
                                                $('[name="inv_items_btm['+add_id+'][certification_id]"]').val(($('#'+add_id+'_certification_select').val()=='null')?0:$('#'+add_id+'_certification_select').val());
                                            });
                                            
                                            set_dropdown_list(add_id+'_origin_select', 18,add_origin); //18 for origin dropdown_list_name_id
                                            $('#'+add_id+'_origin_select').change(function(){ 
                                                var txt_id = this.id; 
                                                $('[name="inv_items_btm['+add_id+'][origin_id]"]').val(($('#'+add_id+'_origin_select').val()=='null')?0:$('#'+add_id+'_origin_select').val());
                                            });
                                            
                                            
                                            
                                            $('#rowb_'+add_id).hide();
                                              
                                            $('.remove_res_row').click(function(){
                                                var rmv_id = $('#'+this.id+"_remove").val();
                                                 
                                                    $('#rowt_'+rmv_id).remove();
                                                    $('#rowb_'+rmv_id).show();
                                                    
                                                    calc_tots_osub()
                                            });
                                            
                                             $('.add_new_btn').click(function(){  
                                                var elm_name = (this.id).split('_')[1];
                                                 $('#temp_select_id').val((this.id).split('_')[0]+'_'+elm_name+'_select')
                                                var elm_title = '';
                                                var dd_id = 0;
                                                switch(elm_name){
                                                    case 'shape': dd_id = 16; elm_title = 'Shape'; break;
                                                    case 'color': dd_id = 17; elm_title = 'Color'; break;
                                                    case 'origin': dd_id = 18; elm_title = 'Origin Country'; break; 
                                                    case 'treatment': dd_id = 5; elm_title = 'Treatment'; break; 
                                                }
                                                $('.name_title').text(elm_title)
                                                $('#dropdown_id').val(dd_id);
                                               $('#add_dropdown_modal').modal({backdrop: 'static', keyboard: false }); 
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

function set_dropdown_list(select_id,input_dpname_id, default_val=''){
    var ret_val = 0;
     $.ajax({
                            url: "<?php echo site_url('DropDownList/fl_ajax/');?>",
                            type: 'post',
                            data : {function_name:'get_dropdown_formodal', dd_name_id:input_dpname_id},
                            success: function(dd_data){
//                            fl_alert('info',)    $('#res_op_mod2').html(dd_data);  
                                var $select = $('#'+select_id);
                                $select.empty();
                                
                                //set first empty val
                                var option = $("<option/>").attr("value", 0).text('No Selection');
                                $select.append(option);
                                
                                if(dd_data!=''){
                                    ret_val =1;
//                                    console.log(dd_data)
                                    
                                    var dd_options  = JSON.parse(dd_data); 
                                    $.each(dd_options,function(index, o) { 
                                         var option = $("<option/>").attr("value", index).text(o);
                                         $select.append(option);
                                     });
//                                    $select.select2();  
//                                    
                                       if(default_val!=''){ $select.val(default_val).change();}
//                                    $('#add_dropdown_modal').modal('toggle'); 
                                }else{  
                                    fl_alert('info',"Something went wrong!");
                                }
                            }
                    });
}
</script>
 