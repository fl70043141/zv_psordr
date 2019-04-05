<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode_print_a4_60 extends CI_Controller {
  
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
            $data['main_content']='reports_all/inventory/barcode_print_a4_60/search_summary_report'; 
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
            $this->load->view('reports_all/inventory/barcode_print_a4_60/search_summary_report_result',$invoices);
	} 
        
        public function print_report(){
//            $this->input->post() = 'aa';
//            $report_data = $this->load_data_barcode(); 
            $inputs = $this->input->get();
//            echo '<pre>';            print_r($inputs); die; 
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
            
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('FAHRY LAFIR');
            $pdf->SetTitle('NVELOOP SOLUTION');
            $pdf->SetSubject('BARCODE PRINT');
            $pdf->SetKeywords('BARCODE');

            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            //$pdf->SetMargins(0,0,0);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                    require_once(dirname(__FILE__).'/lang/eng.php');
                    $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set font
            //$pdf->SetFont('times', 'BI', 20);

            $pdf->AddPage('P',array('297','210')); 
            
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
 
                $from=$inputs['start_from']; $to=($inputs['start_from']+$inputs['units']-1);$arr_key=0;
                $bc_arr = array(); 
                $count=1;
                
                require_once dirname(__FILE__) . '/../../libraries/tcpdf/tcpdf_barcodes_1d.php';
                $barcodeobj = new TCPDFBarcode($inputs['item_code'], 'C128');
                $img =  $barcodeobj->getBarcodePngData(2,20); 
                $base64 = 'data:image/png;base64,' . base64_encode($img);  
                    
                $bc_count = ($inputs['start_from']+$inputs['units'])-1;
//                $to=$bc_count;
                 
                   
                $rows = ($bc_count-($bc_count%5))/5; 
                if(($bc_count%5)>0){
                    $rows++;
                }
//                echo '<pre>';            print_r($inputs); die;  
                //if($rows < 1){$rows=1;}
                $html = '<table border="0.0" cellpadding="2" ><tbody>
                    <tr>
                        <td width="2%" style="line-height:0.8mm;"></td>
                        <td width="96%" colspan="5" style="line-height:0.8mm;"></td>
                        <td width="2%" style="line-height:0.8mm;"></td>
                    </tr>';
                $sticker_count = 1;
                //$rows =18;
                for($i=0;$i<$rows;$i++){
                 $html .= '<tr> 
                                       <td width="2%"></td>';
                                       for($k=0;$k<5;$k++){
                                           if($sticker_count>=$from & $sticker_count<=$to){
                                            $html .= '<td style="padding:10px; overflow:hidden;"><table border="0.0" >
                                                         <tr>
                                                             <td colspan="4"  style="line-height:2.0mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:3.80mm;padding-top: 10px;padding-bottom: 10px;"><span style="text-align:center;font-size:12px;">'.(($inputs['company_name']!='')?strtoupper($inputs['company_name']):SYSTEM_NAME).'</span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:1.8mm;padding-top: 2px;"><span style="text-align:center;font-size:8px;">'.((isset($inputs['city_name']) && $inputs['city_name']!="")?$inputs['city_name']:'').'</span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td width="5%" style="line-height:1mm;"></td> 
                                                             <td colspan="2" width="87%" style="line-height:4mm;"><img src="'.$base64.'"></td>
                                                             <td width="3%" style="line-height:4mm;"></td>
                                                         </tr>
                                                         <tr>
                                                             <td width="5%" style="line-height:2mm;"></td> 
                                                             <td width="60%"  style="line-height:2mm;"><span style="font-size:7.5px;text-align:left">'.$inputs['item_code'].(($inputs['supp_code']!='')?'-'.$inputs['supp_code']:'').(($inputs['cost_code']!='')?'-'.$inputs['cost_code']:'').((isset($inputs['pric_fixed']) && $inputs['pric_fixed']==1)?'- X':'').'</span></td>
                                                             <td width="30%" style="line-height:2mm;"><span style="font-size:7.5px;text-align:right">'.(($inputs['other_entry']!='')?$inputs['other_entry']:'').'</span></td> 
                                                             <td width="5%" style="line-height:2mm;"></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:4mm;"><span style="font-size:11px;text-align:center"><b>'.(($inputs['sales_price']>0)?'Rs. '.number_format($inputs['sales_price'],2):'').'</b></span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:4mm;padding-top: 2px;"><span style="font-size:7.5px;text-align:center">'.(($inputs['item_name']!='')?$inputs['item_name']:'').'</span></td> 
                                                         </tr>
                                                     </table>
                                                     </td>  '; 
                                            }else{
                                                $html .= '<td style="padding:10px; overflow:hidden;"><table border="0" >
                                                         <tr>
                                                             <td colspan="4"  style="line-height:1.7mm;padding-top: 2px;"> </td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:5.8mm;padding-top: 2px;"><span style="text-align:center;font-size:9px;"> </span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td width="5%" style="line-height:1mm;"> </td>
                                                             <td colspan="2" width="87%" style="line-height:22mm;"><p style="font-size:6px;"> </p></td>
                                                             <td width="3%" style="line-height:6mm;"> </td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:2mm;"><span style="font-size:7.5px;text-align:center"> </span></td>
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4" style="line-height:2.15mm;"><span style="font-size:7px;text-align:center"> </span></td> 
                                                         </tr>
                                                         <tr>
                                                             <td colspan="4"  style="line-height:2.3mm;padding-top: 2px;"></td> 
                                                         </tr>
                                                     </table>
                                                     </td>  '; 
                                            }
                                           $sticker_count++;
                                       }

                                     $html .= '   <td width="2%"></td>
                                </tr> ';
                        }
                         $html .= '</tbody></table>'; 
                //         echo $html; die;
                // print a block of text using Write()
                $pdf->writeHTMLCell(210,20,0,0,$html);

        // ---------------------------------------------------------



        //Close and output PDF document
        $pdf->Output('barcode_a4_60_.pdf', 'I');
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
