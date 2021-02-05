<?php

namespace App\Entity\DamageCase\Part\Claimant;

use App\Repository\DamageCase\Part\Claimant\ClaimantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClaimantRepository::class)
 */
class Claimant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $streetMailbox;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=ClaimantTyp::class, inversedBy="claimants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typ;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kindOfRelationship;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInDomesticCommunityWithMe;

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

    public function getTyp(): ?ClaimantTyp
    {
        return $this->typ;
    }

    public function setTyp(?ClaimantTyp $typ): self
    {
        $this->typ = $typ;

        return $this;
    }

    public function getKindOfRelationship(): ?string
    {
        return $this->kindOfRelationship;
    }

    public function setKindOfRelationship(?string $kindOfRelationship): self
    {
        $this->kindOfRelationship = $kindOfRelationship;

        return $this;
    }

    public function getIsInDomesticCommunityWithMe(): ?bool
    {
        return $this->isInDomesticCommunityWithMe;
    }

    public function setIsInDomesticCommunityWithMe(bool $isInDomesticCommunityWithMe): self
    {
        $this->isInDomesticCommunityWithMe = $isInDomesticCommunityWithMe;

        return $this;
    }
}
