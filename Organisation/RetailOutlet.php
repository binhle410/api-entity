<?php
// src/AppBundle/Entity/Organisation/RetailOutlet.php
namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\Location\Address;
use AppBundle\Entity\Core\Location\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisation_business_retail_outlet")
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

    /**
     * @var Location
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\Location\Location")
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $location;

    /**
     * @var Business
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Business", inversedBy="retailOutlets",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
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
     */
    private $contactNo;

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
        $location->setEntity('organisation.organisation');
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


}