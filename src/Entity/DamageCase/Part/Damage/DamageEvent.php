<?php

namespace App\Entity\DamageCase\Part\Damage;

use App\Repository\DamageCase\Part\Damage\DamageEventRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DamageEventRepository::class)
 */
class DamageEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $itemsDamaged;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $damageAmount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfVehiclesInvolved;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $damageAmountOnOpponent;

    /**
     * @ORM\OneToOne(targetEntity=DamageCausedBy::class, cascade={"persist", "remove"})
     */
    private $causedBy;

    /**
     * @ORM\ManyToMany(targetEntity=DamageTyp::class)
     */
    private $typs;

    /**
     * @ORM\ManyToMany(targetEntity=CauseOfDamageTyp::class)
     */
    private $causeOfDamage;

    public function __construct()
    {
        $this->typs = new ArrayCollection();
        $this->causeOfDamage = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getItemsDamaged(): ?string
    {
        return $this->itemsDamaged;
    }

    public function setItemsDamaged(?string $itemsDamaged): self
    {
        $this->itemsDamaged = $itemsDamaged;

        return $this;
    }

    public function getDamageAmount()
    {
        return $this->damageAmount;
    }

    public function setDamageAmount($damageAmount): self
    {
        $this->damageAmount = $damageAmount;

        return $this;
    }

    public function getNumberOfVehiclesInvolved(): ?int
    {
        return $this->numberOfVehiclesInvolved;
    }

    public function setNumberOfVehiclesInvolved(?int $numberOfVehiclesInvolved): self
    {
        $this->numberOfVehiclesInvolved = $numberOfVehiclesInvolved;

        return $this;
    }

    public function getDamageAmountOnOpponent(): ?string
    {
        return $this->damageAmountOnOpponent;
    }

    public function setDamageAmountOnOpponent(?string $damageAmountOnOpponent): self
    {
        $this->damageAmountOnOpponent = $damageAmountOnOpponent;

        return $this;
    }

    public function getCausedBy(): ?DamageCausedBy
    {
        return $this->causedBy;
    }

    public function setCausedBy(?DamageCausedBy $causedBy): self
    {
        $this->causedBy = $causedBy;

        return $this;
    }

    /**
     * @return Collection|DamageTyp[]
     */
    public function getTyps(): Collection
    {
        return $this->typs;
    }

    public function addTyp(DamageTyp $typ): self
    {
        if (!$this->typs->contains($typ)) {
            $this->typs[] = $typ;
        }

        return $this;
    }

    public function removeTyp(DamageTyp $typ): self
    {
        $this->typs->removeElement($typ);

        return $this;
    }

    /**
     * @return Collection|CauseOfDamageTyp[]
     */
    public function getCauseOfDamage(): Collection
    {
        return $this->causeOfDamage;
    }

    public function addCauseOfDamage(CauseOfDamageTyp $causeOfDamage): self
    {
        if (!$this->causeOfDamage->contains($causeOfDamage)) {
            $this->causeOfDamage[] = $causeOfDamage;
        }

        return $this;
    }

    public function removeCauseOfDamage(CauseOfDamageTyp $causeOfDamage): self
    {
        $this->causeOfDamage->removeElement($causeOfDamage);

        return $this;
    }
}
