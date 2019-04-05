<?php

class Sendmail_model extends CI_model{
	
        function  send_mail($to='',$from='',$from_name='',$subject='',$message='',$attathments=''){
            $this->load->library('email'); 

            $this->email->from($from,$from_name)
                        ->reply_to('fahrycc@gmail.com')    // Optional, an account where a human being reads.
                        ->to($to)
                        ->subject($subject)
                        ->message($message);
            if(is_array($attathments)){
                foreach ($attathments as $attathment){
                    $this->email->attach($attathment);
                } 
            }else if($attathments!=''){
                    $this->email->attach($attathments);
            }
            $result = $this->email->send();
            
//
//            var_dump($result);
//            echo '<br />';echo $this->email->print_debugger(); exit;
            return $result;  
//            exit;
        }
}