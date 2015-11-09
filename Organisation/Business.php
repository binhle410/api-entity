<?php
// src/AppBundle/Entity/Organisation/Business.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\Core\Tag;
use AppBundle\Entity\Merchant\Marketing\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisation_business")
 * @Serializer\XmlRoot("business")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_business",
 *         parameters = { "entity" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation("owner", href = @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getOwner().getId())" },
 *         absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation("promotions", href = @Hateoas\Route(
 *         "get_business_promotions",
 *         parameters = { "business" = "expr(object.getOwner().getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getPromotions().count() === 0)")
 * )
 *
 * @Hateoas\Relation("tags", href = @Hateoas\Route(
 *         "get_business_tags",
 *         parameters = { "business" = "expr(object.getOwner().getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getTags().count() === 0)")
 * )
 *
 * @Hateoas\Relation("outlets", href = @Hateoas\Route(
 *         "get_business_outlets",
 *         parameters = { "business" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getRetailOutlets().count() === 0)")
 * )
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

    function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->retailOutlets = new ArrayCollection();
    }

    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation", inversedBy="businesses")
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
     * @Serializer\Exclude
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Core\Tag",cascade={"merge","persist"})
     * @ORM\JoinTable(name="businesses_tags",
     *      joinColumns={@ORM\JoinColumn(name="id_business", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $tags;

    /**
     * @param Tag $tag
     * @return Business
     */
    public function addTag($tag)
    {
        $this->tags->add($tag);
        return $this;
    }

    /**
     * @param Tag $tag
     * @return Business
     */
    public function removeTag($tag)
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\RetailOutlet", mappedBy="business", orphanRemoval=true)
     * @Serializer\Exclude
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