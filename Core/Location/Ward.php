<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="location_ward")
 */
class Ward
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var District
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\District", inversedBy="wards")
     * @ORM\JoinColumn(name="id_country", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $district;

    /**
     * @var string
     * ORM\Column(length=50, type="string")
     */
    private $name;
}