<?php
// src/AppBundle/Entity/Work/Position.php
namespace AppBundle\Entity\Work;
use AppBundle\Entity\User\UserAccount;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="position")
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct(UserAccount $employee, Organisation $employer)
    {
        $employee->addPosition($this);
        $employer->addPosition($this);
    }

    // e.g: Business Development, Telesales
    /** @ORM\Column(length=50, name="title",type="string",nullable=true) */
    private $title;

    /**
     * @var \AppBundle\Entity\User\UserAccount
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User\UserAccount", inversedBy="positions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_employee", referencedColumnName="id")
     */
    private $employee;

    /**
     * @var \AppBundle\Entity\Work\Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Work\Organisation", inversedBy="positions",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_employer", referencedColumnName="id")
     */
    private $employer;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return \AppBundle\Entity\User\UserAccount
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param \AppBundle\Entity\User\UserAccount $employee
     */
    public function setEmployee(UserAccount $employee)
    {
        $this->employee = $employee;
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


}