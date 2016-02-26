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
     * @var string
     * @ORM\Column(name="question",type="string",length=1000,nullable=true)
     * @Serializer\Exclude
     */
    private $question;


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
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }


}