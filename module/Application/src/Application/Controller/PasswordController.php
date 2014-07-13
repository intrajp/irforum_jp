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
use Application\Model\Auth as Auth;
use Application\Model\Forum;
use Application\Model\Iruser;
use Application\Model\Password;
use Application\Form\IruserForm;
use Application\Form\ForumForm;
use Application\Form\ForumUpdateForm;
use Application\Form\IruserEditForm;
use Application\Form\PasswordForm;
use Application\Form\SearchIruserForm;
use Application\Auth\Adapter\BcryptDbAdapter as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Request;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Session\Container;
use Zend\Validator;


class PasswordController extends AbstractActionController
{
    protected $auth;
    protected $authAdapter;
    protected $dbAdapter;
    protected $storage;
    protected $iruserTable;
    protected $forumTable;
    protected $passwordTable;
    protected $loginName;
    protected $surNameYomiPost;
    protected $form3;

    //construct AuthenticationService and set to property
    public function __construct(){
      $this->auth = new AuthenticationService();
    }
    /*after logged in successfully he can get the user's data*/
    public function indexAction()
    {
      $forumIdPost="";
      $surNameYomi="";
      $pageNo="";
      $pagePost="";
      $user_session = new Container('user');
      $forum_session = new Container('forum');
      if($this->params()->fromQuery('page')){
        $pagePost = $this->params()->fromQuery('page', '' );
      }
      if( ( $this->params()->fromPost('surNameYomi') == "" ) && ( $pagePost =="" ) ){
        $user_session->getManager()->getStorage()->clear('user');
      }
      if($this->params()->fromPost('id')){
        $pageNo = (int)$this->params()->fromPost('id', 0 );
      }
      // This should be out of auth->hasIdentity()////Retrieve username from session
      $surNameYomiPost = $user_session->surNameYomi; // $surNameYomiPost now contains what has been posted
      //form for registration(this form should be out of auth->hasIdentity();
      $form = new PasswordForm();
      $request = $this->getRequest();
      $data = $request->getPost();

      if ( $this->auth->hasIdentity() ) {
        //form for searching user 
        $form2 = new SearchIruserForm(null, $surNameYomiPost);
        //form for editing(updating) user 
        $form3 = new IruserEditForm();

        if($this->params()->fromQuery('forumId')){
          $forumIdPost = $this->params()->fromQuery('forumId', null );
          $forum_session->forumId = $forumIdPost;
          $iruser_test = new Iruser();
          $form3->setInputFilter($iruser_test->getInputFilter());
          $data = [
            "forumIdFilter" => $forumIdPost,
          ];
          $form3->setValidationGroup('forumIdFilter');
          $form3->setData($data);
          if(!$form3->isValid()){
            throw new \Exception("The form is not valid");
            exit;
          }
        }
        if($this->params()->fromPost('surNameYomi')){
          $surNameYomi = $this->params()->fromPost('surNameYomi', null );
          $user_session->surNameYomi = $surNameYomi;
          $iruser_test = new Iruser();
          $form2->setInputFilter($iruser_test->getInputFilter());
          $data = [
            "surNameYomiFilter" => $surNameYomi,
          ];
          $form2->setValidationGroup('surNameYomiFilter');
          $form2->setData($data);
          if(!$form2->isValid()){
            throw new \Exception("The form is not valid");
            exit;
          }
        }
        $forum_id_sess = $forum_session->forumId; // $forum_id now contains forum_id
        $admin_user_name = $admin_user_session->userName; // $admin_user_name now contains admin user name
        $paginator = $this->getIruserTable()->fetchAllPaginated( true ,  array( 'surname_yomi' => $surNameYomiPost ), $forum_id_sess );
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        $paginator->setItemCountPerPage(10);
        $admin_user_session = new Container('admin_user');
        $userIdPost = $this->params()->fromQuery('userId', '' );
        if( $userIdPost !="" ){
          $iruserData = $this->getIruserTable()->fetchAllWithUserId(array( 'user_id' => $userIdPost ) );
          $values = array(
            'form3' => $form3,
            'iruserData' => $iruserData,
            'loginName' => $admin_user_name,
          );
        } else {
          $values = array(
            'form2' => $form2,
            'paginator' => $paginator,
            'loginName' => $admin_user_name,
          );
        }
      }else{
        $values = array(
          'form' => $form,
        );
      }
      $view = new ViewModel( $values );
      return $view;
    }
    /*admin config function*/
    public function configAction()
    {
      if ( $this->auth->hasIdentity() ) {
        //echo "has identity";

        $paginator_config = $this->getForumTable()->fetchAllPaginated( true );
        $paginator_config->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        $paginator_config->setItemCountPerPage(10);

        $formForum = new ForumForm();
        $admin_user_session = new Container('admin_user');
        $admin_user_name = $admin_user_session->userName; // $admin_user_name now contains admin user name
        $values = array(
          'formForum' => $formForum,
          'paginator_config' => $paginator_config,
          'loginName' => $admin_user_name,
        );
        $view = new ViewModel( $values );
        return $view;
      }else{
        $url = '/irforum/application/password/login';
        $this->plugin('redirect')->toUrl($url);
        return FALSE;
      }
    }
    /*admin login function*/
    public function loginAction()
    {
      $loginName = ""; 
      $password = "";
      $request = $this->getRequest();
      $data = $request->getPost();

      $loginName = $this->params()->fromPost('loginName', null );
      $password = $this->params()->fromPost('password', null );
      $form = new PasswordForm();
      if(($loginName)||($password)){
        /*check if post is valid*/
        $dataCheck =[
          "loginName" => $loginName,
          "password" => $password,
        ];
        $loginNameValidator = new Input('loginName');
        $loginNameValidator->getValidatorChain()
                         ->attach(new Validator\StringLength(array('min' => 4, 'max' => 20)))
                           ->attach(new Validator\Regex(array('pattern' => '/^[a-zA-Z0-9]+?$/')));
        $passwordValidator = new Input('password');
        $passwordValidator->getValidatorChain()
                           ->attach(new Validator\StringLength(array('min' => 8, 'max' => 16)))
                           ->attach(new Validator\Regex(array('pattern' => '/^[a-zA-Z0-9]+?$/')));
        $inputFilter = new InputFilter();
        $inputFilter->add($loginNameValidator)
                    ->add($passwordValidator)
                    ->setData($dataCheck);
        if(!$inputFilter->isValid()){
          throw new \Exception("The form is not valid");
          exit;
        }
        //authentication action from here !!!!
        $this->authAdapter = new AuthAdapter($this->getDBAdapter());
        $this->authAdapter
          ->setTableName('password')
          ->setIdentityColumn('login_name')
          ->setCredentialColumn('password');
        $this->authAdapter
          ->setIdentity(addslashes($data->loginName))
          ->setCredential($data->password);
        // attempt authentication
        $result = $this->authAdapter->authenticate();
        //if password is not valid--actually here is not excecuted at all,because index action will do the job even if authentication failed
        if (!$result->isValid()) {
          $values = array(
            'form' => $form,
          );
        //if password is valid 
        } else {
          //Authentication succeeded
          //needs here
          $admin_user_session = new Container('admin_user');
          $admin_user_session->userName = $loginName;
          //$loginUser = $this->getLoginUser();
          $this->storage = $this->auth->getStorage();
          $this->storage->write($this->authAdapter->getResultRowObject(
            null,
            'password'
          ));
          //end needs here
          //actually here is not excecuted at all,because index action will do the job even if authentication succeeds 
          $values = array(
            'form2' => $form2,
            'paginator' => $paginator,
            'loginName' => $admin_user_name,
          );
          //end actually here is not excecuted at all,because index action will do the job even if authentication succeeds 
        }
      }else{
        //when clicked admin page after logged in 
        if( $this->auth->hasIdentity() ){
          //$admin_user_session = new Container('admin_user');
          $url = '/irforum/application/password/index';
          $this->plugin('redirect')->toUrl($url);
        //end when clicked admin page after logged in 
        //first time
        }else{
          $values = array(
            'form' => $form,
          );
        }
      }
      //insurance
      $values = array(
        'form' => $form,
      );
      $view = new ViewModel( $values );
      return $view;
    }
    public function getDBAdapter()
    {
      if( !$this->dbAdapter ){
        //servicelocator cannot be used in constructor, so...
        $sm = $this->getServiceLocator(); 
        $this->dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
      }
      return $this->dbAdapter;
    }

