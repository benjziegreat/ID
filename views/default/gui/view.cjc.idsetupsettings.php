<?php
error_reporting(E_ALL ^ E_WARNING);
ini_set("display_errors", 0);
include_once '../../../libs/include.view.php';
include_once '../../../config/cons.paths.php';

$strModuleName = 'cjc.idsetupsettings';

$view = new View($strModuleName);
$label = $view->getModuleLanguageVariables($strModuleName);
$dateLabel = 'datetimeformat';
$viewDateLabel = new View($dateLabel);
foreach ($label as $key => $value) {
    $$key = $value;
}
$dtmn = 'datetimeformat';
$dtLabel = $view->getModuleLanguageVariables($dtmn);
$lang = ($_GET['lang'] == 'jp' ? 'ja' : 'en');
$dateLabel = $view->getModuleLanguageVariables($dtmn);

$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/css/blitzer/jquery-ui-1.8.16.custom.css");
$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/style.css");
$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/js/jquery.jqGrid-4.4.4/css/ui.jqgrid.css");
$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/navigationPanel.css");

$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/jquery-ui-bootstrap-masterbs3/assets/css/bootstrap.min.css");
$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/css/button.css");
$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/css/docs.css");
$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/jsgui/jquery-ui-bootstrap-masterbs3/assets/css/docs.css");

$view->includeCSS("/" . PROJECTNAME . "/views/" . CURRENT_THEME . "/gui/default_idsetuponly.css");
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
<link rel="stylesheet" href="jsgui/css/button.css"/>
<!--<script type ="text/javascript" src ='jsgui/msgdialog.js'></script>--> 
<script src="jsgui/barcode/EAN_UPC.js"></script>
<script src="jsgui/barcode/CODE128.js"></script>
<script src="jsgui/barcode/JsBarcode.js"></script>
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

    .frontbarcodexy {
        -ms-transform: rotate(-90deg);
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
        position: absolute;
        top: 243px;
        left: 12px;

    }
    body {
        margin: 0 0;
        background: #FFFFFF;
        font: '';
        color: #666666;
        padding: 0px;
    }
    .rotate {

        /*        -webkit-transform: rotate(90deg);
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
                left: 100%;*/
        -webkit-transform: rotate(275deg);
        -webkit-transform-origin: left top;
        -moz-transform: rotate(90deg);
        -moz-transform-origin: left top;
        -ms-transform: rotate(90deg);
        -ms-transform-origin: left top;
        -o-transform: rotate(90deg);
        -o-transform-origin: left top;
        transform: rotate(270deg);
        transform-origin: left top;
        position: absolute;
        top: 107%;
        left: 11%;
    }

</style>
<script src="jsgui/printDivData.js"></script>
<script type ="text/javascript" src ='../js/plugins/mask.js'></script> 



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

<script>
    var pid = 0;
    var patterns = [
        "YYYY-MM-DD",
        "YYYY-DD/MM HH:mm",
        "HH:mm DD+MM+YYYY",
        "HH:mm",
        "n8",
        "az"
    ];
    var defaultValues = [
        Date.now(),
        Date.now(),
        Date.now(),
        Date.now(),
        54422342,
    ]
    var isUtc = [
        true,
        true,
        false
    ]

    var options;
    var masks = [];
    var mask;
    var setErrorFunction = function (isValid, input) {
        if (isValid == false) {
            input.parent().css("border", "1px solid red");
            $(input).val('');
        } else {
            input.parent().css("border", "");
        }
    }

    options = {
        $el: $("#txtdatehired"),
        mask: patterns[0],
        errorFunction: setErrorFunction,
        defaultValue: defaultValues[0],
        isUtc: isUtc[0]
    }
    mask = Mask.newMask(options);
    masks.push(mask);
    options = {
        $el: $("#txtdateresign"),
        mask: patterns[0],
        errorFunction: setErrorFunction,
        defaultValue: defaultValues[0],
        isUtc: isUtc[0]
    }
    mask = Mask.newMask(options);
    masks.push(mask);
    masks.push(Mask.newMask({
        $el: $("#txtbirthdate"),
        mask: patterns[0],
        errorFunction: setErrorFunction,
        defaultValue: defaultValues[0],
        isUtc: isUtc[0]
    }));
    masks.push(Mask.newMask({
        $el: $("#txttax_issueddate"),
        mask: patterns[0],
        errorFunction: setErrorFunction,
        defaultValue: defaultValues[0],
        isUtc: isUtc[0]
    }));
    var openPost;
    openPost = function (url, variables, target) {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("target", target);
        form.setAttribute("action", url);
        for (variable in variables)

        {

            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", variable);
            hiddenField.setAttribute("value", variables[variable]);
            form.appendChild(hiddenField);
        }

        document.body.appendChild(form);
        $(form).submit();
        $(form).remove();

    };
    function setTimePicker(element) {
        $(element).datetimepicker({
            dateFormat: 'yy-mm-dd',
            timeFormat: "hh:mm:ss",
            ampm: false,
            changeMonth: true,
            changeYear: true,
            yearRange: "-110:+0"
        });
    }
