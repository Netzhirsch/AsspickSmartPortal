<?php

namespace App\Entity\DamageCase\Part;

use App\Repository\DamageCase\Part\PolicyholderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PolicyholderRepository::class)
 */
class Policyholder
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
    private ?string $postCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        $string = '';
        if (!empty($this->getFirstname()))
            $string .= $this->getFirstname();
        $string .= $this->getLastname();
        return $string;
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

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
