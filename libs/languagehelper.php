<?php
///
/// Created By: Ayant P. Orcasitas
/// Date Created: 12-Dec-2011
/// Remarks: Contains common function that shall be used in the system
/// 

class LanguageHelper {

    function __construct() {
        
    }
    
    public function getFileContent($filename){
        
        $filename = str_replace('%uFEFF','',$filename);
        
        if (file_exists($filename) && filesize($filename)>0){
            
            $file = fopen($filename, 'rb');
            
            $data = fread($file, filesize($filename));
            fclose($file);
            
            return $data;
        }

    }

    public function iniFileToArray($data){
       /*Function that will convert the data to array
         Row delimiter : "chr(13)" or "enter" 
         Item Key and Value delimiter : "="
         Comment delimiter : if the first character is "#" and other unwante ascii character -> �(239)
         */
        
        $arrData = explode(chr(13),$data);
        $arrReturnValue = array();
        
        foreach($arrData as $val){
            
            $arrSub = explode("=",$val);
            
            //print_r($arrSub);echo ' : '. sizeof($arrSub) . '<br>';
            
            if (sizeof($arrSub) == 2){
                if (isset($arrSub[0]) && (substr(trim($arrSub[0]),0,1)!="#" && trim($arrSub[0])!='' )){                
                    $arrReturnValue[trim($arrSub[0])] = (isset($arrSub[1])? trim($arrSub[1]) : '');
                }
            }
        }

        return  $arrReturnValue;	
    }
	
	
    public function removeFirstLastCharQuote($text){
        /*Example = "Lastname"
         *Result = Lastname
        */
        return substr(substr($text,1),0,strlen($text)-2);
        
    }
    public function convertSJISToUTF8($strValue) {
        return mb_convert_encoding('UFT-8', 'SJIS', $$strValue);       
    }
    public function convertArraySJISToUTF8($arrValue) {
        
        $retValue = mb_convert_variables("UTF-8", "SJIS", $arrValue);

        return $arrValue;

         /*
        if (!$retValue ){
            return  "Wala";
        }
        else{
            return $arrValue;
        }
          * 
          */
    }
}






?>