<?php

set_time_limit(0);

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
include_once '../config/cons.database.php';
include_once '../libs/passencryption.php';
include "../libs/PHPExcel/Classes/PHPExcel.php";

$objPHPExcel = new PHPExcel();

$encryption = new EncyptionCustomize();
//        $encrypted = $encryption->Newncrpting('mypassword', 'mypass');
//        $decrypted = $encryption->Newdcryting('mypassword', substr($encrypted, 0, strlen($encrypted) - 1));
//        print_r(substr($encrypted, 0, strlen($encrypted) - 1) . '<br>' . trim($decrypted));        
$user = trim($encryption->Newdcryting('mypassword', DB_USER));
$pass = trim($encryption->Newdcryting('mypassword', DB_PASS));
$conn = mysql_connect(DB_HOST, $user, $pass) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8", $conn);
mysql_query("SET NAMES 'utf8'", $conn);
$strSQL = stripslashes($_POST["sqlQuery"]);
if ($_POST["Type"] == "hrmsMSTEmployeeInformation") {
    $strSQL = "SELECT 
                  p.`person_code`,   
                  CONCAT(p.`l_name`,' ',p.`f_name`,' ',if(p.`nameext`=null OR p.`nameext`='','',concat(p.`nameext`,' ')),LEFT(p.`m_name`,1),'.' ) PersonName,
                 DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT( CAST(if(p.`birthdate` = '0000-00-00', null, p.`birthdate`) as DATETIME), '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(CAST(if(p.`birthdate` = '0000-00-00', null,p.`birthdate`) as DATETIME), '00-%m-%d')) as Age,
                 (CASE p.`gender`  WHEN 0 THEN 'Female' WHEN 1 THEN 'Male'  END) as Sex,
                  p.`birthdate`,                 
                  (CASE p.`civilstatus`  WHEN 'Others' THEN p.`civilstatusother` ELSE p.`civilstatus`  END) as Status,
                  (CASE p.`citizenship`  WHEN 'Others' THEN p.`citizenshipother` ELSE p.`citizenship`  END) as Nationality,
                 p.`datehired`,
                  p.dateresign,
                  p.workstatus,                
                  CONCAT(
                    if(paddress.`house_st_vlg_brgy`=null OR paddress.`house_st_vlg_brgy`='','',CONCAT(paddress.`house_st_vlg_brgy`,', ')),
                    if(paddress.`city_municipality`=null OR paddress.`city_municipality`='','',CONCAT(paddress.`city_municipality`,', ')),
                    if(paddress.`province`=null OR paddress.`province`='','',CONCAT(paddress.`province`,', ')) ,
                    if(paddress.`zipcode`=null OR paddress.`zipcode`='','',paddress.`zipcode`) 
                  ) permanentaddress,
                 paddress.`telno`
                FROM 
                `hris`.`person` p 
                left join `hris`.person_address paddress ON(p.`person_code`=paddress.`person_code` and paddress.`addresstype`='Permanent' ) 

                 ORDER BY person_code asc ";
}else{
    $strSQL="SELECT
  `idnum`,
  `emp_id`,
  `lname`,
  `fname`,
  `mname`,
  `nameext`,
  `designation`,
  `birthdate`,
  `contact_guardian`,
  `contact_relation`,
  `contact_address`,
  `contactno`,
  `isactive`,
  `sex`,
  `sssgsisno`,
  `tinno`,
  `philno`,
  `status`,
  `category`,
  `pagibigno`,
  `printinghistory`,
  `typeid`,
  `pathpicture`,
  `pathsignature`,
  `isforprint`,
  `addedby`,
  `addeddate`,
  `modifiedby`,
  `modifieddate`
FROM
  cjc_idsystem.`alumni` limit 100";
    
}

$TransTitle = $_POST["transtitle"]."Test";
$IsHasSummaryTotal = $_POST["IsHasSummaryTotal"];


$recs = mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
$cnt = mysql_num_rows($recs);

$activesheet = 0;
$rownum = 3;

$title = "{$TransTitle}  \nDate: " . date('F, d Y') . "";



$styleArray = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 12,
        'name' => 'Verdana'
    ),
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
$styleHeaderFontStyleColorWhite = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size' => 12,
        'name' => 'Calibri'
    ),
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
$styleAlign = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$styleAlignWorksheet2BillDetailsBoldBlue = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '050bf7'),
        'size' => 11,
        'name' => 'Tahoma'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
    )
);
$styleAlignWorksheet2BillDetailsNotBoldBlue = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '050bf7'),
        'size' => 11,
        'name' => 'Tahoma'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
    )
);
$styleAlignWorksheet2BillDetailsBoldRed = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'f70505'),
        'size' => 11,
        'name' => 'Tahoma'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
    )
);
$styleAlignWorksheet2BillDetailsNotBoldRed = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => 'f70505'),
        'size' => 11,
        'name' => 'Tahoma'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
    )
);

