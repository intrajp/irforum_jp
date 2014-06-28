<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 *
 * written by Shintaro Fujiwara
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Pref;

class ListController extends AbstractActionController
{
    protected $prefTable;

    public function indexAction()
    {
      $values = array(
        'pref' => $this->getPrefTable()->fetchAll(),
      );
      $view = new ViewModel( $values );
      //null layout
      $view->setTerminal(true);
      return $view;
    }
    public function getPrefTable(){
      if(!$this->prefTable){
        $sm = $this->getServiceLocator();
        $this->prefTable = $sm->get('Application\Model\PrefTable');
      }
      return $this->prefTable;
    }
}

