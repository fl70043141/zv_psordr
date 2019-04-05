<?php 

class Customer_balance_model extends CI_Model
{
	function __construct(){ 
            parent::__construct(); 
 	}
                        
         public function search_result($data=''){ 
            $this->db->select('sl.*,u.first_name,u.last_name');
            $this->db->from(SYSTEM_LOG.' sl'); 
            $this->db->join(USER.' u', 'u.auth_id = sl.user_id');
                          

            if(isset($data['name']) && $data['name'] !=''){
                $this->db->where("(u.first_name like '%".$data['name']."%' OR u.last_name like '%".$data['name']."%')"); 
            } 
            if(isset($data['object']) && $data['object'] !=''){
                $this->db->like('sl.module_id',$data['object']); 
            } 
            if(isset($data['action']) && !empty($data['action'])){
                foreach ($data['action'] as $action){
                    $this->db->like('sl.action_id',$action);    
                }
            } 
            if((isset($data['date_from']) && $data['date_from'] !='') && isset($data['date_to']) && $data['date_to'] !=''){
                $this->db->where('sl.date>', strtotime($data['date_from'])); 
                $this->db->where('sl.date<', strtotime($data['date_to'])); 
            } 
            $result = $this->db->get()->result_array(); 
//              echo '<pre>';print_r(date('Y-m-d',time())); die;
//            echo $this->db->last_query();die;
            return $result;
	}
	
         public function get_single_log($id){ 
            $this->db->select('sl.*,sld.*,u.first_name,u.last_name');
            $this->db->from(SYSTEM_LOG.' sl');
            $this->db->join(SYSTEM_LOG_DETAIL.' sld', 'sld.system_log_id = sl.id');
            $this->db->join(USER.' u', 'u.auth_id = sl.user_id');
            $this->db->where('sl.id',$id);
            $result = $this->db->get()->result_array(); 
//            echo $this->db->last_query(); die;
            return $result;
	}
        
         public function get_customer_list($cust_id=''){ 
            $this->db->select('*'); 
            $this->db->from(CUSTOMERS);
            $this->db->where('deleted',0);
            if($cust_id!='')$this->db->where('id',$cust_id);
            $result = $this->db->get()->result_array();     
            return $result;
	}
         public function get_reservations_customer($cust_id=''){ 
            $this->db->select('r.*,c.customer_name,c.phone,count(rv.id) as vehicle_count'); 
            $this->db->from(RESERVATION.' r');
            $this->db->join(RESERVATION_VEHICLES.' rv', 'rv.reservation_id = r.id','left');   
            $this->db->join(PAYMENT_TERMS.' pt', 'pt.id = r.payment_term_id','left');   
            $this->db->join(CUSTOMERS.' c', 'c.id = r.customer_id','left');   
              
            $this->db->where('r.deleted',0); 
            if($cust_id!='')$this->db->where('r.customer_id',$cust_id);
            $this->db->group_by('r.id'); 
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;    
            return $result;
	}
        public function get_reservation_charges($res_id){ 
            $this->db->select('*');
            $this->db->from(RESERVATION_CHARGES); 
            $this->db->where('reservation_id',$res_id);
            $this->db->where('status',1);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;    
            return $result;
	}
        public function get_invoices_customers($cust_id){ 
            $this->db->select('*');
            $this->db->from(INVOICES); 
            $this->db->where('invoice_type',10); //10 for sales
            $this->db->where('person_id',$cust_id);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;    
            return $result;
	}
                        
         
}
?>