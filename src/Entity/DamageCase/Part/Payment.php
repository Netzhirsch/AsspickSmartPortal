<?php

namespace App\Entity\DamageCase\Part;

use App\Repository\DamageCase\Part\PaymentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentsRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bank;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $iban;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bic;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accountHolder;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentTransferToTyp::class)
     */
    private $transferTo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasInputTaxDeduction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(string $bank): self
    {
        $this->bank = $bank;

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

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }

    public function getAccountHolder(): ?string
    {
        return $this->accountHolder;
    }

    public function setAccountHolder(string $accountHolder): self
    {
        $this->accountHolder = $accountHolder;

        return $this;
    }

    public function getTransferTo(): ?PaymentTransferToTyp
    {
        return $this->transferTo;
    }

    public function setTransferTo(?PaymentTransferToTyp $transferTo): self
    {
        $this->transferTo = $transferTo;

        return $this;
    }

    public function getHasInputTaxDeduction(): ?bool
    {
        return $this->hasInputTaxDeduction;
    }

    public function setHasInputTaxDeduction(?bool $hasInputTaxDeduction): self
    {
        $this->hasInputTaxDeduction = $hasInputTaxDeduction;

        return $this;
    }
}
