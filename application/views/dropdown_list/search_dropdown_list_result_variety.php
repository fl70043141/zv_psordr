      

<table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Value</th>
                                                <th>RI</th>
                                                <th>SG</th>
                                                <th>Dropdown Type</th> 
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                         <?php
                                            //var_dump($search_list); die;
                                                $i = 0;
                                                 foreach ($search_list as $row){ 
                                                    echo '
                                                        <tr>
                                                            <td>'.($i+1).'</td>
                                                            <td>'.$row['dropdown_value'].'</td>
                                                            <td>'.$row['ri_value'].'</td>
                                                            <td>'.$row['sg_value'].'</td>
                                                            <td>'.$row['dropdown_list_name'].'</td> 
                                                            <td>
                                                                <a href="'.  base_url('DropDownList/view/'.$row['id']).'"><span class="fa fa-eye"></span></a> |
                                                                <a href="'.  base_url('DropDownList/edit/'.$row['id']).'"><span class="fa fa-pencil"></span></a> |
                                                                <a href="'.  base_url('DropDownList/delete/'.$row['id']).'"><span class="fa fa-trash"></span></a> 
                                                            </td>  ';
                                                    $i++;
                                                }
                                            ?>  
                                             
                                        </tbody>
                                    </table>