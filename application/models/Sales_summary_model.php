<?php 

class Sales_summary_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	  
        public function search_result1($data='',$where=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->select('sum(tr.transection_ref_amount) as tot_trans');
            $this->db->from(INVOICES.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id');  
            $this->db->join(TRANSECTION_REF.' tr','tr.reference_id= i.id');  
            $this->db->where('i.deleted',0); 
            
            $this->db->where('tr.person_type = 10');
            if($where!='') $this->db->where($where);
            
            if(isset($data['invoice_no'])) $this->db->like('i.invoice_no',$data['invoice_no']);
            if(isset($data['customer_id']) && $data['customer_id']!='') $this->db->where('i.customer_id',$data['customer_id']);
            $this->db->group_by('i.id');
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
        public function search_result($data=''){ 
//            echo '<pre>';            print_r(); die;
            $this->db->select('i.*');
            $this->db->select('(select sum(unit_price*item_quantity*(100-discount_persent)*0.01) from '.INVOICE_DESC.' where invoice_id = i.id) as invoice_desc_total');
            $this->db->select('c.customer_name,c.short_name,pt.payment_term_name,pt.days_after');
            $this->db->from(INVOICES.' i');
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id'); 
            $this->db->where('i.deleted',0); 
            
            if(isset($data['invoice_no']) && $data['invoice_no']!='') $this->db->where('i.invoice_no',$data['invoice_no']);
            if(isset($data['customer_id']) && $data['customer_id']!='') $this->db->where('i.customer_id',$data['customer_id']);
            if($data['from_date']!='' && $data['to_date']!='') $this->db->where("invoice_date>= ".$data['from_date']." AND invoice_date<= ".$data['to_date']." ");
           
            if($this->session->userdata(SYSTEM_CODE)['user_group_id']!=0) $this->db->where('i.inv_group_id',$this->session->userdata(SYSTEM_CODE)['user_group_id']); 
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
	  
        public function get_customers($cust_id=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('c.*'); 
            $this->db->from(CUSTOMERS.' c');  
            $this->db->where('c.deleted',0); 
            if($cust_id!='') $this->db->where('c.id',$cust_id);
            $result = $this->db->get()->result_array();   
            return $result;
	}
 
}
?>