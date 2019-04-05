<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_payments extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Payments_model'); 
        }

        public function index($person_type=10){
            $this->add($person_type);
	} 
        
	function add($person_type=10){  //10: cust, 20:sup, 30: consignee
            $data['action']		= 'Add';
            $data['main_content']='customer_payments/manage_customer_payments'; 
            
            switch ($person_type){
                case 10:
                    $data['person_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id','');
                    $data['person'] = "Customer";
                    $data['person_type'] = $person_type;
                    $data['trans_type_id'] = 1;// cust payment
                    break;
                case 20:
                    $data['person_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id','');
                    $data['person'] = "Supplier";
                    $data['person_type'] = $person_type;
                    $data['trans_type_id'] = 3;
                    break;
                case 30:
                    $data['person_list'] = get_dropdown_data(CONSIGNEES,'consignee_name','id','');
                    $data['person'] = "Consignee";
                    $data['person_type'] = $person_type;
                    $data['trans_type_id'] = 1;
                    break;
                    
            } 
            
//            $data['person_dues'] = $this->get_dues($person_type, 1);
            $data['bank_account_list'] = get_dropdown_data(BANK_ACCOUNTS,'account_code','id',''); 
            $data['currency_list'] = get_dropdown_data(CURRENCY,'title','code',''); 
            $data['transection_type_list'] = get_dropdown_data(TRANSECTION_TYPES,'name','id','','person_type = '.$person_type); 
            $this->load->view('includes/template',$data);
	}
	 
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='customers/manage_customers'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='customers/manage_customers'; 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
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

            $this->form_validation->set_rules('person_id','Person','required');
            $this->form_validation->set_rules('trans_date','Date','required'); 
            $this->form_validation->set_rules('transection_amount','Amount','required|numeric|greater_than[0]'); 
      }	 
      
	function create(){   
            $inputs = $this->input->post();  
            $trans_id = get_autoincrement_no(TRANSECTION);       
            $cur_det = get_currency_for_code($inputs['currency_code']);
            $data['trans_tbl'] = array(
                                        'id' => $trans_id, 
                                        'transection_type_id' => $inputs['transection_type_id'], //cust_payment
                                        'reference' => $inputs['id'], 
                                        'person_type' => $inputs['person_type'], //customer
                                        'person_id' => $inputs['person_id'], 
                                        'transection_amount' => $inputs['transection_amount'],
                                        'trans_date' => strtotime($inputs['trans_date']),
                                        'currency_code' => $cur_det['code'], 
                                        'currency_value' => $cur_det['value'], 
                                        'trans_memo' => $inputs['memo'], 
                                        'status' => 1, 
                                    );
                    
            $data['trans_ref'] =array();
            $data['trans_inv'] =array();
            if(isset($inputs['allocation']) && !empty($inputs['allocation'])){
                foreach ($inputs['allocation'] as $trans_ref){ 
                    if($trans_ref['amount'] != 0){
                        $data['trans_ref'][] = array(
                                                   'transection_id'=>$trans_id,
                                                   'reference_id'=>$trans_ref['inv_id'],
                                                   'trans_reference'=>$trans_ref['inv_id'],
                                                   'person_type'=>$inputs['person_type'],
                                                   'transection_ref_amount'=>$trans_ref['amount'],
                                                   'status'=>1,
                                                   );
                        $due_amount = $trans_ref['amount_due'] - $trans_ref['amount']; 
                        if($due_amount <= 0){
                           $data['trans_inv'][$trans_ref['inv_id']] = array('payment_settled'=>1);
                        } 
                    }
                }
            }
            
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Payments_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Payments_model->get_single_row($add_stat[1]);
                    add_system_log(TRANSECTION, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD); 
                    redirect(base_url($this->router->fetch_class().'/'.$inputs['person_type'])); 
                }else{
                    $this->session->set_flashdata('warn',ERROR); 
                    redirect(base_url($this->router->fetch_class().'/'.$inputs['person_type'])); 
                } 
	}
	
	function update(){ 
            $inputs = $this->input->post();
            $customer_id = $inputs['id']; 
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
             //create Dir if not exists for store necessary images   
            if(!is_dir(CUSTOMER_LICENSE.$customer_id.'/')) mkdir(CUSTOMER_LICENSE.$customer_id.'/', 0777, TRUE); 

            $this->load->library('fileuploads'); //file upoad library created by FL
            $res_image = $this->fileuploads->upload_all('licence_image',CUSTOMER_LICENSE.$customer_id.'/');
            
            $data = array(
                            'customer_name' => $inputs['customer_name'],
                            'short_name' => $inputs['short_name'],
                            'customer_type_id' => $inputs['customer_type_id'],
                            'description' => $inputs['description'],
                            'nic_no' => $inputs['nic_no'],
                            'license_no' => $inputs['license_no'],
                            'status' => $inputs['status'],
                            'phone' => $inputs['phone'],
                            'fax' => $inputs['fax'],
                            'email' => $inputs['email'],
                            'website' => $inputs['website'],
                            'address' => $inputs['address'],
                            'city' => $inputs['city'],
                            'postal_code' => $inputs['postal_code'],
                            'state' => $inputs['state'],
                            'country' => $inputs['country'],
                            'commision_plan' => $inputs['commision_plan'],
                            'commission_value' => $inputs['commission_value'],
                            'credit_limit' => $inputs['credit_limit'],
                            'licence_image' => (!empty($res_image))?$res_image[0]['name']:'',
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
            
//            echo '<pre>'; print_r($data); die;
            //old data for log update
            $existing_data = $this->Payments_model->get_single_row($inputs['id']);

            $edit_stat = $this->Payments_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Payments_model->get_single_row($inputs['id']);
                add_system_log(CUSTOMERSS, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            $existing_data = $this->Payments_model->get_single_row($inputs['id']);
            $delete_stat = $this->Payments_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CUSTOMERSS, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Payments_model->get_single_row($inputs['id']);
            if($this->Payments_model->delete2_db($id)){
                //update log data
                add_system_log(HOTELS, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
        function load_data($id){
            
            $data['user_data'] = $this->Payments_model->get_single_row($id); 
            if(empty($data['user_data'])){
                $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                redirect(base_url($this->router->fetch_class()));
            }
            
            $data['customer_type_list'] = get_dropdown_data(CUSTOMER_TYPE,'customer_type_name','id',''); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','');
            $data['country_state_list'] = get_dropdown_data(COUNTRY_STATES,'state_name','id',''); 
            $data['country_district_list'] = get_dropdown_data(COUNTRY_DISTRICTS,'district_name','id',''); 
            return $data;	
	}	
        
        function search(){
		$search_data=array( 'customer_name' => $this->input->post('name'), 
                                    'category' => $this->input->post('category'), 
                                    ); 
		$data_view['search_list'] = $this->Payments_model->search_result($search_data);
                                        
		$this->load->view('customers/search_customers_result',$data_view);
	}
                    
        function get_sales_invoice_info($inv_id){
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
//            echo '<pre>';            print_r($data); die;
            return $data;
        }
        
        public function get_dues(){
//            echo '<pre>';            print_r($this->input->post()); die;
            $person_type = $this->input->post('person_type');
            $person_id = $this->input->post('person_id');
            $due_info = array();
            switch ($person_type){
                case 10: 
                    $this->load->model('Sales_invoices_model');
                    $dues = $this->Sales_invoices_model->search_result('','payment_settled=0 AND i.customer_id='.$person_id); 
                    foreach ($dues as $due_inv){
                        $data_arr = $this->get_sales_invoice_info($due_inv['id']);
                        $data_arr['trans_type'] = 'Sales Invoice';
                        $due_info[] =  $data_arr;
                       
                    }
            }
//            echo '<pre>';            print_r($due_info); die;
            echo json_encode($due_info);
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
