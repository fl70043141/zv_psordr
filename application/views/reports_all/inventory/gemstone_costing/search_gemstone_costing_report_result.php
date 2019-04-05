
<table id="example1" class="table  dataTable table-bordered table-striped">
              <?php
              $html_row = "";
              $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
              $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//              echo '<pre>';              print_r($def_cur); die;
              $html_row .= '<thead>
                                <tr>
                                    <th>#</th>
                                    <th style="text-align:center;">Code</th> 
                                    <th style="text-align:center;">Desc</th>  
                                    <th style="text-align:center;">Unit 1</th> 
                                    <th style="text-align:center;">Unit 2</th>   
                                    <th style="text-align:left;">Type</th>    
                                    <th style="text-align:left;">Person</th>    
                                    <th style="text-align:right;">Cost</th>    
                                    <th style="text-align:right;">Total Cost</th>    
                                </tr>
                            </thead>
                            <tbody>';
              
                    $i = 0; 
                    $cat_tot_units = $cat_tot_units_2 = $cat_tot_amount = 0;
                    if(!empty($rep_data)){
                        foreach ($rep_data as $item){ 
//                            echo '<pre>';                       print_r($item); die;

                                     $tot_units = $item['units_available'] + $item['units_on_workshop'] + $item['units_on_consignee'];
                                     $tot_units_2 = $item['units_available_2'] + $item['units_on_workshop_2'] + $item['units_on_consignee_2'];
                                     $purch_cost = (($item['price_amount'] / $item['ip_curr_value']) * $tot_units);
                                     $cost = (($item['price_amount'] / $item['ip_curr_value']) * $tot_units) + $item['total_lapidary_cost'];

                                     $cat_tot_units += $tot_units;
                                     $cat_tot_units_2 += $tot_units_2;
                                     $cat_tot_amount += $cost;

                                     $all_tot_units += $tot_units;
                                     $all_tot_units_2 += $tot_units_2;
                                     $all_tot_amount += $cost;

                                     if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                         $bg_colr = ($i%2==0)?'#F5F5F5':'#FFFFFF';
                                         $html_row .= '
                                             <tr style="background-color: '.$bg_colr.'">
                                                 <td>'.($i+1).'</td> 
                                                 <td align="center">'.$item['item_code'].'</td>
                                                 <td align="center">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                                 <td align="center">'.$item['units_available'].' '.$item['uom_name'].'</td>
                                                 <td align="center">'.(($item['uom_id_2']!=0)?$item['units_available_2'].' '.$item['uom_name_2']:'-').'</td>
                                                 <td align="left">Purchase</td>
                                                 <td align="left">Supplier</td> 
                                                 <td align="right">'. number_format($purch_cost,2).'</td>
                                                 <td rowspan="'.(count($item['lapidary_costs'])+1).'" align="right" style="vertical-align: bottom;">'. number_format($cost,2).'</td>
                                            </tr>';
                                         if(!empty($item['lapidary_costs'])){
                                             foreach ($item['lapidary_costs'] as $lcost){
                                                $html_row .= '<tr style="background-color: '.$bg_colr.'">
                                                                    <td colspan="5"></td> 
                                                                    <td align="left">'.$lcost['dropdown_list_name'].'</td>
                                                                    <td align="left">'.$lcost['dropdown_value'].'</td> 
                                                                    <td align="right">'. number_format($lcost['amount_cost'],2).'</td>
                                                                    
                                                               </tr>';
                                            }
                                         }
                                         $i++;
                                         $item_count++;
                                     }
                                    
                        }
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
                                    <dt>Units: </dt><dd>'.$all_tot_units.' '.((isset($item)?$item['uom_name'].(($item['uom_id_2']!=0)?' |  '.$all_tot_units_2.' '.$item['uom_name_2']:'-'):'')).' </dd>
                                </dl> 
                            </div>
                                
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Costs: </dt><dd>'.$def_cur['code'].' '. number_format($all_tot_amount,2).'</dd>
                                </dl> 
                            </div>

                        </div>'.$html_row; 
              ?>   
        </tbody> 
         </table>
