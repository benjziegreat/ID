<?php

set_time_limit(0);

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
include_once '../config/cons.database.php';
include "../libs/PHPExcel/Classes/PHPExcel.php";
$objPHPExcel = new PHPExcel();
// print_r($data);
// foreach ($data as $rowData ){
//       print_r($rowData);
//       print_r($rowData['id']);print_r($rowData['emp_id']);
//   }
  foreach ($data as $x => $y) {
    print_r( $y['address']);
  }

//::::
///

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8", $conn);
mysql_query("SET NAMES 'utf8'", $conn);
//$strSQL = stripslashes($_POST["sqlQuery"]);

$strSQL = "SELECT 
            DATE_FORMAT(p.`datefrom`, '%m-%d-%y') DATEFROM, 
            IF(p.`dateto`='' OR p.`dateto` is null,'Present',DATE_FORMAT(p.`dateto`, '%m-%d-%y')) DATETO, 
            p.`designation_title` DESIGNATIONTITLE,
            LEFT(p.`status`,1) STATUS, 
            p.`salary_annum` SALARYANNUM, 
            p.`station_place_assign` STATIONPLACCEASSIGN, 
            p.`branch` BRANCH, 
            p.`lv_abs_wopay` LVABSWOPAY,
            DATE_FORMAT(p.`dateofseparation`, '%d-%e-%y') DATEOFSEPARATION, 
            p.`reasonofseparation` REASONOFSEPARATION
            
        FROM hris.person_workexperience p       
        where p.person_code='{$_POST["person_code"]}'";
$TransTitle = $_POST["transtitle"];
$IsHasSummaryTotal = $_POST["IsHasSummaryTotal"];


$recs = mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
$cnt = mysql_num_rows($recs);

$strSQLEmp = "SELECT 
                  
                  UCASE(p.`l_name`) l_name,
                  UCASE(p.`f_name`) f_name,
                  UCASE(CONCAT(LEFT(p.`m_name`,1),'.'))  m_name,
                  CONCAT(p.`l_name`,' ',p.`f_name`,' ',LEFT(p.`m_name`,1),'.' ) PersonName,
                  CONCAT(MONTHNAME(p.`birthdate`),' ,',day(p.`birthdate`),' ',year(p.`birthdate`)) birthdate,
                  CONCAT(MONTHNAME(NOW()),' ,',day(NOW()),' ',year(now())) DateIssued,                 
                  CONCAT(
                    if(paddress.`house_st_vlg_brgy`=null OR paddress.`house_st_vlg_brgy`='','',CONCAT(paddress.`house_st_vlg_brgy`,', ')),
                    if(paddress.`city_municipality`=null OR paddress.`city_municipality`='','',CONCAT(paddress.`city_municipality`,', ')),
                    if(paddress.`province`=null OR paddress.`province`='','',CONCAT(paddress.`province`,' '))
                    
                  ) permanentaddress
                FROM 
                hris.`person` p 
                left join `hris`.person_address paddress ON(p.`person_code`=paddress.`person_code` and paddress.`addresstype`='Permanent' ) 
                WHERE p.person_code='{$_POST["person_code"]}'";
$recordEmployee = mysql_query($strSQLEmp, $conn) or die(mysql_error() . $strSQLEmp);



$activesheet = 0;
$rownum = 25;
$footerRowstart = 53;

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
$styleAlignBottom = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
$styleArrayBorderNoTop = array(
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        )
    ),
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Arial'
    )
);
$styleArrayBorderNoBottom = array(
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
    )
);
$styleArrayBorderNoBottomandTop = array(
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        )
    )
);

$styleArrayBorderDouble = array(
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
        ),
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        )
    )
);
$styleArrayBorderDoubleBottom = array(
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
        ),
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        )
    )
);
$styleArrayBorderBottom = array(
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE,
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

$styleArrayArial12 = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 12,
        'name' => 'Arial'
    )
);
$styleArrayArial9 = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Arial'
    )
);
$styleArrayArial12Bold = array(
    'font' => array(
        'bold' => tru,
        'color' => array('rgb' => '000000'),
        'size' => 12,
        'name' => 'Arial'
        ));
$styleArrayArial8 = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 8,
        'name' => 'Arial'
    )
//    ,
//    'alignment' => array(
//        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
//        )
);
$styleArrayArial8Bold = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 8,
        'name' => 'Arial'
        ));