</script>
<script type="text/javascript">
    var summarySQL = "";
    var lastCol, lastRow;
    var lastiRow, lastiCol;
    var GlobalIDDataSeledted;
    var GlobalGridSelected = '';
    var GlobalAddressSelectedLastIrow, GlobalAddressSelectedLastIrCol;
    var ctrlkey = -1;
    var combinekey = -1;
    var printWindow;
    $(document).ready(function () {
        loadList('tblIDSetupList', 'pgIDSetupList');
        iniControls();
        onresize = function () {
//            resizeWindow();//this function resize is from cjcnaviframe
            setTableListResizeGrids();

            $('#dvContainer').css({
                position: 'absolute',
                width: $(window).width(),
                height: $(window).height()
            });
        };
//        $('body').css('overflow', 'auto');
    });
    function pad(n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }

    function iniControls() {
		$('#divAdditionalFilter').contents().remove();
        $("input[type='text']").click(event, function () {
            $(this).select();
        });
        $('#dvContainer').css({
            position: 'absolute',
            width: $(window).width(),
            height: $(window).height()
        });
        $("#txtSearchIDSetup").keyup(event, function () {
            if (event.keyCode == 13) {
                loadList('tblIDSetupList', 'pgIDSetupList');
            }
        });
        $("button[name='btnSearchEmployee']").click(null, function (event) {
            loadList('tblIDSetupList', 'pgIDSetupList');
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $(".browserjqgrid").remove();
            jQuery("#" + GlobalGridSelected).saveCell(GlobalAddressSelectedLastIrow, GlobalAddressSelectedLastIrCol); //save jqgrid Address values,GlobalAddressSelectedLastIrCol

            var target = $(e.target);
//            $("#" + target.data('tableName')).setGridWidth($(target.get(0).hash).width() * 1, true);
//            console.log(target.data('tableName'));
//            $('#divTabContent').css('padding', '0px');
            setTableListResizeGridsTabs();
            if ($.trim(target.data('tableName')) === "tblPersonalInformation") {
                $('#divTabContent').css('padding-right', '17px');
            } else if ($.trim(target.data('tableName')) === "tblDesignationMovement") {
                $("#" + target.data('tableName')).setGridWidth($(target.get(0).hash).width() * 1 - 5, true);
                setTableListResizeGridsTabs();
            } else if ($.trim(target.data('tableName')) === "tblIDPreview") {
                //Trigger function auto fit text to div tags

//                fitTextInBox('frontnamexy');
//                fitTextInBox('frontdesignationxy');
//                $('div[id="frontnamexy"]').map(function(index, elem) {
//                    fitTextInBox(elem);
//                });
//                $('div[id="frontdesignationxy"]').map(function(index, elem) {
//                    fitTextInBox(elem);
//                });
                //end of auto fit text
                $('img[id="barcode"]').map(function (index, elem) {
                    $(elem).JsBarcode('2009-0418-5', {width: 1, height: 50, displayValue: false, fontSize: 18});
                });
                $('img').map(function (index, elem) {
                    var srcval = $(elem).attr('src');
                    var newSrc = srcval.split('?')[0];
//                    console.log(elem);
                    if ($(elem).attr('id') == "barcode") {
                    } else {
                        $(elem).attr('src', newSrc + '?' + new Date());
                    }
                });

            }
        });
        $('button[name="btnSaveIDSetup"],button[name="btnPrintID"],button[name="btnCancel"]').bind("click", function (event) {

            if (event.ctrlKey)
                return;
            if ($(this).attr('name') === "btnSaveIDSetup") {

                saveIDSetupList(event);
            } else if ($(this).attr('name') === "btnCancel") {
                $('div[aria-labelledby$="idsetupsettings_dialog"] span[class="ui-icon ui-icon-closethick"]').click();


            }
        });
        $('button[name="btnRefresh"]').bind("click", function (e) {
            loadList('tblIDSetupList', 'pgIDSetupList');
        });
        $('button[name="btnExitCancel"]').bind("click", function (e) {
            parent.$('div[aria-labelledby$="frmIDSetupSettings"] span[class="ui-icon ui-icon-closethick"]').click();
        });

        $('button[name="btnPreviewID"]').bind("click", function (e) {
            if (isAllowedAccessClick('module', 'ID Setup Settings', 'print')) {
                $('span br').map(function (index, elem) {
                    $(elem).removeAttr('style');
                });
                printDivData_WP('divIDPreview', 'P');
                $('span br').map(function (index, elem) {
                    $(elem).attr('style', "content:'';margin: -3px; display: block;");
                });
            }
        });

        $('button[name="btnExport"]').bind("click", function (event) {
            if (event.ctrlKey)
                return;
            //    window.location = "http://localhost/sqltoexcel?query=" + summarySQL.split('LIMIT')[0];
            console.log('Export has been Clicked.');
            var currentSelectedBtnElement = $(this);
            if ($.trim($(currentSelectedBtnElement).attr('name')) === "btnExport" && isAllowed()) {
                msgBox("Are you sure to export employee profiles?", "Confirm", 'ask', 'Yes|No', 0, 0, function (v) {
                    if (v == 1) {
                        var sqlQuery = summarySQL.split('LIMIT')[0];
//                console.log(sqlQuery);
                        openPost('../../../models/ExportExcelTemplate.php', {
                            sqlQuery: sqlQuery,
                            transtitle: $.trim($('#labelTitle').text()),
                            IsHasSummaryTotal: 'No',
                            Type: 'hrmsMSTEmployeeInformation'
                        }, '');
                    } else {
                        return;
                    }
                });
                var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');


            }





        });
        $('button[name="btnNew"]').bind("click", function (e) {
            if (isAllowed()) {
                var rowdata = $('#tblIDSetupList').jqGrid('getRowData', 1);
                popupDialogForm(e, 'idsetupsettings_dialog', rowdata);
                $('#txtIDsetup').val("");
                $('#txtsetuptitle').val("");
                $('#txtSetuptype').val("");
                $('#chkissetdefault').attr('checked', true);
                $('#txtsetuptitle').attr('readonly', false);
                $('#txtSetuptype').attr('disabled', false);

                $('#img_front,#img_back').attr('src', '../../../../ID/documents/zzzIDSetupImage/nopic.png?' + new Date());
            }

        });
        $('button[name="btnEdit"]').bind("click", function (e) {
//            if (isAllowed()) {
            var rowdata = $('#tblIDSetupList').jqGrid('getRowData', $('#tblIDSetupList').jqGrid('getGridParam', 'selrow'));
            if ($.isEmptyObject(rowdata)) {

            } else {
                popupDialogForm(e, 'idsetupsettings_dialog', rowdata);
            }
//            }
        });

        //Initial Format css jquery functions
        $('#idsetupsettings_dialog input,select').css({"height": "28px", "font-size": "12px", "padding": "5px", "font-weight": "bolder"});
        $('#idsetupsettings_dialog select').css({"padding": "0px"});
        $('#btnPrintPreviewID').button();
        //bind events of chkbox Gender
        $('input[id="chkIsSexMale"],input[id="chkIsSexFemale"]').bind("click", function (event) {
            $('input[id="chkIsSexMale"],input[id="chkIsSexFemale"]').removeAttr('checked');
            $(this).attr('checked', 'checked');
        });
        //end of bind event of chkbox Gender



//Spinner FOntsizefieldelement
        $('.spinner .btn:first-of-type').on('click', function () {

            var rowdata = $('#tblSetupIDDetails').jqGrid('getRowData', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'));
            //console.log(rowdata);
            if ($.isEmptyObject(rowdata)) {
                swal("System Message", "No Item selected .", 'warning');
            } else {
                var value = parseInt($('.spinner input').val()) + 1;
                $('.spinner input').val(value);
                $('#' + rowdata["fieldorig"] + ' span').css(rowdata["attrib3"], value + 'px');
                $("#tblSetupIDDetails").setRowData($('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), {
                    value3: value + "px",
                    FLAG: "Edit"

                });
                $("#tblSetupIDDetails").jqGrid('saveRow', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), false);
            }
        });

        $('.spinner .btn:last-of-type').on('click', function () {
            if (parseInt($('.spinner input').val(), 10) > 1) {
//                $('.spinner input').val(parseInt($('.spinner input').val()) - 1);
                var rowdata = $('#tblSetupIDDetails').jqGrid('getRowData', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'));
                //console.log(rowdata);
                if ($.isEmptyObject(rowdata)) {
                    swal("System Message", "No Item selected .", 'warning');
                } else {
                    var value = parseInt($('.spinner input').val()) - 1;
                    $('.spinner input').val(value);
                    $('#' + rowdata["fieldorig"] + ' span').css(rowdata["attrib3"], value + 'px');
                    $("#tblSetupIDDetails").setRowData($('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), {
                        value3: value + "px",
                        FLAG: "Edit"

                    });
                    $("#tblSetupIDDetails").jqGrid('saveRow', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), false);
                }
            }

        });
        $('.spinner input').keydown(function (key) {
            console.log(parseInt(key.which, 10));
            //Initialized key
            if (parseInt(key.which, 10) == 39 || parseInt(key.which, 10) == 38) {
                //up key
                $('.spinner .btn:first-of-type').click();
                key.preventDefault();
            }
            if (parseInt(key.which, 10) == 37 || parseInt(key.which, 10) == 40) {
                //down key
                $('.spinner .btn:last-of-type').click();
                key.preventDefault();
            }


        });
//End of SPinner FontSize
        clickLabel();
    }


    function reloadtblIDSetupList() {
        $("div#divIDSetupList table#tblIDSetupList").setGridParam({
            postData: {
                ACTION: 'loadList',
                GETPARAM: {
                    _searchKey: $("#txtSearchIDSetup").val()
                }
            }
        }).trigger('reloadGrid');
    }

    function loadList(gridID, pgID) {
        $("#" + gridID).jqGrid('GridUnload');
        $("#" + gridID).jqGrid({
            url: '../../../models/mod.cjc.idsetupsettings.php',
            datatype: 'json',
            async: false,
            mtype: 'GET',
            postData: {
                ACTION: 'loadList',
                GETPARAM: {
                    _searchKey: $("#txtSearchIDSetup").val()
                }
            },
            colModel: [
                {
                    name: 'id',
                    index: 'id',
                    hidden: false,
                    align: 'center',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLRECID"><?= $LBL_TBLRECID; ?></label>',
                    width: 40
                },
                {
                    name: 'title',
                    index: 'title',
                    hidden: false,
                    width: 120,
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLSETUPTITLE"><?= $LBL_TBLSETUPTITLE; ?></label>'
                },
                {
                    name: 'setdefault',
                    index: 'setdefault',
                    hidden: true,
                },
                {
                    name: 'setdefault',
                    index: 'setdefault',
                    hidden: false,
                    width: 50,
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLDEFAULT"><?= $LBL_TBLDEFAULT; ?></label>',
                    edittype: 'checkbox',
                    editoptions: {value: '1:0', defaultValue: '0'},
                    formatoptions: {disabled: false},
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "isactive";
                        var chkValue = (cellvalue == 1 ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox"' + chkValue + ' disabled value = "' + cellvalue + '" offval="0">';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return $("input:checkbox", cell).prop("checked") ? 1 : 0;
                    },
                    align: 'center'
                },
                {
                    name: 'setuptype',
                    index: 'setuptype',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLSETUPTYPE"><?= $LBL_TBLSETUPTYPE; ?></label>',
                    hidden: false,
                    width: 100,
                },
                {
                    name: "category",
                    index: "category",
                    label: "Category",
                    align: 'LEFT',
                    width: 200,
                    editable: true,
                    edittype: 'select',
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;font-weight: bolder;',
                        value: function () {
                            var rowdata = $('#' + gridID).jqGrid('getRowData', $('#' + gridID).jqGrid('getGridParam', 'selrow'));
                            console.log(rowdata.setuptype);

                            var strDesignationList = "";
                            var arrList = [];
                            if (rowdata.setuptype == "Employee") {
                                arrList.push(1 + ":" + '');
                                arrList.push(2 + ":" + 'CJC');
                                arrList.push(3 + ":" + 'ELRIC');
                                arrList.push(4 + ":" + 'LEDOUX');
                                arrList.push(5 + ":" + 'BROTHER POLYCARP');
                                strDesignationList = arrList.join(';');
                            } else {
                                arrList.push(1 + ":" + '');
                                arrList.push(2 + ":" + 'COLLEGE');
                                arrList.push(3 + ":" + 'BASIC EDUCATION');
                                arrList.push(4 + ":" + 'GRADUATE SCHOOL');
                                arrList.push(5 + ":" + 'LAW SCHOOL');
                                arrList.push(6 + ":" + 'VOC TECHNOLOGY');
                                strDesignationList = arrList.join(';');
                            }
                            return strDesignationList;
                        },
                        defaultValue: '1',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + gridID).saveCell(lastRow, lastCol);
//                                    GlobalGridSelected = Grid;
//                                    GlobalAddressSelectedLastIrow = lastRow;
//                                    GlobalAddressSelectedLastIrCol = lastCol;
                                }
                            }
                        ]
                    }

                },
                {
                    name: 'frontpicturexy',
                    index: 'frontpicturexy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLPICTUREXY"><?= $LBL_TBLPICTUREXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'frontnamexy',
                    index: 'frontnamexy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLNAMEXY"><?= $LBL_TBLNAMEXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'frontdesignationxy',
                    index: 'frontdesignationxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLDESIGNATIONXY"><?= $LBL_TBLDESIGNATIONXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'frontidnumxy',
                    index: 'frontidnumxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLIDNUMBERXY"><?= $LBL_TBLIDNUMBERXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'frontcategoryxy',
                    index: 'frontcategoryxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLCATEGORYXY"><?= $LBL_TBLCATEGORYXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'frontbarcodexy',
                    index: 'frontbarcodexy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLBARCODEXY"><?= $LBL_TBLBARCODEXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backsssgsisnoxy',
                    index: 'backsssgsisnoxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLSSSGSISNOXY"><?= $LBL_TBLSSSGSISNOXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backtinxy',
                    index: 'backtinxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLTINNOXY"><?= $LBL_TBLTINNOXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backphihealthxy',
                    index: 'backphihealthxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLPHILHEALTHXY"><?= $LBL_TBLPHILHEALTHXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backdateofbirthxy',
                    index: 'backdateofbirthxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLBIRTHDATEXY"><?= $LBL_TBLBIRTHDATEXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backcivilstatusxy',
                    index: 'backcivilstatusxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLCIVILSTATUSXY"><?= $LBL_TBLCIVILSTATUSXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backguardiannamexy',
                    index: 'backguardiannamexy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLGUARDIANXY"><?= $LBL_TBLGUARDIANXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backguardianaddressxy',
                    index: 'backguardianaddressxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLGUARDADDRESSXY"><?= $LBL_TBLGUARDADDRESSXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backguardiantelnoxy',
                    index: 'backguardiantelnoxy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLGUARDTELXY"><?= $LBL_TBLGUARDTELXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'backsignaturexy',
                    index: 'backsignaturexy',
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLSIGNATUREXY"><?= $LBL_TBLSIGNATUREXY; ?></label>',
                    hidden: true
                },
                {
                    name: 'frontbatchxy',
                    index: 'frontbatchxy',
                    hidden: true
                },
                {
                    name: "idwidth",
                    index: "idwidth",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLIDWIDTH"><?= $LBL_TBLIDWIDTH; ?>ID Width</label>',
                    align: 'LEFT',
                    width: 65,
                    editable: true,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + gridID).saveCell(lastRow, lastCol);
                                }
                            }
                        ]
                    }

                },
                {
                    name: "idheight",
                    index: "idheight",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLIDHEIGHT"><?= $LBL_TBLIDHEIGHT; ?>ID Height</label>',
                    align: 'LEFT',
                    width: 65,
                    editable: true,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + gridID).saveCell(lastRow, lastCol);
                                }
                            }
                        ]
                    }

                },
                {
                    name: "picwidth",
                    index: "picwidth",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLIDWIDTH"><?= $LBL_TBLIDWIDTH; ?>Picture Width</label>',
                    align: 'CENTER',
                    width: 100,
                    editable: true,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + gridID).saveCell(lastRow, lastCol);
                                }
                            }
                        ]
                    }

                },
                {
                    name: "picheight",
                    index: "picheight",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLIDHEIGHT"><?= $LBL_TBLIDHEIGHT; ?>Picture Height</label>',
                    align: 'CENTER',
                    width: 100,
                    editable: true,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + gridID).saveCell(lastRow, lastCol);
                                }
                            }
                        ]
                    }

                },
                {
                    name: 'addedby',
                    index: 'addedby',
                    hidden: true
                },
                {
                    name: 'datedadded',
                    index: 'datedadded',
                    hidden: true
                },
                {
                    name: 'datemodified',
                    index: 'datemodified',
                    hidden: true
                },
                {
                    name: 'modifiedby',
                    index: 'modifiedby',
                    hidden: true
                }
            ],
            width: $(window).width() - 210,
            height: $(window).height() - 230,
            pager: "#" + pgID,
            jsonReader: {
                repeatitems: false
            },
            rowNum: 1000,
            cellsubmit: 'clientArray',
            autowidth: true,
            shrinkToFit: false,
            rownumbers: true,
            sortorder: 'ASC',
            sortname: 'id',
            multiselect: true,
            multiboxonly: true,
            viewrecords: true,
            footerrow: false,
            userDataOnFooter: false,
            cellEdit: true,
            beforeProcessing: function (data, status, xhr) {
                summarySQL = data.sql;
            },
            onSelectRow: function (id) {
            },
            afterEditCell: function (rowid, cellname, value, iRow, iCol) {
//                document.getElementById(iRow + '_' + cellname).select();

                lastCol = iCol;
                lastRow = iRow;
            },
            ondblClickRow: function (id) {
//                if (isAllowed()) {
                var rv = $(this).getRowData(id);
                jQuery("#" + gridID).saveCell(lastRow, lastCol);
                popupDialogForm('', 'idsetupsettings_dialog', rv);
//                }
            },
            loadComplete: function () {
            }
        });

        //  $("#" + gridID).jqGrid('setFrozenColumns');
    }
    function setTableListResizeGrids() {
        $("#tblIDSetupList").setGridWidth($('#main').width() - 10, false);
        $('#tblIDSetupList').jqGrid('setGridHeight', $('#main').height() - 150);
    }
    function setTableListResizeGridsTabs() {
        $("#tblSetupIDDetails").setGridWidth($('#divTabContent').width() - 5, false);
        //    $('#tblSetupIDDetails').jqGrid('setGridHeight', 100);



    }
    function FramePopupID(event, frmtitle, url) {
        if (event.ctrlKey)
            return;
        var dwidth = $(window).width() - 100;
        var dheight = $(window).height() - 50;
        var horizontalPadding = 150;
        var verticalPadding = 0;
        $('<iframe id="' + frmtitle + '" style="float:none;" frameborder="0" src="' + url + '" />')
                .dialog({
                    title: '<?php echo $LBL_SERVICEMASTERTITLE; ?>',
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
                        $(this).dialog('option', 'position', ['top', 0]);
                    },
                    close: function () {
                        $(this).dialog('destroy').remove();
                    }
                }).width(dwidth - horizontalPadding).height(dheight - verticalPadding);
    }

    function LoadSetupIDDetails(Grid, pgGrid, data) {
        $("#" + Grid).jqGrid('GridUnload');
        $("#" + Grid).jqGrid({
            url: "",
            datatype: "json",
            mtype: 'GET',
            postData: {
                ACTION: '',
                GETPARAM: {
                },
                TYPE: 1
            },
            colModel: [
                {
                    name: 'addID',
                    index: 'addID',
                    hidden: true
                },
                {
                    name: 'setup_id',
                    index: 'setup_id',
                    hidden: true
                },
                {
                    name: 'fieldorig',
                    index: 'fieldorig',
                    hidden: true
                },
                {
                    name: "fieldname",
                    index: "fieldname",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLFIELDNAME"><?= $LBL_TBLFIELDNAME; ?></label>',
                    align: 'LEFT',
                    width: 120,
                    sortable: false,
                    editable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {
                                    //   $('#divTabContent').scrollTop(264);
                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    //  $('#divTabContent').scrollTop(264);
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    // $('#divTabContent').scrollTop(264);

                                }
                            }
                        ]
                    }

                },
                {
                    name: "attrib1",
                    index: "attrib1",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLATTRIB1"><?= $LBL_TBLATTRIB1; ?></label>',
                    align: 'LEFT',
                    width: 70,
                    editable: true,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                }
                            }
                        ]
                    }

                },
                {
                    name: "value1",
                    index: "value1",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLVALUE1"><?= $LBL_TBLVALUE1; ?></label>',
                    align: 'LEFT',
                    width: 65,
                    editable: false,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {
                                    $('#divTabContent').scrollTop(264);
                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                }
                            }
                        ]
                    }

                },
                {
                    name: "attrib2",
                    index: "attrib2",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLATTRIB2"><?= $LBL_TBLATTRIB2; ?></label>',
                    align: 'center',
                    width: 70,
                    editable: true,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                }
                            }
                        ]
                    }

                },
                {
                    name: "value2",
                    index: "value2",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLVALUE2"><?= $LBL_TBLVALUE2; ?></label>',
                    align: 'center',
                    width: 65,
                    sortable: false,
                    editable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                }
                            }
                        ]
                    }

                },
                {
                    name: "attrib3",
                    index: "attrib3",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLATTRIB3"><?= $LBL_TBLATTRIB3; ?></label>',
                    align: 'center',
                    width: 70,
                    editable: true,
                    sortable: false,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                }
                            }
                        ]
                    }

                },
                {
                    name: "value3",
                    index: "value3",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLVALUE3"><?= $LBL_TBLVALUE3; ?></label>',
                    align: 'center',
                    width: 65,
                    sortable: false,
                    editable: true,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;',
                        dataEvents: [
                            {
                                type: 'keydown',
                                fn: function (e) {
                                    if (e.keyCode == 13) {
                                        e.keyCode = 9;
                                        return e.keyCode;
                                    }
                                }
                            },
                            {
                                type: 'focus',
                                fn: function (e) {

                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;
                                }
                            }
                        ]
                    }

                },
                {
                    name: "FLAG",
                    index: "FLAG",
                    hidden: true
                }

            ],
            pager: '#' + pgGrid,
            rownumbers: true,
            rowNum: 100,
            sortorder: 'DESC',
            sortname: 'piAddressType',
            width: $('#divTabContent').width() - 5,
            height: '60%',
            shrinkToFit: false,
            multiselect: false,
            multiboxonly: true,
            autowidth: true,
            viewrecords: true,
            footerrow: false,
            cellEdit: true,
            userDataOnFooter: true,
            jsonReader: {
                repeatitems: false
            },
            beforeProcessing: function (data, status, xhr) {
//                summarySQL = data.sql;
            },
            ondblClickRow: function (rowid, iRow, iCol, rowObject) {

            },
            onSelectRow: function (id) {
                var rv = $(this).getRowData(id);
                $('#txtFontSize').val(rv["value3"].split('px').join(''));
            },
            cellsubmit: 'clientArray',
            afterSaveCell: function (rowid, name, val, iRow, iCol) {

            },
            afterInsertRow: function (ids) {

            },
            afterEditCell: function (rowid, cellname, value, iRow, iCol) {
//                document.getElementById(iRow + '_' + cellname).select();

                lastCol = iCol;
                lastRow = iRow;
            },
            loadComplete: function () {
                $('td[id="pgSetupIDDetails_left"]').css('width', '33%');

            }
        });
        $("#" + Grid).jqGrid('navGrid', '#' + pgGrid, {edit: false, add: false, del: false, search: false, refresh: false});
