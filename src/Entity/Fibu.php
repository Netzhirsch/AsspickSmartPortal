<?php

namespace App\Entity;

use App\Repository\FibuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FibuRepository::class)
 */
class Fibu
{
    const UPLOAD_FOLDER = 'fibu';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $intermediaryName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getIntermediaryName(): ?string
    {
        return $this->intermediaryName;
    }

    public function setIntermediaryName(string $intermediaryName): self
    {
        $this->intermediaryName = $intermediaryName;

        return $this;
    }
}
