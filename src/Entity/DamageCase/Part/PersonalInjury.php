<?php

namespace App\Entity\DamageCase\Part;

use App\Repository\DamageCase\Part\PersonalInjuryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonalInjuryRepository::class)
 */
class PersonalInjury
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
    private $personFirstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $personLastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $injuries;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonFirstname(): ?string
    {
        return $this->personFirstname;
    }

    public function setPersonFirstname(?string $personFirstname): self
    {
        $this->personFirstname = $personFirstname;

        return $this;
    }

    public function getPersonLastname(): ?string
    {
        return $this->personLastname;
    }

    public function setPersonLastname(?string $personLastname): self
    {
        $this->personLastname = $personLastname;

        return $this;
    }

    public function getInjuries(): ?string
    {
        return $this->injuries;
    }

    public function setInjuries(?string $injuries): self
    {
        $this->injuries = $injuries;

        return $this;
    }
}
