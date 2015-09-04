<?php
// src/AppBundle/Entity/Core/User/User.php
// cachced system.user:username:['password' => text, 'roles' => $user->getRoles()]
// <- ApiKeyAuthenticator:authenticateToken:93

// config: fos_user.user_class
namespace AppBundle\Entity\Core\User;

use AppBundle\Entity\Work\Position;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __construct()
    {
        parent::__construct();
        $this->jobs = new ArrayCollection();
        // your own logic
    }

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Position", mappedBy="employee", orphanRemoval=true)
     */
    private $positions;

    public function addPosition(Position $position)
    {
        $this->positions->add($position);
        $position->setEmployee($this);
    }

    /**
     * @ORM\ManyToMany(targetEntity="UserGroup")
     * @ORM\JoinTable(name="user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_group", referencedColumnName="id")}
     * )
     */
    protected $groups;
    //TODO implement addGroup, removeGroup

    /** @ORM\Column(length=120, name="ssn",type="string",nullable=true) */
    private $ssn;

    /** @ORM\Column(length=120, name="first_name",type="string",nullable=true) */
    private $firstName;

    /** @ORM\Column(length=120, name="middle_name",type="string",nullable=true) */
    private $middleName;

    /** @ORM\Column(length=120, name="last_name",type="string",nullable=true) */
    private $lastName;


    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param mixed $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return Organisation
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param mixed $sites
     */
    public function setSites($sites)
    {
        $this->sites = $sites;
    }

    /**
     * @return mixed
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * @param mixed $ssn
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;
    }

    /**
     * @return ArrayCollection
     */
    public function getPositions()
    {
        return $this->positions;
    }


}