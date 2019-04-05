<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_ledgers extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('General_ledgers_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->General_ledgers_model->search_result();
            $data['form_setup'] = $this->input->get();
            $data['gl_acc_type_list'] = get_dropdown_data(GL_CHART_TYPE,'type_name','id','No Ledger Type');  
//            $data['vehicle_owner_list'] = get_dropdown_data(VEHICLE_OWNERS,'owner_name','id','All Owners');
            $data['main_content']='general_ledgers/search_general_ledgers';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content']='general_ledgers/manage_general_ledgers';  
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id);  
            $data['action']		= 'Edit';
            $data['main_content']='general_ledgers/manage_general_ledgers'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='general_ledgers/manage_general_ledgers'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='general_ledgers/manage_general_ledgers'; 
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
        
	function form_val_setrules(){ ;
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('account_name','Ledger Account Name','required|min_length[2]');   
            $this->form_validation->set_rules('account_code','Code','min_length[2]');   
      }	
        
	function create(){  
            $inputs = $this->input->post();   
            $cat_id = get_autoincrement_no(GL_CHART_MASTER); 
            $inputs['status'] = (isset($inputs['status']))?1:0; 
                    
            $data = array(
                            'id' => $cat_id,
                            'account_name' => $inputs['account_name'], 
                            'account_code' => $inputs['account_code'], 
                            'account_type_id' => $inputs['account_type_id'], 
                            'status' => $inputs['status'],  
                        ); 
                    
		$add_stat = $this->General_ledgers_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->General_ledgers_model->get_single_row($add_stat[1]);
                    add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update(){
            $inputs = $this->input->post();   
//                                echo '<pre>';                                print_r($inputs); die;
            $cat_id = $this->input->post('id');  
            $inputs['status'] = (isset($inputs['status']))?1:0; 
            $data = array( 
                            'account_name' => $inputs['account_name'], 
                            'account_code' => $inputs['account_code'], 
                            'account_type_id' => $inputs['account_type_id'], 
                            'status' => $inputs['status'],  
                        );  
                    
//            echo '<pre>';            print_r($data); die;
            //old data for log update
            $existing_data = $this->General_ledgers_model->get_single_row($inputs['id']);

            $edit_stat = $this->General_ledgers_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->General_ledgers_model->get_single_row($inputs['id']);
                add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
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
//                                'deleted_on' => date('Y-m-d'),
//                                'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                             ); 
            $delete_stat = $this->General_ledgers_model->delete_db($inputs['id'],$data);

                if($delete_stat){
                    //update log data
                    add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                    $this->session->set_flashdata('warn',RECORD_DELETE);
                    redirect(base_url($this->router->fetch_class()));
                }else{
                    $this->session->set_flashdata('error',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->General_ledgers_model->get_single_row($inputs['id']);
            if($this->General_ledgers_model->delete2_db($id)){
                //update log data
                add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
         function load_data($id=''){
             $data = array();
            if($id!=''){
                $data['user_data'] = $this->General_ledgers_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
//            echo '<pre>';            print_r($data); die;
            $data['gl_acc_list'] = get_dropdown_data(GL_CHART_MASTER,'account_name','id','');  
            $data['gl_acc_type_list'] = get_dropdown_data(GL_CHART_TYPE,'type_name','id','');  
            return $data;
         }
        
        function search(){
            $input = $this->input->post();
		$search_data=array( 'ledger_name' => $this->input->post('ledger_name'), 
                                    'gl_acc_type_id' => $this->input->post('gl_acc_type_id'),
                                    'status' => (isset($input['status']))?1:0 
                                ); 
		$data_view['search_list'] = $this->General_ledgers_model->search_result($search_data);
                
		$this->load->view('general_ledgers/search_general_ledgers_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('General_ledgers_model');
//            $data = $this->General_ledgers_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(ITEM_CAT,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
                    
                    
}
