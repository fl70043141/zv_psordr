<table id="example1" class="table dataTable11 table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Image</th> 
                <th>Item code</th> 
                <th>Item name</th> 
                <th>Category</th>  
                <th>Unit of Measure</th>
                <th>Cost price</th>
                <th>Sale price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0;
                   foreach ($search_list as $search){ 
                        // echo '<pre>';            print_r($search); die;
                        $selling_price = 0;
                        $sale_price_obj = get_single_row_helper(ITEM_PRICES, 'item_id='.$search["id"].' and item_price_type=2 and sales_type_id=15 and deleted=0');
                        
                        if(!empty($sale_price_obj)){
                            $selling_price = $sale_price_obj['price_amount'];
                        }

                        $cost_price = 0;
                        $sale_price_obj = get_single_row_helper(ITEM_PRICES, 'item_id='.$search["id"].' and item_price_type=3 and deleted=0');
                        if(!empty($sale_price_obj)){
                            $cost_price = $sale_price_obj['price_amount'];
                        }

                       echo '
                           <tr>
                               <td>'.($i+1).'</td>
                               <td><img style="width:30px;height:30px;" src="'. base_url(ITEM_IMAGES.(($search['image']!="")?$search['id'].'/'.$search['image']:'../default/default.jpg')).'"></td> 
                               <td>'.$search['item_code'].'</td> 
                               <td>'.$search['item_name'].'</td> 
                               <td>'.$search['category_name'].'</td> 
                               <td>'.$search['unit_abbreviation'].'</td>
                               <td>'.number_format($cost_price,2).'</td>
                               <td>'.number_format($selling_price,2).'</td>
                               <td>'; 
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'view'))?'<a href="'. base_url($this->router->fetch_class().'/view/'.$search['id']).'" title="View" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'. base_url($this->router->fetch_class().'/edit/'.$search['id']).'" title="Edit" class="btn btn-success btn-xs"><span class="fa fa-edit"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'. base_url($this->router->fetch_class().'/delete/'.$search['id']).'" title="Delete" class="btn btn-danger btn-xs"><span class="fa fa-remove"></span></a> ':'';
                                   
                                echo '</td>  ';
                       $i++;
                   }
              ?>   
        </tbody>
           <tfoot>
           <tr>
                <th>#</th>
                <th>Image</th> 
                <th>Item code</th> 
                <th>Item name</th> 
                <th>Category</th>  
                <th>Unit of Measure</th>
                <th>Cost price</th>
                <th>Sale price</th>
                <th>Action</th>
           </tr>
           </tfoot>
         </table>
<script>
    $(document).ready(function() {
   
  $(".dataTable11").DataTable({"scrollX": true ,"pageLength": 25});
} );
</script>