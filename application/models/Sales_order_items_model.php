<?php 

class Sales_order_items_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	} 
        
        public function so_search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
           $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('(select dropdown_value from '.DROPDOWN_LIST.' where id= i.price_type_id) as price_list_type');
            $this->db->select('c.customer_name,c.address,c.city,c.phone');
            $this->db->select('cb.branch_name');
            $this->db->from(SALES_ORDERS.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id');  
            $this->db->join(CUSTOMER_BRANCHES.' cb','cb.id = i.customer_branch_id');  
            $this->db->where('i.deleted',0);
            if(isset($data['sales_order_no'])) $this->db->like('i.sales_order_no',$data['sales_order_no']);
            if(isset($data['customer_id']) && $data['customer_id']!='') $this->db->where('i.customer_id',$data['customer_id']);
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
            return $result;
	}
	
        public function search_result($data='',$where=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*');
            $this->db->select('ic.id as cat_id,ic.category_name,ic.description as ic_desc,ic.cat_image');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = ic.item_uom_id)  as unit_abbreviation');
            if(isset($data['price_type_id']))$this->db->select('(select price_amount from '.ITEM_PRICES.' where item_id = i.id and sales_type_id = '.$data['price_type_id'].')  as item_price_amount');
            $this->db->join(ITEM_CAT." ic", 'ic.id = i.item_category_id');  
            $this->db->from(ITEMS." i");  
            $this->db->where('ic.deleted',0); 
            $this->db->where('ic.status',1);
            if($where!='') $this->db->where($where);
            if(isset($data['category_id']) && $data['category_id']!='') $this->db->where('ic.id',$data['category_id']);
            if(isset($data['item_code']) && $data['item_code']!='') $this->db->where('i.item_code',$data['item_code']);
            $this->db->order_by('i.id');
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
	
         public function get_single_row($id,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('(select symbol_left from '.CURRENCY.' where code = i.currency_code) as symbol_left');
            $this->db->select('(select symbol_right from '.CURRENCY.' where code = i.currency_code) as symbol_right');
            $this->db->select('c.customer_name,c.address,c.city,c.phone');
            $this->db->select('cb.branch_name,cb.branch_short_name,cb.mailing_address,cb.contact_person');
            $this->db->from(SALES_ORDERS.' i'); 
            $this->db->join(CUSTOMER_BRANCHES.' cb','cb.id = i.customer_branch_id'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
//            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id'); 
            $this->db->where('i.id',$id);
            $this->db->where('i.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}               
         public function get_so_desc($id){ 
            $this->db->select('id.*, (id.unit_price*id.units*(100-id.discount_percent)*0.01) as sub_total');
            $this->db->select('im.item_code,im.image');
            $this->db->select('(select ic.id from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = id.item_id) as item_category');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.unit_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.secondary_unit_uom_id)  as unit_abbreviation_2');
            $this->db->join(ITEMS.' im','im.id = id.item_id','left'); 
            $this->db->from(SALES_ORDER_DESC.' id'); 
            $this->db->where('id.sales_order_id',$id);
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
         public function get_single_item($item_code,$customer_id,$price_type_id,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('ip.price_amount,ip.currency_code');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(ITEMS.' i'); 
            $this->db->join(ITEM_PRICES.' ip','ip.item_id = i.id'); 
            $this->db->where('i.status',1);
            $this->db->where('i.deleted',0);
            $this->db->where('ip.deleted',0);
            $this->db->where('ip.item_price_type',2); //2 for sales
            $this->db->where('i.item_code',$item_code);
            $this->db->where('ip.sales_type_id',$price_type_id);
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
         public function get_item_price($item_id,$price_type_id,$where=''){ 
            $this->db->select('*');
            $this->db->from(ITEM_PRICES);
            if($item_id!='')$this->db->where('item_id',$item_id);
            if($price_type_id!='')$this->db->where('sales_type_id',$price_type_id);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result))
                return $result[0];
            return $result;
	}
         public function get_temp_so_item($order_id,$where=''){ 
            $this->db->select('*');
            $this->db->from(SALES_ORDER_ITEM_TEMP);
            if($order_id!='')$this->db->where('reference',$this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$order_id);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result))
                return $result[0];
            return $result;
	}
         public function get_temp_so_item_user($where=''){ 
            $this->db->select('*');
            $this->db->from(SALES_ORDER_ITEM_TEMP);
            $this->db->where('user_id',$this->session->userdata(SYSTEM_CODE)['ID']);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result))
                return $result;
            return $result;
	}
        
        function delete_temp_so_item($reference='',$user_id=''){
                $this->db->trans_start();
//                $this->db->where('reference',$reference);
                if($reference!='') $this->db->where('reference', $reference);
                if($user_id!='') $this->db->where('user_id', $user_id);
                $this->db->delete('sales_order_item_temp');    
                $status = $this->db->trans_complete();  
//                echo '<pre>';                print_r($status);
                return $status;	
	} 
        public function insert_temp_item($data){    
              $this->db->trans_start();
              $this->db->insert(SALES_ORDER_ITEM_TEMP, $data);   
              $status=$this->db->trans_complete();
              return $status;
	}
                        
        public function add_db($data){    
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                
		if(!empty($data['so_tbl']))$this->db->insert(SALES_ORDERS, $data['so_tbl']);  
		if(!empty($data['so_desc']))$this->db->insert_batch(SALES_ORDER_DESC, $data['so_desc']);   
		if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_on_demand'=>$stock['units_on_demand'],'units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }
                
                $this->db->where('reference',$this->session->userdata(SYSTEM_CODE)['ID'].'_so_0');
                $this->db->delete(SALES_ORDER_ITEM_TEMP);    
                
		if(!empty($data['og_ref_tbl']))$this->db->insert_batch(OLD_GOLD_REF, $data['og_ref_tbl']); //OG Refs
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['resource_tbl']['id']; 
		return $status;
	}
        public function add_item_for_order($data){    
                $this->db->trans_start();
                 
		if(!empty($data['so_desc']))$this->db->insert(SALES_ORDER_DESC, $data['so_desc']);   
		if(!empty($data['item_stock_transection']))$this->db->insert(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){ 
                    $this->db->where('location_id', $data['item_stock']['location_id']);
                    $this->db->where('item_id', $data['item_stock']['item_id']);
                    $this->db->update(ITEM_STOCK, array('units_on_demand'=>$data['item_stock']['units_on_demand'],'units_available'=>$data['item_stock']['new_units_available'],'units_available_2'=>$data['item_stock']['new_units_available_2']));
                } 
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function edit_db($id,$data){
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                if(!empty($data['pre_update_check']['updt_itm_trans_table'])){
                    foreach ($data['pre_update_check']['updt_itm_trans_table'] as $key1=>$updt_trans_row){
                        //remove transections
                        $this->db->where('id', $key1);
                        $this->db->where('deleted',0);
                        $this->db->update(ITEM_STOCK_TRANS, $updt_trans_row);
                    }
                }
                if(!empty($data['pre_update_check']['updt_itm_stock_table'])){
                    foreach ($data['pre_update_check']['updt_itm_stock_table'] as $key2=>$updt_stock_row){
                        //remove transections
                        $this->db->where('id', $key2);
                        $this->db->where('deleted',0);
                        $this->db->update(ITEM_STOCK, $updt_stock_row);
                    }
                }
//                die; 
                
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
                $this->db->update(SALES_ORDERS, $data['so_tbl']);  
                
                $this->db->where('sales_order_id', $id); 
                $this->db->where('deleted',0);
//		$this->db->update(SALES_ORDER_DESC, array('deleted'=>1));
                $this->db->delete(SALES_ORDER_DESC);    
		if(!empty($data['so_desc']))$this->db->insert_batch(SALES_ORDER_DESC, $data['so_desc']);   
                
                
		if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_on_demand'=>$stock['units_on_demand'],'units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }
		$status=$this->db->trans_complete();
		return $status;
	}
        
        
        public function delete_db($id,$data){ 
//            echo '<pre>';            print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(SALES_ORDERS, $data['del_arr']);
		
                $this->db->where('sales_order_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(SALES_ORDER_DESC, array('deleted'=>1));
		
                if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_on_demand'=>$stock['units_on_demand'],'units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }
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