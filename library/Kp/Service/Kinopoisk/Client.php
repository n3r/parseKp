<?php 
/**
 * kinopoisk parser
 * page for one film
 */
class Kp_Service_Kinopoisk_Client extends Zend_Http_Client
{
    function __construct($username = null, $password = null)
    {
        parent::__construct();
        
        //magic headers for kinopoisk
        $this->setHeaders("Host", "www.kinopoisk.ru:80");
        $this->setHeaders("Accept", "image/gif, image/x-xbitmap, image/jpeg, image/pjpeg");

        $config['maxredirects'] = 5;
        $config['timeout']      = 300;
        $config['useragent']    = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7 FirePHP/0.4';
        $this->setConfig($config);
    }

    /**
     * @todo check uri
     */
    public function getHtmlPage($uri)
    {
        try{
            $this->setUri($uri);
            $result = $this->request()->getBody();
            //@todo short tags.            
            return $this->clearHtml($result); 
        }
        catch (Exception $e){
        }
    }

    protected function clearHtml($html)
    {
        $html = iconv('cp1251', 'utf-8', $html);
        $html = str_replace(array('&nbsp;', '\n', '<br />', '<br>'), ' ', $html);
        //todo: clean scripts, styles, comments.

        return $html;
    }

}
