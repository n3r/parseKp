<?php 
/**
 * kinopoisk parser
 *
 */
class Kp_Service_Kinopoisk
{
    protected $_username;
    protected $_password;

    protected $_time;

    protected $_httpClient;

    public function __construct($username = null, $password = null)
    {
        $this->_time = microtime(true);
        $this->_httpClient = new Kp_Service_Kinopoisk_Client($username, $password);
        //parent::__construct();
    }


    /**
     *
     */
    public function getById($id)
    {
        $result = array();

        $page = new Kp_Service_Kinopoisk_PageTypes_Film($id);

        $html = $this->_httpClient->getHtmlPage($page->getUrl());

$result['time_request'] = microtime(true) - $this->_time;

		$page->setHtmlSource($html);

		$params = $page->getParams();

        $result['time_parse'] = microtime(true) - $this->_time - $result['time_request'];
        $result['time_all'] = microtime(true) - $this->_time;

        Zend_Debug::dump(array_merge($result,$params));
    }
}
