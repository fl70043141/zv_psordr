<?php 

class Consignee_submission_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
	 
        public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.consignee_name,c.address,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->from(CONSIGNEE_SUBMISSION.' i'); 
            $this->db->join(CONSIGNEES.' c','c.id = i.consignee_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id');  
            $this->db->where('i.deleted',0); 
            
            if(isset($data['cs_no'])) $this->db->like('i.cs_no',$data['cs_no']);
            if(isset($data['consignee_id']) && $data['consignee_id']!='') $this->db->where('i.consignee_id',$data['consignee_id']);
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
	
         public function get_single_row($id,$where=''){ 
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.consignee_name,c.address,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->from(CONSIGNEE_SUBMISSION.' i'); 
            $this->db->join(CONSIGNEES.' c','c.id = i.consignee_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payement_term_id');  
            $this->db->where('i.id',$id);
            $this->db->where('i.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}               
         public function get_invc_desc($id){ 
            $this->db->select('id.*, (id.unit_price*id.item_quantity*(100-id.discount_persent)*0.01) as sub_total');
            $this->db->select('(select ic.id from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = id.item_id) as item_category');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.item_quantity_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.item_quantity_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(CONSIGNEE_SUBMISSION_DESC.' id'); 
            $this->db->where('id.cs_id',$id);
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
         
                        
        public function add_db($data){    
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                
		if(!empty($data['inv_tbl']))$this->db->insert(CONSIGNEE_SUBMISSION, $data['inv_tbl']);  
		if(!empty($data['inv_desc']))$this->db->insert_batch(CONSIGNEE_SUBMISSION_DESC, $data['inv_desc']);   
		if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array(
                                                            'units_available'=>$stock['new_units_available'],
                                                            'units_available_2'=>$stock['new_units_available_2'],
                                                            'units_on_consignee'=>$stock['new_units_on_consignee'],
                                                            'units_on_consignee_2'=>$stock['new_units_on_consignee_2']
                                                            ));
                    }
                }
                 
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
		$this->db->update(CONSIGNEE_SUBMISSION, $data['tbl_data']);
		
                $this->db->where('cs_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(CONSIGNEE_SUBMISSION_DESC, array('deleted'=>1));
		
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_on_consignee'=>$stock['new_units_available'],'units_on_consignee_2'=>$stock['new_units_available_2']));
                    }
                }
                
                
                $this->db->where('trans_ref', $id); 
                $this->db->where('transection_type', 30); //30 trans type pf consignee submission
                $this->db->delete(ITEM_STOCK_TRANS); 
                
                
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