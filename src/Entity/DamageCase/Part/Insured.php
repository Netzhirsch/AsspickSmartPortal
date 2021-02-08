<?php

namespace App\Entity\DamageCase\Part;

use App\Entity\DamageCase\Car\Car;
use App\Repository\DamageCase\Part\InsuredRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InsuredRepository::class)
 */
class Insured
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $insured;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insuranceNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dangerNumber;

    /**
     * @ORM\OneToOne(targetEntity=Car::class, mappedBy="insured", cascade={"persist", "remove"})
     */
    private $car;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInsured(): ?string
    {
        return $this->insured;
    }

    public function setInsured(string $insured): self
    {
        $this->insured = $insured;

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
        if ($car->getInsured() !== $this) {
            $car->setInsured($this);
        }

        $this->car = $car;

        return $this;
    }
}
