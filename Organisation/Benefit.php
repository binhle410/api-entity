<?php
namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Merchant\Marketing\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $promotion;

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Organisation\Organisation", inversedBy="benefits",cascade={"persist","merge","remove"})
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     */
    private $organisation;

}