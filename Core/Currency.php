<?php
namespace AppBundle\Entity\Core;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency")
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    //todo symbol, exchangeRate
}