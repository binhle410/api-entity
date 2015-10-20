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
     */
    private $reviewers;

    /**
     * @var ArrayCollection User
     */
    private $observers;

    /**
     * @var ArrayCollection CandidateFolder
     */
    private $folders;
}