$styleArrayArial10 = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'name' => 'Arial'
        ));
$styleArrayArial10Italize = array(
    'font' => array(
        'bold' => false,
        'italic' => true,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'name' => 'Arial'
        ));
$styleArrayArial10NoAlignment = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'name' => 'Arial'
        ));
$styleArrayArial10BoldNoAlignmentUnderline = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'underline' => false,
        'name' => 'Arial'
        ));
$styleArrayArial10NoAlignmentUnderline = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'underline' => true,
        'name' => 'Arial'
        ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    ));
$styleArrayArial10Bold = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'name' => 'Arial'
        ));
$styleArrayArial10BoldCenter = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'name' => 'Arial'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);
$styleArrayArial10Center = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 10,
        'name' => 'Arial'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);
$styleArrayArial26 = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 26,
        'name' => 'Arial'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));





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
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A1', "Republic of the Philippines");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A2', "Province of Bukidnon");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A3', "Municipality of Kitaotao");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A4', "");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A5', "MUNICIPAL GOVERNMENT OF KITAOTAO");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A6', "Service Record");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('D9', "        (To be accomplished by employer)");

$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A11', "Name");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B11', mysql_result($recordEmployee, 0, "l_name")); //emplname
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('D11', mysql_result($recordEmployee, 0, "f_name")); //empfname
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('F11', mysql_result($recordEmployee, 0, "m_name")); //empmname
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B12', "(Surname)");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('D12', "(Given Name)");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('F12', "(M.I.)");

$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A14', "Birth");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B14', "" . mysql_result($recordEmployee, 0, "birthdate") . "           " . mysql_result($recordEmployee, 0, "permanentaddress") . ""); //birth address
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B15', "Date");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('D15', "Place");



$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G11', "       (if married woman, give also");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G12', "        full maiden name)");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G14', "       (Data herein should be checked");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G15', "        from birth or baptismal certificate");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G16', "        or some other reliable documents)");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A18', "         THIS IS TO CERTIFY that the employee named herein above actually rendered services in this office as shown by the Service Record below, each line of which is supported by appointments and other papers actually issued by this office and approved by the authorities concerned.");


//Table Header
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A20', "SERVICE");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A21', "(Inclusive Dates)");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('C21', "RECORD OF APPOINTMENT");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('F21', " OFFICE/ENTITY");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('I21', "SEPARATION");

$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A23', "From");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B23', "To");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('C23', "DESIGNATION");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('D23', "STATUS");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('E23', "SALARY/");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('E24', "ANNUM");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('F22', "Station");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('F23', "Place of");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('F24', "Assignment");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G23', "Branch");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('H22', "LV/ABS");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('H23', "W/O PAY");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('I22', "Date");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('J22', "Cause");

//Footer Caption
//header page merge
$objPHPExcel->getActiveSheet()->mergeCells("A1:J1");
$objPHPExcel->getActiveSheet()->mergeCells("A2:J2");
$objPHPExcel->getActiveSheet()->mergeCells("A3:J3");
$objPHPExcel->getActiveSheet()->mergeCells("A5:J5");
$objPHPExcel->getActiveSheet()->mergeCells("A6:J6");
$objPHPExcel->getActiveSheet()->mergeCells("A7:J7");
$objPHPExcel->getActiveSheet()->mergeCells("A8:J8");
$objPHPExcel->getActiveSheet()->mergeCells("A6:A8");
$objPHPExcel->getActiveSheet()->mergeCells("A18:J18");
//Table header merge
$objPHPExcel->getActiveSheet()->mergeCells("A20:B20");
$objPHPExcel->getActiveSheet()->mergeCells("A21:B21");
$objPHPExcel->getActiveSheet()->mergeCells("C21:E21");
$objPHPExcel->getActiveSheet()->mergeCells("F21:H21");
$objPHPExcel->getActiveSheet()->mergeCells("I21:J21");





