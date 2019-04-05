<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pnl_gemstones extends CI_Controller {
  
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
            $data['main_content']='reports_all/ledgers/pnl_gemstones/search_pnl_gemstone_report'; 
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_name','id','Location');
            $data['item_cat_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Gem Category','is_gem = 1');
            
            $data['treatments_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Treatment','dropdown_id = 5'); //14 for treatments
            $data['shape_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Shape','dropdown_id = 16'); //16 for Shape
            $data['color_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Color','dropdown_id = 17'); //17 for Color
            $data['item_type_list'] = get_dropdown_data(ITEM_TYPES,'item_type_name','id','No Item Type'); 
            
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
            $data['rep_data'] = $this->load_data(); 
            $this->load->view('reports_all/ledgers/pnl_gemstones/search_pnl_gemstone_report_result',$data);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $item_stocks = $this->load_data(); 
            $inputs = $this->input->get();
//            echo '<pre>';            print_r($this->input->get()); die;
            $category_name = ($inputs['item_category_id'] != '')?get_single_row_helper(ITEM_CAT,'id = "'.$inputs['item_category_id'].'"')['category_name']:'All'; 
            $treatment_name = ($inputs['treatment_id'] != '')?get_single_row_helper(DROPDOWN_LIST,'id = "'.$inputs['treatment_id'].'"')['dropdown_value']:'All'; 
           
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
             $def_cur = get_single_row_helper(CURRENCY,'code="'.$this->session->userdata(SYSTEM_CODE)['default_currency'].'"');
//            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Report';//invice bg
            $pdf->fl_header_title_RTOP='Sale Profit Contribution';//invice bg
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
            
            $html .=' <table id="example1" class="table table-line " border="0">
                            <thead> 
                                <tr style=""> 
                                    <th width="4%" style="text-align: left;"><u><b>#</b></u></th>  
                                    <th width="8%" style="text-align: left;"><u><b>Code</b></u></th>  
                                    <th width="15%" style="text-align: left;"><u><b>Desc</b></u></th>  
                                    <th width="14%" style="text-align: center;"><u><b>Unit</b></u></th>    
                                    <th width="12%" style="text-align: right;"><u><b>Purch Cost</b></u></th> 
                                    <th width="12%" style="text-align: right;"><u><b>Lapidary Cost</b></u></th> 
                                    <th width="12%" style="text-align: right;"><u><b>Total Cost</b></u></th> 
                                    <th width="12%" style="text-align: right;"><u><b>Sales</b></u></th>  
                                    <th width="12%" style="text-align: right;"><u><b>Profit</b></u></th> 
                                 </tr>
                            </thead>
                        <tbody>';
            
            $tot_sales = $tot_pnl = $all_tot_units = $all_tot_units_2 = $all_tot_amount = $item_count = 0;
            $i = 1; 
            foreach ($item_stocks as $item){
//                echo '<pre>';            print_r($item); die;    

                $tot_units = $item['item_quantity'];
                $tot_units_2 = $item['item_quantity_2'] ; 
                $cost = $item['purch_standard_cost'] + $item['total_lapidary_cost'];

                $all_tot_units += $tot_units;
                $all_tot_units_2 += $tot_units_2;
                $all_tot_amount += $cost;
                $tot_sales += $item['item_sale_amount'];

                $pnl_amount = $item['item_sale_amount'] - $cost;
                $tot_pnl += $pnl_amount;

              
                   $html .= '
                       <tr>
                           <td style="width:4%;">'.$i.'</td> 
                           <td style="width:8%;" align="left">'.$item['item_code'].'</td>
                           <td style="width:15%;" align="left">'.$item['item_name'].(($item['type_short_name']!='')?' <b>('.$item['type_short_name'].')</b>':'').'</td>
                           <td style="width:14%;" align="center">'.$item['item_quantity'].' '.$item['uom_name'].(($item['item_quantity_uom_id_2']!=0)?' | '.$item['item_quantity_2'].' '.$item['uom_name_2']:'-').'</td>
                           <td style="width:12%;" align="right">'. number_format($item['purch_standard_cost'],2).'</td>
                           <td style="width:12%;" align="right">'. number_format($item['total_lapidary_cost'],2).'</td>
                           <td style="width:12%;" align="right">'. number_format($cost,2).'</td>
                           <td style="width:12%;" align="right">'. number_format($item['item_sale_amount'],2).'</td>
                            <td style="width:12%; text-align:right; color:'.(($pnl_amount<0)?'red':'').';" >'. number_format($pnl_amount,2).'</td>
                      </tr>'; 
                   $i++;
                   $item_count++; 
            } 
            $html .= '</tbody></table>';
            
            $html = '<table border="0">
                        <tr>
                            <td><b>Report: Sales Profit Contribution Report</b></td>
                            <td align="center"> Variety: '.$category_name.' </td> 
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr> 
                        <tr>
                            <td></td>
                            <td align="center">CDC: '.$treatment_name.' </td>
                            <td align="right">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                        <tr><td colspan="3"></td></tr>
                        <tr>
                            <td colspan="3"><b>Report Summary -</b><br>
                                Items: '.$item_count.'<br>
                                Units: '.$all_tot_units.' '.((isset($item))?$item['uom_name'].(($item['item_quantity_uom_id_2']!=0)?' |  '.$all_tot_units_2.' '.$item['uom_name_2']:'-'):'').' <br> 
                                Total Sale: '.$def_cur['code'].' '. number_format($tot_sales,2).'<br>
                                Total Cost: '.$def_cur['code'].' '. number_format($all_tot_amount,2).'<br>
                                '.(($tot_pnl>0)?'Profit':'Lost').' Amount : '.$def_cur['code'].' '. number_format($tot_pnl,2).'</td>
                        </tr> 
                        
                        <tr><td colspan="3"></td></tr>
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
            $pdf->Output('PNL_Gemstone_report.pdf', 'I');
        }
        
        public function  load_data(){
            $invoices = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post(); 
//            echo '<pre>';            print_r($input); die;  
            $this->load->model("Reports_all_model");
            $item_stocks = $this->Reports_all_model->get_sales_profit($input);
            
//            echo '<pre>';            print_r($item_stocks); die; 
            $ret_arr = array();
            foreach ($item_stocks as $item_stock){
                $ret_arr[$item_stock['item_id']] = $item_stock;
                $ret_arr[$item_stock['item_id']]['lapidary_costs'] = $this->Reports_all_model->get_gemstone_lapidary_costing($item_stock['item_id']);
                
            } 
            
//            echo '<pre>';            print_r($ret_arr); die; 
            return $ret_arr;
        }
}