    /*if admins logs in correctly, he can edit user's data*/
    public function updateAction()
    {
      if( $this->auth->hasIdentity() ){
        $form = new IruserEditForm();    
        $request = $this->getRequest();
        if($request->isPost()){ 

          $userIdPost = $this->params()->fromPost('userId', null );
          $surNamePost = $this->params()->fromPost('surName', null );
          $firstNamePost = $this->params()->fromPost('firstName', null );
          $surNameYomiPost = $this->params()->fromPost('surNameYomi', null );
          $firstNameYomiPost = $this->params()->fromPost('firstNameYomi', null );
          $emailPost = $this->params()->fromPost('email', null );
          $zipFirstPost = $this->params()->fromPost('zipFirst', null );
          $zipLastPost = $this->params()->fromPost('zipLast', null );
          $prefIdPost = $this->params()->fromPost('prefId', null );
          $cityPost = $this->params()->fromPost('city', null );
          $townPost = $this->params()->fromPost('town', null );
          $buildingPost = $this->params()->fromPost('building', null );
          $phoneFirstPost = $this->params()->fromPost('phoneFirst', null );
          $phoneSecondPost = $this->params()->fromPost('phoneSecond', null );
          $phoneThirdPost = $this->params()->fromPost('phoneThird', null );

          $iruser_test = new Iruser();
          $form->setInputFilter($iruser_test->getInputFilter());

          $data = [
            "userIdFilter" => $userIdPost,
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
          ];
          if($buildingPost == ""){
            $form->setValidationGroup('userIdFilter','surNameFilter','firstNameFilter','surNameYomiFilter','firstNameYomiFilter','prefIdFilter','emailFilter','zipFirstFilter','zipLastFilter','cityFilter','townFilter','phoneFirstFilter','phoneSecondFilter','phoneThirdFilter');
          }else{
            $form->setValidationGroup('userIdFilter','surNameFilter','firstNameFilter','surNameYomiFilter','firstNameYomiFilter','prefIdFilter','emailFilter','zipFirstFilter','zipLastFilter','cityFilter','townFilter','buildingFilter','phoneFirstFilter','phoneSecondFilter','phoneThirdFilter');
          }
          $form->setData($data);

          if($form->isValid()){
            //send iruser update userdata
            $user_update_session = new Container('user_update');
            $user_update_session->userId = $userIdPost;
            $user_update_session->surName = $surNamePost;
            $user_update_session->firstName = $firstNamePost;
            $user_update_session->surNameYomi = $surNameYomiPost;
            $user_update_session->firstNameYomi = $firstNameYomiPost;
            $user_update_session->email = $emailPost;
            $user_update_session->zipFirst = $zipFirstPost;
            $user_update_session->zipLast = $zipLastPost;
            $user_update_session->prefId = $prefIdPost;
            $user_update_session->city = $cityPost;
            $user_update_session->town = $townPost;
            $user_update_session->building = $buildingPost;
            $user_update_session->phoneFirst = $phoneFirstPost;
            $user_update_session->phoneSecond = $phoneSecondPost;
            $user_update_session->phoneThird = $phoneThirdPost;
            //commooonn!!
            $this->getIruserTable()->updateIruser($user_update_session);
            return $this->redirect()->toRoute('application', array(
              'controller' => 'password',
              'action' => 'index'
            ));
          }else{
            throw new \Exception("The form is not valid");
            exit;
          }
        }else{
          $user_update_session->getManager()->getStorage()->clear('user_update');
          return $this->redirect()->toRoute('application', array(
            'controller' => 'password',
            'action' => 'index'
          ));
        }
      }
    }
    /* this action logs out safely from login state*/
    public function logoutAction()
    {
      if( $this->auth->hasIdentity() ){
        $this->auth->getStorage()->clear();
        $this->auth->clearIdentity();
      }
      $url = "/irforum/application/password/login";
      return $this->redirect()->toUrl($url);
    }
    /*this action adds data to forum table*/
    public function addforumAction()
    {
      if( $this->auth->hasIdentity() ){
        $request = $this->getRequest();
        if($request->isPost()){ 
          $datePost = $this->params()->fromPost('datepicker', null );
          $titlePost = $this->params()->fromPost('title', null );
          $activePost = $this->params()->fromPost('checkBox', null );
            $dataCheck = [
              "date" => $datePost,
              "title" => $titlePost,
              "active" => $activePost,
            ];
          $dateValidator = new Input('date');
          $dateValidator->getValidatorChain()
                        ->attach(new Validator\StringLength(array('min' => 4, 'max' => 20)))
                        ->attach(new Validator\Regex(array('pattern' => '/^[a-zA-Z0-9\/]+?$/')));
          $titleValidator = new Input('title');
          $titleValidator->getValidatorChain()
                         ->attach(new Validator\StringLength(array('min' => 2, 'max' => 40)))
                         ->attach(new Validator\Regex(array('pattern' => '/^[a-zA-Z0-9ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/')));
          $activeValidator = new Input('active');
          $activeValidator->getValidatorChain()
                         ->attach(new Validator\StringLength(array('min' => 1, 'max' => 1)))
                         ->attach(new Validator\Regex(array('pattern' => '/^[0-1]+?$/')));
          $inputFilter = new InputFilter();
          $inputFilter->add($dateValidator)
                      ->add($titleValidator)
                      ->add($activeValidator)
                      ->setData($dataCheck);
          if(!$inputFilter->isValid()){
            throw new \Exception("The form is not valid");
            exit;
          }
          $forum = new Forum();
          $forum->date = $datePost;
          $forum->title = $titlePost;
          $forum->active = $activePost;
          $this->getForumTable()->saveForum( $forum );
//////////have to rewrite here to redirect properly
          return $this->redirect()->toRoute('application', array(
            'controller' => 'password',
            'action' => 'index'
          ));
//////////end have to rewrite here to redirect properly
        }else{
          $formForum = new ForumForm();
          $admin_user_session = new Container('admin_user');
          $admin_user_name = $admin_user_session->userName; // $admin_user_name now contains admin user name
          $values = array(
            'formForum' => $formForum,
            'paginator_config' => $paginator_config,
            'loginName' => $admin_user_name,
          );
          $view = new ViewModel( $values );
          return $view;
        }
      }else{
        return $this->redirect()->toRoute('application', array(
          'controller' => 'password',
          'action' => 'index'
        ));
      }
    }
    public function updateforumAction()
    {
      if( $this->auth->hasIdentity() ){
        $form = new ForumUpdateForm();    
        $deleteForumPost = $this->params()->fromPost('quickregisterForumDelete', null );
        $updateForumPost = $this->params()->fromPost('quickregisterForumUpdate', null );
        $forumIdPost = $this->params()->fromQuery('forumId', '' );
        $forumIdPostDelUpdate = $this->params()->fromPost('forumId', '' );
        //deleting foum by forum id
        if(($deleteForumPost!="")&&($forumIdPostDelUpdate !="")){
          $this->getForumTable()->deleteForum($forumIdPostDelUpdate);
          $url = '/irforum/application/password/config';
          $this->plugin('redirect')->toUrl($url);
        //updating foum by forum id
        }else if(($updateForumPost!="")&&($forumIdPostDelUpdate !="")){
          $datePost = $this->params()->fromPost('datepicker', null );
          $titlePost = $this->params()->fromPost('title', null );
          $activePost = $this->params()->fromPost('checkBox', null );
          $dataCheck = [
            "date" => $datePost,
            "title" => $titlePost,
            "active" => $activePost,
          ];
          $dateValidator = new Input('date');
          $dateValidator->getValidatorChain()
                        ->attach(new Validator\StringLength(array('min' => 4, 'max' => 20)))
                        ->attach(new Validator\Regex(array('pattern' => '/^[a-zA-Z0-9\/\-]+?$/')));
          $titleValidator = new Input('title');
          $titleValidator->getValidatorChain()
                         ->attach(new Validator\StringLength(array('min' => 2, 'max' => 40)))
                         ->attach(new Validator\Regex(array('pattern' => '/^[a-zA-Z0-9ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/')));
          $activeValidator = new Input('active');
          $activeValidator->getValidatorChain()
                         ->attach(new Validator\StringLength(array('min' => 1, 'max' => 1)))
                         ->attach(new Validator\Regex(array('pattern' => '/^[0-1]+?$/')));
          $inputFilter = new InputFilter();
          $inputFilter->add($dateValidator)
                      ->add($titleValidator)
                      ->add($activeValidator)
                      ->setData($dataCheck);
          if(!$inputFilter->isValid()){
            throw new \Exception("The form is not valid");
            exit;
          }
          $forum = new Forum();
          $forum->forum_id = $forumIdPostDelUpdate;
          $forum->date = $datePost;
          $forum->title = $titlePost;
          $forum->active = $activePost;
          $this->getForumTable()->updateForum( $forum ,array('forum_id'=>$forum->forum_id));
          $url = '/irforum/application/password/config';
          $this->plugin('redirect')->toUrl($url);
        }else{
          if( $forumIdPost !="" ){
            $forumData = $this->getForumTable()->fetchAllWithForumId(array( 'forum_id' => $forumIdPost ) );
          }
        }
        $values = array(
          'forumData' => $forumData,
          'form' => $form,
        );
        $view = new ViewModel( $values );
        return $view;
      }else{
        return $this->redirect()->toRoute('application', array(
          'controller' => 'password',
          'action' => 'index'
        ));
      }
    } 
    /*this action adds admin user to password table*/
    public function addAction()
    {
      $password = new Password();
      /*change to your favorite login_name and passord*/
      //$password->login_name = "adminuser";// should be [a-zA-Z0-9] ('min' => 4, 'max' => 20)
      //$password->password = "adminpassword";// should be [a-zA-Z0-9] ('min' => 8, 'max' => 16)
      $this->getPasswordTable()->savePassword( $password );
    }

