<?php 

class Dashboard_model extends CI_Model
{
	function __construct(){	
            parent::__construct(); 
 	}
        
         public function get_tbl_couts($table_name,$where=''){ 
            $this->db->select('*');
            $this->db->from($table_name); 
            $this->db->where('status',1);
            $this->db->where('deleted',0);
            if($where!='')$this->db->where($where);
            $result = $this->db->get()->result_array();  
            return count($result);
	}
         public function get_number_inv($tbl,$start='',$end='',$where=''){ 
            $this->db->select('id');
            $this->db->from($tbl); 
            $this->db->where('deleted',0);
            if(isset($start) && $start!='')$this->db->where('added_on >=', $start);
            if(isset($end) && $end!='')$this->db->where('added_on <=', $end);
            if(isset($where) && $where!='')$this->db->where($where);
            $result = $this->db->get()->result_array(); 
            return count($result);
	}
        public function get_available_items($where='',$limit='',$res=''){
//            echo '<pre>';            print_r($limit); die;
            $this->db->select("sum(is.units_available + is.units_on_consignee + is.units_on_workshop) as sum_unit_1");
            $this->db->select("sum(is.units_available_2 + is.units_on_consignee_2 + is.units_on_workshop_2) as sum_unit_2");
            $this->db->select("is.*,itm.item_code,itm.item_category_id,CONCAT(itm.item_name,'-',itm.item_code) as item_name");
            $this->db->select('(select category_name from '.ITEM_CAT.' where id = itm.item_category_id)  as item_category_name');
            $this->db->select('(select location_name from '.INV_LOCATION.' where id = is.location_id)  as location_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id)  as uom_name');
            $this->db->select('(select unit_abbreviation from '.ITEM_UOM.' where id = is.uom_id_2)  as uom_name_2');
            $this->db->join(ITEMS.' itm','itm.id = is.item_id','left');
            $this->db->from(ITEM_STOCK.' is');     
//            $this->db->where('is.units_available >',0);
            $this->db->where('is.units_available > 0 OR is.units_on_consignee>0 OR is.units_on_workshop>0');
//            $this->db->where('is.units_available > is.units_on_reserve');
            $this->db->where('is.deleted',0);
            $this->db->where('is.status',1);
            $this->db->where('itm.sales_excluded',0);
            $this->db->where('itm.item_type_id !=',4);
            $this->db->group_by('itm.id');
            if($where!='') $this->db->where($where);
            if($limit!='') $this->db->limit($limit);
            $result = $this->db->get()->result_array(); 
//            echo '<pre>';        print_r($result); die; 
//            echo $this->db->last_query(); die; 
            if($res==1){
                return $result;
            }else{
                return count($result);
            }
	}
        
        public function get_ledger_info($data,$where=''){
            $def_curcode = $this->session->userdata(SYSTEM_CODE)['default_currency'];
            $cur_det = get_currency_for_code($def_curcode);

            $this->db->select('"'.$cur_det['symbol_left'].'" as cur_left_symbol, "'.$cur_det['symbol_right'].'" as cur_right_symbol'); 
            $this->db->select('sum(gt.amount*('.$cur_det['value'].'/gt.currency_value)) as glcm_tot_amount'); 
            $this->db->select('gt.*,(gt.amount*('.$cur_det['value'].'/gt.currency_value)) as amount_defcur'); 
            $this->db->select('glcm.account_name as glcm_account_name, glcm.account_code as glcm_code,glcm.id as glcm_id,glcm.account_type_id');  
            $this->db->select('gct.id as gct_id,gct.type_name,gct.class_id,gcc.class_name');  
            $this->db->from(GL_TRANS.' gt'); 
            $this->db->join(GL_CHART_MASTER.' glcm','glcm.account_code = gt.account_code'); 
            $this->db->join(GL_CHART_TYPE.' gct','gct.id= glcm.account_type_id'); 
            $this->db->join(GL_CHART_CLASS.' gcc','gcc.id= gct.class_id'); 

            if(isset($data['from_date']) && $data['from_date']!='') $this->db->where("gt.trans_date>= ",$data['from_date']);
            if(isset($data['to_date']) && $data['to_date']!='') $this->db->where("gt.trans_date<= ",$data['to_date']); 
            if($where!='')$this->db->where($where);
            $this->db->where('gt.deleted',0);
            $this->db->group_by('glcm.id');
            $result = $this->db->get()->result_array();   
    //echo $this->db->last_query(); die;

//            echo '<pre>';        print_r($result); die;
            return $result;
        }
        
