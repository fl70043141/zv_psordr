
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
        console.log(post_data);
        $.ajax({
			url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
			type: 'post',
			data : post_data,
			success: function(result){ 
                             $("#result_search").html(result);
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
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="min_weight">Minimum Weight (cts).</label>
                                                     <?php echo form_input('min_weight',set_value('min_weight',0),' class="form-control" placeholder="Enter Minimim Carat weight"  id="min_weight"');?>
                                               </div> 
                                        </div>    
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="max_weight">Maximum Weight (cts) <input type="checkbox" name="max_weight_check" id="max_weight_check" id="max_weight_check" value="1"></label>
                                                     <?php echo form_input('max_weight',set_value('max_weight',10),' class="form-control" placeholder="Enter Maximum Carat weight" id="max_weight"');?>
                                               </div> 
                                        </div>    
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="item_code">Item Code</label>
                                                     <?php echo form_input('item_code',set_value('item_code',''),' class="form-control" placeholder="Search by Code" id="max_weight"');?>
                                               </div> 
                                        </div>    
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="treatment_id">Treatment</label>
                                                     <?php echo form_dropdown('treatment_id',$treatments_list,set_value('treatment_id'),' class="form-control select2" id="treatment_id"');?>
                                              
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad no-pad-top">
                                                    <label for="color_id">Color.</label>
                                                     <?php echo form_dropdown('color_id',$color_list,set_value('color_id'),' class="form-control select2" id="color_id"');?>
                                              
                                                </div> 
                                        </div>    
                                        <div class="col-md-3">  
                                                <div class="form-group pad no-pad-top">
                                                    <label for="shape_id">Shape</label>
                                                     <?php echo form_dropdown('shape_id',$shape_list,set_value('shape_id'),' class="form-control select2" id="shape_id"');?>
                                              
                                                </div> 
                                        </div> 
                                
                                        <div class="col-md-3">  
                                                <div class="form-group pad  no-pad-top">
                                                    <label for="item_type_id">Purchasing Type</label>
                                                     <?php echo form_dropdown('item_type_id',$item_type_list,set_value('item_type_id'),' class="form-control select2" id="item_type_id"');?>
                                              
                                                </div> 
                                        </div> 
                                    </div>
                              
                        </div>
                    </div>
                <div class="panel-footer">
                                    <button  class="btn btn-default">Clear Form</button>                                    
                                    <a id="print_btn" class="btn btn-info margin-r-5 pull-right"><span class="fa fa-print"></span> Print</a>
                                    <a id="search_btn" class="btn btn-primary margin-r-5 pull-right"><span class="fa fa-search"></span> Search</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div> 
        
     <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search Results</h3>
            </div>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body fl_scrollable_x"> </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 