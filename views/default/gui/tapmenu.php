<?php
if($GLOBALS['strModuleInfoSystemgroup']=='system'){
  $GLOBALS['strModuleInfoSystemgroup'] = 'pdc';
}
include('view.'.$GLOBALS['strModuleInfoSystemgroup'].'.tapmenu.php');
?>