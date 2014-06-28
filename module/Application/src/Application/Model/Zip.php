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

class Zip 
{
  public $city;
  public $town;
  public $pref_id;
  public $pref_name_kanji;
  public function exchangeArray($data)
  {
    $this->city = (isset($data['city'])) ? $data['city'] : 'test';
    $this->town = (isset($data['town'])) ? $data['town'] : 0;
    $this->pref_id = (isset($data['pref_id'])) ? $data['pref_id'] : 0; 
    $this->pref_name_kanji = (isset($data['pref_name_kanji'])) ? $data['pref_name_kanji'] : 'test'; 
  }
}

