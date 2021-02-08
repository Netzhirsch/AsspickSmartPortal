<?php

namespace App\Entity\DamageCase\Car;

use App\Entity\DamageCase\Part\DamageEvent;
use App\Entity\DamageCase\Part\Insured;
use App\Entity\DamageCase\Part\Policyholder;
use App\Repository\DamageCase\Car\CarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TypOfInsurance::class, inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typOfInsurance;

    /**
     * @ORM\ManyToOne(targetEntity=TypOfTrip::class, inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typOfTrip;

    /**
     * @ORM\OneToOne(targetEntity=Insured::class, inversedBy="car", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $insured;

    /**
     * @ORM\OneToOne(targetEntity=Policyholder::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $policyholder;

    /**
     * @ORM\OneToOne(targetEntity=DamageEvent::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $damageEvent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $licensePlate;

    /**
     * @ORM\OneToOne(targetEntity=Driver::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypOfInsurance(): ?TypOfInsurance
    {
        return $this->typOfInsurance;
    }

    public function setTypOfInsurance(?TypOfInsurance $typOfInsurance): self
    {
        $this->typOfInsurance = $typOfInsurance;

        return $this;
    }

    public function getTypOfTrip(): ?TypOfTrip
    {
        return $this->typOfTrip;
    }

    public function setTypOfTrip(?TypOfTrip $typOfTrip): self
    {
        $this->typOfTrip = $typOfTrip;

        return $this;
    }

    public function getInsured(): ?Insured
    {
        return $this->insured;
    }

    public function setInsured(Insured $insured): self
    {
        $this->insured = $insured;

        return $this;
    }

    public function getPolicyholder(): ?Policyholder
    {
        return $this->policyholder;
    }

    public function setPolicyholder(Policyholder $policyholder): self
    {
        $this->policyholder = $policyholder;

        return $this;
    }

    public function getDamageEvent(): ?DamageEvent
    {
        return $this->damageEvent;
    }

    public function setDamageEvent(DamageEvent $damageEvent): self
    {
        $this->damageEvent = $damageEvent;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }
}
