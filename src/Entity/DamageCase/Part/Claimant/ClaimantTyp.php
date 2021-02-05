<?php

namespace App\Entity\DamageCase\Part\Claimant;

use App\Repository\DamageCase\Part\Claimant\ClaimantTypRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClaimantTypRepository::class)
 */
class ClaimantTyp
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Claimant::class, mappedBy="typ")
     */
    private $claimants;

    public function __construct()
    {
        $this->claimants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Claimant[]
     */
    public function getClaimants(): Collection
    {
        return $this->claimants;
    }

    public function addClaimant(Claimant $claimant): self
    {
        if (!$this->claimants->contains($claimant)) {
            $this->claimants[] = $claimant;
            $claimant->setTyp($this);
        }

        return $this;
    }

    public function removeClaimant(Claimant $claimant): self
    {
        if ($this->claimants->removeElement($claimant)) {
            // set the owning side to null (unless already changed)
            if ($claimant->getTyp() === $this) {
                $claimant->setTyp(null);
            }
        }

        return $this;
    }
}
