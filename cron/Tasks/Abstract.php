<?php

abstract class Task_Abstract
{
    protected $_name;
    protected $_db;

    public function  __construct()
    {
        $this->_db = Zend_Db_Table::getDefaultAdapter();
    }

    public function changeTime($time)
    {
        return $this->_db->update('cron', array('task_time' => $time),
                                          array('task_name = ?' => $this->_name));
    }

    abstract public function direct();

    abstract protected function action();

    //logs
    protected function _log($message)
    {
	//@todo move log dir to log file
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/log/cron_log_'.$this->_name.'.log');
        $logger = new Zend_Log($writer);

        echo $message;
        $logger->info($message . "\n");
        return;
    }


    //errors with cron
    protected function _error($message)
    {
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/log/cron_ERROR_'.$this->_name.'.log');
        $logger = new Zend_Log($writer);

        echo $message;
        $logger->info($message . "\n");
        return;
    }


}
