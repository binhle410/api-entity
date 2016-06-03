<?php
namespace AppBundle\Entity\Core\User;

use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("user_group")
 * @ORM\Entity
 * @ORM\Table(name="user__group")
 *
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_organisation_usergroup",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())","userGroup" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Hateoas\Relation(
 *  "users",
 *  href= @Hateoas\Route(
 *         "get_organisation_usergroup_users",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())","userGroup" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  )
 * @Hateoas\Relation(
 *  "handbook_user_group_aces",
 *  href= @Hateoas\Route(
 *         "get_organisation_usergroup_cloudbookacls",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())","userGroup" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "user_user_group_aces",
 *  href= @Hateoas\Route(
 *         "get_organisation_usergroup_useracls",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())","userGroup" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "user_group_user_group_aces",
 *  href= @Hateoas\Route(
 *         "get_organisation_usergroup_usergroupacls",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())","userGroup" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 *
 */
class UserGroup  implements BaseVoterSupportInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User", mappedBy="groups",cascade={"persist","remove"},orphanRemoval=true)
     * @Serializer\Exclude
     */
    private $users;

    public function addUser($user)
    {
        $this->users->add($user);
        $user->addGroup($this);
    }

    public function removeUser($user)
    {
        $this->users->removeElement($user);
//        $user->removeGroup()
    }

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Organisation",inversedBy="userGroups")
     * @Serializer\Exclude
     */
    private $organisation;

    /**
     * @var string
     * @ORM\Column(length=120, name="type",type="string",nullable=false)
     */
    private $type;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @var string
     * @ORM\Column(length=120, name="name",type="string",nullable=false)
     */
    private $name;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return Organisation
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param Organisation $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }


}
