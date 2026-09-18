<?php

include_once 'database.php';
include_once 'simpleimage.php';
include_once 'resize.php';
include_once 'common.php';

abstract class Model {

    protected $db = null;
    protected $img = null;
     
    public function __construct($dbHost, $dbUser, $dbPass, $dbCharSet) {
        //instanciate database  uses      
        $this->db = new Database($dbHost, $dbUser, $dbPass, $dbCharSet);
        $this->img = new SimpleImage();
    }

    public function getJSonJQGridPagingResponse($strSQL, $strSortFieldDefault, $isConvertToSJIS = false) {

        //JQGrid Default 
        //===========================================================================================================
        $lngPage = $_GET['page']; // get the requested page 
        $lngLimitEnd = $_GET['rows']; // get how many rows we want to have into the grid 
        $strSortField = $_GET['sidx']; // get index row - i.e. user click to sort 
        $strSortType = $_GET['sord']; // get the direction
        //Set Defaults
        $lngPage = ((($lngPage + 0) == 0) ? 1 : $lngPage);
        $lngLimitEnd = ((($lngLimitEnd + 0) == 0) ? 1 : $lngLimitEnd);
        $strSortField = (empty($strSortField) ? $strSortFieldDefault : $strSortField);
        if ($strSortFieldDefault != 'null') {
            $strSortType = (empty($strSortType) ? "ASC" : $strSortType);
        } else {
            $strSortType = "";
        }
        //===========================================================================================================


        $strSQLCount = "SELECT COUNT(*) as RowCount FROM (" . $strSQL . " )c";
        $arrRowCount = $this->db->fetchAll($strSQLCount);
        $lngRowCount = $arrRowCount[0]["RowCount"];

        $lngTotalPages = (($lngRowCount > 0) ? ceil($lngRowCount / $lngLimitEnd) : 0);
        $lngPage = (($lngPage > $lngTotalPages) ? $lngTotalPages : $lngPage);
        $lngLimitStart = $lngLimitEnd * $lngPage - $lngLimitEnd;
        $lngLimitStart = ($lngLimitStart < 0 ? 0 : $lngLimitStart);

        if ($strSortFieldDefault != 'null') {
            $strSQL = $strSQL . " ORDER BY " . $strSortField;
        }
        $strSQL = $strSQL . ' ' . $strSortType . ' LIMIT ' . $lngLimitStart . ',' . $lngLimitEnd;


        //return $strSQL;

        $rows = ($isConvertToSJIS ? $this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)) : $this->db->fetchAll($strSQL));

        $jqResponse = new stdClass();

        $jqResponse->sql = $strSQL;
        $jqResponse->page = $lngPage;
        $jqResponse->total = $lngTotalPages;
        $jqResponse->records = $lngRowCount;
        $jqResponse->rows = $rows;

        return json_encode($jqResponse);
    }
    
    public function getJSonJQGridResponse($strSQL, $strSortFieldDefault, $lngRowLimit = 0, $isConvertToSJIS = false) {

        //JQGrid Default 
        //===========================================================================================================
        $strSortField = $_GET['sidx']; // get index row - i.e. user click to sort 
        $strSortType = $_GET['sord']; // get the direction

        $strSortField = (empty($strSortField) ? $strSortFieldDefault : $strSortField);
        $strSortType = (empty($strSortType) ? "ASC" : $strSortType);
        //===========================================================================================================

        if ($lngRowLimit > 0) {
            $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType . ' LIMIT ' . $lngRowLimit;
        } else {
            $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType;
        }

        //print_r($strSortField . '<br/>');
        //print_r($strSQL);

        $rows = ($isConvertToSJIS ? $this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)) : $this->db->fetchAll($strSQL));

        $jqResponse = new stdClass();

        $jqResponse->sql = $strSQL;
        $jqResponse->page = 1;
        $jqResponse->total = sizeof($rows);
        $jqResponse->records = sizeof($rows);
        $jqResponse->rows = $rows;

        return json_encode($jqResponse);
    }
    
    public function getJSonJQGridResponseLimit($strSQL, $strSortFieldDefault, $lngRowLimit = 0, $isConvertToSJIS = false) {

        //JQGrid Default 
        //===========================================================================================================
        $strSortField = $_GET['sidx']; // get index row - i.e. user click to sort 
        $strSortType = $_GET['sord']; // get the direction

        $strSortField = (empty($strSortField) ? $strSortFieldDefault : $strSortField);
        $strSortType = (empty($strSortType) ? "ASC" : $strSortType);
        //===========================================================================================================

//        if ($lngRowLimit > 0) {
//            $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType . ' LIMIT ' . $lngRowLimit;
//        } else {
//            $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType. ' limit 1000';
//        }
        $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType. ' limit 500';

        //print_r($strSortField . '<br/>');
        //print_r($strSQL);

        $rows = ($isConvertToSJIS ? $this->convertArraySJISToUTF8($this->db->fetchAll($strSQL)) : $this->db->fetchAll($strSQL));

        $jqResponse = new stdClass();

        $jqResponse->sql = $strSQL;
        $jqResponse->page = 1;
        $jqResponse->total = sizeof($rows);
        $jqResponse->records = sizeof($rows);
        $jqResponse->rows = $rows;

        return json_encode($jqResponse);
    }

   
  
    public function convertArraySJISToUTF8($arrValue) {

        $retValue = mb_convert_variables("UTF-8", "SJIS-win", $arrValue);
        return $arrValue;
    }

    public function convertArrayUTF8ToSJIS($arrValue) {

        $retValue = mb_convert_variables("SJIS-win", "UTF-8", $arrValue);
        return $arrValue;
    }

    public function convertToUTF8Searching($arrColumns, $strSearchKey) {
        $converted = array();

        foreach ($arrColumns as $column) {
            //            $converted[] = "CONVERT({$column} using utf8)  COLLATE utf8_unicode_ci LIKE '%{$strSearchKey}%'";
            $converted[] = "CONVERT({$column} using utf8)  COLLATE utf8_unicode_ci LIKE CONCAT('%', CAST('{$strSearchKey}' AS CHAR CHARACTER  SET utf8), '%')";
        }


        return "(\r\n" . implode("\r\nOR ", $converted) . "\r\n)";
    }

}

?>