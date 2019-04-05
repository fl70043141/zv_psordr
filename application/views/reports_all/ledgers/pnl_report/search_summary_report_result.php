<?php
        $pnl_total = $pnl_income_tot = $pnl_cost_tot = 0;
        
        $income_html = '<table id="example1" class="table  dataTable table-bordered table-striped">
                        <tbody>';
              if(isset($income_data) && !empty($income_data)){
                   foreach ($income_data as $glcm_id => $search){
//echo '<pre>';print_r($search); die;
                       
                    $income_html .='<tr>
                                <td><b>'.$search[0]['type_name'].'</b></td> 
                            </tr>
                            <table  class="pad table dataTable table-bordered table-striped"> 
                               <tbody>
                               </tbody>';
                        $i = 0; $type_tot = 0;
                        if(!empty($search)){
                            foreach ($search as $trans){
                                $amnt_clr = ($trans['glcm_tot_amount']>=0)?'':'#F1948A'; 
                                $income_html .='
                                    <tr>
                                        <td width="5%">'.($i+1).'.</td> 
                                        <td width="10%" align="left">'.$trans['account_code'].'</td>
                                        <td width="60%" align="left">'.$trans['glcm_account_name'].'</td>
                                        <td width="25%" align="right" style="color:'.$amnt_clr.';">'. number_format(abs($trans['glcm_tot_amount']),2).'</td> 
                                    </tr>';
                                $pnl_income_tot += $trans['glcm_tot_amount'];
                                $type_tot += $trans['glcm_tot_amount'];
                                        
                                $i++;
                            }
                            
                            $income_html .= '<tr>
                                    <td colspan="3" align="right">Total '.$search[0]['type_name'].': </td> 
                                    <td align="right"><b>'.number_format(abs($type_tot),2).'</b></td> 
                                </tr>';
                       }
                   }
              }
              
            $income_html .= '</tbody> 
                               </table>';
         
            $cost_html = '<table id="example1" class="table  dataTable table-bordered table-striped">
                    <tbody>';

              if(isset($cost_data) && !empty($cost_data)){
                   foreach ($cost_data as $glcm_id => $search){
//echo '<pre>';print_r($search); die;
                       
                        $cost_html .= '<tr>
                                <td colspan="3"><b>'.$search[0]['type_name'].'</b></td> 
                            </tr>
                            <table  class="pad table dataTable table-bordered table-striped"> 
                               <tbody>
                               </tbody>';
                        $i = 0; $type_tot = 0;
                        if(!empty($search)){
                            foreach ($search as $trans){
                                $amnt_clr = ($trans['glcm_tot_amount']>=0)?'':'#F1948A'; 
                                $cost_html .= '
                                    <tr>
                                        <td width="5%">'.($i+1).'.</td> 
                                        <td width="10%" align="left">'.$trans['account_code'].'</td>
                                        <td width="60%" align="left">'.$trans['glcm_account_name'].'</td>
                                        <td width="25%" align="right" style="color:'.$amnt_clr.';">'. number_format(abs($trans['glcm_tot_amount']),2).'</td> 
                                    </tr>';
                                $pnl_cost_tot += $trans['glcm_tot_amount'];
                                $type_tot += $trans['glcm_tot_amount'];
                                        
                                $i++;
                            }
                            
                            $cost_html .= '<tr>
                                    <td colspan="3" align="right">Total '.$search[0]['type_name'].': </td> 
                                    <td align="right"><b>'.number_format(abs($type_tot),2).'</b></td> 
                                </tr>';
                       }
                   }
              }
              $cost_html .= '
                            </tbody> 
                             </table> ';
              
              echo '<div class="row">
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Total Income: </dt><dd>'.number_format(abs($pnl_income_tot),2).'</dd>
                                </dl> 
                            </div>
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Total Cost: </dt><dd>'.number_format(abs($pnl_cost_tot),2).'</dd>
                                </dl> 
                            </div>
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Calculated Return: </dt><dd style="color:'.((($pnl_income_tot+$pnl_cost_tot)>0)?'red':'').';">'. number_format(abs($pnl_income_tot+$pnl_cost_tot),2).'</dd>
                                </dl> 
                            </div> 

                        </div>';
              ?>   
         
         
<h3>Income</h3>
<?php echo $income_html;?>
<h3>Cost</h3>
<?php echo $cost_html;?>