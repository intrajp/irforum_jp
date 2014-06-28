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
use Zend\Form\Element\Checkbox;

class ForumForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('forum');
    $this->setAttribute('method', 'post');

    $this->add(array(
      'name' => 'checkBox',
      'type' => 'Zend\Form\Element\Checkbox',
      'attributes' => array(
        'id' => 'checkBox',
      ),
      'options' => array(
        'label' => 'アクティブ化？(1つのみ可能)',
        'value_options' => array(
          'use_hidden_element' => true,
          'checked_value' => '1',
          'unchecked_value' => '0'
        ),
      ),
    ));
    $this->add(array(
      'name' => 'datepicker',
      'attributes' => array(
        'type' => 'text',
        'id' => 'datepicker',
        'class' => 'datepicker',
        'size' => '20',
      ),
    ));
    $this->add(array(
      'name' => 'title',
      'attributes' => array(
        'type' => 'text',
        'id' => 'title',
        'class' => 'title',
        'size' => '40',
      ),
    ));
    $this->add(array(
      'name' => 'quickregisterForum',
      'attributes' => array(
        'type' => 'submit',
        'value' => 'このフォーラムを登録',
        'id' => 'btExecForum',
        'class' => 'submitObjectForum',
      ),
    ));
  }
}

