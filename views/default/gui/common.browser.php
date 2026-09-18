 
<!-- 
Browser Common Container
-->

<?php
// Use an autoloader!
error_reporting(E_ALL ^ E_WARNING);
include_once '../../../libs/include.view.php';

$strModuleName = 'common.browser';

$view = new View($strModuleName);

$id = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<input id = "txtBrowserOwner<?php echo $id; ?>" type = "hidden" name="txtBrowserOwner<?php echo $id; ?>"  style =" width: 88%" hidden="true" readonly="true"</input>
<input id = "txtBrowserOwnerRow<?php echo $id; ?>" type = "hidden" name="txtBrowserOwnerRow<?php echo $id; ?>"  style =" width: 88%" hidden="true" readonly="true"</input>
<input id = "txtBrowserOwnerCol<?php echo $id; ?>" type = "hidden" name="txtBrowserOwnerCol<?php echo $id; ?>"  style =" width: 88%" hidden="true" readonly="true"</input>
<input id = "txtBrowserOwnerCellName<?php echo $id; ?>" type = "hidden" name="txtBrowserOwnerCellName<?php echo $id; ?>"  style =" width: 88%" hidden="true" readonly="true"</input>

<div id="listCommonBrowser<?php echo $id; ?>" >
    <div id="listCommonBrowserHeader<?php echo $id;?>">
        
    <label id="<?php echo $strModuleName . '-LBL_SEARCH'; ?>"><?php echo $view->listModuleLangVariables["LBL_SEARCH"] ?>  </label>

    <input id = "txtSearchCommonBrowser<?php echo $id; ?>" 
           class="common-textbox"
           style="width: 85%;height: 1.8em;"
           type = "text" 
           name="Search"  
           value="" 
           onkeyup="doEventCommonBrowser(event, $('#txtBrowserOwner<?php echo $id; ?>').val(),$('#txtBrowserOwnerRow<?php echo $id; ?>').val(),$('#txtBrowserOwnerCol<?php echo $id; ?>').val(),$('#txtBrowserOwnerCellName<?php echo $id; ?>').val());"/>
           
    <input  id="<?php echo $strModuleName . '-LBL_BUTTON_SEARCH' ?>"
            type = "button"
            class="btn-browser-inline"
            style="width: 28px;height: 22px;margin-top: -3px;"
            onclick = "doEventCommonBrowser(event, $('#txtBrowserOwner<?php echo $id; ?>').val());" />    
    
    </div>

    <div style="height: 5px;"></div>
    <table id = "tblListCommonBrowser<?php echo $id; ?>" ></table>
    <div id ="pagerCommonBrowser<?php echo $id; ?>"></div>

    <div style="height: 1px;background-color: #CCC;margin-top: 3px;"></div>

    <div id="divPdcStockInfoActionCommand<?php echo $id; ?>" style="height: 39px; margin-top: 5px; float: right;">
        <input  id="btnOk<?php echo $id; ?>" type = "button" value = "<?php echo $view->listModuleLangVariables["LBL_OK"] ?>" class="btn-action-command-common" style="width: 80px;height:30px; " onclick = "doSetBrowserSelected($('#txtBrowserOwner<?php echo $id; ?>').val(),$('#txtBrowserOwnerRow<?php echo $id; ?>').val(),$('#txtBrowserOwnerCol<?php echo $id; ?>').val(),$('#txtBrowserOwnerCellName<?php echo $id; ?>').val())" ></input>
        <input  id="btnCancel<?php echo $id; ?>" type = "button" value = "<?php echo $view->listModuleLangVariables["LBL_CLOSE"] ?>" class="btn-action-command-common" style="width: 80px;height:30px;" onclick = "closeBrowser()" ></input>
    </div>

</div>