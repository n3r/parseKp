<?php 
/**
 * main page of film
 * @link http://www.kinopoisk.ru/level/1/film/
 * 
 */
class Kp_Service_Kinopoisk_Pages_Film_Premier
        extends Kp_Service_Kinopoisk_Pages_Abstract
        //implements Kp_Service_Kinopoisk_Pages_Interface
{
    protected $_url = 'http://www.kinopoisk.ru/level/80/film/%id%/';

    /**
     * file with content for dev mode.
     * @var string
     */
    protected $_devFile = 'film-premier.html';

    protected $_htmlSource;
    protected $_id;

    protected $_params = array(
    	'premier-views' => array(
            'description'	=> 'Название',
            'value'			=> array()
//    array(
//        'countryId' => array(
//            'premier' => '10 сентября 2001',
//            'views'   => '13444248',    //человек
//        ),
//        ...
        )
    );


    /**
     * +
     */
    public function getName()
    {
        $result = '';
        // <h1 style="margin: 0; padding: 0" class="moviename-big" itemprop="name">Аватар </h1>
        if( preg_match('/itemprop=\"name\">(.+?) <\/h1>/', $this->_htmlSource, $name) ) {
     		$result = $name[1];
     	}

        return $result;
    }

    
    /**
     * +
     */
    public function getAlt_name()
    {
        $result = '';
        // <span style="color: #666; font-size: 13px" itemprop="alternativeHeadline">Battle for Terra</span>
        if( preg_match('/itemprop=\"alternativeHeadline\">(.+?)<\/span>/', $this->_htmlSource, $name) ) {
     		$result = $name[1];
     	}

     	return $result;
    }


    /**
     * +
     */
    public function getYear()
    {
        $result = '';

        // a href="/level/10/m_act%5Byear%5D/2009/" title=""
        if( preg_match('/m_act%5Byear%5D\/(\d{4})\/\"/', $this->_htmlSource, $year) ) {
     		$result = $year[1];
     	};
        return $result;
    }

    /**
     * +
     */
    public function getCountries()
    {
        $result = array();
        if(preg_match_all('/m_act%5Bcountry%5D\/(\d{1,2})\/\" >/', $this->_htmlSource, $row)){
            foreach($row[1] as $countryId){
                $result[$countryId] = $countryId;
            }
        }
        return $result;
    }

    
    /**
     * +
     */
    public function getSlogan()
    {
        $result = '';

        //<tr><td class="type">слоган</td><td style="color: #555">«They are coming»</td></tr>
        if( preg_match('/style="color: #555">&laquo;(.+?)&raquo;<\/td>/', $this->_htmlSource, $name) ) {
     		$result = $name[1];
     	}
     	return $result;
    }

    /**
     * +
     */
    public function getDescription()
    {
        $result = '';

        //itemprop="description">blablabla</div>
        if( preg_match('/itemprop="description">(.+?)<\/div>/', $this->_htmlSource, $name) ) {
     		$result = $name[1];
     	}
        return $result;
    }

    
    /**
     * +
     */
    public function getKp_rating()
    {
    	$result = '';
    	// text-decoration: none"><span>8.082</span><span style="font:100
        if( preg_match('/ text-decoration: none\"><span>(.+?)<\/span><span style/', $this->_htmlSource, $rat) ){
        	$result = $rat[1];
        }

		return (float) $result;
    }


    /**
     * +
     */
    public function getKp_rating_count()
    {
        $result = '';

        //ratingCount
        if( preg_match('/itemprop="ratingCount"> ([\d\s]+)<\/span>/', $this->_htmlSource, $name) ) {
     		$result = (int) str_replace(' ', '', $name[1]);
     	}
        return $result;
    }


    /**
     * +
     */
    public function getImdb_rating()
    {
    	$result = '';
    	//<div style="color:#999;font:100 11px tahoma, verdana">IMDb: 8.10 (358 081)</div>
    	if( preg_match('/>IMDb: (.+?) \(/', $this->_htmlSource, $rat) ){
        	$result = (float) $rat[1];
        }

		return $result;
    }


    /**
     * +
     */
    public function getImdb_rating_count()
    {
        $result = '';

    	//<div style="color:#999;font:100 11px tahoma, verdana">IMDb: 8.10 (358 081)</div>
        if( preg_match('/>IMDb: \d\.\d{2} \(([\d\s]+)\)/', $this->_htmlSource, $rat) ) {
     		$result = (int) str_replace(' ', '', $rat[1]);
     	}
        return $result;
    }


    /**
     * +
     */
    public function getCritic_rating()
    {
    	$result = '';
    	
//        <p class="perc">
//         <span class="perc">83%</span>
//         <span class="reviews_num">280</span>
//         <i><span class="plus">233</span> <span class="minus">47</span> <span class="star">7.4</span></i>
//      </p>

    	if( preg_match('/<span class="perc">(\d{2})\%<\/span>/', $this->_htmlSource, $rat) ){
        	$result = (int) $rat[1];
        }

		return $result;
    }


    /**
     * +
     */
    public function getCritic_rating_count()
    {
        $result = '';

//        <p class="perc">
//         <span class="perc">83%</span>
//         <span class="reviews_num">280</span>
//         <i><span class="plus">233</span> <span class="minus">47</span> <span class="star">7.4</span></i>
//      </p>

        if( preg_match('/<span class="reviews_num">(\d+)<\/span>/', $this->_htmlSource, $rat) ){
        	$result = (int) $rat[1];
        }

        return $result;
    }

    
    /**
     * +
     */
    public function getMpaa()
    {
        $result = '';

        //<a href="/level/38/film/251733/rn/PG-13/">
        if( preg_match('/level\/38\/film\/\d+\/rn\/(.+?)\//', $this->_htmlSource, $rat) ){
        	$result = $rat[1];
        }

        return $result;
    }


    /**
     * +
     */
    public function getLongtime()
    {
        $result = '';

        //<td class="time" id="runtime">85 мин.</td>
        if( preg_match('/<td class="time" id="runtime">(.+?) мин.<\/td>/', $this->_htmlSource, $rat) ){
        	$result = $rat[1];
        }

        return $result;
    }


    /**
     * +
     * @return array of digits
     */
    public function getGenres()
    {
    	$result = array();

    	preg_match_all('/m_act%5Bgenre%5D(.+?)<\/a>/is', $this->_htmlSource, $rowgenre);
    	if( preg_match_all('/m_act%5Bgenre%5D(.+?)<\/a>/is', $this->_htmlSource, $rowgenre) ){
	        foreach($rowgenre[1] as $g){
	            if(preg_match('/^\/(\d{1,2})\//', $g, $idgenres) && $idgenres[1] > 0){
    	        	$result[ (int) $idgenres[1] ] = (int) $idgenres[1];
	        	}
            }
    	}
        return $result;        
    }


    /**
     * +
     * @return str
     */
    public function getAvatar()
    {
        //<img style="border: none; border-left: 10px #f60 solid" src="http://st.kinopoisk.ru/images/film/251733.jpg" alt="Аватар (Avatar)" itemprop="image">
        return 'http://st.kinopoisk.ru/images/film/' . $this->_id . '.jpg';
    }
}