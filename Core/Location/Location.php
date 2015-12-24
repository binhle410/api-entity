<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="location__location")
 *
 * @Serializer\XmlRoot("location")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_location",
 *         parameters = { "location" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Hateoas\Relation("addresses", href = @Hateoas\Route(
 *         "get_location_addresses",
 *         parameters = { "locationId" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getAddresses().count() === 0)")
 *)
 *
 * @Hateoas\Relation("addresses.post", href = @Hateoas\Route(
 *         "post_address",
 *         parameters = {   },
 *         absolute = true
 *     )
 *)
 */
class Location
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Address", mappedBy="location")
     * @Serializer\Exclude
     **/
    private $addresses;
    //todo addAddress / removeAddress

    /**
     * @var boolean
     * @ORM\Column(length=125, type="string",options={"default":true},nullable=true)
     */
    private $enabled;


    /**
     * @var string
     * @ORM\Column(length=125, type="string",nullable=false)
     */
    private $name;

    /**
     * @var float
     * @ORM\Column(name="latitude ",type="float",nullable=true)
     */
    private $geoLat;
    /**
     * @var float
     * @ORM\Column(name="longitude ",type="float",nullable=true)
     */
    private $geoLng;

    /**
     * @return float
     */
    public function getGeoLng()
    {
        return $this->geoLng;
    }

    /**
     * @param float $geoLng
     */
    public function setGeoLng($geoLng)
    {
        $this->geoLng = $geoLng;
    }

    /**
     * @return float
     */
    public function getGeoLat()
    {
        return $this->geoLat;
    }

    /**
     * @param float $geoLat
     */
    public function setGeoLat($geoLat)
    {
        $this->geoLat = $geoLat;
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

    /**
     * @return ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param ArrayCollection $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

}