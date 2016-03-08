<?php

namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\JobBoard\Listing\JobListing;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__application__candidate")
 *
 * @Serializer\XmlRoot("jobcandidate")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_jobcandidate",
 *         parameters = {"candidate" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Hateoas\Relation(
 *  "job_listing",
 *  href= @Hateoas\Route(
 *         "get_joblisting",
 *         parameters = {"listing" = "expr(object.getListing().getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Hateoas\Relation(
 *  "user",
 *  href= @Hateoas\Route(
 *         "get_user",
 *         parameters = {"username" = "expr(object.getUser().getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 */
class JobCandidate implements BaseVoterSupportInterface
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->folders = new ArrayCollection();
        $this->interviews = new ArrayCollection();
    }

    /**
     * @var ArrayCollection CandidateFolder
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateFolder"))
     * @ORM\JoinTable(name="job__application__candidates_folders",
     *      joinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_folder", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $folders;

    public function addFolder(CandidateFolder $folder)
    {
        $this->folders->add($folder);
    }

    public function removeFolder(CandidateFolder $folder)
    {
        $this->folders->removeElement($folder);
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateInterview", mappedBy="candidate")
     * @Serializer\Exclude
     */
    private $interviews;

    public function addInterview(CandidateInterview $interviews)
    {
        $this->interviews->add($interviews);
        return $this;
    }

    public function removeInterview(CandidateInterview $interviews)
    {
        $this->interviews->removeElement($interviews);
        return $this;
    }

    /**
     * @var JobListing
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Listing\JobListing", inversedBy="candidates")
     * @ORM\JoinColumn(name="id_listing", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $listing;

    /**
     * @var JobListing
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User", inversedBy="candidates")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $user;

    /**
     * @var Gallery
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", cascade={"merge","persist","remove"},orphanRemoval=true, inversedBy="introCandidate")
     * @ORM\JoinColumn(name="id_intro_video_gallery", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $introVideoGallery;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="enabled", options={"default":false})
     */
    private $enabled;

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
     * @return JobListing
     */
    public function getListing()
    {
        return $this->listing;
    }

    /**
     * @param JobListing $listing
     */
    public function setListing($listing)
    {
        $this->listing = $listing;
    }

    /**
     * @return JobListing
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param JobListing $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getInterviews()
    {
        return $this->interviews;
    }

    /**
     * @param ArrayCollection $interviews
     */
    public function setInterviews($interviews)
    {
        $this->interviews = $interviews;
    }

    /**
     * @return ArrayCollection
     */
    public function getReviewers()
    {
        return $this->reviewers;
    }

    /**
     * @param ArrayCollection $reviewers
     */
    public function setReviewers($reviewers)
    {
        $this->reviewers = $reviewers;
    }

    /**
     * @return ArrayCollection
     */
    public function getObservers()
    {
        return $this->observers;
    }

    /**
     * @param ArrayCollection $observers
     */
    public function setObservers($observers)
    {
        $this->observers = $observers;
    }

    /**
     * @return ArrayCollection
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * @param ArrayCollection $folders
     */
    public function setFolders($folders)
    {
        $this->folders = $folders;
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
