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
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\JobBoard\Application\JobCandidateRepository")
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
 *  "interviews",
 *  href= @Hateoas\Route(
 *         "get_joblisting_jobcandidate_candidateinterviews",
 *         parameters = {"listing" = "expr(object.getListing().getId())","candidate" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object.getInterviews().count() === 0)"},
 * )
 *
 *
 * @Hateoas\Relation(
 *  "logged_in_reviewer",
 *  href= @Hateoas\Route(
 *         "get_joblisting_jobcandidate_candidatereviewer",
 *         parameters = {"listing" = "expr(object.getListing().getId())","candidate" = "expr(object.getId())","reviewer"="expr(service('app.job_board.application.candidate_reviewer_retriever').getLoggedInCandidateReviewer(object).getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object.getInterviews().count() === 0)"},
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(service('app.job_board.application.candidate_reviewer_retriever').getLoggedInCandidateReviewer(object) === null)"
 *      )
 *
 * )
 *
 * @Hateoas\Relation(
 *  "job_listing",
 *  href= @Hateoas\Route(
 *         "get_joblisting",
 *         parameters = {"listing" = "expr(object.getListing().getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object.getListing() === null)"},
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
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object.getIntroVideoGallery() === null)"},
 * )
 */
class JobCandidate implements BaseVoterSupportInterface, OwnableInterface
{
    const INVITATION_INVITED = 'INVITED';
    const INVITATION_ACCEPTED = 'ACCEPTED';
    const INVITATION_REJECTED = 'REJECTED';
    const INVITATION_UNINVITED = 'UNINVITED'; // DEFAULT

    const STATUS_APPLIED = 'APPLIED'; // applied + !viewed = NEW, applied + viewed = VIEWED
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_HIRED = 'HIRED';
    const STATUS_PENDING = 'PENDING';
    const STATUS_NO_DECISION = 'NO_DECISION';

    function __construct()
    {
        $this->invitationStatus = self::INVITATION_UNINVITED;
        $this->reattemptable = false;
        $this->enabled = true;
        $this->interviewed = false;
        $this->folders = new ArrayCollection();
        $this->interviews = new ArrayCollection();
        $this->reviewers = new ArrayCollection();
        $this->withdrawn = false;
        $this->status = self::STATUS_APPLIED;
    }

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\Core\InvitationCode")
     * @ORM\JoinColumn(name="invitation_code_id", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $invitationCode;

    /**
     * @return mixed
     */
    public function getInvitationCode()
    {
        return $this->invitationCode;
    }

    /**
     * @param mixed $invitationCode
     */
    public function setInvitationCode($invitationCode)
    {
        $this->invitationCode = $invitationCode;
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
     * @var ArrayCollection CandidateInterView $interviews
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateInterview", mappedBy="candidate")
     * @Serializer\Exclude
     */
    private $interviews;


    /**
     * @param CandidateInterview $interview
     * @return $this
     */
    public function addInterview($interview)
    {
        $this->interviews->add($interview);
        $interview->setCandidate($this);
        return $this;
    }

    /**
     * @param CandidateInterview $interview
     * @return $this
     */
    public function removeInterview($interview)
    {
        $this->interviews->removeElement($interview);
        $interview->setCandidate(null);
        return $this;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateReviewer", mappedBy="candidate")
     * @Serializer\Exclude
     */
    private $reviewers;

    public function addReviewer(CandidateReviewer $reviewer)
    {
        $this->reviewers->add($reviewer);
        return $this;
    }

    public function removeReviewer(CandidateReviewer $reviewer)
    {
        $this->reviewers->removeElement($reviewer);
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User", inversedBy="candidates",cascade={"merge","persist","remove"})
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $user;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"merge","persist","remove"},inversedBy="resumeCandidate")
     * @ORM\JoinColumn(name="id_resume", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $resume;

    /**
     * @var Gallery
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", cascade={"merge","persist","remove"},orphanRemoval=true, inversedBy="introCandidate")
     * @ORM\JoinColumn(name="id_intro_video_gallery", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $introVideoGallery;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="deadline",nullable=true)
     */
    private $deadline;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="interviewed",options={"default":false},nullable=true)
     */
    private $interviewed;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="enabled", options={"default":true})
     */
    private $enabled;


    /**
     * @var bool
     * @ORM\Column(type="boolean", name="reattemptable", options={"default":false},nullable=true)
     */
    private $reattemptable;


    /**
     * @var bool
     * @ORM\Column(type="boolean", name="withdrawn", options={"default":false})
     */
    private $withdrawn;

    /**
     * @var string
     * @ORM\Column(type="string", name="status")
     */
    private $status;


    /**
     * @var string
     * @ORM\Column(type="string", name="invitation_status")
     */
    private $invitationStatus;


    /**
     * @param bool $withdawn
     */
    public function setWithdrawn($withdrawn)
    {
        $this->withdrawn = $withdrawn;
    }

    /**
     * @param Position $position
     * @return $this
     */
    public function setPositionOwner($position)
    {
        return null;
    }


    /**
     * @param User $user
     * @return $this
     */
    public function setUserOwner($user)
    {
        return $this;
    }

    /**
     * @return User
     */
    public function getUserOwner()
    {
        return $this->user;
    }

    /**
     * @return Position
     */
    public function getPositionOwner()
    {
        return $this->getListing()->getCreator();
    }

    /**
     * @param Organisation $organisation
     * @return $this
     */
    public function setOrganisationOwner($organisation)
    {
        return $this;
    }

    /**
     * @return Organisation
     */
    public function getOrganisationOwner()
    {
        return null;
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

    /**
     * @return ArrayCollection
     */
    public function getReviewers()
    {
        return $this->reviewers;
    }

    /**
     * @param ArrayCollection CandidateReviewer $reviewers
     */
    public function setReviewers($reviewers)
    {
        $this->reviewers = $reviewers;
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Gallery
     */
    public function getIntroVideoGallery()
    {
        return $this->introVideoGallery;
    }

    /**
     * @param Gallery $introVideoGallery
     */
    public function setIntroVideoGallery($introVideoGallery)
    {
        $this->introVideoGallery = $introVideoGallery;
    }

    /**
     * @return Media
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param Media $resume
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
    }

    /**
     * @return boolean
     */
    public function isReattemptable()
    {
        return $this->reattemptable;
    }

    /**
     * @param boolean $reattemptable
     */
    public function setReattemptable($reattemptable)
    {
        $this->reattemptable = $reattemptable;
    }


    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getInvitationStatus()
    {
        return $this->invitationStatus;
    }

    /**
     * @param string $invitationStatus
     */
    public function setInvitationStatus($invitationStatus)
    {
        $this->invitationStatus = $invitationStatus;
    }

    /**
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param \DateTime $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @return boolean
     */
    public function isInterviewed()
    {
        return $this->interviewed;
    }

    /**
     * @param boolean $interviewed
     */
    public function setInterviewed($interviewed)
    {
        $this->interviewed = $interviewed;
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

}
