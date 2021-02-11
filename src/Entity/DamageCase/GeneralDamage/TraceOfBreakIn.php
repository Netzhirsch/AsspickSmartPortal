<?php

namespace App\Entity\DamageCase\GeneralDamage;

use App\Repository\DamageCase\GeneralDamage\TraceOfBreakInRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraceOfBreakInRepository::class)
 */
class TraceOfBreakIn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isTracePresent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsTracePresent(): ?bool
    {
        return $this->isTracePresent;
    }

    public function setIsTracePresent(?bool $isTracePresent): self
    {
        $this->isTracePresent = $isTracePresent;

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
}
