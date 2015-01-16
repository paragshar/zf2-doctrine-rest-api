<?php
  
namespace User\Entity;
  
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
  
/**
 * Base Entity
 * 
 */
class Base
{

    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $rawdata;

    public function __construct($data){
        $this->set($data);
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function getInputFilter($em){
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
        unset(
            $vars['rawdata'], 
            $vars['inputFilter'],
            $vars['__initializer__'], 
            $vars['__cloner__'], 
            $vars['__isInitialized__']
        );
        foreach($vars as $key =>$val){
            if(is_object($val))
                $vars[$key] = $val->toArray();
        }
        return $vars;
    }

    public function validate($em = null, $throwException = true){
        $errorMessages = array();
        $vars = get_object_vars($this);
        foreach($vars as $key =>$val){
            if(is_object($val) && method_exists($this->$key, "validate")){
                $entity = $this->$key;
                $result = $entity->validate($em, false);
                if($result !== true){
                    array_push($errorMessages, $result[0]);
                }
                    
            }
        }

        $this->getInputFilter($em);
        $this->inputFilter->setData($this->toArray());
        if(!$this->inputFilter->isValid()){
            $cls = str_ireplace("DoctrineORMModule\\Proxy\\__CG__\\", "", get_class($this));
            array_push($errorMessages, array($cls=>$this->inputFilter->getMessages()));
        }
            
        
        if(count($errorMessages) > 0){
            if($throwException)
                throw new \User\Exception\DataValidationException($errorMessages);
            else
                return $errorMessages;
        }else
            return true;
    }

    public function set($data){
        $this->rawdata = $data;        
        if(!empty($data)){
            $vars = get_class_vars(get_class($this));
            foreach($data as $key => $val){
                if(is_array($val) && array_key_exists($key, $vars)){
                    if(empty($this->$key)){
                        $className = __NAMESPACE__."\\".$key;
                        $val = new $className($val);
                    }else{
                        $obj = $this->$key;
                        $obj->set($val);
                        $val = $obj;
                    }
                    
                }
                $this->$key = $val;
            }
        } 
    }
}