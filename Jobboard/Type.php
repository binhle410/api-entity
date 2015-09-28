<?php
// src/AppBundle/Entity/Jobboard/Type.php
namespace AppBundle\Entity\Jobboard;

use AppBundle\Entity\Core\BasicEnum;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_listing_type")
 */
class JobType extends BasicEnum {
    const FULL_TIME = 'FULL_TIME';
    const PART_TIME = 'PART_TIME';
    const CONTRACT = 'CONTRACT';
    const AD_HOC = 'AD_HOC';
    const OJT = 'OJT';

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