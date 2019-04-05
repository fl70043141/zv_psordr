<?php 

class Gems_receival_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	} 
        
        public function search_issued_items($data,$where='',$limit=''){
//            echo '<pre>';            print_r($data); die;
            $this->db->select("gir.record_type,gir.progress_stats,gir.gem_issue_id,gi.gem_issue_no,gi.issue_date,gi.return_date");
            $this->db->select("is.*");
            $this->db->select("itm.item_code,itm.item_category_id,CONCAT(itm.item_name,'-',itm.item_code) as item_name, itm.length,itm.width,itm.height,itm.certification,itm.certification_no,itm.treatment,itm.origin");
            $this->db->select('gi.receiver_id, (select dropdown_value from '.DROPDOWN_LIST.' where id = gi.receiver_id)  as lapidarist_name');
            $this->db->select('gir.certification, (select dropdown_value from '.DROPDOWN_LIST.' where id = gir.certification)  as certification_val');
            $this->db->select('gir.treatment, (select dropdown_value from '.DROPDOWN_LIST.' where id = gir.treatment)  as treatment_val');
            $this->db->select('gir.origin, (select dropdown_value from '.DROPDOWN_LIST.' where id = gir.origin)  as origin_val');
            $this->db->select('gir.color, (select dropdown_value from '.DROPDOWN_LIST.' where id = gir.color)  as color_val');
            $this->db->select('gir.shape, (select dropdown_value from '.DROPDOWN_LIST.' where id = gir.shape)  as shape_val');
            $this->db->select('(select category_name from '.ITEM_CAT.' where id = itm.item_category_id)  as item_category_name');
            $this->db->select('(select location_name from '.INV_LOCATION.' where id = is.location_id)  as location_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id)  as uom_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id_2)  as uom_name_2');$this->db->select('si.supplier_invoice_no'); 
            $this->db->join(ITEMS.' itm','itm.id = is.item_id','left');
            $this->db->join(SUPPLIER_INVOICE_DESC.' sid','sid.item_id = itm.id','left');
            $this->db->join(SUPPLIER_INVOICE.' si','si.id = sid.supplier_invoice_id','left');
            $this->db->join(GEM_ISSUE_RECORDS.' gir','gir.item_id = itm.id','left');
            $this->db->join(GEM_ISSUES.' gi','gi.id = gir.gem_issue_id','left');
            $this->db->from(ITEM_STOCK.' is');     
            $this->db->where('is.units_on_workshop >',0); 
            $this->db->where('is.deleted',0);
            $this->db->where('is.status',1); 
            $this->db->where('gir.progress_stats',0); //stil on lapidary check
            $this->db->where('gir.record_type',10); //record for submission
            $this->db->where('itm.item_type_id !=',4);
            if($where!='') $this->db->where($where);
            if($limit!='') $this->db->limit($limit);
            
            if(isset($data['gem_issue_no']) && $data['gem_issue_no']!='') $this->db->like('gi.gem_issue_no',$data['gem_issue_no']);
            if(isset($data['item_code']) && $data['item_code']!='') $this->db->like('itm.item_code',$data['item_code']);
            if(isset($data['category_id']) && $data['category_id']!='') $this->db->where('itm.item_category_id',$data['category_id']);
            if(isset($data['weight_from']) && $data['weight_from']!='') $this->db->where('is.units_available >=',$data['weight_from']);
            if(isset($data['weight_to']) && $data['weight_to']!='') $this->db->where('is.units_available <=',$data['weight_to']);
            if(isset($data['supplier_id']) && $data['supplier_id']!='') $this->db->where('si.supplier_id', $data['supplier_id']);
            
            if(isset($data['gem_issue_type_id']) && $data['gem_issue_type_id']!='') {
                $lapidarist_txt = '';
                switch($data['gem_issue_type_id']){
                    case 1: $lapidarist_txt = 'gem_cutter_id'; break;
                    case 2: $lapidarist_txt = 'gem_lab_id'; break;
                    case 3: $lapidarist_txt = 'gem_heater_id'; break;
                    case 4: $lapidarist_txt = 'gem_cutter_id'; break;
                    case 5: $lapidarist_txt = 'gem_polishing_id'; break;
                    case 6: $lapidarist_txt = 'gem_cutter_id'; break;
                    case 7: $lapidarist_txt = 'gem_lab_id'; break;
                } 
                if($lapidarist_txt!='') $this->db->where('gi.receiver_id',$data[$lapidarist_txt]);
                $this->db->where('gi.gem_issue_type_id',$data['gem_issue_type_id']);
            
        }
            
            $result = $this->db->get()->result_array();  
//            echo $this->db->last_query(); die;
//            echo '<pre>';            print_r($result); die;
            return $result;
	}
         public function search_result($data=''){
//            echo '<pre>';            print_r($data); die;
                $this->db->select('gir.item_id,itm.item_code');
                $this->db->select('gr.*');
                $this->db->select('(select gem_issue_type_name from '.GEM_ISSUE_TYPES.' where id = gr.gem_issue_type_id) as gem_issue_type_name');
                $this->db->select('(select dropdown_value from '.DROPDOWN_LIST.' where id = gr.lapidary_id) as lapidarist_name');
                $this->db->select('(select location_name from '.INV_LOCATION.' where id = gr.receiving_location_id) as location_name');
                $this->db->from(GEM_ISSUE_RECORDS.' gir');  
                $this->db->join(GEM_RECEIVAL.' gr','gr.id = gir.gem_receive_id');  
                $this->db->join(ITEMS.' itm','itm.id = gir.item_id');  
                
                $this->db->where('gr.deleted',0); 
                if(isset($data['gem_receival_no']) && $data['gem_receival_no']!='') $this->db->like('gr.gem_receival_no',$data['gem_receival_no']);
                if(isset($data['gem_issue_type_id']) && $data['gem_issue_type_id']!='') $this->db->where('gr.gem_issue_type_id',$data['gem_issue_type_id']);
                if(isset($data['location_id']) && $data['location_id']!='') $this->db->where('gr.receiving_location_id',$data['location_id']);
                if(isset($data['cutter_id']) && $data['cutter_id']!='') $this->db->where('gr.lapidary_id',$data['cutter_id']);
                if(isset($data['pollishing_id']) && $data['pollishing_id']!='') $this->db->where('gr.lapidary_id',$data['pollishing_id']);
                if(isset($data['lab_id']) && $data['lab_id']!='') $this->db->where('gr.lapidary_id',$data['lab_id']);
                if(isset($data['heater_id']) && $data['heater_id']!='') $this->db->where('gr.lapidary_id',$data['heater_id']);
                if(isset($data['received_date']) && $data['received_date']!='') $this->db->where('gr.receive_date',$data['received_date']); 
                if(isset($data['item_code']) && $data['item_code']!='') $this->db->like('itm.item_code',$data['item_code']);
                
                $this->db->group_by('gr.id');  
                $this->db->where('gir.record_type',20);
                $result = $this->db->get()->result_array();
//                echo $this->db->last_query();die;
//                echo '<pre>';            print_r($result); die;
                return $result;
         }
        public function add_db($data){    
                $this->db->trans_start();
                
//            echo '<pre>';            print_r($data); die; 
		if(!empty($data['gmr_tbl']))$this->db->insert(GEM_RECEIVAL, $data['gmr_tbl']);  
		if(!empty($data['gmr_records']))$this->db->insert_batch(GEM_ISSUE_RECORDS, $data['gmr_records']);   
                if(!empty($data['item_stock_transection']))$this->db->insert_batch(ITEM_STOCK_TRANS, $data['item_stock_transection']);   
                
                if(!empty($data['gmr_records'])){
                    foreach ($data['gmr_records'] as $gmr_rc){
                        $this->db->where('gem_issue_id',$gmr_rc['gem_issue_id']);
                        $this->db->where('item_id',$gmr_rc['item_id']);
                        $this->db->update(GEM_ISSUE_RECORDS,array('progress_stats'=>1));
                         
                        
                        //update item_table
                        $item_update_arr = array(  
                                                'certification' => $gmr_rc['certification'],
                                                'certification_no' => $gmr_rc['certification_no'],
                                                'color' => $gmr_rc['color'],
                                                'treatment' => $gmr_rc['treatment'], 
                                                'shape' => $gmr_rc['shape'], 
                                                'origin' => $gmr_rc['origin'], 
                                                'length' => $gmr_rc['length'],
                                                'width' => $gmr_rc['width'],
                                                'height' => $gmr_rc['height'],
                                            );
                        $this->db->where('id',$gmr_rc['item_id']);
                        $this->db->update(ITEMS,$item_update_arr);
                    }
                }
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){ 
                        $update_arr = array(
                                            'units_available'=>$stock['new_units_available'],
                                            'units_available_2'=>$stock['new_units_available_2'],
                                            'workshop_stats'=>$stock['workshop_stats'],
                                            'units_on_workshop'=>0,
                                            'units_on_workshop_2'=>0,
                                            'units_vanished'=>$stock['units_on_workshop'],//wastage
                                            'units_vanished_2'=>$stock['units_on_workshop_2'],//wastage
                                            );
                        
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK, $update_arr);
                    }
                }
                
		if(!empty($data['lpd_costs']))$this->db->insert_batch(GEM_LAPIDARY_COSTING, $data['lpd_costs']);
		if(!empty($data['gl_trans']))$this->db->insert_batch(GL_TRANS, $data['gl_trans']);
                
		$status[0]=$this->db->trans_complete();
		$status[1]=$data['cms_tbl']['id']; 
		return $status;
	} 
         
        
        public function delete_db($id,$data){
//                            echo '<pre>';            print_r( $data); die;
		$this->db->trans_start();
                
		$this->db->where('id', $id);
                $this->db->where('deleted',0);
		$this->db->update(GEM_RECEIVAL, $data['del_arr']); 
                
                //update so desc table
                $this->db->where('record_type', 20);// 10 for Genm issue  
                $this->db->where('gem_receive_id', $id);  
                $this->db->update(GEM_ISSUE_RECORDS,array('status'=>0,'deleted'=>1)); 
                
                //update so stock tran
                $this->db->where('transection_type', 65); // 65 for gem receive  
                $this->db->where('trans_ref', $id); // gem isse id 
                $this->db->update(ITEM_STOCK_TRANS,$data['del_arr']); 
                
                if(!empty($data['item_stock'])){
                    foreach ($data['item_stock'] as $stock){ 
                        $update_arr = array(
                                            'units_available'=>$stock['new_units_available'],
                                            'units_available_2'=>$stock['new_units_available_2'],
                                            'workshop_stats'=>$stock['workshop_stats'], //gem issuetype id
                                            'units_on_workshop'=>$data['gi_stock_trans'][$stock['item_id']]['units'],
                                            'units_on_workshop_2'=>$data['gi_stock_trans'][$stock['item_id']]['units_2'],
                                            'units_vanished'=>$stock['units_vanished']+ $stock['units_on_workshop'] - $data['gi_stock_trans'][$stock['item_id']]['units']  ,
                                            'units_vanished_2'=>$stock['units_vanished_2']  + $stock['units_on_workshop_2'] - $data['gi_stock_trans'][$stock['item_id']]['units_2'],
                                            );
                        
//                            echo '<pre>';            print_r($data['gi_stock_trans'][$stock['item_id']]['trans_ref']); die;
                        $this->db->where('location_id', $stock['location_id']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(ITEM_STOCK,$update_arr);
                        
                        
                        $this->db->where('gem_issue_id', $data['gi_stock_trans'][$stock['item_id']]['trans_ref']);
                        $this->db->where('item_id', $stock['item_id']);
                        $this->db->update(GEM_ISSUE_RECORDS, array('progress_stats'=>0));
                    }
                }
                
                foreach ($data['gem_rec_info'] as $gir_info){
                    //update item_table
                    $item_update_arr = array(  
                                            'certification' => $gir_info['gem_issue_info']['certification'],
                                            'certification_no' => $gir_info['gem_issue_info']['certification_no'],
                                            'color' => $gir_info['gem_issue_info']['color'],
                                            'treatment' => $gir_info['gem_issue_info']['treatment'], 
                                            'shape' => $gir_info['gem_issue_info']['shape'], 
                                            'origin' => $gir_info['gem_issue_info']['origin'], 
                                            'length' => $gir_info['gem_issue_info']['length'],
                                            'width' => $gir_info['gem_issue_info']['width'],
                                            'height' => $gir_info['gem_issue_info']['height'],
                                        );
                    $this->db->where('id',$gir_info['gem_issue_info']['item_id']);
                    $this->db->update(ITEMS,$item_update_arr);
                }
                
                
                //update lapidary costing  
                $this->db->where('gem_receival_id', $id);  
                $this->db->update(GEM_LAPIDARY_COSTING,array('status'=>0,'deleted'=>1)); 
                
                $this->db->where('person_type', 50);
                $this->db->where('trans_ref', $id);
                $this->db->update(GL_TRANS, $data['del_arr']);
                
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
            $this->db->select('gr.*');
            $this->db->select('(select gem_issue_type_name from '.GEM_ISSUE_TYPES.' where id = gr.gem_issue_type_id) as gem_issue_type_name');
            $this->db->select('(select dropdown_value from '.DROPDOWN_LIST.' where id = gr.lapidary_id) as lapidarist_name');
            $this->db->select('(select location_name from '.INV_LOCATION.' where id = gr.receiving_location_id) as location_name');
            $this->db->from(GEM_RECEIVAL.' gr');  
            $this->db->where('gr.deleted',0);  
            $this->db->where('gr.id',$id); 
            $this->db->group_by('gr.id');
            $result = $this->db->get()->result_array(); 
            return $result[0];
	}
        
         public function get_gem_receival_desc($id,$where=''){
            $this->db->select('gir.*');
            $this->db->select('gi.gem_issue_no,gi.issue_date,gi.receiver_id');
            $this->db->select('glc.amount_cost,glc.currency_code,glc.currency_value');
            $this->db->select('itm.item_code,itm.item_name');
            $this->db->select('(select category_name from  '.ITEM_CAT.' where id = gir.item_category_id) as category_name');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gi.receiver_id) as gi_lapidarist_name');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.certification) as certification_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.color) as color_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.treatment) as treatment_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.shape) as shape_val');
            $this->db->select('(select dropdown_value from  '.DROPDOWN_LIST.' where id = gir.origin) as origin_val');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = gir.uom_id)  as unit_abbr');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = gir.uom_id_2)  as unit_abbr_2');
            $this->db->from(GEM_ISSUE_RECORDS.' gir');
            $this->db->join(ITEMS.' itm','itm.id = gir.item_id');
            $this->db->join(GEM_ISSUES.' gi','gi.id = gir.gem_issue_id');
            $this->db->join(GEM_LAPIDARY_COSTING.' glc','glc.gem_receival_id = gir.gem_receive_id and glc.item_id = gir.item_id');
            $this->db->where('gir.record_type',20); //20 for gem receival 
            $this->db->where('gir.deleted',0); 
            $this->db->where('gir.gem_receive_id',$id); 
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//            echo '<pre>';        print_r($result);die;
            return $result;
	}   
        
         public function get_gem_issue_for_receival_item($gi_id,$item_id,$where=''){
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
            $this->db->where('gir.record_type',10); //20 for gem issue 
            $this->db->where('gir.progress_stats',1); //1 for gem issue 
            $this->db->where('gir.deleted',0); 
            $this->db->where('gir.gem_issue_id',$gi_id); 
            $this->db->where('gir.item_id',$item_id); 
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//            echo '<pre>';        print_r($result);die;
            return $result[0];
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