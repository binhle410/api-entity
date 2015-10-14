<?php
// src/AppBundle/Entity/Core/User/UserGroupType.php
namespace AppBundle\Entity\Core\User;

use AppBundle\Entity\Core\BasicEnum;

abstract class UserGroupType extends BasicEnum
{
    const CUSTOM = 'CUSTOM';
    const BENEFIT_APP_USERS = 'BENEFIT-APP-USERS';

}

