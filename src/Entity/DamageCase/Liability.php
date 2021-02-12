<?php

namespace App\Entity\DamageCase;

use App\Entity\DamageCase\Part\Claimant\Claimant;
use App\Entity\DamageCase\Part\Damage\DamageCause;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\Insured;
use App\Entity\DamageCase\Part\Payment;
use App\Entity\DamageCase\Part\PersonalInjury;
use App\Entity\DamageCase\Part\PoliceRecording;
use App\Entity\DamageCase\Part\Policyholder;
use App\Entity\DamageCase\Part\Witness;
use App\Entity\File;
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
        'new' => 'damageCase_liability_new',
        'edit' => 'damageCase_liability_edit'
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Insured::class, cascade={"persist", "remove"})
     */
    private $insured;

    /**
     * @ORM\OneToOne(targetEntity=Policyholder::class, cascade={"persist", "remove"})
     */
    private $policyholder;

    /**
     * @ORM\OneToOne(targetEntity=DamageEvent::class, cascade={"persist", "remove"})
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
     */
    private $policeRecording;

    /**
     * @ORM\OneToOne(targetEntity=Claimant::class, cascade={"persist", "remove"})
     */
    private $claimant;

    /**
     * @ORM\Column(type="boolean", nullable=true)
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
     */
    private $payment;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="liability", cascade={"persist", "remove"})
     */
    private $files;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->setCreatedAt((new DateTime()));
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInsured(): ?Insured
    {
        return $this->insured;
    }

    public function setInsured(?Insured $insured): self
    {
        $this->insured = $insured;

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
}
