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
 *         parameters = { "organisationId" = "expr(object.getEmployer().getId())","positionId" = "expr(object.getEmployer().getId())"},
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
 *  @Hateoas\Relation("employee",
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
class Position {

    function __construct(User $employee, Organisation $employer) {
        $this->employee = $employee;
        $employee->getPositions()->add($this);
        $this->employer = $employer;
        $employer->getPositions()->add($this);
    }

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="active", options={"default":false})
     */
    private $active;
    // e.g: Business Development, Telesales
    /** @ORM\Column(length=50, name="title",type="string",nullable=true) */
    private $title;

    /**
     * @var \AppBundle\Entity\Core\User\User
     * @ORM\Id @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Core\User\User",inversedBy="positions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_employee", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $employee;

    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\Id @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation",inversedBy="positions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_employer", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $employer;

    /**
     * @return \AppBundle\Entity\Core\User\User
     */
    public function getEmployee() {
        return $this->employee;
    }

    /**
     * @param \AppBundle\Entity\Core\User\User $employee
     */
    public function setEmployee(User $employee) {
        $this->employee = $employee;
    }

    /**
     * @return Organisation
     */
    public function getEmployer() {
        return $this->employer;
    }

    /**
     * @param Organisation $employer
     */
    public function setEmployer(Organisation $employer) {
        $this->employer = $employer;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return boolean
     */
    public function isActive() {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

}
