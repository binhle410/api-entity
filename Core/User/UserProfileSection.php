<?php
namespace AppBundle\Entity\Core\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class UserProfileSection
{

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
     * @var UserProfileSection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\User\UserProfileSection", mappedBy="parent",orphanRemoval=true)
     */
    private $children;

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
}