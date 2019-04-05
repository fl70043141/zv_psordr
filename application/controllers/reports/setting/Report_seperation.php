<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_seperation extends CI_Controller {
  
        function __construct() {
            parent::__construct();
            $module =$this->load->model('Report_seperation_model');
        }

        public function index(){ 
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/setting/manage_seperation';  
//            echo '<pre>';            print_r($data); die;
            $this->load->view('includes/template',$data);
	} 
        function fl_ajax(){
            
//            echo '<pre>';            print_r($this->input->post()); die;
            $func = $this->input->post('function_name');
            $param = $this->input->post();
            
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            }
        }
        
        public function search(){ //view the report
            $inputs = $this->input->post();
            $search_data = array(
                                    'invoice_no' => $inputs['invoice_no'],
                                    'invoice_date' => strtotime($inputs['invoice_date']),
                                );
            $invoices = $this->Report_seperation_model->search_result($search_data); 
            $inv_array = array();
            foreach ($invoices as $invoice){
                $inv_dets = $this->get_invoice_info($invoice['id']);
                    $inv_array[$invoice['inv_group_id']][$invoice['id']] = $invoice;
                    $inv_array[$invoice['inv_group_id']][$invoice['id']]['net_total'] = $inv_dets['net_total'];
//                    $inv_array[$invoice['inv_group_id']][$invoice['id']] = $invoice['invoice_no'].'['.$invoice['currency_code'].' '.$inv_dets['net_total'].']';
            }
//            echo json_encode($inv_array);
            $data['grouped_invoices'] = $inv_array;
            $this->load->view('reports_all/setting/manage_seperation_result',$data);
	} 
         
        function submit_seperation(){
            $inputs = $this->input->post();
            unset($inputs['function_name']);
            $res = $this->Report_seperation_model->update_invoices_groupstats($inputs);
            
            if($res){
                echo 1;
            }else{
                echo 0;
            }
            
        }
        function get_invoice_info($inv_id){
            $this->load->model('Sales_invoices_model');  
            $this->load->model('Items_model');  
            if($inv_id!=''){
                 $data['invoice_dets'] = $this->Sales_invoices_model->get_single_row($inv_id); //10 fro sale invoice
                if(empty($data['invoice_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['invoice_desc'] = array();
            $invoice_desc = $this->Sales_invoices_model->get_invc_desc($inv_id);
//                    echo '<pre>';                    print_r($invoice_desc); die;
            $data['invoice_desc_list'] = $invoice_desc;
            
//            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
            
            $data['invoice_desc_total']= 0;
            foreach ($item_cats as $cat_key=>$cay_name){ 
//                    echo '<pre>';                    print_r($invoice_desc); die;
                foreach ($invoice_desc as $invoice_itm){
                    $item_info = $this->Items_model->get_single_row($invoice_itm['item_id'])[0];
                    $invoice_itm['item_code']=$item_info['item_code'];
                    if($invoice_itm['item_category']==$cat_key){
                        $data['invoice_desc'][$cat_key][]=$invoice_itm;
                        $data['invoice_desc_total'] +=  $invoice_itm['sub_total'];
                    }
                }
            }
            $data['invoice_total'] = $data['invoice_desc_total'];
            $data['transection_total']=0;
            $this->load->model('Payments_model');
           $data['inv_transection'] = $this->Payments_model->get_transections(10,$inv_id); //10 for customer
//            echo '<pre>';            print_r(  $data['inv_transection']); die;
           $data['net_total'] = $data['invoice_total'];
            foreach ($data['inv_transection'] as $trans){
                switch ($trans['calculation']){
                    case 1: //  addition from invoive
                            $data['transection_total'] += $trans['transection_ref_amount'];
                            $data['invoice_total'] += $trans['transection_ref_amount'];
                            break;
                    case 2: //substitute from invoiice
                            $data['transection_total'] -= $trans['transection_ref_amount'];
                            $data['invoice_total'] -= $trans['transection_ref_amount'];
                            break;
                    case 4: //settlement cust
                            $data['transection_total'] += $trans['transection_ref_amount'];
                            $data['invoice_total'] += $trans['transection_ref_amount'];
                            break;
                    default:
                            break;
                } 
            }
            
            //addons
            $this->load->model("Sales_pos_model");
            $invoice_addons = $this->Sales_pos_model->get_invoice_addons($inv_id); 
            if(!empty($invoice_addons)){
                foreach ($invoice_addons as $invoice_addon){
                    $data['invoice_total']+= $invoice_addon['addon_amount'];
                    $data['net_total'] += $invoice_addon['addon_amount'];
                }
            }
            $data['invoice_addons'] = $invoice_addons; 
            
            return $data;
        }
         
}
