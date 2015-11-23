<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
/**
 * @ORM\Entity
 * @ORM\Table(name="location__ward")
 *
 * @Serializer\XmlRoot("ward")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_ward",
 *         parameters = { "ward" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 * * @Hateoas\Relation("district", href = @Hateoas\Route(
 *         "get_ward_district",
 *         parameters = { "wardId" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 *)
 */
class Ward
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var District
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\District", inversedBy="wards")
     * @ORM\JoinColumn(name="id_district", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $district;

    /**
     * @var string
     * @ORM\Column(length=50, type="string")
     */
    private $name;

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
     * @return District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param District $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

}