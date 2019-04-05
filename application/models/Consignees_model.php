<?php 

class Consignees_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('s.*');
            $this->db->from(CONSIGNEES.' s');  
            $this->db->where('s.deleted',0);
            if(isset($data['consignee_name']) && $data['consignee_name']!='')$this->db->like('s.consignee_name', $data['consignee_name']);   
            if(isset($data['code']) && $data['code']!='')$this->db->like('s.consignee_short_name', $data['code']);   
            if(isset($data['phone']) && $data['phone']!='')$this->db->like('s.phone', $data['phone']);   
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();
            return $result;
	}
	
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(CONSIGNEES); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){
//            echo '<pre>';            print_r($data); die;       
                $this->db->trans_start();
		$this->db->insert(CONSIGNEES, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(CONSIGNEES, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(CONSIGNEES, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(CONSIGNEES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>