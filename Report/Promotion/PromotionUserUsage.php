<?php
namespace AppBundle\Entity\Report\Promotion;

use AppBundle\Entity\Core\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="report__promotion__user_usage")
 */
class PromotionUserUsage implements BaseVoterSupportInterface
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
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

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