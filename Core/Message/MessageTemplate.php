<?php

// src/AppBundle/Entity/Core/Message/MessageTemplate.php

namespace AppBundle\Entity\Core\Message;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("message_template")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_messagetemplate",
 *         parameters = { "template" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 * @Hateoas\Relation(
 *  "message_template.post",
 *  href= @Hateoas\Route(
 *         "post_messagetemplate",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 * @ORM\Entity
 * @ORM\Table(name="message__template")
 */
class MessageTemplate
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="subject_template", length=250)
     */
    private $subjectTemplate;

    /**
     * @var string
     * @ORM\Column(name="body_template", length=1200)
     */
    private $bodyTemplate;

    /**
     * Message:CONST TYPE_EMAIL, TYPE_SMS, TYPE_APP
     * @var string
     * @ORM\Column(name="type", length=50)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="entity", length=120)
     */
    private $entity;

    /**
     * @var string
     * @ORM\Column(name="code", length=120)
     */
    private $code;

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
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getSubjectTemplate()
    {
        return $this->subjectTemplate;
    }

    /**
     * @param string $subjectTemplate
     */
    public function setSubjectTemplate($subjectTemplate)
    {
        $this->subjectTemplate = $subjectTemplate;
    }

    /**
     * @return string
     */
    public function getBodyTemplate()
    {
        return $this->bodyTemplate;
    }

    /**
     * @param string $bodyTemplate
     */
    public function setBodyTemplate($bodyTemplate)
    {
        $this->bodyTemplate = $bodyTemplate;
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


}
