<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');ob_start();
class Backup extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->dbutil();
		$this->load->database(); 
		$this->load->library('session');
		$this->load->model('Sendmail_model'); 
	}
	
    
    function index(){
        
//	  $this->send_backup();
//          die;
        $data['action']		= 'Add';
        $data['main_content'] = 'backup/get_backup';  
        $this->load->view('includes/template',$data);
//        $url = $this->backup_folder(); 
//       echo base_url($url); 
// redirect(base_url($url));
	  // $this->delete_temp_password(); // remove older than 7 days
//	  $this->send_backup();
      // $this->genmail();// send reminder mails
      // $this->send_wrng_message();// send reminder mails
    }
	
	function backup_db($redirect=1){
		if(!$this->dbutil->database_exists($this->db->database)){
			 echo "Database does not exist..";
		}
		else{
		$file_name='db_backup_'.$this->db->database.'-'.date("YmdHis", time());
			
		$prefs = array( 
                'ignore'      => array(),
                'format'      => 'zip',   
                'filename'    => 'db_backup.zip',  
                'add_drop'    => TRUE,            
                'add_insert'  => TRUE,        
                'newline'     => "\n"      
              );

		$backup = $this->dbutil->backup($prefs);	
			
		// Load the file helper and write the file to your server
		$this->load->helper('file');
                if(write_file(DB_BACKUPS.$file_name.'.zip', $backup)){
                    add_system_log('', $this->router->fetch_class(), __FUNCTION__, '');
                }
		
//		return DB_BACKUPS.$file_name.'.zip';
                if($redirect==1){
                    redirect(base_url( DB_BACKUPS.$file_name.'.zip'));
                }else{  
                    return './'.DB_BACKUPS.'/'.$file_name.'.zip';
                }
		
	}
}
	
	 
	function backup_folder(){
	 
		$zip = new ZipArchive();
                $file_name = FILE_BACKUPS.'/Lab_system_Backup_'.date('Y-m-d_H-i-s').'.zip';
                $zip->open($file_name, ZipArchive::CREATE);
		$dirName = FILE_BACKUP_SOURCE;

		if (!is_dir($dirName)) {
			throw new Exception('Directory ' . $dirName . ' does not exist');
				}

					$dirName = realpath($dirName);
					if (substr($dirName, -1) != '/') {
					$dirName.= '/';
				}

			$dirStack = array($dirName);
			//Find the index where the last dir starts
			$cutFrom = strrpos(substr($dirName, 0, -1), '/')+1;

			while (!empty($dirStack)) {
			$currentDir = array_pop($dirStack);
			$filesToAdd = array();

			$dir = dir($currentDir);
			while (false !== ($node = $dir->read())) {
				if (($node == '..') || ($node == '.')) {
				continue;
				}
				if (is_dir($currentDir . $node)) {
				array_push($dirStack, $currentDir . $node . '/');
				}
				if (is_file($currentDir . $node)) {
				$filesToAdd[] = $node;
				}
		}

			$localDir = substr($currentDir, $cutFrom);
			$zip->addEmptyDir($localDir);

			foreach ($filesToAdd as $file) {
			$zip->addFile($currentDir . $file, $localDir . $file);
			}
		}
		$zip->close();
			  
//		$backup_file = FILE_BACKUPS.'/PAS_Backup_'.date('Y-m-d_H-i-s').'.zip';
		
		redirect(base_url( $file_name));
//		return $file_name;
	}
	
	 
	function send_backup(){
//            echo '<pre>';            print_r($this->session->userdata(SYSTEM_CODE)); die;
		$attathments[0] = $this->backup_db(0);
//		$attathments[1] = $this->backup_folder();
		 
		$to         = 'fahrylafir@gmail.com'; // backups to 
		$from 		= 'noreply@nveloop.com';
		$from_name 	= 'Current User : '.$this->session->userdata(SYSTEM_CODE)['user_name'];
		$subject 	= 'NVELOOP MySQL Database Backup  Backup('.date('Y-m-d_H-i-s').')'; 
				
		$message    = '<table width="100%" border="0">
						<br>
						<tr>
						<td width="7%">&nbsp;</td>
						<td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Please find attached Database backup file and Folder backup file generated  at '.date('Y-m-d H:i').'</td>
						</tr>
						<tr>
						<td width="7%">&nbsp;</td>
						<td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">&nbsp;</td>
						</tr>
					
						
						<tr>
						<td width="7%">&nbsp;</td>
						<td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
						</tr>
						<tr>
						<td width="7%">&nbsp;</td>
						<td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Best Regards</td>
						</tr>
							
						<tr>
						<td width="7%">&nbsp;</td>
						<td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Nveloop Admin</td>
						</tr>
						<td width="7%">&nbsp;</td>
						<td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
						</tr>
						<tr>
						<td width="7%">&nbsp;</td>
						<td colspan="2" style="font:Verdana; color:#A8A8A8;">Please note that this is an automatd email from the Nveloop Gem Merchant Software.</td>
						</tr>
			</table>';
			// echo $message; die;
		if($this->Sendmail_model->send_mail($to,$from,$from_name,$subject,$message,$attathments)){
//			echo 'Database and Folder Backups Email Sent Successflly <br>';
                        return true;;
		}else{
//			echo "error sending backup email..<br>";
                        return false;
		}
	}
	 
	 
	
	function test(){
		echo 'okokoko';
		}
}
?>