    
<?php
        $i = 0;
        foreach ($search_list as $user){ 
            echo '
                <tr>
                    <td>'.($i+1).'</td>
                    <td>'.$user['first_name'].'</td>
                    <td>'.$user['last_name'].'</td>
                    <td>'.$user['user_role'].'</td>
                    <td>'.$user['email'].'</td>
                    <td>
                        <a href="'.  base_url('users/view/'.$user['auth_id']).'"><span class="fa fa-eye"></span></a> |
                        <a href="'.  base_url('users/edit/'.$user['auth_id']).'"><span class="fa fa-pencil"></span></a> |
                        <a href="'.  base_url('users/delete/'.$user['auth_id']).'"><span class="fa fa-trash"></span></a> 
                    </td> 

                       
                </tr>
                ';
            $i++;
        }
       ?> 