<?php
namespace AppBundle\Entity\Organisation\Application;
use AppBundle\Entity\Core\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @ORM\Entity
 * @ORM\Table(name="organisation__application__application")
 */
class Application
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * only manytomany relationship is named with plural nouns.
     * @var ArrayCollection User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\User\User")
     * @ORM\JoinTable(name="organisation__application__applications_handlers",
     *      joinColumns={@ORM\JoinColumn(name="id_application", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id")}
     *      )
     * @Serializer\Exclude
     */
    private $handlers;
    /**
     * @param User  $user
     * @return Application
     */
    public function addHandler($user)
    {
        $this->handlers->add($user);
        return $this;
    }

    /**
     * @param User $user
     * @return Application
     */
    public function removeHandler($user)
    {
        $this->handlers->removeElement($user);
        return $this;
    }

    /**
     * @var ArrayCollection $organisations
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Organisation", mappedBy="applications")
     * @Serializer\Exclude
     */
    private $organisations;

    /**
     * @param Organisation  $application
     * @return Application
     */
    public function addOrganisation($organisation)
    {
        $this->organisations->add($organisation);
        return $this;
    }

    /**
     * @param Organisation $application
     * @return Application
     */
    public function removeOrganisation($organisation)
    {
        $this->organisations->removeElement($organisation);
        return $this;
    }
}