<?php 

class Location_transfer_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	  
                        
        public function add_db($data){    
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                
		if(!empty($data['lt_tbl']))$this->db->insert(LOCATION_TRASNFER, $data['lt_tbl']);  
		if(!empty($data['lt_desc']))$this->db->insert_batch(LOCATION_TRASNFER_DESC, $data['lt_desc']);   
		if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }  
                $status[0]=$this->db->trans_complete();
		$status[1]=$data['lt_tbl']['id']; 
		return $status;
	}
         
        
        public function delete_db($id,$data){ 
            
//            echo '<pre>';            print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(INVOICES, $data['tbl_data']);
		
                $this->db->where('invoice_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(INVOICE_DESC, array('deleted'=>1));
                
                $this->db->where('reference_id', $id); 
                $this->db->where('person_type', 10); // cust
                $this->db->where('deleted',0);
		$this->db->update(TRANSECTION_REF, array('deleted'=>1,'deleted_on' => date('Y-m-d'),'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']));
		
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }
                
                
                $this->db->where('trans_ref', $id); 
                $this->db->where('transection_type', 2); 
                $this->db->delete(ITEM_STOCK_TRANS); 
                
                
                $status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(VEHICLE_RATES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
         public function get_single_row($id,$where=''){ 
            $this->db->select('i.*');
             $this->db->from(LOCATION_TRASNFER.' i');  
            $this->db->where('i.id',$id);
            $this->db->where('i.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}     
 
}
?>