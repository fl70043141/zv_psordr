    <table id="example1" class="table dataTable table-bordered table-striped">
               <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th> 
                            <th>Module Object</th>
                            <th>Action Made</th>
                            <th>Destination</th>
                            <th>time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody >
                       

                      
<?php
        $i = 0;
       foreach ($log_list as $log){ 
            echo '
                <tr>
                    <td>'.($i+1).'</td>
                    <td>'.$log['first_name'].' '.$log['last_name'].'</td>
                    <td>'.$log['module_id'].'</td>
                    <td>'.$log['action_id'].'</td>
                    <td>'.$log['ip'].'</td>
                    <td>'.date('Y-m-d',$log['date']).'</td>
                    <td>
                        <a href="'.  base_url('AuditTrials/view/'.$log['id']).'"><span class="fa fa-eye"></span></a> 

                    </td>  ';
            $i++;
        }
       ?>
</tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>User</th> 
                    <th>Module Object</th>
                    <th>Action Made</th>
                    <th>Destination</th>
                    <th>time</th>
                    <th>Action</th>
                </tr>
                </tfoot>
              </table> 