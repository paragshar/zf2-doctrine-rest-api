<?php
namespace User\Validator;

use User\Validator\ValidatorBase;

class NoEntityExists extends ValidatorBase{

  private $_ec = null;
  private $_property = null;
  private $_exclude = null;

  const ERROR_ENTITY_EXISTS = "EntityExists";

  protected $messageTemplates = array(
    self::ERROR_ENTITY_EXISTS => "Another record already contains '%value%'"
  );

  protected $messageVariables = array(
        'value' => 'value',
    );

  public function __construct($opts){
    $this->_ec = $opts['class'];
    $this->_property = $opts['property'];
    $this->_exclude = $opts['exclude'];
    parent::__construct($opts['entityManager']);

  }

  public function getQuery(){
    $qb = $this->em()->createQueryBuilder();
    $qb->select('o')
            ->from($this->_ec,'o')
            ->where('o.' . $this->_property .'=:value');

    if ($this->_exclude !== null){ 
      if (is_array($this->_exclude)){

        foreach($this->_exclude as $k=>$ex){                    
          $qb->andWhere('o.' . $ex['property'] .' != :value'.$k);
          $qb->setParameter('value'.$k,$ex['value'] ? $ex['value'] : '');
        }
      } 
    }
    $query = $qb->getQuery();
    return $query;
  }

  public function isValid($value){
    $valid = true;
    $this->setValue($value);

    $query = $this->getQuery();
    $query->setParameter("value", $value);

    $result = $query->execute();

    if (count($result)){ 
      $valid = false;
      $this->error(self::ERROR_ENTITY_EXISTS);
    }
    return $valid;

  }
}