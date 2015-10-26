<?php
// src/AppBundle/Entity/Core/User/User.php
// cachced system.user:username:['password' => text, 'roles' => $user->getRoles()]
// <- ApiKeyAuthenticator:authenticateToken:93

// config: fos_user.user_class
namespace AppBundle\Entity\Core\User;

use AppBundle\Entity\Core\Message\MessageBox;
use AppBundle\Entity\Organisation\Position;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Intl\Exception\MethodArgumentNotImplementedException;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\Core\User\UserRepository")
 * @ORM\Table(name="user")
 *
 * @Serializer\XmlRoot("user")
 * @Hateoas\Relation("user.post", href = @Hateoas\Route(
 *         "post_user",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_user",
 *         parameters = { "username" = "expr(object.getEmail())" },
 *         absolute = true
 *     ),
 * attributes = { "method" = {"put","delete"} },
 * )
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
        $this->dateAdded = new \DateTime('now');
        $this->birthday = new \Datetime();
    }

    /**
     * @var MessageBox
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\Message\MessageBox", mappedBy="user",orphanRemoval=true)
     **/
    private $messageBox;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Organisation\Position", mappedBy="employee", orphanRemoval=true)
     */
    private $positions;

    /** positions are initiated by itself and employers/ees should be set to positions and not
     * the other way around.
     */
    public function addPosition(Position $position)
    {
        throw new MethodArgumentNotImplementedException('addPosition', 'position');
    }

    /**
     * @param Position $position
     * @return User
     */
    public function removePosition(Position $position)
    {
        $this->positions->removeElement($position);
        $position->setEmployer(null);
        return $this;
    }

    /**
     * @var ArrayCollection UserProfile
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\User\UserProfile", mappedBy="user",orphanRemoval=true)
     */
    private $profiles;

    public function addProfile(UserProfile $profile)
    {
        $this->profiles->add($profile);
        $profile->setUser($this);
    }

    public function removeProfile(UserProfile $profile)
    {
        $this->profiles->removeElement($profile);
        $profile->setUser(null);
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

    /**
     * @var \DateTime
     * @ORM\Column(name="birthday",type="datetime")
     */
    private $birthday;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_added",type="datetime")
     */
    private $dateAdded;

    /**
     * @var string
     * @ORM\Column(length=50, name="code",type="string",nullable=true, unique=true)
     */
    private $code;

    /** @ORM\Column(length=120, name="ssn",type="string",nullable=true) */
    private $ssn;

    /** @ORM\Column(length=120, name="first_name",type="string",nullable=true) */
    private $firstName;

    /** @ORM\Column(length=120, name="middle_name",type="string",nullable=true) */
    private $middleName;

    /** @ORM\Column(length=120, name="last_name",type="string",nullable=true) */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(length=50,name="office_no", nullable=true)
     */
    private $officeNo;

    /**
     * @var string
     * @ORM\Column(length=50,name="mobile_no", nullable=true)
     */
    private $mobileNo;


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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param ArrayCollection $sites
     */
    public function setSites(ArrayCollection $sites)
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

    /**
     * @param ArrayCollection $positions
     */
    public function setPositions(ArrayCollection $positions)
    {
        $this->positions = $positions;
    }

    /**
     * @return mixed
     */
    public function getMessageBox()
    {
        return $this->messageBox;
    }

    /**
     * @param mixed $messageBox
     */
    public function setMessageBox($messageBox)
    {
        $this->messageBox = $messageBox;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * @param string $mobileNo
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param \DateTime $dateAdded
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * @return string
     */
    public function getOfficeNo()
    {
        return $this->officeNo;
    }

    /**
     * @param string $officeNo
     */
    public function setOfficeNo($officeNo)
    {
        $this->officeNo = $officeNo;
    }

    /**
     * @return ArrayCollection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @param ArrayCollection $profiles
     */
    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
    }



}