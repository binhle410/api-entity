<?php

// src/AppBundle/Entity/Core/Message/Message.php

namespace AppBundle\Entity\Core\Message;

use AppBundle\Entity\Core\Core\Push;
use AppBundle\Entity\Core\Core\Tag;
use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("message")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_message",
 *         parameters = { "message" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 * @Hateoas\Relation(
 *  "message.post",
 *  href= @Hateoas\Route(
 *         "post_message",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation("sender",
 *  href = @Hateoas\Route(
 *         "get_user",
 *         parameters = { "username" = "expr(object.getSender().getEmail())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getSender() === null)")
 * )
 * @Hateoas\Relation("recipient",
 *  href = @Hateoas\Route(
 *         "get_user",
 *         parameters = { "username" = "expr(object.getRecipient().getEmail())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getRecipient() === null)")
 * )
 *
 * @Hateoas\Relation("creator",
 *  href = @Hateoas\Route(
 *         "get_user",
 *         parameters = { "username" = "expr(object.getCreator().getEmail())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getCreator() === null)")
 * )
 *
 * @Hateoas\Relation("parent",
 *  href = @Hateoas\Route(
 *         "get_message",
 *         parameters = { "message" = "expr(object.getParent().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getParent() === null)")
 * )
 *
 *  Hateoas\Relation(
 *  "notification.push",
 *  href= Hateoas\Route(
 *         "put_organisation_notification_push",
 *         parameters = { "organisation" = "expr(object.getPush().getEntityId())","notification" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.isTagNotification() === false)")
 * )
 *
 * @Hateoas\Relation("push",
 *  href = @Hateoas\Route(
 *         "get_push",
 *         parameters = { "push" = "expr(object.getPush().getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getPush() === null)")
 * )
 *
 * @ORM\Entity
 * @ORM\Table(name="message")
 */
class Message
{

    const TYPE_EMAIL = 'EMAIL';
    const TYPE_APP = 'APP';
    const TYPE_SMS = 'SMS';
    const TAG_NOTIFICATION = 'NOTIFICATION';

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->tags = new ArrayCollection();
//        $this->push = new Push();
    }

    /**
     * @var Push
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Core\Push",cascade={"merge","remove","persist"})
     * @ORM\JoinColumn(name="id_push", referencedColumnName="id", unique=true)
     * @Serializer\Exclude
     */
    private $push;

    /**
     * @var Message
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Message\Message")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $parent;

    /**
     * @var MessageSetting
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Message\MessageList",inversedBy="messages")
     * @ORM\JoinColumn(name="id_list", referencedColumnName="id")
     */
    private $list;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_creator", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $creator;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_sender", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $sender;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinColumn(name="id_recipient", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $recipient;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Core\Tag")
     * @ORM\JoinTable(name="messages_tags",
     *      joinColumns={@ORM\JoinColumn(name="id_message", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id")}
     *      )
     * */
    private $tags;

    public function hasNotificationTag()
    {
        $tags = $this->getTags();
        foreach ($tags as $tag) {
            if ($tag->getName() == self::TAG_NOTIFICATION) {
                return true;
            }
        }
        return false;
    }

    public function addNotificationTag(Tag $notificationTag)
    {
        if ($notificationTag->getName() !== self::TAG_NOTIFICATION) {
            return false;
        }
        foreach ($this->tags as $tag) {
            if ($tag->getName() == self::TAG_NOTIFICATION) {
                return true;
            }
        }
        $this->tags->add($notificationTag);
        return true;
    }

    /**
     * @param Tag $tag
     */
    public function addTag($tag)
    {
        $this->tags->add($tag);
        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function removeTag($tag)
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at",nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="last_sent_at",nullable=true)
     */
    private $lastSentAt;

    /**
     * @var boolean
     * @ORM\Column(name="automated",type="boolean",options={"default":false},nullable=true)
     */
    private $automated;

    /**
     * @var boolean
     * @ORM\Column(name="is_read",type="boolean",options={"default":false},nullable=true)
     */
    private $read;

    /**
     * @var boolean
     * @ORM\Column(name="trashed",type="boolean",options={"default":false},nullable=true)
     */
    private $trashed;

    /**
     * @var boolean
     * @ORM\Column(name="archived",type="boolean",options={"default":false},nullable=true)
     */
    private $archived;

    /**
     * eg: 202 to be used with an automated message.
     * The message has been accepted but not yet sent, if directly posted then an id should be returned
     * ... 404 when sending failed
     * ... 200 means OK
     * ... 201 when the message is created and sent in one single API call.
     * @var int
     * @ORM\Column(name="status", type="integer",nullable=true)
     */
    private $status;

    /**
     * @var int
     * @ORM\Column(name="error_code", type="integer",nullable=true)
     */
    private $errorCode;

    /**
     * @var string
     * @ORM\Column(name="error_msg", length=120,nullable=true)
     */
    private $errorMsg;

    /**
     * EMAIL, APP, SMS
     * @var string
     * @ORM\Column(name="type", length=50,nullable=true)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="msg_subject",length=250,nullable=true)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="msg_body", length=12000,nullable=true)
     */
    private $body;

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
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return User
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param User $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return boolean
     */
    public function isAutomated()
    {
        return $this->automated;
    }

    /**
     * @param boolean $automated
     */
    public function setAutomated($automated)
    {
        $this->automated = $automated;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * @param string $errorMsg
     */
    public function setErrorMsg($errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }

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
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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
     * @return \DateTime
     */
    public function getLastSentAt()
    {
        return $this->lastSentAt;
    }

    /**
     * @param \DateTime $lastSentAt
     */
    public function setLastSentAt($lastSentAt)
    {
        $this->lastSentAt = $lastSentAt;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return boolean
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @param boolean $read
     */
    public function setRead($read)
    {
        $this->read = $read;
    }

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
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return boolean
     */
    public function isTrashed()
    {
        return $this->trashed;
    }

    /**
     * @param boolean $trashed
     */
    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
    }

    /**
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param boolean $archived
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    /**
     * @return MessageSetting
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param MessageSetting $list
     */
    public function setList($list)
    {
        $this->list = $list;
    }

    /**
     * @return Message
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Message $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Push
     */
    public function getPush()
    {
        return $this->push;
    }

    /**
     * @param Push $push
     */
    public function setPush($push)
    {
        $this->push = $push;
    }

}
