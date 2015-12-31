<?php
// src/AppBundle/Entity/Core/User/UserGroupType.php
namespace AppBundle\Entity\Core\User;

use AppBundle\Entity\Core\Core\BasicEnum;

abstract class UserGroupType extends BasicEnum implements BaseVoterSupportInterface
{
    const CUSTOM = 'CUSTOM';
    const BENEFIT_APP_USERS = 'BENEFIT-APP-USERS';

}

