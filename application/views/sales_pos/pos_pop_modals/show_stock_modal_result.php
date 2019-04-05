
                 <table id="example1" class="table dataTable table-bordered table-striped">
                        <thead>
                           <tr>
                               <th>#</th> 
                               <th>Item code</th> 
                               <th>Item name</th> 
                               <th>Category</th>  
                               <th>Unit of Measure</th> 
                               <th>Units</th> 
                           </tr>
                       </thead>
                       <tbody>
                           <?php
                                $i=1;
                                foreach ($item_res as $item){
                                    
//                echo '<pre>';            print_r($item); die; 
                                    echo '
                                            <tr class="item-search-pick" id="item-search-picktr_'.$item['item_code'].'" >
                                                <td>'.$i.'</td>
                                                <td>'.$item['item_code'].'</td>
                                                <td>'.$item['item_name'].'</td>
                                                <td>'.$item['category_name'].'</td>  
                                                <td>'.$item['unit_abbreviation'].'</td>   
                                                <td>'.$item['total_units'].'</td>   
                                           </tr> 
                                        ';
                                }
                           ?>
                            
                       </tbody>
                          <tfoot>
                          <tr>
                               <th>#</th> 
                               <th>Item code</th> 
                               <th>Item name</th> 
                               <th>Category</th> 
                               <th>Price</th>  
                               <th>Unit of Measure</th> 
                           </tr>
                          </tfoot>
                        </table> 