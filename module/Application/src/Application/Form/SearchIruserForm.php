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

class SearchIruserForm extends Form
{
  public function __construct($name = null, $surNameYomiPost )
  {
    parent::__construct('iruser');
    $this->setAttribute('method', 'post');

    $this->add(array(
      'name' => 'surNameYomi',
      'type' => 'Text',
      'attributes' => array(
        'value' => "$surNameYomiPost",
        'id' => 'surNameYomi',
        'class' => 'surNameYomi',
      ),
      'options' => array(
        'label' => '名字（よみがな）',
      ),
    ));
    $this->add(array(
      'name' => 'quickregisterSearch',
      'attributes' => array(
        'type' => 'submit',
        'value' => '検索',
        'id' => 'btExecSearch',
        'class' => 'submitObjectSearch',
      ),
    ));
  }
}

