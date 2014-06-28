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
use Zend\Form\Element\Email;
use Zend\Form\Element\Select;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Hidden;
use Zend\Paginator\Paginator;

class IruserEditForm extends Form
{
  public function __construct($name = null)
  //public function __construct($name = null,$surName)
  //public function __construct($name = null, Paginator $paginator)
  {
    parent::__construct('iruser');
    $this->setAttribute('method', 'post');

    $this->add(array(
      'name' => 'checkBox',
      'type' => 'Zend\Form\Element\Checkbox',
      'attributes' => array(
        'id' => 'checkBox',
      ),
      'options' => array(
        'label' => '同意しますか？',
        'value_options' => array(
          'agree' => 'する',
        ),
      ),
    ));
    $this->add(array(
      'name' => 'firstTry',
      'type' => 'Zend\Form\Element\Hidden',
      'attributes' => array(
        'id' => 'firstTry',
        'value' => 'yes',
      ),
    ));
    $this->add(array(
      'name' => 'userId',
      'attributes' => array(
        'type' => 'hidden',
        'id' => 'userId',
        'class' => 'userId',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'surName',
      'attributes' => array(
        'type' => 'text',
        'id' => 'surName',
        'class' => 'surName',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'firstName',
      'attributes' => array(
        'type' => 'text',
        'id' => 'firstName',
        'class' => 'firstName',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'surNameYomi',
      'attributes' => array(
        'type' => 'text',
        'id' => 'surNameYomi',
        'class' => 'surNameYomi',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'firstNameYomi',
      'attributes' => array(
        'type' => 'text',
        'id' => 'firstNameYomi',
        'class' => 'firstNameYomi',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'email',
      'attributes' => array(
        'type' => 'Zend\Form\Element\Email',
        'id' => 'email',
        'class' => 'email',
        'size' => '40',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'zipFirst',
      'attributes' => array(
        'type' => 'text',
        'size' => '3',
        'id' => 'zipFirst',
        'class' => 'zipFirst',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'zipLast',
      'attributes' => array(
        'type' => 'text',
        'size' => '4',
        'id' => 'zipLast',
        'class' => 'zipLast',
      ),
    ));
    $this->add(array(
      'name' => 'prefId',
      'type' => 'Zend\Form\Element\Select',
      'attributes' => array(
        'id' => 'prefSelection',
        'class' => 'prefSelection',
      ),
    ));
    $this->add(array(
      'name' => 'city',
      'attributes' => array(
        'type' => 'text',
        'id' => 'city',
        'class' => 'city',
        'size' => '30',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'town',
      'attributes' => array(
        'type' => 'text',
        'id' => 'town',
        'class' => 'town',
        'size' => '30',
      ),
    ));
    $this->add(array(
      'name' => 'building',
      'attributes' => array(
        'type' => 'text',
        'id' => 'building',
        'class' => 'building',
        'size' => '30',
      ),
    ));
    $this->add(array(
      'name' => 'phoneFirst',
      'attributes' => array(
        'type' => 'text',
        'size' => '4',
        'maxlength' => '4',
        'id' => 'phoneFirst',
        'class' => 'phoneFirst',
      ),
      'options' => array(
      ),
    ));
    $this->add(array(
      'name' => 'phoneSecond',
      'attributes' => array(
        'type' => 'text',
        'size' => '4',
        'maxlength' => '4',
        'id' => 'phoneSecond',
        'class' => 'phoneSecond',
      ),
    ));
    $this->add(array(
      'name' => 'phoneThird',
      'attributes' => array(
        'type' => 'text',
        'size' => '4',
        'maxlength' => '4',
        'id' => 'phoneThird',
        'class' => 'phoneThird',
      ),
    ));
    $this->add(array(
      'name' => 'prefNameKanjiFromDb',
      'attributes' => array(
        'type' => 'hidden',
        'id' => 'prefNameKanjiFromDb',
      ),
    ));
    $this->add(array(
      'name' => 'prefIdFromDb',
      'attributes' => array(
        'type' => 'hidden',
        'id' => 'prefIdFromDb',
      ),
    ));
    $this->add(array(
      'name' => 'quickregisterUpdate',
      'attributes' => array(
        'type' => 'submit',
        'value' => '修正',
        'id' => 'btExecUpdate',
        'class' => 'submitObjectUpdate',
      ),
    ));
    $this->add(array(
      'name' => 'quickregisterDelete',
      'attributes' => array(
        'type' => 'submit',
        'value' => '削除',
        'id' => 'btExecDelete',
        'class' => 'submitObjectDelete',
      ),
    ));
  }
}

