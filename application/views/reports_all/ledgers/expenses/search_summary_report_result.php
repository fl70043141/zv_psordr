<table id="example1" class="table dataTable table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Account_name </th> 
                <th>Type</th> 
                <th style="text-align: right;">Amount Entered</th> 
                <th style="text-align: right;">Amount</th>  
            </tr>
        </thead>
        <tbody>
              <?php
              $html_row = '';
                  $i = $tot_exp = 0;
                   foreach ($search_list as $search){ 
//            echo '<pre>';            print_r($search); die;
                       $html_row .= '
                           <tr>
                               <td>'.($i+1).'</td>
                               <td>'.$search['account_name'].'</td>
                               <td>'.$search['type_name'].'</td>
                               <td align="right">'.$search['symbol_left'].' '. number_format($search['amount'],2).' '.$search['symbol_right'].'</td>
                               <td align="right">'.$search['cur_left_symbol'].' '. number_format($search['expense_amount'],2).' '.$search['cur_right_symbol'].'</td>';
                       $i++;
                       $tot_exp += $search['expense_amount'];
                   }
                   
                   echo '<div class="row">
                            <div class="col-md-4">
                                <dl class="dl-horizontal">
                                    <dt>Total Expenses: </dt><dd>'. number_format($tot_exp,2).'</dd>
                                </dl> 
                            </div> 
                                

                        </div>'.$html_row; 
              ?>   
        </tbody>
           <tfoot>
            <tr>
                <th>#</th>
                <th>Account_name </th> 
                <th>Type</th> 
                <th style="text-align: right;">Amount Entered</th> 
                <th style="text-align: right;">Amount</th>  
            </tr>
           </tfoot>
         </table>