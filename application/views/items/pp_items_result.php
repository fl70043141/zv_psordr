<table class="table table-bordered">
                                                          <tbody>
                                                              <tr>
                                                                  <th>Supplier</th>
                                                                  <th>Price</th>
                                                                  <th>Currency</th> 
                                                                  <th>Supplier Unit</th> 
                                                                  <th>Conversation</th> 
                                                                  <th>Description</th> 
                                                                  <th>Action</th> 
                                                              </tr>
                                                              <?php
                                                              if(isset($item_prices)){
                                                                foreach($item_prices['purchasing'] as $purchasing_price){
//                                                                    echo '<pre>'; print_r($purchasing_price); die;
                                                                    echo '
                                                                         <tr>
                                                                            <td>'.$purchasing_price['supplier_name'].'</td>
                                                                            <td>'. number_format($purchasing_price['price_amount'],2).'</td>
                                                                            <td>'.$purchasing_price['currency_code'].'</td>
                                                                            <td>'.$purchasing_price['supplier_unit'].'</td>
                                                                            <td>'.$purchasing_price['supplier_unit_conversation'].'</td>
                                                                            <td>'.$purchasing_price['note'].'</td>
                                                                            <td><span id="'.$purchasing_price['id'].'" class="fa fa-trash btn btn-danger price_del_btn"></span></td>
                                                                          </tr>
                                                                        ';
                                                              }}
                                                              ?>
                                                              
                                                          </tbody></table>

<script>
    
$(document).ready(function(){   
    $(".price_del_btn").click(function(){  
         var price_id = this.id;
         if(confirm("Click Ok to confirm delete price.")){
             remove_price(price_id);
         }else{
             return false;
         }
		
    });
    function remove_price(id){
        $.ajax({
			url: "<?php echo site_url('Items/remove_price/');?>/"+id,
			type: 'post',
			data : jQuery('#form_mng').serializeArray(),
			success: function(result){
                             $("#pp_result").html(result);
                        }
		});
    }
    
});

 
</script>