  
 <!-- Modal Checkout-->
<div class="modal fade"  id="item_price_check_modal" tabindex="-1" role="dialog" aria-labelledby="item_price_check_modal_label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="width: 800px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h3 style="text-align: center" class="modal-title" id="item_price_check_modal_label">Item Price Check
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-x fa-close" aria-hidden="true"></span>
            </button>
        </h3>

      </div> 
        <div class="modal-body " style="height: 500px; overflow: scroll;">
            <div class="box-body">
                <div class="col-md-4"> 
                    <div class="form-group">
                      <label for="pc_item_category_id" class=" control-label">Category</label>
                        <?php echo form_dropdown('pc_item_category_id',$item_category_list,set_value('pc_item_category_id'),' class="form-control  input-lg  " style="width:100%;" data-live-search="true" id="pc_item_category_id"');?>
                      </div>
                </div>
                <div hidden class="col-md-4"> 
                    <div class="form-group">
                      <label for="pc_customer_type_id" class=" control-label">Customer Type</label>
                        <?php echo form_dropdown('pc_customer_type_id',$customer_type_list,set_value('pc_customer_type_id'),' class="form-control  input-lg  " style="width:100%;" data-live-search="true" id="pc_customer_type_id"');?>
                      </div>
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label for="pc_item_desc" class="control-label">Name</label> 
                        <input  type="pc_item_desc" name="pc_item_desc" class="form-control input-lg" id="pc_item_desc" placeholder="Search by Name">
                    </div> 
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label for="pc_item_code" class="control-label">Code</label> 
                        <input  type="pc_item_code" name="pc_item_code" class="form-control input-lg" id="pc_item_code" placeholder="Search by code">
                    </div> 
                </div>
              <div class="col-md-12">
              <hr>
                <div id="result_item_price_check_modal"> 
                </div>
              </div>
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="col-md-6"><a id="pc_submit_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-search"></span> Search</a></div>
          <div class="col-md-6"><a id="pc_back_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-backward"></span> Back</a></div>
      </div> 
    </div>
  </div>
</div>  
     
<script>
    $(document).ready(function(){
       $('#price_check').click(function(){ 
          $('#item_price_check_modal').modal({backdrop: 'static', keyboard: false }); 
       });
       $('#pc_back_btn').click(function(){ 
          $('#item_price_check_modal').modal('toggle'); 
       });
       
       $('#pc_submit_btn').click(function(){ 
            get_modal_item_price_check()
       });
       $('#pc_item_category_id').change(function(){ 
            get_modal_item_price_check()
       });
       $('#pc_item_code').keyup(function(){ 
            get_modal_item_price_check()
       });
       $('#pc_item_desc').keyup(function(){ 
            get_modal_item_price_check()
       });
       
        function get_modal_item_price_check(category='',item_desc='',item_code=''){
            $.ajax({
			url: "<?php echo site_url('Sales_pos/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_item_price_check_modal',item_cat_id:$('#pc_item_category_id').val(),item_desc:$('#pc_item_desc').val(),item_code:$('#pc_item_code').val(),customer_type_id:$('#pc_customer_type_id').val()},
			success: function(result){
                             $("#result_item_price_check_modal").html(result);
                             $(".dataTable").DataTable(); 
                    }
                    
		});
       }
    });
        
        
    
      
</script>