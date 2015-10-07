<?php
// src/AppBundle/Entity/Core/Message/Message.php

namespace AppBundle\Entity\Core\Message;

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
 *     )
 * )
 * @Hateoas\Relation("recipient",
 *  href = @Hateoas\Route(
 *         "get_user",
 *         parameters = { "username" = "expr(object.getRecipient().getEmail())"},
 *         absolute = true
 *     )
 * )
 *
 * @ORM\Entity
 * @ORM\Table(name="message")
 */
class Message
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct(){
        $this->createdAt = new DateTime();
    }

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
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="last_sent_at")
     */
    private $lastSentAt;

    /**
     * @var boolean
     * @ORM\Column(length=50, name="automated",type="boolean",options={"default":false})
     */
    private $automated;

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
     * @var string
     * @ORM\Column(name="subject",length=250,nullable=true)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="content", length=12000,nullable=true)
     */
    private $content;

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
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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


}