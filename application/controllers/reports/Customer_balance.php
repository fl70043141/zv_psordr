<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_balance extends CI_Controller {
  
        function __construct() {
            parent::__construct();
            $this->load->model('Sales_summary_model');
        }

        public function index(){ 
              //I'm just using rand() function for data example 
            $this->view_search_report();
	}
        public function view_search_report(){ 
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/sales/customer_balance/search_customer_balance'; 
            $data['customer_list'] = get_dropdown_data(CUSTOMERS,'customer_name','id','Customers');
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
            $data = $this->load_data();
            $this->load->view('reports_all/sales/customer_balance/search_customer_balance_result',$data);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $invoices = $this->load_data(); 
//            echo '<pre>';            print_r($invoices); die; 
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Customer Outstanding';//invice bg
            
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
            $html = '<table border="0">
                        <tr>
                            <td><b>Report: Customer Outstanding Report</b></td>
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr>
                        <tr>
                            <td>Dates Result: '.$this->input->get('sales_from_date').' - '.$this->input->get('sales_to_date').'</td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr>
                    </table> ';
            $html .= '<table  class="table-line" border="0">
                        <thead> 
                            <tr class="colored_bg">
                                <th width="5%" align="center;">#</th> 
                                <th width="25%" align="left">Customer Name</th> 
                                <th width="16%" align="left">City</th> 
                                <th width="18%" align="right">Total Invoices</th> 
                                <th width="18%" align="right">Settled</th> 
                                <th width="18%" align="right">Outstanding Amount</th>  
                            </tr>
                        </thead>
                        <tbody>';
            $i=1;
            $g_tot_settled = $g_inv_total = $g_tot_balance=0;
            foreach ($invoices['rep_data'] as $cust_dets){$tot_settled = $inv_total = $tot_balance=0;
                 if(isset($cust_dets['invoices'])){
                    foreach ($cust_dets['invoices'] as $invoice){
                        $due_date = $invoice['invoice_date']+(60*60*24*$invoice['days_after']);
                        $invoice_total = $invoice['invoice_desc_total'];
                        $cust_payments = (!empty($invoice['transections']))?$invoice['transections'][0]['total_amount']:0;
                        $pending = $invoice_total-$cust_payments;

                        $inv_total += $invoice_total;
                        $tot_settled += $cust_payments;
                        $tot_balance += $pending;
 

                     } 
                }
                                 
                if($tot_balance>0){
                    $g_inv_total += $inv_total;
                    $g_tot_settled += $tot_settled;
                    $g_tot_balance += $tot_balance;
                    $html .= '<tr> 
                                    <td width="5%" align="center">'.$i.'.</td>
                                    <td width="25%" align="left">'.$cust_dets['customer']['customer_name'].'- '.(($cust_dets['customer']['short_name']!='')?' ['.$cust_dets['customer']['short_name'].']':'').'</td>
                                    <td width="16%" align="left">'.$cust_dets['customer']['city'].'</td>
                                    <td width="18%" align="right">'.number_format($inv_total,2).'</td>
                                    <td width="18%" align="right">'.number_format($tot_settled,2).'</td>
                                    <td width="18%" align="right">'.number_format($tot_balance,2).'</td>
                                </tr>';
                                         
                $i++;
                }
            }
            $html .= ' </tbody> </table> ';
            $html .= '
                    <table>
                        
                        <tfoot> 
                            <tr class="">
                                <td align="left" colspan="4"></td>
                            </tr> 
                            <tr> 
                                <th width="5%" align="center"></th>
                                <th width="25%" align="center"></th>
                                <th width="16%" align="center"></th>
                                <th width="18%" align="right"><b>'.number_format($g_inv_total,2).'</b></th>
                                <th width="18%" align="right"><b>'.number_format($g_tot_settled,2).'</b></th> 
                                <th width="18%" align="right"><b>'.number_format($g_tot_balance,2).'</b></th>
                            </tr>
                        </tfoot>
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
            $pdf->writeHTMLCell(190,'',10,'',$html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('Sales_invoice_.pdf', 'I');
        }
        
        public function  load_data(){
            $invoices = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post(); 
//            echo '<pre>';            print_r($input); die; 
            $this->load->model("Payments_model");
            $cust_list = $this->Sales_summary_model->get_customers($input['customer_id']);
            
            //search invoices 
            foreach ($cust_list as $cust){
                $search_data=array( 
                                    'customer_id' => $cust['id'],
                                    'invoice_no' => (isset($input['sales_invoice_no']))?$input['sales_invoice_no']:'',  
                                    'from_date' => strtotime($input['sales_from_date']),  
                                    'to_date' => strtotime($input['sales_to_date'])  
                                    ); 
                
                $invoices['rep_data'][$cust['id']]['customer'] = $cust;
                $invoice_list = $this->Sales_summary_model->search_result($search_data);
                if(!empty($invoice_list)){
                    foreach ($invoice_list as $invoice){
                        $invoices['rep_data'][$cust['id']]['invoices'][$invoice['id']]=$invoice;
                        $invoices['rep_data'][$cust['id']]['invoices'][$invoice['id']]['transections']= $this->Payments_model->get_transections(10,$invoice['id'],'transection_type_id = 1');
                    }
                }
                
            } 
            return $invoices;
        }
}
