<?php 

class Buy_gold_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
           $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->from(OLD_GOLD.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payment_term_id'); 
            $this->db->where('i.deleted',0);
//            if(isset($data['supp_invoice_no'])) $this->db->like('i.supplier_invoice_no',$data['supp_invoice_no']);
//            if(isset($data['supplier_id']) && $data['supplier_id']!='') $this->db->where('i.supplier_id',$data['supplier_id']);
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
	
         public function get_single_row($id,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone');
            $this->db->from(OLD_GOLD.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
//            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payment_term_id');  
            $this->db->where('i.id',$id);
            $this->db->where('i.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}               
         public function get_invc_desc($id){ 
            $this->db->select('id.*, (id.og_unit_price*id.og_unit) as sub_total'); 
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.og_unit_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.og_unit_id_2)  as unit_abbreviation_2');
            $this->db->from(OLD_GOLD_DESC.' id'); 
            $this->db->where('id.og_id',$id);
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
         public function get_single_item($item_code,$supp_id,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('ip.price_amount,ip.currency_code');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(ITEMS.' i'); 
            $this->db->join(ITEM_PRICES.' ip','ip.item_id = i.id'); 
            $this->db->where('i.status',1);
            $this->db->where('i.deleted',0);
            $this->db->where('ip.deleted',0);
            $this->db->where('ip.item_price_type',1);
            $this->db->where('ip.supplier_id',$supp_id);
            $this->db->where('i.item_code',$item_code);
//            $this->db->where('ip.sales_type_id',$sales_type);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result)){
                return $result[0];
            }else{
                return $this->get_single_item_for_code($item_code, $where);
            }
            return $result;
	}
        
         public function get_single_category($cat_id,$where=''){ 
            $this->db->select('ic.*');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = ic.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = ic.item_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(ITEM_CAT.' ic'); 
            $this->db->where('ic.status',1);
            $this->db->where('ic.deleted',0);
            $this->db->where('ic.id',$cat_id);
//            $this->db->where('ip.sales_type_id',$sales_type);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result))
                return $result[0];
            return $result;
	}
         public function get_single_item_for_code($item_code,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(ITEMS.' i'); 
            $this->db->where('i.status',1);
            $this->db->where('i.deleted',0);
            $this->db->where('i.item_code',$item_code);
//            $this->db->where('ip.sales_type_id',$sales_type);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result))
                return $result[0];
            return $result;
	}
         
         public function get_currency_for_code($code='LKR',$where=''){ 
            $this->db->select('*');
            $this->db->from(CURRENCY);
            if($code!='')$this->db->where('code',$code);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result))
                return $result[0];
            return $result;
	}
         
                        
        public function add_db($data){
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                
		if(!empty($data['inv_tbl']))$this->db->insert(OLD_GOLD, $data['inv_tbl']);       
		if(!empty($data['inv_desc']))$this->db->insert_batch(OLD_GOLD_DESC, $data['inv_desc']); 
                
		if(!empty($data['og_ref_tbl']))$this->db->insert(OLD_GOLD_REF, $data['og_ref_tbl']);   
                
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']);  
                
                if(isset($data['so_og_data'])){//temp so
                    $this->db->where('user_id',$this->session->userdata(SYSTEM_CODE)['ID']);
                    $this->db->where('reference',$this->session->userdata(SYSTEM_CODE)['ID'].'_so_0');
                    $this->db->update(SALES_ORDER_ITEM_TEMP,array('og_data'=> json_encode($data['so_og_data'])));
                }
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['inv_tbl']['id']; 
		return $status;
	}
        
        public function add_new_invoice_item($data){      
//            echo '<pre>';            print_r($data); die;
                $this->db->trans_start();
                
		$this->db->insert(ITEMS, $data['item']);   
		$this->db->insert(ITEM_PRICES, $data['purchase_price']); 
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['item']['id']; 
		return $status;
	}
        
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(VEHICLE_RATES, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
//                echo '<pre>'; print_r($data); die; 
		$this->db->trans_start();
                
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(OLD_GOLD, $data['bg_tbl']);
		
                $this->db->where('og_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(OLD_GOLD_DESC, array('deleted'=>1));
                
                if($data['ref_so']==1){
                    $this->db->where('og_id', $id); 
                    $this->db->where('deleted',0);
                    $this->db->update(OLD_GOLD_REF, array('deleted'=>1));
                }
		
                $this->db->where('og_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(OLD_GOLD_REF, array('deleted'=>1)); 
		
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
                
                $status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(VEHICLE_RATES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
 
}
?>