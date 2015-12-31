<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
/**
 * @ORM\Entity
 * @ORM\Table(name="location__district")
 *
 * @Serializer\XmlRoot("district")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_district",
 *         parameters = { "district" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Hateoas\Relation("city", href = @Hateoas\Route(
 *         "get_city",
 *         parameters = { "city" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *  exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getCity() === null)")
 *)
 *
 * @Hateoas\Relation("wards", href = @Hateoas\Route(
 *         "get_district_wards",
 *         parameters = { "districtId" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getWards().count() === 0)")
 *)
 *
 */
class District implements BaseVoterSupportInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection Wards
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\Ward", mappedBy="district")
     * @Serializer\Exclude
     **/
    private $wards;

    /**
     * @var string
     * @ORM\Column(length=50, type="string")
     */
    private $name;

    /**
     * @var City
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\City", inversedBy="districts")
     * @ORM\JoinColumn(name="id_city", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $city;

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
    public function getWards()
    {
        return $this->wards;
    }

    /**
     * @param ArrayCollection $wards
     */
    public function setWards($wards)
    {
        $this->wards = $wards;
    }

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
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }


}