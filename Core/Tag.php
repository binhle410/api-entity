<?php
// src/AppBundle/Entity/Core/Tag.php
namespace AppBundle\Entity\Core;

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

    /** @ORM\Column(length=120, name="label",type="string",nullable=true) */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumn(name="id_site", referencedColumnName="id")
     **/
    private $site;

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