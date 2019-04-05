<?php 

class Consignee_receive_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
        
        
       
        public function search_consignee_submission($cs_no='',$from='',$to='',$consigee_id='',$location_id=''){
//            echo $location_id; die;
            $this->db->select("cs.cs_no,cs.submitted_date,cs.currency_code"); 
            $this->db->select("sd.id as sd_id,sd.item_id,sd.item_description,sd.item_quantity,sd.item_quantity_2,sd.item_quantity_uom_id,sd.item_quantity_uom_id_2,sd.unit_price,sd.discount_persent");
//            
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sd.item_quantity_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = sd.item_quantity_uom_id_2)  as unit_abbreviation_2');
//            
            $this->db->select('(select consignee_name from '.CONSIGNEES.' WHERE id = cs.consignee_id) as consignee_name');
            $this->db->select('(select item_code from '.ITEMS.' WHERE id = sd.item_id) as item_code');
            
            $this->db->from(CONSIGNEE_SUBMISSION_DESC." sd");
            $this->db->join(CONSIGNEE_SUBMISSION." cs","cs.id = sd.cs_id");
            $this->db->join(ITEM_STOCK." is","is.item_id = sd.item_id");
            
            
            if($consigee_id!='') $this->db->where('cs.consignee_id',$consigee_id);
            if($location_id!='') $this->db->where('is.location_id',$location_id);
            if($location_id!='') $this->db->where('is.units_on_consignee > 0');
            $this->db->where("cs.submitted_date >= '$from' AND cs.submitted_date <= '$to'");
            if($cs_no!='') $this->db->where('cs.cs_no',$cs_no); 
            
            
            $result = $this->db->get()->result_array();
//            echo $this->db->last_query();die;
//            echo '<pre>';            print_r($result); die;
            return $result;
            
        }
         public function search_result($data=''){ 
//            echo '<pre>';            print_r($data); die;
                $this->db->select('i.*');
                $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
                $this->db->select('c.consignee_name,c.address,pt.payment_term_name,pt.days_after');
                $this->db->from(CONSIGNEE_RECIEVE.' i'); 
                $this->db->join(CONSIGNEES.' c','c.id = i.consignee_id'); 
                $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payment_term_id'); 
                $this->db->where('i.deleted',0); 
                if(isset($data['cr_no'])) $this->db->like('i.cr_no',$data['cr_no']);
                if(isset($data['consignee_id']) && $data['consignee_id']!='') $this->db->where('i.consignee_id',$data['consignee_id']);

                $result = $this->db->get()->result_array();  
//                echo $this->db->last_query();die;
    //            echo '<pre>';            print_r($result); die;
                return $result;
         }
        public function add_db($data){    
//            echo '<pre>';            print_r($data); die; 
                $this->db->trans_start();
                
		if(!empty($data['cr_tbl']))$this->db->insert(CONSIGNEE_RECIEVE, $data['cr_tbl']);  
		if(!empty($data['cr_desc']))$this->db->insert_batch(CONSIGNEE_RECIEVE_DESC, $data['cr_desc']);   
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
		$status[1]=$data['cr_tbl']['id']; 
		return $status;
	} 
        
        public function delete_db($id,$data){ 
            
//            echo '<pre>';            print_r($data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(CREDIT_NOTES, $data['cn_tbl']);
		
                $this->db->where('cn_id', $id); 
                $this->db->where('deleted',0);
		$this->db->update(CREDIT_NOTES_DESC, array('deleted'=>1));
		
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, array('units_available'=>$stock['new_units_available'],'units_available_2'=>$stock['new_units_available_2']));
                    }
                }
                
                $this->db->where('trans_ref', $id); 
                $this->db->where('transection_type', 20); 
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
            $this->db->select('i.*');
            $this->db->select('(select concat(first_name," ",last_name) from '.USER.' where auth_id = i.added_by) as sales_person');
            $this->db->select('c.consignee_name,c.address,c.phone,pt.payment_term_name,pt.days_after');
            $this->db->from(CONSIGNEE_RECIEVE.' i'); 
            $this->db->join(CONSIGNEES.' c','c.id = i.consignee_id'); 
            $this->db->join(PAYMENT_TERMS.' pt','pt.id = i.payment_term_id');  
            $this->db->where('i.id',$id);
            $this->db->where('i.deleted',0);
            if($where!='') $this->db->where($where);
            $result = $this->db->get()->result_array();  
            return $result[0];
	}               
        
        
        public function get_invc_desc($id){ 
            $this->db->select('im.item_code,id.*, (id.unit_price*id.item_quantity*(100-id.discount_persent)*0.01) as sub_total');
            $this->db->select('(select ic.id from '.ITEM_CAT.' ic LEFT JOIN '.ITEMS.' itm ON itm.item_category_id = ic.id where itm.id = id.item_id) as item_category');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.item_quantity_uom_id)  as unit_abbreviation');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = id.item_quantity_uom_id_2)  as unit_abbreviation_2');
            $this->db->from(CONSIGNEE_RECIEVE_DESC.' id'); 
            $this->db->join(ITEMS.' im','im.id = id.item_id');
            $this->db->where('id.cr_id',$id);
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
         
        public function edit_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(VEHICLE_RATES, $data);
                        
		$status=$this->db->trans_complete();
		return $status;
	}
        
 
}
?>