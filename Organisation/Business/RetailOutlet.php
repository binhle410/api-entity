<?php
// src/AppBundle/Entity/Organisation/RetailOutlet.php
namespace AppBundle\Entity\Organisation\Business;

use AppBundle\Entity\Core\Location\Address;
use AppBundle\Entity\Core\Location\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisation__business__retail_outlet")
 * retail_outlet is abbreviated as outlet in some classes
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_business_outlet",
 *         parameters = { "businessId" = "expr(object.getBusiness().getId())","outlet" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation("location", href = @Hateoas\Route(
 *         "get_business_outlet_location",
 *         parameters = { "businessId" = "expr(object.getBusiness().getId())","outlet" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getLocation() === null)")
 * )
 *

 * @Hateoas\Relation("business", href = @Hateoas\Route(
 *         "get_business",
 *         parameters = { "entity" = "expr(object.getBusiness().getId())" },
 *         absolute = true
 *     ),
 * exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getBusiness() === null)")
 *)

 * @Hateoas\Relation("redemptions", href = @Hateoas\Route(
 *         "get_business_outlet_redemptions",
 *         parameters = { "businessId" = "expr(object.getBusiness().getId())","outlet" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getRedemptions() === null)")
 *)
 */
class RetailOutlet
{
    /**
     * slide 23
     *
     * adress:String, unitNo, mallName,postalCode, geoLocation:Location,
     *
     */

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->redemptions = new ArrayCollection();
    }

    /**
     * @var Location
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\Location\Location",cascade={"merge","persist"})
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $location;

    /**
     * @var Business
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Business\Business", inversedBy="retailOutlets",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_business", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $business;

    /**
     * @var ArrayCollection Redemption
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\Redemption", mappedBy="retailOutlet",orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude
     */
    private $redemptions;

    /**
     * @var string
     * @ORM\Column(name="contact_no",length=25)
     */
    private $contactNo;
    /**
     * @var string
     * @ORM\Column(name="name",length=250)
     */
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
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
    public function setLocation($location)
    {
        $this->location = $location;
        $location->setEntity(__CLASS__);
    }

    /**
     * @return Business
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param Business $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
    }

    /**
     * @return ArrayCollection
     */
    public function getRedemptions()
    {
        return $this->redemptions;
    }

    /**
     * @param ArrayCollection $redemptions
     */
    public function setRedemptions($redemptions)
    {
        $this->redemptions = $redemptions;
    }

    /**
     * @return string
     */
    public function getContactNo()
    {
        return $this->contactNo;
    }

    /**
     * @param string $contactNo
     */
    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;
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


}