$styleArrayBorder = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

$styleArrayTotalSummary = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 12,
        'name' => 'Calibri'
    )
);

$styleArrayDisabledCellColor = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FFFFFFFF'),
        ),
    ),
);

function cellColor($cells, $color) {
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()
            ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => $color)
    ));
}

$objPHPExcel->setActiveSheetIndex($activesheet);
$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(100);



//$query=$strSQL;
//$result=mysql_query($query);
//$numfields = mysql_num_fields($result);
//
//echo "<table>\n<tr>";
//
//for ($i=0; $i < $numfields; $i++) // Header
//{ echo '<th>'.mysql_field_name($result, $i).'</th>'; }
//
//echo "</tr>\n";
//
//while ($row = mysql_fetch_row($result)) // Data
//{ echo '<tr><td>'.implode($row,'</td><td>')."</td></tr>\n"; }
//
//echo "</table>\n";

$query = $strSQL;
$result = mysql_query($query);
$numfields = mysql_num_fields($result);
$arrFieldContainer = array();

for ($i = 0; $i < $numfields; $i++) { // Header
    array_push($arrFieldContainer, mysql_field_name($result, $i));
}
//print_r($arrFieldContainer);
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A1', $title);
//function: AutoIncrement Letters
$arrCellLetterContainer = array();
$cnter = 0;
$lettercnt = -1;
for ($i = 0; $i < count($arrFieldContainer); $i++) {
    if ($i <= 25) {
        //echo $i.': '.chr(($i %26) +97).PHP_EOL;
        array_push($arrCellLetterContainer, strtoupper(chr(($i % 26) + 97)));
    } else {
        ++$cnter;
        if ($cnter % 26 == 1) {
            $lettercnt++;
        }
        //echo $i.': '.chr(($lettercnt %26) +97).chr(($i %26) +97).PHP_EOL;
        array_push($arrCellLetterContainer, strtoupper(chr(($lettercnt % 26) + 97) . chr(($i % 26) + 97)));
    }
}
//print_r($arrCellLetterContainer[count($arrFieldContainer)-1]);
////End of autoIncrement letterss
for ($a = 0; $a < count($arrFieldContainer); $a++) {
    $objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue($arrCellLetterContainer[$a] . "2", $arrFieldContainer[$a]);
    $objPHPExcel->getActiveSheet()->getColumnDimension($arrCellLetterContainer[$a])->setWidth('20');
}
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth('30');
for ($ii = 0; $ii < $cnt; $ii++) {

    for ($a = 0; $a < count($arrFieldContainer); $a++) {

        $ProcessValue = mysql_result($recs, $ii, $arrFieldContainer[$a]);
        $ProcessValue = (int) $ProcessValue < 0 ? "" : $ProcessValue;
        if ($arrFieldContainer[$a] == 'isactive' || $arrFieldContainer[$a] == 'ISVOID' || $arrFieldContainer[$a] == 'IsSupervisor' || $arrFieldContainer[$a] == 'IsWillReturn' || $arrFieldContainer[$a] == 'IsVoid') {
            if ((int) $ProcessValue == 1) {
                $ProcessValue = "Yes";
            } else {
                $ProcessValue = "No";
            }
            $objPHPExcel->getActiveSheet()->getStyle($arrCellLetterContainer[$a] . $rownum)->applyFromArray($styleAlign);
        }

        $objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue($arrCellLetterContainer[$a] . $rownum, $ProcessValue);
        if (is_numeric($ProcessValue)) {
            $objPHPExcel->getActiveSheet()->getStyle($arrCellLetterContainer[$a] . $rownum)->applyFromArray($styleAlign);
        }


        if ($ii == $cnt - 1) {
            $rr = $rownum + 1;
            if (is_numeric($ProcessValue)) {
                $objPHPExcel->getActiveSheet()->getStyle($arrCellLetterContainer[$a] . $rr)->applyFromArray($styleAlign);
            }
        }
    }


    $objPHPExcel->getActiveSheet()->getStyle("B{$rownum}:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}{$rownum}")->getNumberFormat()->setFormatCode("#,##0.000");


    $rownum = $rownum + 1;
}
//Sum total Footer
if ($IsHasSummaryTotal == "Yes") {

    for ($a = 1; $a < count($arrFieldContainer); $a++) {
        $ProcessValue = mysql_result($recs, 0, $arrFieldContainer[$a]);
        if (is_numeric($ProcessValue)) {
            $objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue($arrCellLetterContainer[$a] . "2", $arrFieldContainer[$a]);
            $objPHPExcel->getActiveSheet()->setCellValue("{$arrCellLetterContainer[$a]}{$rownum}", "=SUM({$arrCellLetterContainer[$a]}3:{$arrCellLetterContainer[$a]}" . ($rownum - 1) . ")");

            $objPHPExcel->getActiveSheet()->getStyle("B{$rownum}:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}{$rownum}")->getNumberFormat()->setFormatCode("#,##0.000");
            $objPHPExcel->getActiveSheet()->getStyle("A{$rownum}:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}{$rownum}")->applyFromArray($styleArrayTotalSummary);
        }
    }
}
////End of Sum Total

