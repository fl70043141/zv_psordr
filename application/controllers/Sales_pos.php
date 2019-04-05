<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_pos extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Sales_pos_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Sales_pos_model->search_result();
            $data['main_content']='sales_pos/search_sales_invoices'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id','Customers');
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data(); 
              
            if(isset($_GET['soid'])){ //data from sale order
                $this->load->model('Sales_orders_model');
                $data['so_data'] = $this->Sales_orders_model->get_single_row($_GET['soid']); 
                $data['so_order_items'] = $this->Sales_orders_model->get_so_desc($_GET['soid']); 
            }
//            echo '<pre>';            print_r($this->session->all_userdata());die;
//            echo '<pre>';            print_r($data); die;
            $data['action']		= 'Add';
            $data['main_content']='sales_pos/manage_sales_pos';    
            $this->load->view('includes/template_rep',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='vehicle_rates/manage_vehicle_rates'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='sales_invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){  
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='sales_invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
//            echo '<pre>';            print_r($data['inv_data']['invoice_desc']); die;
            $this->load->view('includes/template',$data);
	}
	
        function pos_print_direct($id=''){ 
            $invoice_data = $this->get_invoice_info($id);
//            echo '<pre>';            print_r($invoice_data); die;
            $this->load->helper('print_helper');
            fl_direct_print_invoice($invoice_data);
            
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

            $this->form_validation->set_rules('invoice_date','Invoice Date','required');
            $this->form_validation->set_rules('customer_id','Customer','required');
//            $this->form_validation->set_rules('reference','Reference','required'); 
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
//            echo '<pre>';            print_r($inputs); die;
            $invoice_id = get_autoincrement_no(INVOICES);
            $invoice_no = gen_id(INVOICE_NO_PREFIX, INVOICES, 'id');
            
            $cur_det = $this->Sales_pos_model->get_currency_for_code($inputs['currency_code']);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['inv_tbl'] = array(
                                    'id' => $invoice_id,
                                    'invoice_no' => $invoice_no,
                                    'customer_id' => $inputs['customer_id'], 
                                    'invoice_type_id' => 1, 
//                                    'reference' => $inputs['reference'],  
                                    'comments' => $inputs['memo'], 
                                    'invoice_date' => strtotime($inputs['invoice_date']), 
                                    'invoiced' => 1,   
                                    'so_id' => $inputs['so_id'],   
                                    'sales_type_id' => $inputs['price_type_id'], 
                                    'payement_term_id' => $inputs['payment_term_id'], 
                                    'currency_code' => $cur_det['code'], 
                                    'currency_value' => $cur_det['value'], 
                                    'location_id' => $inputs['location_id'],
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            if($this->session->userdata(SYSTEM_CODE)['user_group_id']!=0){
                $data['inv_tbl']['inv_group_id'] = $this->session->userdata(SYSTEM_CODE)['user_group_id'];
            }
            
            $data['inv_desc'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection 
            $data['transection'] = array(); //payments transection 
            $data['gl_trans'] = array(); //payments transection 
            
            $total_stnd = $total = 0;
            foreach ($inputs['inv_items'] as $inv_item){
                $standard_price_info = $this->Sales_pos_model->get_item_standard_prices($inv_item['item_id']);
                $standard_price = (!empty($standard_price_info))?$standard_price_info[0]['price_amount']:'';
                
                $total += ($inv_item['item_quantity']*$inv_item['item_unit_cost']) - $inv_item['item_line_discount'];
                $total_stnd += $inv_item['item_quantity']*$standard_price;
                
//                $total += $inv_item['item_quantity']*$inv_item['item_unit_cost']*(100-$inv_item['item_line_discount'])*0.01;
                $data['inv_desc'][] = array(
                                            'invoice_id' => $invoice_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_description' => $inv_item['item_desc'],
                                            'item_quantity' => $inv_item['item_quantity'],
                                            'item_quantity_uom_id' => $inv_item['item_quantity_uom_id'],
                                            'item_quantity_2' => $inv_item['item_quantity_2'],
                                            'item_quantity_uom_id_2' => $inv_item['item_quantity_uom_id_2'],
                                            'unit_price' => $inv_item['item_unit_cost'],
                                            'discount_fixed' => $inv_item['item_line_discount'],
                                            'location_id' => $inputs['location_id'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
                
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>2, //2 for Sales transection
                                                            'trans_ref'=>$invoice_id, 
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
                    if($inv_item['item_quantity_partial'] == 1){
                        $item_stock_data['partial_invoiced'] = 1;
                    }
                    $data['item_stock'][] = $item_stock_data;
                }
                
            }
            $data['so_ref'] = $inputs['so_id'];
            
            //payments
            $this->load->model('Payments_model'); 
            $trans_totl = 0;
            $payment_terms = $this->Payments_model->get_payment_term($inputs['payment_term_id']);
            if($payment_terms['payment_done']==1 & !empty($inputs['trans'])){ //cash payment for invoice 
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
                        
//                        echo '<pre>';            print_r($trn); die;
                        $data['payment_transection'][] = array(
                                                                'id' =>$trans_id,
                                                                'transection_type_id' =>1, //1 for customer payments
                                                                'payment_method' =>$p_method, 
                                                                'reference' =>'', 
                                                                'person_type' =>10, //10 for customer 
                                                                'person_id' =>$inputs['customer_id'],
                                                                'transection_amount' =>$trn,
                                                                'currency_code' => $cur_det['code'], 
                                                                'currency_value' => $cur_det['value'], 
                                                                'trans_date' => strtotime($inputs['invoice_date']),
                                                                'trans_memo' => $tr_key,
                                                                'status' => 1,
                                                            );

                        $data['payment_transection_ref'][] = array(
                                                                'transection_id' =>$trans_id,
                                                                'reference_id' =>$invoice_id,
                                                                'trans_reference' =>$invoice_no,
                                                                'transection_ref_amount' =>$trn, 
                                                                'person_type' =>10, //10 for customer 
                                                                'status' =>1, 
                                                            ); 
                        $trans_totl += $trn; 
                        $trans_id++;
                        
                        if($p_method==4){ //GL FOR SALES RETURN FUND
                            
                            $data['gl_trans'][] = array(
                                                            'person_type' => 10,
                                                            'person_id' => $inputs['customer_id'],
                                                            'trans_ref' => $invoice_id,
                                                            'trans_date' => strtotime("now"),
                                                            'account' => 14, //14 AC Payable GL
                                                            'account_code' => 2100, 
                                                            'memo' => 'RET_REFUND',
                                                            'amount' => ($trn),
                                                            'currency_code' => $cur_det['code'], 
                                                            'currency_value' => $cur_det['value'], 
                                                            'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                            'status' => 1,
                                                    );
                            $data['gl_trans'][] = array(
                                                            'person_type' => 10,
                                                            'person_id' => $inputs['customer_id'],
                                                            'trans_ref' => $invoice_id,
                                                            'trans_date' => strtotime("now"),
                                                            'account' => 1, //2 petty cash
                                                            'account_code' => 1060,
                                                            'memo' => 'RET_REFUND',
                                                            'amount' => (-$trn),
                                                            'currency_code' => $cur_det['code'], 
                                                            'currency_value' => $cur_det['value'], 
                                                            'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                            'status' => 1,
                                                    );
                            
                            $data['sales_ret_tbl']['payment_settled']=1;
                        }
                    }
                    
                        
                }
                
                
            }
            
            $addons_total = 0;
            $data['addons'] = array();
            if(!empty($inputs['addons']) && isset($inputs['addons'])){
                $this->load->model('Addons_model');
                foreach ($inputs['addons'] as $addn_key=>$addon){
                    $addon_info_jsn='';
                    $addon_info = $this->Addons_model->get_single_row($addn_key);
                    if(!empty($addon_info)){
                        $addon_info_jsn = json_encode($addon_info);
                    }
                    $addons_total+= $addon;
                     $data['addons'][] = array(
                                                'invoice_id'=>$invoice_id,
                                                'addon_id'=>$addn_key,
                                                'addon_amount'=>$addon,
                                                'addon_info'=>$addon_info_jsn,
                                                'status'=>1,
                                               );
                     
                    $this->load->model('General_ledgers_model');
                    $debit_gl = $this->General_ledgers_model->get_single_row_code($addon_info[0]['debit_gl_code'])[0];
                    $data['gl_trans'][] = array(
                                                   'person_type' => 10,
                                                   'person_id' => $inputs['customer_id'],
                                                   'trans_ref' => $invoice_id,
                                                   'trans_date' => strtotime("now"),
                                                   'account' => $debit_gl['id'], 
                                                   'account_code' => $debit_gl['account_code'],
                                                   'memo' => $addon_info[0]['addon_name'],
                                                   'amount' => (+$addon), 
                                                   'currency_code' => $cur_det['code'], 
                                                   'currency_value' => $cur_det['value'], 
                                                   'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                   'status' => 1,
                                           );

                    $credit_gl = $this->General_ledgers_model->get_single_row_code($addon_info[0]['credit_gl_code'])[0];
                    $data['gl_trans'][] = array(
                                                   'person_type' => 10,
                                                   'person_id' => $inputs['customer_id'],
                                                   'trans_ref' => $invoice_id,
                                                   'trans_date' => strtotime("now"),
                                                   'account' => $credit_gl['id'], 
                                                   'account_code' => $credit_gl['account_code'],
                                                   'memo' => $addon_info[0]['addon_name'],
                                                   'amount' => (-$addon),
                                                   'currency_code' => $cur_det['code'], 
                                                   'currency_value' => $cur_det['value'], 
                                                   'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                   'status' => 1,
                                           );
                }
            }
            $total += $addons_total;
//            echo '<br>traadd = '.($trans_totl+$addons_total); 
//            echo '<br>tra = '.$trans_totl; 
//            echo '<br>add = '.$addons_total; 
//            echo '<br>tot='.$total; die;
            if($trans_totl >= $total){
                    $data['inv_tbl']['payment_settled']=1;
                }else{ 
                    $this->session->set_flashdata('error','POS Invoice Payment Incompleted');
                    redirect(base_url($this->router->fetch_class().'/add/')); 
                }
                
                if(isset($inputs['return_note_nos'])){
                    $data['return_note_nos'] = $inputs['return_note_nos'];
                }
            
                $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 5, //5 inventory GL
                                                    'account_code' => 1510, //5 inventory GL
                                                    'memo' => 'SALES_POS',
                                                    'amount' => (-$total_stnd),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1
                                            );
                $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 43, //43 COGS id
                                                    'account_code' => 5010, //COGS GL
                                                    'memo' => 'SALES_POS',
                                                    'amount' => ($total_stnd),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 37, //14  SALES GL
                                                    'account_code' => 4010, 
                                                    'memo' => 'SALES_POS',
                                                    'amount' => (-$total),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                    $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 3, //3 AC RECEIVBLE
                                                    'account_code' => 1200,
                                                    'memo' => 'SALES_POS',
                                                    'amount' => (+$total),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                
                if($inputs['payment_term_id']==1){ //if cash payments
                    $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 3, //14 AC Receivable GL
                                                    'account_code' => 1200, 
                                                    'memo' => '',
                                                    'amount' => (-$total),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                    $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 1, //1 petty cash
                                                    'account_code' => 1060,
                                                    'memo' => '',
                                                    'amount' => (+$total),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                }
            
//            echo '<pre>';            print_r($total); die;
//            echo '<pre>';            print_r($data); die;
                    
		$add_stat = $this->Sales_pos_model->add_db($data);
                
		if($add_stat[0]){  
                    $this->cancel_temp_invoice(); //remove open current Tem Invoice;
//                    $this->pos_print_direct($add_stat[1]);
                    $new_data = $this->Sales_pos_model->get_single_row($add_stat[1]);
                    add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    $this->session->set_flashdata('prn_id',$add_stat[1]);
                    redirect(base_url($this->router->fetch_class().'/add/')); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class().'/add/')); 
                } 
	}
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0,$calc='-'){ //updatiuon for item_stock table
            $this->load->model('Item_stock_model');
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
            }else{
                if($calc=='+'){
                    $available_units = $stock_det['units_available'] + $units;
                    $available_units_2 = $stock_det['units_available_2'] + $units_2;
                }else{
                    
                    $available_units = $stock_det['units_available'] - $units;
                    $available_units_2 = $stock_det['units_available_2'] - $units_2;
                }
            }
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_available'=>$available_units,'new_units_available_2'=>$available_units_2);
                
            return $update_arr;
        }
        
	function update(){ 
            $inputs = $this->input->post();
            $agent_id = $inputs['id']; 
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data = array(
                            'vehicle_id' => $inputs['vehicle_id'], 
                            'description' => $inputs['description'], 
                            'rate_amount' => $inputs['rate_amount'], 
                            'owner_rate_plan' => $inputs['owner_rate_plan'], 
                            'owner_rate' => $inputs['owner_rate'], 
                            'km_limit_day' => $inputs['km_limit_day'], 
                            'extra_km_rate' => $inputs['extra_km_rate'], 
                            'extra_time_rate' => $inputs['extra_time_rate'], 
                            'status' => $inputs['status'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
            
//            echo '<pre>'; print_r($data); die;
            //old data for log update
            $existing_data = $this->Sales_pos_model->get_single_row($inputs['id']);

            $edit_stat = $this->Sales_pos_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Sales_pos_model->get_single_row($inputs['id']);
                add_system_log(VEHICLE_RATES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
//            echo '<pre>';            print_r($this->input->post()); die;
            $this->load->model('Item_stock_model');
            $inputs = $this->input->post(); 
            //check the payments before delete reservation
//            $this->load->model('Payments_model');
//            $data['inv_transection'] = $this->Payments_model->get_transections(10,$inputs['id']); //10 for customer
//            if(!empty($trans_data)){
//                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
//                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
//                return false;
//            }
            $data['tbl_data'] = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            
            $si_stock_trans = $this->Item_stock_model->get_stock_transection($inputs['id'],'transection_type = 2'); //30 for Sales returm or credit Notes
            
            foreach ($si_stock_trans as $cn_stock){
                
                if($cn_stock['uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],$cn_stock['uom_id_2'],$cn_stock['units_2'],'+');
                else
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],'','','+');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
            }
            $existing_data = $this->Sales_pos_model->get_single_row($inputs['id']);  
            $delete_stat = $this->Sales_pos_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Sales_pos_model->get_single_row($inputs['id']);
            if($this->Sales_pos_model->delete2_db($id)){
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
                $data['user_data'] = $this->Sales_pos_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            } 
            
//            $data['customer_type_list'] = array(1=>'Regular',2=>'Gold',3=>'Silver');
            $data['customer_type_list'] = get_dropdown_data(CUSTOMER_TYPE, 'customer_type_name', 'id','','show_pos = 1');
            $data['customer_list'] = get_dropdown_data(CUSTOMERS, 'customer_name', 'id','Customers');
            $data['customer_list2'] = get_dropdown_data(CUSTOMERS, 'short_name', 'id');
            $data['customer_branch_list'] = array();
//            $data['price_type_list'] = array(16=>'Whole Sale',15=>'Retail');
            $data['price_type_list'] = get_dropdown_data(DROPDOWN_LIST, 'dropdown_value', 'id','','dropdown_id = 14');
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); //14 for sales type
//            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code','item_type_id!=4'); 
            $data['item_list'] = $this->get_availale_items_dropdown(); 
            $data['item_data'] = $this->get_all_available_items(); 
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','Item Category');
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');  
            
            $data['item_categories'] = $this->Sales_pos_model->item_categories('','show_pos = 1');
            $data['sales_vouchers'] = $this->Sales_pos_model->get_vouchers();
            
            $data['treatments_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Treatment','dropdown_id = 5'); //14 for treatments
            $data['shape_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Shape','dropdown_id = 16'); //16 for Shape
            $data['color_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Color','dropdown_id = 17'); //17 for Color
            
            
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code',''); 
            return $data;
	}	
        
        
        function get_availale_items_dropdown(){
            $this->load->model('Items_model');
            $itms = $this->Items_model->get_available_items('',SELECT2_ROWS_LOAD);
            $drop_down_data = array();
            if(!empty($itms)){
                foreach ($itms as $itm){
                    $drop_down_data[$itm['item_code']] = $itm['item_name'];
                }
            }
            return $drop_down_data;
        }
                
        function search(){ 
            $input = $this->input->post();
            $search_data=array( 
                                'invoice_no' => $this->input->post('invoice_no'),
                                'customer_id' => $input['customer_id'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $invoices['search_list'] = $this->Sales_pos_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Sales_pos_model->search_result();
            $this->load->view('sales_invoices/search_sales_invoices_result',$invoices);
	}
        
        function get_single_item(){
            $this->load->model('Item_stock_model');
            $inputs = $this->input->post(); 
            $data = $this->Sales_pos_model->get_single_item($inputs['item_code'],$inputs['price_type_id']); 
            $data['stock'] = $this->Item_stock_model->get_stock_by_code($inputs['item_code'],'');
//            echo '<pre>';            print_r($data); die;
            echo json_encode($data);
        }
        
        
        function get_all_available_items(){
            $this->load->model('Item_stock_model');
            $this->load->model('Items_model');
            $itms = $this->Items_model->get_available_items('',SELECT2_ROWS_LOAD);
//            echo '<pre>';            print_r($itms); die;
            $data_itms = array();
            foreach ($itms as $itm){
                $data_itms[$itm['item_code']] = $this->Sales_pos_model->get_single_item($itm['item_code'],15);
                $data_itms[$itm['item_code']]['stock'] = $this->Item_stock_model->get_stock_by_code($itm['item_code'],'');
            }  
            return $data_itms;  
        }
        
        function sales_invoice_print($inv_id){
//            echo '<pre>';            print_r($this->get_invoice_info(2)); die;
            $inv_data = $this->get_invoice_info($inv_id);
            $inv_dets = $inv_data['invoice_dets'];
            $inv_desc = $inv_data['invoice_desc'];
            $inv_trans = $inv_data['inv_transection'];
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            
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
                            <td>Invoiced Date: '.date('m/d/Y',$inv_dets['invoice_date']).'</td>
                            <td align="right">Invoiced by: '.$inv_dets['sales_person'].'</td>
                        </tr>
                        <tr> 
                            <td colspan="2" align="center"><h1>INVOICE</h1></td>
                        </tr> 
                        <tr>
                            <td><b>Bill To:</b> </td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td>'.$inv_dets['customer_name'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td>'.$inv_dets['address'].' '.$inv_dets['city'].', <br>'.$inv_dets['phone'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr><td  colspan="5"><br></td></tr>
                    </table> 
                ';
           
//            echo '<pre>';            print_r($inv_data); die;
            foreach ($inv_desc as $inv_itms){ 
                     $html .= '<table id="example1" class="table-line" border="0">
                                <thead>
                                    <tr class="colored_bg" style="background-color:#E0E0E0;">
                                         <th colspan="5">'.$inv_data['item_cats'][$inv_itms[0]['item_category']].'</th> 
                                     </tr>
                                    <tr style="">
                                         <th width="15%" style="text-align: left;"><u><b>NL No</b></u></th>  
                                         <th width="40%" style="text-align: left;"><u><b>Description</b></u></th> 
                                         <th  width="10%"><u><b>Qty</b></u></th>  
                                         <th width="15%" style="text-align: right;"><u><b>Rate</b></u></th>  
                                         <th width="19%" style="text-align: right;"><u><b>Total</b></u></th> 
                                     </tr>
                                </thead>
                            <tbody>';
                     
                     foreach ($inv_itms as $inv_itm){
//                         $item_info = $this->Items_model->get_single_row($inv_itm['id'])[0];
//                                     echo '<pre>';            print_r($inv_itm); die;

                         $html .= '<tr>
                                        <td width="15%" style="text-align: left;">'.$inv_itm['item_code'].'</td> 
                                        <td width="40%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                                        <td width="10%">'.$inv_itm['item_quantity'].'</td>  
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['unit_price'],2).'</td> 
                                         <td width="19%" style="text-align: right;">'. number_format($inv_itm['sub_total'],2).'</td> 
                                    </tr> ';
                     }
                     $html .= '
                                <tr><td  colspan="5"></td></tr></tbody></table>'; 
            }
            $html .= '
                    
                    <table id="example1" class="table-line" border="0">
                        
                       <tbody>

                                <tr class="td_ht">
                                    <td style="text-align: right;" colspan="4"><b> Total</b></td> 
                                    <td  width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_desc_total'],2).'</b></td> 
                                </tr>'; 
//            echo '<pre>';            print_r($inv_trans); die;
                        foreach ($inv_trans as $inv_tran){
                            $html .= '<tr>
                                            <td  style="text-align: right;" colspan="4">'.$inv_tran['trans_type_name'].(($inv_tran['payment_method']!='')?' ['.$inv_tran['payment_method'].']':'').'</td> 
                                            <td  width="19%"  style="text-align: right;">'. number_format($inv_tran['transection_amount'],2).'</td> 
                                        </tr> ';

                        }
                        $html .= '
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
                        line-height: 20px;
                    }
                    </style>';
            $pdf->writeHTML($html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);           
            $pdf->Text(160,20,$inv_dets['invoice_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output('Sales_invoice_'.$inv_id.'.pdf', 'I');
                
        }
        
        function get_invoice_info($inv_id){
            $this->load->model('Items_model');  
            if($inv_id!=''){
                 $data['invoice_dets'] = $this->Sales_pos_model->get_single_row($inv_id); //10 fro sale invoice
                if(empty($data['invoice_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['invoice_desc'] = array();
            $invoice_desc = $this->Sales_pos_model->get_invc_desc($inv_id);
//                    echo '<pre>';                    print_r($invoice_desc); die;
            $data['invoice_desc_list'] = $invoice_desc;
            
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
            
            $data['invoice_desc_total']= 0;
            foreach ($item_cats as $cat_key=>$cay_name){
//                    echo '<pre>';                    print_r($invoice_desc); die;
                foreach ($invoice_desc as $invoice_itm){
                    $item_info = $this->Items_model->get_single_row($invoice_itm['item_id'])[0];
                    $invoice_itm['item_code']=$item_info['item_code'];
                    if($invoice_itm['item_category']==$cat_key){
                        $data['invoice_desc'][$cat_key][]=$invoice_itm;
                        $data['invoice_desc_total'] +=  $invoice_itm['sub_total'];
                    }
                }
            }
            $data['invoice_total'] = $data['invoice_desc_total'];
            $data['transection_total']=0;
            $this->load->model('Payments_model');
            $data['inv_transection'] = $this->Payments_model->get_transections(10,$inv_id); //10 for customer
//            echo '<pre>';            print_r(  $data['inv_transection']); die;
           
            foreach ($data['inv_transection'] as $trans){
                switch ($trans['calculation']){
                    case 1: //  addition from invoive
                            $data['transection_total'] += $trans['transection_ref_amount'];
                            $data['invoice_total'] += $trans['transection_ref_amount'];
                            break;
                    case 2: //substitute from invoiice
                            $data['transection_total'] -= $trans['transection_ref_amount'];
                            $data['invoice_total'] -= $trans['transection_ref_amount'];
                            break;
                    case 4: //settlement cust
                            $data['transection_total'] += $trans['transection_ref_amount'];
                            $data['invoice_total'] += $trans['transection_ref_amount'];
                            break;
                    default:
                            break;
                }
            }
            
            //addons
            $invoice_addons = $this->Sales_pos_model->get_invoice_addons($inv_id);
            return $data;
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
        function get_category_info(){ 
                $inputs = $this->input->post(); 
                $this->load->model('Item_categories_model');
                $res = $this->Item_categories_model->get_single_row($inputs['item_cat_id']);
                if(!empty($res)){
                    echo json_encode($res[0]); 
                }else{
                    echo 0;
                } 
        }
        function get_return_refund(){ 
                $inputs = $this->input->post(); 
                $res = $this->Sales_pos_model->get_creditnote($inputs['pos_return_note_no'],'i.invoice_type = 10');
                if(!empty($res)){
//                    echo json_encode($res[0]);
                    echo number_format($res[0]['cn_amount'],2,'.','');
                }else{
                    echo 0;
                }
//                echo '<pre>';            print_r($data); die;
        }
        function get_item_search_modal(){ 
                $inputs = $this->input->post();
//                echo '<pre>';            print_r($inputs); die;
                $this->load->model('Items_model');
                $cat_qry_str = ($inputs['item_cat_id']!='')?"itm.item_category_id = ".$inputs['item_cat_id']." AND ":'';
                $cat_qry_str .= ($inputs['treatment_id']!='')?"itm.treatment = ".$inputs['treatment_id']." AND ":'';
                $cat_qry_str .= ($inputs['color_id']!='')?"itm.color = ".$inputs['color_id']." AND ":'';
                $cat_qry_str .= ($inputs['shape_id']!='')?"itm.shape = ".$inputs['shape_id']." AND ":'';
//                $item_res = $this->Items_model->get_available_items("itm.item_category_id = ".$inputs['item_cat_id']." AND itm.item_code like '%".$inputs['item_code']."%' AND itm.item_name LIKE '%".$inputs['item_desc']."'%");
                $data['item_res'] = $this->Items_model->get_available_items($cat_qry_str."itm.item_code like '%".$inputs['item_code']."%'  AND itm.item_name like '%".$inputs['item_desc']."%'",SELECT2_ROWS_LOAD);
                
                $this->load->view('sales_pos/pos_pop_modals/item_search_modal_result',$data);
//                echo '<pre>';            print_r($data); die;
        }
        
        function get_item_price_check_modal(){ 
                $inputs = $this->input->post();
//                echo '<pre>';            print_r($inputs); die; 
                $data['item_res'] = $this->Sales_pos_model->search_item_pric_check($inputs); 
                $this->load->view('sales_pos/pos_pop_modals/price_check_modal_result',$data); 
        }
        function get_stock_check_modal(){ 
                $inputs = $this->input->post();
                $data['item_res'] = $this->Sales_pos_model->search_item_stock_check($inputs); 
                $this->load->view('sales_pos/pos_pop_modals/show_stock_modal_result',$data); 
        }
        function get_recall_reserve_modal(){ //search resrved
                $inputs = $this->input->post();
                $where = ($inputs['recl_cust_id']!='')?'it.customer_id = '.$inputs['recl_cust_id']:'';
                $data['item_res'] = $this->Sales_pos_model->get_temp_invoice_reserved($inputs['recl_res_no'],$where); 
                $this->load->view('sales_pos/pos_pop_modals/recall_reserve_modal_result',$data); 
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
        
        
        function set_temp_invoice(){
            $inputs = $this->input->post();
            
            unset($inputs['function_name']);       
                    
            $temp_invoice_open = $this->Sales_pos_model->get_temp_invoice_open($this->session->userdata(SYSTEM_CODE)['ID']);
            $json_data=$json_trans_data=null;
            if(isset($inputs['inv_items'])){
                $json_data = json_encode($inputs['inv_items'],true);
            }
            if(isset($inputs['trans'])){
                $json_trans_data = json_encode($inputs['trans'],true);
            }
//                echo '<pre>';            print_r($temp_invoice_open); die;
            if(empty($temp_invoice_open)){
                
                $temp_invoice_id = get_autoincrement_no(INVOICES_TEMP);
                $temp_invoice_no = gen_id(TEMP_INVOICE_NO_PREFIX, INVOICES_TEMP, 'id');
//                        print_r($json_trans_data); die;
                $insert_data =  array(
                                        'id'   => $temp_invoice_id,
                                        'user_id'  => $this->session->userdata(SYSTEM_CODE)['ID'],
                                        'temp_invoice_no'   => $temp_invoice_no,
                                        'customer_id'   => $inputs['customer_id'],
                                        'item_data'   => $json_data, 
                                        'temp_invoice_status'   => 0,
                                        'status'   => 1,
                                        'added_on' => date('Y-m-d'),
                                        'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                        );
                    
                $this->Sales_pos_model->insert_temp_invoice_item($insert_data);
            }else{
                $update_data = array('item_data' => $json_data,
                                    'customer_id'   => $inputs['customer_id'],
                                    'payments'   => $json_trans_data);
                $this->Sales_pos_model->update_temp_invoice_item($update_data);
            }

                    
        }
         function get_temp_invoice_data($temp_inv_id=''){ 
             $this->load->model('Item_stock_model');
            $temp_invoice_open = $this->Sales_pos_model->get_temp_invoice_open($this->session->userdata(SYSTEM_CODE)['ID']);
            $temp_invoice_open_itms = (isset($temp_invoice_open['item_data'])?$temp_invoice_open['item_data']:'');
            $data=array();
            if($temp_invoice_open_itms!=""){
                $temp_inv = json_decode($temp_invoice_open_itms,true);
                foreach ($temp_inv as $key=>$temp_inv1){
                    $data[$key] = $temp_inv1;
//                    $data['inv_tot'] = $temp_inv1;
                    $data[$key]['stock']= $this->Item_stock_model->get_stock_by_code($temp_inv1['item_code'],'');
                    
                }
            } 
            $fin_data['items'] = $data;
            $fin_data['open_temp_data'] = $temp_invoice_open;
            echo json_encode($fin_data);
//            echo '<pre>';            print_r(json_decode($temp_invoice_open)); die;
//            return $list_data_jsn;
            
        }
         function cancel_temp_invoice($temp_inv_id=''){  
            $temp_invoice_remove = $this->Sales_pos_model->delete_temp_invoice_item(); 
            if($temp_invoice_remove>0){ 
                $this->session->set_flashdata('warn',"Cancellation Success"); 
            }else{
                $this->session->set_flashdata('error',"No active invoice found for cancel");  
            } 
                echo $temp_invoice_remove;
        }
         function pause_temp_invoice(){
            $inputs = $this->input->post();
            
            $temp_invoice_remove = $this->Sales_pos_model->update_temp_invoice_item(array('temp_invoice_status'=>1)); 
            if($temp_invoice_remove>0){ 
                $this->session->set_flashdata('warn',"Invoice successfuly added to Hold List"); 
            }else{
                $this->session->set_flashdata('error',"No active invoice found for cancel");  
            } 
                echo $temp_invoice_remove;
        }
         function reserve_temp_invoice(){
            $inputs = $this->input->post();
            
                $temp_invoice_open = $this->Sales_pos_model->get_temp_invoice_open($this->session->userdata(SYSTEM_CODE)['ID']);
//                echo '<pre>';                print_r($temp_invoice_open); die;
                if(!empty($temp_invoice_open)) {
                    $inv_items = json_decode($temp_invoice_open['item_data'],true);
                    foreach ($inv_items as $inv_item){ 
                        $stock_update_data = array( //se resrve status
                                                'location_id'=>$inputs['location_id'],
                                                'item_id'=>$inv_item['item_id'], 
                                                'units_on_reserve'=>$inv_item['item_quantity'],
                                                'units_on_reserve_2'=>$inv_item['item_quantity_2'], 
                                                );  
                            $data['item_stock'][] = $stock_update_data;
                    }
                }
            $temp_invoice_remove = $this->Sales_pos_model->update_temp_invoice_item(array('temp_invoice_status'=>2)); 
            if($temp_invoice_remove>0){
                $temp_stock_updation = $this->Sales_pos_model->update_stock_reserve($data); 
                $this->session->set_flashdata('warn',"Invoice successfuly added to Reserved List"); 
            }else{
                $this->session->set_flashdata('error',"No active invoice found for reserve");  
            }
                echo $temp_invoice_remove;
        }
         function recall_reserve_temp_invoice($id){
             $this->load->model('Item_stock_model');
            $inputs = $this->input->post();
            $tmp_inv_id = $inputs['tmp_invoice_id'];
            
            $this->Sales_pos_model->update_temp_invoice_item(array('temp_invoice_status'=>1)); //set all temp invoice to hold
            $temp_invoice_update = $this->Sales_pos_model->update_temp_invoice_item(array('temp_invoice_status'=>0),'id = '.$tmp_inv_id); 
           
//            echo '<pre>';            print_r($inputs); die;
                $temp_invoice_open = $this->Sales_pos_model->get_temp_invoice_open($this->session->userdata(SYSTEM_CODE)['ID']);
                if(!empty($temp_invoice_open)) {
                    $inv_items = json_decode($temp_invoice_open['item_data'],true);
                    foreach ($inv_items as $inv_item){ 
                        $item_stock1 = $this->Item_stock_model->get_stock($inputs['location_id'],$inv_item['item_id'])[0];
                        
                        $stock_update_data = array( //se resrve status
                                                'location_id'=>$inputs['location_id'],
                                                'item_id'=>$inv_item['item_id'], 
                                                'units_on_reserve'=>$item_stock1['units_on_reserve'] - $inv_item['item_quantity'],
                                                'units_on_reserve_2'=>$item_stock1['units_on_reserve_2'] - $inv_item['item_quantity_2'], 
                                                );  
                            $data['item_stock'][] = $stock_update_data;
                    }
                }
            if($temp_invoice_update>0){ 
                $temp_stock_updation = $this->Sales_pos_model->update_stock_reserve($data); 
                $this->session->set_flashdata('warn',"Hold Invoice Recalled Succuess."); 
            }else{
                $this->session->set_flashdata('error',"Something went wrong; Please Retry.");  
            } 
                echo $temp_invoice_update;
        }
         function load_temp_invoice(){
            $tmp_inv_id = $this->input->post('tmp_invoice_id');
//            echo $tmp_inv_id; die;
            $this->Sales_pos_model->update_temp_invoice_item(array('temp_invoice_status'=>1)); //set all temp invoice to hold
            $temp_invoice_update = $this->Sales_pos_model->update_temp_invoice_item(array('temp_invoice_status'=>0),'id = '.$tmp_inv_id); 
            if($temp_invoice_update>0){ 
                $this->session->set_flashdata('warn',"Hold Invoice Recalled Succuess."); 
            }else{
                $this->session->set_flashdata('error',"Something went wrong; Please Retry.");  
            } 
                echo $temp_invoice_update;
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
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
            echo json_encode($res);
        }
        function get_single_branch_info(){
                $branch_id = $this->input->post('branch_id');
                $this->db->select("cb.*");	
                $this->db->select("(select commission_value from ".CUSTOMERS." where id = cb.customer_id) as cust_discount");	
                $this->db->select("(select commision_plan from ".CUSTOMERS." where id = cb.customer_id) as cust_discount_plan");	
                $this->db->from(CUSTOMER_BRANCHES." cb");	 
                $this->db->where('cb.deleted',0);
                if($branch_id > 0){
                    $this->db->where('cb.id',$branch_id);  
                }                       
                
                $res = $this->db->get()->result_array();
                $dropdown_data=array();
                    
//                echo '<pre>';                print_r($res); die;
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
                echo json_encode($res[0]);
        }
        
        function get_customer_addons(){
            
            //addon calculation
            $inputs = $this->input->post();
            $customer_id = (isset($inputs['customer_id'])?$inputs['customer_id']:'');
            $addons_infos = array();
            if($customer_id!=''){
                $customer_info = $this->Sales_pos_model->get_customer_info($customer_id);
                if($customer_info['addons_included']!=''){
                    $addon_ids = json_decode($customer_info['addons_included']);
                    foreach ($addon_ids as $addon_id){
                        $res2 = $this->Sales_pos_model->get_addon_info($addon_id);
                        if(!empty($res2)){
                            $addons_infos[] = $res2;
                        }
                    } 
                }
            }
            echo json_encode($addons_infos); 
        }
        
        function get_availale_items_dropdown_json(){
            $inputs = $this->input->post();
            $this->load->model('Items_model');
            $itms = $this->Items_model->get_available_items("itm.item_name like '%".$inputs['item_search_txt']."%' OR itm.item_code like '%".$inputs['item_search_txt']."%'",(isset($inputs['item_lmit'])?$inputs['item_lmit']:''),SELECT2_ROWS_LOAD);
            $drop_down_data = array();
            if(!empty($itms)){
                foreach ($itms as $itm){
                    $drop_down_data[$itm['item_code']] = $itm['item_name'];
                }
            } 
            if(!empty($drop_down_data)){
                echo json_encode($drop_down_data);
            }else{
                echo 0;
            }
        }
        function test(){
            
            $this->load->helper('print_helper');
            fl_direct_print_test(1); die;
//            $this->pos_print_direct(25); die;
//            $this->load->helper('cookie'); 
//            $cookie= array(
//                            'name'   => 'fahry',
//                            'value'  => 'This is Demonstration of how to set cookie in CI',
//                            'expire' => '3600',
//                   );
 
//       $this->input->set_cookie($cookie);
//       delete_cookie('faget');
//  echo $this->input->cookie('fahry',true);
//       echo "Congragulatio Cookie Set";
            echo '<pre>';            print_r($_COOKIE); die;
//            echo '<pre>';            print_r($this->input->cookie('sale_inv_list',true)); die;
            
//            $this->load->view('sales_invoices/sales_invoices');
//            $data = $this->Sales_pos_model->get_single_item(1002,15);
//            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
}
