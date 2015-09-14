<?php
// src/AppBundle/Entity/Organisation/Business.php

namespace AppBundle\Entity\Organisation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="business")
 */
class Business
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation", inversedBy="businesses",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\RetailOutlet", mappedBy="business", orphanRemoval=true)
     */
    private $retailOutlets;
}