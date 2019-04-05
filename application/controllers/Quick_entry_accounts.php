<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quick_entry_accounts extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('GL_quick_entry_accounts_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->GL_quick_entry_accounts_model->search_result();
            $data['form_setup'] = $this->input->get();
//            $data['vehicle_owner_list'] = get_dropdown_data(VEHICLE_OWNERS,'owner_name','id','All Owners');
            $data['main_content']='gl_quick_entry_accounts/search_gl_quick_entry_accounts';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content']='gl_quick_entry_accounts/manage_gl_quick_entry_accounts';  
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id);  
            $data['action']		= 'Edit';
            $data['main_content']='gl_quick_entry_accounts/manage_gl_quick_entry_accounts'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='gl_quick_entry_accounts/manage_gl_quick_entry_accounts'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='gl_quick_entry_accounts/manage_gl_quick_entry_accounts'; 
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
            $this->form_validation->set_rules('short_name','Short Name','min_length[2]|required');   
            $this->form_validation->set_rules('debit_gl_code','Debit Ledger Account','required');   
            $this->form_validation->set_rules('credit_gl_code','Credit Ledger Account','required');   
      }	
        
	function create(){  
            $inputs = $this->input->post(); 
            $id = get_autoincrement_no(GL_QUICK_ENTRY_ACC); 
            $inputs['status'] = (isset($inputs['status']))?1:0; 
                    
            $data = array(
                            'id' => $id,
                            'account_name' => $inputs['account_name'], 
                            'short_name' => $inputs['short_name'], 
                            'debit_gl_code' => $inputs['debit_gl_code'], 
                            'credit_gl_code' => $inputs['credit_gl_code'], 
                            'status' => $inputs['status'], 
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'], 
                        ); 
                    
		$add_stat = $this->GL_quick_entry_accounts_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->GL_quick_entry_accounts_model->get_single_row($add_stat[1]);
                    add_system_log(GL_QUICK_ENTRY_ACC, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
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
                            'short_name' => $inputs['short_name'], 
                            'debit_gl_code' => $inputs['debit_gl_code'], 
                            'credit_gl_code' => $inputs['credit_gl_code'], 
                            'status' => $inputs['status'], 
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'], 
                        );  
                    
            //old data for log update
            $existing_data = $this->GL_quick_entry_accounts_model->get_single_row($inputs['id']);

            $edit_stat = $this->GL_quick_entry_accounts_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->GL_quick_entry_accounts_model->get_single_row($inputs['id']);
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
                                'deleted_on' => date('Y-m-d'),
                                'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                             ); 
            $delete_stat = $this->GL_quick_entry_accounts_model->delete_db($inputs['id'],$data);

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
            
            $existing_data = $this->GL_quick_entry_accounts_model->get_single_row($inputs['id']);
            if($this->GL_quick_entry_accounts_model->delete2_db($id)){
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
                $data['user_data'] = $this->GL_quick_entry_accounts_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
//            echo '<pre>';            print_r($data); die;
            $data['gl_acc_list'] = get_dropdown_data(GL_CHART_MASTER,array('account_name',"CONCAT(account_name,'-',account_code) as account_name"),'account_code','');  
            return $data;
         }
        
        function search(){
            $input = $this->input->post();
		$search_data=array( 'account_name' => $this->input->post('account_name'), 
                                    'status' => (isset($input['status']))?1:0 
                                ); 
		$data_view['search_list'] = $this->GL_quick_entry_accounts_model->search_result($search_data);
                                        
		$this->load->view('gl_quick_entry_accounts/search_gl_quick_entry_accounts_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('GL_quick_entry_accounts_model');
//            $data = $this->GL_quick_entry_accounts_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(ITEM_CAT,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
                    
                    
}
