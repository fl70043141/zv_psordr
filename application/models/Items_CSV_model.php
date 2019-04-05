<?php 

class Items_CSV_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	  
        public function add_db_purch_invoice($data){    
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                
		$this->db->insert(SUPPLIER_INVOICE, $data['supp_inv_tbl']);   
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        public function add_db_item($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(ITEMS, $data['item']);  
		$this->db->insert_batch(ITEM_PRICES, $data['prices']);  
		$this->db->insert(SUPPLIER_INVOICE_DESC, $data['supplier_inv_desc']);  
                if(!empty($data['item_stock_transection']))$this->db->insert(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){ 
                        $this->db->where('location_id', $data['item_stock']['location_id']);
                        $this->db->where('item_id', $data['item_stock']['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_available'=>$data['item_stock']['new_units_available'],'units_available_2'=>$data['item_stock']['new_units_available_2']));
                  
                }
		$status[0]=$this->db->trans_complete();
		return $status;
	}
        public function add_db_gl($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
//		if(!empty($data['addons']))$this->db->insert_batch(INVOICES_ADDONS, $data['addons']); 
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
                
		$status[0]=$this->db->trans_complete();
		return $status;
	}
 
}
?>