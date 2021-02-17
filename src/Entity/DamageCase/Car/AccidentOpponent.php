<?php

namespace App\Entity\DamageCase\Car;

use App\Repository\DamageCase\Car\AccidentOpponentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccidentOpponentRepository::class)
 */
class AccidentOpponent
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
    private ?string $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $streetMailbox;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $postCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $location;

    public function __toString(): string
    {
        $name = '';
        $firstname = $this->getFirstname();
        if (empty($firstname))
            return $name;
        $name .= $firstname;

        $lastname = $this->getLastname();
        if (empty($lastname))
            return $name;
        $name .= ' '.$lastname;

        return $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStreetMailbox(): ?string
    {
        return $this->streetMailbox;
    }

    public function setStreetMailbox(?string $streetMailbox): self
    {
        $this->streetMailbox = $streetMailbox;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

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
}
