<?php 

class Currencies_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('ct.*');
            $this->db->from(CURRENCY." ct");  
            $this->db->where('ct.deleted',0);
            if($data!=''){
                $this->db->where('ct.status',$data['status']);
//                $this->db->like('ct.customer_type_name',$data['type_name']);
            }
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
          public function get_single_row($id){ 
            $this->db->select('il.*');
            $this->db->from(CURRENCY." il");  
            $this->db->where('il.id',$id);
            $this->db->where('il.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(CURRENCY, $data);  
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
//            echo '<pre>';            print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(CURRENCY, $data); 
                        
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(CURRENCY, $data); 
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(CURRENCY, array('id' => $id));     
                $this->db->delete(HOTEL_RESOURCE, array('hotel_id' => $id));     
                $this->db->delete(HOTEL_IMAGES_TBL, array('hotel_id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>