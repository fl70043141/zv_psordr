
<script>
$(document).ready(function(){
    
    get_results();
    $("#category_id").change(function(){ 
		event.preventDefault();
		get_results();
    });  
    $("#price_type_id").change(function(){ 
		event.preventDefault();
		get_results();
    });  
	
	 
});
function get_results(){
            $("#result_search").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    

            var post_data = jQuery('#form_search').serializeArray(); 
            post_data.push({name:"function_name",value:'search_cats'});
    //        console.log(post_data); 
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
</script>
 
<?php // echo '<pre>'; print_r($facility_list); die;?>

<div class="row">
<div class="col-md-12">
    <!--<br>-->   
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
    
<!-- <br><hr>-->
    <section  class="content">  
              <!-- general form elements -->
              <div class="box box-primary"> 
                <!-- /.box-header -->
                    <div class="box-body">
                            <!-- form start -->

                        <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
                       <?php echo form_hidden('order_id',$order_id)?>  
                        <div class="row"> 
                            <div class="col-md-3">
                                    <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url('Sales_order_items'.(($order_id!="")?'/edit/'.$order_id:'')).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
                                     <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url('Sales_order_items/add').'" class="btn btn-app "><i class="fa fa-check"></i>Finalize Order</a>':''; ?>
            
                            </div>
                            <div class="col-md-3">  
                                    <div class="form-group pad  no-pad-top">
                                        <label for="location_id">Category Name:</label>
                                         <?php  echo form_dropdown('category_id',$category_list,set_value('category_id'),' class="form-control " data-live-search="true" id="category_id"');?>
                                    </div> 
                            </div>   
                            <div class="col-md-3">  
                                    <div class="form-group pad  no-pad-top">
                                        <label for="item_code">Item Code</label>
                                        <?php  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" placeholder="Search by Code" id="item_code"');?>
                                   </div> 
                            </div> 
                            
                            <div class="col-md-3">  
                                    <div class="form-group pad  no-pad-top">
                                        <label for="price_type_id">Price:</label>
                                         <?php  echo form_dropdown('price_type_id',$sales_type_list,set_value('price_type_id'),' class="form-control " data-live-search="true" id="price_type_id"');?>
                                    </div> 
                            </div> 
                        </div>
                            
                            <?php echo form_close(); ?> 
                    </div> 
              </div>
                                    
        <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo SYSTEM_NAME;?> Category List</h3>
            </div>
            <div class="box-body row">
                <div id="result_search"> 
                    
                </div>
            </div>
            
          </div>
       
    </section>              
   
     </div>
</div> 