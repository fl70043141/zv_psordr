<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consignee_stockcheck extends CI_Controller {
  
        function __construct() {
            parent::__construct();
            $this->load->model('Reports_all_model');
        }

        public function index(){ 
              //I'm just using rand() function for data example 
            $this->view_search_report();
	}
        public function view_search_report(){ 
//            $this->add();
//            $data['search_list'] = $this->Sales_invoices_model->search_result();
            $data['main_content']='reports_all/sales/consignee_stocksheet/search_consignee_stocksheet'; 
            $data['consignee_list'] = get_dropdown_data(CONSIGNEES,'consignee_name','id','Consignee');
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
            $invoices = $this->load_data(); 
            $this->load->view('reports_all/sales/sales_summary/search_summary_report_result',$invoices);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $rep_data = $this->load_data(); 
//            echo '<pre>';            print_r($rep_data); die; 
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
            $pdf->SetFont('times', '', 10);
        
        
            $pdf->AddPage();   
            $pdf->SetTextColor(32,32,32);     
            $html = '<table border="0">
                        <tr>
                            <td><b>Report: Consignee Stock Check Sheet</b></td>
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr>
                        <tr>
                            <td>Dates Result: '.$this->input->get('from_date').' - '.$this->input->get('to_date').'</td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr>
                    </table> ';
            
            $i=1;
            $g_tot_settled = $g_inv_total = $g_tot_balance=0;
            foreach ($rep_data as $consignee_dets){
            $html .= '<table  class="table-line" border="0">
                        <thead>
                            <tr class="">
                                <th align="left" colspan="6"></th>
                            </tr>
                            <tr class="">
                                <th align="left" colspan="6">'.$i.'. <u>'.$consignee_dets['consignee_info']['consignee_name'].' - '.(($consignee_dets['consignee_info']['consignee_short_name']!='')?' ['.$consignee_dets['consignee_info']['consignee_short_name'].']':'').'</u></th>
                            </tr>
                            <tr class="colored_bg">
                                <th width="30%" align="left">Item Desc</th> 
                                <th width="23%" align="center">Submitted</th> 
                                <th width="23%" align="center">Received</th> 
                                <th width="23%" align="center">On Consignee</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <table>';
                                        $tot_settled = $inv_total = $tot_balance=0;
                                        if(isset($consignee_dets['items'])){
                                            foreach ($consignee_dets['items'] as $item_info){
//            echo '<pre>';            print_r($item_info); die; 


                                                $html .= '<tr>
                                                            <td width="30%" align="left">'.$item_info['submitted_data']['item_description'].'</td>
                                                            <td width="23%" align="center">'.$item_info['stock']['submitted'].'</td>
                                                            <td width="23%" align="center">'.$item_info['stock']['recieved'].'</td>
                                                            <td width="23%" align="center">'.$item_info['stock']['availabe'].'</td>
                                                        </tr>';
                                            }
                                        } 
                                        
                                    $html .= '</table>
                                </td>
                            </tr>
                        </tbody> 
                    </table> 
                ';               
                $i++;
            } 
            
            
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
            $pdf->Output('Consignee_Stocks.pdf', 'I');
        }
        
        public function  load_data(){ 
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post(); 
//            echo '<pre>';            print_r($input); die; 
            
            $search_data = array(
                                'consignee_id' => $input['consignee_id'],
                                'from_date' => strtotime($input['from_date']),
                                'to_date' => strtotime($input['to_date']),
                                );
            $this->load->model("Payments_model");
            $consignee_subs = $this->Reports_all_model->get_consignee_submission_desc($search_data);
//            $consignee_recs = $this->Reports_all_model->get_consignee_recieve_desc($search_data);
            
            $rep_data = array();
            $this->load->model('Consignees_model');
            foreach ($consignee_subs as $cs){
                $consignee_recs = $this->Reports_all_model->get_consignee_recieve_desc($search_data,'crd.item_id = '.$cs['item_id']);
                $rep_data[$cs['consignee_id']]['items'][$cs['item_id']]['submitted_data'] = $cs;
                $rep_data[$cs['consignee_id']]['items'][$cs['item_id']]['received_data'] = $consignee_recs;
                
                $submitted_uom1 = $cs['item_quantity'] - ((isset($consignee_recs[0]['item_quantity']))?$consignee_recs[0]['item_quantity']:0);
                $submitted_uom2 = $cs['item_quantity_2'] - ((isset($consignee_recs[0]['item_quantity_2']))?$consignee_recs[0]['item_quantity_2']:0);
                $rep_data[$cs['consignee_id']]['items'][$cs['item_id']]['stock'] = array(
                                                                                            'submitted'=> $cs['item_quantity'].' '.$cs['uom_name'].' | '.$cs['item_quantity_2'].' '.$cs['uom_name_2'],
                                                                                            'recieved'=> ((isset($consignee_recs[0]['item_quantity']))?$consignee_recs[0]['item_quantity']:0).' '.$cs['uom_name'].' | '.((isset($consignee_recs[0]['item_quantity_2']))?$consignee_recs[0]['item_quantity_2']:0).' '.$cs['uom_name_2'],
                                                                                            'availabe'=> $submitted_uom1.' '.$cs['uom_name'].' | '.$submitted_uom2.' '.$cs['uom_name_2'],
                                                                                        );
                $consignee_info = $this->Consignees_model->get_single_row($cs['consignee_id']);
                $rep_data[$cs['consignee_id']]['consignee_info'] = $consignee_info[0];
            }
//                echo '<pre>';            print_r($rep_data); die; 
            return $rep_data;
        }
}
