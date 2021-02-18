<?php

namespace App\Entity\DamageCase\GeneralDamage;

use App\Repository\DamageCase\GeneralDamage\RepairCompanyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepairCompanyRepository::class)
 */
class RepairCompany
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
    private ?string $name;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
