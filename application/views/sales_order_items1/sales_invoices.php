
<script>
    
//    $(document).keypress(function(e) {
//            if(e.keyCode == 13) {
//                fl_alert('info','You pressed tab!');
//                $('#item_quantity').focus();
//                
//            }
//        });
$(document).ready(function(){
    $('#item_code').focus();
    $('.select2').on("select2:close", function () { $(this).focus(); });
    
    window.log = function(e){
        fl_alert('info','keyCode: '+e.keyCode+' \nwhich: '+e.which+' \ncharCode:'+e.charCode)
    }
	get_results();
    $("#reg_no").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
	 
    $("#category").change(function(){
		event.preventDefault();
		get_results();
    });
    $("#status").change(function(){
		event.preventDefault();
		get_results();
    });
	
	
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('Vehicle_rates/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
                             $(".dataTable").DataTable();
        }
		});
	}
});
</script>
 
<?php // echo '<pre>'; print_r($facility_list); die;?>

<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

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
<!--    
        <div class="">
            <a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
            <a href="<?php // echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>

        </div>-->
    </div>
    
 <!--<br><hr>-->
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary"> 
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customer <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('customer_id',$customer_list,set_value('customer_id'),' class="form-control select2" data-live-search="true" id="customer_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Reference <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('reference',set_value('reference'),' class="form-control" id="reference"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id'),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Sale Type <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('sales_type_id',$sales_type_list,set_value('sales_type_id'),' class="form-control select2" data-live-search="true" id="sales_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('invoice_date',set_value('invoice_date'),' class="form-control datepicker" id="invoice_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <hr>
                            <h4 class="col-md-offset-3">Add Item sale</h4> 
                            <div class="">
                                <div class="col-md-12">
                                    <table id="example1" class="table  table-bordered table-striped">
                                        <thead>
                                           <tr>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_code">Item Code</label>
                                                        <?php  echo form_input('item_code',set_value('item_code'),' class="form-control" data-live-search="true" id="item_code"');?>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_desc">Item Description</label>
                                                        <?php  echo form_dropdown('item_desc',$item_list,set_value('item_desc'),' class="form-control select2" style="width:100%;" data-live-search="true" id="item_desc"');?>
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_quantity">Quantity</label>
                                                        <input type="item_quantity" class="form-control" id="item_quantity" placeholder="Enter Quamtity">
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_unit_cost">Unit Cost</label>
                                                        <input type="item_unit_cost" class="form-control" id="item_unit_cost" placeholder="Unit Cost for item">
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="item_code">Discount</label>
                                                        <input type="item_discount" class="form-control" id="item_discount" placeholder="Enter discount percent">
                                                    </div>
                                                    </div>
                                               </td>
                                               <td>
                                                    <div class="col-md-12">
                                                    <div class="form-group"><br>
                                                        <span class="btn-default btn">Add</span>
                                                    </div>
                                                    </div>
                                               </td>
                                           </tr>
                                       </thead>
                                    </table>
                                </div>    
                            </div>    
                        </div>
                    </div>
                
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div>
     <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body"> </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 