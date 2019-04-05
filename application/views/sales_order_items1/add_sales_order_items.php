
<script>
    
$(document).ready(function(){  
	get_results();
        get_results_item();
    $("#item_code").keyup(function(){ 
		event.preventDefault();
                get_results_item();
//		get_results();
    });
	 
    $("#category_id").change(function(){
		event.preventDefault();
		get_results();get_results_item();
    });
    $("#cancel_order").click(function(){
        if(!confirm("Click ok confirm Cancel the Order")){
            return false;
        }
    });
	
	
	function get_results(cat_id=''){ 
            var cat = (cat_id!='')?cat_id:$('#category_id').val();
            $("#result_search").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
            $.ajax({
			url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
			type: 'post',
			data : {function_name:'search_cats',category_id:cat,item_code:$('#item_code').val()},
			success: function(result){
                             $("#result_search").html(result);
//                             $(".dataTable").DataTable();
                        }
                    });
	}
	function get_results_item(cat_id=''){
            var cat = (cat_id!='')?cat_id:$('#category_id').val();
            $("#result_search_items").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
              
            $.ajax({
                    url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
                    type: 'post',
                    data : {function_name:'pagination_dets',category_id:cat},
                    success: function(result){ 
                        pages=result;  
//                        fl_alert('info',pages)
                        var opts = {
                            onPageClick: function (event, page) {
                                $.ajax({
                                    url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
                                    type: 'post',
                                    data : {function_name:'search_items',category_id:cat,item_code:$('#item_code').val(),page_no:page},
                                    success: function(result){
            //                            console.log(result); 
                                         $("#result_search_items").html(result); 
                                         
            //                             $(".dataTable").DataTable();
                                    }
                                });
                            },
                            totalPages: pages,
                            visiblePages: 5,
                        };

                            $('#pagination').twbsPagination('destroy');
                            $('#pagination').twbsPagination(opts); 
                    }
                });
            
            
            
            
	}
});
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
                            <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Category Name:<span style="color: red">*</span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <?php  echo form_dropdown('category_id',$category_list,set_value('category_id'),' class="form-control select2" data-live-search="true" id="category_id"');?>
                                         
                                            </div>                                            
                                            <?php echo form_error('category_id');?>
                                        </div>
                                    </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="col-md-3 control-label">Item Code)<span style="color: red"></span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <?php  echo form_input('item_code',set_value('item_code'),' class="form-control add_item_inpt" data-live-search="true" id="item_code"');?>
                                         
                                            </div>                                            
                                            <?php echo form_error('item_code');?>
                                        </div>
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
            <div class="container">
                   <div class="row form-group ">
                   <div class="col-xs-12">
                       <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                           <li class="active"><a href="#step-1">
                               <h4 class="list-group-item-heading">Categories</h4>
                               <p class="list-group-item-text">Click a category for Item list</p>
                           </a></li>
                           <li class=""><a href="#step-2">
                               <h4 class="list-group-item-heading">Items</h4>
                               <p class="list-group-item-text">Available Item List</p>
                           </a></li>   
                       </ul>
                   </div>
                   </div>
            <div class="row setup-content" id="step-1"> 
                    <!-- /.box-header -->
                   <div  id="result_search" class="box-body"> 


                   </div>
                   <!-- /.box-body -->
            </div>
            <div class="row setup-content" id="step-2">
                    <!-- /.box-header -->
                   <div  id="result_search_items" class="box-body"> 


                   </div>
                    <nav aria-label="Page navigaation">
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                   <!-- /.box-body -->
            </div>
                <div class="row">
                 <div style="padding-top: 5px;" class="col-md-6 col-xs-6 col-sm-6">
                       <a id="cancel_order" href="<?php echo base_url("Sales_orders");?>" type="button" class="btn btn-block btn-primary btn-lg" data-dismiss="modal">Cancel Order</a>
                  </div>
                  <div style="padding-top: 5px;" class="col-md-6 col-xs-6 col-sm-6">
                      <a id="confirm_new_order" href="<?php echo base_url("Sales_order_items/add");?>" type="button" class="btn btn-block btn-success btn-lg">Confirm order</a>
                  </div>
                    
              </div>
           </div>	
          </div>
       
    </section>              
   
     </div>
</div> 
    
<script>
    
     
// Activate Next Step

$(document).ready(function() {
    
    var navListItems = $('ul.setup-panel li a'),
        allWells = $('.setup-content');

    allWells.hide();

    navListItems.click(function(e)
    {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this).closest('li');
        
        if (!$item.hasClass('disabled')) {
            navListItems.closest('li').removeClass('active');
            $item.addClass('active');
            allWells.hide();
            $target.show();
        }
    });
    
    $('ul.setup-panel li.active a').trigger('click');
    
    // DEMO ONLY //
    $('#activate-step-2').on('click', function(e) {
        $('ul.setup-panel li:eq(1)').removeClass('disabled');
        $('ul.setup-panel li a[href="#step-2"]').trigger('click'); 
//        $(this).remove();
    });
    
    
});
    </script>