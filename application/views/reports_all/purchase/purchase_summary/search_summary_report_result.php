<style>
    .table-bordered{
        line-height: 10px;
    }
</style>
<table id="example1" class="table  dataTable table-bordered table-striped">
        <tbody>
              <?php
              if(!empty($rep_data)){
                   foreach ($rep_data as $cust_id => $search){ 
                       if(isset($search['invoices'])){
                       if(isset($search['invoices']) && count($search['invoices'])>0){
                        echo '<tr>
                                <td><b>'.$search['supplier']['supplier_name'].'</b></td> 
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
                                       <th style="text-align:right;">Balance</th>
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
//                                echo '<pre>';                                print_r($invoice); die;
                                $due_date = $invoice['invoice_date']+(60*60*24*$invoice['days_after']);
                                $invoice_total = $invoice['invoice_desc_total'];
                                
                                //addons
                                $CI =& get_instance();
                                $CI->load->model("Sales_pos_model");
//                                $invoice_addons = $CI->Sales_pos_model->get_invoice_addons($invoice['id']); 
//                                if(!empty($invoice_addons)){
//                                    foreach ($invoice_addons as $invoice_addon){
//                                        $invoice_total += $invoice_addon['addon_amount'];
//                                    }
//                                } 
                                
                                $cust_payments = (!empty($invoice['transections']))?$invoice['transections'][0]['total_amount']:0;
                                $pending = $invoice_total-$cust_payments;
                                echo '
                                    <tr>
                                        <td>'.($i+1).'</td> 
                                        <td align="center">'.$invoice['supplier_invoice_no'].'</td>
                                        <td align="center">'.(($invoice['invoice_date']>0)?date('d M Y',$invoice['invoice_date']):'').'</td>
                                        <td align="right">'. number_format($invoice_total/$invoice['currency_value'],2).'</td> 
                                        <td align="right">'. number_format($cust_payments/$invoice['currency_value'],2).'</td> 
                                        <td align="center">'.date('d M Y',$due_date).'</td> 
                                        <td align="right">'. number_format($pending/$invoice['currency_value'],2).'</td> 
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
                    }
                   }
                }
                echo '<tr>
                                  <td>No Results found</td> 
                              </tr>';
              ?>   
        </tbody> 
         </table> 