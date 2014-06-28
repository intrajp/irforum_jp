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

class Pref
{
  public $pref_id;
  public $pref_name_kanji;
  public $pref_name_yomi;

  public function exchangeArray($data)
  {
    $this->pref_id = (isset($data['pref_id'])) ? $data['pref_id'] : 0;
    $this->pref_name_kanji = (isset($data['pref_name_kanji'])) ? $data['pref_name_kanji'] : 'test';
    $this->pref_name_yomi = (isset($data['pref_name_yomi'])) ? $data['pref_name_yomi'] : 'test'; 
  }
}

