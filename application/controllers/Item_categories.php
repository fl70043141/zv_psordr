<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_categories extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Item_categories_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Item_categories_model->search_result();
            $data['form_setup'] = $this->input->get();
//            $data['vehicle_owner_list'] = get_dropdown_data(VEHICLE_OWNERS,'owner_name','id','All Owners');
            $data['main_content']='item_categories/search_item_categories';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content']='item_categories/manage_item_categories';  
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id);  
            $data['action']		= 'Edit';
            $data['main_content']='item_categories/manage_item_categories'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='item_categories/manage_item_categories'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='item_categories/manage_item_categories'; 
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

            $this->form_validation->set_rules('category_name','Category Name','required|min_length[2]');   
            $this->form_validation->set_rules('category_code','Category Code','required|callback_check_unique_catcode');   
            $this->form_validation->set_rules('description','description','min_length[2]');   
      }	
      
       function check_unique_catcode(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(ITEM_CAT,'category_name','id','','category_code = "'.$this->input->post('category_code').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(ITEM_CAT,'category_name','id','','category_code = "'.$this->input->post('category_code').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_catcode','Alrady exists,Should be unique');
                    return false;
                } 
        }
        
	function create(){
            $inputs = $this->input->post();   
            $cat_id = get_autoincrement_no(ITEM_CAT); 
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $inputs['sales_excluded'] = (isset($inputs['sales_excluded']))?1:0;
            $inputs['purchases_excluded'] = (isset($inputs['purchases_excluded']))?1:0;
            $inputs['show_pos'] = (isset($inputs['show_pos']))?1:0;
            $inputs['is_gem'] = (isset($inputs['is_gem']))?1:0;
                    
              //create Dir if not exists for store necessary images   
            if(!is_dir(CAT_IMAGES.$cat_id.'/')) mkdir(CAT_IMAGES.$cat_id.'/', 0777, TRUE); 
            
            $this->load->library('fileuploads'); //file upoad library created by FL
            $def_image = $this->fileuploads->upload_all('cat_image',CAT_IMAGES.$cat_id.'/');
            
            $data = array(
                            'id' => $cat_id,
                            'category_name' => $inputs['category_name'],
                            'category_code' => $inputs['category_code'],
                            'item_uom_id' => $inputs['item_uom_id'],
                            'item_uom_id_2' => $inputs['item_uom_id_2'],
                            'parent_cat_id' => $inputs['parent_cat_id'],
                            'order_by' => $inputs['order_by'], 
                            'item_type_id' => $inputs['item_type_id'],
                            'description' => $inputs['description'],
                            'addon_type_id' => $inputs['addon_type_id'],
                            'sales_excluded' => $inputs['sales_excluded'],
                            'purchases_excluded' => $inputs['purchases_excluded'],
                            'cat_image' => (!empty($def_image))?$def_image[0]['name']:'',
                            'show_pos' => $inputs['show_pos'], 
                            'is_gem' => $inputs['is_gem'], 
                            'status' => $inputs['status'], 
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
//                                echo '<pre>';                                print_r($data); die;
                    
		$add_stat = $this->Item_categories_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Item_categories_model->get_single_row($add_stat[1]);
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
            $cat_id = $this->input->post('id');  
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $inputs['sales_excluded'] = (isset($inputs['sales_excluded']))?1:0;
            $inputs['purchases_excluded'] = (isset($inputs['purchases_excluded']))?1:0;
            $inputs['is_gem'] = (isset($inputs['is_gem']))?1:0;
            
              //create Dir if not exists for store necessary images   
            if(!is_dir(CAT_IMAGES.$cat_id.'/')) mkdir(CAT_IMAGES.$cat_id.'/', 0777, TRUE); 
            
            $this->load->library('fileuploads'); //file upoad library created by FL
            $def_image = $this->fileuploads->upload_all('cat_image',CAT_IMAGES.$cat_id.'/');
                                
            $data = array(
                            'category_name' => $inputs['category_name'],
                            'category_code' => $inputs['category_code'],
                            'item_uom_id' => $inputs['item_uom_id'],
                            'item_uom_id_2' => $inputs['item_uom_id_2'],
                            'item_type_id' => $inputs['item_type_id'],
                            'parent_cat_id' => $inputs['parent_cat_id'],
                            'order_by' => $inputs['order_by'], 
                            'description' => $inputs['description'],
                            'addon_type_id' => $inputs['addon_type_id'],
                            'sales_excluded' => $inputs['sales_excluded'],
                            'purchases_excluded' => $inputs['purchases_excluded'],
                            'show_pos' => $inputs['show_pos'], 
                            'is_gem' => $inputs['is_gem'], 
                            'status' => $inputs['status'], 
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
            
                        if(!empty($def_image)) $data['cat_image'] = $def_image[0]['name']; 
                            
//            echo '<pre>';            print_r($data); die;
            //old data for log update
            $existing_data = $this->Item_categories_model->get_single_row($inputs['id']);

            $edit_stat = $this->Item_categories_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Item_categories_model->get_single_row($inputs['id']);
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

                    $existing_data = $this->Item_categories_model->get_single_row($inputs['id']);
                    $delete_stat = $this->Item_categories_model->delete_db($inputs['id'],$data);

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
            
            $existing_data = $this->Item_categories_model->get_single_row($inputs['id']);
            if($this->Item_categories_model->delete2_db($id)){
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
                $data['user_data'] = $this->Item_categories_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            $data['item_uom_list'] = get_dropdown_data(ITEM_UOM,'unit_abbreviation','id',''); 
            $data['item_uom_list_2'] = get_dropdown_data(ITEM_UOM,'unit_abbreviation','id','No Secondor UOM'); 
            $data['addon_type_list'] = array(0=>'Default');
            $data['item_type_list'] = array(1=>'Purchased',2=>'Service',3=>'Manufactured');
            $data['item_cat_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Category','id != '.$id); 
//            echo '<pre>';            print_r($data); die;
            return $data;
         }
        
        function search(){
            $input = $this->input->post();
		$search_data=array( 'cat_name' => $this->input->post('cat_name'), 
                                    'category_code' => $this->input->post('category_code'), 
                                    'status' => (isset($input['status']))?1:0 
                                ); 
		$data_view['search_list'] = $this->Item_categories_model->search_result($search_data);
                                        
		$this->load->view('item_categories/search_item_categories_result',$data_view);
	}
                                        
        function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Item_categories_model');
//            $data = $this->Item_categories_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(ITEM_CAT,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
                    
                    
}
