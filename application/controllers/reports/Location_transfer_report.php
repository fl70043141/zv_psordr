<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_transfer_report extends CI_Controller {
  
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
            $data['main_content']='reports_all/inventory/location_transfer/search_location_transfer_report'; 
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_name','id','Location');
            $data['item_cat_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','Item Cayegory');
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
            $this->load->view('reports_all/inventory/location_transfer/search_location_transfer_report_result',$invoices);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $loc_transfers = $this->load_data();  
//            echo '<pre>';            print_r($input_get); die; 
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
             
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Location Transfer';//invice bg
            
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
                            <td><b>Report: Location Transfer Summary </b></td>
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr>
                        <tr>
                            <td>Dates Result: '.$this->input->get('transfer_from_date').' - '.$this->input->get('transfer_to_date').'</td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                    </table> ';
            $i=1; 
            
            $html .= '<table  class="table-line" border="0">
                        <thead> 
                            <tr class="colored_bg">
                                <th width="12%" align="left">Code</th> 
                                <th width="18%" align="center">Desc</th> 
                                <th width="12%" align="center">Transfer Date</th> 
                                <th width="20%" align="center">From</th> 
                                <th width="20%" align="center">To</th> 
                                <th width="20%" align="center">Qty</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($loc_transfers as $loc_transf){
//            echo '<pre>';            print_r($loc_transf); die;
                    foreach ($loc_transf['trans_desc'] as $item){  

                         $html .= '<tr>
                                     <td width="12%" align="left">'.$item['item_code'].'</td>
                                     <td width="18%" align="center">'.$item['item_description'].'</td>
                                     <td width="12%" align="center" >'.date(SYS_DATE_FORMAT,$loc_transf['transfer_date']).'</td>
                                     <td width="20%" align="center" >'.$loc_transf['from_location_name'].'</td>
                                     <td width="20%" align="center" >'.$loc_transf['to_location_name'].'</td>
                                     <td width="20%" align="center">'.$item['item_quantity'].' '.$item['uom_name'].(($item['item_quantity_uom_id_2']!=0)?' | '.$item['item_quantity_2'].' '.$item['uom_name_2']:'').'</td>

                                 </tr>';
                     }               
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
            $pdf->Output('Purchase_Summary.pdf', 'I');
        }
        
        public function  load_data(){
            $invoices = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post(); 
//            echo '<pre>';            print_r($input); die; 
            $data = array(
                            'from_location_id' => $input['from_location_id'],
                            'to_location_id' => $input['to_location_id'],
                            'from_date' => strtotime($input['transfer_from_date']),
                            'to_date' => strtotime($input['transfer_to_date']),
                    ); 
            $location_transfers = $this->Reports_all_model->get_location_transfers($data);
            
            $ret_arr = array();
            foreach ($location_transfers as $loc_trans){
//            echo '<pre>';            print_r($loc_trans); die; 
                $ret_arr[$loc_trans['id']] = $loc_trans; 
                $ret_arr[$loc_trans['id']]['trans_desc'] = $this->Reports_all_model->get_location_transfers_desc($loc_trans['id']);;
                
            } 
            
//            echo '<pre>';            print_r($ret_arr); die; 
            return $ret_arr;
        }
}