    public function getLoginUser()
    {
      $loginUser = new Password();
      if( $this->auth->hasIdentity() ){
        $loginUser = $this->auth->getIdentity();
      }
      return $loginUser;
    }
    /*if admins logs in correctly, he can delete user's data*/
    public function deleteForumAction()
    {
      if( $this->auth->hasIdentity() ){
        $forumIdPost = $this->params()->fromPost('forumId', null );
        if(
            ( $forumIdPost !="" )
          ){
          $this->getForumTable()->deleteForum($forumIdPost);
          return $this->redirect()->toRoute('application', array(
            'controller' => 'password',
            'action' => 'config'
          ));
        }else{
        }
      }
    }
    /*if admins logs in correctly, he can delete user's data*/
    public function deleteAction()
    {
      if( $this->auth->hasIdentity() ){
        $userIdPost = $this->params()->fromPost('userId', null );
        if(
            ( $userIdPost !="" )
          ){
          $this->getIruserTable()->deleteIruser($userIdPost);
          return $this->redirect()->toRoute('application', array(
            'controller' => 'password',
            'action' => 'index'
          ));
        }else{
        }
      }
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
    /*get iruserTable*/
    public function getIruserTable()
    {
      if(!$this->iruserTable){
        $sm = $this->getServiceLocator();
        $this->iruserTable = $sm->get('Application\Model\IruserTable');
      }
      return $this->iruserTable;
    }
    /*get passwordTable*/
    public function getPasswordTable()
    {
      if(!$this->passwordTable){
        $sm = $this->getServiceLocator();
        $this->passwordTable = $sm->get('Application\Model\PasswordTable');
      }
      return $this->passwordTable;
    }
}

