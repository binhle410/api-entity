<?php
namespace AppBundle\Entity\Core\User;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\Core\User\UserRepository")
 * @ORM\Table(name="user__user_action")
 *
 * @Serializer\XmlRoot("user-action")
 *
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_user",
 *         parameters = { "username" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Gedmo\TranslationEntity(class="AppBundle\TranslationEntity\Core\User\UserActionTranslation")
 */
class UserAction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     * @ORM\Column(type="boolean",options={"default":true},name="enabled")
     */
    private $enabled = true;

    /**
     * @var string
     * @ORM\Column(type="string", name="name",length=250)
     * @Gedmo\Translatable
     */
    private $name;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
