<?php
namespace Region\Model;

use Zend\InputFilter\Factory as InputFactory;     
use Zend\InputFilter\InputFilter;                 
use Zend\InputFilter\InputFilterAwareInterface;


class Contact implements InputFilterAwareInterface
{
    public $_contactId;
    public $_contactPhone;
    public $_contactMail;
    protected $_inputFilter;  

    public function exchangeArray($data)
    {
        $this->_contactId = (isset($data['ContactId'])) ? $data['ContactId'] : null;
        $this->_contactPhone = (isset($data['ContactPhone'])) ? $data['ContactPhone'] : null;
        $this->_contactMail = (isset($data['ContactMail'])) ? $data['ContactMail'] : null;
    }

    
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->_inputFilter = $inputFilter;
    }
    
    
	public function getInputFilter()
    {
        if (!$this->_inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ContactId',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ContactMail',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',
                         'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 255,
                            'messages' => array(
                                \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address format is invalid'
                            )
                        ], 
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ContactPhone',
                'required' => true,
               'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'Regex',
                         'options' => [
                            'encoding' => 'UTF-8',
                            'pattern' => '/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
                             'messages' => array(
                               'regexNotMatch'=>'There was some random custom error'
                            )
                            
                        ], 
                    ),
                ),
            )));

            $this->_inputFilter = $inputFilter;
        }

        return $this->_inputFilter;
    }
}

           