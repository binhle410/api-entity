<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="province")
 */
class Province
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Country", inversedBy="provinces")
     * @ORM\JoinColumn(name="id_country", referencedColumnName="id", onDelete="CASCADE")
     **/
    private $country;

    /**
     * @var ArrayCollection Wards
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\Ward", mappedBy="province")
     **/
    private $wards;

    /**
     * @var string
     * ORM\Column(length=50, type="string")
     */
    private $name;

}