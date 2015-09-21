<?php
namespace AppBundle\Entity\Merchant\Marketing\Promotion;
use Doctrine\ORM\Mapping as ORM;

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
     * clients:ArrayCollectoin<Organisation>
     * clientEmployees:ArrayCollectoin<UserGroup>
     *
     */
}