<?php
// src/AppBundle/Entity/Jobboard/Visibility.php
namespace AppBundle\Entity\Jobboard;

use AppBundle\Entity\Core\BasicEnum;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_listing_visibility")
 */
class Visibility extends BasicEnum
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
}