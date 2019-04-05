<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerBalance extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Customer_balance_model');
        }


        public function index()
	{
//            echo 'aaa'; die;
            $this->get_cust_balance();
	}
        
        function get_cust_balance($datas=''){
            $data['cust_accs'] = $this->get_customer_accounts();
            $data['log_list'] = $this->Customer_balance_model->search_result();
            $data['main_content']='reports_all/search_customer_ballance'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id', 'Customers');
            
            $this->load->view('includes/template',$data);
	}
                                        
	
	function view($id){ 
                $data['log_data'] = $this->Customer_balance_model->get_single_log($id); 
		$data['action']		= 'View';
		$data['main_content']='audit_trials/manage_audit_trial'; 
//                $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
		$this->load->view('includes/template',$data);
	}
	 
        function load_data(){
            
//            $data['log_data'] = $this->Customer_balance_model->get_single_log($id); 
            $data['module_list'] = get_dropdown_data(MODULES,'module_name','page_id', 'Object',array('col'=>'user_permission_apply','val'=>'1'),1);
            $data['action_list'] = array(
                                            'create' => 'Create', 
                                            'update' => 'Update', 
                                            'Remove' => 'Remove', 
                                        );
            return $data;	
	}	
        
        function search(){ 
		$data_view['search_list'] = $this->get_customer_accounts($this->input->post('customer_id'));
		
		$this->load->view('reports_all/search_customer_ballance_result',$data_view);
	}
        function print_result_report(){ 
//                echo '<pre>';print_r($this->input->post()); die;
            $search_list = $this->get_customer_accounts($this->input->post('customer_id')); 
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
            $pdf->SetFont('times', '', 10);
        
        
            $pdf->AddPage();   
            
            
            
            $pdf->SetTextColor(32,32,32);    
            
            $html='';
            $html .='<table class="table-line ">
                        <thead>
                            <tr class="colored_bg header_tr">
                                <th width="25%"><b>Customer</b></th>
                                <th align="center"  width="30%"><b>Rent reservations</b></th>
                                <th align="center"  width="30%"><b>Garage Invoices</b></th>
                                <th align="center" width="15%"><b>Total Balance</b></th>
                            </tr>
                        </thead>
                        <tbody>';
            $full_amount_pending=0;
            foreach ($search_list as $customer){
                $res_total_amount = $res_total_paid = $res_total_balance=$total_all=0;
                $inv_total_amount = $inv_total_paid = $inv_total_balance=0;
                if(isset($customer['res_charges_all'])){
                    foreach ($customer['res_charges_all'] as $res_charges){
                        $res_total_amount += $res_charges['gross_total'];
                        $res_total_balance += $res_charges['total'];
                    }               
                }
                $res_total_paid = $res_total_amount-$res_total_balance;
                
                if(isset($customer['invoices_all'])){
                    foreach ($customer['invoices_all'] as $inv){
                        $inv_total_amount += $inv['invoice_desc_total'];
                        $inv_total_balance += $inv['invoice_total'];
                    }               
                }
                $inv_total_paid = $inv_total_amount-$inv_total_balance;
                $total_all = $inv_total_balance+$res_total_balance;
                $full_amount_pending += $total_all;
            $html .= '       <tr class="normal_tr">
                                <td width="25%">
                                    '.$customer['info']['customer_name'].'<br>
                                    Phone: '.$customer['info']['phone'].'<br>
                                    City: '.$customer['info']['phone'].'
                                </td>
                                <td width="30%">
                                    <table>
                                        <tr><td width="45%">Total</td><td width="5%">:</td><td align="right" width="50%">'.number_format($res_total_amount,2).'</td></tr>
                                        <tr><td width="45%">Paid</td><td width="5%">:</td><td align="right" width="50%">'.number_format($res_total_paid,2).'</td></tr>
                                        <tr><td width="45%">Pending</td><td width="5%">:</td><td align="right" width="50%">'.number_format($res_total_balance,2).'</td></tr>
                                    </table>
                                </td>
                                <td width="30%">
                                    <table>
                                        <tr><td width="45%">Total</td><td width="5%">:</td><td align="right" width="50%">'.number_format($inv_total_amount,2).'</td></tr>
                                        <tr><td width="45%">Paid</td><td width="5%">:</td><td align="right" width="50%">'.number_format($inv_total_paid,2).'</td></tr>
                                        <tr><td width="45%">Pending</td><td width="5%">:</td><td align="right" width="50%">'.number_format($inv_total_balance,2).'</td></tr>
                                    </table>
                                </td> 
                                <td width="15%">
                                    <table>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td align="right" width="100%">'.number_format($total_all,2).'</td></tr>
                                    </table>
                                </td> 
                            </tr>';
            }
            $html .= '
                            <tr class=" ">
                                <th colspan="3" align="right"><b>Total Balance</b></th>
                                <th align="right"><b>'.number_format($full_amount_pending,2).'</b></th>
                            </tr>
                        </tbody> 
                    </table>';
            
            $html .= '
            <style>
            .colored_bg{
                background-color:#E0E0E0;
            }
            .table-line {
                padding-top:5px;
                padding-bottom:5px;
            }
            .table-line th, .table-line td { 
                border-bottom: 1px solid #ddd;
                border: 1px solid #ddd;
                text-align:left; 
            }
            .text-right,.table-line.text-right{
                text-align:right;
            }
            .table-line .header_tr{
                line-height: 20px;
            }
            .table-line .normal_tr{
                line-height: 15px;
            }
            </style>
                    ';
            $pdf->writeHTML($html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('example_003.pdf', 'I');
	}
                  
        
        
        
        
        
        
        
        
        function get_customer_accounts($cust_id=''){ 
            //customer list
            $customer_list = $this->Customer_balance_model->get_customer_list($cust_id); 
            
            $customers = array();
            foreach ($customer_list as $customer){
                $customers[$customer['id']]['info'] = $customer;
                    
                
                //******get Invoices for customer
                $cust_invoices = $this->Customer_balance_model->get_invoices_customers($customer['id']); 
                foreach ($cust_invoices as $cust_invoice){ 
                    $customers[$customer['id']]['invoices_all'][$cust_invoice['id']] = $this->get_invoice_info($cust_invoice['id']);
                }
                
            } 
            return $customers;
        }
        
        
        function get_invoice_info($inv_id){
            $this->load->model('Invoice_model');
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
