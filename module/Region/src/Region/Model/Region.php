<?php
namespace Region\Model;

use Zend\InputFilter\Factory as InputFactory;     
use Zend\InputFilter\InputFilter;                 
use Zend\InputFilter\InputFilterAwareInterface;

class Region implements InputFilterAwareInterface
{
    public $_regionId;
    public $_regionLabel;
    public $_regionWeight;
    protected $_inputFilter;  

    public function exchangeArray($data)
    {
        $this->_regionId = (isset($data['RegionId'])) ? $data['RegionId'] : null;
        $this->_regionLabel = (isset($data['RegionLabel'])) ? $data['RegionLabel'] : null;
        $this->_regionWeight = (isset($data['RegionWeight'])) ? $data['RegionWeight'] : null;
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
                'name'     => 'RegionId',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'RegionLabel',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'RegionWeight',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $this->_inputFilter = $inputFilter;
        }

        return $this->_inputFilter;
    }
}