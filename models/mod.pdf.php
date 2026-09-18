<?php

require_once '../libs/PDF/tcpdf_6_0_093/config/lang/eng.php';
require_once '../libs/PDF/tcpdf_6_0_093/config/lang/jpn.php';
require_once '../libs/PDF/tcpdf_6_0_093/tcpdf.php';

class PrintPDF extends TCPDF
{
//    protected $fontPath = "../libs/PDF/tcpdf_6_0_093/PDF/fonts/rcjfont_src/";
    protected $footerInfo = array();
    protected $headerInfo = array();

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    public function setFooterInfo($footerData = array())
    {
        $this->footerInfo = $footerData;
    }

    public function setHeaderInfo($headerData = array())
    {
        $this->headerInfo = $headerData;
    }

    public function setFontPath($fontPath)
    {
        $this->fontPath = $fontPath;
    }

    public function getFontPath()
    {
        return $this->fontPath;
    }

    public function printFooter()
    {
        $this->SetY(-16);
        $fontname = $this->addTTFfont($this->fontPath . 'RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);
        $this->SetFont($fontname, '', 7);
        $this->Cell(0, 10, $this->footerInfo["WHName"], 0, 'T', 'R', 0, '', 0, false, 'T', 'M');
        $this->SetY(-13);
        $fontname = $this->addTTFfont($this->fontPath . 'RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);
        $this->SetFont($fontname, '', 7);
        $this->Cell(0, 10, $this->footerInfo["WHAddress"], 0, 'T', 'R', 0, '', 0, false, 'T', 'M');
        $this->SetY(-10);
        $fontname = $this->addTTFfont($this->fontPath . 'RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);
        $this->SetFont($fontname, '', 7);
        $this->Cell(0, 10, $this->footerInfo["WHTelNo"], 0, 'T', 'R', 0, '', 0, false, 'T', 'M');
    }

    public function printHeader()
    {
        //print_r($this->headerInfo);
        //Do print header
    }

    public function AutoPrint($dialog = false)
    {
        //Open the print dialog or start printing immediately on the standard printer
        $param = ($dialog ? 'true' : 'false');
        $script = "print($param);";
        $this->IncludeJS($script);
    }

  

}

?>
