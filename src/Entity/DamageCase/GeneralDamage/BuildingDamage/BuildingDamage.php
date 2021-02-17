<?php

namespace App\Entity\DamageCase\GeneralDamage\BuildingDamage;

use App\Repository\DamageCase\GeneralDamage\BuildingDamage\BuildingDamageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuildingDamageRepository::class)
 */
class BuildingDamage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=RelationshipToBuilding::class)
     */
    private ?RelationshipToBuilding $relationshipToBuilding;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isDamageInRentedRooms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $tenantFirstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $tenantLastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $homeInsurer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $homeInsurerNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelationshipToBuilding(): ?RelationshipToBuilding
    {
        return $this->relationshipToBuilding;
    }

    public function setRelationshipToBuilding(?RelationshipToBuilding $relationshipToBuilding): self
    {
        $this->relationshipToBuilding = $relationshipToBuilding;

        return $this;
    }

    public function getIsDamageInRentedRooms(): ?bool
    {
        return $this->isDamageInRentedRooms;
    }

    public function setIsDamageInRentedRooms(?bool $isDamageInRentedRooms): self
    {
        $this->isDamageInRentedRooms = $isDamageInRentedRooms;

        return $this;
    }

    public function getTenantFirstname(): ?string
    {
        return $this->tenantFirstname;
    }

    public function setTenantFirstname(?string $tenantFirstname): self
    {
        $this->tenantFirstname = $tenantFirstname;

        return $this;
    }

    public function getTenantLastname(): ?string
    {
        return $this->tenantLastname;
    }

    public function setTenantLastname(?string $tenantLastname): self
    {
        $this->tenantLastname = $tenantLastname;

        return $this;
    }

    public function getHomeInsurer(): ?string
    {
        return $this->homeInsurer;
    }

    public function setHomeInsurer(?string $homeInsurer): self
    {
        $this->homeInsurer = $homeInsurer;

        return $this;
    }

    public function getHomeInsurerNumber(): ?string
    {
        return $this->homeInsurerNumber;
    }

    public function setHomeInsurerNumber(?string $homeInsurerNumber): self
    {
        $this->homeInsurerNumber = $homeInsurerNumber;

        return $this;
    }
}
