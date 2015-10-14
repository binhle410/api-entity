<?php
// src/AppBundle/Entity/Core/Tag.php
namespace AppBundle\Entity\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumn(name="id_site", referencedColumnName="id")
     **/
    private $site;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Business", mappedBy="tags")
     **/
    private $businesses;


    /** @ORM\Column(length=120, name="label",type="string",nullable=true) */
    private $label;


    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $sites
     */
    public function setSite($site)
    {
        $this->sites = $site;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

}