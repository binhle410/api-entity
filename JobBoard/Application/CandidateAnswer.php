<?php
namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\JobBoard\Listing\InterviewQuestion;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\ListVoterSupportInterface;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__application__answer")
 *
 * @Serializer\XmlRoot("answer")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_joblisting_jobcandidate_candidateinterview_answer",
 *         parameters = { "listing" = "expr(object.getInterview().getCandidate().getListing().getId())","candidate" = "expr(object.getInterview().getCandidate().getId())","interview" = "expr(object.getInterview().getId())","answer" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))"},
 * )

 * @Hateoas\Relation(
 *  "question_text",
 *  href= @Hateoas\Route(
 *         "get_joblisting_jobcandidate_candidateinterview_answer_question_text",
 *         parameters = { "listing" = "expr(object.getInterview().getCandidate().getListing().getId())","candidate" = "expr(object.getInterview().getCandidate().getId())","interview" = "expr(object.getInterview().getId())","answer" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))"},
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(object.getViewTime()  !== null)"
 *      )
 * )

 * @Hateoas\Relation(
 *  "video",
 *  href= @Hateoas\Route(
 *         "post_joblisting_jobcandidate_candidateinterview_answer_video",
 *         parameters = { "listing" = "expr(object.getInterview().getCandidate().getListing().getId())","candidate" = "expr(object.getInterview().getCandidate().getId())","interview" = "expr(object.getInterview().getId())","answer" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))"},
 * )
 *
 *
 */
class CandidateAnswer implements BaseVoterSupportInterface, ListVoterSupportInterface
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
        $this->enabled = true;
    }

    /**
     * @var CandidateInterview
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateInterview", inversedBy="answers")
     * @ORM\JoinColumn(name="id_interview", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $interview;

    /**
     * @var Media
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", inversedBy="candidateAnswer")
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $video;

    /**
     * @var \DateTime
     * @ORM\Column(name="view_time",type="datetime",nullable=true)
     */
    private $viewTime;

    /**
     * @var \DateTime
     * @ORM\Column(name="record_time",type="datetime",nullable=true)
     */
    private $recordTime;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="enabled", options={"default":true})
     */
    private $enabled;

    /**
     * Time limit in mili seconds
     * @var int
     * @ORM\Column(name="interview_time_limit", type="integer", options={"default":0}, nullable=true)
     */
    private $interviewTimeLimit;

    /**
     * @var int
     * @ORM\Column(name="question_reading_time_limit", type="integer", options={"default":0}, nullable=true)
     */
    private $questionReadingTimeLimit;

    /**
     * @var int
     * @ORM\Column(name="ordering", type="integer", nullable=true)
     * @Serializer\Exclude
     */
    private $ordering;

    /**
     * @var string
     * @ORM\Column(name="question_text",type="string",length=1000,nullable=true)
     * @Serializer\Exclude
     */
    private $questionText;


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
     * @return CandidateInterview
     */
    public function getInterview()
    {
        return $this->interview;
    }

    /**
     * @param CandidateInterview $interview
     */
    public function setInterview($interview)
    {
        $this->interview = $interview;
    }

    /**
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param int $ordering
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
    }

    /**
     * @return string
     */
    public function getQuestionText()
    {
        return $this->questionText;
    }

    /**
     * @param string $questionText
     */
    public function setQuestionText($questionText)
    {
        $this->questionText = $questionText;
    }

    /**
     * @return \DateTime
     */
    public function getViewTime()
    {
        return $this->viewTime;
    }

    /**
     * @param \DateTime $viewTime
     */
    public function setViewTime($viewTime)
    {
        $this->viewTime = $viewTime;
    }

    /**
     * @return \DateTime
     */
    public function getRecordTime()
    {
        return $this->recordTime;
    }

    /**
     * @param \DateTime $recordTime
     */
    public function setRecordTime($recordTime)
    {
        $this->recordTime = $recordTime;
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
     * @return Media
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Media $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return mixed
     */
    public function getInterviewTimeLimit()
    {
        return $this->interviewTimeLimit;
    }

    /**
     * @param mixed $interviewTimeLimit
     */
    public function setInterviewTimeLimit($interviewTimeLimit)
    {
        $this->interviewTimeLimit = $interviewTimeLimit;
    }

    /**
     * @return int
     */
    public function getQuestionReadingTimeLimit()
    {
        return $this->questionReadingTimeLimit;
    }

    /**
     * @param int $questionReadingTimeLimit
     */
    public function setQuestionReadingTimeLimit($questionReadingTimeLimit)
    {
        $this->questionReadingTimeLimit = $questionReadingTimeLimit;
    }

}