//        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
//            buttonicon: "ui-icon-plusthick",
//            caption: '',
//            title: 'Add Address',
//            onClickButton: function (e) {
//                addSetupIDDetails(Grid);
//            }
//        });
//        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
//            buttonicon: "ui-icon-minusthick",
//            caption: '',
//            title: 'Remove Address',
//            onClickButton: function (e) {
//                deleteSetupIDDetails(Grid);
//            }
//        });
        clickLabel();
        $('td[id="pgSetupIDDetails_left"]').css('width', '33%');
        addRecordIDsetupDetails(Grid, data);
    }
    function addRecordIDsetupDetails(Grid, data) {
        if (data == null) {
            //No data record///
        } else {
            // console.log(data);

            var gridRow = data;
            $('#txtidwidth').val(gridRow["idwidth"].split('input').length > 1 ? '' : gridRow["idwidth"]);
            $('#txtidheight').val(gridRow["idheight"].split('input').length > 1 ? '' : gridRow["idheight"]);
            $('#txtpicwidth').val(gridRow["picwidth"].split('input').length > 1 ? '' : gridRow["picwidth"]);
            $('#txtpicheight').val(gridRow["picheight"].split('input').length > 1 ? '' : gridRow["picheight"]);
            $('#txtcategory').val(gridRow["category"].split('input').length > 1 ? '' : gridRow["category"]);
            var arrValItem = {};
            $.each(gridRow, function (k, v) {
                arrValItem[k] = v;
                if (k.split('front').length > 1 || k.split('back').length > 1) {
                    var arrvalues = v.split(';');
                    // console.log(k);
                    var newRow = [{
                            ID: getGridNewID(Grid),
                            fieldname: k.split('xy').join(""),
                            fieldorig: k,
                            attrib1: arrvalues[0].split(':')[0],
                            value1: arrvalues[0].split(':')[1],
                            attrib2: arrvalues[1].split(':')[0],
                            value2: arrvalues[1].split(':')[1],
                            attrib3: arrvalues[2].split(':')[0],
                            value3: arrvalues[2].split(':')[1],
                            FLAG: "Edit"
                        }];
                    $("#" + Grid).addRowData("ID", newRow, 'bottom');
                }
            });



        }
    }
    function reLoadSetupIDDetails() {
        $("#tblSetupIDDetails").setGridParam({
            postData: {
                ACTION: 'GetEmpAddress',
                GETPARAM: {
                    EMPID: $('input[id*="txtperson_code"]').val()
                },
                TYPE: 1
            }
        }).trigger("reloadGrid");
    }

    function popupDialogForm(event, div, data) {
        if (event.ctrlKey)
            return;
        var divPopupElement = $('div[id="' + div + '"');
        for (var i = 0; i < divPopupElement.length; i++) {
            if (i > 0) {
                $(divPopupElement).eq(i).remove();
            }
        }
        $('#' + div).dialog("destroy");
        $('#' + div).dialog("close");
        $('#' + div).dialog({
            title: $("<label/>", {id: "<?= $strModuleName ?>-LBL_MODULETITLE", text: "<?= $LBL_MODULETITLE ?>"}).get(0).outerHTML,
            autoOpen: false,
            draggable: false,
            resizable: true,
            width: $('#divIDSetupList').width(),
            //width: 1300,
            height: $(window).height() - 10,
            modal: false,
            overlay: {
                opacity: 1,
                background: "black"
            },
            open: function (event) {
                $('div[class="ui-widget-overlay"]').css('background', 'black').css('opacity', '0.05');
//                $('div[role="dialog"][aria-labelledby$="idsetupsettings_dialog"]').css('z-index', parseInt($('#header  .navbar').css('z-index')) + 30);

                clickLabel();
                $(this).dialog('option', 'position', ['left', 0]);
//                $(this).dialog('option', 'position', [$('#divIDSetupList').position().left + 5, $('#divIDSetupList').position().top + 5]);
                $("#txtbirthdate,#txtdatehired,#txtdateresign").datepicker({
                    dateFormat: '<?php echo $dateLabel['LBL_DATEFORMAT'] ?>',
                    dayNamesMin: [<?php echo $dateLabel['LBL_WEEKDAYS'] ?>],
                    monthNamesShort: [<?php echo $dateLabel['LBL_MONTHNAME'] ?>],
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function () {
                    }
                }).datepicker('setDate', new Date());
                //Reattach title if field has changes.
                $('div[id="idsetupsettings_dialog"] input,select,textarea:not(input[id$="isactive"],#txtSearchIDSetup)').map(function (index, elem) {
                    $(elem).bind("keyup", function (event) {
                        $(this).attr('title', $(this).val());
                    });
                });
                //End of Reattach title if field has changes.
                if (data == null) {
                    GlobalIDDataSeledted = null;
                    $('#txtIDsetup').val('');
                    $('#txtsetuptitle').val('');
                    $('#txtSetuptype').val('');
                    $('#chkissetdefault').attr('checked', true);
                    LoadSetupIDDetails('tblSetupIDDetails', 'pgSetupIDDetails', data);
                    $('#txtsetuptitle').attr('readonly', false);
                    $('#txtSetuptype').attr('disabled', false);


                } else {
                    GlobalIDDataSeledted = data;

                    $('#txtIDsetup').val(data["id"]);
                    $('#txtsetuptitle').val(data["title"]);
                    $('#txtSetuptype').val(data["setuptype"]);
                    $('#chkissetdefault').attr('checked', parseInt(data["setdefault"]) == 1);
                    if (parseInt($('#txtIDsetup').val()) <= 3) {
                        $('#txtsetuptitle').attr('readonly', true);
                        $('#txtSetuptype').attr('disabled', true);
//                        if ($.trim(getCookie("loginUserNameID")) === "1") {
//
//                        } else {
//                            swal("System Message", "Cannot Modify default id setup.", 'warning');
//                            return;
//                        }
                    } else {
                        $('#txtsetuptitle').attr('readonly', false);
                        $('#txtSetuptype').attr('disabled', false);
                    }

                    LoadSetupIDDetails('tblSetupIDDetails', 'pgSetupIDDetails', data);

                    LoadDivPrintIDContainer(data);
//                    funcIDSetupIniatialID(data);

                }

                //$('div[aria-labelledby$="idsetupsettings_dialog"] div[class="panel-body"] div:not(div[id="divPicImageThumb"])').css({"padding": "0px", "padding-left": "5px"});
                $('.input-group-addon').css({"text-align": "left"});
                $("#h-slider").slider({
                    orientation: "horizontal",
                    range: "min",
                    min: -350,
                    max: 350,
                    value: 60,
                    slide: function (event, ui) {
                        if (parseInt($('#txtIDsetup').val()) <= 3) {
                            if ($.trim(getCookie("loginUserNameID")) === "1") {

                            } else {
                                swal("System Message", "Cannot Modify default id setup.", 'warning');
                                return;
                            }
                        }
                        $("#amounth").val(ui.value);
                        var rowdata = $('#tblSetupIDDetails').jqGrid('getRowData', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'));
                        //console.log(rowdata);
                        if ($.isEmptyObject(rowdata)) {
                            swal("System Message", "No Item selected to be resized.", 'warning');
                        } else {
                            $('#' + rowdata["fieldorig"]).css(rowdata["attrib2"], ui.value + 'px');
                            $("#tblSetupIDDetails").setRowData($('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), {
                                value2: ui.value + "px",
                                FLAG: "Edit"

                            });
                            $("#tblSetupIDDetails").jqGrid('saveRow', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), false);
                        }

                    }
                });
                $("#amounth").val($("#h-slider").slider("value"));
                $("#v-slider").slider({
                    orientation: "vertical",
                    range: "min",
                    min: -350,
                    max: 350,
                    value: 60,
                    slide: function (event, ui) {
                        if (parseInt($('#txtIDsetup').val()) <= 3) {
                            if ($.trim(getCookie("loginUserNameID")) === "1") {

                            } else {
                                swal("System Message", "Cannot Modify default id setup.", 'warning');
                                return;
                            }
                        }
                        $("#amountv").val(ui.value);
//                        $('#frontpicturexy').css('margin-top', ui.value + 'px');
                        var rowdata = $('#tblSetupIDDetails').jqGrid('getRowData', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'));
                        //console.log(rowdata);
                        if ($.isEmptyObject(rowdata)) {
                            swal("System Message", "No Item selected to be resized.", 'warning');
                        } else {
                            $('#' + rowdata["fieldorig"]).css(rowdata["attrib1"], ui.value + 'px');
                            $("#tblSetupIDDetails").setRowData($('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), {
                                value1: ui.value + "px",
                                FLAG: "Edit"

                            });
                            $("#tblSetupIDDetails").jqGrid('saveRow', $('#tblSetupIDDetails').jqGrid('getGridParam', 'selrow'), false);
                        }
                    }
                });
                $("#amountv").val($("#v-slider").slider("value"));
                $('#txtFontSize').css('height', '34px');


            },
            close: function (event) {

            }
        });
//        $('#' + div).show();
        $('#' + div).dialog("open");
    }
    //function ID Setup initial values;
    function funcIDSetupIniatialID(data) {
//        console.log(data['mname']);
        //Front Populate
//        $('div[id="frontnamexy"] span').text(data['fname'].toString().toUpperCase() + ' ' + ($.trim(data['mname']) == "." ? "" : data['mname'].toString().toUpperCase().slice(0, 1) + ".") + ' ' + data['lname'].toString().toUpperCase());
//        $('div[id="frontidnumxy"] span').text($.trim(data['frontidnumxy']));
//        $('div[id="frontdesignationxy"] span').text(data['designation']);
//        $('div[id="frontcategoryxy"] span').text(data['category']);
//        $('div[id="emp_president"] span').text('BR. ELLAKIM P. SOSMEÑA, S.C.');
//        $('div[id="emp_president"] span').text('PRESIDENT');

        $('img[id="barcode"]').map(function (index, elem) {
            $(elem).JsBarcode(11, {width: 1, height: 50, displayValue: false, fontSize: 14, format: 'CODE39', font: "Arial,sans-serif"});
            $(elem).css({"width": "171px", "height": "25px"});
        });
        if (file_exists("../../../documents/EmployeePictures/" + $("#txtfrontidnumxy").val() + ".png")) {
            $('#frontpicturexy img').attr('src', '../../../documents/EmployeePictures/nopic.png' + "?time=" + new Date());
        } else {
            //Picture not exist.
            $('#frontpicturexy img').attr("src", '../../../documents/EmployeePictures/nopic.png' + "?time=" + new Date());
        }
        if (file_exists("../../../documents/EmployeeSignature/" + GlobalIDDataSeledted["frontidnumxy"] + ".png")) {
            $('#backsignaturexy img').attr("src", '../../../documents/EmployeeSignature/nopic' + ".png" + "?time=" + new Date());
        } else {
            //Picture not exist.
            $('#backsignaturexy img').attr("src", '../../../documents/EmployeeSignature/nopic.png' + "?time=" + new Date());
        }

        //Back ID Populate
//        $('div[id="backsssgsisnoxy"] span').text(data['sssgsisno']);
//        $('div[id="backtinxy"] span').text(data['tinno']);
//        $('div[id="backphihealthxy"] span').text(data['philno']);
//        $('div[id="backdateofbirthxy"] span').text(data['birthdatevalue']);
//        $('div[id="backcivilstatusxy"] span').text(data['status']);
//        $('div[id="backguardiannamexy"] span').text(data['contact_guardian']);
//        $('div[id="backguardianaddressxy"] span').text(data['contact_address']);
//        $('div[id="backguardiantelnoxy"] span').text(data['contactno']);


        $('img').map(function (index, elem) {
            var srcval = $(elem).attr('src');
            var newSrc = srcval.split('?')[0];
            // console.log(elem);
            if ($(elem).attr('id') == "barcode") {
            } else {
                $(elem).attr('src', newSrc + '?' + new Date());
            }
        });
    }
    //ENd of id setup initial values

    function saveIDSetupList(event) {
        if (event.ctrlKey) {
            return;
        }
        if (parseInt($('#txtIDsetup').val()) == 1 || parseInt($('#txtIDsetup').val()) == 2 || parseInt($('#txtIDsetup').val()) == 3) {
            //playWarningSound();
            if ($.trim(getCookie("loginUserNameID")).split('+').join(' ') == "1") {
//continue if admin (1)
            } else {
                swal("Access denied", "Default ID Setup can't be modified.", "error");
                return;
            }

        }

//        if (parseInt($('#txtIDsetup').val()) <= 3) {
//            if ($.trim(getCookie("loginUserNameID")) === "1") {
//
//            } else {
//                swal("System Message", "Cannot Modify default id setup.", 'warning');
//                return;
//            }
//        }

        //validate required fields first
        if ($.trim($('#txtsetuptitle').val()) == "" || $.trim($('#txtSetuptype').val()) == "") {
            $('input[id="btnSubmitSaveConfirmation"]').click();
            //   swal("System Message", "There are field empty.", 'warning');
            return;
        }
        var arrDataRow = $('#tblSetupIDDetails').jqGrid('getDataIDs');
        var arrSetupIDDetails = [];
        arrDataRow = $('#tblSetupIDDetails').jqGrid('getDataIDs');
        for (var i = 0; i < arrDataRow.length; i++) {

            var gridRow = $("#tblSetupIDDetails").getRowData(arrDataRow[i]);
            var arrValItem = {};
            var values = "";
            $.each(gridRow, function (k, v) {
                arrValItem[k] = v;
//                 if (k == "fieldname") {
//                    values = values + $.trim(v)+i + ')))';
//                }
                if (k == "attrib1") {
                    values = values + $.trim(v) + ':';
                }
                if (k == "value1") {
                    values = values + $.trim(v) + ';';
                }
                if (k == "attrib2") {
                    values = values + $.trim(v) + ':';
                }
                if (k == "value2") {
                    values = values + $.trim(v) + ';';
                }
                if (k == "attrib3") {
                    values = values + $.trim(v) + ':';
                }
                if (k == "value3") {
                    values = values + $.trim(v);
                }
            });
            arrSetupIDDetails.push(values);
        }
        console.log(arrSetupIDDetails);
        var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATECONFIRMATION'><?= $LBL_SAVEUPDATECONFIRMATION ?></label>";
        msgBox(message, "Confirmation", "ask", "Yes|No", 300, 250, function (dlgvalue) {
            clickLabel();
            if (dlgvalue == 1) {
                animation(1);
                $.ajax({
                    url: "../../../models/mod.cjc.idsetupsettings.php?ACTION=saveIDSetup",
                    type: "POST",
                    data: {
                        POSTPARAM: {
                            id: $.trim($('#txtIDsetup').val()) == "" ? $.trim($('#txtIDsetup').val()) : parseInt($('#txtIDsetup').val()),
                            title: $('#txtsetuptitle').val(),
                            setdefault: ($("#chkissetdefault").is(":checked") ? 1 : 0),
                            setuptype: $('#txtSetuptype').val(),
                            idwidth: $('#txtidwidth').val(),
                            idheight: $('#txtidheight').val(),
                            picwidth: $('#txtpicwidth').val(),
                            picheight: $('#txtpicheight').val(),
                            category: $('#txtcategory').val(),
                            frontpicturexy: arrSetupIDDetails[0],
                            frontnamexy: arrSetupIDDetails[1],
                            frontdesignationxy: arrSetupIDDetails[2],
                            frontidnumxy: arrSetupIDDetails[3],
                            frontcategoryxy: arrSetupIDDetails[4],
                            frontbarcodexy: arrSetupIDDetails[5],
                            backsssgsisnoxy: arrSetupIDDetails[6],
                            backtinxy: arrSetupIDDetails[7],
                            backphihealthxy: arrSetupIDDetails[8],
                            backdateofbirthxy: arrSetupIDDetails[9],
                            backcivilstatusxy: arrSetupIDDetails[10],
                            backguardiannamexy: arrSetupIDDetails[11],
                            backguardianaddressxy: arrSetupIDDetails[12],
                            backguardiantelnoxy: arrSetupIDDetails[13],
                            backsignaturexy: arrSetupIDDetails[14],
                            frontbatchxy: arrSetupIDDetails[15]

                        }
                    },
                    success: function (rec_code) {

                        if (rec_code !== "") {
                            var data = new FormData();
                            var img1 = document.getElementById("imgFilechooser1").files[0];
                            var img2 = document.getElementById("imgFilechooser2").files[0];
                            data.append('binImage1', img1);
                            data.append('binImage2', img2);
                            data.append('POSTPARAM[uploadID]', rec_code);
                            $.ajax({
                                url: '../../../models/mod.cjc.idsetupsettings.php?ACTION=uploadImage',
                                data: data,
                                cache: false,
                                contentType: false,
                                processData: false,
                                type: 'POST',
                                success: function (data) {
                                    var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATESUCCESS'><?= $LBL_SAVEUPDATESUCCESS ?></label>";
                                    msgBox(message, "Success", "success", "OK", 300, 250, function (dlgvalue) {
                                        $('#txtIDsetup').val(rec_code);
                                        //LoadIDSetupListDetails('');
                                        $('button[name="btnCancel"]').click();
                                        reloadtblIDSetupList();
                                        if (dlgvalue == 1) {

                                        }
                                    });
                                    var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                                    clickLabel();
                                    animation(0);
                                }
                            });
                        } else {
                            console.log(rec_code);
                            var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATEERROR'><?= $LBL_SAVEUPDATEERROR ?></label>";
                            msgBox(message, "Error", "failed", "OK", 300, 250, function (dlgvalue) {

                            });
                            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                            clickLabel();
                            animation(0);
                        }

                    }
                });
            }
        });
        var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
        clickLabel();
    }

    //Function Browsers & Commands
    //:::::::::::::::::::::::::::::::::
    function addSetupIDDetails(Grid) {

        var newRow = [{
                ID: getGridNewID(Grid),
                FLAG: "New"
            }];
        jQuery("#" + Grid).addRowData("ID", newRow, 'bottom');
    }
    function deleteSetupIDDetails(Grid) {

        var strRowIDs = $("#" + Grid).jqGrid('getGridParam', 'selarrrow');
        var arrRowIDs = $.trim(strRowIDs.toString()).split(',');
        var strRowID;
        if ($.trim(strRowIDs) === "") {
            return;
        }

        for (var i = 0; i < arrRowIDs.length; i++) {

            strRowID = arrRowIDs[i];
            var grid = $("#" + Grid);
            grid.jqGrid('setRowData', strRowID, {
                FLAG: 'Delete'
            });
            grid.jqGrid('saveRow', strRowID, false);
            //Hide the Row
            $("#" + strRowID, "#" + Grid).css({
                display: "none"
            });
        }

    }
    function checkIsActive(gridID, rowid, chkID) {
        changeFlag(gridID, rowid);
        var checked = $(gridID + ' input[id="' + chkID + '"]').is(":checked");
        $(gridID + ' input[id="' + chkID + '"]').attr("checked", checked);
    }
    function changeFlag(gridID, rowid) {

        var gridRow = $(gridID).getRowData(rowid);
        if (gridRow["FLAG"] !== "New") {
            $(gridID).jqGrid('setRowData', rowid, {
                FLAG: "Edit"
            });
            $(gridID).jqGrid('saveRow', rowid, false);
        }

    }

    //Image Functions
//:::::::::::::::
    //Images viewing/uploading function
    function showImageGridRatio(strID) {

        var div = $('#divImageGrid-' + strID);
        var img = $('#imgImageGrid-' + strID);
        var imgThumbPosTop = Math.floor((div.height() - img.height()) / 2);
        var imgThumbPosLeft = Math.floor((div.width() - img.width()) / 2);
        img.css({'margin-top': imgThumbPosTop + 'px', 'margin-left': imgThumbPosLeft + 'px'});
    }
    function setImage(strID) {

        var imgWidth;
        var imgHeight;
        //on the fly main image to canvas
        // ==========================================================================================================================================
        var imgMain;
        var imgProductMain = "divPicImageThumb";
        $("#" + imgProductMain).contents().remove();
        imgMain = document.createElement('img');
        imgMain.id = 'imgempPic';
        $(imgMain).css('display:block');
        imgMain.src = '../../../models/mod.cjc.idsetupsettings.php?ACTION=getImageOriginal&GETPARAM=' + strID;
        $("#" + imgProductMain).append(imgMain);
        $('img[id="imgempPic"]').css('height', '180px').css('width', '180px').addClass('img-polaroid');
        imgMain.onload = function () {
            imgWidth = imgMain.offsetWidth;
            imgHeight = imgMain.offsetHeight;
        };
    }
    function readURL(input, type) {
        var imgType = '', widthcm = $('#txtidwidth').val(), heightcm = $('#txtidheight').val();
        if (type == 1) {
            imgType = 'img_front';
        } else {
            imgType = 'img_back';
        }

        //if ($('#txtSetuptype :selected').val() == "Alumni") {
         //   widthcm = '8.35cm';
        //    heightcm = '5.3cm';
       // }
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var imgWidth;
                var imgHeight;

                var img = document.createElement('img');
                img.id = imgType;
                $(img).css('display:block');
                img.src = e.target.result;
                $("#" + imgType).attr('src', e.target.result);
                $('img[id="' + imgType + '"]').css('height', heightcm).css('width', widthcm);
                img.onload = function () {
                    imgWidth = img.offsetWidth;
                    imgHeight = img.offsetHeight;
                };
            };
//            console.log(input.files[0]);
            reader.readAsDataURL(input.files[0]);
        }
