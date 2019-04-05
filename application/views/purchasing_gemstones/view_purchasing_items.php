<?php
//echo '<pre>';print_r($inv_data); die;
$inv_dets = $inv_data['invoice_dets'];
$inv_desc = $inv_data['invoice_desc'];
$inv_trans = $inv_data['inv_transection'];


?>
<style>
    .colored_bg{
        background-color:#E0E0E0;
    }
    .table-line th, .table-line td {
        padding-bottom: 2px;
        border-bottom: 1px solid #ddd;
        text-align:center; 
    }
    .text-right,.table-line.text-right{
        text-align:right;
    }
    .table-line tr{
        line-height: 30px;
    }
    </style>
<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

        <div class="">
            <a href="<?php echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
            <a href="<?php echo base_url($this->router->class);?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], 'Customer_payments', 'add_customer_payment'))?'<a href="'.base_url('Customer_payments/add_customer_payment/'.$inv_dets['id'].'/20').'" class="btn btn-app "><i class="fa fa-money"></i>Payments</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$inv_dets['id']).'" class="btn btn-app "><i class="fa fa-trash"></i>Delete Invoice</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'supplier_invoice_print'))?'<a target="_blank" href="'.base_url($this->router->fetch_class().'/supplier_invoice_print/'.$inv_dets['id']).'" class="btn btn-app "><i class="fa fa-print"></i>Print Invoice</a>':''; ?>

        </div>
    </div>
    
 <br><hr>
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
            
            <?php echo form_open($this->router->class."/validate", 'id="form_search" class="form-horizontal"')?>  
              <!-- general form elements -->
              <div class="box box-primary"> 
                  <div class="box-body">
                <!-- /.box-header -->
                <!-- form start -->
               <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Supplier <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('supplier_id',array($inv_dets['supplier_name']),set_value('supplier_id'),' class="form-control select2" data-live-search="true" id="supplier_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Invoice# <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('supplier_invoice_no',set_value('supplier_invoice_no',$inv_dets['supplier_invoice_no']),' class="form-control " readonly id="supplier_invoice_no"');?>
                                         <!--<span class="help-block"><?php // echo form_error('invoice_date');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Reference <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('reference',set_value('reference',$inv_dets['reference']),' class="form-control"  readonly id="reference"');?>
                                         <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id',$inv_dets['payment_term_id']),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('invoice_date',set_value('invoice_date',date('m/d/Y',$inv_dets['invoice_date'])),' class="form-control datepicker" readonly id="invoice_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('invoice_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$inv_dets['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                            </div>
                        </div>
             
                    <div class="box-body fl_scrollable_x">
                    <div class="col-md-10 col-md-offset-1">
                        <table width="100%" border="1">
                            <tr><td>
                    <?php
                            $cur_det = get_single_row_helper(CURRENCY,'code = "'.$inv_dets['currency_code'].'"');
//                            echo '<pre>';                            print_r($cur_det); die;
                    foreach ($inv_desc as $inv_itms){ 
                         echo '<table width="100%" id="example1" class="table-line" border="0">
                                    <thead>
                                        <tr class="colored_bg" style="background-color:#E0E0E0;">
                                             <th colspan="10">'.$inv_data['item_cats'][$inv_itms[0]['item_category']].'</th> 
                                         </tr>
                                        <tr style="">
                                            <th width="8%" style="text-align: left;"><u><b>Item Code</b></u></th>  
                                            <th width="14%" style="text-align: left;"><u><b>Gemstone</b></u></th>  
                                             <th width="8%" style="text-align: left;"><u><b>NH/H</b></u></th>  
                                             <th width="8%" style="text-align: left;"><u><b>Shape</b></u></th>  
                                             <th width="10%" style="text-align: left;"><u><b>Color</b></u></th>  
                                             <th width="8%" style="text-align: left;"><u><b>Origin</b></u></th>  
                                             <th width="10%" style="text-align: left;"><u><b>Certificate</b></u></th>  
                                             <th  width="15%"><u><b>Qty</b></u></th> 
                                             <th width="9%" style="text-align: right;"><u><b>Rate ('.$cur_det['symbol_left'].')</b></u></th>  
                                             <th width="10%" style="text-align: right;"><u><b>Total('.$cur_det['symbol_left'].')</b></u></th> 
                                         </tr>
                                    </thead>
                                <tbody>';

                     foreach ($inv_itms as $inv_itm){
                        $item_info = get_single_row_helper(ITEMS, 'id='.$inv_itm['item_id']);
//echo '<pre>';print_r($item_info);  
                         echo     '<tr>
                                        <td width="8%" style="text-align: left;">'.$inv_itm['item_code'].'</td> 
                                        <td width="14%" style="text-align: left;">'.$inv_itm['supplier_item_desc'].'</td>   
                                        <td width="8%" style="text-align: left;">'. (($item_info['treatment']>0)?get_dropdown_value($item_info['treatment']):'').'</td>   
                                        <td width="8%" style="text-align: left;">'. (($item_info['shape']>0)?get_dropdown_value($item_info['shape']):'-').'</td>   
                                        <td width="10%" style="text-align: left;">'. (($item_info['color']>0)?get_dropdown_value($item_info['color']):'-').'</td>   
                                        <td width="8%" style="text-align: left;">'. (($item_info['origin']>0)?get_dropdown_value($item_info['origin']):'-').'</td>   
                                        <td width="10%" style="text-align: left;">'. (($item_info['certification']>0)?get_dropdown_value($item_info['certification']):'-').'</td>   
                                        <td width="15%">'.$inv_itm['purchasing_unit'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['secondary_unit_uom_id']>0)?' | '.$inv_itm['secondary_unit'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
                                        <td width="9%" style="text-align: right;">'. number_format($inv_itm['purchasing_unit_price'],2).'</td> 
                                        <td width="10%" style="text-align: right;">'. number_format($inv_itm['sub_total'],2).'</td> 
                                    </tr> ';
                     }
                     echo       ' <tr><td  colspan="5"></td></tr></tbody></table>'; 
            }
            echo '
                    <table id="example1" width="100%" class="table-line" border="0">
                        
                       <tbody>

                                <tr class="td_ht">
                                    <td style="text-align: right;" colspan="4"><b> Total</b></td> 
                                    <td  width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_desc_total'],2).'</b></td> 
                                </tr>'; 
                        foreach ($inv_trans as $inv_tran){
                            echo '<tr>
                                            <td  style="text-align: right;" colspan="4">'.$inv_tran['trans_type_name'].'</td> 
                                            <td  width="19%"  style="text-align: right;">'. number_format($inv_tran['transection_ref_amount'],2).'</td> 
                                        </tr> ';

                        }
                        echo '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                                    <td width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_total'],2).'</b></td> 
                                </tr> 
                        </tbody>
                    </table>
                                                               
                '; 
//             echo $html;
                       ?>
                                    </td></tr>
                        </table>
                    </div>
                    </div>
              </div>
                   <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $user_data['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('Invoice_list'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url($this->router->fetch_class()),'OK','class="btn btn-primary"');
                                    } ?>
                      <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                    </div>
              </div>
              <?php echo form_close();?>
        </div>
    </section>
</div>
</div>
    
   
<script>
    
$(document).keypress(function(e) {
//    fl_alert('info',e.keyCode)
        if(e.keyCode == 80) {//80 for shit+p (print invoice)
           window.open('<?php echo base_url($this->router->fetch_class().'/sales_invoice_print/'.$inv_dets['id']);?>');
        }
        if(e.keyCode == 78) {//80 for shit+p (print invoice)
           window.location.replace('<?php echo base_url('Invoices/add/');?>');
        }
        
    });
    
        
$(document).ready(function(){ 
        $("input[name = 'submit']").click(function(){
            if(confirm("Click Ok to confirmation for Cancel or Remove this Rent Reservation")){
                return true;
            }else{
                return false;
            }
        });
});
</script>