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
 * @ORM\Table(name="job__listing__interview_question")
 *
 * @Serializer\XmlRoot("interview-question")
 * Hateoas\Relation(
 *  "self",
 *  href= Hateoas\Route(
 *         "get_",
 *         parameters = { "listing" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 */
class InterviewQuestion implements BaseVoterSupportInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var InterviewQuestionSet
     * @ORM\ManyToOne(targetEntity="InterviewQuestionSet",inversedBy="questions")
     * @ORM\JoinColumn(name="id_set", referencedColumnName="id")
     **/
    private $set;

    /**
     * @var string
     * @ORM\Column(length=120, name="title",type="string",nullable=true)
     */
    private $title;

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
     * @return InterviewQuestionSet
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @param InterviewQuestionSet $set
     */
    public function setSet($set)
    {
        $this->set = $set;
    }

}