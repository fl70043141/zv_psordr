<?php 

class Gems_issue_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	} 
        
        public function search_available_items($data,$where='',$limit=''){
//            echo '<pre>';            print_r($data); die;
            $this->db->select("is.*");
            $this->db->select("itm.item_code,itm.item_category_id,CONCAT(itm.item_name,'-',itm.item_code) as item_name, itm.length,itm.width,itm.height,itm.certification,itm.certification_no,itm.treatment,itm.origin");
            $this->db->select('itm.color, (select dropdown_value from '.DROPDOWN_LIST.' where id = itm.color)  as color_val');
            $this->db->select('itm.shape, (select dropdown_value from '.DROPDOWN_LIST.' where id = itm.shape)  as shape_val');
            $this->db->select('(select category_name from '.ITEM_CAT.' where id = itm.item_category_id)  as item_category_name');
            $this->db->select('(select location_name from '.INV_LOCATION.' where id = is.location_id)  as location_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id)  as uom_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id_2)  as uom_name_2');
            $this->db->select('si.supplier_invoice_no'); 
            $this->db->join(ITEMS.' itm','itm.id = is.item_id','left');
            $this->db->join(SUPPLIER_INVOICE_DESC.' sid','sid.item_id = itm.id','left');
            $this->db->join(SUPPLIER_INVOICE.' si','si.id = sid.supplier_invoice_id','left');
            $this->db->from(ITEM_STOCK.' is');     
            $this->db->where('is.units_available >',0);
            $this->db->where('is.units_available > is.units_on_reserve');
            $this->db->where('is.deleted',0);
            $this->db->where('is.status',1);
            $this->db->where('itm.sales_excluded',0);
            $this->db->where('itm.item_type_id !=',4);
            if($where!='') $this->db->where($where);
            if($limit!='') $this->db->limit($limit);
            
            if(isset($data['item_code']) && $data['item_code']!='') $this->db->like('itm.item_code',$data['item_code']);
            if(isset($data['category_id']) && $data['category_id']!='') $this->db->where('itm.item_category_id',$data['category_id']);
            if(isset($data['weight_from']) && $data['weight_from']!='') $this->db->where('is.units_available >=',$data['weight_from']);
            if(isset($data['weight_to']) && $data['weight_to']!='') $this->db->where('is.units_available <=',$data['weight_to']);
            if(isset($data['supplier_id']) && $data['supplier_id']!='') $this->db->where('si.supplier_id', $data['supplier_id']);
                
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
         public function search_result($data=''){
//            echo '<pre>';            print_r($data); die;
                $this->db->select('gir.item_id,itm.item_code');
                $this->db->select('gi.*');
                $this->db->select('(select gem_issue_type_name from '.GEM_ISSUE_TYPES.' where id = gi.gem_issue_type_id) as gem_issue_type_name');
                $this->db->select('(select dropdown_value from '.DROPDOWN_LIST.' where id = gi.receiver_id) as lapidarist_name');
                $this->db->select('(select location_name from '.INV_LOCATION.' where id = gi.from_location_id) as location_name');
                $this->db->from(GEM_ISSUE_RECORDS.' gir');  
                $this->db->join(GEM_ISSUES.' gi','gi.id = gir.gem_issue_id');  
                $this->db->join(ITEMS.' itm','itm.id = gir.item_id');  
                $this->db->where('gi.deleted',0); 
                if(isset($data['gem_issue_no']) && $data['gem_issue_no']!='') $this->db->like('gi.gem_issue_no',$data['gem_issue_no']);
                if(isset($data['gem_issue_type_id']) && $data['gem_issue_type_id']!='') $this->db->where('gi.gem_issue_type_id',$data['gem_issue_type_id']);
                if(isset($data['location_id']) && $data['location_id']!='') $this->db->where('gi.location_id',$data['location_id']);
                if(isset($data['cutter_id']) && $data['cutter_id']!='') $this->db->where('gi.receiver_id',$data['cutter_id']);
                if(isset($data['pollishing_id']) && $data['pollishing_id']!='') $this->db->where('gi.receiver_id',$data['pollishing_id']);
                if(isset($data['lab_id']) && $data['lab_id']!='') $this->db->where('gi.receiver_id',$data['lab_id']);
                if(isset($data['heater_id']) && $data['heater_id']!='') $this->db->where('gi.receiver_id',$data['heater_id']);
                if(isset($data['submitted_date']) && $data['submitted_date']!='') $this->db->where('gi.issue_date',$data['submitted_date']);
                if(isset($data['return_date']) && $data['return_date']!='') $this->db->where('gi.return_date',$data['return_date']);
                if(isset($data['item_code']) && $data['item_code']!='') $this->db->like('itm.item_code',$data['item_code']);
                
                $this->db->group_by('gi.id');
                $this->db->where('gir.record_type',10);
                $result = $this->db->get()->result_array();
//                echo $this->db->last_query();die;
//                echo '<pre>';            print_r($data); die;
                return $result;
         }
        public function add_db($data){    
                $this->db->trans_start();
                
//            echo '<pre>';            print_r($data['item_stock']); die; 
		if(!empty($data['gmi_tbl']))$this->db->insert(GEM_ISSUES, $data['gmi_tbl']);  
		if(!empty($data['gmi_records']))$this->db->insert_batch(GEM_ISSUE_RECORDS, $data['gmi_records']);   
                if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){
                        $update_arr = array(
                                            'units_available'=>$stock['new_units_available'],
                                            'units_available_2'=>$stock['new_units_available_2'],
                                            'workshop_stats'=>$stock['workshop_stats'],
                                            'units_on_workshop'=>$stock['units_on_workshop'],
                                            'units_on_workshop_2'=>$stock['units_on_workshop_2'],
                                            );
                        
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, $update_arr);
                    }
                }
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['cms_tbl']['id']; 
		return $status;
	} 
         
        
        public function delete_db($id,$data){
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(GEM_ISSUES, $data['del_arr']); 
                
                //update so desc table
                $this->db->where('record_type', 10);// 10 for Genm issue  
                $this->db->where('gem_issue_id', $id);  
                $this->db->update(GEM_ISSUE_RECORDS,array('status'=>0,'deleted'=>1)); 
                
                //update so stock tran
                $this->db->where('transection_type', 60); // 60 for gem isssue  
                $this->db->where('trans_ref', $id); // gem isse id 
                $this->db->update(ITEM_STOCK_TRANS,$data['del_arr']); 
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){ 
                        $update_arr = array(
                                            'units_available'=>$stock['new_units_available'],
                                            'units_available_2'=>$stock['new_units_available_2'],
                                            'workshop_stats'=>$stock['workshop_stats'],
                                            'units_on_workshop'=>$stock['units_on_workshop'],
                                            'units_on_workshop_2'=>$stock['units_on_workshop_2'],
                                            );
                        
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, $update_arr);
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
            $this->db->select('gi.*');
            $this->db->select('(select gem_issue_type_name from '.GEM_ISSUE_TYPES.' where id = gi.gem_issue_type_id) as gem_issue_type_name');
            $this->db->select('(select dropdown_value from '.DROPDOWN_LIST.' where id = gi.receiver_id) as lapidarist_name');
            $this->db->select('(select location_name from '.INV_LOCATION.' where id = gi.from_location_id) as location_name');
            $this->db->from(GEM_ISSUES.' gi');  
            $this->db->where('gi.deleted',0); 
            $this->db->where('gi.id',$id); 
            $this->db->group_by('gi.id');
            $result = $this->db->get()->result_array(); 
            return $result[0];
	}            
         public function get_gem_issue_desc($id,$where=''){
            $this->db->select('gir.*');
            $this->db->select('itm.item_code,itm.item_name');
            $this->db->select('(select category_name from  '.ITEM_CAT.' where id = gir.item_category_id) as category_name');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.certification) as certification_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.color) as color_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.treatment) as treatment_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.shape) as shape_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.origin) as origin_val');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = gir.uom_id)  as unit_abbr');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = gir.uom_id_2)  as unit_abbr_2');
            $this->db->from(GEM_ISSUE_RECORDS.' gir');
            $this->db->join(ITEMS.' itm','itm.id = gir.item_id');
            $this->db->where('gir.record_type',10); //10 for gem issue 
            $this->db->where('gir.deleted',0); 
            $this->db->where('gir.gem_issue_id',$id); 
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//            echo '<pre>';        print_r($result);die;
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