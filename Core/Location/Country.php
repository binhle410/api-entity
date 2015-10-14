<?php
namespace AppBundle\Entity\Core\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="country")
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\Province", mappedBy="country")
     **/
    private $provinces;

    /**
     * @var string
     * ORM\Column(length=50, type="string",nullable=true)
     */
    private $code;

    /**
     * @var string
     * ORM\Column(length=50, type="string",nullable=true)
     */
    private $name;
}