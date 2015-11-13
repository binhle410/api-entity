<?php
namespace AppBundle\Entity\Core\Message;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="message__message_list")
 */
class MessageList
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->messages = new ArrayCollection();
    }

    /**
     * @var MessageTemplate
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Message\MessageTemplate")
     * @ORM\JoinColumn(name="id_setting", referencedColumnName="id")
     */
    private $setting;

    /**
     * @var ArrayCollection Message
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Message\Message", mappedBy="list")
     */
    private $messages;

    /**
     * @param Message $message
     */
    public function addMessage($message){
        $this->messages->add($message);
        $message->setList($this);
    }

    /**
     * @param Message $message
     */
    public function removeMessage($message){
        $this->messages->removeElement($message);
        $message->setList(null);
    }

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * eg: 100 recipients are still being added and the list is not completed yet.
     * ... 202 to be used with an automated message.
     * A full message list has been accepted but not yet completed sending, if directly posted then an id should be returned
     * ... 404 when sending failed
     * ... 200 means OK
     * ... 201 not allowed here.
     * @var int
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     * @ORM\Column(length=250, name="name",type="string",nullable=true)
     */
    private $name;


    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     */
    public function setSender(User $sender)
    {
        $this->sender = $sender;
    }


    /**
     * @return MessageTemplate
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @param MessageTemplate $setting
     */
    public function setSetting($setting)
    {
        $this->setting = $setting;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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