<?php
$html = '';
$html .='<table id="example1" class="table  dataTable table-bordered table-striped">
    <thead>
        <tr>
            <th width="10%">Account</th>
            <th width="30%">Account Name</th>
            <th width="20%" style="text-align: right;">Open Balance</th>
            <th width="20%" style="text-align: right;">Period</th>
            <th width="20%" style="text-align: right;">Close Balance</th>
        </tr>
    </thead>
        <tbody>';
                $fin_open_bal = $fin_period = $fin_close_bal = 0; 
              if(isset($trans_class_list) && !empty($trans_class_list)){
                   foreach ($trans_class_list as $glcm_id => $search){
//                      $html .='<pre>';                       print_r($search); die;
                       
                       $html .='<tr>
                                <td colspan="5"><h3>'. strtoupper($search['class_name']).'</h3></td> 
                            </tr>
                            <tr><td colspan="5">
                            <table  class="pad table dataTable table-bordered table-striped">';
                        if(isset($search['class_data']) && !empty($search['class_data'])){
                             $all_open_bal = $all_period = $all_close_bal = 0; 
                            foreach ($search['class_data'] as $gltype){
                               $html .='<thead>
                                        <tr>
                                            <th colspan="3">'.$gltype[0]['type_name'].'</th>
                                    </thead>';
                                
                                
                                if(isset($gltype) && !empty($gltype)){
                                    $i = $tot_open_bal = $tot_period = $tot_close_bal = 0; 
                                    foreach ($gltype as $trans){
                                        $tot_open_bal += $trans['open_balance'];
                                        $tot_period += $trans['period_transections'];
                                        $tot_close_bal += $trans['close_balance'];
                                        
                                        $all_open_bal += $trans['open_balance'];
                                        $all_period += $trans['period_transections'];
                                        $all_close_bal += $trans['close_balance'];
                                        
                                        $fin_open_bal += $trans['open_balance'];
                                        $fin_period += $trans['period_transections'];
                                        $fin_close_bal += $trans['close_balance'];
                                       $html .='
                                            <tr>
                                                <td width="10%">'.($i+1).'</td> 
                                                <td width="30%" align="left">'.$trans['glcm_account_name'].'</td>
                                                <td width="20%" align="right" style="color:'.(($trans['open_balance']>=0)?'':'#F1948A').';">'. number_format(($trans['open_balance']),2).'</td> 
                                                <td width="20%" align="right" style="color:'.(($trans['period_transections']>=0)?'':'#F1948A').';">'. number_format(($trans['period_transections']),2).'</td> 
                                                <td width="20%" align="right" style="color:'.(($trans['close_balance']>=0)?'':'#F1948A').';">'. number_format(($trans['close_balance']),2).'</td> 
                                            </tr>';
                                        $i++;
                                    }
                                   $html .='
                                            <tr>
                                                <td colspan="2" width="40%">Total '.$gltype[0]['type_name'].' </td> 
                                                <td width="20%" align="right" style="color:'.(($tot_open_bal>=0)?'':'#F1948A').';">'. number_format(($tot_open_bal),2).'</td> 
                                                <td width="20%" align="right" style="color:'.(($tot_period>=0)?'':'#F1948A').';">'. number_format(($tot_period),2).'</td> 
                                                <td width="20%" align="right" style="color:'.(($tot_close_bal>=0)?'':'#F1948A').';">'. number_format(($tot_close_bal),2).'</td> 
                                            </tr>
                                            <tr><td colspan="5"><br></td></tr>';
                                            
                                }
                            }
                            
                                   $html .='
                                            <tr>
                                                <td colspan="2" width="40%"><h4>Total '.$search['class_name'].' </h4></td> 
                                                <td width="20%" align="right" style="color:'.(($all_open_bal>=0)?'':'#F1948A').';"><h4>'. number_format(($all_open_bal),2).'</h4></td> 
                                                <td width="20%" align="right" style="color:'.(($all_period>=0)?'':'#F1948A').';"><h4>'. number_format(($all_period),2).'</h4></td> 
                                                <td width="20%" align="right" style="color:'.(($all_close_bal>=0)?'':'#F1948A').';"><h4>'. number_format(($all_close_bal),2).'</h4></td> 
                                            </tr> ';
                        }
                                 
                       $html .='<tr>   
                            </table>
                            ';
                   }
              } 
       $html .='</tbody>  
         </table>';
               
       echo   '<div class="row">
                            <div class="col-md-3">
                                <b>Calculated Return >>></b>
                            </div>
                            <div class="col-md-3">
                                <dl class="dl-horizontal">
                                    <dt>Total Open Balance: </dt><dd>'.number_format(abs($fin_open_bal),2).'</dd>
                                </dl> 
                            </div>
                            <div class="col-md-3">
                                <dl class="dl-horizontal">
                                    <dt>Total Period Trans: </dt><dd>'.number_format(abs($fin_period),2).'</dd>
                                </dl> 
                            </div>
                            <div class="col-md-3">
                                <dl class="dl-horizontal">
                                    <dt>Total Close Balance: </dt><dd style="color:'.((($fin_close_bal)>0)?'red':'').';">'. number_format(abs($fin_close_bal),2).'</dd>
                                </dl> 
                            </div> 

                        </div><hr>'.$html; 
              ?>  