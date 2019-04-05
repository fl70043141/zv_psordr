<table id="example1" class="table dataTable table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>CR No</th> 
                <th>Consignee</th> 
                <th>Reference</th> 
                <th>Date</th>  
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0; 
                   foreach ($search_list as $search){ 
//                       echo '<pre>';                       print_r($search); die;
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                       echo '
                           <tr>
                               <td>'.($i+1).'</td> 
                               <td>'.$search['cr_no'].'</td>
                               <td>'.$search['consignee_name'].'</td>
                               <td>'.$search['reference'].'</td>
                               <td>'.(($search['recieve_date']>0)?date('d M Y',$search['recieve_date']):'').'</td> 
                               
                               <td>';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'view'))?'<a class="btn  btn-social-icon fl-btn-instagram" title="View" href="'.  base_url($this->router->fetch_class().'/view/'.$search['id']).'"><span class="fa fa-eye"></span></a>  ':' ';
                                   
                                echo '</td>  ';
                       $i++;
                   }
              ?>   
        </tbody>
           <tfoot>
           <tr>
                <th>#</th>
                <th>Credit Note No</th> 
                <th>Supplier</th> 
                <th>CN Reference</th> 
                <th>Date</th>  
                <th>Action</th>
            </tr>
           </tfoot>
         </table>