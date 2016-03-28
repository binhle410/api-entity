<?php

namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\Organisation\Position;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\ListVoterSupportInterface;
use AppBundle\Services\Core\Framework\OwnableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__application__interview")
 * @Serializer\XmlRoot("candidate-interview")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_joblisting_jobcandidate_candidateinterview",
 *         parameters = { "listing" = "expr(object.getCandidate().getListing().getId())","candidate" = "expr(object.getCandidate().getId())","candidateInterview" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))"},
 * )
 * @Hateoas\Relation(
 *  "answers",
 *  href= @Hateoas\Route(
 *         "get_joblisting_jobcandidate_candidateinterview_answers",
 *         parameters = { "listing" = "expr(object.getCandidate().getListing().getId())","candidate" = "expr(object.getCandidate().getId())","interview" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))"},
 * )
 */
class CandidateInterview implements BaseVoterSupportInterface, ListVoterSupportInterface, OwnableInterface
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
        $this->completed = false;
        $this->answers = new ArrayCollection();
        $this->startTime = new \DateTime();
        $this->enabled = true;
        $this->viewed = false;
    }

    /**
     * @var JobCandidate
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Application\JobCandidate",cascade={"merge","persist","remove"}, inversedBy="interviews")
     * @ORM\JoinColumn(name="id_candidate", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $candidate;

    /**
     * @var ArrayCollection CandidateAnswer
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateAnswer", mappedBy="interview", cascade={"merge","persist","remove"})
     * @Serializer\Exclude
     */
    private $answers;

    /**
     * @param CandidateAnswer $answer
     * @return CandidateInterview
     */
    public function addAnswer($answer)
    {
        $this->answers->add($answer);
        $answer->setInterview($this);
        return $this;
    }

    /**
     * @param CandidateAnswer $answer
     * @return CandidateInterview
     */
    public function removeAnswer($answer)
    {
        $this->answers->removeElement($answer);
        $answer->setInterview(null);
        return $this;
    }


    /**
     * @var \Datetime
     * @ORM\Column(type="datetime", name="start_time",nullable=true)
     */
    private $startTime;

    /**
     * this is the same as JobListing.interviewDeadline
     * @var \Datetime
     * @ORM\Column(type="datetime", name="end_time",nullable=true)
     */
    private $endTime;


    /**
     * @var \Datetime
     * @ORM\Column(type="datetime", name="submitted_time",nullable=true)
     */
    private $submittedTime;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="enabled", options={"default":true})
     */
    private $enabled;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="viewed", options={"default":false})
     */
    private $viewed;

    /**
     * @var string
     * @ORM\Column(type="string", name="question_set_code",nullable=true)
     */
    private $questionSetCode;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="completed",nullable=true)
     */
    private $completed;

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
     * @return JobCandidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param JobCandidate $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * @return string
     */
    public function getQuestionSetCode()
    {
        return $this->questionSetCode;
    }

    /**
     * @param string $questionSetCode
     */
    public function setQuestionSetCode($questionSetCode)
    {
        $this->questionSetCode = $questionSetCode;
    }

    /**
     * @return datetime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \Datetime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \Datetime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \Datetime $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param ArrayCollection $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * @param boolean $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }


    /**
     * @param User $user
     * @return $this
     */
    public function setUserOwner($user)
    {
        // TODO: Implement setUserOwner() method.
    }

    /**
     * @return User
     */
    public function getUserOwner()
    {
        return $this->getCandidate()->getUser();
    }

    /**
     * @param Position $position
     * @return $this
     */
    public function setPositionOwner($position)
    {
        // TODO: Implement setPositionOwner() method.
    }

    /**
     * @return Position
     */
    public function getPositionOwner()
    {
        return $this->getCandidate()->getListing()->getCreator();
    }

    /**
     * @param Organisation $organisation
     * @return $this
     */
    public function setOrganisationOwner($organisation)
    {
        // TODO: Implement setOrganisationOwner() method.
    }

    /**
     * @return Organisation
     */
    public function getOrganisationOwner()
    {
//        return $this->getCandidate()->getListing()->getOrganisation();
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
     * @return boolean
     */
    public function isViewed()
    {
        return $this->viewed;
    }

    /**
     * @param boolean $viewed
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;
    }

    /**
     * @return \Datetime
     */
    public function getSubmittedTime()
    {
        return $this->submittedTime;
    }

    /**
     * @param \Datetime $submittedTime
     */
    public function setSubmittedTime($submittedTime)
    {
        $this->submittedTime = $submittedTime;
    }    

}
