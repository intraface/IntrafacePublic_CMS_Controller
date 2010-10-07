<?php
class IntrafacePublic_CMS_Controller_Enquiry extends IntrafacePublic_CMS_Controller_Index
{
    private $message;
    private $mail_reciever;
    private $mail_bcc;

    // @todo We need another way to get the mail_receiver and $mail_bcc into this
    //       Should just be done with the constructor and having some of the message
    //       created in the factory

    public function addSections($sections)
    {
        $tpl = $this->template->create('IntrafacePublic/CMS/Controller/templates/enquiry');
        $sections['enquiry'] = $this->render($this, array('message' => $this->message));
        return $sections;
    }

    // @todo refactor this method - and make translation possible
    public function postForm()
    {
        $this->POST['name'] = trim($this->POST['name']);
        if ($this->POST['name'] == '') {
            $this->message .= 'Du skal udfylde dit navn.<br />';
        }
        $this->POST['company'] = trim($this->POST['company']);

        $this->POST['email'] = trim($this->POST['email']);
        if (preg_match('/^([\._a-zA-Z0-9-]{1,}){1}@{1}([\.a-zA-Z0-9-]{1,}){1}\.{1}([a-zA-Z]{1,3}){1}$/', $this->POST['email']) == 0) {
            $this->message .= 'Du skal udfylde en gyldig e-mail adresse.<br />';
        }
        $this->POST['enquiry'] = trim($this->POST['enquiry']);
        if ($this->POST['enquiry'] == '') {
            $this->message .= 'Du skal udfylde en besked.<br />';
        }

        if ($this->message == '') {
            $sender = $this->POST['email'];

            $subject = 'Fra hjemmesiden';
            $body = $this->POST['name']."\n".$this->POST['company']."\nE-mail: ".$this->POST['email']."\nTelefon: ".$this->POST['phone']."\nhar lavet en foresp�rgsel:\n".$this->POST['enquiry']."\n\nSendt den ".date('d/m/Y H:i:s');
            $body = wordwrap($body, 70);

            if (mail($this->mail_reciever, $subject, $body, "From: ".$sender."\nBcc:".$this->mail_bcc)) {
                $this->message = 'Din foresp�rgsel er sendt. Vi vender snarest tilbage. Ha\' en god dag.';
                $this->POST = array();
            } else {
                $this->message = 'Vi var desv�rre ikke i stand til at sende foresp�rgslen. V�r venlig at <a href="/kontakt/">ring</a> til os.';
            }
        }

        return $this->render();
    }
}
