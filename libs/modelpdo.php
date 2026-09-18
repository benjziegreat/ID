<?php 

include_once 'databasepdo.php';

abstract class ModelPDO{
    protected $db = null;
    
    public function __construct($dsn) {
        
        if (isset($dsn)){
            $this->db = new DatabasePDO($dsn);
        }
        
    }
    public  function getJSonJQGridPagingResponse($strSQL, $strSortFieldDefault, $isConvertToSJIS = false ){
        
         //JQGrid Default 
        //===========================================================================================================
        $lngPage        = $_GET['page']; // get the requested page 
        $lngLimitEnd    = $_GET['rows']; // get how many rows we want to have into the grid 
        $strSortField   = $_GET['sidx']; // get index row - i.e. user click to sort 
        $strSortType    = $_GET['sord']; // get the direction

        //Set Defaults
        $lngPage        = ((($lngPage + 0)== 0)? 1 : $lngPage);
        $lngLimitEnd    = ((($lngLimitEnd + 0)== 0)? 1 : $lngLimitEnd);
        $strSortField   = (empty($strSortField)? $strSortFieldDefault : $strSortField);
        $strSortType    = (empty($strSortType)? "ASC" : $strSortType);
       //===========================================================================================================

        
        $strSQLCount = "SELECT COUNT(*) as RowCount FROM (" . $strSQL . " )c";        
        $arrRowCount = $this->db->fetchAllPDO($strSQLCount);
        $lngRowCount = $arrRowCount[0]["RowCount"];
        
        $lngTotalPages = (($lngRowCount > 0)?  ceil($lngRowCount/$lngLimitEnd) : 0);
        $lngPage = (($lngPage > $lngTotalPages)? $lngTotalPages : $lngPage);
        $lngLimitStart =$lngLimitEnd * $lngPage - $lngLimitEnd;
        $lngLimitStart = ($lngLimitStart<0? 0 :$lngLimitStart);
  
        $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType . ' LIMIT ' . $lngLimitStart . ',' . $lngLimitEnd ;
        
        
        $rows =  ($isConvertToSJIS? $this->convertArraySJISToUTF8($this->db->fetchAllPDO($strSQL)):$this->db->fetchAllPDO($strSQL));
       
        $jqResponse->page = $lngPage;
        $jqResponse->total = $lngTotalPages;
        $jqResponse->records = $lngRowCount;
        $jqResponse->rows = $rows;
        
        return json_encode($jqResponse);
      
    }
    public  function getJSonJQGridResponse($strSQL, $strSortFieldDefault,$lngRowLimit = 0,$isConvertToSJIS = false ){
        
        //JQGrid Default 
        //===========================================================================================================
        $strSortField   = $_GET['sidx']; // get index row - i.e. user click to sort 
        $strSortType    = $_GET['sord']; // get the direction

        $strSortField   = (empty($strSortField)? $strSortFieldDefault : $strSortField);
        $strSortType    = (empty($strSortType)? "ASC" : $strSortType);
       //===========================================================================================================

        if ($lngRowLimit > 0){
            $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType . ' LIMIT ' . $lngRowLimit;
        }else{
            $strSQL = $strSQL . " ORDER BY " . $strSortField . ' ' . $strSortType;
        }
        
        //print_r($strSQL);
        
        $rows =  ($isConvertToSJIS? $this->convertArraySJISToUTF8($this->db->fetchAllPDO($strSQL)):$this->db->fetchAllPDO($strSQL));
         
        $jqResponse->page = 1;
        $jqResponse->total = sizeof($rows);
        $jqResponse->records = sizeof($rows);
        $jqResponse->rows = $rows;
        
        return json_encode($jqResponse);
        
    }
}

?>
