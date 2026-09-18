

<?php
// Use an autoloader!
error_reporting(E_ALL ^ E_WARNING);
include_once '../../../libs/include.view.php';

$strModuleName = 'main.login';
$strModelName = 'modelmainlogin';
$strModelPath = '../../../models/mod.main.login.php';

$view = new View($strModuleName);
$view->js = array('main.login.js');

$view->loadHeader();

?>
<!--<script type="text/javascript" src='jsgui/main.login.js'></script>-->
<script type="text/javascript">
    $(document).ready(function() {
//        $(document).contents().remove();
        
        animation(0);
     
    });
    function onEnter(evt) {
        if (evt.keyCode == 13) {
            doLogin({});
        }
    }
</script>

<div id="container"> 

    <div id="content">
        <div id="loginmodal">&nbsp;</div>
        <div id="logincontainer">
            <div id="logformcontainer">
                <!--                   <form action="main.login.php" method="post">-->
                <div id="unamediv"><label id="<?php echo $strModuleName . '-LBL_USER_NAME'; ?>"><?php echo $view->listModuleLangVariables["LBL_USER_NAME"] ?></label>: <input type="text" name="UserName" id="txtUsername" /></div>
                <div id="passwddiv"><label id="<?php echo $strModuleName . '-LBL_PASSWORD'; ?>"><?php echo $view->listModuleLangVariables["LBL_PASSWORD"] ?></label>: <input type="password" name="Password" id = "txtPassword" onkeypress="onEnter(event);"/></div>
                <div id="langdiv"><?php $view->getLaguageList(); ?></div>
                <div id="submitdiv">
                    <input type= "button" id="<?php echo $strModuleName . '-LBL_LOGIN' ?>" onclick = "doLogin(event);" name="submit_login" value="  <?php echo $view->listModuleLangVariables["LBL_LOGIN"]; ?> ">
                    <input type="hidden" id="shortcut_goto" name="shortcut_goto" value="<?= ($_GET['goto']); ?>" />
                </div>
                <!--                   </form>-->
            </div><!--#logformcontainer-->
           
        </div><!--#logincontainer-->
    </div><!--#content-->
</div><!--#container-->
<?php $view->loadFooter() ?>

<script>
    document.getElementById("txtUsername").focus();
</script>
