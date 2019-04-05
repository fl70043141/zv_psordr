<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 function get_print_profile($id){
    $CI =& get_instance();
    $CI->db->select("*");	
    $CI->db->from(PRINT_PROFILE);	
    $CI->db->where('id',$id);
    $res = $CI->db->get()->result_array();
    if(!empty($res)){
        return $res[0];
    }
    return 0;
    
}
//Escpos Direcrt Print 
function fl_direct_print_test($profile_id=2){
//function fl_direct_print($printer_name = "FK80_NV",$user="Nveloop",$pass="123",$host="NVELOOP",$network="workgroup"){
    $profile = get_print_profile($profile_id);
//    echo '<pre>';    print_r($profile); die;
    
    $user = $profile['user'];
    $pass = $profile['pass'];
    $host = $profile['host'];
    $network = $profile['network'];
    $printer_name = $profile['printer_name'];
    
    $CI =& get_instance();
    $CI->load->library("EscPos"); 
    try { 

            $connector = null;
//                            $connector = new Escpos\PrintConnectors\NetworkPrintConnector("192.168.1.7");
//            $connector = new Escpos\PrintConnectors\WindowsPrintConnector("smb://Nveloop:123@NVELOOP/workgroup/FK80_NV");
            $connector = new Escpos\PrintConnectors\WindowsPrintConnector("smb://".$user.":".$pass."@".$host."/".$network."/".$printer_name);
            /* Print a "Hello world" receipt" */
            
            $printer = new Escpos\Printer($connector);  
            
            
//            $printer->setEmphasis(false);
            $printer->setJustification(\Escpos\Printer::JUSTIFY_CENTER);
            
//                $printer->text("Nveloop Courier.
//Customer: Shafras Nawas.
//
//            INVOICE
//                              Rs
//Delivery- Mount Lavinia       350.00
//Delivery- Ambepitiya          250.00
//
//Total                         600.00
//");
            for($i=1;$i<5; $i++){
                $printer->setUnderline(Escpos\Printer::UNDERLINE_DOUBLE);
                $printer->text("Item 10500".$i);
                $printer->setBarcodeHeight(60);
                $printer->barcode((105000+$i)); 
                $printer ->feed(3); 
            }
            
            $printer -> cut();
                    /* Close printer */
            $printer -> close();
    } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    } 
    
}
//Escpos Direcrt Print 
function fl_direct_print_invoice($inv_data ,$profile_id=1){
    $profile = get_print_profile($profile_id);
//    echo '<pre>';    print_r($profile); die;
    
    $user = $profile['user'];
    $pass = $profile['pass'];
    $host = $profile['host'];
    $network = $profile['network'];
    $printer_name = $profile['printer_name'];
    
    $items = array();
    $subtotal = $total_line_disc = 0;
    foreach ($inv_data['invoice_desc'] as $inv_cat){ 
        foreach ($inv_cat as $inv_item){
            $item_gross = $inv_item['unit_price'] * $inv_item['item_quantity'];
            $subtotal += $item_gross;
            
            $items[] = new item($inv_item['item_code'], $inv_item['item_description'], $inv_item['item_quantity'], number_format($inv_item['unit_price'],2), number_format($item_gross,2));
            $disc_amount = 0;
            if($inv_item['discount_fixed'] > 0){
                $disc_amount += $inv_item['discount_fixed'];
            }
            if($inv_item['discount_persent'] >0){
                $disc_amount += ($inv_item['item_quantity'] * $inv_item['unit_price']) * $inv_item['discount_persent'] * 0.01;
            } 
            if($disc_amount > 0) { 
                $total_line_disc += $disc_amount;
                $subtotal -= $disc_amount;
                $items[] = new item("","DISCOUNT","", "", number_format($disc_amount,2));
            }
        }
    }
    
        $sub_total = new item( 'SUBTOTAL','','','', number_format($subtotal,2));
        $total = new item('Total', '','','',number_format($subtotal,2),true);
        $invoice_no = $inv_data['invoice_dets']['invoice_no'];
        $sales_person = $inv_data['invoice_dets']['sales_person'];
        $invno_sperson = new twoColsItem('No: '.$invoice_no,'Staff: '.$sales_person);
        //Transection
        $transections = array();
        if(!empty($inv_data['inv_transection'])){
            foreach ($inv_data['inv_transection'] as $trans){
                $transections[] = new twoColsItemTrans($trans['payment_method'], number_format($trans['transection_amount'],2));
            }
        } 
        
        $CI =& get_instance();
        $CI->load->model('Company_model');
        
        $system_data = $CI->session->userdata(SYSTEM_CODE);
        $company_info= $CI->Company_model->get_single_row($system_data['company_id'])[0];
//        echo '<pre>';            print_r($company_info); die;
    $CI->load->library("EscPos"); 
    try { 

            $connector = null;
            $connector = new Escpos\PrintConnectors\WindowsPrintConnector("smb://".$user.":".$pass."@".$host."/".$network."/".$printer_name);
            
            $printer = new Escpos\Printer($connector);   
                /* Date is kept the same for testing */
                // $date = date('l jS \of F Y h:i:s A');
                $date = date(SYS_DATE_FORMAT." H:i s A");
                /* Start the printer */ 
                $logo = Escpos\EscposImage::load(__DIR__."\..\..\storage\images\company\logosm.png"); 
                
                /* Print top logo */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_CENTER);
                $printer -> bitImageColumnFormat($logo); 
                $printer->feed(); 
                
////                /* Name of shop */
                $printer->selectPrintMode(\Escpos\Printer::MODE_DOUBLE_WIDTH);
                $printer->text($company_info['company_name'].".\n");
                
                $printer->selectPrintMode();
                $printer->text($company_info['street_address']." ".(($company_info['city']!='')?$company_info['city']:'')."\n");
                if($company_info['phone']!='')$printer->text("Phone: ".$company_info['phone']."\n");
                $printer->setFont(\Escpos\Printer::FONT_B);
                $printer->text($invno_sperson);
                $printer->feed();
////                /* Title of receipt */
                $printer->setFont(\Escpos\Printer::FONT_A);
                $printer->setEmphasis(true);
                $printer->text("SALES INVOICE");
                $printer->setEmphasis(false); 
                $printer->feed(2);
                
//                /* Items */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_LEFT);
                $printer->setEmphasis(true);
                $printer->setUnderline(true);
                $printer->setFont(\Escpos\Printer::FONT_B);
                $printer->text(new item('CODE', 'DESC', 'QTY', 'PRICE', 'AMOUNT'));
                $printer->setUnderline(false);
//                $printer->text(new item('', '', '', '', '(Rs.)'));
                $printer->setEmphasis(false);
                foreach ($items as $item) {
                    $printer->text($item);
                }
                
                $printer->setEmphasis(false);
                $printer->setFont(\Escpos\Printer::FONT_B); 
                 
                $printer->setUnderline(true);
                $printer->text(".");
                $printer->feed();
                $printer->text($sub_total);
                foreach ($transections as $transection) {
                    $printer->text($transection);
                }
                $printer->setEmphasis(false);
                $printer->feed();
                /* Tax and total */
//                $printer->text($tax);
                $printer->selectPrintMode(\Escpos\Printer::MODE_DOUBLE_WIDTH);
                $printer->setUnderline(true);
                $printer->text($total);
                $printer->setUnderline(false);
                $printer->selectPrintMode();
                
                $printer->feed();
                $printer->setJustification(\Escpos\Printer::JUSTIFY_RIGHT);  
                /* Footer */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_CENTER);
                $printer->feed(1);
                $printer->setBarcodeHeight(60);
                $printer->setBarcodeWidth(2);
                $printer->barcode($invoice_no);  
                $printer->feed(2);
                $printer->text("Thank you for shopping at ".$company_info['company_name']." \n");
                $printer->text("For Inquiry, please email to ".$company_info['email']."\n");
                $printer->feed(1);
                $printer->text("Return / Exchange Possible within 3 days. \n");
                $printer->text("by Submitting original bill & good with \norigonal condition.");
                $printer->feed(2);
                $printer->text($date . "\n");
                
            $printer -> cut();
                    /* Close printer */
            $printer -> close();
    } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    } 
    
}
//Escpos Direcrt Print 
function fl_direct_print_return($inv_data ,$profile_id=1){
    $profile = get_print_profile($profile_id);
//    echo '<pre>';    print_r($profile); die;
    
    $user = $profile['user'];
    $pass = $profile['pass'];
    $host = $profile['host'];
    $network = $profile['network'];
    $printer_name = $profile['printer_name'];
    
    $items = array();
    $subtotal = $total_line_disc = 0;
    
//    echo '<pre>';    print_r($inv_data); die;
    foreach ($inv_data['invoice_desc'] as $inv_cat){ 
        foreach ($inv_cat as $inv_item){
            $item_gross = $inv_item['unit_price'] * $inv_item['units'];
            $subtotal += $item_gross;
            
            $items[] = new item($inv_item['item_code'], $inv_item['item_desc'], $inv_item['units'], number_format($inv_item['unit_price'],2), number_format($item_gross,2));
            $disc_amount = 0;
            if($inv_item['disc_tot_refund'] > 0){
                $disc_amount += $inv_item['disc_tot_refund'];
            } 
            if($disc_amount > 0) { 
                $total_line_disc += $disc_amount;
                $subtotal -= $disc_amount;
                $items[] = new item("","DISC REFUND","", "", number_format($disc_amount,2));
            }
        }
    }
    
        $sub_total = new item( 'SUBTOTAL','','','', number_format($subtotal,2));
        $total = new item('Total', '','','',number_format($subtotal,2),true);
        $invoice_no = $inv_data['invoice_dets']['cn_no'];
        $sales_person = $inv_data['invoice_dets']['sales_person'];
        $invno_sperson = new twoColsItem('No: '.$invoice_no,'Staff: '.$sales_person);
        //Transection
        $transections = array();
//        if(!empty($inv_data['inv_transection'])){
//            foreach ($inv_data['inv_transection'] as $trans){
//                $transections[] = new item($trans['payment_method'],'','','', number_format($trans['transection_amount'],2));
//            }
//        } 
        
        $CI =& get_instance();
        $CI->load->model('Company_model');
        
        $system_data = $CI->session->userdata(SYSTEM_CODE);
        $company_info= $CI->Company_model->get_single_row($system_data['company_id'])[0];
//        echo '<pre>';            print_r($company_info); die;
    $CI->load->library("EscPos"); 
    try { 

            $connector = null;
            $connector = new Escpos\PrintConnectors\WindowsPrintConnector("smb://".$user.":".$pass."@".$host."/".$network."/".$printer_name);
            
            $printer = new Escpos\Printer($connector);   
                /* Date is kept the same for testing */
                // $date = date('l jS \of F Y h:i:s A');
                $date = date(SYS_DATE_FORMAT." H:i s A");
                /* Start the printer */ 
                $logo = Escpos\EscposImage::load(__DIR__."\..\..\storage\images\company\logosm.png"); 
                
                /* Print top logo */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_CENTER);
                $printer -> bitImageColumnFormat($logo); 
                $printer->feed(); 
                
////                /* Name of shop */
                $printer->selectPrintMode(\Escpos\Printer::MODE_DOUBLE_WIDTH);
                $printer->text($company_info['company_name'].".\n");
                
                $printer->selectPrintMode();
                $printer->text($company_info['street_address']." ".(($company_info['city']!='')?$company_info['city']:'')."\n");
                if($company_info['phone']!='')$printer->text("Phone: ".$company_info['phone']."\n");
                $printer->setFont(\Escpos\Printer::FONT_B);
                $printer->text($invno_sperson);
                $printer->feed();
////                /* Title of receipt */
                $printer->setFont(\Escpos\Printer::FONT_A);
                $printer->setEmphasis(true);
                $printer->text("RETURN NOTE");
                $printer->setEmphasis(false); 
                $printer->feed(2);
                
//                /* Items */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_LEFT);
                $printer->setEmphasis(true);
                $printer->setUnderline(true);
                $printer->setFont(\Escpos\Printer::FONT_B);
                $printer->text(new item('CODE', 'DESC', 'QTY', 'PRICE', 'AMOUNT'));
                $printer->setUnderline(false);
//                $printer->text(new item('', '', '', '', '(Rs.)'));
                $printer->setEmphasis(false);
                foreach ($items as $item) {
                    $printer->text($item);
                }
                
                $printer->setEmphasis(false);
                $printer->setFont(\Escpos\Printer::FONT_B); 
                 
                $printer->setUnderline(true);
                $printer->text(".");
                $printer->feed();
                $printer->text($sub_total);
                if(!empty($transections)){
                    foreach ($transections as $transection) {
                        $printer->text($transection);
                    }
                }
                $printer->setEmphasis(false);
                $printer->feed();
                /* Tax and total */
//                $printer->text($tax);
                $printer->selectPrintMode(\Escpos\Printer::MODE_DOUBLE_WIDTH);
                $printer->setUnderline(true);
                $printer->text($total);
                $printer->setUnderline(false);
                $printer->selectPrintMode();
                
                $printer->feed();
                $printer->setJustification(\Escpos\Printer::JUSTIFY_RIGHT);  
                /* Footer */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_CENTER);
                $printer->feed(1);
                $printer->setBarcodeHeight(60);
                $printer->setBarcodeWidth(2);
                $printer->barcode($invoice_no);  
                $printer->feed(2);
                $printer->text("Thank you for shopping at ".$company_info['company_name']." \n");
                $printer->text("For Inquiry, please email to ".$company_info['email']."\n"); 
                $printer->feed(2);
                $printer->text($date . "\n");
                
            $printer -> cut();
                    /* Close printer */
            $printer -> close();
    } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    } 
    
}

