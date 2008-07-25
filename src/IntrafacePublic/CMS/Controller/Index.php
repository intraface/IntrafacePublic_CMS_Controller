<?php
class IntrafacePublic_CMS_Controller_Index extends k_Controller
{
    private $identifier = '';

    function GET()
    {
        $client = $this->registry->get('cms');
        $page = $client->getPage($this->identifier);

        if (!empty($page['http_header_status']) AND $page['http_header_status'] == 'HTTP/1.0 404 Not Found') {
            throw new k_http_Response(404);
        }

        $html = new IntrafacePublic_CMS_HTML_Parser($page);
        $content = $html->getSection('content');

        $this->document->title = $page['title'];
        $this->document->style = $page['css'];
        $this->document->keywords = $page['keywords'];
        $this->document->description = $page['description'];
        $this->document->navigation = $page['navigation_toplevel'];
        if (!empty($page['navigation_sublevel'])) {
            $this->document->subnavigation = $page['navigation_sublevel'];
        } else {
            $this->document->subnavigation = '';
        }

        if (empty($content['html'])) {
            throw new Exception('no html section in the content');
        }

        return $content['html'];
    }

    function forward($name)
    {
        $this->identifier = $name;
        return $this->GET();
    }
}