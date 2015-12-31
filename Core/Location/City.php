<?php
namespace AppBundle\Entity\Core\Location;
use AppBundle\Services\Core\Framework\BaseVoterSupportInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
/**
 * @ORM\Entity
 * @ORM\Table(name="location__city")
 *
 * @Serializer\XmlRoot("city")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_city",
 *         parameters = { "city" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Hateoas\Relation("province", href = @Hateoas\Route(
 *         "get_province",
 *         parameters = { "province" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getProvince() === null)")
 * )
 *
 * @Hateoas\Relation("districts", href = @Hateoas\Route(
 *         "get_districts",
 *         parameters = { "district" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getDistricts() === 0)")
 * )
 */
class City implements BaseVoterSupportInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Province", inversedBy="cities")
     * @ORM\JoinColumn(name="id_province", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $province;

    /**
     * @var ArrayCollection Districts
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\District", mappedBy="city")
     * @Serializer\Exclude
     **/
    private $districts;
    /**
     * @var string
     * @ORM\Column(length=50, type="string",nullable=true)
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getDistricts()
    {
        return $this->districts;
    }

    /**
     * @param ArrayCollection $districts
     */
    public function setDistricts($districts)
    {
        $this->districts = $districts;
    }

    /**
     * @return Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param Province $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
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

}