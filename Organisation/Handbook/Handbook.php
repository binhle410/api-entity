<?php
// src/AppBundle/Entity/Organisation/Handbook/Handbook.php

namespace AppBundle\Entity\Organisation\Handbook;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="handbook")
 */
class Handbook
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Organisation\Organisation", inversedBy="handbook")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     **/
    private $organisation;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Handbook\Section", mappedBy="handbook")
     **/
    private $sections;

    /**
     * @var string
     * @ORM\Column(length=50)
     */
    private $title;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

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
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param mixed $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
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