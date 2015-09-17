<?php
// src/AppBundle/Entity/Organisation/Organisation.php

namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\Location\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Model\MediaInterface;

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
    private $id;

    function __construct()
    {
        $this->children = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }
//todo map the following fields
    /**
     * check slide 22
     *
     *
     * regNo, businessType:Tag, headOfficeNo, billingAddress:String, adminUserEmail,
     * reservationEmail, userContactNo, clientSince:Date
     * officeHours:String
     * redemptionPassword:String, merchantID:String
     * aboutCompany:String
     * Integrate with SonataMediaBundle to store app images along with banner images
     */

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Business", mappedBy="owner", orphanRemoval=true)
     */
    private $businesses;

    /** @ORM\Column(length=150) */
    private $name;

    //todo map OneToOne with UserGroup entity
    private $benefitUserGroup;

    /** @ORM\Column(length=50) */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Position", mappedBy="employer", orphanRemoval=true)
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Site", mappedBy="organisation")
     **/
    private $sites;
    //TODO implement addSite, removeSite

    /**
     * @ORM\OneToMany(targetEntity="Organisation", mappedBy="parent")
     **/
    private $children;

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="children")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $parent;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Location")
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     **/
    private $location;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY", orphanRemoval=true)
     */
    private $media;

    /**
     * @param MediaInterface $media
     */
    public function setMedia(MediaInterface $media)
    {
        $this->media = $media;
    }

    /**
     * @return MediaInterface
     */
    public function getMedia()
    {
        return $this->media;
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

}