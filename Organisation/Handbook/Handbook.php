<?php
namespace AppBundle\Entity\Organisation\Handbook;

use AppBundle\Entity\Core\Classification\Category;
use AppBundle\Entity\Organisation\Organisation;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use AppBundle\Services\Core\Framework\ListVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("handbook")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_organisation_handbook",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())","handbook" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *   attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object === null)"},
 * )
 * @Hateoas\Relation("translations", href = @Hateoas\Route(
 *         "get_organisation_handbook_translations",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())","handbook" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "sections_search",
 *  href= @Hateoas\Route(
 *         "get_organisation_handbook_section_search",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())","handbook" = "expr(object.getId())"},
 *         absolute = true
 *     )
 * )
 * * @Hateoas\Relation(
 *  "sections",
 *  href= @Hateoas\Route(
 *         "get_organisation_handbook_sections",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())","handbook" = "expr(object.getId())"},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *  "organisation",
 *  href= @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())"},
 *         absolute = true
 *     ),
 * )
 * @ORM\Entity
 * @ORM\Table(name="organisation__handbook__handbook")
 * @Gedmo\Loggable()
 * @Gedmo\TranslationEntity(class="AppBundle\TranslationEntity\Organisation\Handbook\HandbookTranslation")
 */
class Handbook implements BaseVoterSupportInterface, ListVoterSupportInterface
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var bool
     * @ORM\Column(type="boolean",name="enabled",nullable=true,options={"default":true})
     * @Gedmo\Versioned
     */
    private $enabled = true;

    /**
     * @var bool
     * @ORM\Column(type="boolean",name="public",nullable=true,options={"default":true})
     * @Gedmo\Versioned
     */
    private $public = true;


    /**
     * @var string
     * @ORM\Column(length=10, nullable=true)
     * @Gedmo\Versioned
     */
    private $version;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\ACEEntities\Organisation\Handbook\HandbookUserGroupACE", mappedBy="selectedObjects")
     * @Serializer\Exclude
     */
    private $userGroupACEs;  
    
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\ACEEntities\Organisation\Handbook\HandbookUserACE", mappedBy="selectedObjects")
     * @Serializer\Exclude
     */
    private $userACEs;

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Organisation", inversedBy="handbook")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     * @Serializer\Exclude
     * */
    private $organisation;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organisation\Handbook\Section", orphanRemoval=true, mappedBy="handbook", cascade={"persist", "remove", "merge"})
     * @Serializer\Exclude
     * */
    private $sections;

    /**
     * @var string
     * @ORM\Column(length=50)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Gedmo\Translatable
     */
    private $description;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @var Category
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Core\Classification\Category", inversedBy="handbooks")
     * @ORM\JoinTable(name="organisation__handbook__handbook_category",
     *      joinColumns={@ORM\JoinColumn(name="id_handbook", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_category", referencedColumnName="id")}
     * )
     * @Serializer\Exclude
     * */
    protected $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function addSection(Section $section)
    {
        $this->sections->add($section);
        $section->setHandbook($this);
    }

    /**
     * @param Section $section
     */
    public function removeChild(Section $section)
    {
        $this->children->removeElement($section);
        $section->setHandbook(null);
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

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param mixed $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }

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
     * @return ArrayCollection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param ArrayCollection $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserGroupACEs()
    {
        return $this->userGroupACEs;
    }

    /**
     * @param ArrayCollection $userGroupACEs
     */
    public function setUserGroupACEs($userGroupACEs)
    {
        $this->userGroupACEs = $userGroupACEs;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserACEs()
    {
        return $this->userACEs;
    }

    /**
     * @param ArrayCollection $userACEs
     */
    public function setUserACEs($userACEs)
    {
        $this->userACEs = $userACEs;
    }
    

    /**
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return Category
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category $categories
     */
    public function setCategories( $categories )
    {
        $this->categories = $categories;
    }

    /**
     * @param $category
     *
     * @return $this
     */
    public function addCategory($category)
    {
        $this->categories->add($category);
        return $this;
    }

    /**
     * @param $category
     *
     * @return $this
     */
    public function removeCategory($category)
    {
        $this->categories->removeElement($category);
        return $this;
    }

    
}
