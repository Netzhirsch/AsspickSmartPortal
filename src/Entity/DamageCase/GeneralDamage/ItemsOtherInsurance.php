<?php

namespace App\Entity\DamageCase\GeneralDamage;

use App\Repository\DamageCase\GeneralDamage\ItemsOtherInsuranceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemsOtherInsuranceRepository::class)
 */
class ItemsOtherInsurance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasOtherInsurance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insured;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insuranceNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHasOtherInsurance(): ?bool
    {
        return $this->hasOtherInsurance;
    }

    public function setHasOtherInsurance(?bool $hasOtherInsurance): self
    {
        $this->hasOtherInsurance = $hasOtherInsurance;

        return $this;
    }

    public function getInsured(): ?string
    {
        return $this->insured;
    }

    public function setInsured(?string $insured): self
    {
        $this->insured = $insured;

        return $this;
    }

    public function getInsuranceNumber(): ?string
    {
        return $this->insuranceNumber;
    }

    public function setInsuranceNumber(?string $insuranceNumber): self
    {
        $this->insuranceNumber = $insuranceNumber;

        return $this;
    }
}
