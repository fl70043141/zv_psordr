<?php 

class Quotaions_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('q.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = q.added_by) as sales_person');
            $this->db->select('(select dropdown_value from '.DROPDOWN_LIST.' where id = q.quotation_type) as quotation_type_name');
            $this->db->select('c.customer_name,c.address,c.city,c.phone');
            $this->db->from(QUOTATIONS.' q'); 
            $this->db->join(CUSTOMERS.' c','c.id = q.person_id');   
            $this->db->where('q.deleted',0);
            if(isset($data['invoice_no']) && $data['invoice_no']!='') $this->db->like('q.quote_no',$data['invoice_no']);
            if(isset($data['customer_id']) && $data['customer_id']!='') $this->db->like('q.person_id',$data['customer_id']);
            if(isset($data['quotation_type']) && $data['quotation_type']!='') $this->db->like('q.quotation_type',$data['quotation_type']);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
            return $result;
	}
	
         public function get_single_row($id,$where=''){ 
            $this->db->select('q.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = q.added_by) as sales_person');
            $this->db->select('(select dropdown_value from '.DROPDOWN_LIST.' where id = q.quotation_type) as quotation_type_name');
            $this->db->select('c.customer_name,c.address,c.city,c.phone');
            $this->db->from(QUOTATIONS.' q'); 
            $this->db->join(CUSTOMERS.' c','c.id = q.person_id'); 
            $this->db->where('q.id',$id);
            $this->db->where('q.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
            return $result[0];
	}               
         public function get_invc_desc($id){ 
            $this->db->select('id.*, (id.unit_price*id.quantity*(100-id.discount_persent)*0.01) as sub_total');
            $this->db->select('(select ic.id from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = id.item_id) as item_category');
            $this->db->from(INVOICE_DESC.' id'); 
            $this->db->where('id.invoice_id',$id);
            $this->db->where('id.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}  
         public function get_transections($inv_id,$where=''){ 
            $this->db->select('tr.*');
            $this->db->select('trt.name,trt.calculation');
            $this->db->from(TRANSECTION.' tr'); 
            $this->db->join(TRANSECTION_TYPES.' trt', 'trt.id = tr.transection_type_id'); 
            $this->db->where('tr.trans_reference',$inv_id);
            $this->db->where('tr.status',1);
            $this->db->where('tr.person_type',20);//garage cust
            $this->db->where('tr.deleted',0);
            if($where!='') $this->db->where('tr.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
         public function get_single_item($item_code,$sales_type,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('ip.price_amount,ip.currency_code');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id)  as unit_abbreviation');
            $this->db->from(ITEMS.' i'); 
            $this->db->join(ITEM_PRICES.' ip','ip.item_id = i.id'); 
            $this->db->where('i.status',1);
            $this->db->where('i.deleted',0);
            $this->db->where('i.item_code',$item_code);
            $this->db->where('ip.sales_type_id',$sales_type);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
            if(!empty($result))
                return $result[0];
            return $result;
	}
        
         public function get_single_row_for_vehicle_id($v_id){ 
            $this->db->select('*');
            $this->db->from(VEHICLE_RATES); 
            $this->db->where('vehicle_id',$v_id);
            $this->db->where('deleted',0);
            $this->db->where('status',1);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){    
            $this->db->trans_start();

            $this->db->insert(QUOTATIONS, $data);   

            $status[0]=$this->db->trans_complete();
            $status[1]=$data['id']; 
//            echo '<pre>';            print_r($status); die; 
            return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(VEHICLE_RATES, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(QUOTATIONS, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(VEHICLE_RATES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>