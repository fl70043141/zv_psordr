<table id="example1" class="table  dataTable table-bordered table-striped">
        <tbody>
              <?php
              if(isset($trans_group_list) && !empty($trans_group_list)){
                   foreach ($trans_group_list as $glcm_id => $search){
                       
                        echo '<tr>
                                <td><b>'.$search[0]['type_name'].'</b></td> 
                            </tr>
                            <table  class="pad table dataTable table-bordered table-striped">
                                <thead>
                                   <tr>
                                       <th>#</th>
                                       <th style="text-align:center;">Account Name</th> 
                                       <th style="text-align:center;">Amount</th>  
                                   </tr>
                               </thead>
                               <tbody>
                               </tbody>';
//                       echo '<pre>';                       print_r($search); die;
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                        $i = 0; 
                        if(!empty($search)){
                            foreach ($search as $trans){
//                                $due_date = $invoice['invoice_date']+(60*60*24*$invoice['days_after']);
//                                $invoice_total = $invoice['invoice_desc_total'];
//                                $cust_payments = (!empty($invoice['transections']))?$invoice['transections'][0]['total_amount']:0;
//                                $pending = $invoice_total-$cust_payments;
                                echo '
                                    <tr>
                                        <td>'.($i+1).'</td> 
                                        <td align="center">'.$trans['glcm_account_name'].'</td>
                                        <td align="right">'. number_format($trans['glcm_tot_amount'],2).'</td> 
                                    </tr>';
                                $i++;
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
              }else{
                echo '<tr>
                        <td>No Results found</td> 
                    </tr>'; 
              }
              ?>   
        </tbody> 
         </table> 