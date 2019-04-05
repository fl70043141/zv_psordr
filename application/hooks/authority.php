<?php
ob_start();
function is_loged_in(){
    
	$CI =& get_instance();
	$CI->load->library('session');
    $allowed_classes = array('login','is_logged_in','crons','forgot_password', 'Extended_display');	 
//    echo '<pre>';    print_r($CI->session->userdata()); die;
    if(!in_array($CI->router->class,$allowed_classes) && $CI->session->userdata(SYSTEM_CODE)['is_logged_in'] == FALSE ){
        redirect('login');	
    }
    
//            echo '<pre>';            print_r($CI->router->class); die;
    if($CI->session->userdata(SYSTEM_CODE)['is_logged_in'] == TRUE && $CI->router->class == 'Login'){
        
        //user_role info
	$CI->load->model('User_default_model');
        $user_role_info = $CI->User_default_model->get_userrole_info($CI->session->userdata(SYSTEM_CODE)['user_role_ID']);
        redirect(base_url($user_role_info['redirect']));
//    	redirect('dashboard');
	}
}

function check_authority(){
 
	$CI =& get_instance();
        $CI->load->helper('url');
	$CI->load->library('session');
	$page = $CI->router->directory.$CI->router->class;
//	echo '<pre>';        print_r($CI->router->directory); die;
	$authorized_page = array('login', 'unauthorized', 'UnauthorizedContact', 'search', 'ajax', 'logout', 'crons','forgot_password','Extended_display');
	
	if(in_array($page, $authorized_page))return;
	$CI->session->set_flashdata('prev_controller', $page); 
	$method = $CI->router->method;
	$method = ($method=='index')?'':$method;
	$user_group = $CI->session->userdata(SYSTEM_CODE)['user_role_ID'];
	$CI->load->model('user_default_model');
	
	if(!$CI->user_default_model->check_authority($user_group, $page, $method)){
		redirect(base_url('unauthorized'));
	}
}

function error_styling()
{
	$CI =& get_instance();	
	$CI->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
}

?>