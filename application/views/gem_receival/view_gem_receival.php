<?php
//echo '<pre>';print_r($row_desc);  
$show_edit = ($action=='Edit')?'':'hidden';
    $row_data_html='';
    $i=1;
    $tot_cost = $tot_units = $tot_units_2 = $tot_units_old = $tot_units_old_2 = 0; 
    foreach ($gem_rec_info as $row){
        $tot_cost += $row['amount_cost'];

        $tot_units += $row['units'];
        $tot_units_2 += $row['units_2'];

        $tot_units_old += $row['gem_issue_info']['units'];
        $tot_units_old_2 += $row['gem_issue_info']['units_2'];

        $measurement_old = (($row['gem_issue_info']['length']>0)?$row['gem_issue_info']['length']:'-').' x '.(($row['gem_issue_info']['width']>0)?$row['gem_issue_info']['width']:'-').' x '.(($row['gem_issue_info']['width']>0)?$row['gem_issue_info']['width']:'-').' mm';
        $measurement = (($row['length']>0)?$row['length']:'-').' x '.(($row['width']>0)?$row['width']:'-').' x '.(($row['width']>0)?$row['width']:'-').' mm';

        $units_old = $row['gem_issue_info']['units'].' '.$row['gem_issue_info']['unit_abbr'];
        $units = $row['units'].' '.$row['unit_abbr'];

        $units_2 = (($row['uom_id_2']>0)?$row['units_2'].' '.$row['unit_abbr_2']:'');
        $units_old_2 = (($row['gem_issue_info']['uom_id_2']>0)?$row['gem_issue_info']['units_2'].' '.$row['gem_issue_info']['unit_abbr_2']:'');
//            echo '<pre>';            print_r($row);  
            $row_data_html .=  '<tr>
                                   <td style="text-align: center;">'.$i.'</td>   
                                   <td style="text-align: left;"><input hidden name="gem_issue_ids['.$row['item_id'].']" value="'.$row['gem_issue_id'].'">'.$row['gem_issue_no'].'</td>   
                                   <td style="text-align: left;">'.date(SYS_DATE_FORMAT,$row['issue_date']).'</td>   
                                   <td style="text-align: left;">'.$row['gi_lapidarist_name'].'</td>   
                                   <td style="text-align: left;">'.$row['category_name'].'</td>   
                                   <td style="text-align: left;">'.$row['item_name'].'</td>   
                                   <td style="text-align: left;">'.$row['item_code'].'</td>   
                                   <td style="text-align: left;">
                                        <table class="table table-bordered gm_info_tbl">
                                            <tr>
                                                <th></th>
                                                <th>Previous</th>
                                                <th>New</th>
                                            </tr>
                                            <tr>
                                                <td>Treatments</td>
                                                <td>'.(($row['gem_issue_info']['treatment_val'])?$row['gem_issue_info']['treatment_val']:'--').'</td>
                                                <td>'.(($row['treatment_val'])?$row['treatment_val']:'--').'</td>
                                            </tr>
                                            <tr>
                                                <td>Color</td>
                                                <td>'.(($row['gem_issue_info']['color_val'])?$row['gem_issue_info']['color_val']:'--').'</td>
                                                <td>'.(($row['color_val'])?$row['color_val']:'--').'</td>
                                            </tr>
                                            <tr>
                                                <td>Shape</td>
                                                <td>'.(($row['gem_issue_info']['shape_val'])?$row['gem_issue_info']['shape_val']:'--').'</td>
                                                <td>'.(($row['shape_val'])?$row['shape_val']:'--').'</td>
                                            </tr>
                                            <tr>
                                                <td>Certification</td>
                                                <td>'.(($row['gem_issue_info']['certification_val'])?$row['gem_issue_info']['certification_val']:'--').'</td>
                                                <td>'.(($row['certification_val'])?$row['certification_val']:'--').'</td>
                                            </tr>
                                            <tr>
                                                <td>Cert #</td>
                                                <td>'.(($row['gem_issue_info']['certification_no'])?$row['gem_issue_info']['certification_no']:'--').'</td>
                                                <td>'.(($row['certification_no']!='')?$row['certification_no']:'--').'</td>
                                            </tr>
                                            <tr>
                                                <td>Origin</td>
                                                <td>'.(($row['gem_issue_info']['origin_val']=='')?'--':$row['gem_issue_info']['origin_val']).'</td>
                                                <td>'.(($row['origin_val']!='')?$row['origin_val']:'--').'</td>
                                            </tr>
                                            <tr>
                                                <td>Measurement (LxWxH)</td>
                                                <td>'.$measurement_old.'</td>
                                                <td>'.$measurement.'</td>
                                            </tr>
                                        </table>
                                   </td>   
                                   <td style="text-align: left;">
                                        <table class="table table-bordered gm_info_tbl">
                                            <tr>
                                                <th></th>
                                                <th>Previous</th>
                                                <th>New</th>
                                            </tr>
                                            <tr>
                                                <td>Unit 1</td>
                                                <td>'.$units_old.'</td>
                                                <td>'.$units.'</td>
                                            </tr>
                                            <tr>
                                                <td>Unit 2</td>
                                                <td>'.$units_old_2.'</td>
                                                <td>'.$units_2.'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Lapidary Cost: </td>
                                                <td>'. number_format($row['amount_cost'],2).'</td> 
                                            </tr>
                                        </table>
                                   </td>       
                               </tr> ';  
                        $i++;
                }  
