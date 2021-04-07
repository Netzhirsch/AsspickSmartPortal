<?php


namespace App\PDF\DamageCase;


use App\Entity\DamageCase\Liability;
use App\Entity\DamageCase\Part\Claimant\Claimant;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\PersonalInjury;
use App\PDF\PDF;
use DateTime;

class LiabilityPDF extends DamageCasePDF
{
    public function create(Liability $liability)
    {
        $this->SetMargins(self::MARGIN_LEFT, self::MARGIN_TOP, self::MARGIN_RIGHT);

        $this->AddPage();

        $this->printTitel('HAFTPFLICHT – SCHADENANZEIGE');
        $this->printDivider();

        $insured = $liability->getInsurer();
        if (!empty($insured)) {
            $this->printInsurer($insured);
            $this->printDivider();
        }
        $policyholder = $liability->getPolicyholder();
        if (!empty($policyholder)) {
            $this->printPolicyholder($policyholder);
            $this->printDivider();
        }
        $damageEvent = $liability->getDamageEvent();
        if (!empty($damageEvent)) {
            $this->printDamageEvent($damageEvent);
            $this->printDivider();
            $this->printDamageEventDescription($damageEvent->getDescription());
            $this->printDivider();
        }

        $damageCause = $liability->getDamageCause();
        if (!empty($damageCause)) {
            $this->printDamageCause($damageCause);
            $this->printDivider();
        }

        $witness = $liability->getWitness();
        $witnessTwo = $liability->getWitnessTwo();
        $this->addPageIfContentDontFit(35);
        $this->printWitnesses($witness,$witnessTwo);
        $this->printDivider();

        $policeRecording = $liability->getPoliceRecording();
        $this->printPoliceRecording($policeRecording,true);
        $this->printDivider();

        $claimant = $liability->getClaimant();
        $this->printClaimant($claimant);
        $this->printDivider();

        $this->printDamageItems($damageEvent,$liability);
        $this->printDivider();

        $personalInjury = $liability->getPersonalInjury();
        $this->printPersonalInjury($personalInjury);
        $this->printDivider();

        $payment = $liability->getPayment();
        $this->printPayment($payment);
        $this->printDivider();

        $this->printDate((new DateTime()));
    }

    private function printClaimant(?Claimant $claimant)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Anspruchsteller:','',0,'',1);

        $maxWidthForOneCells = $this->getMaxWidthForOneCells();
        $minWidthLabel = $this->getMinWidthLabel();

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Cell($minWidthLabel,0,'Name: ',self::DEBUG);
        $name = '';
        if (!empty($claimant))
            $name = $claimant->__toString();
        $this->Cell($maxWidthForOneCells,0,$name,self::DEBUG,1);

        $this->Cell($minWidthLabel,0,'Straße: ',self::DEBUG);
        $streetMailbox = '';
        if (!empty($claimant) && empty($streetMailbox))
            $streetMailbox = $claimant->getStreetMailbox();
        $this->Cell($maxWidthForOneCells,0,$streetMailbox,self::DEBUG,1);

        $this->Cell($minWidthLabel,0,'PLZ, Ort: ',self::DEBUG);
        $postCodeLocationString = $this->getPostCodeLocationString($claimant);
        $this->Cell($maxWidthForOneCells,0,$postCodeLocationString,self::DEBUG,1);

        $this->Cell($minWidthLabel,0,'Telefon: ',self::DEBUG);
        $phone = '';
        if (!empty($claimant) && !empty($phone))
            $phone = $claimant->getPhone();
        $this->Cell($maxWidthForOneCells,0,$phone,self::DEBUG,1);

        $claimantTyp = '';
        if (!empty($claimant)) {
            $claimantTyp = $claimant->getTyp();
            if (!empty($claimantTyp))
                $claimantTyp = $claimantTyp->getName();
        }
        $this->Write(0, 'Ist der Anspruchsteller: '.$claimantTyp,'',0,'',1);

