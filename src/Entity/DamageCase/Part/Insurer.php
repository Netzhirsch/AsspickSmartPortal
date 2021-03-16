<?php

namespace App\Entity\DamageCase\Part;

use App\Entity\DamageCase\Car\Car;
use App\Repository\DamageCase\Part\InsurerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InsurerRepository::class)
 */
class Insurer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $insuranceNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $dangerNumber;

    /**
     * @ORM\OneToOne(targetEntity=Car::class, mappedBy="insured", cascade={"persist", "remove"})
     */
    private ?Car $car;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInsuranceNumber(): ?string
    {
        return $this->insuranceNumber;
    }

    public function setInsuranceNumber(?string $insuranceNumber): self
    {
        $this->insuranceNumber = $insuranceNumber;

        return $this;
    }

    public function getDangerNumber(): ?string
    {
        return $this->dangerNumber;
    }

    public function setDangerNumber(?string $dangerNumber): self
    {
        $this->dangerNumber = $dangerNumber;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(Car $car): self
    {
        // set the owning side of the relation if necessary
        if ($car->getInsurer() !== $this) {
            $car->setInsurer($this);
        }

        $this->car = $car;

        return $this;
    }
}
