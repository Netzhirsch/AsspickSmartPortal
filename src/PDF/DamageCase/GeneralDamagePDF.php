<?php


namespace App\PDF\DamageCase;


use App\Entity\DamageCase\GeneralDamage\BuildingDamage\BuildingDamage;
use App\Entity\DamageCase\GeneralDamage\GeneralDamage;
use App\Entity\DamageCase\GeneralDamage\GeneralDamageTyp;
use App\Entity\DamageCase\GeneralDamage\ItemsOtherInsurance;
use App\Entity\DamageCase\GeneralDamage\RepairCompany;
use App\Entity\DamageCase\GeneralDamage\TraceOfBreakIn;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\PDF\PDF;
use DateTime;

class GeneralDamagePDF extends DamageCasePDF
{
    public function create(GeneralDamage $generalDamage)
    {
        $this->SetMargins(self::MARGIN_LEFT, self::MARGIN_TOP, self::MARGIN_RIGHT);

        $this->AddPage();

        $this->printTitel('Sach – SCHADENANZEIGE');
        $this->printDivider();

        $typs = $generalDamage->getTyps();
        $this->printTyps($typs,$generalDamage->getCostumeTyp());
        $this->printDivider();

        $insurer = $generalDamage->getInsurer();
        $this->printInsurer($insurer);
        $this->printDivider();

        $policyholder = $generalDamage->getPolicyholder();
        $this->printPolicyholder($policyholder);
        $this->printDivider();

        $damageEvent = $generalDamage->getDamageEvent();
        $this->printDamageEventGeneralDamage($damageEvent);
        $this->printDivider();

        $this->printDamageCause($generalDamage->getDamageCause());
        $this->printDivider();

        $this->printBuildingDamage($generalDamage->getBuildingDamage());
        $this->printDivider();

        $this->printItemsOtherInsurance($generalDamage->getItemsOtherInsurance());
        $this->printDivider();

        $this->printTraceOfBreakIn($generalDamage->getTraceOfBreakIn());
        $this->printDivider();

        $this->printRepairCompany($generalDamage->getRepairCompany());
        $this->printDivider();

        $policeRecording = $generalDamage->getPoliceRecording();
        $this->printPoliceRecording($policeRecording,true,true);
        $this->printDivider();

        $payment = $generalDamage->getPayment();
        $this->printPayment($payment);
        $this->printDivider();

        $this->printDate((new DateTime()));
    }

    private function printDamageEventGeneralDamage(DamageEvent $damageEvent) {
        $this->printDamageEvent($damageEvent);
        $this->Ln();
        $this->Write(0, 'Schadenursache Leitungswasser: ');
        if (!empty($damageEvent)) {
            $temp = [];
            $causeOfDamageTyps = $damageEvent->getCauseOfDamageTyps();
            foreach ($causeOfDamageTyps as $causeOfDamageTyp)
                $temp[] = $causeOfDamageTyp->getName();

            $this->Write(0, implode(', ', $temp), '', 0, '', 1);
        }


    }

    /**
     * @param null|GeneralDamageTyp[] $typs
     * @param string|null $costumeTyp
     */
    private function printTyps($typs,?string $costumeTyp)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Art des Schaden: ');

        $typNames = [];
        foreach ($typs as $typ)
            $typNames[] = $typ->getName();

