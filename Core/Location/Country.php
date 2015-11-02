<?php
namespace AppBundle\Entity\Core\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="location_country")
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\Province", mappedBy="country")
     **/
    private $provinces;

    /**
     * @var string
     * @ORM\Column(length=50, type="string",nullable=true)
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(length=50, type="string",nullable=true)
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return ArrayCollection
     */
    public function getProvinces()
    {
        return $this->provinces;
    }

    /**
     * @param ArrayCollection $provinces
     */
    public function setProvinces($provinces)
    {
        $this->provinces = $provinces;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function __construct()
    {
        $this->provinces = new ArrayCollection();
    }

}