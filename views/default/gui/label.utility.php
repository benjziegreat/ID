
<?php
    error_reporting(E_ALL ^ E_WARNING);
    ini_set("display_errors", 0);
    include_once '../../../libs/include.view.php';
    
    $view = new View();
   
    $view->action = (isset($_GET['ACTION'])? $_GET['ACTION'] : null);
    $view->appName = (isset($_POST["AppName"])? $_POST["AppName"] : null);
    $view->labelID = (isset($_POST["LabelID"])? $_POST["LabelID"] : null);
    $view->labelName = (isset($_POST["LabelName"])? $_POST["LabelName"] : null);
    
    
?>

<?php 
    if ( $view->action == "show"){ ?>
        
        <input type="hidden" id="AppName" value="<?php  echo $view->appName; ?>"/>
        <input type="hidden" id="LabelID" value="<?php  echo $view->labelID; ?>"/>
        <input type="hidden" id="LabelName" value="<?php  echo $view->labelName; ?>"/>
        
<?php

        $view->listGridColumnIDs = explode("|",(isset($_POST["GridColumnLanguageIDs"])? $_POST["GridColumnLanguageIDs"] : ''));
        
	foreach($view->getLaguageListArray() as $name => $value){
            
            $langPath = '../../../language/'.$name.'/'.$name.'.'.$view->appName.'.ini';		
            $lblArr = $view->iniFileToArray($view->getFileContent($langPath));
?>
            <?php 
            
                $curLang = str_replace('%uFEFF','', isset($_COOKIE["lang"]) ? $_COOKIE["lang"]:CURRENT_LANGUAGE);
                
                if (sizeof($view->listGridColumnIDs)>1){
                    
                    /* show only on current language.
                     * if multiple
                    */
                    
                    if ($curLang == $name){?>
        
                        <?php echo $view->removeFirstLastCharQuote($value); ?>: </br>
                        <?php
                        foreach ($view->listGridColumnIDs as $key => $item ) { ?>
                        
                            <div style ="float:left;margin:2px">
                                <?php 
                                    $itemColumns = explode(":",$item);
                                    $itemColumnModel =  $itemColumns[0];
                                    $itemColumnHeaderID =  $itemColumns[1];
                                    
                                    echo "<label class = 'labelGridChange'>[" .$view->removeFirstLastCharQuote($lblArr[$itemColumnHeaderID]). "]</label>";
                                ?> 
                                <div><textarea 
                                        class = "labelTextArea" 
                                        id = "<?php  echo $item ?>" 
                                        name ="<?php echo $view->removeFirstLastCharQuote($lblArr[$itemColumnHeaderID]);?>" 
                                        onchange = "languageOnChange(this)"
                                     ><?php  echo $view->removeFirstLastCharQuote($lblArr[$itemColumnHeaderID]); ?></textarea>
                                </div>
                            </div>

                        <?php 
                        }
                    }
                    
                }else{ ?>
                            
                    <?php echo $view->removeFirstLastCharQuote($value); ?>: </br>
                    <textarea class = "labelTextArea" id = "<?php  echo $name ?>"><?php  echo $view->removeFirstLastCharQuote($lblArr[$view->labelID]); ?></textarea>
                    <br/>
            <?php    
                }
             ?>
            
            
<?php 
	}
        
    }else {
        
        $view->listGridColumnValues = (isset($_POST["GridColumnLanguageValues"])? $_POST["GridColumnLanguageValues"] : null);
        $curLang = str_replace('%uFEFF','', isset($_COOKIE["lang"]) ? $_COOKIE["lang"]:CURRENT_LANGUAGE);
        
        if (sizeof($view->listGridColumnValues) > 0){
            
            $langFolder = '../../../language/'.$curLang.'/';
            $langPath = $langFolder.$curLang.'.'.$view->appName.'.ini';	

            foreach ($view->listGridColumnValues as $key => $value){
                //example $key = Code:LBL_CODE.
                //$columnHeaderID = LBL_CODE.
                
                $column = explode(":",$key);
                $columnHeaderID = $column[1];
                
                $view->saveLanguage($langPath,$columnHeaderID,$value);
            }

        }else{
            
            $view->labelData = $_POST;
            
            foreach($view->getLaguageListArray() as $name=>$value){

                $langFolder = '../../../language/'.$name.'/';
                $langPath = $langFolder.$name.'.'.$view->appName.'.ini';		

                if (!file_exists($langPath)){

                    if(!file_exists($langFolder)) mkdir($langFolder,0777);

                    $newfile = fopen($langPath,'w');
                    fclose($newfile);
                    unset($newfile);
                    $isOk = true; 
                }

               if(str_replace('%uFEFF','',$name) == $curLang) {
                   echo  $view->defaultTrim($view->labelData[$name]);
               }
               
               //$view->saveLabel($langPath,$view->labelID,$view->labelData[$name]);
               $view->saveLanguage($langPath,$view->labelID,$view->labelData[$name]);

            }   
        }
        
}


?>
