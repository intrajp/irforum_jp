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

class Forum
{
  public $forum_id;
  public $date;
  public $title;
  public $active;

  public function exchangeArray($data)
  {
    $this->forum_id = (isset($data['forum_id'])) ? $data['forum_id'] : 0;
    $this->date = (isset($data['date'])) ? $data['date'] : null;
    $this->title = (isset($data['title'])) ? $data['title'] : null;
    $this->active = (isset($data['active'])) ? $data['active'] : null;
  }

}
