<?php 

class Sales_orders_model extends CI_Model
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
            $this->db->where('i.invoiced',0);
            $this->db->where('i.deleted',0);
            if(isset($data['order_no'])) $this->db->like('i.sales_order_no',$data['order_no']);
            if(isset($data['customer_id']) && $data['customer_id']!='') $this->db->where('i.customer_id',$data['customer_id']);
            $this->db->order_by('i.id','desc');
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
            $this->db->where('i.invoiced',0);
            $this->db->where('i.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}               
         public function get_so_desc($id){ 
            $this->db->select('id.*, (id.unit_price*id.units*(100-id.discount_percent)*0.01) as sub_total');
            $this->db->select('im.item_code');
            $this->db->select('(select itmc.category_name from '.ITEM_CAT.' itmc where id = im.item_category_id) as item_cat_name');
            $this->db->select('(select item_code from '.ITEMS.' where id = cmrd.item_id) as new_itemcode');
            $this->db->select('(select inv.id from '.INVOICES.' inv LEFT JOIN '.INVOICE_DESC.' invd ON invd.invoice_id = inv.id where invd.item_id = id.new_item_id AND inv.so_id = id.sales_order_id group by inv.id) as invoice_id');
            $this->db->select('cms.cm_submission_no,cms.return_date');
            $this->db->select('cmrd.units as actual_units,cmrd.sale_unit_price, (cmrd.units*cmrd.sale_unit_price) as actual_sub_total');
            $this->db->select('(select ic.id from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = id.item_id) as item_category');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.unit_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.secondary_unit_uom_id)  as unit_abbreviation_2');
            $this->db->join(ITEMS.' im','im.id = id.item_id'); 
            $this->db->join(CRAFTMANS_SUBMISSION.' cms','cms.id = id.so_craftman_submission_id','left'); 
            $this->db->join(CRAFTMANS_RECEIVE_DESC.' cmrd','cmrd.order_desc_id = id.id','left'); 
//            $this->db->join(INVOICES.' inv','inv.so_id = id.sales_order_id','left'); 
            $this->db->from(SALES_ORDER_DESC.' id'); 
            $this->db->where('id.sales_order_id',$id);
            $this->db->where('id.deleted',0);
            $result = $this->db->get()->result_array();  
            return $result;
	}  
         public function get_og_for_so($id){ 
            $this->db->select('ogr.*,og.og_no, og.og_date');
            $this->db->select('sum(ogd.og_unit*ogd.og_unit_price) as og_amount');
            $this->db->from(OLD_GOLD_REF." ogr"); 
            $this->db->join(OLD_GOLD." og", 'og.id = ogr.og_id'); 
            $this->db->join(OLD_GOLD_DESC." ogd", 'ogd.og_id = og.id'); 
            $this->db->where('ogr.ref_type','11'); // sales order - 11
            $this->db->where('ogr.ref_id',$id);
            $this->db->where('ogr.deleted',0);
            $this->db->group_by('og.id');
            $result = $this->db->get()->result_array();  
            return $result;
	}  
          public function get_transections_so_invoice($order_id,$person_type=10,$where=''){ 
            $this->db->select('t.*,tr.reference_id,sum(t.transection_amount) as trans_amount'); 
            $this->db->select('pm.payment_method_name'); 
            $this->db->select('i.invoice_no'); 
            $this->db->from(TRANSECTION.' t');
            $this->db->join(TRANSECTION_REF.' tr','tr.transection_id = t.id','left');
            $this->db->join(PAYMENT_METHOD.' pm', 'pm.id = t.payment_method','left');
            $this->db->join(INVOICES.' i', 'i.id = tr.reference_id');
            $this->db->where('i.so_id',$order_id);
            $this->db->where('tr.person_type',$person_type);
            $this->db->where('t.person_type',$person_type);
            $this->db->where('t.deleted',0);
            $this->db->group_by('i.id');
//            $this->db->group_by('t.payment_method');
            if($where!='') $this->db->where($where); 
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;    
            return $result;
	}
        
         public function get_so_redeem_inv($person_type,$reference_id,$where=''){ 
            $this->db->select('tr.*'); 
            $this->db->select('(select invoice_no from '.INVOICES.' where id = t.redeemed_inv_id) as invoice_no '); 
            $this->db->select('(select payment_method_name from '.PAYMENT_METHOD.' where id = t.payment_method) as payment_method'); 
            $this->db->select('(select sum(transection_ref_amount) from '.TRANSECTION_REF.' where reference_id = tr.reference_id and person_type= '.$person_type.') as total_amount '); 
            $this->db->select('t.redeemed_inv_id,t.currency_code,t.trans_date,t.transection_amount'); 
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
        
        function delete_temp_so_item($reference){
                $this->db->trans_start();
//                $this->db->where('reference',$reference);
                $this->db->where('reference', $reference);
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
		 
		if(!empty($data['og_ref_tbl']))$this->db->insert_batch(OLD_GOLD_REF, $data['og_ref_tbl']); //OG Refs
                
                if(!empty($data['payment_transection']))$this->db->insert_batch(TRANSECTION, $data['payment_transection']);  
		if(!empty($data['payment_transection_ref']))$this->db->insert_batch(TRANSECTION_REF, $data['payment_transection_ref']);  
		
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
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
                
                //og_ref
                $this->db->where('ref_id', $id); 
                $this->db->where('ref_type', 11); //11 for sales order
                $this->db->where('deleted',0);
//		$this->db->update(SALES_ORDER_DESC, array('deleted'=>1));
                $this->db->delete(OLD_GOLD_REF);     
		if(!empty($data['og_ref_tbl']))$this->db->insert_batch(OLD_GOLD_REF, $data['og_ref_tbl']); //OG Refs
                
		$status=$this->db->trans_complete();
		return $status;
	}
        
        public function delete_db($id,$data){ 
		$this->db->trans_start();
                
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(SALES_ORDERS, $data);
		
                $this->db->where('sales_order_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(SALES_ORDER_DESC, array('deleted'=>1));
		
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