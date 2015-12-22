<?php
namespace AppBundle\Entity\Core\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * ORM\Entity
 * ORM\Table(name="core__patch")
 */
class Patch
{
    /**
     * ORM\Id
     * ORM\Column(type="integer",options={"unsigned":true})
     * ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Operation objects MUST have exactly one "op" member, whose value
    indicates the operation to perform.  Its value MUST be one of "add",
    "remove", "replace", "move", "copy", or "test"; other values are
    errors.  The semantics of each object is defined below. ... (rfc6902)
     */
    const OP_ADD = 'ADD_OPERATION';
    const OP_REMOVE = 'REMOVE_OPERATION';
    const OP_REPLACE = 'REPLACE_OPERATION';
    const OP_MOVE = 'MOVE_OPERATION';
    const OP_COPY = 'COPY_OPERATION';
    const OP_TEST = 'TEST_OPERATION';

    private $op;
    private $path;
    private $value;
    private $from;

    /**
     * @return mixed
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * @param mixed $op
     */
    public function setOp($op)
    {
        $this->op = $op;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return ArrayCollection
     */
    public function getPatches()
    {
        return $this->patches;
    }

    /**
     * @param ArrayCollection $patches
     */
    public function setPatches($patches)
    {
        $this->patches = $patches;
    }




}