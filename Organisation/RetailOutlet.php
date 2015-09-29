<?php
// src/AppBundle/Entity/Organisation/RetailOutlet.php
namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\Location\Address;
use AppBundle\Entity\Core\Location\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="retail_outlet")
 */
class RetailOutlet
{
    /**
     * slide 23
     *
     * adress:String, unitNo, mallName,postalCode, geoLocation:Location,
     *
     */

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var Address
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Core\Location\Address")
     * @ORM\JoinColumn(name="id_address", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $address;


    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation", inversedBy="businesses",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_owner", referencedColumnName="id")
     */
    private $business;

    /**
     * @var ArrayCollection Redemption
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\Redemption", mappedBy="retailOutlet",orphanRemoval=true,cascade={"persist","merge","remove"})
     * @Serializer\Exclude
     */
    private $redemptions;

    /**
     * @var string
     */
    private $contactNo;

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