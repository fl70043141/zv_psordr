<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addons extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Addons_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Addons_model->search_result();
            $data['main_content']='addons/search_addons'; 
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='addons/manage_addons';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='addons/manage_addons'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='addons/manage_addons'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='addons/manage_addons'; 
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

            $this->form_validation->set_rules('addon_name','Addon Name','required|min_length[2]');
            $this->form_validation->set_rules('active_from','Active From','required');
            $this->form_validation->set_rules('active_to','End date','required');
            $this->form_validation->set_rules('addon_value','Addon Value','required');
            $this->form_validation->set_rules('addon_type','Addon Type','required');
            $this->form_validation->set_rules('calculation_type','Clculation Type','required');
      }	
        
	function create(){  
            
//            echo '<pre>';            print_r($this->input->post()); die;
            $inputs = $this->input->post();
            $inputs['ignore_end_date'] = (isset($inputs['ignore_end_date']))?$inputs['ignore_end_date']:0;
            $inputs['status'] = (isset($inputs['status']))?$inputs['status']:0;
            
            $cur_det = get_currency_for_code($this->session->userdata(SYSTEM_CODE)['default_currency']);
            
            $data = array(
                            'addon_name' => $inputs['addon_name'], 
                            'description' => $inputs['description'], 
                            'active_from' => strtotime($inputs['active_from']), 
                            'active_to' => strtotime($inputs['active_to']), 
                            'addon_value' => $inputs['addon_value'], 
                            'ignore_end_date' => $inputs['ignore_end_date'], 
                            'currency_code' => $inputs['currency_code'], 
                            'currency_value' => $inputs['value'], 
                            'calculation_type' => $inputs['calculation_type'], 
                            'calculation_included' => (isset($inputs['calculation_included']))?json_encode($inputs['calculation_included']):'', 
                            'calculation_included_addons' => (isset($inputs['calculation_included_addons']))?json_encode($inputs['calculation_included_addons']):'', 
                            'status' => $inputs['status'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
                    
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Addons_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Addons_model->get_single_row($add_stat[1]);
                    add_system_log(ADDONS, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update(){ 
            $inputs = $this->input->post();
            $agent_id = $inputs['id'];  
            $inputs['status'] = (isset($inputs['status']))?$inputs['status']:0;
            $inputs['ignore_end_date'] = (isset($inputs['ignore_end_date']))?$inputs['ignore_end_date']:0;
            
            $cur_det = get_currency_for_code($this->session->userdata(SYSTEM_CODE)['default_currency']);
                    
            $data = array(
                            'addon_name' => $inputs['addon_name'], 
                            'description' => $inputs['description'], 
                            'active_from' => strtotime($inputs['active_from']), 
                            'active_to' => strtotime($inputs['active_to']), 
                            'ignore_end_date' => $inputs['ignore_end_date'], 
                            'addon_type' => $inputs['addon_type'], 
                            'addon_value' => $inputs['addon_value'], 
                            'debit_gl_code' => $inputs['debit_gl_code'], 
                            'credit_gl_code' => $inputs['credit_gl_code'], 
                            'currency_code' => $cur_det['code'], 
                            'currency_value' => $cur_det['value'], 
                            'calculation_type' => $inputs['calculation_type'], 
                            'calculation_included' => (isset($inputs['calculation_included']))?json_encode($inputs['calculation_included']):'', 
                            'calculation_included_addons' => (isset($inputs['calculation_included_addons']))?json_encode($inputs['calculation_included_addons']):'', 
                            'status' => $inputs['status'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
            
//            echo '<pre>'; print_r($data); die;
            //old data for log update
            $existing_data = $this->Addons_model->get_single_row($inputs['id']);

            $edit_stat = $this->Addons_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Addons_model->get_single_row($inputs['id']);
                add_system_log(ADDONS, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
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
                
            $existing_data = $this->Addons_model->get_single_row($inputs['id']);
            $delete_stat = $this->Addons_model->delete_db($inputs['id'],$data);
                    
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
            
            $existing_data = $this->Addons_model->get_single_row($inputs['id']);
            if($this->Addons_model->delete2_db($id)){
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
                $data['user_data'] = $this->Addons_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            
            $data['gl_acc_list'] = get_dropdown_data(GL_CHART_MASTER,array('account_name',"CONCAT(account_name,'-',account_code) as account_name"),'account_code','');  
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
                                    'name' => $this->input->post('name'), 
                                    'category' => $this->input->post('category'), 
                                    ); 
		$data_view['search_list'] = $this->Addons_model->search_result($search_data);
                                        
		$this->load->view('addons/search_addons_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Addons_model');
//            $data = $this->Addons_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(HOTELS,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        
                    
}
