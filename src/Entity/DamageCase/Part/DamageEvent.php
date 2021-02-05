<?php

namespace App\Entity\DamageCase\Part;

use App\Repository\DamageCase\Part\DamageEventRepository;
use DateTimeInterface;
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
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $itemsDamaged;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $damageAmount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getItemsDamaged(): ?string
    {
        return $this->itemsDamaged;
    }

    public function setItemsDamaged(string $itemsDamaged): self
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
}