//             echo $html;
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
    .gm_info_tbl tr{
        line-height: 10px;
        font-size: 12px
    }
    </style>
<div class="row">
<div class="col-md-12">
    <br>   <br>   
    <div class="col-md-12">

    
    
        <div class="top_links">
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add/').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$row_data['id']).'" class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'.base_url($this->router->fetch_class().'/edit/'.$row_data['id']).'" class="btn btn-app "><i class="fa fa-pencil"></i>Edit</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'gem_issue_print'))?'<a target="_blank" href="'.base_url($this->router->fetch_class().'/gem_issue_print/'.$row_data['id']).'" class="btn btn-app "><i class="fa fa-print"></i>Print Issue note</a>':''; ?> 
             
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
                <div style="font-size: 15px;" class="row header_form_sales">
                        <div id="result_search" class="col-md-12">
                            <br>
                        </div> 
                        <div class="col-md-4">
                            <dl class="dl-horizontal">
                                <dt>Receival Issue #:</dt><dd><?php echo $row_data['gem_receival_no'];?></dd>
                                <dt>Received Location:</dt><dd><?php echo $row_data['location_name'];?></dd> 
                                <dt>Received Date :</dt><dd><?php echo (($row_data['receive_date']>0)?date(SYS_DATE_FORMAT,$row_data['receive_date']):'');?></dd> 
                                <dt>Issue Type :</dt><dd><?php echo $row_data['gem_issue_type_name'];?></dd> 
                                <dt>Lapidarist Name :</dt><dd><?php echo $row_data['lapidarist_name'];?></dd> 
                            </dl> 
                        </div> 
                        <div class="col-md-4">
                            <dl class="dl-horizontal"> 
                                <dt>Payment Term :</dt><dd><?php echo (($row_data['receive_date']>0)?date(SYS_DATE_FORMAT,$row_data['receive_date']):'');?></dd> 
                                <dt>Currency :</dt><dd><?php echo $row_data['currency_code'];?></dd> 
                                <dt>Total Cost :</dt><dd><?php echo number_format($tot_cost,2);?></dd> 
                            </dl> 
                        </div> 
                        <div class="col-md-4">
                            <dl class="dl-horizontal"> 
                                <dt>Total Weight Issued:</dt><dd><?php echo $tot_units_old.' '.$row['gem_issue_info']['unit_abbr'].(($row['gem_issue_info']['uom_id_2']>0)?' | '.$tot_units_old_2.' '.$row['gem_issue_info']['unit_abbr_2']:'');?></dd> 
                                <dt>Total Weight Received :</dt><dd><?php echo $tot_units.' '.$row['unit_abbr'].(($row['uom_id_2']>0)?' | '.$tot_units_2.' '.$row['unit_abbr_2']:'');?></dd> 
                                <dt>Memo :</dt><dd><?php echo $row_data['memo'];?></dd> 
                            </dl> 
                        </div> 

                        <div id="result_search" class="col-md-12">
                            <hr>
                        </div>
                    </div>
             
                    <div class="box-body fl_scrollable_x">
                    <div class="col-md-12 col-md-offset-0">
                        <table width="100%" id="example1" class="table table-bordered table-striped fl_scrollable" border="0">
                           <thead>
                               <tr> 
                                    <th width="3%" >#</th>
                                    <th width="5%"  style="text-align: center;">Issue#</th> 
                                    <th width="8%"  style="text-align: center;">Issued Date</th> 
                                    <th width="10%"  style="text-align: left;">Lapidarist</th> 
                                    <th width="10%"  style="text-align: center;">Variety</th> 
                                    <th width="15%"  style="text-align: left;">Item Desc</th> 
                                    <th width="8%"  style="text-align: center;">Code</th> 
                                    <th width="8%"  style="text-align: center;">Attribute Changes</th>  
                                    <th width="16%" style="text-align: center;">Weight</th> 
                                </tr>
                           </thead>
                            <tbody>
                                <?php echo $row_data_html?> 
                    </tbody>
                </table> 
                    </div>
                         <div class="col-md-6"> 
                            </div>
                    </div>
              </div>
                   <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $row_data['id']); ?>
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
           window.open('<?php echo base_url($this->router->fetch_class().'/sales_invoice_print/'.$row_data['id']);?>');
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