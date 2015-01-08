<?php

namespace User\Validator;

use Zend\Validator\AbstractValidator;
use Doctrine\ORM\EntityManager;

abstract class ValidatorBase extends AbstractValidator{
  /**
   * @var Doctrine\ORM\EntityManager
   */
  protected $_em;


  public function __construct(EntityManager $em){
    $this->_em = $em;
    parent::__construct();
  }

  public function em(){
    return $this->_em;
  }
}