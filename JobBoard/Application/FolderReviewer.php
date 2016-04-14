<?php

namespace AppBundle\Entity\JobBoard\Application;

use AppBundle\Entity\Core\User\User;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__application__folder_reviewer")
 */
class FolderReviewer implements BaseVoterSupportInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct() {
        
    }
    
    /**
     * @var Position
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Position", inversedBy="folderReviewers")
     * @ORM\JoinColumn(name="id_position", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $position;

    /**
     * @var bool
     */
    private $viewOnly;

    /**
     * @var string
     */
    private $vote;


    /**
     * @var JobCandidate
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\JobBoard\Application\CandidateFolder", inversedBy="reviewers")
     * @ORM\JoinColumn(name="id_folder", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $folder;

    /**
     * @return JobCandidate
     */
    public function getCandidate() {
        return $this->candidate;
    }

    /**
     * @param JobCandidate $candidate
     */
    public function setCandidate($candidate) {
        $this->candidate = $candidate;
    }


    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
}
