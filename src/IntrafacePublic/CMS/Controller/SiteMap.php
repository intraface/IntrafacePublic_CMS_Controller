<?php

class IntrafacePublic_CMS_Controller_SiteMap extends IntrafacePublic_CMS_Controller_Index
{
    
    
    public function getCMS()
    {
        return $this->context->getCMS();
    }
    
    public function addSections($sections)
    {
        $client = $this->getCMS();
        
        if(isset($this->GET['update'])) {
            $client->clearPageListCache(array('type' => 'page'));
            $client->clearPageListCache(array('type' => 'article'));
            $client->clearPageListCache(array('type' => 'news'));
        }
        $areas['pages'] = $client->getPageList(array('type' => 'page'));
        $areas['articles'] = $client->getPageList(array('type' => 'article'));
        $areas['news'] = $client->getPageList(array('type' => 'news'));
        
        $sitemap = '';
        foreach($areas AS $area => $pages) {
            if(is_array($pages) && count($pages) > 0) {
                $sitemap .= '<h2>'.ucfirst($area).'</h2><ul id="sitemap">';
                $level = 0;
                foreach($pages AS $page) {
                    if(intval($page['level']) > $level) {
                        $sitemap .= '<ul>';
                    } elseif (intval($page['level']) < $level) {
                        $sitemap .= '</ul>';
                    }
                    
                    $sitemap .= '<li><a href="'.$page['url'].'">'.$page['navigation_name'].'</a></li>';
                    $level = $page['level'];
                }
                $sitemap .= '</ul>';
            }
        }
        
        $sections['sitemap'] = $this->render('IntrafacePublic/CMS/Controller/templates/sitemap-tpl.php', array('sitemap' => $sitemap));
        return $sections;
    }
}
