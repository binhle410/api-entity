<?php
// src/AppBundle/Entity/Organisation/RetailOutlet.php
namespace AppBundle\Entity\Organisation;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="retail_outlet")
 */
class RetailOutlet extends Organisation
{
    //todo map
    /**
     * slide 23
     *
     * adress:String, unitNo, mallName,postalCode, geoLocation:Location,
     * contactNo
     * participations:ArrayCollection<OutletParticipation>
     * merchant:Merchant
     */


    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation", inversedBy="businesses",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
     */
    private $business;

}