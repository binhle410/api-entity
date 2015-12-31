<?php
namespace AppBundle\Entity\Core\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="user__profile_section")
 */
class UserProfileSection implements BaseVoterSupportInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var UserProfile
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Core\User\UserProfile",inversedBy="sections")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $profile;

    /**
     * @var UserProfileSection
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Core\User\UserProfileSection",inversedBy="children")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\User\UserProfileSection", mappedBy="parent",orphanRemoval=true)
     */
    private $children;

    public function addChild(UserProfileSection $section)
    {
        $this->children->add($section);
        $section->setParent($this);
    }

    public function removeChild(UserProfileSection $section)
    {
        $this->children->removeElement($section);
        $section->setParent(null);
    }

    /**
     * @var \DateTime
     * @ORM\Column(name="start_time",type="datetime",nullable=true)
     */
    private $startTime;

    /**
     * @var \DateTime
     * @ORM\Column(name="end_time",type="datetime",nullable=true)
     */
    private $endTime;

    /**
     * @var string
     * @ORM\Column(length=120, name="title",type="string",nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(length=120, name="description",type="string",nullable=true)
     */
    private $description;

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
     * @return UserProfile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param UserProfile $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return UserProfileSection
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param UserProfileSection $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return UserProfileSection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param UserProfileSection $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}