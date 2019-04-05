  
 <!-- Modal Checkout-->
<div class="modal fade"  id="customer_search_modal"  role="dialog" aria-labelledby="customer_search_modal_label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="width: 800px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h3 style="text-align: center" class="modal-title" id="customer_search_modal_label">Customers
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-x fa-close" aria-hidden="true"></span>
            </button>
        </h3>

      </div> 
        <div class="modal-body " style="height: 500px; overflow: scroll;">
            <div class="box-body">
                <div class="col-md-4"> 
                    <div class="form-group">
                      <label for="" class=" control-label">Customer</label>
                        <?php echo form_dropdown('search_customer_id',$customer_list,set_value('search_customer_id'),' class="form-control  input-lg select2 " style="width:100%;" data-live-search="true" id="search_customer_id"');?>
                        <a id="add_supp_btn" class="btn btn-primary pull-right btn-xs "><span class="fa fa-plus"></span></a>
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label for="search_customer_code" class="control-label">Code</label> 
                        <input  type="search_customer_code" name="search_customer_code" class="form-control input-lg" id="search_customer_code" placeholder="Search by Name">
                    </div> 
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label for="search_customer_phone" class="control-label">Phone</label> 
                        <input  type="search_customer_phone" name="search_customer_phone" class="form-control input-lg" id="search_customer_phone" placeholder="Search by code">
                    </div> 
                </div>
              <div class="col-md-12">
              <hr>
                <div id="result_customer_search_modal"> 
                </div>
              </div>
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="col-md-6"><a id="cust_search_submit_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-search"></span> Search</a></div>
          <div class="col-md-6"><a id="cust_search_back_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-backward"></span> Back</a></div>
      </div> 
    </div>
  </div>
</div>  
 <style>
    #customer_search_modal .select2-container--default .select2-selection--single{height: 46px;}
    #customer_search_modal .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 39px;}
</style>

<script>
    $(document).ready(function(){
       $('#top_customer_search').click(function(){ 
          $('#customer_search_modal').modal({backdrop: 'static', keyboard: false }); 
       });
       $('#cust_search_back_btn').click(function(){ 
          $('#customer_search_modal').modal('toggle'); 
       });
       
       $('#cust_search_submit_btn').click(function(){ 
            get_modal_item_search()
       });
       $('#search_customer_id').change(function(){ 
            get_modal_item_search()
       });
       $('#search_customer_code').keyup(function(){ 
            get_modal_item_search()
       });
       $('#search_customer_phone').keyup(function(){ 
            get_modal_item_search()
       });
       
        $('#cust_refname').text($( "#customer_id option:selected" ).text()); 
        function get_modal_item_search(category='',item_desc='',item_code=''){
            $.ajax({
			url: "<?php echo site_url('Sales_pos/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_customer_search_modal',search_customer_id:$('#search_customer_id').val(),costemer_code:$('#search_customer_code').val(),costomer_phone:$('#search_customer_phone').val()},
			success: function(result){
                             $("#result_customer_search_modal").html(result);
                             $(".dataTable").DataTable();
                             
                            $('.customer-search-pick').click(function(){
//                                fl_alert('info',)
                                var ism_cust_code = (this.id).split("_");
                                $('#customer_id').val(ism_cust_code[1]); 
                                $('#cust_refname').text($( "#customer_id option:selected" ).text()); 
                                set_temp_invoice();
                                get_customers_addons();
                                $('#customer_search_modal').modal('toggle'); 
                            });
                    }
                    
		});
       }
    });
        
        
    
      
</script>