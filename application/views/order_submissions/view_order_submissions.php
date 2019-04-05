<?php
//echo '<pre>';print_r($inv_data);  
$inv_dets = $inv_data['sub_dets'];
$so_desc = $inv_data['so_desc_list'];
//$inv_trans = $inv_data['inv_transection'];
//echo '<pre>';print_r($inv_data['invoice_desc']); die;
$show_edit = ($action=='Edit')?'':'hidden';
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
    <br>   <br>   
    <div class="col-md-12">

    
    
        <div class="top_links">
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add/').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$inv_dets['id']).'" class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'.base_url($this->router->fetch_class().'/edit/'.$inv_dets['id']).'" class="btn btn-app "><i class="fa fa-pencil"></i>Edit</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'so_submission_print'))?'<a target="_blank" href="'.base_url($this->router->fetch_class().'/so_submission_print/'.$inv_dets['id']).'" class="btn btn-app "><i class="fa fa-print"></i>Print CM note</a>':''; ?>
             
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Craftman <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('craftman_id',array($inv_dets['craftman_id']=>$inv_dets['craftman_name']),set_value('craftman_id',$inv_dets['craftman_id']),' class="form-control select2" data-live-search="true" id="craftman_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Submission# <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('cm_submission_no',set_value('cm_submission_no',$inv_dets['cm_submission_no']),' class="form-control " readonly id="cm_submission_no"');?>
                                         <!--<span class="help-block"><?php // echo form_error('submission_date');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div> 
                            
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Submission Date<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('submission_date',set_value('submission_date',date('m/d/Y',$inv_dets['submission_date'])),' class="form-control datepicker" readonly id="submission_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('submission_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Return Date <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('return_date',set_value('return_date',date('m/d/Y',$inv_dets['return_date'])),' class="form-control datepicker" readonly id="return_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div id="result_search" class="col-md-12">
                                <br>
                            </div>
                        </div>
             
                    <div class="box-body">
                    <div class="col-md-12 col-md-offset-0">
                        <table width="100%" id="example1" class="table table-bordered table-striped fl_scrollable" border="0">
                           <thead>
                               <tr class="colored_bg" style="background-color:#E0E0E0;">
                                    <th  width="10%" style="text-align: left;"><u><b>Category</b></u></th> 
                                    <th  width="15%" style="text-align: center;"><u><b>Order ItemCode</b></u></th> 
                                    <th width="20%" style="text-align: left;"><u><b>Item Name</b></u></th>  
                                    <th width="12%" style="text-align: center;"><u><b>Weight</b></u></th>  
                                    <th width="13%" style="text-align: center;"><u><b>Order#</b></u></th>  
                                    <th width="30%" style="text-align: left;"><u><b>Description</b></u></th>   
                                    <th <?php echo $show_edit;?> width="30%" style="text-align: left;"><u><b>Action</b></u></th>   
                                </tr> 
                           </thead>
                            <tbody>
                    <?php 
                    foreach ($so_desc as $inv_itm){
//            echo '<pre>';            print_r($inv_itm);  
                        echo  '<tr>
                                   <td width="10%" style="text-align: left;">'.$inv_itm['category_name'].'<input hidden  name="so_desc_ids['.$inv_itm['id'].']" value="'.$inv_itm['id'].'"></td>  
                                   <td width="15%" style="text-align: center;">'.$inv_itm['item_code'].'</td>  
                                   <td width="20%" style="text-align: left;">'.$inv_itm['item_desc'].'</td>  
                                   <td width="12%" style="text-align: center;">'.$inv_itm['units'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['unit_uom_id']!=0)?' | '.$inv_itm['secondary_unit'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
                                   <td width="13%" style="text-align: center;">'.$inv_itm['order_no'].'</td>  
                                   <td width="30%" style="text-align: left;">'.$inv_itm['description'].'</td>  
                                   <td '.$show_edit.' width="30%" style="text-align: left;"><button id="del_btn" type="button" class="del_btn_inv_row btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>  
                                    
                               </tr> ';  
                }  
//             echo $html;
                       ?>  
                    </tbody>
                </table> 
                    </div>
                         <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memo" class="col-sm-2 control-label">Memo</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="memo"><?php echo $inv_dets['memo'];?></textarea>
                                    </div>
                                  </div>
                            </div>
                    </div>
              </div>
                   <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $user_data['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit', constant($action) ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url($this->router->class),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php // echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

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
        
    $(".top_links a").click(function(){ 
        if($('input[name=action]').val()=='Add' || $('input[name=action]').val()=='Edit'){
            if(!confirm("Click Ok to Confirm leave from here. This form may have unsaved data.")){
                   return false;
            }
        }
    });
        
        $('#saleret_receipt_print').click(function(){
            if(!confirm("Click Ok to confirm Return Note Print")){ 
                return false;
            }
            $.ajax({
			url: "<?php echo site_url('Sales_returns/pos_sales_ret_print_direct');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
                             $(".dataTable").DataTable();
                    }
		});
        });
         //delete row
        $('.del_btn_inv_row').click(function(){
            if(!confirm("click ok Confirm remove this item.")){
                return false;
            } 
            $(this).closest('tr').remove();  
        });
});
</script>