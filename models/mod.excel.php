<?php

include_once "../libs/PHPExcel/Classes/PHPExcel.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class ExcelAPI
{

    public $arr_strData;
    public $arr_strColModel;
    public $str_intTotalColumn;
    public $str_intTotalRow;
    public $obj_objExcel;
    public $obj_objWriter;
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
        $this->obj_objSheet->freezePane('A2');
        $this->obj_objSheet->getPageSetup()->setRowsToRepeatAtTop(array(1, 1));
        $this->obj_objSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    }

    public function getGridToExcel($arr_strData, $arr_strColModel)
    {
        set_time_limit(0);
        $this->arr_strData = $arr_strData;
        $this->arr_strColModel = $arr_strColModel;
        $this->str_intTotalRow = count($this->arr_strData);
        $this->str_intTotalColumn = count($this->arr_strData[0]);

        $this->showPopulateGridHeaders();
        $this->showPopulateGridData();
        $this->setAutoSizeColumnWidth();
    }

    public function decodeHTMLentities($value)
    {
        return html_entity_decode($value, ENT_COMPAT | ENT_HTML401 | ENT_NOQUOTES, "UTF-8");
    }

    public function showPopulateGridHeaders()
    {
        $gridHeaders = array_merge($this->arr_objHeaderStyle, $this->arr_objGridStyle);

        for ($j = 0; $j < $this->str_intTotalColumn; $j++) {
            $this->obj_objSheet->setCellValueByColumnAndRow($j, 1, $this->decodeHTMLentities($this->arr_strData[0][$j]));
            $this->obj_objSheet->getStyleByColumnAndRow($j, 1)->applyFromArray($gridHeaders);
        }
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
        $this->obj_objSheet->getStyle($cells)->applyFromArray($this->arr_objGridStyle);

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

        $height = ($height * 1.50) * (0.12135); //calculations for the Excel Row Height;
        $height = round($height, 2, PHP_ROUND_HALF_UP); // round up and two decimal places only;
        $return[] = $height;

        return $return;
    }

    public function showPopulateGridData()
    {

        for ($i = 2; $i <= $this->str_intTotalRow; ++$i) {
            for ($j = 0; $j < $this->str_intTotalColumn; ++$j) {

                $rowStyle = $this->arr_objGridStyle;

                if (($i % 2) != 0) {
                    $rowStyle = array_merge($this->arr_objGridStyle, $this->arr_objAltRow);
                    //$this->setCellStyles($j, $i, $this->arr_strColAlignment[$j]->columnAlignment, $rowStyle);
                }

                $coordinates = PHPExcel_Cell::stringFromColumnIndex($j) . $i;

                $value = $this->decodeHTMLentities($this->arr_strData[$i - 1][$j]);


                if ($this->arr_strData[0][$j] != "") {
                    $this->obj_objSheet->setCellValueByColumnAndRow($j, $i, $value);
                } else {
                    $this->processImage($value, $coordinates);
                }

                $this->setCellStyles($j, $i, $this->arr_strColModel[$j]->columnAlignment, $rowStyle);
            }
        }
    }

    public function setCellStyles($col, $row, $alignment, $style)
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

        $style = array_merge($style, $cellAlignment);
        $this->obj_objSheet->getStyleByColumnAndRow($col, $row)->applyFromArray($style);
    }

    public function setAutoSizeColumnWidth()
    {
        for ($j = 0; $j < $this->str_intTotalColumn; $j++) {
            if ($this->arr_strData[0][$j] != "") {
                $this->obj_objSheet->getColumnDimensionByColumn($j)->setAutoSize(true);
            }
        }
    }

    public function getExcelFile($fileName)
    {
        header("Content-Type: application/vnd.ms-excel';charset=UTF-8");
        header("Content-Disposition: inline;filename=" . $fileName . ".xls");
        //header('Cache-Control: max-age=0');
        $this->obj_objWriter = PHPExcel_IOFactory::createWriter($this->obj_objExcel, 'Excel5');
        $this->obj_objWriter->save("php://output");
    }

    public function getExcelToHTML()
    {
        $this->obj_objWriter = new PHPExcel_Writer_PDF($this->obj_objExcel);
        $this->obj_objWriter->buildCSS(true);
        return $this->obj_objWriter->generateSheetData();
    }


}

?>
