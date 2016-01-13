<?php
namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use AppBundle\Entity\Core\Classification\Tag;
use AppBundle\Entity\Organisation\Business\Business;
use AppBundle\Entity\Organisation\Business\RetailOutlet;
use AppBundle\Entity\Report\Promotion\PromotionUsage;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\ListVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 *
 * @Serializer\XmlRoot("promotion")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_promotion",
 *         parameters = { "promotion" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} }
 * )
 * @Hateoas\Relation(
 *  "self.post",
 *  href= @Hateoas\Route(
 *         "post_promotion",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *  "type",
 *  href= @Hateoas\Route(
 *         "get_promotion_type",
 *         parameters = { "type" = "expr(object.getType().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getType() === null)")
 * )
 * @Hateoas\Relation(
 *  "redemptions",
 *  href= @Hateoas\Route(
 *         "get_promotion_redemptions",
 *         parameters = { "promotion" = "expr(object.getId())"},
 *         absolute = true
 *     )
 *)
 *
 * @Hateoas\Relation(
 *  "tags",
 *  href= @Hateoas\Route(
 *         "get_promotion_tags",
 *         parameters = { "promotion" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getTags().count() === 0)")
 * )
 *
 * @Hateoas\Relation(
 *  "retail_outlets",
 *  href= @Hateoas\Route(
 *         "get_promotion_participating_outlets",
 *         parameters = { "promotion" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getRetailOutlets().count() === 0)")
 * )
 *
 *
 *
 * @Hateoas\Relation(
 *  "usage",
 *  href= @Hateoas\Route(
 *         "get_promotion_usage",
 *         parameters = { "promotion" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @ORM\Entity
 * @ORM\Table(name="marketing__promotion__promotion")
 */
class Promotion implements BaseVoterSupportInterface, ListVoterSupportInterface
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
        $this->setUsage(new PromotionUsage());
        $this->effectiveFrom = new \DateTime();
        $this->expireOn = new \DateTime();

        $this->benefits = new ArrayCollection();
        $this->retailOutlets = new ArrayCollection();
        $this->redemptions = new ArrayCollection();
        $this->tags = new ArrayCollection();

        $this->enabled = false;
        $this->everyOutletIncluded = true;
    }

    /**
     * @var PromotionUsage
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Report\Promotion\PromotionUsage", mappedBy="promotion", cascade={"merge","persist", "remove"},orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $usage;

    /**
     * @var Business
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Business\Business", inversedBy="promotions")
     * @ORM\JoinColumn(name="id_business", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $business;

    /**
     * @var PromotionType
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\PromotionType")
     * @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $type;

    /**
     * empty array means it include all organisations
     * @var ArrayCollection Benefit
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Benefit", mappedBy="promotion", orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude
     */
    private $benefits;

    /**
     * @var ArrayCollection RetailOutlet
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Business\RetailOutlet",cascade={"merge","persist"})
     * @ORM\JoinTable(name="marketing__promotion__promotions_retail_outlets",
     *      joinColumns={@ORM\JoinColumn(name="id_promotion", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_outlet", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $retailOutlets;

    /**
     * @var ArrayCollection Redemption
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\Redemption", mappedBy="promotion",orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude
     */
    private $redemptions;

    /**
     * only manytomany relationship is named with plural nouns.
     * @var ArrayCollection Tag
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Classification\Tag",cascade={"merge","persist"})
     * @ORM\JoinTable(name="marketing__promotion__promotions_tags",
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


    /**
     * @var int
     * @ORM\Column(name="offer_limit", type="integer",options={"default" = 0},nullable=true)
     */
    private $offerLimit;

    /**
     * @var int
     * @ORM\Column(name="weekly_limit", type="integer",options={"default" = 0},nullable=true)
     */
    private $weeklyLimit;

    /**
     * @var int
     * @ORM\Column(name="monthly_limit", type="integer",options={"default" = 0},nullable=true)
     */
    private $monthlyLimit;

    /**
     * @var int
     * @ORM\Column(name="yearly_limit", type="integer",options={"default" = 0},nullable=true)
     */
    private $yearlyLimit;

    /**
     * @var int
     * @ORM\Column(name="organisation_limit", type="integer",options={"default" = 0},nullable=true)
     */
    private $organisationLimit;
    /**
     * @var int
     * @ORM\Column(name="user_limit", type="integer",options={"default" = 0},nullable=true)
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
     * @ORM\Column(name="enabled",type="boolean", options={"default":false})
     */
    private $enabled;


    /**
     * @var bool
     * @ORM\Column(name="every_outlet_included",type="boolean",options={"default":true})
     */
    private $everyOutletIncluded;

    /**
     * @var string
     * @ORM\Column(length=120,name="title")
     */
    private $title;


    /**
     * @var float
     * @ORM\Column(name="discount_amount", precision=2,options={"default":0},nullable=true)
     */
    private $discountAmount;

    /**
     * @var float
     * @ORM\Column(name="estimated_value", scale=2, precision=5,options={"default":0},nullable=true)
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
     * @return PromotionType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param PromotionType $type
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
    public function getOrganisationLimit()
    {
        return $this->organisationLimit;
    }

    /**
     * @param int $organisationLimit
     */
    public function setOrganisationLimit($organisationLimit)
    {
        $this->organisationLimit = $organisationLimit;
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
     * @return Business
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
     * @return ArrayCollection
     */
    public function getRedemptions()
    {
        return $this->redemptions;
    }

    /**
     * @param ArrayCollection $redemptions
     */
    public function setRedemptions($redemptions)
    {
        $this->redemptions = $redemptions;
    }

    /**
     * @return PromotionUsage
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * @param PromotionUsage $usage
     */
    public function setUsage($usage)
    {
        $usage->setPromotion($this);
        $this->usage = $usage;
    }

    /**
     * @return int
     */
    public function getWeeklyLimit()
    {
        return $this->weeklyLimit;
    }

    /**
     * @param int $weeklyLimit
     */
    public function setWeeklyLimit($weeklyLimit)
    {
        $this->weeklyLimit = $weeklyLimit;
    }

    /**
     * @return boolean
     */
    public function isEveryOutletIncluded()
    {
        return $this->everyOutletIncluded;
    }

    /**
     * @param boolean $everyOutletIncluded
     */
    public function setEveryOutletIncluded($everyOutletIncluded)
    {
        $this->everyOutletIncluded = $everyOutletIncluded;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }


}