<?php
error_reporting(E_ALL ^ E_WARNING);
ini_set("display_errors", 0);
include_once '../../../libs/include.view.php';
include_once '../../../config/cons.paths.php';

$strModuleName = 'cjc.usersettings';

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
?>
<script src="jsgui/printDivData.js"></script>
<script type ="text/javascript" src ='../js/plugins/mask.js'></script> 
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
    /*    .list-group.panel > .list-group-item {
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 4px;
            background-color: #5D8BEA;
            color: white;
            font: bolder 13px verdana, Arial, Helvetica, sans-serif;
        }
        .list-group-submenu {
            margin-left:20px;
        }
        .list-group-item>.badge{float:right}
        .list-group-item>.badge+.badge{margin-right:5px}
        a.list-group-item{color:black}
        a.list-group-item .list-group-item-heading{color:black}
        a.list-group-item:hover,a.list-group-item:focus{text-decoration:none;background-color:#f5f5f5}
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
            background-color: #fff;
            border: 1px solid #ddd;
            font-size: 14px;
        }*/

</style>
<script>
    var prod = {
        type: null
        , no: null
        , id: null
        , img: null
        , util: {
            productBrowserHandler: null
            , productPanelRemoved: []
            , grid: null
            , isLoaded: {
                DuplicatePanels: 0,
                PassedSummary: 0,
                NCSummary: 0,
                StatusPanels: 0
            }
            , loadingIntervalHandler: null
        }

    };
    (function ($) {
        $.widget("custom.combobox", {
            _create: function () {

                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _highlight: function (s, t) {
                var matcher = new RegExp("(" + $.ui.autocomplete.escapeRegex(t) + ")", "ig");
                return s.replace(matcher, "<strong><u>$1</u></strong>");
            },
            _createAutocomplete: function () {
                $('ul[class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"]').css('max-height', '500px').css('width', '221px').css('overflow', 'auto');
                var ccbo = this;
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", value)
                        .attr("id", "custom-combobox-input-" + this.element[0].id)
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        });
                /* plugin not present
                 .tooltip({
                 tooltipClass: "ui-state-highlight"
                 })*/

                this.input.data('autocomplete')._renderItem = function (ul, item) {

                    item.label = ccbo._highlight(item.label, this.term);
                    return $("<li></li>")
                            .data("item.autocomplete", item)
                            .append('<a>' + item.label + '</a>')
                            .appendTo(ul);
                };
                this.input.bind('autocompleteselect', function (event, ui) {
                    ui.item.option.selected = true;
                    $(this).trigger("select", event, {
                        item: ui.item.option
                    });
                    $(this).attr('title', ui.item['value']);
                });
                this.input.bind('autocompletechange', function (event, ui) {

                    // Selected an item, nothing to do
                    try {
                        $(this).attr('title', ui.item['value']);
                        if (ui.item) {
                            return;
                        }

                        // Search for a match (case-insensitive)

                        var value = this.input.val();
                        var valueLowerCase = value.toLowerCase();
                        var valid = false;
                        this.element.children("option").each(function () {
                            if ($(this).text().toLowerCase() === valueLowerCase) {
                                this.selected = valid = true;
                                return false;
                            }
                        });
                        // Found a match, nothing to do
                        if (valid) {
                            return;
                        }

                        // Remove invalid value
                        this.input.val("")
                                .attr("title", value + " didn't match any item")
                                /*.tooltip("open")*/;
                        this.element.val("");
                        this._delay(function () {
                            this.input /*.tooltip("close")*/
                                    .attr("title", "");
                        }, 2500);
                        this.input.data("ui-autocomplete").term = "";
                    } catch (err) {
                        console.log(err);
                    }
                });
                /* using delegate instead
                 this._on( this.input, {
                 autocompleteselect: function( event, ui ) {
                 ui.item.option.selected = true;
                 this._trigger( "select", event, {
                 item: ui.item.option
                 });
                 },
                 
                 autocompletechange: "_removeIfInvalid"
                 });*/
            },
            _createShowAllButton: function () {
                $('ul[class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"]').css('max-height', '450px').css('width', '200px').css('overflow', 'auto');
                var input = this.input,
                        wasOpen = false;
                $("<a>")
                        .attr("tabIndex", -1).attr("title", "Show All Items")
                        .attr("id", "custom-combobox-showall-" + this.element[0].id)
                        //.tooltip()
                        .appendTo(this.wrapper)
                        .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: false
                        })
                        .removeClass("ui-corner-all")
                        .addClass("custom-combobox-toggle ui-corner-right")
                        .mousedown(function () {
                            //                            debugger;
                            wasOpen = input.autocomplete("widget").is(":visible");
                        })
                        .click(function () {
                            input.focus();
                            // Close if already visible
                            if (wasOpen) {
                                return;
                            }

                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete("search", "");
                        });
            },
            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);
    /**
     * Description
     * @method loadComboxBox
     * @param {string} combo_box_id element id.
     * @param {string} url result set url.
     * @param {string} valueColumn column to set as value.
     * @param {string} textColumn column to set as text.
     * @return void
     */

    function loadComboxBox(combo_box_id, url, valueColumn, textColumn) {
        $('#' + combo_box_id + ' option').each(function () {
            $(this).remove();
        });
        var combo_box = $("#" + combo_box_id);
        //        prod.util.isLoaded[combo_box_id] = 0;
        $.ajax({
            url: url
            , type: 'GET'
            , dataType: 'json'
                    //            , async: false
            ,
            success: function (res) {

                if (typeof res === "object") {
                    res = res.rows;
                }

                combo_box.append($("<option/>", {value: "", text: ""}));
                for (each in res) {
                    console.log(res[each][valueColumn]);
                    var option = $("<option/>", {value: res[each][valueColumn], text: res[each][textColumn]});
                    combo_box.append(option);
                }

                combo_box.combobox();
                $("#custom-combobox-showall-" + combo_box_id).button({disabled: false});
                //                prod.util.isLoaded[combo_box_id] = 1;
            }
        });
    }

    function loadEmployeeListCombo(strCboType) {

        $('#' + strCboType + ' option').each(function () {
            $(this).remove();
        });
        $('#' + strCboType).append($('<option>', {
            value: '',
            text: ''
        }));
        $.ajax({
            url: "../../../models/mod.cjc.usersettings.php",
            data: {
                ACTION: "loadEmployeeList"
            },
            dataType: 'json',
            async: false,
            success: function (jsonReturn) {
                $.each(jsonReturn, function (index, value) {
                    var options = "<option value='" + value['person_code'] + "' >" + pad(value['person_code'], 6) + " - " + value['EmployeeName'] + "</option>";
                    $('#' + strCboType).append(options);
                });
            }});
    }
    function loadEmployeeListComboSingleValue(strCboType, value) {
        $('#' + strCboType + ' option').each(function () {
            $(this).remove();
        });
        $('#' + strCboType).append($('<option>', {
            value: '',
            text: ''
        }));
        var options = "<option value='" + value + "' >" + value + "</option>";
        $('#' + strCboType).append(options);
    }

    function loadComboxBoxStaticOption(combo_box_id, valueColumn, textColumn) {
        $('#' + combo_box_id + ' option').each(function () {
            $(this).remove();
        });
        var combo_box = $("#" + combo_box_id);
        for (var i = 0; i < valueColumn.length; i++) {
            var option = $("<option/>", {value: valueColumn[i], text: textColumn[i]});
            combo_box.append(option);
        }
        combo_box.combobox();
    }
