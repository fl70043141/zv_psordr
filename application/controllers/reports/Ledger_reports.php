<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_reports extends CI_Controller {
  
        function __construct() {
            parent::__construct();
            $module =$this->load->model('Reports_all_model');
        }

        public function index(){ 
              //I'm just using rand() function for data example 
            $this->view_search_report();
	}
        public function monthly_ledger(){
            
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/ledgers/monthly/search_summary_report'; 
            $data['quick_entry_list'] = get_dropdown_data(GL_QUICK_ENTRY_ACC,'account_name','id','Quick entry');
            $this->load->view('includes/template',$data);
        }
        public function daily_ledger(){
            
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/ledgers/daily/search_summary_report'; 
            $data['quick_entry_list'] = get_dropdown_data(GL_QUICK_ENTRY_ACC,'account_name','id','Quick entry');
            $this->load->view('includes/template',$data);
        }
        
        public function expenses(){
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/ledgers/expenses/search_summary_report'; 
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
        
//        public function search_month(){ //view the report
//            $invoices = $this->get_ledger_month(); 
//            $this->load->view('reports_all/ledgers/monthly/search_summary_report_result',$invoices);
//	} 
        
        public function  search_balance_sheet(){ // view month ledger
            $trans_group = $this->load_data();
//                echo '<pre>';            print_r($this->router->fetch_class()); die;
                 
            $this->load->view('reports_all/ledgers/monthly/search_summary_report_result',$trans_group);
        }
        
        function load_data(){
            $trans_group = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post();  
            $search_data=array( 
                                'from_date' => ($input['date_from']>0)?strtotime($input['date_from']):'',
                                'to_date' => ($input['date_to']>0)?strtotime($input['date_to']):'',
                                'quick_entry_acc_id' => $input['quick_entry_acc'],   
                                ); 
                 
            $trans_list = $this->Reports_all_model->get_ledger_month($search_data,'gct.class_id=1 OR gct.class_id=2');

//                echo '<pre>';            print_r($trans_list); die;

            if(!empty($trans_list)){
                foreach ($trans_list as $trans){
                    $trans_group['trans_class_list'][$trans['class_id']]['class_name']=$trans['class_name']; 

                    $acc_amount_open =  $this->Reports_all_model->get_sum_ledger('',strtotime($input['date_from']),'gt.account_code = '.$trans['account_code']);
                    $trans['open_balance'] = (isset($acc_amount_open[0]['sum_amount']))?$acc_amount_open[0]['sum_amount']:0;
                   
                    
                    $acc_amount_period =  $this->Reports_all_model->get_sum_ledger('','','gt.trans_date>= '.strtotime($input['date_from']).' AND gt.trans_date <= '.strtotime($input['date_to']).' AND gt.account = '.$trans['account']);
                    $trans['period_transections'] = (isset($acc_amount_period[0]['sum_amount']))?$acc_amount_period[0]['sum_amount']:0;
// echo '<pre>';                    print_r($trans); die;
                    $trans['close_balance'] = $trans['open_balance'] +$trans['period_transections'];

                    $trans_group['trans_class_list'][$trans['class_id']]['class_data'][$trans['gct_id']][]=$trans; 
                }
            }
                return $trans_group;
        }
        
        function load_expensess_data(){
            $trans_group = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post();   
            
                $search_data=array( 
                                    'from_date' => ($input['from_date']>0)?strtotime($input['from_date']):'',
                                    'to_date' => ($input['to_date']>0)?strtotime($input['to_date']):'',
                                    'quick_entry_acc_id' => $input['quick_entry_acc'],   
                                    ); 
                 
                $expenses_list = $this->Reports_all_model->get_expenses($search_data);
                
                $data['search_list'] = $expenses_list; 
                $expenses_group =array();
                if(!empty($expenses_list)){
                    foreach ($expenses_list as $expenses){
                        $expenses_group['expenses_group'][$expenses['account_type_id']]['name']=$expenses['type_name']; 
                        $expenses_group['expenses_group'][$expenses['account_type_id']]['data'][$expenses['id']]=$expenses; 
                    }
                }
//                sort($expenses_group['expenses_group']);
//                echo '<pre>';            print_r($expenses_list); die;
            return $expenses_group;
        }
        public function  search_ledger_month(){ // view month ledger
            $trans_group = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post();  
//                echo '<pre>';            print_r($input); die;
//            $timestamp    = strtotime($input['date_month']);
//            $first_day =  strtotime(date('01-m-Y 00:00:00', $timestamp));
//            $last_day  =  strtotime(date('t-m-Y 23:59:59', $timestamp));  
              
             
                $search_data=array( 
                                    'from_date' => ($input['date_from']>0)?strtotime($input['date_from']):'',
                                    'to_date' => ($input['date_to']>0)?strtotime($input['date_to']):'',
                                    'quick_entry_acc_id' => $input['quick_entry_acc'],   
                                    ); 
                 
                $trans_list = $this->Reports_all_model->get_ledger_month($search_data);
                
//                echo '<pre>';            print_r(date('Y-m-d H:i:s',$last_day)); die;
                
                if(!empty($trans_list)){
                    foreach ($trans_list as $trans){
                        $trans_group['trans_group_list'][$trans['gct_id']][]=$trans; 
                    }
                }
//                echo '<pre>';            print_r($trans_group); die;
                 
            $this->load->view('reports_all/ledgers/monthly/search_summary_report_result',$trans_group);
        }
        
        public function  search_ledger_day(){ // view month ledger
            $trans_group = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post();  
            $timestamp    = strtotime($input['date_day']);
            $begin_time =  strtotime(date('01-m-Y 00:00:00', $timestamp));
            $end_time  =  strtotime(date('t-m-Y 23:59:59', $timestamp));  
              
             
                $search_data=array( 
                                    'from_date' => $begin_time,
                                    'to_date' => $end_time,
                                    'quick_entry_acc_id' => $input['quick_entry_acc'],   
                                    ); 
                 
                $trans_list = $this->Reports_all_model->get_ledger_day($search_data);
                
//                echo '<pre>';            print_r(date('Y-m-d H:i:s',$last_day)); die;
                
                if(!empty($trans_list)){
                    foreach ($trans_list as $trans){
                        $trans_group['trans_group_list'][$trans['gct_id']][]=$trans; 
                    }
                }
//                echo '<pre>';            print_r($trans_group); die;
                 
            $this->load->view('reports_all/ledgers/monthly/search_summary_report_result',$trans_group);
        }
        
        public function  search_expenses(){ 
            $trans_group = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post();   
            
                $search_data=array( 
                                    'from_date' => ($input['from_date']>0)?strtotime($input['from_date']):'',
                                    'to_date' => ($input['to_date']>0)?strtotime($input['to_date']):'',
                                    'quick_entry_acc_id' => $input['quick_entry_acc'],   
                                    ); 
                 
                $expenses_list = $this->Reports_all_model->get_expenses($search_data);
                $data['search_list'] = $expenses_list;
//                echo '<pre>';            print_r($expenses_list); die;
//                $expenses_group =array();
//                if(!empty($expenses_list)){
//                    foreach ($expenses_list as $expenses){
//                        $expenses_group['expenses_group'][$expenses['account_type_id']]['name']=$expenses['type_name']; 
//                        $expenses_group['expenses_group'][$expenses['account_type_id']]['data'][$expenses['id']]=$expenses; 
//                    }
//                }
//                echo '<pre>';            print_r($data); die;
                 
            $this->load->view('reports_all/ledgers/expenses/search_summary_report_result',$data);
        }
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $data= $this->load_data(); 
//            echo '<pre>';            print_r($data); die; 
            $inputs = $this->input->get();
            $date_from = date(SYS_DATE_FORMAT, strtotime($inputs['date_from']));
            $date_to = date(SYS_DATE_FORMAT, strtotime($inputs['date_to']));
            
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Balance Sheet';//invice bg
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
            
            
            
            $html = '<style>
                    .colored_bg{
                        background-color:#E0E0E0;
                    }
                    .table-line th, .table-line td {
                        padding-bottom: 2px;
                        border-bottom: 1px solid #ddd;
                        border-top: 1px solid #ddd;
                    }
                    .text-right,.table-line.text-right{
                        text-align:right;
                    }
                    .table-line tr{
                        line-height: 20px;
                    }
                    th {
                        background-color:#E0E0E0;
                    }
                    </style>';
            $bal_html = "";
            $fin_open_tot = $fin_close_tot = $fin_period_tot = 0; $tot_class_array = array();
            foreach ($data['trans_class_list'] as $cls_id => $class_data){
                $all_open_tot = $all_close_tot = $all_period_tot = 0;
                $class_tot = 0;
                $bal_html .= '<br><h2>'. strtoupper($class_data['class_name']).'</h2> <table border="0" class="table-line"> 
                                <tr>
                                    <th width="10%">Account</th>
                                    <th width="30%">Account Name</th>
                                    <th width="20%" align="right">Open Balance</th>
                                    <th width="20%" align="right">Period</th>
                                    <th width="20%" align="right">Close Balance</th>
                                </tr> 
                            <tbody>';
                  if(isset($class_data['class_data']) && !empty($class_data['class_data'])){
                                         foreach ($class_data['class_data'] as $glcm_id => $search){

//                      echo '<pre>';print_r($data); die;

                                              $bal_html .= '<tr>
                                                                  <td colspan="5"><b>'.$search[0]['type_name'].'</b></td> 
                                                              </tr>
                                                                <table  class="table table-line" border="0"> 
                                                                   <tbody>';
                                                                        $i = 0; $type_tot = $open_tot = $period_tot = $close_tot = 0;
                                                                        if(!empty($search)){
                                                                            foreach ($search as $trans){
//                                                                                $amnt_clr = ($trans['glcm_tot_amount']>=0)?'':'#F1948A'; 
                                                                                $amnt_clr = ''; 
                                                                                $bal_html .= '
                                                                                    <tr> 
                                                                                        <td width="10%" align="left">'.$trans['account_code'].'</td>
                                                                                        <td width="30%" align="left">'.$trans['glcm_account_name'].'</td>
                                                                                        <td width="20%" align="right" style="color:'.$amnt_clr.';">'. number_format(($trans['open_balance']),2).'</td> 
                                                                                        <td width="20%" align="right" style="color:'.$amnt_clr.';">'. number_format(($trans['period_transections']),2).'</td> 
                                                                                        <td width="20%" align="right" style="color:'.$amnt_clr.';">'. number_format(($trans['close_balance']),2).'</td> 
                                                                                    </tr>';
                                                                                $class_tot += $trans['glcm_tot_amount'];
                                                                                $open_tot += $trans['open_balance'];
                                                                                $period_tot += $trans['period_transections'];
                                                                                $close_tot += $trans['close_balance'];
                                                                                
                                                                                $all_open_tot += $trans['open_balance'];
                                                                                $all_period_tot += $trans['period_transections'];
                                                                                $all_close_tot += $trans['close_balance'];
                                                                                
                                                                                $fin_open_tot += $trans['open_balance'];
                                                                                $fin_period_tot += $trans['period_transections'];
                                                                                $fin_close_tot += $trans['close_balance'];
                                                                                $i++;
                                                                            }
                                                                        $bal_html    .= '</tbody> 
                                                                        </table> ';

                                                                            $bal_html .= '<tr>
                                                                                              <td colspan="2" align="left">Total '.$search[0]['type_name'].': </td> 
                                                                                              <td align="right"><b>'.number_format(($open_tot),2).'</b></td> 
                                                                                              <td align="right"><b>'.number_format(($period_tot),2).'</b></td> 
                                                                                              <td align="right"><b>'.number_format(($close_tot),2).'</b></td> 
                                                                                          </tr>';
                                                                       }
                                                                       
                                                       }
                                                       
                                                  }
                    $tot_class_array[$cls_id] = array(
                                                'class_tot_open' => $all_open_tot,
                                                'class_tot_period' => $all_period_tot,
                                                'class_tot_close' => $all_close_tot,
                                            );                              
                    $bal_html .= '<tr>
                                      <td colspan="2" align="left"><h3>Total '.$class_data['class_name'].': </h3></td> 
                                      <td align="right"><h3>'.number_format(($all_open_tot),2).'</h3></td> 
                                      <td align="right"><h3>'.number_format(($all_period_tot),2).'</h3></td> 
                                      <td align="right"><h3>'.number_format(($all_close_tot),2).'</h3></td> 
                                  </tr>';
                    
                  $bal_html .= '</tbody> 
                                 </table> ';

            }
                    $bal_html .= '<table><tbody><tr><td colspan="5"></td></tr>';
                    $bal_html .= '<tr>
                                      <td colspan="2" align="left"><h3>Calculated Return: </h3></td> 
                                      <td align="right"><h3>'.number_format(abs($fin_open_tot),2).'</h3></td> 
                                      <td align="right"><h3>'.number_format(abs($fin_period_tot),2).'</h3></td> 
                                      <td align="right"><h3>'.number_format(abs($fin_close_tot),2).'</h3></td> 
                                  </tr>';
                    
                    $tot_liablit_arr = $tot_class_array[2]; //2 array liabliltes class id
                    
                    $bal_html .= '<table><tbody><tr><td colspan="5"></td></tr>';
                    $bal_html .= '<tr>
                                      <td colspan="2" align="left"><h3>Total Liabilities and Equities: </h3></td> 
                                      <td align="right"><h3>'.number_format(abs($fin_open_tot-$tot_liablit_arr['class_tot_open']),2).'</h3></td> 
                                      <td align="right"><h3>'.number_format(abs($fin_period_tot-$tot_liablit_arr['class_tot_period']),2).'</h3></td> 
                                      <td align="right"><h3>'.number_format(abs($fin_close_tot-$tot_liablit_arr['class_tot_close']),2).'</h3></td> 
                                  </tr>';
                  $bal_html .= '</tbody> 
                                 </table> ';
                   
            
            $html .= '<table border="0">
                        <tr>
                            <td><b>Report: Balance Sheet</b></td>
                            <td align="center"> </td> 
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr> 
                        <tr>
                            <td>Period: '.$date_from.' - '.$date_to.'</td>
                            <td align="center"></td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                        
                    </table> ';
//            echo '<pre>';            print_r($tot_class_array);
            $html .= $bal_html;
            $pdf->writeHTMLCell(190,'',10,'',$html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
//            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('Balance_sheet.pdf', 'I');
        }
        public function print_expenses_report(){ 
//            $this->input->post() = 'aa';
            $expense_data = $this->load_expensess_data(); 
            $inputs = $this->input->get();
            
//                    echo '<pre>';            print_r($expense_data); die;
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//            
            $date_from = date(SYS_DATE_FORMAT, strtotime($inputs['from_date']));
            $date_to = date(SYS_DATE_FORMAT, strtotime($inputs['to_date']));
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Expenses Report';//invice bg
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
            $html =""; 
            
            $total_expenses = $item_count =0;
            foreach ($expense_data['expenses_group'] as $expense_type){
//                    echo '<pre>';            print_r($expense_type); die; 
                $html .=' <table id="example1" class="table table-line " border="0">
                                <thead> 
                                    <tr style=""> 
                                        <th colspan="5" style="text-align: left;"><h3>'.$expense_type['name'].'</h3></th>   
                                     </tr>
                                    <tr style=""> 
                                        <th width="8%" style="text-align: left;"><u><b>#</b></u></th>  
                                        <th width="40%" style="text-align: left;"><u><b>Expenses</b></u></th>  
                                        <th width="12%" style="text-align: center;"><u><b>Date</b></u></th> 
                                        <th width="20%" style="text-align: right;"><u><b>Amount</b></u></th> 
                                        <th width="20%" style="text-align: right;"><u><b>Amount ('.$def_cur['code'].')</b></u></th> 
                                     </tr>
                                </thead>
                            <tbody>';

                $i = 1; $tot_type=0;
                foreach ($expense_type['data'] as $expense){
                    $item_count++;
                    $tot_type +=$expense['expense_amount']; 
//                    echo '<pre>';            print_r($expense); die;
                    $total_expenses += $expense['expense_amount'];
                       $html .= '
                           <tr>
                               <td style="width:8%;">'.$i.'</td> 
                               <td style="width:40%;" align="left">'.$expense['account_name'].' '.(($expense['memo']!='')?'('.$expense['memo'].')':'').'</td>
                               <td style="width:12%;" align="center">'. date(SYS_DATE_FORMAT, $expense['entry_date']).'</td>
                               <td style="width:20%;" align="right">'.$expense['currency_code'].' '. number_format($expense['amount'],2).'</td>
                               <td style="width:20%;" align="right">'. number_format($expense['expense_amount'],2).'</td>
                          </tr>'; 
                       $i++; 
                } 
                
                $html .= '<tr>
                            <td colspan="2"><b>Total '.$expense_type['name'].' - ('.$expense['def_cur_code'].') </b></td>
                            <td colspan="3" align="right;"><b>'. number_format($tot_type,2).'</b></td>
                         </tr>';
                $html .= '<tr> 
                            <td colspan="5" align="right;" style="border-bottom: 1px solid #fff; ;"><br></td>
                         </tr>';
                $html .= '</tbody></table>';
            }
            
            $html = '<table border="0">
                        <tr>
                            <td><b>Report: Expenses Report</b></td>
                            <td align="center"> </td> 
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr> 
                        <tr>
                            <td>Period: '.$date_from.' - '.$date_to.'</td>
                            <td align="center"> </td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr>  
                        
                        <tr><td colspan="3"></td></tr>
                        <tr>
                            <td colspan="3"><b>Report Summary -</b><br>
                                Total Expenses: '.$def_cur['code'].' <b>'. number_format($total_expenses,2).'</b><br>
                                Total Expenses Entries: '.$item_count.'<br>
                            </td>
                        </tr> 
                    </table> '.$html;
            
            $html .= '
                        <style>
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
                        </style>
                                ';
            $pdf->writeHTMLCell(190,'',10,'',$html);
            
            $pdf->SetFont('times', '', 12.5, '', false);
            $pdf->SetTextColor(255,125,125);            
            // force print dialog
            $js = 'this.print();';
//            $js = 'print(true);';
            // set javascript
//            $pdf->IncludeJS($js);
            $pdf->Output('Expenses_report.pdf', 'I');
        }
}