        function get_sales_amount($data, $where=''){ 
            $def_curcode = $this->session->userdata(SYSTEM_CODE)['default_currency'];
            $cur_det = get_currency_for_code($def_curcode);
            
            $this->db->select('i.*');
            $this->db->select('(sum(id.item_quantity * id.unit_price) * '.$cur_det['value'].'/i.currency_value) as inv_subtot');
            $this->db->select('"'.$cur_det['symbol_left'].'" as cur_left_symbol, "'.$cur_det['symbol_right'].'" as cur_right_symbol'); 
             $this->db->join(INVOICE_DESC.' id','id.invoice_id = i.id');
            $this->db->from(INVOICES.' i');
            $this->db->where('i.deleted',0);
            $this->db->group_by('i.id');
            
            if(isset($data['from_date']) && $data['from_date']!='') $this->db->where("i.invoice_date>= ",$data['from_date']);
            if(isset($data['to_date']) && $data['to_date']!='') $this->db->where("i.invoice_date<= ",$data['to_date']); 
               
            $result = $this->db->get()->result_array(); 
            
            return $result;
        }
        
        function get_purch_amount($data, $where=''){ 
            $def_curcode = $this->session->userdata(SYSTEM_CODE)['default_currency'];
            $cur_det = get_currency_for_code($def_curcode);
            
            $this->db->select('i.*');
            $this->db->select('(sum(id.purchasing_unit * id.purchasing_unit_price) * '.$cur_det['value'].'/i.currency_value) as inv_subtot');
            $this->db->select('"'.$cur_det['symbol_left'].'" as cur_left_symbol, "'.$cur_det['symbol_right'].'" as cur_right_symbol'); 
             $this->db->join(SUPPLIER_INVOICE_DESC.' id','id.supplier_invoice_id = i.id');
            $this->db->from(SUPPLIER_INVOICE.' i');
            $this->db->where('i.deleted',0);
            $this->db->group_by('i.id');
            
            if(isset($data['from_date']) && $data['from_date']!='') $this->db->where("i.invoice_date>= ",$data['from_date']);
            if(isset($data['to_date']) && $data['to_date']!='') $this->db->where("i.invoice_date<= ",$data['to_date']); 
            $result = $this->db->get()->result_array(); 
//            echo '<pre>';            print_r($result); die;
            return $result;
        }
        
        function get_expenses_amount($data, $where=''){ 
            $def_curcode = $this->session->userdata(SYSTEM_CODE)['default_currency'];
            $cur_det = get_currency_for_code($def_curcode);
            
//              echo '<pre>';            print_r($cur_det); die;
            $this->db->select('qa.*');
            $this->db->select('q.amount,q.entry_date,q.currency_value');
            $this->db->select('(sum(q.amount) * '.$cur_det['value'].'/q.currency_value) as expense_amount');
            $this->db->select('"'.$cur_det['symbol_left'].'" as cur_left_symbol, "'.$cur_det['symbol_right'].'" as cur_right_symbol'); 
             $this->db->join(GL_QUICK_ENTRY.' q','q.quick_entry_account_id = qa.id');
             $this->db->join(GL_CHART_MASTER.' cm','cm.account_code = qa.debit_gl_code AND (cm.account_type_id = 12 OR cm.account_type_id=13)'); //12: gen expense 13: :ab charges
            $this->db->from(GL_QUICK_ENTRY_ACC.' qa');
            $this->db->where('qa.deleted',0);
            $this->db->group_by('qa.id');
            
            if(isset($data['from_date']) && $data['from_date']!='') $this->db->where("q.entry_date>= ",$data['from_date']);
            if(isset($data['to_date']) && $data['to_date']!='') $this->db->where("q.entry_date<= ",$data['to_date']); 
               
            $result = $this->db->get()->result_array(); 
            
            return $result;
        }
        
        function get_sales_profit(){
            $fiscyear_info = get_single_row_helper(GL_FISCAL_YEARS,'id = '.$this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id']);
            
            $def_curcode = $this->session->userdata(SYSTEM_CODE)['default_currency'];
            $cur_det = get_currency_for_code($def_curcode);
            
            $this->db->select('id.*');
            $this->db->select('"'.$cur_det['symbol_left'].'" as cur_left_symbol, "'.$cur_det['symbol_right'].'" as cur_right_symbol'); 
            $this->db->select('sum((id.unit_price * '.$cur_det['value'].'/i.currency_value) * id.item_quantity) as item_sale_amount');
            $this->db->select('(SELECT sum(amount_cost * '.$cur_det['value'].'/currency_value) from '.GEM_LAPIDARY_COSTING.' where item_id = id.item_id AND deleted=0) as total_lapidary_cost'); 
            $this->db->select('ip.item_price_type, ((ip.price_amount * '.$cur_det['value'].'/ip.currency_value) * id.item_quantity) as purch_standard_cost,ip.currency_code as ip_curr_code, ip.currency_value as ip_curr_value'); 
            $this->db->join(ITEM_PRICES.' ip','ip.item_id = id.item_id and ip.item_price_type = 3 and ip.deleted=0'); //3 standard cost 
            $this->db->join(INVOICES.' i', 'i.id = id.invoice_id');
            $this->db->from(INVOICE_DESC.' id');
            $this->db->where('i.invoice_date >= ',$fiscyear_info['begin']);
            $this->db->where('i.invoice_date <= ',$fiscyear_info['end']);
            $this->db->where('id.deleted',0);
            $this->db->group_by('id.item_id'); 
            $result = $this->db->get()->result_array();  
            
            return $result;
        }
 
}
?>