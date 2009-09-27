<?php
class IntrafacePublic_CMS_Controller_Index extends k_Controller
{
    
    public function getCMS()
    {
        return $this->context->getCMS();
    }
    
    public function getPathToTemplate($template)
    {
        return $this->context->getPathToTemplate($template);
    }
    
    /**
     * Funktion which makes it possible to extend from this controller and overwrite
     * this function to add sections to the template. 
     * IntrafacePublic_CMS_Controller_Enquiry uses this function.
     *  
     * @return array with extra sections.
     */
    protected function addSections($sections)
    {
        return $sections;
    } 

    function GET()
    {
        $client = $this->getCMS();

        if(isset($this->GET['update'])) {
            $client->clearPageCache($this->name);
        }
        
        $page = $client->getPage($this->name);

        if (!empty($page['http_header_status']) AND $page['http_header_status'] == 'HTTP/1.0 404 Not Found') {
            throw new k_http_Response(404);
        }

        $html = new IntrafacePublic_CMS_HTML_Parser($page);
        $this->document->title = $page['title'];
        $this->document->style = $page['css'];
        $this->document->keywords = $page['keywords'];
        $this->document->description = $page['description'];
        $this->document->navigation['html'] = $html->parseNavigation();
        $this->document->navigation['toplevel'] = $page['navigation_toplevel'];
        if (!empty($page['navigation_sublevel'])) {
            $this->document->navigation['sublevel'] = $page['navigation_sublevel'];
        } else {
            $this->document->navigation['sublevel'] = array();
        }
        
        $sections = $html->getSections();
        $sections = $this->addSections($sections);
        return $this->render($this->getPathToTemplate($page['template_identifier'].'-tpl.php'), $sections);
    }
    
    /*
    function forward($name)
    {
        $this->name = $name;
        return $this->GET();
    }*/
}