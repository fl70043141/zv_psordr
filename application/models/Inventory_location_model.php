<?php 

class Inventory_location_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('il.*');
            $this->db->from(INV_LOCATION." il");  
            $this->db->where('il.deleted',0);
            if(isset($data['status']) && $data['status']!='')$this->db->where('il.status',$data['status']);
            if(isset($data['location_name']) && $data['location_name']!='')$this->db->like('il.location_name',$data['location_name']);
            if(isset($data['code']) && $data['code']!='')$this->db->like('il.location_code',$data['code']);
           
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
          public function get_single_row($id){ 
            $this->db->select('il.*');
            $this->db->from(INV_LOCATION." il");  
            $this->db->where('il.id',$id);
            $this->db->where('il.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(INV_LOCATION, $data);  
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['resource_tbl']['hotel_id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(INV_LOCATION, $data); 
                        
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(INV_LOCATION, $data); 
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(INV_LOCATION, array('id' => $id));     
                $this->db->delete(HOTEL_RESOURCE, array('hotel_id' => $id));     
                $this->db->delete(HOTEL_IMAGES_TBL, array('hotel_id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>