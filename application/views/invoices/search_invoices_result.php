<table id="example1" class="table dataTable table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Invoice No</th> 
                <th>Customer</th> 
                <th class="text-right">Total</th> 
                <th class="text-right">Paid</th> 
                <th class="text-right">Pending</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0;
                  
                  $total_amnt_desc = $total_amnt_trns = $total_amnt_bal = 0;   
                   foreach ($search_list as $search){ 
//                       echo '<pre>';                       print_r($search); die;
                       
                       $total_amnt_bal += $search['invoice_total'];
                       $total_amnt_desc += $search['invoice_desc_total'];
                       $total_amnt_trns += $search['transection_total'];
                       
                       echo '
                           <tr>
                               <td>'.($i+1).'</td> 
                               <td>'.$search['invoice_dets']['invoice_no'].'</td>
                               <td>'.$search['invoice_dets']['customer_name'].'</td>
                               <td class="text-right">'. number_format($search['invoice_desc_total'],2).'</td>
                               <td class="text-right">'. number_format(abs($search['transection_total']),2).'</td>
                               <td class="text-right">'. number_format($search['invoice_total'],2).'</td>
                               
                               <td>';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'view'))?'<a href="'.  base_url($this->router->fetch_class().'/view/'.$search['invoice_dets']['id']).'"><span class="fa fa-eye"></span></a> | ':' ';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], 'Customer_payments', 'add_customer_payment'))?'<a href="'.  base_url('Customer_payments'.'/add_customer_payment/'.$search['invoice_dets']['id'].'/20').'"><span class="fa fa-money"></span></a> | ':' ';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'sales_invoice_print'))?'<a target="_blank" href="'.  base_url($this->router->fetch_class().'/sales_invoice_print/'.$search['invoice_dets']['id']).' "><span class="fa fa-print"></span></a> ':' ';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?' | <a href="'.  base_url($this->router->fetch_class().'/delete/'.$search['invoice_dets']['id']).'"><span class="fa fa-trash"></span></a> ':' ';
                                   
                                echo '</td>  ';
                       $i++;
                   }
              ?>   
        </tbody>
           <tfoot>
           <tr>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-right"><?php echo number_format($total_amnt_desc,2);?></th>
                <th class="text-right"><?php echo number_format($total_amnt_trns,2);?></th>
                <th class="text-right"><?php echo number_format($total_amnt_bal,2);?></th>
                <th></th>
            </tr>
           </tfoot>
         </table>