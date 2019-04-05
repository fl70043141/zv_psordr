<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_location extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Inventory_location_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Inventory_location_model->search_result(); 
//            $data['vehicle_owner_list'] = get_dropdown_data(VEHICLE_OWNERS,'owner_name','id','All Owners');
            $data['main_content']='inventory_location/search_inventory_location';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content']='inventory_location/manage_inventory_location';  
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id);  
            $data['action']		= 'Edit';
            $data['main_content']='inventory_location/manage_inventory_location'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='inventory_location/manage_inventory_location'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='inventory_location/manage_inventory_location'; 
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

            $this->form_validation->set_rules('location_name','Location Name','required|min_length[2]');   
            $this->form_validation->set_rules('location_code','Short Name','required|min_length[2]|callback_check_unique_location_code');   
            $this->form_validation->set_rules('contact_person','Contact Person','required');   
            $this->form_validation->set_rules('description','description','min_length[2]');   
      }	
        
       function check_unique_location_code(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(INV_LOCATION,'location_name','id','','location_code = "'.$this->input->post('location_code').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(INV_LOCATION,'location_name','id','','location_code = "'.$this->input->post('location_code').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_location_code','Alrady exists,Should be unique');
                    return false;
                } 
        }
	function create(){  
            $inputs = $this->input->post();   
//                                                        echo '<pre>';                                print_r($inputs); die;

            $loc_id = get_autoincrement_no(INV_LOCATION); 
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $data = array(
                            'id' => $loc_id,
                            'location_name' => $inputs['location_name'],
                            'location_code' => $inputs['location_code'],
                            'contact_person' => $inputs['contact_person'],
                            'description' => $inputs['description'],
                            'contact_person' => $inputs['contact_person'],
                            'address' => $inputs['address'],
                            'phone' => $inputs['phone'],
                            'phone2' => $inputs['phone2'],
                            'email' => $inputs['email'],
                            'status' => $inputs['status'], 
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
//                 echo '<pre>';                                print_r($data); die;
                    
		$add_stat = $this->Inventory_location_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Inventory_location_model->get_single_row($add_stat[1]);
                    add_system_log(INV_LOCATION, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
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
            $data = array( 
                            'location_name' => $inputs['location_name'],
                            'location_code' => $inputs['location_code'],
                            'contact_person' => $inputs['contact_person'],
                            'description' => $inputs['description'],
                            'contact_person' => $inputs['contact_person'],
                            'address' => $inputs['address'],
                            'phone' => $inputs['phone'],
                            'phone2' => $inputs['phone2'],
                            'email' => $inputs['email'],
                            'status' => $inputs['status'], 
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
                            
//            echo '<pre>';            print_r($data); die;
            //old data for log update
            $existing_data = $this->Inventory_location_model->get_single_row($inputs['id']);

            $edit_stat = $this->Inventory_location_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Inventory_location_model->get_single_row($inputs['id']);
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
            
            $check_del = deletion_check(ITEMS, 'item_category_id', $inputs['id']); //has rates 
            if($check_del2==0 || $check_del2==0){                           
                $data = array(
                                'deleted' => 1, 
                                'deleted_on' => date('Y-m-d'),
                                'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                             ); 

                    $existing_data = $this->Inventory_location_model->get_single_row($inputs['id']);
                    $delete_stat = $this->Inventory_location_model->delete_db($inputs['id'],$data);

                if($delete_stat){
                    //update log data
                    add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                    $this->session->set_flashdata('warn',RECORD_DELETE);
                    redirect(base_url($this->router->fetch_class()));
                }else{
                    $this->session->set_flashdata('error',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
            }else{
                $this->session->set_flashdata('error','Can not delete! This Vehicle has rates or reservation.');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
            }
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Inventory_location_model->get_single_row($inputs['id']);
            if($this->Inventory_location_model->delete2_db($id)){
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
                $data['user_data'] = $this->Inventory_location_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            $data['item_uom_list'] = get_dropdown_data(ITEM_UOM,'unit_abbreviation','id',''); 
            $data['addon_type_list'] = array(0=>'Default');
            $data['item_type_list'] = array(1=>'Purchased',2=>'Service',3=>'Manufactured');
            return $data;
         }
        
        function search(){
            $input = $this->input->post();
		$search_data=array( 'location_name' => $this->input->post('location_name'), 
                                    'code' => $this->input->post('code'),
                                    'status' => (isset($input['status']))?1:0 
                                ); 
		$data_view['search_list'] = $this->Inventory_location_model->search_result($search_data);
                                        
		$this->load->view('inventory_location/search_inventory_location_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Inventory_location_model');
//            $data = $this->Inventory_location_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(ITEM_CAT,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
                    
                    
}
