<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_UOM extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Item_UOM_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Item_UOM_model->search_result();
            $data['form_setup'] = $this->input->get(); 
            $data['main_content']='item_UOM/search_item_UOM';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content']='item_UOM/manage_item_UOM';  
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id);  
            $data['action']		= 'Edit';
            $data['main_content']='item_UOM/manage_item_UOM'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='item_UOM/manage_item_UOM'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='item_UOM/manage_item_UOM'; 
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

            $this->form_validation->set_rules('unit_abbreviation','Abbreviation','required');   
      }	
        
	function create(){  
            $inputs = $this->input->post();  
            $inputs['status'] = (isset($inputs['status']))?1:0;
                    
            $data = array(
                            'unit_abbreviation' => $inputs['unit_abbreviation'],
                            'unit_description' => $inputs['unit_description'],
                            'descimal_point' => $inputs['descimal_point'],
                            'status' => $inputs['status'], 
                        );
//                                echo '<pre>';                                print_r($data); die;
                    
		$add_stat = $this->Item_UOM_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Item_UOM_model->get_single_row($add_stat[1]);
                    add_system_log(ITEM_UOM, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
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
                            'unit_abbreviation' => $inputs['unit_abbreviation'],
                            'unit_description' => $inputs['unit_description'],
                            'descimal_point' => $inputs['descimal_point'],
                            'status' => $inputs['status'], 
                        ); 
                            
//            echo '<pre>';            print_r($data); die;
            //old data for log update
            $existing_data = $this->Item_UOM_model->get_single_row($inputs['id']);

            $edit_stat = $this->Item_UOM_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Item_UOM_model->get_single_row($inputs['id']);
                add_system_log(ITEM_UOM, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();
            
            $check_del = deletion_check(ITEMS, 'item_uom_id', $inputs['id']); //has rates
            $check_del2 = deletion_check(ITEM_CAT, 'item_uom_id', $inputs['id']); //has rates
            if($check_del2==0 || $check_del2==0){                           
                $data = array(
                                'deleted' => 1, 
                             ); 

                    $existing_data = $this->Item_UOM_model->get_single_row($inputs['id']);
                    $delete_stat = $this->Item_UOM_model->delete_db($inputs['id'],$data);

                if($delete_stat){
                    //update log data
                    add_system_log(ITEM_UOM, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
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
            
            $existing_data = $this->Item_UOM_model->get_single_row($inputs['id']);
            if($this->Item_UOM_model->delete2_db($id)){
                //update log data
                add_system_log(ITEM_UOM, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
         function load_data($id=''){
             $data=array();
            if($id!=''){
                $data['user_data'] = $this->Item_UOM_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           return $data;
         }
        
        function search(){
            $input = $this->input->post();
		$search_data=array( 'unit_description' => $this->input->post('unit_description'), 
                                    'status' => (isset($input['status']))?1:0 
                                ); 
		$data_view['search_list'] = $this->Item_UOM_model->search_result($search_data);
                                        
		$this->load->view('item_UOM/search_item_UOM_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Item_UOM_model');
//            $data = $this->Item_UOM_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(ITEM_UOM,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
                    
                    
}
