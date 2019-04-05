<?php 

class Upload_csv_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	  
                        
        public function add_db($data){     
            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
		$this->db->insert(ADDONS, $data); 
                $insert_id =  $this->db->insert_id();
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
         
        
 
}
?>