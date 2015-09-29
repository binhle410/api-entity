<?php

// src/AppBundle/Entity/Organisation/Handbook/Section.php

namespace AppBundle\Entity\Organisation\Handbook;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Serializer\XmlRoot("section")
 * @Hateoas\Relation("self",
 *  href= @Hateoas\Route(
 *         "get_organisation_handbook_section",
 *         parameters = { "organisationId" = "expr(object.getHandbook().getOrganisation().getId())","handbookId" = "expr(object.getHandbook().getId())","section"="expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "organisation",
 *  href= @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getHandbook().getOrganisation().getId())"},
 *         absolute = true
 *     ),
 * )
 *  @Hateoas\Relation("handbook",
 *  href = @Hateoas\Route(
 *         "get_organisation_handbook",
 *         parameters = { "organisationId" = "expr(object.getHandbook().getOrganisation().getId())","handbook" = "expr(object.getHandbook().getId())" },
 *         absolute = true
 *     )
 * )
 *  @Hateoas\Relation("children",
 *  href = @Hateoas\Route(
 *         "get_organisation_handbook_section_children",
 *         parameters = { "organisationId" = "expr(object.getHandbook().getOrganisation().getId())","handbookId" = "expr(object.getHandbook().getId())","section"= "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getChildren().count() == 0)")
 * )
 *  @Hateoas\Relation("parent",
 *  href = @Hateoas\Route(
 *         "get_organisation_handbook_section_parent",
 *         parameters = { "organisationId" = "expr(object.getHandbook().getOrganisation().getId())","handbookId" = "expr(object.getHandbook().getId())","section"= "expr(object.getId())"},
 *         absolute = true
 *     ),
 *   exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getParent() == null)")
 * )
 * @ORM\Entity
 * @ORM\Table(name="handbook_section")
 * @Gedmo\Loggable()
 */
class Section {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    function __construct() {
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Handbook\Handbook", inversedBy="sections")
     * @ORM\JoinColumn(name="id_handbook", referencedColumnName="id")
     * @Gedmo\Versioned
     * @Serializer\Exclude
     * */
    private $handbook;

    /**
     * @var string
     * @ORM\Column(length=10, nullable=true)
     * @Gedmo\Versioned
     */
    private $version;

    /**
     * @var string
     * @ORM\Column(length=50)
     * @Gedmo\Versioned
     */
    private $title;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Gedmo\Versioned
     */
    private $active = true;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Gedmo\Versioned
     */
    private $description;

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="children")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id", onDelete="CASCADE")
     * @Gedmo\Versioned
     * @Serializer\Exclude
     * */
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Section", mappedBy="parent")
     * @Serializer\Exclude
     * */
    private $children;

    /**
     * @param Section $section
     * @return $this
     */
    public function addChild(Section $section) {
        $this->children->add($section);
        $section->setParent($this);
        return $this;
    }

    /**
     * Remove a child
     *
     * @param Section $child
     */
    public function removeChild(Section $child) {
        $this->children->removeElement($child);
        $child->setParent(null);
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return boolean
     */
    public function isActive() {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return Organisation
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param Organisation $parent
     */
    public function setParent($parent) {
        $this->parent = $parent;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version) {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getHandbook() {
        return $this->handbook;
    }

    /**
     * @param mixed $handbook
     */
    public function setHandbook($handbook) {
        $this->handbook = $handbook;
    }

}
