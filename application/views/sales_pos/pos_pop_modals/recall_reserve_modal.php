  
 <!-- Modal Checkout-->
<div class="modal fade"  id="recall_reserve_modal"role="dialog" aria-labelledby="recall_reserve_modal_label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="width: 800px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h3 style="text-align: center" class="modal-title" id="recall_reserve_modal_label">Recall Reserved Invoice
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-x fa-close" aria-hidden="true"></span>
            </button>
        </h3>

      </div> 
        <div class="modal-body " style="height: 500px; overflow: scroll;">
            <div class="box-body">  
                <div class="col-md-6">
                     <div class="form-group">
                        <label for="recl_res_no" class="control-label">Reservation No</label> 
                        <input  type="recl_res_no" name="recl_res_no" class="form-control input" id="recl_res_no" placeholder="Search by Reservation No..">
                    </div> 
                </div>
                
                <div class="col-md-6"> 
                    <div class="form-group">
                      <label for="" class=" control-label">Customer</label>
                        <?php echo form_dropdown('recl_res_customer_id',$customer_list,set_value('recl_res_customer_id'),' class="form-control  input-lg select2 " style="width:100%;" data-live-search="true" id="recl_res_customer_id"');?>
                        
                    </div>
                </div>
              <div class="col-md-12">
              <hr>
                <div id="result_recall_reserve_modal"> 
                </div>
              </div>
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="col-md-6"><a id="recl_submit_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-search"></span> Search</a></div>
          <div class="col-md-6"><a id="recl_back_btn"  class="btn btn-block btn-primary btn-lg"><span class="fa fa-backward"></span> Back</a></div>
      </div> 
    </div>
  </div>
</div>  
     
<script>
    $(document).ready(function(){
       $('#reserve_item_recall_btn').click(function(){ 
          $('#recall_reserve_modal').modal({backdrop: 'static', keyboard: false });
       });
       $('#recall_reserve_modal').on('shown.bs.modal', function () {
          $('#recl_res_no').focus().select();
        })  
       $('#recl_back_btn').click(function(){ 
          $('#recall_reserve_modal').modal('toggle'); 
       });
       
       $('#recl_submit_btn').click(function(){ 
            get_modal_stock_check()
       }); 
       
       
    if($('input[name=temp_inv_id_recall]').val()!=''){
        var temp_inv_id_recall = $('input[name=temp_inv_id_recall]').val();
        $('input[name=temp_inv_id_recall]').val('');
        load_temp_invoice_resreve(temp_inv_id_recall);
    }
       
        function get_modal_stock_check(category='',item_desc='',item_code=''){
            $.ajax({
			url: "<?php echo site_url('Sales_pos/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_recall_reserve_modal',recl_res_no:$('#recl_res_no').val(),recl_cust_id:$('#recl_res_customer_id').val()},
			success: function(result){
                             $("#result_recall_reserve_modal").html(result);
                             $(".dataTable").DataTable(); 
                             
                              $('.reserve-search-pick').click(function(){
//                                  fl_alert('info',)
                                var resrv_temp_inv_id = (this.id).split("_");
//                                fl_alert('info',resrv_temp_inv_id[1])
                                load_temp_invoice_resreve(resrv_temp_inv_id[1]);
                            });
                    }
                    
		});
       }
    });
        
        
    function load_temp_invoice_resreve(tmp_invoice_id){ 
                                    
//                                        return false;
            $.ajax({
                url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=recall_reserve_temp_invoice');?>",
                type: 'post',
                data : {function_name:"recall_reserve_temp_invoice",tmp_invoice_id:tmp_invoice_id,inv_stat:2,location_id:$('#location_id').val()},
                success: function(result){ 
//                    console.log(result)
                     location.reload(); 
                }
            });
        }
      
</script>