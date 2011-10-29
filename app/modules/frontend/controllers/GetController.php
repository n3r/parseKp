<?php
/**
 * 
 */
class GetController extends Zend_Controller_Action
{
    
    public function filmAction()
    {

        $id = (int) $this->getRequest()->getParam('id');
        if($id > 0){
            $model = new Kp_Service_Kinopoisk();
            $film = $model->getFilmById($id);
            echo '<!doctype html> <head></head><body>';
                Zend_Debug::dump($film);
            echo '</body></html>';
        }
        die;
        //echo '<html>';
        
    }
}