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

namespace Application\Model;

//use Zend\Authentication\Adapter\DbTable as AuthAdapter;
//use Application\Auth\Adapter as AuthAdapter;
use Application\Auth\Adapter\BcryptDbAdapter as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Application\Model\Password;

class Auth
{
  protected $auth;

  public function __construct()
  {
   $this->auth = new AuthenticationService( new SessionStorage( 'user_auth' ) );
  }
  public function login( Password $password, $dbAdapter )
  {
    $authAdapter = new AuthAdapter( $dbAdapter);
    $authAdapter->setTableName('password')
                ->setIdentityColumn('loginName')
                ->setCredentialColumn('password');
    $result = $this->auth->authenticate( $authAdapter );
    if( $result->isValid() ){
      $storage = $this->auth->getStorage();
      $storage->write( $authAdapter->getResultRowObject() );
      return true;
    }else{
     return false; 
    }

  }
  public function logout()
  {
    $this->auth->getStorage()->clear();
    $this->auth->clearIdentity();
  }
}

