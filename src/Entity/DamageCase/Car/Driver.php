<?php

namespace App\Entity\DamageCase\Car;

use App\Repository\DamageCase\Car\DriverRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DriverRepository::class)
 */
class Driver
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

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $hasLicense;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $licenseClass;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $licenseNumber;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $dateOfIssue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $exhibitionLocation;

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

    public function getHasLicense(): ?bool
    {
        return $this->hasLicense;
    }

    public function setHasLicense(?bool $hasLicense): self
    {
        $this->hasLicense = $hasLicense;

        return $this;
    }

    public function getLicenseClass(): ?string
    {
        return $this->licenseClass;
    }

    public function setLicenseClass(?string $licenseClass): self
    {
        $this->licenseClass = $licenseClass;

        return $this;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(?string $licenseNumber): self
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    public function getDateOfIssue(): ?DateTimeInterface
    {
        return $this->dateOfIssue;
    }

    public function setDateOfIssue(?DateTimeInterface $dateOfIssue): self
    {
        $this->dateOfIssue = $dateOfIssue;

        return $this;
    }

    public function getExhibitionLocation(): ?string
    {
        return $this->exhibitionLocation;
    }

    public function setExhibitionLocation(?string $exhibitionLocation): self
    {
        $this->exhibitionLocation = $exhibitionLocation;

        return $this;
    }

}
