<?php
namespace AppBundle\Entity\JobBoard\Application;
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\JobBoard\Application\JobCandidate")
     * @ORM\JoinTable(name="job_folders_candidates",
     *      joinColumns={@ORM\JoinColumn(name="id_folder", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_candidate", referencedColumnName="id", unique=true)}
     *      )
     */
    private $reviewers;

    /**
     * @var ArrayCollection User
     */
    private $observers;

    /**
     * @var ArrayCollection JobCandidate
     */
    private $candidates;

    /**
     * @var string
     */
    private $title;


}