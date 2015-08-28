<?php
// src/AppBundle/Entity/Core/Site.php

namespace AppBundle\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="site")
 */
class Site {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /** @ORM\Column(length=150) */
    private $name;
    /** @ORM\Column(length=50) */
    private $domain;
}