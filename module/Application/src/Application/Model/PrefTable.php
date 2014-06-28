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

class PrefTable
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
  public function savePref(Pref $pref)
  {
    $data = array (
      'pref_id' => $pref->pref_id,
      'pref_name_kanji' => $pref->pref_name_kanji,
    );
    $this->tableGateway->insert($data);
  }
}

