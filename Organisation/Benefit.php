<?php
namespace AppBundle\Entity\Organisation;

use AppBundle\Entity\Core\User\User;
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

    function __construct(Promotion $promotion, Organisation $organisation)
    {
        $this->beneficiaries = new ArrayCollection();
        $this->promotion = $promotion;
        $promotion->getBenefits()->add($this);
        $this->organisation = $organisation;
        $organisation->getBenefits()->add($this);
    }

    /**
     * @var Promotion
     * @ORM\Id @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Merchant\Marketing\Promotion\Promotion", inversedBy="benefits",cascade={"persist","merge","remove"})
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

    /**
     * only manytomany relationship is named with plural nouns.
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="beneficiaries",
     *      joinColumns={@ORM\JoinColumn(name="id_benefit", referencedColumnName="id_promotion")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $beneficiaries;

    public function addBeneficiary(User $user)
    {
        $this->beneficiaries->add($user);
        return $this;
    }

    public function removeBeneficiary(User $user)
    {
        $this->beneficiaries->removeElement($user);
        return $this;
    }

    /**
     * @return Promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param Promotion $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @return ArrayCollection
     */
    public function getBeneficiaries()
    {
        return $this->beneficiaries;
    }

    /**
     * @param ArrayCollection $beneficiaries
     */
    public function setBeneficiaries($beneficiaries)
    {
        $this->beneficiaries = $beneficiaries;
    }

    /**
     * @return Organisation
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param Organisation $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }


}