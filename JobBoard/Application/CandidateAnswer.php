<?php
namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\JobBoard\Listing\InterviewQuestion;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\ListVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__application__answer")
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

    /**
     * @var CandidateInterview
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateInterview", inversedBy="answers")
     * @ORM\JoinColumn(name="id_interview", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $interview;

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
     * @var int
     * @ORM\Column(name="ordering", type="integer", nullable=true)
     * @Serializer\Exclude
     */
    private $ordering;

    /**
     * @var string
     * @ORM\Column(name="question_text",type="string",length=1000,nullable=true)
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

}