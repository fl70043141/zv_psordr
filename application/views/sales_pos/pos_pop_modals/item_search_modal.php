  
 <!-- Modal Checkout-->
<div class="modal fade"  id="item_search_modal" tabindex="-1" role="dialog" aria-labelledby="item_search_modal_label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="width: 800px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h3 style="text-align: center" class="modal-title" id="item_search_modal_label">Item Search
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-x fa-close" aria-hidden="true"></span>
            </button>
        </h3>

      </div> 
        <div class="modal-body " style="height: 500px; overflow: scroll;">
            <div class="box-body">
                <div class="col-md-4"> 
                    <div class="form-group">
                      <label for="search_item_category_id" class=" control-label">Category</label>
                        <?php echo form_dropdown('search_item_category_id',$item_category_list,set_value('search_item_category_id'),' class="form-control  input-lg  " style="width:100%;" data-live-search="true" id="search_item_category_id"');?>
                      </div>
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label for="search_item_desc" class="control-label">Name</label> 
                        <input  type="search_item_desc" name="search_item_desc" class="form-control input-lg" id="search_item_desc" placeholder="Search by Name">
                    </div> 
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label for="search_item_code" class="control-label">Code</label> 
                        <input  type="search_item_code" name="search_item_code" class="form-control input-lg" id="search_item_code" placeholder="Search by code">
                    </div> 
                </div>
                
              <div hidden class="col-md-12 no-padding" id="gem_search_div">
                  <div class="col-md-4"> 
                        <div class="form-group">
                            <label for="search_item_treatment_id" class=" control-label">Treatments</label>
                            <?php echo form_dropdown('search_item_treatment_id',$treatments_list,set_value('search_item_treatment_id'),' class="form-control  input-lg  " style="width:100%;" data-live-search="true" id="search_item_treatment_id"');?>
                        </div>
                  </div>
                  <div class="col-md-4"> 
                        <div class="form-group">
                            <label for="search_item_color_id" class=" control-label">Color</label>
                            <?php echo form_dropdown('search_item_color_id',$color_list,set_value('search_item_color_id'),' class="form-control  input-lg  " style="width:100%;" data-live-search="true" id="search_item_color_id"');?>
                        </div>
                  </div>
                  <div class="col-md-4"> 
                        <div class="form-group">
                            <label for="search_item_shape_id" class=" control-label">Shape</label>
                            <?php echo form_dropdown('search_item_shape_id',$shape_list,set_value('search_item_shape_id'),' class="form-control  input-lg  " style="width:100%;" data-live-search="true" id="search_item_shape_id"');?>
                        </div>
                  </div>
              </div>
              <div class="col-md-12">
              <hr>
                <div id="result_item_search_modal"> 
                </div>
              </div>
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="col-md-6"><a id="search_submit_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-search"></span> Search</a></div>
          <div class="col-md-6"><a id="search_back_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-backward"></span> Back</a></div>
      </div> 
    </div>
  </div>
</div>  
     
<script>
    $(document).ready(function(){
       $('#top_item_search').click(function(){ 
          $('#item_search_modal').modal({backdrop: 'static', keyboard: false }); 
       });
       $('#search_back_btn').click(function(){ 
          $('#item_search_modal').modal('toggle'); 
       });
       
       $('#search_submit_btn').click(function(){ 
            get_modal_item_search()
       });
       $('#search_item_category_id').change(function(){ 
            get_modal_item_search()
       });
       $('#search_item_treatment_id').change(function(){ 
            get_modal_item_search()
       });
       $('#search_item_shape_id').change(function(){ 
            get_modal_item_search()
       });
       $('#search_item_color_id').change(function(){ 
            get_modal_item_search()
       });
       $('#search_item_code').keyup(function(){ 
            get_modal_item_search()
       });
       $('#search_item_desc').keyup(function(){ 
            get_modal_item_search()
       });
       
        function get_modal_item_search(category='',item_desc='',item_code=''){
            $.ajax({
			url: "<?php echo site_url('Sales_pos/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_category_info',item_cat_id:$('#search_item_category_id').val()},
			success: function(result){
                            var cat_info =  JSON.parse(result); 
                            if(cat_info.is_gem == '1'){
                                $('#gem_search_div').show();
                            }else{
                                $('#gem_search_div').hide();
                            }
                             
                    }
                    
		});
            $.ajax({
			url: "<?php echo site_url('Sales_pos/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_item_search_modal',item_cat_id:$('#search_item_category_id').val(),item_desc:$('#search_item_desc').val(),item_code:$('#search_item_code').val(),
                                        treatment_id:$('#search_item_treatment_id').val(),
                                        color_id:$('#search_item_color_id').val(),
                                        shape_id:$('#search_item_shape_id').val()
                                },
			success: function(result){
                             $("#result_item_search_modal").html(result);
                             $(".dataTable").DataTable();
                             
                            $('.item-search-pick').click(function(){
                                var ism_item_code = (this.id).split("_");
//                                fl_alert('info',ism_item_code[1])
                                $('#barcode_input').val(ism_item_code[1]);
//                                $('#item_code').val(ism_item_code[1]);
//                                $('#item_code').trigger('keyup');
                                $('#barcode_input').trigger('change');
                                $('#add_item_btn').trigger('click');
                            });
                    }
                    
		});
       }
    });
        
        
    
      
</script>