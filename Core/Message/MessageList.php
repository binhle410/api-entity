<?php
namespace AppBundle\Entity\Core\Message;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="message_list")
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

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_sender", referencedColumnName="id")
     */
    private $sender;

    /**
     * @var MessageSetting
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Message\MessageSetting")
     * @ORM\JoinColumn(name="id_setting", referencedColumnName="id")
     */
    private $setting;

    /**
     * @var ArrayCollection User
     * @ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @JoinTable(name="messages_users",
     *      joinColumns={@JoinColumn(name="id_message", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="id_recipient", referencedColumnName="id", unique=true)}
     *      )
     */
    private $recipients;

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
     * @return ArrayCollection
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param ArrayCollection $recipients
     */
    public function setRecipients(ArrayCollection $recipients)
    {
        $this->recipients = $recipients;
    }

    /**
     * @return MessageSetting
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @param MessageSetting $setting
     */
    public function setSetting($setting)
    {
        $this->setting = $setting;
    }

}