<?php 

class Order_receivals_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
        
        
       
        public function search_so_submission_for_receive($data='',$where=''){
//            echo '<pre>';            print_r($data); die;   
            $this->db->select("sod.*"); 
            $this->db->select("cmn.craftman_name, csub.cm_submission_no"); 
            $this->db->select("so.order_date,so.sales_order_no,so.customer_id,so.price_type_id,so.currency_code,so.currency_value,so.order_date,so.required_date"); 
            $this->db->select("itm.item_code,itm.item_category_id");  
            $this->db->select("(select category_name from ".ITEM_CAT." where id=itm.item_category_id) as item_cat_name"); 
//           
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sod.unit_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sod.secondary_unit_uom_id)  as unit_abbreviation_2');
            
            $this->db->from(SALES_ORDER_DESC." sod"); 
            $this->db->join(SALES_ORDERS." so",'so.id = sod.sales_order_id'); 
            $this->db->join(ITEMS." itm",'itm.id = sod.item_id'); //ref item catelog
            $this->db->join(CRAFTMANS_SUBMISSION." csub",'csub.id = sod.so_craftman_submission_id'); //ref craftman Submission
            $this->db->join(CRAFTMANS." cmn",'cmn.id = csub.craftman_id'); //ref craftman 
            $this->db->where("sod.craftman_status",1); // 1: send to craftman
            
            if(isset($data['craftman_id']) && $data['craftman_id']!='') $this->db->where('csub.craftman_id',$data['craftman_id']);
            if(isset($data['so_no']) && $data['so_no']!='') $this->db->where('so.sales_order_no',$data['so_no']);
            if(isset($data['submission_no']) && $data['submission_no']!='') $this->db->where('csub.cm_submission_no',$data['submission_no']);
            if(isset($data['required_date']) && $data['required_date']!='') $this->db->where('csub.return_date',$data['required_date']);
             
            $this->db->order_by('csub.return_date','asc');
            
            
            $result = $this->db->get()->result_array();
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
            
        }
         public function search_result($data=''){
             
//            echo '<pre>';            print_r($data); die;
                $this->db->select('cr.*');
                $this->db->select('count(cd.id) as total_items,sum(cd.units) as total_units,sum(cd.units_2) as total_units_2');
                $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = cd.uom_id)  as unit_abbreviation');
                $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = cd.uom_id_2)  as unit_abbreviation_2');
                $this->db->from(CRAFTMANS_RECEIVE.' cr');  
                $this->db->join(CRAFTMANS_RECEIVE_DESC.' cd','cd.cmr_no = cr.cm_receival_no');  
                $this->db->join(SALES_ORDERS.' so','so.id = cd.order_id');  
                $this->db->where('cr.deleted',0); 
                if(isset($data['receival_no']) && $data['receival_no']!='') $this->db->like('cr.cm_receival_no',$data['receival_no']);
                if(isset($data['received_date']) && $data['received_date']!='') $this->db->where('cr.receival_date',$data['received_date']);
                if(isset($data['order_no']) && $data['order_no']!='') $this->db->like('so.sales_order_no',$data['order_no']);
                $this->db->group_by('cr.id');
                $this->db->order_by('cr.id','desc');
                $result = $this->db->get()->result_array();   
                return $result;
         }
        public function add_db($data){   
                $this->db->trans_start();
                
		if(!empty($data['cmr_tbl']))$this->db->insert(CRAFTMANS_RECEIVE, $data['cmr_tbl']); 
		if(!empty($data['cmr_tbl_desc']))$this->db->insert_batch(CRAFTMANS_RECEIVE_DESC, $data['cmr_tbl_desc']); 
                  
                if(!empty($data['so_desc'])){
                    foreach ($data['so_desc'] as $so_item){
                        $this->db->where('id', $so_item['so_desc_id']); 
                        unset($so_item['so_desc_id']);
                        $this->db->update(SALES_ORDER_DESC,$so_item);
                    }
                }  
                
		if(!empty($data['items']))$this->db->insert_batch(ITEMS, $data['items']);  
		if(!empty($data['item_prices_purch']))$this->db->insert_batch(ITEM_PRICES, $data['item_prices_purch']);  
		if(!empty($data['item_prices_sale']))$this->db->insert_batch(ITEM_PRICES, $data['item_prices_sale']);  
		if(!empty($data['item_prices_standard']))$this->db->insert_batch(ITEM_PRICES, $data['item_prices_standard']);  
                
                if(!empty($data['purch_inv_tbl']))$this->db->insert(SUPPLIER_INVOICE, $data['purch_inv_tbl']);  
		if(!empty($data['purch_inv_desc']))$this->db->insert_batch(SUPPLIER_INVOICE_DESC, $data['purch_inv_desc']);   
		if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }
                
		if(!empty($data['payment_transection']))$this->db->insert(TRANSECTION, $data['payment_transection']);  
		if(!empty($data['payment_transection_ref']))$this->db->insert(TRANSECTION_REF, $data['payment_transection_ref']);  
		
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']); 
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['cmr_tbl']['id']; 
		return $status;
	} 
        
        public function edit_db($id,$data){
//            echo '<pre>'; print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(CRAFTMANS_SUBMISSION, $data['so_sub_tbl']);
                if(!empty($data['so_desc'])){
                    
                    $this->db->where('so_craftman_submission_id', $id);  
                    $this->db->update(SALES_ORDER_DESC,array('so_craftman_submission_id'=>0,'craftman_status'=>0)); 
                    
                    foreach ($data['so_desc'] as $so_item){ 
                        $this->db->where('id', $so_item['so_desc_id']); 
                        unset($so_item['so_desc_id']);
                        $this->db->update(SALES_ORDER_DESC,$so_item);
                    }
                }   
		$status=$this->db->trans_complete();
		return $status;
	}
        public function delete_db($id,$data){
//            echo '<pre>'; print_r($id); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(CRAFTMANS_SUBMISSION, $data); 
                
                //update so desc table
                $this->db->where('so_craftman_submission_id', $id);  
                $this->db->update(SALES_ORDER_DESC,array('so_craftman_submission_id'=>0,'craftman_status'=>0)); 
                    
		$status=$this->db->trans_complete();
		return $status;
	}
        function delete_db2($id){
                $this->db->trans_start();
                $this->db->delete(VEHICLE_RATES, array('id' => $id));     
                $status = $this->db->trans_complete();
                return $status;	
	} 
        
        public function get_stock($location_id,$item_id='',$where=''){
            $this->db->select('*');
            $this->db->from(ITEM_STOCK); 
            if($location_id!='')$this->db->where('location_id',$location_id);
            if($item_id!='')$this->db->where('item_id',$item_id);
            if($where!='')$this->db->where($where);
            $this->db->where('deleted',0);
            $result = $this->db->get()->result_array();  
            
            return $result;
	}
        
         
	
         public function get_single_row($id,$where=''){
            $this->db->select('cr.*');
            $this->db->select('count(cd.id) as total_items,sum(cd.units) as total_units,sum(cd.units_2) as total_units_2');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = cd.uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = cd.uom_id_2)  as unit_abbreviation_2');
            $this->db->from(CRAFTMANS_RECEIVE.' cr');  
            $this->db->join(CRAFTMANS_RECEIVE_DESC.' cd','cd.cmr_no = cr.cm_receival_no');  
            $this->db->where('cr.deleted',0);  
            $this->db->where('cr.id',$id);  
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die; 
            return $result[0];
	}
         public function get_single_row_cn_no($cn_no,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.customer_name,c.address,c.city,c.phone');
            $this->db->from(CREDIT_NOTES.' i'); 
            $this->db->join(CUSTOMERS.' c','c.id = i.person_id'); 
//            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id'); 
            $this->db->where('i.cn_no',$cn_no);
            $this->db->where('i.deleted',0);
            $this->db->where('i.invoice_type',10); //Sales invoice
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}               
        
        
        
         public function get_ret_desc($id){
            $this->db->select('crd.*, (crd.purch_unit_price*crd.units) as sub_total_purch, (crd.sale_unit_price*crd.units) as sub_total_sale');
            $this->db->select('sod.so_craftman_submission_id,sod.units as so_units, sod.unit_price as so_unit_price,sod.secondary_unit as so_units_2, cms.cm_submission_no');
            $this->db->select('itm.item_code');
            $this->db->select('(select item_code from '.ITEMS.' where id = crd.order_item_id) as order_item_code');
            $this->db->select('(select ic.category_name from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = crd.item_id) as category_name');
            $this->db->select('(select sales_order_no from '.SALES_ORDERS.' where id = crd.order_id)  as order_no');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = crd.uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = crd.uom_id_2)  as unit_abbreviation_2');
            $this->db->join(ITEMS.' itm','itm.id = crd.item_id'); 
            $this->db->join(SALES_ORDER_DESC.' sod','sod.id = crd.order_desc_id'); 
            $this->db->join(CRAFTMANS_SUBMISSION.' cms','cms.id = sod.so_craftman_submission_id'); 
            $this->db->join(CRAFTMANS_RECEIVE.' cr','cr.cm_receival_no = crd.cmr_no');  
            $this->db->from(CRAFTMANS_RECEIVE_DESC.' crd'); 
            $this->db->where('cr.id',$id);
            $this->db->where('cr.deleted',0);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
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
         
        
 
}
?>