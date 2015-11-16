<?php
// src/AppBundle/Entity/Core/Classification/Tag.php
namespace AppBundle\Entity\Core\Classification;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\ClassificationBundle\Entity\BaseTag;

/**
 * @ORM\Entity
 * @ORM\Table(name="classification__tag")
 */
class Tag extends BaseTag
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Core\Site")
     * @ORM\JoinColumn(name="id_site", referencedColumnName="id")
     **/
    private $site;

    /**
     * var ArrayCollection
     * ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Business\Business", mappedBy="tags")
     **/
//    private $businesses;

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean",nullable=false,options={"default":false})
     */
    private $active;

    /**
     * @var bool
     * @ORM\Column(name="system",type="boolean",nullable=true,options={"default":false})
     */
    private $system = false;

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

    /**
     * @return boolean
     */
    public function isSystem()
    {
        return $this->system;
    }

    /**
     * @param boolean $system
     */
    public function setSystem($system)
    {
        $this->system = $system;
    }


}