<?php


namespace App\PDF;


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