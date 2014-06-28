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

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Crypt\Password\Bcrypt;

class PasswordTable
{
  protected $tableGateway;

  public function __construct(TableGateway $tableGateway)
  {
    $this->tableGateway = $tableGateway;
  }
  public function fetchAll()
  {
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }
  public function fetchAllWithPassword( $where = null )
  {
    $sql = new Sql( $this->tableGateway->adapter );
    $select = $sql->select();
    $select->from('password');
    $select->columns(array('password'));
    $select->where( $where );
    //for debug -- this echoes raw sql!!
    //echo $select->getSqlString();
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $statement->execute();
    return $result;
  }

  public function getPassword( $loginName, $password )
  {
    $rowset = $this->tableGateway->select(array('login_name' => $loginName));
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("Could not find row $loginName");
    }
    //var_dump($row);
    //echo $row->password;
    $bcrypt = new Bcrypt();
    //$securePass = 'the stored bcrypt value';
    //$password = 'the password to check';
    $securePass = $row->password;

    if ($bcrypt->verify($password, $securePass)) {
      //echo "The password is correct! \n";
      return true;
    } else {
      echo "The password is NOT correct.\n";
    }
    //return $row;
    return false;
  }

  public function savePassword(Password $password)
  {
    $bcrypt = new Bcrypt();
    $securePass = $bcrypt->create("$password->password");
    $data = array (
      'login_name' => $password->login_name,
      'password' => $securePass,
    );
    $this->tableGateway->insert($data);
  }
}

