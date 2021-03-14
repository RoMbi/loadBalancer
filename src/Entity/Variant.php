<?php

namespace App\Entity;

use Doctrine\ORM;

/**
 * Entity class of LoadBalancer variants
 * Implemented as Symfony Entity
 *
 * @ORM\Table(name="LoadBalancerVariant")
 * @ORM\Entity
 */
class Variant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="max_load", type="float")
     */
    private $maxLoad;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getMaxLoad(): float
    {
        return $this->maxLoad;
    }

    /**
     * @param float $maxLoad
     */
    public function setMaxLoad(float $maxLoad): void
    {
        $this->maxLoad = $maxLoad;
    }
}