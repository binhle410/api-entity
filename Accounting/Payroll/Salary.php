<?php
namespace AppBundle\Entity\Accounting\Payroll;

/**
 * @ORM\Entity
 * @ORM\Table(name="salary")
 */
class Salary
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    //todo type (hourly, daily, weekly, monthly)
    // currency, amount
}