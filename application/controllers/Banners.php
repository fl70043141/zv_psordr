<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends CI_Controller {
	
        function __construct() {
            parent::__construct();
            $this->load->model('User_model');
            $this->load->model('Banner_model');     
        }


        public function index()
	{
            $this->view_search();
	}
        
        function view_search($datas=''){
            
            $data['banner_list'] = $this->Banner_model->search_result();
            $data['main_content']='banners/search_banner'; 
            $this->load->view('includes/template',$data);
	}
        
	function extended_display(){
		$data['banners'] = $this->Banner_model->get_single_row(1);
//                        echo '<pre>'; print_r($data); die;
//		$data  			= $this->load_data();
		$data['action']		= 'Add';
		$data['main_content']='banners/extended_display'; 
                $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id'); 
                $this->load->view('includes/template_rep',$data);
	}
	function add(){
//		$data  			= $this->load_data();
		$data['action']		= 'Add';
		$data['main_content']='banners/manage_banner'; 
                $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
		$this->load->view('includes/template',$data);
	}
	
	function edit($id){
//		$this->redirection_handler($ac_reg_id,'Edit');
		$data['user_data'] = $this->Banner_model->get_single_row($id);
		$data['action']		= 'Edit';
		$data['main_content']='banners/manage_banner'; 
		$this->load->view('includes/template',$data);
	}
	
	function delete($id){
//		$this->redirection_handler($ac_reg_id,'Delete');
		$data  			= $this->load_data($id);
		$data['action']		= 'Delete';
		$data['main_content']='banners/manage_banner'; 
		$this->load->view('includes/template',$data);
	}
	
	function view($id){
//		$this->redirection_handler($ac_reg_id,'View');
		$data  			= $this->load_data($id);
		$data['action']		= 'View';
		$data['main_content']='banners/manage_banner'; 
                $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
		$this->load->view('includes/template',$data);
	}
	
        
	function validate(){  
//                        echo '<pre>'; print_r($this->input->post()); die;
			$this->form_val_setrules(); 
                          if($this->form_validation->run() == False){
                            switch($this->input->post('action')){
                                case 'Add':
                                        $this->add();
                                        break;
                                case 'Edit':
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
		
                $this->form_validation->set_rules('banner_name','banner Name','required');
                $this->form_validation->set_rules('banner_entry_count','banner_entry_count Name','callback_get_count_banner_entries');
                                        
	}	 
        
        function get_count_banner_entries(){
                $inputs_banners = $this->input->post('arr'); 
                if(count($this->input->post('arr'))>0){
                    return true;
                }else{
                    $this->form_validation->set_message('get_count_banner_entries','Please add atleast one entry');
                    return false;
                } 

        }
                
        
	function create(){
            $inputs = $this->input->post();
            $inputs['status'] = 0;
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            }
            
            
            $files_array= array();
            foreach ($_FILES['arr']['name'] as $index=>$files_arr){
                $files_array[$index]['name'] = $_FILES['arr']['name'][$index]['img'];
                $files_array[$index]['type'] = $_FILES['arr']['type'][$index]['img'];
                $files_array[$index]['tmp_name'] = $_FILES['arr']['tmp_name'][$index]['img'];
                $files_array[$index]['error'] = $_FILES['arr']['error'][$index]['img'];
                $files_array[$index]['size'] = $_FILES['arr']['size'][$index]['img'];  
                
                $inputs['arr'][$index]['image_name'] =  $_FILES['arr']['name'][$index]['img'];
            }
            $_FILES = $files_array;
            
//              echo '<pre>'; print_r($inputs);
//              echo '<pre>'; print_r(is_dir(BANNERS_PIC.'slider/')); die; 
                                        
              //create Dir if not exists for store necessary images 
           
            
            $data = array(
                            'banner_name' => $inputs['banner_name'],
                            'status' => isset($inputs['status'])?1:0,
                            'data_json' => json_encode($inputs['arr']), 
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
            
//                          echo '<pre>'; print_r($data); die; 

                                        
                 
		$add_stat = $this->Banner_model->add_db($data);
                
		if($add_stat[0]){
                                //upload images
                                $this->load->library('fileuploads'); //file upoad library created by FL
                                if(!is_dir(BANNERS_PIC.$add_stat[1].'/')) mkdir(BANNERS_PIC.$add_stat[1].'/', 0777, TRUE); 
                                foreach ($inputs['arr'] as $img_index=>$img_field){
                                    $res_image[] = $this->fileuploads->upload_all($img_index,BANNERS_PIC.$add_stat[1].'/');
                                }
//                                echo '<pre>';                                print_r($res_image); die;
                                $new_data = $this->User_model->get_single_user($add_stat[1]);
                                add_system_log(BANNERS, $this->router->fetch_class(), __FUNCTION__, '', $new_data);//update log data
				$this->session->set_flashdata('warn',RECORD_ADD);
				redirect('banners/edit/'.$add_stat[1]);
			}else{
				$this->session->set_flashdata('warn',ERROR);
				redirect(base_url('banners'));;
			} 
	}
	
	function update(){
            $inputs = $this->input->post();
            $inputs['status'] = 0;
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            }
            
            
             //old data for log update
            $existing_data = $this->Banner_model->get_single_row($inputs['id']);
            $prev_entries = json_decode($existing_data[0]['data_json'], true);
            
            $files_array= array();
            foreach ($_FILES['arr']['name'] as $index=>$files_arr){ 
                if($files_arr['img'] != ''){
                    $files_array[$index]['name'] = $_FILES['arr']['name'][$index]['img'];
                    $files_array[$index]['type'] = $_FILES['arr']['type'][$index]['img'];
                    $files_array[$index]['tmp_name'] = $_FILES['arr']['tmp_name'][$index]['img'];
                    $files_array[$index]['error'] = $_FILES['arr']['error'][$index]['img'];
                    $files_array[$index]['size'] = $_FILES['arr']['size'][$index]['img'];  
                
                    $inputs['arr'][$index]['image_name'] =  $_FILES['arr']['name'][$index]['img'];
                }else{
                    $inputs['arr'][$index]['image_name'] =  $prev_entries[$index]['image_name']; 
                }
            }
            $_FILES = $files_array;
            
            
//            echo '<pre>'; print_r($_FILES); die;
            
//              echo '<pre>'; print_r(is_dir(BANNERS_PIC.'slider/')); die; 
                                        
              //create Dir if not exists for store necessary images 
           //upload images
            $this->load->library('fileuploads'); //file upoad library created by FL
            if(!is_dir(BANNERS_PIC.$inputs['id'].'/')) mkdir(BANNERS_PIC.$inputs['id'].'/', 0777, TRUE); 
            $j=0;
            foreach ($_FILES as $img_index=>$img_field){
                $res_image[] = $this->fileuploads->upload_all($img_index,BANNERS_PIC.$inputs['id'].'/');
                $inputs['arr'][$img_index]['image_name'] =  $res_image[$j][0]['name'];
                $j++;
            }
//            echo '<pre>';                                print_r($res_image); die;
            
            $data = array(
                            'banner_name' => $inputs['banner_name'],
                            'status' => isset($inputs['status'])?1:0,
                            'data_json' => json_encode($inputs['arr']), 
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
            
//                          echo '<pre>'; print_r($data); die; 
            $edit_stat = $this->Banner_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Banner_model->get_single_row($inputs['id']);
                add_system_log(BANNERS, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}
	
	function remove(){
//                        echo '<pre>';            print_r($this->session->userdata());die;

		$user_id  = $this->input->post('user_id'); 
                if($user_id == $this->session->userdata(SYSTEM_CODE)['ID'] || $user_id == 1){
                    $this->session->set_flashdata('error','You Dont have permission delete this user!');
                    redirect(base_url('users'));;
                }
                $existing_data = $this->User_model->get_single_user($user_id);
		if($this->User_model->delete_user($user_id)){
                                //update log data
                                add_system_log(USER_TBL.'-'.USER, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
				$this->session->set_flashdata('warn',RECORD_DELETE);
				redirect(base_url('users'));;
			}else{
				$this->session->set_flashdata('warn',ERROR);
				redirect(base_url('users'));;
			}  
	}
        function load_data($type){
              
            return $data;	
	}	
        
        function search(){
		$search_data=array( 'banner_name' => $this->input->post('user_name')); 
		$data_view['search_list'] = $this->Banner_model->search_result($search_data);
		
//                var_dump($this->input->post()); die;
		$this->load->view('banners/search_banner_result',$data_view);
	}
                   
         function do_upload($file_nm, $pic_name='default', $upload_dir='',$overwrite=true){
             
            $config['upload_path'] = BANNERS_PIC.$upload_dir.'/';
            $config['file_name'] = $pic_name;
            $config['overwrite'] = $overwrite;
            $config['allowed_types'] = 'gif|jpg|png'; 

          
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            $files = $_FILES;
            $cpt = count($_FILES[$file_nm]['name']);
            $uploaded_data=array();
            for($i=0; $i<$cpt; $i++){     
                if(is_array($files[$file_nm]['name'])){
                    $_FILES[$file_nm]['name']= $files[$file_nm]['name'][$i];
                    $_FILES[$file_nm]['type']= $files[$file_nm]['type'][$i];
                    $_FILES[$file_nm]['tmp_name']= $files[$file_nm]['tmp_name'][$i];
                    $_FILES[$file_nm]['error']= $files[$file_nm]['error'][$i];
                    $_FILES[$file_nm]['size']= $files[$file_nm]['size'][$i];   
                }
                  echo '<pre>';                print_r($_FILES); die; 
                if ( ! $this->upload->do_upload($file_nm)){
                    return "";
                }
                else{
                    $data = $this->upload->data();
                    $uploaded_data[] = $data['file_name'];
                }
            }
            return $uploaded_data; 
	}
        
        function test(){
            echo 'okoo';
        }
}
