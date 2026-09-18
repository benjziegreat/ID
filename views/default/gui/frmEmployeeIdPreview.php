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
        $strModuleName = 'test';

        $view = new View($strModuleName);
//        $view->loginCheck();
        $label = $view->getModuleLanguageVariables($strModuleName);
        $dateLabel = 'datetimeformat';
        $viewDateLabel = new View($dateLabel);
        foreach ($label as $key => $value) {
            $$key = $value;
        }

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
        ?>

        <style>
            .btn-standard{
                color: rgb(66, 139, 202);
                height: 17.5px;
                border: none;
                background: transparent;
                padding: 0px 7px;
            }
            .txt-standard{
                height: 24px;
            }
            .icon-standard{
                font-size: 12px;
            }  

            .class_barcode {
                -ms-transform: rotate(-90deg);
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
                position: absolute;
                top: 243px;
                left: 12px;

            }
            *, *:before, *:after {
                /* -webkit-box-sizing: border-box; */
                -moz-box-sizing: border-box;
                /*box-sizing: border-box;*/
                box-sizing: initial;
            }
        </style>
                <!--<script type ="text/javascript" src ='jsgui/msgdialog.js'></script>--> 
        <script src="jsgui/barcode/EAN_UPC.js"></script>
        <script src="jsgui/barcode/CODE128.js"></script>
        <script src="jsgui/barcode/CODE39.js"></script>
        <script src="jsgui/barcode/JsBarcode.js"></script>
        <script src="jsgui/printDivData.js"></script>
        <script type ="text/javascript" src ='../js/plugins/mask.js'></script> 
        <!-- Image Preloader -->
        <script type="text/javascript">
            /************************************************************************************************************
             (C) www.dhtmlgoodies.com, October 2005
             
             This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
             
             Terms of use:
             You are free to use this script as long as the copyright message is kept intact. However, you may not
             redistribute, sell or repost it without our permission.
             
             Thank you!
             
             www.dhtmlgoodies.com
             Alf Magne Kalleland
             
             ************************************************************************************************************/
          var fitTextInBox_maxWidth = false;
    var fitTextInBox_maxHeight = false;
    var fitTextInBox_currentWidth = false;
    var fitTextInBox_currentBox = false;
    var fitTextInBox_currentTextObj = false;
    function fitTextInBox(element, maxHeight)
    {
        if (maxHeight)
            fitTextInBox_maxHeight = maxHeight;
        else
            fitTextInBox_maxHeight = 10000;
        var obj = element;
        fitTextInBox_maxWidth = obj.offsetWidth;
        fitTextInBox_currentBox = obj;
        fitTextInBox_currentTextObj = obj.getElementsByTagName('SPAN')[0];
        console.log(fitTextInBox_currentTextObj);
        fitTextInBox_currentTextObj.style.fontSize = '1px';
        fitTextInBox_currentWidth = fitTextInBox_currentTextObj.offsetWidth;
        fitTextInBoxAutoFit();

    }

    function fitTextInBoxAutoFit()

    {
        debugger;
        var tmpFontSize = fitTextInBox_currentTextObj.style.fontSize.replace('px', '') / 1;
        fitTextInBox_currentTextObj.style.fontSize = tmpFontSize + 1 + 'px';
        var tmpWidth = fitTextInBox_currentTextObj.offsetWidth;
        var tmpHeight = fitTextInBox_currentTextObj.offsetHeight;
        if (tmpWidth >= fitTextInBox_currentWidth && tmpWidth < fitTextInBox_maxWidth && tmpHeight < fitTextInBox_maxHeight && tmpFontSize < 300) {
            fitTextInBox_currentWidth = fitTextInBox_currentTextObj.offsetWidth;
            fitTextInBoxAutoFit();
        } else {
            fitTextInBox_currentTextObj.style.fontSize = fitTextInBox_currentTextObj.style.fontSize.replace('px', '') / 1 - 1 + 'px';
        }
    }



        </script>

        <script type="text/javascript">
            var employeeData = null, seriesIDs = '';
            document.addEventListener("DOMContentLoaded", function (event) {
                resizeWindow();
                if ((detectBrowser()).search(/chrome/i) !== -1) {
                    //                   alert('chrome browser');
                    //                    initialLoad();
                } else {
                    $('html').remove();
                    document.write('<b style="color:blue;font-size:24px;">Browser not supported. Try Open in chrome browser.</b>');
                    window.stop();
                }

                onresize = function () {
                    resizeWindow();
                };
            });

            function resizeWindow() {
                $('#main').css('height', ($(window).height() - $('#header').height()) - 22 + 'px');
                $('#sidebar').css('height', ($(window).height() - $('#header').height()) - 22 + 'px');
            }
            function initialLoad() {
                $.ajax({
                    url: "../../../models/mod.cjc.employeerecord.php",
                    data: {
                        ACTION: "GetDetailList",
                        GETPARAM: {
                            recid: employeeData
                        }
                    },
                    dataType: 'json',
                    async: false,
                    success: function (jsonReturn) {
                     LoadIDData(jsonReturn);
                    }

                });
//                LoadIDData(employeeData);
            }
            function LoadIDData(data) {
                
                $('#idContainer').contents().remove();
                for (var i = 0; i < data.length-1; i++) {
                     console.log(data[i].idnum);
                     var delimeter=',';
                     if(i ==data.length-1){
                         delimeter='';
                     }
                     seriesIDs=seriesIDs+data[i].idnum+delimeter;
                    var fullname = data[i].fname.toUpperCase() + ' ' + ($.trim(data[i].mname) == "." ? "" : data[i].mname.toUpperCase().slice(0, 1) + ".") + ' ' + data[i].lname.toUpperCase().split(' ').join(' ');
                     var guardianname=data[i].contact_guardian.toUpperCase() ;
                    var strDivID = '<div style="text-align:center;display:inline-block;" id="div_print_id' + i + '">\n\
                     <div style="width:auto;">\n\
                           <div id="_front" style="display:inline-block;border-right:black solid thin;   padding: 10px 27px 30px 20px;">\n\
                              <div id="div_img_id_front" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width:'+data[i].idwidth+';height:'+data[i].idheight+';position:relative;float:left;">\n\
                                  <img id="img_front" src="../../../../ID/documents/zzzIDSetupImage/Front'+data[i].setupid+'.png?' + new Date() + '" style="border-radius:5px;width:'+data[i].idwidth+';height:'+data[i].idheight+';" alt="Emp ID">\n\
                                  <div id="emp_pic' + i + '" style="width:'+data[i].picwidth+';height:'+data[i].picheight+';top:0px;position:absolute;margin-top: 76px;right: 10px;text-align: center;">\n\
                                      <img src="../../../documents/EmployeePictures/' + data[i].emp_id + '.png" style="width:'+data[i].picwidth+';height:'+data[i].picheight+';border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt="">\n\
                                  </div> \n\
                                  <div class="class_barcode' + i + '" style="top:0px;position:absolute;font-weight: bold;text-align: center;width: 100%;    margin-top: 233px;left: 0px;-webkit-transform: scale(1,0.9081);"> \n\
                                    <!-- <img id="barcode' + i + '" style="width: auto;height:auto;"/>-->\n\
                                      <img id="barcode' + i + '" style="width: 180px;height:25px;"/>   \n\
                                  </div> \n\
                                  <div id="emp_name' + i + '" style="top:0px;position:absolute;margin-top: 177px;font-weight: bold;margin-left: 0px;text-align: right;right: 1px; width: 100%; -webkit-transform: scale(0.89051,1.013570);"> \n\
                                     <span style="font-size:10px;">' + fullname + '</span>\n\
                                   </div> \n\
                                 <div id="emp_id' + i + '" style="top:0px;position:absolute;margin-top: 214.4px;font-weight: bold;text-align: left;left: 7px;width: 32%;font-size: 9px;-webkit-transform: scale(0.757801,1.0102570);">\n\
                                     <span style=" font-size: 11px;">' + data[i].emp_id + '</span> \n\
                                 </div> \n\
                                 <div id="emp_idtype' + i + '" style="top:0px;position:absolute;margin-top: 216.2px;font-weight: bold;text-align: center;left: 68px;font-size: 9px;width: 60%;-webkit-transform: scale(1.00516999,1.0140357);"> \n\
                                     <span>' + data[i].category + '</span>\n\
                                 </div> \n\
                                 <div id="emp_position' + i + '" style="top:0px;position:absolute;margin-top: 192px;font-weight: bold;margin-left: 0px;text-align: right;right: 1px; width: 85%; -webkit-transform: scale(0.89051,1.013570);"> \n\
                                     <span style="font-size:10px;" >' + padLeft(data[i].designation, fullname.length, " ") + '</span>\n\
                                 </div> \n\
                                 <div id="emp_pressignature' + i + '" style="display:none;top:0px;position:absolute;margin-top: 274px;/* margin-left: 83px; */text-align: center;width: 210px;">\n\
                                     <img src="../../../documents/PresidentSignature/PresidentSignature.png" style="width: 128px;height: 20px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> \n\
                                 </div> \n\
                                 <div id="emp_presidentname' + i + '" style="display:none;top:0px;position:absolute;margin-top: 293px;font-weight: bold;margin-left: 0px;text-align: center;width: 220px; -webkit-transform: scale(0.781,0.81570);">\n\
                                      <span style="color:#3d0b0c;font-size: 12px;">BR. ELLAKIM P. SOSMEÑA, S.C.</span> \n\
                                 </div> \n\
                                 <div id="emp_president' + i + '" style="display:none;top:0px;position:absolute;margin-top: 303px;font-weight: bold;text-align: center;width: 220px;-webkit-transform: scale(0.71,0.75);">\n\
                                      <span style=" font-size: 11px; color: #3d0b0c; "> President</span>\n\
                                 </div> \n\
                             </div>\n\
                          </div>\n\
                          <div id="_back" style="display: inline-block;    padding: 10px 0px 30px 20px;"> \n\
                             <div id="div_img_id_back" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width:'+data[i].idwidth+';height:'+data[i].idheight+';position:relative;float:right;"> \n\
                                <img id="img_back" src="../../../../ID/documents/zzzIDSetupImage/BACK'+data[i].setupid+'.png?' + new Date() + '" style="border-radius:5px;width:'+data[i].idwidth+';height:'+data[i].idheight+';" alt="Emp ID">\n\
                                 <div id="s_SSS' + i + '" style="position: absolute;top: 0;margin-top: 25px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175);font-weight: bold;"> <span>' + data[i].sssgsisno + '</span></div>\n\
                                 <div id="s_tinno' + i + '" style="position: absolute;top: 0;margin-top: 45px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>' + data[i].tinno + '</span></div>\n\
                                 <div id="s_philhealth' + i + '" style="position: absolute;top: 0;margin-top: 64px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>' + data[i].philno + '</span></div> \n\
                                <div id="s_birthdate' + i + '" style="position: absolute;top: 0;margin-top: 83px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;">  <span>' + data[i].birthdatevalue + '</span></div>\n\
                                 <div id="p_civil' + i + '" style="position: absolute;top: 0;margin-top: 103px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>' + data[i].status + '</span></div>\n\
                                 <div id="s_mother' + i + '" style="position: absolute;top: 0;margin-top: 143px;left: -10px;font-size: 12px;width: 110%;text-align: left;-webkit-transform: scale(0.81,0.9175); font-weight: bold;"> <span>' + guardianname + '</span></div>\n\
                                 <div id="p_address' + i + '" style="position: absolute; top: 0;margin-top: 157px; left:-10px; font-size: 11px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold;"> <span>' + data[i].contact_address + '</span></div>\n\
                                 <div id="p_cellno' + i + '" style="position: absolute; top: 0;margin-top:197px; left: 45px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span>' + data[i].contactno + ' </span></div>\n\
                                 <div id="emp_signature' + i + '" style="width: 100%;position: relative;top: 0;margin-top: -56px;-webkit-transform: scale(0.91,0.975); font-weight: bold;">\n\
                                     <img src="../../../documents/EmployeeSignature/' + data[i].emp_id + '.png?Thu Sep 03 2015 21:51:26 GMT-0700 (Pacific Daylight Time)" style="/*width: 160px;height: 35px;*/height:50px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> \n\
                                 </div> \n\
                            </div>\n\
                         </div> \n\
                      </div> \n\
                  </div>';
                    $('#idContainer').append(strDivID);
                    $('img[id="barcode' + i + '"]').map(function (index, elem) {
                        $(elem).JsBarcode(data[i].emp_id, {width: 1, height: 50, displayValue: false, fontSize: 14, format: 'CODE39', font: "Arial,sans-serif"});
                        $(elem).css({"width": "171px", "height": "26px"});
                    });
                    if (file_exists("../../../documents/EmployeePictures/" + data[i].emp_id + ".png")) {
                        $('#emp_pic' + i + ' img').attr("src", '../../../documents/EmployeePictures/' + data[i].emp_id + ".png" + "?time=" + new Date());
                    } else {
                        //Picture not exist.
                        $('#emp_pic' + i + ' img').attr("src", '../../../documents/EmployeePictures/nopic.png' + "?time=" + new Date());
                    }
                    if (file_exists("../../../documents/EmployeeSignature/" + data[i].emp_id + ".png")) {
                        $('#emp_signature' + i + ' img').attr("src", '../../../documents/EmployeeSignature/' + data[i].emp_id + ".png" + "?time=" + new Date());
                    } else {
                        //Picture not exist.
                        $('#emp_signature' + i + ' img').attr("src", '../../../documents/EmployeeSignature/nopic.png' + "?time=" + new Date());
                    }
                     
//                    $('div[id="s_mother' + i + '"]').map(function(index, elem) {
//                        fitTextInBox(elem);
//                    });
                }
                loadXYSetupID(data);

            }
            function loadXYSetupID(data) {
                for (var i = 0; i < data.length; i++) {
                    var frontpicturexy = data[i].frontpicturexy.split(';');
                    var arrp1 = frontpicturexy[0].split(':');
                    var arrp2 = frontpicturexy[1].split(':');
                    var arrp3 = frontpicturexy[2].split(':');
                    $('div[id="emp_pic' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="emp_pic' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var frontnamexy = data[i].frontnamexy.split(';');
                    arrp1 = frontnamexy[0].split(':');
                    arrp2 = frontnamexy[1].split(':');
                    arrp3 = frontnamexy[2].split(':');
                    $('div[id="emp_name' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="emp_name' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var frontdesignationxy = data[i].frontdesignationxy.split(';');
                    arrp1 = frontdesignationxy[0].split(':');
                    arrp2 = frontdesignationxy[1].split(':');
                    arrp3 = frontdesignationxy[2].split(':');
                    $('div[id="emp_position' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="emp_position' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var frontidnumxy = data[i].frontidnumxy.split(';');
                    arrp1 = frontidnumxy[0].split(':');
                    arrp2 = frontidnumxy[1].split(':');
                    arrp3 = frontidnumxy[2].split(':');
                    $('div[id="emp_id' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="emp_id' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var frontcategoryxy = data[i].frontcategoryxy.split(';');
                    arrp1 = frontcategoryxy[0].split(':');
                    arrp2 = frontcategoryxy[1].split(':');
                    arrp3 = frontcategoryxy[2].split(':');
                    $('div[id="emp_idtype' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="emp_idtype' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var frontbarcodexy = data[i].frontbarcodexy.split(';');
                    arrp1 = frontbarcodexy[0].split(':');
                    arrp2 = frontbarcodexy[1].split(':');
                    arrp3 = frontbarcodexy[2].split(':');
                    $('div[class="class_barcode' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[class="class_barcode' + i + '"] span').css(arrp3[0], arrp3[1]);


                    var backsssgsisnoxy = data[i].backsssgsisnoxy.split(';');
                    arrp1 = backsssgsisnoxy[0].split(':');
                    arrp2 = backsssgsisnoxy[1].split(':');
                    arrp3 = backsssgsisnoxy[2].split(':');
                    $('div[id="s_SSS' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="s_SSS' + i + '"] span').css(arrp3[0], arrp3[1]);


                    var backtinxy = data[i].backtinxy.split(';');
                    arrp1 = backtinxy[0].split(':');
                    arrp2 = backtinxy[1].split(':');
                    arrp3 = backtinxy[2].split(':');
                    $('div[id="s_tinno' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="s_tinno' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var backphihealthxy = data[i].backphihealthxy.split(';');
                    arrp1 = backphihealthxy[0].split(':');
                    arrp2 = backphihealthxy[1].split(':');
                    arrp3 = backphihealthxy[2].split(':');
                    $('div[id="s_philhealth' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="s_philhealth' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var backdateofbirthxy = data[i].backdateofbirthxy.split(';');
                    arrp1 = backdateofbirthxy[0].split(':');
                    arrp2 = backdateofbirthxy[1].split(':');
                    arrp3 = backdateofbirthxy[2].split(':');
                    $('div[id="s_birthdate' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="s_birthdate' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var backcivilstatusxy = data[i].backcivilstatusxy.split(';');
                    arrp1 = backcivilstatusxy[0].split(':');
                    arrp2 = backcivilstatusxy[1].split(':');
                    arrp3 = backcivilstatusxy[2].split(':');
                    $('div[id="p_civil' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="p_civil' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var backguardiannamexy = data[i].backguardiannamexy.split(';');
                    arrp1 = backguardiannamexy[0].split(':');
                    arrp2 = backguardiannamexy[1].split(':');
                    arrp3 = backguardiannamexy[2].split(':');
                    $('div[id="s_mother' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="s_mother' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var backguardianaddressxy = data[i].backguardianaddressxy.split(';');
                    arrp1 = backguardianaddressxy[0].split(':');
                    arrp2 = backguardianaddressxy[1].split(':');
                    arrp3 = backguardianaddressxy[2].split(':');
                    $('div[id="p_address' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="p_address' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var backguardiantelnoxy = data[i].backguardiantelnoxy.split(';');
                    arrp1 = backguardiantelnoxy[0].split(':');
                    arrp2 = backguardiantelnoxy[1].split(':');
                    arrp3 = backguardiantelnoxy[2].split(':');
                    $('div[id="p_cellno' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="p_cellno' + i + '"] span').css(arrp3[0], arrp3[1]);

                    var backsignaturexy = data[i].backsignaturexy.split(';');
                    arrp1 = backsignaturexy[0].split(':');
                    arrp2 = backsignaturexy[1].split(':');
                    arrp3 = backsignaturexy[2].split(':');
                    $('div[id="emp_signature' + i + '"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
                    $('div[id="emp_signature' + i + '"] span').css(arrp3[0], arrp3[1]);
                }
                 $('div[id^="emp_name"]').map(function(index, elem) {
                 //console.log($(elem).find('span').text());
                  if($.trim($(elem).find('span').text()).length>29){
                        fitTextInBox(elem);
                      }              
                   });
                  $('div[id^="s_mother"]').map(function(index, elem) {
                 //console.log($(elem).find('span').text());
                  if($.trim($(elem).find('span').text()).length>26){
                        fitTextInBox(elem);                      }                
                           
                    });
                  $('div[id^="p_cellno"]').map(function(index, elem) {
                 //console.log($(elem).find('span').text());
                  if($.trim($(elem).find('span').text()).length>26){
                        fitTextInBox(elem);                      }                
                           
                    });
            }


            clickLabel();
            function flashEvent(e) {
                clickLabel();
                //routeEvent(e)
            }
            //window.captureEvents(Event.CLICK);
            window.onclick = flashEvent;
            function file_exists(url) {
//        console.log(url);
                // http://kevin.vanzonneveld.net
                // +   original by: Enrique Gonzalez
                // +      input by: Jani Hartikainen
                // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // %        note 1: This function uses XmlHttpRequest and cannot retrieve resource from different domain.
                // %        note 1: Synchronous so may lock up browser, mainly here for study purposes.
                // *     example 1: file_exists('http://kevin.vanzonneveld.net/pj_test_supportfile_1.htm');
                // *     returns 1: '123'
                var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
                if (!req) {
                    throw new Error('XMLHttpRequest not supported');
                }

                // HEAD Results are usually shorter (faster) than GET

                req.open('HEAD', url, false);
                req.send(null);
                if (req.status == 200) {
                    return true;
                }

                return false;
            }
            function printFrame() {
                var message = "Do you want to print ID?";
                msgBox(message, "Confirmation", "ask", "Yes|No", 300, 250, function (dlgvalue) {
                    clickLabel();
                    if (dlgvalue == 1) {
                        animation(1);
                        $.ajax({
                            url: "../../../models/mod.cjc.employeerecord.php?ACTION=updateprintinghistory",
                            type: "POST",
                            data: {
                                POSTPARAM: {
                                    idnum:seriesIDs.substring(0,seriesIDs.length-1),
                                    type: 'multiple'
                                }
                            },
                            success: function (emp_id) {

                                if (emp_id !== "") {
                                    printDivData_WP('idContainer', 'P','_self');
                                } else {
                                    console.log(emp_id);
                                    var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATEERROR'><?= $LBL_SAVEUPDATEERROR ?></label>";
                                    msgBox(message, "Error", "failed", "OK", 300, 250, function (dlgvalue) {

                                    });
                                    var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?>System Message</label>";
                                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                                    $('div[id="___msgBox"]').css("height", "");
                                    clickLabel();
                                    animation(0);
                                }

                            }
                        });
                    }else{
                     parent.$('div[aria-labelledby="ui-dialog-title-frmEmployeeIDPreview"] div:eq(0) a').click();
                    }
                });
                var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?>System Message</label>";
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                $('div[id="___msgBox"]').css("height", "");
                clickLabel();

            }
            function padLeft(n, width, z) {
                var i = 0;
                z = z || '0';
                n = n + '';
                return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
            }
        </script>
        <!--//for Side Bar css tags-->

    </head>


    <div class="container" style="color:black;font-family: Arial,sans-serif;    padding: 0px 3.5% 0px 0%;">
        <div class="panel-heading" id="divTopHeader" style="height: 40px;width: 100%;padding: 0px;">           
            <div class="col-md-12" style="float:left;margin-top:3px;">
                <button onclick="printFrame()" id="cjc.employeerecord-LBL_PRINTPDS" name="btnPrintID" class="btn btn-info btn-lg" title="Print ID" style="padding: 7px 12px;float: right;font-size: 12px;min-width: 80px;margin-right: 0.5%;">
                    <span class="glyphicon glyphicon-print"></span> Print ID</button> 
            </div>
        </div>
        <div class="panel-body" style="padding-bottom:0px;">
            <div id="idContainer" class="panel-body" style="padding-top:0px;padding-bottom:0px;" >
            </div>
        </div>
    </div>







