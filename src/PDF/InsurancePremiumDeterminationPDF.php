<?php


namespace App\PDF;


use App\Entity\InsurancePremiumDetermination;

class InsurancePremiumDeterminationPDF extends PDF
{
    const GREY = [
        'r' => '237',
        'g' => '239',
        'b' => '243'
    ];

    public function create(InsurancePremiumDetermination $insurancePremiumDetermination, array $parameters)
    {
        $this->SetMargins(self::MARGIN_LEFT, self::MARGIN_TOP, self::MARGIN_RIGHT);

        $this->AddPage();

        $this->printTitel('BVAW Gebäude');
        $this->printDivider(true);

        $this->printPerson($insurancePremiumDetermination);
        $this->printDivider();

        $this->printSumsInsured($insurancePremiumDetermination);


        $this->Write(0, 'Anzahl WE: ');
        $this->Write(0, $insurancePremiumDetermination->getNumberOfCommerciallyUsedUnits(),'',false,'',1);

        $this->Write(0, 'Anzahl GE: ');
        $this->Write(0, $insurancePremiumDetermination->getNumberOfResidentialUnits(),'',false,'',1);


        $this->Write(0, 'Größe Öltank: ');
        $this->Write(0, $insurancePremiumDetermination->getOilTankSize(),'',false,'',1);
        $this->Ln();

        $this->printResult($parameters);


    }

    /**
     * @param InsurancePremiumDetermination $insurancePremiumDetermination
     */
    protected function printPerson(InsurancePremiumDetermination $insurancePremiumDetermination)
    {
        $salutation = '-';
        $options = array_flip(InsurancePremiumDetermination::getSalutationOptions());
        if (!empty($insurancePremiumDetermination->getSalutation())) {
            $salutation = $options[$insurancePremiumDetermination->getSalutation()];
        }

        $this->SetFont(self::FONT_FAMILY, '', 9);
        $this->Write(0, $salutation, '', false, '', 1);
        $this->Write(0, $insurancePremiumDetermination->getFirstName());
        $this->Write(0, ' ');
        $this->Write(0, $insurancePremiumDetermination->getLastName(), '', false, '', 1);
        $this->Write(0, $insurancePremiumDetermination->getStreet(), '', false, '', 1);
        $this->Write(0, $insurancePremiumDetermination->getZipcode());
        $this->Write(0, ' ');
        $this->Write(0, $insurancePremiumDetermination->getCity(), '', false, '', 1);


        $payment = '-';
        $options = array_flip(InsurancePremiumDetermination::getPaymentMethods());
        if (!empty($insurancePremiumDetermination->getPaymentMethod())) {
            $payment = $options[$insurancePremiumDetermination->getPaymentMethod()];
        }
        $this->Write(0, 'Zahlart: ');
        $this->Write(0, $payment, '', false, '', 1);
    }

    /**
     * @param InsurancePremiumDetermination $insurancePremiumDetermination
     */
    protected function printSumsInsured(InsurancePremiumDetermination $insurancePremiumDetermination): void
    {
        $modus = '-';
        $options = array_flip(InsurancePremiumDetermination::getModeOptions());
        if (!empty($insurancePremiumDetermination->getMode())) {
            $modus = $options[$insurancePremiumDetermination->getMode()];
        }
        $this->Write(0, 'Modus: ');
        $this->Write(0, $modus, '', false, '', 1);
        $this->Ln(2);
        $maxContentWidth = $this->getMaxContentWidth();
        $maxPerCol = $maxContentWidth / 6;

        $this->Cell($maxPerCol, 0, 'VS 1914', self::DEBUG);
        $this->Cell($maxPerCol, 0, $insurancePremiumDetermination->getSumInsured(), self::DEBUG);
        $this->Cell($maxPerCol, 0, 'VS 2000', self::DEBUG);
        $this->Cell($maxPerCol, 0, $insurancePremiumDetermination->getSumInsuredVs(), self::DEBUG, 1);

        $this->Cell($maxPerCol, 0, 'Wert aktuell', self::DEBUG);
        $this->Cell($maxPerCol, 0, $insurancePremiumDetermination->getCurrentValue(), self::DEBUG);
        $this->Cell($maxPerCol, 0, 'VS 2000', self::DEBUG);
        $this->Cell($maxPerCol, 0, $insurancePremiumDetermination->getCurrentValueVs(), self::DEBUG, 1);

        $this->Cell($maxPerCol, 0, 'VS 2000', self::DEBUG);
        $this->Cell($maxPerCol, 0, $insurancePremiumDetermination->getSumInsured(), self::DEBUG);
        $this->Cell($maxPerCol, 0, 'VS aktuell', self::DEBUG);
        $this->Cell($maxPerCol, 0, $insurancePremiumDetermination->getSumInsuredVs(), self::DEBUG, 1);
    }

