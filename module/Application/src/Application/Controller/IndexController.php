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
use Zend\View\Helper\HeadScript;
use Zend\View\Model\ViewModel;
use Application\Form\IruserForm;
use Application\Model\Forum;

class IndexController extends AbstractActionController
{
    protected $forumTable;

    public function indexAction()
    {
      $forumExists = $this->getForumTable()->fetchActiveForum();
      $paginator = $this->getForumTable()->fetchActiveForumData();

      $form = new IruserForm();    
      $values = array(
        'form' => $form,
        'paginator' => $paginator,
        'forumExists' => $forumExists,
      );
      $view = new ViewModel( $values );
      return $view;
    }
    /*get forumTable*/
    public function getForumTable()
    {
      if(!$this->forumTable){
        $sm = $this->getServiceLocator();
        $this->forumTable = $sm->get('Application\Model\ForumTable');
      }
      return $this->forumTable;
    }
}

