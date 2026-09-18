<?php

include_once 'passencryption.php';

class View extends Template {

    var $model = null;

    function __construct($strModuleName = '', $strHeaderPath = '', $strFooterPath = '') {
        $encryption = new EncyptionCustomize();
        //$encrypted = $encryption->Newncrpting('cjcdigos', 'TEST');
        //$decrypted = $encryption->Newdcryting('cjcdigos', substr($encrypted, 0, strlen($encrypted) - 1));
       // print_r(substr($encrypted, 0, strlen($encrypted) - 1) . '<br>' . trim($decrypted));   
       //print_r($_SERVER["HTTP_HOST"]);


        //  $encrypted = $encryption->Newncrpting('mypassword', 'rootroot');
        // $decrypted = $encryption->Newdcryting('mypassword', substr($encrypted, 0, strlen($encrypted) - 1));
		
        //TODO...
        parent::__construct();

        if (!empty($strModuleName)) {
            $this->listModuleLangVariables = $this->getModuleLanguageVariables($strModuleName);
        }
        list($this->waste, $this->modtype) = explode('.', $strModuleName);
        $this->strHeaderPath = (empty($strHeaderPath) ? 'header.php' : $strHeaderPath);
        $this->strFooterPath = (empty($strFooterPath) ? 'footer.php' : $strFooterPath);


        $this->strHeaderPathCommon = (empty($strHeaderPath) ? 'headercommon.php' : $strHeaderPath);
    }

    public function getModuleLanguageVariables($strModuleName) {

        $arrValues = array();

        foreach ($this->getModuleDictionary($strModuleName) as $key => $val) {

            $arrValues[$key] = $this->removeFirstLastCharQuote($val);
            //$$key = $this->removeFirstLastCharQuote($val);
        }

        return $arrValues;
    }

    public function show($strRoot, $strModuleName) {

        foreach ($this->getModuleDictionary($strModuleName) as $key => $val) {

            $$key = $this->removeFirstLastCharQuote($val);
        }

        require($strRoot . '/' . $strModuleName . '.php');
    }

    public function loginCheck() {

        if (!isset($_COOKIE['loginUserID']) || count_chars(trim($_COOKIE['loginUserID'])) == 0) {
//            header('location: main.login.php');
//            header('Location: http://192.168.0.3/NTC_PMS/views/default/gui/main.login.php');
//            header('Location: http://192.168.0.3/NTC_HRMS/', true, 302);
        }
    }

    public function loadModel($strModelPath, $strModelName) {
        /*
          Subject:Instanciate model. example:$strName = (cont.support.request)
         * Rules: elimate ("cont: and ".") to get the partial class name of the model to instanciate
         *        then concatenated with "model" at the beginning. and the path only "cont." will be elimated.
         *
         * Result Model Name: modelsupportrequest
         * Result Model Path: models/mod.support.request.php


          $modelName = explode('.',$strName);
          $strPath =  implode('.' ,$modelName);

          $modelName = 'model' . implode('',$modelName);
          $strPath = 'models/mod.'.$strPath.'.php';


          if (file_exists($strPath)) {

          require $strPath;

          $this->model = new $modelName();


          }
         */

        if (file_exists($strModelPath)) {

            require $strModelPath;
            $this->model = new $strModelName();
        } else {
            echo "Model Not Found";
        }
    }

    public function loadHeader() {

        if (file_exists($this->strHeaderPath)) {
            require $this->strHeaderPath;
        } else {
            echo $this->strHeaderPath . " Header Not Found";
        }
    }

    public function loadHeaderCommon() {

        if (file_exists($this->strHeaderPathCommon)) {
            require $this->strHeaderPathCommon;
        } else {
            echo $this->strHeaderPathCommon . " Header Not Found";
        }
    }

    public function loadHeaderInline() {

        if (file_exists($this->strHeaderPathCommon)) {
            require $this->strHeaderPathCommon;
        } else {
            echo $this->strHeaderPathCommon . " Header Not Found";
        }
    }

    public function loadFooter() {

        if (file_exists($this->strFooterPath)) {
            require $this->strFooterPath;
        } else {
            echo $this->strFooterPath . " Footer Not Found";
        }
    }

    public function includeJSPathVariable($returnMessage) {
        $encryption = new EncyptionCustomize();
        return true;
        // if ($_SERVER["HTTP_HOST"] == trim($encryption->Newdcryting('cjcdigos', 'U2FsdGVkX1+l+xmbakaAZYKYlphmOmFBGWeNGzn9Qr8'))) {
        //     //access granted  U2FsdGVkX1+l+xmbakaAZYKYlphmOmFBGWeNGzn9Qr8-cjcthis  .2=U2FsdGVkX1+l8dYh3YLhX+W7WL6vrma1vqR9OtLdv/o 3.local -U2FsdGVkX19zOPVNSLe313NHjswoMS2cfWIagS7L1zg
        //     copy('variable.ini', 'temp.ini');
        //     return true;
        // }else if ($_SERVER["HTTP_HOST"] == trim($encryption->Newdcryting('cjcdigos', 'U2FsdGVkX19zOPVNSLe313NHjswoMS2cfWIagS7L1zg'))) {
        //     //access 3.local -U2FsdGVkX19zOPVNSLe313NHjswoMS2cfWIagS7L1zg
        //     copy('variable.ini', 'temp.ini');
        //     return true;
        // } else if ($_SERVER["HTTP_HOST"] == trim($encryption->Newdcryting('cjcdigos', 'U2FsdGVkX1/FWRMepi95OFFtmP377P3pqv+EgSSvY2c'))) {
        //     //access granted  U2FsdGVkX1/FWRMepi95OFFtmP377P3pqv+EgSSvY2c=desktop-5p5jpdt
        //     copy('variable.ini', 'temp.ini');
        //     return true;
        // }  else if ($_SERVER["HTTP_HOST"] == trim($encryption->Newdcryting('cjcdigos', 'U2FsdGVkX1+A7FmBSHtJpJXNTt5nDxuSMSzeATfvrco'))) {
        //     //access granted  U2FsdGVkX1+A7FmBSHtJpJXNTt5nDxuSMSzeATfvrco=192.168.1.2
        //     copy('variable.ini', 'temp.ini');
        //     return true;
        // }else if ($_SERVER["HTTP_HOST"] == trim($encryption->Newdcryting('cjcdigos', 'U2FsdGVkX18KWdClRlUUTCqltFLAqM7gm027pM7Mf4E'))) {
        //     //access granted  U2FsdGVkX18KWdClRlUUTCqltFLAqM7gm027pM7Mf4E=apps.cjc.edu.ph
        //     copy('variable.ini', 'temp.ini');
        //     return true;
        // } else if ($_SERVER["HTTP_HOST"] == trim($encryption->Newdcryting('cjcdigos', 'U2FsdGVkX1838DUpMJPfqM72xo3piSMyjuI58L+FWKc'))) {
        //     //access granted  U2FsdGVkX1838DUpMJPfqM72xo3piSMyjuI58L+FWKc=iapps.cjc.edu.ph
        //     copy('variable.ini', 'temp.ini');
        //     return true;
        // }else {         
        //     copy('tempEmpty.ini', 'temp.ini');
        //     die('<B style="font-size:24px;color:green;">' . $returnMessage . '</B>');
        // }
    }

}

?>
