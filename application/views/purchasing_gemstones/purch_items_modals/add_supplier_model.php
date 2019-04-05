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
   <?php echo form_open("", 'id="form_add_sup" class="form-horizontal"')?>  
   
<div class="modal fade" id="add_supplier_model"   role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Supplier
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h5>

      </div> 
      <div class="modal-body form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="supplier_name" class="col-sm-3 control-label">Supplier Name<span style="color: red">*</span></label>
                <div class="col-sm-9">
                    <input type="supplier_name" name="supplier_name" class="form-control input-lg checkout_input" id="supplier_name" placeholder="Supplier Name">
                </div>
              </div>  
              <div class="form-group">
                <label for="phone" class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-9">
                    <input type="phone" name="phone" class="form-control input-lg checkout_input" id="phone" placeholder="Phone Number">
                </div>
              </div>  
              <div class="form-group">
                <label for="address" class="col-sm-3 control-label">Street Address</label>
                <div class="col-sm-9">
                    <input type="address" name="address" class="form-control input-lg checkout_input" id="address" placeholder="Street address">
                </div>
              </div>  
              <div class="form-group">
                <label for="city" class="col-sm-3 control-label">City<span style="color: red">*</span></label>
                <div class="col-sm-9">
                    <input type="city" name="city" class="form-control input-lg checkout_input" id="city" placeholder="City Name">
                </div>
              </div>  
              <div class="form-group">
                <label for="city" class="col-sm-3 control-label">Country</label>
                <div class="col-sm-9"> 
                    <?php  echo form_dropdown('country',$country_list,set_value('country','LK'),'style="width:100%" class="form-control input-lg select2" data-live-search="true" id="country"');?> 
                </div>
              </div>  
                <div id="res_op_mod1"></div>
                
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="row">
              <div class="col-md-6"><a id="back_add_supp"  class="col-md-6 btn btn-block btn-primary btn-lg">Back </a></div>
              <div class="col-md-6"><a id="confirm_add_supp"  class="col-md-6 btn btn-block btn-primary btn-lg">Add Supplier</a></div>
          </div>
      </div> 
    </div>
  </div>
</div>  
<?php echo form_close();?>
<script>
    $(document).ready(function(){ 
        $('#add_supp_btn').click(function(){ 
           $('#add_supplier_model').modal({backdrop: 'static', keyboard: false }); 
        });
        $('#add_supplier_model').on('shown.bs.modal', function () {
            $('#supplier_name').focus();
        })  
 
        
        $('#back_add_supp').click(function(){
            $('#add_supplier_model').modal('toggle'); 
        }); 
        $('#confirm_add_supp').click(function(){  
            
            if($('#supplier_name').val()=='' || $('#supplier_name').val().length<3){
                fl_alert('info',"Supplier Name Invalid!");
                $('#supplier_name').focus().select();
                return false;
            }
            if($('#city').val()=='' || $('#city').val().length<3){
                fl_alert('info',"City Name Invalid!");
                $('#city').focus().select();
                return false;
            }
            add_supplier_modal(); 
        });
        
    });
    
    function add_supplier_modal(){
        var ret_val = 0;
        var post_data = jQuery('#form_add_sup').serializeArray(); 
            post_data.push({name:"function_name",value:'add_suuplier_quick'}); 
                
            $.ajax({
                url: "<?php echo site_url('Suppliers/fl_ajax/');?>",
                type: 'post',
                data : post_data,
                success: function(result){ 
                     $.ajax({
                            url: "<?php echo site_url('Suppliers/fl_ajax/');?>",
                            type: 'post',
                            data : {function_name:'get_dropdown_formodal'},
                            success: function(dd_data){  
                                $('#supplier_id').empty();
                                if(dd_data!=''){
                                    ret_val =1;
                                    console.log(dd_data)
                                    var dd_options  = JSON.parse(dd_data); 
                                    var $select = $('#supplier_id');   
                                    $.each(dd_options,function(index, o) { 
                                         var option = $("<option/>").attr("value", index).text(o);
                                         $select.append(option);
                                     });
                                    $('#supplier_id').select2();  
                                    $('#supplier_id').val(result).change();
                                    $('#add_supplier_model').modal('toggle'); 
                                }else{  
                                    fl_alert('info',"Something went wrong!");
                                }
                            }
                    });
                    
                }
            }); 
    }
</script>