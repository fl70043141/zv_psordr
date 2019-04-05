    <table id="example1" class="table dataTable table-bordered table-striped">
               <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th> 
                            <th>Total Rent</th>
                            <th>Total Garage</th> 
                            <th>Total Pending</th> 
                        </tr>
                    </thead>
                    <tbody >
                       

                      
<?php
        $i = 0;
       foreach ($search_list as $search){ 
           $total_res_pending = $total_invoice_pending = 0;
           if(isset($search['res_charges_all'])){
                foreach ($search['res_charges_all'] as $res_charge){
                    $total_res_pending += $res_charge['total'];
                }
            }
            
           if(isset($search['invoices_all'])){
                foreach ($search['invoices_all'] as $inv_charge){
                    $total_invoice_pending += $inv_charge['invoice_total'];
                }
           }
            
//                echo '<pre>';           print_r($total_invoice_pending); die;
            echo '
                <tr>
                    <td>'.($i+1).'</td>
                    <td>'.$search['info']['customer_name'].'</td>
                    <td>'. number_format($total_res_pending,2).'</td>
                    <td>'. number_format($total_invoice_pending,2).'</td>
                    <td>'. number_format(($total_invoice_pending+$total_res_pending),2).'</td> 
                </tr> ';
            $i++;
        }
       ?>
</tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Customer</th> 
                    <th>Total Rent</th>
                    <th>Total Garage</th> 
                    <th>Total Pending</th> 
                </tr>
                </tr>
                </tfoot>
              </table> 