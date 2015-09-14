<?php
// src/AppBundle/Entity/Jobboard/Listing.php

namespace AppBundle\Entity\Jobboard;

use AppBundle\Entity\Core\Location\Location;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_listing")
 */
class Listing
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /** @ORM\Column(length=120, name="title",type="string",nullable=true) */
    private $title;

    /** @ORM\Column(length=20, name="job_type",type="string",nullable=true) */
    private $jobType; // Referenced from Type.php

    /** @ORM\Column(length=20, name="visibility",type="string",nullable=true) */
    private $visibility; // Referenced from Visibility.php

    /** @ORM\Column(length=250, name="description",type="string",nullable=true) */
    private $description;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
     **/
    private $owner;
    /**
     * @ORM\Column(type="integer",name="salary_from",options={"unsigned":true})
     **/
    private $salaryFrom;

    /**
     * @ORM\Column(type="integer",name="salary_to",options={"unsigned":true})
     **/
    private $salaryTo;

    /** @ORM\Column(length=3, name="currency",type="string",nullable=true) */
    private $currency;

    /** @ORM\Column(length=120, name="qr_code_url",type="string",nullable=true) */
    private $qrCodeURL;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Location")
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     **/
    private $location;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Tag")
     * @ORM\JoinTable(name="listing_tag",
     *      joinColumns={@ORM\JoinColumn(name="id_listing", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     **/
    private $tags;

    /** @ORM\Column(name="expiry_date",type="datetime",nullable=true) */
    private $expiryDate;


    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getSalaryFrom()
    {
        return $this->salaryFrom;
    }

    /**
     * @param mixed $salaryFrom
     */
    public function setSalaryFrom($salaryFrom)
    {
        $this->salaryFrom = $salaryFrom;
    }

    /**
     * @return mixed
     */
    public function getSalaryTo()
    {
        return $this->salaryTo;
    }

    /**
     * @param mixed $salaryTo
     */
    public function setSalaryTo($salaryTo)
    {
        $this->salaryTo = $salaryTo;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getQrCodeURL()
    {
        return $this->qrCodeURL;
    }

    /**
     * @param mixed $qrCodeURL
     */
    public function setQrCodeURL($qrCodeURL)
    {
        $this->qrCodeURL = $qrCodeURL;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
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
     * @return mixed
     */
    public function getJobType()
    {
        return $this->jobType;
    }

    /**
     * @param mixed $jobType
     */
    public function setJobType($jobType)
    {
        $this->jobType = $jobType;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}