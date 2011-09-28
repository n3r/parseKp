<?php 
/**
 * page of film
 */
class Kp_Service_Kinopoisk_PageTypes_Film extends Kp_Service_Kinopoisk_PageTypes_Abstract
{
    protected $_pageUrl = 'http://www.kinopoisk.ru/level/1/film/%id%/';

    protected $_htmlSource;
    protected $_id;

    
    protected $_regEXPes = array(
    	'name'					=> "/<*itemprop=\"name\"*>(.+?)<\//",
    	'alternativeHeadline'	=> "/<*itemprop=\"alternativeHeadline\"*>(.+?)<\//",
    );

    function __construct($id)
    {
        $this->_id = (int) $id;
        $this->_pageUrl = str_replace('%id%', $this->_id, $this->_pageUrl);
    }

    public function getUrl()
    {
        return $this->_pageUrl;
    }


    public function setHtmlSource($html)
    {
        $this->_htmlSource = $html;
    }

    public function getParams()
    {
    	$result = array(
    		'name' 					=> $this->getByParam('name'),
    		'alternativeHeadline' 	=> $this->getByParam('alternativeHeadline'),
    		'description' 			=> $this->getByParam('description'),
    		'year'					=> $this->getYear(),
    		'kp_rating'				=> $this->getKpRating(),
    		'getGenres'				=> $this->getGenres(),
    		'getCountries'			=> $this->getCountries(),
    		'getPremierDate'		=> $this->getPremierDate(),
    		'getPremierDateRus'		=> $this->getPremierDateRus(),
    	    'getAvatars'			=> $this->getAvatars()
    	);
    	return $result;
    }

    public function getYear()
    {
    	$result = '';
     	if( preg_match('/m_act%5Byear%5D\/\d{4}\/\">/', $this->_htmlSource, $year) ) {
     		$result = $year[1];
     	};
        return $result;
    }

    public function getKpRating()
    {
    	$result = '';
        if( preg_match('/ text-decoration: none\">(.+?)<span style/is', $this->_htmlSource, $rat) ){
        	$result = $rat[1];
        }
		return $result;
    }

    public function getGenres()
    {
    	$result = array();

    	if( preg_match_all('/m_act%5Bgenre%5D(.+?)<\/a>/is', $this->_htmlSource, $rowgenre) ){
    	        foreach($rowgenre[0] as $g){
                    
    	        	if(preg_match('/\/\">(.+?)<\/a>/is', $g, $genres)){
	    	        	preg_match('/m_act%5Bgenre%5D\/(.+?)\//is', $g, $idgenres);
	                    $result[] = array(
	                            'genre_kp_name' => $genres[1],
	                            'genre_kp_id'   => $idgenres[1]
	                    );
    	        	}
                }
    	}

        return $result;        
    }


    public function getCountries()
    {
        $result = array();
        if(isset(preg_match_all('/m_act%5Bcountry%5D\/(.+?)<\/a>/is', $this->_htmlSource, $rowgenre))){
            foreach($rowgenre[0] as $g){
                if( !preg_match('/<img(.+?)>/is', $g, $is_img) 
					&& preg_match('/\/\">(.+?)<\/a>/is', $g, $namecountry)
                	&& preg_match('/m_act%5Bcountry%5D\/(.+?)\//is', $g, $idcountry)
                	){
						$result[] = array(
							'country_kp_id'   => $idcountry[1],
							'country_kp_name' => $namecountry[1]
	                    );
					}
        	}
        }
        return $result;
    }


    public function getPremierDate()
    {
        preg_match('/премьера \(мир\)(.+?)<\/a>/is', $this->_htmlSource, $rdate);
        if(isset($rdate[1])){
            preg_match('/<a(.+?)<\/a>/is', $rdate[0], $row);
            preg_match('/\">(.+?)<\/a>/is', $row[0], $date);
            return (isset($date[1])) ? $date[1] : ""; 
        }
        return "";
    }

    public function getPremierDateRus()
    {
        if( preg_match('/премьера \(РФ\)(.+?)<\/a>/is', $this->_htmlSource, $rdate) ){
            if(preg_match('/\'>(.+?)<\/a>/is', $rdate[0], $date)) {
            	return $date[1];
            }
        }
    }
    

    public function getAvatars()
    {
        $result = array();
        $result[] = 'http://www.kinopoisk.ru/level/17/film/'.$this->_id;
        $result[] = 'http://www.kinopoisk.ru/level/13/film/'.$this->_id;
        return $result;
    }
}