    private function printResult(array $parameters)
    {
        $this->printTitel('Ergebnis');
        $this->printDivider(true);

        [$cols, $aligns] = $this->setDefaults();

        $isToTall = $this->printCol(false,true, false, [
            'Gebäudedeckung',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €¹'
        ], $cols,$aligns);


        $isToTall = $this->printCol($isToTall,false, false, [
            'Mindestbeitrag 120 €',
            $parameters['gebaeudedeckung_mindestbeitrag_netto'],
            'ohne Glas  ',
            $parameters['gebaeudedeckung_mindestbeitrag_faktor'],
            $parameters['gebaeudedeckung_mindestbeitrag_brutto']
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, true, [
            'inklusiv Graffiti (SB 200 €)',
            $parameters['gebaeudedeckung_inklusive_graffiti_netto'],
            'mit Glas allg.  ',
            $parameters['gebaeudedeckung_inklusive_graffiti_faktor'],
            $parameters['gebaeudedeckung_inklusive_graffiti_brutto']
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'inklusive Verzicht auf grobe Fahrlässigkeit bis 50 €',
            $parameters['gebaeudedeckung_inklusive_verzicht_netto'],
            'mit Glas allg.  ',
            $parameters['gebaeudedeckung_inklusive_verzicht_faktor'],
            $parameters['gebaeudedeckung_inklusive_verzicht_brutto']
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,true, false, [
            'Gebäudedeckung mit innerer Unruhe',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €¹',
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'inklusive mut-/böswilliger Beschädigungen (SB 500 €)',
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_netto'],
            'ohne Glas  ',
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_faktor'],
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_1_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, true, [
            '',
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_netto'],
            'mit Glas allg.  ',
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_faktor'],
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_2_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            '',
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_netto'],
            'mit Glas ges.  ',
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_faktor'],
            $parameters['gebaeudedeckung_mit_unruhe_inklusive_beschaedigung_3_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,true, false, [
            'Gebäudedeckung mit Elementar',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €¹',
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'Zürs Zone 1 und 2 (SB 500€)',
            $parameters['gebaeudedeckung_mit_elementar_1_netto'],
            'ohne Glas  ',
            $parameters['gebaeudedeckung_mit_elementar_1_faktor'],
            $parameters['gebaeudedeckung_mit_elementar_1_netto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, true, [
            '',
            $parameters['gebaeudedeckung_mit_elementar_2_netto'],
            'mit Glas allg.  ',
            $parameters['gebaeudedeckung_mit_elementar_2_faktor'],
            $parameters['gebaeudedeckung_mit_elementar_2_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            '',
            $parameters['gebaeudedeckung_mit_elementar_3_netto'],
            'mit Glas allg.  ',
            $parameters['gebaeudedeckung_mit_elementar_3_faktor'],
            $parameters['gebaeudedeckung_mit_elementar_3_brutto'],
        ], $cols,$aligns);

        $this->AddPage();

        $isToTall = $this->printCol($isToTall,true, false, [
            'Gebäudedeckung komplett',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €¹',
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'inklusive innerer Unruhe und Elementarschäden',
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_1_netto'],
            'ohne Glas  ',
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_1_faktor'],
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_1_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, true, [
            '',
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_2_netto'],
            'mit Glas allg.  ',
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_2_faktor'],
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_2_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            '',
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_3_netto'],
            'mit Glas ges.  ',
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_3_faktor'],
            $parameters['gebaeudedeckung_komplett_ohne_gefahren_3_brutto'],
        ], $cols,$aligns);


        $isToTall = $this->printCol($isToTall,false, false, [
            'inklusive unben. Gefahren (SB 500)',
            $parameters['gebaeudedeckung_komplett_mit_gefahren_1_netto'],
            'ohne Glas  ',
            $parameters['gebaeudedeckung_komplett_mit_gefahren_1_faktor'],
            $parameters['gebaeudedeckung_komplett_mit_gefahren_1_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, true, [
            '',
            $parameters['gebaeudedeckung_komplett_mit_gefahren_2_netto'],
            'mit Glas allg.  ',
            $parameters['gebaeudedeckung_komplett_mit_gefahren_2_faktor'],
            $parameters['gebaeudedeckung_komplett_mit_gefahren_2_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            '',
            $parameters['gebaeudedeckung_komplett_mit_gefahren_3_netto'],
            'mit Glas ges.  ',
            $parameters['gebaeudedeckung_komplett_mit_gefahren_3_faktor'],
            $parameters['gebaeudedeckung_komplett_mit_gefahren_3_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,true, false, [
            'Bauleistungsversicherung',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €²',
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'MB 250 € (SB 250 €)',
            $parameters['bauleistungsversicherung_1_netto'],
            'ohne Feuer  ',
            $parameters['bauleistungsversicherung_1_faktor'],
            $parameters['bauleistungsversicherung_1_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, true, [
            '',
            $parameters['bauleistungsversicherung_2_netto'],
            'mit Feuer  ',
            $parameters['bauleistungsversicherung_2_faktor'],
            $parameters['bauleistungsversicherung_2_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,true, false, [
            'Bauherrenhaftpflicht für EFH',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €²',
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'MB 50 €, bei MFH beitragsfrei in HuG-HV',
            $parameters['bauherrenhaftpflicht_netto'],
            '12,5 Mio  ',
            $parameters['bauherrenhaftpflicht_faktor'],
            $parameters['bauherrenhaftpflicht_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,true, false, [
            'Haus- und Grundbesitzerhaftpflicht',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €²',
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'WE 4 € / GE 8 € / MB 50 € inklusive Bauherren-HV',
            $parameters['haus_und_grundbesitzerhaftpflicht_1_netto'],
            '5 Mio  ',
            '',
            $parameters['haus_und_grundbesitzerhaftpflicht_1_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, true, [
            'WE 5 € / GE 10 € / MB 59 € inklusive Bauherren-HV',
            $parameters['haus_und_grundbesitzerhaftpflicht_2_netto'],
            '10 Mio  ',
            '',
            $parameters['haus_und_grundbesitzerhaftpflicht_2_brutto'],
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,true, false, [
            'Gewässerschadenhaftpflicht',
            'Nettobeitrag in €',
            '',
            '',
            'Bruttobeitrag in €²',
        ], $cols,$aligns);

        $isToTall = $this->printCol($isToTall,false, false, [
            'ober- und unterirdische Tankanlagen',
            $parameters['gewaesserschadenhaftpflicht_1_netto'],
            '5 Mio  ',
            '',
            $parameters['gewaesserschadenhaftpflicht_1_brutto'],
        ], $cols,$aligns);

        $this->printCol($isToTall,false, true, [
            'bis 10t, bis 30t, bis 50t, bis 100t',
            $parameters['gewaesserschadenhaftpflicht_2_netto'],
            '10 Mio  ',
            '',
            $parameters['gewaesserschadenhaftpflicht_2_brutto'],
        ], $cols,$aligns);

        $this->Ln();
        $this->SetFont(self::FONT_FAMILY, '', 7);
        $this->Write(0, '1. inkl. Vers.St. 16,34%');
        $this->Ln(3);
        $this->Write(0, '2. inkl. Vers.St. 19,00%');

    }

    private function printCol(bool $isToTall,bool $isTh,bool $fill,array $texts,array $cols,array $aligns): bool
    {
        if ($isToTall)
            $this->Ln(2);

        $this->SetFont(self::FONT_FAMILY, '', 8);
        if ($isTh) {
            $this->SetFont(self::FONT_FAMILY_BOLD, '', 8);
        }

        $x = self::MARGIN_RIGHT+5;
        $isToTall = false;
        $minHeight = 0;
        foreach ($texts as $key => $text) {
            $this->MultiCell($cols[$key], $minHeight, $text, self::DEBUG,$aligns[$key],$fill,0,$x,$this->GetY());
            $x += $cols[$key];
            $height = $this->getStringHeight($cols[$key], $text);
            if ($height >= 6) {
                $minHeight = $height;
                $isToTall = true;
            }
        }


        $this->Ln();
        if ($isTh)
            $this->Line(
                self::MARGIN_LEFT,
                $this->GetY(),
                190,
                $this->GetY(),
                [
                    'width' => 0.5,
                    'cap' => 'butt',
                    'join' => 'miter',
                    'dash' => '2,2,2,2',
                    'phase' => 10,
                    'color' => self::GREY,
                ]
            );

        return $isToTall;
    }

    private function printDivider($isTitel = false) {
        if ($isTitel)
            $this->Ln(2);
        else
            $this->Ln();
        $this->Line(self::MARGIN_LEFT, $this->GetY(), 190, $this->GetY());
        $this->Ln();
    }/**
 * @return array
 */
    private function setDefaults(): array
    {
        $cols = [
            65,
            30,
            25,
            10,
            35
        ];
        $aligns = [
            'L',
            'R',
            'R',
            'L',
            'R',
        ];
        $this->SetFillColor(self::GREY['r'],self::GREY['g'],self::GREY['b']);
        $this->setCellPaddings(1, 1, 1, 1);

        return array($cols, $aligns);
    }

}