if ($_POST["Type"] == "payrollJournalReport") {
    $objPHPExcel->getActiveSheet()->freezePane('G3');
} else if ($_POST["Type"] == "hrmsMSTEmployeeInformation") {
    $objPHPExcel->getActiveSheet()->freezePane('C3');
} else {
    $objPHPExcel->getActiveSheet()->freezePane('B3');
}
$objPHPExcel->getActiveSheet()->mergeCells("A1:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}1");
//
$objPHPExcel->getActiveSheet()->getStyle("A1:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}1")->applyFromArray($styleAlign)->applyFromArray($styleArrayBorder);
$objPHPExcel->getActiveSheet()->getStyle("A2:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}2")->applyFromArray($styleAlign)->applyFromArray($styleArrayBorder);
//

$objPHPExcel->getActiveSheet()->getStyle("A2:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}2")->applyFromArray($styleArrayBorder);
$objPHPExcel->getActiveSheet()->getStyle("A1:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}1")->applyFromArray($styleArrayBorder);
$objPHPExcel->getActiveSheet()->getStyle("A1:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}1")->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("A2:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}2")->applyFromArray($styleAlign)->applyFromArray($styleHeaderFontStyleColorWhite);



$objPHPExcel->getActiveSheet()->getStyle("A1:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}1")
        ->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle("A2:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}2")
        ->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('1')
        ->setRowHeight(50);
$tempVal = $cnt + 2;
$objPHPExcel->getActiveSheet()
        ->getStyle('A3:A' . $tempVal . '')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

cellColor("A1:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}1", 'd9d9d9');
cellColor("A2:{$arrCellLetterContainer[count($arrFieldContainer) - 1]}2", '538dd5');
//End of Writing Values of excel



$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getSheet(0)->setTitle($TransTitle);

$filename = "{$TransTitle}  List as of " . date("Y-m-d");
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=$filename.xls");
header("Cache-Control: max-age=0");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>       