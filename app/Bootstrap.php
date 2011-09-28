<?php

/**
 * bootstrap
 *
 * @category   portal
 * @package    Bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfigs()
    {
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('Portal_Config', $config);
        return $config;
    }

    protected function _initPluginAutoload()
    {
        $loader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH
        ));

        return $loader;
    }

    protected function _initViewResource()
    {
        $config = $this->getOption('site');

        // utf-8 support
        if (function_exists('iconv')) {
            iconv_set_encoding('internal_encoding', 'UTF-8');
            iconv_set_encoding('input_encoding', 'UTF-8');
            iconv_set_encoding('output_encoding', 'UTF-8');
        }
        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding('UTF-8');
        }

        // init view
        $view = new Zend_View(array('encoding' => 'UTF-8'));
        $view->setBasePath($config['path'] . '/views')
             ->addHelperPath(APPLICATION_PATH . '/views/helpers', 'View_Helper');

        // helpers
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('kp parser') //move to config
             ->setSeparator(' >> ');

        // init view renderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        Zend_Registry::set('Portal_View', $view);

        return $view;
    }

    protected function _initSiteBootstrap()
    {
        $config = $this->getOption('site');
        $bootstrapClass = $this->_formatModuleName($config['name']) . '_Bootstrap';
        $bootstrapPath = $config['path'] . '/Bootstrap.php';
        $siteBootstrap = null;
        if (file_exists($bootstrapPath)) {
            include_once $bootstrapPath;
            if (class_exists($bootstrapClass, false)) {
                $siteBootstrap = new $bootstrapClass($this);
                $siteBootstrap->bootstrap();
            }
        }

        Zend_Session::setOptions(array('cookie_domain'=> '.'.$config['host']));

        return $siteBootstrap;
    }

    /**
    * Enable FirePHP console in not production mode
    *
    * @return void
    */
    protected function _initFirebug()
    {
        if ('production' === APPLICATION_ENV) {
            return false;
        }
        // bootstrap DB
        if (!$this->hasResource('db')) {
            $this->bootstrap('db');
        }
        // init db profiler for firebug
        if (($db = Zend_Db_Table::getDefaultAdapter()) instanceof Zend_Db_Adapter_Abstract) {
            $profiler = new Zend_Db_Profiler_Firebug('Db Profiler');
            $profiler->setEnabled(true);
            $db->setProfiler($profiler);
        }
        return $profiler;
    }

    /**
     * Format a module name to the module class prefix
     *
     * @param  string $name
     * @return string
     */
    protected function _formatModuleName($name)
    {
        $name = strtolower($name);
        $name = str_replace(array('-', '.'), ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name;
    }
}
