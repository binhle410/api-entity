<?php
// src/AppBundle/Entity/Core/Site.php

namespace AppBundle\Entity\Core\Core;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="core__site")
 * @Serializer\XmlRoot("site")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_site",
 *         parameters = { "site" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
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
    /** @ORM\Column(length=50) */
    private $subdomain;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Organisation", inversedBy="sites")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     **/
    private $organisation;

}