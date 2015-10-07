<?php

// src/AppBundle/Entity/Core/Message/MessageSetting.php

namespace AppBundle\Entity\Core\Message;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("message_setting")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_messagesetting",
 *         parameters = { "messageSetting" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 * @Hateoas\Relation(
 *  "message_setting.post",
 *  href= @Hateoas\Route(
 *         "post_messagesetting",
 *         parameters = {},
 *         absolute = true
 *     )
 * )
 * @ORM\Entity
 * @ORM\Table(name="message_setting")
 */
class MessageSetting {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="template", length=1200)
     */
    private $template;

    /**
     * eg: email
     * @var string
     * @ORM\Column(name="type", length=12)
     */
    private $type;

    /**
     * eg: organisation.position
     * @var string
     * @ORM\Column(name="entity", length=120)
     */
    private $entity;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template) {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity($entity) {
        $this->entity = $entity;
    }

}
