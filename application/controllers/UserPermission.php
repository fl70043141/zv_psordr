<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserPermission extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('User_permission');
        }

        public function index(){
            $this->view_search_user_permission();
	}
        
         function view_search_user_permission($datas=''){
            
            $data['user_permission_list'] = $this->User_permission->getPermissionGroup(); 
//            echo '<pre>'; print_r($data); die; 
            $data['main_content']='user_permissions/view_permissions'; 
            $this->load->view('includes/template',$data);
	}
        
	function edit($id){ 
            $data['permission_data']   = $this->get_permission_data($id); 
            $this->permission_instertion_ur($id); 

            $data['action']		= 'Edit';
            $data['urole_id']		= $id;
            $data['main_content'] = 'user_permissions/manage_permission'; 
            $this->load->view('includes/template',$data);
	}
         
        function get_permission_data($user_role_id){
            $modules = $this->User_permission->get_module_list();
            $module_data = array();
            foreach ($modules as $module){
                $module_data[$module['id']]['p_data'] = $this->User_permission->getPermissionData($user_role_id, $module['id']);
                $module_data[$module['id']]['name'] = $module['module_name'];
                $module_data[$module['id']]['id'] = $module['id'];
                
            } 
            return $module_data;
        } 
          
	function validate(){  
            
             $inputs = $this->input->post();
             $status = $this->User_permission->updateUserPermission($inputs);
//            if(isset($inputs['status'])){
//                $inputs['status'] = 1;
//            } else{
//                $inputs['status'] = 0;
//            }
              

            if($status){
                add_system_log('', $this->router->fetch_class(), __FUNCTION__, '', '');
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                redirect(base_url('userPermission'));
            }else{
                $this->session->set_flashdata('error',ERROR);
                redirect('userPermission/'.$inputs['user_role_id']);
            } 
	} 
                                  
        function permission_instertion_ur($ur_id){
           $admin_data =  $this->User_permission->getAdminPermissionData(1);
           $perm_insert_arr = array();
           foreach ($admin_data as $admin_p){ 
                $ur_others =  $this->User_permission->getAdminPermissionData($ur_id,'module_action_id = '.$admin_p['module_action_id']);
                if(empty($ur_others)){
                    $perm_insert_arr[] = array(
                                                'user_role_id' =>$ur_id,
                                                'module_action_id' => $admin_p['module_action_id'],
                                                'display_order' => 101,
                                                'status' => 0,
                                            );
                }
               
           } 
           if(!empty($perm_insert_arr)){
            $this->User_permission->insert_batch_permission($perm_insert_arr);
           }
//                echo '<pre>';            print_r($perm_insert_arr);  die;
        }
        function test(){
            echo 'okoo';
        }
        function make_fresh_system(){
//             echo 'WARNING: PLS HIDE THIS COMMENT BEFORE EXECUTE'; die;
            $truncate_tables = array(
                                        CONSIGNEES,
                                        CONSIGNEE_COMMISH,
                                        CONSIGNEE_RECIEVE,
                                        CONSIGNEE_RECIEVE_DESC,
                                        CONSIGNEE_SUBMISSION,
                                        CONSIGNEE_SUBMISSION_DESC,
                                        CREDIT_NOTES,
                                        CREDIT_NOTES_DESC,
                                        CUSTOMERS,
                                        CUSTOMER_BRANCHES,
//                                        CUSTOMER_TYPE,
                                        GEM_ISSUES,
                                        GEM_ISSUE_RECORDS,
                                        GEM_RECEIVAL,
                                        GEM_LAPIDARY_COSTING,
                                        GL_QUICK_ENTRY,
                                        GL_TRANS,
                                        INV_LOCATION,
                                        LOCATION_TRASNFER,
                                        LOCATION_TRASNFER_DESC,
                                        INVOICES,
                                        INVOICE_DESC,
                                        INVOICES_ADDONS,
                                        INVOICES_TEMP,
                                        ITEMS,
//                                        ITEM_CAT,
                                        ITEM_PRICES,
                                        ITEM_STOCK,
                                        ITEM_STOCK_TRANS,
                                        OLD_GOLD,
                                        OLD_GOLD_DESC,
                                        OLD_GOLD_REF,
                                        QUOTATIONS,
                                        SALES_ORDERS,
                                        SALES_ORDER_DESC,
                                        SALES_ORDER_ITEM_TEMP,
                                        CRAFTMANS,
                                        CRAFTMANS_RECEIVE,
                                        CRAFTMANS_RECEIVE_DESC,
                                        CRAFTMANS_SUBMISSION,
                                        SUPPLIERS,
                                        SUPPLIER_INVOICE,
                                        SUPPLIER_INVOICE_DESC,
                                        SYSTEM_LOG,
                                        SYSTEM_LOG_DETAIL,
                                        TRANSECTION,
                                        TRANSECTION_REF,
                                    );
            foreach ($truncate_tables as $tbl_name){ 
                $this->User_permission->make_fresh_system($tbl_name);
            }
            $this->session->set_flashdata('warn',"SB SET UP TO FRESH JEWELLERY SOFTWARE");
            redirect('userPermission/');
        }
         
}
