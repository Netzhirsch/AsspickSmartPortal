<?php

namespace App\Entity\DamageCase\Part\Damage;

use App\Repository\DamageCase\Part\Damage\DamageCauseRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DamageCauseRepository::class)
 */
class DamageCause
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
    private ?string $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $streetMailbox;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $phone;


    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $location;

    public function __toString(): string
    {
        $name = '';
        $firstname = $this->getFirstname();
        if (!empty($firstname))
            $name .= $firstname;

        $lastname = $this->getLastname();
        if (empty($lastname))
            return $name;

        return $name.' '.$lastname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStreetMailbox(): ?string
    {
        return $this->streetMailbox;
    }

    public function setStreetMailbox(string $streetMailbox): self
    {
        $this->streetMailbox = $streetMailbox;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateOfBirth(): ?DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

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
}
