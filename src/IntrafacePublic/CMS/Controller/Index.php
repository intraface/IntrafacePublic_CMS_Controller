<?php
class IntrafacePublic_CMS_Controller_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $client = $this->getCMS();

        if ($this->query('update')) {
            $client->clearPageCache($this->name());
        }

        $page = $client->getPage($this->name());

        if (!empty($page['http_header_status']) AND $page['http_header_status'] == 'HTTP/1.0 404 Not Found') {
            throw new k_PageNotFound();
        }

        $html = new IntrafacePublic_CMS_HTML_Parser($page);
        $this->document->setTitle($this->modifyTitle($page['title']));
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
        $tpl = $this->template->create($this->getPathToTemplate($page['template_identifier']));
        return $tpl->render($this, $sections);
    }

    public function getCMS()
    {
        return $this->context->getCMS();
    }

    public function getPathToTemplate($template)
    {
        return $this->context->getPathToTemplate($template);
    }

    private function modifyTitle($title)
    {
        if (is_callable(array($this->context, 'modifyTitle'))) {
            return $this->context->modifyTitle($title);
        }

        return $title;
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
}