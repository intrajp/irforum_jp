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
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;

class IruserTable
{
  protected $tableGateway;
  protected $keyPost;
  protected $valuePost;

  public function __construct(TableGateway $tableGateway)
  {
    $this->tableGateway = $tableGateway;
  }
  public function fetchAll()
  {
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }
  /* this function returns paginated results from database table */
  //public function fetchAllPaginated( $paginated = false, $where = false )
  public function fetchAllPaginated( $paginated = false, $where = false, $forumId )
  {
    if($where){
      foreach($where as $key => $value){
        $this->keyPost = $key;
        $this->valuePost = $value."%";
      }
    }
    $key = $this->keyPost;
    $value = $this->valuePost;
    if($paginated) {
      $sql = new Sql( $this->tableGateway->adapter );
      $select = $sql->select();
      $select->from('iruser');
      $select->columns(array('user_id', 'surname', 'firstname','surname_yomi','firstname_yomi','email',
        'zip_first','zip_last','city','town','building','phone_first','phone_second','phone_third','forum_id'));
      $select->where->like( 'surname_yomi', $this->valuePost );  
      if($forumId){
        $select->where(array('forum_id' => $forumId));
      }
      $select->order( 'user_id desc' );
      $select->join( 'pref', 'iruser.pref_id=pref.pref_id',
        array(
          'pref_name_kanji'
        )
      );
      //echo $select->getSqlString();
      $resultSetPrototype = new ResultSet();
      $resultSetPrototype->setArrayObjectPrototype(new Iruser());
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

  public function getPageAll( $pageNo )
  {
    $sql = new Sql( $this->tableGateway->adapter );
    $select = $sql->select();
    $select->from('iruser');
    $select->columns(array('user_id', 'surname', 'firstname','surname_yomi','firstname_yomi'));
    //$select->where( $where );
    $select->order( 'user_id desc' );
    $select->join( 'pref', 'iruser.pref_id=pref.pref_id',
      array(
        'pref_name_kanji'
      )
    );
    //for debug -- this echoes raw sql!!
    //echo $select->getSqlString();

    $adapter = new DbSelect($select, $sql);
    $paginator = new paginator($adapter);
    $paginator->setCurrentPageNumber( $pageNo );
    $paginator->setItemCountPerPage(10);
    $paginator->setPageRange(5);
    return $paginator;
  }
  public function fetchAllWithUserId( $where = null )
  {
    $sql = new Sql( $this->tableGateway->adapter );
    $select = $sql->select();
    $select->from('iruser');
    $select->columns(array('user_id', 'surname', 'firstname','surname_yomi','firstname_yomi','email',
      'zip_first','zip_last','pref_id','city','town','building','phone_first','phone_second','phone_third',
      'forum_id'));
    $select->where( $where );
    $select->join( 'pref', 'iruser.pref_id = pref.pref_id',
      array(
        'pref_name_kanji',
      )
    );
    $select->join( 'forum', 'forum.forum_id = iruser.forum_id',
      array(
        'title',
        'active',
      )
    );
    /*for debug*/
    //echo $select->getSqlString($adapter->getPlatform());
    //echo $select->getSqlString();
    $resultSetPrototype = new ResultSet();
    $resultSetPrototype->setArrayObjectPrototype(new Iruser());
    $paginatorAdapter = new DbSelect(
       $select,
       $this->tableGateway->getAdapter(),
       $resultSetPrototype
    );
    $paginator = new Paginator($paginatorAdapter);
    return $paginator;
  }
  public function saveIruser(Iruser $iruser)
  {
    $data = array (
      'surname' => $iruser->surname,
      'firstname' => $iruser->firstname,
      'surname_yomi'=> $iruser->surname_yomi,
      'firstname_yomi' => $iruser->firstname_yomi,
      'pref_id' => $iruser->pref_id,
      'email' => $iruser->email,
      'zip_first' => $iruser->zip_first,
      'zip_last'=> $iruser->zip_last,
      'city' => $iruser->city,
      'town'=> $iruser->town,
      'building' => $iruser->building,
      'phone_first' => $iruser->phone_first,
      'phone_second' => $iruser->phone_second, 
      'phone_third' => $iruser->phone_third,
      'forum_id' => $iruser->forum_id,
    );
    $this->tableGateway->insert($data);
  }
  /* updating user information by admin*/
  public function updateIruser(Container $user_update_session)
  {
    if($user_update_session->userId){
      $userUpdateSessionUserId = $user_update_session->userId;
      $userUpdateSessionSurName = $user_update_session->surName;
      $userUpdateSessionFirstName = $user_update_session->firstName;
      $userUpdateSessionSurNameYomi = $user_update_session->surNameYomi;
      $userUpdateSessionFirstNameYomi = $user_update_session->firstNameYomi;
      $userUpdateSessionEmail = $user_update_session->email;
      $userUpdateSessionZipFirst = $user_update_session->zipFirst;
      $userUpdateSessionZipLast = $user_update_session->zipLast;
      $userUpdateSessionPrefId = $user_update_session->prefId;
      $userUpdateSessionCity = $user_update_session->city;
      $userUpdateSessionTown = $user_update_session->town;
      $userUpdateSessionBuilding = $user_update_session->building;
      $userUpdateSessionPhoneFirst = $user_update_session->phoneFirst;
      $userUpdateSessionPhoneSecond = $user_update_session->phoneSecond;
      $userUpdateSessionPhoneThird = $user_update_session->phoneThird;
      //clear user_update session
      $user_update_session->getManager()->getStorage()->clear('user_update');
      $data = array (
        'surname' => $userUpdateSessionSurName,
        'firstname' => $userUpdateSessionFirstName,
        'surname_yomi'=> $userUpdateSessionSurNameYomi,
        'firstname_yomi' => $userUpdateSessionFirstNameYomi,
        'pref_id' => $userUpdateSessionPrefId,
        'email' => $userUpdateSessionEmail,
        'zip_first' => $userUpdateSessionZipFirst,
        'zip_last'=> $userUpdateSessionZipLast,
        'city' => $userUpdateSessionCity,
        'town'=> $userUpdateSessionTown,
        'building' => $userUpdateSessionBuilding,
        'phone_first' => $userUpdateSessionPhoneFirst,
        'phone_second' => $userUpdateSessionPhoneSecond, 
        'phone_third' => $userUpdateSessionPhoneThird,
      );
      $this->tableGateway->update($data, array('user_id' => $userUpdateSessionUserId));
    }
  }
  /* deleting user information by admin*/
  public function deleteIruser($userIdPost)
  {
    if($userIdPost){
      $data = array (
        'user_id' => $userIdPost,
      );
      $this->tableGateway->delete($data, array('user_id' => $userIdPost));
    }
  }
}