</script>
<script>
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
        $el: $("#txtDATEADDED"),
        mask: patterns[0],
        errorFunction: setErrorFunction,
        defaultValue: defaultValues[0],
        isUtc: isUtc[0]
    }
    mask = Mask.newMask(options);
    masks.push(mask);
    options = {
        $el: $("#txtDATERESIGN"),
        mask: patterns[0],
        errorFunction: setErrorFunction,
        defaultValue: defaultValues[0],
        isUtc: isUtc[0]
    }
    mask = Mask.newMask(options);
    masks.push(mask);
    options = {
        $el: $("#txtDATE_OF_BIRTH"),
        mask: patterns[0],
        errorFunction: setErrorFunction,
        defaultValue: defaultValues[0],
        isUtc: isUtc[0]
    }
    mask = Mask.newMask(options);
    masks.push(mask);
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
    };</script>
<script type="text/javascript">
    var summarySQL = "";
    var lastCol, lastRow;
    var lastiRow, lastiCol;
    var GlobalIDDataSeledted;
    var GlobalIDDataSeledtedTabs;
    var GlobalGridSelected = '';
    var GlobalAddressSelectedLastIrow, GlobalAddressSelectedLastIrCol;
    $(document).ready(function () {
        loadList('tblList', 'pgList');
        clickLabel();
        iniControls();
        onresize = function () {
            resizeWindow(); //this function resize is from cjcnaviframe
            setTableListResizeGrids();
        };
    });
