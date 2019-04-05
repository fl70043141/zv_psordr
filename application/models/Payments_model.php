<?php 

class Payments_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}   
        
        public function get_payment_term($id){ 
            $this->db->select('*'); 
            $this->db->from(PAYMENT_TERMS);
              
            $this->db->where('deleted',0); 
            $this->db->where('id',$id);
            $this->db->group_by('id'); 
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;    
            return $result[0];
	}
        
         public function get_transections($person_type,$reference_id,$where=''){ 
            $this->db->select('tr.*'); 
            $this->db->select('(select payment_method_name from '.PAYMENT_METHOD.' where id = t.payment_method) as payment_method'); 
            $this->db->select('(select sum(transection_ref_amount) from '.TRANSECTION_REF.' where reference_id = tr.reference_id and person_type= '.$person_type.') as total_amount '); 
            $this->db->select('t.redeemed_inv_id,t.transection_type_id,t.currency_code,t.trans_date,t.transection_amount'); 
            $this->db->select('tt.name as trans_type_name,tt.calculation'); 
            $this->db->from(TRANSECTION_REF." tr");
            $this->db->join(TRANSECTION." t","t.id = tr.transection_id");
            $this->db->join(TRANSECTION_TYPES." tt","tt.id = t.transection_type_id");
              
            $this->db->where('tr.person_type',$person_type); 
            $this->db->where('tr.reference_id',$reference_id); 
            $this->db->where('tr.deleted',0);  
            if($where!='') $this->db->where($where);
            $this->db->group_by('tr.id'); 
            
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
            return $result[0];
	}
                        
        public function add_db($data){      
//            echo '<pre>';            print_r($data); die;    
                $this->db->trans_start();
                
                if(!empty($data['trans_tbl']))$this->db->insert(TRANSECTION, $data['trans_tbl']); 
                if(isset($data['trans_tbl_so_redeem']) && !empty($data['trans_tbl_so_redeem']))$this->db->insert(TRANSECTION, $data['trans_tbl_so_redeem']); 
		if(!empty($data['trans_ref']))$this->db->insert_batch(TRANSECTION_REF, $data['trans_ref']);  
                
                if(isset($data['trans_inv']) && !empty($data['trans_inv'])){
                    foreach ($data['trans_inv'] as $inv_id => $trans_inv){ 
                        $this->db->where('id',$inv_id);
                        if($data['trans_tbl']['person_type']==10){ $this->db->update(INVOICES,$trans_inv);}
                        if($data['trans_tbl']['person_type']==20){ $this->db->update(SUPPLIER_INVOICE,$trans_inv);} 
                    }
                }  
		 
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
                $insert_id =  $data['trans_tbl']['id'];
		$status[0]=$this->db->trans_complete();
		$status[1]=$insert_id; 
		return $status;
	}
                
        public function delete_db($id,$data){   
                $trans_info = $this->get_single_row($id);
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
                $this->db->where('id',$id); 
                $this->db->update(TRANSECTION, $data['trans_tbl']); 
                
		$this->db->where('transection_id', $id);  
		$this->db->update(TRANSECTION_REF, $data['trans_tbl']);  
                
                 
                if($trans_info['person_type']==10){ 
                    $this->db->where('id',$trans_info['reference_id']);
                    $this->db->update(INVOICES,array('payment_settled'=>0));
                }
                if($trans_info['person_type']==20){ 
                    $this->db->where('id',$trans_info['reference_id']);
                    $this->db->update(SUPPLIER_INVOICE,array('payment_settled'=>0));
                } 
                
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
                    
		$status=$this->db->trans_complete(); 
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(ACTIVITY_EVENTS, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
         
        
 
}
?>