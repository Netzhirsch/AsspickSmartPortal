<?php

namespace App\Entity\DamageCase\GeneralDamage\BuildingDamage;

use App\Repository\DamageCase\GeneralDamage\BuildingDamage\RelationshipToBuildingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelationshipToBuildingRepository::class)
 */
class RelationshipToBuilding
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
    private ?string $name;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
