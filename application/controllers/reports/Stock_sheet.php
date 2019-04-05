<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_sheet extends CI_Controller {
  
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
            $data['main_content']='reports_all/inventory/stock_sheet/search_stock_sheet_report'; 
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
            $this->load->view('reports_all/inventory/stock_sheet/search_stock_sheet_report_result',$invoices);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $item_stocks_cat = $this->load_data(); 
//            echo '<pre>';            print_r($item_stocks_cat); die; 
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Stock Sheet';//invice bg
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
            $pdf->SetFont('times', '', 10);
        
        
            $pdf->AddPage();   
            $pdf->SetTextColor(32,32,32);     
            $html = '<table border="0">
                        <tr>
                            <td><b>Report: Stock Summary </b></td>
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                    </table> ';
            $i=1; 
            
            foreach ($item_stocks_cat as $item_stocks){
//            echo '<pre>';            print_r($item_stocks); die;
            $html .= '<table  class="table-line" border="0">
                        <thead>
                            <tr class="">
                                <th align="left" colspan="6"></th>
                            </tr>
                            <tr class="">
                                <th align="left" colspan="6">'.$i.'. <u>'.$item_stocks['item_category_name'].'</u></th>
                            </tr>
                            <tr class="colored_bg">
                                <th width="14%" align="left">Code</th> 
                                <th width="23%" align="left">Desc</th> 
                                <th width="21%" align="center" colspan="2">In Stock</th> 
                                <th width="21%" align="center" colspan="2">On Reserved</th>  
                                <th width="21%" align="center" colspan="2">Available</th>
                            </tr>
                            <tr class="colored_bg">
                                <th width="14%" align="left"></th> 
                                <th width="23%" align="left"></th> 
                                <th width="11%" align="right">Weight</th> 
                                <th width="10%" align="center">Qty</th>   
                                <th width="11%" align="right">Weight</th> 
                                <th width="10%" align="center">Qty</th>   
                                <th width="11%" align="right">Weight</th> 
                                <th width="10%" align="center">Qty</th>    
                            </tr>
                        </thead>
                        <tbody>';
                       foreach ($item_stocks['item_list'] as $item){  
                                            if($item['units_available']>0){
                                            $html .= '<tr>
                                                        <td width="14%" align="left">'.$item['item_code'].'</td>
                                                        <td width="23%" align="left">'.$item['item_name'].'</td>
                                                        <td width="11%" align="right" >'.$item['units_available'].' '.$item['uom_name'].'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;">'.(($item['uom_id_2']!=0)?$item['units_available_2'].' '.$item['uom_name_2']:'-').'</td>
                                                        <td width="11%" align="right">'.$item['units_on_reserve'].' '.$item['uom_name'].'</td>
                                                        <td width="10%" align="center" style="border-right: 1px solid #cdd0d4;">'.(($item['uom_id_2']!=0)?$item['units_on_reserve_2'].' '.$item['uom_name_2']:'').'</td>
                                                        <td width="11%" align="right">'.($item['units_available']-$item['units_on_reserve']).' '.$item['uom_name'].'</td>
                                                        <td width="10%" align="center">'.($item['units_available_2']-$item['units_on_reserve_2']).' '.$item['uom_name_2'].'</td>

                                                    </tr>';
                                            }
                                        }      
            $html .= '</tbody> 
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
                    .table-line td{ 
                        font-size: 8;
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
//            $this->load->model("Reports_all_model");
            $item_stocks = $this->Reports_all_model->get_item_stocks($input['location_id'],$input['item_category_id']);
            
//            echo '<pre>';            print_r($item_stocks); die; 
            $ret_arr = array();
            foreach ($item_stocks as $item_stock){
                $ret_arr[$item_stock['item_category_id']]['item_category_name'] = $item_stock['item_category_name'];
                $ret_arr[$item_stock['item_category_id']]['item_list'][$item_stock['item_id']] = $item_stock;
            } 
            
//            echo '<pre>';            print_r($ret_arr); die; 
            return $ret_arr;
        }
}
