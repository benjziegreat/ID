<?php
set_time_limit(0);
require_once('tcpdf_include.php');
include_once '../../../config/cons.database.php';

$htmlContent=stripslashes($_POST["htmlContent"]);
$titlePDF="PDS Report";

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Benjziegreat');
$pdf->SetTitle('Personal Data Sheet');
$pdf->SetSubject('PDS Report');
$pdf->SetKeywords('Personal Data Sheet Report');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 035', PDF_HEADER_STRING);
$pdf->SetHeaderData('',0, '','',array(255,255,255),array(255,255,255));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('times', 'BI', 16);

// add a page
$pdf->AddPage();


$html =$htmlContent;
//print_r($html);
// output the HTML content
$pdf->SetFont('times', 'B', 12);
//$pdf->SetFont('dejavusans', '', 12, '', true);
//$pdf->SetFont('aealarabiya', '', 12);
$pdf->SetDisplayMode(100);
$pdf->writeHTML($html, true, 0, true, 0);
// ---------------------------------------------------------

//Close and output PDF document/
$pdf->Output($titlePDF.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
