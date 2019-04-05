<?php 

class General_ledgers_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('ic.*');
            $this->db->select('(select type_name from '.GL_CHART_TYPE.' where id = ic.account_type_id) as account_type_name');
            $this->db->from(GL_CHART_MASTER." ic");  
            $this->db->where('ic.deleted',0);
            
            if(isset($data['ledger_name']) && $data['ledger_name'] !='') $this->db->like('ic.account_name',$data['ledger_name']);
            if(isset($data['gl_acc_type_id']) && $data['gl_acc_type_id'] !='') $this->db->where('ic.account_type_id',$data['gl_acc_type_id']);
            if(isset($data['status'])) $this->db->where('ic.status',$data['status']);
        
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
          public function get_single_row($id){ 
            $this->db->select('ic.*');
            $this->db->select('(select type_name from '.GL_CHART_TYPE.' where id = ic.account_type_id) as account_type_name');
            $this->db->from(GL_CHART_MASTER." ic");  
            $this->db->where('ic.id',$id);
            $this->db->where('ic.deleted',0);
            $result = $this->db->get()->result_array();    
            return $result;
	}
	
          public function get_single_row_code($code){ 
            $this->db->select('ic.*');
            $this->db->select('(select type_name from '.GL_CHART_TYPE.' where id = ic.account_type_id) as account_type_name');
            $this->db->from(GL_CHART_MASTER." ic");  
            $this->db->where('ic.account_code',$code);
            $this->db->where('ic.deleted',0);
            $result = $this->db->get()->result_array();    
            return $result;
	}
                        
        public function add_db($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(GL_CHART_MASTER, $data);  
                
		$status[0]=$this->db->trans_complete();
//		$status[1]=$data['id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(GL_CHART_MASTER, $data); 
                        
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(GL_CHART_MASTER, $data); 
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(GL_CHART_MASTER, array('id' => $id));     
                $this->db->delete(HOTEL_RESOURCE, array('hotel_id' => $id));     
                $this->db->delete(HOTEL_IMAGES_TBL, array('hotel_id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>