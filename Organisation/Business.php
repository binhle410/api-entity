<?php
// src/AppBundle/Entity/Organisation/Business.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Merchant\Marketing\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="business")
 * @Serializer\XmlRoot("business")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_business",
 *         parameters = { "business" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 *
 *
 */
class Business
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation", inversedBy="businesses",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
     */
    private $owner;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\Promotion", mappedBy="business", orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude
     */
    private $promotions;

    public function addPromotion(Promotion $promotion)
    {
        $this->promotions->add($promotion);
        $promotion->setBusiness($this);
        return $this;
    }

    public function removePromotion(Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
        $promotion->setBusiness(null);
        return $this;
    }

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Core\Tag", inversedBy="businesses")
     * @ORM\JoinTable(name="businesses_tags",
     *      joinColumns={@ORM\JoinColumn(name="id_business", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     */
    private $tags;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\RetailOutlet", mappedBy="business", orphanRemoval=true)
     */
    private $retailOutlets;

    /**
     *
     * Integrate with SonataMediaBundle to store app images along with banner images
     */

    /** @ORM\Column(length=10,name="merchant_code") */
    private $merchantCode;


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
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param Organisation $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return ArrayCollection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @param ArrayCollection $promotions
     */
    public function setPromotions($promotions)
    {
        $this->promotions = $promotions;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return ArrayCollection
     */
    public function getRetailOutlets()
    {
        return $this->retailOutlets;
    }

    /**
     * @param ArrayCollection $retailOutlets
     */
    public function setRetailOutlets($retailOutlets)
    {
        $this->retailOutlets = $retailOutlets;
    }

    /**
     * @return mixed
     */
    public function getMerchantCode()
    {
        return $this->merchantCode;
    }

    /**
     * @param mixed $merchantCode
     */
    public function setMerchantCode($merchantCode)
    {
        $this->merchantCode = $merchantCode;
    }


}