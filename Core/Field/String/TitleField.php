<?php
namespace AppBundle\Entity\Core\Field\String;

use AppBundle\Entity\Core\Field\Field;

class TitleField extends Field implements BaseVoterSupportInterface
{

    /**
     * @return TitleField
     */
    function getInstance()
    {
        return $this;
    }
}