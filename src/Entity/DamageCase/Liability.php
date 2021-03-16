<?php

namespace App\Entity\DamageCase;

use App\Entity\DamageCase\Part\Claimant\Claimant;
use App\Entity\DamageCase\Part\Damage\DamageCause;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\Insurer;
use App\Entity\DamageCase\Part\Payment;
use App\Entity\DamageCase\Part\PersonalInjury;
use App\Entity\DamageCase\Part\PoliceRecording;
use App\Entity\DamageCase\Part\Policyholder;
use App\Entity\DamageCase\Part\Witness;
use App\Entity\File;
use App\PDF\DamageCase\LiabilityPDF;
use App\Repository\DamageCase\LiabilityRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LiabilityRepository::class)
 */
class Liability
{
    const UPLOAD_FOLDER = 'liability';
    const FORM_ROUTES= [
        'index' => 'damageCase_liability_index',
        'new' => 'damageCase_liability_new',
        'edit' => 'damageCase_liability_edit'
    ];
    const PDF_CLASS = LiabilityPDF::class;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=Insurer::class, cascade={"persist", "remove"})
     */
    private ?Insurer $insurer;

    /**
     * @ORM\OneToOne(targetEntity=Policyholder::class, cascade={"persist", "remove"})
     */
    private ?Policyholder $policyholder;

    /**
     * @ORM\OneToOne(targetEntity=DamageEvent::class, cascade={"persist", "remove"})
     */
    private ?DamageEvent $damageEvent;

    /**
     * @ORM\OneToOne(targetEntity=DamageCause::class, cascade={"persist", "remove"})
     */
    private ?DamageCause $damageCause;

    /**
     * @ORM\OneToOne(targetEntity=Witness::class, cascade={"persist", "remove"})
     */
    private ?Witness $witness;

    /**
     * @ORM\OneToOne(targetEntity=PoliceRecording::class, cascade={"persist", "remove"})
     */
    private ?PoliceRecording $policeRecording;

    /**
     * @ORM\OneToOne(targetEntity=Claimant::class, cascade={"persist", "remove"})
     */
    private ?Claimant $claimant;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isRepairPossible;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfOwnership::class)
     */
    private ?TypeOfOwnership $typeOfOwnership;

    /**
     * @ORM\OneToOne(targetEntity=PersonalInjury::class, cascade={"persist", "remove"})
     */
    private ?PersonalInjury $personalInjury;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, cascade={"persist", "remove"})
     */
    private ?Payment $payment;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="liability", cascade={"persist", "remove"})
     */
    private Collection $files;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isLocked;

    /**
     * @ORM\OneToOne(targetEntity=Witness::class, cascade={"persist", "remove"})
     */
    private ?Witness $witnessTwo;

    public function __construct()
    {
        $this->setCreatedAt((new DateTime()));
        $this->files = new ArrayCollection();
        $this->damageEvent = null;
        $this->setIsLocked(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInsurer(): ?Insurer
    {
        return $this->insurer;
    }

    public function setInsurer(?Insurer $insurer): self
    {
        $this->insurer = $insurer;

        return $this;
    }

    public function getPolicyholder(): ?Policyholder
    {
        return $this->policyholder;
    }

    public function setPolicyholder(?Policyholder $policyholder): self
    {
        $this->policyholder = $policyholder;

        return $this;
    }

    public function getDamageEvent(): ?DamageEvent
    {
        return $this->damageEvent;
    }

    public function setDamageEvent(?DamageEvent $damageEvent): self
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

    public function setPoliceRecording(?PoliceRecording $policeRecording): self
    {
        $this->policeRecording = $policeRecording;

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

    public function setIsRepairPossible(?bool $isRepairPossible): self
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

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setLiability($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getLiability() === $this) {
                $file->setLiability(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsLocked(): ?bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(bool $isLocked): self
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    public function getWitnessTwo(): ?Witness
    {
        return $this->witnessTwo;
    }

    public function setWitnessTwo(?Witness $witnessTwo): self
    {
        $this->witnessTwo = $witnessTwo;

        return $this;
    }
}
