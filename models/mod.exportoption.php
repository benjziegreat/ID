<?php
include_once 'mod.excel.php';
include_once 'mod.pdf.php';

$buffer = $_POST['csvBuffer'];

$arr_strData = json_decode($buffer);

$arr_strColumnModel = array_shift($arr_strData);

$excel = new ExcelAPI();
$excel->getGridToExcel($arr_strData, $arr_strColumnModel);

if ($_POST['action'] == 'excel' && $_POST['module']) {

    $excel->getExcelFile($_POST['module']);
    //echo $excel->getExcelToHTML();

} else if ($_POST['action'] == 'pdf' && $_POST['module'] && $_POST['pdftitle']) {

    // create new PDF document
    $pdf = new PrintPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetHeaderData("", "", "印刷 日時: " . date('Y-m-d H:i:s'), $_POST['pdftitle']);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 15);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //set some language-dependent strings
    $pdf->setLanguageArray($l);

    // set font
    $fontname = $pdf->addTTFfont(K_PATH_FONTS . 'rcjfont_src/RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);

    $pdf->SetFont($fontname, '', 7);

    // add a page
    $pdf->AddPage();

    $html = $excel->getExcelToHTML();

    $pdf->writeHTML($html, true, false, false, true);

    $pdf->AutoPrint(false);

    //Close and output PDF document
    $pdf->Output($_POST['module'] . ".pdf", 'I');

} else if ($_POST['action'] == 'stockissuancepdf') {

    // create new PDF document
    $pdf = new PrintPDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetHeaderData("issuancelogo.PNG", 80, "発行日     " . date("Y年m月d日"), '');

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //set some language-dependent strings
    $pdf->setLanguageArray($l);

    // add a page
    $pdf->AddPage();

    $pdf->stockIssuanceDRInfoSheet($_POST['BranchName'], $_POST['CustName'], $_POST['SiteAddress'], $_POST['CustTelNo'], $_POST['ForemanName'], $_POST['ForemanNo'], $_POST['DeliveryMonth'], $_POST['DeliveryDay'], $_POST['DeliveryTime'], $_POST['UnloadingPlace'], $_POST['BigTruck'], $_POST['Mafia'], $_POST['ParkingPlaceDistance'], $_POST['UniCam'], $_POST['RoadCondition'], $_POST['DeliveryCompanion'], $_POST['WithMap'], $_POST['WingCar'], $_POST['Remarks']);

    $pdf->AutoPrint(false);

    //Close and output PDF document
    $pdf->Output($_POST['module'] . ".pdf", 'I');
}

?>
