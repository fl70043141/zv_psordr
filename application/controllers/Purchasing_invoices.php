<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasing_invoices extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Purchasing_invoices_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Purchasing_invoices_model->search_result();
            $data['main_content']= 'purchasing_invoices/search_purchasing_invoices'; 
            $data['supplier_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id','Suppliers');
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='purchasing_invoices/manage_purchasing_invoices';    
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
            $data['main_content']='purchasing_invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='purchasing_invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
//            echo '<pre>';            print_r($data); die;
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
            $this->form_validation->set_rules('reference','Reference','required'); 
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
            $invoice_id = get_autoincrement_no(SUPPLIER_INVOICE);
            $invoice_no = gen_id(SUP_INVOICE_NO_PREFIX, SUPPLIER_INVOICE, 'id');
            
            $cur_det = $this->Purchasing_invoices_model->get_currency_for_code($inputs['currency_code']);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['inv_tbl'] = array(
                                    'id' => $invoice_id,
                                    'supplier_invoice_no' => $invoice_no,
                                    'supplier_id' => $inputs['supplier_id'], 
                                    'reference' => $inputs['reference'],  
                                    'comments' => $inputs['memo'], 
                                    'invoice_date' => strtotime($inputs['invoice_date']), 
                                    'invoiced' => 1,   
                                    'payment_term_id' => $inputs['payment_term_id'], 
                                    'currency_code' => $inputs['currency_code'], 
                                    'currency_value' => $cur_det['value'], 
                                    'location_id' => $inputs['location_id'],
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            $data['inv_desc'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection purchasing
            
            $total = 0;
            foreach ($inputs['inv_items'] as $inv_item){
                $total += $inv_item['item_quantity']*$inv_item['item_unit_cost'];
                $data['inv_desc'][] = array(
                                            'supplier_invoice_id' => $invoice_id,
                                            'item_id' => $inv_item['item_id'],
                                            'supplier_item_desc' => $inv_item['item_desc'],
                                            'purchasing_unit' => $inv_item['item_quantity'],
                                            'purchasing_unit_uom_id' => $inv_item['item_quantity_uom_id'],
                                            'secondary_unit' => $inv_item['item_quantity_2'],
                                            'secondary_unit_uom_id' => $inv_item['item_quantity_uom_id_2'],
                                            'purchasing_unit_price' => $inv_item['item_unit_cost'],
                                            'location_id' => $inputs['location_id'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>1, //1 for purchsing transection
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
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2'],'+');
                else
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],'',0,'+');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                
                //standared price calculation
                $this->load->model('Item_stock_model');
                $itm_stock_all = $this->Item_stock_model->get_stock_by_code($inv_item['item_code']);
                $itm_standard_price_info = $this->Purchasing_invoices_model->get_item_standard_prices($inv_item['item_id']);
                $cur_standard_price = (!empty($itm_standard_price_info))?$itm_standard_price_info[0]['price_amount']:0;
                
                if(!empty($itm_stock_all) || $itm_stock_all['units_available']>0){
                    //existing stock value
                    $exist_stock_value = $itm_stock_all['units_available']*$cur_standard_price;
                    $new_stock_value = $inv_item['item_quantity']*$inv_item['item_unit_cost'];
                    
                    $standard_cost = ($exist_stock_value + $new_stock_value)/($itm_stock_all['units_available']+$inv_item['item_quantity']);
                    
                    
                    $data['standard_price'] = array(
                                                    'item_id' => $inv_item['item_id'],
                                                    'item_price_type' => 3, //3 Standard price
                                                    'price_amount' =>$standard_cost,
                                                    'currency_code' =>$cur_det['code'],
                                                    'currency_value' =>$cur_det['value'], 
                                                    'status' =>1,
                                                    );
//                echo '<pre>';            print_r($data); die;
                } 
            }
            
            //payments
            $this->load->model('Payments_model');
            $payment_terms = $this->Payments_model->get_payment_term($inputs['payment_term_id']);
            if($payment_terms['payment_done']==1){ //cash payment for invoice 
                $trans_id = get_autoincrement_no(TRANSECTION);
                $data['payment_transection'] = array(
                                                'id' =>$trans_id,
                                                'transection_type_id' =>3, //1 for Supp payments
                                                'reference' =>'', 
                                                'person_type' =>20, //10 for Supplier 
                                                'person_id' =>$inputs['supplier_id'],
                                                'transection_amount' =>$total,
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'], 
                                                'trans_date' => strtotime($inputs['invoice_date']),
                                                'trans_memo' => 'Supplier Cash Invoice',
                                                'status' => 1,
                                            );
                
                $data['payment_transection_ref'] = array(
                                                'transection_id' =>$trans_id,
                                                'reference_id' =>$invoice_id,
                                                'trans_reference' =>$invoice_no,
                                                'transection_ref_amount' =>$total, 
                                                'person_type' =>20, //10 for supplier 
                                                'status' =>1, 
                                            );
                
                $data['inv_tbl']['payment_settled']=1;
                
            }
            
            $data['gl_trans'] = array(array(
                                                'person_type' => 20,
                                                'person_id' => $inputs['supplier_id'],
                                                'trans_ref' => $invoice_id,
                                                'trans_date' => strtotime("now"),
                                                'account' => 5, //5 inventory GL
                                                'account_code' => 1510, //5 inventory GL
                                                'memo' => '',
                                                'amount' => +($total),
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'], 
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        ),array(
                                                'person_type' => 20,
                                                'person_id' => $inputs['supplier_id'],
                                                'trans_ref' => $invoice_id,
                                                'trans_date' => strtotime("now"),
                                                'account' => 14, //14 AC Payable GL
                                                'account_code' => 2100, //inventory GL
                                                'memo' => '',
                                                'amount' => (-$total),
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'], 
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        )
                                    );
            if($inputs['payment_term_id']==1){
                $data['gl_trans'][] = array(
                                                'person_type' => 20,
                                                'person_id' => $inputs['supplier_id'],
                                                'trans_ref' => $invoice_id,
                                                'trans_date' => strtotime("now"),
                                                'account' => 14, //14 AC Payable GL
                                                'account_code' => 2100, 
                                                'memo' => '',
                                                'amount' => ($total),
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'], 
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        );
                $data['gl_trans'][] = array(
                                                'person_type' => 20,
                                                'person_id' => $inputs['supplier_id'],
                                                'trans_ref' => $invoice_id,
                                                'trans_date' => strtotime("now"),
                                                'account' => 1, //2 petty cash
                                                'account_code' => 1060,
                                                'memo' => '',
                                                'amount' => (-$total),
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'], 
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        );
            }
//            echo '<pre>';            print_r($data); die;
                    
		$add_stat = $this->Purchasing_invoices_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Purchasing_invoices_model->get_single_row($add_stat[1]);
                    add_system_log(SUPPLIER_INVOICE, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class().'/view/'.$invoice_id)); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
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
            $existing_data = $this->Purchasing_invoices_model->get_single_row($inputs['id']);

            $edit_stat = $this->Purchasing_invoices_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Purchasing_invoices_model->get_single_row($inputs['id']);
                add_system_log(VEHICLE_RATES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post(); 
            $this->load->model('Item_stock_model');
            //check the payments before delete reservation
            $this->load->model('Payments_model');
            $trans_data = $this->Payments_model->get_transections(20,$inputs['id']); //20 for supp in transection
//            echo '<pre>';            print_r($trans_data); die;
            if(!empty($trans_data)){
                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
                return false;
            }
            $data['tbl_data'] = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            
            $si_stock_trans = $this->Item_stock_model->get_stock_transection($inputs['id'],'transection_type = 1'); //1 for purchase invoice
            
            foreach ($si_stock_trans as $cn_stock){
                
                if($cn_stock['uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],$cn_stock['uom_id_2'],$cn_stock['units_2'],'-');
                else
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],'','','-');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
            }
//            $existing_data = $this->Purchasing_invoices_model->get_single_row($inputs['id']);   
            $existing_data = $this->get_invoice_info($inputs['id']); 
            $cur_det = get_currency_for_code($existing_data['invoice_dets']['currency_code']);
             //GL Entries
            $data['gl_trans'] = array(array(
                                                'person_type' => 20,
                                                'person_id' => $existing_data['invoice_dets']['supplier_id'],
                                                'trans_ref' => $existing_data['invoice_dets']['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 5, //5 inventory GL
                                                'account_code' => 1510, //5 inventory GL
                                                'memo' => 'SI Deletion',
                                                'amount' => (-$existing_data['invoice_total']),
                                                'currency_code' => $cur_det['code'], 
                                                'currency_value' => $cur_det['value'],  
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        ),array(
                                                'person_type' => 20,
                                                'person_id' => $existing_data['invoice_dets']['supplier_id'],
                                                'trans_ref' => $existing_data['invoice_dets']['id'],
                                                'trans_date' => strtotime("now"),
                                                'account' => 14, //14 AC Payable GL
                                                'account_code' => 2100, //inventory GL
                                                'memo' => 'SI Deletion',
                                                'amount' => ($existing_data['invoice_total']),
                                                'currency_code' => $cur_det['code'], 
                                                'currency_value' => $cur_det['value'],  
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        )
                                    );
                
            $delete_stat = $this->Purchasing_invoices_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('Purchasing_items'));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('Purchasing_items'));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Purchasing_invoices_model->get_single_row($inputs['id']);
            if($this->Purchasing_invoices_model->delete2_db($id)){
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
                $data['user_data'] = $this->Purchasing_invoices_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            
            
            $data['supplier_list'] = get_dropdown_data(SUPPLIERS, 'supplier_name', 'id','');
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); //14 for sales type
            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code','','item_type_id = 1'); 
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');

            return $data;
	}	
        
        function search(){ 
            $input = $this->input->post();
            $search_data=array( 
                                'supp_invoice_no' => $this->input->post('supp_invoice_no'),
                                'supplier_id' => $input['supplier_id'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $invoices['search_list'] = $this->Purchasing_invoices_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Purchasing_invoices_model->search_result();
            $this->load->view('purchasing_invoices/search_purchasing_invoices_result',$invoices);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Purchasing_invoices_model->get_single_item($inputs['item_code'],$inputs['supplier_id']); 
            echo json_encode($data);
        }
        function test(){
//            echo '<pre>';            print_r($this->router->class); die;
            
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Purchasing_invoices_model->get_single_item(1002,15);
            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        function supplier_invoice_print($inv_id){ 
            $inv_data = $this->get_invoice_info($inv_id);
            $inv_dets = $inv_data['invoice_dets'];
            $inv_desc = $inv_data['invoice_desc'];
            $inv_trans = $inv_data['inv_transection'];
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
//                        echo '<pre>';            print_r($inv_dets); die;
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='INVOICE';//invice bg
            $pdf->fl_header_title_RTOP='PURCHASING';//invice bg
            $pdf->fl_footer_text=0;//invice bg
            
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
            $pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    
            // set font 
            $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/Lato-Regular.ttf', 'TrueTypeUnicode', '', 96);
            $pdf->SetFont($fontname, 'I', 9);
        
        
            $pdf->AddPage();   
            
            
            
            $pdf->SetTextColor(32,32,32);     
            
            $html = '<table>
                        <tr>
                            <td>Invoiced Date: '.date('m/d/Y',$inv_dets['invoice_date']).'</td>
                            <td align="right">Invoiced by: '.$inv_dets['sales_person'].'</td>
                        </tr>
                        <tr> 
                            <td colspan="2" align="center"><h2>PURCHASING INVOICE</h2></td>
                        </tr> 
                        <tr>
                            <td><b>Bill To:</b> </td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td>'.$inv_dets['supplier_name'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td>'.$inv_dets['address'].' '.$inv_dets['city'].' <br>'.$inv_dets['phone'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr><td  colspan="5"><br></td></tr>
                    </table> 
                ';
            $html = '<text>Supplier Details:</text><br>';
            $html .= '<table style="padding:2;" border="0.4"> 
                        <tr><td>
                            <table style="padding:0 50 2 0;">
                            <tr>
                                <td style="padding:10px;">Supplier Code: '.$inv_dets['supplier_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Full Name: '.$inv_dets['supplier_name'].'</td> 
                            </tr>   
                            <tr>
                                <td style="padding:10px;">Address: '.$inv_dets['address'].' '.$inv_dets['city'].' '.(($inv_dets['phone']!='')?'<br>Phone: '.$inv_dets['phone']:'').'</td> 
                            </tr>   
                        </table> 
                    </td></tr>
                    </table> ';
            
            $html .= '<table border="0">
                            <tr><td  colspan="3"><br></td></tr>
                            <tr>
                                <td align="left">Invoice  No: '.$inv_dets['supplier_invoice_no'].'</td> 
                                <td align="center">Invoice Date '.date(SYS_DATE_FORMAT,$inv_dets['invoice_date']).'</td> 
                                <td align="right">Currency: '.$inv_data['invoice_dets']['currency_code'].'</td> 
                            </tr>   
                            <tr><td  colspan="3"><br></td></tr>
                        </table>  ';
           
            $cur_det = $this->Purchasing_invoices_model->get_currency_for_code($inv_data['invoice_dets']['currency_code']);
//            echo '<pre>';            print_r($inv_desc); die;
            
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
                                          <td width="33%" style="text-align: left;">'.$inv_itm['supplier_item_desc'].'</td> 
                                          <td width="12%" style="text-align: left;">'.$inv_itm['item_cat_name'].'</td>  
                                          <td width="12%" style="text-align: left;">'.$inv_itm['item_code'].'</td>  
                                          <td width="23%" style="text-align: center;">'.$inv_itm['purchasing_unit'].' '.$inv_itm['unit_abbreviation'].'</td> 
                                          <td width="20%" style="text-align: right;"> '. number_format($inv_itm['sub_total'],2).'</td> 
                                      </tr> ';
                           $inv_tot+=$inv_itm['sub_total'];
                       }
                       if($inv_itm['is_gem']==1){
                           $item_info = get_single_row_helper(ITEMS, 'id='.$inv_itm['item_id']);

//                                echo '<pre>';         print_r($inv_itm); die;
                           $gem_list_html .= '<tr>
                                              <td width="16%" style="text-align: left;">'.$inv_itm['supplier_item_desc'].'</td> 
                                              <td width="10%" style="text-align: left;">'.$inv_itm['item_code'].'</td>  
                                              <td width="10%" style="text-align: left;">'. (($item_info['color']>0)?get_dropdown_value($item_info['treatment']):'-').'</td>  
                                              <td width="10%" style="text-align: left;">'. (($item_info['color']>0)?get_dropdown_value($item_info['shape']):'-').'</td>  
                                              <td width="12%" style="text-align: left;">'. (($item_info['color']>0)?get_dropdown_value($item_info['color']):'-').'</td>  
                                              <td width="12%" style="text-align: left;">'. (($item_info['color']>0)?get_dropdown_value($item_info['origin']):'-').'</td>  
                                              <td width="18%" style="text-align: center;">'.$inv_itm['purchasing_unit'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['secondary_unit_uom_id']>0)?' / '.$inv_itm['secondary_unit'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
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
                    
                    <table id="example2" class="table-line" border="0">
                        
                       <tbody>

                                <tr class="td_ht">
                                    <td style="text-align: right;" colspan="4"><b> Total</b></td> 
                                    <td  width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_desc_total'],2).'</b></td> 
                                </tr>'; 
                        $transection_tot =0;
                        $balance_amount =  0;
                        foreach ($inv_trans as $inv_tran){
                            if($inv_tran['calculation']==1)$transection_tot +=  $inv_tran['transection_amount'];
                            if($inv_tran['calculation']==2)$transection_tot -=  $inv_tran['transection_amount'];
//            echo '<pre>';            print_r($inv_tran); die;
                            $html .= '<tr>
                                            <td  style="text-align: right;" colspan="4">'.$inv_tran['trans_type_name'].' ('.date(SYS_DATE_FORMAT,$inv_tran['trans_date']).')</td> 
                                            <td  width="19%"  style="text-align: right;">'. number_format($inv_tran['transection_amount'],2).'</td> 
                                        </tr> '
                                    ;
                            $balance_amount += $transection_tot;

                        }
                        $balance_amount += $inv_data['invoice_desc_total']; 
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                                    <td  width="19%"  style="text-align: right;"><b>'. number_format($balance_amount,2).'</b></td> 
                                </tr> ';
                        
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
                font-size:10px;
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
//            $pdf->Text(160,20,$inv_dets['supplier_invoice_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output('Purch_invoice_'.$inv_id.'.pdf', 'I');
                
        }
        
        function get_invoice_info($inv_id){
            if($inv_id!=''){
                 $data['invoice_dets'] = $this->Purchasing_invoices_model->get_single_row($inv_id);
                if(empty($data['invoice_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['invoice_desc'] = array();
            $invoice_desc = $this->Purchasing_invoices_model->get_invc_desc($inv_id);
            
            $data['invoice_desc_list'] = $invoice_desc;
            
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
            
            $data['invoice_desc_total']= 0;
            foreach ($item_cats as $cat_key=>$cay_name){ 
                foreach ($invoice_desc as $invoice_itm){
                    if($invoice_itm['item_category']==$cat_key){
                        $data['invoice_desc'][$cat_key][]=$invoice_itm;
                        $data['invoice_desc_total'] +=  $invoice_itm['sub_total'];
                    }
                }
            }
            $data['invoice_total'] = $data['invoice_desc_total'];
            $data['transection_total']=0;
            $this->load->model('Payments_model');
            $data['inv_transection'] = $this->Payments_model->get_transections(20,$inv_id); //20 for Supplier 
            
//            echo '<pre>';            print_r($data); die;
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
}
