<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once 'mod.excel.new.php';
include_once 'mod.pdf.php';
include_once 'mod.pdc.rptwarehouseinvsummary.php';
include_once 'mod.payroll.rptprocessdtr.php';
include_once 'mod.pdc.rptwarehouseissuance.php';
include_once 'mod.pdc.mststock.php';


include_once 'mod.ies.mstbank.php';
include_once 'mod.ies.mstemail.php';
include_once 'mod.ies.mstclass.php';
include_once 'mod.ies.msttype.php';
include_once 'mod.ies.mstsupplier.php';
include_once 'mod.ies.exportsalesreport.php';

$buffer = $_POST['csvBuffer'];

//echo $buffer;
//echo "<pre>";
//print_r($_POST);
// var_dump($_POST);

$getParam = json_decode($_POST["GETPARAM"]);

$jsonGridData = json_decode($buffer);

//print_r($jsonGridData->headers[1]);
$excel = new ExcelExport();
if (isset($_POST['from'])) {

    switch ($_POST['from']) {
        case 'MstStock':
            $mod = new ModelPDCMstStock();
            $method = $_POST['method'];
            $arr = $mod->$method($strSearchKey = '', (int)$_POST['StockStatusType'], (int)$_POST['ResourceType'], (int)$_POST['NoPriceOnly'], $isJQGrid = false);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr;

           break;
        case 'WarehouseInvSummary':
            $mod = new ModelPDCRptWarehouseInvSummary();
            $params = array();
            $params['BranchID'] = $_POST['BranchID'];
            $params['BegDatetime'] = $_POST['BegDatetime'];
            $params['EndDatetime'] = $_POST['EndDatetime'];
            $params['TrnType'] = $_POST['TrnType'];
            $method = $_POST['method'];

            //print_r($_POST);
            //echo $method;
            $arr = $mod->$method($params, 0);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;


            break;
        case 'WarehouseIssuanceSummary':
            $mod = new ModelPDCRptWarehouseIssuance();
            $params = array();
            $params['BranchID'] = $_POST['BranchID'];
            $params['StartDate'] = $_POST['StartDate'];
            $params['EndDate'] = $_POST['EndDate'];
            $params['SearchString'] = $_POST['SearchString'];
            $params['IncludeUnposted'] = $_POST['IncludeUnposted'];
            $arr = $mod->getWarehouseIssuanceList($params, 0);
            $arr = json_decode($arr);
//            print_r($arr);
            $jsonGridData->body = $arr->rows;
            break;
        case 'PayrollProcessDtr':
        case 'PayrollProcessDtrSummary':
            $func = "get" . $_POST['from'] . 'List';

            $mod = new ModelPayrollRptProcessDTR();
            $params = array();
            $params['PeriodID'] = $_POST['PeriodID'];


            $arr = $mod->$func($params, 0);

            //echo $func;
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;
        case 'PayrollProcessDtrSummary':
            $mod = new ModelPayrollRptProcessDTR();

            $arr = $mod->$func($params, 0);
            //echo $func;
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;

        case 'IEGSBankList':
            $mod = new ModelIESMstBank();
            $arr = $mod->getList('', 0);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;
        case 'IEGSEmailList':
            $mod = new ModelIESEmail();
            $arr = $mod->getList('', 0);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;
        case 'IESSupplierList':
            $mod = new ModelIESMstSupplier();
            $arr = $mod->getList('', 0);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;
        case 'IEGSTypeList':
            $mod = new ModelIESType();
            $arr = $mod->getList('', 0);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;

        case 'IEGSClassList':
            $mod = new ModelIESClass();
            $arr = $mod->getList('', 0);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;
        case 'IESExportSalesReport':
            $mod = new ModelIESExportSalesReport();
            $params = array();
            $params['Year'] = $_POST['Year'];
            $params['Month'] = $_POST['Month'];
            $params['SearchKey'] = $_POST['SearchKey'];
            $params['IsDirect'] = $_POST['IsDirect'];
            $arr = $mod->getExportSalesReport($params, 0);
            $arr = json_decode($arr);
            $jsonGridData->body = $arr->rows;
            break;
    }
    $excel->setGridDataToExcelWithColModel($jsonGridData, json_decode($_POST['colModel']));
} else {

    $excel->setGridDataToExcel($jsonGridData);
}


switch ($_POST['action']) {
    case 'excel':

        $excel->getExcelFile($_POST['module']);

        // echo $excel->getExcelToHTML();
        break;
    case 'pdf':
        // create new PDF document
        $pdf = new PrintPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetHeaderData("", "", ($_COOKIE['lang'] == 'jp' ? "印刷 日時: " : 'Print Datetime: ') . date('Y-m-d H:i:s'), $_POST['pdftitle']);

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

        //$pdf->SetDisplayMode($zoom='fullwidth', $layout='SinglePage', $mode='UseNone');
        // set font
        $fontname = $pdf->addTTFfont(K_PATH_FONTS . 'rcjfont_src/RCJFONTGothic.ttf', 'TrueTypeUnicode', '', 32);

        $pdf->SetFont($fontname, '', 7);

        // add a page
        $pdf->AddPage();

        $html = $excel->getExcelToHTML();

        $pdf->writeHTML($html);

        $pdf->AutoPrint(false);

        //Close and output PDF document
        $pdf->Output("{$_POST['module']}.pdf", 'I');
        break;
}
$excel->clearFromMemory();
//echo $excel->getExcelToHTML();
?>
