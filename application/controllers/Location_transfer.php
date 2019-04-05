<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_transfer extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Sales_invoices_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
//            $data['main_content']='sales_invoices/search_sales_invoices'; 
//            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id','Customers');
//            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data  			= $this->load_data();  
            
            $data['action']		= 'Add';
            $data['main_content']='inventory_location_transfer/manage_inventory_location_transfer';  
//            echo '<pre>';            print_r($data); die;  
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
            $data['main_content']='sales_invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='sales_invoices/view_invoice'; 
            $data['inv_data'] = $this->get_invoice_info($id);
//            echo '<pre>';            print_r($data['inv_data']['invoice_desc']); die;
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

            $this->form_validation->set_rules('transfer_date','Transfer Date','required');
            $this->form_validation->set_rules('to_location_id','Location','required'); 
            $this->form_validation->set_rules('from_location_id','Location','required'); 
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
//            echo '<pre>';            print_r($this->input->post()); die;
            
            $inputs = $this->input->post();
            $trans_id = get_autoincrement_no(LOCATION_TRASNFER); 
                    
            if(isset($inputs['status'])){
                $inputs['status'] = 1;
            } else{
                $inputs['status'] = 0;
            }
            $data['lt_tbl'] = array(
                                    'id' => $trans_id,  
                                    'from_location_id' => $inputs['from_location_id'], 
                                    'to_location_id' => $inputs['to_location_id'], 
                                    'transfer_date' => strtotime($inputs['transfer_date']),  
                                    'status' => 1,
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            
            $data['inv_desc'] = array(); 
            $data['item_stock_transection'] = array(); //stock transection 
            $data['transection'] = array(); //payments transection 
            $data['item_stock'] = array(); //payments transection 
                    
            foreach ($inputs['inv_items'] as $inv_item){
                 $data['lt_desc'][] = array(
                                            'transfer_id' => $trans_id,
                                            'item_id' => $inv_item['item_id'],
                                            'item_description' => $inv_item['item_desc'],
                                            'item_quantity' => $inv_item['item_quantity'],
                                            'item_quantity_uom_id' => $inv_item['item_quantity_uom_id'],
                                            'item_quantity_2' => $inv_item['item_quantity_2'],
                                            'item_quantity_uom_id_2' => $inv_item['item_quantity_uom_id_2'], 
                                            'status' => 1,
                                            'deleted' => 0,
                                        );
                
                
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>3, //3 flocation change/transfer
                                                            'trans_ref'=>$trans_id, 
                                                            'item_id'=>$inv_item['item_id'], 
                                                            'units'=>$inv_item['item_quantity'], 
                                                            'uom_id'=>$inv_item['item_quantity_uom_id'], 
                                                            'units_2'=>$inv_item['item_quantity_2'], 
                                                            'uom_id_2'=>$inv_item['item_quantity_uom_id_2'], 
                                                            'location_id'=>$inputs['from_location_id'], 
                                                            'status'=>1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                            );
                
                //from location updation
                if($inv_item['item_quantity_uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['from_location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2']);
                else
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['from_location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity']);
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                
                //to location updation
                if($inv_item['item_quantity_uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['to_location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2'],'+');
                else
                    $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['to_location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],'',0,'+');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                
            } 
//            echo '<pre>';            print_r($inputs); die;
//            echo '<pre>';            print_r($data); die;
                $this->load->model('Location_transfer_model');
		$add_stat = $this->Location_transfer_model->add_db($data);
                
		if($add_stat[0]){  
//                    delete_cookie('sale_inv_list');
                    //update log data
                    $new_data = $this->Location_transfer_model->get_single_row($add_stat[1]);
                    add_system_log(LOCATION_TRASNFER, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
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
            $existing_data = $this->Sales_invoices_model->get_single_row($inputs['id']);

            $edit_stat = $this->Sales_invoices_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Sales_invoices_model->get_single_row($inputs['id']);
                add_system_log(VEHICLE_RATES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
//            echo '<pre>';            print_r($this->input->post()); die;
            $this->load->model('Item_stock_model');
            $inputs = $this->input->post(); 
            //check the payments before delete reservation
//            $this->load->model('Payments_model');
//            $data['inv_transection'] = $this->Payments_model->get_transections(10,$inputs['id']); //10 for customer
//            if(!empty($trans_data)){
//                $this->session->set_flashdata('error','You need to remove the Payments transections before delete Invoice!');
//                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
//                return false;
//            }
            $data['tbl_data'] = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
                
            
            $si_stock_trans = $this->Item_stock_model->get_stock_transection($inputs['id'],'transection_type = 2'); //30 for Sales returm or credit Notes
            
            foreach ($si_stock_trans as $cn_stock){
                
                if($cn_stock['uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],$cn_stock['uom_id_2'],$cn_stock['units_2'],'+');
                else
                    $item_stock_data = $this->stock_status_check($cn_stock['item_id'],$cn_stock['location_id'],$cn_stock['uom_id'],$cn_stock['units'],'','','+');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
            }
            $existing_data = $this->Sales_invoices_model->get_single_row($inputs['id']);  
            $delete_stat = $this->Sales_invoices_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(INVOICES, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Sales_invoices_model->get_single_row($inputs['id']);
            if($this->Sales_invoices_model->delete2_db($id)){
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
                $data['user_data'] = $this->Sales_invoices_model->get_single_row($id); 
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            } 
            
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); //14 for sales type
//            $data['item_list'] = get_dropdown_data(ITEMS,array('item_name',"CONCAT(item_name,'-',item_code) as item_name"),'item_code',''); 
            $data['item_list'] = $this->get_availale_items_dropdown(); 
            $data['category_list'] = get_dropdown_data(ADDON_CALC_INCLUDED,'name','id','Agent Type');  
            return $data;
	}	
        
        function get_availale_items_dropdown(){
            $this->load->model('Items_model');
            $itms = $this->Items_model->get_available_items();
            $drop_down_data = array();
            if(!empty($itms)){
                foreach ($itms as $itm){
                    $drop_down_data[$itm['item_code']] = $itm['item_name'];
                }
            }
            return $drop_down_data;
        }
                
        function search(){ 
            $input = $this->input->post();
            $search_data=array( 
                                'invoice_no' => $this->input->post('invoice_no'),
                                'customer_id' => $input['customer_id'],  
//                                    'category' => $this->input->post('category'), 
                                ); 
            $invoices['search_list'] = $this->Sales_invoices_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Sales_invoices_model->search_result();
            $this->load->view('sales_invoices/search_sales_invoices_result',$invoices);
	}
        
        function get_single_item(){
//            echo '<pre>';            print_r($this->input->post()); die;
            $this->load->model('Item_stock_model');
            $inputs = $this->input->post(); 
            $data = $this->Sales_invoices_model->get_single_item($inputs['item_code']); 
            $data['stock'] = $this->Item_stock_model->get_stock_by_code($inputs['item_code'],$inputs['location_id']);
//            echo '<pre>';            print_r($data); die;
            echo json_encode($data);
        }
        function sales_invoice_print($inv_id){
//            echo '<pre>';            print_r($this->get_invoice_info(2)); die;
            $inv_data = $this->get_invoice_info($inv_id);
            $inv_dets = $inv_data['invoice_dets'];
            $inv_desc = $inv_data['invoice_desc'];
            $inv_trans = $inv_data['inv_transection'];
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            
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
                            <td><b>Bill To:</b> </td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td>'.$inv_dets['customer_name'].'</td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td>'.$inv_dets['address'].' '.$inv_dets['city'].', <br>'.$inv_dets['phone'].'</td>
                            <td align="right"></td>
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
                                         <th width="15%" style="text-align: left;"><u><b>NL No</b></u></th>  
                                         <th width="40%" style="text-align: left;"><u><b>Description</b></u></th> 
                                         <th  width="10%"><u><b>Qty</b></u></th>  
                                         <th width="15%" style="text-align: right;"><u><b>Rate</b></u></th>  
                                         <th width="19%" style="text-align: right;"><u><b>Total</b></u></th> 
                                     </tr>
                                </thead>
                            <tbody>';
                     
                     foreach ($inv_itms as $inv_itm){
//                         $item_info = $this->Items_model->get_single_row($inv_itm['id'])[0];
//                                     echo '<pre>';            print_r($inv_itm); die;

                         $html .= '<tr>
                                        <td width="15%" style="text-align: left;">'.$inv_itm['item_code'].'</td> 
                                        <td width="40%" style="text-align: left;">'.$inv_itm['item_description'].'</td> 
                                        <td width="10%">'.$inv_itm['item_quantity'].'</td>  
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['unit_price'],2).'</td> 
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
                        line-height: 20px;
                    }
                    </style>';
            $pdf->writeHTML($html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);           
            $pdf->Text(160,20,$inv_dets['invoice_no']);
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output('Sales_invoice_'.$inv_id.'.pdf', 'I');
                
        }
        
        function get_invoice_info($inv_id){
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
            
            $data['item_cats'] = get_dropdown_data(ITEM_CAT, 'category_name','id');
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
//            echo '<pre>';            print_r($data); die;
            return $data;
        }
        
        function fl_ajax(){
            
//            echo '<pre>';            print_r($this->input->post()); die;
            $func = $this->input->get('function_name');
            $param = $this->input->post();
            
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            }
        }
        
        function item_list_set_cookies(){
            $this->load->helper('cookie'); 
            $cookie= array(
                            'name'   => 'sale_inv_list',
                            'value'  => json_encode($this->input->post()),
                            'expire' => '3600',
                   );
            
            delete_cookie('sale_inv_list');
            $this->input->set_cookie($cookie);
//        $this->test();
//            echo '<pre>';            print_r(json_decode($this->input->cookie('sale_inv_list',true))); die;
        }
        
        function get_cookie_data_itms(){
            $list_data_jsn = $this->input->cookie('sale_inv_list',true);
            echo $list_data_jsn;
//            echo '<pre>';            print_r($list_data_jsn); die;
//            return $list_data_jsn;
        }
        
        function get_dropdown_branch_data(){ 
                $parent_id = $this->input->post('customer_id');
                $this->db->select("branch_name, id");	
                $this->db->from(CUSTOMER_BRANCHES);	 
                $this->db->where('deleted',0);
                if($parent_id > 0){
                    $this->db->where('customer_id',$parent_id); //identification - parent for variety
                }                       
                
                $res = $this->db->get()->result_array();
                $dropdown_data=array();
                    
                    $dropdown_data['']='Select Customer'; 
                foreach ($res as $res1){
                    $dropdown_data[$res1['id']] = $res1['branch_name'];
                    $result[$res1['id']] = $res1;
                } 
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
            echo json_encode($res);
        }
        function get_single_branch_info(){
                $branch_id = $this->input->post('branch_id');
                $this->db->select("cb.*");	
                $this->db->select("(select commission_value from ".CUSTOMERS." where id = cb.customer_id) as cust_discount");	
                $this->db->select("(select commision_plan from ".CUSTOMERS." where id = cb.customer_id) as cust_discount_plan");	
                $this->db->from(CUSTOMER_BRANCHES." cb");	 
                $this->db->where('cb.deleted',0);
                if($branch_id > 0){
                    $this->db->where('cb.id',$branch_id);  
                }                       
                
                $res = $this->db->get()->result_array();
                $dropdown_data=array();
                    
//                echo '<pre>';                print_r($res); die;
//                echo form_dropdown('variety',$dropdown_data, set_value('variety'),' class="form-control select" data-live-search="true" id="variety" ');
                echo json_encode($res[0]);
        }
        
        function test(){
            $this->load->helper('cookie'); 
//            $cookie= array(
//                            'name'   => 'fahry',
//                            'value'  => 'This is Demonstration of how to set cookie in CI',
//                            'expire' => '3600',
//                   );
 
//       $this->input->set_cookie($cookie);
//       delete_cookie('faget');
//  echo $this->input->cookie('fahry',true);
//       echo "Congragulatio Cookie Set";
            echo '<pre>';            print_r($_COOKIE); die;
//            echo '<pre>';            print_r($this->input->cookie('sale_inv_list',true)); die;
            
//            $this->load->view('sales_invoices/sales_invoices');
//            $data = $this->Sales_invoices_model->get_single_item(1002,15);
//            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
}
