<?php
namespace AppBundle\Entity\Core\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * ORM\Entity
 * ORM\Table(name="core__patch_request")
 */
class PatchRequest
{
    /**
     * ORM\Id
     * ORM\Column(type="integer",options={"unsigned":true})
     * ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @Serializer\Exclude
     */
    private $patches;

    /**
     * @return ArrayCollection
     */
    public function getPatches()
    {
        return $this->patches;
    }

    /**
     * @param ArrayCollection $patches
     */
    public function setPatches($patches)
    {
        $this->patches = $patches;
    }




}