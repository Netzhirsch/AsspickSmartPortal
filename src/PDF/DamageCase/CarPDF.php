<?php


namespace App\PDF\DamageCase;


use App\Entity\DamageCase\Car\AccidentOpponent;
use App\Entity\DamageCase\Car\Car;
use App\Entity\DamageCase\Car\Driver;
use App\Entity\DamageCase\Car\OpponentCar;
use App\Entity\DamageCase\Car\TheftProtectionTyp;
use App\Entity\DamageCase\Car\TypOfInsurance;
use App\Entity\DamageCase\Car\TypOfTrip;
use App\Entity\DamageCase\Car\WhoseCar;
use App\Entity\DamageCase\Part\Damage\DamageCausedBy;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\Damage\DamageTyp;
use App\Enumeration\TypOfInsuranceEnum;
use App\PDF\PDF;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CarPDF extends PDF
{
    public function create(Car $car)
    {
        $this->SetMargins(self::MARGIN_LEFT, self::MARGIN_TOP, self::MARGIN_RIGHT);

        $this->AddPage();

        $this->printTitel('KFZ – SCHADENANZEIGE');
        $this->printDivider();

        $typOfInsurance = $car->getTypOfInsurance();
        $this->printTypOpInsurance($typOfInsurance);
        $typOfTrip = $car->getTypOfTrip();
        $this->printTypOfTrip($typOfTrip);
        $licensePlate = $car->getLicensePlate();
        $this->printLicensePlate($licensePlate);
        $this->printDivider();

        $insurer = $car->getInsurer();
        $this->printInsurer($insurer);
        $this->printDivider();

        $policyholder = $car->getPolicyholder();
        $this->printPolicyholder($policyholder);
        $this->printDivider();

        $damageEvent = $car->getDamageEvent();
        $this->printDamageEvent($damageEvent);
        $this->printDivider();

        $driver = $car->getDriver();
        $accidentOpponent = $car->getAccidentOpponent();
        $this->printDrivers($driver,$accidentOpponent);
        $this->printDivider();
        $license = null;
        if (!empty($driver))
            $license = $driver->getHasLicense();
        $this->printLicense($license);

        $opponentCar = $car->getOpponentCar();
        $this->printCar($opponentCar,$typOfInsurance);
        $this->printDivider();

        $description = '';
        if (!empty($damageEvent))
            $description = $damageEvent->getDescription();
        $this->printDamageEventDescription($description);
        $this->printDivider();

        $damageTyps = new ArrayCollection();
        if (!empty($damageEvent))
            $damageTyps = $car->getDamageEvent()->getTyps();
        $this->printDamageTyps($damageTyps);
        $this->printDivider();

        $causedBy = null;
        if (!empty($damageEvent) && !empty($damageEvent->getCausedBy()))
            $causedBy = $damageEvent->getCausedBy();
        $this->printCausedBy($causedBy);
        $this->printDivider();

        $this->printDamageAmounts($damageEvent);
        $this->printDivider();

        $personalInjury = $car->getTypeOfInjury();
        $this->printPersonalInjury($personalInjury);
        $this->printDivider();

        $theftProtectionTyp = $car->getTheftProtectionTyp();
        $this->printTheftProtection($theftProtectionTyp);
        $this->printDivider();

        $viewedOn = $car->getViewedOn();
        $this->printViewedOn($viewedOn);
        $whoseCars = $car->getWhoseCars();
        $this->Ln();
        $this->printWhoseCars($whoseCars);
        $this->printDivider();

        $policeRecording = $car->getPoliceRecording();
        $this->printPoliceRecording($policeRecording,true,true);
        $this->printDivider();

        $witness = $car->getWitness();
        $witnessTwo = $car->getWitnessTwo();
        $this->addPageIfContentDontFit(35);
        $this->printWitnesses($witness,$witnessTwo);
        $this->printDivider();

        $other = $car->getOther();
        $this->printOther($other);
        $this->printDivider();
//
//        $claimant = $liability->getClaimant();
//        $this->printClaimant($claimant);
//        $this->printDivider();
//
//        $this->printDamageItems($damageEvent,$liability);
//        $this->printDivider();
//
//
        $payment = $car->getPayment();
        $this->printPayment($payment);
        $this->printDivider();

        $this->printDate((new DateTime()));
    }

//    private function printDamageItems(?DamageEvent $damageEvent,Liability $liability)
//    {
//        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
//        $this->Write(0, 'Sachschäden (was wurde beschädigt):','',0,'',1);
//
//        $maxWidthForTwoCells = $this->getMaxWidthForTwoCells();
//        $minWidthLabel = $this->getMinWidthLabel();
//
//        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
//        $itemsDamaged = '';
//        if (!empty($damageEvent) && !empty($damageEvent->getItemsDamaged())) {
//            $itemsDamaged = $damageEvent->getItemsDamaged();
//        }
//        $this->Write(0, $itemsDamaged,'',0,'',1);
//
//        $this->Cell($maxWidthForTwoCells,0,'Ist eine Reparatur möglich?',self::DEBUG);
//        $isRepairPossible = '';
//        if (!empty($liability->getIsRepairPossible())) {
//            $isRepairPossible = $liability->getIsRepairPossible();
//            if ($isRepairPossible)
//                $isRepairPossible = 'ja';
//            else
//                $isRepairPossible = 'nein';
//        }
//        $this->Cell($minWidthLabel,0,$isRepairPossible,self::DEBUG);
//
//        $this->Cell($maxWidthForTwoCells,0,'Geschätzte Schadenhöhe:',self::DEBUG);
//        $damageAmount = 0;
//        if (!empty($damageEvent) && !empty($damageEvent->getDamageAmount()))
//            $damageAmount = $damageEvent->getDamageAmount();
//        $this->Cell(
//            $minWidthLabel,
//            0,
//            number_format($damageAmount, 2, ",", ".").' EUR',
//            self::DEBUG,
//            1
//        );
//
//        $this->Cell
//        (
//            $maxWidthForTwoCells + $minWidthLabel,
//            0,
//            'Hatten Sie die beschädigte Sache:',
//            self::DEBUG
//        );
//        $typeOfOwnership = '';
//        if (!empty($liability->getTypeOfOwnership())) {
//            $typeOfOwnership = $liability->getTypeOfOwnership();
//            if (!empty($typeOfOwnership))
//                $typeOfOwnership = $typeOfOwnership->getName();
//        }
//        $this->Cell($maxWidthForTwoCells,0,$typeOfOwnership,self::DEBUG);
//    }

    private function printPersonalInjury(?string $injuries)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Personenschäden:','',0,'',1);

        $maxWidthForTwoCells = $this->getMaxWidthForTwoCells();

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Cell($maxWidthForTwoCells,0,'Art der Verletzung:',self::DEBUG);
        $personalInjuryString = '';
        if (!empty($injuries))
            $personalInjuryString = $injuries;
        $this->Cell(0,0,$personalInjuryString,self::DEBUG);
    }

    private function printTypOpInsurance(?TypOfInsurance $typOfInsurance)
    {
        $minWidthLabel = $this->getMinWidthLabel(6);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);

        $this->Cell($minWidthLabel,0,'Type: ',self::DEBUG);
        $type = '';
        if (!empty($typOfInsurance) && !empty($typOfInsurance->getName()))
            $type = $typOfInsurance->getName();
        $this->Cell(20,0,$type,self::DEBUG);
    }

    private function printTypOfTrip(?TypOfTrip $typOfTrip)
    {
        $minWidthLabel = $this->getMinWidthLabel();
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);

        $this->Cell($minWidthLabel,0,'Art der Fahrt: ',self::DEBUG);
        $type = '';
        if (!empty($typOfTrip) && !empty($typOfTrip->getName()))
            $type = $typOfTrip->getName();
        $this->Cell(30,0,$type,self::DEBUG);
    }

    private function printLicensePlate(?string $licensePlate)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);

        $this->Cell(50,0,'Amtliches Kennzeichen: ',self::DEBUG);
        $licensePlateString = '';
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        if (!empty($licensePlate))
            $licensePlateString = $licensePlate;
        $this->Cell(0,0,$licensePlateString,self::DEBUG);
    }

    private function printDrivers(?Driver $driver, ?AccidentOpponent $accidentOpponent)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $half = $this->getMaxContentWidth() / 2;
        $this->Cell($half,0,'Fahrer(in) zum Schadenzeitpunkt: ',self::DEBUG);
        $this->Cell($half,0,'Unfallgegner: ',self::DEBUG,1);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $minWidthLabel = $this->getMinWidthLabel();

        $this->Cell($minWidthLabel,0,'Name: ',self::DEBUG);
        $halfRest = $half - $minWidthLabel;
        $name = '';
        if (!empty($driver))
            $name = $driver->__toString();
        $this->Cell($halfRest,0,$name,self::DEBUG);
        $name = '';
        if (!empty($accidentOpponent))
            $name = $accidentOpponent->__toString();
        $this->Cell(0,0,$name,self::DEBUG,1);

        $this->Cell($minWidthLabel,0,'Straße: ',self::DEBUG);
        $streetMailbox = '';
        if (!empty($driver) && !empty($driver->getStreetMailbox()))
            $streetMailbox = $driver->getStreetMailbox();
        $this->Cell($halfRest,0,$streetMailbox,self::DEBUG);
        $streetMailbox = '';
        if (!empty($accidentOpponent) && !empty($accidentOpponent->getStreetMailbox()))
            $streetMailbox = $accidentOpponent->getStreetMailbox();
        $this->Cell(0,0,$streetMailbox,self::DEBUG,1);

        $this->Cell($minWidthLabel,0,'PLZ, Ort',self::DEBUG);
        $postcodeLocation = $this->getPostCodeLocationString($driver);
        $this->Cell($halfRest,0,$postcodeLocation,self::DEBUG);
        $postcodeLocation = $this->getPostCodeLocationString($accidentOpponent);
        $this->Cell(0,0,$postcodeLocation,self::DEBUG);
    }

    private function printLicense(?bool $license)
    {
        $half = $this->getMaxContentWidth() / 2;
        $fourth = $half / 2;
        $this->Cell($fourth, 0, 'Gültigen Fahrerlaubnis: ',self::DEBUG);
        $licenseString = '';
        if (!empty($license) && $license)
            $licenseString = 'ja';
        elseif (!empty($license))
            $licenseString = 'nein';
        $this->Cell($fourth,0,$licenseString);
    }

    private function printCar(
        ?OpponentCar $car,
        ?TypOfInsurance $typOfInsurance
    )
    {
        $titel = 'Gegnerisches Fahrzeug bei Haftpflicht- oder eigenes Fahrzeug bei einem Kaskoschaden:';
        if (!empty($typOfInsurance) && $typOfInsurance->getId() == TypOfInsuranceEnum::HAFTPFLICHT)
            $titel = 'Gegnerisches Fahrzeug:';
        elseif(!empty($typOfInsurance) && $typOfInsurance->getId() == TypOfInsuranceEnum::KASKO)
            $titel = 'Gegnerisches Fahrzeug:';
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $half = $this->getMaxContentWidth() / 2;
        $this->Cell($half,0,$titel,self::DEBUG,1);
        $this->SetX($this->GetX()+$half);
        $fourth = $half / 2;
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Cell($fourth,0,'Amtl. Kennzeichen:');
        $licensePlate = '';
        if (!empty($car) && !empty($car->getLicensePlate()))
            $licensePlate = $car->getLicensePlate();
        $this->Cell($fourth,0,$licensePlate,self::DEBUG,1);

        $this->SetX($this->GetX()+$half);
        $this->Cell($fourth,0,'Hersteller:');
        $manufacturer = '';
        if (!empty($car) && !empty($car->getManufacturer()))
            $manufacturer = $car->getManufacturer();
        $this->Cell($fourth,0,$manufacturer,self::DEBUG,1);

        $this->SetX($this->GetX()+$half);
        $this->Cell($fourth,0,'Modell/Baujahr:');
        $modelAndYear = [];
        if (!empty($car) && !empty($car->getModel()))
            $modelAndYear[] = $car->getModel();
        if (!empty($car) && !empty($car->getYearOfManufacture()))
            $modelAndYear[] = $car->getYearOfManufacture();
        $this->Cell($fourth,0,implode('/', $modelAndYear),self::DEBUG,1);

        if(!empty($car) && !empty($typOfInsurance) && $typOfInsurance->getId() == TypOfInsuranceEnum::KASKO) {
            $this->SetX($this->GetX()+$half);
            $this->Cell($fourth,0,'Km-Stand:');
            $kmStatus = '';
            if (!empty($car->getKmStatus()))
                $kmStatus = $car->getKmStatus();
            $this->Cell($fourth,0,$kmStatus,self::DEBUG,1);
        }

        $this->SetX($this->GetX()+$half);
        $this->Cell($fourth,0,'Versichert bei:');
        $insuredWith = '';
        if (!empty($car) && !empty($car->getInsuredWith()))
            $insuredWith = $car->getInsuredWith();
        $this->Cell($fourth,0,$insuredWith,self::DEBUG,1);

        $this->SetX($this->GetX()+$half);
        $this->Cell($fourth,0,'VS-Nr.:');
        $number = '';
        if (!empty($car) && !empty($car->getInsuranceNumber()))
            $number = $car->getInsuranceNumber();
        $this->Cell($fourth,0,$number,self::DEBUG);
    }

    /**
     * @param DamageTyp[]|Collection $damageTyps
     */
    private function printDamageTyps($damageTyps)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Schadenart:','',0,'',1);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $typs = [];
        foreach ($damageTyps as $damageTyp) {
            $typs[] = $damageTyp->getName();
        }
        $this->Write(0, implode(', ', $typs));
    }

    private function printCausedBy(?DamageCausedBy $causedBy)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Verursacht durch:','',0,'',1);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $who = '';
        if (!empty($causedBy))
            $who = $causedBy->getName();
        $this->Write(0, $who);
    }

    private function printDamageAmounts(?DamageEvent $damageEvent)
    {
        $half = $this->getMaxContentWidth() / 2;
        $this->Cell($half,0,'Schaden am eigenen Fahrzeug');
        $amount = 0;
        if (!empty($damageEvent) && !empty($damageEvent->getDamageAmount()))
            $amount = $damageEvent->getDamageAmount();
        $this->Cell
        (
            $half,
            0,
            number_format($amount, 2, ",", ".").' EUR',
            self::DEBUG,
            1
        );

        $this->Cell($half,0,'Schaden am fremden Fahrzeug');
        $amount = 0;
        if (!empty($damageEvent) && !empty($damageEvent->getDamageAmountOnOpponent()))
            $amount = $damageEvent->getDamageAmountOnOpponent();
        $this->Cell(
            $half,
            0,
            number_format($amount, 2, ",", ".").' EUR',
            self::DEBUG,
            1
        );

    }

    /**
     * @param TheftProtectionTyp[] |Collection $theftProtection
     */
    private function printTheftProtection(Collection $theftProtection)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Bei Diebstahlschäden:','',0,'',1);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $typs = [];
        foreach ($theftProtection as $theftProtectionTyp) {
            $typs[] = $theftProtectionTyp->getName();
        }
        $this->Write(0, implode(', ', $typs));
    }

    private function printViewedOn(?string $viewedOn)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Fahrzeug Besichtigung:','',0,'',1);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $viewedOnString = '';
        if (!empty($viewedOn))
            $viewedOnString = $viewedOn;
        $this->Write(0, $viewedOnString,'',0,'',1);
    }

    /**
     * @param WhoseCar[] | Collection $whoseCars
     */
    private function printWhoseCars(Collection $whoseCars)
    {
        $this->Write(0, 'Wessen Fahrzeug: ');
        $cars = [];
        foreach ($whoseCars as $car) {
            $cars[] = $car->getName();
        }
        $this->Write(0, implode(', ', $cars));
    }

    private function printOther(?string $other)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Sonstiges:','',0,'',1);
        $otherString = '';
        if (!empty($other))
            $otherString = $other;
        $this->Write(0, $otherString);
    }
}