        $kindOfRelationship = '';
        if (!empty($claimant) && !empty($kindOfRelationship))
            $kindOfRelationship = $claimant->getKindOfRelationship();
        $this->Write(
            0,
            'Art des Verwandtschafts-, Angestellten oder Vertragsverhältnisses: '.$kindOfRelationship,
            '',
            0,
            '',
            1
        );

        $isInDomesticCommunityWithMe = '';
        if (!empty($claimantTyp) && !empty($claimant->getIsInDomesticCommunityWithMe())) {
            $isInDomesticCommunityWithMe = $claimant->getIsInDomesticCommunityWithMe();
            if ($isInDomesticCommunityWithMe)
                $isInDomesticCommunityWithMe = 'ja';
            else
                $isInDomesticCommunityWithMe = 'nein';
        }
        $this->Write(
            0,
            'Lebt der Anspruchsteller mit Ihnen in häuslicher Gemeinschaft: '.$isInDomesticCommunityWithMe
        );
    }

    private function printDamageItems(?DamageEvent $damageEvent,Liability $liability)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Sachschäden (was wurde beschädigt):','',0,'',1);

        $maxWidthForTwoCells = $this->getMaxWidthForTwoCells();
        $minWidthLabel = $this->getMinWidthLabel();

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $itemsDamaged = '';
        if (!empty($damageEvent) && !empty($damageEvent->getItemsDamaged())) {
            $itemsDamaged = $damageEvent->getItemsDamaged();
        }
        $this->Write(0, $itemsDamaged,'',0,'',1);

        $this->Cell($maxWidthForTwoCells,0,'Ist eine Reparatur möglich?',self::DEBUG);
        $isRepairPossible = '';
        if (!empty($liability->getIsRepairPossible())) {
            $isRepairPossible = $liability->getIsRepairPossible();
            if ($isRepairPossible)
                $isRepairPossible = 'ja';
            else
                $isRepairPossible = 'nein';
        }
        $this->Cell($minWidthLabel,0,$isRepairPossible,self::DEBUG);

        $this->Cell($maxWidthForTwoCells,0,'Geschätzte Schadenhöhe:',self::DEBUG);
        $damageAmount = 0;
        if (!empty($damageEvent) && !empty($damageEvent->getDamageAmount()))
            $damageAmount = $damageEvent->getDamageAmount();
        $this->Cell(
            $minWidthLabel,
            0,
            number_format($damageAmount, 2, ",", ".").' EUR',
            self::DEBUG,
            1
        );

        $this->Cell($maxWidthForTwoCells+$minWidthLabel,0,'Hatten Sie die beschädigte Sache:',self::DEBUG);
        $typeOfOwnership = '';
        if (!empty($liability->getTypeOfOwnership())) {
            $typeOfOwnership = $liability->getTypeOfOwnership();
            if (!empty($typeOfOwnership))
                $typeOfOwnership = $typeOfOwnership->getName();
        }
        $this->Cell($maxWidthForTwoCells,0,$typeOfOwnership,self::DEBUG);
    }

    private function printPersonalInjury(?PersonalInjury $personalInjury)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Personenschäden:','',0,'',1);

        $maxWidthForTwoCells = $this->getMaxWidthForTwoCells();

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Cell($maxWidthForTwoCells,0,'Wer wurde verletzt:',self::DEBUG);
        $who = '';
        if (!empty($personalInjury))
            $who = $personalInjury->__toString();
        $this->Cell(0,0,$who,self::DEBUG,1);
        $this->Cell($maxWidthForTwoCells,0,'Welche Verletzungen:',self::DEBUG);
        $injuries = '';
        if (!empty($personalInjury) && !empty($personalInjury->getInjuries()))
            $injuries = $personalInjury->getInjuries();
        $this->Cell(0,0,$injuries,self::DEBUG);
    }
}