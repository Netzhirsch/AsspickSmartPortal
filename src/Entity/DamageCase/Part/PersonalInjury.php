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
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $personFirstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $personLastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $injuries;

    public function __toString(): string
    {
        $name = '';
        $firstname = $this->getPersonFirstname();
        if (empty($firstname))
            return $name;
        $name .= $firstname;

        $lastname = $this->getPersonLastname();
        if (empty($lastname))
            return $name;
        $name .= ' '.$lastname;

        return $name;
    }

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
