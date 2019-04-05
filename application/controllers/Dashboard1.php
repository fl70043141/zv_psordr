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
            
            $data['total_reservations']= array(
                                                'label' =>'Gemstones in Hand',
                                                'count' => $this->Dashboard_model->get_tbl_couts(ITEMS),
                                                );
            $data['total_invoices']= array(
                                            'label' =>'Invoices',
                                            'count' => $this->Dashboard_model->get_tbl_couts(INVOICES),
                                            );
            $data['total_vehicles']= array(
                                            'label' =>'Users',
                                            'count' => $this->Dashboard_model->get_tbl_couts(INVOICES),
                                            );
            $data['total_cust']= array(
                                        'label' =>'Customers',
                                        'count' => $this->Dashboard_model->get_tbl_couts(CUSTOMERS),
                                        );
            return $data;
        }
        
        function get_barchart_data(){
            $data_bc = array();
            for ($i = 0; $i < 7; $i++) {
                $date_start = date('Y-m-1', strtotime("-$i month"));
                $date_end = date('Y-m-t', strtotime("-$i month"));
                
                $data_bc[$i]['month']= date('M',strtotime("-$i month"));
                $data_bc[$i]['res']=$this->Dashboard_model->get_number_inv(INVOICES,$date_start,$date_end);
                $data_bc[$i]['inv']=$this->Dashboard_model->get_number_inv(INVOICES,$date_start,$date_end);
            }
            
//            echo '<pre>';            print_r($data_bc);die;
            return $data_bc;
        }
        
        function get_donut_data(){
            $data_donut = array();
                $data_donut['res']=$this->Dashboard_model->get_number_inv(INVOICES);
                $data_donut['inv']=$this->Dashboard_model->get_number_inv(INVOICES);
                $data_donut['itm']=$this->Dashboard_model->get_number_inv(ITEMS);
            
//            echo '<pre>';            print_r($data_donut);die;
            return $data_donut;
        }

        public function test(){
            $this->load->model('Dashboard_model');
            echo '<pre>';            print_r($this->getData()); die;

        }
        
}
