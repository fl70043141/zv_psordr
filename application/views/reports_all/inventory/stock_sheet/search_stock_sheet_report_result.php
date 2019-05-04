<table id="example1" class="table  dataTable table-bordered table-striped">
        <tbody>
              <?php
                   foreach ($rep_data as $cust_id => $search){ 
//                       echo '<pre>';                       print_r($search); die;
                       
                        echo '<tr>
                                <td><b>'.$search['item_category_name'].'</b></td> 
                            </tr>
                            <table  class="pad table dataTable table-bordered table-striped">
                                <thead>
                                   <tr>
                                       <th>#</th>
                                       <th style="text-align:center;">Code</th> 
                                       <th style="text-align:left;">Desc</th>  
                                       <th style="text-align:center;">In Stock</th>  
                                   </tr>
                               </thead>
                               <tbody>
                               </tbody>';
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                        $i = 0; 
                        if(!empty($search['item_list'])){
                            foreach ($search['item_list'] as $item){ 
                                if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                    echo '
                                        <tr>
                                            <td>'.($i+1).'</td> 
                                            <td align="center">'.$item['item_code'].'</td>
                                            <td align="left">'.$item['item_name'].'</td>
                                            <td align="center">'.$item['units_available'].' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$item['units_available_2'].' '.$item['uom_name_2']:'').'</td>
                                        </tr>';
                                    $i++;
                                }
                            }
                       }else{
                            echo '<tr>
                                    <td>No Results found</td> 
                                </tr>';
                       }
                        echo '<tr>  <td colspan="6"></td</tr>   
                            
                            </table>
                            ';
                   }
              ?>   
        </tbody> 
         </table> 