<?php
// src/AppBundle/Entity/JobBoard/Visibility.php
namespace AppBundle\Entity\JobBoard\Listing;

use AppBundle\Entity\Core\Core\BasicEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_listing_visibility")
 */
class ListingVisibility extends BasicEnum // Means Application Type (By invitation only / public)
{
    const LISTED = 'LISTED';
    const UNLISTED = 'UNLISTED';
    const SECURED = 'SECURED';

    /**
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
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