<?php

namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Entity\Organisation\Position;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\OwnableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\JobBoard\Application\CandidateReviewerRepository")
 * @ORM\Table(name="job__application__candidate_reviewer")
 */
class CandidateReviewer implements BaseVoterSupportInterface, OwnableInterface
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
        $this->viewed = false;
    }

    /**
     * @var JobCandidate
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Application\JobCandidate", inversedBy="reviewers")
     * @ORM\JoinColumn(name="id_candidate", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $candidate;

    /**
     * @var Position
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Position", inversedBy="candidateReviewers")
     * @ORM\JoinColumn(name="id_position", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $position;

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
     * @ORM\Column(type="string",name="title")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="vote",type="string")
     */
    private $vote;


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
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
     * @return string
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param string $vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
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
        // TODO: Implement getUserOwner() method.
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
        return $this->position;
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
        // TODO: Implement getOrganisationOwner() method.
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

}
