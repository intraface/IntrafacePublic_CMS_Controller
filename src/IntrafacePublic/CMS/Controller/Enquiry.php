<?php
class IntrafacePublic_CMS_Controller_Enquiry extends IntrafacePublic_CMS_Controller_Index
{
    private $message;
    private $mail_reciever;
    private $mail_bcc;
    
    public function __construct($context, $name, $mail_reciever, $mail_bcc = '') 
    {
        parent::__construct($context, $name);
        $this->mail_reciever = $mail_reciever;
        $this->mail_bcc = $mail_bcc;
    }
    
    public function addSections($sections)
    {
        $sections['enquiry'] = $this->render('IntrafacePublic/CMS/Controller/templates/enquiry-tpl.php', array('message' => $this->message)); 
        return $sections;
    }
    
    public function POST()
    {
    
        $this->POST['name'] = trim($this->POST['name']);
        if($this->POST['name'] == '') {
            $this->message .= 'Du skal udfylde dit navn.<br />';
        }
        $this->POST['company'] = trim($this->POST['company']);
        
        $this->POST['email'] = trim($this->POST['email']);
        if(preg_match('/^([\._a-zA-Z0-9-]{1,}){1}@{1}([\.a-zA-Z0-9-]{1,}){1}\.{1}([a-zA-Z]{1,3}){1}$/', $this->POST['email']) == 0) {
            $this->message .= 'Du skal udfylde en gyldig e-mail adresse.<br />';
        }
        $this->POST['enquiry'] = trim($this->POST['enquiry']);
        if($this->POST['enquiry'] == '') {
            $this->message .= 'Du skal udfylde en besked.<br />';
        }
        
        
        if($this->message == '') {
            $sender = $this->POST['email'];
            
            $subject = 'Fra hjemmesiden';
            $body = $this->POST['name']."\n".$this->POST['company']."\nE-mail: ".$this->POST['email']."\nTelefon: ".$this->POST['phone']."\nhar lavet en forespørgsel:\n".$this->POST['enquiry']."\n\nSendt den ".date('d/m/Y H:i:s');
            $body = wordwrap($body, 70);
            
            if(mail(utf8_decode($this->mail_reciever), utf8_decode($subject), utf8_decode($body), utf8_decode("From: ".$sender."\nBcc:".$this->mail_bcc))) {
                $this->message = 'Din forespørgsel er sendt. Vi vender snarest tilbage. Ha\' en god dag.'; 
                $this->POST = array();
            }
            else {
                $this->message = 'Vi var desværre ikke i stand til at sende forespørgslen. Vær venlig at <a href="/kontakt/">ring</a> til os.';
            }
        }
        
        return $this->GET();
    }
}
?>