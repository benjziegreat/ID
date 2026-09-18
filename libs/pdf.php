<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('PHPExcel/Classes/PHPExcel/Shared/PDF/config/lang/eng.php');
require_once('PHPExcel/Classes/PHPExcel/Shared/PDF/tcpdf.php');	

class Pdf extends FPDF{
    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }
    
    var $fontPath="PHPExcel/Classes/PHPExcel/Shared/PDF/fonts/rcjfont_src/";
    var $footerInfo=array();
    var $headerInfo=array();
    
    function setFooterInfo($footerInfo){
	$this->footerInfo=$footerInfo;
    }
    
    function setHeaderInfo($headerInfo){
	$this->footerInfo=$footerInfo;
    }
						
    public function setFontPath($fontPath="PHPExcel/Classes/PHPExcel/Shared/PDF/fonts/rcjfont_src/") {
        $this->fontPath=$fontPath;
    }

    public function getFontPath() {
        return $this->fontPath;
    }
    
    public function printFooter() {
	$this->SetY(-16);
	$fontname = $this->addTTFfont($this->fontPath.'RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);
	$this->SetFont($fontname, '', 7);
	$this->Cell(0, 10, $this->footerInfo["WHName"], 0, 'T', 'R', 0, '', 0, false, 'T', 'M');							
	$this->SetY(-13);
	$fontname = $this->addTTFfont($this->fontPath.'RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);
	$this->SetFont($fontname, '', 7);
	$this->Cell(0, 10, $this->footerInfo["WHAddress"], 0, 'T', 'R', 0, '', 0, false, 'T', 'M');														
	$this->SetY(-10);
	$fontname = $this->addTTFfont($this->fontPath.'RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);
	$this->SetFont($fontname, '', 7);
        $this->Cell(0, 10, $this->footerInfo["WHTelNo"], 0, 'T', 'R', 0, '', 0, false, 'T', 'M');
    }
    
    public function printHeader() {
	//print_r($this->headerInfo);
        //Do print header
    }    
}
?>
