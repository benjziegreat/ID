<?php

include_once "../libs/PHPExcel/Classes/PHPExcel.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ExcelExport
{

    public $has_ImageColumn = false;
    public $imageColumnIndex = "A";
    public $imageColumnWidth = -1;
    public $obj_objExcel;
    public $obj_objWriter ;
    public $obj_objSheet;
    public $arr_objHeaderStyle = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => 'FFFFFF')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF0000')
        )
    );
    public $arr_objGridStyle = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '800000'),
            )
        )
    );
    public $arr_objAltRow = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'E0EBFF')
        )
    );

    public function __construct()
    {
        $this->obj_objExcel = new PHPExcel;
        $this->obj_objExcel->setActiveSheetIndex(0);

        $this->obj_objSheet = $this->obj_objExcel->getActiveSheet();
        $this->obj_objSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    }

    public function decodeHTMLentities($value)
    {
        return html_entity_decode($value, ENT_COMPAT | ENT_HTML401 | ENT_NOQUOTES, "UTF-8");
    }

    public function processImage($img_path, $coordinates)
    {
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        //set the path of the image .. false to retrieve the remote link image ..
        $objDrawing->setPath($img_path, false);
        $objDrawing->setCoordinates($coordinates); //ex. A1

        list($x, $w) = $this->getCellOffsetXAndColWidth($objDrawing->getWidth());
        list($y, $h) = $this->getCellOffsetYAndRowHeight($objDrawing->getHeight());

        $objDrawing->setOffsetX($x);
        $objDrawing->setOffsetY($y);

        list($col, $row) = PHPExcel_Cell::coordinateFromString($objDrawing->getCoordinates());


        $this->obj_objSheet->getColumnDimension($col)->setWidth($w); //setting the Column Width;
        $this->obj_objSheet->getRowDimension($row)->setRowHeight($h); // setting the Row Height;


        $objDrawing->setWorksheet($this->obj_objSheet);
    }

    public function renderImageAtTheTop($img_path)
    {
        //Insert a new row at the top        
        $this->obj_objSheet->insertNewRowBefore(1, 1);

        //Process the image using PHPExcel_Worksheet_Drawing();
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath($img_path);
        $objDrawing->setCoordinates('A1'); //ex. A1
        $objDrawing->setResizeProportional(false);
        $objDrawing->setHeight($objDrawing->getHeight() * 0.75);
        $objDrawing->setWidth($objDrawing->getWidth() * 0.352);


        $lastCol = PHPExcel_Cell::stringFromColumnIndex($this->str_intTotalColumn - 1);
        $cells = 'A1:' . $lastCol . '1';
        $this->obj_objSheet->mergeCells($cells);
        //$this->obj_objSheet->getStyle($cells)->applyFromArray($this->arr_objGridStyle);

        $objDrawing->setWorksheet($this->obj_objSheet);

        list($y, $h) = $this->getCellOffsetYAndRowHeight($objDrawing->getHeight());

        $objDrawing->setOffsetX(12);
        $objDrawing->setOffsetY($y);

        $this->obj_objSheet->getRowDimension(1)->setRowHeight($h);
    }

    public function getCellOffsetYAndRowHeight($width)
    {

        $the_width = ($width * 1.50) * 0.75; //calculations for the Excel Column Width;
        $the_width = round($the_width, 2, PHP_ROUND_HALF_UP); // round up and two decimal places only;
        $the_width = $the_width > 409.50 ? 409.5 : $the_width;

        $the_offset = $the_width == 409.50 ? ((546 - $width) / 2) : ($width * 0.28);

        return array($the_offset, $the_width);
    }

    public function getCellOffsetXAndColWidth($height)
    {
        $return = array();
        $return[] = round(($height * 0.15)); //calculations for  OffsetY;

        $height = ($height * 0.80) * (0.12135); //calculations for the Excel Row Height;
        $height = round($height, 2, PHP_ROUND_HALF_UP); // round up and two decimal places only;
        $return[] = $height;

        return $return;
    }

    public function setCellTextAlignment($alignment)
    {
        $cellAlignment = array();

        switch ($alignment) {
            case 'right':
                $cellAlignment['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                break;
            case 'left':
                $cellAlignment['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                break;
            case 'center':
                $cellAlignment['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                break;

            default:
                break;
        }

        $cellAlignment['alignment']['vertical'] = PHPExcel_Style_Alignment::VERTICAL_CENTER;
        return $cellAlignment;
    }

    public function setCellBgColor($color = 'FFFFFF')
    {
        if($color == 'FFFFFF'){
            return array();
        }

        return array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => $color)
            )
        );
    }

    public function setCellTextColor($color = '333333')
    {
        return
            array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => $color)
                )
            );
    }

    public function setCellBorderColor($color = 'D8DCDF')
    {
        if($color == 'D8DCDF'){
            return array();
        }

        return array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => $color),
                )
            )
        );

    }

    public function setCellBorderBottom($strParams)
    {
        list($size, $style, $scolor) = explode(" ", $strParams);

        return array(
            'borders' => array(
                'bottom' => array(
                    'style' => $style == "double" ? PHPExcel_Style_Border::BORDER_DOUBLE : PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
    }

    public function setAutoSizeColumnWidth($colCount)
    {
        for ($j = 0; $j < $colCount; $j++) {
            $this->obj_objSheet->getColumnDimensionByColumn($j)->setAutoSize(true);
        }
    }

    public function getExcelFile($fileName)
    {
        //echo $fileName;
        ///**
        header("Content-Type: application/vnd.ms-excel;charset=UTF-8");
        header("Content-Disposition: attachment;filename={$fileName}.xls");
        header('Cache-Control: max-age=0');
        $this->obj_objWriter = PHPExcel_IOFactory::createWriter($this->obj_objExcel, 'Excel5');
        ob_end_clean();
        $this->obj_objWriter->save("php://output");
        //**/


    }

    public function getExcelToHTML()
    {
        $this->obj_objWriter = new PHPExcel_Writer_PDF($this->obj_objExcel);
        $this->obj_objWriter->writeAllSheets();
        $this->obj_objWriter->buildCSS(false);
//        print_r($this->obj_objWriter->generateSheetData());


        return $this->obj_objWriter->generateSheetData();
    }

    public function clearFromMemory()
    {
        $this->obj_objExcel->disconnectWorksheets();
        unset($this->obj_objExcel);
    }

    public function setGridDataToExcel($arr_objGridData)
    {
        set_time_limit(0);
        ini_set('memory_limit', '8048M');
        $this->str_intTotalColumn = $arr_objGridData->colNum;
        $afterHeader = sizeof($arr_objGridData->header);
        $afterContent = $afterHeader + sizeof($arr_objGridData->body);

        $this->loadGridContent($arr_objGridData->header, 0, $arr_objGridData->colNum);
        $this->loadGridContent($arr_objGridData->body, $afterHeader, $arr_objGridData->colNum);
        $this->loadGridContent($arr_objGridData->footer, $afterContent, $arr_objGridData->colNum);

        $col = $arr_objGridData->frozenCol > 0 ? PHPExcel_Cell::stringFromColumnIndex($arr_objGridData->frozenCol + 1) : 'A';
        $this->obj_objSheet->freezePane($col . ($afterHeader + 1));


        if (!$arr_objGridData->AutoSize) {
            for ($j = 0; $j < sizeof($arr_objGridData->colWidth); $j++) {
                $this->obj_objSheet->getColumnDimensionByColumn($j)->setWidth($arr_objGridData->colWidth[$j] * 0.13806666666666666666666666666667);
            }
        } else {
            $this->setAutoSizeColumnWidth($arr_objGridData->colNum);
        }

        $this->obj_objSheet->getPageSetup()->setRowsToRepeatAtTop(array(1, $afterHeader));

    }

    public function loadGridContent($arr_objData, $startAt, $intTotalColumn)
    {

        $gridHeaders = array_merge($this->arr_objHeaderStyle, $this->arr_objGridStyle);


        $colArr = array();

        for ($i = 0; $i < sizeof($arr_objData); $i++) {
            $row = $arr_objData[$i];
            $currCol = 0;
            for ($j = 0; $j < $intTotalColumn; $j++) {

                $cstring = PHPExcel_Cell::stringFromColumnIndex($j);
                if (isset($colArr[$cstring])) {
                    if ($colArr[$cstring] != 0) {
                        continue;
                    }
                }

                $cellData = $row[$currCol];

                //print_r($row[$currCol]);
                $gridHeaders = array_merge($this->setCellTextColor($cellData->textColor), $this->setCellBgColor($cellData->textBackGroundColor), $this->setCellTextAlignment($cellData->textAlignment), $this->setCellBorderColor($cellData->borderColor));

                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\//";

                if (preg_match($reg_exUrl, $cellData->text)) {
                    $x = $startAt + 1;
                    $y = PHPExcel_Cell::stringFromColumnIndex($j);
                    $coordinates = $y . $x;

                    $this->processImage($cellData->text, $coordinates);
                } else {
                    $this->obj_objSheet->setCellValueByColumnAndRow($j, $startAt + 1, $cellData->text);
                }


                if (isset($row[$currCol]->colSpan) && isset($row[$currCol]->rowSpan)) {

                    $cspan = $row[$currCol]->colSpan > $intTotalColumn ? $intTotalColumn : $row[$currCol]->colSpan;

                    $fromC = PHPExcel_Cell::stringFromColumnIndex($j);
                    $toC = PHPExcel_Cell::stringFromColumnIndex($j + $cspan - 1);

                    $fromR = $startAt + 1;
                    $toR = $fromR + ($row[$currCol]->rowSpan - 1);

                    $mergeRange = $fromC . $fromR . ":" . $toC . $toR;


                    $this->obj_objSheet->mergeCells($mergeRange);
                    $this->obj_objSheet->getStyle($mergeRange)->applyFromArray($gridHeaders);

                    $j += $cspan - 1;
                    $colArr[$col] = $row[$currCol]->rowSpan;

                } else if (isset($row[$currCol]->colSpan)) {

                    $cspan = $row[$currCol]->colSpan > $intTotalColumn ? $intTotalColumn : $row[$currCol]->colSpan;

                    $from = PHPExcel_Cell::stringFromColumnIndex($j);
                    $to = PHPExcel_Cell::stringFromColumnIndex($j + $cspan - 1);
                    $mergeRange = $from . '' . ($startAt + 1) . ':' . $to . '' . ($startAt + 1); //A1:B1

                    $this->obj_objSheet->mergeCells($mergeRange);
                    $this->obj_objSheet->getStyle($mergeRange)->applyFromArray($gridHeaders);

                    $j += $cspan - 1;

                } else if (isset($row[$currCol]->rowSpan)) {

                    $col = PHPExcel_Cell::stringFromColumnIndex($j);
                    $from = $startAt + 1;
                    $to = $from + ($row[$currCol]->rowSpan - 1);
                    $mergeRange = $col . $from . ':' . $col . $to; //ex A1:A2
                    $this->obj_objSheet->mergeCells($mergeRange);
                    $this->obj_objSheet->getStyle($mergeRange)->applyFromArray($gridHeaders);

                    $colArr[$col] = $row[$currCol]->rowSpan;
                }


                $this->obj_objSheet->getStyleByColumnAndRow($j, $startAt + 1)->applyFromArray($gridHeaders);

                if (isset($cellData->borderStyleBottom) && !empty($cellData->borderStyleBottom)) {
                    $this->obj_objSheet->getStyleByColumnAndRow($j, $startAt + 1)->applyFromArray($this->setCellBorderBottom($cellData->borderStyleBottom));
                }

                if ($cellData->textUnderline) {
                    $this->obj_objSheet->getStyleByColumnAndRow($j, $startAt + 1)->applyFromArray(
                        array(
                            'font' => array(
                                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
                            )
                        )
                    );
                }


                $currCol++;
            }

            if (sizeof($colArr) > 0) {
                foreach ($colArr as &$value) {
                    if ($value == 0) {
                        continue;
                    }
                    $value--;
                }
            }
            $startAt++;
        }
    }

    public function setGridDataToExcelWithColModel($arr_objGridData, $arr_objGridColModel)
    {
        set_time_limit(0);
        ini_set('memory_limit', '8048M');

        $afterHeader = sizeof($arr_objGridData->header);
        $afterContent = $afterHeader + sizeof($arr_objGridData->body);

        $this->loadGridContent($arr_objGridData->header, 0, $arr_objGridData->colNum);
        $this->loadGridContentWithColModel($arr_objGridData->body, $afterHeader, $arr_objGridColModel);
        $this->loadGridContent($arr_objGridData->footer, $afterContent, $arr_objGridData->colNum);

        $col = $arr_objGridData->frozenCol > 0 ? PHPExcel_Cell::stringFromColumnIndex($arr_objGridData->frozenCol + 1) : 'A';
        $this->obj_objSheet->freezePane($col . ($afterHeader + 1));
        $this->setAutoSizeColumnWidth($arr_objGridData->colNum);
    }

    public function loadGridContentWithColModel($arr_objData, $startAt, $arr_objGridColModel)
    {
        //$temp = array();
        for ($i = 0; $i < sizeof($arr_objData); $i++) {
            $row = $arr_objData[$i];

            $col = 0;

            for ($j = 0; $j < sizeof($arr_objGridColModel); $j++) {

                foreach ($row as $key => $value) {

                    if ($arr_objGridColModel[$j]->hidedlg) {
                        continue;
                    }

                    if (empty($arr_objGridColModel[$j]->hidden)) {
                        if ($arr_objGridColModel[$j]->index == $key) {
                            //$temp[$i][$key] = $value;

                            $gridHeaders = array_merge($this->setCellTextColor(), $this->setCellBgColor(), $this->setCellTextAlignment($arr_objGridColModel[$j]->align), $this->setCellBorderColor());
                            $this->obj_objSheet->setCellValueByColumnAndRow($col, $startAt + 1, $value);
                            $this->obj_objSheet->getStyleByColumnAndRow($col, $startAt + 1)->applyFromArray($gridHeaders);
                            $col++;
                            break;
                        }
                    }

                }
            }
            $startAt++;
        }
        //print_r($temp);
    }

}

?>