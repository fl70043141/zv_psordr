<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SummaryReports extends CI_Controller {
  
        function __construct() {
            parent::__construct();
            $this->load->model('SummaryReports_model');
        }

        public function index(){ 
              //I'm just using rand() function for data example 
            $this->view_search_report();
	}
        
        function view_search_report($datas=''){
            
            $column_array = array(
                                    'report_no' => 'Report No',
                                    'customer_name' => 'Customer Name',
                                    'gem_type_name' => 'Type',
                                    'spec_cost_name' => 'Special',
                                    'report_date' => 'Date',
                                    'object_val' => 'Item',
                                    'identification_val' => 'Identification',
                                    'variety_val' => 'Variety',
                                    'weight' => 'Weight',
                                    'dimension' => 'Dimension',
                                    'cut_val' => 'Cut',
                                    'polish' => 'Polish',
                                    'shape_val' => 'Shape',
                                    'color' => 'Color',
                                    'color_distribution_val' => 'Color Type',
                                    'transparency' => 'Transparency',
                                    'country_name' => 'Origin',
                                    'comments' => 'Comments',
                                    'special_note' => 'Special Note',
                                    'appendix' => 'Appendix',
                                    'added_on' => 'Added Date',
                                    'added_by' => 'Added By',
                                    );
            $selected_array = array(  'report_no' ,  'customer_name'  ,'report_date' , 'identification_val', 'variety_val', 'weight');
//                        echo '<pre>'; print_r($column_array); die;
            $data['report_cols'] = $column_array;
            $data['customer_list'] = get_dropdown_data(AGENTS,'agent_name','id','Customer Name');
            $data['report_cols_selected'] = $selected_array;
            $data['report_list'] = $this->SummaryReports_model->search_result();
            $data['main_content']='summary_reports/search_summary_report'; 
            $this->load->view('includes/template',$data);
	}
                    
	
         
        
        function load_data($id=''){ 
            if($id!=''){ 
                $data['property_data'] = $this->Report_model->get_single_row($id); 
             }else{
                 
                $data['report_no'] = gen_id(REPNO_PREFIX, LAB_REPORT, 'id');
             }
            $data['country_list'] = get_dropdown_data(COUNTRY_LIST,'country_name','country_code','Country');
            $data['agent_type_list'] = get_dropdown_data(AGENT_TYPE,'agent_type_name','id','Agent Type');
            $data['customer_list'] = get_dropdown_data(AGENTS,'agent_name','id','Customer Name');
            $data['gem_type_list'] = get_dropdown_data(GEM_CAT,'name','id','Stone Category');
            $data['spec_cost_list'] = get_dropdown_data(SPEC_COST,'name','id','Special Cost');
            
            $data['item_list_dpd']             = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Item',array('col'=>'dropdown_id', 'val'=>4));
            $data['identification_list_dpd']   = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Identification',array('col'=>'dropdown_id', 'val'=>5));
            $data['variety_list_dpd']          = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Variety',array('col'=>'dropdown_id', 'val'=>6));
            $data['cut_list_dpd']              = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Cut',array('col'=>'dropdown_id', 'val'=>7));
            $data['shape_list_dpd']            = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Shape',array('col'=>'dropdown_id', 'val'=>8));
            $data['color_type_list_dpd']       = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Color Distribution',array('col'=>'dropdown_id', 'val'=>9));
            $data['refractive_index_list_dpd'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Refractive Index',array('col'=>'dropdown_id', 'val'=>10));
            $data['specific_gravity_list_dpd'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Item',array('col'=>'dropdown_id', 'val'=>11));


            return $data;	
	}	
        
        function search_summary_report_arangement(){
            
                $status = $this->input->post('status'); 

		$search_data=array( 'report_no' => $this->input->post('report_no'), 
                                    'report_date' => $this->input->post('date'), 
                                    'date_monthly' => $this->input->post('date_monthly'), 
                                    'date_year' => $this->input->post('date_year'), 
                                    'customer' => $this->input->post('customer'), 
                                    'status' => ($status!='')?1:0);  

		$data_view['search_list'] = $this->SummaryReports_model->search_result($search_data);
                
                 $column_array = array(
                                    'report_no' => 'Report No',
                                    'customer_name' => 'Customer Name',
                                    'gem_type_name' => 'Type',
                                    'spec_cost_name' => 'Special',
                                    'report_date' => 'Date',
                                    'object_val' => 'Item',
                                    'identification_val' => 'Identification',
                                    'variety_val' => 'Variety',
                                    'weight' => 'Weight',
                                    'dimension' => 'Dimension',
                                    'cut_val' => 'Cut',
                                    'polish' => 'Polish',
                                    'shape_val' => 'Shape',
                                    'color' => 'Color',
                                    'color_distribution_val' => 'Color Type',
                                    'transparency' => 'Transparency',
                                    'country_name' => 'Origin',
                                    'comments' => 'Comments',
                                    'special_note' => 'Special Note',
                                    'appendix' => 'Appendix',
                                    'added_on' => 'Added Date',
                                    'added_by' => 'Added By',
                                    );
		$data_view['all_report_columns'] =  $column_array  ;
		$data_view['report_columns'] =  $this->input->post('report_columns')  ;
                return $data_view;
        }
        function search_summary_report(){  
                $data_view = $this->search_summary_report_arangement();
		$this->load->view('summary_reports/search_summary_report_result',$data_view);
	}
        
         function generate_pdf(){ 
             $this->load->model('Company_model');
             $company_det = $this->Company_model->get_single_row(1);
             $company_det = $company_det[0];
//             echo '<pre>';             print_r($company_det); die;
            $data= $this->search_summary_report_arangement();
            //load library
            $this->load->library('Pdf');

            $pdf = new Pdf('p', 'mm', 'A4', true, 'UTF-8', false);
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF BGL Report');
            $pdf->SetSubject('BGL Report');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            // remove default header/footer
            $pdf->setPrintHeader(true);
            $pdf->setPrintFooter(false);

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(10, 22, 10);
            

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 5);
            
            define ('REPORT_HEADER_STR', $company_det['street_address'].','.$company_det['city'].','.$company_det['country'].','.$company_det['zipcode']);
            // set default header data
            $pdf->setHeaderMargin(4);
            $pdf->SetHeaderData(base_url(COMPANY_LOGO.$company_det['logo']), '45', $company_det['company_name'], REPORT_HEADER_STR);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
 
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

            // set font
            $pdf->SetFont('times','',9);  
            
            $pdf->SetAutoPageBreak(true, 22);
            $pdf->AddPage('P', 'A4'); 
            
            //table header
            $tbl_header='<th class="id_first">#</th>';
            foreach ($data['report_columns'] as $h_column){
                $tbl_header .=  '<th style="width:'.(95/count($data['report_columns'])).'%;">'.$data['all_report_columns'][$h_column].'</th>';
            }
            
            //table data
            $tbl_data = '';
            $i = 0;
            $bg_clr = '';
            foreach ($data['search_list'] as $row){ 
                $bg_clr = '#FFFFFF';
                if($i%2==0){
                    $bg_clr='#F8F8F8';
                }
               $tbl_data .= '<tr nobr="true" style="background-color:'.$bg_clr.';"> <td>'.($i+1).'</td>';
               foreach ($data['report_columns'] as $h_column){
                               $tbl_data .= '<td>'.$row[$h_column].'</td>';
                           }
                $tbl_data .= '</tr>';
               $i++;
           }
            // define some HTML content with style
            $html = ' <style>
                            
                           .id_first{ 
                                text-align:center;  
                                height:20px; 
                                width:5%;
                            }
                           td{
                                height:18px;
                                text-align:center
                                border:1px solid #000;
                                
                            }

                            th{
                               text-align:center; 
                               background-color:#E8E8E8;
                            }
                    </style>
                    <table width="100%" border="1">
                        <tr>
                            '.$tbl_header.'
                        </tr>
                            '.$tbl_data.'
                    </table>
                    ';
            

//             echo '<pre>';
//             print_r( $html); die;
            // output the HTML content
            $pdf->writeHTML( $html); 
            $pdf_output = $pdf->Output('aa.pdf', 'I');
                    
           
        }
        
                                        
        function test(){
            $this->load->model('RemoteSync_model');
            $this->load->library('Curl');
            $this->RemoteSync_model->postToRemoteServer();
            //load library  
//            echo gen_id(REPNO_PREFIX, LAB_REPORT, 'id');
            echo '<img src ="'. base_url().COMPANY_LOGO.'logo_1.png">';

            echo COMPANY_LOGO.'logo_1.png';
        }
                                        
        function report_print($report_no){
            $report_data = $this->Report_model->get_single_row($report_no);
            $report_data = $report_data[0];
            redirect(base_url().LAB_REPORT_PDF.$report_data['report_no'].'.pdf');
        }
         
}
