<?php
// src/AppBundle/Entity/Merchant/Marketing/Promotion/PromotionType.php
namespace AppBundle\Entity\Merchant\Marketing\Promotion;

use AppBundle\Entity\Core\Core\BasicEnum;


use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @ORM\Entity
 * @ORM\Table(name="marketing__promotion__type")
 */
class PromotionType extends BasicEnum implements BaseVoterSupportInterface
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

    function __construct()
    {
        $this->enabled = true;
    }

    /**
     * @var bool
     * @ORM\Column(name="enabled",type="boolean", options={"default":true})
     */
    private $enabled;


    /**
     * @var string
     * @ORM\Column(length=25, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(length=25,nullable=true)
     */
    private $code;

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

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }


}
