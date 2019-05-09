<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoices extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Sales_invoices_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='sales_invoices/search_sales_invoices'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id','Customers','customer_type_id = 1');
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data();  
            if(isset($_GET['soid'])){ //data from sale order
                $this->load->model('Sales_orders_model');
                $so_data = $this->get_salesorder_info($_GET['soid']);
                $data['so_data'] = $so_data['order_dets']; 
                $data['so_order_items'] = $so_data['order_desc']; 
                $data['og_data'] = $so_data['so_og_info']; 
                $data['so_transection_pay'] = $so_data['so_transection_pay']; 
            }
            
            $data['action']		= 'Add';
            $data['main_content']='sales_invoices/manage_sales_invoices';  
//            echo '<pre>';            print_r($data); die;  
            $this->load->view('includes/template',$data);
	}
	function add_from_order(){ 
            $data  			= $this->load_data();  
            if(isset($_GET['soid'])){ //data from sale order
                $this->load->model('Sales_orders_model');
                $so_data = $this->get_salesorder_info($_GET['soid']);
                $data['so_data'] = $so_data['order_dets']; 
                $data['so_order_items'] = $so_data['order_desc']; 
                $data['og_data'] = $so_data['so_og_info']; 
                $data['so_transection_pay'] = $so_data['so_transection_pay']; 
            }
            
            $data['action']		= 'Add';
            $data['main_content']='sales_invoices/manage_sales_invoices_gen';  
//            echo '<pre>';            print_r($data); die;  
            $this->load->view('includes/template',$data);
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
//            echo '<pre>';            print_r($data['inv_data']['inv_transection']); die;
            $this->load->view('includes/template',$data);
	}
	
        
	function validate(){   
//            echo '<pre>';            print_r($this->input->post()); die;
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
                        
            $inputs = $this->input->post();
                            if((isset($inputs['so_gen_type']) && $inputs['so_gen_type'] == 'regular'))
                                $this->createfrom_order();
                            else
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
            
            $invoice_id = get_autoincrement_no(INVOICES);
            $invoice_no = gen_id(INVOICE_NO_PREFIX, INVOICES, 'id');
            
            $cur_det = $this->Sales_invoices_model->get_currency_for_code($inputs['currency_code']);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['inv_tbl'] = array(
                                    'id' => $invoice_id,
                                    'invoice_no' => $invoice_no,
                                    'customer_id' => $inputs['customer_id'], 
                                    'invoice_type_id' => 1, //direct
                                    'reference' => $inputs['customer_reference'],  
                                    'comments' => $inputs['memo'], 
                                    'invoice_date' => strtotime($inputs['invoice_date']), 
                                    'invoiced' => 1,   
                                    'so_id' => $inputs['so_id'],   
                                    'sales_type_id' => $inputs['sales_type_id'], 
                                    'payement_term_id' => $inputs['payment_term_id'], 
                                    'currency_code' => $inputs['currency_code'], 
                                    'currency_value' => $cur_det['value'], 
                                    'location_id' => $inputs['location_id'],
                                    'payment_settled' => 0,
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            if($this->session->userdata(SYSTEM_CODE)['user_group_id']!=0){
                $data['inv_tbl']['inv_group_id'] = $this->session->userdata(SYSTEM_CODE)['user_group_id'];
            }
            
            
            $data['inv_desc'] = array(); 
            $data['gl_trans'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection 
            $data['transection'] = array(); //payments transection 
            
            $total_stnd = $total = 0;
            foreach ($inputs['inv_items'] as $inv_item){
                $standard_price_info = $this->Sales_invoices_model->get_item_standard_prices($inv_item['item_id']);
                $standard_price = (!empty($standard_price_info))?$standard_price_info[0]['price_amount']:'';
           
                //convert to invoice currency 
                $standard_price = ($standard_price/$standard_price_info[0]['currency_value'])*$cur_det['value'];
//            echo '<pre>';            print_r($standard_price); die;
                $total += $inv_item['item_quantity']*$inv_item['item_unit_cost']*(100-$inv_item['item_line_discount'])*0.01;
                $item_total = $total; 
                $total_stnd += $inv_item['item_quantity']*$standard_price;
                $data['inv_desc'][] = array(
                                            'invoice_id' => $invoice_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_description' => $inv_item['item_desc'],
                                            'item_quantity' => $inv_item['item_quantity'],
                                            'item_quantity_uom_id' => $inv_item['item_quantity_uom_id'],
                                            'item_quantity_2' => $inv_item['item_quantity_2'],
                                            'item_quantity_uom_id_2' => $inv_item['item_quantity_uom_id_2'],
                                            'unit_price' => $inv_item['item_unit_cost'],
                                            'discount_persent' => $inv_item['item_line_discount'],
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
                    $data['item_stock'][] = $item_stock_data;
                }
                 
                $data['so_desc_tbl'][] = array('new_item_id'=>$inv_item['item_id'],'invoiced'=>1);
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
                                                       'amount' => (-abs($addon)),
                                                       'currency_code' => $cur_det['code'], 
                                                       'currency_value' => $cur_det['value'], 
                                                       'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                       'status' => 1,
                                               );
                }
            }
            $total += $addons_total; 
            
            $data['so_ref'] = $inputs['so_id'];
            if($inputs['so_id']!=''){
                $data['inv_tbl']['invoice_type_id'] = 2; 
                $data['gl_trans'][] = array(
                                               'person_type' => 10,
                                               'person_id' => $inputs['customer_id'],
                                               'trans_ref' => $invoice_id,
                                               'trans_date' => strtotime("now"),
                                               'account' => 5, //5 inventory GL
                                               'account_code' => 1510, //5 inventory GL
                                               'memo' => 'SO to Invoice',
                                               'amount' => (-$total_stnd), 
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
                                               'account' => 75, //75 workshop asset
                                               'account_code' => 1210, 
                                               'memo' => 'SO to Invoice',
                                               'amount' => ($total_stnd),
                                               'currency_code' => $cur_det['code'], 
                                               'currency_value' => $cur_det['value'], 
                                               'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                               'status' => 1,
                                       );
//                    $data['inv_tbl']['payment_settled']=1;
//                    $tot_available_for_invoice = $this->SO_invoice_gen_check($inputs['so_id'])['available_amount'];  
//                    if($total>$tot_available_for_invoice){ 
//                            $this->session->set_flashdata('error',"insufficient Order Payment for complete this invoice; Please Add Payment to Order");
//                            redirect(base_url($this->router->fetch_class().'/add/?soid='.$inputs['so_id']));
//                            die;
//                    }
            }else{
                //payments
                $this->load->model('Payments_model');
                $payment_terms = $this->Payments_model->get_payment_term($inputs['payment_term_id']);
                if($payment_terms['payment_done']==1){ //cash payment for invoice 
                    $trans_id = get_autoincrement_no(TRANSECTION);
                    $data['payment_transection'] = array(
                                                    'id' =>$trans_id,
                                                    'transection_type_id' =>1, //1 for customer payments
                                                    'reference' =>'', 
                                                    'person_type' =>10, //10 for customer 
                                                    'person_id' =>$inputs['customer_id'],
                                                    'transection_amount' =>$total,
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'],
                                                    'trans_date' => strtotime($inputs['invoice_date']),
                                                    'trans_memo' => 'Cash Invoice',
                                                    'status' => 1,
                                                );

                    $data['payment_transection_ref'] = array(
                                                    'transection_id' =>$trans_id,
                                                    'reference_id' =>$invoice_id,
                                                    'trans_reference' =>$invoice_no,
                                                    'transection_ref_amount' =>$total, 
                                                    'person_type' =>10, //10 for customer 
                                                    'status' =>1, 
                                                );

                    $data['inv_tbl']['payment_settled']=1;

                }


                $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 5, //5 inventory GL
                                                    'account_code' => 1510, //5 inventory GL
                                                    'memo' => '',
                                                    'amount' => (-$total_stnd),
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
                                                    'account' => 43, //43 COGS id
                                                    'account_code' => 5010, //COGS GL
                                                    'memo' => '',
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
                                                    'account' => 37, //37  SALES GL
                                                    'account_code' => 4010, 
                                                    'memo' => '',
                                                    'amount' => (-$item_total),
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
                                                    'memo' => '',
                                                    'amount' => (+$item_total),
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
                                                    'account' => 1, //1  cash
                                                    'account_code' => 1060,
                                                    'memo' => '',
                                                    'amount' => (+$total),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                }
            }
                  
