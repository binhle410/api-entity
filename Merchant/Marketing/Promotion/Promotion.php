<?php
namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity
 * @ORM\Table(name="promotion")
 */
class Promotion
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
    $this->benefits = new ArrayCollection();
    }

    /**
     * @var ArrayCollection Benefit
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Benefit", mappedBy="promotion", orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $benefits;


    //todo map
    /**
     * slide 24
     * offerTitle, offerType:String, estimatedValue:float:precision-2,
     * offerCat:Tag, discountAmount:String,
     * totalOfferLimit:int, totalMonthlyLimit:int, totalYearlyLimit:int
     * totalCompanyLimit:int, totalUserLimit:int
     *
     * effectiveFrom:DateTime, expireOn:DateTime, isActive:bool (-true/false-)
     *
     * outletParticipants:ArrayCollection<OutletParticipation>
     * business:Business
     *
     */

}