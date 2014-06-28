<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
//added by intrajp
return array(
    'db' => array(
        'driver'   => 'Pdo',
        //'dsn'      => 'pgsql:dbname=irforum;host=localhost;charset=utf8',
        'dsn'      => 'pgsql:dbname=irforum;host=localhost',
        //'username' => 'postgres',
        //'password' => '',
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
/*
return array(
    // ...
);
*/
