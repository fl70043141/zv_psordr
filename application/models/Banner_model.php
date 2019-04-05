<?php 

class Banner_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
         public function search_result($data=''){ 
            $this->db->select('*');
            $this->db->from(BANNERS);   
//            $this->db->where('deleted',0);
            if($data !=''){
                $this->db->like('banner_name', $data['banner_name']); 
               } 
            $result = $this->db->get()->result_array();  
            return $result;
	}
	
         public function get_banner_list($type){ 
            $this->db->select('*');
            $this->db->from(BANNERS); 
            $this->db->where('type',$type);
//            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
         public function get_single_row($id){ 
            $this->db->select('*');
            $this->db->from(BANNERS); 
            $this->db->where('id',$id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}
                        
        public function add_db($data){       
                $this->db->trans_start(); 
                $this->db->insert(BANNERS, $data);   
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(BANNERS, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->where('id!=', 1);
                $this->db->where('deleted',0);
		$this->db->update(BANNERS, $data);
		$status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(BANNERS, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>