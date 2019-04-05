<style>
.btn-huge{
    height: 60px;
    padding-top:18px; 
}     
.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
} 
.btn-circle.btn-xl {
  width: 60px;
  height: 60px;
  padding: 15px 16px;
  font-size: 24px;
  line-height: 1.33;
  border-radius: 35px;
}

</style>
 <!-- Modal Checkout-->
   <?php echo form_open("", 'id="form_add_cust" class="form-horizontal"')?>  
   
<div class="modal fade" id="add_new_customer_model"   role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h5>

      </div> 
      <div class="modal-body form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="new_customer_type_id" class="col-sm-3 control-label">Customer Type</label>
                <div class="col-sm-9"> 
                    <?php  echo form_dropdown('new_customer_type_id',$customer_type_list,set_value('new_customer_type_id','LK'),'style="width:100%" class="form-control input-lg select2" data-live-search="true" id="new_customer_type_id"');?> 
                </div>
              </div>
              <div class="form-group">
                <label for="new_customer_name" class="col-sm-3 control-label">Customer Name<span style="color: red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" name="new_customer_name" class="form-control input-lg checkout_input" id="new_customer_name" placeholder="Customer Name">
                </div>
              </div>  
              <div class="form-group">
                <label for="new_customer_phone" class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-9">
                    <input type="text" name="new_customer_phone" class="form-control input-lg checkout_input" id="new_customer_phone" placeholder="Phone Number">
                </div>
              </div>  
              <div class="form-group">
                <label for="new_customer_address" class="col-sm-3 control-label">Street Address</label>
                <div class="col-sm-9">
                    <input type="text" name="new_customer_new_customer_address" class="form-control input-lg checkout_input" id="new_customer_address" placeholder="Street new_customer_address">
                </div>
              </div>  
              <div class="form-group">
                <label for="new_customer_city" class="col-sm-3 control-label">City<span style="color: red">*</span></label>
                <div class="col-sm-9">
                    <input type="text" name="new_customer_city" class="form-control input-lg checkout_input" id="new_customer_city" placeholder="City Name">
                </div>
              </div>  
              <div class="form-group">
                <label for="new_customer_country_code" class="col-sm-3 control-label">Country</label>
                <div class="col-sm-9"> 
                    <?php  echo form_dropdown('new_customer_country_code',$country_list,set_value('new_customer_country_code','LK'),'style="width:100%" class="form-control input-lg select2" data-live-search="true" id="new_customer_country_code"');?> 
                </div>
              </div>  
                <div id="res_op_mod1"></div>
                
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="row">
              <div class="col-md-6"><a id="back_add_cust"  class="col-md-6 btn btn-block btn-primary btn-lg">Back </a></div>
              <div class="col-md-6"><a id="confirm_add_cust"  class="col-md-6 btn btn-block btn-primary btn-lg">Add Customer</a></div>
          </div>
      </div> 
    </div>
  </div>
</div>  
<?php echo form_close();?>
<script>
    $(document).ready(function(){ 
        $('#add_supp_btn').click(function(){ 
           $('#add_new_customer_model').modal({backdrop: 'static', keyboard: false }); 
        });
        $('#add_new_customer_model').on('shown.bs.modal', function () {
            $('#new_customer_name').focus();
        })  
 
        
        $('#back_add_cust').click(function(){
            $('#add_new_customer_model').modal('toggle'); 
        }); 
        $('#confirm_add_cust').click(function(){  
            
            if($('#new_customer_name').val()=='' || $('#new_customer_name').val().length<3){
                fl_alert('info',"Customer Name Invalid!");
                $('#new_customer_name').focus().select();
                return false;
            }
            if($('#new_customer_city').val()=='' || $('#new_customer_city').val().length<3){
                fl_alert('info',"City Name Invalid!");
                $('#new_customer_city').focus().select();
                return false;
            }
            add_customer_modal(); 
        });
        
    });
    
    function add_customer_modal(){
        var ret_val = 0;
//        var post_data = {name:"function_name",value:'add_customer_quick'}; 
//            post_data.push({name:"function_name",value:'add_customer_quick'}); 
            $.ajax({
                url: "<?php echo site_url('Customers/fl_ajax/');?>",
                type: 'post',
                data : {function_name:'add_customer_quick',
                        customer_name:$('#new_customer_name').val(),
                        phone:$('#new_customer_phone').val(),
                        address:$('#new_customer_address').val(),
                        city:$('#new_customer_city').val(),
                        country:$('#new_customer_country_code').val(),
                        customer_type_id:$('#new_customer_type_id').val()
                        },
                success: function(result){ 
                     $.ajax({
                            url: "<?php echo site_url('Customers/fl_ajax/');?>",
                            type: 'post',
                            data : {function_name:'get_dropdown_formodal'},
                            success: function(dd_data){ 
                                $('#search_customer_id').empty();
                                $('#customer_id').empty();
                                
                                if(dd_data!=''){
                                    ret_val =1;
//                                    console.log(dd_data)
                                    var dd_options  = JSON.parse(dd_data); 
                                    var $select = $('#search_customer_id');   
                                    var $select2 = $('#customer_id');   
                                    $.each(dd_options,function(index, o) { 
                                        var name = o.split(' | ');
                                        var option = $("<option/>").attr("value", index).text(name[0]);
                                        var option2 = $("<option/>").attr("value", index).text(name[1]);
                                         $select.append(option);
                                         $select2.append(option2);
                                     });
                                    $('#search_customer_id').select2();  
                                    $('#add_new_customer_model').modal('toggle'); 
                                    $('#search_customer_id').val(result).change();  
                                }else{  
                                    fl_alert('info',"Something went wrong!");
                                }
                            }
                    });
                    
                }
            }); 
    }
</script>