function fl_direct_print($printer_name = "FK80_ZV",$user="fahryy",$pass="fahrydgt",$host="zoneventure",$network="workgroup"){
//function fl_direct_print($printer_name = "FK80_NV",$user="Nveloop",$pass="123",$host="NVELOOP",$network="workgroup"){
    $CI =& get_instance();
    $CI->load->library("EscPos"); 
    try { 

            $connector = null;
//                            $connector = new Escpos\PrintConnectors\NetworkPrintConnector("192.168.1.7");
//            $connector = new Escpos\PrintConnectors\WindowsPrintConnector("smb://Nveloop:123@NVELOOP/workgroup/FK80_NV");
            $connector = new Escpos\PrintConnectors\WindowsPrintConnector("smb://".$user.":".$pass."@".$host."/".$network."/".$printer_name);
            /* Print a "Hello world" receipt" */
            
            $printer = new Escpos\Printer($connector);   
                $items = array(new item("10001","Canon Printer","2","14,000.00", "28,000.00"), 
                               new item("10002","Tempered Glass S6","2", "300.00","600.00"),
                               new item("10003","Accounting PACK","3","75,000.00",  "225,000.00"),
                               new item("10004","External HD 1 TB","3","15,000.00",  "45,000.00"),
                               new item("10005","Galaxy Tab 2","2", "42,000.00", "84,000.00"),
                               new item("","DISCOUNT","", "", "4,000.00"),
                               new item("10005","I-phone 5S","2", "55,000.00", "110,000.00"),
                            );
                $printer->text("Nveloop Solution"); 
                $subtotal = new item('Subtotal', '12.95');
//                $tax = new item('A local tax', '1.30');
                $total = new item('Total', '','','','Rs. 488,600.00',true);
                /* Date is kept the same for testing */
                // $date = date('l jS \of F Y h:i:s A');
                $date = date(SYS_DATE_FORMAT." H:i s A");
                /* Start the printer */
//                echo '<pre>';                print_r(__DIR__); die;
                $logo = Escpos\EscposImage::load(__DIR__."\..\..\storage\images\company\logosm.png"); 
                /* Print top logo */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_CENTER);
                $printer -> bitImageColumnFormat($logo); 
                $printer->feed();
////
////                /* Name of shop */
                $printer->selectPrintMode(\Escpos\Printer::MODE_DOUBLE_WIDTH);
                $printer->text("Nveloop Solution.\n");
                
                $printer->selectPrintMode();
                $printer->text("No 195/8, Galle Road, Kaluthara South\n");
                $printer->feed();
////                /* Title of receipt */
                $printer->setEmphasis(true);
                $printer->text("SALES INVOICE - ZV1807-1225\n");
                $printer->setEmphasis(false); 
                $printer->feed();
//                /* Items */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_LEFT);
                $printer->setEmphasis(true);
                $printer->setUnderline(true);
                $printer->setFont(\Escpos\Printer::FONT_B);
                $printer->text(new item('CODE', 'DESC', 'QTY', 'PRICE', 'AMOUNT'));
                $printer->setUnderline(false);
//                $printer->text(new item('', '', '', '', '(Rs.)'));
                $printer->setEmphasis(false);
                foreach ($items as $item) {
                    $printer->text($item);
                }
                
                $printer->setEmphasis(false);
                $printer->setFont(\Escpos\Printer::FONT_B);
                $sub_total = new item( 'SUBTOTAL','','','','488,600.00'); 
                $payment = new item('Cash','','','','200,600.00');
                $payment2 = new item('Card','','','','288,000.00');
                $discount = new item('DISCOUNT','','','','1,000.00');
                
                $printer->setUnderline(true);
                $printer->text(".");
                $printer->feed();
                $printer->text($sub_total);
                $printer->text($payment);
                $printer->text($payment2);
                $printer->text($discount);
                $printer->setEmphasis(false);
                $printer->feed();
                /* Tax and total */
//                $printer->text($tax);
                $printer->selectPrintMode(\Escpos\Printer::MODE_DOUBLE_WIDTH);
                $printer->setUnderline(true);
                $printer->text($total);
                $printer->setUnderline(false);
                $printer->selectPrintMode();
                ;
                $printer->feed();
                $printer->setJustification(\Escpos\Printer::JUSTIFY_RIGHT); 
                $printer->text("Sales Person: Fahry");
                /* Footer */
                $printer->setJustification(\Escpos\Printer::JUSTIFY_CENTER);
                $printer->feed(2);
                $printer->setBarcodeHeight(60);
                $printer->setBarcodeWidth(2);
                $printer->barcode("ZV1807-1225");  
                $printer->feed(2);
                $printer->text("Thank you for shopping at Zone Venture\n");
                $printer->text("For Inquiry, please visit www.zoneventure.com\n");
                $printer->feed(1);
                $printer->text("Return / Exchange Possible within 3 days. \n");
                $printer->text("by Submitting original bill & good with \norigonal condition.");
                $printer->feed(2);
                $printer->text($date . "\n");
                
            $printer -> cut();
                    /* Close printer */
            $printer -> close();
    } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
    } 
    
}

