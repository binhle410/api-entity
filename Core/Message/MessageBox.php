<?php
namespace AppBundle\Entity\Core\Message;

use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="message_box")
 */
class MessageBox
{
    /**
     * @var User
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\User\User", inversedBy="messageBox")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $user;

    /**
     * @var ArrayCollection Message
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Message\Message")
     * @ORM\JoinTable(name="users_messages",
     *      joinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id_user")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_message", referencedColumnName="id")}
     *      )
     */
    private $messages;

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param ArrayCollection $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }


}