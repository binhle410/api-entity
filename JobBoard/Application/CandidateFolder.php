<?php
namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__application__folder")
 */
class CandidateFolder implements BaseVoterSupportInterface
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
        $this->reviewers = new ArrayCollection();
        $this->observers = new ArrayCollection();
        $this->candidates = new ArrayCollection();
    }

    /**
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="job__application__folders_reviewers",
     *      joinColumns={@ORM\JoinColumn(name="id_folder", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_reviewer", referencedColumnName="id", unique=true)}
     *      )
     */
    private $reviewers;

    public function addReviewer(User $user)
    {
        $this->reviewers->add($user);
    }

    public function removeReviewer(User $user)
    {
        $this->reviewers->removeElement($user);
    }

    /**
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="job__application__folders_observers",
     *      joinColumns={@ORM\JoinColumn(name="id_folder", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_observer", referencedColumnName="id", unique=true)}
     *      )
     */
    private $observers;

    public function addObserver(User $user)
    {
        $this->observers->add($user);
    }

    public function removeObserver(User $user)
    {
        $this->observers->removeElement($user);
    }

    /**
     * @var ArrayCollection JobCandidate
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\JobCandidate",mappedBy="folders")
     */
    private $candidates;

    public function addCandidate(User $user)
    {
        $this->candidates->add($user);
    }

    public function removeCandidate(User $user)
    {
        $this->candidates->removeElement($user);
    }

    /**
     * @var string
     */
    private $title;

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
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * @param ArrayCollection $candidates
     */
    public function setCandidates($candidates)
    {
        $this->candidates = $candidates;
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


}