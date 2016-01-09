<?php

namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\JobBoard\Listing\JobListing;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
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
 *         "get_jobcandidates",
 *         parameters = {},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 * @Hateoas\Relation(
 *  "jobcandidate.post",
 *  href= @Hateoas\Route(
 *         "post_jobcandidate",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 */
class JobCandidate implements BaseVoterSupportInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct() {
        $this->observers = new ArrayCollection();
        $this->reviewers = new ArrayCollection();
        $this->folders = new ArrayCollection();
    }

    /**
     * @var JobListing
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Listing\JobListing", inversedBy="candidates")
     * @ORM\JoinColumn(name="id_listing", referencedColumnName="id")
     */
    private $listing;

    /**
     * @var JobListing
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User", inversedBy="candidates")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateInterview", mappedBy="candidate")
     */
    private $interviews;

    public function addInterview(CandidateInterview $interviews) {
        $this->interviews->add($interviews);
        return $this;
    }

    public function removeInterview(CandidateInterview $interviews) {
        $this->interviews->removeElement($interviews);
        return $this;
    }

    /**
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="job__application__candidates_reviewers",
     *      joinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_reviewer", referencedColumnName="id", unique=true)}
     *      )
     */
    private $reviewers;

    public function addReviewer(User $user) {
        $this->reviewers->add($user);
    }

    public function removeReviewer(User $user) {
        $this->reviewers->removeElement($user);
    }

    /**
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="job__application__candidates_observers",
     *      joinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_observer", referencedColumnName="id", unique=true)}
     *      )
     */
    private $observers;

    public function addObserver(User $user) {
        $this->observers->add($user);
    }

    public function removeObserver(User $user) {
        $this->observers->removeElement($user);
    }

    /**
     * @var ArrayCollection CandidateFolder
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateFolder"))
     * @ORM\JoinTable(name="job__application__candidates_folders",
     *      joinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_folder", referencedColumnName="id")}
     *      )
     */
    private $folders;

    public function addFolder(CandidateFolder $folder) {
        $this->folders->add($folder);
    }

    public function removeFolder(CandidateFolder $folder) {
        $this->folders->removeElement($folder);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return JobListing
     */
    public function getListing() {
        return $this->listing;
    }

    /**
     * @param JobListing $listing
     */
    public function setListing($listing) {
        $this->listing = $listing;
    }

    /**
     * @return JobListing
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param JobListing $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getInterviews() {
        return $this->interviews;
    }

    /**
     * @param ArrayCollection $interviews
     */
    public function setInterviews($interviews) {
        $this->interviews = $interviews;
    }

    /**
     * @return ArrayCollection
     */
    public function getReviewers() {
        return $this->reviewers;
    }

    /**
     * @param ArrayCollection $reviewers
     */
    public function setReviewers($reviewers) {
        $this->reviewers = $reviewers;
    }

    /**
     * @return ArrayCollection
     */
    public function getObservers() {
        return $this->observers;
    }

    /**
     * @param ArrayCollection $observers
     */
    public function setObservers($observers) {
        $this->observers = $observers;
    }

    /**
     * @return ArrayCollection
     */
    public function getFolders() {
        return $this->folders;
    }

    /**
     * @param ArrayCollection $folders
     */
    public function setFolders($folders) {
        $this->folders = $folders;
    }

}
