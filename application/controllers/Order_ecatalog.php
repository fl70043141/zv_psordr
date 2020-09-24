<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_ecatalog extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Order_ecataog_modal'); 
        }

        public function index($so_id=''){
            $data['category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','All Categories');
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            
            $data['order_id'] = $so_id;
            $data['main_content']='sales/order_ecatalog/category_grid';  
            $this->load->view('includes/template',$data);
	}
        
        public function item_list($cat_id="", $page_no='1'){
            $cat_arr = explode('_',$cat_id); 
            $data['category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','All Categories');
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            
            $data['category_id'] = $cat_arr[0];
            $data['order_id'] = $cat_arr[1];
            $data['page_no'] = $page_no; 
            $data['main_content']='sales/order_ecatalog/item_grid';  
            $this->load->view('includes/template',$data);
	}
        
        public function image_loader($cat_id="", $page_no='1'){
            $cat_arr = explode('_',$cat_id); 
            $cat_id = $cat_arr[0];
            $price_type_id = (isset($cat_arr[2]))?$cat_arr[2]:'';
//            $data['category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Categories');
            
            $cur_page = (isset($page_no) && $page_no>0)?$page_no:1 ;
            $page_limit_from = 9*($cur_page-1);
            
            $search_data=array(  
                                'category_id' => $cat_id, 
                                );
            
            $item_res = $this->Order_ecataog_modal->search_items($search_data,9,$page_limit_from);  
//                    echo '<pre>';            print_r($cur_page); die;
            $data = array();
            if(!empty($item_res)){
                foreach ($item_res as $item){ 
//                    echo '<pre>';            print_r($input); die;
                    $data['item_res'][$item['id']] = $item; 
                    $data['item_res'][$item['id']]['price_info'] = $this->Order_ecataog_modal->get_item_price($item['id'],16); 
                    
                }
            }else{
                return false;
            }
//                    echo '<pre>';            print_r($inputs); die;
            $data['category_id'] = $cat_id;
            $data['order_id'] = $cat_arr[1];
            $data['page_no'] = $cur_page; 
            $data['price_type_id'] = $price_type_id; 
            $data['main_content']='sales/order_ecatalog/item_grid_img_loader';  
            $this->load->view('includes/template',$data);
	}
        
        function search_cats($ret_arr=0){
            $input = $this->input->post();
//            echo '<pre>';            print_r($input['price_type_id']); die;
            $search_data=array(  
                                'category_id' => $input['category_id'],  
                                'item_code' => $input['item_code'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $data['categories_res'] = $this->Order_ecataog_modal->search_categories($search_data); 
            $data['order_id'] = $input['order_id'];
            $data['price_type_id'] = $input['price_type_id'];
//		$data_view['search_list'] = $this->Order_ecataog_modal->search_result();
            $this->load->view('sales/order_ecatalog/category_grid_result',$data);
	}
        function search_items_for_cats(){
            $input = $this->input->post();
            $search_data=array(  
                                'category_id' => $input['item_category_id'],  
                                'item_code' => $input['item_code'],   
                                'price_type_id' => $input['price_type_id'],   
                                );
            $cur_page = (isset($input['curr_page_no']) && $input['curr_page_no']>0)?$input['curr_page_no']:1 ;
            $page_limit_from = 9*($cur_page-1);
            $item_res = $this->Order_ecataog_modal->search_items($search_data,9,$page_limit_from); 
            $data = array();
            if(!empty($item_res)){
                foreach ($item_res as $item){ 
//                    echo '<pre>';            print_r($item); die;
                    if($item['tot_units_1'] > 0){
                        $data['item_res'][$item['item_id']] = $item; 
                        $data['item_res'][$item['item_id']]['price_info'] = $this->Order_ecataog_modal->get_item_price($item['id'],$input['price_type_id']); 
                    }
                }
            }
            $data['category_id1'] =$input['item_category_id'];
            $data['price_type_id1'] = $input['price_type_id'];
            $data['cur_page1'] = $cur_page;
            $data['order_id'] = $input['order_id'];
//            echo '<pre>';            print_r($data); die;
            $this->load->view('sales/order_ecatalog/item_grid_result',$data);
	}
                    
        
        function fl_ajax(){ 
            $func = $this->input->post('function_name');
            $param = $this->input->post();
            
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            } 
        
        } 
         function get_single_item_info(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Order_ecataog_modal->get_single_item_info($inputs['item_id'],$inputs['price_type_id']); 
            echo json_encode($data);
        }
        
         function get_items_for_view(){
            $data = $this->search_items_page();
            echo json_encode($data);
        }
        
        function view_item($item_id, $item_categorty_id=0,$page_no=''){
            $cat_arr = explode('_',$item_categorty_id); 
            $item_categorty_id = $cat_arr[0];
//            $this->load->view('sales/order_ecatalog/item_single_view');
            $data['item_id'] = $item_id;
            $data['item_cat_id'] = $item_categorty_id;
            $data['item_list_page_no'] = $page_no;
            $data['order_id'] = (isset($cat_arr[1]))?$cat_arr[1]:'';
            $data['price_type_id'] = (isset($cat_arr[2]))?$cat_arr[2]:'';
            $data['main_content']='sales/order_ecatalog/item_single_view';  
            $this->load->view('includes/template_rep',$data);
        }
        
        function search_items_page(){
            $input = $this->input->post();
            $search_data=array(  
                                'category_id' => ($input['item_category_id']==0)?'':$input['item_category_id'],  
                                'item_code' => (isset($input['item_code']))?$input['item_code']:'',   
                                'price_type_id' => $input['price_type_id'],   
                                );
//            echo '<pre>';            print_r($search_data); die;
            $cur_page = (isset($input['curr_page_no']) && $input['curr_page_no']>0)?$input['curr_page_no']:1 ;
            $page_limit_from = 9*($cur_page-1);
            $item_res = $this->Order_ecataog_modal->search_items($search_data,9,$page_limit_from); 
//            echo '<pre>';            print_r($item_res); die;
            $data = array();
            $exist_item = 0;
            if(!empty($item_res)){
                foreach ($item_res as $item){ 
                    if(isset($input['itm_id']) && $item['item_id']==$input['itm_id']){
                        $exist_item=1;
                    }
                    if($item['tot_units_1'] > 0){
                        $data['item_res'][$item['item_id']] = $item; 
                        $data['item_res'][$item['item_id']]['item_price_info'] = $this->Order_ecataog_modal->get_item_price($item['item_id'],$input['price_type_id']); 
                        $data['item_res'][$item['item_id']]['item_stock_info'] = $this->Order_ecataog_modal->get_item_stock($item['item_id']); 
                    }
                }
                if(isset($input['itm_id']) && $input['itm_id']!='' && $exist_item==0){    
                    $item_exist = $this->Order_ecataog_modal->search_items(array('item_id'=>$input['itm_id']));
                    if(!empty($item_exist)){
                        $item_exist = $item_exist[0];
                        $data['item_res'][$item_exist['item_id']] = $item_exist; 
                        $data['item_res'][$item_exist['item_id']]['item_price_info'] = $this->Order_ecataog_modal->get_item_price($item_exist['item_id'],$input['price_type_id']); 
                        $data['item_res'][$item_exist['item_id']]['item_stock_info'] = $this->Order_ecataog_modal->get_item_stock($item_exist['item_id']); 
                    }
                }
            }
//                    echo '<pre>';            print_r($item_exist); die;
            $data['category_id1'] = $input['item_category_id'];
            $data['cur_page1'] = $cur_page;
            return $data;
        }

        function add_to_tmp_order(){ 
            $inputs = $this->input->post();
            $cur_user_id = $this->session->userdata(SYSTEM_CODE)['ID'];
            $update_arr = array(); 
            $reference_check = $cur_user_id.'_so_'.(($inputs['order_id']=='')?0:$inputs['order_id']);
//            echo '<pre>';            print_r($reference_check); die;
            $open_tmp_order = $this->Order_ecataog_modal->get_tmp_order_open($cur_user_id,"sot.reference = '".$reference_check."'");
            
            $ret_res = 0;
            if($open_tmp_order == ""){
                $tmp_id = get_autoincrement_no(SALES_ORDER_ITEM_TEMP);
                $tmp_order_no = gen_id(TEMP_SALE_ORDER_NO_PREFIX, SALES_ORDER_ITEM_TEMP, 'id');
                $insert_arr = array(
                                    'id' => $tmp_id, 
                                    'reference' => $reference_check, 
                                    'temp_order_no' => $tmp_order_no,
                                    'value' => json_encode(array($inputs['item_id']=>array('item_id'=>$inputs['item_id'],'units'=>$inputs['units'],'unit_price'=>$inputs['unit_price']))),
                                    'user_id' => $cur_user_id,
                                    'updated_time' => time(),
                                    'status' => 0, //0 for open status
                                    'deleted' => 0,
                                );
                
//            echo '<pre>';            print_r($insert_arr); die;
                $ret_res = $this->Order_ecataog_modal->insert_temp_item($insert_arr);
            }else{
                $open_curr_value = json_decode($open_tmp_order['value'],true);
                if(isset($open_curr_value[$inputs['item_id']]) && !empty($open_curr_value[$inputs['item_id']])){ //alrady item added to temp
                    $open_curr_value[$inputs['item_id']]['units'] = ($open_curr_value[$inputs['item_id']]['units']+$inputs['units']);
                    $open_curr_value[$inputs['item_id']]['unit_price'] = $inputs['unit_price'];
                }else{
                    $open_curr_value[$inputs['item_id']] = array('item_id'=>$inputs['item_id'],'units'=>$inputs['units'],'unit_price'=>$inputs['unit_price']);
                }
                
                $update_arr = array(
                                        'value' => json_encode($open_curr_value),
                                        'updated_time' => time(),
                                    );
                
                $ret_res = $this->Order_ecataog_modal->update_temp_item($open_tmp_order['id'], $update_arr);
            }
            
            echo $ret_res;
        }
        
        function remove_temp_so_item(){
            $inputs = $this->input->post();
            $cur_user_id = $this->session->userdata(SYSTEM_CODE)['ID'];
            $reference = $cur_user_id.'_so_'.((isset($inputs['order_id']))?$inputs['order_id']:0);
            $update_arr = array(); 
            $open_tmp_order = $this->Order_ecataog_modal->get_tmp_order_open($cur_user_id,"sot.reference = '".$reference."'");
            
//            echo '<pre>';            print_r($open_tmp_order); die;
            $open_curr_value = json_decode($open_tmp_order['value'],true);
            unset($open_curr_value[$inputs['del_itemid']]);
            $ret_res = 0;
            if(empty($open_curr_value)){//remove temp row empty unsvaed items
                $cur_user_id = $this->session->userdata(SYSTEM_CODE)['ID'];
                $reference = $cur_user_id.'_so_'.((isset($inputs['order_id']))?$inputs['order_id']:0);
                $ret_res = $this->Order_ecataog_modal->cancel_temp_opened_order($reference);
            }else{
                $update_arr = array(
                                        'value' => json_encode($open_curr_value),
                                        'updated_time' => time(),
                                    );

                $ret_res = $this->Order_ecataog_modal->update_temp_item($open_tmp_order['id'], $update_arr);
            }
            echo $ret_res;
        }
                
        function cancel_open_temp_order($order_id=''){ //remove from from  temp order
            
            $input = $this->input->post();
//            echo '<pre>';            print_r($input); die;
            $cur_user_id = $this->session->userdata(SYSTEM_CODE)['ID'];
            $reference = $cur_user_id.'_so_'.((isset($input['order_id']))?$input['order_id']:0);
            $ret_res = $this->Order_ecataog_modal->cancel_temp_opened_order($reference);
            
            $this->session->set_flashdata('warn','Your unsaved Order items Cancelled Successfully!');
            echo $ret_res;
        }
                
        function get_temp_so_open($temp_id){
            $cur_user_id = $this->session->userdata(SYSTEM_CODE)['ID'];
            
            $inputs = $this->input->post();
            $reference_check = $cur_user_id.'_so_'.$inputs['order_id'];
            $open_tmp_order = $this->Order_ecataog_modal->get_tmp_order_open($cur_user_id,"sot.reference = '".$reference_check."'");

//            $open_tmp_order = $this->Order_ecataog_modal->get_tmp_order_open($cur_user_id);
            
            $ret_array = array();
            if(isset($open_tmp_order['value']) && !empty($open_tmp_order['value'])){
                $open_tmp_arr = json_decode($open_tmp_order['value'],true);
                
                foreach ($open_tmp_arr as $tmp_item){
                    $tmp_item_info = $this->Order_ecataog_modal->get_single_item_info($tmp_item['item_id'],16);
                    $ret_array[$tmp_item['item_id']] = $tmp_item_info;
                    $ret_array[$tmp_item['item_id']]['temp_info'] = $tmp_item;
                }
                echo json_encode($ret_array); 
            }
        }




// ***************************************************
        
        
        
        
        function view_search($datas=''){
            
            //removing temp so items
                $this->load->model('Sales_order_items_model');
                $del_res = $this->Sales_order_items_model->delete_temp_so_item($this->session->userdata(SYSTEM_CODE)['ID'].'_so_0');
                
//            $this->add();
            $this->load->model('Item_categories_model'); 
            $data['search_list'] = $this->Order_ecataog_modal->search_result();
            $data['main_content']='sales_orders/search_sales_orders'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id','Customer','customer_type_id = 1');
            $this->load->view('includes/template',$data);
	}
        function add_item_by_cat($order_id){
//            $this->add();
            $this->load->model('Item_categories_model'); 
            $data['search_list'] = $this->Order_ecataog_modal->search_result();
//            $data['sales_order_det'] = $this->Order_ecataog_modal->get_single_row($order_id);
            $data['order_id'] = $order_id;
            $data['main_content']='sales_orders/add_sales_order_items'; 
            $data['category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','Categories');
//            echo '<pre>';            print_r($data);die;
            $this->load->view('includes/template',$data);
	}
//        
//        function view_search($datas=''){
////            $this->add();
//            $data['search_list'] = $this->Order_ecataog_modal->search_result();
//            $data['main_content']='sales_orders/search_sales_orders'; 
//            $data['supplier_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id','Suppliers');
//            $this->load->view('includes/template',$data);
//	}
        
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='sales_orders/manage_sales_orders';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='sales_orders/manage_sales_orders'; 
            $data['inv_data'] = $this->get_salesorder_info($id);
//            echo '<pre>';            print_r($data);die;
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='sales_orders/manage_sales_orders'; 
            $data['inv_data'] = $this->get_salesorder_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='sales_orders/manage_sales_orders'; 
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
//            echo '<pre>';            print_r($this->input->post()); die;
            
            $inputs = $this->input->post();
            $sale_order_id = get_autoincrement_no(SALES_ORDERS);
            $order_no = gen_id(SALE_ORDER_NO_PREFIX, SALES_ORDERS, 'id');
            $inputs['currency_code'] = (isset($inputs['currency_code']))?$inputs['currency_code']:$this->session->userdata(SYSTEM_CODE)['default_currency']; 
            
            $cur_det = $this->Order_ecataog_modal->get_currency_for_code($inputs['currency_code']);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['so_tbl'] = array(
                                    'id' => $sale_order_id,
                                    'sales_order_no' => $order_no,
                                    'customer_id' => $inputs['customer_id'], 
                                    'customer_branch_id' => (isset($inputs['customer_branch_id']))?$inputs['customer_branch_id']:'', 
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
            $tot_amount = 0;
            foreach ($inputs['inv_items'] as $inv_item){
                $data['so_desc'][] = array(
                                            'sales_order_id' => $sale_order_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_desc' => $inv_item['item_desc'],
                                            'description' => $inv_item['description'],
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
                $tot_amount += $inv_item['item_unit_cost'] * $inv_item['item_quantity'];
                
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
            
                //GL for SO
                $data['gl_trans'][] = array(
                                                    'person_type' => 11,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $sale_order_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 75, //75 Worksop Avl GL
                                                    'account_code' => 1210, //5 Worksop GL
                                                    'memo' => 'SALES ORDER',
                                                    'amount' => (-$tot_amount),
                                                    'currency_code' => $cur_det['code'],
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                $data['gl_trans'][] = array(
                                                    'person_type' => 11,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $sale_order_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 3, //14 AC Receivable GL
                                                    'account_code' => 1200, //Receivable GL
                                                    'memo' => 'SALES ORDER',
                                                    'amount' => ($tot_amount),
                                                    'currency_code' => $cur_det['code'],
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
            //payments
            $this->load->model('Payments_model');  
            $trans_totl = 0; 
            if(!empty($inputs['trans']) && isset($inputs['trans'])){ //cash payment for Order 
                $trans_id = get_autoincrement_no(TRANSECTION); 
                foreach ($inputs['trans'] as $tr_key => $trans){
                    $p_method=1;
                    switch ($tr_key){
                        case 'cash': $p_method = 1; break;
                        case 'card': $p_method = 2; break;
                        case 'voucher': $p_method = 3; break;
                        case 'return_refund': $p_method = 4; break;
                    }
                    
                    foreach ($trans as $trn){
                        $data['payment_transection'][] = array(
                                                                'id' =>$trans_id,
                                                                'transection_type_id' =>1, //1 for customer payments
                                                                'payment_method' =>$p_method, 
                                                                'reference' =>'', 
                                                                'person_type' =>11, //11 for customer Sales Order
                                                                'person_id' =>$inputs['customer_id'],
                                                                'transection_amount' =>$trn,
                                                                'currency_code' => $cur_det['code'],
                                                                'currency_value' => $cur_det['value'], 
                                                                'trans_date' => strtotime($inputs['order_date']),
                                                                'trans_memo' => $tr_key.'_SO',
                                                                'status' => 1,
                                                            );

                        $data['payment_transection_ref'][] = array(
                                                                'transection_id' =>$trans_id,
                                                                'reference_id' =>$sale_order_id,
                                                                'trans_reference' =>$order_no,
                                                                'transection_ref_amount' =>$trn, 
                                                                'person_type' =>11, //10 for customer Sales Order 
                                                                'status' =>1, 
                                                            ); 
                        $trans_totl += $trn; 
                        $trans_id++; 
                    }
                    
                    $data['gl_trans'][] = array(
                                                    'person_type' => 11,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $sale_order_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 3, //14 AC Receivable GL
                                                    'account_code' => 1200, 
                                                    'memo' => '',
                                                    'amount' => (-$trans_totl),
                                                    'currency_code' => $cur_det['code'],
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                    $data['gl_trans'][] = array(
                                                    'person_type' => 11,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $sale_order_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 1, //2 petty cash
                                                    'account_code' => 1060,
                                                    'memo' => '',
                                                    'amount' => (+$trans_totl),
                                                    'currency_code' => $cur_det['code'],
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                    
                        
                }
                
                
            }
            
//            echo '<pre>';            print_r($data); die;
                    
		$add_stat = $this->Order_ecataog_modal->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Order_ecataog_modal->get_single_row($add_stat[1]);
                    add_system_log(SALES_ORDERS, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class().'/edit/'.$sale_order_id)); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0){ //updatiuon for item_stock table
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
                
//                $stock_trans_det = $this->Item_stock_model->get_stock_transection($this->input->post('id'));
//                echo '<pre>';            print_r($stock_trans_det); die;
                $available_units = $stock_det['units_available'] - $units;
                $available_units_2 = $stock_det['units_available_2'] - $units_2;
                $units_on_demand = $stock_det['units_on_demand'] + $units;
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
            
                    $this->session->set_flashdata('error','You are not Authorised to update the Order');
                    redirect(base_url($this->router->fetch_class()."/edit/".$this->input->post('id'))); 
                    die;
                    
            $inputs = $this->input->post();
            $sale_order_id = $inputs['id']; 
            
            $cur_det = $this->Order_ecataog_modal->get_currency_for_code($inputs['currency_code']);
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
            //old data for log update
            $existing_data = $this->Order_ecataog_modal->get_single_row($inputs['id']);
            $data['pre_update_check'] = $this->stock_status_updatecheck($inputs['id']);
//            echo '<pre>';            print_r($data); die;
            $edit_stat = $this->Order_ecataog_modal->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $del_res = $this->Order_ecataog_modal->delete_temp_so_item($this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['id']);
            
//                delete_cookie($this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['id']);
                $new_data = $this->Order_ecataog_modal->get_single_row($inputs['id']);
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
//            $trans_data = $this->Order_ecataog_modal->get_transections($inputs['id']);
            if(!empty($trans_data)){
                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
                return false;
            }
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            $existing_data = $this->Order_ecataog_modal->get_single_row($inputs['id']);  
            $delete_stat = $this->Order_ecataog_modal->delete_db($inputs['id'],$data);
                    
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
            
            $existing_data = $this->Order_ecataog_modal->get_single_row($inputs['id']);
            if($this->Order_ecataog_modal->delete2_db($id)){
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
                $data['so_data'] = $this->Order_ecataog_modal->get_single_row($id); 
                
                $data['so_order_items'] = $this->Order_ecataog_modal->get_so_desc($id); 
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
            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code','','',0,SELECT2_ROWS_LOAD); 
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
            $data['search_list'] = $this->Order_ecataog_modal->so_search_result($search_data);  
            $this->load->view('sales_orders/search_sales_orders_result',$data);
	}
        function pagination_dets($ret_arr=0){ 
            $input = $this->input->post();
            $data['sales_order_det'] = $this->Order_ecataog_modal->get_single_row($input['order_id']);
            $search_data=array(  
                                'category_id' => $input['category_id'],  
                                'item_code' => $input['item_code'],  
                                'price_type_id' => $data['sales_order_det']['price_type_id'],  
                                ); 
            $data['search_list_items'] = $this->Order_ecataog_modal->search_result($search_data);
                    
            if(!empty($data['search_list_items'])){
                $search_list_items_chunks = array_chunk ($data['search_list_items'], 12);
                $data['search_list_items_chunks'] = $search_list_items_chunks[(0)];
                echo count($search_list_items_chunks);
            }else{
                echo '0';
            }
	}
        function search_items(){ 
            $input = $this->input->post();
            $data['sales_order_det'] = $this->Order_ecataog_modal->get_single_row($input['order_id']);
            $search_data=array(  
                                'category_id' => $input['category_id'],  
                                'item_code' => $input['item_code'],  
                                'price_type_id' => $data['sales_order_det']['price_type_id'], 
                                ); 
            $data['search_list_items'] = $this->Order_ecataog_modal->search_result($search_data,'i.status = 1');
            $data['search_list_cats'] = $data['search_list_items_chunks'] = array();
            $data['order_id'] = $input['order_id'];
            foreach ($data['search_list_items'] as $item){
                $data['search_list_cats'][$item['cat_id']]=$item;
            }
            if(!empty($data['search_list_items'])) {
                $search_list_items_chunks = array_chunk ($data['search_list_items'], 12);
                $data['search_list_items_chunks'] = $search_list_items_chunks[($input['page_no']-1)];
                $data['res_page_count'] = count($search_list_items_chunks);
            }
//		$data_view['search_list'] = $this->Order_ecataog_modal->search_result();
            $this->load->view('sales_orders/add_so_items_itm_result',$data);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Order_ecataog_modal->get_single_item($inputs['item_code'],$inputs['customer_id'],$inputs['price_type_id']); 
            echo json_encode($data);
        }
        function test(){
            
            $data['main_content']='test';  
            $this->load->view('includes/template',$data); 
            die;
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Order_ecataog_modal->get_single_item(1002,15);
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
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='ORDER';//invice bg
            $pdf->fl_header_title_RTOP='CUSTOMER COPY';//invice bg
            $pdf->fl_footer_text=1;//invice bg
            
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
            $pdf->SetMargins(5, 50, 5);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    
            // set font 
            $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/Lato-Regular.ttf', 'TrueTypeUnicode', '', 96);
            $pdf->SetFont($fontname, 'I', 9);
//            $pdf->SetFont('times', '', 11);
                        
            $pdf->AddPage();   
                        
            $so_invoices_html = $payment = $old_gold = '';
            $payment_tot = $old_gold_tot = $tot_redeem_full = $tot_inv_payment_full = 0;
            $pdf->SetTextColor(32,32,32);    
                        
            if(isset($inv_data['so_invoices']) && !empty($inv_data['so_invoices'])){
                        
                $so_invoices_html = '
                           <table id="example1" class="" style="padding:5px;" border="0">

                              <tbody> 
                               <tr><td width="65%" style="border-bottom: 1px solid #00000;text-align: left;"  colspan="2">Invoice Summary</td></tr>
                              '; 

                               $so_invoices_html .= '<thead><tr style="background-color:#F5F5F5;">
                                           <th style="text-align: left;"  width="14%"><b>Invoice#</b></th> 
                                           <th style="text-align: right;"  width="12%"><b>Received</b></th> 
                                           <th style="text-align: right;"  width="14%"><b>Order Redeemed</b></th> 
                                           <th style="text-align: right;"  width="12%"><b>Invoice Total</b></th> 
                                           <th style="text-align: right;"  width="13%"><b>Balance</b></th> 
                                       </tr></thead><tbody> ';
                                           foreach ($inv_data['so_inv_trans'] as $so_inv_trans){//invoice Trans
                                               $tot_redeem = 0;
                                               if(isset($inv_data['so_inv_redeem_pay']) && !empty($inv_data['so_inv_redeem_pay'])){//inv  redeemed
                                                    foreach ($inv_data['so_inv_redeem_pay'] as $redeemed){
                                                        if($redeemed['redeemed_inv_id'] == $so_inv_trans['reference_id'] )
                                                            $tot_redeem += $redeemed['transection_amount'];
                                                    }
                                                }
                                                
//                                                    echo '<pre>';                    print_r($inv_data['so_invoices'][$so_inv_trans['reference_id']]['sub_total']); die;
                                               $inv_sub_total = $inv_data['so_invoices'][$so_inv_trans['reference_id']]['sub_total'];
                                               $inv_balance = $inv_sub_total - $so_inv_trans['trans_amount'];
                                               
                                               $tot_inv_payment_full += $so_inv_trans['trans_amount'];
                                               $tot_redeem_full += $tot_redeem;
                                               
                                               $so_invoices_html .= '<tr style="line-height: 10px;">
                                                   <td style="text-align: left;"  width="14%">'.$so_inv_trans['invoice_no'].'</td> 
                                                   <td style="text-align: right;"  width="12%">'.number_format($so_inv_trans['trans_amount'],2).'</td> 
                                                   <td style="text-align: right;"  width="14%">'.number_format($tot_redeem,2).'</td> 
                                                   <td style="text-align: right;"  width="12%">'.number_format($inv_sub_total,2).'</td> 
                                                   <td style="text-align: right;"  width="13%">'.number_format($inv_balance,2).'</td> 
                                               </tr> ';
                                           }
                               $so_invoices_html .= '<tr><td width="65%" style="border-top: 1px solid #00000;text-align: right;"  colspan="2"></td></tr></tbody>
                           </table>  ';
           } 
            if(isset($inv_data['so_transection_pay']) && !empty($inv_data['so_transection_pay'])){
                $payment = '
                           <table id="example1" class="" style="padding:5px;" border="0">

                              <tbody> 
                               <tr><td width="65%" style="border-bottom: 1px solid #00000;text-align: left;"  colspan="2">Payments</td></tr>
                              '; 

                               $payment .= '<thead><tr style="background-color:#F5F5F5;">
                                           <th style="text-align: left;"  width="15%"><b>Paid Date</b></th> 
                                           <th style="text-align: center;"  width="15%"><b>Paymet ID</b></th> 
                                           <th style="text-align: center;"  width="15%"><b>Payment Method</b></th> 
                                           <th style="text-align: right;"  width="20%"><b>Amount</b></th> 
                                       </tr></thead><tbody> ';
                                           foreach ($inv_data['so_transection_pay'] as $payment_info){
                                               $payment_tot += $payment_info['transection_amount'];
                                               $payment .= '<tr style="line-height: 10px;">
                                                   <td style="text-align: left;"  width="15%">'. date(SYS_DATE_FORMAT,$payment_info['trans_date']).'</td> 
                                                   <td style="text-align: center;"  width="15%">'.$payment_info['id'].'</td> 
                                                   <td style="text-align: center;"  width="15%">'.$payment_info['payment_method'].'</td> 
                                                   <td style="text-align: right;"  width="20%">'.number_format($payment_info['transection_amount'],2).'</td> 
                                               </tr> ';
                                           }
                               $payment .= '<tr><td width="65%" style="border-top: 1px solid #00000;text-align: right;"  colspan="2"></td></tr></tbody>
                           </table>  ';
           } 
            if(isset($inv_data['so_og_info']) && !empty($inv_data['so_og_info'])){
                 $old_gold = '
                            <table id="example1" class="" style="padding:5px;" border="0">

                               <tbody> 
                                <tr><td width="65%" style="border-bottom: 1px solid #00000;text-align: left;"  colspan="2">Old Gold</td></tr>
                               '; 

                                $old_gold .= '<thead><tr style="background-color:#F5F5F5;">
                                            <th style="text-align: left;"  width="22%"><b>Date</b></th> 
                                            <th style="text-align: center;"  width="23%"><b>OG No</b></th>  
                                            <th style="text-align: right;"  width="20%"><b>Amount</b></th> 
                                        </tr></thead><tbody> ';
                                            foreach ($inv_data['so_og_info'] as $og){
                                                $old_gold_tot += $og['og_amount'];
                //            echo '<pre>';            print_r($payment); die;
                                                $old_gold .= '<tr style="line-height: 10px;">
                                                    <td style="text-align: left;"  width="22%">'. date(SYS_DATE_FORMAT,$og['og_date']).'</td> 
                                                    <td style="text-align: center;"  width="23%">'.$og['og_no'].'</td>  
                                                    <td style="text-align: right;"  width="20%">'.number_format($og['og_amount'],2).'</td> 
                                                </tr> ';
                                            }
                                $old_gold .= '<tr><td width="65%" style="border-top: 1px solid #00000;text-align: right;"  colspan="2"></td></tr></tbody>
                            </table>  ';
            }
                        
                        
            $html = '<text>Customer Details:</text><br>';
            $html .= '<table style="padding:2;" border="0.4"> 
                        <tr><td>
                            <table style="padding:0 50 2 0;">
                            <tr>
                                <td style="padding:10px;">Customer Code: '.$inv_dets['branch_short_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Full Name: '.$inv_dets['customer_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Address: '.$inv_dets['delivery_address'].'</td> 
                            </tr>   
                        </table> 
                    </td></tr>
                    </table> ';
            $html .= '<table border="0">
                            <tr><td  colspan="3"><br></td></tr>
                            <tr>
                                <td align="center">TRX Type: Order</td> 
                                <td align="center">Date '.date('m/d/Y',$inv_dets['order_date']).'</td> 
                                <td align="center">Order No: '.$inv_dets['sales_order_no'].'</td> 
                            </tr>  
                            <tr><td  colspan="3"><br></td></tr>
                        </table>  ';
           
                     $html .= '<table border="0" style=""><tr><td>
                                            <table id="example1" class="table-line" border="0">
                                                <thead> 
                                                    <tr style=""> 
                                                        <th width="33%" style="text-align: left;"><u><b>Article Description</b></u></th>  
                                                        <th width="12%" style="text-align: left;"><u><b>Category</b></u></th>  
                                                        <th width="12%" style="text-align: left;"><u><b>Item code</b></u></th> 
                                                        <th  width="23%" style="text-align: center;" ><u><b>Weight</b></u></th>  
                                                        <th width="20%" style="text-align: right;"><u><b>Price</b></u></th> 
                                                     </tr>
                                                </thead>
                                            <tbody>';
                                     $order_total = 0;
                                     foreach ($inv_desc as $inv_itm){
//            echo '<pre>';            print_r($inv_itm); die; 
                                         $html .= '<tr>
                                                        <td width="33%" style="text-align: left;">'.$inv_itm['item_desc'].'</td> 
                                                        <td width="12%" style="text-align: left;">'.$inv_itm['item_cat_name'].'</td>  
                                                        <td width="12%">'.(($inv_itm['new_itemcode']!='')?$inv_itm['new_itemcode']:$inv_itm['item_code']).'</td>  
                                                        <td width="23%" style="text-align: center;">'.(($inv_itm['actual_units']!='')?$inv_itm['actual_units']:$inv_itm['units']).' '.$inv_itm['unit_abbreviation'].'</td> 
                                                        <td width="20%" style="text-align: right;"> '. number_format(($inv_itm['actual_sub_total']!='')?$inv_itm['actual_sub_total']:$inv_itm['sub_total'],2).'</td> 
                                                    </tr> ';
                                         $order_total+=(($inv_itm['actual_sub_total']!='')?$inv_itm['actual_sub_total']:$inv_itm['sub_total']);
                                     }
                                     $balance = $order_total;
                                     $html .= '
                                                <tr><td  colspan="5"></td></tr></tbody></table>';  
            $html .= '
                    
                    <table id="example1" class="table-line" border="0">
                        
                       <tbody> '; 
                    
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Total</b></td> 
                                    <td width="20%"  style="border-top: 1px solid #00000;text-align: right;"><b> '. number_format($order_total,2).'</b></td> 
                                </tr>';
                        if($payment_tot>0){
                            $balance -= $payment_tot;
                            $html .= '<tr>
                                        <td  style="text-align: right;" colspan="4"><b>Payments</b></td> 
                                        <td width="20%"  style="text-align: right;"><b> '. number_format($payment_tot,2).'</b></td> 
                                    </tr>';
                        }
                        if($old_gold_tot>0){
                            $balance -= $old_gold_tot;
                            $html .= '<tr>
                                        <td  style="text-align: right;" colspan="4"><b>Old Gold</b></td> 
                                        <td width="20%"  style="text-align: right;"><b> '. number_format($old_gold_tot,2).'</b></td> 
                                    </tr>';
                        }
                        if($tot_inv_payment_full>0){
                            $balance -= $tot_inv_payment_full;
                            $html .= '<tr>
                                        <td  style="text-align: right;" colspan="4"><b>Invoice Payments</b></td> 
                                        <td width="20%"  style="text-align: right;"><b> '. number_format($tot_inv_payment_full,2).'</b></td> 
                                    </tr>';
                        }
                        if($tot_redeem_full>0){
                            $balance += $tot_redeem_full;
                            $html .= '<tr>
                                        <td  style="text-align: right;" colspan="4"><b>Order Payment Redeemed</b></td> 
                                        <td width="20%"  style="text-align: right;"><b> [-]'. number_format($tot_redeem_full,2).'</b></td> 
                                    </tr>';
                        }
                        
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                                    <td width="20%" style="border-top: 1px solid #00000;text-align: right;" ><b> '. number_format($balance,2).'</b></td> 
                                </tr>';
                        $html .= '</tbody>
                    </table>
                                </td></tr></table>                               
                ';
                        
                        
            $html .= $payment.$old_gold.$so_invoices_html;
            
            $html .= '<table border="0">
                            <tr style="line-height:80px;"><td  colspan="2"><br></td></tr>
                            <tr>
                                <td  align="center">Fahry</td> 
                                <td align="center"></td> 
                            </tr>  
                            <tr style="line-height:5px;">
                                <td  align="center">...............................................</td> 
                                <td align="center">...............................................</td> 
                            </tr>  
                            <tr>
                                <td align="center">Sales Person</td> 
                                <td align="center">Customer Signature</td> 
                            </tr>   
                           </table>  ';            
            
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
                line-height: 20px;
            }
            </style>
                    ';
            $pdf->writeHTML($html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);           
//            $pdf->Text(160,20,$inv_dets['sales_order_no']);
            // force print dialog
            $js = 'this.print();';
            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('ORDER_'.$inv_dets['sales_order_no'].'.pdf', 'I'); 
        }
        
        function get_salesorder_info($order_id){
            if($order_id!=''){
                 $data['order_dets'] = $this->Order_ecataog_modal->get_single_row($order_id); 
                if(empty($data['order_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['order_desc'] = array();
            $order_desc = $this->Order_ecataog_modal->get_so_desc($order_id); 
            
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
            
            //og data
            $data['so_og_info'] = $this->Order_ecataog_modal->get_og_for_so($order_id); 
            
            $data['order_total'] = $data['order_desc_total'];
            $data['transection_total']=0;
            $this->load->model('Payments_model');
            $data['so_transection_pay'] = $this->Payments_model->get_transections(11,$order_id,'t.transection_type_id = 1'); //11 for SO customer type 1 for payments
//            echo '<pre>';            print_r(  $data['so_transection_pay']); die;
           
            foreach ($data['so_transection_pay'] as $trans){
                switch ($trans['calculation']){
                    case 1: //  addition from invoive
                            $data['transection_total'] += $trans['transection_ref_amount'];
                            $data['order_total'] += $trans['transection_ref_amount'];
                            break;
                    case 2: //substitute from invoiice
                            $data['transection_total'] -= $trans['transection_ref_amount'];
                            $data['order_total'] -= $trans['transection_ref_amount'];
                            break;
                    case 4: //settlement cust
                            $data['transection_total'] += $trans['transection_ref_amount'];
                            $data['order_total'] += $trans['transection_ref_amount'];
                            break;
                    default:
                            break;
                } 
            } 
            
            //get Invoice paymnts for order
            $data['so_inv_trans'] = $this->Order_ecataog_modal->get_transections_so_invoice($order_id); 
            
            //get Released Order Payments 
            $data['so_inv_redeem_pay'] = $this->Order_ecataog_modal->get_so_redeem_inv(11,$order_id,'t.transection_type_id = 5'); //11 for SO customer type 5 for Redeemed payments
//            echo '<pre>';            print_r($data['so_inv_redeem_pay']); die;
        $this->load->model('Sales_invoices_model');
            $so_invoices = $this->Sales_invoices_model->get_invc_desc_for_so($order_id,'','i.id'); //11 for SO customer type 5 for Redeemed payments
            foreach ($so_invoices as $so_inv){
                $data['so_invoices'][$so_inv['invoice_id']] = $so_inv; 
            }
//            echo '<pre>';            print_r($data['so_invoices']); die;
            return $data;
        }
        
        
        function add_so_payments(){
            $inputs = $this->input->post();
            $order_det = $this->Order_ecataog_modal->get_single_row($inputs['order_id']);
            $cur_det = get_currency_for_code($order_det['currency_code']);
                $trans_id = get_autoincrement_no(TRANSECTION); 
                $p_method=1;
                switch ($inputs['pay_method']){
                    case 'cash': $p_method = 1; break;
                    case 'card': $p_method = 2; break;
                    case 'voucher': $p_method = 3; break;
                    case 'return_refund': $p_method = 4; break;
                }
                    
                $data['trans_tbl'] = array(
                                                    'id' =>$trans_id,
                                                    'transection_type_id' =>1, //1 for customer payments
//                                                    'payment_method' =>$p_method, 
                                                    'payment_method' =>($inputs['pay_method_id']!='' && isset($inputs['pay_method_id']))?$inputs['pay_method_id']:1,// 1 for cash 
                                                    'reference' =>'', 
                                                    'person_type' =>11, //11 for customer Sales Order
                                                    'person_id' =>$order_det['customer_id'],
                                                    'transection_amount' =>$inputs['amount'],
                                                    'currency_code' => $cur_det['code'],
                                                    'currency_value' => $cur_det['value'],  
                                                    'trans_date' => strtotime('now'),
                                                    'trans_memo' => $inputs['pay_method'].'_SO',
                                                    'status' => 1,
                                                );

                $data['trans_ref'][] = array(
                                                    'transection_id' =>$trans_id,
                                                    'reference_id' =>$order_det['id'],
                                                    'trans_reference' =>$order_det['sales_order_no'],
                                                    'transection_ref_amount' =>$inputs['amount'], 
                                                    'person_type' =>11, //11 for customer Sales Order 
                                                    'status' =>1, 
                                                );  

                $data['gl_trans'][] = array(
                                                'person_type' => 11,
                                                'person_id' => $order_det['customer_id'],
                                                'trans_ref' => $order_det['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 3, //14 AC Receivable GL
                                                'account_code' => 1200, 
                                                'memo' => 'SO Payment',
                                                'amount' => (-$inputs['amount']),
                                                'currency_code' => $cur_det['code'],
                                                'currency_value' => $cur_det['value'],
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        );
                $data['gl_trans'][] = array(
                                                'person_type' => 11,
                                                'person_id' => $order_det['customer_id'],
                                                'trans_ref' => $order_det['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 1, //2 petty cash
                                                'account_code' => 1060,
                                                'memo' => 'SO Payment',
                                                'amount' => (+$inputs['amount']),
                                                'currency_code' => $cur_det['code'],
                                                'currency_value' => $cur_det['value'],
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        );
                
            $this->load->model('Payments_model');
            $res = $this->Payments_model->add_db($data);
            if($res[0]){ 
                    $this->session->set_flashdata('warn',"Payment Added Successfully"); 
            }else{
                    $this->session->set_flashdata('error',"Payment Incomplete; Something went Wrong!");  
            }
            echo $res[0];
//            echo '<pre>';            print_r($res);die;

            
        }
        function remove_so_payments(){
            $inputs = $this->input->post();
            $order_det = $this->Order_ecataog_modal->get_single_row($inputs['order_id']);
            $cur_det = get_currency_for_code($order_det['currency_code']);
                $trans_id = get_autoincrement_no(TRANSECTION); 
                $p_method=1;
                switch ($inputs['pay_method']){
                    case 'cash': $p_method = 1; break;
                    case 'card': $p_method = 2; break;
                    case 'voucher': $p_method = 3; break;
                    case 'return_refund': $p_method = 4; break;
                }
                    
                $data['trans_tbl'] = array(
                                                        'id' =>$trans_id,
                                                        'transection_type_id' =>1, //1 for customer payments
                                                        'payment_method' =>$p_method, 
                                                        'reference' =>'', 
                                                        'person_type' =>11, //11 for customer Sales Order
                                                        'person_id' =>$order_det['customer_id'],
                                                        'transection_amount' =>$inputs['amount'],
                                                        'currency_code' => $cur_det['code'],
                                                        'currency_value' => $cur_det['value'],
                                                        'trans_date' => strtotime('now'),
                                                        'trans_memo' => $inputs['pay_method'].'_SO',
                                                        'status' => 1,
                                                    );

                $data['trans_ref'][] = array(
                                                        'transection_id' =>$trans_id,
                                                        'reference_id' =>$order_det['id'],
                                                        'trans_reference' =>$order_det['sales_order_no'],
                                                        'transection_ref_amount' =>$inputs['amount'], 
                                                        'person_type' =>11, //11 for customer Sales Order 
                                                        'status' =>1, 
                                                    );  

                $data['gl_trans'][] = array(
                                                'person_type' => 11,
                                                'person_id' => $order_det['customer_id'],
                                                'trans_ref' => $order_det['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 3, //14 AC Receivable GL
                                                'account_code' => 1200, 
                                                'memo' => 'SO Payment',
                                                'amount' => (-$inputs['amount']),
                                                'currency_code' => $cur_det['code'],
                                                'currency_value' => $cur_det['value'],
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        );
                $data['gl_trans'][] = array(
                                                'person_type' => 11,
                                                'person_id' => $order_det['customer_id'],
                                                'trans_ref' => $order_det['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 1, //2 petty cash
                                                'account_code' => 1060,
                                                'memo' => 'SO Payment',
                                                'amount' => (+$inputs['amount']),
                                                'currency_code' => $cur_det['code'],
                                                'currency_value' => $cur_det['value'],
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        );
                
            $this->load->model('Payments_model');
            $res = $this->Payments_model->add_db($data);
            if($res[0]){ 
                    $this->session->set_flashdata('warn',"Payment Added Successfully"); 
            }else{
                    $this->session->set_flashdata('error',"Payment Incomplete; Something went Wrong!");  
            }
            echo $res[0];
//            echo '<pre>';            print_r($res);die;

            
        }
        
        function item_list_set_cookies(){
            $inputs = $this->input->post();
            unset($inputs['function_name']);       
            
            $list_data_jsn = $this->Order_ecataog_modal->get_temp_so_item($inputs['order_id'])['value'];
            if(!empty($list_data_jsn))$temp_data = json_decode($list_data_jsn);
            $temp_data[]=$inputs; 
             
            $data =  array(
                            'reference'   => $this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['order_id'],
                            'value'  => json_encode($temp_data),
                            );
            
            $del_res = $this->Order_ecataog_modal->delete_temp_so_item($this->session->userdata(SYSTEM_CODE)['ID'].'_so_'.$inputs['order_id']);
            $add_res = $this->Order_ecataog_modal->insert_temp_item($data);
            $list_data_jsn = $this->Order_ecataog_modal->get_temp_so_item($inputs['order_id']);
            if(!empty($list_data_jsn)) 
                echo '1';
            else
                echo '0';
//        $this->test();
//            echo '<pre>';            print_r(json_decode($this->input->cookie('sale_inv_list',true))); die;
        }
         function get_cookie_data_itms(){ 
            $list_data_jsn = $this->Order_ecataog_modal->get_temp_so_item($this->input->post('order_id'))['value'];
            echo $list_data_jsn;
//            echo '<pre>';            print_r($list_data_jsn); die;
//            return $list_data_jsn;
        }
         function get_so_trans_info($order_id){ 
             $inputs = $this->input->post(); 
             $data = array();
             
             //OG Data
            $og_data = $this->Order_ecataog_modal->get_og_for_so($inputs['order_id']); 
            if(!empty($og_data)) $data['og_data']  = $og_data;
            
            //So Payment
            $so_info = $this->get_salesorder_info($inputs['order_id']);
//            echo '<pre>';            print_r($so_info); die;
            if(!empty($so_info['so_transection_pay'])) $data['paymennt_data']  = $so_info['so_transection_pay'];
            if(!empty($so_info['so_inv_trans'])) $data['inv_paymennt_data']  = $so_info['so_inv_trans'];
            if(!empty($so_info['so_inv_redeem_pay'])) $data['inv_redeem_data']  = $so_info['so_inv_redeem_pay'];
            if(!empty($so_info['so_invoices'])) $data['so_invoices']  = $so_info['so_invoices'];
            
            echo json_encode($data);
        }
        
        
        function add_items_order(){
            $inputs = $this->input->post();
            
            $sale_order_dets = $this->Order_ecataog_modal->get_single_row($inputs['order_id']); 
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
            $res = $this->Order_ecataog_modal->add_item_for_order($data);
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
