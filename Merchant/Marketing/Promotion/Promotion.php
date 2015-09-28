<?php
namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use AppBundle\Entity\Core\Tag;
use AppBundle\Entity\Organisation\Business;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity
 * @ORM\Table(name="promotion")
 */
class Promotion
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
        $this->benefits = new ArrayCollection();
    }

    /**
     * @var Business
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Business", inversedBy="promotions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_business", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $business;

    /**
     * @var ArrayCollection Benefit
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Benefit", mappedBy="promotion", orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude
     */
    private $benefits;

    /**
     * only manytomany relationship is named with plural nouns.
     * @var ArrayCollection Tag
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Tag")
     * @ORM\JoinTable(name="promotions_tags",
     *      joinColumns={@ORM\JoinColumn(name="id_promotion", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $tags;

    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
        return $this;
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    //todo map
    /**
     * outletParticipants:ArrayCollection<OutletParticipation>
     *
     */


    /**
     * @var int
     * @ORM\Column(name="offer_limit", type="integer")
     */
    private $offerLimit;
    /**
     * @var int
     * @ORM\Column(name="monthly_limit", type="integer")
     */
    private $monthlyLimit;

    /**
     * @var int
     * @ORM\Column(name="yearly_limit", type="integer")
     */
    private $yearlyLimit;

    /**
     * @var int
     * @ORM\Column(name="company_limit", type="integer")
     */
    private $companyLimit;
    /**
     * @var int
     * @ORM\Column(name="user_limit", type="integer")
     */
    private $userLimit;


    /**
     * @var \DateTime
     * @ORM\Column(name="effective_from",type="datetime")
     */
    private $effectiveFrom;
    /**
     * @var \DateTime
     * @ORM\Column(name="expire_on",type="datetime")
     */
    private $expireOn;

    /**
     * @var bool
     * @ORM\Column(name="active",type="boolean")
     */
    private $active = false;

    /**
     * @var string
     * @ORM\Column(length=120,name="title")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(length=120,name="type")
     */
    private $type;

    /**
     * @var float
     * @ORM\Column(name="discount_amount", precision=2)
     */
    private $discountAmount;

    /**
     * @var float
     * @ORM\Column(name="estimated_value", scale=2, precision=5)
     */
    private $estimatedValue;

    /**
     * @return ArrayCollection
     */
    public function getBenefits()
    {
        return $this->benefits;
    }

    /**
     * @param ArrayCollection $benefits
     */
    public function setBenefits($benefits)
    {
        $this->benefits = $benefits;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @param float $discountAmount
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }

    /**
     * @return float
     */
    public function getEstimatedValue()
    {
        return $this->estimatedValue;
    }

    /**
     * @param float $estimatedValue
     */
    public function setEstimatedValue($estimatedValue)
    {
        $this->estimatedValue = $estimatedValue;
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
     * @return int
     */
    public function getOfferLimit()
    {
        return $this->offerLimit;
    }

    /**
     * @param int $offerLimit
     */
    public function setOfferLimit($offerLimit)
    {
        $this->offerLimit = $offerLimit;
    }

    /**
     * @return int
     */
    public function getMonthlyLimit()
    {
        return $this->monthlyLimit;
    }

    /**
     * @param int $monthlyLimit
     */
    public function setMonthlyLimit($monthlyLimit)
    {
        $this->monthlyLimit = $monthlyLimit;
    }

    /**
     * @return int
     */
    public function getYearlyLimit()
    {
        return $this->yearlyLimit;
    }

    /**
     * @param int $yearlyLimit
     */
    public function setYearlyLimit($yearlyLimit)
    {
        $this->yearlyLimit = $yearlyLimit;
    }

    /**
     * @return int
     */
    public function getCompanyLimit()
    {
        return $this->companyLimit;
    }

    /**
     * @param int $companyLimit
     */
    public function setCompanyLimit($companyLimit)
    {
        $this->companyLimit = $companyLimit;
    }

    /**
     * @return int
     */
    public function getUserLimit()
    {
        return $this->userLimit;
    }

    /**
     * @param int $userLimit
     */
    public function setUserLimit($userLimit)
    {
        $this->userLimit = $userLimit;
    }

    /**
     * @return \DateTime
     */
    public function getEffectiveFrom()
    {
        return $this->effectiveFrom;
    }

    /**
     * @param \DateTime $effectiveFrom
     */
    public function setEffectiveFrom($effectiveFrom)
    {
        $this->effectiveFrom = $effectiveFrom;
    }

    /**
     * @return \DateTime
     */
    public function getExpireOn()
    {
        return $this->expireOn;
    }

    /**
     * @param \DateTime $expireOn
     */
    public function setExpireOn($expireOn)
    {
        $this->expireOn = $expireOn;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param mixed $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
    }


}