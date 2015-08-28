<?php
// src/AppBundle/Entity/Core/Address.php

namespace AppBundle\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="addresses")
     * @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     **/
    private $location;

    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $room;

    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $level;

    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $block;

    /** @ORM\Column(length=120, type="string",nullable=true) */
    private $number;
    /** @ORM\Column(length=50, type="string",nullable=true) */
    private $street;
    /** @ORM\Column(length=50, type="string",nullable=true) */
    private $ward;
    /** @ORM\Column(length=50, type="string",nullable=true) */
    private $district;
    /** @ORM\Column(length=50, type="string",nullable=true) */
    private $city;
    /** @ORM\Column(length=50, type="string",nullable=true) */
    private $province;
    /** @ORM\Column(length=50, type="string",nullable=true) */
    private $country;

}