
                 <table id="example1" class="table dataTable table-bordered table-striped">
                        <thead>
                           <tr>
                               <th>#</th> 
                               <th>Reservation No</th> 
                               <th>Customer</th>  
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php
//                echo '<pre>';            print_r($item_res); die; 
                                $i=1;
                                foreach ($item_res as $item){
                                    echo '
                                            <tr class="reserve-search-pick" id="item-search-picktr_'.$item['id'].'" >
                                                <td>'.$i.'</td>
                                                <td>'.$item['temp_invoice_no'].'</td> 
                                                <td>'.$item['customer_name'].'</td>   
                                                <td><a id="reserve-search-pick_'.$item['id'].'" class="btn btn-success btn-xs "><span class="fa fa-cart-plus"></span></a></td>
                                           </tr> 
                                        ';
                                }
                           ?>
                            
                       </tbody>
                          <tfoot>
                          <tr>
                               <th>#</th> 
                               <th>Reservation No</th> 
                               <th>Customer</th>  
                               <th>Action</th>
                           </tr>
                          </tfoot>
                        </table> 