<?php
// src/AppBundle/Entity/Merchant/Marketing/Promotion/Redemption.php

namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Business\RetailOutlet;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
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
 *         parameters = { "promotionId" = "expr(object.getPromotion().getId())","redemption"="expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} }
 * )
 *
 * @Hateoas\Relation(
 *  "promotion",
 *  href= @Hateoas\Route(
 *         "get_promotion",
 *         parameters = {"promotion"="expr(object.getPromotion().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getPromotion() === null)")
 * )
 *
 * @Hateoas\Relation(
 *  "retail_outlet",
 *  href= @Hateoas\Route(
 *         "get_business_outlet",
 *         parameters = {"businessId"="expr(object.getRetailOutlet().getBusiness().getId())","outlet"="expr(object.getRetailOutlet().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getRetailOutlet() === null)")
 * )
 *
 * @Hateoas\Relation(
 *  "user",
 *  href= @Hateoas\Route(
 *         "get_user",
 *         parameters = {"username"="expr(object.getUser().getUsername())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getUser() === null)")
 * )
 *
 * @ORM\Entity
 * @ORM\Table(name="marketing__promotion__redemption")
 */
class Redemption implements BaseVoterSupportInterface
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
        $this->redeemedAt = new \DateTime();
        $this->code = strtoupper(chr(rand(64, 90)) . base_convert(uniqid(), 10, 32));
    }

    /**
     * @var Promotion
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\Promotion",inversedBy="redemptions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_promotion", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $promotion;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $user;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Organisation")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $organisation;

    /**
     * @var RetailOutlet
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Business\RetailOutlet",inversedBy="redemptions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_outlet", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $retailOutlet;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="redeemed_at")
     */
    private $redeemedAt;

    /**
     * @var string
     * @ORM\Column(type="string", name="code", unique=true)
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(type="string", name="user_pin")
     */
    private $userPIN;

    /**
     * @var string
     * @ORM\Column(type="string", name="merchant_pin")
     */
    private $merchantPIN;


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
        $promotion->getRedemptions()->add($this);
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
        $retailOutlet->getRedemptions()->add($this);
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

    /**
     * @return string
     */
    public function getUserPIN()
    {
        return $this->userPIN;
    }

    /**
     * @param string $userPIN
     */
    public function setUserPIN($userPIN)
    {
        $this->userPIN = $userPIN;
    }

    /**
     * @return string
     */
    public function getMerchantPIN()
    {
        return $this->merchantPIN;
    }

    /**
     * @param string $merchantPIN
     */
    public function setMerchantPIN($merchantPIN)
    {
        $this->merchantPIN = $merchantPIN;
    }

    /**
     * @return User
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param User $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


}