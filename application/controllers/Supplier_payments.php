<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_payments extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Customer_payments_model'); 
        }

        public function index(){
            $this->add();
	} 
        
	function add_supplier_payment($supp_id,$person_type='40'){
            $this->load->model('Vehicle_owners_model');
            $this->load->model('Transection_model');
            
            $data['owner_info'] = $this->Vehicle_owners_model->get_single_row($supp_id)[0];
            $owner_amounts = $this->Vehicle_owners_model->get_owner_amounts($supp_id);
            $data['total_invoiced_amount'] =0;
            $owner_amounts_arr = array();
            foreach ($owner_amounts as $owner_amount){
                if(!isset($owner_amounts_arr[$owner_amount['vehicle_owner_id']])){
                    $owner_amounts_arr[$owner_amount['vehicle_owner_id']] = 0;
                }
                $owner_amounts_arr[$owner_amount['vehicle_owner_id']] += $owner_amount['amount'];
            }
            $data['total_invoiced_amount'] = (isset($owner_amounts_arr[$supp_id])?$owner_amounts_arr[$supp_id]:0);
            
            $supp_transections = $this->Transection_model->get_transections_supplier($supp_id,$person_type);
            $total_trans = 0;
            foreach ($supp_transections as $trans){
                $total_trans += $trans['transection_amount'];
            }
            
            $data['pending_total_amount'] = $data['total_invoiced_amount'] + $total_trans;
            $data['total_tansection_amount'] = $total_trans;
            $data['action']		= 'Add';
            $data['main_content']='supplier_payments/manage_supplier_payments'; 
            $data['supplier_list'] = get_dropdown_data(VEHICLE_OWNERS,'owner_name','id','',array('col'=>'id','val'=>$supp_id));  
            $data['transection_type_list'] = get_dropdown_data(TRANSECTION_TYPES,'name','id','',array('col'=>'cats!=','val'=>'sales')); 
//            echo '<pre>';            print_r($data); die;
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
            $this->form_val_setrules(); 
            if($this->form_validation->run() == False){
                switch($this->input->post('action')){
                    case 'Add':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form'); 
                            $this->add_supplier_payment($this->input->post('id'));
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

            $this->form_validation->set_rules('supplier_id','Supplier','required');
            $this->form_validation->set_rules('trans_date','Date','required'); 
            $this->form_validation->set_rules('transection_amount','Amount','required|numeric|greater_than[0]'); 
      }	 
      
	function create(){   
            $inputs = $this->input->post(); 
                    
            
//            echo '<pre>';            print_r($inputs); die;
            $data = array(
                            'transection_type_id' => $inputs['transection_type_id'], //cust_payment
                            'description' => $inputs['reference_no'],
                            'person_type' => 40, //owner
                            'trans_reference' => $inputs['supplier_id'], 
                            'person_id' => $inputs['supplier_id'], 
                            'transection_amount' => $inputs['transection_amount'],
                            'trans_date' => strtotime($inputs['trans_date']),
                            'trans_memo' => $inputs['description'], 
                        );
                    
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Customer_payments_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Customer_payments_model->get_single_row($add_stat[1]);
                    add_system_log(TRANSECTION, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url('Vehicle_owners/edit/'.$inputs['supplier_id'])); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url('Vehicle_owners/'.$inputs['supplier_id'])); 
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
            $existing_data = $this->Customer_payments_model->get_single_row($inputs['id']);

            $edit_stat = $this->Customer_payments_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Customer_payments_model->get_single_row($inputs['id']);
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
                
            $existing_data = $this->Customer_payments_model->get_single_row($inputs['id']);
            $delete_stat = $this->Customer_payments_model->delete_db($inputs['id'],$data);
                    
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
            
            $existing_data = $this->Customer_payments_model->get_single_row($inputs['id']);
            if($this->Customer_payments_model->delete2_db($id)){
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
            
            $data['user_data'] = $this->Customer_payments_model->get_single_row($id); 
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
		$data_view['search_list'] = $this->Customer_payments_model->search_result($search_data);
                                        
		$this->load->view('customers/search_customers_result',$data_view);
	}
              
        function get_reservation_charges($res_id,$start,$end){ 
            $start_from = new DateTime(date('m/d/Y h:i A',$start));
            $end_to = new DateTime(date('m/d/Y h:i A',$end)); 
            $interval = $start_from->diff($end_to); 
            $days = $interval->format('%a'); 
//            echo date('m/d/Y h:i A',$start).'-'.date('m/d/Y h:i A',$end).'<br>days --'.$days.'<br><br>'; 
            
            $res_charges_tbl = $this->Bookings_model->get_reservation_charges($res_id);
            $res_charges_all = array('total'=>0);
            $res_charges_all['vehicles']['total']=$res_charges_all['addons']['total']=$res_charges_all['transection']['total']=0;
            
            foreach ($res_charges_tbl as $res_charge){
                
                if($res_charge['reservation_vehicle_id']>0){ //vehicle rate
                    $vehicle_info = $this->Bookings_model->get_reservation_vehicle($res_charge['reservation_id'],$res_charge['reservation_vehicle_id'])[0];
                    $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['vehicel_info'] = $vehicle_info;
                    $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['extra_km_amount']=0;
                    $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['calculated_km'] =0;
//                    $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['rate_amount']=0;
                                
                    switch ($res_charge['charge_type_id']) {
                        case 1: ///charge_type_id 1=> rent Amount 
                                $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['calculated_days']=0;
                                $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['rate_amount'] = $res_charge['amount'];
                                $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['calculated_days'] = $res_charge['amount'] * $days;;
                                
                                $res_charges_all['vehicles']['total'] += $res_charge['amount']* $days;
                                $res_charges_all['total'] += $res_charge['amount']* $days;
                                break;
                        case 2: ///charge_type_id 2=> Charge for extra KM
                                $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['extra_km_amount'] = $res_charge['amount'];
                                $km_def = ($vehicle_info['odo_meter_to'] - $vehicle_info['odo_meter_from']);   
                        
                                if($km_def > 0 && $km_def > ($days*$vehicle_info['km_limit_day'])){
                                    
                                    $exceeded_km = $km_def-($days*$vehicle_info['km_limit_day']);
                                    $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['calculated_km'] = $res_charge['amount']*abs($exceeded_km);
                                    $res_charges_all['vehicles']['total'] += $res_charge['amount']*abs($exceeded_km);
                                    $res_charges_all['total'] += $res_charge['amount']*abs($exceeded_km);
                                }
                                break;
                        case 3: ///charge_type_id 3=> Charge for extra time
//                                $res_charges_all['vehicles']['list'][$res_charge['reservation_vehicle_id']]['extra_time_amount'] = $res_charge['amount'];
//                                $res_charges_all['total'] += $res_charge['amount'];
                                break;

                        default:
                            break;
                    }
                }
                
                if($res_charge['addon_id']>0){ //addons rate
                    $this->load->model('Addons_model');
                    $addon_info = $this->Addons_model->get_single_row($res_charge['addon_id']);
                    $res_charges_all['addons']['list'][$res_charge['addon_id']]['addon_info'] = $addon_info[0];
                    $res_charges_all['addons']['list'][$res_charge['addon_id']]['addon_amount'] = $res_charge['amount'];
                      
                    $res_charges_all['addons']['total'] += $res_charge['amount'];
                    $res_charges_all['total'] += $res_charge['amount'];
//                      echo '<pre>';            print_r($res_charges_all); die;
                }
            }
            
            $res_charges_all['gross_total']=$res_charges_all['total'];
            //transections 
            $res_trans_tbl = $this->Bookings_model->get_transections($res_id);
            foreach ($res_trans_tbl as $trans){
                $res_charges_all['transection']['list'][$trans['id']]['transection_info'] = $trans;
                switch ($trans['calculation']){
                    case 1: //  addition from invoive
                            $res_charges_all['transection']['total'] += $trans['transection_amount'];
                            $res_charges_all['total'] += $trans['transection_amount'];
                            break;
                    case 2: //substitute from invoiice
                            $res_charges_all['transection']['total'] -= $trans['transection_amount'];
                            $res_charges_all['total'] -= $trans['transection_amount'];
                            break;
                    default:
                            break;
                } 
            }
//            echo '<pre>';            print_r($res_trans_tbl); die;
            
            return $res_charges_all;
        }
        
                    
}
