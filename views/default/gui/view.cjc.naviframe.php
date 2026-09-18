<?php
ini_set("display_errors", 0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8;"/>
        <?php
// Use an autoloader!
        error_reporting(E_ALL ^ E_WARNING);
        include_once '../../../libs/include.view.php';
        include_once '../../../config/cons.paths.php';
        $strModuleName = 'cjc_useraccess';

        $view = new View($strModuleName);
//        $view->loginCheck();
        $label = $view->getModuleLanguageVariables($strModuleName);
        $dateLabel = 'datetimeformat';
        $viewDateLabel = new View($dateLabel);
        foreach ($label as $key => $value) {
            $$key = $value;
        }
        if ($view->includeJSPathVariable($LBL_MSG)) {
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/css/blitzer/jquery-ui-1.8.16.custom.css");
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/style.css");
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css");
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/navigationPanel.css");

            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/jquery-ui-bootstrap-masterbs3/assets/css/bootstrap.min.css");
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/css/button.css");
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/css/docs.css");
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/jquery-ui-bootstrap-masterbs3/assets/css/docs.css");

            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/default.css");
            $view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/html5/sweetalert-master/dist/sweetalert.css");


            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jquery.min.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/javascript.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery-1.7.1.min.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery.blockUI.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery.jqGrid-4.5.2/js/i18n/grid.locale-en.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery.jqGrid-4.5.2/js/jquery.jqGrid.min.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery.format-1.2.min.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery-ui-1.8.16.custom.min.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery-ui-timepicker-addon.js");

            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/common.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/msgdialog.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/cjc_useraccess.js");

            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/jquery-ui-bootstrap-masterbs3/assets/js/vendor/bootstrap.js");
            $view->includeJSPath("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/html5/sweetalert-master/dist/sweetalert.min.js");
        }
        ?>
        <title><?php echo $view->listModuleLangVariables['LBL_PROJECTTITLE']; ?></title>

        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta http-equiv="Content-Type" content="text/html; charset=us-ascii"/>        
        <link rel="shortcut icon" href="../../../views/default/images/cjc/favicon.ico"/>

        <!-- Photobooth plugin import -->
           <!--<script type="text/javascript" src="../../../js/photobooth-js/website/js/jquery.js"></script>-->
        <script type="text/javascript" src="../../../js/photobooth-js/photobooth_min.js"></script>
        <script type="text/javascript" src="../../../js/photobooth-js/website/js/script.js"></script>       
        <script src="jsgui/printDivData.js"></script>  
        <!--<link type="text/css" rel="stylesheet" media="screen" href="../../../js/photobooth-js/website/css/page.css" />-->
        <!-- End of photobooth plugin import-->

        <!-- Image Preloader -->
        <script type="text/javascript">
            var loginCounter = 0;
//            $(document).ready(function() {
//                resizeWindow();
//                initialLoad();
//                onresize = function() {
//                    resizeWindow();
//                };
//            });

            document.addEventListener("DOMContentLoaded", function (event) {
                resizeWindow();
                if ((detectBrowser()).search(/chrome/i) !== -1) {
//                   alert('chrome browser');

                    initialLoad();
                } else {
                    $('html').remove();
                    document.write(navigator.userAgent + '<b style="color:blue;font-size:24px;">Browser not supported. Try Open in chrome browser.</b>');
                    window.stop();
                }

                onresize = function () {
                    resizeWindow();
                };
            });
//            $(document).ready(function () {
//
//            }).keydown(function (key) {
//
//                console.log(parseInt(key.which, 10));
//                //Initialized key               
//                key.preventDefault();
//                if (key.ctrlKey && (String.fromCharCode(key.which).toLowerCase() === 'W')) {
//                    
//                    console.log("You pressed CTRL + C");
//                }
//
//
//
//            });
            function playWarningSound() {
                var audio = document.getElementById('audio1');
                audio.play();
            }

            function resizeWindow() {
                $('#main').css('height', ($(window).height() - $('#header').height()) - 11 + 'px');
                $('#sidebar').css('height', ($(window).height() - $('#header').height()) - 11 + 'px');
                $('#divTitleModule').css('width', $('div[id="sidebar"]').width() + 'px');

            }


            function initialLoad() {
//                $('.list-group a:not([data-parent="#MainMenu"]').unbind();
//                $('.list-group a:not([data-parent="#MainMenu"]').bind("click", function () {
//                    $('#labelTitle').text($(this).text());
//                    $('.list-group a:not([data-parent="#MainMenu"]').removeClass('listselected');
//                    $(this).addClass('listselected');
//                });
                if ($.trim(getCookie("loginUserID")) == "") {
                    $('#linkLogout').css({"display": "none"});
                    $('#idlinkToggleuser').addClass("disabled");
                    $('#spanIdUserloginname').text('User');
                    LoadInit();
                    popupLoginform();
                } else {
                    $('#linkLogout').css({"display": ""});
                    if ($.trim(getCookie("type")).toUpperCase() == "USER") {
                        $('#linkUserMasterfile').css({"display": "none"});
                        $('#lstNavSetting').css({"display": "none"});

                    } else {
                        $('#linkUserMasterfile').css({"display": ""});
                        $('#lstNavSetting').css({"display": ""});
                    }
                    $('#idlinkToggleuser').removeClass("disabled");
                    $('#spanIdUserloginname').text(JSON.stringify(eval($.trim(getCookie("loginUserName")).split('+').join(' '))).split('"').join(''));
                }

                $('div[id="MainMenu"] div:not(div[id="MainMenu"] div:eq(0)) a').map(function (index, elem) {


                })
                //click event changing selected accordion color background
                LoadInit();
                $('div[id="MainMenu"] div:not(div[id="MainMenu"] div:eq(0)) a').unbind();
                $('div[id="MainMenu"] div:not(div[id="MainMenu"] div:eq(0)) a').bind("click", function (event) {
                    $('div[id="MainMenu"] div:not(div[id="MainMenu"] div:eq(0)) a').removeClass('listselected');
                    $(this).addClass('listselected');
                    $('#labelTitle').text($(this).text());
                });
                //end of changing backgroundcolor


            }


            clickLabel();

            function flashEvent(e) {
                clickLabel();
                //routeEvent(e)
            }
            //window.captureEvents(Event.CLICK);
            window.onclick = flashEvent;


            function popupLoginform() {
//                    HRISLoginCheck();
                swal({
                    title: "Login Information",
                    text: "Provide Username and Password:",
                    type: "input",
                    closeOnConfirm: false,
                    showCancelButton: false,
                    allowEscapeKey: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Username"},
                        function (inputValue) {
                            if (inputValue === false)
                                return false;
                            if (inputValue === "") {
                                return false
                            }
                            //swal("Login Success", "Welcome: " + inputValue, "success");
                            return false;
                        }
                );
                //Add password field
                // $('input[placeholder="Username"]:not(input[id="txtUsername"])').clone().appendTo('div[class^="sweet-alert"] fieldset');
                var txtUsernameField = "<input type=\"text\" tabindex=\"3\" placeholder=\"Username\" id=\"txtUsername\">";
                var txtPasswordField = "<input type=\"password\" tabindex=\"4\" placeholder=\"Password\" id=\"txtPassword\">";
                $('div[class^="sweet-alert"] fieldset').contents().remove();
                $('div[class^="sweet-alert"] fieldset').append('<form action=""></form>');
                $('div[class^="sweet-alert"] fieldset form').append(txtUsernameField);
                $('div[class^="sweet-alert"] fieldset form').append(txtPasswordField);
                $('div[class^="sweet-alert"] fieldset form').append('<input type="submit" id="btnSubmitLogin" value="Login" style="display:none;"/>');
                //add id class name of username and password
                $('div[class^="sweet-alert"] fieldset input').map(function (index, elem) {
                    // console.log(elem,index);
                    if (index == 0) {
                        $(this).attr('id', 'txtUsername');
                    }
                    $(this).attr('required', true);
                });

                //Add Event of Cancel and OK button in Login Form
                var strBtnChangePassword = "<button class=\"confirm\" onclick=\"PasswordChange();\" tabindex=\"3\" style=\"display: inline-block;box-shadow: rgba(174, 222, 244, 0.8) 0px 0px 2px, rgba(0, 0, 0, 0.0470588) 0px 0px 0px 1px inset;color: rgb(21, 20, 20);background-color: rgb(241, 127, 127);font-size: 14px;padding: 7px;height: 37px;\" id=\"btnChangePassword\">Change Password</button>";
                var strBtnCancel = "<button class=\"cancel\" tabindex=\"2\" id=\"btnCancel\" style=\"display: inline-block;color:#575757;\">Cancel</button>";
                $('div[class^="sweet-alert"] div[class="sa-button-container"]').append(strBtnCancel + strBtnChangePassword);
                $('div[class^="sweet-alert"] div[class="sa-button-container"] button:eq(1)').attr("id", "btnOkLogin").css('color', '#575757');
                $('div[class^="sweet-alert"] div[class="sa-button-container"] button:eq(0)').remove();
                $('div[class^="sweet-alert"] div[class="sa-button-container"] button').map(function (index, elem) {
                    if (index == 0) {
                        $(this).bind("click", function (event) {
                            console.log('OK is clicked add function for login validation here ');// + $('input[id="txtUsername"]').val() + $('input[id="txtPassword"]').val());
                            //Function here.................   
                            LoginUser();
                        });
                    } else if (index == 1) {
                        $(this).bind("click", function (event) {
                            console.log('Cancel is clicked add function for cancel login');
                            //Function here.................
                            $('div[class^="sweet-"]').remove();
                            $('a[href="#accordion4"][class="list-group-item list-group-item-success"]').click();


                        });
                    }

                });
                //1a:Set focus username and Add event of the element txtUsername;txtPassword;BtnOK,BtnCancel
                $('#txtUsername').focus();
                $('#txtUsername').on("keydown", function (event) {
                    if (event.which == 9) {
                        event.preventDefault();
                        $('#txtPassword').focus();
                    } else if (event.which == 13) {
                        event.preventDefault();
                        $('#txtPassword').focus();
                    }
                });
                $('#txtPassword').on("keydown", function (event) {
                    if (event.which == 9) {
                        event.preventDefault();
                        $('button[id="btnOkLogin"]').focus();
                    } else if (event.which == 13) {
                        event.preventDefault();
                        $('button[id="btnOkLogin"]').click();
                    }

                });
                //End of Events 1a:.

            }

            function LoginUser() {
                //HTML5 Trigger Required Validation
                if ($.trim($('#txtUsername').val()) == "") {
                    $('#btnSubmitLogin').click();
                }
                if ($.trim($('#txtPassword').val()) == "") {
                    $('#btnSubmitLogin').click();
                }
                //End of HTML5 Required Validation
                if ($.trim($('#txtUsername').val()) !== "" && $.trim($('#txtPassword').val()) !== "") {
                    console.log('Save function Here.');
                    $.ajax({
                        url: '../../../models/mod.cjc.usersettings.php?ACTION=LoginUser',
//                        url: '../../../documents/userJSON/users.json',
                        data: {
                            GETPARAM: {
                                USERNAME: $.trim($('#txtUsername').val()),
                                PASSWORD: $.trim($('#txtPassword').val())
                            }
                        },
                        type: 'GET',
                        dataType: 'json',
                        async: false,
                        success: function (data) {
//                            console.log(data);
//                            console.log(data["users"][0]);
//                            var loginOK = false, userType = "";
//                            $.each(data, function (i, item) {
//                                console.log(i, item.USERNAME, item.PASSWORD);
//                                if (item.USERNAME === $.trim($('#txtUsername').val()) && item.PASSWORD === calcJSCALCULATE($.trim($('#txtPassword').val()))) {
//                                    loginOK = true;
//                                    userType = item.USERTYPE;
//                                    setLoginCookie(item);
//                                }
//                            });
                            if (!jQuery.isEmptyObject(data)) {
                                RecordActivityLogs('Login', 'Login', 'Login');
//                                debugger;
//                            if (loginOK) {
                                $('#idlinkToggleuser').removeClass("disabled");
                                $('#spanIdUserloginname').text(JSON.stringify(eval($.trim(getCookie("loginUserName")).split('+').join(' '))).split('"').join(''));
                                console.log('Success Login');
                                $('div[class^="sweet-"]').remove();
                                swal({
                                    title: "Login Success",
                                    text: "Successfully Login",
                                    type: 'success',
                                    closeOnConfirm: true,
                                    showCancelButton: false,
                                    allowEscapeKey: false,
                                    animation: "slide-from-top"}
                                );
                                $('div[class^="sweet-alert"] div[class="sa-button-container"] button:eq(1)').unbind();
                                $('div[class^="sweet-alert"] div[class="sa-button-container"] button:eq(1)').bind("click", function () {
                                    console.log('Success Form display soon...');
                                    $('#linkLogout').css({"display": ""});
//                                    if ($.trim(userType).toLowerCase() === "administrator") {
                                    if ($.trim(data[0].usertype).toLowerCase() === "administrator") {
                                        $('#linkUserMasterfile').css({"display": ""});
                                        $('#lstNavSetting').css({"display": ""});
                                    } else {
                                        $('#linkUserMasterfile').css({"display": "none"});
                                        $('#lstNavSetting').css({"display": "none"});
                                    }



                                });

                            } else {
                                console.log('Not Login');
                                $('div[class^="sweet-"]').remove();
                                swal("Login Failed", "Login Failed", "error", function () {
                                    console.log('Return login failure.');
                                });
                                $('div[class^="sweet-alert"] div[class="sa-button-container"] button:eq(1)').unbind();
                                $('div[class^="sweet-alert"] div[class="sa-button-container"] button:eq(1)').bind("click", function () {
                                    navLogin('');
                                });


                            }

                        }
                    });

                }
            }
            function PasswordChange() {
                var message = "Change User Password";
                msgBox(message, "", "info", "Save|Cancel", 250, 250, function (dlgvalue) {

                    if (dlgvalue == 1) {
                        console.log('Save click');
                    }
                });
                var messageTitle = "<label>Change Password</label>";
                var divPasswordChangeBody = "\
                         <form onsubmit=\"return false;\"><div class=\"col-xs-12\" style=\"padding: 0px 0px 0px 0px;\">\n\
                           <div class=\"row-fluid\" style=\"padding: 0px 0px 0px 0px;\">\n\
                               <div class=\"col-xs-12\" style=\"padding: 5px 0px 0px 0px;\">\n\
                                  <div class=\"input-group\" style=\"padding: 0px 0px 0px 0px;\">\n\
                                     <span class=\"input-group-addon\" style=\"min-width: 138px; text-align: left;\">\n\
                                        <label style=\"min-width: 151px;\">Username</label>\n\
                                     </span><input name=\"USERNAME\" class=\"form-control\" type=\"text\" id=\"txtCPUsername\" required=\"required\" style=\"height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;\">\n\
                                   </div>\n\
                                </div> \n\
                                <div class=\"col-xs-12\" style=\"padding: 10px 0px 0px 0px;\">\n\
                                  <div class=\"input-group\" style=\"padding: 0px 0px 0px 0px;\">\n\
                                     <span class=\"input-group-addon\" style=\"min-width: 138px; text-align: left;\">\n\
                                        <label style=\"min-width: 151px;\">Current Password</label>\n\
                                     </span><input name=\"CurrentPassword\" class=\"form-control\" type=\"password\" id=\"txtCPCurrentPassword\" required=\"required\"style=\"height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;\">\n\
                                   </div>\n\
                                </div> \n\
                                <div class=\"col-xs-12\" style=\"padding: 10px 0px 0px 0px;\">\n\
                                  <div class=\"input-group\" style=\"padding: 0px 0px 0px 0px;\">\n\
                                     <span class=\"input-group-addon\" style=\"min-width: 138px; text-align: left;\">\n\
                                        <label >New Password</label>\n\
                                     </span><input name=\"NewPassword\" class=\"form-control\" type=\"password\" id=\"txtCPNewPassword\" required=\"required\" style=\"height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;\">\n\
                                   </div>\n\
                                </div> \n\
                                 <div class=\"col-xs-12\" style=\"padding: 10px 0px 0px 0px;\">\n\
                                  <div class=\"input-group\" style=\"padding: 0px 0px 0px 0px;\">\n\
                                     <span class=\"input-group-addon\" style=\" min-width: 138px; text-align: left;\">\n\
                                        <label >Retype Password</label>\n\
                                     </span><input name=\"RetPassword\" class=\"form-control\" type=\"password\" id=\"txtCPRetPassword\" required=\"required\"style=\"height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;\">\n\
                                   </div>\n\
                                </div> \n\
                                 <div class=\"col-xs-12\" style=\"padding: 10px 0px 0px 0px;\">\n\
                                  <div class=\"input-group\" style=\"padding: 0px 0px 0px 0px;\">\n\
                                     <span class=\"input-group-addon\" style=\" background:transparent;border:none;min-width: 138px; text-align: left;\">\n\
                                        <label id=\"lblErrorMessage\" style=\"color:red;opacity:0;\">*Password Missmatched</label>\n\
                                     </span> </div>\n\
                                </div> \n\
                            </div>\n\
                          </div><input type=\"submit\" id=\"btnSubmitSaveConfirmationPassword\" value=\"ConfirmSave\" style=\"display:none;\"><form>";
                $('div[id="___msgContainer"]').contents().remove();
                $('div[id="___msgContainer"]').append(divPasswordChangeBody);
                $('button[id*="btn1"]').unbind();
                $('button[id*="btn1"]').bind("click", function () {
                    console.log('Save password function here...');
                    savePasswordChange();
                });

                $('#txtCPRetPassword').bind("keyup", function (event) {
                    if (event.keyCode == 13) {
                        $('button[id*="btn1"]').click();
                    }
                });

                $('div[class="ui-widget-overlay"]').css('z-index', 91111);
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"]').css('z-index', 91112);
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                $('div[id="___msgBox"]').css("height", "");
            }
            function savePasswordChange() {
                $('#btnSubmitSaveConfirmationPassword').click();
                $('#lblErrorMessage').css('opacity', 0).text('');

                if ($('#txtCPRetPassword').val() == "" || $('#txtCPNewPassword').val() == "") {
                    $('#lblErrorMessage').css({'opacity': '1', 'color': 'red'}).text('* Field required input.');
                } else {
                    if ($('#txtCPRetPassword').val() == $('#txtCPNewPassword').val()) {
                        $('#lblErrorMessage').css({'opacity': '1', 'color': 'green'}).text('*Password Matched');
                    } else {
                        $('#lblErrorMessage').css({'opacity': '1', 'color': 'red'}).text('*Password Missmatched.');
                    }
                    if ($('#lblErrorMessage').text() == "*Password Matched" && $('#lblErrorMessage').css('color') == "rgb(0, 128, 0)") {
                        $.ajax({
                            url: '../../../models/mod.cjc.usersettings.php?ACTION=changePassword',
                            datatype: 'json',
                            async: false,
                            type: 'POST',
                            data: {
                                POSTPARAM: {
                                    username: $('#txtCPUsername').val(),
                                    currentpassword: $('#txtCPCurrentPassword').val(),
                                    password: $('#txtCPRetPassword').val()
                                }
                            },
                            success: function (jsRet) {

                                if (jsRet !== "") {
                                    console.log(jsRet, 'Ouput');
                                    if (jsRet == "not found") {
//                                        alert("User does not exist.");
                                        $('#lblErrorMessage').css({'opacity': '1', 'color': 'red'}).text('*User does not exist.');
                                    } else {
                                        alert("Password successfully change");
                                        $('#btn2').click();
                                    }

                                } else {
                                    alert("Error while saving");
                                }
                            }

                        });
                    }
                }


            }
            function LoadInit() {
                var txtFile = "";
                jQuery.get('temp.ini', function (data) {
                    txtFile = data;
                }).done(function () {
                    // alert("second success");
                    if ($.trim(txtFile) == "") {
                        window.open("../../../redirectindexerror.php", "_self");
                    }
                    // console.log(txtFile);
                }).fail(function () {
                    // alert("error");
                    window.open("../../../redirectindexerror.php", "_self");
                }).always(function () {
                    //alert("finished");
                });



            }
            function setLoginCookie(item) {
                console.log(item);
                var d = new Date();
                d.setTime(d.getTime() + (1 * 24 * 60 * 60 * 1000));
//                var expires = "expires=" + d.toGMTString();
                var expires = "expires=Session";
                document.cookie = 'loginUserNameID' + "=" + $.trim(item.ID) + ";path=/; " + expires;
                document.cookie = 'loginUserID' + "=" + $.trim(item.USERNAME) + ";path=/; " + expires;
                document.cookie = 'loginUserName' + "=" + $.trim(item.EmployeeName) + ";path=/; " + expires;
                document.cookie = 'type' + "=" + $.trim(item.USERTYPE) + ";path=/; " + expires;

            }
            function CloseWithWindowOpenTrick() {
//                ctrl+w
//                var e = jQuery.Event("keydown");
//                e.which = 87;
//                e.ctrlKey = true;
//                $(window).trigger(e);
//                window.open('', '_self').close();
//                  var objWindow = window.open(location.href, "_self");
                objWindow.close();
//                console.log('clicked me ');
//                var e = jQuery.Event("keydown");
//                e.which = 87;
//                e.ctrlKey = true;
//                $('#linkIDExitProgram').trigger(e);
                // $('#linkIDExitProgram').click();
            }
            function IDSetupPopup(event) {

                if (event.ctrlKey)
                    return;

                var dwidth = $(window).width();
                var dheight = $(window).height();
                var horizontalPadding = 20;
                var verticalPadding = 20;
                $('<iframe id="frmIDSetupSettings" style="float:none;" frameborder="0" src="view.cjc.idsetupsettings.php" />')

                        .dialog({
                            title: 'ID Setup Settings',
                            autoOpen: true,
                            height: dheight,
                            width: dwidth,
                            modal: true,
                            resizable: true,
                            autoResize: false,
                            overlay: {
                                opacity: 0.5,
                                background: "black"
                            },
                            open: function () {
                                $(this).dialog('option', 'position', ['middle', 0]);
                                $('body[data-spy="scroll"]').css('overflow', 'hidden');
                            },
                            close: function () {
                                $(this).dialog('destroy').remove();
                                $('body[data-spy="scroll"]').css('overflow', '');
                            }

                        }).width(dwidth - horizontalPadding).height(dheight - verticalPadding);

            }
            
            function IDUsermanualPopup(event) {

                if (event.ctrlKey)
                    return;

                var dwidth = $(window).width();
                var dheight = $(window).height();
                var horizontalPadding = 20;
                var verticalPadding = 20;
                $('<iframe id="frmIDUserManual" style="float:none;" frameborder="0" src="../../../help/html" />')

                        .dialog({
                            title: 'ID System Documentation',
                            autoOpen: true,
                            height: dheight,
                            width: dwidth,
                            modal: true,
                            resizable: true,
                            autoResize: false,
                            overlay: {
                                opacity: 0.5,
                                background: "black"
                            },
                            open: function () {
                                $(this).dialog('option', 'position', ['middle', 0]);
                                $('body[data-spy="scroll"]').css('overflow', 'hidden');
                            },
                            close: function () {
                                $(this).dialog('destroy').remove();
                                $('body[data-spy="scroll"]').css('overflow', '');
                            }

                        }).width(dwidth - horizontalPadding).height(dheight - verticalPadding);

            }

            function clickNavUsersettings(event) {
                if (event.ctrlKey)
                    return;
                if ($('a[href="#accordion4"]').attr('class').split('collapsed').length == 2) {
                    $('a[href="#accordion4"]').click();
                }
                $('#linkUserMasterfile').click();
            }
        </script>
        <!--//for Side Bar css tags-->
        <style>
            .listselected{
                background-color: #C7D9FB;
            }
            .list-group.panel > .list-group-item {
                border-bottom-right-radius: 4px;
                border-bottom-left-radius: 4px;
                background-color: #2975ab;
                color: white;
                font: bolder 13px verdana, Arial, Helvetica, sans-serif;
            }
            .list-group-submenu {
                margin-left:20px;
            }
            .list-group-item>.badge{float:right}
            .list-group-item>.badge+.badge{margin-right:5px}
            a.list-group-item{color:black}
            a.list-group-item .list-group-item-heading{color:#333}
            a.list-group-item:hover,a.list-group-item:focus{text-decoration:none;background-color:#C7D9FB}/*#f5f5f5*/
            .list-group-item.active,.list-group-item.active:hover,.list-group-item.active:focus{z-index:2;color:#fff;background-color:#428bca;border-color:#428bca}
            .list-group-item.active .list-group-item-heading,.list-group-item.active:hover .list-group-item-heading,.list-group-item.active:focus .list-group-item-heading{color:inherit}
            .list-group-item.active .list-group-item-text,.list-group-item.active:hover .list-group-item-text,.list-group-item.active:focus .list-group-item-text{color:#e1edf7}
            .list-group-item-heading{margin-top:0;margin-bottom:5px}
            .list-group-item-text{margin-bottom:0;line-height:1.3}
            .list-group-item {
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                /*background-color: #fff;*/
                border: 1px solid #ddd;
                font-size: 14px;
            }
            .rotate {

                -webkit-transform: rotate(90deg);
                -webkit-transform-origin: left top;
                -moz-transform: rotate(90deg);
                -moz-transform-origin: left top;
                -ms-transform: rotate(90deg);
                -ms-transform-origin: left top;
                -o-transform: rotate(90deg);
                -o-transform-origin: left top;
                transform: rotate(90deg);
                transform-origin: left top;
                position: absolute;
                top: 25%;
                left: 100%;
            }
        </style>
    </head>

    <body data-spy="scroll" data-target=".bs-docs-sidebar" data-twttr-rendered="true">

        <!-- Navbar
        ================================================== -->
        <header id="header" class="navbar navbar-inverse navbar-fixed-top">
            <div class="container" style="padding:0px;">
                <div class="navbar"  style="margin-bottom: 0px;">
                    <div id="divTitleModule" class="col-lg-3">
                        <b id="labelTitle" style="float:left;font-size: 18px;color: rgb(246, 246, 247);margin-top:10px;    text-shadow: rgb(3, 3, 3) 2px 2px 5px;"></b>
                        <label style="display:none;float: left;padding-top: 22px;padding-left: 2%;color: rgb(78, 131, 162);font-size: larger;"><?php echo " IP : [" . $_SERVER['REMOTE_ADDR'] . "]" ?></label>
                    </div>
                    <div id="divAdditionalFilter" class="col-lg-3" style="padding:0px;margin:0px;"></div>
                    <div id="divLogoandTitle" class="col-lg-6" style="padding:0px;float: right;">   
                        <ul class="nav nav-pills col-lg-12" role="tablist" style=" float: right; padding: 0; ">
                            <li role="presentation" class="active" style="float: right;/*position: absolute;*/padding-right: 5px;margin-top: 6px;    z-index: 9999;top: 0;right: 0px;">
                                <a id='idlinkToggleuser' href="#" style="height: 28px;padding: 3px 10px 10px 10px;background-color:#5F9DE3;" class="dropdown-toggle" data-toggle="dropdown"role="button" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-user" style="font-weight: bolder;text-shadow: rgb(3, 3, 3) 1px 1px 4px;"></span>
                                    <span id='spanIdUserloginname' class="badge" style="text-shadow: rgb(3, 3, 3) 1px 1px 4px;border-radius: 6px;color: white; padding: 3px; background: transparent;font-weight: bolder; ">Benjie Penol</span>

                                    <span class="caret" style=" font-weight: bolder;   border-top-color: #FFFFFF;    border-bottom-color: #FFFFFF;"></span>
                                </a>
                                <ul class="dropdown-menu"> 
                                <li><a href="javascript:void(0);" title="This will fetch student records from MSSQL and import into student records" onClick="javascript:doUserAccessImportFromSQL(event);"><span class="glyphicon glyphicon-import text-warning" style="padding-right: 6px;"></span>Import Records</a>
                                    <li id='lstNavSetting'><a href="javascript:void(0);" onclick="clickNavUsersettings(event)"><span class="glyphicon glyphicon-user text-success" style="padding-right: 6px;"></span>User Settings</a></li> 
                                    <li><a href="javascript:void(0);" onClick="javascript:doUserAccessLogout(event);"><span class="glyphicon glyphicon-lock text-warning" style="padding-right: 6px;"></span>Logout</a>
                                    </li>
                                    <li style="display: none;"><a id="linkIDExitProgram" href="javascript:var win=window.open('','_self'); win.open();win.close();"><span class="glyphicon glyphicon-transfer text-danger" style="padding-right: 6px;"></span>Exit</a></li> 
                                    <!--                                    <li role="separator" class="divider"></li>
                                                                        <li><a href="#">Separated link</a></li> -->
                                </ul> 
                            </li> 
                            <li role="presentation" class="active" style="float: right;padding-right: 5px;      min-height: 41px;background: transparent;    margin-top: 9px;">
                                <a href="#" style=" height: 41px;    padding: 0px 13px 10px 13px;background: transparent;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                    <span> 
                                        <img src="../images/cjc/logo.png" style="width: 35px;height: 35px;margin-top: -18px;margin-left: -8px;" class=""/>
                                    </span>

                                    <span class="badge" style="border-radius: 6px;color: white; padding: 3px;background: transparent;">
                                        <label style="  float: right;color: rgb(246, 246, 247);font-size: 17px;text-shadow: rgb(3, 3, 3) 2px 2px 5px;" id="<?= $strModuleName; ?>-LBL_PROJECTTITLE"><?= $LBL_PROJECTTITLE; ?></label>
                                    </span>
                                </a>

                            </li>

                        </ul>    

<!--                        <label   style="  float: right;color: rgb(246, 246, 247);  margin-top: 10px;  margin-left: 4px;font-size: 26px;text-shadow: rgb(3, 3, 3) 3px 2px 6px;" id="<?= $strModuleName; ?>-LBL_PROJECTTITLE"><?= $LBL_PROJECTTITLE; ?></label>
 <img src="../images/cjc/logo.png" style=" float: right;width: 50px;height: 50px;"/>-->
                    </div> 
                </div>
            </div>
        </header>


        <!-- Subhead
        ================================================== -->
        <header class="bs-header" id="overview" style="padding:42px 15px 0px;   color: black;    background-image: none; background-color: transparent;">

        </header>


        <div class="container" id="layout" >
            <!-- Docs nav ================================================== -->
            <div class="row" style="padding: 0px;">
                <div class="col-lg-3 col-sm-3" id="sidebar" style="padding: 0px;">
                    <div id="MainMenu">
                        <div class="list-group panel">
                            <a href="#accordion1" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
                                <span class="glyphicon glyphicon-folder-close">
                                </span> 
                                <label  id="<?= $strModuleName; ?>-LBL_MASTERFILE"><?= $LBL_MASTERFILE; ?></label>
                            </a>
                            <div class="collapse" id="accordion1">                           
                                <a href="javascript:void(0);" onclick="navStudentRecord(event);" class="list-group-item">
                                    <span class="glyphicon glyphicon-user text-info"></span>
                                    <label  id="<?= $strModuleName; ?>-LBL_MSTSTUDENTRECORD"><?= $LBL_MSTSTUDENTRECORD; ?></label>

                                </a>
                                <a href="javascript:void(0);" onclick="navEmployeeRecord(event);" class="list-group-item">
                                    <span class="glyphicon glyphicon-user text-info"></span>
                                    <label  id="<?= $strModuleName; ?>-LBL_MSTEMPLOYEERECORD"><?= $LBL_MSTEMPLOYEERECORD; ?></label>

                                </a>
                                <a href="javascript:void(0);" onclick="navAlumniRecord(event);" class="list-group-item">
                                    <span class="glyphicon glyphicon-user text-info"></span>
                                    <label  id="<?= $strModuleName; ?>-LBL_MSTALUMNIRECORD"><?= $LBL_MSTALUMNIRECORD; ?></label>

                                </a>

                            </div>



                            <a href="#accordion4" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
                                <span class="glyphicon glyphicon-tasks"></span>                           
                                <label  id="<?= $strModuleName; ?>-LBL_SETTINGS"><?= $LBL_SETTINGS; ?></label>
                            </a>
                            <div class="collapse" id="accordion4">

                                <a href="javascript:void(0);" style="" onclick="doIDSetupSettings(event)" class="list-group-item">
                                    <span class="glyphicon glyphicon-fullscreen text-info"></span>                                
                                    <label  id="<?= $strModuleName; ?>-LBL_IDSETUPSETTINGS"><?= $LBL_IDSETUPSETTINGS; ?></label>
                                </a>                           
                                <a href="javascript:void(0);" id="linkUserMasterfile" style="display:none;" onclick="navUserSettings(event);" class="list-group-item">					
                                    <span class="glyphicon glyphicon-user text-success"></span>
                                    <label  id="<?= $strModuleName; ?>-LBL_USERSETTINGS"><?= $LBL_USERSETTINGS; ?></label>			
                                </a>

                                <a href="javascript:void(0);" id="linkLogout" style="display:none;" onClick="javascript:doUserAccessLogout(event);" class="list-group-item">					
                                    <span class="glyphicon glyphicon-lock text-danger"></span>
                                    <label >Logout</label>		
                                </a>

                                <a href="javascript:void(0);" class="list-group-item" style="display: none;">					
                                    <span class="glyphicon glyphicon-remove" style="color: rgb(211, 54, 54);"></span>
                                    <label  id="<?= $strModuleName; ?>-LBL_EXITAPPLICATION"><?= $LBL_EXITAPPLICATION; ?></label>
                                </a>
                            </div>
                            <a href="#accordion5" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu">
                                <span class="glyphicon glyphicon-dashboard"></span>                           
                                <label  id="<?= $strModuleName; ?>-LBL_HELP"><?= $LBL_HELP; ?></label>
                            </a>
                            <div class="collapse" id="accordion5">
                                <a href="javascript:void(0);"  onclick="IDUsermanualPopup(event);" class="list-group-item">					
                                    <span class="glyphicon glyphicon-magnet text-info"></span>
                                    <label  id="<?= $strModuleName; ?>-LBL_USERMANUAL"><?= $LBL_USERMANUAL; ?></label>			
                                </a>
                                <a href="javascript:void(0);"  onclick="navSystemInfo(event);" class="list-group-item">					
                                    <span class="glyphicon glyphicon-registration-mark text-danger"></span>
                                    <label  id="<?= $strModuleName; ?>-LBL_SYSTEMINFO"><?= $LBL_SYSTEMINFO; ?></label>			
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-9" id="main" style="padding:0px;" >
                    <!--                     Main Form Container ================================================== 
                                        <section id="main" style="padding:0px;width:100%;">                       
                                        </section>                   -->
                </div>
            </div>
        </div>

        <!-- Footer
        ================================================== -->
        <audio id="audio1" style="display:none;">
            <!--<source src="Audio.mp3" type="audio/mpeg"/>-->
            <source src="lobibox-master/sounds/sound5.ogg" type="audio/ogg"/>
            <embed height="50" width="100" src="Audio.mp3"/>
        </audio>      
        <footer class="bs-footer" style="display:none;">
            <!--            <div class="container">
                            <div class="row">
                                <div class="col-lg-3 col-sm-3">
                                    <h3><span class="icon-envelope"></span> Contact</h3>
                                    <ul class="icons">
                                        <li><i class="icon-link"></i> Blog: <a class="targetblank" href="http://addyosmani.com/blog/">Addy Osmani</a></li>
                                        <li><i class="icon-twitter"></i> Twitter: <a class="targetblank" href="https://twitter.com/addyosmani">@addyosmani</a></li>
                                        <li><i class="icon-github"></i> Github: <a class="targetblank" href="https://github.com/addyosmani/jquery-ui-bootstrap/issues?state=open">Issues</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-sm-4">
                                    <h3><span class="icon-group"></span> Team</h3>
                                    <ul class="list-unstyled">
                                        <li>Lead Product Developer : <a class="targetblank" href="http://addyosmani.com/blog/" hreflang="en">Addy Osmani</a></li>
                                        <li>Chief Maintainer : <a class="targetblank" href="http://blog.aurelien-gerits.be" hreflang="fr">Aurélien Gérits</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-5 col-sm-5">
                                    <h3><span class="icon-lightbulb"></span> Credits</h3>
                                    <ul class="list-unstyled">
                                        <li>jQuery UI Bootstrap &copy; <strong class="text-info">Addy Osmani</strong> 2012 - 2013.</li>
                                        <li>Twitter Bootstrap &copy; <strong class="text-info">Twitter</strong> 2012 - 2013</li>
                                    </ul>
                                </div>
                            </div>
                        </div>-->
        </footer>
        <!-- Placed at the end of the document so the pages load faster -->






    </body>
</html>





