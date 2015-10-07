<?php
namespace AppBundle\Entity\Core\Location;

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

    /**
     * @var string
     * @ORM\Column(length=12, type="string",nullable=true) */
    private $value;

    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $room;
    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $level;
    /** @ORM\Column(length=12, type="string",nullable=true) */
    private $block;

    /** @ORM\Column(length=120, type="string",nullable=true) */
    private $number;

    /**
     * @var Street
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Street", inversedBy="children")
     * @ORM\JoinColumn(name="id_street", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $street;

    /**
     * @var Ward
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Ward", inversedBy="children")
     * @ORM\JoinColumn(name="id_ward", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $ward;

    /**
     * @var District
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\District", inversedBy="children")
     * @ORM\JoinColumn(name="id_district", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $district;

    /**
     * @var City
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\City", inversedBy="children")
     * @ORM\JoinColumn(name="id_city", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $city;

    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Province", inversedBy="children")
     * @ORM\JoinColumn(name="id_province", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $province;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Country", inversedBy="children")
     * @ORM\JoinColumn(name="id_country", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $country;

}