//
$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray($styleAlign);
$objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray($styleAlign);
$objPHPExcel->getActiveSheet()->getStyle("A3:J3")->applyFromArray($styleAlign);
$objPHPExcel->getActiveSheet()->getStyle("A5:J5")->applyFromArray($styleAlign);
$objPHPExcel->getActiveSheet()->getStyle("A6:J6")->applyFromArray($styleAlign);
$objPHPExcel->getActiveSheet()->getStyle("A7:J7")->applyFromArray($styleAlign);
$objPHPExcel->getActiveSheet()->getStyle("A8:J8")->applyFromArray($styleAlign);
$objPHPExcel->getActiveSheet()->getStyle("D9")->applyFromArray($styleAlignBottom);
//
//$objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray($styleArrayBorder);
//$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray($styleArrayBorder);
$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->applyFromArray($styleArrayArial12);
$objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray($styleArrayArial12);
$objPHPExcel->getActiveSheet()->getStyle("A3:J31")->applyFromArray($styleArrayArial12);
$objPHPExcel->getActiveSheet()->getStyle("A5:J5")->applyFromArray($styleArrayArial12);
$objPHPExcel->getActiveSheet()->getStyle("A6:J6")->applyFromArray($styleArrayArial26);
$objPHPExcel->getActiveSheet()->getStyle("D9")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("A5:J5")->applyFromArray($styleArrayBorderDoubleBottom);
$objPHPExcel->getActiveSheet()->getStyle("A11")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("B11:F11")->applyFromArray($styleArrayArial12Bold);
$objPHPExcel->getActiveSheet()->getStyle("B11:F11")->applyFromArray($styleArrayBorderBottom);
$objPHPExcel->getActiveSheet()->getStyle("B14:F14")->applyFromArray($styleArrayBorderBottom);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.50);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10.52);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14.90);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(6.50);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.75);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15.50);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7.90);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8.90);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7.75);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10.90);

$objPHPExcel->getActiveSheet()->getStyle("G11:G16")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("B12:F12")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("A14:J14")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("A15:J15")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("A18:J18")->applyFromArray($styleArrayArial10);


$objPHPExcel->getActiveSheet()->getStyle("A20:B20")->applyFromArray($styleAlignBottom);
$objPHPExcel->getActiveSheet()->getStyle("A21:B21")->applyFromArray($styleAlignBottom);
$objPHPExcel->getActiveSheet()->getStyle("C21:E21")->applyFromArray($styleAlignBottom);
$objPHPExcel->getActiveSheet()->getStyle("F21:H21")->applyFromArray($styleAlignBottom);
$objPHPExcel->getActiveSheet()->getStyle("I21:J1")->applyFromArray($styleAlignBottom);



$objPHPExcel->getActiveSheet()->getStyle("A20:B20")->applyFromArray($styleArrayBorderNoBottom);
$objPHPExcel->getActiveSheet()->getStyle("A21:B21")->applyFromArray($styleArrayBorderNoTop);
$objPHPExcel->getActiveSheet()->getStyle("C20:E20")->applyFromArray($styleArrayBorderNoBottom);
$objPHPExcel->getActiveSheet()->getStyle("C21:E21")->applyFromArray($styleArrayBorderNoTop);
$objPHPExcel->getActiveSheet()->getStyle("F20:H20")->applyFromArray($styleArrayBorderNoBottom);
$objPHPExcel->getActiveSheet()->getStyle("F21:H21")->applyFromArray($styleArrayBorderNoTop);
$objPHPExcel->getActiveSheet()->getStyle("I20:J20")->applyFromArray($styleArrayBorderNoBottom);
$objPHPExcel->getActiveSheet()->getStyle("I21:J21")->applyFromArray($styleArrayBorderNoTop);

