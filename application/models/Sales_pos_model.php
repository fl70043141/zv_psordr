<?php 

class Sales_pos_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data='',$where=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->from(INVOICES.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id');  
            $this->db->where('i.deleted',0); 
            
            if($where!='') $this->db->where($where);
            
            if(isset($data['invoice_no'])) $this->db->like('i.invoice_no',$data['invoice_no']);
            if(isset($data['customer_id']) && $data['customer_id']!='') $this->db->where('i.customer_id',$data['customer_id']);
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
         public function search_result_reservartion($data='',$where=''){
//            echo '<pre>';            print_r($data); die;
            $this->db->select('it.*'); 
            $this->db->select('c.customer_name,c.phone'); 
            $this->db->join(CUSTOMERS.' c', 'c.id = it.customer_id');
            $this->db->from(INVOICES_TEMP.' it');
            $this->db->where('it.temp_invoice_status',2);//resercved 
            if(isset($data['res_no']))$this->db->like('it.temp_invoice_no',$data['res_no']);
            if(isset($data['customer_id']) && $data['customer_id']!='')$this->db->where('it.customer_id',$data['customer_id']);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();
//            echo  $this->db->last_query(); die;    
            return $result;
	}
	
         public function get_single_row($id,$where=''){
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->from(INVOICES.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.customer_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id'); 
            $this->db->where('i.id',$id);
            $this->db->where('i.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}               
         public function get_invc_desc($id){
            $this->db->select('id.*, ((id.unit_price*id.item_quantity*(100-id.discount_persent)*0.01) - id.discount_fixed) as sub_total');
            $this->db->select('(select ic.id from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = id.item_id) as item_category');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.item_quantity_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.item_quantity_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(INVOICE_DESC.' id'); 
            $this->db->where('id.invoice_id',$id);
            $this->db->where('id.deleted',0);
            $result = $this->db->get()->result_array();  
//        echo '<pre>';        print_r($result);die;
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
        public function get_single_item($item_code,$sales_type_id,$where=''){
//            $this->db->select('i.*,is.uom_id,is.units_available,is.uom_id_2,is.units_available_2');
            $this->db->select('i.*');
            $this->db->select('ip.price_amount,ip.currency_code');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(ITEMS.' i'); 
//            $this->db->join(ITEM_STOCK.' is','is.item_id = i.id'); 
            $this->db->join(ITEM_PRICES.' ip','ip.item_id = i.id'); 
            $this->db->where('i.status',1);
            $this->db->where('i.deleted',0);
            $this->db->where('ip.deleted',0);
            $this->db->where('ip.item_price_type',2); 
            $this->db->where('i.item_code',$item_code);
            $this->db->where('ip.sales_type_id',$sales_type_id);
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
        
         public function item_categories($id='',$where=''){ 
            $this->db->select('*');
            $this->db->from(ITEM_CAT);
            $this->db->order_by('order_by','asc');
            if($id!='')$this->db->where('id',$id);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die; 
            return $result;
	}
         public function get_vouchers($id='',$where=''){ 
            $this->db->select('*');
            $this->db->from(SALES_VOUCHER);
            if($id!='')$this->db->where('id',$id);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die; 
            return $result;
	}
        
         public function get_payment_methods($id='',$where=''){ 
            $this->db->select('*');
            $this->db->from(PAYMENT_METHOD);
            if($id!='')$this->db->where('id',$id);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die; 
            return $result;
	}
         
                        
        public function add_db($data){
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                
		if(!empty($data['inv_tbl']))$this->db->insert(INVOICES, $data['inv_tbl']);  
		if(!empty($data['inv_desc']))$this->db->insert_batch(INVOICE_DESC, $data['inv_desc']);   
		if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $update_arr = array('units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']);
                        if($stock['partial_invoiced']==1){
                            $update_arr['partial_invoiced'] = $stock['partial_invoiced'];
                        } 
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, $update_arr);
                    }
                }
                
                if($data['so_ref']!=""){//update so after invoice created 
                    $this->db->where('id',$data['so_ref']);
                    $this->db->update(SALES_ORDERS,array('invoiced'=>1));
                }
                if(isset($data['sales_ret_tbl'])){//update so after invoice created 
                    $this->db->where('id',$data['so_ref']);
                    $this->db->update(SALES_ORDERS,array('invoiced'=>1));
                }
                
                if(isset($data['return_note_nos'])){
                    foreach ($data['return_note_nos'] as $ret_notes){
                        $this->db->where('cn_no',$ret_notes);
                        $this->db->update(CREDIT_NOTES,array('payment_settled'=>1));
                    }
                }
                
                
		if(!empty($data['payment_transection']))$this->db->insert_batch(TRANSECTION, $data['payment_transection']);  
		if(!empty($data['payment_transection_ref']))$this->db->insert_batch(TRANSECTION_REF, $data['payment_transection_ref']);  
		
		if(!empty($data['addons']))$this->db->insert_batch(INVOICES_ADDONS, $data['addons']); 
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
                
                $status[0]=$this->db->trans_complete();
		$status[1]=$data['inv_tbl']['id']; 
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
            
//            echo '<pre>';            print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(INVOICES, $data['tbl_data']);
		
                $this->db->where('invoice_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(INVOICE_DESC, array('deleted'=>1));
                
                $this->db->where('reference_id', $id); 
                $this->db->where('person_type', 10); // cust
                $this->db->where('deleted',0);
		$this->db->update(TRANSECTION_REF, array('deleted'=>1,'deleted_on' => date('Y-m-d'),'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']));
		
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }
                
                
                $this->db->where('trans_ref', $id); 
                $this->db->where('transection_type', 2); 
                $this->db->delete(ITEM_STOCK_TRANS); 
                
//		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
                $this->db->where('trans_ref', $id); 
                $this->db->where('person_type', 10); // Cust
                $this->db->where('deleted',0);
		$this->db->update(GL_TRANS, array('deleted'=>1,'deleted_on' => date('Y-m-d'),'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']));
		
                $status=$this->db->trans_complete();
		return $status;
	}
        
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(VEHICLE_RATES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
        /*
            `   TEMP INVOICE TABLE
         */
        
         public function get_temp_invoice_open($user_id='',$where=''){ 
            $this->db->select('*');
            $this->db->from(INVOICES_TEMP);
            $this->db->where('temp_invoice_status',0);
            if($user_id!='')$this->db->where('user_id',$this->session->userdata(SYSTEM_CODE)['ID']);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
            if(!empty($result))
                return $result[0];
            return $result;
	}
        
         public function get_temp_invoice_paused($user_id='',$where=''){ 
            $this->db->select('*');
            $this->db->from(INVOICES_TEMP);
            $this->db->where('temp_invoice_status',1);//paused
            if($user_id!='')$this->db->where('user_id',$this->session->userdata(SYSTEM_CODE)['ID']);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();   
            return $result;
	}
         public function get_temp_invoice_reserved($recl_res_no='',$where=''){ 
            $this->db->select('it.*');
            $this->db->select('(select customer_name from '.CUSTOMERS.' where id = it.customer_id) as customer_name');
            $this->db->from(INVOICES_TEMP.' it');
            $this->db->where('it.temp_invoice_status',2);//resercved 
            if($recl_res_no!='')$this->db->like('it.temp_invoice_no',$recl_res_no);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();
//            echo  $this->db->last_query(); die;    
            return $result;
	}
        
        public function insert_temp_invoice_item($data){    
              $this->db->trans_start();
              $this->db->insert(INVOICES_TEMP, $data);   
              $status=$this->db->trans_complete();
              return $status;
	}
        public function update_temp_invoice_item($data,$where='temp_invoice_status = 0'){    
              $this->db->trans_start();
              $this->db->where('user_id',$this->session->userdata(SYSTEM_CODE)['ID']); 
              if($where!='')$this->db->where($where);
              $this->db->update(INVOICES_TEMP, $data);
              $status = $this->db->affected_rows();   
              $this->db->trans_complete();
              return $status;
	}
        
         public function get_temp_invoice_item($order_id,$where=''){ 
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
         public function get_temp_invoice_item_user($where=''){ 
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
        
        function delete_temp_invoice_item($id='',$where='temp_invoice_status =0'){
                $this->db->trans_start(); 
//                $this->db->where('temp_invoice_status', 0);
                $this->db->where('user_id',$this->session->userdata(SYSTEM_CODE)['ID']);
                if($id!='') $this->db->where('id',$id);
                if($where!='') $this->db->where($where);
                $this->db->delete(INVOICES_TEMP); 
                $status = $this->db->affected_rows();    
                $this->db->trans_complete(); 
                
//                echo '<pre>';                print_r($status);die;
                return $status;	
	} 
        
        public function search_item_pric_check($data='', $where=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*');
            $this->db->select('ip.price_amount,ip.currency_code');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select category_name from '.ITEM_CAT.' where id = i.item_category_id)  as category_name');
            $this->db->from(ITEMS." i");  
            $this->db->join(ITEM_PRICES." ip", 'ip.item_id = i.id');  
            $this->db->where('i.deleted',0);
            $this->db->where('ip.item_price_type',2); //2 sales price
            $this->db->where('ip.sales_type_id',15); //15 retail price -- DROPDOWN ID
            $this->db->where('ip.status',1); 
            $this->db->where('ip.deleted',0); 
            if($where!='')$this->db->where($where);
            
            if(isset($data['item_cat_id']) && $data['item_cat_id']!='') $this->db->where('i.item_category_id',$data['item_cat_id']);
            if(isset($data['item_desc']) && $data['item_desc']!='') $this->db->like('i.item_name',$data['item_desc']);
            if(isset($data['item_code']) && $data['item_code']!='') $this->db->where('i.item_code',$data['item_code']);
              
            $result = $this->db->get()->result_array();  
//            echo '<pre>';            print_r($result); die;
//            echo $this->db->last_query(); die;
            return $result;
	}
        public function search_item_stock_check($data=''){  
            
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*'); 
            $this->db->select('SUM(is.units_available) as total_units'); 
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = i.item_uom_id)  as unit_abbreviation');
            $this->db->select('(select category_name from '.ITEM_CAT.' where id = i.item_category_id)  as category_name');
            $this->db->from(ITEMS." i");    
            $this->db->join(ITEM_STOCK." is",'is.item_id = i.id');    
            $this->db->where('i.deleted',0); 
            $this->db->group_by('is.item_id'); 
            
            if(isset($data['item_cat_id']) && $data['item_cat_id']!='') $this->db->where('i.item_category_id',$data['item_cat_id']);
            if(isset($data['item_desc']) && $data['item_desc']!='') $this->db->like('i.item_name',$data['item_desc']);
            if(isset($data['item_code']) && $data['item_code']!='') $this->db->where('i.item_code',$data['item_code']);
              
            $result = $this->db->get()->result_array();  
//            echo '<pre>';            print_r($result); die;
//            echo $this->db->last_query(); die;
            return $result;
	}

         public function get_creditnote($cn_no,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('SUM((cnd.units*cnd.unit_price)-(cnd.disc_tot_refund)) as cn_amount');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone');
            $this->db->from(CREDIT_NOTES.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.person_id'); 
            $this->db->join(CREDIT_NOTES_DESC.' cnd','cnd.cn_id = i.id'); 
            $this->db->where('i.cn_no',$cn_no);
            $this->db->where('i.payment_settled',0);
            $this->db->where('i.deleted',0);  
            
            $this->db->group_by('i.id');  
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
                   
        function update_stock_reserve($data){
            
//                echo '<pre>';                print_r($data);
            if(!empty($data['item_stock'])){
                foreach ($data['item_stock'] as $item){
                    $this->db->where('item_id',$item['item_id']);
                    $this->db->where('location_id',$item['location_id']);
                    $this->db->update(ITEM_STOCK,array('units_on_reserve'=>$item['units_on_reserve'],'units_on_reserve_2'=>$item['units_on_reserve_2']));
                }
            }
        }
        
        //addons and cust type
        function get_customer_info($customer_id){
            $this->db->select('c.*');
            $this->db->select('ct.customer_type_name,ct.addons_included');
            $this->db->from(CUSTOMERS.' c');
            $this->db->join(CUSTOMER_TYPE.' ct','ct.id = c.customer_type_id');
            $this->db->where('c.id',$customer_id);
            $res = $this->db->get()->result_array();
             if(!empty($res))
                 return $res[0];
            return '';
        }
        function get_addon_info($addon_id){
            $cur_date = strtotime("now");
            $this->db->select('a.*'); 
            $this->db->from(ADDONS.' a'); 
            $this->db->where('a.id',$addon_id);
            $this->db->where('a.status',1);
            $this->db->where('a.active_from <',$cur_date);
            $this->db->where('(a.active_to > '.$cur_date.' OR a.active_to = 1)');
            $res = $this->db->get()->result_array();
             if(!empty($res))
                 return $res[0];
            return '';
        }
        
        function get_invoice_addons($invoice_id){
            $this->db->select('ia.*');
            $this->db->from(INVOICES_ADDONS.' ia');
            $this->db->where('invoice_id',$invoice_id);
            $res = $this->db->get()->result_array();
            return $res;
        }
        
        public function get_item_standard_prices($item_id,$where=''){ 
            $this->db->select('ip.*');  
            $this->db->from(ITEM_PRICES." ip");    
            $this->db->where('ip.item_id',$item_id);
            $this->db->where('ip.deleted',0);
            $this->db->where('ip.status',1);
            $this->db->where('ip.item_price_type',3); //3 for standard price
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
            return $result;
	}
}
?>