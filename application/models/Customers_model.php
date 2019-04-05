<?php 

class Customers_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data='',$where=''){  
//                        echo '<pre>';            print_r($data); die;
            $this->db->select('a.*, at.customer_type_name');
            $this->db->from(CUSTOMERS.' a');  
            $this->db->join(CUSTOMER_TYPE.' at','at.id = a.customer_type_id');  
            $this->db->where('a.deleted',0);
            if($data !=''){
                if(isset($data['customer_name']) && $data['customer_name']!='') $this->db->like('a.customer_name', $data['customer_name']); 
                if(isset($data['category']) && $data['category']!='') $this->db->like('a.customer_type_id', $data['category']); 
                if(isset($data['code']) && $data['code']!='') $this->db->like('a.short_name', $data['code']); 
                    if(isset($data['costomer_phone']) && $data['costomer_phone']!='') $this->db->like('a.phone', $data['costomer_phone']); 
            } 
               
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(CUSTOMERS); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){     
                $this->db->trans_start();
		$this->db->insert(CUSTOMERS, $data['customer']); 
		$this->db->insert(CUSTOMER_BRANCHES, $data['customer_branch']); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['customer']['id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(CUSTOMERS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(CUSTOMERS, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(CUSTOMERS, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
        //*******************Branches *******************************
        
        public function get_single_row_branch($id='',$customer_id=''){ 
            $this->db->select('cb.*,c.customer_name');
            $this->db->join(CUSTOMERS.' c','c.id = cb.customer_id', 'left');
            $this->db->from(CUSTOMER_BRANCHES.' cb'); 
            if($customer_id!='')$this->db->where('cb.customer_id',$customer_id);
            if($id!='')$this->db->where('cb.id',$id);
            $this->db->where('cb.deleted',0);
            $result = $this->db->get()->result_array();   
            return $result;
	}
         public function add_db_branch($data){       
                $this->db->trans_start();
		$this->db->insert(CUSTOMER_BRANCHES, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db_branch($id,$data){
//            echo '<pre>';            print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(CUSTOMER_BRANCHES, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db_branch($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(CUSTOMER_BRANCHES, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
 
}
?>