//            echo '<pre>';            print_r($tot_available_for_invoice);  
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Sales_invoices_model->add_db($data);
                
		if($add_stat[0]){  
//                    delete_cookie('sale_inv_list');
                    //update log data
                    $new_data = $this->Sales_invoices_model->get_single_row($add_stat[1]);
                    add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class().'/view/'.$invoice_id)); 
                }else{
                    $this->session->set_flashdata('error',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	function createfrom_order(){
            $inputs = $this->input->post();
            
            $invoice_id = get_autoincrement_no(INVOICES);
            $invoice_no = gen_id(INVOICE_NO_PREFIX, INVOICES, 'id');
            
            $cur_det = $this->Sales_invoices_model->get_currency_for_code($inputs['currency_code']);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['inv_tbl'] = array(
                                    'id' => $invoice_id,
                                    'invoice_no' => $invoice_no,
                                    'customer_id' => $inputs['customer_id'], 
                                    'invoice_type_id' => 1, //direct
                                    'reference' => $inputs['customer_reference'],  
                                    'comments' => $inputs['memo'], 
                                    'invoice_date' => strtotime($inputs['invoice_date']), 
                                    'invoiced' => 1,   
                                    'so_id' => $inputs['so_id'],   
                                    'sales_type_id' => $inputs['sales_type_id'], 
                                    'payement_term_id' => $inputs['payment_term_id'], 
                                    'currency_code' => $inputs['currency_code'], 
                                    'currency_value' => $cur_det['value'], 
                                    'location_id' => $inputs['location_id'],
                                    'payment_settled' => 0,
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            if($this->session->userdata(SYSTEM_CODE)['user_group_id']!=0){
                $data['inv_tbl']['inv_group_id'] = $this->session->userdata(SYSTEM_CODE)['user_group_id'];
            }
            
            
            $data['inv_desc'] = array(); 
            $data['gl_trans'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection 
            $data['transection'] = array(); //payments transection 
            
            $total_stnd = $total = 0;
            foreach ($inputs['inv_items'] as $inv_item){
                $standard_price_info = $this->Sales_invoices_model->get_item_standard_prices($inv_item['item_id']);
                $standard_price = (!empty($standard_price_info))?$standard_price_info[0]['price_amount']:'';
           
                //convert to invoice currency 
                $standard_price = ($standard_price/$standard_price_info[0]['currency_value'])*$cur_det['value'];
//            echo '<pre>';            print_r($standard_price); die;
                $total += $inv_item['item_quantity']*$inv_item['item_unit_cost']*(100-$inv_item['item_line_discount'])*0.01;
                $item_total = $total; 
                $total_stnd += $inv_item['item_quantity']*$standard_price;
                $data['inv_desc'][] = array(
                                            'invoice_id' => $invoice_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_description' => $inv_item['item_desc'],
                                            'item_quantity' => $inv_item['item_quantity'],
                                            'item_quantity_uom_id' => $inv_item['item_quantity_uom_id'],
                                            'item_quantity_2' => $inv_item['item_quantity_2'],
                                            'item_quantity_uom_id_2' => $inv_item['item_quantity_uom_id_2'],
                                            'unit_price' => $inv_item['item_unit_cost'],
                                            'discount_persent' => $inv_item['item_line_discount'],
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
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2'],'-',1);
                else
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],'',0,'-',1);
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                 
                $data['so_desc_tbl'][] = array('new_item_id'=>$inv_item['item_id'],'invoiced'=>1);
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
                                                       'amount' => (-abs($addon)),
                                                       'currency_code' => $cur_det['code'], 
                                                       'currency_value' => $cur_det['value'], 
                                                       'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                       'status' => 1,
                                               );
                }
            }
            $total += $addons_total; 
            
            $data['so_ref'] = $inputs['so_id'];
            if($inputs['so_id']!=''){
                if(isset($inputs['so_gen_type'])=='regular') $data['gen_type'] = 'regular'; 
                $data['inv_tbl']['invoice_type_id'] = 2; 
            }
                //payments
                $this->load->model('Payments_model');
                $payment_terms = $this->Payments_model->get_payment_term($inputs['payment_term_id']);
                if($payment_terms['payment_done']==1){ //cash payment for invoice 
                    $trans_id = get_autoincrement_no(TRANSECTION);
                    $data['payment_transection'] = array(
                                                    'id' =>$trans_id,
                                                    'transection_type_id' =>1, //1 for customer payments
                                                    'reference' =>'', 
                                                    'person_type' =>10, //10 for customer 
                                                    'person_id' =>$inputs['customer_id'],
                                                    'transection_amount' =>$total,
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'],
                                                    'trans_date' => strtotime($inputs['invoice_date']),
                                                    'trans_memo' => 'Cash Invoice',
                                                    'status' => 1,
                                                );

                    $data['payment_transection_ref'] = array(
                                                    'transection_id' =>$trans_id,
                                                    'reference_id' =>$invoice_id,
                                                    'trans_reference' =>$invoice_no,
                                                    'transection_ref_amount' =>$total, 
                                                    'person_type' =>10, //10 for customer 
                                                    'status' =>1, 
                                                );

                    $data['inv_tbl']['payment_settled']=1;

                }


                $data['gl_trans'][] = array(
                                                    'person_type' => 10,
                                                    'person_id' => $inputs['customer_id'],
                                                    'trans_ref' => $invoice_id,
                                                    'trans_date' => strtotime("now"),
                                                    'account' => 5, //5 inventory GL
                                                    'account_code' => 1510, //5 inventory GL
                                                    'memo' => '',
                                                    'amount' => (-$total_stnd),
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
                                                    'account' => 43, //43 COGS id
                                                    'account_code' => 5010, //COGS GL
                                                    'memo' => '',
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
                                                    'account' => 37, //37  SALES GL
                                                    'account_code' => 4010, 
                                                    'memo' => '',
                                                    'amount' => (-$item_total),
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
                                                    'memo' => '',
                                                    'amount' => (+$item_total),
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
                                                    'account' => 1, //1  cash
                                                    'account_code' => 1060,
                                                    'memo' => '',
                                                    'amount' => (+$total),
                                                    'currency_code' => $cur_det['code'], 
                                                    'currency_value' => $cur_det['value'], 
                                                    'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                    'status' => 1,
                                            );
                } 
                  
//            echo '<pre>';            print_r($tot_available_for_invoice);  
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Sales_invoices_model->add_db($data);
                
		if($add_stat[0]){  
//                    delete_cookie('sale_inv_list');
                    //update log data
                    $new_data = $this->Sales_invoices_model->get_single_row($add_stat[1]);
                    add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class().'/view/'.$invoice_id)); 
                }else{
                    $this->session->set_flashdata('error',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
        
        function SO_invoice_gen_check($order_id){ //get available amount for invoice creation
            $this->load->model('Payments_model');
            $this->load->model('Sales_orders_model');
            $data =array();
            
            $order_total = $tot_payments = $tot_og = $tot_redeem_amount = 0;
            $order_desc = $this->Sales_orders_model->get_so_desc($order_id); 
            $data['so_desc'] = $order_desc;
            foreach ($order_desc as $order_itm){ 
                    $order_total +=  ($order_itm['actual_sub_total']!=0)?$order_itm['actual_sub_total']:$order_itm['sub_total']; 
            }
            
            $trasns = $this->Payments_model->get_transections(11,$order_id);//11 so cust
            $data['so_payments'] = $trasns;
            foreach ($trasns as $tran){
                if($tran['transection_type_id'] == 5){//redeemed
                    $tot_payments -= $tran['transection_amount'];
                }else{
                    $tot_payments += $tran['transection_amount'];
                }
            }
            
            $og_data = $this->Sales_orders_model->get_og_for_so($order_id);  
            $data['so_oldgold'] = $trasns;
            foreach ($og_data as $og){
                $tot_og += $og['og_amount'];
            }
            
            $inv_desc = $this->Sales_invoices_model->get_invc_desc_for_so($order_id);
            $order_inv_tot = (isset($inv_desc[0]['sub_total']))?$inv_desc[0]['sub_total']:0;
            
            $tot_redeemed =  $this->Sales_orders_model->get_so_redeem_inv(11,$order_id,'t.transection_type_id = 5'); //11 for SO customer type 5 for Redeemed payments
            foreach ($tot_redeemed as $redeemed){
                $tot_redeem_amount += $redeemed['transection_amount']; 
            }
            $available_amount = ($tot_og+$tot_payments);
//            $available_amount = ($tot_og+$tot_payments-$tot_redeem_amount); 
            
            $data['tot_og'] = $tot_og;
            $data['tot_payments'] = $tot_payments;
            $data['order_inv_tot'] = $order_inv_tot;//invoiced
            $data['order_total'] = $order_total;
            $data['available_amount'] = $available_amount;
            $data['tot_redeem_amount'] = $tot_redeem_amount;
//            echo '<br>ot: '.$order_total;
//            echo '<br>$tot_payments: '.$tot_payments;
//            echo '<br>$tot_og: '.$tot_og;
//            echo '<br>$order_inv_tot: '.$order_inv_tot;die;
            return $data;
        }
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0,$calc='-',$is_order=0){ //updatiuon for item_stock table
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
                if($is_order==0){ 
                    if($calc=='+'){
                        $available_units = $stock_det['units_available'] + $units;
                        $available_units_2 = $stock_det['units_available_2'] + $units_2;
                    }else{
                        $available_units = $stock_det['units_available'] - $units;
                        $available_units_2 = $stock_det['units_available_2'] - $units_2;
                    }
                }else{
                    if($calc=='+'){
                        $units_on_demand = $stock_det['units_on_demand'] + $units;
                        $units_on_demand_2 = $stock_det['units_on_demand_2'] + $units_2;
                    }else{
                        $units_on_demand = $stock_det['units_on_demand'] - $units;
                        $units_on_demand_2 = $stock_det['units_on_demand_2'] - $units_2;
                    }
                }
            }
            if($is_order==0){
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_available'=>$available_units,'new_units_available_2'=>$available_units_2);
            }else{
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_on_demand'=>$units_on_demand,'new_units_on_demand_2'=>$units_on_demand_2);
            }
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
            $existing_data = $this->Sales_invoices_model->get_single_row($inputs['id']);

            $edit_stat = $this->Sales_invoices_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Sales_invoices_model->get_single_row($inputs['id']);
                add_system_log(VEHICLE_RATES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
            $this->load->model('Item_stock_model');
            $inputs = $this->input->post(); 
            //check the payments before delete reservation
            $this->load->model('Payments_model');
            $data['inv_transection'] = $this->Payments_model->get_transections(10,$inputs['id']); //10 for customer
            if(!empty($data['inv_transection'])){
                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
                return false;
            }
                    
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
//            $existing_data = $this->Sales_invoices_model->get_single_row($inputs['id']);
            $existing_data = $this->get_invoice_info($inputs['id']); 
            
//            echo '<pre>';            print_r($existing_data); die;
             //GL Entries
//            $data['gl_trans'] = array(array(
//                                                'person_type' => 10,
//                                                'person_id' => $existing_data['invoice_dets']['customer_id'],
//                                                'trans_ref' => $existing_data['invoice_dets']['id'],
//                                                'trans_date' => strtotime("now"),
//                                                'account' => 5, //5 inventory GL
//                                                'account_code' => 1510, //5 inventory GL
//                                                'memo' => 'SALE_I Deletion',
//                                                'amount' => (+$existing_data['invoice_total']),
//                                                'currency_code' => $existing_data['invoice_dets']['currency_code'],
//                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
//                                                'status' => 1,
//                                        ),array(
//                                                'person_type' => 10,
//                                                'person_id' => $existing_data['invoice_dets']['customer_id'],
//                                                'trans_ref' => $existing_data['invoice_dets']['id'],
//                                                'trans_date' => strtotime("now"),
//                                                'account' => 3, //14 AC Receivable GL
//                                                'account_code' => 1200,  
//                                                'memo' => 'SALE_I Deletion',
//                                                'amount' => (-$existing_data['invoice_total']),
//                                                'currency_code' => $existing_data['invoice_dets']['currency_code'],
//                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
//                                                'status' => 1,
//                                        )
//                                    );
                
            $delete_stat = $this->Sales_invoices_model->delete_db($inputs['id'],$data);
                    
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
            
            $existing_data = $this->Sales_invoices_model->get_single_row($inputs['id']);
            if($this->Sales_invoices_model->delete2_db($id)){
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
                $data['user_data'] = $this->Sales_invoices_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            } 
            
            $data['customer_list'] = get_dropdown_data(CUSTOMERS, 'customer_name', 'id','');
            $data['customer_type_list'] = get_dropdown_data(CUSTOMER_TYPE, 'customer_type_name', 'id','');
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code',''); 
            
            $data['customer_branch_list'] = array();
            $data['consignee_list'] = get_dropdown_data(CONSIGNEES, 'consignee_name', 'id','Consignee'); 
//            $data['price_type_list'] = array(16=>'Whole Sale',15=>'Retail');
            $data['price_type_list'] = get_dropdown_data(DROPDOWN_LIST, 'dropdown_value', 'id','','dropdown_id = 14');
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
            $data['payment_method_list'] = get_dropdown_data(PAYMENT_METHOD, 'payment_method_name', 'id');
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); //14 for sales type
//            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code','','',0,SELECT2_ROWS_LOAD); //25 limit 
            $data['item_list'] = $this->get_availale_items_dropdown(); 
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');
                    

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
                                'item_code' => $this->input->post('item_code'), 
                                ); 
            $invoices['search_list'] = $this->Sales_invoices_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Sales_invoices_model->search_result();
            $this->load->view('sales_invoices/search_sales_invoices_result',$invoices);
	}
        
        function get_single_item(){
            $this->load->model('Item_stock_model');
            $inputs = $this->input->post(); 
            $data = $this->Sales_invoices_model->get_single_item($inputs['item_code'],$inputs['price_type_id']); 
            $data['stock'] = $this->Item_stock_model->get_stock_by_code($inputs['item_code'],$inputs['location_id']);
//            echo '<pre>';            print_r($data); die;
            echo json_encode($data);
        }
        
        function sales_invoice_print($inv_id,$tmp_mail=''){
            $this->load->model('Sales_orders_model');
//            echo '<pre>';            print_r($this->get_invoice_info($inv_id)); die; 
            $inv_data = $this->get_invoice_info($inv_id);
            $inv_dets = $inv_data['invoice_dets'];
            $inv_desc = $inv_data['invoice_desc'];
            $this->load->library('Pdf');
            
            $cur_det = $this->Sales_invoices_model->get_currency_for_code($inv_dets['currency_code']);
            $cust_dets = get_single_row_helper(CUSTOMERS,'id='.$inv_dets['customer_id']);
//            echo '<pre>';            print_r($cust_dets); die; 
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='INVOICE';//invice bg
            $pdf->fl_header_title_RTOP='CUSTOMER COPY';//invice bg
            $pdf->fl_footer_text=1;//invice bg
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF JWL Invoice');
            $pdf->SetSubject('JWL Invoice');
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
                        
//            echo '<pre>';            print_r($cur_det['symbol_left']); die;
            $payment = $old_gold = '';
            $payment_tot = $old_gold_tot = 0;
            $pdf->SetTextColor(32,32,32);    
            if(isset($inv_data['inv_transection']) && !empty($inv_data['inv_transection'])){
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
                                           foreach ($inv_data['inv_transection'] as $payment_info){
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
                                <td style="padding:10px;">Customer Code: '.$inv_dets['short_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Full Name: '.$inv_dets['customer_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Address: '.$inv_dets['address'].(($inv_dets['city']!='')?', '.$inv_dets['city']:'').'</td> 
                            </tr>   
                        </table> 
                    </td></tr>
                    </table> ';
            $del_type = '';
            if($inv_dets['so_id']!=0){
                $so_desc1 = $this->Sales_orders_model->get_so_desc($inv_dets['so_id']);
                if(count($so_desc1)==count($inv_data['invoice_desc_list'])){
                    $del_type = 'FULL';
                }
                if(count($so_desc1)>count($inv_data['invoice_desc_list'])){
                    $del_type = 'PART';
                }
            }
//                            echo '<pre>';            print_r(count($inv_data['invoice_desc_list'])); die;
            $html .= '<table border="0">
                            <tr><td  colspan="3"><br></td></tr>
                            <tr>
                                <td align="left">TRX Type: '.$inv_dets['invoice_type'].'</td> 
                                <td align="center">Invoice Date '.date(SYS_DATE_FORMAT,$inv_dets['invoice_date']).'</td> 
                                <td align="right">Invoice  No: '.$inv_dets['invoice_no'].'</td> 
                            </tr>  
                            <tr '.(($inv_dets['so_id']>0)?'':'style="line-height:0px;"').'>
                                <td align="left">'.(($del_type=='')?'':'Delivery Type: '.$del_type).'</td> 
                                <td align="center">'.(($inv_dets['order_date']!='')?'Order Date: '.date(SYS_DATE_FORMAT,$inv_dets['order_date']):'').'</td> 
                                <td align="right">'.(($inv_dets['sales_order_no']!='')?'Order No: '.$inv_dets['sales_order_no']:'').'</td> 
                            </tr>  
                            <tr>
                                <td align="left"></td> 
                                <td align="center"></td> 
                                <td align="right">Currency: '.$cur_det['code'].'</td> 
                            </tr>  
                            <tr><td  colspan="3"><br></td></tr>
                        </table>  ';
           
                     $html .= '<table border="0" style=""><tr><td>';
                                     $inv_tot = 0;
                                     $is_gem_stat = $is_item_stat = 0;
                                     $item_list_html = $gem_list_html = '';
//            echo '<pre>';            print_r($inv_data['invoice_desc_list']); die; 
                                foreach ($inv_data['invoice_desc_list'] as $inv_itm){
                                    if($inv_itm['is_gem']==1){
                                        $is_gem_stat++;
                                    }
                                    if($inv_itm['is_gem']==0){
                                        $is_item_stat++;
                                    }
                                    if($inv_itm['is_gem']==0){
                                        $item_list_html .= '<tr>
                                                       <td width="33%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                                                       <td width="12%" style="text-align: left;">'.$inv_itm['item_cat_name'].'</td>  
                                                       <td width="12%">'.$inv_itm['item_code'].'</td>  
                                                       <td width="23%" style="text-align: center;">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].'</td> 
                                                       <td width="20%" style="text-align: right;"> '. number_format($inv_itm['sub_total'],2).'</td> 
                                                   </tr> ';
                                        $inv_tot+=$inv_itm['sub_total'];
                                    }
                                    if($inv_itm['is_gem']==1){
                                        $item_info = get_single_row_helper(ITEMS, 'id='.$inv_itm['item_id']);
                                        
//                                echo '<pre>';         print_r($inv_itm); die;
                                        $gem_list_html .= '<tr>
                                                           <td width="16%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                                                           <td width="10%" style="text-align: left;">'.$inv_itm['item_code'].'</td>  
                                                           <td width="10%">'. (($item_info['color']>0)?get_dropdown_value($item_info['treatment']):'-').'</td>  
                                                           <td width="10%">'. (($item_info['color']>0)?get_dropdown_value($item_info['shape']):'-').'</td>  
                                                           <td width="12%">'. (($item_info['color']>0)?get_dropdown_value($item_info['color']):'-').'</td>  
                                                           <td width="12%">'. (($item_info['color']>0 && get_dropdown_value($item_info['origin'])!='0')?get_dropdown_value($item_info['origin']):'-').'</td>  
                                                           <td width="18%" style="text-align: center;">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['item_quantity_uom_id_2']>0)?' / '.$inv_itm['item_quantity_2'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
                                                           <td width="12%" style="text-align: right;"> '. number_format($inv_itm['sub_total'],2).'</td> 
                                                       </tr> ';
                                        $inv_tot+=$inv_itm['sub_total'];
                                    }
                                }
                                
                                //items
                                if($is_item_stat>0){
                                    $html .='
                                                <table id="example1" class="table-line" border="0">
                                                    <thead> 
                                                        <tr style=""> 
                                                            <th width="33%" style="text-align: left;"><u><b>Article Description</b></u></th>  
                                                            <th width="12%" style="text-align: left;"><u><b>Category</b></u></th>  
                                                            <th width="12%" style="text-align: left;"><u><b>Item code</b></u></th> 
                                                            <th  width="23%" style="text-align: center;" ><u><b>Weight</b></u></th>  
                                                            <th width="20%" style="text-align: right;"><u><b>Price ('.$cur_det['symbol_left'].')</b></u></th> 
                                                         </tr>
                                                    </thead>
                                                <tbody>';
                                    $html .= $item_list_html;
                                    $html .= ' <tr><td  colspan="5"></td></tr></tbody></table>';  
                                }
                                //gemstones
                                if($is_gem_stat>0){
                                    $html .= '<table id="example2" class="table-line" border="0">
                                                    <thead> 
                                                        <tr style=""> 
                                                            <th width="16%" style="text-align: left;"><u><b>Gemstone</b></u></th>  
                                                            <th width="10%" style="text-align: left;"><u><b>Item Code</b></u></th>  
                                                            <th width="10%" style="text-align: left;"><u><b>CDC</b></u></th> 
                                                            <th  width="10%" style="text-align: left;" ><u><b>Shape</b></u></th>  
                                                            <th  width="12%" style="text-align: left;" ><u><b>Color</b></u></th>  
                                                            <th  width="12%" style="text-align: left;" ><u><b>Origin</b></u></th>  
                                                            <th  width="18%" style="text-align: center;" ><u><b>Weight</b></u></th>  
                                                            <th width="12%" style="text-align: right;"><u><b>Price ('.$cur_det['symbol_left'].')</b></u></th> 
                                                         </tr>
                                                    </thead>
                                                <tbody>';
                                    $html .= $gem_list_html;
                                    $html .= ' <tr><td  colspan="5"></td></tr></tbody></table>';  
                                }
            $html .= '
                      <table id="example1" class="table-line" border="0">
                        
                       <tbody> '; 
                    
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Sub Total</b></td> 
                                    <td width="20%"  style="border-top: 1px solid #00000;text-align: right;"><b> '. number_format($inv_tot,2).'</b></td> 
                                </tr>';
                        
                        if(!empty($inv_data['invoice_addons'])){
                            foreach ($inv_data['invoice_addons'] as $inv_addon){
                                $inv_tot += $inv_addon['addon_amount'];
                                $addon_info = json_decode($inv_addon['addon_info'],true)[0];
                                $percent = '';
                                if($addon_info['calculation_type']==2){
                                    $percent = '('.$addon_info['addon_value'].' %)';
                                }
//                                echo '<pre>';         print_r($addon_info); die;
                                $html .= '<tr>
                                            <td  style="text-align: right;" colspan="4"><b>'.$addon_info['addon_name'].' '.$percent.'</b></td> 
                                            <td width="20%"  style="text-align: right;"><b> '. number_format($inv_addon['addon_amount'],2).'</b></td> 
                                        </tr>';
                            }
                            
                            $html .= '<tr>
                                        <td  style="text-align: right;" colspan="4"><b>Total</b></td> 
                                        <td width="20%"  style="border-top: 1.5px solid #00000;text-align: right;"><b> '. number_format($inv_tot,2).'</b></td> 
                                    </tr>';
                        }
                        
                        $balance = $inv_tot;
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
                        
                        if($balance>0){
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                                    <td width="20%" style="border-top: 1px solid #00000;text-align: right;" ><b> '. number_format($balance,2).'</b></td> 
                                </tr>';
                        }
                        $html .= '</tbody>
                    </table>
                                </td></tr></table>                               
                ';
                        
                        
            $html .= $payment.$old_gold;
//            $html .= '<table border="0">
//                            <tr style="line-height:80px;"><td  colspan="4"><br></td></tr>
//                            <tr>
//                                <td  align="center"></td> 
//                                <td align="center"></td> 
//                                <td  align="center">'.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td> 
//                                <td align="center"></td> 
//                            </tr>  
//                            <tr style="line-height:5px;">
//                                <td  align="center">...............................................</td> 
//                                <td align="center">...............................................</td> 
//                                <td  align="center">...............................................</td> 
//                                <td align="center">...............................................</td> 
//                            </tr>  
//                            <tr>
//                                <td align="center">Sales Person</td> 
//                                <td align="center">Checked by</td> 
//                                <td align="center">Approved by</td>  
//                                <td align="center">Customer Signature</td> 
//                            </tr>  
//                           </table>  ';            
            
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
            
            $pdf->SetFont('times', '', 12.5, '', true);
            $pdf->SetTextColor(255,125,125);           
//            $pdf->Text(160,20,$inv_dets['sales_order_no']);

            if($tmp_mail==1){
                
//                    echo '<pre>';                    print_r($cust_dets); die;
                $pd_file_path = BASEPATH.'.'.PDF_TMP_MAIL.'sales_invoices/INV_'.$inv_dets['invoice_no'].'.pdf';
                if(file_exists($pd_file_path)) unlink($pd_file_path);  //check and remove old file exists
                $pdf->Output($pd_file_path, 'F');
                
                    if($cust_dets['email'] == ''){
                         $this->session->set_flashdata('error','Error! Email not sent. Please Check Customer Email address.');
                    }else{
                        if(file_exists($pd_file_path) && $cust_dets['email'] != ''){
                            $message    = '<table width="100%" border="0">
                                                        <br>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Please find attached invoice (Invoice No '.$inv_dets['invoice_no'].')  send  at '.date('Y-m-d H:i').'</td>
                                                        </tr>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">&nbsp;</td>
                                                        </tr> 
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                        </tr>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Best Regards</td>
                                                        </tr>

                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">'.SYSTEM_NAME.'</td>
                                                        </tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                        </tr>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8;">Please note that this is an automatd email from the <a href="http://nveloop.com">Nveloop</a> Gem Merchant Software.</td>
                                                        </tr>
                                </table>';
                            $attathments[0] = $pd_file_path;
        //                    $attathments = '';
                            $this->load->model('Sendmail_model');
                            if($this->Sendmail_model->send_mail($cust_dets['email'],SMTP_USER,SYSTEM_NAME.' Billing',SYSTEM_SHOTR_NAME.' Invoice # :'.$inv_dets['invoice_no'],$message,$attathments)){
                                 $this->session->set_flashdata('warn','Success! Email send to  '.$cust_dets['email'].' Successfully');
                                 unlink($pd_file_path);
                                 echo '1';
                            }else{
        //                        echo 'bbbb';
                                 $this->session->set_flashdata('error','Error! Email not sent.');
                                 echo '0';
                            }
                        }
                    }
            }else{ 
                
                // force print dialog
                $js = 'this.print();';
                $js = 'print(true);';
                // set javascript
                $pdf->IncludeJS($js);
                $pdf->Output('INV_'.$inv_dets['invoice_no'].'.pdf', 'I');
            }
        } 
        function get_invoice_info($inv_id){
            $this->load->model('Items_model');  
            if($inv_id!=''){
                 $data['invoice_dets'] = $this->Sales_invoices_model->get_single_row($inv_id); //10 fro sale invoice
                if(empty($data['invoice_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['invoice_desc'] = array();
            $invoice_desc = $this->Sales_invoices_model->get_invc_desc($inv_id);
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
            $this->load->model("Sales_pos_model");
            $invoice_addons = $this->Sales_pos_model->get_invoice_addons($inv_id); 
            if(!empty($invoice_addons)){
                foreach ($invoice_addons as $invoice_addon){
                    $data['invoice_total']+= $invoice_addon['addon_amount'];
                }
            }
            $data['invoice_addons'] = $invoice_addons; 
            
            return $data;
        }
        
        function fl_ajax(){
            
//            echo '<pre>';            print_r($this->input->post()); die;
            $func = $this->input->get('function_name');
            $param = $this->input->post();
            
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            }
        }
        
        function get_calculate_required_payment(){
            $inputs = $this->input->post();
            $new_amount_inv = $inputs['total_amount'];
            $so_data = $this->SO_invoice_gen_check($inputs['order_id']);
            
            $so_available_cur = $so_data['available_amount'];
            $balance_amount_inv = $so_data['available_amount'] - $new_amount_inv;//
            
            if($balance_amount_inv>0){
                $bal1 = abs($balance_amount_inv);
            }else{
                $insuff = abs($balance_amount_inv);
            }
            
            $balance_order = $so_data['order_total'] - ($new_amount_inv+$so_data['order_inv_tot']);//order balance
            
            $locked_amount = $balance_order*0.2;
            $releasable_amount = $so_available_cur - $locked_amount;
            
            $required_payment = $locked_amount + $new_amount_inv;
            $required_payment2 = $required_payment - $so_available_cur;
            $ret_array =array(
                                'required_payment' => $required_payment,
                                'locked_amount' => $locked_amount,
                                'tot_payments' => $so_data['tot_payments'],
                                'order_total' => $so_data['order_total'] ,
                                'balance_order' => $balance_order,
                                'balance_amount_inv' => $balance_amount_inv,
                                'so_available_cur' => $so_available_cur,
                                'required_calculated' => $required_payment2,
                                'releasable_amount' => $releasable_amount,
                                'tot_redeem_amount' => $so_data['tot_redeem_amount'],
                            );
            echo json_encode($ret_array);
//                $so_data = $this->get_salesorder_info($inputs['order_id']);
//                echo '<pre>';                print_r($inputs['total_amount']); die;
        }
                
        function item_list_set_cookies(){
            $this->load->helper('cookie'); 
            $cookie= array(
                            'name'   => 'sale_inv_list',
                            'value'  => json_encode($this->input->post()),
                            'expire' => '3600',
                   );
            
            delete_cookie('sale_inv_list');
            $this->input->set_cookie($cookie);
//        $this->test();
//            echo '<pre>';            print_r(json_decode($this->input->cookie('sale_inv_list',true))); die;
        }
        
        function get_cookie_data_itms(){
            $list_data_jsn = $this->input->cookie('sale_inv_list',true);
            echo $list_data_jsn;
//            echo '<pre>';            print_r($list_data_jsn); die;
//            return $list_data_jsn;
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
                echo json_encode($res[0]);
        }
        
        function get_single_customer(){
                $customer_id = $this->input->post('customer_id');
                $this->db->select("c.*");	 	
                $this->db->from(CUSTOMERS." c");
                $this->db->select("(select country_name from ".COUNTRY_LIST." where country_code = c.country) as country_name");	
                $this->db->where('c.deleted',0);
                if($customer_id > 0){
                    $this->db->where('c.id',$customer_id);  
                }                       
                
                $res = $this->db->get()->result_array();
                echo json_encode($res[0]);
        }
        
        function get_salesorder_info($order_id){
            $this->load->model('Sales_orders_model');
            if($order_id!=''){
                 $data['order_dets'] = $this->Sales_orders_model->get_single_row($order_id); 
                if(empty($data['order_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['order_desc'] = array();
            $order_desc = $this->Sales_orders_model->get_so_desc($order_id); 
            
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
            $data['so_og_info'] = $this->Sales_orders_model->get_og_for_so($order_id); 
            
            $data['order_total'] = $data['order_desc_total'];
            $data['transection_total']=0;
            $this->load->model('Payments_model');
            $data['so_transection_pay'] = $this->Payments_model->get_transections(11,$order_id); //10 for customer
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
//            echo '<pre>';            print_r($data); die;
            return $data;
        }
        function add_inv_payments(){
            $inputs = $this->input->post(); 
            $inv_det = $this->Sales_invoices_model->get_single_row($inputs['invoice_id']);
            $cur_det = get_currency_for_code($inv_det['currency_code']);
//            echo '<pre>';            print_r($inputs); 
//            echo '<pre>';            print_r($inv_det); 
            
            // customer payment for invoice
                $trans_id = get_autoincrement_no(TRANSECTION); 
                $p_method=$inputs['pay_method']; 
                    
                $data['trans_tbl'] = array(
                                                    'id' =>$trans_id,
                                                    'transection_type_id' =>1, //1 for customer payments
                                                    'payment_method' =>$p_method, 
                                                    'reference' =>'', 
                                                    'person_type' =>10, //11 for customer Sales Order
                                                    'person_id' =>$inv_det['customer_id'],
                                                    'transection_amount' =>$inputs['tot_amount'],
                                                    'currency_code' => $cur_det['code'],
                                                    'currency_value' => $cur_det['value'], 
                                                    'trans_date' => strtotime('now'),
                                                    'trans_memo' => $inputs['pay_method'].'_SI',
                                                    'status' => 1,
                                                );

                $data['trans_ref'][] = array(
                                                    'transection_id' =>$trans_id,
                                                    'reference_id' =>$inv_det['id'],
                                                    'trans_reference' =>$inv_det['invoice_no'],
                                                    'transection_ref_amount' =>$inputs['tot_amount'], 
                                                    'person_type' =>10, //11 for customer Sales Order 
                                                    'status' =>1, 
                                                );  
                
                if($inputs['amount_release']>0 && $inputs['order_id']>0){
                    $this->load->model('Sales_orders_model');
                    $order_det = $this->Sales_orders_model->get_single_row($inputs['order_id']);
                    // customer payment for invoice
                        $trans_id = $trans_id+1;  

                        $data['trans_tbl_so_redeem'] = array(
                                                            'id' =>$trans_id,
                                                            'transection_type_id' =>5, //5 SO redeem
                                                            'payment_method' =>'', 
                                                            'reference' =>'', 
                                                            'person_type' =>11, //11 for customer Sales Order
                                                            'person_id' =>$order_det['customer_id'],
                                                            'redeemed_inv_id' =>$inv_det['id'],
                                                            'transection_amount' =>$inputs['amount_release'],
                                                            'currency_code' => $cur_det['code'],
                                                            'currency_value' => $cur_det['value'], 
                                                            'trans_date' => strtotime('now'),
                                                            'trans_memo' => 'Released_So_Advance_'.$inv_det['invoice_no'],
                                                            'status' => 1,
                                                        );

                        $data['trans_ref'][] = array(
                                                            'transection_id' =>$trans_id,
                                                            'reference_id' =>$order_det['id'],
                                                            'trans_reference' =>$order_det['sales_order_no'],
                                                            'transection_ref_amount' =>$inputs['amount_release'], 
                                                            'person_type' =>11, //11 for customer Sales Order 
                                                            'status' =>1, 
                                                        ); 
                }

                $data['gl_trans'][] = array(
                                                'person_type' => 11,
                                                'person_id' => $inv_det['customer_id'],
                                                'trans_ref' => $inv_det['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 3, //14 AC Receivable GL
                                                'account_code' => 1200, 
                                                'memo' => 'INV Payment',
                                                'amount' => (-$inputs['amount']),
                                                'currency_code' => $cur_det['code'],
                                                'currency_value' => $cur_det['value'], 
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        );
                $data['gl_trans'][] = array(
                                                'person_type' => 11,
                                                'person_id' => $inv_det['customer_id'],
                                                'trans_ref' => $inv_det['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 1, //2 petty cash
                                                'account_code' => 1060,
                                                'memo' => 'INV Payment',
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
        function get_cur_det_code_json(){
            $inputs =$this->input->post();
            $cur_det = get_currency_for_code($inputs['currency_code']);
            echo json_encode($cur_det);
        }
        
        function get_availale_items_dropdown_json(){
            $inputs = $this->input->post();
            $this->load->model('Items_model');
            $itms = $this->Items_model->get_available_items("itm.item_name like '%".$inputs['item_search_txt']."%' OR itm.item_code like '%".$inputs['item_search_txt']."%'",(isset($inputs['item_lmit'])?$inputs['item_lmit']:''));
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
            $this->load->helper('cookie'); 
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
//            $data = $this->Sales_invoices_model->get_single_item(1002,15);
//            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
}
