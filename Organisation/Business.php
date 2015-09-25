<?php
// src/AppBundle/Entity/Organisation/Business.php

namespace AppBundle\Entity\Organisation;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="business")
 * @Serializer\XmlRoot("business")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_business",
 *         parameters = { "business" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 *
 *
 */
class Business
{
    /**
     * @var int
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
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Tag", inversedBy="businesses")
     * @ORM\JoinTable(name="businesses_tags")
     */
    private $tags;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\RetailOutlet", mappedBy="business", orphanRemoval=true)
     */
    private $retailOutlets;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}