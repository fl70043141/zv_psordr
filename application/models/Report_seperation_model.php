<?php 

class Report_seperation_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data='',$where=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->from(INVOICES.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id');  
            $this->db->where('i.deleted',0); 
            
            if($where!='') $this->db->where($where); 
            if(isset($data['invoice_no']) && $data['invoice_no']!='') $this->db->like('i.invoice_no',$data['invoice_no']);
            if(isset($data['invoice_date']) && $data['invoice_date']!='') $this->db->where('i.invoice_date',$data['invoice_date']);
            
            $this->db->order_by('i.id','desc'); 
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
	 
        function update_invoices_groupstats($data,$where=''){
//            echo '<pre>';            print_r($data); die;
            $this->db->trans_start();
            
            if(isset($data['grouped']) && !empty($data['grouped'])){
                foreach ($data['grouped'] as $group_itm) {
                    $this->db->where('id', $group_itm);
                    $this->db->update(INVOICES, array('inv_group_id'=>$data['grouped_id']));
                } 
            }
            if(isset($data['notgrouped']) && !empty($data['notgrouped'])){
                foreach ($data['notgrouped'] as $notgroup_itm) {
                    $this->db->where('id', $notgroup_itm);
                    $this->db->update(INVOICES, array('inv_group_id'=>0));
                } 
            }
            
            $res = $this->db->trans_complete();
            return $res;
        }
}
?>