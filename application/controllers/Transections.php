<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transections extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Transection_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Transection_model->search_result();
            $data['main_content']='transections/search_transections';  
            $data['category_list'] = get_dropdown_data(TRANSECTION_TYPES,'name','id','Agent Type');
//            echo '<pre>'; print_r($data); die;
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='transections/manage_transections';    
            $this->load->view('includes/template',$data);
	}
                    
	
	function delete_so_pop($id){ 
            $data  			= $this->load_data($id);
            $data['no_menu']		= 1;
//            echo '<pre>'; print_r($data); die;
            $data['action']		= 'Delete';
            $data['main_content']='transections/manage_transections'; 
            $this->load->view('includes/template_pos',$data);
	}
        
	function delete($id){ 
            $data  			= $this->load_data($id);
//            echo '<pre>'; print_r($data); die;
            $data['action']		= 'Delete';
            $data['main_content']='transections/manage_transections'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='transections/manage_transections'; 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
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

            $this->form_validation->set_rules('id','Trans ID','required'); 
      }	
                    
        function remove(){
            $inputs = $this->input->post(); 
            $this->load->model('Payments_model');
            $payment_info = $this->Payments_model->get_single_row($inputs['id']); 
//            echo '<pre>';            print_r($payment_info); die;
            $data['trans_tbl'] = array(
                                        'deleted' => 1,
                                        'deleted_on' => date('Y-m-d'),
                                        'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                                     ); 
            
            $cur_det = get_currency_for_code($payment_info['currency_code']);
                //GL Entries
            switch ($payment_info['person_type']){
                case 20:
                        $data['gl_trans'][] = array(
                                                        'person_type' => $payment_info['person_type'],
                                                        'person_id' => $payment_info['person_id'],
                                                        'trans_ref' => $payment_info['reference_id'],
                                                        'trans_date' => strtotime("now"),
                                                        'account' => 14, //14 AC Payable GL
                                                        'account_code' => 2100, 
                                                        'memo' => 'Supp Pay Remove',
                                                        'amount' => (-$payment_info['transection_amount']),
                                                        'currency_code' => $cur_det['code'], 
                                                        'currency_value' => $cur_det['value'],
                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                        'status' => 1,
                                                );
                        $data['gl_trans'][] = array(
                                                        'person_type' => $payment_info['person_type'],
                                                        'person_id' => $payment_info['person_id'],
                                                        'trans_ref' => $payment_info['reference_id'],
                                                        'trans_date' => strtotime("now"),
                                                        'account' => 1, //2 petty cash
                                                        'account_code' => 1060,
                                                        'memo' => 'Supp Pay Remove',
                                                        'amount' => ($payment_info['transection_amount']),
                                                        'currency_code' => $cur_det['code'], 
                                                        'currency_value' => $cur_det['value'],
                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                        'status' => 1,
                                                );
                        break;
                case 10:
                        $data['gl_trans'][] = array(
                                                        'person_type' => $payment_info['person_type'],
                                                        'person_id' => $payment_info['person_id'],
                                                        'trans_ref' => $payment_info['reference_id'],
                                                        'trans_date' => strtotime("now"),
                                                        'account' => 3, //14 AC Payable GL
                                                        'account_code' => 1200, 
                                                        'memo' => 'Cust Pay Remove',
                                                        'amount' => ($payment_info['transection_amount']),
                                                        'currency_code' => $cur_det['code'], 
                                                        'currency_value' => $cur_det['value'],
                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                        'status' => 1,
                                                );
                        $data['gl_trans'][] = array(
                                                        'person_type' => $payment_info['person_type'],
                                                        'person_id' => $payment_info['person_id'],
                                                        'trans_ref' => $payment_info['reference_id'],
                                                        'trans_date' => strtotime("now"),
                                                        'account' => 1, //2 petty cash
                                                        'account_code' => 1060,
                                                        'memo' => 'Cust Pay Remove',
                                                        'amount' => (-$payment_info['transection_amount']),
                                                        'currency_code' => $cur_det['code'], 
                                                        'currency_value' => $cur_det['value'],
                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                        'status' => 1,
                                                );
                        break;
                case 11:
                        $data['gl_trans'][] = array(
                                                        'person_type' => $payment_info['person_type'],
                                                        'person_id' => $payment_info['person_id'],
                                                        'trans_ref' => $payment_info['reference_id'],
                                                        'trans_date' => strtotime("now"),
                                                        'account' => 3, //14 AC Payable GL
                                                        'account_code' => 1200, 
                                                        'memo' => 'Cust Pay Remove for SO',
                                                        'amount' => ($payment_info['transection_amount']),
                                                        'currency_code' => $cur_det['code'], 
                                                        'currency_value' => $cur_det['value'],
                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                        'status' => 1,
                                                );
                        $data['gl_trans'][] = array(
                                                        'person_type' => $payment_info['person_type'],
                                                        'person_id' => $payment_info['person_id'],
                                                        'trans_ref' => $payment_info['reference_id'],
                                                        'trans_date' => strtotime("now"),
                                                        'account' => 1, //2 petty cash
                                                        'account_code' => 1060,
                                                        'memo' => 'Cust Pay Remove for SO',
                                                        'amount' => (-$payment_info['transection_amount']),
                                                        'currency_code' => $cur_det['code'], 
                                                        'currency_value' => $cur_det['value'],
                                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                                        'status' => 1,
                                                );
                        break;
            }
                
                
            $existing_data = $payment_info;
            $delete_stat = $this->Payments_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(ADDONS, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Transection_model->get_single_row($inputs['id']);
            if($this->Transection_model->delete2_db($id)){
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
                $data['user_data'] = $this->Transection_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            
            $data['calculation_included_addons_list'] = get_dropdown_data(ADDONS,'addon_name','id','',array('col'=>'id!=','val'=>$id));
            $data['calculation_included_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','');
            $data['addon_type_list'] = array('1'=>'Addition','2'=>'Substract');
            $data['calculation_type_list'] = array('1'=>'Fixed Amount','2'=>'Percentage','3'=>'Percentage (Included in Tarrifs)');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'concat(title, " - ", code)','code','Currency');
//            echo '<pre>';            print_r($data); die; 
            return $data;	
	}	
        
        function search(){
		$search_data=array( 
                                    'reference' => $this->input->post('reference'), 
                                    'amount' => $this->input->post('amount'), 
                                    'category' => $this->input->post('category'), 
                                    ); 
		$data_view['search_list'] = $this->Transection_model->search_result($search_data);
                                        
		$this->load->view('transections/search_transections_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Transection_model');
//            $data = $this->Transection_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(HOTELS,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        
                    
}
