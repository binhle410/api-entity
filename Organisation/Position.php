<?php

// src/AppBundle/Entity/Organisation/Position.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\User\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("position")
 *
 * @Hateoas\Relation("self",
 *  href= @Hateoas\Route(
 *         "get_organisation_position",
 *          parameters = { "organisationId" = "expr(object.getEmployer().getId())","userId" = "expr(object.getEmployee().getId())"},
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
 *         parameters = { "username" = "expr(object.getEmployee().getEmail())"},
 *         absolute = true
 *     )
 * )
 *
 * @ORM\Entity
 * @ORM\Table(name="position")
 */
class Position
{
//    function __construct(User $employee, Organisation $employer) {
//        $this->employee = $employee;
//        $employee->getPositions()->add($this);
//        $this->employer = $employer;
//        $employer->getPositions()->add($this);
//    }

    /**
     * @var \AppBundle\Entity\Core\User\User
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Core\User\User",inversedBy="positions")
     * @ORM\JoinColumn(name="id_employee", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $employee;

    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation",inversedBy="positions")
     * @ORM\JoinColumn(name="id_employer", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $employer;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="active", options={"default":false})
     */
    private $active;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="handbook_contact", options={"default":false})
     */
    private $handbookContact;
    // e.g: Business Development, Telesales
    /** @ORM\Column(length=50, name="title",type="string",nullable=true) */
    private $title;

    /** @ORM\Column(length=50, name="mobile_phone",type="string",nullable=true) */
    private $mobilePhone;

    /** @ORM\Column(length=50, name="office_phone",type="string",nullable=true) */
    private $officePhone;

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

}
