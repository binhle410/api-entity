<?php
namespace AppBundle\Entity\Core\User;

use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="user__group")
 */
class UserGroup extends BaseGroup implements BaseVoterSupportInterface
{
    function __construct($name, array $roles)
    {
        parent::__construct($name, $roles);
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User", mappedBy="groups")
     * @Serializer\Exclude
     */
    private $users;

    /**
     * @var string
     * @ORM\Column(length=120, name="type",type="string",nullable=false)
     */
    private $type;
    //todo map
    /**
     * organisation:Orga.... - each usergroup must belong to an Organisation
     */
}
