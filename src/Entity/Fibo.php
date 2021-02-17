<?php

namespace App\Entity;

use App\Repository\FiboRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FiboRepository::class)
 */
class Fibo
{
    const UPLOAD_FOLDER = 'fibo';
    const FORM_ROUTES= [
        'new' => 'damageCase_liability_new',
        'edit' => 'damageCase_liability_edit'
    ];
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
}
