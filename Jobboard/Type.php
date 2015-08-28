<?php
// src/AppBundle/Entity/Jobboard/Type.php
namespace AppBundle\Entity\Jobboard;

use AppBundle\Entity\Core\BasicEnum;

abstract class Type extends BasicEnum {
    const FULL_TIME = 'FULL_TIME';
    const PART_TIME = 'PART_TIME';
    const CONTRACT = 'CONTRACT';
    const AD_HOC = 'AD_HOC';
    const OJT = 'OJT';
}