//        document.addEventListener("DOMContentLoaded", function (event) {
//           loadList('tblList', 'pgList');
//        clickLabel();
//        iniControls();
//        onresize = function () {
//            resizeWindow(); //this function resize is from cjcnaviframe
//            setTableListResizeGrids();
//        };
//        });


    function iniControls() {
		$('#divAdditionalFilter').contents().remove();
        $("input[type='text']").click(event, function () {
            $(this).select();
        });
        $("#txtSearchUser").keyup(event, function () {
            if (event.keyCode == 13) {
                loadList('tblList', 'pgList');
            }
        });
        $("button[name='btnSearchUser']").click(event, function () {
            loadList('tblList', 'pgList');
        });
        $('button[name="btnSave"],button[name="btnCancel"]').bind("click", function (event) {
            if (event.ctrlKey) {
                return;
            }
            if ($(this).attr('name') === "btnSave" && isAllowedAccessClick('module', 'User Settings', 'update')) {
                var password = $("#txtRetypePass").val();
                var valueValidate = "*Password match";
                if (password === "") {
                    valueValidate = "Required field.";
                    $('#divCheckPasswordMatch').css({"color": "red"});
                    $("#txtRetypePass").addClass('required-field');
                } else {
                    $("#txtRetypePass").removeClass('required-field');
                }
                if ($('#txtPASSWORD').val() === "") {
                    valueValidate = "Required field.";
                    $('#divCheckPasswordMatch').css({"color": "red"});
                    $("#txtPASSWORD").addClass('required-field');
                } else {
                    $("#txtPASSWORD").addClass('required-field');
                }
//                else {
//                    valueValidate = "*Password match";
//                    $('#divCheckPasswordMatch').css({"color": "rgb(0, 0, 204)"});
//
//                }

                $("#divCheckPasswordMatch").html(password === $('#txtPASSWORD').val() ? valueValidate : "*Password did not match!");
                if (password === $('#txtPASSWORD').val() && (password !== "" && $('#txtPASSWORD').val() !== "")) {
                    $('#divCheckPasswordMatch').css({"color": "rgb(0, 0, 204)"});
                } else {
                    $('#divCheckPasswordMatch').css({"color": "red"});
                    return;
                }


                var inputs = $("#txtID,#txtemployee,#txtUSERNAME,#txtusertype,#txtPASSWORD,#txtRetypePass,#chkISACTIVE,#txtUSERROLE");
                var li = "<ul>";
                var valid = true;
                var obj = {};
                $.each(inputs, function (k, v) {
                    var name = $(v).attr('id');
                    //                    console.log(name, v);
                    if (name != undefined) {
                        if ($(v).attr('id').match(/(txtemployee|txtUSERNAME|txtPASSWORD|txtRetypePass)/ig) != null) {
                            name = name.replace(/txt/ig, '');
                            if ($.trim($(v).val()) == "") {
                                $(v).addClass('required-field');
                                valid = false;
                                li += "<li>" + ($(v).attr('name')) + "</li>";
                            } else {
                                obj[name] = $(v).val();
                                $(v).removeClass('required-field');
                            }
                        } else {
                            name = name.replace(/txt/ig, '');
                            obj[name] = $(v).val();
                        }
                    }

                });
                obj['ISACTIVE'] = $('#chkISACTIVE').is(':checked') ? 1 : 0;
                if (!valid) {
                    msgBox("<div style='float: left;overflow: auto;'>" + li + "</div>", "Please fill up the following...", "stop", "ok", 290, 350, function (v) {
                        return false;
                    });
                    return false;
                } else {
                    if ($.trim($("#divCheckPasswordMatch").text()) !== "*Password match") {
                        $('#txtPASSWORD,#txtRetypePass').addClass('required-field');
                        $("#divCheckPasswordMatch").html("* Password field(s) empty");
                        $('#divCheckPasswordMatch').css({"color": "red"});
                        return;
                    }
                    msgBox("Continue Saving?", "System Message", "ask", "Yes|No", 270, 240, function (v) {
                        if (v == 1) {
                            $.ajax({
                                url: '../../../models/mod.cjc.usersettings.php?ACTION=saveData',
                                datatype: 'json',
                                async: false,
                                type: 'POST',
                                data: {
                                    POSTPARAM: obj
                                },
                                success: function (jsRet) {

                                    if (jsRet !== "") {
                                        console.log(jsRet, 'Ouput');
                                        if (jsRet == "Username Exist") {
                                            $("#divCheckPasswordMatch").html("* Username already exist");
                                            $('#divCheckPasswordMatch').css({"color": "red"});
                                            return;
                                        } else {
                                            var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATESUCCESS'><?= $LBL_SAVEUPDATESUCCESS ?></label>";
                                            msgBox(message, "Success", "success", "OK", 300, 250, function (dlgvalue) {
                                                $("#divUserSetting_dialog").dialog('close');
                                                reloadtblList();
                                                if (dlgvalue == 1) {

                                                }
                                            });
                                            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                                            $('div[id="___msgBox"]').css("height", "");
                                            clickLabel();
                                            animation(0);
                                        }

                                    } else {
                                        msgBox("Error Saving!", "System Message", "stop", "ok", 270, 230, function (v) {
                                            return false;
                                        });
                                    }
                                }

                            });
                        } else {
                            return false;
                        }
                    });
                    var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                    $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                    $('div[id="___msgBox"]').css("height", "");
                }
            } else if ($(this).attr('name') === "btnCancel") {
                $('div[aria-labelledby$="divUserSetting_dialog"] span[class="ui-icon ui-icon-closethick"]').click()
            }
        });
        $('button[name="btnRefresh"]').bind("click", function (event) {
            if (event.ctrlKey)
                return;
            loadList('tblList', 'pgList');
        });
        $('button[name="btnExport"]').bind("click", function (event) {
            if (event.ctrlKey)
                return;
            var currentSelectedBtnElement = $(this);
            if ($.trim($(currentSelectedBtnElement).attr('name')) === "btnExport" && isAllowedAccessClick('module', 'User Settings', 'view')) {
                var sqlQuery = summarySQL.split('LIMIT')[0];
                //                         console.log(sqlQuery);
                openPost('../../../models/ExportExcelTemplate.php', {
                    sqlQuery: sqlQuery,
                    transtitle: $.trim($('#labelTitle').text()),
                    IsHasSummaryTotal: 'No',
                    Type: 'hrisUserSettings'
                }, '');
            }


        });
        $('button[name="btnNew"]').bind("click", function (e) {
            if (isAllowedAccessClick('module', 'User Settings', 'create')) {
                popupDialogForm(e, 'divUserSetting_dialog', null);
            }
        });
        $('button[name="btnEdit"]').bind("click", function (e) {
            if (isAllowedAccessClick('module', 'User Settings', 'update')) {
                var rowdata = jQuery('#tblList').jqGrid('getRowData', jQuery('#tblList').jqGrid('getGridParam', 'selrow'));
                if ($.isEmptyObject(rowdata)) {

                } else {
                    popupDialogForm(e, 'divUserSetting_dialog', rowdata);
                }
            }

        });
        //Initial Format css jquery functions
        $('#divUserSetting_dialog input,select').css({"height": "28px", "font-size": "12px", "padding": "5px", "font-weight": "bolder"});
        $('#divUserSetting_dialog select').css({"padding": "0px"});
    }


    function pad(n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }
    function setTableListResizeGrids() {
        $("#tblList").setGridWidth($('#main').width() - 10, false);
        $('#tblList').jqGrid('setGridHeight', $('#main').height() - 150);
    }
    function reloadtblList() {
        $("div#divList table#tblList").setGridParam({
            postData: {
                ACTION: 'loadList',
                GETPARAM: {
                    _searchKey: $("#txtSearchUser").val()
                }
            }
        }).trigger('reloadGrid');
    }
    function loadList(gridID, pgID) {
        $("#" + gridID).jqGrid('GridUnload');
        $("#" + gridID).jqGrid({
            url: '../../../models/mod.cjc.usersettings.php',
            datatype: 'json',
            async: false,
            mtype: 'GET',
            postData: {
                ACTION: 'loadList',
                GETPARAM: {
                    _searchKey: $("#txtSearchUser").val()
                }
            },
            colModel: [
                {
                    name: 'ID',
                    index: 'ID',
                    label:'<label  id="<?= $strModuleName; ?>-LBL_ID"><?= $LBL_ID; ?></label>',
                },
                {
                    name: 'PERSONNAME',
                    index: 'PERSONNAME',
                    hidden: false,
                    width: 265,
                    label: "<label id='<?= $strModuleName; ?>-LBL_EMPLOYEENAME'><?= $LBL_EMPLOYEENAME; ?></label>"
                },
                {
                    name: 'USERNAME',
                    index: 'USERNAME',
                    hidden: false,
                    width: 265,
                    label: "<label id='<?= $strModuleName; ?>-LBL_USERNAME'><?= $LBL_USERNAME; ?></label>"
                },
                {
                    name: 'USERTYPE',
                    index: 'USERTYPE',
                    hidden: false,
                    label:'<label  id="<?= $strModuleName; ?>-LBL_USERTYPE"><?= $LBL_USERTYPE; ?></label>',
                },
                {
                    name: 'USERROLE',
                    index: 'USERROLE',
                    hidden: true
                },
                {
                    name: 'ACTIVATIONKEY',
                    index: 'ACTIVATIONKEY',
                    hidden: true
                },
                {
                    name: 'ISACTIVE',
                    index: 'ISACTIVE',
                    hidden: false,
                    width: 100,
                    label: "<label id='<?= $strModuleName; ?>-LBL_ISACTIVE'><?= $LBL_ISACTIVE; ?></label>",
                    edittype: 'checkbox',
                    editoptions: {value: '1:0', defaultValue: '0'},
                    formatoptions: {disabled: false},
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "ISACTIVE";
                        var chkValue = (cellvalue == 1 ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox"' + chkValue + ' disabled value = "' + cellvalue + '" offval="0">';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return $("input:checkbox", cell).prop("checked") ? 1 : 0;
                    },
                    align: 'center'
                },
                {
                    name: 'DATEADDED',
                    index: 'DATEADDED',
                    hidden: false,
                    width: 265,
                    label: '<label id="<?= $strModuleName; ?>-LBL_TBLDATEADDED"><?= $LBL_TBLDATEADDED; ?></label>'
                },
            ],
            width: $(this).parent().width() - 10,
            height: $("#main").height() - 175,
            pager: "#" + pgID,
            jsonReader: {
                repeatitems: false
            },
            rowNum: 1000,
            cellsubmit: 'clientArray',
            autowidth: true,
            shrinkToFit: true,
            rownumbers: true,
            sortorder: 'ASC',
            sortname: 'ID',
            multiboxonly: false,
            viewrecords: true,
            footerrow: false,
            userDataOnFooter: false,
            beforeProcessing: function (data, status, xhr) {
                summarySQL = data.sql;
            },
            onSelectRow: function (id) {
            },
            ondblClickRow: function (id) {
                if (isAllowedAccessClick('module', 'User Settings', 'update')) {
                    var rv = $(this).getRowData(id);
                    popupDialogForm('', 'divUserSetting_dialog', rv);
                }
            },
            loadComplete: function () {
            }
        });
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
            resizable: true,
            width: 660,
            height: 390,
            modal: true,
            open: function (event) {
                clickLabel();
                //                $(this).dialog('option', 'position', ['middle', 200]);
                $("#txtDATEADDED,#txtDATERESIGN,#txtDATE_OF_BIRTH").datepicker({
                    dateFormat: '<?php echo $dateLabel['LBL_DATEFORMAT'] ?>',
                    dayNamesMin: [<?php echo $dateLabel['LBL_WEEKDAYS'] ?>],
                    monthNamesShort: [<?php echo $dateLabel['LBL_MONTHNAME'] ?>],
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function () {
                    }
                }).datepicker('setDate', new Date());
                $('#divCheckPasswordMatch').text("");
                if (data == null) {
                    $("div[id=\"divUserSetting_dialog\"] input[type='text'],#txtemployee,input[type='checkbox']:not(input[id^='Row']),select,textarea").val('');
                    $('div[id="divUserSetting_dialog"] select,input:not(input[id="txtID"],input[id^="Row"])').removeAttr('disabled').removeAttr('readonly');
                    $('#chkISACTIVE').attr('checked', true);
                    $('#chkISACTIVE').attr('disabled', true);
                } else {
                    var inputs = $("div[id=\"divUserSetting_dialog\"] input[type='text'],input[type='checkbox']:not(input[id^='Row']),select,textarea");
                    $.each(inputs, function (k, v) {
                        var type__ = $(v).attr('type');
                        var name = $.trim($(v).attr('id'));
                        if (type__ != null) {
                            if (type__.match(/checkbox/ig) != null) {
                                name = name.replace(/chk/ig, '');
                                $(v).attr('checked', parseInt(data[name]) == 1);
                            } else {
                                name = name.replace(/txt/ig, '');
                                $(v).val(data[name]);
                            }
                        } else {
                            name = name.replace(/txt/ig, '');
                            $(v).val(data[name]);
                        }
                    });
                    $('#txtID').val(data['ID']);
                    $('#txtusertype').val(data['USERTYPE']);
                    $('#txtemployee').val(data['PERSONNAME']);
                    $('#txtactivation').val(data['ACTIVATIONKEY']);
                    $('#chkISACTIVE').attr('disabled', false);
                    $('#txtPASSWORD,#txtRetypePass').val('');
                    $('#txtUSERNAME').attr('readonly', true).attr('disabled', false);
//                    $('input[id="custom-combobox-input-txtemployee"]').attr('title', $('#txtemployee option:selected').text()).val($('#txtemployee option:selected').text()).tooltip('destroy');
                    //                   $(inputs).attr('readonly', true).attr('disabled', true);

                }

                $('div[aria-labelledby$="divUserSetting_dialog"] div[class="panel-body"] div:not(div[id="divPicImageThumb"])').css({"padding": "0px", "padding-left": "5px"});
                $('.input-group-addon').css({"text-align": "left"});

            },
            close: function (event) {

            }
        });
        $('#' + div).show();
        $('#' + div).dialog("open");
    }


