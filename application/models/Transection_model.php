<?php 

class Transection_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data='',$where=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('t.*'); 
            $this->db->select('tr.reference_id,tr.trans_reference,tr.person_type'); 
//            $this->db->select('(select invoice_no from '.INVOICES.' where id=t.trans_reference and t.person_type =20) as invoice_no');
            $this->db->select('(select name from '.TRANSECTION_TYPES.' where id=t.transection_type_id) as tt_name');
            $this->db->join(TRANSECTION_REF.' tr', 'tr.transection_id = t.id');   
            $this->db->from(TRANSECTION.' t');   
            $this->db->where('t.deleted',0);  
            if(isset($data['category']) && $data['category']!='')$this->db->where('t.transection_type_id', $data['category']); 
            if(isset($data['amount']) && $data['amount']!='')$this->db->where('t.transection_amount', $data['amount']); 
              
            if($where!=''){
                  $this->db->where('t.status', $where); 
            }
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('t.*'); 
            $this->db->select('tr.reference_id,tr.trans_reference,tr.person_type'); 
            $this->db->select('(select name from '.TRANSECTION_TYPES.' where id=t.transection_type_id) as tt_name');
            $this->db->join(TRANSECTION_REF.' tr', 'tr.transection_id = t.id');   
            $this->db->from(TRANSECTION.' t');   
           $this->db->where('t.id',$id);
            $this->db->where('t.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){       
                $this->db->trans_start();
		$this->db->insert(TRANSECTION, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(TRANSECTION, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(TRANSECTION, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(TRANSECTION, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
        public function get_transections_supplier($sup_id,$person_type='30'){ 
            $this->db->select('tr.*');
            $this->db->select('trt.name,trt.calculation');
            $this->db->from(TRANSECTION.' tr'); 
            $this->db->join(TRANSECTION_TYPES.' trt', 'trt.id = tr.transection_type_id'); 
            $this->db->where('tr.person_id',$sup_id);
            $this->db->where('tr.person_type',$person_type);
            $this->db->where('tr.transection_type_id',3);//sup payments
            $this->db->where('tr.status',1);
            $this->db->where('tr.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
 
}
?>