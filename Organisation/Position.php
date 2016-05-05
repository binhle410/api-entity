<?php

// src/AppBundle/Entity/Organisation/Position.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\Classification\Tag;
use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Handbook\Handbook;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\ListVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Serializer\XmlRoot("position")
 *
 * @Hateoas\Relation("self",
 *  href= @Hateoas\Route(
 *         "get_organisation_position",
 *          parameters = { "organisationId"="expr(object.getEmployer().getId())","position" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 * @Hateoas\Relation("position.post",
 *  href= @Hateoas\Route(
 *         "post_organisation_position",
 *          parameters = { "organisationId" = "expr(object.getEmployer().getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "employer",
 *  href= @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getEmployer().getId())"},
 *         absolute = true
 *     ),
 * )
 *
 * @Hateoas\Relation("redemptions",
 *  href = @Hateoas\Route(
 *         "get_organisation_position_redemptions",
 *         parameters = { "organisationId"="expr(object.getEmployer().getId())","position" = "expr(object.getId())"},
 *         absolute = true
 *     )
 * )
 *
 * @Hateoas\Relation("employee",
 *  href = @Hateoas\Route(
 *         "get_user",
 *         parameters = { "username" = "expr(object.getEmployee().getId())"},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation("tags", href = @Hateoas\Route(
 *         "get_organisation_position_tags",
 *         parameters = { "organisationId" = "expr(object.getEmployer().getId())","position" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * )
 *
 * @Hateoas\Relation("employee_classes", href = @Hateoas\Route(
 *         "get_organisation_position_classes",
 *         parameters = { "organisationId" = "expr(object.getEmployer().getId())","position" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation("employee_functions", href = @Hateoas\Route(
 *         "get_organisation_position_functions",
 *         parameters = { "organisationId" = "expr(object.getEmployer().getId())","position" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * )
 *
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\Organisation\PositionRepository")
 * @ORM\Table(name="organisation__position", uniqueConstraints={@ORM\UniqueConstraint(name="position_unique", columns={"id_employer", "id_employee"})})
 */
class Position implements BaseVoterSupportInterface
{
//*  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getTags().count() === 0)")
//    function __construct(User $employee, Organisation $employer) {
//        $this->employee = $employee;
//        $employee->getPositions()->add($this);
//        $this->employer = $employer;
//        $employer->getPositions()->add($this);
//    }

    //Security("is_granted('VIEW', object)")
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    function __construct()
    {
        $this->employeeClasses = new ArrayCollection();
        $this->employeeFunctions = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->tags = new ArrayCollection();
        $this->enabled = true;
        $this->benefitAppAccessible = true;
        $this->defaultPos = true;
        $this->handbookContact = true;
        $this->hrAdmin = false;
    }

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Handbook\Handbook", inversedBy="viewers")
     * @ORM\JoinTable(name="organisation__handbook__handbooks_viewers",
     *      joinColumns={@ORM\JoinColumn(name="id_handbook", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_position", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude()
     **/
    private $handbooks;

    /**
     * @param Handbook $handbook
     * @return ArrayCollection
     */
    public function addHandbook($handbook)
    {
        $this->handbooks->add($handbook);
        return $this->handbooks;
    }

    /**
     * @param Handbook $handbook
     * @return ArrayCollection
     */
    public function removeHandbook($handbook)
    {
        $this->handbooks->removeElement($handbook);
        return $this->handbooks;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateReviewer", mappedBy="position", orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $candidateReviewers;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\FolderReviewer", mappedBy="position", orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $folderReviewers;
    /**
     * @var \AppBundle\Entity\Core\User\User
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Core\User\User",inversedBy="positions", fetch="EAGER")
     * @ORM\JoinColumn(name="id_employee", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $employee;

    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation",inversedBy="positions", fetch="EAGER")
     * @ORM\JoinColumn(name="id_employer", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $employer;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Classification\Tag",cascade={"merge","persist"})
     * @ORM\JoinTable(name="organisation__positions_classes",
     *      joinColumns={@ORM\JoinColumn(name="id_position", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $employeeClasses;

    /**
     * @param Tag $tag
     * @return Position
     */
    public function addEmployeeClass($tag)
    {
        if ($tag->isEmployeeClass()) {
            $this->employeeClasses->add($tag);
        }
        return $this;
    }

    /**
     * @param Tag $tag
     * @return Position
     */
    public function removeEmployeeClass($tag)
    {
        $this->employeeClasses->removeElement($tag);
        return $this;
    }


    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Classification\Tag",cascade={"merge","persist"})
     * @ORM\JoinTable(name="organisation__positions_functions",
     *      joinColumns={@ORM\JoinColumn(name="id_position", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $employeeFunctions;

    /**
     * @param Tag $tag
     * @return Position
     */
    public function addEmployeeFunction($tag)
    {
        if ($tag->isEmployeeFunction()) {
            $this->employeeFunctions->add($tag);
        }
        return $this;
    }

    /**
     * @param Tag $tag
     * @return Position
     */
    public function removeEmployeeFunction($tag)
    {
        $this->employeeFunctions->removeElement($tag);
        return $this;
    }

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Classification\Tag",cascade={"merge","persist"})
     * @ORM\JoinTable(name="organisation__positions_tags",
     *      joinColumns={@ORM\JoinColumn(name="id_position", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $tags;

    /**
     * @param Tag $tag
     * @return Position
     */
    public function addTag($tag)
    {
        if ($tag->isEmployeeClass() || $tag->isEmployeeFunction()) {
            $this->tags->add($tag);
        }
        return $this;
    }

    /**
     * @param Tag $tag
     * @return Position
     */
    public function removeTag($tag)
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at",nullable=true)
     */
    private $createdAt;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="benefit_app_accessible", nullable=true, options={"default":true})
     */
    private $benefitAppAccessible;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="default_pos", options={"default":true})
     */
    private $defaultPos;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="hr_admin", options={"default":false})
     */
    private $hrAdmin;
    

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="enabled", options={"default":true})
     */
    private $enabled;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="handbook_contact", options={"default":false})
     */
    private $handbookContact;
    // e.g: Business Development, Telesales

    /**
     * @deprecated
     * @var string
     * @ORM\Column(length=50, name="title",type="string",nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(length=50, name="mobile_phone",type="string",nullable=true)
     */
    private $mobilePhone;

    /**
     * @var string
     * @ORM\Column(length=50, name="office_phone",type="string",nullable=true)
     */
    private $officePhone;

    /**
     * @var string
     * @ORM\Column(length=50, name="email_address",type="string",nullable=true)
     */
    private $emailAddress;

    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
    }

    public function getOfficePhone()
    {
        return $this->officePhone;
    }

    public function setOfficePhone($officePhone)
    {
        $this->officePhone = $officePhone;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Core\User\User
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param \AppBundle\Entity\Core\User\User $employee
     */
    public function setEmployee(User $employee)
    {
        $this->employee = $employee;
        $employee->getPositions()->add($this);
    }

    /**
     * @return Organisation
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param Organisation $employer
     */
    public function setEmployer(Organisation $employer)
    {
        $this->employer = $employer;
        $employer->getPositions()->add($this);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return boolean
     */
    public function isHandbookContact()
    {
        return $this->handbookContact;
    }

    /**
     * @param boolean $handbookContact
     */
    public function setHandbookContact($handbookContact)
    {
        $this->handbookContact = $handbookContact;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
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
        foreach ($tags as $tag) {
            if ($tag->isEmployeeClass() || $tag->isEmployeeFunction()) {
                $this->tags->add($tag);
            }
        }
//        $this->tags = $tags;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
     * @return boolean
     */
    public function isBenefitAppAccessible()
    {
        return $this->benefitAppAccessible;
    }

    /**
     * @param boolean $benefitAppAccessible
     */
    public function setBenefitAppAccessible($benefitAppAccessible)
    {
        $this->benefitAppAccessible = $benefitAppAccessible;
    }

    /**
     * @return mixed
     */
    public function getHandbooks()
    {
        return $this->handbooks;
    }

    /**
     * @param mixed $handbooks
     */
    public function setHandbooks($handbooks)
    {
        $this->handbooks = $handbooks;
    }

    /**
     * @return ArrayCollection
     */
    public function getCandidateReviewers()
    {
        return $this->candidateReviewers;
    }

    /**
     * @param ArrayCollection $candidateReviewers
     */
    public function setCandidateReviewers($candidateReviewers)
    {
        $this->candidateReviewers = $candidateReviewers;
    }

    /**
     * @return ArrayCollection
     */
    public function getFolderReviewers()
    {
        return $this->folderReviewers;
    }

    /**
     * @param ArrayCollection $folderReviewers
     */
    public function setFolderReviewers($folderReviewers)
    {
        $this->folderReviewers = $folderReviewers;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmployeeClasses()
    {
        return $this->employeeClasses;
    }

    /**
     * @param ArrayCollection $employeeClasses
     */
    public function setEmployeeClasses($employeeClasses)
    {
        $this->employeeClasses = $employeeClasses;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmployeeFunctions()
    {
        return $this->employeeFunctions;
    }

    /**
     * @param ArrayCollection $employeeFunctions
     */
    public function setEmployeeFunctions($employeeFunctions)
    {
        $this->employeeFunctions = $employeeFunctions;
    }

    /**
     * @return boolean
     */
    public function isDefaultPos()
    {
        return $this->defaultPos;
    }

    /**
     * @param boolean $defaultPos
     */
    public function setDefaultPos($defaultPos)
    {
        $this->defaultPos = $defaultPos;
    }

    /**
     * @return boolean
     */
    public function isHrAdmin()
    {
        return $this->hrAdmin;
    }

    /**
     * @param boolean $hrAdmin
     */
    public function setHrAdmin($hrAdmin)
    {
        $this->hrAdmin = $hrAdmin;
    }


}
