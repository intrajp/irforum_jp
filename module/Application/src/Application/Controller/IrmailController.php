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
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;

class IrmailController extends AbstractActionController
{
    public function indexAction(){
      $email = $this->params()->fromPost('email', 0 );
      $surName = $this->params()->fromPost('surName', 0 );
      $firstName = $this->params()->fromPost('firstName', 0 );
      $recipient = $surName . " " . $firstName;

      $message = new Message();
      $message->addFrom('irforum2014-test@irforum2014-test.com','irforum2914-test')
              ->setBody('御登録ありがとうございました!')
              ->addTo("$email","$recipient")
              ->setSubject('irforumからの登録完了メール');
      $message->setBody('御登録ありがとうございました!');
      $message->setEncoding("UTF-8");

      $transport = new SendmailTransport();
      $transport->send($message);
    }
}

