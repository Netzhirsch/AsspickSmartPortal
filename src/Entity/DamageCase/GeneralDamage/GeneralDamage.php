<?php

namespace App\Entity\DamageCase\GeneralDamage;

use App\Entity\DamageCase\GeneralDamage\BuildingDamage\BuildingDamage;
use App\Entity\DamageCase\Part\Damage\DamageCause;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\Insured;
use App\Entity\DamageCase\Part\Payment;
use App\Entity\DamageCase\Part\PoliceRecording;
use App\Entity\DamageCase\Part\Policyholder;
use App\Entity\File;
use App\Repository\DamageCase\GeneralDamage\GeneralDamageRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GeneralDamageRepository::class)
 */
class GeneralDamage
{
    const UPLOAD_FOLDER = 'general_damage';
    const FORM_ROUTES = [
        'new' => 'damageCase_generalDamage_new',
        'edit' => 'damageCase_generalDamage_edit',
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToMany(targetEntity=GeneralDamageTyp::class)
     */
    private Collection $typs;

    /**
     * @ORM\OneToOne(targetEntity=Insured::class, cascade={"persist", "remove"})
     */
    private ?Insured $insured;

    /**
     * @ORM\OneToOne(targetEntity=Policyholder::class, cascade={"persist", "remove"})
     */
    private ?Policyholder $policyholder;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, cascade={"persist", "remove"})
     */
    private ?Payment $payment;

    /**
     * @ORM\OneToOne(targetEntity=RepairCompany::class, cascade={"persist", "remove"})
     */
    private ?RepairCompany $repairCompany;

    /**
     * @ORM\OneToOne(targetEntity=PoliceRecording::class, cascade={"persist", "remove"})
     */
    private ?PoliceRecording $policeRecording;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\OneToOne(targetEntity=DamageEvent::class, cascade={"persist", "remove"})
     */
    private ?DamageEvent $damageEvent;

    /**
     * @ORM\OneToOne(targetEntity=DamageCause::class, cascade={"persist", "remove"})
     */
    private ?DamageCause $damageCause;

    /**
     * @ORM\OneToOne(targetEntity=BuildingDamage::class, cascade={"persist", "remove"})
     */
    private ?BuildingDamage $buildingDamage;

    /**
     * @ORM\OneToOne(targetEntity=ItemsOtherInsurance::class, cascade={"persist", "remove"})
     */
    private ?ItemsOtherInsurance $itemsOtherInsurance;

    /**
     * @ORM\OneToOne(targetEntity=TraceOfBreakIn::class, cascade={"persist", "remove"})
     */
    private ?TraceOfBreakIn $traceOfBreakIn;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="generalDamage", cascade={"persist", "remove"})
     */
    private Collection $files;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isLocked;


    public function __construct()
    {
        $this->setIsLocked(false);
        $this->createdAt = (new DateTime());
        $this->typs = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->damageEvent = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|GeneralDamageTyp[]
     */
    public function getTyps(): Collection
    {
        return $this->typs;
    }

    public function addTyp(GeneralDamageTyp $typ): self
    {
        if (!$this->typs->contains($typ)) {
            $this->typs[] = $typ;
        }

        return $this;
    }

    public function removeTyp(GeneralDamageTyp $typ): self
    {
        $this->typs->removeElement($typ);

        return $this;
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

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getRepairCompany(): ?RepairCompany
    {
        return $this->repairCompany;
    }

    public function setRepairCompany(?RepairCompany $repairCompany): self
    {
        $this->repairCompany = $repairCompany;

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

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getBuildingDamage(): ?BuildingDamage
    {
        return $this->buildingDamage;
    }

    public function setBuildingDamage(?BuildingDamage $buildingDamage): self
    {
        $this->buildingDamage = $buildingDamage;

        return $this;
    }

    public function getItemsOtherInsurance(): ?ItemsOtherInsurance
    {
        return $this->itemsOtherInsurance;
    }

    public function setItemsOtherInsurance(?ItemsOtherInsurance $itemsOtherInsurance): self
    {
        $this->itemsOtherInsurance = $itemsOtherInsurance;

        return $this;
    }

    public function getTraceOfBreakIn(): ?TraceOfBreakIn
    {
        return $this->traceOfBreakIn;
    }

    public function setTraceOfBreakIn(?TraceOfBreakIn $traceOfBreakIn): self
    {
        $this->traceOfBreakIn = $traceOfBreakIn;

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
            $file->setGeneralDamage($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getGeneralDamage() === $this) {
                $file->setGeneralDamage(null);
            }
        }

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
}