//        img id="img_front"
//        id="img_back"

    }
    function FileBrowser(event, type) {
        if (event !== null) {
            if (event.ctrlKey) {
                return;
            }
        }
        $('#imgFilechooser' + type).click();
    }
    function removeAttachement(event) {
        if (event !== null) {
            if (event.ctrlKey) {
                return;
            }
        }

        if (file_exists("../../../documents/EmployeePictures/" + parseInt($("#txtperson_code").val()) + ".jpg")) {
            msgBox("Are you sure to remove attachment?", "Confirm", 'ask', 'YES|NO', 0, 0, function (v) {
                if (v == 1) {
                    $.ajax({
                        url: '../../../models/mod.cjc.idsetupsettings.php?ACTION=removeAttachment',
                        data: {
                            POSTPARAM: parseInt($('#txtperson_code').val())
                        },
                        type: 'POST',
                        dataType: 'json',
                        async: false,
                        success: function (data) {

                        }
                    });
                    $("#imgempPic").removeAttr('src');
                    $("#idsetupsettings_dialog #imgempPic").attr("src", '../../../documents/EmployeePictures/2.png' + "?time=" + new Date());
                } else {
                    return;
                }
            });
        } else {
            $("#imgempPic").removeAttr('src');
            $("#idsetupsettings_dialog #imgempPic").attr("src", '../../../documents/EmployeePictures/2.png' + "?time=" + new Date());
        }

    }
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
//End of Image
//:::::::::::::::::::::::

    function LoadDivPrintIDContainer(data) {

        if (data['setuptype'] == "Alumni") {
            $('#divForAlumni div,#divForAlumni img').map(function (index, elem) {
                if ($(elem).attr('id') == undefined) {
                } else {
                    var arrRec = $(elem).attr('id').split('ALUMNIIDS');
                    console.log(arrRec);
                    if (arrRec.length == 2) {
                        $(elem).attr('id', arrRec[0]);
                    }
                }
            });
            $('#divForStudentEmployee div,#divForStudentEmployee img').map(function (index, elem) {
                if ($(elem).attr('id') == undefined) {

                } else {
                    var arrRec = $(elem).attr('id').split('EMPSTUDENT');
                    if (arrRec.length == 2) {

                    } else {
                        $(elem).attr('id', $(elem).attr('id') + 'EMPSTUDENT');
                    }
                    // console.log($(elem).attr('id'),arrRec.length);
                }
            });
            $('#divForAlumni').css({'display': ''});
            $('#divForStudentEmployee').css({'display': 'none'});
            $('#div_img_id_front,#div_img_id_back').css({'width': '7.96cm', 'height': '4.98cm'});
//            $('#_front').css({'border-bottom': 'black solid thin', 'border-right': 'none', 'padding-top': '10px', 'padding-bottom': '10px', 'margin-right': '150px'});
//            $('#_back').css({'margin-right': '168px', 'display': '', 'padding-top': '10px'});
            $('#img_front,#img_back').css({'width': '7.96cm', 'height': '4.98cm'});
//            top: 0px;position: absolute;margin-top: 95px;font-weight: bold;margin-left: 0px;text-align: left;left: 107px;width: 70%;transform: scale(0.89051, 1.01357);box-sizing: initial;
//            $('div[id="frontnamexy"]').css({'text-align': 'left', 'left': '107px', 'width': '70%'});
//            $('div[id="frontdesignationxy"]').css({'text-align': 'left', 'width': '70%'});
//            $('div[id="frontcategoryxy"]').css({'text-align': 'left'});
            $('#frontnamexy span').html('LASTNAME, Name <br style="content: &quot;&quot;;margin: -3px; display: block;"> MIDDLENAME');
            $('#barcode').css({'width': '240px', 'height': '40px'});
            //            $('#divIDPreview').addClass('rotate');
        } else {
            $('#divForAlumni div,#divForAlumni img').map(function (index, elem) {
                if ($(elem).attr('id') == undefined) {

                } else {
                    var arrRec = $(elem).attr('id').split('ALUMNIIDS');
                    if (arrRec.length == 2) {

                    } else {
                        $(elem).attr('id', $(elem).attr('id') + 'ALUMNIIDS');
                    }
                    //  console.log($(elem).attr('id'));
                }
            });
            $('#divForStudentEmployee div,#divForStudentEmployee img').map(function (index, elem) {
                if ($(elem).attr('id') == undefined) {
                } else {
                    var arrRec = $(elem).attr('id').split('EMPSTUDENT');
                    if (arrRec.length == 2) {
                        $(elem).attr('id', arrRec[0]);
                    }
                }
            });

            $('#divForAlumni').css({'display': 'none'});
            $('#divForStudentEmployee').css({'display': ''});
            $('#div_img_id_front,#div_img_id_back').css({'height': '7.96cm', 'width': '4.98cm'});
            $('#_front').css({'border-right': 'black solid thin', 'border-bottom': 'none', 'padding-top': '3px', 'padding-bottom': '30px', 'margin-right': 'auto'});
            $('#_back').css({'margin-right': 'auto', 'display': 'inline-block'});
            $('#img_front,#img_back').css({'height': '7.96cm', 'width': '4.98cm'});
//           $('#divIDPreview').removeClass('rotate');
            // frontnamexy top: 0px; position: absolute; margin-top: 95px; font-weight: bold; margin-left: 0px; text-align: right; right: 93px; width: 85%; transform: scale(0.89051, 1.01357); box-sizing: initial;
            $('div[id="frontnamexy"]').css({'text-align': 'right', 'left': '', 'right': '93px', 'width': '85%'});
            $('div[id="frontdesignationxy"]').css({'text-align': 'right', 'left': '', 'right': '1px', 'width': '85%'});
            $('div[id="frontpicturexy"]').css({'width': '95px', 'height': '95px', 'top': '0px', 'position': 'absolute', 'margin-top': '76px', 'right': '10px', 'text-align': 'center', 'box-sizing': 'initial', 'left': ''});
            $('div[id="frontcategoryxy"]').css({'text-align': 'center'});
            $('#frontnamexy span').html('NAME M. LASTNAME');

            $('#barcode').css({'width': '171px', 'height': '26px'});
        }


        $('#divIDPreview div,#divIDPreview img,#divIDPreview span').map(function (index, elem) {
            $(elem).css({"-webkit-box-sizing:": "border-box", "-moz-box-sizing": "border-box", "box-sizing": "initial"})
        });
        //setup id xy configuration
//        console.log(data, data['frontpicturexy'].toString());
//img_front img_back
        $('#img_front').attr('src', "../../../../ID/documents/zzzIDSetupImage/FRONT" + data['id'] + ".png?" + new Date() + "");
        $('#img_back').attr('src', "../../../../ID/documents/zzzIDSetupImage/BACK" + data['id'] + ".png?" + new Date() + "");

        $('#div_img_id_frontdis,#img_front,#div_img_id_backdis,#img_back').css({'width': data['idwidth'], 'height': data['idheight']});
        $('div[id="frontpicturexy"],div[id="frontpicturexy"] img').css({'width': data['picwidth'], 'height': data['picheight']});
        $('#div_img_id_front,#div_img_id_back').css({'width': data['idwidth'], 'height': data['idheight']});

//
        var frontpicturexy = data['frontpicturexy'].toString().split(';');
        var arrp1 = frontpicturexy[0].split(':');
        var arrp2 = frontpicturexy[1].split(':');
        var arrp3 = frontpicturexy[2].split(':');
        $('div[id^="frontpicturexy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="frontpicturexy"] span').css(arrp3[0], arrp3[1]);


        var frontbatchxy = data['frontbatchxy'].toString().split(';');
        arrp1 = frontbatchxy[0].split(':');
        arrp2 = frontbatchxy[1].split(':');
        arrp3 = frontbatchxy[2].split(':');
        $('div[id^="frontbatchxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="frontbatchxy"] span').css(arrp3[0], arrp3[1]);

        var frontnamexy = data['frontnamexy'].toString().split(';');
        arrp1 = frontnamexy[0].split(':');
        arrp2 = frontnamexy[1].split(':');
        arrp3 = frontnamexy[2].split(':');
        $('div[id^="frontnamexy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="frontnamexy"] span').css(arrp3[0], arrp3[1]);

        var frontdesignationxy = data['frontdesignationxy'].toString().split(';');
        arrp1 = frontdesignationxy[0].split(':');
        arrp2 = frontdesignationxy[1].split(':');
        arrp3 = frontdesignationxy[2].split(':');
        $('div[id^="frontdesignationxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="frontdesignationxy"] span').css(arrp3[0], arrp3[1]);

        var frontidnumxy = data['frontidnumxy'].toString().split(';');
        arrp1 = frontidnumxy[0].split(':');
        arrp2 = frontidnumxy[1].split(':');
        arrp3 = frontidnumxy[2].split(':');
        $('div[id^="frontidnumxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="frontidnumxy"] span').css(arrp3[0], arrp3[1]);

        var frontcategoryxy = data['frontcategoryxy'].toString().split(';');
        arrp1 = frontcategoryxy[0].split(':');
        arrp2 = frontcategoryxy[1].split(':');
        arrp3 = frontcategoryxy[2].split(':');
        $('div[id^="frontcategoryxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="frontcategoryxy"] span').css(arrp3[0], arrp3[1]);

        var frontbarcodexy = data['frontbarcodexy'].toString().split(';');
        arrp1 = frontbarcodexy[0].split(':');
        arrp2 = frontbarcodexy[1].split(':');
        arrp3 = frontbarcodexy[2].split(':');
        $('div[id^="frontbarcodexy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="frontbarcodexy"] span').css(arrp3[0], arrp3[1]);


        var backsssgsisnoxy = data['backsssgsisnoxy'].toString().split(';');
        arrp1 = backsssgsisnoxy[0].split(':');
        arrp2 = backsssgsisnoxy[1].split(':');
        arrp3 = backsssgsisnoxy[2].split(':');
        $('div[id^="backsssgsisnoxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backsssgsisnoxy"] span').css(arrp3[0], arrp3[1]);


        var backtinxy = data['backtinxy'].toString().split(';');
        arrp1 = backtinxy[0].split(':');
        arrp2 = backtinxy[1].split(':');
        arrp3 = backtinxy[2].split(':');
        $('div[id^="backtinxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backtinxy"] span').css(arrp3[0], arrp3[1]);

        var backphihealthxy = data['backphihealthxy'].toString().split(';');
        arrp1 = backphihealthxy[0].split(':');
        arrp2 = backphihealthxy[1].split(':');
        arrp3 = backphihealthxy[2].split(':');
        $('div[id^="backphihealthxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backphihealthxy"] span').css(arrp3[0], arrp3[1]);

        var backdateofbirthxy = data['backdateofbirthxy'].toString().split(';');
        arrp1 = backdateofbirthxy[0].split(':');
        arrp2 = backdateofbirthxy[1].split(':');
        arrp3 = backdateofbirthxy[2].split(':');
        $('div[id^="backdateofbirthxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backdateofbirthxy"] span').css(arrp3[0], arrp3[1]);

        var backcivilstatusxy = data['backcivilstatusxy'].toString().split(';');
        arrp1 = backcivilstatusxy[0].split(':');
        arrp2 = backcivilstatusxy[1].split(':');
        arrp3 = backcivilstatusxy[2].split(':');
        $('div[id^="backcivilstatusxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backcivilstatusxy"] span').css(arrp3[0], arrp3[1]);

        var backguardiannamexy = data['backguardiannamexy'].toString().split(';');
        arrp1 = backguardiannamexy[0].split(':');
        arrp2 = backguardiannamexy[1].split(':');
        arrp3 = backguardiannamexy[2].split(':');
        $('div[id^="backguardiannamexy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backguardiannamexy"] span').css(arrp3[0], arrp3[1]);

        var backguardianaddressxy = data['backguardianaddressxy'].toString().split(';');
        arrp1 = backguardianaddressxy[0].split(':');
        arrp2 = backguardianaddressxy[1].split(':');
        arrp3 = backguardianaddressxy[2].split(':');
        $('div[id^="backguardianaddressxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backguardianaddressxy"] span').css(arrp3[0], arrp3[1]);

        var backguardiantelnoxy = data['backguardiantelnoxy'].toString().split(';');
        arrp1 = backguardiantelnoxy[0].split(':');
        arrp2 = backguardiantelnoxy[1].split(':');
        arrp3 = backguardiantelnoxy[2].split(':');
        $('div[id^="backguardiantelnoxy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backguardiantelnoxy"] span').css(arrp3[0], arrp3[1]);

        var backsignaturexy = data['backsignaturexy'].toString().split(';');
        arrp1 = backsignaturexy[0].split(':');
        arrp2 = backsignaturexy[1].split(':');
        arrp3 = backguardiantelnoxy[2].split(':');
        $('div[id^="backsignaturexy"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id^="backsignaturexy"] span').css(arrp3[0], arrp3[1]);
        //end of id xy configuration

    }
    function SelectIDSetupChange(el) {
        console.log(el, $(el + ':selected').val());
        if ($(el + ':selected').val() == "Alumni") {
            $('td[aria-describedby="tblSetupIDDetails_attrib2"]').map(function (index, elem) {
                if (index < 3) {
                    $(elem).text("left");
                }

            });
            $('#txtidwidth').val('7.96cm');
            $('#txtidheight').val('4.98cm');
        } else {
            $('td[aria-describedby="tblSetupIDDetails_attrib2"]').map(function (index, elem) {
                if (index < 3) {
                    $(elem).text("right");
                }

            });
            $('#txtidwidth').val('4.98cm');
            $('#txtidheight').val('7.96cm');
        }
        $('#txtpicwidth').val('90px');
        $('#txtpicheight').val('90px');

    }
