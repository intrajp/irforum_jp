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

class ZipTable
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
  public function fetchAllWithZip( $where = null )
  {
    $sql = new Sql( $this->tableGateway->adapter );
    $select = $sql->select();
    $select->from('zip');
    $select->columns(array('city', 'town','pref_id'));
    $select->where( $where );
    $select->join( 'pref', 'zip.pref_id=pref.pref_id',
      array(
        'pref_name_kanji'
      )
    );
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $statement->execute();
    return $result;
  }
}

