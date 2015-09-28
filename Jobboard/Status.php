<?php
// src/AppBundle/Entity/Jobboard/Status.php
namespace AppBundle\Entity\Jobboard;

use AppBundle\Entity\Core\BasicEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_listing_status")
 */
class ListingStatus extends BasicEnum
{
    const ACTIVE = 'ACTIVE';
    const PENDING = 'PENDING';
    const EXPIRED = 'EXPIRED';
    const DRAFT = 'DRAFT';

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
}