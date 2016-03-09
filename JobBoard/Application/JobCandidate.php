<?php

namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\JobBoard\Listing\JobListing;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\Organisation\Position;
use AppBundle\Entity\JobBoard\Application\CandidateReviewer;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\OwnableInterface;
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
 *         "get_joblisting_jobcandidate",
 *         parameters = {"listing" = "expr(object.getListing().getId())","candidate" = "expr(object.getId())"},
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
 *
 * @Hateoas\Relation(
 *  "intro_video_gallery",
 *  href= @Hateoas\Route(
 *         "get_joblisting_jobcandidate_intros_videos_galleries",
 *         parameters = {"listing" = "expr(object.getListing().getId())","candidate" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 */
class JobCandidate implements BaseVoterSupportInterface, OwnableInterface {

    function __construct() {
        $this->enabled = true;
        $this->folders = new ArrayCollection();
        $this->interviews = new ArrayCollection();
        $this->reviewers = new ArrayCollection();
    }

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var ArrayCollection CandidateFolder
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateFolder"))
     * @ORM\JoinTable(name="job__application__candidates_folders",
     *      joinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_folder", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $folders;

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

    public function addFolder(CandidateFolder $folder) {
        $this->folders->add($folder);
    }

    public function removeFolder(CandidateFolder $folder) {
        $this->folders->removeElement($folder);
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateInterview", mappedBy="candidate")
     * @Serializer\Exclude
     */
    private $interviews;

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

    public function addInterview(CandidateInterview $interview) {
        $this->interviews->add($interview);
        return $this;
    }

    public function removeInterview(CandidateInterview $interview) {
        $this->interviews->removeElement($interview);
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
     * @var JobListing
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User", inversedBy="candidates")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $user;

    /**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUserOwner($user) {
        return $this;
    }

    /**
     * @return User
     */
    public function getUserOwner() {
        return $this->user;
    }

    /**
     * @var Gallery
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", cascade={"merge","persist","remove"},orphanRemoval=true, inversedBy="introCandidate")
     * @ORM\JoinColumn(name="id_intro_video_gallery", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $introVideoGallery;

    /**
     * @return Gallery
     */
    public function getIntroVideoGallery() {
        return $this->introVideoGallery;
    }

    /**
     * @param Gallery $introVideoGallery
     */
    public function setIntroVideoGallery($introVideoGallery) {
        $this->introVideoGallery = $introVideoGallery;
    }

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="enabled", options={"default":true})
     */
    private $enabled;

    /**
     * @return boolean
     */
    public function isEnabled() {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateReviewer", mappedBy="candidate")
     * @Serializer\Exclude
     */
    private $reviewers;

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

    public function addReviewers(CandidateReviewer $reviewers) {
        $this->reviewers->add($reviewers);
        return $this;
    }

    public function removeReviewers(CandidateReviewer $reviewers) {
        $this->reviewers->removeElement($reviewers);
        return $this;
    }

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"merge","persist","remove"},inversedBy="resumeCandidate")
     * @ORM\JoinColumn(name="id_resume", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $resume;

    /**
     * @return Media
     */
    public function getResume() {
        return $this->resume;
    }

    /**
     * @param Media $resume
     */
    public function setResume($resume) {
        $this->resume = $resume;
    }

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="reattempted", options={"default":false})
     */
    private $reattempted;

    /**
     * @return bool
     */
    public function isReattempted() {
        return $this->reattempted;
    }

    /**
     * @param bool $reattempted
     */
    public function setReattempted($reattempted) {
        $this->reattempted = $reattempted;
    }

    /**
     * @var string
     * @ORM\Column(type="string", name="status")
     */
    private $status;

    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @var string
     * @ORM\Column(type="string", name="invitation_status")
     */
    private $invitationStatus;

    /**
     * @return string
     */
    public function getInvitationStatus() {
        return $this->invitationStatus;
    }

    /**
     * @param string $invitationStatus
     */
    public function setInvitationStatus($invitationStatus) {
        $this->invitationStatus = $invitationStatus;
    }

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="withdawn", options={"default":false})
     */
    private $withdawn;

    /**
     * @return bool
     */
    public function isWithdawn() {
        return $this->withdawn;
    }

    /**
     * @param bool $withdawn
     */
    public function setWithdawn($withdawn) {
        $this->withdawn = $withdawn;
    }

    /**
     * @param Position $position
     * @return $this
     */
    public function setPositionOwner($position) {
        return null;
    }

    /**
     * @return Position
     */
    public function getPositionOwner() {
        return null;
    }

    /**
     * @param Organisation $organisation
     * @return $this
     */
    public function setOrganisationOwner($organisation) {
        return $this;
    }

    /**
     * @return Organisation
     */
    public function getOrganisationOwner() {
        return null;
    }

}
