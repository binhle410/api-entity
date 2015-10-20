<?php
namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Accounting\Payroll\Salary;
use AppBundle\Entity\Core\Location\Location;
use AppBundle\Entity\Core\Tag;
use AppBundle\Entity\Core\User\User;
use AppBundle\Entity\JobBoard\Listing\JobListing;
use AppBundle\Entity\Organisation\Organisation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_candidate")
 */
class JobCandidate
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var JobListing
     */
    private $listing;

    /**
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="job_candidates_reviewers",
     *      joinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id")},
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
     * @ORM\JoinTable(name="job_candidates_observers",
     *      joinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id")},
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
     * @var ArrayCollection CandidateFolder
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateFolder",mappedBy="candidates"))
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

}