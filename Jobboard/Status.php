<?php
// src/AppBundle/Entity/Jobboard/Status.php
namespace AppBundle\Entity\Jobboard;

use AppBundle\Entity\Core\BasicEnum;

abstract class Status extends BasicEnum
{
    const ACTIVE = 'ACTIVE';
    const PENDING = 'PENDING';
    const EXPIRED = 'EXPIRED';
    const DRAFT = 'DRAFT';
}