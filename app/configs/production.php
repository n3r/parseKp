<?php

$config = array(
    'phpSettings' => array(
        'display_startup_errors' => 0,
        'display_errors'         => 0
    ),
    'bootstrap' => array(
        'path'  => APPLICATION_PATH . '/Bootstrap.php',
        'class' => 'Bootstrap'
    ),
    'autoloaderNamespaces' => array(
        'core' => 'Kp_'
    ),
    'resources' => array(
        'frontController' => array(
            'moduleDirectory'       => APPLICATION_PATH . '/modules',
            'defaultModule'         => 'frontend'
        ),
        'layout' => array(
            'layoutPath' => '/layouts',
        ),
        'router' => array(
            'routes' => array(
                'index' => array(
                    'type'     => 'Zend_Controller_Router_Route_Static',
                    'route'    => APPLICATION_PATH . '/modules',
                    'defaults' => array(
                        'module'     => 'frontend',
                        'controller' => 'index',
                        'action'     => 'index'
                    )
                )
            )
        ),
        'db' => array(
            'adapter' => 'mysqli',
            'params' => array(
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'kp_parser',
                'charset'  => 'utf8'
            )
        ),
        'session' => array(
            'name'                => 'SPSID',
            'use_cookies'         => 1,
            'cookie_lifetime'     => 0,
            'cookie_httponly'     => 1
        )
    ),
    'kinopoisk' => array(
        'username' => 'tester',
        'password' => 'tester'
    )
);

return $config;
