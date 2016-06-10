<?php
// src/AppBundle/Entity/Core/Site.php

namespace AppBundle\Entity\Core\Core;

use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="core__invitation_code")
 * @Serializer\XmlRoot("invitation_code")

 */
class InvitationCode implements BaseVoterSupportInterface
{

    const TYPE_INVITATION_CODE_JOB = 'JOB';
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    

    /** @ORM\Column(name="code",type="string") */
    private $code;

    /** @ORM\Column(name="type",type="string") */
    private $type;

    /** @ORM\Column(name="enabled",type="boolean",options={"default":true}) */
    private $enabled;

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }


    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



}