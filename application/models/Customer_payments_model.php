<?php 

class Customer_payments_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}  
        
         
        
         public function get_single_row($id){ 
            $this->db->select('*'); 
            $this->db->from(TRANSECTION);
              
            $this->db->where('deleted',0); 
            $this->db->where('id',$id);
            $this->db->group_by('id'); 
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;    
            return $result[0];
	}
                        
        public function add_db($data){          
                $this->db->trans_start();
		$this->db->insert(TRANSECTION, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
                
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->where('id!=', 1);
                $this->db->where('deleted',0);
		$this->db->update(ACTIVITY_EVENTS, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(ACTIVITY_EVENTS, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
         
        
 
}
?>