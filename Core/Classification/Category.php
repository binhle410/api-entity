<?php
namespace AppBundle\Entity\Core\Classification;

use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory;
use Sonata\MediaBundle\Model\MediaInterface;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity
 * @ORM\Table(name="core__classification__category")
 *
 * @Serializer\XmlRoot("category")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_organisation_category",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())","category" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *   attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object === null)"},
 * )
 * @Hateoas\Relation(
 *  "handbooks",
 *  href= @Hateoas\Route(
 *         "get_organisation_category_handbooks",
 *         parameters = { "organisation" = "expr(object.getOrganisation().getId())","category" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *   attributes = { "actions" =  "expr(service('app.core.security.authority').getAllowedActions(object))","null" = "expr(object === null)"},
 * )
 */
class Category  extends BaseCategory implements BaseVoterSupportInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     * @Serializer\Exclude
     */
    private $root;

    /**
     * @var integer
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     * @Serializer\Exclude
     */
    private $left;

    /**
     * @var integer
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     * @Serializer\Exclude
     */
    private $level;

    /**
     * @var integer
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     * @Serializer\Exclude
     */
    private $right;

    /**
     * @var Category
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    protected $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @Serializer\Exclude
     **/
    protected $children;

    /**
     * @var handbooks
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organisation\Handbook\Handbook", mappedBy="categories" ,cascade={"persist", "remove", "merge"})
     * @Serializer\Exclude
     */
    protected $handbooks;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\ACEEntities\Core\Classification\CategoryUserGroupACE", mappedBy="selectedObjects")
     * @Serializer\Exclude
     */
    private $userGroupACEs;


    /**
     * @var \AppBundle\Entity\Organisation\Organisation
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organisation\Organisation",inversedBy="categories")
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $organisation;

    /**
     * @return \AppBundle\Entity\Organisation\Organisation
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param \AppBundle\Entity\Organisation\Organisation $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
    }
    
    


    public function __construct()
    {
        $this->handbooks = new ArrayCollection();
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
     * @return int
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param int $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param int $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param int $right
     */
    public function setRight($right)
    {
        $this->right = $right;
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
    public function setUserGroupACEs( $userGroupACEs )
    {
        $this->userGroupACEs = $userGroupACEs;
    }

    /**
     * @return handbook
     */
    public function getHandbooks()
    {
        return $this->handbooks;
    }

    /**
     * @param handbook $handbooks
     */
    public function setHandbooks( $handbooks )
    {
        $this->handbooks = $handbooks;
    }

    /**
     * @param $handbook
     *
     * @return $this
     */
    public function addHandbook($handbook)
    {
        $this->handbooks->add($handbook);
        $handbook->addCategory($this);
        return $this;
    }

    /**
     * @param $handbook
     *
     * @return $this
     */
    public function removeHandbook($handbook)
    {
        $this->handbooks->removeElement($handbook);
        $handbook->removeCategory($this);
        return $this;
    }

}