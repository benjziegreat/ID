<?php

class Language extends LanguageHelper{

    function __construct() {
        
    }
    
    public function getLaguageListArray(){
        
        $lang = (isset($_COOKIE["lang"])? $_COOKIE["lang"]: CURRENT_LANGUAGE);	
        $langDir=(isset($_COOKIE["langDIR"])? $_COOKIE["langDIR"]: CURRENT_LANGUAGE);	
        //$langPath=SITE_PATH.'\\language\\language.ini';
//        $langPath =  '../../../language/language.ini';
         $langPath =  '../../../language/language.'.$langDir.'.ini';
        return $this->iniFileToArray($this->getFileContent($langPath));

    }
    public function getModuleDictionary($strName){
        
        $lang = isset($_COOKIE["lang"])?$_COOKIE["lang"]:CURRENT_LANGUAGE;
        
        //$langPath=SITE_PATH.'\\language\\'.$lang.'\\'.$lang.'.'.$strName.'.ini';
        $langPath = '../../../language/'.$lang.'/'.$lang.'.'.$strName.'.ini';
        
        return $this->iniFileToArray($this->getFileContent($langPath));
        
    }
    
    public function getLaguageList(){	
        
        $lang=isset($_COOKIE["lang"])?$_COOKIE["lang"]:CURRENT_LANGUAGE;
        
        $arr_Language = $this->getLaguageListArray();
        
        //Formulate Language Options:
        echo '<select name = "language" onchange = "changeLang(this.value)" >';
        //	echo '<select name="language" onchange="javascript:alert(this.value);" >';
        foreach($arr_Language as $name=>$value){
            echo '<option value="'.trim($name ).'"'. (isset($lang) && trim($lang)==trim($name)?' selected ':'').'>'.trim($this->removeFirstLastCharQuote($value)).'</option>';
        }
        echo '</select>';
        
    }

    public function saveLanguage($filename,$langID, $langValue){
        
        
        try {
           
            $fileContent = file_get_contents($filename);
            $arrData = explode(chr(13),$fileContent);
            $oldValue = "";
            
            //$fileContent = str_replace($oldLineValue[1], $langID. '="' . $langValue .'"' , $fileContent);
            
            foreach ($arrData as $key=> $item){
                
                $listItem = explode("=",$item);
                
                if (trim($listItem[0]) == trim($langID)){
                    $oldValue = $item;
                    break;
                }
                /*
                if (ereg($langID, $item)){
                    $oldValue = $item;
                    break;
                }
                 * 
                 */
            }
            
            $fileHandle = fopen($filename, "w");
            $fileContent = str_replace($oldValue.'', $langID . ' = "' . $langValue .'"' , $fileContent);
            //print_r($fileContent);
            fwrite($fileHandle,$fileContent);
            fclose($fileHandle);
            
        }catch (Exception $ex){
            print_r($ex);
        }
       
    }
    
    public function saveLabel($filename, $labelID, $labelValue){
            
        
//        try {	
//            
//            $arrData = $this->iniFileToArray($this->getFileContent($filename));
//        /*		
//            if (is_writable($filename)) {
//                    echo 'The file is writable';
//            } else {
//                    echo 'The file is not writable';
//            }
//            */
//        //			echo '<pre>';
//        //			echo 'Old:';
//        //			print_r($arrData);
//            $arrData[$labelID]='"'.$labelValue.'"';	
//        //			echo 'Old:';
//        //			print_r($arrData);
//            $file = fopen($filename,'rb+');	// Open file for reading/writing
//
//            if(flock($file,LOCK_EX|LOCK_NB)){
//                ftruncate ($file,0); // Clear the file content
//                foreach($arrData as $key=>$value){
//                    fwrite($file, $key.'='.$value.chr(13)); 	
//                }		
//                flock($file,LOCK_UN);
//            }
//            
//            fclose($file); // Close the file
//            unset($file); // unset the file handle
//            sleep(1);		
//            
//        }
//        catch (Exception  $e){
//            //echo $e->__toString();
//        }	
//       
    }
	
    function defaultTrim($strValue, $trimCharList=" \t\n\r\0\x0B"){
        return  trim($strValue,$trimCharList);
    }

    function defaultStr($value, $defValue=''){
        return  isset($value) ?$value:$defValue;
    }

    function defaultNum($value, $defValue=0){
        return  isset($value) && is_numeric($value)?$value:$defValue;
    }

}

?>