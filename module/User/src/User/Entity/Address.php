<?php
  
namespace User\Entity;
  
use Doctrine\ORM\Mapping as ORM;
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

    public function __construct($db, $data){
        parent::__construct($db, $data);
    }
}


