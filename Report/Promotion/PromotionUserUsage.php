<?php
namespace AppBundle\Entity\Report\Promotion;
use AppBundle\Entity\Core\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="promotion_user_usage")
 */
class PromotionUserUsage
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
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     */
    private $promotionUsage;

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getPromotionUsage()
    {
        return $this->promotionUsage;
    }

    /**
     * @param int $promotionUsage
     */
    public function setPromotionUsage($promotionUsage)
    {
        $this->promotionUsage = $promotionUsage;
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