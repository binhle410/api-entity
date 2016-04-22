<?php
namespace AppBundle\Entity\Core\Core;

use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="core__currency")
 *
 * @Serializer\XmlRoot("currency")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_currency",
 *         parameters = { "entity" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 */
class Currency implements BaseVoterSupportInterface
{
//    const SYMBOLS = ['USD','EUR','SGD','VND','PHILIPPINE_PESO'];
    /**
     * const USD = 'USD';
     * const EUR = 'EUR';
     * const SGD = 'SGD';
     * const VND = 'VND';
     * const PHILIPPINE_PESO = 'PHILIPPINE_PESO';
     */

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string",length=120)
     */
    private $symbol;

    /**
     * @var float
     * @ORM\Column(name="exchange_rate",type="float", precision=12, scale=8)
     */
    private $exchangeRate;

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param mixed $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }


    /**
     * @return float
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * @param float $exchangeRate
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }




}