<?php
// src/AppBundle/Entity/Work/Organisation.php

namespace AppBundle\Entity\Work;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="organisation")
 */
class Organisation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    function __construct()
    {
        $this->children = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    /** @ORM\Column(length=150) */
    private $name;


    /** @ORM\Column(length=50) */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Work\Position", mappedBy="employer", orphanRemoval=true)
     */
    private $positions;

    public function addPosition(Position $position)
    {
        $this->positions->add($position);
        $position->setEmployer($this);
        return $this;
    }
    //todo implement removePosition

    /**
     * @OneToMany(targetEntity="AppBundle\Entity\Core\Site", mappedBy="organisation")
     **/
    private $sites;
    //TODO implement addSite, removeSite

    /**
     * @ORM\OneToMany(targetEntity="Organisation", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="children")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $parent;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Location")
     * @ORM\JoinTable(name="organisation_location",
     *      joinColumns={@ORM\JoinColumn(name="id_organisation", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_location", referencedColumnName="id", unique=true)}
     *      )
     */
    private $locations;

    /**
     * @return mixed
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param mixed $locations
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
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

}