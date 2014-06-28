<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
//added by intrajp
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Forum;
use Application\Model\ForumTable;
use Application\Model\Iruser;
use Application\Model\IruserTable;
use Application\Model\Pref;
use Application\Model\PrefTable;
use Application\Model\Zip;
use Application\Model\ZipTable;
use Application\Model\Password;
use Application\Model\PasswordTable;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    //added by intrajp
    public function getServiceConfig()
    {
      return array(
        'factories' => array(
          'Application\Model\ForumTable' => function($sm) {
            $tableGateway = $sm->get('ForumTableGateway');
            $table = new ForumTable($tableGateway);
            return $table;
          },
          'Application\Model\IruserTable' => function($sm) {
            $tableGateway = $sm->get('IruserTableGateway');
            $table = new IruserTable($tableGateway);
            return $table;
          },
          'Application\Model\PrefTable' => function($sm) {
            $tableGateway = $sm->get('PrefTableGateway');
            $table = new PrefTable($tableGateway);
            return $table;
          },
          'Application\Model\PasswordTable' => function($sm) {
            $tableGateway = $sm->get('PasswordTableGateway');
            $table = new PasswordTable($tableGateway);
            return $table;
          },
          'Application\Model\ZipTable' => function($sm) {
            $tableGateway = $sm->get('ZipTableGateway');
            $table = new ZipTable($tableGateway);
            return $table;
          },
          'ForumTableGateway' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Forum());
            return new TableGateway(
              'forum', $dbAdapter, null, $resultSetPrototype
            );
          },
          'IruserTableGateway' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Iruser());
            return new TableGateway(
              'iruser', $dbAdapter, null, $resultSetPrototype
            );
          },
          'PasswordTableGateway' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Password());
            return new TableGateway(
              'password', $dbAdapter, null, $resultSetPrototype
            );
          },
          'PrefTableGateway' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Pref());
            return new TableGateway(
              'pref', $dbAdapter, null, $resultSetPrototype
            );
          },
          'ZipTableGateway' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Zip());
            return new TableGateway(
              'zip', $dbAdapter, null, $resultSetPrototype
            );
          },
        ) 
      );
    }
}
