<?php 

class Fiscal_years_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('ct.*');
            $this->db->from(GL_FISCAL_YEARS." ct");  
            $this->db->where('ct.deleted',0);
            if($data!=''){
                $this->db->where('ct.status',$data['status']);
                $this->db->where('ct.closed',$data['closed']);
//                $this->db->like('ct.customer_type_name',$data['type_name']);
            }
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
          public function get_single_row($id){ 
            $this->db->select('il.*');
            $this->db->from(GL_FISCAL_YEARS." il");  
            $this->db->where('il.id',$id);
            $this->db->where('il.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(GL_FISCAL_YEARS, $data);  
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
//            echo '<pre>';            print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(GL_FISCAL_YEARS, $data); 
                        
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(GL_FISCAL_YEARS, $data); 
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(GL_FISCAL_YEARS, array('id' => $id));     
                $this->db->delete(HOTEL_RESOURCE, array('hotel_id' => $id));     
                $this->db->delete(HOTEL_IMAGES_TBL, array('hotel_id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>