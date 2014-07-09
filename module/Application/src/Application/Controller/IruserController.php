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
use Application\Model\Iruser;
use Application\Form\IruserForm;
use Application\Form\IruserEditForm;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

class IruserController extends AbstractActionController
{
    protected $iruserTable;

    public function indexAction()
    {
      $view = new ViewModel();
      //null layout
      $view->setTerminal(true);
      return $view;
    }
    public function detailAction()
    {
      $values = array(
        'userlist' => $this->getIruserTable()->fetchAll(),
      );
      $view = new ViewModel( $values );
      return $view;
    }
    /*adding user to database*/
    public function addAction()
    {
      $form = new IruserForm();    
      $request = $this->getRequest();
      if($request->isPost()){ 
        $surNamePost = $this->params()->fromPost('surName', null );
        $firstNamePost = $this->params()->fromPost('firstName', null );
        $surNameYomiPost = $this->params()->fromPost('surNameYomi', null );
        $firstNameYomiPost = $this->params()->fromPost('firstNameYomi', null );
        $prefIdPost = $this->params()->fromPost('prefId', null );
        $emailPost = $this->params()->fromPost('email', null );
        $zipFirstPost = $this->params()->fromPost('zipFirst', null );
        $zipLastPost = $this->params()->fromPost('zipLast', null );
        $cityPost = $this->params()->fromPost('city', null );
        $townPost = $this->params()->fromPost('town', null );
        $buildingPost = $this->params()->fromPost('building', null );
        $phoneFirstPost = $this->params()->fromPost('phoneFirst', null );
        $phoneSecondPost = $this->params()->fromPost('phoneSecond', null );
        $phoneThirdPost = $this->params()->fromPost('phoneThird', null );
        $forumIdPost = $this->params()->fromPost('forumId', null );

        $iruser_test = new Iruser();
        $form->setInputFilter($iruser_test->getInputFilter());

        $data = [
          "surNameFilter" => $surNamePost,
          "firstNameFilter" => $firstNamePost,
          "surNameYomiFilter" => $surNameYomiPost,
          "firstNameYomiFilter" => $firstNameYomiPost,
          "prefIdFilter" => $prefIdPost,
          "emailFilter" => $emailPost,
          "zipFirstFilter" => $zipFirstPost,
          "zipLastFilter" => $zipLastPost,
          "cityFilter" => $cityPost,
          "townFilter" => $townPost,
          "buildingFilter" => $buildingPost,
          "phoneFirstFilter" => $phoneFirstPost,
          "phoneSecondFilter" => $phoneSecondPost,
          "phoneThirdFilter" => $phoneThirdPost,
          "forumIdFilter" => $forumIdPost,
        ];
        if($buildingPost == ""){
          $form->setValidationGroup('surNameFilter','firstNameFilter','surNameYomiFilter','firstNameYomiFilter','prefIdFilter','emailFilter','zipFirstFilter','zipLastFilter','cityFilter','townFilter','phoneFirstFilter','phoneSecondFilter','phoneThirdFilter','forumIdFilter');
        } else {
          $form->setValidationGroup('surNameFilter','firstNameFilter','surNameYomiFilter','firstNameYomiFilter','prefIdFilter','emailFilter','zipFirstFilter','zipLastFilter','cityFilter','townFilter','buildingFilter','phoneFirstFilter','phoneSecondFilter','phoneThirdFilter','forumIdFilter');
        }
        $form->setData($data);
        if($form->isValid()){
          $iruser = new Iruser();
          $iruser->surname = $surNamePost;
          $iruser->firstname = $firstNamePost;
          $iruser->surname_yomi = $surNameYomiPost;
          $iruser->firstname_yomi = $firstNameYomiPost;
          $iruser->pref_id = $prefIdPost;
          $iruser->email = $emailPost;
          $iruser->zip_first = $zipFirstPost;
          $iruser->zip_last = $zipLastPost;
          $iruser->city = $cityPost;
          $iruser->town = $townPost;
          $iruser->building = $buildingPost;
          $iruser->phone_first = $phoneFirstPost;
          $iruser->phone_second = $phoneSecondPost;
          $iruser->phone_third = $phoneThirdPost;
          $iruser->forum_id = $forumIdPost;

          $this->getIruserTable()->saveIruser($iruser);

          return $this->redirect()->toRoute('application', array(
            'controller' => 'index',
            'action' => 'index'
          ));
        } else {
          throw new \Exception("The form is not valid");
          exit;
        }
      }
    }
    /*get IruserTable*/
    public function getIruserTable(){
      if(!$this->iruserTable){
        $sm = $this->getServiceLocator();
        $this->iruserTable = $sm->get('Application\Model\IruserTable');
      }
      return $this->iruserTable;
    }
}

