<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_receivals extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Order_receivals_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Order_receivals_model->search_result();
            $data['main_content']='order_receivals/search_order_receivals'; 
            $data['craftman_list'] = get_dropdown_data(CRAFTMANS,'craftman_name','id','Craftman');
            $this->load->view('includes/template',$data);
	}
        
	function add_POS($spos=1){
            $data  			= $this->load_data(); 
            $data['no_menu']		= $spos;
            $data['action']		= 'Add';
            $data['main_content'] = 'order_receivals/manage_order_receivals';  
            $this->load->view('includes/template_pos',$data);  
	}
	function add(){
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content'] = 'order_receivals/manage_order_receivals';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content' ] = 'order_receivals/view_order_receivals'; 
            $data['cm_ret_data'] = $this->get_cm_return_info($id);
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']= 'order_receivals/view_order_receivals'; 
            $data['cm_ret_data'] = $this->get_cm_return_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'View';
            $data['main_content' ] = 'order_receivals/view_order_receivals'; 
            $data['cm_ret_data'] = $this->get_cm_return_info($id);
            $this->load->view('includes/template',$data);
	}
	function view_POS($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='order_submissions/view_order_submissions'; 
            $data['cm_ret_data'] = $this->get_cm_return_info($id);
//            echo '<pre>';            print_r($data); die; 
            $this->load->view('includes/template_pos',$data);  
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

            $this->form_validation->set_rules('receival_date','Reeceiving Date','required'); 
            $this->form_validation->set_rules('location_id','Receiving Location','required'); 
            foreach ($this->input->post('inv_items_btm') as $key=>$inpt_itm){ 
                $this->form_validation->set_rules('inv_items_btm['.$key.'][new_item_code]','Item Code','callback_check_unique_itemcode'); 
                
            }
      }	 
        
       function check_unique_itemcode(){
          $res = array();
          foreach ($this->input->post('inv_items_btm') as $key=>$inpt_itm){
                 $res =  get_dropdown_data(ITEMS,'item_name','id','','item_code = "'.$inpt_itm['new_item_code'].'" ');
            }
          
          
                if(count($res)==0){
                    return true;
                }else{
                    
                    $this->session->set_flashdata('warn',"Item code exists,Should be unique"); 
                    return false;
                } 
        }
	function create(){   
            $inputs = $this->input->post();
            $cmr_id = get_autoincrement_no(CRAFTMANS_RECEIVE);
            $cmr_no = gen_id(CRF_REC_NO_PREFIX, CRAFTMANS_RECEIVE, 'id'); 
            $cur_code = (isset($inputs['currency_code']))?$inputs['currency_code']:$this->session->userdata(SYSTEM_CODE)['default_currency']; 
            $supp_id = (isset($inputs['supplier_id']))?$inputs['supplier_id']:1;  //1 : Nveloop Supplier
            $pay_term_id = (isset($inputs['payment_term_id']))?$inputs['payment_term_id']:1; //1 cash payment
            $data['cmr_tbl'] = array(
                                    'id' => $cmr_id,
                                    'cm_receival_no' => $cmr_no, 
                                    'receival_date' => strtotime($inputs['receival_date']),  
                                    'location_id' => $inputs['location_id'],  
                                    'memo' => $inputs['memo'],  
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            
            //purch invoice data
            $invoice_id = get_autoincrement_no(SUPPLIER_INVOICE);
            $invoice_no = gen_id(SUP_INVOICE_NO_PREFIX, SUPPLIER_INVOICE, 'id');
            $this->load->model('Purchasing_items_model'); 
            $cur_det = $this->Purchasing_items_model->get_currency_for_code($cur_code);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['purch_inv_tbl'] = array(
                                            'id' => $invoice_id,
                                            'supplier_invoice_no' => $invoice_no,
                                            'supplier_id' => $supp_id, 
                                            'reference' => 'SO-STOCK-UPDATE'.date('ymd'),  
                                            'comments' => 'Craftman receive No:'.$cmr_no, 
                                            'invoice_date' =>  strtotime($inputs['receival_date']), 
                                            'invoiced' => 1,   
                                            'payment_term_id' => $pay_term_id, //cash
                                            'currency_code' => $cur_code, 
                                            'currency_value' => $cur_det['value'], 
                                            'location_id' => $inputs['location_id'],
                                            'status' => 1,
                                            'added_on' => date('Y-m-d'),
                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                        );
            $data['purch_inv_desc'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection purchasing
            
            
            $data['cmr_tbl_desc'] = array(); 
            $next_item_id = get_autoincrement_no(ITEMS); 
            $total=0;
            foreach ($inputs['inv_items_btm'] as $so_desc_id => $inv_item){
                $total += $inv_item['new_units']*$inv_item['new_purch_unit_price'];
                
                $item_id = $next_item_id;
                $next_item_id++;
                $item_code = ($inv_item['new_item_code']=='')?gen_id_for_no('1', $item_id, 'id',4):$inv_item['new_item_code'];
                $data['items'][] = array(
                                    'id' => $item_id,
                                    'item_code' => $item_code,
                                    'item_name' => $inv_item['item_description'],
                                    'item_uom_id' => $inv_item['uom_id'],
                                    'item_uom_id_2' => $inv_item['uom_id_2'],
                                    'item_category_id' => $inv_item['item_category_id'],
                                    'item_type_id' => 1,//purchased 
                                    'description' => $inv_item['item_description_note'], 
                                    'addon_type_id' => 0,
                                    'sales_excluded' => 1,
                                    'purchases_excluded' => 1, 
                                    'cost_material' =>$inv_item['new_price_purchase_material'], 
                                    'cost_stone' =>$inv_item['new_price_purchase_stone'], 
                                    'cost_craftman' =>$inv_item['new_price_purchase_craftman'], 
                                    'status' => 1, 
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
                $data['item_prices_purch'][] =   array( //purch price
                                                    'item_id' => $item_id,
                                                    'item_price_type' => 1, //1 purchasing price
                                                    'price_amount' =>$inv_item['new_purch_unit_price'],
                                                    'currency_code' =>$cur_det['code'],
                                                    'currency_value' =>$cur_det['value'], 
                                                    'supplier_id' => $supp_id,
                                                    'supplier_unit' =>$inv_item['uom_abr'], // string value can be change at item mng purchase price
                                                    'supplier_unit_conversation' =>1,// can be change at item mng purchase price
                                                    'note' =>'',//Genrated on Purchasing Invoice
                                                    'status' =>1,
                                                ); 
                $data['item_prices_sale'][] = array( //sale price
                                                    'item_id' => $item_id,
                                                    'item_price_type' => 2, //2 sales price
                                                    'price_amount' =>$inv_item['new_sale_unit_price'],
                                                    'currency_code' =>$cur_det['code'],
                                                    'currency_value' =>$cur_det['value'], 
                                                    'sales_type_id' =>15,
                                                    'status' =>1,
                                                    ); 
                
                $data['item_prices_standard'][] = array( //standad price
                                                    'item_id' => $item_id,
                                                    'item_price_type' => 3, //3 Standard price
                                                    'price_amount' =>$inv_item['new_purch_unit_price'],
                                                    'currency_code' =>$cur_det['code'],
                                                    'currency_value' =>$cur_det['value'], 
                                                    'status' =>1,
                                                    );
                    
                $data['cmr_tbl_desc'][] = array(
                                            'cmr_no' => $cmr_no,
                                            'order_id' =>$inv_item['order_id'],
                                            'order_desc_id' =>$inv_item['so_desc_id'],
                                            'order_item_id' =>$inv_item['item_id'],
                                            'item_id' =>$item_id,
                                            'item_description' => $inv_item['item_description'], 
                                            'location_id' => $inputs['location_id'], 
                                            'units' => $inv_item['new_units'], 
                                            'uom_id' => $inv_item['uom_id'], 
                                            'units_2' => 1, // 1 article 
                                            'uom_id_2' => $inv_item['uom_id_2'], 
                                            'purch_unit_price' => $inv_item['new_purch_unit_price'], 
                                            'sale_unit_price' => $inv_item['new_sale_unit_price'], 
                                            'status' => 1, 
                                        ); 
                
                $data['purch_inv_desc'][] = array(
                                            'supplier_invoice_id' => $invoice_id,
                                            'item_id' => $item_id,
                                            'supplier_item_desc' => $inv_item['item_description'],
                                            'purchasing_unit' => $inv_item['new_units'],
                                            'purchasing_unit_uom_id' => $inv_item['uom_id'],
                                            'secondary_unit' => 1,//article
                                            'secondary_unit_uom_id' => $inv_item['uom_id_2'],
                                            'purchasing_unit_price' => $inv_item['new_purch_unit_price'],
                                            'location_id' => $inputs['location_id'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>1, //1 for purchsing transection
                                                            'trans_ref'=>$invoice_id, 
                                                            'item_id'=>$item_id, 
                                                            'units'=>$inv_item['new_units'], 
                                                            'uom_id'=>$inv_item['uom_id'], 
                                                            'units_2'=>1,//atricle 
                                                            'uom_id_2'=>$inv_item['uom_id_2'], 
                                                            'location_id'=>$inputs['location_id'], 
                                                            'status'=>1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                            );
                
                if($inv_item['uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($item_id,$inputs['location_id'],$inv_item['uom_id'],$inv_item['new_units'],$inv_item['uom_id_2'],1,'+'); //1 article
                else
                    $item_stock_data = $this->stock_status_check($item_id,$inputs['location_id'],$inv_item['uom_id'],$inv_item['new_units'],'',0,'+');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                } 
                
                $data['so_desc'][] = array(
                                            'craftman_status' => 2,//received from craftman
                                            'new_item_id' => $item_id, 
                                            'so_desc_id' => $so_desc_id, 
                                        ); 
                
            }
            
            //payments
            $this->load->model('Payments_model');
            $payment_terms = $this->Payments_model->get_payment_term($pay_term_id);
            if($payment_terms['payment_done']==1){ //cash payment for invoice 
                $trans_id = get_autoincrement_no(TRANSECTION);
                $data['payment_transection'] = array(
                                                'id' =>$trans_id,
                                                'transection_type_id' =>3, //3 for Supp payments
                                                'reference' =>'', 
                                                'person_type' =>20, //10 for Supplier 
                                                'person_id' =>$supp_id,
                                                'transection_amount' =>$total,
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'], 
                                                'trans_date' => strtotime($inputs['receival_date']),
                                                'trans_memo' => 'Supplier Cash Invoice - ORDER CRAFTMAN RECEIVAL',
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
                
                $data['purch_inv_tbl']['payment_settled']=1;
                
            }
            
            $data['gl_trans'] = array(array(
                                                'person_type' => 20,
                                                'person_id' => $supp_id,
                                                'trans_ref' => $invoice_id,
                                                'trans_date' => strtotime("now"),
                                                'account' => 5, //5 inventory GL
                                                'account_code' => 1510, //5 inventory GL
                                                'memo' => 'CM RECEIVE',
                                                'amount' => +($total),
                                                'currency_code' =>$cur_det['code'],
                                                'currency_value' =>$cur_det['value'], 
                                                'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                'status' => 1,
                                        ),array(
                                                'person_type' => 20,
                                                'person_id' => $supp_id,
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
            if($pay_term_id==1){
                $data['gl_trans'][] = array(
                                                'person_type' => 20,
                                                'person_id' => $supp_id,
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
                                                'person_id' => $supp_id,
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
                    
		$add_stat = $this->Order_receivals_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Order_receivals_model->get_single_row($add_stat[1]);
                    add_system_log(CRAFTMANS_SUBMISSION, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    if($inputs['no_menu']==1){
                        redirect(base_url($this->router->fetch_class().'/view/'.$cmr_id)); 
                    }else{
                        redirect(base_url($this->router->fetch_class().'/view/'.$cmr_id)); 
                    }
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
//            echo '<pre>';            print_r($inputs); die; 
            $cs_id = $inputs['id'];  
            $data['so_sub_tbl'] = array(
                                    'memo' => $inputs['memo'],  
                                    'submission_date' => strtotime($inputs['submission_date']),  
                                    'return_date' => strtotime($inputs['return_date']),  
                                    'updated_on' => date('Y-m-d'),
                                    'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            $data['so_desc'] = array();
            if(!empty($inputs['so_desc_ids'])){
                foreach ($inputs['so_desc_ids'] as $so_desc_id){
                    $data['so_desc'][] = array(
                                            'craftman_status' => 1,//submitted to craftman
                                            'so_craftman_submission_id' => $cs_id, 
                                            'so_desc_id' => $so_desc_id, 
                                        ); 
                
                 }
            }
            //old data for log update
            $existing_data = $this->get_cm_return_info($cs_id);

            $edit_stat = $this->Order_receivals_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Order_receivals_model->get_single_row($inputs['id']);
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
//            echo '<pre>';            print_r($inputs); die; 
            $ret_dets = $this->get_cm_return_info($inputs['id']); 
                    
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                    
            
            $existing_data = $this->get_cm_return_info($inputs['id']);  
            $delete_stat = $this->Order_receivals_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CRAFTMANS_SUBMISSION, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                    redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Order_receivals_model->get_single_row($inputs['id']);
            if($this->Order_receivals_model->delete2_db($id)){
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
                $data['user_data'] = $this->Order_receivals_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            } 
            $data['craftman_list'] = get_dropdown_data(CRAFTMANS, 'craftman_name', 'id','Craftman'); 
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); //14 for sales type
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','Agent Type');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');

            return $data;
	}	
        
        function search(){ 
            $input = $this->input->post();
//            echo '<pre>';            print_r($input); die;
            $search_data=array( 
                                'receival_no' => $this->input->post('receive_no'),
                                'order_no' => $input['order_no'],  
                                'received_date' => strtotime($input['received_date']),  
                                ); 
            $so_subms['search_list'] = $this->Order_receivals_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Order_receivals_model->search_result();
            $this->load->view('order_receivals/search_order_receivals_result',$so_subms);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Order_receivals_model->get_single_item($inputs['item_code'],$inputs['supplier_id']); 
            echo json_encode($data);
        }
        function test(){
//            echo '<pre>';            print_r($this->router->class); die;
            
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Order_receivals_model->get_single_item(1002,15);
            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        function sales_return_print($sub_id){
//            echo '<pre>';            print_r($this->get_cm_return_info(2)); die;
            $inv_data = $this->get_cm_return_info($sub_id);
            $inv_dets = $inv_data['invoice_dets'];
            $inv_desc = $inv_data['invoice_desc'];
            $inv_trans = $inv_data['inv_transection'];
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
                            <td>Invoiced Date: '.date('m/d/Y',$inv_dets['invoice_date']).'</td>
                            <td align="right">Invoiced by: '.$inv_dets['sales_person'].'</td>
                        </tr>
                        <tr> 
                            <td colspan="2" align="center"><h1>SALES RETURN NOTE</h1></td>
                        </tr>  
                        <tr>
                            <td>Customer: '.$inv_dets['customer_name'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td>Customer Contact Number: '.$inv_dets['phone'].'</td>
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
                                         <th  width="10%"><u><b>Qty</b></u></th> 
                                         <th width="40%" style="text-align: left;"><u><b>Description</b></u></th>  
                                         <th width="15%" style="text-align: right;"><u><b>Rate</b></u></th> 
                                         <th width="15%" style="text-align: right;"><u><b>Discount</b></u></th> 
                                         <th width="19%" style="text-align: right;"><u><b>Total</b></u></th> 
                                     </tr>
                                </thead>
                            <tbody>';
                     
                     foreach ($inv_itms as $inv_itm){
                         $html .= '<tr>
                                        <td width="10%">'.$inv_itm['quantity'].'</td> 
                                        <td width="40%" style="text-align: left;">'.$inv_itm['item_description'].'</td>  
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['unit_price'],2).'</td> 
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['discount_persent'],2).'</td> 
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
                        foreach ($inv_trans as $inv_tran){
                            $html .= '<tr>
                                            <td  style="text-align: right;" colspan="4">'.$inv_tran['name'].'</td> 
                                            <td  width="19%"  style="text-align: right;">'. number_format($inv_tran['transection_amount'],2).'</td> 
                                        </tr> ';

                        }
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                                    <td width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_total'],2).'</b></td> 
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
            $pdf->Text(160,20,$inv_dets['invoice_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output('example_003.pdf', 'I');
                
        }
        
        function get_cm_return_info($sub_id='',$cn_no=''){
            if($sub_id!=''){
                 $data['ret_dets'] = $this->Order_receivals_model->get_single_row($sub_id);
                if(empty($data['ret_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            } 
           
            $data['ret_dets_desc'] = array();
            $ret_dets_desc = $this->Order_receivals_model->get_ret_desc($sub_id);
            foreach ($ret_dets_desc as $ret_det){
                $data['ret_dets_desc'][$ret_det['order_id']][] = $ret_det;
            }
            
//            echo '<pre>';            print_r($data); die;
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
                    
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
        function get_search_submitted_order(){
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die;
            $search_data = array(
                                    'so_no' => $inputs['sales_order_no'],
                                    'craftman_id' => $inputs['craftman_id'],
                                    'submission_no' => $inputs['submission_no'],
                                    'required_date' => (isset($inputs['req_date_apply']))?strtotime($inputs['required_date']):'', 
                                );  
            
            $result = $this->Order_receivals_model->search_so_submission_for_receive($search_data); 
//            echo '<pre>';            print_r($result); die;  
//            echo '<pre>';            print_r($result_available); die; 
            echo json_encode($result);
        }
        function pos_sales_ret_print_direct(){ 
            $inputs = $this->input->post();
            $invoice_data = $this->get_cm_return_info('',$inputs['cn_no']);
            $this->load->helper('print_helper');
            fl_direct_print_return($invoice_data);
            
        }
        function check_itemcode_unique(){
            $item_code = $this->input->post('item_code');
            $res = get_single_row_helper(ITEMS, 'item_code = '.$item_code);
            if(!empty($res)){
                echo 1;
            }else{ 
                echo 0;
            }
               
        }
}
