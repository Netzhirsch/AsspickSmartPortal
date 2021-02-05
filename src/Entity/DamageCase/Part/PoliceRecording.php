<?php

namespace App\Entity\DamageCase\Part;

use App\Repository\DamageCase\Part\PoliceRecordingRepository;
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
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isRecorded;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileReference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diaryNumber;

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
}
