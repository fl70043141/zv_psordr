

<script>
    
$(document).ready(function(){  
//	get_results();
    $("#supp_invoice_no").keyup(function(){ 
		event.preventDefault();
//		get_results();
    }); 
    $("#search_btn").click(function(){
		event.preventDefault();
		get_results();
    });
    $("#print_btn").click(function(){
        var post_data = jQuery('#form_search').serialize(); 
//        var json_data = JSON.stringify(post_data)
        window.open('<?php echo $this->router->fetch_class()."/print_report?";?>'+post_data,'ZV VINDOW',width=600,height=300)
    });
	
	
	function get_results(){
        $("#result_search").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
        
        var post_data = jQuery('#form_search').serializeArray(); 
        post_data.push({name:"function_name",value:'search'});
//        console.log(post_data);
        $.ajax({
			url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
			type: 'post',
			data : post_data,
			success: function(result){ 
                             $("#result_search").html(result);
                             $('#right_tbl_body tr').each(function() {
                                 var itm_id = (this.id).split('_')[1]; 
//                                 fl_alert('info',itm_id);
                                 $('#left_table #itml_'+itm_id).remove();
                        //                                        console.log(this); 
                                }); 
//                             fl_alert('info',$('#left_tbl_body tr').length)
                             
                            $('#pending_item_count').text($('#result_search tbody tr').length);
//                             $(".dataTable").DataTable();
                
        }
		});
	}
});
</script>
 
<?php // echo '<pre>'; print_r($search_list); die;?>

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
    
       
    </div>
     
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Search </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        <div class="row"> 
                            <div class="row col-md-12 center-block"> 
                                        <div hidden class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="location_id">Scanned String</label>
                                            <input readonly id="barcode_input_stock" type="text" class="form-control " >
                                              
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="scanned_code_stock">Item Code</label>
                                                    <input readonly id="scanned_code_stock" type="text" class="form-control" >
                                              
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="location_id">Item Location</label>
                                                     <?php echo form_dropdown('location_id',$location_list,set_value('location_id'),' class="form-control select2" id="location_id"');?>
                                              
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="item_category_id">Item Cat.</label>
                                                     <?php echo form_dropdown('item_category_id',$item_cat_list,set_value('item_category_id'),' class="form-control select2" id="item_category_id"');?>
                                              
                                                </div> 
                                        </div>         
                                    </div>
                              
                        </div>
                    </div>
                <div class="panel-footer">
                                    <a  class="btn btn-default">Clear Form</a>                                    
                                    <a id="print_btn" class="btn btn-info margin-r-5 pull-right"><span class="fa fa-print"></span> Print</a>
                                    <a id="search_btn" class="btn btn-primary margin-r-5 pull-right"><span class="fa fa-search"></span> Search</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div> 
        
     <div class="col-md-6">
        <div class="box no-mar">  
              <h4 class="box-">Pending for Check [ITEMS: <span id="pending_item_count">0</span>]</h4>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body">
            <table id="left_table" class="table   table-bordered afaf table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="text-align:center;">Category</th> 
                            <th style="text-align:center;">Code</th> 
                            <th style="text-align:center;">Desc</th>  
                            <th style="text-align:center;">Location</th>  
                            <th style="text-align:center;">In Stock</th>  
                        </tr>
                    </thead>
                        <tbody id="">
                            
                        </tbody> 
                         </table> 
            </div>
            <!-- /.box-body -->
          </div>
       
     </div>
     <div class="col-md-6">
        <div class="box no-mar">  
            <h4 class="box-">Checked [ITEMS: <span id="checked_item_count">0</span>]</h4>
            <!-- /.box-header -->
            <div  id="" class="box-body"> </div>
                <table id="right_table" class="table   table-bordered afaf table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="text-align:center;">Category</th> 
                            <th style="text-align:center;">Code</th> 
                            <th style="text-align:center;">Desc</th>  
                            <th style="text-align:center;">Location</th>  
                            <th style="text-align:center;">In Stock</th>  
                            <th style="text-align:center;">Action</th>  
                        </tr>
                    </thead>
                        <tbody id="right_tbl_body">
                            
                        </tbody> 
                         </table> 
          </div>
       
     </div>
</div> 
     