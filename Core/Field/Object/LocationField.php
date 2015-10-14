<?php
// src/AppBundle/Entity/Core/Field/Object/IntegerField.php
namespace AppBundle\Entity\Core\Field\Object;

use AppBundle\Entity\Core\Field\Field;
use AppBundle\Entity\Core\Location\Location;

/**
 * ORM\Entity
 * ORM\Table(name="field_location")
 */
class LocationField extends Field
{
    /**
     * @var Location
     */
    private $location;

    /**
     * @return LocationField
     */
    function getInstance()
    {
        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

}