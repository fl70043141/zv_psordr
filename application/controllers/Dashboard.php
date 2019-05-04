<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
         function __construct() {
            parent::__construct();
            $this->load->model('Dashboard_model'); 
        }

	public function index(){ 
            
            $data                 = $this->getData(); 
            $data['barchart']     = $this->get_barchart_data(); 
            $data['donut']     = $this->get_donut_data(); 
            $data['main_content'] = 'dashboard/index'; 
            $this->load->view('includes/template',$data);
	}
        function getData(){
            $item_pnl_data = $this->Dashboard_model->get_sales_profit(); //PNL CALCULATIION
            
            $pnl_amount = 0; 
            $cur_left_synbol = $cur_right_synbol ='';
            if(!empty($item_pnl_data)){
                foreach ($item_pnl_data as $pnl_info){
                    $pnl_amount += $pnl_info['item_sale_amount'] - ($pnl_info['purch_standard_cost']-$pnl_info['total_lapidary_cost']);
                    $cur_left_synbol = $pnl_info['cur_left_symbol'];
                    $cur_right_synbol = $pnl_info['cur_right_symbol'];
    //                echo '<br>code_id: '.$pnl_info['item_id'].'  /  SALE_AMOUNT: '.$pnl_info['item_sale_amount'],'  / PYRCH: '.$pnl_info['purch_standard_cost'];
                }
            }
//            echo '<pre>';            print_r($item_pnl_data); die;
            
            $available = $this->Dashboard_model->get_available_items('','',1);
            $tot_weight = $total_pcs = 0;
//            $tot_weight = $total_pcs = 0;
            foreach ($available as $item){
                $tot_weight += $item['sum_unit_1'];
                $total_pcs += $item['sum_unit_2'];
            }
            $tot_count = $tot_weight.' cts | '.$total_pcs.' pcs';
            $data['total_1']= array(
                                                'label' =>'Sales Invoices',
                                                'count' => $this->Dashboard_model->get_tbl_couts(INVOICES),
                                                );
            $data['total_2']= array(
                                            'label' =>'Purchase Invoices',
                                            'count' => $this->Dashboard_model->get_tbl_couts(SUPPLIER_INVOICE),
                                            );
            $data['total_3']= array(
                                            'count' =>count($available),
                                            'label' => "ITEMS ",
                                            );
            $data['total_4']= array(
                                        'label' =>'Categories',
                                        'count' => $this->Dashboard_model->get_tbl_couts(ITEM_CAT),
                                        );
            $data['total_5']= array(
                                        'label' =>(($pnl_amount>0)?'PROFIT ':'LOST ').' FROM SALES',
                                        'count' => $cur_left_synbol.' '.number_format(abs($pnl_amount),2).' '.$cur_right_synbol,
                                        'color' => (($pnl_amount>0)?'bg-lime-active ':'bg-red ')
                                        );
            
            $data['total_6']= array(
                                        'label' =>'Orders',
                                        'count' => $this->Dashboard_model->get_tbl_couts(SALES_ORDERS),
                                        );
            return $data;
        }
        
        function get_barchart_data(){
            $data_bc = array();
            for ($i = 0; $i < 7; $i++) {
                $date_start = date('Y-m-1', strtotime("-$i month"));
                $date_end = date('Y-m-t', strtotime("-$i month"));
                
                $data_bc[$i]['month']= date('M',strtotime("-$i month"));
                $data_bc[$i]['res']=$this->Dashboard_model->get_number_inv(SUPPLIER_INVOICE,$date_start,$date_end);
                $data_bc[$i]['inv']=$this->Dashboard_model->get_number_inv(INVOICES,$date_start,$date_end);
            }
            
//            echo '<pre>';            print_r($data_bc);die;
            return $data_bc;
        }
        
        function get_donut_data1(){
            $data_donut = array();
                
                $data_donut['sales']=$this->Dashboard_model->get_number_inv(SALES_ORDERS);
                $data_donut['purch']=$this->Dashboard_model->get_number_inv(INVOICES);
                $data_donut['expenses']=$this->Dashboard_model->get_number_inv(SALES_ORDERS,'','',' invoiced=0');
            
//            echo '<pre>';            print_r($data_donut);die;
            return $data_donut;
        }
        function get_donut_data(){
            $data_donut = array();
            
                $percentage_tot = $sale_percentage = $purch_percentage = $expenses_percentage= 0;
                
                $sales_info = $this->get_sales_info(1);
                $purch_info = $this->get_purch_info(1);
                $expenses_info = $this->get_expenses_info(1);
                
                if(!empty($sales_info) && isset($sales_info['total'])){
                    $sale_percentage =$sales_info['total']; 
                    $percentage_tot +=$sales_info['total']; 
                }
                if(!empty($purch_info) && isset($purch_info['total'])){
                    $purch_percentage =$purch_info['total']; 
                    $percentage_tot +=$purch_info['total']; 
                }
                if(!empty($expenses_info) && isset($expenses_info['total'])){
                    $expense_percentage =$expenses_info['total']; 
                    $percentage_tot +=$expenses_info['total']; 
                }
                
                $data_donut['sales']= ($percentage_tot>0)? number_format(($sale_percentage/$percentage_tot)*100):0;
                $data_donut['purch']= ($percentage_tot>0)? number_format(($purch_percentage/$percentage_tot)*100):0;
                $data_donut['expenses']= ($percentage_tot>0)? number_format(($expense_percentage/$percentage_tot)*100):0;
//                $data_donut['expenses']=0;
                 
//            echo '<pre>';            print_r($data_donut);die;
            return $data_donut;
        }

        public function test(){
            $this->load->model('Dashboard_model');
            echo '<pre>';            print_r($this->getData()); die;

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
        function get_temp_salesorder_user(){ //for Top header data
           
            $this->load->model('Sales_order_items_model');
            $res = $this->Sales_order_items_model->get_temp_so_item_user();
//            echo '<pre>';            print_r($res); die;
            $html_str = '';
            if(count($res)>0){
                $html_str .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell-o"></i>
                            <span id="count_temp_so_list" class="label label-warning">'.count($res).'</span>
                          </a>
                          <ul class="dropdown-menu">
                            <li class="header">Pending Temp Items</li>';
                            
                foreach ($res as $res1){
                    $html_str .= '<li>
                                    <!-- inner menu: contains the actual data -->
                                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                       <li>
                                        <a href="#">
                                          <i class="fa fa-edit text-red"></i> '.$res1['temp_order_no'].' '.count(json_decode($res1['value'])).' Items in list
                                        </a>
                                      </li>';
                }
                $html_str .= '</ul><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                            </li> 
                          </ul>';
                echo $html_str;
            }
        }
        function get_temp_sales_invoice_user(){ //for Top header data
           
            $this->load->model('Sales_pos_model');
            $res = $this->Sales_pos_model->get_temp_invoice_paused($this->session->userdata(SYSTEM_CODE)['ID']);
//            echo '<pre>';            print_r($res); die;
            if(!empty($res)){
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-file"></i>
                            <span id="count_temp_invoice_list" class="label label-warning">'.count($res).'</span>
                          </a>
                          <ul class="dropdown-menu">
                            <li class="header togg_down">Pending Temp Invoices</li>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                            ';
                foreach ($res as $res1){
                    $items_count = count(json_decode($res1['item_data'],true));
                    echo' 
                          <li><a class="invtmp" id="invtemp_'.$res1['id'].'" href="#" style="color:black;">'.$res1['temp_invoice_no'].' <span class="pull-right badge bg-blue">'.$items_count.' items</span></a></li> 
                        ';
                }
                echo ' </ul>
                      </div> ';
            }
        }
        
        function get_sales_info($return=false){
             $fiscyear_info = get_single_row_helper(GL_FISCAL_YEARS,'id = '.$this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id']);
             $data = array(
                                'from_date' => ($fiscyear_info['begin']>0)?$fiscyear_info['begin']:'',
                                'to_date' => ($fiscyear_info['end']>0)?$fiscyear_info['end']:'', 
                            );
              
              $sales_info = $this->Dashboard_model->get_sales_amount($data);
              $sales_data = array();
              $tot_sales = 0;
                foreach ($sales_info as $sale){
                    $sales_data[$sale['id']] = $sale;
                    $tot_sales += $sale['inv_subtot'];
                    $sales_data['symbol_left'] = $sale['cur_left_symbol'];
                    $sales_data['symbol_right'] = $sale['cur_right_symbol'];
                }
                $sales_data['total'] = $tot_sales;
                
                if($return==1){
                    return $sales_data;
                }else{
                    echo json_encode($sales_data);
                }
        }
        
        function get_purch_info($return=false){
             $fiscyear_info = get_single_row_helper(GL_FISCAL_YEARS,'id = '.$this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id']);
             $data = array(
                                'from_date' => ($fiscyear_info['begin']>0)?$fiscyear_info['begin']:'',
                                'to_date' => ($fiscyear_info['end']>0)?$fiscyear_info['end']:'', 
                            );
              
              $purch_info = $this->Dashboard_model->get_purch_amount($data);
              $purch_data = array();
              $tot_purch = 0;
                foreach ($purch_info as $purch){
                    $purch_data[$purch['id']] = $purch;
                    $tot_purch += $purch['inv_subtot'];
                    $purch_data['symbol_left'] = $purch['cur_left_symbol'];
                    $purch_data['symbol_right'] = $purch['cur_right_symbol'];
                }
                $purch_data['total'] = $tot_purch;
                
                 if($return==1){
                    return $purch_data;
                }else{
                    echo json_encode($purch_data);
                }
        }
        
        function get_expenses_info($return=false){
             $fiscyear_info = get_single_row_helper(GL_FISCAL_YEARS,'id = '.$this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id']);
             $data = array(
                                'from_date' => ($fiscyear_info['begin']>0)?$fiscyear_info['begin']:'',
                                'to_date' => ($fiscyear_info['end']>0)?$fiscyear_info['end']:'', 
                            );
              
              $expense_info = $this->Dashboard_model->get_expenses_amount($data);
              $expense_data = array();
              $tot_expense = 0;
                foreach ($expense_info as $expense){
                    $expense_data[$expense['id']] = $expense;
                    $tot_expense += $expense['expense_amount'];
                    $expense_data['symbol_left'] = $expense['cur_left_symbol'];
                    $expense_data['symbol_right'] = $expense['cur_right_symbol'];
                }
                $expense_data['total'] = $tot_expense;
                
                 if($return==1){
                    return $expense_data;
                }else{
                    echo json_encode($expense_data);
                }
        }
//        function get_sales_info(){
//             $fiscyear_info = get_single_row_helper(GL_FISCAL_YEARS,'id = '.$this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id']);
//             $data = array(
//                                'from_date' => ($fiscyear_info['begin']>0)?$fiscyear_info['begin']:'',
//                                'to_date' => ($fiscyear_info['end']>0)?$fiscyear_info['end']:'', 
//                            );
//              
//              $ledger_info = $this->Dashboard_model->get_ledger_info($data);
//              $ledger_data = array();
//                foreach ($ledger_info as $ledger){
//                    $ledger_data[$ledger['glcm_code']] = $ledger;
//                }
//                
//                echo json_encode($ledger_data);
//        }
        
        
}