/* A wrapper to do organise item names & prices into columns */
class item
{
    private $code;
    private $name;
    private $qty;
    private $price;
    private $amount;
    private $dollarSign;
    public function __construct($code = '',$name = '',$qty='', $price = '', $amount = '', $dollarSign = false)
    {
        $this->code = $code;
        $this->name = $name;
        $this->qty = $qty;
        $this->price = $price;
        $this->amount = $amount;
        $this->dollarSign = $dollarSign;
    }
    public function __toString()
    { 
        $itemCodeCols = 8;
        $nameCols = 20;
        $qtyCols = 9;
        $priceCols = 11;
        $amountCols = 13;
        if ($this->dollarSign) {//total
            $itemCodeCols = 4;
            $nameCols = 0;
            $qtyCols = 0;
            $priceCols = 0;
            $amountCols = 17;
        }
        $itemCode = str_pad($this->code, $itemCodeCols);
        $name = str_pad($this->name, $nameCols);
        $qty = str_pad($this->qty, $qtyCols);
        $sign = $this->dollarSign ? '' : '';
        $price = str_pad($sign . $this->price, $priceCols, ' ', STR_PAD_LEFT);
        $amount = str_pad($sign . $this->amount, $amountCols, ' ', STR_PAD_LEFT);
        return "{$itemCode}{$name}{$qty}{$price}{$amount}\n";
    }
}
class twoColsItem
{
    private $name;
    private $price;
    private $dollarSign;
    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->dollarSign = $dollarSign;
    }
    public function __toString()
    {
        $rightCols = 29;
        $leftCols = 29;
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);
        $sign = $this->dollarSign ? '$ ' : '';
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "{$left}{$right}\n";
    }
}
class twoColsItemTrans
{
    private $name;
    private $price;
    private $dollarSign;
    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->dollarSign = $dollarSign;
    }
    public function __toString()
    {
        $rightCols = 20;
        $leftCols = 41;
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);
        $sign = $this->dollarSign ? '$ ' : '';
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "{$left}{$right}\n";
    }
}