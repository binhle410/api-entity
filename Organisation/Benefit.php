<?php
namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Merchant\Marketing\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="benefit")
 */
class Benefit
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct()
    {
        $this->beneficiaries = new ArrayCollection();
    }

    /**
     * @var ArrayCollection User
     */
    private $beneficiaries;

    /**
     * @var Promotion
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Merchant\Marketing\Promotion\Promotion", inversedBy="benefits",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_promotion", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $promotion;

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="benefits",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $organisation;

}