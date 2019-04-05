<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consignees extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Consignees_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Consignees_model->search_result();
            $data['main_content']='consignees/search_consignees';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content']='consignees/manage_consignees'; 
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code',''); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code',''); 
            $data['country_state_list'] = get_dropdown_data(COUNTRY_STATES,'state_name','id',''); 
            $data['country_district_list'] = get_dropdown_data(COUNTRY_DISTRICTS,'district_name','id',''); 
//            $data['country_city'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code',''); 
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='consignees/manage_consignees'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='consignees/manage_consignees'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='consignees/manage_consignees'; 
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

            $this->form_validation->set_rules('consignee_name','Name','required|min_length[2]');
            $this->form_validation->set_rules('consignee_short_name','Short Name','required|min_length[2]'); 
            $this->form_validation->set_rules('phone','phone','required|min_length[10]|integer'); 
            $this->form_validation->set_rules('commission_amount','Amount','numeric');     
      }	
                    
	function create(){   
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die;
            $consignee_id = get_autoincrement_no(CONSIGNEES);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
                    
            
            $data = array(
                            'id' => $consignee_id,
                            'consignee_name' => $inputs['consignee_name'],
                            'consignee_short_name' => $inputs['consignee_short_name'], 
                            'description' => $inputs['description'],
                            'address' => $inputs['address'], 
                            'status' => $inputs['status'],
                            'phone' => $inputs['phone'],
                            'phone2' => $inputs['phone2'],
                            'email' => $inputs['email'],
                            'bank_acc_number' => $inputs['bank_acc_number'],
                            'bank_acc_name' => $inputs['bank_acc_name'],
                            'bank_name' => $inputs['bank_name'],
                            'bank_acc_branch' => $inputs['bank_acc_branch'],
                            'commission_plan' => $inputs['commission_plan'],
                            'commission_amount' => $inputs['commission_amount'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
                    
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Consignees_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Consignees_model->get_single_row($add_stat[1]);
                    add_system_log(CONSIGNEES, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update(){ 
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($this->input->post()); die;
            $supplier_id = $inputs['id']; 
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            } 
            $data = array(
                            'consignee_name' => $inputs['consignee_name'],
                            'consignee_short_name' => $inputs['consignee_short_name'], 
                            'description' => $inputs['description'],
                            'address' => $inputs['address'], 
                            'status' => $inputs['status'],
                            'phone' => $inputs['phone'],
                            'phone2' => $inputs['phone2'],
                            'email' => $inputs['email'],
                            'bank_acc_number' => $inputs['bank_acc_number'],
                            'bank_acc_name' => $inputs['bank_acc_name'],
                            'bank_name' => $inputs['bank_name'],
                            'bank_acc_branch' => $inputs['bank_acc_branch'],
                            'commission_plan' => $inputs['commission_plan'],
                            'commission_amount' => $inputs['commission_amount'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
            
//            echo '<pre>'; print_r($data); die;
            //old data for log update
            $existing_data = $this->Consignees_model->get_single_row($inputs['id']);

            $edit_stat = $this->Consignees_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Consignees_model->get_single_row($inputs['id']);
                add_system_log(CONSIGNEES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
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
                
            $existing_data = $this->Consignees_model->get_single_row($inputs['id']);
            $delete_stat = $this->Consignees_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CONSIGNEES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Consignees_model->get_single_row($inputs['id']);
            if($this->Consignees_model->delete2_db($id)){
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
            
            $data['user_data'] = $this->Consignees_model->get_single_row($id); 
            if(empty($data['user_data'])){
                $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                redirect(base_url($this->router->fetch_class()));
            }
            
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code',''); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','');
            $data['country_state_list'] = get_dropdown_data(COUNTRY_STATES,'state_name','id',''); 
            $data['country_district_list'] = get_dropdown_data(COUNTRY_DISTRICTS,'district_name','id',''); 
            return $data;	
	}	
        
        function search(){
		$search_data=array( 'consignee_name' => $this->input->post('name'), 
                                    'code' => $this->input->post('code'), 
                                    'phone' => $this->input->post('phone'), 
                                    ); 
		$data_view['search_list'] = $this->Consignees_model->search_result($search_data);
                                        
		$this->load->view('consignees/search_consignees_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Consignees_model');
//            $data = $this->Consignees_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(HOTELS,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        
                    
}
