<?php
//var_dump($search_list); die;
    $i = 0;
     foreach ($search_list as $row){ 
        echo '
            <tr>
                <td>'.($i+1).'</td>
                <td>'.$row['agent_name'].'</td>
                <td>'.$row['short_name'].'</td>
                <td>'.$row['agent_type_name'].'</td> 
                <td>'.$row['city'].'</td> 
                <td>'.$row['phone'].'</td> 
                <td>
                    <a href="'.  base_url('agents/view/'.$row['id']).'"><span class="fa fa-eye"></span></a> |
                    <a href="'.  base_url('agents/edit/'.$row['id']).'"><span class="fa fa-pencil"></span></a> |
                    <a href="'.  base_url('agents/delete/'.$row['id']).'"><span class="fa fa-trash"></span></a> 
                </td>  ';
        $i++;
    }
?>       

 