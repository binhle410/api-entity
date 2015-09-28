<?php
// src/AppBundle/Entity/Organisation/Organisation.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\Location\Location;
use AppBundle\Entity\Core\Tag;
use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Handbook\Handbook;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Model\MediaInterface;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity
 * @ORM\Table(name="organisation")
 *
 * @Serializer\XmlRoot("organisation")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *  "handbook",
 *  href= @Hateoas\Route(
 *         "get_organisation_handbook",
 *         parameters = { "organisation" = "expr(object.getId())","handbook" = "expr(object.getHandbook().getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getHandbook() === null)")
 * )
 * @Hateoas\Relation(
 *  "positions",
 *  href= @Hateoas\Route(
 *         "get_organisation_positions",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getPositions().count() == 0)")
 * )
 * @Hateoas\Relation(
 *  "sites",
 *  href= @Hateoas\Route(
 *         "get_organisation_sites",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getSites().count() == 0)")
 * )
 * @Hateoas\Relation(
 *  "children",
 *  href= @Hateoas\Route(
 *         "get_organisation_children",
 *         parameters = { "organisationId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getChildren().count() == 0)")
 * )
 * @Hateoas\Relation(
 *  "parent",
 *  href= @Hateoas\Route(
 *         "get_organisation_parent",
 *         parameters = { "organisation" = "expr(object.getId())"},
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
 */
class Organisation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->children = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->businesses = new ArrayCollection();
        $this->sites = new ArrayCollection();
    }

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_admin", referencedColumnName="id")
     * @Serializer\Exclude
     **/
    private $adminUser;

    /**
     * @var Handbook
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Organisation\Handbook\Handbook", mappedBy="organisation", orphanRemoval=true)
     * @Serializer\Exclude
     **/
    private $handbook;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Business", mappedBy="owner", orphanRemoval=true)
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Site", mappedBy="organisation")
     * @Serializer\Exclude
     **/
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
     **/
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Organisation", mappedBy="parent")
     * @Serializer\Exclude
     **/
    private $children;


    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Location")
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     **/
    private $location;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY", orphanRemoval=true)
     * @ORM\JoinColumn(name="id_logo", referencedColumnName="id")
     */
    private $logo;

    /**
     * @var string
     * @ORM\Column(length=150) */
    private $name;
    /**
     * @var string
     * @ORM\Column(length=50) */
    private $code;
    /**
     * @var string
     * @ORM\Column(length=50,name="reg_no") */
    private $regNo;
    /**
     * @var string
     * @ORM\Column(length=50,name="head_office_no") */
    private $headOfficeNo;
    /**
     * @var string
     * @ORM\Column(length=50,name="billing_address") */
    private $billingAddress;
    /**
     * @var string
     * @ORM\Column(length=50,name="reservation_email") */
    private $reservationEmail;
    /**
     * @var string
     * @ORM\Column(length=50,name="user_contact_no") */
    private $userContactNo;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="client_since") */
    private $clientSince;
    /**
     * @var string
     * @ORM\Column(length=120,name="office_hours") */
    private $officeHours;
    /**
     * @var string
     * @ORM\Column(length=10,name="redemption_password") */
    private $redemptionPassword;
    /**
     * @var string
     * @ORM\Column(length=10,name="about_company") */
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
    public function getHandbook()
    {
        return $this->handbook;
    }

    /**
     * @param Handbook $handbook
     */
    public function setHandbook(Handbook $handbook)
    {
        $this->handbook = $handbook;
        $handbook->setOrganisation($this);
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
    public function setPositions(ArrayCollection $positions)
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
    public function setBusinesses(ArrayCollection $businesses)
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
    public function setSites(ArrayCollection $sites)
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
    public function setChildren(ArrayCollection $children)
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
    public function setAdminUser(User $adminUser)
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


}