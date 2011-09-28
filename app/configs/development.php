<?php

$parent = include APPLICATION_PATH . '/configs/production.php';

// extending production config
$config = array(
    'phpSettings' => array(
        'display_startup_errors' => 1,
        'display_errors'         => 1
    ),
    'resources' => array(
        'db' => array(
            'adapter' => 'mysqli',
            'params' => array(
                'host'     => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'joylife_dev',
                'charset'  => 'utf8'
            )
        )
    )
);

return $application->mergeOptions($parent, $config);
