<?php
namespace AppBundle\Entity\Report\Promotion;

use AppBundle\Entity\Organisation\Organisation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="report__promotion__organisation_usage")
 */
class PromotionOrganisationUsage
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var PromotionUsage
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Report\Promotion\PromotionUsage", inversedBy="organisationUsages")
     * @ORM\JoinColumn(name="id_promotion_usage", referencedColumnName="id")
     */
    private $promotionUsage;

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Organisation")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     */
    private $organisation;

    /**
     * @var int
     * @ORM\Column(name="redemption_count", type="integer",options={"default" = 0})
     */
    private $redemptionCount;

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
     * @return Organisation
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param Organisation $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * @return int
     */
    public function getRedemptionCount()
    {
        return $this->redemptionCount;
    }

    /**
     * @param int $redemptionCount
     */
    public function setRedemptionCount($redemptionCount)
    {
        $this->redemptionCount = $redemptionCount;
    }

    /**
     * @return PromotionUsage
     */
    public function getPromotionUsage()
    {
        return $this->promotionUsage;
    }

    /**
     * @param PromotionUsage $promotionUsage
     */
    public function setPromotionUsage($promotionUsage)
    {
        $this->promotionUsage = $promotionUsage;
    }


}