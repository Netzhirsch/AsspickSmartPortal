<?php

namespace App\Entity\DamageCase\Car;

use App\Repository\DamageCase\Car\OpponentCarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OpponentCarRepository::class)
 */
class OpponentCar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licensePlate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $yearOfManufacture;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kmStatus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insuredWith;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $insuranceNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYearOfManufacture(): ?string
    {
        return $this->yearOfManufacture;
    }

    public function setYearOfManufacture(?string $yearOfManufacture): self
    {
        $this->yearOfManufacture = $yearOfManufacture;

        return $this;
    }

    public function getKmStatus(): ?int
    {
        return $this->kmStatus;
    }

    public function setKmStatus(?int $kmStatus): self
    {
        $this->kmStatus = $kmStatus;

        return $this;
    }

    public function getInsuredWith(): ?string
    {
        return $this->insuredWith;
    }

    public function setInsuredWith(?string $insuredWith): self
    {
        $this->insuredWith = $insuredWith;

        return $this;
    }

    public function getInsuranceNumber(): ?string
    {
        return $this->insuranceNumber;
    }

    public function setInsuranceNumber(string $insuranceNumber): self
    {
        $this->insuranceNumber = $insuranceNumber;

        return $this;
    }
}
