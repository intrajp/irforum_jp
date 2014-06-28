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
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class ForumTable
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
  /*checks if active forum exists*/
  public function fetchActiveForumData()
  {
    $sql = new Sql( $this->tableGateway->adapter );
    $select = $sql->select();
    $select->from('forum');
    $select->columns(array('forum_id','date','title','active'));
    //$select->where( $where );
    $select->where(array( 'active' => 1 ) );
    /*for debug*/
    //echo $select->getSqlString($adapter->getPlatform());
    //echo $select->getSqlString();
    $resultSetPrototype = new ResultSet();
    $resultSetPrototype->setArrayObjectPrototype(new Forum());
    $paginatorAdapter = new DbSelect(
       $select,
       $this->tableGateway->getAdapter(),
       $resultSetPrototype
    );
    $paginator = new Paginator($paginatorAdapter);
    return $paginator;
  }
  /*checks if active forum exists*/
  public function fetchActiveForum()
  {
    $sql = new Sql( $this->tableGateway->adapter );
    $select = $sql->select();
    $select->from('forum');
    $select->columns(array('active'));
    //$select->where( $where );
    $select->where(array( 'active' => 1 ) );
    /*for debug*/
    //echo $select->getSqlString($adapter->getPlatform());
    //echo $select->getSqlString();
    $resultSetPrototype = new ResultSet();
    $resultSetPrototype->setArrayObjectPrototype(new Forum());
    $paginatorAdapter = new DbSelect(
       $select,
       $this->tableGateway->getAdapter(),
       $resultSetPrototype
    );
    $paginator = new Paginator($paginatorAdapter);
    if($paginator){
      foreach ($paginator as $list) : 
        return 1;
      endforeach; 
    }
    return -1;
  }
  /*get forum data from id*/
  public function fetchAllWithForumId( $where = null )
  {
    $sql = new Sql( $this->tableGateway->adapter );
    $select = $sql->select();
    $select->from('forum');
    $select->columns(array('forum_id', 'date', 'title','active'));
    $select->where( $where );
    /*for debug*/
    //echo $select->getSqlString($adapter->getPlatform());
    //echo $select->getSqlString();
    $resultSetPrototype = new ResultSet();
    $resultSetPrototype->setArrayObjectPrototype(new Forum());
    $paginatorAdapter = new DbSelect(
       $select,
       $this->tableGateway->getAdapter(),
       $resultSetPrototype
    );
    $paginator = new Paginator($paginatorAdapter);
    return $paginator;
  }
  /*updating the forum*/
  public function updateForum(Forum $forum)
  {
    $active_forum_exists = $this->fetchActiveForum();
    if( ($forum->active == 1) && ( $active_forum_exists == 1) ){
      throw new \Exception("Active forum exists! Only one forum should be active.");
      exit;
    }
    $data = array (
      'date' => $forum->date,
      'title' => $forum->title,
      'active' => $forum->active,
    );
    $this->tableGateway->update($data, array('forum_id' => $forum->forum_id));
  }
  /*adding forum to table*/
  public function saveForum(Forum $forum)
  {
    $active_forum_exists = $this->fetchActiveForum();
    if( ($forum->active == 1) && ( $active_forum_exists == 1) ){
      throw new \Exception("Active forum exists! Only one forum should be active.");
      exit;
    }
    $data = array (
      'date' => $forum->date,
      'title' => $forum->title,
      'active' => $forum->active,
    );
    $this->tableGateway->insert($data);
  }
  /* this function returns paginated results from database table */
  public function fetchAllPaginated( $paginated = false )
  {
    if($paginated) {
      $sql = new Sql( $this->tableGateway->adapter );
      $select = $sql->select();
      $select->from('forum');
      $select->columns(array('forum_id', 'date','title','active'));
      $select->order( 'forum_id desc' );
      $resultSetPrototype = new ResultSet();
      $resultSetPrototype->setArrayObjectPrototype(new Forum());
      $paginatorAdapter = new DbSelect(
         $select,
         $this->tableGateway->getAdapter(),
         $resultSetPrototype
      );
      $paginator = new Paginator($paginatorAdapter);
      //have to rewrite here
      //$paginator->setCurrentPageNumber( $pageNo );
      $paginator->setItemCountPerPage(10);
      $paginator->setPageRange(5);
      return $paginator;
    }
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }
  /* deleting forum information by admin*/
  public function deleteForum($forumIdPost)
  {
    if($forumIdPost){
      $data = array (
        'forum_id' => $forumIdPost,
      );
      $this->tableGateway->delete($data, array('forum_id' => $forumIdPost));
    }
  }
}

