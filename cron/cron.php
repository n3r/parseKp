<?php

defined('APPLICATION_PATH')
    ||define('APPLICATION_PATH',realpath(dirname(__FILE__).'/../application'));
defined('LIBRARY_PATH') ||
    define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../library/zend_1.10'));
defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', realpath(dirname(__FILE__)));
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', 'development');
// Setup inlude path
set_include_path(LIBRARY_PATH);
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$application = new Zend_Application(APPLICATION_ENV);

$resource = new Zend_Loader_Autoloader_Resource(array('basePath' => PUBLIC_PATH, 'namespace' => ''));
$resource->addResourceType('task', 'Tasks', 'Task');

$config = include  APPLICATION_PATH . '/configs/' . APPLICATION_ENV . '.php';
$db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
Zend_Db_Table::setDefaultAdapter($db);

$time = time();
$select = $db->select()
             ->from('cron',array('task_name'))
             ->where('task_enable = "1"')
             ->where("task_time <= {$time}");
$tasks = $db->fetchAll($select);
foreach ($tasks as $task) {
    $task = 'Task_' . $task['task_name'];
    $taskObject = new $task();
    $taskObject->direct();
}
