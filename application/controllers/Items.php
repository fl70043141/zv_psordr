<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('Items_model'); 
        }

        public function index(){
            $this->view_search();
	}
        
        function view_search($datas=''){
            $data['search_list'] = $this->Items_model->search_result('',50);
            $data['form_setup'] = $this->input->get();
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id','No Items Category'); 
            $data['main_content']='items/search_items';  
            $this->load->view('includes/template',$data);
	}
        
	function add(){ 
            $data = $this->load_data();
            $data['action']		= 'Add';
            $data['main_content']='items/add_item';  
            $this->load->view('includes/template',$data);
	}
	
	function edit($id){ 
            $data  			= $this->load_data($id);  
            $data['action']		= 'Edit';
            $data['main_content']='items/manage_items'; 
            $this->load->view('includes/template',$data);
	}
	
	function delete($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'Delete';
            $data['main_content']='items/manage_items'; 
            $this->load->view('includes/template',$data);
	}
	
	function view($id){ 
            $data  			= $this->load_data($id);
            $data['action']		= 'View';
            $data['main_content']='items/manage_items'; 
            $data['user_role_list'] = get_dropdown_data(USER_ROLE,'user_role','id');
            $this->load->view('includes/template',$data);
	}
	
        
	function validate(){  
            $this->form_val_setrules(); 
            if($this->form_validation->run() == False){
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

            $this->form_validation->set_error_delimiters('<p style="color:rgb(255, 115, 115);" class="help-block"><i class="glyphicon glyphicon-exclamation-sign"></i> ','</p>');

            $this->form_validation->set_rules('item_code','Item code','required|min_length[2]|callback_check_unique_itemcode');   
            $this->form_validation->set_rules('item_name','Item Name','required|min_length[2]');   
            $this->form_validation->set_rules('description','description','min_length[2]');   
            $this->form_validation->set_rules('stock_unit','Unit','numeric');   
            $this->form_validation->set_rules('stock_unit_2','Unit','numeric');   
            
            $sales_type_list = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
//            echo '<pre>';            print_r($sales_type_list);die;
            foreach ($sales_type_list as $key=>$sales_type_list){
                $this->form_validation->set_rules('prices[sales]['.$key.'][amount]','Price Amount','numeric');   
            }
      }	
       function check_unique_itemcode(){
          $res = array();
          if($this->input->post('id')!=''){
                $res =  get_dropdown_data(ITEMS,'item_name','id','','item_code = "'.$this->input->post('item_code').'" and id!= "'.$this->input->post('id').'" ');  
          } else {
                 $res =  get_dropdown_data(ITEMS,'item_name','id','','item_code = "'.$this->input->post('item_code').'" ');;    
          } 
                if(count($res)==0){
                    return true;
                }else{
                    $this->form_validation->set_message('check_unique_itemcode','Alrady exists,Should be unique');
                    return false;
                } 
        }
        
	function create(){  
            $inputs = $this->input->post();  
//            echo '<pre>';            print_r($inputs);die;
 
            $item_id = get_autoincrement_no(ITEMS); 
            $item_code = ($inputs['item_code']=='')?gen_id('1', ITEMS, 'id',4):$inputs['item_code'];
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $inputs['sales_excluded'] = (isset($inputs['sales_excluded']))?1:0;
            $inputs['purchases_excluded'] = (isset($inputs['purchases_excluded']))?1:0;
             
            //create Dir if not exists for store necessary images   
            if(!is_dir(ITEM_IMAGES.$item_id.'/')) mkdir(ITEM_IMAGES.$item_id.'/', 0777, TRUE); 
            if(!is_dir(ITEM_IMAGES.$item_id.'/other/')) mkdir(ITEM_IMAGES.$item_id.'/other/', 0777, TRUE);
            
            $appendedFiles = array();

            // scan uploads directory for appended images
            $uploadsFiles = array_diff(scandir(ITEM_IMAGES.$item_id.'/other/'), array('.', '..'));
            foreach($uploadsFiles as $file) { 
                    if(is_dir($file))// skip if directory
                            continue; 
                    $appendedFiles[] = array(
                            "name" => $file,
                            "type" => get_mime_by_extension(ITEM_IMAGES.$item_id.'/other/' . $file),
                            "size" => filesize(ITEM_IMAGES.$item_id.'/other/' . $file),
                            "file" => base_url(ITEM_IMAGES.$item_id.'/other/' . $file),
                            "data" => array(
                                "url" => base_url(ITEM_IMAGES.$item_id.'/other/' . $file)
                            )
                    );
            }    
            
            $this->load->library('fileuploads'); //file upoad library created by FL
            $def_image = $this->fileuploads->upload_all('image',ITEM_IMAGES.$item_id.'/');
            $res_itm_all_px = $this->fileuploads->upload_all('item_images',ITEM_IMAGES.$item_id.'/other/',$appendedFiles);
            
            //resize def image
            if(!empty($def_image))
                fl_image_resizer($def_image[0]['name'], 400, '',$def_image[0]['name'], BASEPATH.'.'.ITEM_IMAGES.$item_id.'/');
                        
                        
            if(!empty($res_itm_all_px)){ //images
                foreach ($res_itm_all_px as $itm_img){
                    $all_images[]=$itm_img['name'];
                    fl_image_resizer($itm_img['name'], 400, '',$itm_img['name'], BASEPATH.'.'.ITEM_IMAGES.$item_id.'/other/');
                }
            }; 
           
//            echo '<pre>';            print_r($all_images);die;
            $data['item'] = array(
                                    'id' => $item_id,
                                    'item_code' => $inputs['item_code'],
                                    'item_name' => $inputs['item_name'],
                                    'item_uom_id' => $inputs['item_uom_id'],
                                    'item_uom_id_2' => $inputs['item_uom_id_2'],
                                    'item_category_id' => $inputs['item_category_id'],
                                    'certification' => $inputs['certification'],
                                    'certification_no' => $inputs['certification_no'],
                                    'color' => $inputs['color'],
                                    'origin' => $inputs['origin'],
                                    'length' => $inputs['length'],
                                    'width' => $inputs['width'],
                                    'height' => $inputs['height'],
                                    'treatment' => $inputs['treatment'],
                                    'item_type_id' => $inputs['item_type_id'],
                                    'description' => $inputs['description'],
                                    'addon_type_id' => $inputs['addon_type_id'],
                                    'sales_excluded' => $inputs['sales_excluded'],
                                    'purchases_excluded' => $inputs['purchases_excluded'],
                                    'image' => (!empty($def_image))?$def_image[0]['name']:'',
                                    'images' => (isset($all_images))?json_encode($all_images):'',
                                    'status' => $inputs['status'], 
                                    'added_on' => date('Y-m-d'),
                                    'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                                );
                    
//                $data['item_stock_transection'][] = array(
//                                                                'transection_type'=>1, //1 for purchsing transection
//                                                                'trans_ref'=>$invoice_id, 
//                                                                'item_id'=>$inv_item['item_id'], 
//                                                                'units'=>$inv_item['item_quantity'], 
//                                                                'uom_id'=>$inv_item['item_quantity_uom_id'], 
//                                                                'units_2'=>$inv_item['item_quantity_2'], 
//                                                                'uom_id_2'=>$inv_item['item_quantity_uom_id_2'], 
//                                                                'location_id'=>$inputs['location_id'], 
//                                                                'status'=>1, 
//                                                                'added_on' => date('Y-m-d'),
//                                                                'added_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
//                                                                );
//
//                    if($inv_item['item_quantity_uom_id_2']!=0)
//                        $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity'],$inv_item['item_quantity_uom_id_2'],$inv_item['item_quantity_2']);
//                    else
//                        $item_stock_data = $this->stock_status_check($inv_item['item_id'],$inputs['location_id'],$inv_item['item_quantity_uom_id'],$inv_item['item_quantity']);
//
//                    if(!empty($item_stock_data)){
//                        $data['item_stock'][] = $item_stock_data;
//                    }
                    
            $data['sales_price'] = array();
            if(isset($inputs['prices']['sales'])){
                foreach ($inputs['prices']['sales'] as $sale_price){
                    $data['sales_price'][] = array(
                                                    'item_id' => $item_id,
                                                    'item_price_type' => 2, //2 sales price
                                                    'price_amount' =>$sale_price['amount'],
                                                    'currency_code' =>$sale_price['currency_id'],
                                                    'sales_type_id' =>$sale_price['sales_type_id'],
                                                    'status' =>1,
                                                    );

                            }
            }
//            if(!empty($def_image)) $data['image'] = $def_image[0]['name'];
//                                echo '<pre>';                                print_r($data); die;
                    
		$add_stat = $this->Items_model->add_db($data);
                
		if($add_stat[0]){ 
                    //update log data
                    $new_data = $this->Items_model->get_single_row($add_stat[1]);
                    add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__, '', $new_data);
                    $this->session->set_flashdata('warn',RECORD_ADD);
                    redirect(base_url($this->router->fetch_class())); 
                }else{
                    $this->session->set_flashdata('warn',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
	}
	
	function update(){
            $inputs = $this->input->post();   
            $this->update_sales_price(0);
            $item_id = $this->input->post('id');   
            $inputs['status'] = (isset($inputs['status']))?1:0;
            $inputs['sales_excluded'] = (isset($inputs['sales_excluded']))?1:0;
            $inputs['purchases_excluded'] = (isset($inputs['purchases_excluded']))?1:0;
              //create Dir if not exists for store necessary images   
            if(!is_dir(ITEM_IMAGES.$item_id.'/')) mkdir(ITEM_IMAGES.$item_id.'/', 0777, TRUE); 
            if(!is_dir(ITEM_IMAGES.$item_id.'/other/')) mkdir(ITEM_IMAGES.$item_id.'/other/', 0777, TRUE);
            if(!is_dir(ITEM_IMAGES.$item_id.'/videos/')) mkdir(ITEM_IMAGES.$item_id.'/videos/', 0777, TRUE);
            
            $appendedFiles = $appendedVideos= array();

            // scan uploads directory for appended images
            $uploadsFiles = array_diff(scandir(ITEM_IMAGES.$item_id.'/other/'), array('.', '..'));
            foreach($uploadsFiles as $file) { 
                    $file_type = explode('/', get_mime_by_extension(ITEM_IMAGES.$item_id.'/other/' . $file));
                    if(is_dir($file))// skip if directory
                            continue; 
                                $file_array = array(
                                                    "name" => $file,
                                                    "type" => $file_type,
                                                    "size" => filesize(ITEM_IMAGES.$item_id.'/other/' . $file),
                                                    "file" => base_url(ITEM_IMAGES.$item_id.'/other/' . $file),
                                                    "data" => array("url" => base_url(ITEM_IMAGES.$item_id.'/other/' . $file) )
                                                     );
                                
                                if(isset($file_type[0]) && $file_type[0]=='image'){
                                    $appendedFiles[] = $file_array;
                                }
            }       
            
            $this->load->library('fileuploads'); //file upoad library created by FL
            $def_image = $this->fileuploads->upload_all('image',ITEM_IMAGES.$item_id.'/');
            $res_itm_all_px = $this->fileuploads->upload_all('item_images',ITEM_IMAGES.$item_id.'/other/',$appendedFiles);
            $res_itm_all_vdo = $this->fileuploads->upload_all('item_videos',ITEM_IMAGES.$item_id.'/videos/',$appendedVideos);
            
//            echo '<pre>';            print_r($res_itm_all_px); die;
            //resize def image
            if(!empty($def_image))
                fl_image_resizer($def_image[0]['name'], 660, 566, '',$def_image[0]['name'], BASEPATH.'.'.ITEM_IMAGES.$item_id.'/');
                        
                        
            if(!empty($res_itm_all_px)){ //images
                foreach ($res_itm_all_px as $itm_img){
                    $all_images[]=$itm_img['name'];
                    fl_image_resizer($itm_img['name'], 660, 566, '',$itm_img['name'], BASEPATH.'.'.ITEM_IMAGES.$item_id.'/other/');
                }
            }; 
            
            if(!empty($res_itm_all_vdo)){//vdos
                foreach ($res_itm_all_vdo as $itm_vdo){
                    $all_videos[]=$itm_vdo['name'];
                }
            }; 
            if(!empty($inputs['exist_vdos'])){//existing videos
                foreach ($inputs['exist_vdos'] as $itm_vdo_exst){
                    $all_videos[]=$itm_vdo_exst;
                }
            }; 
            
            //remove video file that was deleted
            $dir_videos = array_diff(scandir(ITEM_IMAGES.$item_id.'/videos/'), array('.', '..'));
            $arr_dif = array_diff($dir_videos, $all_videos);
            if(!empty($arr_dif)){
                foreach ($arr_dif as $remove_vdos){
                    unlink(ITEM_IMAGES.$item_id.'/videos/'.$remove_vdos);
                }
            }
            
            $data = array(
                            'item_code' => $inputs['item_code'],
                            'item_name' => $inputs['item_name'],
                            'item_uom_id' => $inputs['item_uom_id'],
                            'item_uom_id_2' => $inputs['item_uom_id_2'],
                            'item_category_id' => $inputs['item_category_id'],
                            'certification' => $inputs['certification'],
                            'certification_no' => $inputs['certification_no'],
                            'color' => $inputs['color'],
                            'origin' => $inputs['origin'],
                            'length' => $inputs['length'],
                            'width' => $inputs['width'],
                            'height' => $inputs['height'],
                            'treatment' => $inputs['treatment'],
                            'item_type_id' => $inputs['item_type_id'],
                            'description' => $inputs['description'],
                            'addon_type_id' => $inputs['addon_type_id'],
                            'sales_excluded' => $inputs['sales_excluded'],
                            'purchases_excluded' => $inputs['purchases_excluded'], 
                            'status' => $inputs['status'], 
                            'updated_on' => date('Y-m-d'),
                            'images' => (isset($all_images))?json_encode($all_images):'',
                            'videos' => (isset($all_videos))?json_encode($all_videos):'',
                            'updated_by' => $this->session->userdata(SYSTEM_CODE)['ID'],
                        ); 
                        if(!empty($def_image)) $data['image'] = $def_image[0]['name']; 
                            
                        
//            echo '<pre>';            print_r($data); die;
            //old data for log update
            $existing_data = $this->Items_model->get_single_row($inputs['id']);

            $edit_stat = $this->Items_model->edit_db($inputs['id'],$data);
            
            if($edit_stat){
                //update log data
                $new_data = $this->Items_model->get_single_row($inputs['id']);
                add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__, $new_data, $existing_data);
                $this->session->set_flashdata('warn',RECORD_UPDATE);
                    
                redirect(base_url($this->router->fetch_class().'/edit/'.$inputs['id']));
            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url($this->router->fetch_class()));
            } 
	}	
        function update_sales_price($msg_need=1){  
            
            $inputs = $this->input->post();   
//            echo '<pre>';            print_r($inputs); die;
            $sp_i =0;
            if($inputs['id']>0 && isset($inputs['prices']['sales']) && !empty($inputs['prices']['sales'])){
                foreach ($inputs['prices']['sales'] as $sales_price){
                    $sales_price_exst = $this->Items_model->get_item_prices($inputs['id'],'item_price_type=2 and sales_type_id = '.$sales_price['sales_type_id'].' ');
                    
                    $cur_det = $this->Items_model->get_currency_for_code($sales_price['currency_id']);
                    
                    $sp_data = array(
                                    'item_id' => $inputs['id'],
                                    'item_price_type' => 2, //2 sales price
                                    'price_amount' =>$sales_price['amount'],
                                    'currency_code' =>$cur_det['code'],
                                    'currency_value' =>$cur_det['value'],
                                    'sales_type_id' =>$sales_price['sales_type_id'],
                                    'status' =>1,
                                    );
//                    echo '<pre>';            print_r($sp_data);die;
                    if(empty($sales_price_exst)){ 
                        $insert = $this->Items_model->add_db_item_price($sp_data);
                        if(!$insert && $msg_need==1){
                            echo '<div class="alert alert-danger alert-dismissible fl_msg">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    </i> Failed! please retry!</div>';
                            break;
                        }
                    }else{
                        $update = $this->Items_model->edit_db_item_price($sales_price_exst[0]['id'],$sp_data);
                        if(!$update && $msg_need==1){
                            echo '<div class="alert alert-danger alert-dismissible fl_msg">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    </i> Failed! please retry!</div>';
                            break;
                        }
                        
                    }
                    $sp_i++; 
                }
                if($sp_i>0 && $msg_need==1){
                    echo '<div class="alert alert-success alert-dismissible fl_msg">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        </i> Success! Price updated.</div>';
                }
//                die;
            }else{
                if($msg_need==1){
                     echo '<div class="alert alert-danger alert-dismissible fl_msg">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            </i> Failed! You need to create item first!</div>'; 
                    } 
                }
                    
        }
        function update_purchasing_price(){
            $inputs = $this->input->post();  
            $sp_i =0;
            if($inputs['id']>0 && isset($inputs['prices']['purchasing']) && !empty($inputs['prices']['purchasing'])){
                $purchase_price = $inputs['prices']['purchasing'];
                
                $cur_det = $this->Items_model->get_currency_for_code($purchase_price['purchasing_currency']);
                   
//                echo '<pre>';            print_r($cur_det);die;
                    $pp_data = array(
                                    'item_id' => $inputs['id'],
                                    'item_price_type' => 1, //2 purchasing price
                                    'price_amount' =>$purchase_price['purchasing_amount'],
                                    'currency_code' =>$cur_det['code'],
                                    'currency_value' =>$cur_det['value'],
                                    'supplier_id' =>$purchase_price['supplier_id'],
                                    'supplier_unit' =>$purchase_price['supplier_unit'],
                                    'supplier_unit_conversation' =>$purchase_price['unit_conversation'],
                                    'note' =>$purchase_price['description'],
                                    'status' =>1,
                                    ); 
//                    echo '<pre>';            print_r($pp_data);die;
                    $purchasing_price_exst = $this->Items_model->get_item_prices($inputs['id'],'item_price_type=1 and supplier_id = '.$purchase_price['supplier_id'].' ');
//                    $purchasing_price_exst = $this->Items_model->get_item_prices($inputs['id'],'item_price_type=1 and supplier_id = '.$purchase_price['supplier_id'].' and price_amount='.$purchase_price['purchasing_amount'].'  and currency_code= "'.$purchase_price['purchasing_currency'].'"   and supplier_unit_conversation='.$purchase_price['unit_conversation'].' ');
                    
                    $insert = false; 
                    if(empty($purchasing_price_exst)){       
                        $insert = $this->Items_model->add_db_item_price($pp_data);
                    }
                        if(!$insert){
                            echo '<div class="alert alert-danger alert-dismissible fl_msg">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    </i> Failed! This supplier already has amount for this item!</div>'; 
                        } else {
                            echo '<div class="alert alert-success alert-dismissible fl_msg">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                </i> Success! Price updated.</div>';
                        }
                        
                }else{
                     echo '<div class="alert alert-danger alert-dismissible fl_msg">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            </i> Failed! You need to create item first!</div>'; 
                }  
                $data = $this->load_data($this->input->post('id'));  
                $this->load->view('items/pp_items_result',$data);
            } 
            
        
        function load_purchasing_price(){ 
                $data = $this->load_data($this->input->post('id'));  
                $this->load->view('items/pp_items_result',$data);
        }
        
        function remove_price($id){
            $data= array('deleted'=>1,'status'=>0);
            $delete_stat = $this->Items_model->delete_db($id,$data,ITEM_PRICES);
            if(true){
                echo '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </i> Success! Item price deleted successfully.</div>';
                $data = $this->load_data($this->input->post('id'));  
                $this->load->view('items/pp_items_result',$data);
            }
	}
	
        function remove(){
            $inputs = $this->input->post();
            
            $check_del = deletion_check(ITEMS, 'item_category_id', $inputs['id']); //has rates 
            if($check_del==0 || $check_del==0){                           
                $data = array(
                                'deleted' => 1, 
                                'deleted_on' => date('Y-m-d'),
                                'deleted_by' => $this->session->userdata(SYSTEM_CODE)['ID']
                             ); 

                    $existing_data = $this->Items_model->get_single_row($inputs['id']);
                    $delete_stat = $this->Items_model->delete_db($inputs['id'],$data);

                if($delete_stat){
                    //update log data
                    add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__,$existing_data, '');
                    $this->session->set_flashdata('warn',RECORD_DELETE);
                    redirect(base_url($this->router->fetch_class()));
                }else{
                    $this->session->set_flashdata('error',ERROR);
                    redirect(base_url($this->router->fetch_class()));
                } 
            }else{
                $this->session->set_flashdata('error','Can not delete! This Vehicle has rates or reservation.');
                redirect(base_url($this->router->fetch_class().'/delete/'.$inputs['id']));
            }
	}
	
	
	function remove2(){
            $id  = $this->input->post('id'); 
            
            $existing_data = $this->Items_model->get_single_row($inputs['id']);
            if($this->Items_model->delete2_db($id)){
                //update log data
                add_system_log(ITEM_CAT, $this->router->fetch_class(), __FUNCTION__, '', $existing_data);
                
                $this->session->set_flashdata('warn',RECORD_DELETE);
                redirect(base_url('company'));

            }else{
                $this->session->set_flashdata('warn',ERROR);
                redirect(base_url('company'));
            }  
	}
        
         function load_data($id=''){
             $data = array(); 
            if($id!=''){
                $data['user_data'] = $this->Items_model->get_single_row($id); 
                $data['item_prices']['sales'] = $this->Items_model->get_item_prices($id,'item_price_type=2'); //2 for sales price
                $data['item_prices']['purchasing'] = $this->Items_model->get_item_prices($id,'item_price_type=1'); //2 for sales price
                $data['stock_status'] = $this->Items_model->get_item_status($id);
                if(empty($data['user_data'])){
                    $this->session->set_flashdata('error','INVALID! Please use the System Navigation');
                    redirect(base_url($this->router->fetch_class()));
                }
            }
            $data['new_item_code'] =  gen_id('1', ITEMS, 'id',4);
//            echo '<pre>';            print_r($data); die;
            $data['item_category_list'] = get_dropdown_data(ITEM_CAT,'category_name','id',''); 
            $data['location_list'] = get_dropdown_data(INV_LOCATION,'location_name','id',''); 
            $data['item_uom_list'] = get_dropdown_data(ITEM_UOM,'unit_abbreviation','id',''); 
            $data['item_uom_list_2'] = get_dropdown_data(ITEM_UOM,'unit_abbreviation','id','No Secondory UOM'); 
            $data['sales_type_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','','dropdown_id = 14'); //14 for sales type
            $data['certification_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','Certification','dropdown_id = 4'); //4 for certification
            $data['color_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Colors','dropdown_id = 17'); //18 Origin
            $data['origin_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Origin','dropdown_id = 18'); //4 for certification
            $data['shape_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Shapes','dropdown_id = 16'); //4 for certification
            $data['treatments_list'] = get_dropdown_data(DROPDOWN_LIST,'dropdown_value','id','No Treatment','dropdown_id = 5'); //14 for treatments
            $data['supplier_list'] = get_dropdown_data(SUPPLIERS,'supplier_name','id',''); 
            $data['currency_list'] = get_dropdown_data(CURRENCY,'title','code',''); 
            $data['addon_type_list'] = array(0=>'Default');
            $data['item_type_list'] = get_dropdown_data(ITEM_TYPES,'item_type_name','id','');
            return $data;
         }
        
        function search(){
            $input = $this->input->post();
//                        echo '<pre>';            print_r($input); die;
		$search_data=array( 'item_name' => $this->input->post('item_name'), 
                                    'item_category_id' => $this->input->post('item_category_id'),
                                    'item_code' => $this->input->post('item_code'),
                                    'status' => (isset($input['status']))?1:0 
                                ); 
		$data_view['search_list'] = $this->Items_model->search_result($search_data,(isset($input['row_limit']) && is_numeric($input['row_limit']))?$input['row_limit']:50);
                                        
		$this->load->view('items/search_items_result',$data_view);
	}
                        
        function fl_ajax(){
            $func = $this->input->post('function_name');
            $param = $this->input->post();
            
            if(method_exists($this, $func)){ 
                (!empty($param))?$this->$func($param):$this->$func();
            }else{
                return false;
            }
        }
        
        function get_category($para){//ajax 1
            $this->load->model('Item_categories_model');
            $item_vat_det = $this->Item_categories_model->get_single_row($para['cat_id']);
            echo json_encode($item_vat_det[0]);
//                        echo '<pre>';            print_r($item_vat_det);

        }
                
        function test(){ 
            $data['main_content']='test';  
            $this->load->view('test'); die;
//            echo '<pre>';            print_r(is_connected_internet('www.fahrylafir.com')); die;
                    
            $data['action']		= 'Add';
            $data['main_content']='items/test';  
            $this->load->view('includes/template',$data);
            
            $this->fl_ajax('get_category',array('2')); die;
            echo '<pre>';            print_r($this->router->class); die;
//            $this->load->model('Items_model');
//            $data = $this->Items_model->get_single_row(1);
            echo '<pre>' ; print_r(get_dropdown_data(ITEM_CAT,'hotel_name','id','Hotel'));die;
//            log_message('error', 'Some variable did not contain a value.');
        }
                    
                    
}
