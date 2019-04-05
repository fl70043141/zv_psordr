<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_csv extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Items_CSV_model');
        }


        public function index()
	{
            $this->view_form_csv();
	}
        
        function view_form_csv($datas=''){
//            $data = $this->load_data();
//            $data['log_list'] = $this->Audit_trial_model->search_result();
		$data['action']		= 'Add';
            $data['main_content']='upload_csv'; 
            $this->load->view('includes/template',$data);
	}
                                        
	 
        function validate(){
//            echo 'INITIAL SETUPS FOR CSV UPLOAD<br> 01. REQUIRED TO SET SUPPLIER ID <br>02. REQUIRED TO SET LOCATION ID';die;
            $file = $_FILES["file"]["tmp_name"];
            $file_open = fopen($file, "r");

            $data_arr = array(); 
            $supplier_id = 1;
            $location_id = 1;

            $supplier_inv_id = get_autoincrement_no(SUPPLIER_INVOICE);
            $supplier_invoice_no = gen_id(SUP_INVOICE_NO_PREFIX, SUPPLIER_INVOICE, 'id');
             
            $this->load->model('Purchasing_items_model');
            $cur_det = $this->Purchasing_items_model->get_currency_for_code($this->session->userdata(SYSTEM_CODE)['default_currency']);
            
            $sdata['supp_inv_tbl'] = array(
                                    'id' => $supplier_inv_id,
                                    'supplier_invoice_no' => $supplier_invoice_no,
                                    'supplier_id' => $supplier_id,
                                    'reference' => 'UPLOAD CSV',
                                    'invoice_date' => strtotime("now"),
                                    'invoiced' => 1,
                                    'payment_term_id' => 2,
                                    'currency_code' =>$cur_det['code'],
                                    'currency_value' =>$cur_det['value'],
                                    'location_id' => $location_id,  
                                    'status' => 1,  
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                ); 
            $insert_stat = $this->Items_CSV_model->add_db_purch_invoice($sdata);
//            $insert_stat = true;
            
            $i=0;
//            if(true){
            if($insert_stat){
                $total=0;
                while (($csv = fgetcsv($file_open, 1000, ",")) !== false && $csv[0]!='') {
                        if($i!=0){
                            $item_code = $csv[0];
                            $item_desc = $csv[1];
                            $cat_id = $csv[2];
                            $sales_price = $csv[3];
                            $purch_price = $csv[4];
                            $supplier_id= $csv[5];
                            $qty= $csv[6];
                            $uom_id= $csv[7];
                            $qty_2= $csv[8];
                            $uom_id_2= $csv[9];
                            $sales_excluded= $csv[11];
                            $purchase_exclude= $csv[12];
                            
//                            $purch_price = $purch_price/$qty;
                            
                            //GEMS 
                            $color = $csv[13];
                            $certfication = $csv[14];
                            $cert_no = $csv[15];
                            $origin = $csv[16];
                            $treatment = $csv[17];
                            $shape = $csv[18];

                            $item_id = get_autoincrement_no(ITEMS); 
                //            $item_code = gen_id('1', ITEMS, 'id',4);
                            $inputs['status'] = (isset($inputs['status']))?1:0;
                            $sales_excluded = (isset($sales_excluded) && $sales_excluded!='')?1:0;
                            $purchase_exclude = (isset($purchase_exclude) && $purchase_exclude!='')?1:0;

                            //create Dir if not exists for store necessary images   
                            if(!is_dir(ITEM_IMAGES.$item_id.'/')) mkdir(ITEM_IMAGES.$item_id.'/', 0777, TRUE); 
                            if(!is_dir(ITEM_IMAGES.$item_id.'/other/')) mkdir(ITEM_IMAGES.$item_id.'/other/', 0777, TRUE);

//                            $dir_path = "E:/xampp_zv/htdocs/nveloop_gems/storage/images/categories/".$cat_id;
                            $dir_path = "E:/My Study/Project11/PROJECTS NVELOOP/NVELOOP/JWL_POS/CSV_UPLOAD/product_list/".$item_code;
                            $file_in = $all_images = array();
                            if(is_dir($dir_path))
                                $file_in = scandir($dir_path,1);

                            $first_img = '';
                            foreach ($file_in as $key => $img){
        //                        echo $key; die;
                                if($key==0 & $img!='.' & $img!='..'){
                                    $first_img = $img; 
                                    copy($dir_path.'/'.$img, ITEM_IMAGES.$item_id.'/'.$img);
                                }
                                if($img!='1.jpg' & $img!='.' & $img!='..'){
                                    copy($dir_path.'/'.$img, ITEM_IMAGES.$item_id.'/other/'.$img);
                                    $all_images[]=$img;
                                }
                            }
        //                        echo '<pre>';        print_r($all_images); die;

                            $data['item'] = array(
                                                    'id' => $item_id,
                                                    'item_code' => $item_code,
                                                    'item_name' => $item_desc,
                                                    'item_uom_id' => $uom_id,
                                                    'item_uom_id_2' => $uom_id_2,
                                                    'item_category_id' => $cat_id,
                                                    'item_type_id' => 1,
                                                    'description' => '',
                                                    'addon_type_id' => 0,
                                                    'sales_excluded' => $sales_excluded,
                                                    'purchases_excluded' => $purchase_exclude,
                                                    'image' => $first_img,
                                                    'images' => (isset($all_images))?json_encode($all_images):'',
                                                    'status' => 1, 
                                                    'added_on' => date('Y-m-d'),
                                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                );
                            
                            if($color!='' && isset($color)){$data['item']['color'] = $color;}
                            if($certfication!='' && isset($certfication)){$data['item']['certification'] = $certfication;}
                            if($cert_no!='' && isset($cert_no)){$data['item']['certification_no'] = $cert_no;}
                            if($treatment!='' && isset($treatment)){$data['item']['treatment'] = $treatment;}
                            if($shape!='' && isset($shape)){$data['item']['shape'] = $shape;}
                            if($origin!='' && isset($origin)){$data['item']['origin'] = $origin;}
                            

                                $supplier_inv_desc_id = get_autoincrement_no(SUPPLIER_INVOICE_DESC);
                                $data['supplier_inv_desc'] = array(
                                                            'id' => $supplier_inv_desc_id,
                                                            'item_id' => $item_id,
                                                            'supplier_invoice_id' => $supplier_inv_id,
                                                            'supplier_item_desc' => $item_desc,
                                                            'purchasing_unit' => $qty,
                                                            'purchasing_unit_uom_id' => $uom_id,
                                                            'secondary_unit_uom_id' => $uom_id_2,
                                                            'secondary_unit' => $qty_2,
                                                            'location_id' => $location_id,
                                                            'purchasing_unit_price' => $purch_price,
                                                            'status' => 1,   
                                                        );

                                  $data['item_stock_transection'] = array(
                                                                    'transection_type'=>1, //1 for purchsing transection
                                                                    'trans_ref'=>$supplier_inv_id, 
                                                                    'item_id'=>$item_id, 
                                                                    'units'=>$qty, 
                                                                    'uom_id'=>$uom_id, 
                                                                    'units_2'=>$qty_2, 
                                                                    'uom_id_2'=>$uom_id_2, 
                                                                    'location_id'=>$location_id, 
                                                                    'status'=>1, 
                                                                    'added_on' => date('Y-m-d'),
                                                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                                                    );

                                if($uom_id_2!=0)
                                    $item_stock_data = $this->stock_status_check($item_id,$location_id,$uom_id,$qty,$uom_id_2,$qty_2);
                                else
                                    $item_stock_data = $this->stock_status_check($item_id,$location_id,$uom_id,$qty);

                                if(!empty($item_stock_data)){
                                    $data['item_stock'] = $item_stock_data;
                                }

                                $data['prices'][0] = array(
                                                                'item_id' => $item_id,
                                                                'item_price_type' => 1, //2 Purch price
                                                                'price_amount' =>$purch_price,
                                                                'currency_code' =>$cur_det['code'],
                                                                'currency_value' =>$cur_det['value'],
                                                                'sales_type_id' =>0,
                                                                'supplier_id' =>$supplier_id,
                                                                'supplier_unit_conversation' =>1,
                                                                'status' =>1,
                                                                ); 
                                $data['prices'][1] = array(
                                                                'item_id' => $item_id,
                                                                'item_price_type' => 2, //2 sales price
                                                                'price_amount' =>$sales_price,
                                                                'currency_code' =>$cur_det['code'],
                                                                'currency_value' =>$cur_det['value'],
                                                                'sales_type_id' =>15,//drop_down for retail sale
                                                                'supplier_id' =>0,
                                                                'supplier_unit_conversation' =>0,
                                                                'status' =>1,
                                                                ); 
                                $data['prices'][2] = array( //standard price
                                                                'item_id' => $item_id,
                                                                'item_price_type' => 3, //2 sales price
                                                                'price_amount' =>$purch_price,
                                                                'currency_code' =>$cur_det['code'],
                                                                'currency_value' =>$cur_det['value'],
                                                                'sales_type_id' =>0,//drop_down for retail sale
                                                                'supplier_id' =>0,
                                                                'supplier_unit_conversation' =>0,
                                                                'status' =>1,
                                                                ); 

                                
                                $total += $purch_price*$qty;
        //                        echo '<pre>';        print_r($data); die;
                //            if(!empty($def_image)) $data['image'] = $def_image[0]['name'];
        //                                            echo '<pre>';                                print_r($data); die;

                            $add_stat = $this->Items_CSV_model->add_db_item($data); 
                            if($add_stat[0]){
                                echo $csv[0].' Added Successfully <br>';
                            }else{
                                echo ' <p style="color:red"> '.$csv[0].' - Error</p><br>';
                            }
                    }
                    $i++;
                }
                
            //GL TRANSECTIONS
            $data_1['gl_trans'] = array(array(
                                        'person_type' => 20,
                                        'person_id' => $supplier_id,
                                        'trans_ref' => $supplier_inv_id,
                                        'trans_date' => strtotime("now"),
                                        'account' => 5, //5 inventory GL
                                        'account_code' => 1510, //5 inventory GL
                                        'memo' => '',
                                        'amount' => +($total),
                                        'currency_code' =>$cur_det['code'],
                                        'currency_value' =>$cur_det['value'],
                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                        'status' => 1,
                                ),array(
                                        'person_type' => 20,
                                        'person_id' => $supplier_id,
                                        'trans_ref' => $supplier_inv_id,
                                        'trans_date' => strtotime("now"),
                                        'account' => 14, //14 AC Payable GL
                                        'account_code' => 2100, //inventory GL
                                        'memo' => '',
                                        'amount' => (-$total),
                                        'currency_code' =>$cur_det['code'],
                                        'currency_value' =>$cur_det['value'],
                                        'fiscal_year'=> $this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id'],
                                        'status' => 1,
                                )
                            );
            
                            $add_stat = $this->Items_CSV_model->add_db_gl($data_1);
                            if($add_stat[0]){
                                echo '<br><br>...........................................<br> GL ENTRY UPDATED SUCCESFULLY<br>';
                            }else{
                                echo ' <p style="color:red"> GL ENTRY - Error</p><br>';
                            }
            }
        }
        
        
        function stock_status_check($item_id,$loc_id,$uom,$units=0,$uom_2='',$units_2=0){ //updatiuon for item_stock table
            $this->load->model('Item_stock_model');
            $stock_det = $this->Item_stock_model->get_single_row('',"location_id = '$loc_id' and item_id = '$item_id'");
            $available_units= $available_units_2 = 0;
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
                $available_units = $stock_det['units_available'] + $units;
                $available_units_2 = $stock_det['units_available_2'] + $units_2;
            }
                $update_arr = array('location_id'=>$loc_id,'item_id'=>$item_id,'new_units_available'=>$available_units,'new_units_available_2'=>$available_units_2);
            return $update_arr;
        }
}
