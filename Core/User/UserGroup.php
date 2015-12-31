<?php

namespace AppBundle\Entity\Core\User;

use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user__group")
 */
class UserGroup extends BaseGroup implements BaseVoterSupportInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(length=120, name="type",type="string",nullable=false) */
    private $type;

    //todo map
    /**
     * organisation:Orga.... - each usergroup must belong to an Organisation
     */
}
