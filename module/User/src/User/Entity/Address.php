<?php
  
namespace User\Entity;
  
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use User\Entity\Base;

/** Address
 *
 * @ORM\Entity
 * @ORM\Table(name="address")
 * @property string $line1
 * @property string $line2
 * @property string $city
 * @property string $country
 * @property string $zipcode
 * 
 */
class Address extends Base{

	/**
     * @ORM\Column(type="string")
     */
    protected $line1;

    /**
     * @ORM\Column(type="string")
     */
    protected $line2;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="string")
     */
    protected $country;

    /**
     * @ORM\Column(type="string")
     */
    protected $zipcode;

    public function __construct($data){
        parent::__construct($data);
    }

    public function getInputFilter($em){
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
 
            $inputFilter->add(array(
                'name'     => 'line1',
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
                            'min'      => 10,
                            'max'      => 50,
                        ),
                    ),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'line2',
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
                            'min'      => 10,
                            'max'      => 50,
                        ),
                    ),
                ),
            ));
 
            $inputFilter->add(array(
                'name'     => 'city',
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
                            'min'      => 2,
                            'max'      => 50,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'country',
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
                            'min'      => 2,
                            'max'      => 20,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'zipcode',
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
                            'min'      => 5,
                            'max'      => 10,
                        ),
                    ),
                ),
            ));
 
            $this->inputFilter = $inputFilter;
        }
 
        return $this->inputFilter;
    }
}


