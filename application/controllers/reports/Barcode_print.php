<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode_print extends CI_Controller {
  
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
            $data['main_content']='reports_all/inventory/barcode_print/search_summary_report'; 
            $data['supplier_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id','Supplier');
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
            $this->load->view('reports_all/inventory/barcode_print/search_summary_report_result',$invoices);
	} 
        
        public function print_report(){ 
//            $this->input->post() = 'aa';
            $report_data = $this->load_data_barcode(); 
//            echo '<pre>';            print_r($report_data); die; 
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_empty';//invice bg
            
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
            
            // define barcode style
                $style = array(
                    'position' => '',
                    'align' => 'C',
                    'stretch' => false,
                    'fitwidth' => true,
                    'cellfitalign' => '',
                    'border' => false,
                    'hpadding' => 'auto',
                    'vpadding' => 'auto',
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false, //array(255,255,255),
                    'text' => true,
                    'font' => 'helvetica',
                    'fontsize' => 8,
                    'stretchtext' => 4
                );
 
                $from=1; $to=100;$arr_key=0;
                $bc_arr = array(); 
                $count=1;
                foreach ($report_data as $item_bc){

                    require_once dirname(__FILE__) . '\..\..\libraries\tcpdf\tcpdf_barcodes_1d.php';
                    $barcodeobj = new TCPDFBarcode($item_bc['item_code'], 'C128');
                    $img =  $barcodeobj->getBarcodePngData(1.5,20); 
                    $base64 = 'data:image/png;base64,' . base64_encode($img);  

                    $item_seriel = $item_bc['item_code'];
                    $item_desc = $item_bc['supplier_item_desc'];
                    for($i=0;$i<$item_bc['purchasing_unit'];$i++){
                        $bc_arr[$count] = array(
                                            'sup_info'=>'AG',
                                            'base64'=>$base64,
                                            'item_serial'=>$item_seriel,
                                            'item_desc'=>$item_desc,
                                            );
                        $count++;
                    }
                    
                }
                $bc_count = count($bc_arr);
                $to=$bc_count;
//            echo '<pre>';            print_r($bc_count); die; 
                   
                $rows = ($bc_count-($bc_count%6))/6; 
                if(($bc_count%6)>0){
                    $rows++;
                }
                //if($rows < 1){$rows=1;}
                $html = '<table border="0.2" cellpadding="2" ><tbody>
                    <tr>
                        <td width="2.9%"></td>
                        <td width="96.2%" colspan="6" style="line-height:9mm;"></td>
                        <td width="2.9%"></td>
                    </tr>';
                $sticker_count = 1;
                //$rows =18;
                for($i=0;$i<$rows;$i++){
                 $html .= '<tr> 
                                       <td width="2.9%"></td>';
                                       for($k=0;$k<6;$k++){
                                           if($sticker_count>=$from & $sticker_count<=$to){
                                            $html .= '<td style="padding:10px; overflow:hidden;"><table border="0" >
                                                         <tr>
                                                             <td colspan="4"  style="line-height:1.2mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:2.30mm;padding-top: 2px;"><span style="text-align:center;font-size:9px;">'.$_SESSION[SYSTEM_CODE]['company_name'].'</span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td width="5%" style="line-height:1mm;"></td>
                                                             <td width="18%" style="line-height:6mm;"><p style="font-size:6px;">'.$bc_arr[$sticker_count]["sup_info"].'</p></td>
                                                             <td width="65%" style="line-height:6mm;"><img src="'.$bc_arr[$sticker_count]["base64"].'"></td>
                                                             <td width="3%" style="line-height:6mm;"></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7.5px;text-align:center">'.$bc_arr[$sticker_count]["item_serial"].'</span></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7px;text-align:center">'.$bc_arr[$sticker_count]["item_desc"].'</span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:0.8mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                     </table>
                                                     </td>  '; 
                                            }else{
                                                $html .= '<td style="padding:10px; overflow:hidden;"><table border="0" >
                                                         <tr>
                                                             <td colspan="4"  style="line-height:1.2mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:2.30mm;padding-top: 2px;"><span style="text-align:center;font-size:9px;"></span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td width="5%" style="line-height:1mm;"></td>
                                                             <td width="18%" style="line-height:6mm;"><p style="font-size:6px;"></p></td>
                                                             <td width="65%" style="line-height:6mm;"></td>
                                                             <td width="3%" style="line-height:6mm;"></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7.5px;text-align:center"></span></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:1.9mm;"><span style="font-size:7px;text-align:center"></span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:0.8mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                     </table>
                                                     </td>  '; 
                                            }
                                           $sticker_count++;
                                       }

                                     $html .= '   <td width="2.9%"></td>
                                </tr> ';
                        }
                         $html .= '</tbody></table>'; 
                //         echo $html; die;
                // print a block of text using Write()
                $pdf->writeHTMLCell(210,20,0,0,$html);

        // ---------------------------------------------------------



        //Close and output PDF document
        $pdf->Output('barcode_.pdf', 'I');
        }
        
        public function  load_data(){
            $invoices = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post();
            $this->load->model("Payments_model");
            $this->load->model("Purchase_report_models");
            $cust_list = $this->Purchase_report_models->get_suppliers($input['supplier_id']);
             
            //search invoices 
            foreach ($cust_list as $cust){
                $search_data=array( 
                                    'supplier_id' => $cust['id'],
                                    'invoice_no' => $input['supplier_invoice_no'],  
                                    'from_date' => strtotime($input['purchase_from_date']),  
                                    'to_date' => strtotime($input['purchase_to_date'])  
                                    ); 
                
                $invoices['rep_data'][$cust['id']]['supplier'] = $cust;
                $invoice_list = $this->Purchase_report_models->search_result($search_data);
                if(!empty($invoice_list)){
                    foreach ($invoice_list as $invoice){
                        $invoices['rep_data'][$cust['id']]['invoices'][$invoice['id']]=$invoice;
                        $invoices['rep_data'][$cust['id']]['invoices'][$invoice['id']]['transections']= $this->Payments_model->get_transections(20,$invoice['id'],'transection_type_id = 3');
                    }
                }
                
            } 
//            echo '<pre>';            print_r($cust_list); die; 
            return $invoices;
        }
        public function  load_data_barcode(){
            $invoices = array();
            $input = (empty($this->input->post()))? $this->input->get():$this->input->post(); 
            $this->load->model("Purchasing_invoices_model");
            $purch_info = $this->Purchasing_invoices_model->get_invc_desc($input['prc_id']);
             
            return $purch_info;
        }
}
