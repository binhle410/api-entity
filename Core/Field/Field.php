<?php
// src/AppBundle/Entity/Core/Field/Field.php

namespace AppBundle\Entity\Core\Field;

/**
 * @ORM\Entity
 * @ORM\Table(name="field")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"integer" = "IntegerField", "title" = "TitleField","location"="LocationField"})
 */
abstract class Field
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="bigint",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     * @ORM\Column(name="active",type="boolean",nullable=false)
     */
    protected $active = true;

    /**
     * @var string
     * @ORM\Column(length=50, name="type",type="string",nullable=false)
     */
    protected $name;

    abstract function getInstance();

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}