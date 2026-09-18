<?php
/**
 *  PHPExcel
 *
 *  Copyright (c) 2006 - 2014 PHPExcel
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with this library; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *  @category    PHPExcel
 *  @package     PHPExcel_Writer_PDF
 *  @copyright   Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 *  @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 *  @version     1.8.0, 2014-03-02
 */


/**  Require mPDF library */
$pdfRendererClassFile = PHPExcel_Settings::getPdfRendererPath() . '/mpdf.php';
if (file_exists($pdfRendererClassFile)) {
    require_once $pdfRendererClassFile;
} else {
    throw new PHPExcel_Writer_Exception('Unable to load PDF Rendering library');
}

/**
 *  PHPExcel_Writer_PDF_mPDF
 *
 *  @category    PHPExcel
 *  @package     PHPExcel_Writer_PDF
 *  @copyright   Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Writer_PDF_mPDF extends PHPExcel_Writer_PDF_Core implements PHPExcel_Writer_IWriter
{
    /**
     *  Create a new PHPExcel_Writer_PDF
     *
     *  @param  PHPExcel  $phpExcel  PHPExcel object
     */
    public function __construct(PHPExcel $phpExcel)
    {
        parent::__construct($phpExcel);
    }

    /**
     *  Save PHPExcel to file
     *
     *  @param     string     $pFilename   Name of the file to save as
     *  @param     string     $pFiletype        Type of the file Document to Format
     *  @throws    PHPExcel_Writer_Exception
     */
    public function save($pFilename = NULL, $pFiletype = NULL)
    {
        $fileHandle = parent::prepareForSave($pFilename);

        //  Default PDF paper size
        $paperSize = 'LETTER';    //    Letter    (8.5 in. by 11 in.)

        //  Check for paper size and page orientation
        if (is_null($this->getSheetIndex())) {
            $orientation = ($this->_phpExcel->getSheet(0)->getPageSetup()->getOrientation()
                == PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
                    ? 'L'
                    : 'P';
            $printPaperSize = $this->_phpExcel->getSheet(0)->getPageSetup()->getPaperSize();
            $printMargins = $this->_phpExcel->getSheet(0)->getPageMargins();
        } else {
            $orientation = ($this->_phpExcel->getSheet($this->getSheetIndex())->getPageSetup()->getOrientation()
                == PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
                    ? 'L'
                    : 'P';
            $printPaperSize = $this->_phpExcel->getSheet($this->getSheetIndex())->getPageSetup()->getPaperSize();
            $printMargins = $this->_phpExcel->getSheet($this->getSheetIndex())->getPageMargins();
        }
        $this->setOrientation($orientation);

        //  Override Page Orientation
        if (!is_null($this->getOrientation())) {
            $orientation = ($this->getOrientation() == PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT)
                ? PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT
                : $this->getOrientation();
        }
        $orientation = strtoupper($orientation);

        //  Override Paper Size
        if (!is_null($this->getPaperSize())) {
            $printPaperSize = $this->getPaperSize();
        }

        if (isset(self::$_paperSizes[$printPaperSize])) {
            $paperSize = self::$_paperSizes[$printPaperSize];
        }

        //  Create PDF
        $pdf = new mpdf();
        $ortmp = $orientation;
        $pdf->_setPageSize(strtoupper($paperSize), $ortmp);
        $pdf->DefOrientation = $orientation;
        $pdf->keep_table_proportions  = true;
        $pdf->AddPage($orientation);

        //  Document info
        $pdf->SetTitle($this->_phpExcel->getProperties()->getTitle());
        $pdf->SetAuthor($this->_phpExcel->getProperties()->getCreator());
        $pdf->SetSubject($this->_phpExcel->getProperties()->getSubject());
        $pdf->SetKeywords($this->_phpExcel->getProperties()->getKeywords());
        $pdf->SetCreator($this->_phpExcel->getProperties()->getCreator());


        $html = $this->generateHTMLHeader(FALSE).$this->generateSheetData().$this->generateHTMLFooter();

        $dom = new DomDocument();
        $dom->loadHTML($html);

        if($pFiletype == 'corner'){
            $page_break = $dom->getElementsByTagName("div");

            foreach($page_break as $key=>$p){
                $page = $page_break->item($key);
                $page->parentNode->removeChild($page);
            }

            $tables = $dom->getElementsByTagName("table");

            foreach($tables as $k=>$t){
                if((($k+1)%2) == 0){
                    $style = $t->getAttribute("style");
                    $t->removeAttribute("style");
                    $t->setAttribute("style", $style."; margin-top: 35pt;");
                }
            }
        }

        $tables = $dom->getElementsByTagName("table");

        foreach ($tables as $t) {
//            $t->removeAttribute("border");
//            $t->removeAttribute("style");
            $t->removeAttribute("cellspacing");
            $t->removeAttribute("cellpadding");

            $t->setAttribute("cellspacing", "0");
            $t->setAttribute("cellpadding", "0");
        }

        $xpath = new DOMXPath($dom);

        $ret = $xpath->query("//td[@rowspan='3'][@colspan='2']");

        foreach($ret as $v){
            $img = $dom->createElement("img");
            $img->setAttribute("src", "nkym_logo.JPG");
            $img->setAttribute("width", "100");

            $prevText = $v->nodeValue;
            $prevText = explode("\n",$prevText);

            $v->nodeValue = "";


            //$v->appendChild($prev_content);
            $v->appendChild($img);
            $v->appendChild($dom->createElement("br"));

            foreach($prevText as $k=>$text){
                $v->appendChild($dom->createTextNode($text));
                if($k != (count($prevText)-1)){
                    $v->appendChild($dom->createElement("br"));
                }
            }

        }


        $html = $dom->saveHTML();

        $pdf->debug = true;
        $pdf->WriteHTML($html);

//        echo $html;
        
//          Write to file
        fwrite($fileHandle, $pdf->Output('', 'S'));

		parent::restoreStateAfterSave($fileHandle);
    }



}
