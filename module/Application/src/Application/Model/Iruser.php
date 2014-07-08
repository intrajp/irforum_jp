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
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\Regex;
use Zend\Validator\Digits;
use Zend\Validator\Between;

class Iruser implements InputFilterAwareInterface
{
  protected $inputFilter;
  public $user_id;
  public $surname;
  public $firstname;
  public $surname_yomi;
  public $firstname_yomi;
  public $pref_id;
  public $pref_name_kanji;
  public $email;
  public $zip_first;
  public $zip_last;
  public $city;
  public $town;
  public $building;
  public $phone_first;
  public $phone_second;
  public $phone_third;
  public $forum_id;
  public $title;
  public $active;

  public function exchangeArray($data)
  {
    $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : 0;
    $this->surname = (isset($data['surname'])) ? $data['surname'] : 'test';
    $this->firstname = (isset($data['firstname'])) ? $data['firstname'] : 'test';
    $this->surname_yomi = (isset($data['surname_yomi'])) ? $data['surname_yomi'] : 'test';
    $this->firstname_yomi = (isset($data['firstname_yomi'])) ? $data['firstname_yomi'] : 'test';
    $this->pref_id = (isset($data['pref_id'])) ? $data['pref_id'] : 1;
    $this->pref_name_kanji = (isset($data['pref_name_kanji'])) ? $data['pref_name_kanji'] : 1;
    $this->email = (isset($data['email'])) ? $data['email'] : 'test';
    $this->zip_first = (isset($data['zip_first'])) ? $data['zip_first'] : 0;
    $this->zip_last = (isset($data['zip_last'])) ? $data['zip_last'] : 0;
    $this->city = (isset($data['city'])) ? $data['city'] : 'test';
    $this->town = (isset($data['town'])) ? $data['town'] : 'test';
    $this->building = (isset($data['building'])) ? $data['building'] : 'test';
    $this->phone_first = (isset($data['phone_first'])) ? $data['phone_first'] : 0;
    $this->phone_second = (isset($data['phone_second'])) ? $data['phone_second'] : 0;
    $this->phone_third = (isset($data['phone_third'])) ? $data['phone_third'] : 0;
    $this->forum_id = (isset($data['forum_id'])) ? $data['forum_id'] : 0;
    $this->title = (isset($data['title'])) ? $data['title'] : 0;
    $this->active = (isset($data['active'])) ? $data['active'] : 0;
  }
  /*unused*/
  public function setInputFilter(InputFilterInterface $inputFilter)
  {
    throw new \Exception("Not used");
  }
  /*inputfileter*/
  public function getInputFilter()
  {
    if (!$this->inputFilter){
      $inputFilter = new InputFilter();
      $factory = new InputFactory();
      $inputFilter->add($factory->createInput(array(
          'name' => 'userIdFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'Int'),
          ),
          'validators' => array(
            array (
              'name' => 'Between',
              'options' => array (
                'min' => 1,
                'max' => 9223372036854775807,
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'surNameFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 1, 
                'max' => 20, 
              ),  
            ),  
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'firstNameFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 1, 
                'max' => 20, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'surNameYomiFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 1, 
                'max' => 20, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをんが>ぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょゎ・ー　])+?$/'
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'firstNameYomiFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 1, 
                'max' => 20, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをんが>ぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょゎ・ー　])+?$/'
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'prefIdFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'Int'),
          ),
          'validators' => array(
            array (
              'name' => 'Between',
              'options' => array (
                'min' => 1,
                'max' => 47,
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'emailFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 4, 
                'max' => 40, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/'
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'zipFirstFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array (
              'name' => 'StringLength',
              'options' => array (
                'encoding' => 'UTF-8', 
                'min' => 3,
                'max' => 3,
              ),
            ),  
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([0-9])+$/'
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'zipLastFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array (
              'name' => 'StringLength',
              'options' => array (
                'encoding' => 'UTF-8', 
                'min' => 4,
                'max' => 4,
              ),
            ),  
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([0-9])+$/'
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'cityFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 1, 
                'max' => 20, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[ぁ-んァ-ヶー一-龠a-zA-Z0-9 　\r\n\t]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'townFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 1, 
                'max' => 20, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[ぁ-んァ-ヶー一-龠a-zA-Z0-9 　\r\n\t]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'buildingFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 1, 
                'max' => 20, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[ぁ-んァ-ヶー一-龠a-zA-Z0-9 　\r\n\t]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'phoneFirstFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array (
              'name' => 'StringLength',
              'options' => array (
                'encoding' => 'UTF-8', 
                'min' => 1,
                'max' => 4,
              ),
            ),  
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([0-9])+$/'
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'phoneSecondFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array (
              'name' => 'StringLength',
              'options' => array (
                'encoding' => 'UTF-8', 
                'min' => 1,
                'max' => 4,
              ),
            ),  
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([0-9])+$/'
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'phoneThirdFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array (
              'name' => 'StringLength',
              'options' => array (
                'encoding' => 'UTF-8', 
                'min' => 1,
                'max' => 4,
              ),
            ),  
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^([0-9])+$/'
              ),
            ),  
          ),  
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'forumIdFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'Int'),
          ),
          'validators' => array(
            array (
              'name' => 'Between',
              'options' => array (
                'min' => 1,
                'max' => 9223372036854775807,
              ),
            ),  
          ),  
      )));
      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }

}

