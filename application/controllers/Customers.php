<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Customers_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Customers_model->search_result();
            $data['main_content']='customers/search_customers'; 
            $data['category_list'] = get_dropdown_data(CUSTOMER_TYPE,'customer_type_name','id','Customer Type');
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data['action']		= 'Add';
            $data['main_content']='customers/manage_customers'; 
            $data['customer_type_list'] = get_dropdown_data(CUSTOMER_TYPE,'customer_type_name','id',''); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code',''); 
            $data['country_state_list'] = get_dropdown_data(COUNTRY_STATES,'state_name','id',''); 
            $data['country_district_list'] = get_dropdown_data(COUNTRY_DISTRICTS,'district_name','id',''); 
//            $data['country_city'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code',''); 
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='customers/manage_customers'; 
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

            $this->form_validation->set_rules('customer_name','Customer Name','required|min_length[2]');
            $this->form_validation->set_rules('short_name','Short Name','required|callback_check_unique_code');
            $this->form_validation->set_rules('customer_type_id','Property Type','required');
//            $this->form_validation->set_rules('address','Address','required');
            $this->form_validation->set_rules('city','City','required');
//            $this->form_validation->set_rules('commision_plan','Commission Plan','required');
            $this->form_validation->set_rules('phone','phone','required|min_length[10]|integer'); 