//Table fields align 
$objPHPExcel->getActiveSheet()->getStyle("A22:A24")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("B22:B24")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("C22:C24")->applyFromArray($styleArrayArial8);
$objPHPExcel->getActiveSheet()->getStyle("D22:D24")->applyFromArray($styleArrayArial8);
$objPHPExcel->getActiveSheet()->getStyle("E22:E24")->applyFromArray($styleArrayArial8);
$objPHPExcel->getActiveSheet()->getStyle("F22:F24")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("G22:G24")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("H22:H24")->applyFromArray($styleArrayArial8);
$objPHPExcel->getActiveSheet()->getStyle("I22:I24")->applyFromArray($styleArrayArial10);
$objPHPExcel->getActiveSheet()->getStyle("J22:J24")->applyFromArray($styleArrayArial10);
//Table fields Borders
$objPHPExcel->getActiveSheet()->getStyle("A22:A24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("B22:B24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("C22:C24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("D22:D24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("E22:E24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("F22:F24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("G22:G24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("H22:H24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("I22:I24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("J22:J24")->applyFromArray($styleArrayBorderNoBottomandTop);
$objPHPExcel->getActiveSheet()->getStyle("A24:J24")->applyFromArray($styleArrayBorderNoTop);


$objPHPExcel->getActiveSheet()->getStyle("A20:B20")->applyFromArray($styleArrayArial10BoldCenter);
$objPHPExcel->getActiveSheet()->getStyle("A21")->applyFromArray($styleArrayArial10Center);
$objPHPExcel->getActiveSheet()->getStyle("C21")->applyFromArray($styleArrayArial10BoldCenter);
$objPHPExcel->getActiveSheet()->getStyle("F21")->applyFromArray($styleArrayArial10BoldCenter);
$objPHPExcel->getActiveSheet()->getStyle("I21")->applyFromArray($styleArrayArial10BoldCenter);


// Add a drawing to the worksheet
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../views/default/images/hris/logoKitaotao.jpg');
//$objDrawing->setPath('C:/AppServ/www/HRIS/views/default/images/hris/logoKitaotao.png');

$objDrawing->setCoordinates('B1');
$objDrawing->setWidthAndHeight(95, 95);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


$objPHPExcel->getActiveSheet()->getStyle("A1:J1")
        ->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle("A2:J2")
        ->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle("A18:J18")
        ->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()
//        ->getRowDimension('1')
//        ->setRowHeight(0);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('1')
        ->setRowHeight(15);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('2')
        ->setRowHeight(13.50);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('3')
        ->setRowHeight(12.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('4')
        ->setRowHeight(6);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('6')
        ->setRowHeight(19.5);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('7')
        ->setRowHeight(11.25);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('8')
        ->setRowHeight(2.25);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('9')
        ->setRowHeight(10.5);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('10')
        ->setRowHeight(10.5);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('11')
        ->setRowHeight(20.25);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('12')
        ->setRowHeight(12.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('13')
        ->setRowHeight(6.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('14')
        ->setRowHeight(12.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('15')
        ->setRowHeight(12.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('16')
        ->setRowHeight(12.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('17')
        ->setRowHeight(6.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('18')
        ->setRowHeight(39.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('19')
        ->setRowHeight(3.75);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('20')
        ->setRowHeight(15);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('21')
        ->setRowHeight(11.25);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('22')
        ->setRowHeight(15);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('23')
        ->setRowHeight(11.25);
$objPHPExcel->getActiveSheet()
        ->getRowDimension('24')
        ->setRowHeight(12);
for ($i = 25; $i <= 100; $i++) {
    $objPHPExcel->getActiveSheet()
            ->getRowDimension($i)
            ->setRowHeight(12.75);
}





//$tempVal = $cnt + 2;
//$objPHPExcel->getActiveSheet()
//        ->getStyle('A3:A' . $tempVal . '')
//        ->getAlignment()
//        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//cellColor("A1:J1", 'd9d9d9');
//cellColor("A2:J2", '538dd5');
//End of Writing Values of excel
//:::::::::::::::::::::::::::::::::::;T A B L E WRITING
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
//for ($a = 0; $a < count($arrFieldContainer); $a++) {
//    $objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue($arrCellLetterContainer[$a] . "2", $arrFieldContainer[$a]);
//    $objPHPExcel->getActiveSheet()->getColumnDimension($arrCellLetterContainer[$a])->setWidth('20');
//}
//$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth('15');
//$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth('30');
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
        $objPHPExcel->getActiveSheet()->getStyle($arrCellLetterContainer[$a] . $rownum)->applyFromArray($styleArrayArial9);
        $objPHPExcel->getActiveSheet()->getStyle($arrCellLetterContainer[$a] . $rownum)->applyFromArray($styleArrayBorderNoBottomandTop);
        if ($ii == $cnt - 1) {
            $rr = $rownum + 1;
            if (is_numeric($ProcessValue)) {
                $objPHPExcel->getActiveSheet()->getStyle($arrCellLetterContainer[$a] . $rr)->applyFromArray($styleAlign);
            }
        }
    }


    $objPHPExcel->getActiveSheet()->getStyle("B{$rownum}:J{$rownum}")->getNumberFormat()->setFormatCode("#,##0");


    $rownum = $rownum + 1;
}
//TABLE BORDER SETUPS
$valInc = $footerRowstart > $rownum ? $footerRowstart : $rownum;
$footerRowstart = $valInc;
//Footer Caption
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B' . ($footerRowstart + 1), "Issued in compliance with Executive Order No. 54 date August 10, 1954 and in accordance with");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('A' . ($footerRowstart + 2), "Circular No. 53, dated August 10, 1954 of the system.");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('F' . ($footerRowstart + 5), "CERTIFIED CORRECT:");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B' . ($footerRowstart + 9), "     " . mysql_result($recordEmployee, 0, "DateIssued") . "");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('B' . ($footerRowstart + 10), "     Date Issued");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G' . ($footerRowstart + 9), "LORENZO A. GAWILAN, JR.");
$objPHPExcel->setActiveSheetIndex($activesheet)->setCellValue('G' . ($footerRowstart + 10), "          Municipal Mayor");
$objPHPExcel->getActiveSheet()->mergeCells("G" . ($footerRowstart + 9) . ":I" . ($footerRowstart + 9) . "");

$objPHPExcel->getActiveSheet()
        ->getRowDimension($footerRowstart)
        ->setRowHeight(4.50);
$objPHPExcel->getActiveSheet()
        ->getRowDimension($footerRowstart + 3)
        ->setRowHeight(9);
$objPHPExcel->getActiveSheet()
        ->getRowDimension($footerRowstart + 4)
        ->setRowHeight(6.750);
//Footer Setup
$objPHPExcel->getActiveSheet()->getStyle('B' . ($footerRowstart + 1))->applyFromArray($styleArrayArial10NoAlignment);
$objPHPExcel->getActiveSheet()->getStyle('A' . ($footerRowstart + 2))->applyFromArray($styleArrayArial10NoAlignment);
$objPHPExcel->getActiveSheet()->getStyle('F' . ($footerRowstart + 5))->applyFromArray($styleArrayArial10NoAlignment);
$objPHPExcel->getActiveSheet()->getStyle('B' . ($footerRowstart + 9))->applyFromArray($styleArrayArial10NoAlignmentUnderline);
$objPHPExcel->getActiveSheet()->getStyle('B' . ($footerRowstart + 10))->applyFromArray($styleArrayArial10Italize);
$objPHPExcel->getActiveSheet()->getStyle('G' . ($footerRowstart + 9))->applyFromArray($styleArrayArial10BoldNoAlignmentUnderline);
$objPHPExcel->getActiveSheet()->getStyle('G' . ($footerRowstart + 10))->applyFromArray($styleArrayArial10Italize);
$objPHPExcel->getActiveSheet()->getStyle("G" . ($footerRowstart + 9) . ":I" . ($footerRowstart + 9) . "")->applyFromArray($styleArrayBorderBottom)->applyFromArray($styleAlign);

for ($j = 25; $j < $valInc; $j++) {
    $objPHPExcel->getActiveSheet()->getStyle("A{$j}:B{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("B{$j}:C{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("C{$j}:D{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("D{$j}:E{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("E{$j}:F{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("F{$j}:G{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("G{$j}:H{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("H{$j}:I{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    $objPHPExcel->getActiveSheet()->getStyle("I{$j}:J{$j}")->applyFromArray($styleArrayBorderNoBottomandTop);
    IF ($j == ($valInc - 1)) {
        $objPHPExcel->getActiveSheet()->getStyle("A{$j}:J{$j}")->applyFromArray($styleArrayBorderNoTop);
    }
}


//:::::::::::::::::::::::::::::::::::::END OF TABLE WRITING




$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getSheet(0)->setTitle(mysql_result($recordEmployee, 0, "PersonName"));//Set Sheet Title


$filename = "{$TransTitle}  List as of " . date("Y-m-d");
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=$filename.xls");
header("Cache-Control: max-age=0");


// Set Orientation, size and scaling
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

$pageMargins = $objPHPExcel->getActiveSheet()->getPageMargins();
$pageMargins->setTop('1');
$pageMargins->setBottom('1');
$pageMargins->setLeft('.5');
$pageMargins->setRight('.5');

// hide gridlines so they don't mess with our Excel art.
$objPHPExcel->getActiveSheet()->setShowGridLines(false);
$objPHPExcel->createSheet();
//$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getSheet(1)->setTitle("Sheet2");
//$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', mysql_result($recordEmployee, 0, "PersonName"));
$objPHPExcel->createSheet();
//$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getSheet(2)->setTitle("Sheet3");


//$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>       