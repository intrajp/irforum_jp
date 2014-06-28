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
use Application\Model\Zip;

class ZipController extends AbstractActionController
{
    protected $zipTable;

    public function indexAction()
    {
      $zipFirst = $this->params()->fromPost('zipFirst', 0 );
      $zipLast = $this->params()->fromPost('zipLast', 0 );
      $values = array(
        'zip' => $this->getZipTable()->fetchAllWithZip( array( 'zip_first' => $zipFirst, 'zip_last' => $zipLast ) ),
      );
      $view = new ViewModel( $values );
      //null layout
      $view->setTerminal(true);
      return $view;
    }

    public function getZipTable(){
      if(!$this->zipTable){
        $sm = $this->getServiceLocator();
        $this->zipTable = $sm->get('Application\Model\ZipTable');
      }
      return $this->zipTable;
    }
}

