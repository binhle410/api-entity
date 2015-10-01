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
 * @ORM\Entity
 * @ORM\Table(name="redemption")
 */
class Redemption
{

    /**
     * @var Promotion
     * @ORM\Id @ORM\ManyToOne(targetEntity="Promotion",inversedBy="redemptions",cascade={"persist","merge","remove"})
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



}