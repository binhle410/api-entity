<?php
namespace AppBundle\Entity\Accounting\Payroll;

use AppBundle\Entity\Core\Currency;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="salary")
 */
class Salary
{
    const HOURLY = 'HOURLY';
    const DAILY = 'DAILY';
    const WEEKLY = 'WEEKLY';
    const MONTHLY = 'MONTHLY';
    const YEARLY = 'YEARLY';

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Currency
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Currency")
     * @ORM\JoinColumn(name="id_currency", referencedColumnName="id")
     */
    private $currency;

    /**
     * @var int
     * @ORM\Column(name="amount",type="float", precision=4, scale=2)
     */
    private $amount;

    /**
     * This var contains the hourly rate in USD currency.
     * @var int
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
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
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
     * @return int
     */
    public function getConvertedAmount()
    {
        return $this->convertedAmount;
    }

    /**
     * @param int $convertedAmount
     */
    public function setConvertedAmount($convertedAmount)
    {
        $this->convertedAmount = $convertedAmount;
    }


}