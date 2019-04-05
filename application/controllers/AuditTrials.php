<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuditTrials extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Audit_trial_model');
        }


        public function index()
	{
            $this->view_search_logs();
	}
        
        function view_search_logs($datas=''){
            $data = $this->load_data();
            $data['log_list'] = $this->Audit_trial_model->search_result();
            $data['main_content']='audit_trials/search_audit_trials'; 
            $this->load->view('includes/template',$data);
	}
                                        
	
	function view($id){ 
                $data['log_data'] = $this->Audit_trial_model->get_single_log($id); 
		$data['action']		= 'View';
		$data['main_content']='audit_trials/manage_audit_trial'; 
//                $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
		$this->load->view('includes/template',$data);
	}
	 
        function load_data(){
            
//            $data['log_data'] = $this->Audit_trial_model->get_single_log($id); 
            $data['module_list'] = get_dropdown_data(MODULES,'module_name','page_id', 'Object',array('col'=>'user_permission_apply','val'=>'1'),1);
            $data['action_list'] = array(
                                            'create' => 'Create', 
                                            'update' => 'Update', 
                                            'Remove' => 'Remove', 
                                        );
            return $data;	
	}	
        
        function search_audit_trials(){
		$search_data=array( 
                                    'name' => $this->input->post('user_name'), 
                                    'object' => $this->input->post('object'),
                                    'action' => $this->input->post('action'),
                                    'date_from' => $this->input->post('date_from'),
                                    'date_to' => $this->input->post('date_to'),
                                    ); 
		$data_view['log_list'] = $this->Audit_trial_model->search_result($search_data);
		
//                echo '<pre>';print_r($this->input->post()); die;
		$this->load->view('audit_trials/search_audit_trials_result',$data_view);
	}
                  
        function test(){
            echo 'okoo';
        }
}
