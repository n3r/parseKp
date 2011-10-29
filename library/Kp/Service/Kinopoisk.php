<?php 
/**
 * kinopoisk parser
 *
 */
class Kp_Service_Kinopoisk
{
    /**
     * is development mode
     * 
     * @var bool
     */
    const IS_DEVELOPMENT = true;

    protected $_username;
    protected $_password;

    //@todo timers
    //protected $_time;

    protected $_httpClient;
    
    
    public function __construct($username = null, $password = null)
    {
        $this->_httpClient = new Kp_Service_Kinopoisk_Client($username, $password);
    }


    /**
     *
     */
    public function getFilmById($id)
    {
        $result = array();
        //@todo: make as protected var
        $availablePages = array(
            'Main'
        );

        foreach($availablePages as $page){
            $class = 'Kp_Service_Kinopoisk_Pages_Film_' . $page;
            $page = new $class($id);

            if(self::IS_DEVELOPMENT && $devFile = $page->getDevFile()){
                $html = file_get_contents($devFile);
                $html = iconv('cp1251', 'utf-8', $html);
            } else {
                $html = $this->_httpClient->getHtmlPage( $page->getUrl() );
            }

            $page->setHtmlSource($html);
            $result = array_merge($result, $page->getParams());
        }

        return $result;
    }
}
