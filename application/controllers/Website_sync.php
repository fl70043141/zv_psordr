<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website_sync extends CI_Controller {

	
        function __construct() {
            parent::__construct();
            $this->load->model('WebsiteSync_model');
        }

        public function index(){
//            echo 'asas'; ; die;
            $data['action']		= 'Add';
            $data['main_content'] = 'website_sync/sync_window';  
           
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
        
        function initial_item_upoad(){
            $this->load->model('Items_model');
            $all_items = $this->Items_model->search_result();
            $itm_data_oc = array();
            foreach ($all_items as $item){
                $item_price = $this->Items_model->get_item_prices($item['id'],'sales_type_id = 15'); //15 retail price
//            echo '<pre>';            print_r($item_price[0]['price_amount']); die;
                $item_price_amount = 0;
                if(isset( $item_price[0]['price_amount'])) $item_price_amount= $item_price[0]['price_amount'];
                    $product         = array(   'product_id' =>$item['id'],
                                                'model' => $item['item_code'],
                                                'quantity' => '12', //fixed 12
                                                'stock_status_id' => '6',
                                                'image' => 'catalog/products/'.$item['item_code'].'/'.$item['image'],
                                                'manufacturer_id' => '0',
                                                'shipping' => '1',
                                                'price' =>$item_price_amount, 
                                                'date_available' => date('Y-m-d'), 
                                                'weight_class_id' => '1',
                                                'length_class_id' => '1',
                                                'subtract' => '1',
                                                'minimum' => '1',
                                                'sort_order' => '1',
                                                'status' => '1',
                                                'viewed' => '0',
                                                'date_added' => date('Y-m-d H:i:s'),
                                                'date_modified' => '0000-00-00 00:00:00'
                                            );
            
                    $product_desc    =  array(  'product_id' => $item['id'],
                                                'language_id' => '1',
                                                'name' => $item['item_name'],
                                                'description' => $item['description'],
                                                'tag' => '',
                                                'meta_title' => 'Nextlook '.$item['category_name'].' | '.$item['item_name'],
                                                'meta_description' =>  $item['item_name'].' '. $item['description'],
                                                'meta_keyword' => 'Nextlook UK, '.$item['category_name'].','.$item['item_name'].', Online House Hold Items, Online Toys, Licester, UK Onine shop',
                                            );
                    $product_images = array();
                    if(!empty($item['images'])){
                        $item_images = json_decode($item['images']);
                        foreach ($item_images as $itm_img){
                            $product_images = array(    'product_id' => $item['id'],
                                                        'image' => 'catalog/products/'.$item['item_code'].'/other/'.$itm_img,
                                                        'sort_order' => '0'
                                                        );
                        }
                    }
                    $product_to_store = array('product_id' => $item['id'],'store_id' => '0');

                    

                    $product_category = array('product_id'=> $item['id'], 'category_id'=>$item['item_category_id']);

                    $product_layout = array('product_id' => $item['id'],'store_id' => '0','layout_id' => '0');
                    
                    $itm_data_oc[$item['id']] = array(
                                                            'product'=> $product,
                                                            'product_desc'=> $product_desc,
                                                            'product_images'=> $product_images,
                                                            'product_to_store'=> $product_to_store,
                                                            'product_category'=> $product_category,
                                                            'product_layout'=> $product_layout,
                                                     );
            }
           
            echo '<pre>';            print_r($itm_data_oc); die;
        }
        
        
        
        
        
        
        
        
        public function sync_local_remote($rep_ids=array()){ //Empty array--> sync all
            $local = $this->syncAllReportLocalData();
            $remote = $this->SyncAllRemoteData($rep_ids);
            echo '<p class="text-danger">Local Sync. completed: '.$local['local_synced'];
            echo ', Local Sync. Failed: '.$local['local_failed'];
            echo '<br>Remote Sync. completed: '.$remote.'</p>';
	}
        
        //step 1 - preparing for Sync
        function syncAllReportLocalData($ids=array()){
            $idString = implode(',', $ids);
            
            $sync_local_data = $this->WebsiteSync_model->get_report_data($idString);
            $new_local_sync = $local_sync_failed = 0;
            foreach($sync_local_data as $local_data){
                $sync_pending = $this->WebsiteSync_model->get_report_sync($local_data['id']);
                if($sync_pending == 0){
                    $insert_local_data = array(
                                                'report_id' => $local_data['id'],
                                                'remote_sync_status' => 0,
                                                'remote_sync_time' => 0,
                                                'local_sync_time' => time(),
                                                );
                    $add_stat = $this->WebsiteSync_model->add_local_sync($insert_local_data); 
                    ($add_stat ==1)?$new_local_sync++:$local_sync_failed++;
                }else{
                    $add_stat = $this->WebsiteSync_model->update_lab_report_statOnly($local_data['id']); 

                }
            }
//            echo 'local Sync Succeeded-'.$new_local_sync." , Failed-".$local_sync_failed;
                return array('local_synced'=>$new_local_sync, 'local_failed'=>$local_sync_failed);
            
        }
        
        //step 2 - execute data to remote
        function SyncAllRemoteData($rep_ids=array()){ 
            $sync_required_data = $this->WebsiteSync_model->get_report_local_syncData($rep_ids);
            //split the array to  each array size 5
            $sync_required_data_splitted = array_chunk($sync_required_data, 5, true);
            $send_data_count = 0;
            foreach ($sync_required_data_splitted as $sync_required_data_chunk){
                            

                $remote_data = array();
                foreach ($sync_required_data_chunk as $report_data){ 
//                    echo '<pre>'; print_r(($report_data)); die;
                    $img_data = ''; 
                    if($report_data['pic1'] != '' && file_exists(BASEPATH.'.'.LAB_REPORT_IMAGES.$report_data['report_no'].'/'.$report_data['pic1'])){
                        $img_data = base64_encode(file_get_contents(BASEPATH.'.'.LAB_REPORT_IMAGES.$report_data['report_no'].'/'.$report_data['pic1']));    

                        $remote_data[] = array(
                                                'local_report_id'=> $report_data['id'],
                                                'lrs_id'=> $report_data['lrs_id'],
                                                'report_no'=> $report_data['report_no'],
                                                'report_date'=> $report_data['report_date'],
                                                'weight'=> $report_data['weight'],
                                                'dimension'=> $report_data['dimension'],
                                                'object'=> $report_data['object_val'],
                                                'identification'=> $report_data['identification_val'],
                                                'variety'=> $report_data['variety_val'],
                                                'shape'=> $report_data['shape_val'],
                                                'cut'=> $report_data['cut_val'],
                                                'refractive_index'=> $report_data['ri_text_value'],
                                                'specific_gravity'=> $report_data['sg_text_value'],
                                                'transparency'=> $report_data['transparency'],
                                                'color'=> $report_data['color'],
                                                'comments'=> $report_data['comments'],
                                                'appendix'=> $report_data['appendix'],
                                                'status'=> $report_data['status'],
                                                'deleted'=> $report_data['deleted'],
                                                'image'=> $img_data,
                                            );
                    }

    //                echo '<img src="data:image/gif;base64,'.$img_data.'">';
                }   

                $this->load->model('RemoteSync_model');
                $this->load->library('Curl');
                $encrypted_remote_response_data = $this->WebsiteSync_model->postToRemoteServer($remote_data);
                $remote_data = unserialize(stripslashes(mc_decrypt($encrypted_remote_response_data, ENCRYPTION_KEY)));

                //Update_remoteSyncTable
                 if(!empty($remote_data)){
                     foreach ($remote_data as $rdata){
                         $update_data = array(
                                                'report_id' => $rdata['report_id'],
                                                'remote_sync_status' => $rdata['remote_sync_status'],
                                                'remote_sync_time' => $rdata['remote_sync_time'],
                                                );
                                                $this->WebsiteSync_model->edit_lab_report_syncTable($rdata['lrs_id'],$update_data);
    //                                   

                     }
    //                echo '<pre>';            print_r($remote_data);die; 
//                    return count($remote_data);
                    $send_data_count = $send_data_count + count($remote_data);
                 } else {
//                    return 0;
                    }
            
            }
            return $send_data_count;
        }
        
        function test(){
            $this->sync_local_remote();
         }
         
}
