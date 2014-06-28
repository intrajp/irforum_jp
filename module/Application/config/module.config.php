<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'passwd' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Password',
                        'action'     => 'index',
                    ),
                ),
            ),
            'passwd2' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Password',
                        'action'     => 'config',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                    //added by intrajp
                    'route2'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Password',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            //added by intrajp
            'Application\Controller\List' => 'Application\Controller\ListController',
            'Application\Controller\Zip' => 'Application\Controller\ZipController',
            'Application\Controller\Iruser' => 'Application\Controller\IruserController',
            'Application\Controller\Irmail' => 'Application\Controller\IrmailController',
            'Application\Controller\Password' => 'Application\Controller\PasswordController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            //added by intrajp
            'application/irmail/index' => __DIR__ . '/../view/application/iruser/index.phtml',
            'application/iruser/index' => __DIR__ . '/../view/application/iruser/index.phtml',
            'application/iruser/add' => __DIR__ . '/../view/application/iruser/index.phtml',
            'application/iruser/update' => __DIR__ . '/../view/application/iruser/update.phtml',
            'application/list/index' => __DIR__ . '/../view/application/list/index.phtml',
            'application/password/add' => __DIR__ . '/../view/application/password/add.phtml',
            'application/password/addforum' => __DIR__ . '/../view/application/password/addforum.phtml',
            'application/password/config' => __DIR__ . '/../view/application/password/config.phtml',
            'application/password/index' => __DIR__ . '/../view/application/password/index.phtml',
            'application/password/login' => __DIR__ . '/../view/application/password/login.phtml',
            'application/password/logout' => __DIR__ . '/../view/application/password/login.phtml',
            'application/password/update' => __DIR__ . '/../view/application/password/update.phtml',
            'application/password/updateforum' => __DIR__ . '/../view/application/password/updateforum.phtml',
            'application/zip/index' => __DIR__ . '/../view/application/zip/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
