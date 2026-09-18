<?php

    error_reporting(E_ALL ^ E_WARNING);

    include_once 'libs/include.index.php';

    
    if (!isset ($_COOKIE['loginUserID']) || count_chars(trim($_COOKIE['loginUserID']))== 0 ){
        header('location: '.ROOT_VIEW.'/' .CURRENT_THEME.'/gui/main.login.php');
    }
    else{
        header('location: '.ROOT_VIEW.'/' .CURRENT_THEME.'/gui/main.php');
    }
    
?>
