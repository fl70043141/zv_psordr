
<!--                                        <div id="res21">aa
                                        </div>-->
                                        <div id="invoice_function_btns">
                                                    <div class="col-md-12 "> 
                                                        <img style="margin: 5px 0 0 30px; width: 70%; overflow: hidden" src="<?php echo base_url(COMPANY_LOGO.'logo.png');?>">
                                                    </div>
                                                    <div class="col-md-12 ">  
                                                        <br>     
                                                        <a  id="pause_func_btn"  title="pause Sale" href="#" class="btn btn-sq-lg  btn-primary">
                                                            <i style="width:96px;height:80px;" class="fa fa-pause fa-5x"></i><br/>
                                                            Hold
                                                        </a> 
                                                        <a  id="pick_held_func_btn"  title="Cancel Sale" href="#" class="btn btn-sq-lg  btn-primary">
                                                            <i style="width:96px;height:80px;" class="fa fa-refresh fa-5x"></i><br/>
                                                            Reload Window
                                                        </a>            
                                                    </div> 
                                                    <div  style="margin-top: 3px;" class="col-md-12">  
                                                        <a  id="cancel_func_btn" href="#" class="btn btn-sq-lg btn-primary">
                                                            <i  style="width:96px;height:80px;" class="fa fa-close fa-5x"></i><br/>
                                                            Cancel
                                                        </a>    
                                                        <a id="print_func_btn" href="#" class="btn btn-sq-lg btn-primary">
                                                            <i  style="width:96px;height:80px;" class="fa fa-print fa-5x"></i><br/>
                                                             Print
                                                        </a>    
                                                    </div>  
                                        </div>

<script>
    $(document).ready(function(){
        $('#print_func_btn').click(function(){ 
            var post_data = jQuery('#form_search').serializeArray(); 
            post_data.push({name:"function_name",value:'pos_print_direct'});
    
            $.ajax({
			url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=pos_print_direct');?>",
			type: 'post',
			data : post_data,
			success: function(result){
                            $('#res21').html(result);
//                            fl_alert('info',"oko");
//                            set_list_items(result);
                        }
		});
        });
        
        $('#cancel_func_btn').click(function(){
           cancel_temp_invoice()
        });
        $('#pause_func_btn').click(function(){
           pause_temp_invoice()
        });  
        $('#reserve_item').click(function(){
          reserve_temp_invoice();
        });  
         
        $('#pick_held_func_btn').click(function(){  
           location.reload();
        }); 
        
         function cancel_temp_invoice(){ 
             if(!confirm("Press Ok to cancel current Invoice.")){
                 return false;
             }
            $.ajax({
                url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=cancel_temp_invoice');?>",
                type: 'post',
                data : {function_name:"cancel_temp_invoice"},
                success: function(result){ 
                     location.reload(); 
                }
            });
        }
         function pause_temp_invoice(resrv_stat=0){ 
             if(!confirm("Press Ok to Hold current Invoice.")){
                 return false;
             }
//                 return false;
            $.ajax({
                url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=pause_temp_invoice');?>",
                type: 'post',
                data : {function_name:"pause_temp_invoice",reserve_stat:resrv_stat,location_id:$('#location_id').val()},
                success: function(result){ 
//                    console.log(result)
                     location.reload(); 
                }
            });
        }
         function reserve_temp_invoice(resrv_stat=0){  
            $.ajax({
                url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=reserve_temp_invoice');?>",
                type: 'post',
                data : {function_name:"reserve_temp_invoice",reserve_stat:1,location_id:$('#location_id').val()},
                success: function(result){ 
//                    console.log(result)
                     location.reload(); 
                }
            });
        }
        
        //hold invoice
        $.ajax({
			url: "<?php echo site_url('Dashboard/fl_ajax');?>",
			type: 'post',
			data : {function_name:'get_temp_sales_invoice_user'},
			success: function(result){
//                            console.log(result)
                            $('#temp_invoice_top_list_res').html(result); //top header bar element
                            
                             $('.invtmp').click(function(){
                                var tmp_id = (this.id).split('_')[1]; 
                                if(!confirm("Press Ok to Recall Pused Invoice.")){
                                        return false;
                                    }
                                    load_temp_invoice(tmp_id);
                             });
                             
                             
                              function load_temp_invoice(tmp_invoice_id){ 
                                    
//                                        return false;
                                   $.ajax({
                                       url: "<?php echo site_url('Sales_pos/fl_ajax?function_name=load_temp_invoice');?>",
                                       type: 'post',
                                       data : {function_name:"load_temp_invoice",tmp_invoice_id:tmp_invoice_id},
                                       success: function(result){  
                                            location.reload(); 
                                       }
                                   });
                               }
                        }
        });
        
    });
</script>