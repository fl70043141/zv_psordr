<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extended_display extends CI_Controller {
	
        function __construct() {
            parent::__construct();
            $this->load->model('User_model');
            $this->load->model('Banner_model');     
        } 
        
        public function index()
	{
            $this->extended_display();
	}
                                
        
	function extended_display(){
		$data['banners'] = $this->Banner_model->get_single_row(1);
//                        echo '<pre>'; print_r($data); die;
//		$data  			= $this->load_data();
		$data['action']		= 'Add';
		$data['main_content']='banners/extended_display';  
                $this->load->view('includes/template_rep',$data);
	} 
        
        function get_temp_invoice_data($temp_inv_id=''){ 
             $this->load->model('Item_stock_model');
             $this->load->model('Sales_pos_model');
            $temp_invoice_open = $this->Sales_pos_model->get_temp_invoice_open($this->session->userdata(SYSTEM_CODE)['ID']);
            $temp_invoice_open_itms = (isset($temp_invoice_open['item_data'])?$temp_invoice_open['item_data']:'');
            $data=array();
            if($temp_invoice_open_itms!=""){
                $temp_inv = json_decode($temp_invoice_open_itms,true);
                foreach ($temp_inv as $key=>$temp_inv1){
                    $data[$key] = $temp_inv1;
//                    $data['inv_tot'] = $temp_inv1;
                    $data[$key]['stock']= $this->Item_stock_model->get_stock_by_code($temp_inv1['item_code'],'');
                    
                }
            } 
            $fin_data['items'] = $data;
            $fin_data['payments'] = (isset($temp_invoice_open['payments'])?json_decode($temp_invoice_open['payments'],true):'');
            $fin_data['open_temp_data'] = $temp_invoice_open;
            echo json_encode($fin_data);
//            echo '<pre>';            print_r(json_decode($temp_invoice_open)); die;
//            return $list_data_jsn;
            
        }
        
        function test(){
            echo 'okoo';
        }
}
