
<table id="example1" class="table  dataTable table-bordered table-striped">
              <?php
              $html_row = "";
              $tot_sales = $tot_pnl = $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
              $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//              echo '<pre>';              print_r($def_cur); die;
              $html_row .= '<thead>
                                <tr>
                                    <th>#</th>
                                    <th style="text-align:center;">Code</th> 
                                    <th style="text-align:center;">Desc</th>  
                                    <th style="text-align:center;">Unit</th>    
                                    <th style="text-align:right;">Total Cost</th>    
                                    <th style="text-align:right;">Sales</th>    
                                    <th style="text-align:center;">PNL</th>    
                                    <th style="text-align:right;">P/L Amount</th>    
                                </tr>
                            </thead>
                            <tbody>';
              
                    $i = 0;  
                    if(!empty($rep_data)){
                        foreach ($rep_data as $item){ 
//                            echo '<pre>';                       print_r($item); die;

                                     $tot_units = $item['item_quantity'];
                                     $tot_units_2 = $item['item_quantity_2'] ; 
                                     $cost = $item['purch_standard_cost'] + $item['total_lapidary_cost'];
                                     
                                     $all_tot_units += $tot_units;
                                     $all_tot_units_2 += $tot_units_2;
                                     $all_tot_amount += $cost;
                                     $tot_sales += $item['item_sale_amount'];
                                     
                                     $pnl_amount = $item['item_sale_amount'] - $cost;
                                     $tot_pnl += $pnl_amount;
                                     
                                         $html_row .= '
                                             <tr>
                                                 <td>'.($i+1).'</td> 
                                                 <td align="center">'.$item['item_code'].'</td>
                                                 <td align="center">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                                 <td align="center">'.$item['item_quantity'].' '.$item['uom_name'].(($item['item_quantity_uom_id_2']!=0)?' | '.$item['item_quantity_2'].' '.$item['uom_name_2']:'-').'</td>
                                                 <td align="right">'. number_format($cost,2).'</td>
                                                 <td align="right">'. number_format($item['item_sale_amount'],2).'</td>
                                                 <td align="center">'.(($pnl_amount>0)?'<p style="color:green;">PROFIT</p>':'<p style="color:red;">LOST</p>').'</td>
                                                 <td align="right" style="vertical-align: bottom;">'. number_format(abs($pnl_amount),2).'</td>
                                            </tr>';
                                         
                                         $i++;
                                         $item_count++; 
                                    
                        }
                        $html_row.= '<tr>
                                            <td align="right" colspan="4"><b>TOTAL</b></td> 
                                            <td align="right"><b>'. number_format($all_tot_amount,2).'</b></td>
                                            <td align="right"><b>'. number_format($tot_sales,2).'</b></td>
                                            <td align="right" colspan="2" ><b style="color:'.(($tot_pnl>0)?'':'red').';">'. number_format($tot_pnl,2).'</b></td>
                                    </tr>';
                    }else{
                            $html_row .= '<tr>
                                    <td>No Results found</td> 
                                </tr>';
                       }
                       $html_row .= '</tbody> </table>';
                   echo '<div class="row">
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Number of Items: </dt><dd>'.$item_count.'</dd>
                                </dl> 
                            </div>
                            
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Units: </dt><dd>'.$all_tot_units.' '.((isset($item)?$item['uom_name'].(($item['item_quantity_uom_id_2']!=0)?' |  '.$all_tot_units_2.' '.$item['uom_name_2']:'-'):'')).' </dd>
                                </dl> 
                            </div>
                                
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>'.(($tot_pnl>0)?'PROFIT':'LOST').': </dt><dd>'.$def_cur['code'].' '. number_format($tot_pnl,2).'</dd>
                                </dl> 
                            </div>

                        </div>'.$html_row; 
              ?>   
        </tbody> 
         </table>
