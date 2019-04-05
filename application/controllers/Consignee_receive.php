<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consignee_receive extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Consignee_receive_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Consignee_receive_model->search_result();
            $data['main_content']='consignee_receive/search_consignee_receive'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'Customer_name','id','Customers');
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content']='consignee_receive/manage_consignee_receive';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content']='consignee_receive/view_consignee_receive'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='consignee_receive/view_consignee_receive'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='consignee_receive/view_consignee_receive'; 
            $data['cr_desc_data'] = $this->get_receive_info($id);
//            echo '<pre>';            print_r($data); die;
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
//            echo '<pre>';            print_r($_POST); die;
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('return_date','Return Date','required');
            $this->form_validation->set_rules('reference','Reference','required'); 
      }	 
        
	function create(){    
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die; 
                $cr_id = get_autoincrement_no(CONSIGNEE_RECIEVE);
                $cr_no = gen_id(CR_NO_PREFIX, CONSIGNEE_RECIEVE, 'id');

                $cur_det = $this->Consignee_receive_model->get_currency_for_code($inputs['currency_code']); 

                $data['cr_tbl'] = array(
                                        'id' => $cr_id,
                                        'cr_no' => $cr_no, 
                                        'consignee_id' => $inputs['consignee_id'], 
                                        'reference' => $inputs['reference'], 
                                        'consignee_id' => $inputs['consignee_id'], 
                                        'comments' => $inputs['memo'],   
                                        'recieve_date' => strtotime($inputs['return_date']),   
                                        'payment_term_id' => $inputs['payment_term_id'], 
                                        'currency_code' => $inputs['currency_code'], 
                                        'currency_value' => $cur_det['value'],  
                                        'location_id' => $inputs['location_id'],
                                        'status' => 1,
                                        'added_on' => date('Y-m-d'),
                                        'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                    );
                $data['cr_desc'] = array(); 
                $data['item_stock_transection'] = array(); //stock transection purchasing

                foreach ($inputs['inv_items_btm'] as $inv_item){
                    $data['cr_desc'][] = array(
                                                'cr_id' => $cr_id,
                                                'cs_no' => $inv_item['cs_no'],
                                                'item_id' => $inv_item['item_id'],
                                                'item_desc' => $inv_item['item_description'], 
                                                'item_quantity' => $inv_item['item_quantity'],
                                                'item_quantity_uom_id' => $inv_item['uom_id'],
                                                'item_quantity_2' => $inv_item['item_quantity_2'],
                                                'item_quantity_uom_id_2' => $inv_item['uom_id_2'],
                                                'unit_price' => $inv_item['unit_price'],
                                                'location_id' => $inputs['location_id'],
                                                'status' => 1,
                                                'deleted' => 0,
                                            );

                    $data['item_stock_transection'][] = array(
                                                                'transection_type'=>50, //50 for Consignee Recieve
                                                                'trans_ref'=>$cr_id, 
                                                                'item_id'=>$inv_item['item_id'], 
                                                                'units'=>$inv_item['item_quantity'], 
                                                                'uom_id'=>$inv_item['uom_id'], 
                                                                'units_2'=>$inv_item['item_quantity_2'], 
                                                                'uom_id_2'=>$inv_item['uom_id_2'], 
                                                                'location_id'=>$inputs['location_id'], 
                                                                'status'=>1, 
                                                                'added_on' => date('Y-m-d'),
                                                                'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                                );

                    if($inv_item['uom_id_2']!=0)
                        $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['uom_id'],$inv_item['item_quantity'],$inv_item['uom_id_2'],$inv_item['item_quantity_2'],'-');
                    else
                        $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['uom_id'],$inv_item['item_quantity'],'','','-');

                    if(!empty($item_stock_data)){
                        $data['item_stock'][] = $item_stock_data;
                    }

                }

    //            echo '<pre>';            print_r($data); die;

                    $add_stat = $this->Consignee_receive_model->add_db($data);

                    if($add_stat[0]){ 
                        //update log data
                        $new_data = $this->Consignee_receive_model->get_single_row($add_stat[1]);
                        add_system_log(CONSIGNEE_RECIEVE, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                        if($inputs['form_action']=='invoice'){ 
                            $this->session->set_flashdata('warn',"Consignee data ready for create Invoice");
                            redirect(base_url('Sales_invoices/add?cr_id='.$cr_id));
                        }
                        $this->session->set_flashdata('warn',RECORD_ADD);
                        redirect(base_url($this->router->fetch_class().'/view/'.$cr_id)); 
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
                    $units_on_consignee = $stock_det['units_on_consignee'] + $units;
                    $units_on_consignee_2 = $stock_det['units_on_consignee_2'] + $units_2;
                    $available_units = $stock_det['units_available'] - $units;
                    $available_units_2 = $stock_det['units_available_2'] - $units_2;
                }else{
                    $units_on_consignee = $stock_det['units_on_consignee'] - $units;
                    $units_on_consignee_2 = $stock_det['units_on_consignee_2'] - $units_2;
                    $available_units = $stock_det['units_available'] + $units;
                    $available_units_2 = $stock_det['units_available_2'] + $units_2;
                }
            }
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_available'=>$available_units,'new_units_available_2'=>$available_units_2,'new_units_on_consignee'=>$units_on_consignee,'new_units_on_consignee_2'=>$units_on_consignee_2);
                
            return $update_arr;
        }
        
                    
        
        function remove(){
            $inputs = $this->input->post(); 
            $this->load->model('Item_stock_model');
            //check the payments before delete reservation
            $trans_data = $this->Consignee_receive_model->get_transections($inputs['id']);
            if(!empty($trans_data)){
                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
                return false;
            }
                    
            $data['cn_tbl'] = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
            
            
            $cn_stock_trans = $this->Item_stock_model->get_stock_transection($inputs['id'],'transection_type = 30'); //30 for Sales returm or credit Notes
            
            foreach ($cn_stock_trans as $cn_stock){
                
                if($cn_stock['uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],$cn_stock['uom_id_2'],$cn_stock['units_2'],'-');
                else
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],'','','-');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
            }
            
            $existing_data = $this->Consignee_receive_model->get_single_row($inputs['id']);  
            $delete_stat = $this->Consignee_receive_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CREDIT_NOTES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                    redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Consignee_receive_model->get_single_row($inputs['id']);
            if($this->Consignee_receive_model->delete2_db($id)){
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
                $data['user_data'] = $this->Consignee_receive_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            
            
            $data['consignee_list'] = get_dropdown_data(CONSIGNEES, 'consignee_name', 'id',''); 
            $data['price_type_list'] = get_dropdown_data(DROPDOWN_LIST, 'dropdown_value', 'id','','dropdown_id = 14'); //14 for dropdown type for sales type
//            $data['price_type_list'] = array(16=>'Whole Sale',15=>'Retail');
            $data['payment_term_list'] = get_dropdown_data(PAYMENT_TERMS, 'payment_term_name', 'id');
                $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); //14 for sales type 
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');

            return $data;
	}	
        
        function search(){ 
            $input = $this->input->post(); 
            $search_data=array( 
                                'cr_no' => $this->input->post('cr_no'),
                                'consignee_id' => $input['consignee_id'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $invoices['search_list'] = $this->Consignee_receive_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Consignee_receive_model->search_result();
            $this->load->view('consignee_receive/search_consignee_receive_result',$invoices);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Consignee_receive_model->get_single_item($inputs['item_code'],$inputs['supplier_id']); 
            echo json_encode($data);
        }
        function test(){
//            echo '<pre>';            print_r($this->router->class); die;
            
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Consignee_receive_model->get_single_item(1002,15);
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
        
        function get_receive_info($inv_id){
            if($inv_id!=''){
                 $data['invoice_dets'] = $this->Consignee_receive_model->get_single_row($inv_id);
                if(empty($data['invoice_dets'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
           
            $data['invoice_desc'] = array();
            $invoice_desc = $this->Consignee_receive_model->get_invc_desc($inv_id);
            
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
           
//            echo '<pre>';            print_r($data); die;
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
        function get_search_res_ret_items(){
            $inputs = $this->input->post();   
            $cs_no = $inputs['cs_no']; //sales invocie no
            $search_from = strtotime($inputs['submit_from_date']); 
            $search_to = strtotime($inputs['submit_to_date']);  
            $consignee_id = $inputs['consignee_id'];  
            $location_id = $inputs['location_id'];  
            
            $result = $this->Consignee_receive_model->search_consignee_submission($cs_no, $search_from,$search_to,$consignee_id,$location_id); 
//            echo '<pre>';            print_r($inputs); die;  
//            echo '<pre>';            print_r($result_available); die; 
            echo json_encode($result);
        }
        
}