//            $this->form_validation->set_rules('commission_value','Commission Value','required|numeric'); 
//            $this->form_validation->set_rules('credit_limit','Credit Limit','required|numeric'); 
//            $this->form_validation->set_rules('postal_code','Postal Code','required'); 
      }	
      
      function check_unique_nic(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(CUSTOMERS,'customer_name','id','','nic_no = "'.$this->input->post('nic_no').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(CUSTOMERS,'customer_name','id','','nic_no = "'.$this->input->post('nic_no').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_nic','Alrady exists,Should be unique');
                    return false;
                } 
        }
      
      function check_unique_license(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(CUSTOMERS,'customer_name','id','','license_no = "'.$this->input->post('license_no').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(CUSTOMERS,'customer_name','id','','license_no = "'.$this->input->post('license_no').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_license','Alrady exists,Should be unique');
                    return false;
                } 
        }
      function check_unique_code(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(CUSTOMERS,'customer_name','id','','short_name = "'.$this->input->post('short_name').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(CUSTOMERS,'customer_name','id','','short_name = "'.$this->input->post('short_name').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_code','Alrady exists,Should be unique');
                    return false;
                } 
        }
        
	function create(){
            
//            echo '<pre>';            print_r($this->input->post()); die;
            $inputs = $this->input->post();
            $cust_id = get_autoincrement_no(CUSTOMERS);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
             //create Dir if not exists for store necessary images   
            if(!is_dir(CUSTOMER_IMAGES.$cust_id.'/')) mkdir(CUSTOMER_IMAGES.$cust_id.'/', 0777, TRUE); 

            $this->load->library('fileuploads'); //file upoad library created by FL
            $res_image = $this->fileuploads->upload_all('customer_image',CUSTOMER_IMAGES.$cust_id.'/');
            
//            echo '<pre>';            print_r($res_image); die;
                    
            $data['customer'] = array(
                            'id' => $cust_id,
                            'customer_name' => $inputs['customer_name'],
                            'short_name' => $inputs['short_name'],
                            'customer_type_id' => $inputs['customer_type_id'],
                            'description' => $inputs['description'], 
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
                            'customer_image' => (!empty($res_image))?$res_image[0]['name']:'',
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
            
                    //customer Branche auto create**************
                    $cust_branch_id = get_autoincrement_no(CUSTOMER_BRANCHES);

                    $data['customer_branch'] = array(
                                                    'id' => $cust_branch_id,
                                                    'customer_id' => $cust_id,
                                                    'branch_name' => $inputs['customer_name'],
                                                    'branch_short_name' => $inputs['short_name'],   
                                                    'billing_address' => $inputs['address'].' '.$inputs['city'],   
                                                    'phone' => $inputs['phone'],
                                                    'fax' => $inputs['fax'],
                                                    'email' => $inputs['email'],
                                                    'status' => $inputs['status'],
                                                    'added_on' => date('Y-m-d'),
                                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                );
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Customers_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Customers_model->get_single_row($add_stat[1]);
                    add_system_log(CUSTOMERSS, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
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
            if(!is_dir(CUSTOMER_IMAGES.$customer_id.'/')) mkdir(CUSTOMER_IMAGES.$customer_id.'/', 0777, TRUE); 

            $this->load->library('fileuploads'); //file upoad library created by FL
            $res_image = $this->fileuploads->upload_all('customer_image',CUSTOMER_IMAGES.$customer_id.'/');
            
            $data = array(
                            'customer_name' => $inputs['customer_name'],
                            'short_name' => $inputs['short_name'],
                            'customer_type_id' => $inputs['customer_type_id'],
                            'description' => $inputs['description'], 
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
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
            
            if(!empty($res_image)){
                $data['customer_image'] = $res_image[0]['name'];
            }
//            echo '<pre>'; print_r($data); die;
            //old data for log update
            $existing_data = $this->Customers_model->get_single_row($inputs['id']);

            $edit_stat = $this->Customers_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Customers_model->get_single_row($inputs['id']);
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
                
            $existing_data = $this->Customers_model->get_single_row($inputs['id']);
            $delete_stat = $this->Customers_model->delete_db($inputs['id'],$data);
                    
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
            
            $existing_data = $this->Customers_model->get_single_row($inputs['id']);
            if($this->Customers_model->delete2_db($id)){
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
            
            $data['user_data'] = $this->Customers_model->get_single_row($id); 
            if(empty($data['user_data'])){
                $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                redirect(base_url($this->router->fetch_class()));
            }
            $data['customer_branches'] = $this->Customers_model->get_single_row_branch('',$id);
            $data['customer_type_list'] = get_dropdown_data(CUSTOMER_TYPE,'customer_type_name','id',''); 
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','');
            $data['country_state_list'] = get_dropdown_data(COUNTRY_STATES,'state_name','id',''); 
            $data['country_district_list'] = get_dropdown_data(COUNTRY_DISTRICTS,'district_name','id',''); 
//                        echo '<pre>';            print_r($data); die;
            return $data;	
	}	
        
        function search(){
		$search_data=array( 'customer_name' => $this->input->post('name'), 
                                    'code' => $this->input->post('code'), 
                                    'costomer_phone' => $this->input->post('phone'), 
                                    'category' => $this->input->post('category'), 
                                    ); 
		$data_view['search_list'] = $this->Customers_model->search_result($search_data);
                                        
		$this->load->view('customers/search_customers_result',$data_view);
	}
              
        
	function add_branch($customer_id){ 
            $data['action']		= 'Add';
            $data['customer_det']       = $this->Customers_model->get_single_row($customer_id)[0];
//            $data['customer_branch_det']       = $this->Customers_model->get_single_row_branch($id)[0];
            $data['main_content']='customers/manage_customer_branch'; 
            $data['sales_person_list'] = get_dropdown_data(SALES_PERSONS,'sales_person_name','id','Sales Person',''); 
//            echo '<pre>';            print_r($data); die;
            $this->load->view('includes/template',$data);
	}

        function load_data_branch($cust_id,$id=''){
            $data['customer_det']       = $this->Customers_model->get_single_row($cust_id)[0];
            $data['customer_branch_det']       = $this->Customers_model->get_single_row_branch($id)[0];
            $data['sales_person_list'] = get_dropdown_data(SALES_PERSONS,'sales_person_name','id','Sales Person',''); 
            return $data;
        }
        function edit_branch($cust_id='',$id){ 
            $data = $this->load_data_branch($cust_id,$id);
            $data['action']		= 'Edit';
            $data['main_content']='customers/manage_customer_branch'; 
//                        echo '<pre>';            print_r($data); die;
            $this->load->view('includes/template',$data);
	}
	
	function delete_branch($cust_id='',$id){ 
            $data = $this->load_data_branch($cust_id,$id);
            $data['action']		= 'Delete';
            $data['main_content']='customers/manage_customer_branch'; 
            $this->load->view('includes/template',$data);
	}
	
	function view_branch($cust_id='',$id){ 
            $data = $this->load_data_branch($cust_id,$id);
            $data['action']		= 'View';
            $data['main_content']='customers/manage_customer_branch'; 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
            $this->load->view('includes/template',$data);
	}
        
        
	function validate_branch(){   
//                        echo '<pre>';            print_r($this->input->post()); die;
            $this->form_val_setrules_branch(); 
            if($this->form_validation->run() == False){
                switch($this->input->post('action')){
                    case 'Add':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form'); 
                            $this->add_branch($this->input->post('customer_id'));
                            break;
                    case 'Edit':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form');
                            $this->edit_branch($this->input->post('customer_id'),$this->input->post('id'));
                            break;
                    case 'Delete':
                            $this->delete_branch($this->input->post('customer_id'),$this->input->post('id'));
                            break;
                } 
            }
            else{
                switch($this->input->post('action')){
                    case 'Add':
                            $this->create_branch();
                    break;
                    case 'Edit':
                        $this->update_branch();
                    break;
                    case 'Delete':
                        $this->remove_branch();
                    break;
                    case 'View':
                        $this->view_branch();
                    break;
                }	
            }
	}
        
	function form_val_setrules_branch(){
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('branch_name','Customer Branch Name','required|min_length[2]');
            $this->form_validation->set_rules('branch_short_name','Short Name','required|min_length[2]'); 
            $this->form_validation->set_rules('sales_person_id','Sales Person','required');
            $this->form_validation->set_rules('contact_person','Contact Person Name','required');
            $this->form_validation->set_rules('mailing_address','Address','required'); 
            $this->form_validation->set_rules('phone','phone','required|min_length[10]|integer'); 
      }	
        function create_branch(){  
            
//            echo '<pre>';            print_r($this->input->post()); die;
            $inputs = $this->input->post();
            $cust_branch_id = get_autoincrement_no(CUSTOMER_BRANCHES);
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
                    
            $data = array(
                            'id' => $cust_branch_id,
                            'customer_id' => $inputs['customer_id'],
                            'branch_name' => $inputs['branch_name'],
                            'branch_short_name' => $inputs['branch_short_name'],
                            'contact_person' => $inputs['contact_person'],
                            'sales_person_id' => $inputs['sales_person_id'],
                            'description' => $inputs['description'],
                            'mailing_address' => $inputs['mailing_address'],
                            'billing_address' => $inputs['billing_address'],
                            'phone' => $inputs['phone'],
                            'fax' => $inputs['fax'],
                            'email' => $inputs['email'],
                            'status' => $inputs['status'],
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
                    
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Customers_model->add_db_branch($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Customers_model->get_single_row_branch($add_stat[1]);
                    add_system_log(CUSTOMER_BRANCHES, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['customer_id'])); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update_branch(){ 
            $inputs = $this->input->post();
            $cust_branch_id = $inputs['id']; 
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
                    
            $data = array(  
                            'branch_name' => $inputs['branch_name'],
                            'branch_short_name' => $inputs['branch_short_name'],
                            'contact_person' => $inputs['contact_person'],
                            'sales_person_id' => $inputs['sales_person_id'],
                            'description' => $inputs['description'],
                            'mailing_address' => $inputs['mailing_address'],
                            'billing_address' => $inputs['billing_address'],
                            'phone' => $inputs['phone'],
                            'fax' => $inputs['fax'],
                            'email' => $inputs['email'],
                            'status' => $inputs['status'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
            
            //old data for log update
            $existing_data = $this->Customers_model->get_single_row_branch($inputs['id']);

            $edit_stat = $this->Customers_model->edit_db_branch($inputs['id'],$data);
            
//            echo '<pre>'; print_r($data); die;
            if($edit_stat){
                //update log data
                    $new_data = $this->Customers_model->get_single_row_branch($add_stat[1]);
                add_system_log(CUSTOMER_BRANCHES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
               redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['customer_id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['customer_id']));
            } 
	}	
        
        function remove_branch(){
            $inputs = $this->input->post();
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            $existing_data = $this->Customers_model->get_single_row_branch($inputs['id']);
            $delete_stat = $this->Customers_model->delete_db_branch($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CUSTOMER_BRANCHES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['customer_id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['customer_id']));
            }  
	}
        
        
       
                
         function fl_ajax(){ 
            $func = $this->input->post('function_name');
            $param = $this->input->post();
            
//                            echo '<pre>';                            print_r($param); die;
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            }
        }
        function get_dropdown_formodal($table='CUSTOMERS',$name='customer_name',$id="id"){ 
             echo json_encode(get_dropdown_data(CUSTOMERS, array('customer_name',"CONCAT(customer_name,' | ',short_name) as customer_name"), $id,'Customer')); 
//             echo json_encode(get_dropdown_data(CUSTOMERS, $name, $id,'Customer')); 
        }
        function add_customer_quick($data1){
            unset($data1['function_name']);
            $short_name = gen_id('C-', CUSTOMERS, 'id',2,0); 
            $cust_id = get_autoincrement_no(CUSTOMERS);
            
            $data2 = array(
                            'id' => $cust_id,  
                            'short_name' => $short_name, 
                            'status' => 1, 
                            'credit_limit' => 0, 
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                            );
                $data['customer'] = array_merge($data1,$data2);
                    
                //customer Branche auto create**************
                $cust_branch_id = get_autoincrement_no(CUSTOMER_BRANCHES);

                $data['customer_branch'] = array(
                                                'id' => $cust_branch_id,
                                                'customer_id' => $cust_id,
                                                'branch_name' => $data['customer']['customer_name'],
                                                'branch_short_name' => $data['customer']['short_name'],   
                                                'billing_address' => $data['customer']['address'].' '.$data['customer']['city'],   
                                                'phone' => $data['customer']['phone'],  
                                                'status' => 1,
                                                'added_on' => date('Y-m-d'),
                                                'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                            );
		$add_stat = $this->Customers_model->add_db($data); 
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Customers_model->get_single_row($add_stat[1]);
                    add_system_log(CUSTOMERS, $this->router->fetch_class(), __FUNCTION__, '', $new_data); 
                }
                echo $add_stat[1];
        }
        function get_states(){
            $country_code = $this->input->post('country_id'); 
            $list = get_dropdown_data(COUNTRY_STATES,'state_name','id','',"country_code = '$country_code'"); 
            
            echo json_encode($list); 
        }
                function test(){
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Customers_model');
//            $data = $this->Customers_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(HOTELS,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        
                    
}
