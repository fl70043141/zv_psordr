<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Invoice_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $this->add();
//            $data['search_list'] = $this->Invoice_model->search_result();
//            $data['main_content']='vehicle_rates/search_vehicle_rates'; 
//            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');
//            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='invoices/manage_invoices';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='vehicle_rates/manage_vehicle_rates'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            $this->load->view('includes/template',$data);
	}
	
        
	function validate(){   
//            echo '<pre>';            print_r($this->input->post()); die;
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

            $this->form_validation->set_rules('invoice_date','Invoice Date','required');
            $this->form_validation->set_rules('reference','Reference','required'); 
      }	
      function check_unique_vehicle(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(VEHICLE_RATES,'id','id','','vehicle_id = "'.$this->input->post('vehicle_id').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(VEHICLE_RATES,'id','id','','vehicle_id = "'.$this->input->post('vehicle_id').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_vehicle','Active Vehicle Rates alrady exists for this vehicle.');
                    return false;
                } 
        }
        
	function create(){  
            
            $inputs = $this->input->post();
            $invoice_id = get_autoincrement_no(INVOICES);
            $invoice_no = gen_id(INVOICE_NO_PREFIX, INVOICES, 'id');
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            
            $data['inv_tbl'] = array(
                                    'id' => $invoice_id,
                                    'invoice_no' => $invoice_no,
                                    'invoice_type' => 10, //sales_invoice
                                    'person_id' => $inputs['customer_id'], 
                                    'reference' => $inputs['reference'],  
                                    'comments' => $inputs['memo'], 
                                    'invoice_date' => strtotime($inputs['invoice_date']), 
                                    'invoiced' => 1, 
                                    'sales_type_id' => $inputs['sales_type_id'], 
                                    'payement_term_id' => $inputs['payment_term_id'], 
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            
            if($this->session->userdata(SYSTEM_CODE)['user_group_id']!=0){
                $data['inv_tbl']['inv_group_id'] = $this->session->userdata(SYSTEM_CODE)['user_group_id'];
            }
            $data['inv_desc'] = array();
            foreach ($inputs['inv_items'] as $inv_item){
                $data['inv_desc'][] = array(
                                            'invoice_id' => $invoice_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_description' => $inv_item['item_desc'],
                                            'quantity' => $inv_item['item_quantity'],
                                            'unit_price' => $inv_item['item_unit_cost'],
                                            'discount_persent' => $inv_item['item_discount'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
            }
            //transection_table if deposit has
            $data['transection_tbl'] = array();
            if($inputs['deposit_amount']>0){
                $data['transection_tbl'] = array(
                                                    'transection_type_id'=>1, //1 Payments
                                                    'reservation_id'=>$invoice_id, 
                                                    'trans_reference'=>$invoice_id, //key reference
                                                    'person_type'=>20, //20 for garage customer
                                                    'person_id'=> $inputs['customer_id'],
                                                    'transection_amount'=> $inputs['deposit_amount'],
                                                    'trans_date'=> time(),
                                                    'status'=> 1,
                                                    );
            }
            
//            echo '<pre>';            print_r($data); die;
                    
		$add_stat = $this->Invoice_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Invoice_model->get_single_row($add_stat[1]);
                    add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class().'/view/'.$invoice_id)); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update(){ 
            $inputs = $this->input->post();
            $agent_id = $inputs['id']; 
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data = array(
                            'vehicle_id' => $inputs['vehicle_id'], 
                            'description' => $inputs['description'], 
                            'rate_amount' => $inputs['rate_amount'], 
                            'owner_rate_plan' => $inputs['owner_rate_plan'], 
                            'owner_rate' => $inputs['owner_rate'], 
                            'km_limit_day' => $inputs['km_limit_day'], 
                            'extra_km_rate' => $inputs['extra_km_rate'], 
                            'extra_time_rate' => $inputs['extra_time_rate'], 
                            'status' => $inputs['status'],
                            'updated_on' => date('Y-m-d'),
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
            
//            echo '<pre>'; print_r($data); die;
            //old data for log update
            $existing_data = $this->Invoice_model->get_single_row($inputs['id']);

            $edit_stat = $this->Invoice_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Invoice_model->get_single_row($inputs['id']);
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
            //check the payments before delete reservation
            $trans_data = $this->Invoice_model->get_transections($inputs['id']);
            if(!empty($trans_data)){
                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
                return false;
            }
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            $existing_data = $this->Invoice_model->get_single_row($inputs['id']);  
            $delete_stat = $this->Invoice_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('Invoice_list'));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('Invoice_list'));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Invoice_model->get_single_row($inputs['id']);
            if($this->Invoice_model->delete2_db($id)){
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
                $data['user_data'] = $this->Invoice_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            
            
            $data['customer_list'] = get_dropdown_data(CUSTOMERS, 'customer_name', 'id','','customer_type_id != 1');
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code'); 
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');

            return $data;
	}	
        
        function search(){
            $input = $this->input->post(); 
            $input = $this->input->post();
            $search_data=array( 
                                'invoice_no' => $this->input->post('invoice_no'),
                                'customer_id' => $input['customer_id'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $invoices = $this->Invoice_model->search_result($search_data);
            $data_view['search_list']= array();
            foreach ($invoices as $invoice){
                $data_view['search_list'][] = $this->get_invoice_info($invoice['id']);
            }
//		$data_view['search_list'] = $this->Invoice_model->search_result();
            $this->load->view('Invoices/search_invoices_result',$data_view);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
            $data = $this->Invoice_model->get_single_item($inputs['item_code'],$inputs['sales_type_id']); 
            echo json_encode($data);
        }
        function test(){
//            echo '<pre>';            print_r($this->router->class); die;
            
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Invoice_model->get_single_item(1002,15);
            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        function sales_invoice_print($inv_id){
//            echo '<pre>';            print_r($this->get_invoice_info(2)); die;
            $inv_data = $this->get_invoice_info($inv_id);
            $inv_dets = $inv_data['invoice_dets'];
            $inv_desc = $inv_data['invoice_desc'];
            $inv_trans = $inv_data['inv_transection'];
            $this->load->library('Pdf');
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_am';//invice bg
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF AM Invoice');
            $pdf->SetSubject('AM Invoice');
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
            $pdf->SetFont('times', '', 11);
        
        
            $pdf->AddPage();   
            
            
            
            $pdf->SetTextColor(32,32,32);     
            
            $html = '<table>
                        <tr>
                            <td>Invoiced Date: '.date('m/d/Y',$inv_dets['invoice_date']).'</td>
                            <td align="right">Invoiced by: '.$inv_dets['sales_person'].'</td>
                        </tr>
                        <tr> 
                            <td colspan="2" align="center"><h1>INVOICE</h1></td>
                        </tr> 
                        <tr>
                            <td>Insurance Company: '.((isset($inv_dets['insurance_company']) && $inv_dets['insurance_company']!='')?$inv_dets['insurance_company']:'-').'</td>
                            <td align="right">Vehicle No: '.((isset($inv_dets['vehicle_number']) && $inv_dets['vehicle_number']!='')?$inv_dets['vehicle_number']:'-').'</td>
                        </tr>
                        <tr>
                            <td>Customer: '.$inv_dets['customer_name'].'</td>
                            <td align="right">Make/Model: '.((isset($inv_dets['vehicle_model']) && $inv_dets['vehicle_model']!='')?$inv_dets['vehicle_model']:'-').'</td>
                        </tr>
                        <tr>
                            <td>Customer Contact Number: '.$inv_dets['phone'].'</td>
                            <td align="right">Chasis No: '.((isset($inv_dets['chasis_no']) && $inv_dets['chasis_no']!='')?$inv_dets['chasis_no']:'-').'</td>
                        </tr>
                        <tr><td  colspan="5"><br></td></tr>
                    </table> 
                ';
           
//            echo '<pre>';            print_r($inv_data); die;
            foreach ($inv_desc as $inv_itms){ 
                     $html .= '<table id="example1" class="table-line" border="0">
                                <thead>
                                    <tr class="colored_bg" style="background-color:#E0E0E0;">
                                         <th colspan="5">'.$inv_data['item_cats'][$inv_itms[0]['item_category']].'</th> 
                                     </tr>
                                    <tr style="">
                                         <th  width="10%"><u><b>Qty</b></u></th> 
                                         <th width="40%" style="text-align: left;"><u><b>Description</b></u></th>  
                                         <th width="15%" style="text-align: right;"><u><b>Rate</b></u></th> 
                                         <th width="15%" style="text-align: right;"><u><b>Discount</b></u></th> 
                                         <th width="19%" style="text-align: right;"><u><b>Total</b></u></th> 
                                     </tr>
                                </thead>
                            <tbody>';
                     
                     foreach ($inv_itms as $inv_itm){
                         $html .= '<tr>
                                        <td width="10%">'.$inv_itm['quantity'].'</td> 
                                        <td width="40%" style="text-align: left;">'.$inv_itm['item_description'].'</td>  
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['unit_price'],2).'</td> 
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['discount_persent'],2).'</td> 
                                        <td width="19%" style="text-align: right;">'. number_format($inv_itm['sub_total'],2).'</td> 
                                    </tr> ';
                     }
                     $html .= '
                                <tr><td  colspan="5"></td></tr></tbody></table>'; 
            }
            $html .= '
                    
                    <table id="example1" class="table-line" border="0">
                        
                       <tbody>

                                <tr class="td_ht">
                                    <td style="text-align: right;" colspan="4"><b> Total</b></td> 
                                    <td  width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_desc_total'],2).'</b></td> 
                                </tr>'; 
                        foreach ($inv_trans as $inv_tran){
                            $html .= '<tr>
                                            <td  style="text-align: right;" colspan="4">'.$inv_tran['name'].'</td> 
                                            <td  width="19%"  style="text-align: right;">'. number_format($inv_tran['transection_amount'],2).'</td> 
                                        </tr> ';

                        }
                        $html .= '<tr>
                                    <td  style="text-align: right;" colspan="4"><b>Balance</b></td> 
                                    <td width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_total'],2).'</b></td> 
                                </tr> 
                        </tbody>
                    </table>
                                                               
                ';
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
                line-height: 30px;
            }
            </style>
                    ';
            $pdf->writeHTML($html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);           
            $pdf->Text(160,20,$inv_dets['invoice_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output('example_003.pdf', 'I');
                
        }
        
        function get_invoice_info($inv_id){
            if($inv_id!=''){
                 $data['invoice_dets'] = $this->Invoice_model->get_single_row($inv_id,'invoice_type = 10'); //10 fro sale invoice
                if(empty($data['invoice_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['invoice_desc'] = array();
            $invoice_desc = $this->Invoice_model->get_invc_desc($inv_id);
            $data['invoice_desc_list'] = $invoice_desc;
            
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
            
            $data['invoice_desc_total']= 0;
            foreach ($item_cats as $cat_key=>$cay_name){ 
                foreach ($invoice_desc as $invoice_itm){
                    if($invoice_itm['item_category']==$cat_key){
                        $data['invoice_desc'][$cat_key][]=$invoice_itm;
                        $data['invoice_desc_total'] +=  $invoice_itm['sub_total'];
                    }
                }
            }
            $data['invoice_total'] = $data['invoice_desc_total'];
            $data['transection_total']=0;
           $data['inv_transection'] = $this->Invoice_model->get_transections($inv_id);
            foreach ($data['inv_transection'] as $trans){
                switch ($trans['calculation']){
                    case 1: //  addition from invoive
                            $data['transection_total'] += $trans['transection_amount'];
                            $data['invoice_total'] += $trans['transection_amount'];
                            break;
                    case 2: //substitute from invoiice
                            $data['transection_total'] -= $trans['transection_amount'];
                            $data['invoice_total'] -= $trans['transection_amount'];
                            break;
                    case 4: //settlement cust
                            $data['transection_total'] += $trans['transection_amount'];
                            $data['invoice_total'] += $trans['transection_amount'];
                            break;
                    default:
                            break;
                } 
            }
//            echo '<pre>';            print_r($data); die;
            return $data;
        }
        
                    
}
