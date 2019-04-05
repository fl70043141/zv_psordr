<table id="example1" class="table dataTable table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Reference No</th> 
                <th>Type</th> 
                <th>Insurance Company</th> 
                <th>Customer</th> 
                <th>Total</th>  
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0;
                   foreach ($search_list as $search){ 
//                       echo '<pre>';                       print_r($search); die;
                       echo '
                           <tr>
                               <td>'.($i+1).'</td> 
                               <td>'.$search['invoice_dets']['quote_no'].'</td>
                               <td>'.$search['invoice_dets']['quotation_type_name'].'</td>
                               <td>'.$search['invoice_dets']['insurance_company'].'</td>
                               <td>'.$search['invoice_dets']['customer_name'].'</td>
                               <td>'. number_format($search['invoice_desc_total'],2).'</td> 
                               
                               <td>';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'view'))?'<a href="'.  base_url($this->router->fetch_class().'/view/'.$search['invoice_dets']['id']).'"><span class="fa fa-eye"></span></a> | ':' ';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.  base_url($this->router->fetch_class().'/delete/'.$search['invoice_dets']['id']).'"><span class="fa fa-trash"></span></a> | ':' ';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'quote_print'))?'<a target="_blank" href="'.  base_url($this->router->fetch_class().'/quote_print/'.$search['invoice_dets']['id']).' "><span class="fa fa-print"></span></a> ':' ';
                                   
                                echo '</td>  ';
                       $i++;
                   }
              ?>   
        </tbody>
           <tfoot>
           <tr> 
                <th>#</th>
                <th>Invoice No</th> 
                <th>Type</th> 
                <th>Customer</th> 
                <th>Total</th>  
                <th>Action</th>
            </tr>
           </tfoot>
         </table>