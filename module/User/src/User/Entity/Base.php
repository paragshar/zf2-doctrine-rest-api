<?php
  
namespace User\Entity;
  
use Doctrine\ORM\Mapping as ORM;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
  
/**
 * Base Entity
 * 
 */
class Base implements InputFilterAwareInterface
{

    protected $inputFilter;
    protected $em;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $rawdata;

    public function __construct($em, $data){
        $this->em = $em;
        $this->getInputFilter();
        $this->set($data);
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setInputFilter(InputFilterInterface $inputFilter){

    }

    public function getInputFilter(){
        if (!$this->inputFilter) {
            $this->inputFilter = new InputFilter();
        }
        return $this->inputFilter;
    }

    /**
     * Convert the object to an array.
     * @return array
    */
    public function toArray() {
        $vars = get_object_vars($this);
        unset($vars['rawdata'], $vars['inputFilter'], $vars['em']);
        foreach($vars as $key =>$val){
            if(is_object($val))
                $vars[$key] = $val->toArray();
        }
        return $vars;
    }

    public function __get($property){
        return $this->property;
    }

    public function __set($property, $value){
        $this->property = $value;
    }

    public function set($data){
        $this->rawdata = $data;

        $this->inputFilter->setData($data);
        if(!$this->inputFilter->isValid()){
            throw new \User\Exception\DataValidationException($this->inputFilter->getMessages());
        }else{
            if(!empty($data)){
                $vars = get_class_vars(get_class($this));
                foreach($data as $key => $val){
                    if(is_array($val) && array_key_exists($key, $vars)){
                        $className = __NAMESPACE__."\\".$key;
                        $val = new $className($this->em, $val);
                    }
                    $this->$key = $val;
                }
            }
        }
        
    }
}