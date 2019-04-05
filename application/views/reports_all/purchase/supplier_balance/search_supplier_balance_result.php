<table  class="pad table dataTable table-bordered table-striped">
                                <thead> 
                                    <tr class="colored_bg">
                                        <th  style="text-align:left;">#</th> 
                                        <th style="text-align:left;">Supplier</th> 
                                        <th style="text-align:left;">City</th> 
                                        <th style="text-align:right;">Total Invoices</th> 
                                        <th style="text-align:right;">Settled AMpont</th> 
                                        <th style="text-align:right;">Outstanding Amount</th>  
                                    </tr>
                                </thead>
                               <tbody>
              <?php
//                       echo '<pre>';                       print_r($rep_data); die;
//                   foreach ($rep_data as $cust_id => $search){ 
//                       echo '<pre>';                       print_r($rep_data); 
                        
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                        
                         $i=1;
                        $g_tot_settled = $g_inv_total = $g_tot_balance=0;
                        if(!empty($rep_data)){
                        foreach ($rep_data as $sup_dets){
                            $tot_settled = $inv_total = $tot_balance=0;
                             if(isset($sup_dets['invoices'])){
                                foreach ($sup_dets['invoices'] as $invoice){
                                    $due_date = $invoice['invoice_date']+(60*60*24*$invoice['days_after']);
                                    $invoice_total = $invoice['invoice_desc_total'];
                                    $cust_payments = (!empty($invoice['transections']))?$invoice['transections'][0]['total_amount']:0;
                                    $pending = $invoice_total-$cust_payments;
                                    if($pending>0){
                                        $inv_total += ($invoice_total/$invoice['currency_value']);
                                        $tot_settled += ($cust_payments/$invoice['currency_value']);
                                        $tot_balance += ($pending/$invoice['currency_value']);
                                    }

                                 }
                            }

                            if($tot_balance>0){
                                $g_inv_total += $inv_total;
                                $g_tot_settled += $tot_settled;
                                $g_tot_balance += $tot_balance;
                                echo    '<tr> 
                                                <td align="left">'.$i.'</td>
                                                <td align="left">'.$sup_dets['supplier']['supplier_name'].' - '.(($sup_dets['supplier']['supplier_ref']!='')?' ['.$sup_dets['supplier']['supplier_ref'].']':'').'</td>
                                                <td align="left">'.$sup_dets['supplier']['city'].'</td>
                                                <td align="right">'.number_format($inv_total,2).'</td>
                                                <td align="right">'.number_format($tot_settled,2).'</td>
                                                <td align="right">'.number_format($tot_balance,2).'</td>
                                            </tr>';

                            $i++;
                            }
                        }
                   }
                   echo '<tr>
                                     <td>No Results found</td> 
                                 </tr>';
                        echo '
                                        <tr> 
                                            <th colspan="3" align="center"></th>
                                            <th style="text-align:right;"><b>'.number_format($g_inv_total,2).'</b></th>
                                            <th style="text-align:right;"><b>'.number_format($g_tot_settled,2).'</b></th> 
                                            <th style="text-align:right;"><b>'.number_format($g_tot_balance,2).'</b></th>
                                        </tr>';
                        echo ' </tbody> </table> ';  
                        
//                   }
              ?>   
        </tbody> 
         </table> 