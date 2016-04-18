<?php
namespace AppBundle\Entity\Accounting\Payroll;

use AppBundle\Entity\Core\Core\Currency;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="accounting__payroll__salary")
 *
 * @Serializer\XmlRoot("salary")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_salary",
 *         parameters = { "salary" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 * @Hateoas\Relation(
 *  "currency",
 *  href= @Hateoas\Route(
 *         "get_currency",
 *         parameters = { "entity" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 */
class Salary implements BaseVoterSupportInterface
{
    const HOURLY = 'HOURLY';
    const DAILY = 'DAILY';
    const WEEKLY = 'WEEKLY';
    const MONTHLY = 'MONTHLY';
    const YEARLY = 'YEARLY';

    function __construct()
    {
        $this->type = self::HOURLY;
    }

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @var Currency
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Core\Currency")
     * @ORM\JoinColumn(name="id_currency", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $currency;

    /**
     * @var float
     * @ORM\Column(name="amount",type="float", precision=4, scale=2)
     */
    private $amount;

    /**
     * This var contains the hourly rate in USD currency. We need a script to update convertedAmount
     * when the FX rates change.
     * @var float
     * @ORM\Column(name="converted_amount",type="float", precision=4, scale=2)
     */
    private $convertedAmount;

    /**
     * e.g: hourly, daily, weekly, monthly, yearly
     * @var string
     * @ORM\Column(length=12, name="type",type="string",nullable=true)
     */
    private $type;

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

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getConvertedAmount()
    {
        return $this->convertedAmount;
    }

    /**
     * @param float $convertedAmount
     */
    public function setConvertedAmount($convertedAmount)
    {
        $this->convertedAmount = $convertedAmount;
    }

}