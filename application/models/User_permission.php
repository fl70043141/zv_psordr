<?php 

class USer_permission extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        function getPermissionGroup(){
            $this->db->select("*");
            $this->db->from(USER_ROLE);
            $res = $this->db->get()->result_array();
              return $res;
        }
        
	 
        function getPermissionData($user_role_id, $module_id=''){
            $this->db->select("ma.*,m.module_name,mur.user_role_id, mur.status as ur_status");
            $this->db->from(MODULES_ACTION.' ma');
            $this->db->join(MODULE_USER_ROLE_ACT.' mur','mur.module_action_id = ma.id','LEFT');
            $this->db->join(MODULES.' m','m.id = ma.module_id','RIGHT');
            $this->db->where('mur.user_role_id',$user_role_id);
            $this->db->where('m.id',$module_id);
            $res = $this->db->get()->result_array();
              return $res;
        }
        
        function get_module_list(){
            $this->db->select('*');
            $this->db->from(MODULES);
            $this->db->where('user_permission_apply','1');
            $res = $this->db->get()->result_array();
            return $res;
        }
        
        function updateUserPermission($inputArr){
             
            $this->db->trans_start(); 
            
            $this->db->where('user_role_id',$inputArr['user_role_id']);
            $this->db->where('module_action_id!=','1');
            $this->db->update(MODULE_USER_ROLE_ACT, array('status'=>'0'));
            
            foreach ($inputArr['permission_cb'] as $module_action){
                foreach ($module_action as $ur_key => $ur_prmsn){
//                    echo $ur_key ; die;
                    $this->db->where('module_action_id	',$ur_key);
                    $this->db->where('user_role_id',$inputArr['user_role_id']);
                    $this->db->update(MODULE_USER_ROLE_ACT, array('status'=>'1'));
                }
            } 
            $status=$this->db->trans_complete();
            return $status;
            
        }
         
        function getAdminPermissionData($ur_id=1,$where=''){
            $this->db->select("*");
            $this->db->from(MODULE_USER_ROLE_ACT); 
            $this->db->where('user_role_id',$ur_id);
            if($where!='') $this->db->where($where);
            $res = $this->db->get()->result_array();
            return $res;
        }
        public function insert_batch_permission($data){     
                $this->db->trans_start();
		$this->db->insert_batch(MODULE_USER_ROLE_ACT, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        
        
        
        
         
         public function search_result($data=''){ 
//             echo '<pre>';print_r($this->db); echo'<pre>';die;
            $this->db->select('ag.*, at.agent_type_name');
            $this->db->join(AGENT_TYPE.' at','at.id = ag.agent_type_id');
            
            if(isset($data['agent_name'])){ 
                $this->db->like('ag.agent_name', $data['agent_name']); 
            }
            if(isset($data['agent_type_id']) && $data['agent_type_id']!=''){ 
                $this->db->where('ag.agent_type_id', $data['agent_type_id']); 
            } 
            if(isset($data['status'])){
                $this->db->where('ag.status', $data['status']); 
            }else{
                 $this->db->where('ag.status', '0'); 
            }   
            $this->db->from(AGENTS." ag");  

            $this->db->where('ag.deleted', '0'); 
            $result = $this->db->get()->result_array();   
//            echo $this->db->last_query(); die;
//            echo '<pre>'; print_r($result); echo '<pre>'; die;
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(AGENTS); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_agent($data){     
                $this->db->trans_start();
		$this->db->insert(AGENTS, $data); 
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_agent($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(AGENTS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_agent($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(AGENTS, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_hotel2($id){
                $this->db->trans_start();
                $this->db->delete(HOTELS, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        function make_fresh_system($table_name){  
                $query = $this->db->query('TRUNCATE '.$table_name);
                return $status;	
	} 
 
}
?>