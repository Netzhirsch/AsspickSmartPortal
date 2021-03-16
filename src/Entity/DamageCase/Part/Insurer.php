<?php

namespace App\Entity\DamageCase\Part;

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
}
