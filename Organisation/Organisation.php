<?php
// src/AppBundle/Entity/Organisation/Organisation.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Annotations\Core\Pagination;
use AppBundle\Entity\Core\Location\Location;
use AppBundle\Entity\Core\Classification\Tag;
use AppBundle\Entity\Core\Message\Message;
use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Application\Application;
use AppBundle\Entity\Organisation\Handbook\Handbook;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sonata\MediaBundle\Model\MediaInterface;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity
 * @ORM\Table(name="organisation__organisation")
 *
 * @Serializer\XmlRoot("organisation")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object === null)"},
 * )
 *
 * @Hateoas\Relation(
 *  "organisation.post",
 *  href= @Hateoas\Route(
 *         "post_organisation",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *  "handbooks",
 *  href= @Hateoas\Route(
 *         "get_organisation_handbooks",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "methods" =  "expr('abc')" },
 * )
 * @Hateoas\Relation("handbooks.post", href = @Hateoas\Route(
 *         "post_organisation_handbook",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getHandbooks().count() == 0)")
 * )
 * @Hateoas\Relation(
 *  "positions",
 *  href= @Hateoas\Route(
 *         "get_organisation_positions",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation("positions.post",
 *  href= @Hateoas\Route(
 *         "post_organisation_position",
 *          parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "sites",
 *  href= @Hateoas\Route(
 *         "get_organisation_sites",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *  "children",
 *  href= @Hateoas\Route(
 *         "get_organisation_children",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *  "parent",
 *  href= @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getParent().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getParent() === null)")
 * )
 * @Hateoas\Relation(
 *  "businesses",
 *  href= @Hateoas\Route(
 *         "get_organisation_businesses",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getBusinesses().count() == 0)")
 * )
 *
 * @Hateoas\Relation(
 *  "notifications",
 *  href= @Hateoas\Route(
 *         "get_organisation_notifications",
 *         parameters = { "organisation" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getNotifications().count() == 0)")
 * )
 * @Hateoas\Relation(
 *  "notifications.post",
 *  href= @Hateoas\Route(
 *         "post_organisation_notifications",
 *         parameters = { "organisation" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "logo",
 *  href= @Hateoas\Route(
 *         "get_medium",
 *         parameters = { "medium" = "expr(object.getLogo().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getLogo() == null)")
 * )
 * @Hateoas\Relation(
 *  "logo.post",
 *  href= @Hateoas\Route(
 *         "post_organisation_logo",
 *         parameters = { "organisation" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['EDIT',object]))"
 *      )
 * )
 * @Hateoas\Relation(
 *  "app_image",
 *  href= @Hateoas\Route(
 *         "get_medium",
 *         parameters = { "medium" = "expr(object.getAppImage().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getAppImage() == null)")
 * )
 * @Hateoas\Relation(
 *  "app_image.post",
 *  href= @Hateoas\Route(
 *         "post_organisation_app_image",
 *         parameters = { "organisation" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "banners",
 *  href= @Hateoas\Route(
 *         "get_organisation_banners",
 *         parameters = { "organisation" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getBanners().count() == 0)")
 * )
 * @Hateoas\Relation(
 *  "banners.post",
 *  href= @Hateoas\Route(
 *         "post_organisation_banner",
 *         parameters = { "organisation" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "businesses.post",
 *  href= @Hateoas\Route(
 *         "post_business",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 */
class Organisation implements BaseVoterSupportInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    function __construct()
    {
        $this->businesses = new ArrayCollection();
        $this->benefits = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->sites = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->handbooks = new ArrayCollection();
        $this->banners = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_admin", referencedColumnName="id", nullable=true)
     * @Serializer\Exclude
     * */
    private $adminUser;

    /**
     * @var Handbook
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Handbook\Handbook", mappedBy="organisation", orphanRemoval=true)
     * @Serializer\Exclude
     * */
    private $handbooks;

    /**
     * @param Handbook $handbook
     */
    public function addHandbook($handbook)
    {
        $this->handbooks->add($handbook);
    }

    /**
     * @param Handbook $handbook
     */
    public function removeHandbook($handbook)
    {
        $this->handbooks->removeElement($handbook);
    }

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Application\Application",inversedBy="organisations",cascade={"merge","persist"})
     * @ORM\JoinTable(name="organisation__organisations_applications",
     *      joinColumns={@ORM\JoinColumn(name="id_organisation", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_application", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $applications;

    /**
     * @param Application $application
     * @return Organisation
     */
    public function addApplication($application)
    {
        $this->applications->add($application);
        return $this;
    }

    /**
     * @param Application $application
     * @return Organisation
     */
    public function removeApplication($application)
    {
        $this->applications->removeElement($application);
        return $this;
    }


    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Classification\Tag",cascade={"merge","persist"})
     * @ORM\JoinTable(name="organisation__organisations_tags",
     *      joinColumns={@ORM\JoinColumn(name="id_organisation", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $tags;

    /**
     * @param Tag $tag
     * @return Organisation
     */
    public function addTag($tag)
    {
        $this->tags->add($tag);
        return $this;
    }

    /**
     * @param Tag $tag
     * @return Organisation
     */
    public function removeTag($tag)
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    /**
     * @var ArrayCollection
     * -> OneToMany unidirectional
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Message\Message",cascade={"persist","merge","remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="organisation__organisations_messages",
     *      joinColumns={@ORM\JoinColumn(name="id_organisation", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_message", referencedColumnName="id", unique=true)}
     *      )
     * @Serializer\Exclude
     */
    private $notifications;

    /**
     * @param Message $notification
     */
    public function addNotification($notification)
    {
        $this->notifications->add($notification);
    }

    /**
     * @param Message $notification
     */
    public function removeNotification($notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Business\Business", mappedBy="owner",cascade={"persist","merge","remove"}, orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $businesses;

    /**
     * @var ArrayCollection Benefit
     * @ORM\OneToMany(targetEntity="Benefit", mappedBy="organisation", orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $benefits;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Position", mappedBy="employer", orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $positions;

    /**
     * @param Position $position
     * @return Organisation
     */
    public function removePosition(Position $position)
    {
        $this->positions->removeElement($position);
        $position->setEmployer(null);
        return $this;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Core\Site", mappedBy="organisation")
     * @Serializer\Exclude
     * */
    private $sites;
    //TODO implement addSite, removeSite

    /**
     * @var integer
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     * @Serializer\Exclude
     */
    private $root;

    /**
     * @var integer
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     * @Serializer\Exclude
     */
    private $lft;

    /**
     * @var integer
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     * @Serializer\Exclude
     */
    private $lvl;

    /**
     * @var integer
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     * @Serializer\Exclude
     */
    private $rgt;

    /**
     * @var Organisation
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="children")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     * */
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Organisation", mappedBy="parent")
     * @Serializer\Exclude
     * */
    private $children;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Location",cascade={"merge","persist"})
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     * */
    private $location;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="id_logo", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $logo;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="id_app_image", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $appImage;

    /**
     * @var ArrayCollection
     * -> OneToMany unidirectional
     * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media",cascade={"persist","merge"})
     * @ORM\JoinTable(name="organisation__organisations_banners",
     *      joinColumns={@ORM\JoinColumn(name="id_organisation", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_banner", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $banners;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="enabled", options={"default":false})
     */
    private $enabled;

    /**
     * @var string
     * @ORM\Column(length=50, name="code",type="string",nullable=true, unique=true)
     * @Security("is_granted('EDIT', _secure_object)")
     */
    private $code;

    /**
     * @var string
     * @ORM\Column(length=150)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(length=250,name="slogan", nullable=true)
     */
    private $slogan;

    /**
     * @var string
     * @ORM\Column(length=250,name="facebook_link", nullable=true)
     */
    private $facebookLink;

    /**
     * @var string
     * @ORM\Column(length=250,name="linked_in_link", nullable=true)
     */
    private $linkedInLink;

    /**
     * @var string
     * @ORM\Column(length=25,name="account_name", nullable=true, unique=true)
     */
    private $accountName;

    /**
     * @var string
     * @ORM\Column(length=250,name="qr_code", nullable=true)
     */
    private $qrCode;

    /**
     * @var string
     * @ORM\Column(length=50,name="reg_no", nullable=true)
     */
    private $regNo;

    /**
     * @var string
     * @ORM\Column(length=50,name="head_office_no", nullable=true)
     *
     */
    private $headOfficeNo;

    /**
     * @var string
     * @ORM\Column(length=120,name="office_address", nullable=true)
     */
    private $officeAddress;

    /**
     * @var string
     * @ORM\Column(length=120,name="billing_address", nullable=true)
     */
    private $billingAddress;

    /**
     * @var string
     * @ORM\Column(length=50,name="reservation_email", nullable=true)
     */
    private $reservationEmail;

    /**
     * @var string
     * @ORM\Column(length=50,name="user_contact_no", nullable=true)
     */
    private $userContactNo;

    /**
     * @var \DateTime
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     * @ORM\Column(type="datetime", name="client_since",nullable=true)
     */
    private $clientSince;

    /**
     * @var string
     * @ORM\Column(length=120,name="office_hours",nullable=true)
     */
    private $officeHours;

    /**
     * @var string
     * @ORM\Column(length=10,name="redemption_password",nullable=true)
     */
    private $redemptionPassword;

    /**
     * @var string
     * @ORM\Column(length=2500,name="about_company",nullable=true)
     */
    private $aboutCompany;

    /**
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param \Application\Sonata\MediaBundle\Entity\Media $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getAppImage()
    {
        return $this->appImage;
    }

    /**
     * @param \Application\Sonata\MediaBundle\Entity\Media $appImage
     */
    public function setAppImage($appImage)
    {
        $this->appImage = $appImage;
    }

    /**
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * @param \Application\Sonata\MediaBundle\Entity\Media $banners
     */
    public function setBanners($banners)
    {
        $this->banners = $banners;
        return $this;
    }

    public function addBanner($banner)
    {
        $this->banners->add($banner);
        return $this;
    }

    public function removeBanner($banner)
    {
        $this->banners->removeElement($banner);
        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getHandbooks()
    {
        return $this->handbooks;
    }

    /**
     * @param  $handbooks
     */
    public function setHandbooks($handbooks)
    {
        $this->handbooks = $handbooks;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Organisation
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Organisation $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return ArrayCollection
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @param ArrayCollection $positions
     */
    public function setPositions($positions)
    {
        $this->positions = $positions;
    }

    /**
     * @return ArrayCollection
     */
    public function getBusinesses()
    {
        return $this->businesses;
    }

    /**
     * @param ArrayCollection $businesses
     */
    public function setBusinesses($businesses)
    {
        $this->businesses = $businesses;
    }

    /**
     * @return ArrayCollection
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param ArrayCollection $sites
     */
    public function setSites($sites)
    {
        $this->sites = $sites;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param mixed $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * @return int
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @param int $lft
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    /**
     * @return int
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @param int $lvl
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * @return int
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @param int $rgt
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    /**
     * @return User
     */
    public function getAdminUser()
    {
        return $this->adminUser;
    }

    /**
     * @param User $adminUser
     */
    public function setAdminUser(User $adminUser = null)
    {
        $this->adminUser = $adminUser;
    }

    /**
     * @return string
     */
    public function getRegNo()
    {
        return $this->regNo;
    }

    /**
     * @param string $regNo
     */
    public function setRegNo($regNo)
    {
        $this->regNo = $regNo;
    }

    /**
     * @return string
     */
    public function getHeadOfficeNo()
    {
        return $this->headOfficeNo;
    }

    /**
     * @param string $headOfficeNo
     */
    public function setHeadOfficeNo($headOfficeNo)
    {
        $this->headOfficeNo = $headOfficeNo;
    }

    /**
     * @return string
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param string $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return string
     */
    public function getReservationEmail()
    {
        return $this->reservationEmail;
    }

    /**
     * @param string $reservationEmail
     */
    public function setReservationEmail($reservationEmail)
    {
        $this->reservationEmail = $reservationEmail;
    }

    /**
     * @return string
     */
    public function getUserContactNo()
    {
        return $this->userContactNo;
    }

    /**
     * @param string $userContactNo
     */
    public function setUserContactNo($userContactNo)
    {
        $this->userContactNo = $userContactNo;
    }

    /**
     * @return \DateTime
     */
    public function getClientSince()
    {
        return $this->clientSince;
    }

    /**
     * @param \DateTime $clientSince
     */
    public function setClientSince($clientSince)
    {
        $this->clientSince = $clientSince;
    }

    /**
     * @return string
     */
    public function getOfficeHours()
    {
        return $this->officeHours;
    }

    /**
     * @param string $officeHours
     */
    public function setOfficeHours($officeHours)
    {
        $this->officeHours = $officeHours;
    }

    /**
     * @return string
     */
    public function getRedemptionPassword()
    {
        return $this->redemptionPassword;
    }

    /**
     * @param string $redemptionPassword
     */
    public function setRedemptionPassword($redemptionPassword)
    {
        $this->redemptionPassword = $redemptionPassword;
    }

    /**
     * @return string
     */
    public function getAboutCompany()
    {
        return $this->aboutCompany;
    }

    /**
     * @param string $aboutCompany
     */
    public function setAboutCompany($aboutCompany)
    {
        $this->aboutCompany = $aboutCompany;
    }

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
     * @return string
     */
    public function getOfficeAddress()
    {
        return $this->officeAddress;
    }

    /**
     * @param string $officeAddress
     */
    public function setOfficeAddress($officeAddress)
    {
        $this->officeAddress = $officeAddress;
    }

    /**
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * @param string $slogan
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    }

    /**
     * @return string
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * @param string $facebookLink
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;
    }

    /**
     * @return string
     */
    public function getLinkedInLink()
    {
        return $this->linkedInLink;
    }

    /**
     * @param string $linkedInLink
     */
    public function setLinkedInLink($linkedInLink)
    {
        $this->linkedInLink = $linkedInLink;
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * @param string $accountName
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }

    /**
     * @return string
     */
    public function getQrCode()
    {
        return $this->qrCode;
    }

    /**
     * @param string $qrCode
     */
    public function setQrCode($qrCode)
    {
        $this->qrCode = $qrCode;
    }

    /**
     * @return ArrayCollection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param ArrayCollection $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
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

    /**
     * @return ArrayCollection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param ArrayCollection $applications
     */
    public function setApplications($applications)
    {
        $this->applications = $applications;
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


}
