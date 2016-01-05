<?php

namespace AppBundle\Entity\Core\User;

use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use AppBundle\Entity\Core\User\User;

/**
 * UserDevice
 *
 * @ORM\Table(name="user__device")
 * @ORM\Entity()
 */
class UserDevice implements BaseVoterSupportInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="device_token", type="string", length=255, nullable=false)
     */
    private $deviceToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="userDevices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Serializer\Exclude
     * */
    private $user;

    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $deviceToken
     * @return UserDevice
     */
    public function setDeviceToken($deviceToken)
    {
        $this->deviceToken = $deviceToken;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDeviceToken()
    {
        return $this->deviceToken;
    }

    /**
     * Set User
     *
     * @param User $user
     * @return User
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

}