</script>
<div  class="container-fluid">
    <div class="panel panel-default" style="margin: 0px;">
        <div class="panel-heading heading-style" style="height: 50px;">
            <div class="contaner-fluid">
                <div class="row-fluid">
                    <div class="">
                        <div class="row-fluid">
                            <div class="col-xs-6 text-left">
                                <div class="input-group">
                                    <input id="txtSearchIDSetup" class="form-control txt-standard" type="text" placeholder="Search">
                                    <span class="input-group-addon" style="padding: 0px;">
                                        <button name="btnSearchEmployee" class="btn btn-default btn-md btn-standard">
                                            <span class="glyphicon glyphicon-search search-standard"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-6" style="float:right;margin-top: -2px;padding-right: 0;">

                                <button id="<?= $strModuleName ?>-LBL_CANCEL" name="btnExitCancel" class="btn btn-info btn-lg" title="Cancel" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;    width: 13%;">
                                    <span class="glyphicon glyphicon-remove-circle"></span> <?= $LBL_CANCEL ?>
                                </button> 
                                <button id="<?= $strModuleName ?>-LBL_PREVIEWID" name="btnPreviewID" class="btn btn-info btn-lg" title="export" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;    width: 15%;">
                                    <span class="glyphicon glyphicon-export"></span> <?= $LBL_PREVIEWID ?> 
                                </button>
                                <button id="<?= $strModuleName ?>-LBL_REFRESH" name="btnRefresh" class="btn btn-info btn-lg" title="Refresh" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;    width: 13%;">
                                    <span class="glyphicon glyphicon-refresh"></span> <?= $LBL_REFRESH ?>
                                </button> 

                                <button id="<?= $strModuleName ?>-LBL_EDIT" name="btnEdit" class="btn btn-info btn-lg" title="Edit" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;    width: 13%;">
                                    <span class="glyphicon glyphicon-edit"></span> <?= $LBL_EDIT ?>   
                                </button> 
                                <button  id="<?= $strModuleName ?>-LBL_NEW" name="btnNew" class="btn btn-info btn-lg" title="New" style="padding: 7px 12px;float: right;font-size: 12px;    width: 13%;">
                                    <span class="glyphicon glyphicon-new-window"></span> <?= $LBL_NEW ?>   
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body" id="panel-body" style="padding:0px;"> 
        <div class="row-fluid" style="padding: 0px 0px 0px 0px;">
            <div  class="col-xs-6" id="divIDSetupList" style=" border: black solid 4px;    padding: 0;    height: 86%;width:45%;">
                <table id="tblIDSetupList"></table>
                <div id="pgIDSetupList"></div>
            </div>
            <div class="col-xs-6" id="divPrintPreview" style=" color: black;border: black solid 4px;    padding: 0;    height: 86%;width:55%;">
                <div id="divIDPreview" class="panel-body" style=" padding: 0;padding-top:0px;padding-bottom:0px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing: initial;">
                    <div style="text-align: center; display: inline-block; box-sizing: initial;" id="div_print_id">
                        <div id="divForStudentEmployee" style="width: auto; box-sizing: initial;">
                            <div id="_front" style="display: inline-block; border-right-color: black; border-right-style: solid; border-right-width: thin; padding: 10px 25px 30px; box-sizing: initial;">
                                <div id="div_img_id_front" style="border-radius: 10px; border: rgba(153, 153, 153, 0) dashed 0.5px; width: 5.30cm; height: 8.35cm; position: relative; float: left; box-sizing: initial;">
                                    <img id="img_front" src="../../../../ID/documents/zzzIDSetupImage/FRONT1.png?Wed Mar 09 2016 18:31:59 GMT-0800 (Pacific Standard Time)" style="border-radius: 5px; width: 5.30cm; height: 8.35cm; box-sizing: initial;" alt="Emp ID">
                                    <div id="frontpicturexy" style="width: 95px; height: 95px; top: 0px; position: absolute; margin-top: 76px; right: 10px; text-align: center; box-sizing: initial;">
                                        <img src="../../../documents/EmployeePictures/nopic.png?time=Wed Mar 09 2016 18:32:01 GMT-0800 (Pacific Standard Time)" style="width: 95px; height: 95px; border: thin solid transparent; border-radius: 5px; box-sizing: initial;" alt="">
                                    </div> 
                                    <div id="frontbarcodexy" style="position: absolute; font-weight: bold; text-align: center; width: 100%; top: 0px; transform: scale(1, 0.9081); box-sizing: initial; margin-top: 236px; left: 1px;"> 
                                       <!--<img id="barcode" style="width: auto;height:auto;"/>-->
                                        <img id="barcode" style="width: 171px; height: 26px; box-sizing: initial;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOQAAAAyCAYAAABMMHe/AAAD20lEQVR4Xu2d3XaDIBCEk/d/6PYkxojIMrOuOd58uelJW1JFlvlhoM+H//p7PB7P5tfX96+v6+v189H79fujn69t289zPqdtl/37/X1k27e/P7r+/vPa+8/cr/s52etX9x/1/+h6qvdzR/9Fz2/W39Xxb1Va+2BUg+oFRQWceaDRwL56QKoHQ0EuE280QVcL2p2IZhP9DBgoyA9ygpDbtOcwAndgXj0hVQuq2t69bwoSynqg5HdQLkU5FcKr9tWCqranIBVfbRDOGYBqQCjKh4bUWrx9DiDkuL+icQhlhbJeprlG2o2CpCC/AwyXdSmHmeuMyxojvsO4ru4/EBKEBCEbWaQKDA2Jhnz3gKNde0ZwxwyvTBml4VX7qilTbU9BUpAUZDMhVQuq2p6CpCApSAryWwX9+maWYo8mFKPE9kkL1YCkzpjSQlmPphYIufTJqJCndUZ0LmeXu0mjX1MupQHRkPN1XFxWXFZcVlxWRUKhrOv6YY8oCmGiGdZxaUcUN0PxCAbUKPLMJVfPPQrTO+NHV2OX1lcN0JBoyJlZcTYsf4cGh7JCWaGsUFaFeVBWKKtvfkT7C6sUHITsZipdtnvO7nSg4uJKg2W1mMPhe0rV3ke2vbr+2f1XBzAaEg357gE0JBoSDbnBV/YIGwv4WIdkHdI96gLKWjtTioIcRMGiCBSUdemBM0diVCm4I4FUdC27bITLisuKy4rLqkESygplhbJuJpEyIwkGfHpolL6vuKTVLCguK8dAYuoE6fkzR4hQkHu3MEIGR1ujIbe+nC3Xab5KdO67nOMMvMxBz6xD+lIAU6cT11blsg4ZHmJ1x4CqIrxqn3EtQUgQ8nCEfRbh1IBU4h4NiYZEQ6IhhzvQf6GhQcj9sZ5qHdQBBIuJsuzhax005JGaRcsA1YL+tQYnGEAwgGAAwQANkiAkCEkwgGDAd6bIUp6rsqiYOqxDvnpAjQMVSDlDzacwCUKCkCAkCAlCdpo6M9OyQXkroDO7UzjkSmzrySwsQ1nH63+O7Z45MSEzQWSe38g9vSNYgcuKy4rLisuKyzoS5VdQPpI6JHVI6pDUIanTYMzZc2DRkGjIsJDOmhLKrldZXNUeDUl0brebYrav7ArKqQakGtBQVigrlBXKCmWFsu4THVGyJmu7K4QBIecnilcRXrWHskJZoayDZQF310N2QqQglx5z+4HtV591y7sGJBrSjxQSDNhm0hmz04uQnKnz7qMzG3wV5XYnElzWoySaZWuzmxGi50BSh6QOSR2SOhok2e0BQrLbY6kThczVfzalqxHKCmUVA9Exi9CQF2rIf/Zqsueh2C4iAAAAAElFTkSuQmCC">   
                                    </div> 
                                    <div id="frontnamexy" style="top: 0px; position: absolute; margin-top: 178.5px; font-weight: bold; margin-left: 0px; text-align: right; right: 1px; width: 85%; transform: scale(0.89051, 1.01357); box-sizing: initial;"> 
                                        <span style="font-size: 10px; box-sizing: initial;">NAME M. LASTNAME</span>
                                    </div> 
                                    <div id="frontidnumxy" style="top: 0px; position: absolute; margin-top: 216.4px; font-weight: bold; text-align: left; left: 7px; width: 32%; font-size: 9px; transform: scale(0.757801, 1.01026); box-sizing: initial;">
                                        <span style="font-size: 11px; box-sizing: initial;">0000-0000-0</span> 
                                    </div> 
                                    <div id="frontcategoryxy" style="top: 0px; position: absolute; margin-top: 218.2px; font-weight: bold; text-align: center; left: 68px; font-size: 9px; width: 60%; transform: scale(1.00517, 1.01404); box-sizing: initial;"> 
                                        <span style="box-sizing: initial;">BASIC EDUCATION</span>
                                    </div> 
                                    <div id="frontdesignationxy" style="top: 0px; position: absolute; margin-top: 193.5px; font-weight: bold; margin-left: 0px; text-align: right; right: 1px; width: 85%; transform: scale(0.89051, 1.01357); box-sizing: initial;"> 
                                        <span style="font-size: 10px; box-sizing: initial;">FACULTY</span>
                                    </div> 
                                    <div id="emp_pressignature" style="display: none; top: 0px; position: absolute; margin-top: 274px; text-align: center; width: 210px; box-sizing: initial;">
                                        <img src="../../../documents/PresidentSignature/PresidentSignature.png?Wed Mar 09 2016 18:31:59 GMT-0800 (Pacific Standard Time)" style="width: 128px; height: 20px; border: thin solid transparent; border-radius: 5px; box-sizing: initial;" alt=""> 
                                    </div> 
                                    <div id="emp_presidentname" style="display: none; top: 0px; position: absolute; margin-top: 293px; font-weight: bold; margin-left: 0px; text-align: center; width: 220px; transform: scale(0.781, 0.8157); box-sizing: initial;">
                                        <span style="color: rgb(61, 11, 12); font-size: 12px; box-sizing: initial;">BR. ELLAKIM P. SOSMEÑA, S.C.</span> 
                                    </div> 
                                    <div id="emp_president" style="display: none; top: 0px; position: absolute; margin-top: 303px; font-weight: bold; text-align: center; width: 220px; transform: scale(0.71, 0.75); box-sizing: initial;">
                                        <span style="font-size: 11px; color: rgb(61, 11, 12); box-sizing: initial;"> President</span>
                                    </div> 
                                </div>
                            </div> 
                            <div id="_back" style="display: inline-block; padding: 10px 0px 30px 20px; box-sizing: initial;"> 
                                <div id="div_img_id_back" style="border-radius: 10px; border: rgba(153, 153, 153, 0) dashed 0.5px; width: 5.30cm; height: 8.35cm; position: relative; float: right; box-sizing: initial;"> 
                                    <img id="img_back" src="../../../../ID/documents/zzzIDSetupImage/BACK1.png?Wed Mar 09 2016 18:31:59 GMT-0800 (Pacific Standard Time)" style="border-radius: 5px; width: 5.30cm; height: 8.35cm; box-sizing: initial;" alt="Emp ID">
                                    <div id="backsssgsisnoxy" style="position: absolute;top: 0;margin-top: 25px; left: 45px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold; box-sizing: initial;"> <span style="box-sizing: initial;">0000000000</span></div>
                                    <div id="backtinxy" style="position: absolute; top: 0;margin-top: 45px; left: 45px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold; box-sizing: initial;"> <span style="box-sizing: initial;">0000000000</span></div>
                                    <div id="backphihealthxy" style="position: absolute; top: 0;margin-top: 64px; left: 45px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold; box-sizing: initial;"> <span style="box-sizing: initial;">0000000000</span></div> 
                                    <div id="backdateofbirthxy" style="position: absolute; top: 0;margin-top: 84px; left: 45px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold; box-sizing: initial;">  <span style="box-sizing: initial;">yyy-mm-dd</span></div>
                                    <div id="backcivilstatusxy" style="position: absolute; top: 0;margin-top: 105px; left: 45px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold; box-sizing: initial;"> <span style="box-sizing: initial;">Single</span></div>
                                    <div id="backguardiannamexy" style="position: absolute; top: 0;margin-top: 143px; left: -10px; font-size: 12px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold; box-sizing: initial;"> <span style="box-sizing: initial;">NAME S. LASTNAME</span></div>
                                    <div id="backguardianaddressxy" style="position: absolute; top: 0;margin-top: 157px; left: -10px; font-size: 11px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold; box-sizing: initial;"> <span style="box-sizing: initial;">Street Name Davao del Sur</span></div>
                                    <div id="backguardiantelnoxy" style="position: absolute; top: 0;margin-top: 199px; left: 55px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold; box-sizing: initial;"> <span style="box-sizing: initial;">00000000000</span></div>
                                    <div id="backsignaturexy" style="width: 100%; position: relative; top: 0;margin-top: -56px; transform: scale(0.91, 0.975); font-weight: bold; box-sizing: initial; left: 0px;">
                                        <img src="../../../documents/EmployeeSignature/samplesignature.png?time=Wed Mar 09 2016 18:32:01 GMT-0800 (Pacific Standard Time)" style="/*width: 160px;height: 35px;*/height:50px;border: thin solid transparent; border-radius: 5px; box-sizing: initial;" alt=""> 
                                    </div> 
                                </div>
                            </div> 
                        </div> 
                        <div id="divForAlumni" style="width:auto;display:none;">
                            <div id="_front" style="display:inline-block;border-right:black solid thin;   padding: 10px 0px 30px 0px;">
                                <div id="div_img_id_front" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width:7.96cm;height:4.98cm;position:relative;float:left;">
                                    <img id="img_front" src="../../../../ID/documents/zzzIDSetupImage/Front3.png?Fri Apr 22 2016 20:53:11 GMT-0700 (Pacific Daylight Time)" style="border-radius:5px;width:7.96cm;height:4.98cm;" alt="Emp ID">
                                    <div id="frontpicturexy" style="width: 95px; height: 95px; top: 0px; position: absolute; margin-top: 85px; right: 10px; text-align: center; left: 5px;">
                                        <img src="../../../documents/AlumniPictures/nopic.png?time=Fri Apr 22 2016 20:53:11 GMT-0700 (Pacific Daylight Time)" style="width: 95px;height: 95px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt="">
                                    </div> 
                                    <div id="frontbarcodexy" style="top: 0px; position: absolute; font-weight: bold; text-align: center; width: 100%; margin-top: 152px; left: 52px; transform: scale(1, 0.9081);"> 
                                      <!-- <img id="barcode0" style="width: auto;height:auto;"/>-->
                                        <img id="barcode" style="width: 240px; height: 40px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOQAAAAyCAYAAABMMHe/AAAD4klEQVR4Xu2d0XKrMAxEyf9/dDuEUBxjS7sIZvpw+nKbCwaqeL2rtWxei/7zsyzLqzl9/7z+u/+sx0efo//f27bXc64zat8/j3v/anv3frPzledw/v7RfZz4j57HuX+1/az/qfGL+mkUh/36lf4vIa29QdYAQJ4HHreDuOcDyG2AzwABID9MqAbiLsZQR3ilIzsDzJ3PX2WkXoE4DKXGz/lenfvDkAntwZBHgCIJDiDnqQiA1FK2TIG+jwNIAFllbAAJIP8ioCbZLsNVJa97P0ciIlm3b0cxASMTR4ljm7s6KU4kzUOmhCFhSBhyPnsAIBOzSDUlqgxXbQ9DbhHsOzSmDqbOl7Spdgi1PYAEkP2AhKnzwAgNIM9Aw9TB1MHU+UTANbVUye+YTAASQAJIAInLWrV9ZzWujsunjvBVU6banhySHJIcsskZq4CqtgeQABJAAsi/aYbZgKIqDHLIceGBmrNH5l/otlIYcISHWtZ83lB1masKIxpQnBSnv070Obputtoku4+MM/nEZsJecdWqX0gk+ZSSp+r9q+2RrEhWJCuSFcnauM/Kwvl24IUhgx0IYEh95wVFsUQlbBUJqOZUrmJAsoaZ5naQaY8jSFlO4XZAx0SpSHZMnW8pDUN2kmI2wsKQMGSfg0WEoA5omDrC6g1HMqkjfNWUqbaHITF1MHUwdTB1MHXG0upJhqnkUKPnckwRtT0MCUPCkDAkDAlDwpBuDuycrygNh+HVHFw1SZj20Pu/MJHBrnNPdSgkK5IVyYpkRbIiWXXKZj1kvrtZNE82K35Hsh5F8Vn8mIdkHvLdB65W9pBD8m6Pae5J6dwRmqsAcyuTACSABJBNBKKi7CulXADybPa4krviUiNZkaxI1sRsA5AdA0jzI6z2mL6I1hmxYUgYMsQbOwYc4WELD7bwWHvD6CU+mWeQubsyzuQTYUgYcpJbO5JzZFI57asKgxySHJIckhxSfw8rDIlkdXLgKsNV28OQjUxhHpJ5yCqgqu0BJIC89Do7isvPbqpTOjkC7pV538xsaY9HSgFT55N7zr6YLJBKO4fx7wJYdYRXl09FHVpZ4M3yK3Yul95mVO2QVcmktr8LwMrA4rqUAHJcjA5Dsi9r+spvAEkta5M1fv/qSDylI13JCWDI83I3GJLlV+8+EFW2AMj5vqrVaQZFcpJDaut0My+iX1yg7jARpTZTxlsPMA95hIfSOUrneqIBkEJlT4UhVFPmSYaHIfMF20x7hDy6HSSHPIKUzUvhsm6xurqeFEACyLQAwJnYBpAAsh+QBIiRQ6pJ+l0AozDgDFTXJa5I/p55/52p8wvlmLLnGPqtDgAAAABJRU5ErkJggg==">   
                                    </div> 
                                    <div id="frontbatchxy" style="top: 0px;position: absolute;margin-top: 53px;font-weight: bold;margin-left: 0px;text-align: center;right: 1px;width: 42%;transform: scale(0.89051, 1.01357);left: 114px;"> 
                                        <span style="font-size:10px;">Batch: 0000</span>
                                    </div>
                                    <div id="frontnamexy" style="top: 0px; position: absolute; margin-top: 89px; font-weight: bold; margin-left: 0px; text-align: left; right: 1px; width: 70%; transform: scale(0.89051, 1.01357); left: 99px;"> 
                                        <span style="font-size:10px;">LASTNAME, First Name<br style="content:'';margin: -3px; display: block;">MIDDLENAME</span>
                                    </div> 
                                    <div id="frontidnumxy" style="top: 0px; position: absolute; margin-top: 137px; font-weight: bold; text-align: left; left: 100px; width: 32%; font-size: 9px; transform: scale(0.757801, 1.01026);">
                                        <span style=" font-size: 11px;">0000-0000-0</span> 
                                    </div> 
                                    <div id="frontcategoryxy" style="top: 0px; position: absolute; margin-top: 125px; font-weight: bold; text-align: left; left: 111px; font-size: 9px; width: 60%; transform: scale(1.00517, 1.01404);"> 
                                        <span style="font-size: 9px;">BASIC EDUCATION</span>
                                    </div> 
                                    <div id="frontdesignationxy" style="top: 0px; position: absolute; margin-top: 112px; font-weight: bold; margin-left: 0px; text-align: left; right: 1px; width: 70%; transform: scale(0.89051, 1.01357); left: 99px;"> 
                                        <span style="font-size:10px;">High School</span>
                                    </div> 
                                    <div id="emp_pressignature0" style="display:none;top:0px;position:absolute;margin-top: 274px;/* margin-left: 83px; */text-align: center;width: 210px;">
                                        <img src="../../../documents/PresidentSignature/PresidentSignature.png" style="width: 128px;height: 20px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> 
                                    </div> 
                                    <div id="emp_presidentname0" style="display:none;top:0px;position:absolute;margin-top: 293px;font-weight: bold;margin-left: 0px;text-align: center;width: 220px; -webkit-transform: scale(0.781,0.81570);">
                                        <span style="color:#3d0b0c;font-size: 12px;">BR. ELLAKIM P. SOSMEÑA, S.C.</span> 
                                    </div> 
                                    <div id="emp_president0" style="display:none;top:0px;position:absolute;margin-top: 303px;font-weight: bold;text-align: center;width: 220px;-webkit-transform: scale(0.71,0.75);">
                                        <span style=" font-size: 11px; color: #3d0b0c; "> President</span>
                                    </div> 
                                </div>
                            </div>
                            <div id="_back" style="display: inline-block;    padding: 0px 0px 30px 0px;"> 
                                <div id="div_img_id_back" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width:7.96cm;height:4.98cm;position:relative;float:right;"> 
                                    <img id="img_back" src="../../../../ID/documents/zzzIDSetupImage/BACK3.png?Fri Apr 22 2016 20:53:11 GMT-0700 (Pacific Daylight Time)" style="border-radius:5px;width:7.96cm;height:4.98cm;" alt="Emp ID">
                                    <div id="backsssgsisnoxy" style="position: absolute; top: 0px; margin-top: 12px; left: 72px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span style="font-size: 12px;">0000000000</span></div>
                                    <div id="backtinxy" style="position: absolute; top: 0px; margin-top: 24px; left: 72px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span style="font-size: 12px;"></span>0000000000</div>
                                    <div id="backphihealthxy" style="position: absolute; top: 0px; margin-top: 37px; left: 72px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span style="font-size: 12px;">0000000000</span></div> 
                                    <div id="backdateofbirthxy" style="position: absolute; top: 0px; margin-top: 49px; left: 72px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;">  <span style="font-size: 12px;">January 01, 2016</span></div>
                                    <div id="backcivilstatusxy" style="position: absolute; top: 0px; margin-top: 62px; left: 72px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span style="font-size: 12px;">Single</span></div>
                                    <div id="backguardiannamexy" style="position: absolute; top: 0px; margin-top: 91px; left: -21px; font-size: 12px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold;"> <span style="font-size: 12px;">NAME S. LASTNAME</span></div>
                                    <div id="backguardianaddressxy" style="position: absolute; top: 0px; margin-top: 105px; left: -21px; font-size: 11px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold;"> <span style="font-size: 12px;">Street Name Davao del Sur</span></div>
                                    <div id="backguardiantelnoxy" style="position: absolute; top: 0px; margin-top: 122px; left: 72px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span style="font-size: 12px;">09989622377 </span></div>
                                    <div id="backsignaturexy" style="width: 100%; position: relative; top: 0px; margin-top: -46px; transform: scale(0.91, 0.975); font-weight: bold; left: -14px;">
                                        <img src="../../../documents/AlumniSignature/samplesignature.png?time=Fri Apr 22 2016 20:53:11 GMT-0700 (Pacific Daylight Time)" style="/*width: 160px;height: 35px;*/height:50px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> 
                                    </div> 
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default" id="idsetupsettings_dialog" style="display: none;padding: 0px;">
    <form onsubmit="return false;">
        <div class="panel-heading" id="divTopHeader" style="height: 40px;width: 100%;padding: 0px;">
            <div class="col-md-3" style="padding-right: 0px;margin-top: 6px;">
                <div class="input-group">
                    <span class="input-group-addon" style="text-align: left;text-align: left;font-size: 11px;padding:3px;">
                        <label style="min-width:75px;font-weight: bolder;" id="<?= $strModuleName ?>-LBL_TBLSETUPTITLE"><?= $LBL_TBLSETUPTITLE; ?></label>
                    </span>
                    <input id="txtIDsetup" type="hidden"/>
                    <input id="txtidwidth" type="hidden"/>
                    <input id="txtidheight" type="hidden"/>
                    <input id="txtpicwidth" type="hidden"/>
                    <input id="txtpicheight" type="hidden"/>
                    <input id="txtcategory" type="hidden"/>                    
                    <input name="setuptitle" class="form-control" type="text" id="txtsetuptitle" placeholder="Enter Title" required="required" style="text-align: left; width:100px;height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" title="ACICLOVIR">
                </div>
            </div>
            <div class="col-md-3" style="padding-right: 0px;padding-left: 35px;margin-top: 6px;">
                <div class="input-group">
                    <span class="input-group-addon" style="text-align: left;font-size: 11px;padding:3px;">
                        <label style="min-width:75px;font-weight: bolder;" id="<?= $strModuleName ?>-LBL_TBLSETUPTYPE"><?= $LBL_TBLSETUPTYPE; ?></label>
                    </span>
                    <select id="txtSetuptype" onchange="SelectIDSetupChange(this)" class="form-control" required="required" style="    width: 100px;text-align: center;">                    
                        <option></option>
                        <option>Student</option>
                        <option>Employee</option>
                        <option>Alumni</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5" style="float:right;margin-top:3px;padding:0px;"> 
