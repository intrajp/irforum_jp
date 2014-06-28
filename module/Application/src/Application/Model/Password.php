<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 *
 * written by Shintaro Fujiwara
 *
 */

namespace Application\Model;

class Password 
{
  public $loginName;
  public $password;

  public function exchangeArray($data)
  {
    $this->loginName = (isset($data['login_name'])) ? $data['login_name'] : 'guest';
    $this->password = (isset($data['password'])) ? $data['password'] : 0;
  }
}

