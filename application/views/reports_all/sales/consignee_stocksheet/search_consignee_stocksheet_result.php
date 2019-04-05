<table id="example1" class="table  dataTable table-bordered table-striped">
        <tbody>
              <?php
                   foreach ($rep_data as $cust_id => $search){ 
//                       echo '<pre>';                       print_r($search); die;
                       
                        echo '<tr>
                                <td><b>'.$search['customer']['customer_name'].'</b></td> 
                            </tr>
                            <table  class="pad table dataTable table-bordered table-striped">
                                <thead>
                                   <tr>
                                       <th>#</th>
                                       <th style="text-align:center;">Invoice No</th> 
                                       <th style="text-align:center;">Date</th>  
                                       <th style="text-align:right;">Total</th> 
                                       <th style="text-align:right;">Settled</th> 
                                       <th style="text-align:center;">Due Date</th>
                                       <th style="text-align:right;">Balace</th>
                                   </tr>
                               </thead>
                               <tbody>
                               </tbody>';
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                        $i = 0; 
                        if(!empty($search['invoices'])){
                            foreach ($search['invoices'] as $invoice){
                                $due_date = $invoice['invoice_date']+(60*60*24*$invoice['days_after']);
                                $invoice_total = $invoice['invoice_desc_total'];
                                $cust_payments = (!empty($invoice['transections']))?$invoice['transections'][0]['total_amount']:0;
                                $pending = $invoice_total-$cust_payments;
                                echo '
                                    <tr>
                                        <td>'.($i+1).'</td> 
                                        <td align="center">'.$invoice['invoice_no'].'</td>
                                        <td align="center">'.(($invoice['invoice_date']>0)?date('d M Y',$invoice['invoice_date']):'').'</td>
                                        <td align="right">'. number_format($invoice_total,2).'</td> 
                                        <td align="right">'. number_format($cust_payments,2).'</td> 
                                        <td align="center">'.date('d M Y',$due_date).'</td> 
                                        <td align="right">'. number_format($pending,2).'</td> 
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
              ?>   
        </tbody> 
         </table> 