<!--                <button  id="<?= $strModuleName ?>-LBL_CLEAR"  name="btnClear" class="btn btn-info btn-lg" title="Clear" style="padding: 7px 12px;float: right;font-size: 12px;min-width: 80px;max-width: 80px;margin-right: 0.5%;">
                    <span class="glyphicon glyphicon-list-alt"></span> <?= $LBL_CLEAR ?>
                </button>-->
                <button id="<?= $strModuleName ?>-LBL_CANCEL"  name="btnCancel" class="btn btn-info btn-lg" title="Cancel" style="padding: 7px 12px;float: right;font-size: 12px;    width: 30%;margin-right: 0.5%;">
                    <span class="glyphicon glyphicon-remove-circle"></span> Close
                </button> 
                <button  id="<?= $strModuleName ?>-LBL_SAVE"  name="btnSaveIDSetup" class="btn btn-info btn-lg" title="Save" style="padding: 7px 12px;float: right;font-size: 12px;    width: 30%;margin-right: 0.5%;">
                    <span class="glyphicon glyphicon-floppy-save"></span> <?= $LBL_SAVE ?>
                </button>
                <button  id="<?= $strModuleName ?>-LBL_REFRESH"  name="btnDetailRefresh" class="btn btn-info btn-lg" title="Refresh" style="padding: 7px 12px;float: right;font-size: 12px;    width: 30%;margin-right: 0.5%;">
                    <span class="glyphicon glyphicon-refresh"></span> <?= $LBL_REFRESH ?>
                </button>


            </div>

        </div>    
        <div class="panel-body" style="padding-bottom:0px;">
            <div class="container-fluid col-md-11" style="padding:0px;width:94.5%;border: 1px solid #aaaaaa;">
                <table id="tblSetupIDDetails"></table>
                <div id="pgSetupIDDetails"></div>
            </div>
            <div id="divVSlider" class="col-md-1" style="width:4%;">
                <input type="text" id="amountv" value="" style="display:none;">
                <div id="v-slider" style="    border: 1px solid #aaaaaa;  height: 350px;  max-height: 370px;"></div>
            </div>
            <div style="clear:both;"></div>
            <div id="divHSlider" class="col-md-12">
                <input type="text" id="amounth" value=""  style="display:none;">
                <div id="h-slider" style="    border: 1px solid #aaaaaa;    max-width: 590px;"></div>
            </div>
            <div style="clear:both;    margin-bottom: 15px;"></div>
            <div  class="col-md-12" style="padding:0px;">
                <div class="input-group col-xs-1" style="padding:0px;">
                    <input type="checkbox" id="chkissetdefault" style="float: right;  margin-left: 20px; height: 28px; width: 24px; margin-top: 0px; cursor: pointer; font-size: 12px; padding: 5px; font-weight: bolder;" value="" checked="checked">
                    <span class="input-group-addon" style="width: 140px; text-align: left;  border: none; background: transparent;">
                        <label for="chkissetdefault"  id="<?= $strModuleName ?>-LBL_TBLSETDEFAULT"><?= $LBL_TBLSETDEFAULT; ?></label>
                    </span> 
                </div>
                <div class="input-group col-xs-1" style="padding:0px;">
                    <span class="input-group-addon" style="text-align: left;">
                        <label style="    min-width: 0px;" id="<?= $strModuleName ?>-LBL_TBLSETUPFONT"><?= $LBL_TBLSETUPFONT; ?></label>
                    </span>
                    <div class="input-group spinner">
                        <input type="text" id="txtFontSize" class="form-control" style="height: 34px;  font-weight: bolder;  border-top-left-radius: 0px;    border-bottom-left-radius: 0px;" value="1">
                        <div class="input-group-btn-vertical">
                            <button class="btn btn-default" type="button" style="    background-image: url('../images/cjc/up.png');background-size: 16px 14px;background-repeat: no-repeat;"><i class="fa-caret-up"></i></button>
                            <button class="btn btn-default" type="button" style="    background-image: url('../images/cjc/down.png');background-size: 16px 14px;background-repeat: no-repeat;"><i class="fa fa-caret-down"></i></button>
                        </div>
                    </div>
                                  <!--<input name="noofitemsconfirm" class="form-control" type="text" id="txtnoofitemsconfirmation" style="text-align: left; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;">-->
                </div>


                <input id="imgFilechooser2" name="imgFilechooser2" type="file" style="display: none;" onchange="readURL(this, 2);">
                <button id="<?= $strModuleName ?>-LBL_BROWSEBACKID"  name="btnBrowseBackID"  onclick="FileBrowser(event, 2);" class="btn btn-info btn-lg" title="Browse Back ID" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;    /*width: 25%;*/">
                    <span class=" glyphicon glyphicon-upload"></span><?= $LBL_BROWSEBACKID ?>
                </button>
                <input id="imgFilechooser1" name="imgFilechooser1" type="file" style="display: none;" onchange="readURL(this, 1);">

                <button id="<?= $strModuleName ?>-LBL_BROWSEFRONTID" name="btnBrowseFrontID" onclick="FileBrowser(event, 1);" class="btn btn-info btn-lg" title="Browse Front ID" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;    /*width: 25%;*/">
                    <span class=" glyphicon glyphicon-upload"></span><?= $LBL_BROWSEFRONTID ?>
                </button>
            </div>

        </div>



        <input type="submit" id="btnSubmitSaveConfirmation" value="ConfirmSave" style="display:none;" >
    </form>


    <!--     <div class="panel-footer" style="padding:0px;">           
         </div>-->

