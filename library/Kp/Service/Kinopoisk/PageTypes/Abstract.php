<?php 
/**
 */
class Kp_Service_Kinopoisk_PageTypes_Abstract
{
    protected $_htmlSource;

	protected function getByParam($paramName)
    {
    	$regexp = "itemprop=\"{$paramName}\"";
    	return $this->getByRegexp($regexp);
    }


    protected function getByRegexp($regexp)
    {
    	$result = '';
    	
    	$regexp = "/<*{$regexp}*>(.+?)<\//";
		if( preg_match($regexp,$this->_htmlSource, $name) )
        {
	        $result = trim($name[1]);
        }
	    return $result;
    }
}
