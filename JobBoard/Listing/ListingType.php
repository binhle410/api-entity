<?php
// src/AppBundle/Entity/JobBoard/Type.php
namespace AppBundle\Entity\JobBoard\Listing;

use AppBundle\Entity\Core\Core\BasicEnum;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job__listing__type")
 */
class ListingType extends BasicEnum implements BaseVoterSupportInterface {
    const FULL_TIME = 'FULL_TIME';
    const PART_TIME = 'PART_TIME';
    const CONTRACT = 'CONTRACT';
    const AD_HOC = 'AD_HOC';
    const OJT = 'OJT';

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=25)
     */
    private $title;

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

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


}