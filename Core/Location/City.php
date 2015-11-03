<?php
namespace AppBundle\Entity\Core\Location;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="location_city")
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Province", inversedBy="cities")
     * @ORM\JoinColumn(name="id_province", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $province;

    /**
     * @var ArrayCollection Districts
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\City", mappedBy="city")
     **/
    private $districts;
    /**
     * @var string
     * @ORM\Column(length=50, type="string",nullable=true)
     */
    private $name;

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

    /**
     * @return ArrayCollection
     */
    public function getDistricts()
    {
        return $this->districts;
    }

    /**
     * @param ArrayCollection $districts
     */
    public function setDistricts($districts)
    {
        $this->districts = $districts;
    }

    /**
     * @return Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param Province $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

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

}