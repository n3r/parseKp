<?php
/**
 *
 */
class AjaxController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->_helper->layout->disableLayout();
    }

    public function getbyidAction()
    {
        $id = $this->getRequest()->getParam('id');
        $kinopoisk = new Kp_Service_Kinopoisk();

        $this->view->film = $kinopoisk->getById($id);
        
    }
}
