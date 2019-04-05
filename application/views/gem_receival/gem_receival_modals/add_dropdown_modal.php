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
   <?php echo form_open("", 'id="form_add_dropdown" class="form-horizontal"')?>  
   
<div class="modal fade" id="add_dropdown_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New <span class="name_title"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h5>

      </div> 
      <div class="modal-body form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="dropdown_value" class="col-sm-3 control-label"><span class="name_title"></span> Name<span style="color: red">*</span></label>
                <div class="col-sm-9">
                    <input type="dropdown_value" name="dropdown_value" class="form-control input-lg checkout_input" id="dropdown_value" placeholder="Drop Down Value">
                </div>
              </div>    
              <div hidden class="form-group">
                <label for="dropdown_id" class="col-sm-3 control-label">Name<span style="color: red">*</span></label>
                <div class="col-sm-9">
                    <input type="dropdown_id" name="dropdown_id" class="form-control input-lg checkout_input" id="dropdown_id" placeholder="Supplier Name">
                    <input hidden id="temp_select_id" value="0">
                </div>
              </div>    
                <div id="res_op_mod2"></div>
                
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="row">
              <div class="col-md-6"><a id="back_add_dropdown"  class="col-md-6 btn btn-block btn-primary btn-lg">Back </a></div>
              <div class="col-md-6"><a id="confirm_add_dropdown"  class="col-md-6 btn btn-block btn-primary btn-lg">Add New</a></div>
          </div>
      </div> 
    </div>
  </div>
</div>  
<?php echo form_close();?>
<script>
    $(document).ready(function(){  
        
        $('#add_dropdown_modal').on('shown.bs.modal', function () {
            $('#dropdown_value').focus();
        })  
 
        
        $('#back_add_dropdown').click(function(){
            $('#add_dropdown_modal').modal('toggle'); 
        }); 
        $('#confirm_add_dropdown').click(function(){  
            
            if($('#dropdown_value').val()=='' || $('#dropdown_value').val().length<2){
                fl_alert('info',"Input Name Invalid!");
                $('#dropdown_value').focus().select();
                return false;
            } 
            add_dropdown_modal(); 
                $('#dropdown_value').val('');
        });
        
    });
    
    function add_dropdown_modal(){
        var ret_val = 0;
        var temp_select_id = $('#temp_select_id').val();
        var post_data = jQuery('#form_add_dropdown').serializeArray(); 
            post_data.push({name:"function_name",value:'add_dropdown_quick'}); 
            $.ajax({
                url: "<?php echo site_url('DropDownList/fl_ajax/');?>",
                type: 'post',
                data : post_data,
                success: function(result){ 
                     $.ajax({
                            url: "<?php echo site_url('DropDownList/fl_ajax/');?>",
                            type: 'post',
                            data : {function_name:'get_dropdown_formodal', dd_name_id:$('#dropdown_id').val(),first_null_option:'No Selection'},
                            success: function(dd_data){
//                            fl_alert('info',)    $('#res_op_mod2').html(dd_data); 
                                var input_dpname_id = $('#dropdown_id').val();
                                var $select = $('#'+temp_select_id);
                                $select.empty();
                                if(dd_data!=''){
                                    ret_val =1;
//                                    console.log(dd_data)
                                    var dd_options  = JSON.parse(dd_data); 
                                    $.each(dd_options,function(index, o) { 
                                         var option = $("<option/>").attr("value", index).text(o);
                                         $select.append(option);
                                     });
//                                    $select.select2();  
                                    $select.val(result).change();
                                    $('#add_dropdown_modal').modal('toggle'); 
                                }else{  
                                    fl_alert('info',"Something went wrong!");
                                }
                            }
                    });
                    
                }
            }); 
    }
</script>