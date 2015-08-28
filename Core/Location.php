<?php
// src/AppBundle/Entity/Core/Location.php

namespace AppBundle\Entity\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="location")
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="location")
     **/
    private $addresses;

    /** @ORM\Column(name="latitude ",type="float",nullable=true) */
    private $geoLat;
    /** @ORM\Column(name="longitude ",type="float",nullable=true) */
    private $geoLng;

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getWard()
    {
        return $this->ward;
    }

    /**
     * @param mixed $ward
     */
    public function setWard($ward)
    {
        $this->ward = $ward;
    }

    /**
     * @return mixed
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param mixed $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getGeoLat()
    {
        return $this->geoLat;
    }

    /**
     * @param mixed $geoLat
     */
    public function setGeoLat($geoLat)
    {
        $this->geoLat = $geoLat;
    }

    /**
     * @return mixed
     */
    public function getGeoLng()
    {
        return $this->geoLng;
    }

    /**
     * @param mixed $geoLng
     */
    public function setGeoLng($geoLng)
    {
        $this->geoLng = $geoLng;
    }


}