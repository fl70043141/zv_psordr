<?php 

class User_model extends CI_Model
{
	function __construct(){
		
        parent::__construct(); 
 	}
	
	
         public function search_result($data=''){ 
            $this->db->select('u.*,ua.*,urm.*');
            $this->db->from(USER.' u'); 
            $this->db->join(USER_TBL.' ua', 'ua.id = u.auth_id');
            $this->db->join(USER_ROLE.' urm', 'urm.id = ua.user_role_id');
                        
            $this->db->where('ua.id!=', 1); 
            
            if($data !=''){
                        
                $this->db->like('email', $data['email']); 
                $this->db->where("(first_name like '%".$data['user_name']."%' OR last_name like '%".$data['user_name']."%')"); 
               } 
               
            $result = $this->db->get()->result_array(); 
//            echo $this->db->last_query();
            return $result;
	}
	
         public function get_single_user($id){ 
            $this->db->select('u.*, ua.user_name, ua.status, urm.user_role, urm.id as user_role_id');
            $this->db->from(USER.' u'); 
            $this->db->join(USER_TBL.' ua', 'ua.id = u.auth_id');
            $this->db->join(USER_ROLE.' urm', 'urm.id = ua.user_role_id');
            $this->db->where('ua.id',$id);
            $cur_user = $this->session->userdata();
            if($cur_user[SYSTEM_CODE]['user_role_ID']!=1){
                $this->db->where('ua.id !=',1);
            }
            $result = $this->db->get()->result_array(); 
            
//            echo $this->db->last_query();
            return $result;
	}
                        
        
        public function add_user($data)
	{ 
		$this->db->trans_start();
                
		$this->db->insert(USER_TBL, $data['user_aut_tbl']);
		$this->db->insert(USER, $data['user_det_tbl']);
		
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['user_det_tbl']['auth_id']; 
		return $status;
	}
        public function edit_user($user_id,$data)
	{
		//print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $user_id);
		$this->db->update(USER_TBL, $data['user_aut_tbl']);
                
		$this->db->where('auth_id', $user_id);
		$this->db->update(USER, $data['user_det_tbl']);
		
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_user($user_id){
                $this->db->trans_start();
                $this->db->where('id!=',1);   
                $this->db->delete(USER_TBL, array('id' => $user_id));   
                $this->db->delete(USER, array('auth_id' => $user_id));   
                $status = $this->db->trans_complete();
                return $status;	

	}
        
        
        
        
	function get_reg_typecode_list(){
		 
		$query = $this->db->get(REG_TYPE);
		$list = $query->result_array();
		$list2[""]="Select";
		foreach($list as $list1){
			$list2[$list1['regtyp_code']] = $list1['regtyp_des'];
		}
		return $list2;
	}
	
        
        
        
	function get_reg_list(){ 
		$query = $this->db->get(REG_TYPE);
		$list = $query->result_array();
		return $list;
	}
	
	
	public function get_single_ac_reg_details($id){
		
		$this->db->where('reg_code', $id); 
		$query = $this->db->get(AIRCRAFT_REG);
		return $query->result_array();
	}
	
	
	
	public function edit_ac_reg($reg_code,$data)
	{
		//print_r($data); die;
		$this->db->trans_start(TRUE);
		$this->db->where('reg_code', $reg_code);
		$this->db->update(AIRCRAFT_REG, $data);
		
		$status=$this->db->trans_complete();
		return $status;
	} 
	
	function delete_ac_reg($reg_code){
		switch($this->tbl_dependency_ac_reg('"'.$reg_code.'"')){
			case false: 
				$this->db->trans_start(TRUE);
				$this->db->delete(AIRCRAFT_REG, array('reg_code' => $reg_code));   
				$status=$this->db->trans_complete();
				return $status;	
			default:
				$status=false;
				return $status;
		}
	}
	 
	

	
	public function tbl_dependency_shifrec_acreg($reg_code){
		
		$query = $this->db->query('select reg_code from '.SHIFT_REC.' where reg_code = '.$reg_code); 
		$nums=$query->num_rows();
		if($nums > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function tbl_dependency_ac_reg($reg_code){
		$query = $this->db->query('select reg_code from '.SHIFT_REC.' where reg_code = '.$reg_code); 
		$nums=$query->num_rows();
		if($nums > 0){
			return true;
		}
		else{
			return false;
		}
	}
 
}
?>