<?php

namespace App\Entity;

use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\Liability;
use App\Repository\FileRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uploadAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity=Liability::class, inversedBy="files")
     */
    private $liability;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="files")
     */
    private $car;

    /**
     * @ORM\ManyToOne(targetEntity=GeneralDamage::class, inversedBy="files")
     */
    private $generalDamage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUploadAt(): ?DateTimeInterface
    {
        return $this->uploadAt;
    }

    public function setUploadAt(DateTimeInterface $uploadAt): self
    {
        $this->uploadAt = $uploadAt;

        return $this;
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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getLiability(): ?Liability
    {
        return $this->liability;
    }

    public function setLiability(?Liability $liability): self
    {
        $this->liability = $liability;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getGeneralDamage(): ?GeneralDamage
    {
        return $this->generalDamage;
    }

    public function setGeneralDamage(?GeneralDamage $generalDamage): self
    {
        $this->generalDamage = $generalDamage;

        return $this;
    }
}
