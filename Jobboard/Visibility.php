<?php
// src/AppBundle/Entity/Jobboard/Visibility.php
namespace AppBundle\Entity\Jobboard;

use AppBundle\Entity\Core\BasicEnum;

abstract class Visibility extends BasicEnum {
    const LISTED = 'LISTED';
    const UNLISTED = 'UNLISTED';
    const SECURED = 'SECURED';
}