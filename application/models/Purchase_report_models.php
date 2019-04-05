<?php 

class Purchase_report_models extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	   
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*');
            $this->db->select('(select sum(purchasing_unit_price*purchasing_unit*(100-discount_persent)*0.01) from '.SUPPLIER_INVOICE_DESC.' where supplier_invoice_id = i.id) as invoice_desc_total');
            $this->db->select('c.supplier_name,c.supplier_ref,pt.payment_term_name,pt.days_after');
            $this->db->from(SUPPLIER_INVOICE.' i');
            $this->db->join(SUPPLIERS.' c','c.id = i.supplier_id','left'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payment_term_id'); 
            $this->db->where('i.deleted',0); 
            
            if(isset($data['invoice_no']) && $data['invoice_no']!='') $this->db->where('i.supplier_invoice_no',$data['invoice_no']);
            if(isset($data['supplier_id']) && $data['supplier_id']!='') $this->db->where('i.supplier_id',$data['supplier_id']);
            if($data['from_date']!='' && $data['to_date']!='') $this->db->where("invoice_date>= ".$data['from_date']." AND invoice_date<= ".$data['to_date']." ");
           
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
	  
        public function get_suppliers($sup_id=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('c.*'); 
            $this->db->from(SUPPLIERS.' c');  
            $this->db->where('c.deleted',0); 
            if($sup_id!='') $this->db->where('c.id',$sup_id);
            $result = $this->db->get()->result_array();   
            return $result;
	}
 
}
?>