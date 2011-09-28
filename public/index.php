<?php
defined('APPLICATION_ROOT')
    || define('APPLICATION_ROOT', realpath(__DIR__ . '/../'));

require_once APPLICATION_ROOT . '/app/Init.php';
require_once 'Zend/Application.php';



$application = new Zend_Application(APPLICATION_ENV);
$config = include APPLICATION_PATH . '/configs/' . APPLICATION_ENV . '.php';
$application->setOptions($config);

try{
    $application->bootstrap()
            ->run();
}  catch (Exception $e){
    Zend_Debug::dump($e->getMessage());
    Zend_Debug::dump($e->getTraceAsString());
    die;
}
