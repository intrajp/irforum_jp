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
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\Regex;
use Zend\Validator\Digits;
use Zend\Validator\Between;

class Password implements InputFilterAwareInterface
{
  protected $inputFilter;
  public $loginName;
  public $password;

  /*unused*/
  public function setInputFilter(InputFilterInterface $inputFilter)
  {
    throw new \Exception("Not used");
  }
  public function exchangeArray($data)
  {
    $this->loginName = (isset($data['login_name'])) ? $data['login_name'] : 'guest';
    $this->password = (isset($data['password'])) ? $data['password'] : 0;
  }

  /*inputfileter*/
  public function getInputFilter()
  {
    if (!$this->inputFilter){
      $inputFilter = new InputFilter();
      $factory = new InputFactory();
      $inputFilter->add($factory->createInput(array(
          'name' => 'loginNameFilter',
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
                'pattern' => '/^[a-zA-Z0-9]+?$/',
              ),  
            ),  
          ),
      )));
      $inputFilter->add($factory->createInput(array(
          'name' => 'passwordFilter',
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
                'min' => 8, 
                'max' => 16, 
              ),  
            ),
            array(
              'name' => 'Regex',
              'options' => array(
                'pattern' => '/^[a-zA-Z0-9]+?$/',
              ),  
            ),  
          ),
      )));
      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }
}

