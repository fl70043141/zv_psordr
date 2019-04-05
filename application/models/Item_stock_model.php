<?php 

class Item_stock_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	  
	
         public function get_single_row($id='',$where=''){ 
            $this->db->select('*');
            $this->db->from(ITEM_STOCK); 
            if($id!='')$this->db->where('id',$id);
            if($where!='')$this->db->where($where);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            
            if(!empty($result))
                return $result[0];
            return $result;
	}
         public function get_stock_transection($trans_ref,$where=''){ //1-purchased, 2-Sale, 3-location_change, 4-return, 5-damaged,6-Sales order
            $this->db->select('*');
            $this->db->from(ITEM_STOCK_TRANS); 
            if($trans_ref!='')$this->db->where('trans_ref',$trans_ref);
            if($where!='')$this->db->where($where);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            
            return $result;
	}
        
         public function get_stock($location_id,$item_id='',$where=''){ //1-purchased, 2-Sale, 3-location_change, 4-return, 5-damaged,6-Sales order
            $this->db->select('*');
            $this->db->from(ITEM_STOCK); 
            if($location_id!='')$this->db->where('location_id',$location_id);
            if($item_id!='')$this->db->where('item_id',$item_id);
            if($where!='')$this->db->where($where);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            
            return $result;
	}
        
         public function get_stock_by_code($item_code='',$location_id='',$where=''){ 
            $this->db->select('itm.item_code,is.*');
            $this->db->select('is.*,SUM(is.units_available) as tot_units_1, SUM(is.units_available_2) as tot_units_2');
            $this->db->join(ITEMS.' itm','itm.id = is.item_id'); 
            $this->db->from(ITEM_STOCK.' is'); 
            if($location_id!='')$this->db->where('is.location_id',$location_id);
            if($item_code!='')$this->db->where('itm.item_code',$item_code);
            if($where!='')$this->db->where($where);
            $this->db->where('is.deleted',0);
            $this->db->group_by('is.item_id',0);
            $result = $this->db->get()->result_array();   
//echo $this->db->last_query(); die;
            
            return (!empty($result[0])?$result[0]:'');
	}
                         
        public function add_db($data){       
                $this->db->trans_start();
		$this->db->insert(ITEM_STOCK, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(ADDONS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}       
        
 
}
?>