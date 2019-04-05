<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_submissions extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Order_submissions_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Order_submissions_model->search_result();
            $data['main_content']='order_submissions/search_order_submissions'; 
            $data['craftman_list'] = get_dropdown_data(CRAFTMANS,'craftman_name','id','Craftman');
            $this->load->view('includes/template',$data);
	}
        
	function add_POS($spos=1){
            $data  			= $this->load_data(); 
            $data['no_menu']		= $spos;
            $data['action']		= 'Add';
            $data['main_content'] = 'order_submissions/manage_order_submissions';  
            $this->load->view('includes/template_pos',$data);  
	}
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content'] = 'order_submissions/manage_order_submissions';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content' ] = 'order_submissions/view_order_submissions'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']= 'order_submissions/view_order_submissions'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'View';
            $data['main_content' ] = 'order_submissions/view_order_submissions'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            $this->load->view('includes/template',$data);
	}
	function view_POS($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='order_submissions/view_order_submissions'; 
            $data['inv_data'] = $this->get_invoice_info($id);
//            echo '<pre>';            print_r($data); die; 
            $this->load->view('includes/template_pos',$data);  
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
//            echo '<pre>';            print_r($_POST); die;
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('return_date','Return Date','required');
            $this->form_validation->set_rules('submission_date','Submission Date','required');
            $this->form_validation->set_rules('craftman_id','Ctraftman','required'); 
      }	 
        
	function create(){   
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die; 
            $cn_id = get_autoincrement_no(CRAFTMANS_SUBMISSION);
            $cn_no = gen_id(CRF_SUB_NO_PREFIX, CRAFTMANS_SUBMISSION, 'id');
                    
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['cms_tbl'] = array(
                                    'id' => $cn_id,
                                    'cm_submission_no' => $cn_no, 
                                    'submission_date' => strtotime($inputs['submission_date']), 
                                    'return_date' => strtotime($inputs['return_date']), 
                                    'craftman_id' => $inputs['craftman_id'],  
                                    'memo' => $inputs['memo'],  
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            
            $data['so_desc'] = array(); 
            
            foreach ($inputs['inv_items_btm'] as $so_desc_id => $inv_item){
                $data['so_desc'][] = array(
                                            'craftman_status' => 1,//submitted to craftman
                                            'so_craftman_submission_id' => $cn_id, 
                                            'so_desc_id' => $so_desc_id, 
                                        ); 
                
            }
                    
//            echo '<pre>';            print_r($data); die;
                    
		$add_stat = $this->Order_submissions_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Order_submissions_model->get_single_row($add_stat[1]);
                    add_system_log(CRAFTMANS_SUBMISSION, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    if($inputs['no_menu']==1){
                        redirect(base_url($this->router->fetch_class().'/view/'.$cn_id)); 
                    }else{
                        redirect(base_url($this->router->fetch_class().'/view/'.$cn_id)); 
                    }
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0,$calc='-'){ //updatiuon for item_stock table
            $this->load->model('Item_stock_model');
            $stock_det = $this->Item_stock_model->get_single_row('',"location_id = '$loc_id' and item_id = '$item_id'");
            $available_units= $available_units_2 = 0;
            $update_arr = array();
            if(empty($stock_det)){
                $insert_data = array(
                                        'location_id'=>$loc_id,
                                        'item_id'=>$item_id,
                                        'uom_id'=>$uom,
                                        'units_available'=>0,
                                        'units_on_order'=>0,
                                        'units_on_demand'=>0,
                                        );
                if($uom_2!=''){
                    $insert_data['units_available_2'] = 0;
                    $insert_data['uom_id_2'] = $uom_2;
                }
                $this->Item_stock_model->add_db($insert_data);
                $available_units = $units;
                $available_units_2 = $units_2;
            }else{
                if($calc=='+'){
                    $available_units = $stock_det['units_available'] + $units;
                    $available_units_2 = $stock_det['units_available_2'] + $units_2;
                }else{
                    
                    $available_units = $stock_det['units_available'] - $units;
                    $available_units_2 = $stock_det['units_available_2'] - $units_2;
                }
            }
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_available'=>$available_units,'new_units_available_2'=>$available_units_2);
                
            return $update_arr;
        }
        
        
	function update(){ 
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die; 
            $cs_id = $inputs['id'];  
            $data['so_sub_tbl'] = array(
                                    'memo' => $inputs['memo'],  
                                    'submission_date' => strtotime($inputs['submission_date']),  
                                    'return_date' => strtotime($inputs['return_date']),  
                                    'updated_on' => date('Y-m-d'),
                                    'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            $data['so_desc'] = array();
            if(!empty($inputs['so_desc_ids'])){
                foreach ($inputs['so_desc_ids'] as $so_desc_id){
                    $data['so_desc'][] = array(
                                            'craftman_status' => 1,//submitted to craftman
                                            'so_craftman_submission_id' => $cs_id, 
                                            'so_desc_id' => $so_desc_id, 
                                        ); 
                
                 }
            }
            //old data for log update
            $existing_data = $this->get_invoice_info($cs_id);

            $edit_stat = $this->Order_submissions_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Order_submissions_model->get_single_row($inputs['id']);
                add_system_log(VEHICLE_RATES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die; 
            $ret_dets = $this->get_invoice_info($inputs['id']); 
                    
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                    
            
            $existing_data = $this->get_invoice_info($inputs['id']);  
            $delete_stat = $this->Order_submissions_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CRAFTMANS_SUBMISSION, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                    redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Order_submissions_model->get_single_row($inputs['id']);
            if($this->Order_submissions_model->delete2_db($id)){
                //update log data
                add_system_log(HOTELS, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
        function load_data($id=''){
            if($id!=''){
                $data['user_data'] = $this->Order_submissions_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            } 
            $data['craftman_list'] = get_dropdown_data(CRAFTMANS, 'craftman_name', 'id','');
            $data['customer_list'] = get_dropdown_data(CUSTOMERS, 'customer_name', 'id','');
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); //14 for sales type
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Category');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');

            return $data;
	}	
        
        function search(){ 
            $input = $this->input->post();
//            echo '<pre>';            print_r($input); die;
            $search_data=array( 
                                'submission_no' => $this->input->post('submission_no'),
                                'order_no' => $this->input->post('order_no'),
                                'craftman_id' => $input['craftman_id'],  
                                'submitted_date' => (isset($input['submitted_date_check']))? strtotime($input['submitted_date']):'',  
                                'return_date' => (isset($input['return_date_check']))?strtotime($input['return_date']):'',   
                                ); 
            $so_subms['search_list'] = $this->Order_submissions_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Order_submissions_model->search_result();
            $this->load->view('order_submissions/search_order_submissions_result',$so_subms);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Order_submissions_model->get_single_item($inputs['item_code'],$inputs['supplier_id']); 
            echo json_encode($data);
        }
        function test(){
//            echo '<pre>';            print_r($this->router->class); die;
            
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Order_submissions_model->get_single_item(1002,15);
            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        function so_submission_print($sub_id){ 
//            $this->input->post() = 'aa';
            $submission_data = $this->get_invoice_info($sub_id);  
            $submission_det = $submission_data['sub_dets'];
            
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
             
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Note';//invice bg
            $pdf->fl_header_title_RTOP='Craftman Submission Note';//invice bg
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF AM Invoice');
            $pdf->SetSubject('FL Invoice');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    
            // set font
            $pdf->SetFont('times', '', 10);
        
        
            $pdf->AddPage();   
            $pdf->SetTextColor(32,32,32);     
            
//            echo '<pre>';            print_r($submission_data); die; 
            $html = '<table border="0">
                        <tr>
                            <td><b>Report: Craftman Submission Note </b></td>
                            <td align="center"></td>
                            <td align="right"></td>
                        </tr> 
                        <tr>
                            <td>Craftman: '.$submission_det['craftman_name'].'</td>
                            <td align="center">Submitted Date : '.date(SYS_DATE_FORMAT,$submission_det['submission_date']).'</td>
                            <td align="RIGHT">Required Date : '.date(SYS_DATE_FORMAT,$submission_det['return_date']).'</td>
                        </tr> 
                        <tr>
                            <td>Submission #: '.$submission_det['cm_submission_no'].'</td>
                            <td align="center"></td>
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr> 
                    </table> ';
            $i=1; 
            
            $html .= '<table  class="table-line" border="0">
                        <thead> 
                            <tr class="colored_bg">
                                <th width="8%" align="left">Catgory</th> 
                                <th width="12%" align="center">Order ItemCode</th> 
                                <th width="15%" align="left">Item Name</th> 
                                <th width="15%" align="center">Weight</th> 
                                <th width="15%" align="center">Order#</th> 
                                <th width="35%" align="left">Description</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($submission_data['so_desc_list'] as $so_item){
//            echo '<pre>';            print_r($so_item); die; 
                $html .= '<tr>
                            <td width="8%" align="left">'.$so_item['category_name'].'</td>
                            <td width="12%" align="center">'.$so_item['item_code'].'</td>
                            <td width="15%" align="left" >'.$so_item['item_desc'].'</td>
                            <td width="15%" align="center" >'.$so_item['units'].' '.$so_item['unit_abbreviation'].(($so_item['secondary_unit_uom_id']!=0)?$so_item['secondary_unit'].' '.$so_item['unit_abbreviation_2']:'').'</td>
                            <td width="15%" align="center" >'.$so_item['order_no'].'</td>
                            <td width="35%" align="left">'.$so_item['description'].'</td>

                        </tr>';            
                $i++;
            } 
            $html .= '</tbody> 
                    </table>   ';      
            
            
            $html .= '
                    <style>
                    .colored_bg{
                        background-color:#E0E0E0;
                    } 
                    .table-line th, .table-line td {
                        padding-bottom: 2px;
                        border-bottom: 1px solid #ddd;
                        text-align:center; 
                    }
                    .text-right,.table-line.text-right{
                        text-align:right;
                    }
                    .table-line tr{
                        line-height: 20px;
                    }
                    </style>';
            $pdf->writeHTMLCell(190,'',10,'',$html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('Craftman_submission.pdf', 'I');
                
        }
        
        function get_invoice_info($sub_id='',$cn_no=''){
            if($sub_id!=''){
                 $data['sub_dets'] = $this->Order_submissions_model->get_single_row($sub_id);
                if(empty($data['sub_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            } 
           
            $data['sub_desc'] = array();
            $so_desc = $this->Order_submissions_model->get_sub_desc($sub_id);
            
            $data['so_desc_list'] = $so_desc;
            
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
                    
            return $data;
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
        function get_search_res_order_items(){
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die;  
            $search_data = array(
                                    'so_no' => $inputs['sales_order_no'],
                                    'category_id' => $inputs['category_id'],
                                    'search_from' => (isset($inputs['so_from_date_check']))? strtotime($inputs['so_from_date']):'',
                                    'search_to' => (isset($inputs['so_to_date_check']))? strtotime($inputs['so_to_date']):'',
                                );  
            
            $result = $this->Order_submissions_model->search_so_submission($search_data); 
//            echo '<pre>';            print_r($result); die;  
//            echo '<pre>';            print_r($result_available); die; 
            echo json_encode($result);
        }
        function pos_sales_ret_print_direct(){ 
            $inputs = $this->input->post();
            $invoice_data = $this->get_invoice_info('',$inputs['cn_no']);
            $this->load->helper('print_helper');
            fl_direct_print_return($invoice_data);
            
        }
}
