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
        if($buildingPost==""){
          $data = [
            "surName" => $surNamePost,
            "firstName" => $firstNamePost,
            "surNameYomi" => $surNameYomiPost,
            "firstNameYomi" => $firstNameYomiPost,
            "prefId" => $prefIdPost,
            "email" => $emailPost,
            "zipFirst" => $zipFirstPost,
            "zipLast" => $zipLastPost,
            "city" => $cityPost,
            "town" => $townPost,
            "phoneFirst" => $phoneFirstPost,
            "phoneSecond" => $phoneSecondPost,
            "phoneThird" => $phoneThirdPost,
            "forumId" => $forumIdPost,
          ];
        }else{
          $data = [
            "surName" => $surNamePost,
            "firstName" => $firstNamePost,
            "surNameYomi" => $surNameYomiPost,
            "firstNameYomi" => $firstNameYomiPost,
            "prefId" => $prefIdPost,
            "email" => $emailPost,
            "zipFirst" => $zipFirstPost,
            "zipLast" => $zipLastPost,
            "city" => $cityPost,
            "town" => $townPost,
            "building" => $buildingPost,
            "phoneFirst" => $phoneFirstPost,
            "phoneSecond" => $phoneSecondPost,
            "phoneThird" => $phoneThirdPost,
            "forumId" => $forumIdPost,
          ];
        }

        //$inputFilter = new InputFilter();
        $iruser_test = new Iruser();
        $inputFilter = $iruser_test->getInputFilter();

        if($buildingPost==""){
          $inputFilter->add($surName)
                      ->add($firstName)
                      ->add($surNameYomi)
                      ->add($firstNameYomi)
                      ->add($prefId)
                      ->add($email)
                      ->add($zipFirst)
                      ->add($zipLast)
                      ->add($city)
                      ->add($town)
                      ->add($phoneFirst)
                      ->add($phoneSecond)
                      ->add($phoneThird)
                      ->add($forumId)
                      ->setData($data);
        }else{
          $inputFilter->add($surName)
                      ->add($firstName)
                      ->add($surNameYomi)
                      ->add($firstNameYomi)
                      ->add($prefId)
                      ->add($email)
                      ->add($zipFirst)
                      ->add($zipLast)
                      ->add($city)
                      ->add($town)
                      ->add($building)
                      ->add($phoneFirst)
                      ->add($phoneSecond)
                      ->add($phoneThird)
                      ->add($forumId)
                      ->setData($data);
        }
        if($inputFilter->isValid()){
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
    /*calling update function of IruserTable Model*/
    public function updateAction()
    {
      $userIdSession = $user_update_session->userId;

      $form = new IruserEditForm();    
      $request = $this->getRequest();
      if($request->isPost()){ 
        $userIdPost = $this->params()->fromPost('userId', null );
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
        if($buildingPost==""){
          $data = [
            "userIdPost" => $userIdPost,
            "surName" => $surNamePost,
            "firstName" => $firstNamePost,
            "surNameYomi" => $surNameYomiPost,
            "firstNameYomi" => $firstNameYomiPost,
            "prefId" => $prefIdPost,
            "email" => $emailPost,
            "zipFirst" => $zipFirstPost,
            "zipLast" => $zipLastPost,
            "city" => $cityPost,
            "town" => $townPost,
            "phoneFirst" => $phoneFirstPost,
            "phoneSecond" => $phoneSecondPost,
            "phoneThird" => $phoneThirdPost,
          ];
        }else{
          $data = [
            "userIdPost" => $userIdPost,
            "surName" => $surNamePost,
            "firstName" => $firstNamePost,
            "surNameYomi" => $surNameYomiPost,
            "firstNameYomi" => $firstNameYomiPost,
            "prefId" => $prefIdPost,
            "email" => $emailPost,
            "zipFirst" => $zipFirstPost,
            "zipLast" => $zipLastPost,
            "city" => $cityPost,
            "town" => $townPost,
            "building" => $buildingPost,
            "phoneFirst" => $phoneFirstPost,
            "phoneSecond" => $phoneSecondPost,
            "phoneThird" => $phoneThirdPost,
          ];
        }
        $userId = new Input('userId');
        $userId->getValidatorChain()
                 ->attach(new Validator\Between(array('min' => 1, 'max' => 9223372036854775807)));
        $surName = new Input('surName');
        $surName->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 20)))
                 ->attach(new Validator\Regex(array('pattern' => '/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/')));
        $firstName = new Input('firstName');
        $firstName->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 20)))
                 ->attach(new Validator\Regex(array('pattern' => '/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/')));
        $surNameYomi = new Input('surNameYomi');
        $surNameYomi->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 20)))
                 ->attach(new Validator\Regex(array('pattern' => '/^([あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをんが>ぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょゎ・ー　])+?$/')));
        $firstNameYomi = new Input('firstNameYomi');
        $firstNameYomi->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 20)))
                 ->attach(new Validator\Regex(array('pattern' => '/^([あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをんが>ぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょゎ・ー　])+?$/')));
        $prefId = new Input('prefId');
        $prefId->getValidatorChain()
                 ->attach(new Validator\Between(array('min' => 1, 'max' => 47)));
        $email = new Input('email');
        $email->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $zipFirst = new Input('zipFirst');
        $zipFirst->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 3, 'max' => 3)));
        $zipLast = new Input('zipLast');
        $zipLast->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 4, 'max' => 4)));
        $city = new Input('city');
        $city->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 20)))
                 ->attach(new Validator\Regex(array('pattern' => '/^[0-9a-zA-Zぁ-んァ-ヶー一-龠 　\r\n\t]+?$/')));
        $town = new Input('town');
        $town->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 20)))
                 ->attach(new Validator\Regex(array('pattern' => '/^[0-9a-zA-Zぁ-んァ-ヶー一-龠 　\r\n\t]+?$/')));
        if($buildingPost !=""){       
          $building = new Input('building');
          $building->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 20)))
                 ->attach(new Validator\Regex(array('pattern' => '/^[0-9a-zA-Zぁ-んァ-ヶー一-龠 　\r\n\t]+?$/')));
        }
        $phoneFirst = new Input('phoneFirst');
        $phoneFirst->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 1, 'max' => 4)))
                 ->attach(new Validator\Between(array('min' => 1, 'max' => 9999)));
        $phoneSecond = new Input('phoneSecond');
        $phoneSecond->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 2, 'max' => 4)))
                 ->attach(new Validator\Between(array('min' => 1, 'max' => 9999)));
        $phoneThird = new Input('phoneThird');
        $phoneThird->getValidatorChain()
                 ->attach(new Validator\StringLength(array('min' => 2, 'max' => 4)))
                 ->attach(new Validator\Between(array('min' => 1, 'max' => 9999)));
        $inputFilter = new InputFilter();
        if($buildingPost==""){
          $inputFilter->add($userId)
                      ->add($surName)
                      ->add($firstName)
                      ->add($surNameYomi)
                      ->add($firstNameYomi)
                      ->add($prefId)
                      ->add($email)
                      ->add($zipFirst)
                      ->add($zipLast)
                      ->add($city)
                      ->add($town)
                      ->add($phoneFirst)
                      ->add($phoneSecond)
                      ->add($phoneThird)
                      ->setData($data);
        }else{
          $inputFilter->add($userId)
                      ->add($surName)
                      ->add($firstName)
                      ->add($surNameYomi)
                      ->add($firstNameYomi)
                      ->add($prefId)
                      ->add($email)
                      ->add($zipFirst)
                      ->add($zipLast)
                      ->add($city)
                      ->add($town)
                      ->add($building)
                      ->add($phoneFirst)
                      ->add($phoneSecond)
                      ->add($phoneThird)
                      ->setData($data);
        }
        if($inputFilter->isValid()){
          //echo "The form is valid\n";
          $iruser = new Iruser();
          $iruser->user_id = $userIdPost;
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
 
          $this->getIruserTable()->updateIruser( $iruser ,array('user_id'=>$iruser->user_id));

          return $this->redirect()->toRoute('application', array(
            'controller' => 'password',
            'action' => 'index'
          ));
        } else {
          throw new \Exception("The form is not valid");
          /*
          echo "The form is not valid\n";
          echo "prefIdPost:".$prefIdPost."\n";
          foreach ($inputFilter->getInvalidInput() as $error) {
            print_r($error->getMessages());
          }
          */
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

