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
      /*want to add between validator*/ 
      $inputFilter->add($factory->createInput(array(
          'name' => 'surName',
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
                'pattern' => '/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'firstName',
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
                'pattern' => '/^[ぁ-んァ-ヶー一-龠 　\r\n\t]+?$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'surNameYomi',
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
                'pattern' => '/^([あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをんが>ぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょゎ・ー　])+?$/'
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'firstNameYomi',
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
                'pattern' => '/^([あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをんが>ぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょゎ・ー　])+?$/'
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'email',
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
            'pattern' => '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/'
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'zipFirst',
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
                'min' => 3, 
                'max' => 3, 
                'pattern' => '/^([0-9])$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'zipLast',
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
                'max' => 4, 
                'pattern' => '/^([0-9])$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'prefId',
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
                'max' => 2, 
                'pattern' => '/^([0-9])$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'city',
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
                'min' => 2, 
                'max' => 30, 
                'pattern' => '/^[ぁ-んァ-ヶー一-龠a-zA-Z0-9 　\r\n\t]+?$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'town',
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
                'min' => 2, 
                'max' => 30, 
                'pattern' => '/^[ぁ-んァ-ヶー一-龠a-zA-Z0-9 　\r\n\t]+?$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'building',
          'required' => false,
          'filters' => array( 
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
          ),
          'validators' => array(
            array(
              'name' => 'StringLength',
              'options' => array(
                'encoding' => 'UTF-8', 
                'min' => 2, 
                'max' => 30, 
                'pattern' => '/^[ぁ-んァ-ヶー一-龠a-zA-Z0-9 　\r\n\t]+?$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'phoneFirst',
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
                'max' => 4, 
                'pattern' => '/^([0-9])$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'phoneSecond',
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
                'max' => 4, 
                'pattern' => '/^([0-9])$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'phoneThird',
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
                'max' => 4, 
                'pattern' => '/^([0-9])$/',
            ),  
          ),
        ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'forumId',
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
                'max' => 19, 
                'pattern' => '/^([0-9])$/',
            ),  
          ),
        ),
      )));
      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }

}

