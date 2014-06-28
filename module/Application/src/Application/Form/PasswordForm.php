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

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element\Password;

class PasswordForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('password');
    $this->setAttribute('method', 'post');

    $this->add(array(
      'name' => 'loginName',
      'type' => 'Text',
      'attributes' => array(
        'id' => 'loginName',
        'class' => 'loginName',
      ),
      'options' => array(
        'label' => 'ログイン名',
      ),
    ));
    $this->add(array(
      'name' => 'password',
      'type' => 'Zend\Form\Element\Password',
      'attributes' => array(
        'id' => 'password',
        'class' => 'password',
      ),
      'options' => array(
        'label' => 'パスワード',
      ),
    ));
    $this->add(array(
      'name' => 'quickregisterLogin',
      'attributes' => array(
        'type' => 'submit',
        'value' => '送信',
        'id' => 'btExecLogin',
        'class' => 'submitObjectLogin',
      ),
    ));
  }
}

