<table id="example1" class="table  table-bordered table-striped dataTable11">
         <thead>
            <tr>
                <th>#</th>
                <th>Order No</th> 
                <th>Customer</th> 
                <th>Customer Branch</th> 
                <th>Price Type</th> 
                <th>Order Date</th> 
                <th>Required Date</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0;
                  
                  $total_amnt_desc = $total_amnt_trns = $total_amnt_bal = 0;   
                   foreach ($search_list as $search){ 
//                       echo '<pre>';                       print_r($search); die; 
                       echo '
                           <tr>
                               <td>'.($i+1).'</td> 
                               <td>'.$search['sales_order_no'].'</td>
                               <td>'.$search['customer_name'].'</td>
                               <td>'.$search['branch_name'].'</td>
                               <td>'.$search['price_list_type'].'</td>
                               <td>'.date('m/d/y',$search['order_date']).'</td>
                               <td>'.date('m/d/y',$search['required_date']).'</td>
                               
                               <td>';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'view'))?'<a href="'. base_url($this->router->fetch_class().'/view/'.$search['id']).'" title="View" class="btn btn-primary btn-sm"><span class="fa fa-eye"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'. base_url($this->router->fetch_class().'/edit/'.$search['id']).'" title="Edit" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'. base_url($this->router->fetch_class().'/delete/'.$search['id']).'" title="Delete" class="btn btn-danger btn-sm"><span class="fa fa-remove"></span></a> ':'';
                                   
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

<script>
    $(document).ready(function() {
   
  $(".dataTable11").DataTable({"scrollX": true });
} );
</script>