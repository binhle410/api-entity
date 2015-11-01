<?php
namespace AppBundle\Entity\Core\Core;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency")
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
class Currency
{
//    const SYMBOLS = ['USD','EUR','SGD','VND','PHILIPPINE_PESO'];
/**
    const USD = 'USD';
    const EUR = 'EUR';
    const SGD = 'SGD';
    const VND = 'VND';
    const PHILIPPINE_PESO = 'PHILIPPINE_PESO';
 */

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=120, name="symbol",type="string",nullable=true,unique=true)
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
     * @param string $symbol
     */
//    public function setSymbol($symbol)
//    {
//        if(!in_array($symbol,Currency::SYMBOLS)){
//            throw new \Exception($symbol.' cannot be found');
//        }
//        $this->symbol = $symbol;
//    }

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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}