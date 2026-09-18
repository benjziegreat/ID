<?php

class Template extends Language {

    private $str_ProgramTitle;
    private $str_ModuleTitle;

    function __construct() {
        
    }

    public function setProgramTitle($strProgramTile) {
        $this->str_ProgramTitle = $strProgramTile;
    }

    public function setModuleTitle($strModuleTile) {
        $this->str_ModuleTitle = $strModuleTile;
    }

    public function getModuleTitle() {
        return $this->str_ModuleTitle;
    }

    public function showHeader() {


        foreach ($this->getModuleDictionary('header') as $key => $val) {

            $$key = $this->removeFirstLastCharQuote($val);
        }

        // require_once('views/'.CURRENT_THEME.'/header.php');
    }

    public function showFooter() {

        foreach ($this->getModuleDictionary('footer') as $key => $val) {
            $$key = $this->removeFirstLastCharQuote($val);
        }
        // require_once('views/'.CURRENT_THEME.'/header.php');
        // require_once('views/'.CURRENT_THEME.'/footer.php');
    }

    public function showProgramTitle() {
        echo $this->str_ProgramTitle;
    }

    public function showModuleTitle() {
        echo $this->str_ModuleTitle;
    }

    public function showFile($strTypeDesc) {
        switch ($strTypeDesc) {
            case 'style_sheet':
                $file = "style.css";
                break;
        }

        echo 'views/' . CURRENT_THEME . '/' . $file;
    }

    public function includeJS($strJsFile) {
        echo '<script type="text/javascript" src="' . URL . 'views/' . CURRENT_THEME . '/js/' . $strJsFile . '.js"></script>';
    }

    public function includeJSPath($strJsFilePath) {
        echo '<script type="text/javascript" src="' . $strJsFilePath . '"></script>';
    }

    public function includeCSS($strCSSFilePath) {
        echo '<link rel="stylesheet" href="' . $strCSSFilePath . '"/>';
    }

    public function getDir($dir = 'active') {

        switch ($dir) {
            case 'active':
                return 'views/' . CURRENT_THEME;
                break;
        }
    }

    public function showDir($dir = 'active') {
        echo $this->getDir($dir);
    }

    public function showUserAccess() {

        foreach ($this->getModuleDictionary('useraccess') as $key => $val) {

            $$key = $this->removeFirstLastCharQuote($val);
        }
        require_once('useraccess.php');
        //require_once('views/'.CURRENT_THEME.'/useraccess.php');
    }

    public function showTapMenu() {

        foreach ($this->getModuleDictionary('useraccess') as $key => $val) {

            $$key = $this->removeFirstLastCharQuote($val);
        }
        require_once('tapmenu.php');
        //require_once('views/'.CURRENT_THEME.'/useraccess.php');
    }

    public function showSideMenu() {

        foreach ($this->getModuleDictionary('useraccess') as $key => $val) {

            $$key = $this->removeFirstLastCharQuote($val);
        }
        require_once('sidemenu.php');
        //require_once('views/'.CURRENT_THEME.'/useraccess.php');
    }

    public function getLoginUserID() {

        $str_intUserID = "";

        if (isset($_COOKIE['loginUserID'])) {
            $str_intUserID = $_COOKIE['loginUserID'];
        }

        return $str_intUserID;
    }

    public function showLoginUserID() {

        echo $this->getLoginUserID();
    }

    public function getLoginUserName() {
        $str_UserName = "";

        if (isset($_COOKIE['loginUserName'])) {
            $str_UserName = $_COOKIE['loginUserName'];
        }

        return mb_convert_encoding($str_UserName, 'UTF-8', 'SJIS');
    }

    public function showLoginUserName() {

        echo $this->getLoginUserName();
    }

}

?>
