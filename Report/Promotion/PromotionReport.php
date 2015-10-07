<?php
namespace AppBundle\Entity\Report\Promotion;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="promotion_report")
 */
class PromotionReport
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="offer_usage", type="integer")
     */
    private $offerUsage;
    /**
     * @var int
     * @ORM\Column(name="monthly_usage", type="integer")
     */
    private $monthlyUsage;

    /**
     * @var int
     * @ORM\Column(name="yearly_usage", type="integer")
     */
    private $yearlyUsage;

    /**
     * @var ArrayCollection PromotionOrganisationUsage
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Report\Promotion\PromotionOrganisationUsage", mappedBy="promotionReport", orphanRemoval=true,cascade={"persist","merge","remove"})
     */
    private $organisationUsages;
    /**
     * @var ArrayCollection PromotionUserUsage
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Report\Promotion\PromotionUserUsage", mappedBy="promotionReport", orphanRemoval=true,cascade={"persist","merge","remove"})
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

}