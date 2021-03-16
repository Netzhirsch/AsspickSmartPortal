<?php


namespace App\PDF;


use App\Entity\DamageCase\Car\AccidentOpponent;
use App\Entity\DamageCase\Car\Driver;
use App\Entity\DamageCase\Part\Claimant\Claimant;
use App\Entity\DamageCase\Part\Damage\DamageCause;
use App\Entity\DamageCase\Part\Damage\DamageEvent;
use App\Entity\DamageCase\Part\Insurer;
use App\Entity\DamageCase\Part\Payment;
use App\Entity\DamageCase\Part\PoliceRecording;
use App\Entity\DamageCase\Part\Policyholder;
use App\Entity\DamageCase\Part\Witness;
use DateTime;
use TCPDF;

class PDF extends TCPDF
{
    const MARGIN_TOP = 50;
    // GESAMTBREITE = 210 - 25 - 20 = 165
    const MARGIN_LEFT = 25;
    const MARGIN_RIGHT = 20;
    const MARGIN_BOTTOM = 40;
    const SPACING_HEADER = 15;
    const WIDTH_COL_ONE = 47;
    const WIDTH_COL_TWO = 47;
    const WIDTH_COL_THREE = 47;
    const FONT_FAMILY = 'dejavusans';
    const FONT_FAMILY_BOLD = 'dejavusansb';
    const FONT_SIZE = 10;
    const FONT_SIZE_BIG = 12;
    const FONT_SIZE_TITEL = 15;
    const DEBUG = 0;

