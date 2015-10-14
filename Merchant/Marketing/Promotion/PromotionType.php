<?php
// src/AppBundle/Entity/Merchant/Marketing/Promotion/PromotionType.php
namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use AppBundle\Entity\Core\BasicEnum;


use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity
 * @ORM\Table(name="promotion_type")
 */
class PromotionType extends BasicEnum
{
    const ONE_FOR_ONE = 'ONE-FOR-ONE';
    const DISCOUNT = 'DISCOUNT';
    const FREE_ADMISSION = 'FREE-ADMISSION';
    const HAPPY_HOUR = 'HAPPY-HOUR';
    const COMPLIMENTARY = 'COMPLIMENTARY';
    const LOYALTY_OFFERS = 'LOYALTY-OFFERS';


    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=25)
     */
    private $title;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

}
