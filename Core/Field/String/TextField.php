<?php
namespace AppBundle\Entity\Core\Field\String;

use AppBundle\Entity\Core\Field\Field;

class TextField extends Field implements BaseVoterSupportInterface
{

    /**
     * @return TextField
     */
    function getInstance()
    {
        return $this;
    }
}