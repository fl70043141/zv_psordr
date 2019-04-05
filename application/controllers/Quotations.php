<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotations extends CI_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('Quotaions_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Quotaions_model->search_result();
            $data['main_content']='quotations/search_quotations'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS, 'customer_name', 'id','All ','customer_type_id != 1');
            $data['quotation_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','All ','dropdown_id = 15'); //15 for quotes type
            
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='quotations/manage_quotations';    
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
            $data['main_content']='quotations/view_quotation'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='quotations/view_quotation'; 
            $data['inv_data'] = $this->get_invoice_info($id);
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

            $this->form_validation->set_rules('quoted_date','Date','required'); 
//            $this->form_validation->set_rules('vehicle_number','Vehicle Number','required'); 
      }	 
        
	function create(){  
            
            $inputs = $this->input->post();
            $quote_id = get_autoincrement_no(QUOTATIONS);
            $quote_no = gen_id(QUOTE_NO_PREFIX, QUOTATIONS, 'id');
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            
            $this->load->model('Items_model');
            foreach ($inputs['inv_items'] as $inv_item){
                $item_dets = $this->Items_model->get_single_row($inv_item['item_id'])[0];
//            echo '<pre>'; print_r($item_dets); die;
                $quot_descreption[] = array( 
                                            'item_id' => $inv_item['item_id'],
                                            'item_description' => $inv_item['item_desc'],
                                            'quantity' => $inv_item['item_quantity'],
                                            'unit_price' => $inv_item['item_unit_cost'],
                                            'unit_abbreviation' => $item_dets['unit_abbreviation'],
                                            'unit_abbreviation_2' => $item_dets['unit_abbreviation_2'],
                                            'discount_persent' => $inv_item['item_discount'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
            }
            
//            echo '<pre>'; print_r($quot_descreption); die;
            
            $data = array(
                            'id' => $quote_id,
                            'quote_no' => $quote_no,
                            'quotation_type' => $inputs['quotation_type'], //1-basic estimation, 2-basic quotation
                            'person_id' => $inputs['customer_id'],  
                            'quoted_date' => strtotime($inputs['quoted_date']),  
                            'sales_type_id' => $inputs['sales_type_id'],   
                            'quot_descreption' => (isset($quot_descreption) && !empty($quot_descreption))?json_encode($quot_descreption):'',   
                            'status' => 1,
                            'added_on' => date('Y-m-d'),
                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        );
            
//            echo '<pre>';            print_r($data); die; 
                    
		$add_stat = $this->Quotaions_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Quotaions_model->get_single_row($add_stat[1]);
                    add_system_log(QUOTATIONS, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class().'/view/'.$quote_id)); 
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
            $existing_data = $this->Quotaions_model->get_single_row($inputs['id']);

            $edit_stat = $this->Quotaions_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Quotaions_model->get_single_row($inputs['id']);
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
            
//            echo '<pre>'; print_r($inputs); die;
                                        
            $data = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            $existing_data = $this->Quotaions_model->get_single_row($inputs['id']);
            $delete_stat = $this->Quotaions_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(VEHICLE_RATES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Quotaions_model->get_single_row($inputs['id']);
            if($this->Quotaions_model->delete2_db($id)){
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
                $data['user_data'] = $this->Quotaions_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            
            
            $data['customer_list'] = get_dropdown_data(CUSTOMERS, 'customer_name', 'id','','customer_type_id != 1');
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            $data['quotation_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 15'); //15 for quotes type
            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code','','',0,SELECT2_ROWS_LOAD); 
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');

            return $data;
	}	
        
        function search(){ 
            $input = $this->input->post();
            $search_data=array( 
                                'invoice_no' => $this->input->post('invoice_no'),
                                'customer_id' => $this->input->post('customer_id'), 
                                'quotation_type' => $this->input->post('quotation_type'), 
                                ); 
//            echo '<pre>';            print_r( $search_data); die;
            $invoices = $this->Quotaions_model->search_result($search_data);
            $data_view['search_list']= array();
            foreach ($invoices as $invoice){
                $data_view['search_list'][] = $this->get_invoice_info($invoice['id']);
            } 
//		$data_view['search_list'] = $this->Quotaions_model->search_result();
            
//            echo '<pre>';            print_r($data_view); die;
            $this->load->view('Quotations/search_quotations_result',$data_view);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
            $data = $this->Quotaions_model->get_single_item($inputs['item_code'],$inputs['sales_type_id']); 
            echo json_encode($data);
        }
        function test(){
//            echo '<pre>';            print_r($this->router->class); die;
            
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Quotaions_model->get_single_item(1002,15);
            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        function quote_print($inv_id){
//            echo '<pre>';            print_r($this->get_invoice_info(1)); die;
            $inv_data = $this->get_invoice_info($inv_id);
            $inv_dets = $inv_data['invoice_dets'];
            $inv_desc = $inv_data['invoice_desc'];
            $inv_trans = array();
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
            $pdf->SetMargins(PDF_MARGIN_LEFT, 53, PDF_MARGIN_RIGHT);
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
            
            $html = '
                    <table> 
                        <tr> 
                            <td colspan="2" align="center"><h2>'.$inv_dets['quotation_type_name'].'</h2></td>
                        </tr>
                        <tr><td colspan="2"><br></td></tr> 
                        <tr>
                            <td>Customer: '.$inv_dets['customer_name'].'</td>
                            <td align="right">Date: '.date('m/d/Y',$inv_dets['quoted_date']).'</td>
                        </tr>
                        <tr>
                            <td>Customer Contact Number: '.$inv_dets['phone'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr><td  colspan="5"><br><br></td></tr>
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
//                         echo '<pre>';                         print_r($inv_itm); die;
                         $html .= '<tr>
                                        <td width="10%">'.$inv_itm['quantity'].((isset($inv_itm['unit_abbreviation']))?' '.$inv_itm['unit_abbreviation']:'').'</td> 
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
                        $html .= ' 
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
            $pdf->Text(160,20,$inv_dets['quote_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('example_003.pdf', 'I');
                
        }
        
        function get_invoice_info($inv_id){
            if($inv_id!=''){
                 $data['invoice_dets'] = $this->Quotaions_model->get_single_row($inv_id); //10 fro sele invoice
                if(empty($data['invoice_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            $data['invoice_desc'] = array();
            $invoice_desc = isset($data['invoice_dets']['quot_descreption'])?json_decode($data['invoice_dets']['quot_descreption'],true):'';
            $data['invoice_desc_list'] = $invoice_desc;
            
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
            $item_cats = get_dropdown_data(ITEM_CAT, 'category_name','id');
            
            $data['invoice_desc_total']= 0;
            foreach ($item_cats as $cat_key=>$cat_name){ 
                foreach ($invoice_desc as $invoice_itm){ 
                    $this->load->model('Items_model');
                    $itm = $this->Items_model->get_single_row($invoice_itm['item_id']);
                    
                    $sub_total = ($invoice_itm['unit_price']*$invoice_itm['quantity']*(100-$invoice_itm['discount_persent'])*0.01);
                    if($itm[0]['item_category_id']==$cat_key){
                        $invoice_itm['item_category'] = $itm[0]['item_category_id'];
                        $invoice_itm['sub_total'] = $sub_total;
                        $data['invoice_desc'][$cat_key][]=$invoice_itm;
                        $data['invoice_desc_total'] +=  $sub_total;
                    }
                }
            }
//            echo '<pre>';            print_r($data); die;
            $data['invoice_total'] = $data['invoice_desc_total'];  
            return $data;
        }
        
}
