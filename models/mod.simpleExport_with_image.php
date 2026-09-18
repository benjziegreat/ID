<?php
	include('../libs/EXPORT_EXCEL_CLASS/PHPExcel_1.8.0_pdf/Classes/PHPExcel.php');
	include('../libs/EXPORT_EXCEL_CLASS/PHPExcel_1.8.0_pdf/Classes/PHPExcel/IOFactory.php');

	set_time_limit(0);
	ini_set('memory_limit','8249M');

	$FILE_N = $_POST["FILE_NAME"]==""?"Export":$_POST["FILE_NAME"];
	$WORKSHEET_NAME = "WORKSHEET DATA" ;

	$xPHPExcel = new PHPExcel();
	$xPHPExcel->getProperties()
		->setCreator("Nelson Gabriel Cañete")
	 	->setLastModifiedBy("Nelson Gabriel Cañete")
	 	->setTitle("Office 2007 XLSX REPORT Document")
	 	->setSubject("Office 2007 XLSX REPORT Document")
	 	->setDescription("REPORT document for Office 2007 XLSX, generated using PHP classes.")
	 	->setKeywords("office 2007 openxml php")
	 	->setCategory("Report result file");

    $writer = $xPHPExcel->getActiveSheet();

 	$xPHPExcel->setActiveSheetIndex(0);
	$con = mysql_connect('192.168.0.6','ric202','test');
    mysql_query("set character set 'utf8'",$con);
    mysql_query("set names 'utf8'",$con);
	$db = mysql_select_db('hr_ntc',$con);
	$result = mysql_query($_POST["_QUERY"],$con);
    $row_c = 2;
    $colModel = array();
    $data_counter = 0;
    while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
        $col_c = 0;
        $data_counter++;
        foreach($row as $key => $value){
            if($row_c==2){
                $colModel[] = $key;
            }
            if($col_c==0){
//                $objDrawing = new PHPExcel_Worksheet_Drawing();
//                //set the path of the image .. false to retrieve the remote link image ..
//                $objDrawing->setPath('http://192.168.0.3/NTC_ERP/models/getImage.php?empid='.($value),false);
//                $objDrawing->setCoordinates("A".$row_c); //ex. A1
//
//                $objDrawing->setWidthAndHeight(150,150);
//                $objDrawing->setResizeProportional(true);
//
//                list($xy__, $w__) = getCellOffsetXAndColWidth($objDrawing->getWidth());
//                list($yx__, $h__) = getCellOffsetYAndRowHeight($objDrawing->getHeight());
//
//                $objDrawing->setOffsetX(0);
//                $objDrawing->setOffsetY($yx__);
//
//                list($col_sx, $row_sx) = PHPExcel_Cell::coordinateFromString($objDrawing->getCoordinates());
//
//
//                $writer->getColumnDimension($col_sx)->setWidth($w__); //setting the Column Width;
//                $writer->getRowDimension($row_sx)->setRowHeight($h__); // setting the Row Height;
//                $objDrawing->setWorksheet($writer);
            }else{
                $writer->setCellValueByColumnAndRow($col_c,$row_c,$value,true);
            }
            $col_c++;
        }
        $row_c++;
    }

    $col_c = 0;
    foreach($colModel as $key=>$value){
        $writer->setCellValueByColumnAndRow($col_c,1,$value,true);
        $writer->getStyleByColumnAndRow($col_c,1)->applyFromArray(
            array(
                'font'    => array('bold'      => true),
                'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER),
                'fill' => array(
                    'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                    'rotation'   => 90,
                    'startcolor' => array('argb' => '11999699')
                )
            )
        );
        $writer->getColumnDimensionByColumn($col_c)->setAutoSize(true);
        $col_c++;
    }
    $writer->getStyle("A1:".(getNameFromNumber($col_c-1)).(1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $writer->getStyle("A2:".(getNameFromNumber($col_c-1)).($data_counter+1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $writer->getStyle("A2:A".($data_counter+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $writer->freezePane("A2");

    $writer->setTitle($WORKSHEET_NAME);

	mysql_free_result($result);
	mysql_close($con);
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$FILE_N.'.xls"');
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header ('Cache-Control: cache, must-revalidate');
	header ('Pragma: public');

    $writer = PHPExcel_IOFactory::createWriter($xPHPExcel, 'Excel5');
    ob_end_clean();
    $writer->save('php://output');

    function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
    function getCellOffsetYAndRowHeight($width)
    {

        $the_width = ($width * 1.50) * 0.75; //calculations for the Excel Column Width;
        $the_width = round($the_width, 2, PHP_ROUND_HALF_UP); // round up and two decimal places only;
        $the_width = $the_width > 409.50 ? 409.5 : $the_width;

        $the_offset = $the_width == 409.50 ? ((546 - $width) / 2) : ($width * 0.28);

        return array($the_offset, $the_width);
    }
    function getCellOffsetXAndColWidth($height)
    {
        $return = array();
        $return[] = round(($height * 0.15)); //calculations for  OffsetY;

        $height = ($height * 0.80) * (0.12135); //calculations for the Excel Row Height;
        $height = round($height, 2, PHP_ROUND_HALF_UP); // round up and two decimal places only;
        $return[] = $height;

        return $return;
    }
?>