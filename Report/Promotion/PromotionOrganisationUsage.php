<?php
namespace AppBundle\Entity\Report\Promotion;

use AppBundle\Entity\Organisation\Organisation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="promotion_organisation_usage")
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
     * @var PromotionReport
     * @ORM\ManyToOne(targetEntity="PromotionReport", inversedBy="organisationUsages")
     * @ORM\JoinColumn(name="id_promotion_report", referencedColumnName="id")
     */
    private $promotionReport;

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Organisation")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     */
    private $organisation;

    /**
     * @var int
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
     * @return PromotionReport
     */
    public function getPromotionReport()
    {
        return $this->promotionReport;
    }

    /**
     * @param PromotionReport $promotionReport
     */
    public function setPromotionReport($promotionReport)
    {
        $this->promotionReport = $promotionReport;
    }


}