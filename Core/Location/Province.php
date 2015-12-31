<?php
namespace AppBundle\Entity\Core\Location;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
/**
 * @ORM\Entity
 * @ORM\Table(name="location__province")
 *
 * @Serializer\XmlRoot("province")
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_province",
 *         parameters = { "province" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {"put","delete"} },
 * )
 *
 * @Hateoas\Relation("country", href = @Hateoas\Route(
 *         "get_province_country",
 *         parameters = { "provinceId" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getCountry() === null)")
 *)
 *
 * @Hateoas\Relation("cities", href = @Hateoas\Route(
 *         "get_province_cities",
 *         parameters = { "provinceId" = "expr(object.getId())" },
 *         absolute = true
 *     ),
 * exclusion=@Hateoas\Exclusion(excludeIf="expr(object.getCities().count() === 0)")
 *)
 */
class Province implements BaseVoterSupportInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Core\Location\Country", inversedBy="provinces")
     * @ORM\JoinColumn(name="id_country", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Exclude
     **/
    private $country;

    /**
     * @var ArrayCollection City
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Core\Location\City", mappedBy="province")
     * @Serializer\Exclude
     **/
    private $cities;

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
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
     * @return ArrayCollection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @param ArrayCollection $cities
     */
    public function setCities($cities)
    {
        $this->cities = $cities;
    }

}