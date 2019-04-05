<?php 

class Audit_trial_model extends CI_Model
{
	function __construct(){ 
            parent::__construct(); 
 	}
                        
         public function search_result($data=''){ 
            $this->db->select('sl.*,u.first_name,u.last_name');
            $this->db->from(SYSTEM_LOG.' sl'); 
            $this->db->join(USER.' u', 'u.auth_id = sl.user_id');
                          

            if(isset($data['name']) && $data['name'] !=''){
                $this->db->where("(u.first_name like '%".$data['name']."%' OR u.last_name like '%".$data['name']."%')"); 
            } 
            if(isset($data['object']) && $data['object'] !=''){
                $this->db->like('sl.module_id',$data['object']); 
            } 
            if(isset($data['action']) && !empty($data['action'])){
                foreach ($data['action'] as $action){
                    $this->db->like('sl.action_id',$action);    
                }
            } 
            if((isset($data['date_from']) && $data['date_from'] !='') && isset($data['date_to']) && $data['date_to'] !=''){
                $this->db->where('sl.date>', strtotime($data['date_from'])); 
                $this->db->where('sl.date<', strtotime($data['date_to'])); 
            } 
            $result = $this->db->get()->result_array(); 
//              echo '<pre>';print_r(date('Y-m-d',time())); die;
//            echo $this->db->last_query();die;
            return $result;
	}
	
         public function get_single_log($id){ 
            $this->db->select('sl.*,sld.*,u.first_name,u.last_name');
            $this->db->from(SYSTEM_LOG.' sl');
            $this->db->join(SYSTEM_LOG_DETAIL.' sld', 'sld.system_log_id = sl.id');
            $this->db->join(USER.' u', 'u.auth_id = sl.user_id');
            $this->db->where('sl.id',$id);
            $result = $this->db->get()->result_array(); 
//            echo $this->db->last_query(); die;
            return $result;
	}
                        
         
}
?>