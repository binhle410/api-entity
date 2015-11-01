<?php

// src/AppBundle/Entity/Organisation/Handbook/Handbook.php

namespace AppBundle\Entity\Organisation\Handbook;

use AppBundle\Entity\Organisation\Organisation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Translatable\Translatable;

/**
 * @Serializer\XmlRoot("handbook")
 * @Hateoas\Relation("self", href = @Hateoas\Route(
 *         "get_organisation_handbook",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())","handbook" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *   attributes = { "method" = {"put","delete"} },
 * )
 * @Hateoas\Relation("handbook.post", href = @Hateoas\Route(
 *         "post_organisation_handbook",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())"},
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *  "sections",
 *  href= @Hateoas\Route(
 *         "get_organisation_handbook_sections",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())","handbook" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getSections().count() == 0)")
 * )
 * @Hateoas\Relation("sections.post",
 *  href= @Hateoas\Route(
 *         "post_organisation_handbook_section",
 *         parameters = { "organisationId" = "expr(object.getOrganisation().getId())","handbookId" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 * )
 * @Hateoas\Relation(
 *  "organisation",
 *  href= @Hateoas\Route(
 *         "get_organisation",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())"},
 *         absolute = true
 *     ),
 * )
 *
 * @ORM\Entity
 * @ORM\Table(name="organisation_handbook")
 * @Gedmo\Loggable()
 */
class Handbook {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(length=10, nullable=true)
     * @Gedmo\Versioned
     */
    private $version;

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
    private $tranlates;

    public function getTranlates() {
        return $this->tranlates;
    }

    public function setTranlates($tranlates) {
        $this->tranlates = $tranlates;
    }

    public function getLocale() {
        return $this->locale;
    }

    public function setLocale($locale) {
        $this->locale = $locale;
    }

    public function addSection(Section $section) {
        $this->sections->add($section);
        $section->setHandbook($this);
    }

    /**
     * @param Section $section
     */
    public function removeChild(Section $section) {
        $this->children->removeElement($section);
        $section->setHandbook(null);
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
     * @return int
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year) {
        $this->year = $year;
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
     * @return mixed
     */
    public function getOrganisation() {
        return $this->organisation;
    }

    /**
     * @param mixed $organisation
     */
    public function setOrganisation($organisation) {
        $this->organisation = $organisation;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return ArrayCollection
     */
    public function getSections() {
        return $this->sections;
    }

    /**
     * @param ArrayCollection $sections
     */
    public function setSections($sections) {
        $this->sections = $sections;
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
        if ($version !== $this->version) {
            if (!empty($this->getSections())) {
                foreach ($this->sections as $section) {
//            $section = new Section();
                    $section->setVersion($version);
                }
            }
        }
        $this->version = $version;
    }

}
