<table id="example1" class="table dataTable table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Trans ID</th> 
                <th>Trans Type</th> 
                <th>Invoice ID</th> 
                <th>Amount</th> 
                <th>Date</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0;
                   foreach ($search_list as $search){ 
//            echo '<pre>'; print_r($search); die;
                       echo '
                           <tr>
                               <td>'.($i+1).'</td> 
                               <td>'.$search['id'].'</td>
                               <td>'.$search['tt_name'].'</td>
                               <td>'.$search['trans_reference'].'</td>
                               <td>'. number_format($search['transection_amount'],2).'</td>
                               <td>'. date('m/d/Y',$search['trans_date']).'</td>
                               <td>';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.  base_url($this->router->fetch_class().'/delete/'.$search['id']).'"><span class="fa fa-trash-o"></span></a> ':' ';
                                   
                                echo '</td>  ';
                       $i++;
                   }
              ?>   
        </tbody>
           <tfoot>
           <tr> 
                <th>#</th>
                <th>Trans ID</th> 
                <th>Trans Type</th> 
                <th>Invoice ID</th> 
                <th>Amount</th> 
                <th>Date</th> 
                <th>Action</th>
            </tr>
           </tfoot>
         </table>