    public function __construct() {
        parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false, true);
        $this->SetAutoPageBreak(true, self::MARGIN_BOTTOM);
        $this->SetMargins(self::MARGIN_LEFT, self::MARGIN_TOP, self::MARGIN_RIGHT);
        $this->setCellPaddings(0, 0, 0, 0);
        $this->SetFont(self::FONT_FAMILY,'',self::FONT_SIZE);
    }

    public function Header() {
        $this->printLogo();
        $this->printContactHeader();
    }

    private function printLogo(){
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pfad = dirname(__DIR__, 2);
        $img = file_get_contents($pfad . '/assets/logo.png');

        $this->Image
        (
            '@'.$img,
            self::MARGIN_LEFT,
            self::SPACING_HEADER,
            80,
            0,
            "",
            'https://www.asspick.de/'
        );
    }

    private function printContactHeader()
    {
        $this->SetY(self::SPACING_HEADER);
        $this->Write(0,'schaden@asspick','mailto:schaden@asspick.de',0,'R',1);
        $this->Write(0,'Fax: 0451/98913-581','',0,'R');
    }

    protected function printTitel($titel){
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE_TITEL);
        $this->Write(0,$titel,'',0,'R',1);
    }

    protected function printInsurer(Insurer $insurer){
        $oneFourth = $this->getMaxContentWidth() / 4;
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $minWidthLabel = $this->getMinWidthLabel();
        $this->Cell($minWidthLabel, 0, 'Versicherer: ',self::DEBUG);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Cell($oneFourth, 0, $insurer->getName(),self::DEBUG);
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $minWidthLabel = $oneFourth + 14;
        $this->Cell($minWidthLabel, 0, 'Versicherungsschein-',self::DEBUG,2);
        $this->Cell($minWidthLabel, 0, ' oder Schaden-Nummer:',self::DEBUG);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $number = $insurer->getInsuranceNumber();
        if (empty($number))
            $number = $insurer->getDangerNumber();
        $this->Cell($oneFourth, 0, $number,self::DEBUG,1,'R');
    }

    protected function printPolicyholder(?Policyholder $policyholder) {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Versicherungsnehmer:','',0,'',1);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $minWidthLabel = $this->getMinWidthLabel();
        $maxWidthValue = $this->getMaxWidthForOneCells();
        $this->Cell($minWidthLabel, 0, 'Name:',self::DEBUG);
        $name = '';
        if (!empty($policyholder))
            $name = $policyholder->__toString();
        $this->Cell($maxWidthValue, 0, $name,self::DEBUG,1);

        $this->Cell($minWidthLabel, 0, 'Straße:',self::DEBUG);
        $streetMailbox = '';
        if (!empty($policyholder) && !empty($policyholder->getStreetMailbox()))
                $streetMailbox = $policyholder->getStreetMailbox();
        $this->Cell($maxWidthValue, 0, $streetMailbox,self::DEBUG,1);

        $this->Cell($minWidthLabel, 0, 'PLZ, Ort:',self::DEBUG);
        $postCodeLocation = $this->getPostCodeLocationString($policyholder);
        $this->Cell(
            $maxWidthValue,
            0,
            $postCodeLocation,
            self::DEBUG,
            1
        );
        $this->Cell($minWidthLabel, 0, 'Telefon:',self::DEBUG);
        $maxWidthValue = $this->getMaxWidthForTwoCells();
        $phone = '';
        if (!empty($policyholder) && !empty($policyholder->getPhone()))
            $phone = $policyholder->getPhone();
        $this->Cell($maxWidthValue, 0, $phone,self::DEBUG);

        $this->Cell($minWidthLabel, 0, 'Mail:',self::DEBUG);
        $mail = '';
        if (!empty($policyholder) && !empty($policyholder->getEmail()))
            $mail = $policyholder->getEmail();
        $this->Cell($maxWidthValue, 0, $mail,self::DEBUG);
    }


    protected function printDamageEvent(?DamageEvent $damageEvent)
    {
        $maxWidthForTwoCells = $this->getMaxWidthForTwoCells();
        $minWidthLabel = $this->getMinWidthLabel();

        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Schadenereignis:','',0,'',1);

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Cell($minWidthLabel, 0, 'Schadentag:',self::DEBUG);
        $dateString = '';
        if (!empty($damageEvent) && !empty($damageEvent->getDate())) {
            $date = $damageEvent->getDate();
            $dateString = $date->format('d.m.Y');
        }
        $this->Cell($maxWidthForTwoCells, 0, $dateString, self::DEBUG);

        $this->Cell($minWidthLabel, 0, 'Schadenzeit:',self::DEBUG);
        $timeString = '';
        if (!empty($damageEvent) && !empty($damageEvent->getTime())) {
            $time = $damageEvent->getTime();
            $timeString = $time->format('H:i');
        }
        $this->Cell($maxWidthForTwoCells, 0, $timeString, self::DEBUG, 1);

        $this->Cell($minWidthLabel, 0, 'Schadenort:',self::DEBUG);
        $location = '';
        if (!empty($damageEvent) && !empty($damageEvent->getLocation()))
            $location = $damageEvent->getLocation();
        $this->Cell(0, 0, $location, self::DEBUG, 1);

        $this->Cell($minWidthLabel, 0, '',self::DEBUG);
        $location = '';
        if (!empty($damageEvent) && !empty($damageEvent->getLocationTwo()))
            $location = $damageEvent->getLocationTwo();
        $this->Cell(0, 0, $location, self::DEBUG, 1);
    }

    protected function printDamageEventDescription(?string $description)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Schadenschilderung:','',0,'',1);
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        if (!empty($description))
            $this->Write(0,$description);
    }

    protected function printDamageCause(DamageCause $cause)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(
            0,
            'Schadenverursacher (Bei Kindern bitte auch das Geburtsdatum):',
            '',
            0,
            '',
            1
        );

        $minWidthLabel = $this->getMinWidthLabel();
        $widthForOneCells = $this->getMaxWidthForOneCells();
        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);

        $this->Cell($minWidthLabel, 0, 'Name:',self::DEBUG);
        $name = $cause->__toString();
        $this->Cell($widthForOneCells, 0, $name,self::DEBUG,1);

        $this->Cell($minWidthLabel, 0, 'Straße:',self::DEBUG);
        $streetMailBox = $cause->getStreetMailbox();
        if (empty($streetMailBox))
            $streetMailBox = '';
        $this->Cell($widthForOneCells, 0, $streetMailBox,self::DEBUG,1);

        $this->Cell($minWidthLabel, 0, 'PLZ, Ort:',self::DEBUG);
        $postCodeLocation = $this->getPostCodeLocationString($cause);
        $this->Cell(
            $widthForOneCells,
            0,
            $postCodeLocation,
            self::DEBUG,
            1
        );

        $this->Cell($minWidthLabel, 0, 'Telefon:',self::DEBUG);
        $maxWidthValue = $this->getMaxWidthForTwoCells()+30;
        $this->Cell($maxWidthValue, 0, $cause->getPhone(),self::DEBUG);

        $this->Cell($minWidthLabel+5, 0, 'Geburtsdatum:',self::DEBUG);
        $dateOfBirth = $cause->getDateOfBirth();
        $dateOfBirthString = '';
        if (empty($dateOfBirth))
            $dateOfBirthString = $dateOfBirth->format('d.m.Y');
        $maxWidthValue -= 65;
        $this->Cell($maxWidthValue, 0, $dateOfBirthString,self::DEBUG);


    }

    protected function printWitnesses(?Witness $witness,?Witness $witnessTwo)
    {
        $maxWidthForTwoCells = $this->getMaxWidthForTwoCells();
        $minWidthLabel = $this->getMinWidthLabel();

        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Zeugen:','',0,'',1);

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        $this->Cell($minWidthLabel, 0, 'Name:',self::DEBUG);
        $name = '';
        if (!empty($witness))
            $name = $witness->__toString();
        $this->Cell($maxWidthForTwoCells, 0, $name, self::DEBUG);

        $maxWidthForTwoCellsNoSecondLabel = $maxWidthForTwoCells + $minWidthLabel-5;
        $this->Cell(5, 0, '',self::DEBUG);
        $name = '';
        if (!empty($witnessTwo))
            $name = $witnessTwo->__toString();
        $this->Cell($maxWidthForTwoCellsNoSecondLabel, 0, $name, self::DEBUG, 1);

        $this->Cell($minWidthLabel, 0, 'Straße:',self::DEBUG);
        $streetMailbox = '';
        if (!empty($witness) && !empty($witness->getStreetMailbox()))
            $streetMailbox = $witness->getStreetMailbox();
        $this->Cell($maxWidthForTwoCells, 0, $streetMailbox, self::DEBUG);
        $this->Cell(5, 0, '',self::DEBUG);
        $streetMailbox = '';
        if (!empty($witnessTwo) && !empty($witnessTwo->getStreetMailbox()))
            $streetMailbox = $witnessTwo->getStreetMailbox();
        $this->Cell($maxWidthForTwoCellsNoSecondLabel, 0, $streetMailbox, self::DEBUG, 1);

        $this->Cell($minWidthLabel, 0, 'PLZ, Ort:',self::DEBUG);
        $postCodeLocation = $this->getPostCodeLocationString($witness);
        $this->Cell($maxWidthForTwoCells, 0, $postCodeLocation, self::DEBUG);
        $this->Cell(5, 0, '',self::DEBUG);
        $postCodeLocation = $this->getPostCodeLocationString($witnessTwo);
        $this->Cell($maxWidthForTwoCellsNoSecondLabel, 0, $postCodeLocation, self::DEBUG, 1);

        $this->Cell($minWidthLabel, 0, 'Telefon:',self::DEBUG);
        $phone = '';
        if (!empty($witness) && !empty($phone))
            $phone = $witness->getPhone();
        $this->Cell($maxWidthForTwoCells, 0, $phone, self::DEBUG);
        $this->Cell(5, 0, '',self::DEBUG);
        $phone = '';
        if (!empty($witness) && !empty($phone))
            $phone = $witness->getPhone();
        $this->Cell($maxWidthForTwoCellsNoSecondLabel, 0, $phone, self::DEBUG);

    }


    protected function printPoliceRecording(?PoliceRecording $policeRecording,$long = false,$car= false)
    {
        $minWidthLabel = $this->getMinWidthLabel();
        $maxWidthForOneCells = $this->getMaxWidthForOneCells();

        $isRecorded = 'polizeiliche Aufnahme: ';
        if (!empty($policeRecording)) {
            $isRecorded = $policeRecording->getIsRecorded();
            if ($isRecorded)
                $isRecorded = 'ja';
            else
                $isRecorded = 'nein';

            $isRecorded = 'polizeiliche Aufnahme: '.$isRecorded;
        }
        $this->Write( 0, $isRecorded,'',0,'',1);

        $department = '';
        if (!empty($policeRecording) && !empty($policeRecording->getDepartment()))
            $department = $policeRecording->getDepartment();
        $this->Cell($minWidthLabel,0,'Dienststelle:',self::DEBUG);
        $this->MultiCell(0,0,$department,0,'',0);
        $this->Cell($minWidthLabel,0,'Aktenzeichen: ',self::DEBUG);
        $fileReference = '';
        if (!empty($policeRecording) && !empty($fileReference))
            $fileReference = $policeRecording->getFileReference();
        $this->Cell($maxWidthForOneCells,0,$fileReference,self::DEBUG,1);
        $this->Cell($minWidthLabel,0,'Tagebuch-Nr: ',self::DEBUG);
        $diaryNumber = '';
        if (!empty($policeRecording) && !empty($diaryNumber))
            $diaryNumber = $policeRecording->getDiaryNumber();
        $this->Cell($maxWidthForOneCells,0,$diaryNumber,self::DEBUG,1);

        if ($long) {
            $hasCriminalProceedings = '';
            if (!empty($policeRecording)) {
                $hasCriminalProceedings = $policeRecording->getHasCriminalProceedings();
                if ($hasCriminalProceedings)
                    $hasCriminalProceedings = 'ja';
                else
                    $hasCriminalProceedings = 'nein';
            }

            $this->Cell(82, 0,'Wurde ein Strafverfahren eingeleitet?',self::DEBUG);
            $this->Cell($minWidthLabel, 0,$hasCriminalProceedings,self::DEBUG);
            $this->Cell(25, 0,'gegen wenn:',self::DEBUG);
            $against = [];
            if (!empty($policeRecording)) {
                $criminalProceedingsAgainst = $policeRecording->getCriminalProceedingsAgainst();
                foreach ($criminalProceedingsAgainst as $againstTyp) {
                    $against[] = $againstTyp->getName();
                }
            }
            $this->Cell(0, 0,implode(', ', $against),self::DEBUG);
        }
        if ($car) {
            $this->Ln();
            $this->Cell(82, 0,'Wurden jemand gebührenpflichtig verwarnt?',self::DEBUG);
            $warnedWithCharge = '';
            if (!empty($policeRecording) && !empty($policeRecording->getIsWarnedWithCharge())) {
                if ($policeRecording->getIsWarnedWithCharge())
                    $warnedWithCharge = 'ja';
                else
                    $warnedWithCharge = 'nein';
            }
            $this->Cell($minWidthLabel, 0,$warnedWithCharge,self::DEBUG);

            $this->Cell(25, 0,'wer:',self::DEBUG);
            $against = [];
            if (!empty($policeRecording)) {
                $whoIsWarnedWithCharge = $policeRecording->getWhoIsWarnedWithCharge();
                foreach ($whoIsWarnedWithCharge as $againstTyp) {
                    $against[] = $againstTyp->getName();
                }
            }
            $this->Cell(0, 0,implode(', ', $against),self::DEBUG,1);

            $this->Cell(82, 0,'Alkohol-/Drogengenuss?',self::DEBUG);
            $drug = '';
            if (!empty($policeRecording) && !empty($policeRecording->getHasDrugUse())) {
                if ($policeRecording->getHasDrugUse())
                    $drug = 'ja';
                else
                    $drug = 'nein';
            }
            $this->Cell($minWidthLabel, 0,$drug,self::DEBUG);
            $this->Cell(40, 0,'Alkohol-/Drogentest:',self::DEBUG);
            $drugTest = '';
            if (!empty($policeRecording) && !empty($policeRecording->getHasDrugTest())) {
                if ($policeRecording->getHasDrugTest())
                    $drugTest = 'ja';
                else
                    $drugTest = 'nein';
            }
            $this->Cell($minWidthLabel, 0,$drugTest,self::DEBUG,1);
            $this->Cell($minWidthLabel,0,'Ergebnis:', self::DEBUG);
            $result = '';
            if (!empty($policeRecording) && !empty($policeRecording->getDrugTestResult())) {
                $result = number_format(
                    $policeRecording->getDrugTestResult(),
                    2,
                    ",",
                    "."
                );
            }
            $this->Cell(0, 0,$result,self::DEBUG);
        }
    }

    protected function printPayment(?Payment $payment)
    {
        $this->SetFont(self::FONT_FAMILY_BOLD,'',PDF::FONT_SIZE);
        $this->Write(0, 'Zahlungen:','',0,'',1);

        $maxWidthForTwoCells = $this->getMaxWidthForTwoCells();
        $minWidthLabel = $this->getMinWidthLabel();

        $this->SetFont(self::FONT_FAMILY,'',PDF::FONT_SIZE);
        if (!empty($payment) && !empty($payment->getTransferTo())) {
            $this->Write(0, 'Überweisung '.$payment->getTransferTo()->getName(),'',0,'',1);
            $this->Ln();
        }

        $this->Cell($minWidthLabel,0,'Bank: ',self::DEBUG);
        $bank = '';
        if (!empty($payment) && !empty($payment->getBank()))
            $bank = $payment->getBank();
        $this->Cell($maxWidthForTwoCells,0,$bank,self::DEBUG);

        $this->Cell($minWidthLabel,0,'Ort: ',self::DEBUG);
        $location = '';
        if (!empty($payment) && !empty($payment->getLocation()))
            $location = $payment->getLocation();
        $this->Cell($maxWidthForTwoCells,0,$location,self::DEBUG,1);

        $this->Cell($minWidthLabel,0,'IBAN: ',self::DEBUG);
        $iban = '';
        if (!empty($payment) && !empty($payment->getIban()))
            $iban = $payment->getIban();
        $this->Cell($maxWidthForTwoCells,0,$iban,self::DEBUG);

        $this->Cell($minWidthLabel,0,'BIC: ',self::DEBUG);
        $bic = '';
        if (!empty($payment) && !empty($payment->getBic()))
            $bic = $payment->getBic();
        $this->Cell($maxWidthForTwoCells,0,$bic,self::DEBUG,1);

        $this->Cell($minWidthLabel,0,'Kontoinhaber: ',self::DEBUG);
        $accountHolder = '';
        if (!empty($payment) && !empty($payment->getAccountHolder()))
            $accountHolder = $payment->getAccountHolder();
        $this->Cell(0,0,$accountHolder,self::DEBUG,1);

        $this->Ln();
        $this->Cell($maxWidthForTwoCells,0,'Vorsteuerabzugsberechtigung: ',self::DEBUG);
        $taxDeduction = '';
        if (!empty($payment) && !empty($payment->getHasInputTaxDeduction()) && $payment->getHasInputTaxDeduction())
            $taxDeduction = 'ja';
        elseif (!empty($payment) && !empty($payment->getHasInputTaxDeduction()) && !$payment->getHasInputTaxDeduction())
            $taxDeduction = 'nein';
        $this->Cell(0,0,$taxDeduction,self::DEBUG,1);

    }


    protected function printDivider($heightOfNextContent = 35) {
        $isPageAdded = $this->addPageIfContentDontFit($heightOfNextContent);
        if ($isPageAdded)
            return;

        $this->Ln();
        $this->Ln();
        $this->Line(self::MARGIN_LEFT, $this->GetY(), 190, $this->GetY());
        $this->Ln();
    }

    protected function getMaxWidthForOneCells(){
        return $this->getMaxContentWidth()-$this->getMinWidthLabel();
    }

    protected function getMaxWidthForTwoCells(){
        return ($this->getMaxContentWidth()-($this->getMinWidthLabel()*2))/2;
    }

    protected function getMaxContentWidth(): int
    {
        return $this->getPageWidth() - self::MARGIN_LEFT - self::MARGIN_RIGHT;
    }

    protected function getMinWidthLabel($cols = 4){
        $oneFourth = $this->getMaxContentWidth() / $cols;
        return $oneFourth - 14;
    }

    /**
     * @param null|DamageCause|Witness|Policyholder|Claimant|Driver|AccidentOpponent $entity
     * @return string
     */
    protected function getPostCodeLocationString($entity): string
    {
        $postCodeLocation = '';
        if (!empty($entity) && !empty($entity->getPostCode())) {
            $postCode = $entity->getPostCode();
            $postCodeLocation .= $postCode;
        }
        $location = '';
        if (!empty($entity) && !empty($entity->getLocation()) && !empty($postCode)) {
            $location = $entity->getLocation();
            $postCodeLocation .= ', ';
        }
        $postCodeLocation .= $location;

        return $postCodeLocation;
    }

    protected function addPageIfContentDontFit($heightOfContent): bool
    {
        $pageHeight = $this->getPageHeight()-self::MARGIN_TOP;
        $heightOfThisComingCells = $heightOfContent;
        if ($this->GetY() + $heightOfThisComingCells > $pageHeight) {
            $this->AddPage();
            return true;
        }
        return false;
    }

    protected function printDate(DateTime $date)
    {
        $this->Write(0, 'Datum: ');
        $this->Write(0, $date->format('d.m.Y'));
    }

}