<table id="example1" class="table dataTable table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Reservation No</th> 
                <th>Customer Name</th>  
                <th>Customer Phone</th>  
                <th>Action</th>
            </tr>
        </thead>
       
        <tbody>
            <?php
//                echo '<pre>';            print_r($search_list); die; 
                 $i=1;
                 foreach ($search_list as $item){
                     echo '
                             <tr class="reserve-search-pick" id="item-search-picktr_'.$item['id'].'" >
                                 <td>'.$i.'</td>
                                 <td>'.$item['temp_invoice_no'].'</td> 
                                 <td>'.$item['customer_name'].'</td>   
                                 <td>'.$item['phone'].'</td>   
                                 <td>
                                 <a id="reserve-search-pick_'.$item['id'].'" class="btn btn-success btn-xs temp_reserve_call_btn"><span class="fa fa-cart-plus"></span></a>';
                                echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?' <a id="reserve-search-delete_'.$item['id'].'"  title="Delete" class="btn btn-danger btn-xs temp_reserve_delete_btn"><span class="fa fa-remove"></span></a> ':'';
                                   
                                     
                                echo ' </td>
                            </tr> 
                         ';
                 }
            ?>

        </tbody>
           <tfoot>
           <tr>
               <th>#</th>
                <th>Category</th>
                <th>Item type</th>  
               <th>Customer Phone</th>
               <th>Action</th>
           </tr>
           </tfoot>
         </table>
<div id="result11"></div>
<script>
    
$(document).ready(function(){  
    
    $('.temp_reserve_call_btn').click(function(){
        if(!confirm("Do you want to recall this Reserved invoice?")){
            return false;
        }
        var resrv_temp_inv_id = (this.id).split("_");
        $.ajax({
                 url: "<?php echo site_url('Reservations/fl_ajax?function_name=set_temp_inv_id');?>",
                 type: 'post',
                 data : {function_name:'set_temp_inv_id', temp_inv_id:resrv_temp_inv_id[1]},
                 success: function(result){
//                     $('#result11').html(result)
//                     alert(result)
                     location.href = "<?php echo base_url('Sales_pos/add');?>";
                 }
         }); 
    }); 
    $('.temp_reserve_delete_btn').click(function(){
        if(!confirm("Clock ok confirm cancellation of Reserved invoice?")){
            return false;
        }
        var resrv_temp_inv_id = (this.id).split("_");
//        return false;
        $.ajax({
                 url: "<?php echo site_url('Reservations/fl_ajax?function_name=remove_temp_invoice');?>",
                 type: 'post',
                 data : {function_name:'remove_temp_invoice', temp_inv_id:resrv_temp_inv_id[1] },
                 success: function(result){
                     location.reload();
                 }
         }); 
    }); 
});
</script>