<?php
namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_candidate_folder")
 */
class CandidateFolder
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="job_folders_reviewers",
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
     * @ORM\JoinTable(name="job_folders_observers",
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\JobCandidate")
     * @ORM\JoinTable(name="job_folders_candidates",
     *      joinColumns={@ORM\JoinColumn(name="id_folder", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id", unique=true)}
     *      )
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


}