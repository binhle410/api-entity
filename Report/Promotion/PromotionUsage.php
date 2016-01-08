<?php
namespace AppBundle\Entity\Report\Promotion;

use AppBundle\Entity\Merchant\Marketing\Promotion\Promotion;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * TODO Link for promotion, orgUsage and userUsage
 * @Serializer\XmlRoot("promotion")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_promotion_usage",
 *         parameters = { "promotion" = "expr(object.getPromotion().getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} }
 * )
 *
 *
 * @ORM\Entity
 * @ORM\Table(name="report__promotion__usage")
 */
class PromotionUsage implements BaseVoterSupportInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Promotion
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\Promotion",inversedBy="usage")
     * @ORM\JoinColumn(name="id_promotion", referencedColumnName="id")
     * @Serializer\Exclude()
     **/
    private $promotion;

    function __construct()
    {
        $this->organisationUsages = new ArrayCollection();
        $this->userUsages = new ArrayCollection();
        $this->offerUsage = 0;
        $this->weeklyUsage = 0;
        $this->monthlyUsage = 0;
        $this->yearlyUsage = 0;
    }


    /**
     * @var int
     * @ORM\Column(name="offer_usage", type="integer",options={"default" = 0})
     *
     */
    private $offerUsage;

    /**
     * @var int
     * @ORM\Column(name="weekly_usage", type="integer",options={"default" = 0})
     */
    private $weeklyUsage;

    /**
     * @var int
     * @ORM\Column(name="monthly_usage", type="integer",options={"default" = 0})
     */
    private $monthlyUsage;

    /**
     * @var int
     * @ORM\Column(name="yearly_usage", type="integer",options={"default" = 0})
     */
    private $yearlyUsage;

    /**
     * @var ArrayCollection PromotionOrganisationUsage
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Report\Promotion\PromotionOrganisationUsage", mappedBy="promotionUsage", orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude()
     */
    private $organisationUsages;

    /**
     * @var ArrayCollection PromotionUserUsage
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Report\Promotion\PromotionUserUsage", mappedBy="promotionUsage", orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude()
     */
    private $userUsages;

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
     * @return int
     */
    public function getOfferUsage()
    {
        return $this->offerUsage;
    }

    /**
     * @param int $offerUsage
     */
    public function setOfferUsage($offerUsage)
    {
        $this->offerUsage = $offerUsage;
    }

    /**
     * @return int
     */
    public function getMonthlyUsage()
    {
        return $this->monthlyUsage;
    }

    /**
     * @param int $monthlyUsage
     */
    public function setMonthlyUsage($monthlyUsage)
    {
        $this->monthlyUsage = $monthlyUsage;
    }

    /**
     * @return int
     */
    public function getYearlyUsage()
    {
        return $this->yearlyUsage;
    }

    /**
     * @param int $yearlyUsage
     */
    public function setYearlyUsage($yearlyUsage)
    {
        $this->yearlyUsage = $yearlyUsage;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrganisationUsages()
    {
        return $this->organisationUsages;
    }

    /**
     * @param ArrayCollection $organisationUsages
     */
    public function setOrganisationUsages($organisationUsages)
    {
        $this->organisationUsages = $organisationUsages;
    }


    /**
     * @return ArrayCollection
     */
    public function getUserUsages()
    {
        return $this->userUsages;
    }

    /**
     * @param ArrayCollection $userUsages
     */
    public function setUserUsages(ArrayCollection $userUsages)
    {
        $this->userUsages = $userUsages;
    }

    /**
     * @return int
     */
    public function getWeeklyUsage()
    {
        return $this->weeklyUsage;
    }

    /**
     * @param int $weeklyUsage
     */
    public function setWeeklyUsage($weeklyUsage)
    {
        $this->weeklyUsage = $weeklyUsage;
    }

    /**
     * @return Promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param Promotion $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

}