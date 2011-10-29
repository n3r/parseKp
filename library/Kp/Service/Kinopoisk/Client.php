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

        //@todo: use login/pass for kinopoisk

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

    /**
     * 
     */
    protected function clearHtml($html)
    {
        $html = iconv('cp1251', 'utf-8', $html);

        $search = array('&nbsp;', '<br />', '<br>', '  ', "\r");
        if(!Kp_Service_Kinopoisk::IS_DEVELOPMENT){
            $search += array("\n");
        }

        $html = str_replace($search, ' ', $html);
        //todo: clean scripts, styles, comments.

        return $html;
    }

}
