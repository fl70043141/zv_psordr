<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');ob_start();
class Logout extends CI_controller
{
	function index()
	{	
		$this->session->sess_destroy();
		redirect('');
	}
	
}


?>