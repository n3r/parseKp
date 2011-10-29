<?php 
/**
 */
class Kp_Service_Kinopoisk_Pages_Abstract
{
    protected $_htmlSource;
    protected $_id;
    protected $_url;

    /**
     * file with content for dev mode.
     * @var string
     */
    protected $_devFile;

    protected $_params;

    function __construct($id)
    {
        $this->_id = (int) $id;
        $this->_url = str_replace('%id%', $this->_id, $this->_url);
    }

    public function getParams()
    {
        foreach($this->_params as $name => &$item){
            $method = 'get' . ucfirst($name);
            try {
                if(method_exists($this, $method)){
                    $item['value'] = $this->{$method}();
                }
            } catch (Exception $e) {
                //@todo: save to log
            }
        }
        return $this->_params;
    }

    public function getDevFile()
    {
        if(!empty($this->_devFile)){
            $file = APPLICATION_ROOT . '/_files/html/' . $this->_devFile;
            if(is_file($file)){
                return $file;
            }
        }
        return false;
    }
    
    
    public function getUrl()
    {
        return $this->_url;
    }

    public function setHtmlSource($html)
    {
        $this->_htmlSource = $html;
    }
}