        if (!empty($costumeTyp))
            $typNames[] = $costumeTyp;

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Write(0, implode(', ', $typNames),'',false,'',1);
    }

    private function printBuildingDamage(?BuildingDamage $buildingDamage)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Bei Gebäudeschäden:','',0,'',1);

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Write(0, 'Sie sind ');
        if (!empty($buildingDamage)) {
            $relationshipToBuilding = $buildingDamage->getRelationshipToBuilding();
            if (!empty($relationshipToBuilding))
                $this->Write(0, $relationshipToBuilding->getName());
        }
        $this->Ln();

        $this->Write(0, 'Ist der Schaden in Mieträumen eingetreten? ');
        if (!empty($buildingDamage)) {
            if (is_null($buildingDamage->getIsDamageInRentedRooms()))
                $inRentedRooms = '';
            elseif($buildingDamage->getIsDamageInRentedRooms())
                $inRentedRooms = 'Ja';
            else
                $inRentedRooms = 'Nein';

            $this->Write(0, $inRentedRooms);
        }
        $this->Ln();

        $this->Write(0, 'Name des Mieters: ');
        if (!empty($buildingDamage)) {
            $tenantName = (!empty($buildingDamage->getTenantFirstname())?$buildingDamage->getTenantFirstname():'');
            $tenantName .= ' '.(!empty($buildingDamage->getTenantLastname())?$buildingDamage->getTenantLastname():'');
            $this->Write(0, $tenantName);
        }
        $this->Ln();

        $this->Write(0, 'Hausratversicherer: ');
        $this->Write(0, $buildingDamage->getHomeInsurer(),'',0,'',1);
        $this->Write(0, 'Vers.-Schein-Nr.: ');
        $this->Write(0, $buildingDamage->getHomeInsurerNumber(),'',0,'',1);

    }

    private function printItemsOtherInsurance(?ItemsOtherInsurance $itemsOtherInsurance)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Anderweitig Versichert','',0,'',1);

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        if (!empty($itemsOtherInsurance)) {
            if (is_null($itemsOtherInsurance->getHasOtherInsurance()))
                $hasOtherInsurance = '';
            elseif($itemsOtherInsurance->getHasOtherInsurance())
                $hasOtherInsurance = 'Ja';
            else
                $hasOtherInsurance = 'Nein';

            $this->Write(0, $hasOtherInsurance);
        }
        $this->Ln();

        $this->Write(0, 'Versicherer: ');
        if (!empty($itemsOtherInsurance))
            $this->Write(0, $itemsOtherInsurance->getInsurer());
        $this->Ln();

        $this->Write(0, 'Vers.-Schein-Nr.: ');
        if (!empty($itemsOtherInsurance))
            $this->Write(0, $itemsOtherInsurance->getInsuranceNumber());
    }

    private function printTraceOfBreakIn(?TraceOfBreakIn $traceOfBreakIn)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Einbruch (nur bei Einbruch-Diebstahl)','',0,'',1);

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Write(0, 'Einbruchspuren vorhanden? ');
        if (!empty($traceOfBreakIn)) {
            if (is_null($traceOfBreakIn->getIsTracePresent()))
                $tracePresent = '';
            elseif($traceOfBreakIn->getIsTracePresent())
                $tracePresent = 'Ja';
            else
                $tracePresent = 'Nein';
            $this->Write(0, $tracePresent);
        }
        $this->Ln();

        $this->Write(0, 'Welcher Art','',0,'',1);
        if (!empty($traceOfBreakIn)) {
            $this->Write(0, $traceOfBreakIn->getDescription());
        }


    }

    private function printRepairCompany(?RepairCompany $repairCompany)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Reparatur Firma','',0,'',1);

        $this->Write(0, 'Firmenname: ');
        if (!empty($repairCompany))
            $this->Write(0, $repairCompany->getName());
        $this->Ln();

        $this->Write(0, 'Straße / Postfach: ');
        if (!empty($repairCompany))
            $this->Write(0, $repairCompany->getStreetMailbox());
        $this->Ln();

        $this->Write(0, 'PLZ, Ort: ');
        if (!empty($repairCompany))
            $this->Write(0, $repairCompany->getPostCode().', '.$repairCompany->getLocation());
        $this->Ln();

        $this->Write(0, 'E-Mail-Adresse: ');
        if (!empty($repairCompany))
            $this->Write(0, $repairCompany->getEmail());
        $this->Ln();

        $this->Write(0, 'Telefon: ');
        if (!empty($repairCompany))
            $this->Write(0, $repairCompany->getPhone());
        $this->Ln();
    }


}