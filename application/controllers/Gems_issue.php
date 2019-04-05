<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gems_issue extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Gems_issue_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
//            $this->add();
            $data['search_list'] = $this->Gems_issue_model->search_result();
            $data['main_content']='gem_issue/search_gem_issue'; 
            $data['gem_issue_type_list'] = get_dropdown_data(GEM_ISSUE_TYPES,'gem_issue_type_name','id','No Issue Type');
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_name','id','No Location');
            $data['lab_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Labs','dropdown_id=4');
            $data['cutter_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Cutter','dropdown_id=19');
            $data['heater_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Heater','dropdown_id=21');
            $data['polishing_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Polishing Lapidarist','dropdown_id=20');
            $this->load->view('includes/template',$data);
	}
                    
	function add(){ 
            $data  			= $this->load_data(); 
            $data['action']		= 'Add';
            $data['main_content'] = 'gem_issue/manage_gem_issue';    
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'Edit';
            $data['main_content' ] = 'gem_issue/view_gem_issue';  
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']= 'gem_issue/view_gem_issue';  
            
            $this->load->view('includes/template',$data); 
	}
	
	function view($id){ 
            $data  			= $this->load_data($id); 
            $data['action']		= 'View';
            $data['main_content' ] = 'gem_issue/view_gem_issue';  
            $this->load->view('includes/template',$data);
	}
	function view_POS($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='gem_issue/view_gem_issue'; 
            $data['inv_data'] = $this->get_gem_issue_info($id);
//            echo '<pre>';            print_r($data); die; 
            $this->load->view('includes/template_pos',$data);  
	}
	
        
	function validate(){   
            $this->form_val_setrules(); 
            if($this->form_validation->run() == False && $this->input->post('action')!='Delete'){
                switch($this->input->post('action')){
                    case 'Add':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form'); 
                            $this->add();
                            break;
                    case 'Edit':
                            $this->session->set_flashdata('error','Not Saved! Please Recheck the form');
                            $this->edit($this->input->post('id'));
                            break;
                    case 'Delete':
                            $this->delete($this->input->post('id'));
                            break;
                } 
            }
            else{
                switch($this->input->post('action')){
                    case 'Add':
                            $this->create();
                    break;
                    case 'Edit':
                        $this->update();
                    break;
                    case 'Delete':
                        $this->remove();
                    break;
                    case 'View':
                        $this->view();
                    break;
                }	
            }
	}
        
	function form_val_setrules(){
//            echo '<pre>';            print_r($_POST); die;
            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('return_date','Return Date','required');
            $this->form_validation->set_rules('issue_date','Issue Date','required');
            $this->form_validation->set_rules('location_id','Location','required'); 
      }	 
        
	function create(){
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die;
            $gmi_id = get_autoincrement_no(GEM_ISSUES);
            $gmi_no = gen_id(GM_ISSUE_PREFIX, GEM_ISSUES, 'id');
                    
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $receiver_id = '';
            switch($inputs['gem_issue_type_id']){
                case 1: $receiver_id = $inputs['gem_cutter_id']; break;
                case 2: $receiver_id = $inputs['gem_lab_id']; break;
                case 3: $receiver_id = $inputs['gem_heater_id']; break;
                case 4: $receiver_id = $inputs['gem_cutter_id']; break;
                case 5: $receiver_id = $inputs['gem_polishing_id']; break;
                case 6: $receiver_id = $inputs['gem_cutter_id']; break;
                case 7: $receiver_id = $inputs['gem_lab_id']; break;
            }
            $data['gmi_tbl'] = array(
                                    'id' => $gmi_id,
                                    'gem_issue_no' => $gmi_no, 
                                    'from_location_id' => $inputs['location_id'], 
                                    'gem_issue_type_id' => $inputs['gem_issue_type_id'], 
                                    'receiver_id' => $receiver_id, 
                                    'issue_date' => strtotime($inputs['issue_date']),  
                                    'return_date' => strtotime($inputs['return_date']),  
                                    'memo' => $inputs['memo'],  
                                    'status' => $inputs['status'],
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            
            $data['gmi_records'] = array(); 
            
            foreach ($inputs['inv_items_btm'] as $gmi_item_id => $gmi_rec){
                $data['gmi_records'][] = array(
                                            'gem_issue_id' => $gmi_id,
                                            'item_id' => $gmi_rec['item_id'],
                                            'item_category_id' => $gmi_rec['category_id'],
                                            'certification' => $gmi_rec['certification'],
                                            'record_type' => 10, //gem issuing 10
                                            'certification_no' => $gmi_rec['certification_no'],
                                            'color' => $gmi_rec['color_dd_id'],
                                            'treatment' => $gmi_rec['treatment'],
                                            'shape' => $gmi_rec['shape_dd_id'],
                                            'origin' => $gmi_rec['origin'],
                                            'length' => $gmi_rec['length'],
                                            'width' => $gmi_rec['width'],
                                            'height' => $gmi_rec['height'],
                                            'units' => $gmi_rec['item_quantity'],
                                            'uom_id' => $gmi_rec['uom_id'],
                                            'units_2' => $gmi_rec['item_quantity_2'],
                                            'uom_id_2' => $gmi_rec['uom_id_2'],
                                            'status' => 1,
                                            'deleted' => 0,
                                        ); 
                
                //stock data update
                $data['item_stock_transection'][] = array(
                                                            'transection_type'=>60, //40 for Consignee Submission
                                                            'trans_ref'=>$gmi_id, 
                                                            'item_id'=>$gmi_rec['item_id'], 
                                                            'units'=>$gmi_rec['item_quantity'], 
                                                            'uom_id'=>$gmi_rec['uom_id'], 
                                                            'units_2'=>$gmi_rec['item_quantity_2'], 
                                                            'uom_id_2'=>$gmi_rec['uom_id_2'], 
                                                            'location_id'=>$inputs['location_id'], 
                                                            'status'=>1, 
                                                            'added_on' => date('Y-m-d'),
                                                            'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                            );
                
                if($gmi_rec['uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($gmi_rec['item_id'],$inputs['location_id'],$gmi_rec['uom_id'],$gmi_rec['item_quantity'],$gmi_rec['uom_id_2'],$gmi_rec['item_quantity_2'],'-');
                else
                    $item_stock_data = $this->stock_status_check($gmi_rec['item_id'],$inputs['location_id'],$gmi_rec['uom_id'],$gmi_rec['item_quantity'],'','','-');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
                

                
            }
                    
//            echo '<pre>';            print_r($data); die;
		$add_stat = $this->Gems_issue_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Gems_issue_model->get_single_row($add_stat[1]);
                    add_system_log(GEM_ISSUES, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    if($inputs['no_menu']==1){
                        redirect(base_url($this->router->fetch_class().'/view/'.$gmi_id)); 
                    }else{
                        redirect(base_url($this->router->fetch_class().'/view/'.$gmi_id)); 
                    }
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0,$calc='-'){ //updatiuon for item_stock table
            $this->load->model('Item_stock_model');
            $stock_det = $this->Item_stock_model->get_single_row('',"location_id = '$loc_id' and item_id = '$item_id'");
            $available_units= $available_units_2 = $wshop_units = $wshop_units_2 = 0;
            $update_arr = array();
            if(empty($stock_det)){
                $insert_data = array(
                                        'location_id'=>$loc_id,
                                        'item_id'=>$item_id,
                                        'uom_id'=>$uom,
                                        'units_available'=>0,
                                        'units_on_order'=>0,
                                        'units_on_demand'=>0,
                                        );
                if($uom_2!=''){
                    $insert_data['units_available_2'] = 0;
                    $insert_data['uom_id_2'] = $uom_2;
                }
                $this->Item_stock_model->add_db($insert_data);
                $available_units = $units;
                $available_units_2 = $units_2;
            }else{
                if($calc=='+'){
                    $available_units = $stock_det['units_available'] + $units;
                    $available_units_2 = $stock_det['units_available_2'] + $units_2;
                    
                    $wshop_units = $stock_det['units_on_workshop'] - $units;
                    $wshop_units_2 = $stock_det['units_on_workshop_2'] - $units_2;
                }else{
                    $available_units = $stock_det['units_available'] - $units;
                    $available_units_2 = $stock_det['units_available_2'] - $units_2;
                    
                    $wshop_units = $stock_det['units_on_workshop'] + $units;
                    $wshop_units_2 = $stock_det['units_on_workshop_2'] + $units_2;
                }
            }
                $input = $this->input->post();
                $update_arr = array(
                                'location_id'=>$loc_id,
                                'item_id'=>$item_id,
                                'new_units_available'=>$available_units,
                                'new_units_available_2'=>$available_units_2,
                                'workshop_stats' => (isset($input['gem_issue_type_id']))?$input['gem_issue_type_id']:0,
                                'units_on_workshop' => $wshop_units,
                                'units_on_workshop_2' => $wshop_units_2,
                        );
                
            return $update_arr;
        }
        
        
	function update(){ 
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs); die; 
            $cs_id = $inputs['id'];  
            $data['so_sub_tbl'] = array(
                                    'memo' => $inputs['memo'],  
                                    'submission_date' => strtotime($inputs['submission_date']),  
                                    'return_date' => strtotime($inputs['return_date']),  
                                    'updated_on' => date('Y-m-d'),
                                    'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
            $data['so_desc'] = array();
            if(!empty($inputs['so_desc_ids'])){
                foreach ($inputs['so_desc_ids'] as $so_desc_id){
                    $data['so_desc'][] = array(
                                            'craftman_status' => 1,//submitted to craftman
                                            'so_craftman_submission_id' => $cs_id, 
                                            'so_desc_id' => $so_desc_id, 
                                        ); 
                
                 }
            }
            //old data for log update
            $existing_data = $this->get_gem_issue_info($cs_id);

            $edit_stat = $this->Gems_issue_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Gems_issue_model->get_single_row($inputs['id']);
                add_system_log(VEHICLE_RATES, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        
        function remove(){
            $inputs = $this->input->post();  
            
            $this->load->model('Item_stock_model');
            $stock_trans = $this->Item_stock_model->get_stock_transection($inputs['id'],'transection_type=60');//60 for gem issue
            
            foreach($stock_trans as $stock_tx){
                 if($stock_tx['uom_id_2']!=0)
                    $item_stock_data = $this->stock_status_check($stock_tx['item_id'],$stock_tx['location_id'],$stock_tx['uom_id'],$stock_tx['units'],$stock_tx['uom_id_2'],$stock_tx['units_2'],'+');
                else
                    $item_stock_data = $this->stock_status_check($stock_tx['item_id'],$stock_tx['location_id'],$stock_tx['uom_id'],$stock_tx['units'],'','','+');
                
                if(!empty($item_stock_data)){
                    $data['item_stock'][] = $item_stock_data;
                }
            }
            
            $data['del_arr'] = array(
                            'deleted' => 1,
                            'deleted_on' => date('Y-m-d'),
                            'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                         ); 
            
            $existing_data = $this->get_gem_issue_info($inputs['id']);  
            $delete_stat = $this->Gems_issue_model->delete_db($inputs['id'],$data);
                    
            if($delete_stat){
                //update log data
                add_system_log(CRAFTMANS_SUBMISSION, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url($this->router->fetch_class()));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            }  
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Gems_issue_model->get_single_row($inputs['id']);
            if($this->Gems_issue_model->delete2_db($id)){
                //update log data
                add_system_log(HOTELS, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
        function load_data($id=''){
            if($id!=''){
                $data['row_data'] = $this->Gems_issue_model->get_single_row($id); 
                $data['rows_desc'] = $this->Gems_issue_model->get_gem_issue_desc($id); 
                if(empty($data['row_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            $data['gem_issue_type_list'] = get_dropdown_data(GEM_ISSUE_TYPES,'gem_issue_type_name','id','No Gem Issue Type');
            $data['lab_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 4'); //4 Labs / Certf
            $data['cutter_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 19'); //19 Gem Cutter
            $data['polishing_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 20'); //20 Polishing
            $data['heater_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 21'); //21 Heater
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_code','id',''); 
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Category');
            $data['currency_list'] = get_dropdown_data(CURRENCY,'code','code','Currency');
            $data['supplier_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id','No Supplier');

            return $data;
	}	
        function get_gem_issue_info($id){
            
                $data['row_data'] = $this->Gems_issue_model->get_single_row($id); 
                $data['rows_desc'] = $this->Gems_issue_model->get_gem_issue_desc($id); 
                return $data;
        }
                
        function search(){ 
            $input = $this->input->post();
            $search_data=array( 
                                'gem_issue_no' => $input['gem_issue_no'],
                                'gem_issue_type_id' => $input['gem_issue_type_id'],
                                'cutter_id' => $input['cutter_id'],  
                                'pollishing_id' => $input['pollishing_id'],  
                                'lab_id' => $input['lab_id'],  
                                'item_code' => $input['item_code'],  
                                'heater_id' => $input['heater_id'],  
                                'location_id' => $input['location_id'],  
                                'submitted_date' => (isset($input['submitted_date']))? strtotime($input['submitted_date']):'',  
                                'return_date' => (isset($input['return_date']))?strtotime($input['return_date']):'',   
                                ); 
            $so_subms['search_list'] = $this->Gems_issue_model->search_result($search_data);
            
//		$data_view['search_list'] = $this->Gems_issue_model->search_result();
            $this->load->view('gem_issue/search_gem_issue_result',$so_subms);
	}
        
        function get_single_item(){
            $inputs = $this->input->post(); 
//            echo '<pre>';            print_r($inputs); die;
            $data = $this->Gems_issue_model->get_single_item($inputs['item_code'],$inputs['supplier_id']); 
            echo json_encode($data);
        }
        function test(){
//            echo '<pre>';            print_r($this->router->class); die;
            
//            $this->load->view('invoices/sales_invoices');
            $data = $this->Gems_issue_model->get_single_item(1002,15);
            echo '<pre>' ; print_r($data);die;
//            log_message('error', 'Some variable did not contain a value.');
        }
        function gem_issue_print($id){ 
//            $this->input->post() = 'aa';
            $gi_data = $this->load_data($id);  
            $gi_info = $gi_data['row_data'];
            $rows_desc = $gi_data['rows_desc'];
//            echo '<pre>';            print_r($gi_data); die;  
            
            $this->load->library('Pdf'); 
            $this->load->model('Items_model');
             
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->fl_header='header_jewel';//invice bg
            $pdf->fl_header_title='Note';//invice bg
            $pdf->fl_header_title_RTOP='Gem Issue Note';//invice bg
            
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Fahry Lafir');
            $pdf->SetTitle('PDF AM Invoice');
            $pdf->SetSubject('FL Invoice');
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
            $fontname = TCPDF_FONTS::addTTFfont('storage/fonts/Lato-Regular.ttf', 'TrueTypeUnicode', '', 96);
            $pdf->SetFont($fontname, 'I', 9);
        
        
            $pdf->AddPage();   
            $pdf->SetTextColor(32,32,32);     
            
//            echo '<pre>';            print_r($submission_data); die; 
            $html = '<table border="0">
                        <tr>
                            <td><b>Report: Gem Issue Note </b></td>
                            <td align="center"></td>
                            <td align="right">Issue No: '.$gi_info['gem_issue_no'].'</td>
                        </tr> 
                        <tr>
                            <td>Issue Type: '.$gi_info['gem_issue_type_name'].'</td>
                            <td align="center">Submitted Date : '.date(SYS_DATE_FORMAT,$gi_info['issue_date']).'</td>
                            <td align="RIGHT">Printed by : '.$this->session->userdata(SYSTEM_CODE)['user_first_name'].' '.$this->session->userdata(SYSTEM_CODE)['user_last_name'].'</td>
                        </tr> 
                        <tr>
                            <td>Lapidarist: '.$gi_info['lapidarist_name'].'</td>
                            <td align="center">Return Date : '.date(SYS_DATE_FORMAT,$gi_info['return_date']).'</td>
                            <td align="right">Printed on : '.date(SYS_DATE_FORMAT).'</td>
                        </tr> 
                        <tr><td style="line-height:30px;" colspan="3"></td></tr>
                    </table> ';
            $i=1; 
            
            $html .='
                        <table id="example1" class="table-line" border="0">
                            <thead> 
                                <tr style=""> 
                                    <th width="3%" style="text-align: left;"><u><b>#</b></u></th>  
                                    <th width="10%" style="text-align: left;"><u><b>Variety</b></u></th>  
                                    <th width="20%" style="text-align: left;"><u><b>Item Desc</b></u></th>  
                                    <th width="12%" style="text-align: left;"><u><b>Code</b></u></th> 
                                    <th width="10%" style="text-align: left;" ><u><b>Color</b></u></th>  
                                    <th width="10%" style="text-align: left;" ><u><b>Shape</b></u></th>  
                                    <th width="18%" style="text-align: center;"><u><b>Measurement</b></u></th> 
                                    <th width="17%" style="text-align: center;"><u><b>Weight</b></u></th> 
                                 </tr>
                            </thead>
                        <tbody>';
//            echo '<pre>';            print_r($rows_desc); die;
            if(isset($rows_desc) && count($rows_desc)>0){
                $i=1;
                $tot_units = $tot_units_2 = 0; 
                foreach ($rows_desc as $row){
                    $tot_units += $row['units'];
                    $tot_units_2 += $row['units_2'];
                    
                    $measurement = (($row['length']>0)?$row['length']:'-').' x '.(($row['width']>0)?$row['width']:'-').' x '.(($row['width']>0)?$row['width']:'-').' mm';
                    $units = $row['units'].' '.$row['unit_abbr'].(($row['uom_id_2']>0)?' | '.$row['units_2'].' '.$row['unit_abbr_2']:'');

                    $html .= '<tr>
                                <td width="3%" style="text-align: left;">'.$i.'</td> 
                                <td width="10%" style="text-align: left;">'.$row['category_name'].'</td>  
                                <td width="20%" style="text-align: left;">'.$row['item_name'].'</td>  
                                <td width="12%" style="text-align: left;">'.$row['item_code'].'</td>  
                                <td width="10%" style="text-align: left;">'.$row['color_val'].'</td>  
                                <td width="10%" style="text-align: left;">'.$row['shape_val'].'</td>  
                                <td width="18%" style="text-align: center;">'.$measurement.'</td> 
                                <td width="17%" style="text-align: right;"> '.$units.'</td> 
                            </tr> ';
                    $i++;
                } 
            }
            $html .=    '<tr>
                            <td colspan="6"  style="text-align: left;"></td>   
                            <td width="18%" style="text-align: right;"><b>Total:</b></td> 
                            <td width="17%" style="text-align: right;"> <b>'.$tot_units.' '.$row['unit_abbr'].(($row['uom_id_2']>0)?' | '.$tot_units_2.' '.$row['unit_abbr_2']:'').'</b></td> 
                        </tr> '; 
            
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
            $pdf->Output('Issue_note_'.$gi_info['gem_issue_no'].'.pdf', 'I');
                
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
        function get_search_res_available_items(){
            $inputs = $this->input->post();
//            echo '<pre>';            print_r($inputs['res_count_check']); die;  
            $search_data = array(
                                    'item_code' => $inputs['item_code'],
                                    'category_id' => $inputs['category_id'],
                                    'weight_from' => $inputs['weight_from'],
                                    'weight_to' => $inputs['weight_to'],
                                    'supplier_id' => $inputs['supplier_id'], 
                                );  
            $limit = '';
            if(isset($inputs['res_count_check']))
                $limit = ($inputs['result_count']>0)?$inputs['result_count']:25;
            
            $result = $this->Gems_issue_model->search_available_items($search_data,'',$limit); 
//            echo '<pre>';            print_r($result); die;  
//            echo '<pre>';            print_r($result_available); die; 
            echo json_encode($result);
        }
        function pos_sales_ret_print_direct(){ 
            $inputs = $this->input->post();
            $invoice_data = $this->get_gem_issue_info('',$inputs['cn_no']);
            $this->load->helper('print_helper');
            fl_direct_print_return($invoice_data);
            
        }
}
