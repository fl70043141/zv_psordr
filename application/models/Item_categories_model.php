<?php 

class Item_categories_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('ic.*');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = ic.item_uom_id)  as unit_abbreviation');
            $this->db->from(ITEM_CAT." ic");  
            $this->db->where('ic.deleted',0);
            if($data!=''){
                if(isset($data['status']) && $data['status']!='')$this->db->where('ic.status',$data['status']);
                if(isset($data['category_name']) && $data['category_name']!='') $this->db->like('ic.category_name',$data['cat_name']);
                if(isset($data['category_code']) && $data['category_code']!='') $this->db->like('ic.category_code',$data['category_code']);
            }
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
          public function get_single_row($id){ 
            $this->db->select('ic.*');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = ic.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = ic.item_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(ITEM_CAT." ic");  
            $this->db->where('ic.id',$id);
            $this->db->where('ic.deleted',0);
            $result = $this->db->get()->result_array();    
            return $result;
	}
                        
        public function add_db($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(ITEM_CAT, $data);  
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['resource_tbl']['hotel_id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(ITEM_CAT, $data); 
                        
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(ITEM_CAT, $data); 
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(ITEM_CAT, array('id' => $id));     
                $this->db->delete(HOTEL_RESOURCE, array('hotel_id' => $id));     
                $this->db->delete(HOTEL_IMAGES_TBL, array('hotel_id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>