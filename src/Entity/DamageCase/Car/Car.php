<?php

namespace App\Entity\DamageCase\Car;

use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\Insurer;
use App\Entity\DamageCase\Part\Payment;
use App\Entity\DamageCase\Part\PoliceRecording;
use App\Entity\DamageCase\Part\Policyholder;
use App\Entity\DamageCase\Part\Witness;
use App\Entity\File;
use App\PDF\DamageCase\CarPDF;
use App\Repository\DamageCase\Car\CarRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    const UPLOAD_FOLDER = 'car';
    const FORM_ROUTES = [
        'index' => 'damageCase_car_index',
        'new' => 'damageCase_car_new',
        'edit' => 'damageCase_car_edit',
    ];
    const PDF_CLASS = CarPDF::class;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=TypOfInsurance::class, inversedBy="cars")
     */
    private ?TypOfInsurance $typOfInsurance;

    /**
     * @ORM\ManyToOne(targetEntity=TypOfTrip::class, inversedBy="cars")
     */
    private ?TypOfTrip $typOfTrip;

    /**
     * @ORM\OneToOne(targetEntity=Insurer::class, inversedBy="car", cascade={"persist", "remove"})
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $licensePlate;

    /**
     * @ORM\OneToOne(targetEntity=Driver::class, cascade={"persist", "remove"})
     */
    private ?Driver $driver;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $hasOwnClaims;

    /**
     * @ORM\OneToOne(targetEntity=AccidentOpponent::class, cascade={"persist", "remove"})
     */
    private ?AccidentOpponent $accidentOpponent;

    /**
     * @ORM\OneToOne(targetEntity=OpponentCar::class, cascade={"persist", "remove"})
     */
    private ?OpponentCar $opponentCar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $typeOfInjury;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=TheftProtectionTyp::class)
     */
    private Collection $theftProtection;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $viewedOn;

    /**
     * @ORM\ManyToMany(targetEntity=WhoseCar::class)
     */
    private Collection $whoseCars;

    /**
     * @ORM\OneToOne(targetEntity=PoliceRecording::class, cascade={"persist", "remove"})
     */
    private ?PoliceRecording $policeRecording;

    /**
     * @ORM\OneToOne(targetEntity=Witness::class, cascade={"persist", "remove"})
     */
    private ?Witness $witness;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $other;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, cascade={"persist", "remove"})
     */
    private ?Payment $payment;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="car", cascade={"persist", "remove"})
     */
    private Collection $files;

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
        $this->createdAt = (new DateTime());
        $this->theftProtection = new ArrayCollection();
        $this->whoseCars = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->damageEvent = null;
        $this->setIsLocked(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getHasOwnClaims(): ?bool
    {
        return $this->hasOwnClaims;
    }

    public function setHasOwnClaims(?bool $hasOwnClaims): self
    {
        $this->hasOwnClaims = $hasOwnClaims;

        return $this;
    }

    public function getTypeOfInjury(): ?string
    {
        return $this->typeOfInjury;
    }

    public function setTypeOfInjury(?string $typeOfInjury): self
    {
        $this->typeOfInjury = $typeOfInjury;

        return $this;
    }

    public function getTypOfInsurance(): ?TypOfInsurance
    {
        return $this->typOfInsurance;
    }

    public function setTypOfInsurance(?TypOfInsurance $typOfInsurance): self
    {
        $this->typOfInsurance = $typOfInsurance;

        return $this;
    }

    public function getTypOfTrip(): ?TypOfTrip
    {
        return $this->typOfTrip;
    }

    public function setTypOfTrip(?TypOfTrip $typOfTrip): self
    {
        $this->typOfTrip = $typOfTrip;

        return $this;
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

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getAccidentOpponent(): ?AccidentOpponent
    {
        return $this->accidentOpponent;
    }

    public function setAccidentOpponent(?AccidentOpponent $accidentOpponent): self
    {
        $this->accidentOpponent = $accidentOpponent;

        return $this;
    }

    public function getOpponentCar(): ?OpponentCar
    {
        return $this->opponentCar;
    }

    public function setOpponentCar(?OpponentCar $opponentCar): self
    {
        $this->opponentCar = $opponentCar;

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

    /**
     * @return Collection|TheftProtectionTyp[]
     */
    public function getTheftProtection(): Collection
    {
        return $this->theftProtection;
    }

    public function addTheftProtection(TheftProtectionTyp $theftProtection): self
    {
        if (!$this->theftProtection->contains($theftProtection)) {
            $this->theftProtection[] = $theftProtection;
        }

        return $this;
    }

    public function removeTheftProtection(TheftProtectionTyp $theftProtection): self
    {
        $this->theftProtection->removeElement($theftProtection);

        return $this;
    }

    public function getViewedOn(): ?string
    {
        return $this->viewedOn;
    }

    public function setViewedOn(?string $viewedOn): self
    {
        $this->viewedOn = $viewedOn;

        return $this;
    }

    /**
     * @return Collection|WhoseCar[]
     */
    public function getWhoseCars(): Collection
    {
        return $this->whoseCars;
    }

    public function addWhoseCar(WhoseCar $whoseCar): self
    {
        if (!$this->whoseCars->contains($whoseCar)) {
            $this->whoseCars[] = $whoseCar;
        }

        return $this;
    }

    public function removeWhoseCar(WhoseCar $whoseCar): self
    {
        $this->whoseCars->removeElement($whoseCar);

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

    public function getWitness(): ?Witness
    {
        return $this->witness;
    }

    public function setWitness(?Witness $witness): self
    {
        $this->witness = $witness;

        return $this;
    }

    public function getOther(): ?string
    {
        return $this->other;
    }

    public function setOther(?string $other): self
    {
        $this->other = $other;

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
            $file->setCar($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getCar() === $this) {
                $file->setCar(null);
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
