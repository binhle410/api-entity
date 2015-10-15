<?php
// src/AppBundle/Entity/Merchant/Marketing/Promotion/Redemption.php

namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\RetailOutlet;
use Doctrine\ORM\Mapping as ORM;


use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Serializer\XmlRoot("redemption")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_promotion_redemption",
 *         parameters = { "promotion" = "expr(object.getPromotion().getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} }
 * )
 * @Hateoas\Relation(
 *  "redemption.post",
 *  href= @Hateoas\Route(
 *         "post_promotion_redemption",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 *
 * @ORM\Entity
 * @ORM\Table(name="redemption")
 */
class Redemption
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
     * @ORM\ManyToOne(targetEntity="Promotion",inversedBy="redemptions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_promotion", referencedColumnName="id")
     */
    private $promotion;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $user;

    /**
     * @var RetailOutlet
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\RetailOutlet",inversedBy="redemptions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_outlet", referencedColumnName="id")
     */
    private $retailOutlet;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="redeemed_at")
     */
    private $redeemedAt;

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

    /**
     * @return RetailOutlet
     */
    public function getRetailOutlet()
    {
        return $this->retailOutlet;
    }

    /**
     * @param RetailOutlet $retailOutlet
     */
    public function setRetailOutlet($retailOutlet)
    {
        $this->retailOutlet = $retailOutlet;
    }

    /**
     * @return \DateTime
     */
    public function getRedeemedAt()
    {
        return $this->redeemedAt;
    }

    /**
     * @param \DateTime $redeemedAt
     */
    public function setRedeemedAt($redeemedAt)
    {
        $this->redeemedAt = $redeemedAt;
    }

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


}