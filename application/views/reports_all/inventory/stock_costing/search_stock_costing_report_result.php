
<table id="example1" class="table  dataTable table-bordered table-striped">
        <tbody>
              <?php
              $html_row = "";
              $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
              $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//              echo '<pre>';              print_r($def_cur); die;
                   foreach ($rep_data as $cust_id => $search){ 
//                       echo '<pre>';                       print_r($search); die;
                       
                        $html_row .= '<tr>
                                <td><b>'.$search['item_category_name'].'</b></td> 
                            </tr>
                            <table  class="pad table dataTable table-bordered table-striped">
                                <thead>
                                   <tr>
                                       <th>#</th>
                                       <th style="text-align:center;">Code</th> 
                                       <th style="text-align:center;">Desc</th>  
                                       <th style="text-align:center;">CDC</th> 
                                       <th style="text-align:center;">Color</th> 
                                       <th style="text-align:center;">Shape</th> 
                                       <th style="text-align:center;">Units</th>   
                                       <th style="text-align:right;">Unit Cost ('.$def_cur['code'].')</th>   
                                       <th style="text-align:right;">Total Cost('.$def_cur['code'].')</th>   
                                   </tr>
                               </thead>
                               <tbody>
                               </tbody>';
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                        $i = 0; 
                        $cat_tot_units = $cat_tot_units_2 = $cat_tot_amount = 0;
                        if(!empty($search['item_list'])){
                            foreach ($search['item_list'] as $item){ 
                                $tot_units = $item['units_available'] + $item['units_on_workshop'] + $item['units_on_consignee'];
                                $tot_units_2 = $item['units_available_2'] + $item['units_on_workshop_2'] + $item['units_on_consignee_2'];
                                $cost = (($item['price_amount'] / $item['ip_curr_value']) * $tot_units) ;
                                
                                $cat_tot_units += $tot_units;
                                $cat_tot_units_2 += $tot_units_2;
                                $cat_tot_amount += $cost;

                                $all_tot_units += $tot_units;
                                $all_tot_units_2 += $tot_units_2;
                                $all_tot_amount += $cost;
                                
                                if($item['units_available']>0 || $item['units_on_workshop']>0 || $item['units_on_consignee']>0){
                                    $html_row .= '
                                        <tr>
                                            <td>'.($i+1).'</td> 
                                            <td align="center">'.$item['item_code'].'</td>
                                            <td align="center">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                                            <td align="center">'.$item['treatment_name'].'</td>
                                            <td align="center">'.$item['color_name'].'</td>
                                            <td align="center">'.$item['shape_name'].'</td> 
                                            <td align="center">'.$item['units_available'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_available_2'].' '.$item['uom_name_2']:'-').'</td>
                                            <td align="right">'. number_format(($item['price_amount'] / $item['ip_curr_value']),2).'</td>
                                            <td align="right">'. number_format($cost,2).'</td>
                                            </tr>';
                                    $i++;
                                    $item_count++;
                                }
                            }
                            if($i>1){
                                       $html_row .= '<tr>
                                                        <td colspan="6" align="right" ><b>Total</b></td>
                                                        <td align="center">'.$cat_tot_units.' '.$item['uom_name'].(($item['uom_id_2']!=0)?' | '.$cat_tot_units_2.' '.$item['uom_name_2']:'-').'</td>
                                                        <td></td>
                                                        <td align="right">'. number_format($cat_tot_amount,2).' &nbsp;&nbsp;</td>

                                                  </tr>';
                                        }
                       }else{
                            $html_row .= '<tr>
                                    <td>No Results found</td> 
                                </tr>';
                       }
                        $html_row .='<tr>  <td colspan="6"></td</tr>   
                            
                            </table>
                            ';
                   }
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
