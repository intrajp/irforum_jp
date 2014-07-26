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

class Forum implements InputFilterAwareInterface
{
  protected $inputFilter;
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
      $inputFilter->add($factory->createInput(array(
          'name' => 'titleFilter',
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
                'max' => 40, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[ぁ-んァ-ヶー一-龠a-zA-Z0-9() 　\r\n\t]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'dateFilter',
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
                'max' => 20, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[a-zA-Z0-9\/\-]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'activeFilter',
          'required' => true,
          'filters' => array( 
            array('name' => 'Int'),
          ),
          'validators' => array(
            array (
              'name' => 'Between',
              'options' => array (
                'min' => 0,
                'max' => 1,
              ),
            ),  
          ),  
      )));

      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }
}
