<?php
// src/AppBundle/Entity/Merchant/Marketing/Promotion/PromotionType.php
namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use AppBundle\Entity\Core\BasicEnum;

abstract class PromotionType extends BasicEnum
{
    const ONE_FOR_ONE = 'ONE-FOR-ONE';
    const DISCOUNT = 'DISCOUNT';
    const FREE_ADMISSION = 'FREE-ADMISSION';
    const HAPPY_HOUR = 'HAPPY-HOUR';
    const COMPLIMENTARY = 'COMPLIMENTARY';
    const LOYALTY_OFFERS = 'LOYALTY-OFFERS';
}
