<?php
// src/AppBundle/Entity/Core/Cotr/Tag.php
namespace AppBundle\Entity\Core\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->active = false;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumn(name="id_site", referencedColumnName="id")
     **/
    private $site;

    /**
     * var ArrayCollection
     * ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Business", mappedBy="tags")
     **/
//    private $businesses;

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean",nullable=false,options={"default":false})
     */
    private $active;

    /**
     * @var bool
     * @ORM\Column(name="employee_class",type="boolean",nullable=true,options={"default":false})
     */
    private $employeeClass = false;

    /**
     * @var bool
     * @ORM\Column(name="employee_function",type="boolean",nullable=true,options={"default":false})
     */
    private $employeeFunction = false;


    /** @ORM\Column(length=120, name="name",type="string",nullable=false,unique=true) */
    private $name;


    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $sites
     */
    public function setSite($site)
    {
        $this->sites = $site;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function isEmployeeClass()
    {
        return $this->employeeClass;
    }

    /**
     * @param boolean $employeeClass
     */
    public function setEmployeeClass($employeeClass)
    {
        $this->employeeClass = $employeeClass;
    }

    /**
     * @return boolean
     */
    public function isEmployeeFunction()
    {
        return $this->employeeFunction;
    }

    /**
     * @param boolean $employeeFunction
     */
    public function setEmployeeFunction($employeeFunction)
    {
        $this->employeeFunction = $employeeFunction;
    }

}