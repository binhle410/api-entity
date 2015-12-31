<?php
namespace AppBundle\Entity\Core\Field\Primitive;

use AppBundle\Entity\Core\Field\Field;


/**
 * ORM\Entity
 * ORM\Table(name="field_integer")
 */
class IntegerField extends Field
{

    /**
     * @return IntegerField
     */
    function getInstance()
    {
        return $this;
    }
}