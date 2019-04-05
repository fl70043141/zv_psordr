<?php 

class Order_submissions_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
        
        
       
        public function search_so_submission($data='',$where=''){
//            echo '<pre>';            print_r($data); die;  
//            echo 'assas'; die;
            $this->db->select("sod.*"); 
            $this->db->select("so.order_date,so.sales_order_no,so.customer_id,so.price_type_id,so.currency_code,so.currency_value,so.order_date,so.required_date"); 
            $this->db->select("itm.item_code");  
            $this->db->select("(select category_name from ".ITEM_CAT." where id=itm.item_category_id) as item_cat_name"); 
           
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sod.unit_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sod.secondary_unit_uom_id)  as unit_abbreviation_2');
            
            $this->db->from(SALES_ORDER_DESC." sod"); 
            $this->db->join(SALES_ORDERS." so",'so.id = sod.sales_order_id'); 
            $this->db->join(ITEMS." itm",'itm.id = sod.item_id'); //ref item catelog
            $this->db->where("sod.craftman_status",0); //not send to craftman
            
            if(isset($data['category_id']) && $data['category_id']!='') $this->db->where('itm.item_category_id',$data['category_id']);
            if(isset($data['so_no']) && $data['so_no']!='') $this->db->where('so.sales_order_no',$data['so_no']);
            
            if(isset($data['search_from']) && $data['search_from']!='') $this->db->where("so.required_date >= ".$data['search_from']);
            if(isset($data['search_to']) && $data['search_to']!='') $this->db->where("so.required_date <= ".$data['search_to']);
                    
            if(isset($data['search_from']) && $data['search_from']!='' && isset($data['search_to']) && $data['search_to']!=''){
                $this->db->where("so.required_date >= ".$data['search_from']." AND so.required_date <= ".$data['search_to']." ");
            }
            $this->db->order_by('so.required_date','asc');
            
            
            $result = $this->db->get()->result_array();
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
            
        }
         public function search_result($data=''){
                $this->db->select('cs.*');
                $this->db->select('c.craftman_name,c.craftman_short_name,c.phone');
                $this->db->from(CRAFTMANS_SUBMISSION.' cs');  
                $this->db->join(CRAFTMANS.' c','c.id = cs.craftman_id');  
                $this->db->join(SALES_ORDER_DESC.' sod','sod.so_craftman_submission_id = cs.id');  
                $this->db->join(SALES_ORDERS.' so','so.id= sod.sales_order_id');  
                $this->db->where('cs.deleted',0); 
                if(isset($data['submission_no']) && $data['submission_no']!='') $this->db->like('cs.cm_submission_no',$data['submission_no']);
                if(isset($data['order_no']) && $data['order_no']!='') $this->db->like('so.sales_order_no',$data['order_no']);
                if(isset($data['craftman_id']) && $data['craftman_id']!='') $this->db->where('cs.craftman_id',$data['craftman_id']);
                if(isset($data['submitted_date']) && $data['submitted_date']!='') $this->db->where('cs.submission_date',$data['submitted_date']);
                if(isset($data['return_date']) && $data['return_date']!='') $this->db->where('cs.return_date',$data['return_date']);
                
                $this->db->group_by('cs.id');
                $result = $this->db->get()->result_array();   
                return $result;
         }
        public function add_db($data){    
                $this->db->trans_start();
                
//            echo '<pre>';            print_r($data); die; 
		if(!empty($data['cms_tbl']))$this->db->insert(CRAFTMANS_SUBMISSION, $data['cms_tbl']);  
                if(!empty($data['so_desc'])){
                    foreach ($data['so_desc'] as $so_item){
                        $this->db->where('id', $so_item['so_desc_id']); 
                        unset($so_item['so_desc_id']);
                        $this->db->update(SALES_ORDER_DESC,$so_item);
                    }
                }  
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['cms_tbl']['id']; 
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
            $this->db->select('cs.*');
            $this->db->select('c.craftman_name,c.craftman_short_name,c.phone');
            $this->db->from(CRAFTMANS_SUBMISSION.' cs');  
            $this->db->join(CRAFTMANS.' c','c.id = cs.craftman_id');  
            $this->db->where('cs.deleted',0); 
            $this->db->like('cs.id',$id); 
            if($where!='') $this->db->where($where);
            
            $result = $this->db->get()->result_array();   
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
        
        
        
         public function get_sub_desc($id){
            $this->db->select('sod.*, (sod.unit_price*sod.units) as sub_total');
            $this->db->select('i.item_code');
            $this->db->select('(select ic.category_name from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = sod.item_id) as category_name');
            $this->db->select('(select sales_order_no from '.SALES_ORDERS.' where id = sod.sales_order_id)  as order_no');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sod.unit_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sod.secondary_unit_uom_id)  as unit_abbreviation_2');
            $this->db->join(ITEMS.' i','i.id = sod.item_id'); 
            $this->db->from(SALES_ORDER_DESC.' sod'); 
            $this->db->where('sod.so_craftman_submission_id',$id);
            $this->db->where('sod.deleted',0);
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