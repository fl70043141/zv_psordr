<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pnl_General extends CI_Controller {
  
        function __construct() {
            parent::__construct();
            $module =$this->load->model('Reports_all_model');
        }

        public function index(){ 
              //I'm just using rand() function for data example 
            $this->view_search_report();
	}
        public function view_search_report(){
            
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/ledgers/pnl_report/search_summary_report'; 
            $data['quick_entry_list'] = get_dropdown_data(GL_QUICK_ENTRY_ACC,'account_name','id','Quick entry');
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
        function load_data(){
            
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post();  
//            $timestamp    = strtotime($input['date_month']);
//            $first_day =  strtotime(date('01-m-Y 00:00:00', $timestamp));
//            $last_day  =  strtotime(date('t-m-Y 23:59:59', $timestamp));  
              
             
                $search_data=array( 
                                    'from_date' => ($input['date_from']>0)?strtotime($input['date_from']):'',
                                    'to_date' => ($input['date_to']>0)?strtotime($input['date_to']):'', 
                                    ); 
                 
                $trans_list = $this->Reports_all_model->get_ledger_month($search_data);
                
                
                $data['income_data'] = $data['cost_data'] = array();
                if(!empty($trans_list)){
                    foreach ($trans_list as $trans){
//                echo '<pre>';            print_r($trans); die;
                        if($trans['class_id'] == 3){//income
                            $data['income_data'][$trans['gct_id']][]=$trans; 
                        } 
                        if($trans['class_id'] == 4){//cost
                            $data['cost_data'][$trans['gct_id']][]=$trans; 
                        } 
                    }
                }
                return $data;
        }

        public function  search_ledger_month(){ // view month ledger 
            $data = $this->load_data(); 
            $this->load->view('reports_all/ledgers/pnl_report/search_summary_report_result',$data);
        }
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $data= $this->load_data(); 
            $income_data = $data['income_data'];
            $cost_data = $data['cost_data'];
            $inputs = $this->input->get();
            $date_from = date(SYS_DATE_FORMAT, strtotime($inputs['date_from']));
            $date_to = date(SYS_DATE_FORMAT, strtotime($inputs['date_to']));
            
//            echo '<pre>';            print_r($date_to); die;
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='P & L Statement';//invice bg
            //
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
            $pdf->SetFont('times', '', 8.5);
        
        
            $pdf->AddPage();   
            $pdf->SetTextColor(32,32,32);   
            
            
            $pnl_total = $pnl_income_tot = $pnl_cost_tot = 0;
            
            $html = '<style>
                    .colored_bg{
                        background-color:#E0E0E0;
                    }
                    .table-line th, .table-line td {
                        padding-bottom: 2px;
                        border-bottom: 1px solid #ddd;
                    }
                    .text-right,.table-line.text-right{
                        text-align:right;
                    }
                    .table-line tr{
                        line-height: 20px;
                    }
                    </style>';
            $income_html = '<h2>INCOME</h2><table class="table-line">
                            <tbody>';
                  if(isset($income_data) && !empty($income_data)){
                                         foreach ($income_data as $glcm_id => $search){

                      //echo '<pre>';print_r($search); die;

                                              $income_html .= '<tr>
                                                                  <td colspan="4"><b>'.$search[0]['type_name'].'</b></td> 
                                                              </tr>
                                                                <table  class="" border="0"> 
                                                                   <tbody>';
                                                                        $i = 0; $type_tot = 0;
                                                                        if(!empty($search)){
                                                                            foreach ($search as $trans){
                                                                                $amnt_clr = ($trans['glcm_tot_amount']>=0)?'':'#F1948A'; 
                                                                                $income_html .= '
                                                                                    <tr>
                                                                                        <td width="5%">'.($i+1).'.</td> 
                                                                                        <td width="10%" align="left">'.$trans['account_code'].'</td>
                                                                                        <td width="60%" align="left">'.$trans['glcm_account_name'].'</td>
                                                                                        <td width="25%" align="right" style="color:'.$amnt_clr.';">'. number_format(abs($trans['glcm_tot_amount']),2).'</td> 
                                                                                    </tr>';
                                                                                $pnl_income_tot += $trans['glcm_tot_amount'];
                                                                                $type_tot += $trans['glcm_tot_amount'];

                                                                                $i++;
                                                                            }
                                                                        $income_html    .= '</tbody> 
                                                                        </table> ';

                                                                            $income_html .= '<tr>
                                                                                              <td colspan="3" align="right">Total '.$search[0]['type_name'].': </td> 
                                                                                              <td align="right"><b>'.number_format(abs($type_tot),2).'</b></td> 
                                                                                          </tr>';
                                                                       }
                                                                       
                                                       }
                                                       
                                                  }
                                                  
                    $income_html .= '<tr>
                                      <td colspan="3" align="left"><h3>Total Income: </h3></td> 
                                      <td align="right"><h3>'.number_format(abs($pnl_income_tot),2).'</h3></td> 
                                  </tr>';

                $income_html .= '</tbody> 
                                   </table>';

                $cost_html = '<h2>COST</h2><table class="table table-line" border="0">
                                <tbody>'; 
                                    if(isset($cost_data) && !empty($cost_data)){
                                         foreach ($cost_data as $glcm_id => $search){

                      //echo '<pre>';print_r($search); die;

                                              $cost_html .= '<tr>
                                                                  <td colspan="4"><b>'.$search[0]['type_name'].'</b></td> 
                                                              </tr>
                                                                <table  class="" border="0"> 
                                                                   <tbody>';
                                                                        $i = 0; $type_tot = 0;
                                                                        if(!empty($search)){
                                                                            foreach ($search as $trans){
                                                                                $amnt_clr = ($trans['glcm_tot_amount']>=0)?'':'#F1948A'; 
                                                                                $cost_html .= '
                                                                                    <tr>
                                                                                        <td width="5%">'.($i+1).'.</td> 
                                                                                        <td width="10%" align="left">'.$trans['account_code'].'</td>
                                                                                        <td width="60%" align="left">'.$trans['glcm_account_name'].'</td>
                                                                                        <td width="25%" align="right" style="color:'.$amnt_clr.';">'. number_format(abs($trans['glcm_tot_amount']),2).'</td> 
                                                                                    </tr>';
                                                                                $pnl_cost_tot += $trans['glcm_tot_amount'];
                                                                                $type_tot += $trans['glcm_tot_amount'];

                                                                                $i++;
                                                                            }
                                                                            
                                                                        $cost_html    .= '</tbody> 
                                                                        </table> ';

                                                                            $cost_html .= '<tr>
                                                                                              <td colspan="3" align="right">Total '.$search[0]['type_name'].': </td> 
                                                                                              <td align="right"><b>'.number_format(abs($type_tot),2).'</b></td> 
                                                                                          </tr>';
                                                                       }
                                                                       
                                                       }
                                                  }         
                                                $cost_html .= '<tr>
                                                                  <td colspan="3" align="left"><h3>Total Cost: </h3></td> 
                                                                  <td align="right"><h3>'.number_format(abs($pnl_cost_tot),2).'</h3></td> 
                                                              </tr>';
                                                $cost_html .= '<tr>
                                                                  <td colspan="3" align="left"><h3>Calculated Return: </h3></td> 
                                                                  <td align="right" style="color:'.((($pnl_cost_tot+$pnl_income_tot)>0)?'red':'').';"><h3>'.number_format(abs($pnl_cost_tot+$pnl_income_tot),2).'</h3></td> 
                                                              </tr>';
                                                  $cost_html .= '</tbody> 
                                                                 </table> ';
            
            $html .= '<table border="0">
                        <tr>
                            <td><b>Report: Profit & Lost Statement</b></td>
                            <td align="center"> </td> 
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr> 
                        <tr>
                            <td>Period: '.$date_from.' - '.$date_to.'</td>
                            <td align="center"></td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                        
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                    </table> ';
            
            $html .= $income_html.' <br>'.$cost_html;
            $pdf->writeHTMLCell(190,'',10,'',$html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
//            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('PNL_Return.pdf', 'I');
        }
        
}
