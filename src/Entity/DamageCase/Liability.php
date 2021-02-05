<?php

namespace App\Entity\DamageCase;

use App\Entity\DamageCase\Part\Claimant\Claimant;
use App\Entity\DamageCase\Part\CriminalProceedingsAgainstTyp;
use App\Entity\DamageCase\Part\DamageCause;
use App\Entity\DamageCase\Part\DamageEvent;
use App\Entity\DamageCase\Part\Insured;
use App\Entity\DamageCase\Part\Payment;
use App\Entity\DamageCase\Part\PersonalInjury;
use App\Entity\DamageCase\Part\PoliceRecording;
use App\Entity\DamageCase\Part\Policyholder;
use App\Entity\DamageCase\Part\Signature;
use App\Entity\DamageCase\Part\Witness;
use App\Repository\DamageCase\LiabilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LiabilityRepository::class)
 */
class Liability
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Insured::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $insured;

    /**
     * @ORM\OneToOne(targetEntity=Policyholder::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $policyholder;

    /**
     * @ORM\OneToOne(targetEntity=DamageEvent::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $damageEvent;

    /**
     * @ORM\OneToOne(targetEntity=DamageCause::class, cascade={"persist", "remove"})
     */
    private $damageCause;

    /**
     * @ORM\OneToOne(targetEntity=Witness::class, cascade={"persist", "remove"})
     */
    private $witness;

    /**
     * @ORM\OneToOne(targetEntity=PoliceRecording::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $policeRecording;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasCriminalProceedings;

    /**
     * @ORM\ManyToOne(targetEntity=CriminalProceedingsAgainstTyp::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $criminalProceedingsAgainst;

    /**
     * @ORM\OneToOne(targetEntity=Claimant::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $claimant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRepairPossible;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfOwnership::class)
     */
    private $typeOfOwnership;

    /**
     * @ORM\OneToOne(targetEntity=PersonalInjury::class, cascade={"persist", "remove"})
     */
    private $personalInjury;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $payment;

    /**
     * @ORM\OneToOne(targetEntity=Signature::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $signature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInsured(): ?Insured
    {
        return $this->insured;
    }

    public function setInsured(Insured $insured): self
    {
        $this->insured = $insured;

        return $this;
    }

    public function getPolicyholder(): ?Policyholder
    {
        return $this->policyholder;
    }

    public function setPolicyholder(Policyholder $policyholder): self
    {
        $this->policyholder = $policyholder;

        return $this;
    }

    public function getDamageEvent(): ?DamageEvent
    {
        return $this->damageEvent;
    }

    public function setDamageEvent(DamageEvent $damageEvent): self
    {
        $this->damageEvent = $damageEvent;

        return $this;
    }

    public function getDamageCause(): ?DamageCause
    {
        return $this->damageCause;
    }

    public function setDamageCause(?DamageCause $damageCause): self
    {
        $this->damageCause = $damageCause;

        return $this;
    }

    public function getWitness(): ?Witness
    {
        return $this->witness;
    }

    public function setWitness(?Witness $witness): self
    {
        $this->witness = $witness;

        return $this;
    }

    public function getPoliceRecording(): ?PoliceRecording
    {
        return $this->policeRecording;
    }

    public function setPoliceRecording(PoliceRecording $policeRecording): self
    {
        $this->policeRecording = $policeRecording;

        return $this;
    }

    public function getHasCriminalProceedings(): ?bool
    {
        return $this->hasCriminalProceedings;
    }

    public function setHasCriminalProceedings(bool $hasCriminalProceedings): self
    {
        $this->hasCriminalProceedings = $hasCriminalProceedings;

        return $this;
    }

    public function getCriminalProceedingsAgainst(): ?CriminalProceedingsAgainstTyp
    {
        return $this->criminalProceedingsAgainst;
    }

    public function setCriminalProceedingsAgainst(?CriminalProceedingsAgainstTyp $criminalProceedingsAgainst): self
    {
        $this->criminalProceedingsAgainst = $criminalProceedingsAgainst;

        return $this;
    }

    public function getClaimant(): ?Claimant
    {
        return $this->claimant;
    }

    public function setClaimant(Claimant $claimant): self
    {
        $this->claimant = $claimant;

        return $this;
    }

    public function getIsRepairPossible(): ?bool
    {
        return $this->isRepairPossible;
    }

    public function setIsRepairPossible(bool $isRepairPossible): self
    {
        $this->isRepairPossible = $isRepairPossible;

        return $this;
    }

    public function getTypeOfOwnership(): ?TypeOfOwnership
    {
        return $this->typeOfOwnership;
    }

    public function setTypeOfOwnership(?TypeOfOwnership $typeOfOwnership): self
    {
        $this->typeOfOwnership = $typeOfOwnership;

        return $this;
    }

    public function getPersonalInjury(): ?PersonalInjury
    {
        return $this->personalInjury;
    }

    public function setPersonalInjury(?PersonalInjury $personalInjury): self
    {
        $this->personalInjury = $personalInjury;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getSignature(): ?Signature
    {
        return $this->signature;
    }

    public function setSignature(Signature $signature): self
    {
        $this->signature = $signature;

        return $this;
    }
}
