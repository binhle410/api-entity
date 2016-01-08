<?php

// src/AppBundle/Entity/Organisation/Position.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\Classification\Tag;
use AppBundle\Entity\Core\User\User;
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

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Security("is_granted('VIEW', object)")
     */
    private $id;

    function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->tags = new ArrayCollection();

        $this->enabled = true;

        // for BW
        $this->active = $this->enabled;
    }

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



}
