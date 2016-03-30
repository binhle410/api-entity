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
 * @ORM\Entity
 * @ORM\Table(name="job__application__folder")
 */
class CandidateFolder implements BaseVoterSupportInterface, OwnableInterface
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
        $this->candidates = new ArrayCollection();
    }

    /**
     * @var ArrayCollection JobCandidate
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\JobCandidate",mappedBy="folders")
     */
    private $candidates;

    public function addCandidate(JobCandidate $candidate)
    {
        $this->candidates->add($candidate);
        $candidate->addFolder($this);
    }

    public function removeCandidate(JobCandidate $candidate)
    {
        $this->candidates->removeElement($candidate);
        $candidate->removeFolder($this);
    }

    /**
     * @var ArrayCollection FolderReviewer
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\JobBoard\Application\FolderReviewer",mappedBy="folder")
     */
    private $reviewers;

    /**
     * @var Position
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Position")
     * @ORM\JoinColumn(name="id_creator", referencedColumnName="id")
     * @Serializer\Exclude
     * */
    private $creator;

    /**
     * @var int
     * @ORM\Column(type="integer", name="ordering")
     */
    private $ordering;
    
    /**
     * @var string
     * @ORM\Column(type="string", name="name",length=250)
     */
    private $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
        // TODO: Implement getPositionOwner() method.
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
     * @return Position
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param Position $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
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
    

}