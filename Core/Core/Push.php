<?php
namespace AppBundle\Entity\Core\Core;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="push")
 * @Serializer\XmlRoot("push")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_push",
 *         parameters = { "push" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 */
class Push
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->size = 0;
        $this->current = 0;
        $this->total = 0;
    }

    /**
     * @var int
     * @ORM\Column(name="total", type="integer",nullable=true,options={"default":0})
     */
    private $total;

    /**
     * @var int
     * @ORM\Column(name="size", type="integer",nullable=true,options={"default":0})
     */
    private $size;

    /**
     * @var int
     * @ORM\Column(name="current", type="integer",nullable=true,options={"default":0})
     */
    private $current;

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
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param int $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

}