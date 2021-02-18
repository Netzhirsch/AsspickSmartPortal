<?php

namespace App\Entity\DamageCase\Part;

use App\Repository\DamageCase\Part\PoliceRecordingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PoliceRecordingRepository::class)
 */
class PoliceRecording
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isRecorded;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $fileReference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $diaryNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $hasCriminalProceedings;

    /**
     * @ORM\ManyToMany(targetEntity=CriminalProceedingsAgainstTyp::class)
     */
    private Collection $criminalProceedingsAgainst;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isWarnedWithCharge;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $hasDrugUse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $hasDrugTest;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     */
    private ?string $drugTestResult;

    /**
     * @ORM\ManyToMany(targetEntity=WhoIsWarnedWithCharge::class)
     */
    private Collection $whoIsWarnedWithCharge;

    public function __construct()
    {
        $this->criminalProceedingsAgainst = new ArrayCollection();
        $this->whoIsWarnedWithCharge = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsRecorded(): ?bool
    {
        return $this->isRecorded;
    }

    public function setIsRecorded(?bool $isRecorded): self
    {
        $this->isRecorded = $isRecorded;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getFileReference(): ?string
    {
        return $this->fileReference;
    }

    public function setFileReference(?string $fileReference): self
    {
        $this->fileReference = $fileReference;

        return $this;
    }

    public function getDiaryNumber(): ?string
    {
        return $this->diaryNumber;
    }

    public function setDiaryNumber(?string $diaryNumber): self
    {
        $this->diaryNumber = $diaryNumber;

        return $this;
    }

    public function getHasCriminalProceedings(): ?bool
    {
        return $this->hasCriminalProceedings;
    }

    public function setHasCriminalProceedings(?bool $hasCriminalProceedings): self
    {
        $this->hasCriminalProceedings = $hasCriminalProceedings;

        return $this;
    }

    /**
     * @return Collection|CriminalProceedingsAgainstTyp[]
     */
    public function getCriminalProceedingsAgainst(): Collection
    {
        return $this->criminalProceedingsAgainst;
    }

    public function addCriminalProceedingsAgainst(CriminalProceedingsAgainstTyp $criminalProceedingsAgainst): self
    {
        if (!$this->criminalProceedingsAgainst->contains($criminalProceedingsAgainst)) {
            $this->criminalProceedingsAgainst[] = $criminalProceedingsAgainst;
        }

        return $this;
    }

    public function removeCriminalProceedingsAgainst(CriminalProceedingsAgainstTyp $criminalProceedingsAgainst): self
    {
        $this->criminalProceedingsAgainst->removeElement($criminalProceedingsAgainst);

        return $this;
    }

    public function getIsWarnedWithCharge(): ?bool
    {
        return $this->isWarnedWithCharge;
    }

    public function setIsWarnedWithCharge(?bool $isWarnedWithCharge): self
    {
        $this->isWarnedWithCharge = $isWarnedWithCharge;

        return $this;
    }

    public function getHasDrugUse(): ?bool
    {
        return $this->hasDrugUse;
    }

    public function setHasDrugUse(?bool $hasDrugUse): self
    {
        $this->hasDrugUse = $hasDrugUse;

        return $this;
    }

    public function getHasDrugTest(): ?bool
    {
        return $this->hasDrugTest;
    }

    public function setHasDrugTest(?bool $hasDrugTest): self
    {
        $this->hasDrugTest = $hasDrugTest;

        return $this;
    }

    public function getDrugTestResult(): ?string
    {
        return $this->drugTestResult;
    }

    public function setDrugTestResult(?string $drugTestResult): self
    {
        $this->drugTestResult = $drugTestResult;

        return $this;
    }

    /**
     * @return Collection|WhoIsWarnedWithCharge[]
     */
    public function getWhoIsWarnedWithCharge(): Collection
    {
        return $this->whoIsWarnedWithCharge;
    }

    public function addWhoIsWarnedWithCharge(WhoIsWarnedWithCharge $whoIsWarnedWithCharge): self
    {
        if (!$this->whoIsWarnedWithCharge->contains($whoIsWarnedWithCharge)) {
            $this->whoIsWarnedWithCharge[] = $whoIsWarnedWithCharge;
        }

        return $this;
    }

    public function removeWhoIsWarnedWithCharge(WhoIsWarnedWithCharge $whoIsWarnedWithCharge): self
    {
        $this->whoIsWarnedWithCharge->removeElement($whoIsWarnedWithCharge);

        return $this;
    }
}
