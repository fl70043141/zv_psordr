<?php 

class Quick_entries_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('q.*'); 
            $this->db->select('qa.account_name, qa.short_name'); 
            $this->db->from(GL_QUICK_ENTRY.' q');    
            $this->db->join(GL_QUICK_ENTRY_ACC.' qa', 'qa.id = q.quick_entry_account_id');    
            $this->db->where('q.deleted',0); 
            if($data!=''){
                if($data['from_date']!='' && $data['to_date']!='') $this->db->where("q.entry_date>= ".$data['from_date']." AND q.entry_date<= ".$data['to_date']." ");
                if($data['quick_entry_account_id']!='' ) $this->db->where('q.quick_entry_account_id',$data['quick_entry_account_id']);
            }
             $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
            return $result;
	}
	
         public function get_single_row($id,$where=''){ 
            $this->db->select('q.*'); 
            $this->db->select('qa.account_name, qa.short_name'); 
            $this->db->from(GL_QUICK_ENTRY.' q');    
            $this->db->join(GL_QUICK_ENTRY_ACC.' qa', 'qa.id = q.quick_entry_account_id');    
            $this->db->where('q.deleted',0); 
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
            $this->db->from(GL_QUICK_ENTRY); 
            $this->db->where('vehicle_id',$v_id);
            $this->db->where('deleted',0);
            $this->db->where('status',1);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){  
//            echo '<pre>';            print_r($data); die;   
            $this->db->trans_start();

            if(!empty($data['entry_tbl']))$this->db->insert_batch(GL_QUICK_ENTRY, $data['entry_tbl']); 
            if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']);  
            
            $status=$this->db->trans_complete(); 
//            echo '<pre>';            print_r($status); die; 
            return $status;
	}
        
        public function edit_db($id,$data){
            die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(GL_QUICK_ENTRY, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
            
//            echo '<pre>'; print_r($data); die;
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(GL_QUICK_ENTRY, $data);
                
		$this->db->where('trans_ref', $id); 
                $this->db->where('deleted',0);
                $this->db->where('person_type',40); //40 for quick entry
		$this->db->update(GL_TRANS, $data);
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(GL_QUICK_ENTRY, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>