<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="location_district")
 */
class District
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var ArrayCollection Wards
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\Ward", mappedBy="districts")
     **/
    private $wards;

    /**
     * @var string
     * ORM\Column(length=50, type="string")
     */
    private $name;

    /**
     * @var City
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\City", inversedBy="districts")
     * @ORM\JoinColumn(name="id_city", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $city;
}