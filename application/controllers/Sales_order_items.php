<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_items extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Sales_order_items_model'); 
        }

        public function index(){
            $this->view_search();
//            $this->add_item_by_cat();
	}
        
        function view_search($datas=''){
//            $this->add();
            $this->load->model('Item_categories_model'); 
            $data['search_list'] = $this->Sales_order_items_model->search_result();
            $data['main_content']='sales_order_items/search_sales_orders'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id','Customer','customer_type_id = 1');
            $this->load->view('includes/template',$data);
	}
        function add_item_by_cat($order_id=0){
//            $this->add();
            $this->load->model('Item_categories_model'); 
            $data['search_list'] = $this->Sales_order_items_model->search_result();
//            $data['sales_order_det'] = $this->Sales_order_items_model->get_single_row($order_id);
            $data['order_id'] = $order_id;
            $data['main_content']='sales_order_items/add_sales_order_items'; 
            $data['category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','Categories');
//            echo '<pre>';            print_r($data);die;
            $this->load->view('includes/template',$data);
	}
//        
//        function view_search($datas=''){
////            $this->add();
//            $data['search_list'] = $this->Sales_order_items_model->search_result();
//            $data['main_content']='sales_order_items/search_sales_orders'; 
//            $data['supplier_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id','Suppliers');
//            $this->load->view('includes/template',$data);
//	}
        
	function add($temp_id=''){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='sales_order_items/manage_sales_orders';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='sales_order_items/manage_sales_orders'; 
            $data['inv_data'] = $this->get_salesorder_info($id);
//            echo '<pre>';            print_r($data);die;
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='sales_order_items/manage_sales_orders'; 
            $data['inv_data'] = $this->get_salesorder_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='sales_order_items/manage_sales_orders'; 
            $data['inv_data'] = $this->get_salesorder_info($id);
            $this->load->view('includes/template',$data);
	}
	
        
	function validate(){   
            $this->form_val_setrules(); 
            if($this->form_validation->run() == False){
                switch($this->input->post('action')){
                    case 'Add':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form'); 
                            $this->add();
                            break;
                    case 'Edit':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form');
                            $this->edit($this->input->post('id'));
                            break;
                    case 'Delete':
                            $this->delete($this->input->post('id'));
                            break;
                } 
            }
            else{
                switch($this->input->post('action')){
                    case 'Add':
                            $this->create();
                    break;
                    case 'Edit':
                        $this->update();
                    break;
                    case 'Delete':
                        $this->remove();
                    break;
                    case 'View':
                        $this->view();
                    break;
                }	
            }
	}
        
	function form_val_setrules(){
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('order_date','Invoice Date','required'); 
      }	
      function check_unique_vehicle(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(VEHICLE_RATES,'id','id','','vehicle_id = "'.$this->input->post('vehicle_id').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(VEHICLE_RATES,'id','id','','vehicle_id = "'.$this->input->post('vehicle_id').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_vehicle','Active Vehicle Rates alrady exists for this vehicle.');
                    return false;
                }
        }
        
	function create(){   
            
            $inputs = $this->input->post();
            $sale_order_id = get_autoincrement_no(SALES_ORDERS);
            $order_no = gen_id(SALE_ORDER_NO_PREFIX, SALES_ORDERS, 'id');
            
            $cur_det = $this->Sales_order_items_model->get_currency_for_code($inputs['currency_code']);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['so_tbl'] = array(
                                    'id' => $sale_order_id,
                                    'sales_order_no' => $order_no,
                                    'customer_id' => $inputs['customer_id'], 
                                    'customer_branch_id' => isset($inputs['customer_branch_id'])?$inputs['customer_branch_id']:'', 
                                    'price_type_id' => $inputs['price_type_id'],  
                                    'order_date' => strtotime($inputs['order_date']),  
                                    'required_date' => strtotime($inputs['required_date']),  
                                    'currency_code' => $inputs['currency_code'], 
                                    'currency_value' => $cur_det['value'], 
                                    'location_id' => $inputs['location_id'],
                                    'delivery_address' => $inputs['delivery_address'],
                                    'customer_phone' => $inputs['customer_phone'],
                                    'customer_reference' => $inputs['customer_reference'],
                                    'memo' => $inputs['memo'],
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            $data['so_desc'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection Saleorder
            
            foreach ($inputs['inv_items'] as $inv_item){
                $data['so_desc'][] = array(
                                            'sales_order_id' => $sale_order_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_desc' => $inv_item['item_desc'],
                                            'units' => $inv_item['item_quantity'],
                                            'unit_uom_id' => $inv_item['item_quantity_uom_id'],
                                            'secondary_unit' => $inv_item['item_quantity_2'],
                                            'secondary_unit_uom_id' => $inv_item['item_quantity_uom_id_2'],
                                            'unit_price' => $inv_item['item_unit_cost'],
//                                            'discount_percent' => $inputs['discount_percent'],
                                            'location_id' => $inputs['location_id'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>6, //6 for Sales Order transection
                                                            'trans_ref'=>$sale_order_id, 
                                                            'item_id'=>$inv_item['item_id'], 
                                                            'units'=>$inv_item['item_quantity'], 
                                                            'uom_id'=>$inv_item['item_quantity_uom_id'], 
                                                            'units_2'=>$inv_item['item_quantity_2'], 
                                                            'uom_id_2'=>$inv_item['item_quantity_uom_id_2'], 
                                                            'location_id'=>$inputs['location_id'], 
                                                            'status'=>1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                            );
                
                if($inv_item['item_quantity_uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2']);
                else
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity']);
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                
            }
            $data['og_ref_tbl']= array();
            if(isset($inputs['og'])){
                foreach ($inputs['og'] as $og_data){
                    $data['og_ref_tbl'][] = array(
                                                'og_id' => $og_data['og_id'],
                                                'ref_type' => 11,//11 for sales order
                                                'ref_id' => $sale_order_id,
                                                'status' => 1,
                                                'deleted' => 0,
                                                );
                }
                
            }
            
//            echo '<pre>';            print_r($data); die;
                    
		$add_stat = $this->Sales_order_items_model->add_db($data);
                
		if($add_stat[0]){ 
                    $this->load->model('Order_ecataog_modal');
                    $del_res = $this->Order_ecataog_modal->cancel_temp_opened_order();//remove temp opend order
//                    $del_res = $this->Sales_order_items_model->delete_temp_so_item($this->session->userdata(SYSTEM_CODE)['ID'].'_so_0');
                    //update log data
                    $new_data = $this->Sales_order_items_model->get_single_row($add_stat[1]);
                    add_system_log(SALES_ORDERS, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url('Sales_order_items/edit/'.$sale_order_id)); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0,$del=false){ //updatiuon for item_stock table
            $this->load->model('Item_stock_model');
//            echo '<pre>';            print_r($this->input->post()); die;
            $stock_det = $this->Item_stock_model->get_single_row('',"location_id = '$loc_id' and item_id = '$item_id'");
            $available_units= $available_units_2 = 0;
            $update_arr = array();
            if(empty($stock_det)){
                $insert_data = array(
                                        'location_id'=>$loc_id,
                                        'item_id'=>$item_id,
                                        'uom_id'=>$uom,
                                        'units_available'=>0,
                                        'units_on_order'=>0,
                                        'units_on_demand'=>0,
                                        );
                if($uom_2!=''){
                    $insert_data['units_available_2'] = 0;
                    $insert_data['uom_id_2'] = $uom_2;
                }
                $this->Item_stock_model->add_db($insert_data);
                $available_units = $units;
                $available_units_2 = $units_2;
                $units_on_demand = $units;
            }else{
                if(!$del){
    //                $stock_trans_det = $this->Item_stock_model->get_stock_transection($this->input->post('id'));
    //                echo '<pre>';            print_r($stock_trans_det); die;
                    $available_units = $stock_det['units_available'] - $units;
                    $available_units_2 = $stock_det['units_available_2'] - $units_2;
                    $units_on_demand = $stock_det['units_on_demand'] + $units;
                }else{//delete order
                    $available_units = $stock_det['units_available'] + $units;
                    $available_units_2 = $stock_det['units_available_2'] + $units_2;
                    $units_on_demand = $stock_det['units_on_demand'] - $units;
                }
            }
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_available'=>$available_units,'new_units_available_2'=>$available_units_2,'units_on_demand'=>$units_on_demand);
            return $update_arr;
        }
         function stock_status_updatecheck($order_no){ //updatiuon for item_stock table
            $this->load->model('Item_stock_model');
            $stock_trans_det = $this->Item_stock_model->get_stock_transection($order_no,'transection_type=6');
//            echo '<pre>';            print_r($stock_trans_det); die;
            $update_arr = array();
            $update_arr_stock = array(); 
            foreach ($stock_trans_det as $stock_trans){
                $update_arr[$stock_trans['id']] = array(
                                                        'units'=>$stock_trans['units'],
                                                        'uom_id'=>$stock_trans['uom_id'],
                                                        'location_id'=>$stock_trans['location_id'],
                                                        'trans_ref'=>$stock_trans['trans_ref'],
                                                        'deleted'=>1,
                                                        'deleted_by'=> $this->session->userdata(SYSTEM_CODE)['ID'],
                                                        );    
                
                $stock_det = $this->Item_stock_model->get_stock($stock_trans['location_id'],$stock_trans['item_id']);
                
                    $update_arr_stock[$stock_det[0]['id']] = array(
                                                            'units_on_demand'=>($stock_det[0]['units_on_demand'] - $stock_trans['units']),
                                                            'units_available'=>($stock_det[0]['units_available'] + $stock_trans['units']),
                                                            'item_id'=>$stock_det[0]['item_id'],
                                                            'location_id'=>$stock_det[0]['location_id'],
                                                        );     
            }
            $data['updt_itm_trans_table'] = $update_arr;
            $data['updt_itm_stock_table'] = $update_arr_stock;
            
            
//            echo '<pre>';            print_r($data); die; 
            return $data;
            
         }
        
	function update(){ 
//            echo '<pre>';            print_r($this->input->post()); die;
            $inputs = $this->input->post();
            $sale_order_id = $inputs['id']; 
            
            $cur_det = $this->Sales_order_items_model->get_currency_for_code($inputs['currency_code']);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['so_tbl'] = array(  
                                    'customer_id' => $inputs['customer_id'], 
                                    'customer_branch_id' => $inputs['customer_branch_id'], 
                                    'price_type_id' => $inputs['price_type_id'],  
                                    'order_date' => strtotime($inputs['order_date']),  
                                    'required_date' => strtotime($inputs['required_date']),  
                                    'currency_code' => $inputs['currency_code'], 
                                    'currency_value' => $cur_det['value'], 
                                    'location_id' => $inputs['location_id'],
                                    'delivery_address' => $inputs['delivery_address'],
                                    'customer_phone' => $inputs['customer_phone'],
                                    'customer_reference' => $inputs['customer_reference'],
                                    'memo' => $inputs['memo'],
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            $data['so_desc'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection Saleorder
            
            foreach ($inputs['inv_items'] as $inv_item){
                $data['so_desc'][] = array(
                                            'sales_order_id' => $sale_order_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_desc' => $inv_item['item_desc'],
                                            'units' => $inv_item['item_quantity'],
                                            'unit_uom_id' => $inv_item['item_quantity_uom_id'],
                                            'secondary_unit' => $inv_item['item_quantity_2'],
                                            'secondary_unit_uom_id' => $inv_item['item_quantity_uom_id_2'],
                                            'unit_price' => $inv_item['item_unit_cost'],
//                                            'discount_percent' => $inputs['discount_percent'],
                                            'location_id' => $inputs['location_id'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>6, //6 for Sales Order transection
                                                            'trans_ref'=>$inputs['id'], 
                                                            'item_id'=>$inv_item['item_id'], 
                                                            'units'=>$inv_item['item_quantity'], 
                                                            'uom_id'=>$inv_item['item_quantity_uom_id'], 
                                                            'units_2'=>$inv_item['item_quantity_2'], 
                                                            'uom_id_2'=>$inv_item['item_quantity_uom_id_2'], 
                                                            'location_id'=>$inputs['location_id'], 
                                                            'status'=>1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                            );
                
                if($inv_item['item_quantity_uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2']);
                else
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity']);
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                
            }
            
            //old data for log update
            $existing_data = $this->Sales_order_items_model->get_single_row($inputs['id']);
            $data['pre_update_check'] = $this->stock_status_updatecheck($inputs['id']);
//            echo '<pre>';            print_r($data); die;
            $edit_stat = $this->Sales_order_items_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $del_res = $this->Sales_order_items_model->delete_temp_so_item($this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['id']);
            
//                delete_cookie($this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['id']);
                $new_data = $this->Sales_order_items_model->get_single_row($inputs['id']);
                add_system_log(SALES_ORDERS, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        
        function remove(){
            $inputs = $this->input->post(); 
            //check the payments before delete reservation
            $this->load->model('Payments_model');
            $trans_data = $this->Payments_model->get_transections(11,$inputs['id'],'t.transection_type_id = 1'); //11 for SO customer type 1 for payments
//           
//            echo '<pre>';            print_r($trans_data); die;
//            $trans_data = $this->Sales_orders_model->get_transections($inputs['id']);
            if(!empty($trans_data)){
                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
                return false;
            }
            $data{'del_arr'} = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            foreach ($inputs['inv_items'] as $inv_item){
                
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>6, //6 for Sales Order transection
                                                            'trans_ref'=>$inputs['id'], 
                                                            'item_id'=>$inv_item['item_id'], 
                                                            'units'=>$inv_item['item_quantity'], 
                                                            'uom_id'=>$inv_item['item_quantity_uom_id'], 
                                                            'units_2'=>$inv_item['item_quantity_2'], 
                                                            'uom_id_2'=>$inv_item['item_quantity_uom_id_2'], 
                                                            'location_id'=>$inputs['location_id'], 
                                                            'status'=>1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                            );
                
                if($inv_item['item_quantity_uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2'],true);
                else
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],'',0,true);
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                
            }
            
            $existing_data = $this->Sales_order_items_model->get_single_row($inputs['id']);  
            $delete_stat = $this->Sales_order_items_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(SALES_ORDERS, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Sales_order_items_model->get_single_row($inputs['id']);
            if($this->Sales_order_items_model->delete2_db($id)){
                //update log data
                add_system_log(HOTELS, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
        function load_data($id=''){
            if($id!=''){
                $data['so_data'] = $this->Sales_order_items_model->get_single_row($id); 
                
                $data['so_order_items'] = $this->Sales_order_items_model->get_so_desc($id); 
                if(empty($data['so_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            
            $data['customer_list'] = get_dropdown_data(CUSTOMERS, 'customer_name', 'id','');
            $data['customer_type_list'] = get_dropdown_data(CUSTOMER_TYPE, 'customer_type_name', 'id','');
            $data['customer_branch_list'] = array();
//            $data['price_type_list'] = array(16=>'Whole Sale',15=>'Retail');
            $data['price_type_list'] = get_dropdown_data(DROPDOWN_LIST, 'dropdown_value', 'id','','dropdown_id = 14');
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id','');
                    
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code','','',0,SELECT2_ROWS_LOAD); //25 limit 
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','Category ');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code',''); 
//            echo '<pre>';            print_r($data); die;
            return $data;
	}	
        
        function search(){ 
            $input = $this->input->post();
            $search_data=array(  
                                'customer_id' => $input['customer_id'],  
                                'order_no' => $input['order_no'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $data['search_list'] = $this->Sales_order_items_model->so_search_result($search_data);  
            $this->load->view('sales_order_items/search_sales_orders_result',$data);
	}
        function search_cats($ret_arr=0){ 
            $input = $this->input->post();
            $search_data=array(  
                                'category_id' => $input['category_id'],  
                                'item_code' => $input['item_code'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $data['search_list_items'] = $this->Sales_order_items_model->search_result($search_data);
            $data['search_list_cats'] = $data['search_list_items_chunks'] = array();
            foreach ($data['search_list_items'] as $item){
                $data['search_list_cats'][$item['cat_id']]=$item;
            }
            if(!empty($data['search_list_items'])){
                $search_list_items_chunks = array_chunk ($data['search_list_items'], 12);
                $data['search_list_items_chunks'] = $search_list_items_chunks[(0)];
                $data['res_page_count'] = count($search_list_items_chunks);
            }
//		$data_view['search_list'] = $this->Sales_order_items_model->search_result();
            $this->load->view('sales_order_items/add_so_items_cat_result',$data);
	}
        function pagination_dets($ret_arr=0){ 
            $input = $this->input->post();
//            $data['sales_order_det'] = $this->Sales_order_items_model->get_single_row($input['order_id']);
            $search_data=array(  
                                'category_id' => (isset($input['category_id']))?$input['category_id']:'', 
                                'item_code' => (isset($input['item_code']))?$input['item_code']:'',  
                                'price_type_id' => 16,  //whole sale
                                ); 
            $data['search_list_items'] = $this->Sales_order_items_model->search_result($search_data);
                    
            if(!empty($data['search_list_items'])){
                $search_list_items_chunks = array_chunk ($data['search_list_items'], 9);
                $data['search_list_items_chunks'] = $search_list_items_chunks[(0)];
                echo count($search_list_items_chunks);
            }else{
                echo '0';
            }
	}
        function search_items(){ 
            $input = $this->input->post();
//            $data['sales_order_det'] = $this->Sales_order_items_model->get_single_row($input['order_id']);
            $search_data=array(  
                                'category_id' => $input['category_id'],  
                                'item_code' => $input['item_code'],  
                                'price_type_id' =>15, //Retail sale
                                ); 
            $data['search_list_items'] = $this->Sales_order_items_model->search_result($search_data,'i.status = 1');
            $data['search_list_cats'] = $data['search_list_items_chunks'] = array();
//            $data['order_id'] = $input['order_id'];
            foreach ($data['search_list_items'] as $item){
                $data['search_list_cats'][$item['cat_id']]=$item;
            }
            if(!empty($data['search_list_items'])) {
                $search_list_items_chunks = array_chunk ($data['search_list_items'], 9);
                $data['search_list_items_chunks'] = $search_list_items_chunks[($input['page_no']-1)];
                $data['res_page_count'] = count($search_list_items_chunks);
            }
//		$data_view['search_list'] = $this->Sales_order_items_model->search_result();
            $this->load->view('sales_order_items/add_so_items_itm_result',$data);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Sales_order_items_model->get_single_item($inputs['item_code'],$inputs['customer_id'],$inputs['price_type_id']); 
            echo json_encode($data);
        }
        function test(){
            
            $data['main_content']='test';  
            $this->load->view('includes/template',$data); 
            die;
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Sales_order_items_model->get_single_item(1002,15);
            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        
        function print_sales_order($inv_id){
//            echo '<pre>';            print_r($this->get_salesorder_info(1)); die;
            $inv_data = $this->get_salesorder_info($inv_id);
            $inv_dets = $inv_data['order_dets'];
            $inv_desc = $inv_data['order_desc']; 
            $this->load->library('Pdf');
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_am';//invice bg
            $pdf->fl_data_arr=array('order_no'=>$inv_dets['sales_order_no']);//invice bg
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF AM Invoice');
            $pdf->SetSubject('AM Invoice');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    
            // set font
            $pdf->SetFont('times', '', 11);
        
        
            $pdf->AddPage();   
            
            
            
            $pdf->SetTextColor(32,32,32);     
            
            $html = '<table>
                        <tr>
                            <td>Order Date: '.date('m/d/Y',$inv_dets['order_date']).'</td>
                            <td align="right">Required Date: '.date('m/d/Y',$inv_dets['required_date']).'</td> 
                        </tr>
                        <tr> 
                            <td colspan="2" align="center"><h1>Sales Order</h1></td>
                        </tr>  
                        <tr>
                            <td>Sold to: '.$inv_dets['customer_name'].'</td>
                            <td align="right">Branch: '.$inv_dets['branch_name'].'</td>
                        </tr>
                        <tr>
                            <td>Customer Contact Number: '.$inv_dets['phone'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr><td  colspan="5"><br></td></tr>
                    </table> 
                ';
           
//            echo '<pre>';            print_r($inv_data); die; 
                     $html .= '<table id="example1" class="table-line" border="0">
                                <thead> 
                                    <tr style="">
                                         <th width="12%" style="text-align: left;"><u><b>NL NO</b></u></th>  
                                         <th width="35%" style="text-align: left;"><u><b>Description</b></u></th>  
                                         <th  width="10%"><u><b>Qty</b></u></th> 
                                         <th width="23%" style="text-align: right;"><u><b>Rate</b></u></th> 
                                          <th width="20%" style="text-align: right;"><u><b>Total</b></u></th> 
                                     </tr>
                                </thead>
                            <tbody>';
                     $order_total = 0;
                     foreach ($inv_desc as $inv_itm){
                         $html .= '<tr>
                                        <td width="12%" style="text-align: left;">'.$inv_itm['item_code'].'</td>  
                                        <td width="35%" style="text-align: left;">'.$inv_itm['item_desc'].'</td> 
                                        <td width="10%">'.$inv_itm['units'].'</td>  
                                        <td width="23%" style="text-align: right;">'.$inv_dets['symbol_left'].' '. number_format($inv_itm['unit_price'],2).'</td> 
                                         <td width="20%" style="text-align: right;">'.$inv_dets['symbol_left'].' '. number_format($inv_itm['sub_total'],2).'</td> 
                                    </tr> ';
                         $order_total+=$inv_itm['sub_total'];
                     } 
                     $html .= '
                                <tr><td  colspan="5"></td></tr></tbody></table>';  
            $html .= '
                    
                    <table id="example1" class="table-line" border="0">
                        
                       <tbody> '; 
                    
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Total</b></td> 
                                    <td width="19%"  style="text-align: right;"><b>'.$inv_dets['symbol_left'].' '. number_format($order_total,2).'</b></td> 
                                </tr> 
                        </tbody>
                    </table>
                                                               
                ';
             $html .= '
            <style>
            .colored_bg{
                background-color:#E0E0E0;
            }
            .table-line th, .table-line td {
                padding-bottom: 2px;
                border-bottom: 1px solid #ddd; 
            }
            .text-right,.table-line.text-right{
                text-align:right;
            }
            .table-line tr{
                line-height: 22px;
            }
            </style>
                    ';
            $pdf->writeHTML($html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);           
//            $pdf->Text(160,20,$inv_dets['sales_order_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output($inv_dets['sales_order_no'].'.pdf', 'I');
                
        }
        function print_sales_order_del1($inv_id){
//            echo '<pre>';            print_r($this->get_salesorder_info(1)); die;
            $inv_data = $this->get_salesorder_info($inv_id);
            $inv_dets = $inv_data['order_dets'];
            $inv_desc = $inv_data['order_desc']; 
            $this->load->library('Pdf');
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_am';//invice bg
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF AM Invoice');
            $pdf->SetSubject('AM Invoice');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    
            // set font
            $pdf->SetFont('times', '', 11);
        
        
            $pdf->AddPage();   
            
            
            
            $pdf->SetTextColor(32,32,32);     
            
            $html = '<table>
                        <tr>
                            <td>Invoiced Date: '.date('m/d/Y',$inv_dets['order_date']).'</td>
                            <td align="right">Required Date: '.date('m/d/Y',$inv_dets['required_date']).'</td> 
                        </tr>
                        <tr> 
                            <td colspan="2" align="center"><h1>Sales Order</h1></td>
                        </tr>  
                        <tr>
                            <td>Customer: '.$inv_dets['customer_name'].'</td>
                            <td align="right">Branch: '.$inv_dets['branch_name'].'</td>
                        </tr>
                        <tr>
                            <td>Customer Contact Number: '.$inv_dets['phone'].'</td>
                            <td align="right">Chasis No: '.$inv_dets['phone'].'</td>
                        </tr>
                        <tr><td  colspan="5"><br></td></tr>
                    </table> 
                ';
           
//            echo '<pre>';            print_r($inv_data); die; 
                     $html .= '<table id="example1" class="table-line" border="0">
                                <thead> 
                                    <tr style="">
                                         <th  width="15%"><u><b>Qty</b></u></th> 
                                         <th width="40%" style="text-align: left;"><u><b>Description</b></u></th>  
                                         <th width="20%" style="text-align: right;"><u><b>Rate</b></u></th> 
                                          <th width="24%" style="text-align: right;"><u><b>Total</b></u></th> 
                                     </tr>
                                </thead>
                            <tbody>';
                     $order_total = 0;
                     foreach ($inv_desc as $inv_itm){
                         $html .= '<tr>
                                        <td width="15%">'.$inv_itm['units'].'</td> 
                                        <td width="40%" style="text-align: left;">'.$inv_itm['item_desc'].'</td>  
                                        <td width="20%" style="text-align: right;">'.$inv_dets['symbol_left'].' '. number_format($inv_itm['unit_price'],2).'</td> 
                                         <td width="24%" style="text-align: right;">'.$inv_dets['symbol_left'].' '. number_format($inv_itm['sub_total'],2).'</td> 
                                    </tr> ';
                         $order_total+=$inv_itm['sub_total'];
                     }
                     $html .= '
                                <tr><td  colspan="5"></td></tr></tbody></table>';  
            $html .= '
                    
                    <table id="example1" class="table-line" border="0">
                        
                       <tbody> '; 
                    
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Total</b></td> 
                                    <td width="19%"  style="text-align: right;"><b>'.$inv_dets['symbol_left'].' '. number_format($order_total,2).'</b></td> 
                                </tr> 
                        </tbody>
                    </table>
                                                               
                ';
             $html .= '
            <style>
            .colored_bg{
                background-color:#E0E0E0;
            }
            .table-line th, .table-line td {
                padding-bottom: 2px;
                border-bottom: 1px solid #ddd;
                text-align:center; 
            }
            .text-right,.table-line.text-right{
                text-align:right;
            }
            .table-line tr{
                line-height: 30px;
            }
            </style>
                    ';
            $pdf->writeHTML($html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);           
            $pdf->Text(160,20,$inv_dets['sales_order_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output('example_003.pdf', 'I');
                
        }
        
        function get_salesorder_info($order_id){
            if($order_id!=''){
                 $data['order_dets'] = $this->Sales_order_items_model->get_single_row($order_id); 
                if(empty($data['order_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['order_desc'] = array();
            $order_desc = $this->Sales_order_items_model->get_so_desc($order_id); 
            
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
            
            $data['order_desc_total']= 0;
            foreach ($item_cats as $cat_key=>$cay_name){ 
                foreach ($order_desc as $order_itm){
                    if($order_itm['item_category']==$cat_key){
                        $data['order_desc'][$cat_key][]=$order_itm;
                        $data['order_desc_total'] +=  $order_itm['sub_total'];
                    }
                }
            }
            $data['order_desc'] = $order_desc;
            $data['order_total'] = $data['order_desc_total'];
//            echo '<pre>';            print_r($data); die;
            return $data;
        }
        
        function fl_ajax(){  
//            echo '<pre>';            print_r($this->input->post()); die;
            $func = $this->input->post('function_name');
            $param = $this->input->post();
            
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            }
        }
         function get_customer_search_modal(){ 
                $inputs = $this->input->post();
                $this->load->model('Customers_model');
                $search_arry = array(
                                        'customer_id' => $inputs['search_customer_id'],
                                        'short_name' => $inputs['costemer_code'],
                                        'costomer_phone' => $inputs['costomer_phone'],
                                    );
                $data['item_res'] = $this->Customers_model->search_result($search_arry);
                
                $this->load->view('sales_pos/pos_pop_modals/customer_search_modal_result',$data);
//                echo '<pre>';            print_r($data); die;
        }
        function item_list_set_cookies(){
            $inputs = $this->input->post();
            unset($inputs['function_name']);       
            
            $list_data_jsn = $this->Sales_order_items_model->get_temp_so_item($inputs['order_id'])['value'];
            if(!empty($list_data_jsn))$temp_data = json_decode($list_data_jsn);
            $temp_data[]=$inputs; 
             
            $data =  array(
                            'reference'   => $this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['order_id'],
                            'value'  => json_encode($temp_data),
                            'user_id'   => $this->session->userdata(SYSTEM_CODE)['ID'],
                            );
            
            $del_res = $this->Sales_order_items_model->delete_temp_so_item($this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['order_id']);
            $add_res = $this->Sales_order_items_model->insert_temp_item($data);
            $list_data_jsn = $this->Sales_order_items_model->get_temp_so_item($inputs['order_id']);
            if(!empty($list_data_jsn)) 
                echo '1';
            else
                echo '0';
//        $this->test();
//            echo '<pre>';            print_r(json_decode($this->input->cookie('sale_inv_list',true))); die;
        }
        function set_temp_order_info(){
            $inputs = $this->input->post();
            unset($inputs['function_name']);     
//            echo '<pre>';            print_r($inputs); die;  
            
            $list_data_jsn = $this->Sales_order_items_model->get_temp_so_item($inputs['order_id'])['value'];
            if(!empty($list_data_jsn))$temp_data = json_decode($list_data_jsn); 
             
            $data =  array(
                            'reference'   => $this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['order_id'],
                            'value'  => $list_data_jsn,
                            'user_id'   => $this->session->userdata(SYSTEM_CODE)['ID'],
                            'customer_id'   => $inputs['customer_id'],
                            ); 
            if(isset($inputs['og'])){
                $data['og_data'] = json_encode($inputs['og']);
            }
//            echo '<pre>';            print_r($data); die;
            
            $del_res = $this->Sales_order_items_model->delete_temp_so_item($this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['order_id']);
            $add_res = $this->Sales_order_items_model->insert_temp_item($data);
            $list_data_jsn = $this->Sales_order_items_model->get_temp_so_item($inputs['order_id']);
            if(!empty($list_data_jsn)) 
                echo '1';
            else
                echo '0';
//        $this->test();
//            echo '<pre>';            print_r(json_decode($this->input->cookie('sale_inv_list',true))); die;
        }
         function get_cookie_data_itms(){ 
            $list_data_jsn = $this->Sales_order_items_model->get_temp_so_item($this->input->post('order_id'))['value'];
            echo $list_data_jsn;
//            echo '<pre>';            print_r(json_decode($list_data_jsn)); die;
//            return $list_data_jsn;
        }
         function get_temp_so_info(){ 
            $list_data_jsn = $this->Sales_order_items_model->get_temp_so_item($this->input->post('order_id'));
            echo json_encode($list_data_jsn);
//            echo '<pre>';            print_r(json_decode($list_data_jsn)); die;
//            return $list_data_jsn;
        }
        
        
        function add_items_order(){
            $inputs = $this->input->post();
            
            $sale_order_dets = $this->Sales_order_items_model->get_single_row($inputs['order_id']); 
             $data['so_desc'] =            array(
                                                            'sales_order_id' => $inputs['order_id'],
                                                            'item_id' => $inputs['item_dets']['id'],
                                                            'item_desc' => $inputs['item_dets']['item_name'],
                                                            'units' => $inputs['modal_qty'],
                                                            'unit_uom_id' => $inputs['item_dets']['item_uom_id'],
                                                            'secondary_unit' => 0,
                                                            'secondary_unit_uom_id' => $inputs['item_dets']['item_uom_id'],
                                                            'unit_price' => $inputs['modal_price'],
                        //                                            'discount_percent' => $inputs['discount_percent'],
                                                            'location_id' => $sale_order_dets['location_id'],
                                                            'status' => 1,
                                                            'deleted' => 0,
                                                        );
            $data['item_stock_transection'] = array(
                                                            'transection_type'=>6, //6 for Sales Order transection
                                                            'trans_ref'=>$inputs['order_id'], 
                                                            'item_id'=>$inputs['item_dets']['id'], 
                                                            'units'=>$inputs['modal_qty'], 
                                                            'uom_id'=>$inputs['item_dets']['item_uom_id'], 
                                                            'units_2'=>0, 
                                                            'uom_id_2'=>$inputs['item_dets']['item_uom_id'],
                                                            'location_id'=>$sale_order_dets['location_id'],
                                                            'status'=>1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                            );
            $item_stock_data = $this->stock_status_check($inputs['item_dets']['id'],$sale_order_dets['location_id'],$inputs['item_dets']['item_uom_id'],$inputs['modal_qty']);
                
            if(!empty($item_stock_data)){
                $data['item_stock'] = $item_stock_data;
            }
            $res = $this->Sales_order_items_model->add_item_for_order($data);
            if($res){
                echo '1';
            }else
                echo '0';
//            echo '<pre>';            print_r(($data));die;
        }
        function get_dropdown_branch_data(){
                $parent_id = $this->input->post('customer_id');
                $this->db->select("branch_name, id");	
                $this->db->from(CUSTOMER_BRANCHES);	 
                $this->db->where('deleted',0);
                if($parent_id > 0){
                    $this->db->where('customer_id',$parent_id); //identification - parent for variety
                }                       
                
                $res = $this->db->get()->result_array();
                $dropdown_data=array();
                    
                    $dropdown_data['']='Select Customer'; 
                foreach ($res as $res1){
                    $dropdown_data[$res1['id']] = $res1['branch_name'];
                    $result[$res1['id']] = $res1;
                }
//                echo '<pre>';                print_r($res); die;
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
            echo json_encode($res);
        }
        function get_single_branch_info(){
                $branch_id = $this->input->post('branch_id');
                $this->db->select("*");	
                $this->db->from(CUSTOMER_BRANCHES);	 
                $this->db->where('deleted',0);
                if($branch_id > 0){
                    $this->db->where('id',$branch_id);  
                }                       
                
                $res = $this->db->get()->result_array();
                $dropdown_data=array();
                    
//                echo '<pre>';                print_r($res); die;
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
                echo json_encode($res[0]);
        }
}
