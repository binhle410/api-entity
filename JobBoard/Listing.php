<?php
// src/AppBundle/Entity/JobBoard/Listing.php

namespace AppBundle\Entity\JobBoard;

use AppBundle\Entity\Accounting\Payroll\Salary;
use AppBundle\Entity\Core\Location\Location;
use AppBundle\Entity\Core\Tag;
use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_listing")
 */
class Listing
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
     **/
    private $owner;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Location")
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     **/
    private $location;

    /**
     * @var Salary
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Accounting\Payroll\Salary")
     * @ORM\JoinColumn(name="id_salary_from", referencedColumnName="id")
     **/
    private $salaryFrom;

    /**
     * @var Salary
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Accounting\Payroll\Salary")
     * @ORM\JoinColumn(name="id_salary_to", referencedColumnName="id")
     **/
    private $salaryTo;

    /**
     * @var JobType
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\JobType")
     * @ORM\JoinColumn(name="id_listing_type", referencedColumnName="id")
     */
    private $jobType;

    /**
     * @var Visibility
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Visibility")
     * @ORM\JoinColumn(name="id_listing_visibility", referencedColumnName="id")
     */
    private $visibility; // Referenced from Visibility.php

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Tag")
     * @ORM\JoinTable(name="job_listings_tags",
     *      joinColumns={@ORM\JoinColumn(name="id_listing", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     **/
    private $tags;

    /**
     * @var \DateTime
     * @ORM\Column(name="expiry_date",type="datetime",nullable=true)
     */
    private $expiryDate;

    /**
     * @var string
     * @ORM\Column(length=120, name="title",type="string",nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(length=250, name="description",type="string",nullable=true)
     */
    private $description;


    /** @ORM\Column(length=250, name="qr_code_url",type="string",nullable=true) */
    private $qrCodeURL;

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
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     */
    public function setTags(ArrayCollection $tags)
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
     * @return JobType
     */
    public function getJobType()
    {
        return $this->jobType;
    }

    /**
     * @param JobType $jobType
     */
    public function setJobType(JobType $jobType)
    {
        $this->jobType = $jobType;
    }

    /**
     * @return Visibility
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param Visibility $visibility
     */
    public function setVisibility(Visibility $visibility)
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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Salary
     */
    public function getSalaryFrom()
    {
        return $this->salaryFrom;
    }

    /**
     * @param Salary $salaryFrom
     */
    public function setSalaryFrom($salaryFrom)
    {
        $this->salaryFrom = $salaryFrom;
    }

    /**
     * @return Salary
     */
    public function getSalaryTo()
    {
        return $this->salaryTo;
    }

    /**
     * @param Salary $salaryTo
     */
    public function setSalaryTo($salaryTo)
    {
        $this->salaryTo = $salaryTo;
    }

    /**
     * @return \DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param \DateTime $expiryDate
     */
    public function setExpiryDate(\DateTime $expiryDate)
    {
        $this->expiryDate = $expiryDate;
    }


}