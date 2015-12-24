<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
/**
 * @ORM\Entity
 * @ORM\Table(name="location__address")
 *
 * @Serializer\XmlRoot("address")
 * @Hateoas\Relation("self",
 *  href= @Hateoas\Route(
 *         "get_address",
 *         parameters = { "entity" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} }
 * )
 *
 * @Hateoas\Relation("location", href = @Hateoas\Route(
 *         "get_location",
 *         parameters = { "location" = "expr(object.getLocation().getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getLocation() === null)")
 *)
 *
 * @Hateoas\Relation("province", href = @Hateoas\Route(
 *         "get_province",
 *         parameters = { "province" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getProvince() === null)")
 *)
 *
 * * @Hateoas\Relation("district", href = @Hateoas\Route(
 *         "get_district",
 *         parameters = { "district" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getDistrict() === null)")
 *)
 *
 ** * @Hateoas\Relation("street", href = @Hateoas\Route(
 *         "get_street",
 *         parameters = { "street" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getStreet() === null)")
 *)
 *
 * @Hateoas\Relation("ward", href = @Hateoas\Route(
 *         "get_ward",
 *         parameters = { "ward" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getWard() === null)")
 *)
 *
 * @Hateoas\Relation("city", href = @Hateoas\Route(
 *         "get_city",
 *         parameters = { "city" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getCity() === null)")
 *)
 *
 * @Hateoas\Relation("country", href = @Hateoas\Route(
 *         "get_country",
 *         parameters = { "country" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getCountry() === null)")
 * )
 *
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="address")
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $location;

    /**
     * @var string
     * @ORM\Column(length=250, type="string", nullable=true) */
    private $value;



    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $room;
    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $level;
    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $block;

    /** @ORM\Column(length=120, type="string",nullable=true) */
    private $number;

    /**
     * @var Street
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Street", inversedBy="children")
     * @ORM\JoinColumn(name="id_street", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $street;

    /**
     * @var Ward
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Ward", inversedBy="children")
     * @ORM\JoinColumn(name="id_ward", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $ward;

    /**
     * @var District
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\District", inversedBy="children")
     * @ORM\JoinColumn(name="id_district", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $district;

    /**
     * @var City
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\City", inversedBy="children")
     * @ORM\JoinColumn(name="id_city", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $city;

    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Province", inversedBy="children")
     * @ORM\JoinColumn(name="id_province", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $province;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Country", inversedBy="children")
     * @ORM\JoinColumn(name="id_country", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $country;

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
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param Street $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return Ward
     */
    public function getWard()
    {
        return $this->ward;
    }

    /**
     * @param Ward $ward
     */
    public function setWard($ward)
    {
        $this->ward = $ward;
    }

    /**
     * @return District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param District $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity($city)
    {
        $this->city = $city;
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
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

}