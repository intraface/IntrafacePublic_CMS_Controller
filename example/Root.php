<?php
class Root extends k_Dispatcher
{
    public function __construct()
    {
        parent::__construct();
        $this->document->template = 'main.tpl.php';
        $this->document->title = 'Titel';
        $this->document->keywords = '';
        $this->document->description = '';
    }

    public function execute()
    {
        return $this->forward('frontpage');
    }

    public function getCMS()
    {
        return $this->registry->get('cms');
    }
    
    public function getPathToTemplate($template)
    {
        return ''.$template;
    }
    
    public function forward($name)
    {
        if($name == 'enquiry') {
            $next = new IntrafacePublic_CMS_Controller_Enquiry($this, $name, 'mail@to.dk', 'mail@bcc.dk');
        } elseif($name == 'sitemap') {
            $next = new IntrafacePublic_CMS_Controller_SiteMap($this, $name);
        } else {
            $next = new IntrafacePublic_CMS_Controller_Index($this, $name);
        }
        
        return $next->handleRequest();
    }
}
