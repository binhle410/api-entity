<?php
namespace AppBundle\Entity\JobBoard\Listing;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__listing__interview_question_set")
 *
 * @Serializer\XmlRoot("interview-question-set")
 */
class InterviewQuestionSet implements BaseVoterSupportInterface
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
        $this->questions = new ArrayCollection();
        $this->active = false;
        $this->enabled = false;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Listing\InterviewQuestion", mappedBy="set", orphanRemoval=true,cascade={"merge","persist","remove"})
     * @Serializer\Exclude
     */
    private $questions;

    public function addQuestion(InterviewQuestion $question)
    {
        $this->questions->add($question);
        $question->setSet($this);
        return $this;
    }

    public function removeQuestion(InterviewQuestion $question)
    {
        $this->questions->removeElement($question);
        $question->setSet(null);
        return $this;
    }

    /**
     * @var JobListing
     * @ORM\ManyToOne(targetEntity="JobListing",inversedBy="interviewQuestionSets")
     * @ORM\JoinColumn(name="id_listing", referencedColumnName="id")
     */
    private $listing;

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean", options={"default":false}, nullable=true)
     */
    private $active;

    /**
     * @var bool
     * @ORM\Column(name="enabled", type="boolean", options={"default":false}, nullable=true)
     */
    private $enabled;

    /**
     * @var string
     * @ORM\Column(length=120, name="title",type="string",nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(length=120, name="code",type="string",nullable=true)
     */
    private $code;

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
     * @return ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param ArrayCollection $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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