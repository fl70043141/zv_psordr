<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currencies extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Currencies_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Currencies_model->search_result(); 
//            $data['vehicle_owner_list'] = get_dropdown_data(VEHICLE_OWNERS,'owner_name','id','All Owners');
            $data['main_content']='currencies/search_currencies';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content']='currencies/manage_currencies';  
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id);  
            $data['action']		= 'Edit';
            $data['main_content']='currencies/manage_currencies'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='currencies/manage_currencies'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='currencies/manage_currencies'; 
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

            $this->form_validation->set_rules('title','Currency Name','required|min_length[2]');  
            $this->form_validation->set_rules('code','Currency Name','required|min_length[2]');  
            $this->form_validation->set_rules('value','Currency Name','required|numeric|greater_than[0]');  
      }	
        
	function create(){  
            $inputs = $this->input->post();    
            $cur_id = get_autoincrement_no(CURRENCY); 
            $inputs['status'] = (isset($inputs['status']))?1:0; 
            
            $def_cur_val = ($this->session->userdata(SYSTEM_CODE)['default_currency_value']>0)?$this->session->userdata(SYSTEM_CODE)['default_currency_value']:1;
//            $cur_rate = $def_cur_val/$search['value'];
            $rel_value = $def_cur_val/$inputs['value'];
            $data = array(
                            'id' => $cur_id,
                            'title' => $inputs['title'],
                            'code' => $inputs['code'],
                            'code' => $inputs['code'],
                            'value' => $rel_value,
                            'symbol_left' => $inputs['symbol_left'],
                            'symbol_right' => $inputs['symbol_right'],
                            'decimal_place' => 2,
                            'status' => $inputs['status'],
                        );
                    
		$add_stat = $this->Currencies_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Currencies_model->get_single_row($add_stat[1]);
                    add_system_log(CURRENCY, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update(){
            $inputs = $this->input->post();   
            $inputs['status'] = (isset($inputs['status']))?1:0;
            
            $def_cur_val = ($this->session->userdata(SYSTEM_CODE)['default_currency_value']>0)?$this->session->userdata(SYSTEM_CODE)['default_currency_value']:1;
//            $cur_rate = $def_cur_val/$search['value'];
            $rel_value = $def_cur_val/$inputs['value'];
            $data = array(
                            'title' => $inputs['title'],
                            'code' => $inputs['code'],
                            'code' => $inputs['code'],
                            'value' => $rel_value,
                            'value_rate' => $inputs['value'],
                            'symbol_left' => $inputs['symbol_left'],
                            'symbol_right' => $inputs['symbol_right'],
                            'decimal_place' => 2,
                            'status' => $inputs['status'],
                        );
                            
            //old data for log update
            $existing_data = $this->Currencies_model->get_single_row($inputs['id']);
//            echo '<pre>';            print_r($existing_data); die;

            $edit_stat = $this->Currencies_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Currencies_model->get_single_row($inputs['id']);
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

                    $existing_data = $this->Currencies_model->get_single_row($inputs['id']);
                    $delete_stat = $this->Currencies_model->delete_db($inputs['id'],$data);

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
            
            $existing_data = $this->Currencies_model->get_single_row($inputs['id']);
            if($this->Currencies_model->delete2_db($id)){
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
                $data['user_data'] = $this->Currencies_model->get_single_row($id);
                
                $def_cur_val = ($this->session->userdata(SYSTEM_CODE)['default_currency_value']>0)?$this->session->userdata(SYSTEM_CODE)['default_currency_value']:1;
                $data['user_data'][0]['curr_rate'] = $def_cur_val/$data['user_data'][0]['value'];
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            $data['item_uom_list'] = get_dropdown_data(ITEM_UOM,'unit_abbreviation','id',''); 
            $data['addon_list'] = get_dropdown_data(ADDONS,'addon_name','id',''); 
//            $data['addon_type_list'] = array(0=>'Default');
            $data['item_type_list'] = array(1=>'Purchased',2=>'Service',3=>'Manufactured');
            return $data;
         }
        
        function search(){
            $input = $this->input->post();
		$search_data=array( 'type_name' => $this->input->post('customer_type_name'), 
                                    'status' => (isset($input['status']))?1:0 
                                ); 
		$data_view['search_list'] = $this->Currencies_model->search_result($search_data);
                                         
		$this->load->view('currencies/search_currencies_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Currencies_model');
//            $data = $this->Currencies_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(ITEM_CAT,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
                    
                    
}