//Assign Designation
    function popupDialogFormAssignDesignation(event, div, data) {
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
            title: "User Designation",
            autoOpen: false,
            resizable: true,
            width: 700,
            height: $(window).height() - 20,
            modal: true,
            open: function (event) {
                clickLabel();
                loadListAssignDesignation('tblListAssignDesignation', 'pgListAssignDesignation');
                $('#txtusername').attr('readonly', true).val($('#txtemployee').val());
                $('#txtactivationkey').attr('readonly', false).val($('#txtactivation').val());

                $('div[aria-labelledby$="divUserSetting_dialog"] div[class="panel-body"] div:not(div[id="divPicImageThumb"])').css({"padding": "0px", "padding-left": "5px"});
                $('.input-group-addon').css({"text-align": "left"});
                $('#txtactivationkey').keypress(function (e) {
                    return IsNumeric(e);
                });

            },
            close: function (event) {

            }
        });
        $('#' + div).show();
        $('#' + div).dialog("open");
    }

//    reloadtblListAssignDesignation
//    loadListAssignDesignation
    function loadListAssignDesignation(Grid, pgGrid) {
        $("#" + Grid).jqGrid('GridUnload');
        $("#" + Grid).jqGrid({
            url: "../../../models/mod.cjc.usersettings.php",
            datatype: "json",
            mtype: 'GET',
            postData: {
                ACTION: 'loadListAssignDesignation',
                GETPARAM: {
                    userid: parseInt($('input[id*="txtID"]').val())
                },
                TYPE: 1
            },
            colModel: [
                {
                    name: 'item_id',
                    index: 'item_id',
                    hidden: true
                },
                {
                    name: 'user_id',
                    index: 'user_id',
                    hidden: true
                },
                {
                    name: 'module_id',
                    index: 'module_id',
                    hidden: true
                },
                {
                    name: "modulename",
                    index: "modulename",
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLMODULENAME"><?= $LBL_TBLMODULENAME; ?></label>',
                    width: 150,
                    editoptions: {
                        style: 'width: 100%;height: 29px;margin-left: 0px;font-weight: bolder;',
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
                                    $(".browserjqgrid").remove();
                                }
                            },
                            {
                                type: "blur",
                                fn: function (e) {
                                    $(".browserjqgrid").remove();
                                    jQuery("#" + Grid).saveCell(lastRow, lastCol);
                                    GlobalGridSelected = Grid;
                                    GlobalAddressSelectedLastIrow = lastRow;
                                    GlobalAddressSelectedLastIrCol = lastCol;

                                }
                            }
                        ]
                    }
                },
                {
                    name: 'allow_create',
                    index: 'allow_create',
                    label:'<label  id="<?= $strModuleName; ?>-LBL_TBLMODULECREATE"><?= $LBL_TBLMODULECREATE; ?></label>',
                    align: "center",
                    width: 55,
                    edittype: 'checkbox',
                    hidden: false,
                    editoptions: {
                        value: '1:0'
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "allow_create";
                        var chkValue = (cellvalue === '1' || rowObject.FLAG === 'New' ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox" ' + chkValue + ' style="height: 18px;width:18px;" onclick="checkIsActive(\'#' + Grid + '\',\'' + options.rowId + '\',\'' + chkID + '\')" />';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return ($(cell).find('input').is(":checked") ? 1 : 0);
                    }
                },
                {
                    name: 'allow_update',
                    index: 'allow_update',
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLMODULEUPDATE"><?= $LBL_TBLMODULEUPDATE; ?></label>',
                    align: "center",
                    width: 55,
                    edittype: 'checkbox',
                    hidden: false,
                    editoptions: {
                        value: '1:0'
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "allow_update";
                        var chkValue = (cellvalue === '1' || rowObject.FLAG === 'New' ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox" ' + chkValue + ' style="height: 18px;width:18px;" onclick="checkIsActive(\'#' + Grid + '\',\'' + options.rowId + '\',\'' + chkID + '\')" />';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return ($(cell).find('input').is(":checked") ? 1 : 0);
                    }
                },
                {
                    name: 'allow_delete',
                    index: 'allow_delete',
                    label:'<label  id="<?= $strModuleName; ?>-LBL_TBLMODULEDELETE"><?= $LBL_TBLMODULEDELETE; ?></label>',
                    align: "center",
                    width: 55,
                    edittype: 'checkbox',
                    hidden: false,
                    editoptions: {
                        value: '1:0'
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "allow_delete";
                        var chkValue = (cellvalue === '1' || rowObject.FLAG === 'New' ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox" ' + chkValue + ' style="height: 18px;width:18px;" onclick="checkIsActive(\'#' + Grid + '\',\'' + options.rowId + '\',\'' + chkID + '\')" />';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return ($(cell).find('input').is(":checked") ? 1 : 0);
                    }
                },
                {
                    name: 'allow_view',
                    index: 'allow_view',
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLMODULEVIEW"><?= $LBL_TBLMODULEVIEW; ?></label>',
                    align: "center",
                    width: 55,
                    edittype: 'checkbox',
                    hidden: false,
                    editoptions: {
                        value: '1:0'
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "allow_view";
                        var chkValue = (cellvalue === '1' || rowObject.FLAG === 'New' ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox" ' + chkValue + ' style="height: 18px;width:18px;" onclick="checkIsActive(\'#' + Grid + '\',\'' + options.rowId + '\',\'' + chkID + '\')" />';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return ($(cell).find('input').is(":checked") ? 1 : 0);
                    }
                },
                {
                    name: 'allow_print',
                    index: 'allow_print',
                    label: '<label  id="<?= $strModuleName; ?>-LBL_TBLMODULEPRINT"><?= $LBL_TBLMODULEPRINT; ?></label>',
                    align: "center",
                    width: 55,
                    edittype: 'checkbox',
                    hidden: false,
                    editoptions: {
                        value: '1:0'
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "allow_print";
                        var chkValue = (cellvalue === '1' || rowObject.FLAG === 'New' ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox" ' + chkValue + ' style="height: 18px;width:18px;" onclick="checkIsActive(\'#' + Grid + '\',\'' + options.rowId + '\',\'' + chkID + '\')" />';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return ($(cell).find('input').is(":checked") ? 1 : 0);
                    }
                },
                {
                    name: "sortorder",
                    index: "sortorder",
                    hidden: true
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
            sortorder: 'ASC',
            sortname: 'item_id',
            width: $('#divAssignDesignation_dialog').width() - 35,
            height: $('#divAssignDesignation_dialog').height() - 265,
            shrinkToFit: false,
            multiselect: true,
            multiboxonly: true,
            autowidth: false,
            viewrecords: true,
            footerrow: true,
            cellEdit: true,
            userDataOnFooter: true,
            jsonReader: {
                repeatitems: false
            },
            beforeProcessing: function (data, status, xhr) {

            },
            ondblClickRow: function (rowid, iRow, iCol, rowObject) {

            },
            cellsubmit: 'clientArray',
            onSelectCell: function (rowid, cellname, value, iRow, iCol) {

                $(".browserjqgrid").remove();
//                console.log(rowid, cellname, value, iRow, iCol);
                var cellValue;
                var objNewContent;

                if (cellname == 'modulename') {
                    var arrValue = value.toString().split(">");
                    if (arrValue.length > 1) {
                        cellValue = arrValue[1];
                    } else {
                        cellValue = value.toString();
                    }
                    objNewContent = '<img id="browserjqgrid-' + rowid + '" class="browserjqgrid"  align="right" src="../images/cjc/browse16x16.png" onclick="browseModuleList(\'' + Grid + '\',' + rowid + ')">' + cellValue;
                    $("#" + Grid).setCell(rowid, 'modulename', objNewContent);

                }


            },
            afterSaveCell: function (rowid, name, val, iRow, iCol) {

            },
            afterInsertRow: function (rowid, rowObject, data) {
            },
            afterEditCell: function (rowid, cellname, value, iRow, iCol) {
//                document.getElementById(iRow + '_' + cellname).select();
                lastCol = iCol;
                lastRow = iRow;

            },
            loadComplete: function () {
            }
        });
        $("#" + Grid).jqGrid('navGrid', '#' + pgGrid, {edit: false, add: false, del: false, search: false, refresh: false});

        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
            buttonicon: "ui-icon-plusthick",
            caption: '',
            title: 'Add New Designation',
            onClickButton: function (e) {
                addGridInfoRecord(Grid);
            }
        });
        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
            buttonicon: "ui-icon-minusthick",
            caption: '',
            title: 'Remove Designation',
            onClickButton: function (e) {
                deleteGridInfoRecord(Grid);
            }
        });
        clickLabel();
    }
    function reloadtblListAssignDesignation() {
        $("#tblListAssignDesignation").setGridParam({
            postData: {
                ACTION: 'loadListAssignDesignation',
                GETPARAM: {
                    userid: parseInt($('input[id*="txtID"]').val())
                },
                TYPE: 1
            }
        }).trigger("reloadGrid");
    }


    function saveDesignation(event) {
        if (event.ctrlKey) {
            return;
        }
        $(".browserjqgrid").remove();
        jQuery("#" + GlobalGridSelected).saveCell(GlobalAddressSelectedLastIrow, GlobalAddressSelectedLastIrCol);
//#1 AssignDesignation Grid Values
        $('td[aria-describedby="tblListAssignDesignation_user_id"]:not(td[aria-describedby="tblListAssignDesignation_user_id"]:last)').map(function (index, elem) {
            $(elem).text($('#txtID').val());
        });
        var isOk = false;
        $('td[aria-describedby="tblListAssignDesignation_module_id"]:not(td[aria-describedby="tblListAssignDesignation_module_id"]:last)').map(function (index, elem) {
            if ($('td[aria-describedby="tblListAssignDesignation_FLAG"]:not(td[aria-describedby="tblListAssignDesignation_FLAG"]:last)').eq(index).text() == "Delete") {
            } else {
                if ($(elem).text() > 0) {
                    isOk = true;
                } else {
                    isOk = false;
                    return;
                }
            }

        });
        if (!isOk) {
            playWarningSound();
            swal("Error", "Either No data entry to be save or there are empty fields..", "warning");
            return;
        }
        //Validate Laboratory Request 
//        var isLabOK = false;
//        $('td[aria-describedby="tblListAssignDesignation_module_id"]:not(td[aria-describedby="tblListAssignDesignation_module_id"]:last)').map(function(index, elem) {
//            if ($(elem).text() == '4') {
////                console.log($('td[aria-describedby="tblListAssignDesignation_laboratory_id"]:not(td[aria-describedby="tblListAssignDesignation_laboratory_id"]:last)').eq(index).text());
//                if ($('td[aria-describedby="tblListAssignDesignation_laboratory_id"]:not(td[aria-describedby="tblListAssignDesignation_laboratory_id"]:last)').eq(index).text() > 0) {
//                    isLabOK = true;
//                } else {
//                    isLabOK = false;
//                    return;
//                }
//            }else{
//                isLabOK = true;
//            }
//
//        });
//        if (!isLabOK) {
//            playWarningSound();
//            swal("Error", "Laboratory Request Module require laboratory entry.", "warning");
//            return;
//        }
        var arrDataRow = $('#tblListAssignDesignation').jqGrid('getDataIDs');
        var gridRow;
        //Address grid::::::::
        arrDataRow = $('#tblListAssignDesignation').jqGrid('getDataIDs');
        var arrAssignDesignationItems = [];
        arrDataRow = $('#tblListAssignDesignation').jqGrid('getDataIDs');
        for (var i = 0; i < arrDataRow.length; i++) {

            gridRow = $("#tblListAssignDesignation").getRowData(arrDataRow[i]);
            var arrValItem = {};
            $.each(gridRow, function (k, v) {
                arrValItem[k] = v;
            });
            arrAssignDesignationItems.push(arrValItem);
        }
//end of #1 AssignDesignation

        var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATECONFIRMATION'><?= $LBL_SAVEUPDATECONFIRMATION ?></label>";
        msgBox(message, "Confirmation", "ask", "Yes|No", 300, 250, function (dlgvalue) {
            clickLabel();
            if (dlgvalue == 1) {
                animation(1);
                $.ajax({
                    url: "../../../models/mod.cjc.usersettings.php?ACTION=saveAssignDesignation",
                    type: "POST",
                    data: {
                        POSTPARAM: {
                            userid: parseInt($('input[id*="txtID"]').val()),
                            activationkey: $('#txtactivationkey').val(),
                            AssignDesignationItems: JSON.stringify(arrAssignDesignationItems)

                        }
                    },
                    success: function (retValue) {

                        if (retValue !== "" && retValue !== "Activationkey already in used.") {
                            var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATESUCCESS'><?= $LBL_SAVEUPDATESUCCESS ?></label>";
                            msgBox(message, "Success", "success", "OK", 300, 250, function (dlgvalue) {
                                reloadtblListAssignDesignation();
                                if (dlgvalue == 1) {

                                }
                            });
                            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                            $('div[id="___msgBox"]').css("height", "");
                            clickLabel();
                            animation(0);
                        } else {
                            console.log(retValue);
                            var message = "<label style='font-size: 13px;' id='<?= $strModuleName ?>-LBL_SAVEUPDATEERROR'><?= $LBL_SAVEUPDATEERROR ?> " + retValue + "</label>";
                            msgBox(message, "Error", "failed", "OK", 300, 250, function (dlgvalue) {

                            });
                            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                            $('div[id="___msgBox"]').css("height", "");
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
        $('div[id="___msgBox"]').css("height", "");
        clickLabel();
    }


    //Browser Module List
    function browseModuleList(Grid, ROWID) {
        $('div[id*="modalBrowserModuleList"]').map(function (index, element) {
            if (index > 0) {
                $(element).remove();
            }
        });
        $("#modalBrowserModuleList").dialog({
            title: 'Browser',
            resizable: false,
            autoOpen: false,
            width: 800,
            height: 600,
            modal: true
        });

        $("#modalBrowserModuleList").dialog("open");
        $("#txtSearchBrowserModuleList").focus();

        //Clear Grid First 
        $("#tblListBrowserModuleList").jqGrid('GridUnload');
        $("#tblListBrowserModuleList").jqGrid({
            url: "../../../models/mod.cjc.usersettings.php",
            datatype: "json",
            mtype: 'GET',
            postData: {
                ACTION: 'getModuleList',
                GETPARAM: {
                },
                TYPE: 1
            },
            colModel: [{
                    name: 'module_id',
                    index: 'module_id',
                    hidden: true
                },
                {
                    name: 'modulename',
                    index: 'modulename'
                }

            ],
            rownumbers: true,
            rowNum: 1000,
            autowidth: true,
            sortname: 'module_id',
            viewrecords: true,
            multiselect: false,
            sortorder: "asc",
            page: false,
            jsonReader: {
                repeatitems: false
            },
            width: '700px',
            height: '420px',
            ondblClickRow: function (rowid) {

//                var rowValue = $("#tblListBrowserRelation").jqGrid('getRowData', $('#tblListBrowserRelation').jqGrid('getGridParam', 'selrow'));
                var rowValue = jQuery("#tblListBrowserModuleList").jqGrid('getRowData', rowid);
//                console.log(rowValue);
                setbrowseModuleList(ROWID, rowValue, Grid);
            },
            loadComplete: function () {

            }
        }
        );
        $("#tblListBrowserModuleList").jqGrid('bindKeys', {"onEnter":
                    function (rowid) {
                        var rowValue = jQuery("#tblListBrowserModuleList").jqGrid('getRowData', rowid);
                        setbrowseModuleList(ROWID, rowValue, Grid);

                    }
        });
        $("#tblListBrowserModuleList").jqGrid('navGrid', '#pagerBrowserModuleList', {
            edit: false,
            add: false,
            del: false,
            search: false
        });

    }
    function reloadBrowserModuleList(event) {
        if (event.keyCode == 13 || event.button == 0) {
            $("#tblListBrowserModuleList").setGridParam({
                postData: {
                    ACTION: 'getModuleList',
                    GETPARAM: {
                    },
                    TYPE: 1
                }
            }).trigger("reloadGrid");
        }
    }
    function setbrowseModuleList(rowid, rowValue, Grid) {
        animation(1);
//        console.log(rowid, rowValue, Grid);
        var prevData = jQuery("#" + Grid).jqGrid('getRowData', rowid);
//        console.log(prevData['lab_id'], rowValue.lab_id);
        var selectionOK = true;
        $('td[aria-describedby="tblListAssignDesignation_module_id"]:not("td[aria-describedby="tblListAssignDesignation_module_id"]:last")').map(function (index, element) {
            if (rowValue.module_id == -1) {
                selectionOK = true;
            } else if (rowValue.module_id == $(element).text()) {
                selectionOK = false;
            }
        });
        if (selectionOK) {
            $("#" + Grid).setRowData(rowid, {
                module_id: rowValue.module_id,
                modulename: rowValue.modulename
            });
            $("#" + Grid).jqGrid('saveRow', rowid, false);
            changeFlag("#" + Grid, rowid);

        } else {
            playWarningSound();
            swal("System Information", "Selected Module already exist in the list.", "warning");
        }
        $("#modalBrowserModuleList").dialog("close");
        animation(0);
    }
//    ..Grid Initial Functions
    function addGridInfoRecord(Grid) {

        var newRow = [{
                ID: getGridNewID(Grid),
                FLAG: "New"
            }];
        jQuery("#" + Grid).addRowData("ID", newRow, 'bottom');
    }
    function deleteGridInfoRecord(Grid) {

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
        imgMain.src = '../../../models/mod.ntchrms.mstemployeeinformation.php?ACTION=getImageOriginal&GETPARAM=' + strID;
        $("#" + imgProductMain).append(imgMain);
        $('img[id="imgempPic"]').css('height', '200px').css('width', '200px').addClass('img-polaroid');
        imgMain.onload = function () {
            imgWidth = imgMain.offsetWidth;
            imgHeight = imgMain.offsetHeight;
        };
    }
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var imgWidth;
                var imgHeight;
                var imgEmployeeThumb = "divPicImageThumb";
                $("#" + imgEmployeeThumb).contents().remove();
                removeAttachement('');
                var img = document.createElement('img');
                img.id = 'imgempPic';
                $(img).css('display:block');
                img.src = e.target.result;
                $("#" + imgEmployeeThumb).append(img);
                $('img[id="imgempPic"]').css('height', '200px').css('width', '200px').addClass('img-polaroid');
                img.onload = function () {
                    imgWidth = img.offsetWidth;
                    imgHeight = img.offsetHeight;
                };
            };
            //            console.log(input.files[0]);
            reader.readAsDataURL(input.files[0]);
        }

    }
    function FileBrowser(event) {
        if (event !== null) {
            if (event.ctrlKey) {
                return;
            }
        }
        $('#imgFilechooser').click();
    }
    function removeAttachement(event) {
        if (event !== null) {
            if (event.ctrlKey) {
                return;
            }
        }

        //        if (file_exists("../../../documents/EmployeePictures/" + $('#txtEmpID').val() + ".jpg")) {
        //            msgBox("Are you sure to remove attachment?", "Confirm", 'ask', 'YES|NO', 0, 0, function(v) {
        //                if (v == 1) {
        //                    $.ajax({
        //                        url: '../../../models/mod.ntchrms.mstemployeeinformation.php?ACTION=removeAttachment',
        //                        data: {
        //                            POSTPARAM: $('#txtEmpID').val()
        //                        },
        //                        type: 'POST',
        //                        dataType: 'json',
        //                        async: false,
        //                        success: function(data) {
        //
        //                        }
        //                    });
        //                    $('#divPicImageThumb').contents().remove();
        //                } else {
        //                    return;
        //                }
        //            });
        //
        //        } else {
        $("#imgempPic").removeAttr('src');
        //        }

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

</script>

<div  class="container-fluid">
    <div class="panel panel-default" style="margin: 0px;">
        <div class="panel-heading heading-style" style="height: 50px;">
            <div class="contaner-fluid">
                <div class="row-fluid">
                    <div class="">
                        <div class="row-fluid">
                            <div class="col-xs-4 text-left">
                                <div class="input-group">
                                    <input id="txtSearchUser" class="form-control txt-standard" type="text" placeholder="Search User">
                                    <span class="input-group-addon" style="padding: 0px;">
                                        <button name="btnSearchUser" class="btn btn-default btn-md btn-standard">
                                            <span class="glyphicon glyphicon-search search-standard"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-8" style="float:right;margin-top: -7px;padding-right: 0;">
                                <button  id="<?= $strModuleName ?>-LBL_EXPORT" name="btnExport" class="btn btn-info btn-lg" title="export" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;min-width: 90px;max-width: 90px;">
                                    <span class="glyphicon glyphicon-export"></span> <?= $LBL_EXPORT ?>
                                </button>
                                <button   id="<?= $strModuleName ?>-LBL_REFRESH" name="btnRefresh" class="btn btn-info btn-lg" title="Refresh" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;min-width: 90px;max-width: 90px;">
                                    <span class="glyphicon glyphicon-refresh"></span> <?= $LBL_REFRESH ?>
                                </button> 

                                <button  id="<?= $strModuleName ?>-LBL_EDIT" name="btnEdit" class="btn btn-info btn-lg" title="Edit" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;min-width: 90px;max-width: 90px;">
                                    <span class="glyphicon glyphicon-edit"></span> <?= $LBL_EDIT ?>
                                </button> 
                                <button   id="<?= $strModuleName ?>-LBL_NEW" name="btnNew" class="btn btn-info btn-lg" title="New" style="padding: 7px 12px;float: right;font-size: 12px;min-width: 90px;max-width: 90px;">
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
        <div id="divList">
            <table id="tblList"></table>
            <div id="pgList"></div>
        </div>
    </div>
</div>
<div id="divUserSetting_dialog" style="display: none;padding: 0px;">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-xs-8 text-left" style="margin-top: 16px;margin-bottom: -18px;">
                    <div class="input-group">
                        <span class="input-group-addon" style="text-align: left;">
                            <label  id="<?= $strModuleName; ?>-LBL_EMPLOYEENAME"><?= $LBL_EMPLOYEENAME; ?></label>
                        </span>
                        <input type="hidden" id="txtactivation">
                        <input name="NAME OF USER" class="form-control" type="text" id="txtemployee"/>
                    <!--                        <select name="Employee" id="txtemployee" class="form-control" style="float:left;height: 28px;font-weight: bolder;padding: 0px 0px 0px 5px;">                      
                                            </select>-->
                    </div> 


                </div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-xs-4 text-left">
                        <div class="input-group" style="display: none;">
                            <span class="input-group-addon" style="width: 100px;text-align: left;">
                                <label  id="<?= $strModuleName; ?>-LBL_APPLICANTID"><?= $LBL_APPLICANTID; ?>ID</label>
                            </span>
                            <input name="ID" class="form-control"  type="text" id="txtID" readonly style="text-align: center;"/>
                        </div>
                    </div>

                </div>
                <div style="clear: both;"></div>
                <div style="width: 100%;">
                    <hr style="height: 1px;margin-bottom: 0px;"/>
                </div>
                <div style="clear: both;"></div>
                <br/> 
                <div class="row-fluid">
                    <div class="col-xs-12">
                        <div class="row-fluid">
                            <div class="col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon" style="  min-width: 131px;">
                                        <label for="txtUSERNAME" id="<?= $strModuleName ?>-LBL_USERNAME"><?= $LBL_USERNAME; ?></label>
                                    </span>
                                    <input name="USERNAME" class="form-control" type="text" id="txtUSERNAME"/>
                                </div>
                            </div>
                            <div class="col-xs-1 text-left"> </div>
                            <div class="col-xs-5 text-left">
                                <div class="input-group">
                                    <span class="input-group-addon" style="text-align: left; min-width: 10px; padding: 0px 0px 0px 30px;">
                                        <label for="txtusertype" id="<?= $strModuleName ?>-LBL_USERTYPE"><?= $LBL_USERTYPE; ?></label>
                                    </span>
                                    <select name="UserType" id="txtusertype" class="form-control" style="float: left; height: 28px; font-weight: bolder; padding: 0px; font-size: 12px;">                      
                                        <option value="user">User</option>
                                        <option value="administrator">Administrator</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style="clear: both;height: 16px;"></div>
                        <div class="row-fluid">
                            <div class="col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon" style="  min-width: 131px;">
                                        <label for="txtpassword" id="<?= $strModuleName ?>-LBL_PASSWORD"><?= $LBL_PASSWORD; ?></label>
                                    </span>
                                    <input name="Password" class="form-control" type="password" id="txtPASSWORD"/>       
                                </div>
                            </div>
                            <div class="col-xs-1 text-left" style="padding: 0px 0px 0px 5px;"> </div>
                            <div class="col-xs-5 text-left">
                                <div class="input-group">
                                    <span class="input-group-addon" style="text-align: left; min-width: 10px; padding: 0px 0px 0px 30px;">
                                        <label for="txtUSERROLE" id="<?= $strModuleName ?>-LBL_USERROLE"><?= $LBL_USERROLE; ?></label>
                                    </span>
                                    <select name="UserRole" id="txtUSERROLE" class="form-control" style="float: left; height: 28px; font-weight: bolder; padding: 0px; font-size: 12px;">                      
                                        <option value="1">User</option>
                                        <option value="2">Manager</option>
                                        <option value="3">Supervisor</option>
                                        <option value="4">Global Admin</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div style="clear: both;height: 5px;"></div>
                        <div class="row-fluid">
                            <div class="col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon" style="min-width: 131px;">
                                        <label for="txtretypepassword" style="    font-size: 13px;" id="<?= $strModuleName ?>-LBL_RETYPEPASSWORD"><?= $LBL_RETYPEPASSWORD; ?></label>
                                    </span>
                                    <input name="RetypePass" class="form-control" type="password" id="txtRetypePass"/>       
                                </div>
                            </div> 
                            <div class="col-xs-1 text-left"> </div>
                            <div class="col-xs-5 text-left" style="padding: 0px 0px 0px 5px;"> 
                                <button id="btnassign" style="    margin-left: 2%;" onclick="popupDialogFormAssignDesignation(event, 'divAssignDesignation_dialog', null);" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">
                                        <label id="<?= $strModuleName ?>-LBL_ASSIGNDESIGNATION"><?= $LBL_ASSIGNDESIGNATION; ?></label>
                                    </span></button>
                            </div>
                        </div>
                        <div style="clear: both;height: 8px;"></div>
                        <div class="registrationFormAlert" id="divCheckPasswordMatch" style="margin-left: 143px; color: #0000cc"></div>
                        <div style="clear: both;height: 8px;"></div>
                        <div class="col-xs-6 text-left">
                            <input type="checkbox" id="chkISACTIVE" style="float: left; height: 28px; width: 21px; margin-top: 0px; margin-left: 10px; cursor: pointer; font-size: 12px; padding: 5px; font-weight: bolder;" value="">
                            <span class="input-group-addon" style="width: 140px; text-align: left; border: none; background: transparent;">
                                <label for="chkISACTIVE" id="<?= $strModuleName ?>-LBL_ISACTIVE"><?= $LBL_ISACTIVE; ?></label>
                            </span>
                        </div>
                    </div><br>


                    <div style="clear: both;"></div>
                    <div style="width: 100%;">
                        <hr style="height: 1px;color: lightgray;margin-bottom: 0px;"/>
                    </div>
                    <br/>      


                </div>
            </div>

            <div class="panel-footer" >
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-xs-12 text-right">

                            <button class="btn btn-info btn-lg standard" name="btnSave" style="padding: 7px 12px;font-size: 12px;min-width: 90px;">
                                <span class="glyphicon glyphicon-save"></span>
                                <label for="" id="<?= $strModuleName; ?>-LBL_SAVE"><?= $LBL_SAVE; ?></label>
                            </button>
                            <button  class="btn btn-info btn-lg standard" name="btnCancel" style="padding: 7px 12px;font-size: 12px;min-width: 90px;max-width: 90px;">
                                <span class="glyphicon glyphicon-remove"></span>
                                <label for="" id="<?= $strModuleName; ?>-LBL_CANCEL"><?= $LBL_CANCEL; ?></label>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<!--User Designation/-->
<div id="divAssignDesignation_dialog" style="display: none;padding: 0px;">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-xs-8 text-left" style="margin-top: 16px;margin-bottom: -18px;">
                    <div class="input-group">
                        <span class="input-group-addon" style="text-align: left;">
                            <label  id="<?= $strModuleName; ?>-LBL_EMPLOYEENAME"><?= $LBL_EMPLOYEENAME; ?></label>
                        </span>
                        <input name="NAME OF USER" class="form-control" type="text" id="txtusername"/>
                    </div> 


                </div>
                <div class="col-xs-4 text-left" style="margin-top: 16px;margin-bottom: -18px;">
                    <div class="input-group">
                        <span class="input-group-addon" style="text-align: left;">
                            <label  id="<?= $strModuleName; ?>-LBL_ACTIVATIONKEY"><?= $LBL_ACTIVATIONKEY; ?></label>
                        </span>
                        <input name="Activation Key" class="form-control" type="text" id="txtactivationkey" maxlength="4"/>
                    </div> 


                </div>
            </div>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-xs-4 text-left">
                        <div class="input-group" style="display: none;">
                            <span class="input-group-addon" style="width: 100px;text-align: left;">
                                <label  id="<?= $strModuleName; ?>-LBL_ID"><?= $LBL_ID; ?></label>
                            </span>
                            <input name="ID" class="form-control"  type="text" id="txtID" readonly style="text-align: center;"/>
                        </div>
                    </div>

                </div>
                <div style="clear: both;"></div>
                <div style="width: 100%;">
                    <hr style="height: 1px;margin-bottom: 0px;"/>
                </div>
                <div style="clear: both;"></div>
                <br/> 
            </div>

            <div class="panel-body" id="panel-body" style="padding:0px;">
                <div id="divListAssignDesignation">
                    <table id="tblListAssignDesignation"></table>
                    <div id="pgListAssignDesignation"></div>
                </div>
            </div>

            <div class="panel-footer" >
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-xs-12 text-right">

                            <button class="btn btn-info btn-lg standard" name="btnSaveDes" onclick="saveDesignation(event)" style="padding: 7px 12px;font-size: 12px;min-width: 90px;">
                                <span class="glyphicon glyphicon-save"></span>
                                <label for="" id="<?= $strModuleName; ?>-LBL_SAVE"><?= $LBL_SAVE; ?></label>
                            </button>
                            <button  class="btn btn-info btn-lg standard" onclick='$("div[aria-labelledby$=\"divAssignDesignation_dialog\"] span[class=\"ui-icon ui-icon-closethick\"]").click()' name="btnCancelDes" style="padding: 7px 12px;font-size: 12px;min-width: 90px;max-width: 90px;">
                                <span class="glyphicon glyphicon-remove"></span>
                                <label for="" id="<?= $strModuleName; ?>-LBL_CANCEL"><?= $LBL_CANCEL; ?></label>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<div id="modalBrowserLaboratoryList" style="display: none;">      
    <div id="listCommonBrowser" >
        <label id="<?= $strModuleName . '-LBL_SEARCH'; ?>"><?= $LBL_SEARCH; ?></label>
        <input id = "txtSearchBrowserLaboratoryList"  class="common-textbox" style="width: 85%;height: 28px;    padding: 5px;" type = "text"   name="Search"   value=""   onkeydown='reloadBrowserLaboratoryList(event);'>  </input>
        <button name="btnBrowserLaboratoryList" onclick="reloadBrowserLaboratoryList(event);" class="btn btn-default btn-md btn-standard" style="    border: #CCCCCC solid 1px;    height: 28px;">
            <span class="glyphicon glyphicon-search search-standard" style="    width: 22px;"></span>
        </button>

        <div style="height: 5px;"></div>
        <table id = "tblListBrowserLaboratoryList" ></table>
        <div id ="pagerBrowserLaboratoryList"></div>

        <div style="height: 1px;background-color: #CCC;margin-top: 3px;"></div>

    </div>
</div>
<div id="modalBrowserModuleList" style="display: none;">      
    <div id="listCommonBrowser" >
        <label id="<?= $strModuleName . '-LBL_SEARCH'; ?>"><?= $LBL_SEARCH; ?></label>
        <input id = "txtSearchBrowserModuleList"  class="common-textbox" style="width: 85%;height: 28px;    padding: 5px;" type = "text"   name="Search"   value=""   onkeydown='reloadBrowserModuleList(event);'>  </input>
        <button name="btnBrowserModuleList" onclick="reloadBrowserModuleList(event);" class="btn btn-default btn-md btn-standard" style="    border: #CCCCCC solid 1px;    height: 28px;">
            <span class="glyphicon glyphicon-search search-standard" style="    width: 22px;"></span>
        </button>

        <div style="height: 5px;"></div>
        <table id = "tblListBrowserModuleList" ></table>
        <div id ="pagerBrowserModuleList"></div>

        <div style="height: 1px;background-color: #CCC;margin-top: 3px;"></div>

    </div>
</div>
<style>
    .required-field{
        border: red solid thin;
    }
    .ui-jqgrid tr.jqgrow td {
        white-space: normal !important;
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
        font-size:12px;
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
</style>