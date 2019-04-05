<?php 

class GL_quick_entry_accounts_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('ic.*');
            $this->db->select('(select CONCAT(account_name," - ",account_code) from '.GL_CHART_MASTER.' where account_code = ic.debit_gl_code) as debit_gl_name');
            $this->db->select('(select CONCAT(account_name," - ",account_code) from '.GL_CHART_MASTER.' where account_code = ic.credit_gl_code) as credit_gl_name');
            $this->db->from(GL_QUICK_ENTRY_ACC." ic");  
            $this->db->where('ic.deleted',0);
            if($data!=''){
                $this->db->where('ic.status',$data['status']);
                $this->db->like('ic.account_name',$data['account_name']);
            }
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
          public function get_single_row($id){ 
            $this->db->select('ic.*');
            $this->db->select('(select CONCAT(account_name," - ",account_code) from '.GL_CHART_MASTER.' where account_code = ic.debit_gl_code) as debit_gl_name');
            $this->db->select('(select CONCAT(account_name," - ",account_code) from '.GL_CHART_MASTER.' where account_code = ic.credit_gl_code) as credit_gl_name');
            $this->db->select('(select id from '.GL_CHART_MASTER.' where account_code = ic.debit_gl_code) as debit_gl_id');
            $this->db->select('(select id from '.GL_CHART_MASTER.' where account_code = ic.credit_gl_code) as credit_gl_id');
            $this->db->from(GL_QUICK_ENTRY_ACC." ic");  
            $this->db->where('ic.id',$id);
            $this->db->where('ic.deleted',0);
            $result = $this->db->get()->result_array();    
            return $result;
	}
                        
        public function add_db($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(GL_QUICK_ENTRY_ACC, $data);  
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(GL_QUICK_ENTRY_ACC, $data); 
                        
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
                
		$this->db->where('id', $id);
		$this->db->update(GL_QUICK_ENTRY_ACC, $data); 
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(GL_QUICK_ENTRY_ACC, array('id' => $id));     
                $this->db->delete(HOTEL_RESOURCE, array('hotel_id' => $id));     
                $this->db->delete(HOTEL_IMAGES_TBL, array('hotel_id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>