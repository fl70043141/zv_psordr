<?php 

class Suppliers_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('s.*');
            $this->db->from(SUPPLIERS.' s');  
            $this->db->where('s.deleted',0);
            if(isset($data['supplier_name']) && $data['supplier_name']!='') $this->db->like('s.supplier_name', $data['supplier_name']);  
            if(isset($data['phone']) && $data['phone']!='') $this->db->like('s.phone', $data['phone']);  
            
            $result = $this->db->get()->result_array();  
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(SUPPLIERS); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){       
                $this->db->trans_start();
		$this->db->insert(SUPPLIERS, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(SUPPLIERS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(SUPPLIERS, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(SUPPLIERS, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>