</div> 


<style>
    .ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {
        border: 1px solid #cdd5da;
        background: #C7D9FB 50% 50% repeat-x;
        font-weight: bold;
        color: #111111;
    }
    .required-field{
        border: red solid thin;
    }
    .ui-jqgrid tr.jqgrow td {
        /*//white-space: normal !important;*/
        height: 30px;
        vertical-align: middle;
    }
    .ui-jqgrid .ui-jqgrid-htable th {height: auto;padding: 0px 2px 0 2px;}
    .ui-jqgrid .ui-jqgrid-htable th div {
        white-space: normal;
        width: inherit;
        height: 30px;
        vertical-align: middle;
        position: relative;
        overflow: hidden;
    }
    ul.ui-autocomplete{
        overflow: auto;
        max-height: 100px;
        width: 300px;
    }
    /*//::bootstrap color css overidden*/

    .btn-info {
        color: #fff;
        background-color: #4E83A2;
        border-color: #A7B2B6;
    }
    .btn-info{color:#fff;background-color:#4E83A2;border-color:rgb(74, 74, 74);}
    .btn-info:hover,.btn-info:focus,.btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{color:#fff;background-color:#0651D1;border-color:black}
    .btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{background-image:none}
    .btn-info.disabled,.btn-info[disabled],fieldset[disabled] .btn-info,
    .btn-info.disabled:hover,.btn-info[disabled]:hover,fieldset[disabled] 
    .btn-info:hover,.btn-info.disabled:focus,.btn-info[disabled]:focus,fieldset[disabled] .btn-info:focus,.btn-info.disabled:active,.btn-info[disabled]:active,fieldset[disabled] 
    .btn-info:active,.btn-info.disabled.active,.btn-info[disabled].active,fieldset[disabled] .btn-info.active{background-color:#0651D1;border-color:#46b8da}
    /*//::END::::*/


    table th label,td{
        font-size: 13px;
    }
    table .ui-jqgrid-labels{
        font-size: 12px;
        font-weight: normal;
    }
    input[type="button"],button[id *= 'LBL']{
        font-size: 12px;
    }

    .ui-jqgrid-htable{
        font-size:12px;   
    }
    .ui-jqgrid-sortable{top: -5px;}
    .ui-jqgrid .ui-jqgrid-htable th {height: auto;padding: 0px 2px 0 2px;}
    .ui-jqgrid .ui-jqgrid-htable th div {
        white-space: normal;
        height: 20px;
        vertical-align: middle;
        position: relative;
        overflow: hidden;
    }
    .form-control{
        color:black;    
        font-size:14px;
    }
    .ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button {
        font-family: Arial,sans-serif;
        /*//  font-size:12px;*/
    }

    .form-control[readonly]{
        cursor: default;
        background-color: white;
    }

    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }
    .custom-combobox-input{
        margin: 0;
        padding: 5px 10px;
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        width: 261px;
        font-weight: normal;
        color:black;
    }

    .custom-combobox-input:not([id='custom-combobox-input-cboModelOption']) {
        margin: 0;
        padding: 5px 10px;
        width: 261px;
        font-weight: normal;
        color:black;
    }
    .ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all{
        height:500px;
        width:221px;
        overflow:auto;
    }
    .nav>li>a {
        position: relative;
        display: block;
        padding: 10px 15px;
        background-color:#dbf3fd;
        font-weight: bolder;
        color:#083256;
        padding: 3px 10px 2px 10px;
        font-size: 12px;
    }
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
        color: #000;
        cursor: default;
        background-color: #87ceeb;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }

    .nav-tabs>li>a:hover{
        border-color:#eee #eee #ddd;
        background-color: #87ceeb;
    }
    .nav>li>a>label {
        cursor: pointer;
    }
    legend {
        border-bottom: 1px solid rgba(229, 229, 229, 0);
        margin-left: 15px;
    }
    #divMainContainer table td{
        padding-left: 3px;
    }
    .input-group-addon label{
        min-width: 100px;
        float:left;
    }
    .browserjqgrid{

        border:#CCCCCC  solid 1px;
        -moz-border-radius: 5px 5px 5px 5px;
        -webkit-border-radius: 5px 5px 5px 5px;
    }
    /*/Spinner css*/
    .spinner {
        width: 100px;
    }
    .spinner input {
        text-align: right;
        height:34px;
    }
    .input-group-btn-vertical {
        position: relative;
        white-space: nowrap;
        width: 1%;
        vertical-align: middle;
        display: table-cell;
    }
    .input-group-btn-vertical > .btn {
        display: block;
        float: none;
        width: 100%;
        max-width: 100%;
        padding: 8px;
        margin-left: -1px;
        position: relative;
        border-radius: 0;
    }
    .input-group-btn-vertical > .btn:first-child {
        border-top-right-radius: 4px;
    }
    .input-group-btn-vertical > .btn:last-child {
        margin-top: -2px;
        border-bottom-right-radius: 4px;
    }
    .input-group-btn-vertical i{
        position: absolute;
        top: 0;
        left: 4px;
    }
    /*/End of spinner css*/
</style>