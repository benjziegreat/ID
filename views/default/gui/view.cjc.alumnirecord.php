<?php
error_reporting(E_ALL ^ E_WARNING);
ini_set("display_errors", 0);
include_once '../../../libs/include.view.php';
include_once '../../../config/cons.paths.php';

$strModuleName = 'cjc.alumnirecord';

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
<link rel="stylesheet" href="jsgui/css/button.css"/>
<!--<script type ="text/javascript" src ='jsgui/msgdialog.js'></script>--> 
<script src="jsgui/barcode/EAN_UPC.js"></script>
<script src="jsgui/barcode/CODE39.js"></script>
<script src="jsgui/barcode/CODE128.js"></script>
<script src="jsgui/barcode/JsBarcode.js"></script>
<script type ="text/javascript" src ='../js/jquery.contextmenu.js'></script>
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
    /*        *, *:before, *:after {
                     -webkit-box-sizing: border-box; 
                    -moz-box-sizing: border-box;
                    box-sizing: border-box;
                      box-sizing: initial;
                }*/
    /*/Css for contextmenu*
  
 /**/    

    .vmenu{
        border:1px solid #aaa;
        position:absolute;
        background:#fbf2fe !important;
        display:none;
        font-size:0.75em;
        box-shadow:#555 2px 2px 4px;
        border-radius:2px 2px 2px 2px;
        -webkit-border-radius: .1em;
        -moz-border-radius: .1em;
    }

    .vmenu *{
        font-size:12px;
    }

    .vmenu .first_li span{
        width:180px;
        display:block;
        padding:5px 10px;
        cursor:pointer;
        font-weight: bolder;
    }

    .vmenu .inner_li{
        display:none;
        margin-left:200px;
        position:absolute;
        border:1px solid #aaa;
        border-left:1px solid #ccc;
        margin-top:-28px;
        background:#efefef !important;
        box-shadow:#555 2px 2px 4px;
        border-radius:1px 1px 1px 1px;
        color:#000;
    }

    .vmenu .sep_li{
        border-top: 1px ridge #aaa;
        margin:5px 0;
    }

    .vmenu .fill_title{
        font-size:11px;font-weight:bold;
        /*height:15px;*/
        /*overflow:hidden;*/
        word-wrap:break-word;
    }

    .vmenu_haschild{
        background:url(arrow_blk.png) no-repeat right !important;
    }

    .vmenu span{
        color:#000;
        text-align:left;
    }

    .vmenu span:hover{
        background-color: #3b64fb !important; 
        cursor:pointer;
        color:#fff;
        -webkit-border-radius: .1em;
        -moz-border-radius: .1em;
    }

    .vmenu_dispan{
        color: #999 !important;
    }
    /*End of css of contextmenu(right click)/*/

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
                $('ul[class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"]').css('max-height', '250px').css('max-width', $($(this)[0].element[0]).css('width')).css('overflow', 'auto').css('box-shadow', '1px 1px 5px rgb(171, 161, 161)');
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
//                    console.log($(this).attr('id').split('custom-combobox-input-').join(''));
//                    $('a[id="custom-combobox-showall'+$(this).attr('id').split('custom-combobox-input-').join('')+'"]').click();
                });
                this.input.bind('autocompletechange', function (event, ui) {
                    // debugger;
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
//                            loadList('tblAlumniInformationList', 'pgAlumniInformationList');
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
//                console.log($($(this)[0].element[0]).css('width')); //output width of selectbox
                $('ul[class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"]').css('max-height', '250px').css('max-width', $($(this)[0].element[0]).css('width')).css('overflow', 'auto').css('box-shadow', '1px 1px 5px rgb(171, 161, 161)');
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

    function loadAlumniListCombo(strCboType) {

        $('#' + strCboType + ' option').each(function () {
            $(this).remove();
        });
        $('#' + strCboType).append($('<option>', {
            value: '',
            text: ''
        }));
        $.ajax({
            url: "../../../models/mod.hris.leavereports.php",
            data: {
                ACTION: "loadAlumniList"
            },
            dataType: 'json',
            async: false,
            success: function (jsonReturn) {
                $.each(jsonReturn, function (index, value) {
                    var options = "<option value='" + value['person_code'] + "' >" + pad(value['person_code'], 6) + " - " + value['AlumniName'] + "</option>";
                    $('#' + strCboType).append(options);
                });
            }});
    }

    function LoadValuesOptionFromDB(strCboType,action,fieldforvalue,fieldfortext) {

        // $('#' + strCboType + ' option').each(function () {
        //     $(this).remove();
        // });
        // $('#' + strCboType).append($('<option>', {
        //     value: '',
        //     text: ''
        // }));
        $.ajax({
            url: "../../../models/mod.cjc.alumnirecord.php",
            data: {
                ACTION: action//"loadCategoryList"
            },
            dataType: 'json',
            async: false,
            success: function (jsonReturn) {
                $.each(jsonReturn, function (index, value) {
                     var str=value[fieldforvalue];
                    if($('#'+strCboType+' option[value="'+str+'"]').length==0){
                       console.log(value[fieldforvalue]);
                      var options = "<option value='" + value[fieldforvalue] + "' >" + value[fieldfortext] + "</option>";
                      $('#' + strCboType).append(options);   
                    }
                    
                });
            }});
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
        iniControls();
        loadList('tblAlumniInformationList', 'pgAlumniInformationList', 'No Display');
        onresize = function () {
            resizeWindow(); //this function resize is from cjcnaviframe
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
//        $("input[type='text']").click(event, function () {
//            $(this).select();
//        });

        $('#divAdditionalFilter').contents().remove();
        var htmdiv = '<div class="input-group col-lg-6" style="margin-top: 3px;">\n\
            <span class="input-group-addon" id="basic-addon1">Batch:</span> \n\
            <input type="number" id="txtFilterBatch"class="form-control" placeholder="YYYY" aria-describedby="basic-addon1"/>\n\
            </div>';
        $('#divAdditionalFilter').append(htmdiv);
        $("#txtFilterBatch").keyup(event, function() {
            if (event.keyCode == 13) {
                loadList('tblAlumniInformationList', 'pgAlumniInformationList', $("#txtSearchAlumni").val());
            }
        });


        $('#dvContainer').css({
            position: 'absolute',
            width: $(window).width(),
            height: $(window).height()
        });
        $("#txtSearchAlumni").keyup(event, function () {
            if (event.keyCode == 13) {
                loadList('tblAlumniInformationList', 'pgAlumniInformationList', $("#txtSearchAlumni").val());
            }
        });
        $("button[name='btnSearchAlumni']").click(null, function (event) {
            loadList('tblAlumniInformationList', 'pgAlumniInformationList', $("#txtSearchAlumni").val());
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
            } else if ($.trim(target.data('tableName')) === "tblImageSettings") {

            } else if ($.trim(target.data('tableName')) === "tblIDPreview") {
//                $('div[id^="emp_name"]').map(function (index, elem) {
//                    //console.log($(elem).find('span').text());
//                    if ($.trim($(elem).find('span').text()).length > 30) {
//                        fitTextInBox(elem);
//                    }
//                });
//                $('div[id^="s_mother"]').map(function (index, elem) {
//                    //console.log($(elem).find('span').text());
//                    if ($.trim($(elem).find('span').text()).length > 30) {
//                        fitTextInBox(elem);
//                    }
//
//                });
                //Trigger function auto fit text to div tags

//                fitTextInBox('emp_name');
//                var fullname=$('#txtfname').val().toString().toUpperCase() + ' ' + $('#txtmname').val().toString().toUpperCase().slice(0, 1) + "." + ' ' + $('#txtlname').val().toString().toUpperCase();
//               $('div[id="emp_name"] span').text(fullname);
//                  if(fullname.length>30){
//                   $('div[id="emp_name"]').map(function(index, elem) {
//                   fitTextInBox(elem);
//                   });
//               }
//                fitTextInBox('emp_position');
//                $('div[id="emp_name"]').map(function(index, elem) {
//                    fitTextInBox(elem);
//                });
//                $('div[id="emp_position"]').map(function(index, elem) {
//                    fitTextInBox(elem);
//                });
                //end of auto fit text
//                $('img[id="barcode"]').map(function (index, elem) {
//                    $(elem).JsBarcode('2009-0418-5', {width: 1, height: 50, displayValue: false, fontSize: 18, format: 'CODE39'});
//                });
//                $("#emp_signature img").attr("src", '../../../documents/AlumniSignature/' + GlobalIDDataSeledted["emp_id"] + '.png' + "?time=" + new Date());

                //        console.log(data['mname']);
                // Front Populate
//               $('div[id="emp_name"] span').html($('#txtlname').val().toString().toUpperCase() + ' ' + ' ' + $('#txtlname').val().toString().capitalizeFirst() +'<br>'+$('#txtmname').val().toString().toUpperCase() + "") ;//.slice(0, 1)
//               $('div[id="emp_id"] span').text($.trim($('#txtemp_id').val()));
//               $('div[id="emp_position"] span').text($('#txtemp_position').val());
//               $('div[id="emp_idtype"] span').text($('#txtcategory').val());
                //   $('div[id="emp_president"] span').text('BR. ELLAKIM P. SOSMEÑA, S.C.');
                //  $('div[id="emp_president"] span').text('PRESIDENT');

//               $('img[id="barcode"]').map(function (index, elem) {
//                   $(elem).JsBarcode($('#txtemp_id').val(), {width: 1, height: 50, displayValue: false, fontSize: 14, format: 'CODE39', font: "Arial,sans-serif"});
//                   $(elem).css({"width": "200px", "height": "27px"});
//               });
//               if (file_exists("../../../documents/AlumniPictures/" + $("#txtemp_id").val() + ".png")) {
//                   $('#emp_pic img').attr('src', '../../../documents/AlumniPictures/' + $('#txtemp_id').val() + '.png' + "?time=" + new Date());
//               } else {
//                   //Picture not exist.
//                   $('#emp_pic img').attr("src", '../../../documents/AlumniPictures/nopic.png' + "?time=" + new Date());
//               }
//               if (file_exists("../../../documents/AlumniSignature/" + $('#txtemp_id').val() + ".png")) {
//                   $('#emp_signature img').attr("src", '../../../documents/AlumniSignature/' + $('#txtemp_id').val() + ".png" + "?time=" + new Date());
//               } else {
//                   //Picture not exist.
//                   $('#emp_signature img').attr("src", '../../../documents/AlumniSignature/nopic.png' + "?time=" + new Date());
//               }
//
//              //  Back ID Populate
//               $('div[id="s_SSS"] span').text($('#sssgsisno').val());
//               $('div[id="s_tinno"] span').text($('#tinno').val());
//               $('div[id="s_philhealth"] span').text($('#philno').val());
//              // $('div[id="s_birthdate"] span').text($('#txtbirthdate').val());
//               $('div[id="p_civil"] span').text($('#txtstatus').val());
//               $('div[id="s_mother"] span').text($('#txtcontact_guardian').val());
//               $('div[id="p_address"] span').text($('#txtcontact_address').val());
//               $('div[id="p_cellno"] span').text($('#txtcontactno').val());
                try {
                    $('img').map(function (index, elem) {
                        var srcval = $(elem).attr('src');
                        var newSrc = srcval.split('?')[0];
                        console.log(elem);
                        if ($(elem).attr('id') == "barcode") {
                        } else {
                            $(elem).attr('src', newSrc + '?' + new Date());
                        }
                    });
                } catch (err) {
                    console.log(err)
                }


            }
        });
        $('button[name="btnSaveAlumni"],button[name="btnPrintID"],button[name="btnCancel"],button[name="btnDetailRefresh"]').bind("click", function (event) {

            if (event.ctrlKey)
                return;
            if ($(this).attr('name') === "btnSaveAlumni" && isAllowed()) {
                saveAlumniInformationList(event);
            } else if ($(this).attr('name') === "btnCancel") {
                $('div[aria-labelledby$="alumniprofile_dialog"] span[class="ui-icon ui-icon-closethick"]').click()
            } else if ($(this).attr('name') === "btnDetailRefresh") {
                GetDetailList($('#txtemp_id').val());
            }
        });
        $('button[name="btnRefresh"]').bind("click", function (e) {
            if (e.ctrlKey)
                return;
            if (isAllowedAccessClick('module', 'Alumni Record', 'view')) {
                loadList('tblAlumniInformationList', 'pgAlumniInformationList', $("#txtSearchAlumni").val());
            }
        });
        $('button[name="btnPreviewID"]').bind("click", function (e) {
            if (e.ctrlKey)
                return;
            if (isAllowedAccessClick('module', 'Alumni Record', 'print')) {
                if ($('input[class="cbox"]').length > 0) {
                    AlumniFramePopupID('', 'frmAlumniIDPreview', 'Alumni ID Preview', 'frmAlumniIdPreview.php');
                } else {
                    animation(1);
                    var rowdata = jQuery("#tblAlumniInformationList").jqGrid('getRowData', jQuery("#tblAlumniInformationList").jqGrid('getGridParam', 'selrow'));
                    if ($.isEmptyObject(rowdata)) {
                        swal("System Message", "No Item selected.", 'warning');
                    } else {
                        AlumniFramePopupID('', 'frmAlumniIDPreview', 'Alumni ID Preview', 'frmAlumniIdPreview.php', true, rowdata["emp_id"]);
                    }
                    animation(0);
                }
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
                            Type: 'hrmsMSTAlumniInformation'
                        }, '');
                    } else {
                        return;
                    }
                });
                var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                $('div[id="___msgBox"]').css("height", "");
            }





        });
        $('button[name="btnNew"]').bind("click", function (e) {
            if (e.ctrlKey)
                return;
            if (isAllowedAccessClick('module', 'Alumni Record', 'create')) {
                popupDialogForm(e, 'alumniprofile_dialog', null);
            }
        });
        $('button[name="btnEdit"]').bind("click", function (e) {
            if (e.ctrlKey)
                return;
            if (isAllowedAccessClick('module', 'Alumni Record', 'update')) {
                var rowdata = jQuery('#tblAlumniInformationList').jqGrid('getRowData', jQuery('#tblAlumniInformationList').jqGrid('getGridParam', 'selrow'));
                if ($.isEmptyObject(rowdata)) {
                    swal("System Message", "No Item selected.", 'warning');
                } else {
                    popupDialogForm(e, 'alumniprofile_dialog', rowdata);
                }
            }
        });
        //Initial Format css jquery functions
        $('#alumniprofile_dialog input,select').css({"height": "28px", "font-size": "12px", "padding": "5px", "font-weight": "bolder"});
        $('#alumniprofile_dialog select').css({"padding": "0px"});
        $('#btnPrintPreviewID').button();
        $('#btnRefreshSignature').button();
        //bind events of chkbox Gender
        $('input[id="chkIsSexMale"],input[id="chkIsSexFemale"]').bind("click", function (event) {
            $('input[id="chkIsSexMale"],input[id="chkIsSexFemale"]').removeAttr('checked');
            $(this).attr('checked', 'checked');
        });
        //end of bind event of chkbox Gender

        //Filter Search Combobox transform to autocomplete
 //Load or Refresh course from smis.student_program
        LoadValuesOptionFromDB('txtfilterdesignation','loadCourseList','shortdesc','shortdesc');
//txtfiltercategory        
        var objectval = [];
        var objectcaption = [];
        $('#txtfiltercategory option').map(function (index, elem) {
            objectval.push($(elem).val());
            objectcaption.push($(elem).text());
        });
        loadComboxBoxStaticOption('txtfiltercategory', objectval, objectcaption);
//txtfilterdesignation        
        objectval = [];
        objectcaption = [];
        $('#txtfilterdesignation option').map(function (index, elem) {
            objectval.push($(elem).val());
            objectcaption.push($(elem).text());
        });
        loadComboxBoxStaticOption('txtfilterdesignation', objectval, objectcaption);
        $('input[id="custom-combobox-input-txtfiltercategory"]').css('width', '83%');
        $('input[id="custom-combobox-input-txtfilterdesignation"]').css('width', '83%');
        // End of Filter Search transform to autocomplete

        $('#txtbatch').unbind();
        $('#txtbatch').bind("keyup", function (event) {
            //console.log($(this).val());
            var value = $(this).val();
            if (value.length > 4) {
                $(this).val(value.substr(0, 4))
            }

        });


        $('#alumnifilterprintulIDsDropdowns li').unbind();
        $('#alumnifilterprintulIDsDropdowns li').bind("click", function (event) {
            $('button[name="btnFiltersType"]').contents().remove();
//             idLinkAllList idLinkIsActive idLinkInActive idLinkIsMain idLinkIsPart
            var caretElement = "<span class=\"caret\" style=\" margin-right: 5px; margin-top: 6px; float: right;margin-left: 5px;\"></span>";
            $('button[name="btnFiltersType"]').append($(this).text() + caretElement);
//            console.log($(this).text());

            $('#chkIsAllList,#chkIsForPrinting,#chkIsPrintedList,#chkIsExpiredItem,#chkIsNoPicture,#chkIsWithPicture,#chkIsNoSignature,#chkIsWithSignature').removeAttr('checked');
//            console.log($(this).find('a').attr('id'));
            $('input[id*="' + $.trim($(this).find('a').attr('id').split('idLink').join('')) + '"]').attr('checked', 'checked');
            if ($.trim($(this).find('a').attr('id').split('idLink').join('')) == "IsAllList") {
                swal("System Message", "Generating ALL LIST will take time depending on how large the data/record is in the database.", 'info');
            }
            // reloadtblLaboratoryRequest();

            // loadList('tblAlumniInformationList', 'pgAlumniInformationList',$("#txtSearchAlumni").val());
        });
        // $('#idLinkIsForPrinting').click();

    }
    function PrintPreviewIDIndividual() {
        if (isAllowedAccessClick('module', 'Alumni Record', 'print')) {
            animation(1);
            AlumniFramePopupID('', 'frmAlumniIDPreview', 'Alumni ID Preview', 'frmAlumniIdPreview.php', true, $('#txtemp_id').val());
            animation(0);
//            var message = "Do you want to print ID?";
//            msgBox(message, "Confirmation", "ask", "Yes|No", 300, 250, function (dlgvalue) {
//                clickLabel();
//                if (dlgvalue == 1) {
//                    animation(1);
//                    AlumniFramePopupID('', 'frmAlumniIDPreview', 'Alumni ID Preview', 'frmAlumniIdPreview.php', true, $('#txtemp_id').val());
//                    animation(0);
////                    $.ajax({
////                        url: "../../../models/mod.cjc.alumnirecord.php?ACTION=updateprintinghistory",
////                        type: "POST",
////                        data: {
////                            POSTPARAM: {
////                                idnum: $('#txtidnum').val(),
////                                type: 'Individual'
////                            }
////                        },
////                        success: function (valret) {
////
////                            if (valret !== "") {
////                                animation(0);
////                                printDivData_WP('divIDPreview', 'P', '_blank');
////                                reloadtblAlumniInformationList();
////                                $('#txtprintinghistory').val(valret);
////                            } else {
////                                console.log(valret);
////                                var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATEERROR'><?= $LBL_SAVEUPDATEERROR ?></label>";
            msgBox(message, "Error", "failed", "OK", 300, 250, function (dlgvalue) {

            });
            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
////                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
////                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
////                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
////                                $('div[id="___msgBox"]').css("height", "");
////                                clickLabel();
////                                animation(0);
////                            }
////
////                        }
////                    });
//                }
//            });
//            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
//            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
//            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
//            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
//            $('div[id="___msgBox"]').css("height", "");
//            clickLabel();
        }

    }
    function functionRefreshAlumniSignature() {
//
//        openPost('../../../models/employeeRenameSignature.php', {
//            filename: GlobalIDDataSeledted["emp_id"]
//        }, '');
        document.getElementById('filename').value = GlobalIDDataSeledted["emp_id"];
        var fd = new FormData(document.forms["form1AlumniSignature"]);
        var xhr = new XMLHttpRequest();
        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                console.log(percentComplete + '% uploaded');
//                    console.log(e);
                alert('Refress Success');
                $('img').map(function (index, elem) {
                    var srcval = $(elem).attr('src');
                    var newSrc = srcval.split('?')[0];
                    console.log(elem);
                    if ($(elem).attr('id') == "barcode") {
                    } else {
                        $(elem).attr('src', newSrc + '?' + new Date());
                    }
                });
            }
        };
        xhr.onload = function () {
            alert('Refress Success');
            $('img').map(function (index, elem) {
                var srcval = $(elem).attr('src');
                var newSrc = srcval.split('?')[0];
                console.log(elem);
                if ($(elem).attr('id') == "barcode") {
                } else {
                    $(elem).attr('src', newSrc + '?' + new Date());
                }
            });
        };
        xhr.open('POST', '../../../views/default/gui/SignaturePad/examples/employeeRenameSignature.php', true);
        xhr.send(fd);
    }
    function reloadtblAlumniInformationList() {
        $("div#divAlumniInformationList table#tblAlumniInformationList").setGridParam({
            postData: {
                ACTION: 'loadList',
                GETPARAM: {
                    _searchKey: $("#txtSearchAlumni").val(),
                    category: $('input[id$="txtfiltercategory"]').val(),
                    designation: $('input[id$="txtfilterdesignation"]').val(),
                    printtype: $('#divFilterPrint input:checked').attr('id').split('chk').join(''),
                    batch:$('input[id$="txtFilterBatch"]').val()

                }
            }
        }).trigger('reloadGrid');
    }

    function loadList(gridID, pgID, searchkey) {
        $("#" + gridID).jqGrid('GridUnload');
        $("#" + gridID).jqGrid({
            url: '../../../models/mod.cjc.alumnirecord' + ($('button[name="btnFiltersType"]').text() == "FILTER BY" ? '123' : '') + '.php',
            datatype: 'json',
            async: false,
            mtype: 'GET',
            postData: {
                ACTION: 'loadList',
                GETPARAM: {
                    _searchKey: searchkey,
                    category: $('input[id$="txtfiltercategory"]').val(),
                    designation: $('input[id$="txtfilterdesignation"]').val(),
                    printtype: $('#divFilterPrint input:checked').attr('id').split('chk').join(''),
                    batch:$('input[id$="txtFilterBatch"]').val()
                }
            },
            colModel: [
                {
                    name: 'emp_id',
                    index: 'emp_id',
                    hidden: false,
                    align: 'center',
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLALUMNIID"><?= $LBL_TBLALUMNIID; ?></label>',
                    width: 100,
                    // formatter: function (cellvalue, options, rowObject) {
                    //     return pad(cellvalue, 6);
                    // },
                    // unformat: function (cellvalue, options, cell) {
                    //     return pad(cellvalue, 6);
                    // },
                    frozen: false
                },
                {
                    name: 'StudentName',
                    index: 'StudentName',
                    hidden: false,
                    width: 200,
                    label: '<label style="font-size: 12px;"  id="<?= $strModuleName; ?>-LBL_TBLNAME"><?= $LBL_TBLNAME; ?></label>',
                    frozen: false
                },
                {
                    name: 'category',
                    index: 'category',
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLCATEGORY"><?= $LBL_TBLCATEGORY; ?></label>',
                    hidden: false
                },
                {
                    name: 'designation',
                    index: 'designation',
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLDESIGNATION"><?= $LBL_TBLDESIGNATION; ?></label>',
                    hidden: false
                },
                {
                    name: 'isforprint',
                    index: 'isforprint',
                    hidden: false,
                    width: 80,
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLISFORPRINT"><?= $LBL_TBLISFORPRINT; ?></label>',
                    edittype: 'checkbox',
                    editoptions: {value: '1:0', defaultValue: '0'},
                    formatoptions: {disabled: false},
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "isforprint";
                        var chkValue = (cellvalue == 1 ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox"' + chkValue + ' disabled value = "' + cellvalue + '" offval="0">';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return $("input:checkbox", cell).prop("checked") ? 1 : 0;
                    },
                    align: 'center'
                },
                {
                    name: 'isactive',
                    index: 'isactive',
                    hidden: true,
                    width: 100,
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLISACTIVE"><?= $LBL_TBLISACTIVE; ?></label>',
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
                    name: 'photopic',
                    index: 'photopic',
                    hidden: false,
                    width: 70,
                    formatter: function (cellvalue, options, rowObject) {
                        var imgSrc = '';
                        if (file_exists("../../../documents/AlumniPictures/" + rowObject.emp_id + ".png")) {
                            imgSrc = '../../../documents/AlumniPictures/' + rowObject.emp_id + '.png?' + new Date();
                        } else {
                            imgSrc = '../../../documents/AlumniPictures/nopic.png?' + new Date();
                        }
                        return '<img id = "imgemployeeImageGrid-' + rowObject.emp_id + '" ' +
                                'src = "' + imgSrc + '"' +
                                'style ="width:20px; vertical-align: middle;max-width: 25px;max-height: 25px;height:20px;width:20px;" ' +
                                '</img>';
                    },
                    align: "center",
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLPHOTO"><?= $LBL_TBLPHOTO; ?></label>'
                },
                {
                    name: 'signaturepic',
                    index: 'signaturepic',
                    hidden: false,
                    width: 70,
                    formatter: function (cellvalue, options, rowObject) {
                        var imgSrc = '';
                        if (file_exists("../../../documents/AlumniSignature/" + rowObject.emp_id + ".png")) {
                            imgSrc = '../../../documents/AlumniSignature/' + rowObject.emp_id + '.png?' + new Date();
                        } else {
                            imgSrc = '../../../documents/AlumniSignature/nopic.png?' + new Date();
                        }
                        return '<img id = "imgemployeeImageGrid-' + rowObject.emp_id + '" ' +
                                'src = "' + imgSrc + '"' +
                                'style ="width:60px; vertical-align: middle;max-width: 65px;max-height: 25px;height:20px;width:60px;" ' +
                                '</img>';
                    },
                    align: "center",
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLSIGNATURE"><?= $LBL_TBLSIGNATURE; ?></label>'
                },
                {
                    name: 'Sex',
                    index: 'Sex',
                    hidden: false,
                    width: 50,
                    align: 'LEFT',
                    label: '<label style="font-size: 12px;"  id="<?= $strModuleName; ?>-LBL_TBLGENDER"><?= $LBL_TBLGENDER; ?></label>'
                },
                {
                    name: 'fname',
                    index: 'fname',
                    hidden: true
                },
                {
                    name: 'mname',
                    index: 'mname',
                    hidden: true
                },
                {
                    name: 'lname',
                    index: 'mname',
                    hidden: true
                },
                {
                    name: 'birthdate',
                    index: 'birthdate',
                    hidden: false,
                    width: 100,
                    align: 'center',
                    label: '<label  style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLBIRTHDATE"><?= $LBL_TBLBIRTHDATE; ?></label>'
                },
                {
                    name: 'Age',
                    index: 'Age',
                    hidden: false,
                    width: 50,
                    align: 'center',
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLAGE"><?= $LBL_TBLAGE; ?></label>'
                },
                {
                    name: 'contact_guardian',
                    index: 'contact_guardian',
                    hidden: false,
                    width: 100,
                    label: '<label style="font-size: 12px;" id="<?= $strModuleName; ?>-LBL_TBLGUARDIAN"><?= $LBL_TBLGUARDIAN; ?></label>'
                },
                {
                    name: 'contact_address',
                    index: 'contact_address',
                    hidden: false,
                    width: 200,
                    label: '<label style="font-size: 12px;"  id="<?= $strModuleName; ?>-LBL_TBLCONTACTADD"><?= $LBL_TBLCONTACTADD; ?></label>'
                },
                {
                    name: 'contactno',
                    index: 'contactno',
                    hidden: false,
                    label: '<label style="font-size: 12px;"  id="<?= $strModuleName; ?>-LBL_TBLCONTACTNO"><?= $LBL_TBLCONTACTNO; ?></label>'
                },
                {
                    name: 'contact_relation',
                    index: 'contact_relation',
                    hidden: true
                },
                {
                    name: 'status',
                    index: 'status',
                    hidden: true
                },
                {
                    name: 'sssgsisno',
                    index: 'sssgsisno',
                    hidden: true
                },
                {
                    name: 'tinno',
                    index: 'tinno',
                    hidden: true
                },
                {
                    name: 'philno',
                    index: 'philno',
                    hidden: true
                },
                {
                    name: 'pagibigno',
                    index: 'pagibigno',
                    hidden: true
                },
                {
                    name: 'birthdatevalue',
                    index: 'birthdatevalue',
                    hidden: true
                },
                {
                    name: 'printinghistory',
                    index: 'printinghistory',
                    hidden: true
                },
                {
                    name: 'idnum',
                    index: 'idnum',
                    hidden: true
                },
                {
                    name: 'FLAG',
                    index: 'FLAG',
                    hidden: true
                }
            ],
            width: $(window).width() - parseInt($('#sidebar').css('width').split('px').join('')) - 8,
            height: $(window).height() - parseInt($('#header').css('height').split('px').join('')) - parseInt($('#divIDFilterAlumniContainer').css('height').split('px').join('')) - 100,
            pager: "#" + pgID,
            jsonReader: {
                repeatitems: false
            },
            rowNum: 50,
            cellsubmit: 'clientArray',
            autowidth: false,
            shrinkToFit: false,
            rownumbers: true,
            sortorder: 'ASC',
            sortname: 'StudentName',
            multiselect: $("#chkIsAllowMultiple ").is(":checked") ? true : false,
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
                if (isAllowedAccessClick('module', 'Alumni Record', 'update')) {
                    var rv = $(this).getRowData(id);
                    popupDialogForm('', 'alumniprofile_dialog', rv);
                }
            },
            loadComplete: function () {
                $(this).contextMenu('AlumniRecordContextRmenu', '#divAlumniInformationList', {
                    bindings: {
                        'mnuadd': function (row) {
                            if (isAllowedAccessClick('module', 'Alumni Record', 'create')) {
                                popupDialogForm('', 'alumniprofile_dialog', null);
                            }
                        },
                        'mnuview': function (row) {
                            if (isAllowedAccessClick('module', 'Alumni Record', 'print')) {
                                if ($('input[class="cbox"]').length > 0) {
                                    AlumniFramePopupID('', 'frmAlumniIDPreview', 'Alumni ID Preview', 'frmAlumniIdPreview.php');
                                } else {
                                    animation(1);
                                    var rowdata = jQuery("#" + gridID).jqGrid('getRowData', jQuery("#" + gridID).jqGrid('getGridParam', 'selrow'));
                                    if ($.isEmptyObject(rowdata)) {
                                        swal("System Message", "No Item selected.", 'warning');
                                    } else {
                                        AlumniFramePopupID('', 'frmAlumniIDPreview', 'Alumni ID Preview', 'frmAlumniIdPreview.php', true, rowdata["emp_id"]);
                                    }
                                    animation(0);
                                }
                            }
                        },
                        'mnuedit': function (row) {
                            if (isAllowedAccessClick('module', 'Alumni Record', 'update')) {
                                var rowdata = jQuery("#" + gridID).jqGrid('getRowData', jQuery("#" + gridID).jqGrid('getGridParam', 'selrow'));
                                if ($.isEmptyObject(rowdata)) {
                                    swal("System Message", "No Item selected.", 'warning');
                                } else {
                                    popupDialogForm('', 'alumniprofile_dialog', rowdata);
                                }
                            }

                        },
                        'mnurefresh': function (row) {
                            if (isAllowedAccessClick('module', 'Alumni Record', 'view')) {
                                loadList('tblAlumniInformationList', 'pgAlumniInformationList', $("#txtSearchAlumni").val());
                            }

                        },
                        'mnumultiple': function (row) {
                            if ($('#chkIsAllowMultiple').is(':checked')) {
                                $('#chkIsAllowMultiple').attr('checked', false);
                            } else {
                                $('#chkIsAllowMultiple').attr('checked', true);
                            }
                            if (isAllowedAccessClick('module', 'Alumni Record', 'view')) {
                                loadList('tblAlumniInformationList', 'pgAlumniInformationList', $("#txtSearchAlumni").val());
                            }

                        }


                    },
                    menuStyle: {
                        backgroundColor: '#fcfdfd',
                        border: '1px solid #a6c9e2',
                        maxWidth: '600px',
                        width: '100%',
//                        width: '150px',
//                        height: '130px'
                    },
                    itemHoverStyle: {
                        border: '1px solid #79b7e7',
                        color: '#1d5987',
                        backgroundColor: '#d0e5f5',
                        cursor: 'pointer'
                    }
                });

            }
        });
        $("#" + gridID).jqGrid('setFrozenColumns');
    }
    function setTableListResizeGrids() {
        $("#tblAlumniInformationList").setGridWidth($(window).width() - parseInt($('#sidebar').css('width').split('px').join('')) - 8, false);
        $('#tblAlumniInformationList').jqGrid('setGridHeight', $(window).height() - parseInt($('#header').css('height').split('px').join('')) - parseInt($('#divIDFilterAlumniContainer').css('height').split('px').join('')) - 100);
    }
    function setTableListResizeGridsTabs() {

        $("#tblImageSettings").setGridWidth($('#divPictureTbl').width() - 1, false);
        //     $('#tblImageSettings').jqGrid('setGridHeight', 290);

        $("#tblImageSettingsSign").setGridWidth($('#divSignatureTbl').width() - 1, false);
        //     $('#tblEducationalBackground').jqGrid('setGridHeight', 290);



    }

    function AlumniFramePopupID(event, frmtitle, title, url, isindividual, empid) {
        if (event.ctrlKey)
            return;
        var dwidth = $(window).width() - $(window).width() * 0.25;
        var dheight = $(window).height() - $(window).height() * 0.10;
        var horizontalPadding = 0;
        var verticalPadding = 0;
        $('<iframe id="' + frmtitle + '" style="float:none;" frameborder="0" src="' + url + '" />')
                .dialog({
                    title: title,
                    autoOpen: true,
                    height: dheight,
                    width: dwidth,
                    modal: true,
                    resizable: true,
                    autoResize: false,
                    closeOnEscape: true,
                    overlay: {
                        opacity: 0.5,
                        background: "black"
                    },
                    open: function () {
                        $(this).dialog('option', 'position', ['top', 0]);
                        $(this).load(function () {
                            // debugger;
                            var frame = this.contentWindow;
                            console.log(frame.employeeData, $(this));
                            if (isindividual == true) {
                                frame.employeeData = empid;
                                frame.initialLoad();
                                //frame.$('button[name="btnPrintID"]').click();
                            } else {
                                var gridRow;
                                var arrData = [];
                                var strRowIDs = $("#tblAlumniInformationList").jqGrid('getGridParam', 'selarrrow');
                                var arrRowIDs = $.trim(strRowIDs.toString()).split(',');
                                arrRowIDs.sort(function (a, b) {
                                    return a - b;
                                });
                                var strRowID;
                                if ($.trim(strRowIDs) === "") {
                                    $(this).dialog('destroy').remove();
                                    swal("System Message", "No Item selected.", 'warning');
                                    return;
                                }
                                var emp_ids = "'0'";
                                for (var i = 0; i < arrRowIDs.length; i++) {

                                    strRowID = arrRowIDs[i];
                                    gridRow = $("#tblAlumniInformationList").getRowData(strRowID);
                                    var arrValItem = {};
                                    var isFlag = true;
                                    $.each(gridRow, function (k, v) {
                                        arrValItem[k] = v;
                                        if (k == "FLAG") {
                                            if (v == "Delete") {
                                                isFlag = false;
                                            }
                                        }
                                    });
                                    if (isFlag) {
                                        arrData.push(arrValItem);
                                        emp_ids = emp_ids + ",'" + gridRow["emp_id"] + "'";
                                    }


                                }
                                frame.employeeData = emp_ids.substring(1, emp_ids.length - 1); //arrData;
                                frame.initialLoad();
//                                frame.$('button[name="btnPrintID"]').click();
                            }


//                            frame.$('button[name="btnPrintID"]').click();

                        });
                        $(this).focus();
                    },
                    close: function () {
                        //loadList('tblAlumniInformationList', 'pgAlumniInformationList');
                        $(this).dialog('destroy').remove();
                    }
                }).width(dwidth - horizontalPadding).height(dheight - verticalPadding);
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
            width: $(window).width() - 180,
            //width: 1300,
            height: $(window).height() - 20,
            modal: true,
            open: function (event) {

//                $('div[role="dialog"][aria-labelledby$="alumniprofile_dialog"]').css('z-index', parseInt($('#header  .navbar').css('z-index')) + 30);

                clickLabel();
//                $(this).dialog('option', 'position', ['middle', 200]);
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
                $('div[id="alumniprofile_dialog"] input,select,textarea:not(input[id$="isactive"],#txtSearchAlumni)').map(function (index, elem) {
                    $(elem).bind("keyup", function (event) {
                        $(this).attr('title', $(this).val());
                    });
                });
                //End of Reattach title if field has changes.
                if (data == null) {
//                    $('div[id="alumniprofile_dialog"] input,select,textarea:not(input[id$="isactive"],#txtSearchAlumni)').val('');
//                    $('div[id="alumniprofile_dialog"] select,input:not(input[id="txtemp_id"],input[id$="isactive"],#txtSearchAlumni)').removeAttr('disabled').removeAttr('readonly');
//                    removeAttachement(event);
                    $('input[name="ID"]').val("");
                    $('input[name="ID"]').attr('title', 'Click To Generate New ID Number');
                    $('input[name="ID"]').css('cursor', 'pointer').css('background-color', '#B5CAFB');
//
//
//                    LoadPersonInfoImageSettingsSign('tblImageSettingsSign', 'pgImageSettingsSign');
//                    LoadPersonInfoImageSettings('tblImageSettings', 'pgImageSettings');
                    GlobalIDDataSeledted = null;
                    //generating auto number  
                    $('#btnPrintPreviewID').attr('disabled', true);


                    $('input[name="ID"]').unbind();
                    $('input[name="ID"]').bind("click", function (index, elem) {
                        //Events in Manipulating Other Civil Status
                        var yeargraduate = prompt("Enter Year Graduated", '0000');
                        if (yeargraduate.length == 4 && parseInt(yeargraduate) < 10000) {

                        } else {
                            swal("System Message", "Invalid Year Entry.Required Entry[YYYY], Sample Input [" + new Date().getFullYear() + "]", 'warning');
                            return;
                        }
                        //console.log(yeargraduate);
                        animation(1);
                        var newIDGen = yeargraduate + '-' + pad(Math.floor(Math.random() * 9999), 4) + '-' + Math.floor(Math.random() * 9);
                        GenerateNewID(newIDGen);
//                    $('input[name="ID"]').val(newIDGen);
                    });
                    $('input[name="ID"]').keyup(event, function () {
                        if ($('input[name="ID"]').val().length == 11) {
                            $('input[name="ID"]').val($(this).val());
                        } else {
                            $('input[name="ID"]').val("");
                        }

                    });
                    //end of generating autonumber
                    GetDetailList(null);
                } else {
                    GlobalIDDataSeledted = data;
                    $('input[name="ID"]').attr('title', '');
                    $('input[name="ID"]').css('cursor', 'auto').css('background-color', 'transparent');
                    GetDetailList(data["emp_id"]);
                    $('#btnPrintPreviewID').attr('disabled', false);
                }
                $('#txtworkstatus').attr('readonly', true).attr('disabled', true);
                //$('div[aria-labelledby$="alumniprofile_dialog"] div[class="panel-body"] div:not(div[id="divPicImageThumb"])').css({"padding": "0px", "padding-left": "5px"});
                $('.input-group-addon').css({"text-align": "left"});
                //:::::::::::::::::::::::::::::::::::::::::
                //Events in Manipulating Other Civil Status
                $('#txtstatus').unbind();
                $('#txtstatus').bind("change", function (index, elem) {
                    //Events in Manipulating Other Civil Status
                    funcChangeCivilStatusOther();
                });
                $('#cbocitizenship').unbind();
                $('#cbocitizenship').bind("change", function (index, elem) {
                    //Events in Manipulating Other Citizenship      
                    funcChangeCitizenshipOther();
                });
                // End of Events in Manipulating Other Civil Status
                // div class="popover-content" idpopover contentpredefined
                $('#idpopover').popover();
                $('#idpopover').bind("click", function (ev) {
                    $('div[class="popover-content"]').contents().remove();
                    var strContent = '<button type="button" onclick="FileBrowser(event);" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" style="width: 100%;">Browse From File</button><button type="button"  onclick="BrowseFromCamera(event);" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" style="margin-top: 1%; width: 100%; ">Browse From Camera</button>';
                    $('div[class="popover-content"]').append(strContent);
                    $('div[class="popover-content"]').css({'padding': '5px', 'padding-top': '0px'});
                    strContent = ' <h3 class="popover-title" style="    border-bottom: 1px solid #ebebeb;margin-bottom: 5px;line-height: 10px;">Browse Signature</h3><button type="button" onclick="FileBrowserSignature(event);" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" style="width: 100%;">Browse From File</button><button type="button"  onclick="BrowseFromDevice(event);" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" style="margin-top: 1%; width: 100%; ">Browse From Device</button>';
                    $('div[class="popover-content"]').append(strContent);
                });
                //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//                //ID PREVIEW SETUP INITIAL VALUES
//                LoadDivPrintIDContainer(data);
//                funcIDSetupIniatialID(data);
//                //END OF ID PREVIEW

            },
            close: function (event) {

            }
        });
//        $('#' + div).show();
        $('#' + div).dialog("open");
    }
    //function GetDetails
    function GetDetailList(recid, type) {
         LoadValuesOptionFromDB('txtdesignation','loadCourseList','shortdesc','shortdesc');
        var objectval = [];
                var objectcaption = [];
                $('#txtcategory option').map(function (index, elem) {
                    objectval.push($(elem).val());
                    objectcaption.push($(elem).text());
                });
                loadComboxBoxStaticOption('txtcategory', objectval, objectcaption);
                 objectval = [];
                 objectcaption = [];
                $('#txtdesignation option').map(function (index, elem) {
                    objectval.push($(elem).val());
                    objectcaption.push($(elem).text());
                });
                loadComboxBoxStaticOption('txtdesignation', objectval, objectcaption);
                $('input[id="custom-combobox-input-txtcategory"]').css('width', '186px');
                $('input[id="custom-combobox-input-txtdesignation"]').css('width', '186px');
        $.ajax({
            url: "../../../models/mod.cjc.alumnirecord.php",
            data: {
                ACTION: "GetDetailList",
                GETPARAM: {
                    recid: recid,
                    type: type
                }
            },
            dataType: 'json',
            async: false,
            success: function (jsonReturn) {
                $.each(jsonReturn, function (index, value) {
                    if (index == 0) {//get first Record Only
//                    var options = "<option value='" + value['person_code'] + "' >" + pad(value['person_code'], 6) + " - " + value['EmployeeName'] + "</option>";
//                    $('#' + strCboType).append(options);
                        var inputs = $('div[id="alumniprofile_dialog"] input:not(input[id$="isactive"],input[id$="isforprint"],#txtSearchEmployee),div[id="alumniprofile_dialog"] select,div[id="alumniprofile_dialog"] textarea');
                        $.each(inputs, function (k, v) {
                            var type__ = $(v).attr('type');
                            var name = $.trim($(v).attr('id'));
//                        console.log(type__, name);
                            if (type__ != null) {
                                if (type__.match(/checkbox/ig) != null) {
                                    name = name.replace(/chk/ig, '');
                                    $(v).attr('checked', parseInt(value[name]) == 1);
                                    if (name.match(/IsSexMale/ig) != null) {
                                        $(v).attr('checked', parseInt(value['gender']) == 1);
                                    }
                                    if (name.match(/IsSexFemale/ig) != null) {
                                        $(v).attr('checked', parseInt(value['gender']) == 0);
                                    }
                                } else {
                                    name = name.replace(/txt/ig, '');
                                    $(v).val(value[name]);
                                    $(v).attr('title', value[name]);
                                }
                            } else {
                                name = name.replace(/txt/ig, '');
                                $(v).val(value[name]);
                                $(v).attr('title', value[name]);
                            }
                            if (name.match(/cbo/ig) != null) {
                                name = name.replace(/cbo/ig, '');
                                $(v).val(value[name]);
                                $(v).attr('title', value[name]);
                            }
                        });
                        $('#lblNoOfAge').html(value["Age"]);
                        if (value["Sex"] == 'Male') {
                            $('#chkIsSexMale').attr('checked', true);
                            $('#chkIsSexFemale').attr('checked', false);
                        } else if (value["Sex"] == 'Female') {
                            $('#chkIsSexMale').attr('checked', false);
                            $('#chkIsSexFemale').attr('checked', true);
                        } else {
                            $('#chkIsSexMale').attr('checked', true);
                            $('#chkIsSexFemale').attr('checked', false);
                        }
                        $('#chkisforprint').attr('checked', parseInt(value["isforprint"]) == 1);

                        //function for select tags change
                        funcChangeCivilStatusOther();
                        funcChangeCitizenshipOther();
                        //end of function select tags change
                        $(inputs).attr('readonly', true).attr('disabled', true);
                        $('textarea').removeAttr('disabled');
                        $("#alumniprofile_dialog #imgempPic").removeAttr('src');
                        if (file_exists("../../../documents/AlumniPictures/" + value["emp_id"] + ".png")) {
                            $("#alumniprofile_dialog #imgempPic").attr("src", '../../../documents/AlumniPictures/' + value["emp_id"] + ".png" + "?time=" + new Date());
                        } else {
                            //Picture not exist.
                            if (file_exists("../../../documents/AlumniPictures/" + $("#txtemp_id").val() + ".png")) {
                                $("#alumniprofile_dialog #imgempPic").attr("src", '../../../documents/AlumniPictures/' + value["emp_id"] + ".png" + "?time=" + new Date());
                            } else {
                                $("#alumniprofile_dialog #imgempPic").attr("src", '../../../documents/AlumniPictures/nopic.png' + "?time=" + new Date());
                            }
                        }



                        $('div[id="alumniprofile_dialog"] select,input:not(input[id="txtemp_id"],input[id$="isforprint"],input[id$="isactive"],#txtSearchEmployee)').removeAttr('disabled').removeAttr('readonly');
                        LoadPersonInfoImageSettingsSign('tblImageSettingsSign', 'pgImageSettingsSign');
                        LoadPersonInfoImageSettings('tblImageSettings', 'pgImageSettings');

                         $('input[id="custom-combobox-input-txtcategory"]').val(value["category"]);
                        $('input[id="custom-combobox-input-txtdesignation"]').val(value["designation"]);
                    }
                });
                //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                //ID PREVIEW SETUP INITIAL VALUES
                LoadDivPrintIDContainer(jsonReturn[0]);
                funcIDSetupIniatialID(jsonReturn[0]);
                //END OF ID PREVIEW
            }

        });
        if (recid == null) {
            $('input[name="ID"]').attr('disabled', false).attr('readonly', false).attr('title', 'Click to Generated New ID');
            $('#chkisforprint').attr('checked', false);
        }

    }

    function GenerateNewID(idgen) {
        $.ajax({
            url: "../../../models/mod.cjc.alumnirecord.php?ACTION=generatenewid",
            type: "POST",
            async: false,
            data: {
                POSTPARAM: {
                    idnum: idgen
                }
            },
            success: function (valret) {

                if (valret !== "") {
                    animation(0);
                    if (valret == "none") {
                        $('input[name="ID"]').val(idgen);
                        $('input[name="ID"]').attr('readonly', true);
                        $('#txtbatch').val(idgen.substr(0, 4));
                    } else {
                        $('input[name="ID"]').val('');
                        $('#txtbatch').val('');
                        swal("System Message", "Generated ID already exist. Try to generate new ID again.", 'warning');

                    }
                } else {
                    animation(0);
                    $('input[name="ID"]').val('');
                }

            }
        });
    }
    //function ID Setup initial values;
    function funcIDSetupIniatialID(data) {
//        console.log(data['mname']);
//       debugger;
//    

        //Front Populate .html(data['lname'].toString().toUpperCase() + ', '  + data['fname'].toString().toUpperCase().capitalizeFirst() +'<br>'+($.trim(data['mname']) == "." ? "" : data['mname'].toString().toUpperCase().slice(0, 1) + ".") + "" ;
        $('div[id="emp_batch"] span').text('Batch: ' + $.trim(data['batch']));
        $('div[id="emp_name"] span').html(data['lname'].toString().toUpperCase().split(' ').join(' ') + ', ' + data['fname'].toString().toUpperCase().capitalizeFirst() + '<br style="content: &quot;&quot;;margin: -3px; display: block;">' + ($.trim(data['mname']) == "." ? "" : data['mname'].toString().toUpperCase()) + "");//.text(data['fname'].toString().toUpperCase() + ' ' + ($.trim(data['mname']) == "." ? "" : data['mname'].toString().toUpperCase().slice(0, 1) + ".") + ' ' + data['lname'].toString().toUpperCase());
        $('div[id="emp_id"] span').text($.trim(data['emp_id']));
        $('div[id="emp_position"] span').text(data['designation']);
        $('div[id="emp_idtype"] span').text(data['category']);
//        $('div[id="emp_president"] span').text('BR. ELLAKIM P. SOSMEÑA, S.C.');
//        $('div[id="emp_president"] span').text('PRESIDENT');

        $('img[id="barcode"]').map(function (index, elem) {
            $(elem).JsBarcode(data["emp_id"], {width: 1, height: 50, displayValue: false, fontSize: 14, format: 'CODE39', font: "Arial,sans-serif"});
            $(elem).css({"width": "240px", "height": "40px"});
        });
        if (file_exists("../../../documents/AlumniPictures/" + $("#txtemp_id").val() + ".png")) {
            $('#emp_pic img').attr('src', '../../../documents/AlumniPictures/' + data["emp_id"] + '.png' + "?time=" + new Date());
        } else {
            //Picture not exist.
            $('#emp_pic img').attr("src", '../../../documents/AlumniPictures/nopic.png' + "?time=" + new Date());
        }
        if (file_exists("../../../documents/AlumniSignature/" + data["emp_id"] + ".png")) {
            $('#emp_signature img').attr("src", '../../../documents/AlumniSignature/' + data["emp_id"] + ".png" + "?time=" + new Date());
        } else {
            //Picture not exist.
            $('#emp_signature img').attr("src", '../../../documents/AlumniSignature/nopic.png' + "?time=" + new Date());
        }

        //Back ID Populate
        $('div[id="s_SSS"] span').text(data['sssgsisno']);
        $('div[id="s_tinno"] span').text(data['tinno']);
        $('div[id="s_philhealth"] span').text(data['philno']);
        $('div[id="s_birthdate"] span').text(data['birthdatevalue']);
        $('div[id="p_civil"] span').text(data['status']);
        $('div[id="s_mother"] span').text($.trim(data['contact_guardian']).toUpperCase());
        $('div[id="p_address"] span').text(data['contact_address']);
        $('div[id="p_cellno"] span').text(data['contactno']);
        try {
            $('img').map(function (index, elem) {
                var srcval = $(elem).attr('src');
                var newSrc = srcval.split('?')[0];
                // console.log(elem);
                if ($(elem).attr('id') == "barcode") {
                } else {
                    $(elem).attr('src', newSrc + '?' + new Date());
                }
            });
        } catch (err) {
            console.log(err);
        }
//        $('div[id^="emp_name"]').map(function (index, elem) {
//            //console.log($(elem).find('span').text());
//            if ($.trim($(elem).find('span').text()).length > 30) {
//                fitTextInBox(elem);
//            }
//        });
//        $('div[id^="s_mother"]').map(function (index, elem) {
//            //console.log($(elem).find('span').text());
//            if ($.trim($(elem).find('span').text()).length > 30) {
//                fitTextInBox(elem);
//            }
//
//        });
    }
    //ENd of id setup initial values
    //Function for civilstatusother and citizenshipother select tags

    function funcChangeCivilStatusOther() {
        if ($.trim($('#txtstatus').val()) == "Others") {
            $('#idDivOriginalCivilStatus').removeClass('col-xs-6');
            $('#idDivOriginalCivilStatus').addClass('col-xs-5');
            $('#idDivOtherCivilStatus').css({"display": ""});
            $('#txtcivilstatusother').focus();
        } else {
            $('#idDivOriginalCivilStatus').removeClass('col-xs-5');
            $('#idDivOriginalCivilStatus').addClass('col-xs-6');
            $('#idDivOtherCivilStatus').css({"display": "none"});
        }
        $('#txtstatus').attr('title', $.trim($('#txtstatus').val()));
    }
    function funcChangeCitizenshipOther() {
        if ($.trim($('#cbocitizenship').val()) == "Others") {
            $('#idDivOriginalCitizenship').removeClass('col-xs-6');
            $('#idDivOriginalCitizenship').addClass('col-xs-5');
            $('#idDivOtherCitizenship').css({"display": ""});
            $('#txtcitizenshipother').focus();
        } else {
            $('#idDivOriginalCitizenship').removeClass('col-xs-5');
            $('#idDivOriginalCitizenship').addClass('col-xs-6');
            $('#idDivOtherCitizenship').css({"display": "none"});
        }
        $('#cbocitizenship').attr('title', $.trim($('#cbocitizenship').val()));
    }
    //End of function civilstatusother and citizenshipother select tags
    function saveAlumniInformationList(event) {
        if (event.ctrlKey) {
            return;
        }
        //        debugger;
        //validate required fields first
        if ($.trim($('#txtemp_id').val()) == "" || $.trim($('#txtlname').val()) == "" || $.trim($('#txtfname').val()) == "" || $.trim($('#txtmname').val()) == ""
                || $.trim($('#txtbirthdate').val()) == "") {
            $('input[id="btnSubmitSaveConfirmation"]').click();
            return;
        }

        //validate for birthdate field  and datehired field
        if ($.trim($('#txtbirthdate').val()) !== "") {
            var txtFieldval = $.trim($('#txtbirthdate').val());
            var arrField = txtFieldval.split('-');
            if (arrField.length == 3) {
                if ($.trim(arrField[0]) !== '' && $.trim(arrField[1]) !== '' && $.trim(arrField[2]) !== '') {
                } else {
                    $('#txtbirthdate').val('');
                    $('input[id="btnSubmitSaveConfirmation"]').click();
                    return;
                }
            } else {
                $('#txtbirthdate').val('');
                $('input[id="btnSubmitSaveConfirmation"]').click();
                return;
            }
        }

        //end of required fields validation of txtbirthdate and datehired field



        $(".browserjqgrid").remove();

//
//////#2 tblImageSettings Grid Values
//        arrDataRow = $('#tblImageSettings').jqGrid('getDataIDs');
//        var arrImageSettingsItem = [];
//        arrDataRow = $('#tblImageSettings').jqGrid('getDataIDs');
//        for (var i = 0; i < arrDataRow.length; i++) {
//
//            gridRow = $("#tblImageSettings").getRowData(arrDataRow[i]);
//            var arrValItem = {};
//            $.each(gridRow, function (k, v) {
//                arrValItem[k] = v;
//            });
//            arrImageSettingsItem.push(arrValItem);
//        }
//////#2
//
//////#3 tblEducationalBackground Grid Values
//        arrDataRow = $('#tblEducationalBackground').jqGrid('getDataIDs');
//        var arrEducationalBackgroundItem = [];
//        arrDataRow = $('#tblEducationalBackground').jqGrid('getDataIDs');
//        for (var i = 0; i < arrDataRow.length; i++) {
//
//            gridRow = $("#tblEducationalBackground").getRowData(arrDataRow[i]);
//            var arrValItem = {};
//            $.each(gridRow, function (k, v) {
//                arrValItem[k] = v;
//            });
//            arrEducationalBackgroundItem.push(arrValItem);
//        }
//////#3



        var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATECONFIRMATION'><?= $LBL_SAVEUPDATECONFIRMATION ?></label>";
        msgBox(message, "Confirmation", "ask", "Yes|No", 300, 250, function (dlgvalue) {
            clickLabel();
            if (dlgvalue == 1) {
                animation(1);
                $.ajax({
                    url: "../../../models/mod.cjc.alumnirecord.php?ACTION=saveAlumniInformation",
                    type: "POST",
                    data: {
                        POSTPARAM: {
                            idnum: $('#txtidnum').val(),
                            emp_id: $('#txtemp_id').val(),
                            lname: $('#txtlname').val(),
                            fname: $('#txtfname').val(),
                            mname: $('#txtmname').val(),
                            nameext: $('#txtnameext').val(),
                            designation: $('input[id="custom-combobox-input-txtdesignation"]').val(),//$('#txtdesignation').val(),
                            birthdate: $('#txtbirthdate').val(),
                            contact_guardian: $('#txtcontact_guardian').val(),
                            contact_relation: $('#txtcontact_relation').val(),
                            contact_address: $('#txtcontact_address').val(),
                            contactno: $('#txtcontactno').val(),
                            sex: ($("#chkIsSexMale").is(":checked") ? 1 : 0),
                            sssgsisno: $('#txtsssgsisno').val(),
                            tinno: $('#txttinno').val(),
                            philno: $('#txtphilno').val(),
                            status: $('#txtstatus').val(),
                            category:$('input[id="custom-combobox-input-txtcategory"]').val(),// $('#txtcategory').val(),
                            pagibigno: $('#txtpagibigno').val(),
                            printinghistory: $.trim($('#txtprintinghistory').val()),
                            isforprint: ($("#chkisforprint").is(":checked") ? 1 : 0),
                            batch: $('#txtbatch').val()

                        }
                    },
                    success: function (emp_id) {

                        if (emp_id !== "") {
                            var data = new FormData();
                            var img1 = document.getElementById("imgFilechooser1").files[0];
                            var img2 = document.getElementById("imgFilechooser2").files[0];
                            data.append('binImage1', img1);
                            data.append('binImage2', img2);
                            data.append('POSTPARAM[uploadID]', emp_id);
                            $.ajax({
                                url: '../../../models/mod.cjc.alumnirecord.php?ACTION=uploadImage',
                                data: data,
                                cache: false,
                                contentType: false,
                                processData: false,
                                type: 'POST',
                                success: function (data) {
                                    var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATESUCCESS'><?= $LBL_SAVEUPDATESUCCESS ?></label>";
                                    msgBox(message, "Success", "success", "OK", 300, 250, function (dlgvalue) {
                                        $('#txtidnum').val(pad(emp_id, 1));
                                        //LoadAlumniInformationListDetails('');
//                                        $('button[name="btnCancel"]').click();
//                                        reloadtblAlumniInformationList();
//                                        loadImagesPictures('tblImageSettings');
                                        //                                        loadImagesSignature('tblImageSettingsSign');
                                        GetDetailList(emp_id, 'idnum');
//                                        if (file_exists("../../../documents/AlumniPictures/" + $("#txtemp_id").val() + ".png")) {
//                                            $("#alumniprofile_dialog #imgempPic").attr("src", '../../../documents/AlumniPictures/' + $("#txtemp_id").val() + ".png" + "?time=" + new Date());
//                                        } else {
//                                            $("#alumniprofile_dialog #imgempPic").attr("src", '../../../documents/AlumniPictures/nopic.png' + "?time=" + new Date());
                                        //                                        }
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
                            });
                        } else {
                            console.log(emp_id);
                            var message = "<label id='<?= $strModuleName ?>-LBL_SAVEUPDATEERROR'><?= $LBL_SAVEUPDATEERROR ?></label>";
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

    ////#2 Family Background function
    function LoadPersonInfoImageSettings(Grid, pgGrid) {

        $("#" + Grid).jqGrid('GridUnload');
        $("#" + Grid).jqGrid({
            url: "../../../models/mod.cjc.alumnirecord.php",
            datatype: "json",
            mtype: 'GET',
            postData: {
                ACTION: 'GetImagePictures',
                GETPARAM: {
                    emp_id: $('input[id="txtemp_id"]').val()
                },
                TYPE: 1
            },
            colModel: [
                {
                    name: 'imgID',
                    index: 'imgID',
                    hidden: true
                },
                {
                    name: 'emp_id',
                    index: 'emp_id',
                    hidden: true
                },
                {
                    name: 'Filename',
                    index: 'Filename',
                    hidden: false
                },
                {
                    name: 'photopic',
                    index: 'photopic',
                    hidden: false,
                    width: 125,
                    formatter: function (cellvalue, options, rowObject) {
                        var imgSrc = '';
                        if (file_exists("../../../documents/AlumniPictures/" + rowObject["Filename"] + "")) {
                            imgSrc = '../../../documents/AlumniPictures/' + rowObject["Filename"] + '?' + new Date();
                        } else {
                            imgSrc = '../../../documents/AlumniPictures/nopic.png?' + new Date();
                        }
                        return '<img id = "imgemployeeImageGrid-' + rowObject["Filename"] + '" ' +
                                'src = "' + imgSrc + '"' +
                                'style ="width:100px; vertical-align: middle;max-width: 100px;max-height: 100px;height:100px;width:100px;" ' +
                                '</img>';
                    },
                    align: "center",
                    label: 'Photo'
                },
                {
                    name: 'isactive',
                    index: 'isactive',
                    label: 'Active',
                    align: "center",
                    width: 50,
                    edittype: 'checkbox',
                    hidden: false,
                    editoptions: {
                        value: '1:0'
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "isactive";
                        var chkValue = (cellvalue === '1' || rowObject.FLAG === 'New' ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox" ' + chkValue + ' style="height: 18px;width:18px;" onclick="checkIsActivePicture(\'#' + Grid + '\',\'' + options.rowId + '\',\'' + chkID + '\')" />';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return ($(cell).find('input').is(":checked") ? 1 : 0);
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
            sortname: 'imgID',
            width: '450px',
            height: '200px',
            shrinkToFit: true,
            multiselect: false,
            multiboxonly: true,
            autowidth: true,
            viewrecords: true,
            footerrow: false,
            cellEdit: false,
            userDataOnFooter: false,
            jsonReader: {
                repeatitems: false
            },
            beforeProcessing: function (data, status, xhr) {
                //                summarySQL = data.sql;
            },
            ondblClickRow: function (rowid, iRow, iCol, rowObject) {

            },
            cellsubmit: 'clientArray',
            onSelectCell: function (rowid, cellname, value, iRow, iCol) {
            },
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

            }
        });
        $("#" + Grid).jqGrid('navGrid', '#' + pgGrid, {edit: false, add: false, del: false, search: false, refresh: false});
//        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
//            buttonicon: "ui-icon-plusthick",
//            caption: '',
//            title: 'Add Educational Background',
//            onClickButton: function (e) {
//                addPersonInfoRecord(Grid);
//            }
//        });
//        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
//            buttonicon: "ui-icon-minusthick",
//            caption: '',
//            title: 'Remove Educational Background',
//            onClickButton: function (e) {
//                deletePersonInfoRecord(Grid);
//            }
        //        });
        clickLabel();

    }
    function reLoadPersonInfoImageSettings() {
        $("#tblImageSettings").setGridParam({
            postData: {
                ACTION: 'GetChildrenList',
                GETPARAM: {
                    EMPID: parseInt($('input[id*="txtemp_id"]').val())
                },
                TYPE: 1
            }
        }).trigger("reloadGrid");
    }

    function LoadPersonInfoImageSettingsSign(Grid, pgGrid) {

        $("#" + Grid).jqGrid('GridUnload');
        $("#" + Grid).jqGrid({
            url: "../../../models/mod.cjc.alumnirecord.php",
            datatype: "json",
            mtype: 'GET',
            postData: {
                ACTION: 'GetImageSignature',
                GETPARAM: {
                    emp_id: $('input[id="txtemp_id"]').val()
                },
                TYPE: 1
            },
            colModel: [
                {
                    name: 'imgID',
                    index: 'imgID',
                    hidden: true
                },
                {
                    name: 'emp_id',
                    index: 'emp_id',
                    hidden: true
                },
                {
                    name: 'Filename',
                    index: 'Filename',
                    hidden: false
                },
                {
                    name: 'photopic',
                    index: 'photopic',
                    hidden: false,
                    width: 225,
                    formatter: function (cellvalue, options, rowObject) {
                        var imgSrc = '';
                        if (file_exists("../../../documents/AlumniSignature/" + rowObject["Filename"])) {
                            imgSrc = '../../../documents/AlumniSignature/' + rowObject["Filename"] + '?' + new Date();

                        } else {
                            imgSrc = '../../../documents/AlumniSignature/nopic.png?' + new Date();
                        }
                        return '<img id = "imgemployeeImageGrid-' + rowObject.emp_id + '" ' +
                                'src = "' + imgSrc + '"' +
                                'style ="width:160px; vertical-align: middle;max-width: 160px;max-height: 35px;height:35px;width:160px;" ' +
                                '</img>';
                    },
                    align: "center",
                    label: 'Signature'
                },
                {
                    name: 'isactive',
                    index: 'isactive',
                    label: 'Active',
                    align: "center",
                    width: 50,
                    edittype: 'checkbox',
                    hidden: false,
                    editoptions: {
                        value: '1:0'
                    },
                    formatter: function (cellvalue, options, rowObject) {
                        var chkID = "Row" + options.rowId + "isactive";
                        var chkValue = (cellvalue === '1' || rowObject.FLAG === 'New' ? "checked='checked'" : "");
                        return '<input id="' + chkID + '" type="checkbox" ' + chkValue + ' style="height: 18px;width:18px;" onclick="checkIsActiveSignature(\'#' + Grid + '\',\'' + options.rowId + '\',\'' + chkID + '\')" />';
                    },
                    unformat: function (cellvalue, options, cell) {
                        return ($(cell).find('input').is(":checked") ? 1 : 0);
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
            sortname: 'imgID',
            width: '450px',
            height: '200px',
            shrinkToFit: true,
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
            cellsubmit: 'clientArray',
            onSelectCell: function (rowid, cellname, value, iRow, iCol) {
            },
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
                $('#divPictureTbl div').map(function (index, elem) {
                    // console.log($(elem).css('width'));
                    if (parseInt($(elem).css('width')) > 1000) {
                        $(elem).css('width', 'auto');
                    }

                });
            }
        });
        $("#" + Grid).jqGrid('navGrid', '#' + pgGrid, {edit: false, add: false, del: false, search: false, refresh: false});
//        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
//            buttonicon: "ui-icon-plusthick",
//            caption: '',
//            title: 'Add Educational Background',
//            onClickButton: function (e) {
//                addPersonInfoRecord(Grid);
//            }
//        });
//        $("#" + Grid).jqGrid('navButtonAdd', '#' + pgGrid, {
//            buttonicon: "ui-icon-minusthick",
//            caption: '',
//            title: 'Remove Educational Background',
//            onClickButton: function (e) {
//                deletePersonInfoRecord(Grid);
//            }
        //        });
        clickLabel();


    }

    function reLoadPersonInfoImageSettingsSign() {
        $("#tblImageSettingsSign").setGridParam({
            postData: {
                ACTION: 'GetChildrenList',
                GETPARAM: {
                    EMPID: parseInt($('input[id*="txtemp_id"]').val())
                },
                TYPE: 1
            }
        }).trigger("reloadGrid");
    }
    //#2 End Family Background function
    //Function Browsers & Commands
    //:::::::::::::::::::::::::::::::::
    function addPersonInfoRecord(Grid) {

        var newRow = [{
                ID: getGridNewID(Grid),
                FLAG: "New"
            }];
        jQuery("#" + Grid).addRowData("ID", newRow, 'bottom');
    }
    function deletePersonInfoRecord(Grid) {

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
    function filtersearchpicture(Grid, fieldtype, iswithpic, display) {
        var arrDataRow = $("#" + Grid).jqGrid('getDataIDs');
        var gridRow;

        arrDataRow = $("#" + Grid).jqGrid('getDataIDs');
        var arremployeelistItem = [];
        arrDataRow = $("#" + Grid).jqGrid('getDataIDs');
        var gridIDseleted = [];
        for (var i = 0; i < arrDataRow.length; i++) {
            gridRow = $("#" + Grid).getRowData(arrDataRow[i]);
            var arrValItem = {};
            $.each(gridRow, function (k, v) {
                if (k == fieldtype) {
                    // console.log(k, v, v.split('nopic.png').length);
                    if (iswithpic) {
                        if (v.split('nopic.png').length == 1) {
                            arrValItem[k] = v;
                            gridIDseleted.push(arrDataRow[i]);
                        }
                    } else {
                        if (v.split('nopic.png').length == 2) {
                            arrValItem[k] = v;
                            gridIDseleted.push(arrDataRow[i]);
                        }
                    }

                }
                arrValItem[k] = v;
            });
            arremployeelistItem.push(arrValItem);
        }
        //console.log(arremployeelistItem, gridIDseleted);

        var strRowIDs = gridIDseleted;// $("#" + Grid).jqGrid('getGridParam', 'selarrrow');
        var arrRowIDs = $.trim(strRowIDs.toString()).split(',');
        var strRowID;
        if ($.trim(strRowIDs) === "") {
            return;
        }
        for (var i = 0; i < arrDataRow.length; i++) {
            strRowID = arrDataRow[i];
            var grid = $("#" + Grid);
            grid.jqGrid('setRowData', strRowID, {
                FLAG: 'show'
            });
            grid.jqGrid('saveRow', strRowID, false);
            //Hide the Row
            $("#" + strRowID, "#" + Grid).css({
                display: ''
            });
        }

        for (var i = 0; i < arrRowIDs.length; i++) {
            strRowID = arrRowIDs[i];
            var grid = $("#" + Grid);
            grid.jqGrid('setRowData', strRowID, {
                FLAG: display == 'none' ? 'Delete' : 'show'
            });
            grid.jqGrid('saveRow', strRowID, false);
            //Hide the Row
            $("#" + strRowID, "#" + Grid).css({
                display: display
            });
        }

    }

    function checkIsActivePicture(gridID, rowid, chkID) {
        var gridRowArr = $(gridID).getRowData(rowid);
        if ($.trim(gridRowArr["Filename"]) == $.trim(gridRowArr["emp_id"] + '.png')) {
            swal("System Message", "Selected Item already active.", 'warning');
            $(gridID + ' input[id="' + chkID + '"]').attr("checked", true);
            return;
        }
        msgBox("Do you want to set this Picture to Active?", "Confirm", 'ask', 'Yes|No', 0, 0, function (v) {
            if (v == 1) {
                changeFlag(gridID, rowid);
                var gridRow = $(gridID).getRowData(rowid);
                console.log(gridRow);
                $('table[id="tblImageSettings"] input[type="checkbox"]:not(#' + chkID + ')').attr('checked', false);
                var checked = $(gridID + ' input[id="' + chkID + '"]').is(":checked");
                $(gridID + ' input[id="' + chkID + '"]').attr("checked", true);

                //Renaming start here
                document.getElementById('img_filename').value = $('#txtemp_id').val() + '.png';
                document.getElementById('img_filenamenew').value = gridRow["Filename"];
                document.getElementById('img_foldername').value = 'AlumniPictures';

                var fd = new FormData(document.forms["frmPictures"]);
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    console.log('readyStatechange:  ' + xhr.readyState);
                    if (xhr.readyState > 2) {

                    }
                };


                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        //console.log(percentComplete + '% uploaded');
                        //                    console.log(e);
                        // alert('Change Success');
                        // $('#divPhotoSettings').data("photobooth").destroy();
                        //loadImagesPictures(gridID);

                    }
                };

                xhr.onload = function () {
                    LoadPersonInfoImageSettings('tblImageSettings', 'pgImageSettings');
                };
                xhr.open('POST', 'photobooth-js/photosaverename.php', true);
                xhr.send(fd);
            } else {
                return;
            }
        });
        var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
        $('div[id="___msgBox"]').css("height", "");


    }
    function checkIsActiveSignature(gridID, rowid, chkID) {
        var gridRowArr = $(gridID).getRowData(rowid);
        if ($.trim(gridRowArr["Filename"]) == $.trim(gridRowArr["emp_id"] + '.png')) {
            swal("System Message", "Selected Item already active.", 'warning');
            $(gridID + ' input[id="' + chkID + '"]').attr("checked", true);
            return;
        }
        msgBox("Do you want to set this Signature to  Active?", "Confirm", 'ask', 'Yes|No', 0, 0, function (v) {
            if (v == 1) {
                changeFlag(gridID, rowid);
                var gridRow = $(gridID).getRowData(rowid);
                console.log(gridRow);
                $('table[id="tblImageSettingsSign"] input[type="checkbox"]:not(#' + chkID + ')').attr('checked', false);
                var checked = $(gridID + ' input[id="' + chkID + '"]').is(":checked");
                $(gridID + ' input[id="' + chkID + '"]').attr("checked", true);

                //Renaming start here
                document.getElementById('img_filename').value = $('#txtemp_id').val() + '.png';
                document.getElementById('img_filenamenew').value = gridRow["Filename"];
                document.getElementById('img_foldername').value = 'AlumniSignature';

                var fd = new FormData(document.forms["frmPictures"]);
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    console.log('readyStatechange:  ' + xhr.readyState);
                    if (xhr.readyState > 2) {

                    }
                };


                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        //console.log(percentComplete + '% uploaded');
                        //                    console.log(e);
                        // alert('Change Success');
                        // $('#divPhotoSettings').data("photobooth").destroy();
                        //loadImagesPictures(gridID);

                    }
                };

                xhr.onload = function () {
                    LoadPersonInfoImageSettingsSign('tblImageSettingsSign', 'pgImageSettingsSign');
                };
                xhr.open('POST', 'photobooth-js/photosavesignaturerename.php', true);
                xhr.send(fd);
            } else {
                return;
            }
        });
        var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
        $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
        $('div[id="___msgBox"]').css("height", "");

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
        imgMain.src = '../../../models/mod.cjc.alumnirecord.php?ACTION=getImageOriginal&GETPARAM=' + strID;
        $("#" + imgProductMain).append(imgMain);
        $('img[id="imgempPic"]').css('height', '180px').css('width', '180px').addClass('img-polaroid');
        imgMain.onload = function () {
            imgWidth = imgMain.offsetWidth;
            imgHeight = imgMain.offsetHeight;
        };
    }
    function readURL(input, type) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            if (type == 1) {

                reader.onload = function (e) {
                    var imgWidth;
                    var imgHeight;
                    var imgAlumniThumb = "divPicImageThumb";
                    $("#" + imgAlumniThumb).contents().remove();
                    removeAttachement('');
                    var img = document.createElement('img');
                    img.id = 'imgempPic';
                    $(img).css('display:block');
                    img.src = e.target.result;
                    $("#" + imgAlumniThumb).append(img);
                    $('img[id="imgempPic"]').css('height', '180px').css('width', '180px').addClass('img-polaroid');
                    $('div[id="emp_pic"] img').attr('src', e.target.result);
                    img.onload = function () {
                        imgWidth = img.offsetWidth;
                        imgHeight = img.offsetHeight;
                    };
                };
            } else if (type == 2) {
                reader = new FileReader();
                reader.onload = function (e) {
                    var imgWidth;
                    var imgHeight;

                    var img = document.createElement('img');
                    //img.id = imgType;
                    //                    $(img).css('display:block');
                    img.src = e.target.result;
                    $('div[id="emp_signature"] img').attr('src', e.target.result);


                    img.onload = function () {
                        imgWidth = img.offsetWidth;
                        imgHeight = img.offsetHeight;
                    };
                };
            }
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
        var iftrue = true;
        $('button[id="idpopover"]').click();
        if ($('img[id="imgempPic"]').attr('src').split('nopic.png').length == 1) {
            msgBox("Do you want to replace Picture?", "Confirm", 'ask', 'Yes|No', 0, 0, function (v) {
                if (v == 1) {
                    //                    $('div[class^="popover"]').eq(0).css({'display': 'none'});                   
                    $('#imgFilechooser1').click();
                    iftrue = false;
                } else {
                    return;
                    iftrue = false;
                }
            });
            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
            $('div[id="___msgBox"]').css("height", "");
        }
        if (iftrue) {
            $('div[class^="popover"]').eq(0).css({'display': 'none'});
            $('#imgFilechooser1').click();
        }
    }
    function FileBrowserSignature(event) {
        if (event !== null) {
            if (event.ctrlKey) {
                return;
            }
        }
        var iftrue = true;
        $('button[id="idpopover"]').click();
        if ($('div[id="emp_signature"] img').attr('src').split('nopic.png').length == 1) {
            msgBox("Do you want to replace signature?", "Confirm", 'ask', 'Yes|No', 0, 0, function (v) {
                if (v == 1) {
//                    $('div[class^="popover"]').eq(0).css({'display': 'none'});

                    $('#imgFilechooser2').click();
                    iftrue = false;
                } else {
                    iftrue = false;
                    return;
                }
            });
            var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
            $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
            $('div[id="___msgBox"]').css("height", "");
        }
        if (iftrue) {
            $('div[class^="popover"]').eq(0).css({'display': 'none'});
            $('#imgFilechooser2').click();
        }

    }
    function removeAttachement(event) {
        if (event !== null) {
            if (event.ctrlKey) {
                return;
            }
        }

        if (file_exists("../../../documents/AlumniPictures/" + $("#txtemp_id").val() + ".jpg")) {
            msgBox("Are you sure to remove attachment?", "Confirm", 'ask', 'YES|NO', 0, 0, function (v) {
                if (v == 1) {
                    $.ajax({
                        url: '../../../models/mod.cjc.alumnirecord.php?ACTION=removeAttachment',
                        data: {
                            POSTPARAM: $('#txtemp_id').val()
                        },
                        type: 'POST',
                        dataType: 'json',
                        async: false,
                        success: function (data) {

                        }
                    });
                    $("#imgempPic").removeAttr('src');
                    $("#alumniprofile_dialog #imgempPic").attr("src", '../../../documents/AlumniPictures/nopic.png' + "?time=" + new Date());
                } else {
                    return;
                }
            });
        } else {
            $("#imgempPic").removeAttr('src');
            $("#alumniprofile_dialog #imgempPic").attr("src", '../../../documents/AlumniPictures/nopic.png' + "?time=" + new Date());
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
    String.prototype.capitalizeFirst = function () {
        return this.toLowerCase().replace(/\b\w/g, function (m) {
            return m.toUpperCase();
        });
    };
    //:::::::::::::::::::::::

    function LoadDivPrintIDContainer(data) {
        var strDivID = '\
      <div style="text-align:center;display:inline-block;" id="div_print_id">\n\
         <div style="width:auto;">\n\
               <div id="_front" style="display:inline-block;border-right:black solid thin;  padding: 10px 10px 30px 20px;">\n\
                  <div id="div_img_id_front" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width:' + data['idwidth'] + ';height:' + data['idheight'] + ';position:relative;float:left;">\n\
                      <img id="img_front" src="../../../../ID/documents/zzzIDSetupImage/Front' + data['setupid'] + '.png?' + new Date() + '" style="border-radius:5px;width:' + data['idwidth'] + ';height:' + data['idheight'] + ';" alt="Emp ID">\n\
                      <div id="emp_pic" style="width:' + data['picwidth'] + ';height:' + data['picheight'] + ';top:0px;position:absolute;margin-top: 81px;right: 8px;text-align: center;">\n\
                          <img src="../../../documents/AlumniPictures/1.png" style="width:' + data['picwidth'] + ';height:' + data['picheight'] + ';border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt="">\n\
                      </div> \n\
                      <div class="class_barcode" style="top:0px;position:absolute;font-weight: bold;text-align: center;width: 100%;top: 0px;/*left: 12px;*/-webkit-transform: scale(1,0.9081);"> \n\
                        <!-- <img id="barcode" style="width: auto;height:auto;"/>-->\n\
                          <img id="barcode" style="width: 180px;height:26px;"/>   \n\
                      </div> \n\
                     <div id="emp_batch" style="top: 0px; position: absolute; margin-top: 62px; font-weight: bold; margin-left: 0px; text-align: center; right: 1px; width: 42%; transform: scale(0.89051, 1.01357); left: -3px; box-sizing: initial;">\n\
                           <span style="font-size: 10px; box-sizing: initial;">Batch: 0000</span>\n\
                     </div> \n\
                      <div id="emp_name" style="top: 0px; position: absolute; margin-top: 95px; font-weight: bold; margin-left: 0px; text-align: left; right: 1px;/* width: 60%;*/ transform: scale(0.89051, 1.01357); left: 107px;"> \n\
                         <span style="font-size:10px;"></span>\n\
                       </div> \n\
                     <div id="emp_id" style="top: 0px; position: absolute; margin-top: 155px; font-weight: bold; text-align: left; left: 111px; width: 32%; font-size: 9px; transform: scale(0.757801,1.0102570);">\n\
                         <span style=" font-size: 11px;"></span> \n\
                     </div> \n\
                     <div id="emp_idtype" style="top: 0px; position: absolute; margin-top: 124px; font-weight: bold; text-align: left; left: 120px; font-size: 9px; width: 60%; transform: scale(1.00517, 1.01404);"> \n\
                         <span></span>\n\
                     </div> \n\
                     <div id="emp_position" style="top: 0px; position: absolute; margin-top: 108px; font-weight: bold; margin-left: 0px; text-align: left; right: 1px; width: 70%; transform: scale(0.89051, 1.01357); left: 107px;"> \n\
                         <span style="font-size:10px;" ></span>\n\
                     </div> \n\
                     <div id="emp_pressignature" style="display:none;top:0px;position:absolute;margin-top: 274px;/* margin-left: 83px; */text-align: center;width: 210px;">\n\
                         <img src="../../../documents/PresidentSignature/PresidentSignature.png" style="width: 128px;height: 20px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> \n\
                     </div> \n\
                     <div id="emp_presidentname" style="display:none;top:0px;position:absolute;margin-top: 293px;font-weight: bold;margin-left: 0px;text-align: center;width: 220px; -webkit-transform: scale(0.781,0.81570);">\n\
                          <span style="color:#3d0b0c;font-size: 12px;">BR. ELLAKIM P. SOSMEÑA, S.C.</span> \n\
                     </div> \n\
                     <div id="emp_president" style="display:none;top:0px;position:absolute;margin-top: 303px;font-weight: bold;text-align: center;width: 220px;-webkit-transform: scale(0.71,0.75);">\n\
                          <span style=" font-size: 11px; color: #3d0b0c; "> President</span>\n\
                     </div> \n\
                 </div>\n\
              </div>\n\
              <div id="_back" style="display: inline-block;    padding: 10px 0px 30px 10px;"> \n\
                 <div id="div_img_id_back" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width:' + data['idwidth'] + ';height:' + data['idheight'] + ';position:relative;float:right;"> \n\
                    <img id="img_back" src="../../../../ID/documents/zzzIDSetupImage/BACK' + data['setupid'] + '.png?' + new Date() + '" style="border-radius:5px;width:' + data['idwidth'] + ';height:' + data['idheight'] + ';" alt="Emp ID">\n\
                     <div id="s_SSS" style="position: absolute;top: 0;margin-top: 25px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175);font-weight: bold;"> <span></span></div>\n\
                     <div id="s_tinno" style="position: absolute;top: 0;margin-top: 45px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span></span></div>\n\
                     <div id="s_philhealth" style="position: absolute;top: 0;margin-top: 65px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span></span></div> \n\
                    <div id="s_birthdate" style="position: absolute;top: 0;margin-top: 85px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;">  <span></span></div>\n\
                     <div id="p_civil" style="position: absolute;top: 0;margin-top: 106px;left: 45px;font-size: 12px;width: 90%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span></span></div>\n\
                     <div id="s_mother" style="position: absolute;top: 0;margin-top: 146px;left: -10px;font-size: 12px;width: 110%;text-align: left;-webkit-transform: scale(0.81,0.9175); font-weight: bold;"> <span></span></div>\n\
                     <div id="p_address" style="position: absolute; top: 0;margin-top: 160px; left:-10px; font-size: 11px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold;"> <span></span></div>\n\
                     <div id="p_cellno" style="position: absolute; top: 0;margin-top: 202px; left: 45px; font-size: 12px; width: 90%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span> </span></div>\n\
                     <div id="emp_signature" style="width: 100%;position: relative;top: 0;margin-top: -60px;-webkit-transform: scale(0.91,0.975); font-weight: bold;">\n\
                         <img src="../../../documents/AlumniSignature/1.png?Thu Sep 03 2015 21:51:26 GMT-0700 (Pacific Daylight Time)" style="/*width: 160px;height: 35px;*/height:50px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> \n\
                     </div> \n\
                </div>\n\
             </div> \n\
          </div> \n\
      </div>';
        //        $('#divIDPreview').contents().remove();
        $('#divIDPreview div[id*="div_print_id"]').remove();
        $('#divIDPreview').append(strDivID);
        $('#divIDPreview div,#divIDPreview img,#divIDPreview span').map(function (index, elem) {
            $(elem).css({"-webkit-box-sizing:": "border-box", "-moz-box-sizing": "border-box", "box-sizing": "initial"})

        });
//        $('#div_img_id_front,#div_img_id_back').css({'width': '8.35cm', 'height': '5.34cm'});
//        $('#_front').css({'border-bottom': 'black solid thin', 'border-right': 'none', 'padding-top': '3px', 'padding-bottom': '3px', 'margin-right': '150px'});
//        $('#_back').css({'margin-right': '168px', 'display': '', 'padding-top': '3px'});
//        $('#img_front,#img_back').css({'width': '8.35cm', 'height': '5.3cm'});

        $('div[id^="emp_name"]').css({'text-align': 'left', 'left': '107px', 'width': '60%'});
        $('div[id^="emp_position"]').css({'text-align': 'left', 'width': '70%'});
        $('div[id^="emp_idtype"]').css({'text-align': 'left'});
        //setup id xy configuration
        //        console.log(data, data['frontpicturexy'].toString());
        var frontpicturexy = data['frontpicturexy'].toString().split(';');
        var arrp1 = frontpicturexy[0].split(':');
        var arrp2 = frontpicturexy[1].split(':');
        var arrp3 = frontpicturexy[2].split(':');
        $('div[id="emp_pic"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="emp_pic"] span').css(arrp3[0], arrp3[1]);



        var frontbatchxy = data['frontbatchxy'].toString().split(';');
        arrp1 = frontbatchxy[0].split(':');
        arrp2 = frontbatchxy[1].split(':');
        arrp3 = frontbatchxy[2].split(':');
        $('div[id="emp_batch"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="emp_batch"] span').css(arrp3[0], arrp3[1]);

        var frontnamexy = data['frontnamexy'].toString().split(';');
        arrp1 = frontnamexy[0].split(':');
        arrp2 = frontnamexy[1].split(':');
        arrp3 = frontnamexy[2].split(':');
        $('div[id="emp_name"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="emp_name"] span').css(arrp3[0], arrp3[1]);

        var frontdesignationxy = data['frontdesignationxy'].toString().split(';');
        arrp1 = frontdesignationxy[0].split(':');
        arrp2 = frontdesignationxy[1].split(':');
        arrp3 = frontdesignationxy[2].split(':');
        $('div[id="emp_position"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="emp_position"] span').css(arrp3[0], arrp3[1]);

        var frontidnumxy = data['frontidnumxy'].toString().split(';');
        arrp1 = frontidnumxy[0].split(':');
        arrp2 = frontidnumxy[1].split(':');
        arrp3 = frontidnumxy[2].split(':');
        $('div[id="emp_id"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="emp_id"] span').css(arrp3[0], arrp3[1]);

        var frontcategoryxy = data['frontcategoryxy'].toString().split(';');
        arrp1 = frontcategoryxy[0].split(':');
        arrp2 = frontcategoryxy[1].split(':');
        arrp3 = frontcategoryxy[2].split(':');
        $('div[id="emp_idtype"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="emp_idtype"] span').css(arrp3[0], arrp3[1]);

        var frontbarcodexy = data['frontbarcodexy'].toString().split(';');
        arrp1 = frontbarcodexy[0].split(':');
        arrp2 = frontbarcodexy[1].split(':');
        arrp3 = frontbarcodexy[2].split(':');
        $('div[class="class_barcode"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[class="class_barcode"] span').css(arrp3[0], arrp3[1]);


        var backsssgsisnoxy = data['backsssgsisnoxy'].toString().split(';');
        arrp1 = backsssgsisnoxy[0].split(':');
        arrp2 = backsssgsisnoxy[1].split(':');
        arrp3 = backsssgsisnoxy[2].split(':');
        $('div[id="s_SSS"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="s_SSS"] span').css(arrp3[0], arrp3[1]);


        var backtinxy = data['backtinxy'].toString().split(';');
        arrp1 = backtinxy[0].split(':');
        arrp2 = backtinxy[1].split(':');
        arrp3 = backtinxy[2].split(':');
        $('div[id="s_tinno"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="s_tinno"] span').css(arrp3[0], arrp3[1]);

        var backphihealthxy = data['backphihealthxy'].toString().split(';');
        arrp1 = backphihealthxy[0].split(':');
        arrp2 = backphihealthxy[1].split(':');
        arrp3 = backphihealthxy[2].split(':');
        $('div[id="s_philhealth"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="s_philhealth"] span').css(arrp3[0], arrp3[1]);

        var backdateofbirthxy = data['backdateofbirthxy'].toString().split(';');
        arrp1 = backdateofbirthxy[0].split(':');
        arrp2 = backdateofbirthxy[1].split(':');
        arrp3 = backdateofbirthxy[2].split(':');
        $('div[id="s_birthdate"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="s_birthdate"] span').css(arrp3[0], arrp3[1]);

        var backcivilstatusxy = data['backcivilstatusxy'].toString().split(';');
        arrp1 = backcivilstatusxy[0].split(':');
        arrp2 = backcivilstatusxy[1].split(':');
        arrp3 = backcivilstatusxy[2].split(':');
        $('div[id="p_civil"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="p_civil"] span').css(arrp3[0], arrp3[1]);

        var backguardiannamexy = data['backguardiannamexy'].toString().split(';');
        arrp1 = backguardiannamexy[0].split(':');
        arrp2 = backguardiannamexy[1].split(':');
        arrp3 = backguardiannamexy[2].split(':');
        $('div[id="s_mother"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="s_mother"] span').css(arrp3[0], arrp3[1]);

        var backguardianaddressxy = data['backguardianaddressxy'].toString().split(';');
        arrp1 = backguardianaddressxy[0].split(':');
        arrp2 = backguardianaddressxy[1].split(':');
        arrp3 = backguardianaddressxy[2].split(':');
        $('div[id="p_address"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="p_address"] span').css(arrp3[0], arrp3[1]);

        var backguardiantelnoxy = data['backguardiantelnoxy'].toString().split(';');
        arrp1 = backguardiantelnoxy[0].split(':');
        arrp2 = backguardiantelnoxy[1].split(':');
        arrp3 = backguardiantelnoxy[2].split(':');
        $('div[id="p_cellno"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="p_cellno"] span').css(arrp3[0], arrp3[1]);

        var backsignaturexy = data['backsignaturexy'].toString().split(';');
        arrp1 = backsignaturexy[0].split(':');
        arrp2 = backsignaturexy[1].split(':');
        arrp3 = backsignaturexy[2].split(':');
        $('div[id="emp_signature"]').css(arrp1[0], arrp1[1]).css(arrp2[0], arrp2[1]);
        $('div[id="emp_signature"] span').css(arrp3[0], arrp3[1]);

        //end of id xy configuration


    }


    function BrowseFromCamera(event) {

        if (event.ctrlKey)
            return;

        //        $('div[class^="popover"]').eq(0).css({'display': 'none'});
        $('button[id="idpopover"]').click();
        var dwidth = 550;
        var dheight = 410;
        var horizontalPadding = 20;
        var verticalPadding = 20;
        $('<iframe id="frmBrowserFromCamera" style="float:none;" frameborder="0" src="photobooth-js/photosettings.php" />')

                .dialog({
                    title: 'Web Camera',
                    autoOpen: true,
                    height: dheight,
                    width: dwidth,
                    modal: true,
                    resizable: true,
                    autoResize: false,
                    overlay: {
                        opacity: 0.7,
                        background: "black"
                    },
                    open: function () {
                        $(this).dialog('option', 'position', ['middle', 100]);
                        $('body[data-spy="scroll"]').css('overflow', 'hidden');
                        $(this).load(function () {
                            var frame = this.contentWindow;
                            console.log(frame.filename, $(this));
                            frame.filename = $('#txtemp_id').val();
                            frame.foldername = 'AlumniPictures';

                            frame.loadInitialCanvas($('#txtemp_id').val(), 'AlumniPictures');
//                            frame.$('button[name="btnPrintID"]').click();
                            //                            frame.$('button[name="btnPrintID"]').click();
                            if ($('img[id="imgempPic"]').attr('src').split('nopic.png').length == 1) {
                                msgBox("Do you want to replace Picture?", "Confirm", 'ask', 'Yes|No', 0, 0, function (v) {
                                    if (v == 1) {

                                    } else {
                                        $('div[aria-labelledby$="frmBrowserFromCamera"] span[class="ui-icon ui-icon-closethick"]').click();
                                        return;
                                    }
                                });
                                var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                                $('div[id="___msgBox"]').css("height", "");
                            }

                        });
                        $(this).focus();
                    },
                    close: function () {
                        $(this).dialog('destroy').remove();
                        $('body[data-spy="scroll"]').css('overflow', '');
                    }

                }).width(dwidth - horizontalPadding).height(dheight - verticalPadding);

    }
    function BrowseFromDevice(event) {

        if (event.ctrlKey)
            return;


        //        $('div[class^="popover"]').eq(0).css({'display': 'none'});
        $('button[id="idpopover"]').click();
        var dwidth = $(window).width();
        var dheight = $(window).height();
        var horizontalPadding = 20;
        var verticalPadding = 20;
        $('<iframe id="frmBrowserFromDevice" style="float:none;" frameborder="0" src="photobooth-js/signaturescanner.php" />')

                .dialog({
                    title: 'Scanner Device',
                    autoOpen: true,
                    height: dheight,
                    width: dwidth,
                    modal: true,
                    resizable: true,
                    autoResize: false,
                    overlay: {
                        opacity: 0.7,
                        background: "black"
                    },
                    open: function () {
                        $(this).dialog('option', 'position', ['middle', 100]);
                        $('body[data-spy="scroll"]').css('overflow', 'hidden');
                        $(this).load(function () {
                            var frame = this.contentWindow;
                            console.log(frame.filename, $(this));
                            frame.filename = $('#txtemp_id').val();
                            frame.foldername = 'AlumniSignature';

                            frame.loadInitialCanvas($('#txtemp_id').val(), 'AlumniSignature');
                            frame.CLIPBOARD_CLASS("my_canvas", true);
//                            frame.$('button[name="btnPrintID"]').click();
                            //                            frame.$('button[name="btnPrintID"]').click();
                            if ($('div[id="emp_signature"] img').attr('src').split('nopic.png').length == 1) {
                                msgBox("Do you want to replace signature?", "Confirm", 'ask', 'Yes|No', 0, 0, function (v) {
                                    if (v == 1) {

                                    } else {
                                        $('div[aria-labelledby$="frmBrowserFromDevice"] span[class="ui-icon ui-icon-closethick"]').click();
                                        return;
                                    }
                                });
                                var messageTitle = "<label id='<?= $strModuleName ?>-LBL_SYSTEMMESSAGETITLE'><?= $LBL_SYSTEMMESSAGETITLE ?></label>";
                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="ui-dialog-title-___msgBox"]').html(messageTitle);
                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('span[id="___msgText"]').css('float', 'left').css('font-weight', 'bolder').css('margin-top', '26px');
                                $('div[class*="ui-dialog"][aria-labelledby="ui-dialog-title-___msgBox"][style*="display: block"]').find('img[id="___msgIcon"]').css('float', 'left');
                                $('div[id="___msgBox"]').css("height", "");
                            }

                        });
                        $(this).focus();
                    },
                    close: function () {
                        $(this).dialog('destroy').remove();
                        $('body[data-spy="scroll"]').css('overflow', '');
                    }

                }).width(dwidth - horizontalPadding).height(dheight - verticalPadding);

    }

</script>
<div  class="container-fluid">
    <div id="divIDFilterAlumniContainer" class="panel panel-default" style="margin: 0px;">
        <div class="panel-heading heading-style" style="height: 50px;">
            <div class="contaner-fluid">
                <div class="row-fluid">
                    <div class="">
                        <div class="row-fluid">                          
                            <div class="col-xs-8 text-left" style=" padding: 0px;width:75%;">                                
                                <div id="divFilterType" class="col-xs-4" style=" padding: 0px; width:30%;   padding: 0px 10px 0px 0px;">
                                    <div class="input-group">
                                        <span class="input-group-addon" style="text-align: left;">
                                            <label style="max-width:55px;" id="<?= $strModuleName ?>-LBL_FRMCATEGORY" ><?= $LBL_FRMCATEGORY ?></label>
                                        </span>
                                        <select  id="txtfiltercategory" class="form-control" required="required" style="text-align: center;">                    
                                            <option></option>
                                            <option>ALL</option>
                                            <option>COLLEGE</option>
                                            <option>BASIC EDUCATION</option>
                                            <option>GRADUATE SCHOOL</option>
                                            <option>LAW SCHOOL</option>
                                            <option>VOC TECHNOLOGY</option>
                                        </select>
                                    </div>
                                </div> 
                                <div id="divFilterDesignation" class="col-xs-3" style=" padding: 0px;">
                                    <div class="input-group">
                                        <span class="input-group-addon" style="text-align: left;">
                                            <label style="max-width:73px;" id="<?= $strModuleName ?>-LBL_FRMDESIGNATION" ><?= $LBL_FRMDESIGNATION ?></label>
                                        </span>
                                        <select  id="txtfilterdesignation" class="form-control" required="required" style="text-align: center;">                    
                                            <option></option>
                                            <option>ALL</option>
                                            <option>Kindergarten</option>
                                            <option>Elementary</option>
                                            <option>Junior High School</option>
                                            <option>Senior High School</option>
                                            <option>AB-E</option>
                                            <option>AB-SS</option>
                                            <option>AT</option>
                                            <option>AUTOMOTIVE NC II</option>
                                            <option>BEED</option>
                                            <option>BEED-F</option>
                                            <option>BEED-G</option>
                                            <option>BEED-GC</option>
                                            <option>BEED-LS</option>
                                            <option>BEED-M</option>
                                            <option>BEED-PE</option>
                                            <option>BEED-PRED</option>
                                            <option>BLIS</option>
                                            <option>BPE - SPE</option>
                                            <option>BPE- SPE</option>
                                            <option>BSA</option>
                                            <option>BSAT</option>
                                            <option>BSBA-FM</option>
                                            <option>BSBA-HRDM</option>
                                            <option>BSBA-MM</option>
                                            <option>BSC</option>
                                            <option>BSC-A</option>
                                            <option>BSC-BA</option>
                                            <option>BSCE</option>
                                            <option>BSCpE</option>
                                            <option>BSCRIM</option>
                                            <option>BSCS</option>
                                            <option>BSE</option>
                                            <option>BSECE</option>
                                            <option>BSEd-E</option>
                                            <option>BSED-F</option>
                                            <option>BSED-GC</option>
                                            <option>BSED-GS</option>
                                            <option>BSED-LS</option>
                                            <option>BSED-M</option>
                                            <option>BSED-PEHM</option>
                                            <option>BSHRM</option>
                                            <option>BSIT</option>
                                            <option>BSMW</option>
                                            <option>BSN</option>
                                            <option>BSP</option>
                                            <option>DRIVING NC II</option>
                                            <option>EIM NC II</option>
                                            <option>GM</option>
                                            <option>Grade School</option>
                                            <option>High School</option>
                                            <option>HKS NC II</option>
                                            <option>JSC</option>
                                            <option>Kindergarten</option>
                                            <option>LLB</option>
                                            <option>MACHINING NC II</option>
                                            <option>MAED - EPM</option>
                                            <option>MAED - GCN</option>
                                            <option>MAED - LIBSCI</option>
                                            <option>MAED - TM</option>
                                            <option>MBA</option>
                                            <option>MBA - BM</option>
                                            <option>MLIS</option>
                                            <option>MLIS-NT</option>
                                            <option>MPA - OM</option>
                                            <option>MSP</option>
                                            <option>PN</option>
                                            <option>SHORT TERM</option>
                                            <option>SMAW NC II</option>
                                            <option>Soc-Grade School</option>
                                            <option>Socialized HS</option>
                                            <option>TCP</option>
                                            <option>TUTORIAL DRIVING</option>
                                            <option>TUTORIAL SMAW</option>
                                        </select>
                                    </div>
                                </div> 
                                <div id="divFilterPrint" class="col-xs-1" style="padding: 0px;width: 15%;">
                                    <input type="checkbox" id="chkIsAllList" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" value="" >
                                    <input type="checkbox" id="chkIsForPrinting" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" value="" checked="checked">
                                    <input type="checkbox" id="chkIsPrintedList" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" value="">
                                    <input type="checkbox" id="chkIsNoPicture" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" value="">
                                    <input type="checkbox" id="chkIsWithPicture" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" value="">
                                    <input type="checkbox" id="chkIsNoSignature" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" value="">
                                    <input type="checkbox" id="chkIsWithSignature" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;" value="">
                                    <div id="alumnifilterprintbtnFilters" class="btn-group" style="padding: 0px;padding-left: 15%;">
                                        <button name="btnFiltersType" class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 5px;font-size: 12px;min-width: 120px;text-align: left;/*padding-left: 13px;*/font-weight: bolder;height: 28px;margin-top: 0px;">FILTER BY<span class="caret" style=" margin-right: 5px; margin-top: 6px; float: right;margin-left: 5px;"></span></button>
                                        <ul id="alumnifilterprintulIDsDropdowns" class="dropdown-menu" role="menu" style="min-width: 120px;margin-left: 13%;">
                                            <li><a id="idLinkIsAllList" style="cursor: pointer;">All List</a></li>
                                            <li class="divider"></li>
                                            <li><a id="idLinkIsForPrinting" style="cursor: pointer;">For Printing</a></li>
                                            <li class="divider"></li>
                                            <li><a id="idLinkIsPrintedList" style="cursor: pointer;">Printed List</a></li>
                                            <li class="divider"></li>
                                            <li><a id="idLinkIsNoPicture" style="cursor: pointer;">No Picture</a></li>
                                            <li class="divider"></li>
                                            <li><a id="idLinkIsWithPicture" style="cursor: pointer;">With Picture</a></li>
                                            <li class="divider"></li>
                                            <li><a id="idLinkIsNoSignature" style="cursor: pointer;">No Signature</a></li>
                                            <li class="divider"></li>
                                            <li><a id="idLinkIsWithSignature" style="cursor: pointer;">With Signature</a></li>
                                            <li class="divider"></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xs-4" style=" padding:0px 0px 0px 2.7%;width: 30%;">
                                    <div class="input-group">
                                        <input id="txtSearchAlumni" class="form-control txt-standard" type="text" placeholder="Search" style="height: 28px;">
                                        <span class="input-group-addon" style="padding: 0px;">
                                            <button name="btnSearchAlumni" id="<?= $strModuleName ?>-LBL_REFRESH" title="click to refresh" class="btn btn-default btn-md btn-standard" style="padding: 1px 7px;height: 25px;">
                                                <span class="glyphicon glyphicon-search search-standard"><b style="    margin-left: 7px;"><?= $LBL_REFRESH ?></b></span>
                                            </button>
                                        </span>
                                    </div>                                  
                                </div>
                            </div>
                            <div class="col-xs-4" style="float:right;margin-top: -2px;padding-right: 0;width:25%;">
                                <button style="display:none;" id="<?= $strModuleName ?>-LBL_EXPORT" name="btnExport" class="btn btn-info btn-lg" title="export" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;">
                                    <span class="glyphicon glyphicon-export"></span> <?= $LBL_EXPORT ?> 
                                </button>
                                <button id="<?= $strModuleName ?>-LBL_PREVIEWID" name="btnPreviewID" class="btn btn-info btn-lg" title="Preview ID" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;width:32%;    min-width: 39%;">
                                    <span class="glyphicon glyphicon-export"></span> <?= $LBL_PREVIEWID ?> 
                                </button>
                                <button id="<?= $strModuleName ?>-LBL_EDIT" name="btnEdit" class="btn btn-info btn-lg" title="Edit" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;width:26%;">
                                    <span class="glyphicon glyphicon-edit"></span> <?= $LBL_EDIT ?>   
                                </button> 
                                <button  id="<?= $strModuleName ?>-LBL_NEW" name="btnNew" class="btn btn-info btn-lg" title="New" style="padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;width:26%;">
                                    <span class="glyphicon glyphicon-new-window"></span> <?= $LBL_NEW ?>   
                                </button>
                                <button id="<?= $strModuleName ?>-LBL_REFRESH" name="btnRefresh" class="btn btn-info btn-lg" title="Refresh" style="display:none;padding: 7px 12px;float: right;font-size: 12px;margin-left:1.5%;width:21%;">
                                    <span class="glyphicon glyphicon-refresh"></span> <?= $LBL_REFRESH ?>
                                </button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body" id="panel-body" style="padding:0px;">
        <div id="divAlumniInformationList" oncontextmenu="return false;">
            <table id="tblAlumniInformationList" ></table>
            <div id="pgAlumniInformationList"></div>
        </div>
    </div>
</div>
<div class="panel panel-default" id="alumniprofile_dialog" style="display: none;padding: 0px;">

    <div class="panel-heading" id="divTopHeader" style="height: 40px;width: 100%;padding: 0px;">
        <div class="col-md-6" style="float:left;margin-top:3px;"> 
            <button  id="<?= $strModuleName ?>-LBL_CLEAR"  name="btnClear" class="btn btn-info btn-lg" title="Clear" style="padding: 7px 12px;float: left;font-size: 12px;margin-right: 0.5%;       width: 15%;">
                <span class="glyphicon glyphicon-list-alt"></span> <?= $LBL_CLEAR ?>
            </button>
            <button  id="<?= $strModuleName ?>-LBL_REFRESH"  name="btnDetailRefresh" class="btn btn-info btn-lg" title="Refresh" style="padding: 7px 12px;float: left;font-size: 12px;margin-right: 0.5%;     width: 15%;">
                <span class="glyphicon glyphicon-refresh"></span> <?= $LBL_REFRESH ?>
            </button>
            <button  id="<?= $strModuleName ?>-LBL_SAVE"  name="btnSaveAlumni" class="btn btn-info btn-lg" title="Save" style="padding: 7px 12px;float: left;font-size: 12px;margin-right: 0.5%;       width: 15%;">
                <span class="glyphicon glyphicon-floppy-save"></span> <?= $LBL_SAVE ?>
            </button>
            <button id="<?= $strModuleName ?>-LBL_CANCEL"  name="btnCancel" class="btn btn-info btn-lg" title="Cancel" style="padding: 7px 12px;float: left;font-size: 12px;margin-right: 0.5%;      width: 15%;">
                <span class="glyphicon glyphicon-remove-circle"></span> <?= $LBL_CANCEL ?>
            </button>     
        </div>

    </div>   
    <form onsubmit="return false;" >
        <div class="panel-body" style="padding-bottom:0px;">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-xs-10" style="padding: 0;">
                        <div class="row-fluid">
                            <div class="col-xs-3" style="padding-right: 0px;">
                                <div class="input-group">
                                    <span class="input-group-addon" style="text-align: left;">
                                        <label  id="<?= $strModuleName; ?>-LBL_FRMALUMNIID" style="    min-width: 84px;"><?= $LBL_FRMALUMNIID; ?></label>
                                    </span>
                                    <input  id="txtidnum" type="hidden"/>
                                    <input name="ID" class="form-control"  type="text" id="txtemp_id" readonly required="required" style="text-align: center;"/>
                                </div>
                            </div> 
                            <div class="row-fluid col-xs-9" style="padding: 0px; ">
                                <div class="col-xs-12"> 
                                    <div class="input-group col-xs-2" style="border-bottom-left-radius: 4px;border-top-left-radius: 4px;border-left: 1px solid #ccc;height: 28px;border-bottom-right-radius: 0px;  border-top-right-radius: 0px;  padding: 0px 0px 0px 0px;">
                                        <span class="input-group-addon " style="padding:0px;padding-left: 10px;"><label id="<?= $strModuleName ?>-LBL_FRMALUMNINAME" style="min-width: 123px;float: left;text-align: left;"><?= $LBL_FRMALUMNINAME ?></label></span>
                                    </div>                       
                                    <div class="input-group col-xs-10" style="border:none;padding:0px;width: 80%;">                            
                                        <span class="input-group-addon" style="border: none; padding: 0px; border-radius: 0px; text-align: left;"> <input type="text" id="txtlname" class="form-control" style="height: 28px; font-weight: bolder; font-size: 12px; padding: 5px;" required="required" ></span>
                                        <span class="input-group-addon " style="border: none; padding: 0px; border-radius: 0px; text-align: left;"> <input type="text" id="txtfname" class="form-control" style="height: 28px; font-weight: bolder; font-size: 12px; padding: 5px;" required="required" ></span>
                                        <span class="input-group-addon " style="border: none; padding: 0px; border-radius: 0px; text-align: left;"> <input type="text" id="txtmname" class="form-control" style="height: 28px; font-weight: bolder; font-size: 12px; padding: 5px;" required="required" ></span>
                                        <span class="input-group-addon " style="border: none; padding: 0px; border-radius: 0px 4px 4px 0px; text-align: left;"> <input type="text" id="txtnameext" class="form-control" style="height: 28px; font-weight: bolder; border-bottom-right-radius: 4px; border-top-right-radius: 4px; font-size: 12px; padding: 5px;"></span>     
                                    </div>
                                </div>  
                                <div class="col-xs-12" style="margin-top:0%;font-size: 11px;color:maroon;padding-right: 6%;">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-10">                                      
                                        <div class="col-xs-3" style="padding-left: 3%;padding-right: 10%;"><label id="<?= $strModuleName ?>-LBL_FRMLASTNAME" style="min-width: 100px;float: left;text-align: left;font-style: oblique;"><?= $LBL_FRMLASTNAME ?></label></div>
                                        <div class="col-xs-3" style="padding-left: 4%;padding-right: 10%;"><label id="<?= $strModuleName ?>-LBL_FRMFIRSTNAME" style="min-width: 100px;float: left;text-align: left;font-style: oblique;"><?= $LBL_FRMFIRSTNAME ?></label></div>
                                        <div class="col-xs-3" style="padding-left: 6%;"><label id="<?= $strModuleName ?>-LBL_FRMMIDDLENAME" style="min-width: 100px;float: left;text-align: left;font-style: oblique;"><?= $LBL_FRMMIDDLENAME ?></label></div>
                                        <div class="col-xs-3" style="padding-left: 6%;"><label id="<?= $strModuleName ?>-LBL_FRMNAMEEXTENSION" style="  min-width: 200px;float: left;text-align: left;font-style: oblique;"><?= $LBL_FRMNAMEEXTENSION ?></label></div>
                                    </div>
                                </div>    
                            </div>




                        </div>
                        <div style="clear: both;height: 4px;"></div>

                        <div style="width: 100%;margin-top: -22px;">
                            <hr style="height: 1px;color: lightgray;margin-bottom: 0px;"/>
                        </div>
                        <div style="clear: both;height: 6px;"></div>                        
                        <div class="row-fluid">
                            <div class="col-xs-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtcontact_guardian" id="<?= $strModuleName ?>-LBL_FRMGUARDIANNAME"><?= $LBL_FRMGUARDIANNAME; ?></label>
                                    </span>
                                    <input name="contact_guardian" class="form-control" type="text" id="txtcontact_guardian"/>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtcontact_relation" id="<?= $strModuleName ?>-LBL_FRMGUARDIANREL"><?= $LBL_FRMGUARDIANREL; ?></label>
                                    </span>
                                    <input name="contact_relation" class="form-control" type="text" id="txtcontact_relation"/>
                                </div>
                            </div>

                        </div>
                        <div style="clear: both;height: 4px;"></div>
                        <div class="row-fluid">
                            <div class="col-xs-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtcontact_address" style="font-size:12.8px;" id="<?= $strModuleName ?>-LBL_FRMGUARDIANADD"><?= $LBL_FRMGUARDIANADD; ?></label>
                                    </span>
                                    <input name="contact_address" class="form-control" type="text" id="txtcontact_address"/>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtcontactno" id="<?= $strModuleName ?>-LBL_FRMGUARDIANCONTACT"><?= $LBL_FRMGUARDIANCONTACT; ?></label>
                                    </span>
                                    <input name="contactno" class="form-control" type="text" id="txtcontactno"/>
                                </div>
                            </div>

                        </div>
                        <div style="clear: both;height: 4px;"></div>
                        <div style="width: 100%;margin-top: -19px;">
                            <hr style="height: 1px;color: lightgray;margin-bottom: 0px;"/>
                        </div>
                        <div style="clear: both;height: 4px;"></div>
                        <div class="row-fluid">
                            <div class="col-xs-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtsssgsisno" id="<?= $strModuleName ?>-LBL_FRMSSSGSINO"><?= $LBL_FRMSSSGSINO; ?></label>
                                    </span>
                                    <input name="sssgsisno" class="form-control" type="text" id="txtsssgsisno"/>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtbatch" id="<?= $strModuleName ?>-LBL_FRMBATCH"><?= $LBL_FRMBATCH; ?></label>
                                    </span>
                                    <input name="batch" Placeholder="YYYY" maxlength="4" class="form-control" type="number" min="1" max="9999" title="Enter Batch Year/ Year Graduated" id="txtbatch"/>
                                </div>
                            </div>


                        </div>
                        <div style="clear: both;height: 4px;"></div>
                        <div class="row-fluid">  
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txttinno" id="<?= $strModuleName ?>-LBL_FRMTINNO"><?= $LBL_FRMTINNO; ?></label>
                                    </span>
                                    <input name="tinno" class="form-control" type="text" id="txttinno"/>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtphilno" id="<?= $strModuleName ?>-LBL_FRMPHILHEALTH"><?= $LBL_FRMPHILHEALTH; ?></label>
                                    </span>
                                    <input name="PHILHEALTHNO" class="form-control" type="text" id="txtphilno"/>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label for="txtpagibigno" id="<?= $strModuleName ?>-LBL_FRMPAGIBIG"><?= $LBL_FRMPAGIBIG; ?></label>
                                    </span>
                                    <input name="PAGIBIGNO" class="form-control" type="text" id="txtpagibigno"/>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-xs-2" style="padding: 0px;">
                        <div role="form" class="form-group col-md-12" style="margin-bottom:0px;" onsubmit="return false;" >
                            <div class="row" >
                                <div   id="divPicImageThumb"  style="height:186px;min-width: 186px;max-width: 186px;border: inset 3px orangered;border-radius: 5px;">
                                    <img id="imgempPic" style="border:1px solid gray;width: 180px;height: 180px;float:left;">
                                </div> 

                            </div>

                            <div class="row" style="margin-top:1%;margin-bottom:1%;">
                                <input id="imgFilechooser1" name="imgFilechooser1" type="file" style="display: none;" onchange="readURL(this, 1);">
                                <input id="imgFilechooser2" name="imgFilechooser2" type="file" style="display: none;" onchange="readURL(this, 2);">
                                <div class="col-xs-6" style="padding:0px;"> 
<!--                                    <button id="<?= $strModuleName ?>-LBL_BROWSE" onclick="FileBrowser(event);"  class="btn btn-info btn-lg" title="Browse" style="padding: 4px 4px;float: left;font-size: 12px;    min-width: 90px;">
                                        <span class="glyphicon glyphicon-upload"></span> <?= $LBL_BROWSE ?>
                                    </button>-->
                                    <button id="idpopover" type="button" class="btn btn-info btn-lg" data-toggle="popover" title="Browse Picture" data-placement="bottom" data-content='' style="padding: 4px 4px;float: left;font-size: 12px;min-width: 90px;">
                                        <span class="glyphicon glyphicon-upload"></span> <?= $LBL_BROWSE ?>
                                    </button>

                                </div>
                                <div class="col-xs-6" style="padding:0px;"> 
                                    <button id="<?= $strModuleName ?>-LBL_CLEAR"  onclick="removeAttachement(event);"  class="btn btn-info btn-lg" title="Remove Attachment" style="padding: 4px 4px;float: left;font-size: 12px;    min-width: 90px;">
                                        <span class="glyphicon glyphicon-remove-circle"></span> <?= $LBL_CLEAR ?>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <div class="panel-heading" style="background: none;border-top: 2px solid #080707;border-radius: 0px;margin: 0px;padding: 0;margin-top: 0.1%;"></div>
        <div class="container-fluid text-left" id="divTabs">
            <ul class="nav nav-tabs" style="margin: 0;">
                <li class="active">
                    <a data-toggle="tab" data-table-name="tblPersonalInformation" href="#tab-PERSONALINFORMATION">
                        <label id="<?= $strModuleName ?>-LBL_TABPERSONALINFORMATION" style="min-width: 100px;text-align: left;"><?= $LBL_TABPERSONALINFORMATION ?></label>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-table-name="tblImageSettings" href="#tab-IMAGESETTINGS">
                        <label id="<?= $strModuleName ?>-LBL_TABIMAGESETTINGS" style="min-width: 100px;text-align: left;"><?= $LBL_TABIMAGESETTINGS ?></label>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" data-table-name="tblIDPreview" href="#tab-IDPREVIEW">
                        <label id="<?= $strModuleName ?>-LBL_TABIDPREVIEW" style="min-width: 100px;text-align: left;"><?= $LBL_TABIDPREVIEW ?></label>
                    </a>
                </li>

            </ul>
            <div class="tab-content" id='divTabContent' style="width:100%;height:290px;overflow: overlay;padding-right: 17px;" >
                <div class="panel panel-default tab-pane fade in active" id="tab-PERSONALINFORMATION">
                    <div class="panel-heading" name="HEADER_BUTTON" style="height: 268px;padding-top: 5px;">
                        <div role="form" class="form-inline" onsubmit="return false;">                        
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="form-group col-xs-3">
                                            <label id="<?= $strModuleName ?>-LBL_FRMSEX" style="min-width: 100px;float: left;text-align: left;font-size: 13px;margin-top: 6px;"><?= $LBL_FRMSEX ?></label>
                                        </div>
                                        <div class="form-group col-xs-8" >  
                                            <input type="checkbox" id='chkIsSexMale'  checked="checked" style="float:left;height: 20px;width: 20px;margin-top: 2px;margin-left: -17px;cursor:pointer;"><label for="chkIsSexMale" id="<?= $strModuleName ?>-LBL_FRMMALE" style="min-width: 100px;float: left;text-align: left;font-size: 13px;margin-top: 6px;margin-left: 4%;cursor:pointer;"><?= $LBL_FRMMALE ?></label>
                                            <input type="checkbox" id='chkIsSexFemale'  style="float:left;height: 20px;width: 20px;margin-top: 2px;margin-left: -17px;cursor:pointer;"><label for="chkIsSexFemale" id="<?= $strModuleName ?>-LBL_FRMFEMALE" style="min-width: 100px;float: left;text-align: left;font-size: 13px;margin-top: 6px;margin-left: 4%;cursor:pointer;"><?= $LBL_FRMFEMALE ?></label>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 0.5%;">
                                        <div class="form-group col-xs-3" style="padding-right:0px;">
                                            <label id="<?= $strModuleName ?>-LBL_FRMBIRTHDATE" style="min-width: 100px;float: left;text-align: left;font-size: 13px;margin-top: 6px;"><?= $LBL_FRMBIRTHDATE ?></label>
                                        </div>
                                        <div class="form-group col-xs-5" style="padding:0;width: 37.5%;">
                                            <input  class="form-control" type="text" id="txtbirthdate" style="text-align: center;" required="required"  readonly/>
                                        </div>
                                        <div class="form-group col-xs-3" style="padding: 0px 0px 0px 5px;">
                                            <b id="lblNoOfAge" style="float:left;color:#2F4F61;font-size: 13px;margin-top: 6px;font-weight: bolder;">24 </b><label  id="<?= $strModuleName ?>-LBL_FRMYEARSOLD" style="min-width: 100px;float: left;text-align: left; color:#2F4F61;font-size: 13px;margin-top: 6px;font-weight: bolder;"> <?= $LBL_FRMYEARSOLD ?></label>
                                        </div>                                      
                                    </div>
                                    <div class="row" style="margin-top: 0.5%;">
                                        <div class="form-group col-xs-3">
                                            <label id="<?= $strModuleName ?>-LBL_FRMCIVILSTATUS" style="min-width: 100px;float: left;text-align: left;font-size: 13px;margin-top: 6px;"><?= $LBL_FRMCIVILSTATUS ?></label>
                                        </div>
                                        <div class="form-group col-xs-9" style="padding: 0px;"> 
                                            <div id="idDivOriginalCivilStatus" class="form-group col-xs-6" style="padding: 0px;"> 
                                                <select id="txtstatus" class="form-control" style="float:left;height: 28px;font-weight: bolder;padding: 0px 0px 0px 5px;">                      
                                                    <option></option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Annulled">Annulled</option>                                                
                                                    <option value="Widowed">Widowed</option>
                                                    <option value="Separated">Separated</option>
                                                    <option value="Others">Others, specify</option>
                                                </select>    
                                            </div>
                                            <div id="idDivOtherCivilStatus" class="form-group col-xs-7" style="padding: 0px;display:none;"> 
                                                <input name="OTHERCIVILSTATUS" class="form-control" style="  height: 28px; font-size: 12px;  padding: 5px;  font-weight: bolder;  width: 150px;"  type="text" id="txtcivilstatusother"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">

                                    <div class="row" style="margin-top: 0.5%;">
                                        <div class="form-group col-xs-3" style="padding-right:0px;">
                                            <label id="<?= $strModuleName ?>-LBL_FRMCATEGORY" style="min-width: 100px;float: left;text-align: left;font-size: 13px;margin-top: 6px;"><?= $LBL_FRMCATEGORY ?></label>
                                        </div>
                                        <div class="form-group col-xs-5" style="padding:0;width: 37.5%;">
                                            <select id="txtcategory" class="form-control" required="required" style="text-align: center;">                    
                                                <option></option>
                                                <option>COLLEGE</option>
                                                <option>BASIC EDUCATION</option>
                                                <option>GRADUATE SCHOOL</option>
                                                <option>LAW SCHOOL</option>
                                                <option>VOC TECHNOLOGY</option>
                                            </select>
                                        </div>                                                                            
                                    </div>
                                    <div class="row" style="margin-top: 0.5%;">
                                        <div class="form-group col-xs-3">
                                            <label id="<?= $strModuleName ?>-LBL_FRMDESIGNATION" style="min-width: 100px;float: left;text-align: left;font-size: 13px;margin-top: 6px;"><?= $LBL_FRMDESIGNATION ?></label>
                                        </div>
                                        <div class="form-group col-xs-9" style="padding: 0px;"> 
                                            <div id="idDivOriginalCivilStatus" class="form-group col-xs-6" style="padding: 0px;"> 
                                                <select  id="txtdesignation" class="form-control" required="required" style="text-align: center;">                    
                                                    <option></option>
                                                    <option>Kindergarten</option>
                                                    <option>Elementary</option>
                                                    <option>Junior High School</option>
                                                    <option>Senior High School</option>
                                                    <option>AB-E</option>
                                                    <option>AB-SS</option>
                                                    <option>AT</option>
                                                    <option>AUTOMOTIVE NC II</option>
                                                    <option>BEED</option>
                                                    <option>BEED-F</option>
                                                    <option>BEED-G</option>
                                                    <option>BEED-GC</option>
                                                    <option>BEED-LS</option>
                                                    <option>BEED-M</option>
                                                    <option>BEED-PE</option>
                                                    <option>BEED-PRED</option>
                                                    <option>BLIS</option>
                                                    <option>BPE - SPE</option>
                                                    <option>BPE- SPE</option>
                                                    <option>BSA</option>
                                                    <option>BSAT</option>
                                                    <option>BSBA-FM</option>
                                                    <option>BSBA-HRDM</option>
                                                    <option>BSBA-MM</option>
                                                    <option>BSC</option>
                                                    <option>BSC-A</option>
                                                    <option>BSC-BA</option>
                                                    <option>BSCE</option>
                                                    <option>BSCpE</option>
                                                    <option>BSCRIM</option>
                                                    <option>BSCS</option>
                                                    <option>BSE</option>
                                                    <option>BSECE</option>
                                                    <option>BSEd-E</option>
                                                    <option>BSED-F</option>
                                                    <option>BSED-GC</option>
                                                    <option>BSED-GS</option>
                                                    <option>BSED-LS</option>
                                                    <option>BSED-M</option>
                                                    <option>BSED-PEHM</option>
                                                    <option>BSHRM</option>
                                                    <option>BSIT</option>
                                                    <option>BSMW</option>
                                                    <option>BSN</option>
                                                    <option>BSP</option>
                                                    <option>DRIVING NC II</option>
                                                    <option>EIM NC II</option>
                                                    <option>GM</option>
                                                    <option>Grade School</option>
                                                    <option>High School</option>
                                                    <option>HKS NC II</option>
                                                    <option>JSC</option>
                                                    <option>Kindergarten</option>
                                                    <option>LLB</option>
                                                    <option>MACHINING NC II</option>
                                                    <option>MAED - EPM</option>
                                                    <option>MAED - GCN</option>
                                                    <option>MAED - LIBSCI</option>
                                                    <option>MAED - TM</option>
                                                    <option>MBA</option>
                                                    <option>MBA - BM</option>
                                                    <option>MLIS</option>
                                                    <option>MLIS-NT</option>
                                                    <option>MPA - OM</option>
                                                    <option>MSP</option>
                                                    <option>PN</option>
                                                    <option>SHORT TERM</option>
                                                    <option>SMAW NC II</option>
                                                    <option>Soc-Grade School</option>
                                                    <option>Socialized HS</option>
                                                    <option>TCP</option>
                                                    <option>TUTORIAL DRIVING</option>
                                                    <option>TUTORIAL SMAW</option>
                                                </select>    
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 0.5%;">
                                        <div class="input-group">
                                            <input type="checkbox" id="chkisforprint" style="float: right;  margin-left: 20px; height: 28px; width: 24px; margin-top: 0px; cursor: pointer; font-size: 12px; padding: 5px; font-weight: bolder;" >

                                            <span class="input-group-addon" style="width: 140px; text-align: left;  border: none; background: transparent;">
                                                <label for="chkisforprint" id="<?= $strModuleName ?>-LBL_TBLISFORPRINT"><?= $LBL_TBLISFORPRINT ?></label>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div style="clear: both;height: 4px;"></div>

                            <div style="width: 100%;margin-top: -22px;">
                                <hr style="height: 1px;color: lightgray;margin-bottom: 0px;"/>
                            </div>
                            <div style="clear: both;height: 6px;"></div> 
                            <div class="row">
                                <div class="col-xs-6">
                                    <!--<fieldset id="fldsetAddress">-->
                                    <!--<legend>-->
                                    <label  id="<?= $strModuleName ?>-LBL_FRMPRINTINGHISTORY" style="    margin-top: -3px;float: left;text-align: left;color: maroon;font-weight: bolder;font-size: 12px;  margin-left: 14px;"><?= $LBL_FRMPRINTINGHISTORY ?></label>
                                    <!--</legend>-->
                                    <div class="col-xs-12" style="padding-right: 0px;margin-top: 0px;float:left;">
                                        <div class="input-group">                                        
                                            <textarea name="remarks" class="form-control" type="text" id="txtprintinghistory" required="required" style="text-align: left; resize: none; font-weight: bolder; font-size: 12px;" rows="8" cols="50"></textarea>
                                        </div>                               

                                    </div>
                                    <!--</fieldset>-->
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

                <div class="panel panel-default tab-pane fade " id="tab-IMAGESETTINGS" style="border: none;">                 

                    <div id="divImageSettings" class="panel-body" style="padding-top:0px;padding-bottom:0px;" >                   
                        <div id="divPictureTbl" class="col-xs-6" style="border: 1px solid #ccc;width: 50%;height: 270px;">
                            <table id="tblImageSettings" class="col-xs-6"></table>
                            <div id="pgImageSettings" class="col-xs-6"></div>
                        </div>
                        <div id="divSignatureTbl" class="col-xs-6" style="border: 1px solid #ccc;width: 50%;height: 270px;">
                            <table id="tblImageSettingsSign"></table>
                            <div id="pgImageSettingsSign"></div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default tab-pane fade " id="tab-IDPREVIEW" style="border: none;">                 
                    <button id="btnPrintPreviewID" style="    margin-left: 3%;" onclick="PrintPreviewIDIndividual();">Print Preview</button>
                    <button id="btnRefreshSignature" style="display:none;" onclick="functionRefreshAlumniSignature();">Refresh Signature</button>

                    <div id="divIDPreview" class="panel-body" style="padding-top:0px;padding-bottom:0px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing: initial;" >
                        <div style="text-align:center;display:inline-block;" id="div_print_id1">
                            <div style="width:auto;">
                                <div id="_front" style="display:inline-block;border-right:black solid thin;   padding: 10px 20px 30px 20px;">
                                    <div id="div_img_id_front" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width: 5.4cm;height: 8.54cm;position:relative;float:left;">
                                        <img id="img_front" src="../../../../ID/views/default/gui/SignaturePad/Front.jpg" style="border-radius:5px;width: 5.30cm;height: 8.5cm;" alt="Emp ID">
                                        <div id="emp_pic" style="width: 100px;height: 100px;top:0px;position:absolute;margin-top: 81px;right: 8px;text-align: center;">
                                            <img src="../../../documents/AlumniPictures/nopic.png?time=Fri Mar 04 2016 00:00:42 GMT-0800 (Pacific Standard Time)" style="width: 97px;height: 97px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt="">
                                        </div> 
                                        <div class="class_barcode" style="top:0px;position:absolute;font-weight: bold;text-align: center;width: 89%;top: 241px;/*left: 12px;*/-webkit-transform: scale(1,0.9081);"> 
                                          <!-- <img id="barcode" style="width: auto;height:auto;"/>-->
                                            <img id="barcode" style="width: 171px; height: 25px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOQAAAAyCAYAAABMMHe/AAADwElEQVR4Xu2dQXbDMAhEnfsfun1x4lpRJGAMqbL43eS1tRoHMwwMSL1t8a+fbdtuzeXH9/fX4+v++9H3x8/b12PNf67v73P2eSKfo73/2fXZ9xutHz0H1f7t9aPP4X3+leuV+43YxfJDz2+vPHcTca1DetAEkI+AlLVDxqGqAtpKQPUBWLGHGkABJAy5+4DFMIoDwpAPC3iBMMpUXsZi2bsqEMOQhQDxHEONyH1KFFlPyvqwUlsyAcjOIIojVThUn7pE39+LkB5AAOS7RqAw/gg46nrl+ohfUEMOxKGI4fqIaBlylnoAyPWAooY0klZEndM4kRQIhlwPaBjyaYFsUVvBcFmVEYZcDygYEoYsUz1hyPWAhiFhyBfZPZspZBwqmyFUiCpZhsuuz9jPy5Boe0z6lqphoqKQ90BQWV/bCRFxTAFIRUBQ3i/iF6isqKy7D0REJCswXVGZKwCRZbjsegBJykrKavSdFYBUBATl/WBIRud2H2B0zt5k0AJFARizrI1CmxUzaHvMd8tER78QdU6HvJLyexqCql0oz81odpy/YjBAe8C0PWh7jBhdSY1NYAJIAKmmjFlRJrteuV8FKFf28cKQk/2IEcPPDK48YBgShoQhu/1wmd0iXg1BH5I+ZCvK9f4wE5UihEANOQAygFzPcKSsBjSpIakhr6TsmbYFgASQZX1Basj1DKsEECWVRNR5WotT5+aDBFZfrHXMiOO1fbuVDAdDwpAw5BeNvgFIAAkgAeT0vGAr00Bl/fAsLCrr+hoQhoQhYUgYEoZUGqyqKMExkK/tGtV+iDrjE+gtES27uYLBAAYDhvs4synj6vW0PZr2RGZ0iO1XbL9ig7LDk0zqMKmjME4FoLIMq9xvJJVHZeVMnd0HrmywZYOyFkAB5IfbFlmHpO1B26MXG2FIGBKGfKJAPSNHvR6GhCF3H+CQKw65mjGxKesg6mg1Cbs91qe8iDq0PTiX9YsmfQAkgASQAPJPFR8FBKVWJWUtrOlIWUlZASSHXLkMHYnQbFA+uSnaPmP71YdVWvqQ6xmOSR0jaUVlRWVVRBJG58b+EslQzNqx/QOhCycHFCsnNzNcznB5BaCVAKIAhUOuGvU2YrgKQJOykrLOGvYAEkC+iTVKYGqZQlmXreFWr4ch6UO6KqeSumccKqoOjjIBVFZU1umO9atHcGQdkpSVlJWUtbCPCCBjZ8HAkOPhdi8ge3bLnJgREk9pe9D2UFLoCpU0W4Mq9xupra1anMEABgN2/7C2b2X+Hd83AApAGlz5C6a1sudQsIdaAAAAAElFTkSuQmCC">  
                                        </div> 
                                        <div id="emp_name" style="top:0px;position:absolute;margin-top: 185px;font-weight: bold;margin-left: 0px;text-align: right;right: 1px; width: 80%; -webkit-transform: scale(0.89051,1.013570);"> 
                                            <span style="font-size:10px;">LOUGENIA MAE A. MOMO</span>
                                        </div> 
                                        <div id="emp_id" style="top:0px;position:absolute;margin-top: 221px;font-weight: bold;text-align: left;left: 8px;width:32%;font-size: 9px;-webkit-transform: scale(0.757801,1.0102570);">
                                            <span style=" font-size: 11px;">0017-0222-5</span> 
                                        </div> 
                                        <div id="emp_idtype" style="top:0px;position:absolute;margin-top: 222px;font-weight: bold;text-align: center;left: 69px;font-size: 9px;width: 60%;-webkit-transform: scale(1.00516999,1.0140357);"> 
                                            <span>GRADUATE SCHOOL</span>
                                        </div> 
                                        <div id="emp_position" style="top:0px;position:absolute;margin-top: 199px;font-weight: bold;margin-left: 0px;text-align: right;right: 1px; width: 80%; -webkit-transform: scale(0.89051,1.013570);"> 
                                            <span style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Faculty</span>
                                        </div> 
                                        <div id="emp_pressignature" style="display:none;top:0px;position:absolute;margin-top: 274px;/* margin-left: 83px; */text-align: center;width: 210px;">
                                            <img src="../../../documents/PresidentSignature/PresidentSignature.png" style="width: 128px;height: 20px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> 
                                        </div> 
                                        <div id="emp_presidentname" style="display:none;top:0px;position:absolute;margin-top: 293px;font-weight: bold;margin-left: 0px;text-align: center;width: 220px; -webkit-transform: scale(0.781,0.81570);">
                                            <span style="color:#3d0b0c;font-size: 12px;">BR. ELLAKIM P. SOSMEÑA, S.C.</span> 
                                        </div> 
                                        <div id="emp_president" style="display:none;top:0px;position:absolute;margin-top: 303px;font-weight: bold;text-align: center;width: 220px;-webkit-transform: scale(0.71,0.75);">
                                            <span style=" font-size: 11px; color: #3d0b0c; "> President</span>
                                        </div> 
                                    </div>
                                </div>
                                <div id="_back" style="display: inline-block;    padding: 10px 0px 30px 20px;"> 
                                    <div id="div_img_id_back" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width: 5.4cm;height: 8.54cm;position:relative;float:right;"> 
                                        <img id="img_back" src="../../../../ID/views/default/gui/SignaturePad/Backemp.png?Thu Sep 03 2015 21:51:26 GMT-0700 (Pacific Daylight Time)" style="border-radius:5px;width: 5.30cm;height:8.5cm;" alt="Emp ID">
                                        <div id="s_SSS" style="position: absolute;top: 25px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175);font-weight: bold;"> <span>09-3572076-9</span></div>
                                        <div id="s_tinno" style="position: absolute;top: 45px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>314-629-913</span></div>
                                        <div id="s_philhealth" style="position: absolute;top: 65px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>16-050586971-8</span></div> 
                                        <div id="s_birthdate" style="position: absolute;top: 85px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;">  <span>September 10, 1990</span></div>
                                        <div id="p_civil" style="position: absolute;top: 106px;left: 55px;font-size: 12px;width: 80%;text-align: left;-webkit-transform: scale(0.7081,0.9175); font-weight: bold;"> <span>Single</span></div>
                                        <div id="s_mother" style="position: absolute;top: 146px;left: -10px;font-size: 12px;width: 110%;text-align: left;-webkit-transform: scale(0.81,0.9175); font-weight: bold;"> <span>MARY DULCE  AMOR A. JOSEPH</span></div>
                                        <div id="p_address" style="position: absolute; top: 160px; left:-10px; font-size: 11px; width: 110%; text-align: left; transform: scale(0.81, 0.9175); font-weight: bold;"> <span>Quirino Dist., Padada, Davao Del Sur</span></div>
                                        <div id="p_cellno" style="position: absolute; top: 202px; left: 55px; font-size: 12px; width: 80%; text-align: left; transform: scale(0.7081, 0.9175); font-weight: bold;"> <span>0912-388-2909 </span></div>
                                        <div id="emp_signature" style="width: 100%;position: relative;top: -60px;-webkit-transform: scale(0.91,0.975); font-weight: bold;">
                                            <img src="../../../documents/AlumniSignature/0017-0222-5.png?time=Fri Mar 04 2016 00:00:42 GMT-0800 (Pacific Standard Time)" style="width: 160px;height: 35px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> 
                                        </div> 
                                    </div>
                                </div> 
                            </div>
                            <!--                            <div style="width:auto;">
                                                            <div id="_front" style="display:inline-block;border-right:black solid thin;   padding: 10px 20px 30px 20px;">
                                                                <div id="div_img_id_front" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width: 5.43cm;height: 8.58cm;position:relative;float:left;">
                                                                    <img id="img_front" src="../../../../ID/views/default/gui/SignaturePad/Front.jpg" style="border-radius:5px;width: 5.30cm;height: 8.5cm;" alt="Emp ID">
                                                                    <div id="emp_pic" style="width: 100px;height: 100px;top:0px;position:absolute;margin-top: 81px;right: 10px;text-align: center;">
                                                                        <img src="../../../documents/AlumniPictures/nopic.png?time=Wed Sep 16 2015 20:33:52 GMT-0700 (Pacific Daylight Time)" style="width: 100px;height: 100px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt="">
                                                                    </div> 
                                                                    <div class="class_barcode" style="top:0px;position:absolute;font-weight: bold;text-align: right;width:136.5px;right:8px; top: 240px; left: 12px;"> 
                                                                        <img id="barcode" style="width: 180px;height:25px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOQAAAAyCAYAAABMMHe/AAADwElEQVR4Xu2dQXbDMAhEnfsfun1x4lpRJGAMqbL43eS1tRoHMwwMSL1t8a+fbdtuzeXH9/fX4+v++9H3x8/b12PNf67v73P2eSKfo73/2fXZ9xutHz0H1f7t9aPP4X3+leuV+43YxfJDz2+vPHcTca1DetAEkI+AlLVDxqGqAtpKQPUBWLGHGkABJAy5+4DFMIoDwpAPC3iBMMpUXsZi2bsqEMOQhQDxHEONyH1KFFlPyvqwUlsyAcjOIIojVThUn7pE39+LkB5AAOS7RqAw/gg46nrl+ohfUEMOxKGI4fqIaBlylnoAyPWAooY0klZEndM4kRQIhlwPaBjyaYFsUVvBcFmVEYZcDygYEoYsUz1hyPWAhiFhyBfZPZspZBwqmyFUiCpZhsuuz9jPy5Boe0z6lqphoqKQ90BQWV/bCRFxTAFIRUBQ3i/iF6isqKy7D0REJCswXVGZKwCRZbjsegBJykrKavSdFYBUBATl/WBIRud2H2B0zt5k0AJFARizrI1CmxUzaHvMd8tER78QdU6HvJLyexqCql0oz81odpy/YjBAe8C0PWh7jBhdSY1NYAJIAKmmjFlRJrteuV8FKFf28cKQk/2IEcPPDK48YBgShoQhu/1wmd0iXg1BH5I+ZCvK9f4wE5UihEANOQAygFzPcKSsBjSpIakhr6TsmbYFgASQZX1Basj1DKsEECWVRNR5WotT5+aDBFZfrHXMiOO1fbuVDAdDwpAw5BeNvgFIAAkgAeT0vGAr00Bl/fAsLCrr+hoQhoQhYUgYEoZUGqyqKMExkK/tGtV+iDrjE+gtES27uYLBAAYDhvs4synj6vW0PZr2RGZ0iO1XbL9ig7LDk0zqMKmjME4FoLIMq9xvJJVHZeVMnd0HrmywZYOyFkAB5IfbFlmHpO1B26MXG2FIGBKGfKJAPSNHvR6GhCF3H+CQKw65mjGxKesg6mg1Cbs91qe8iDq0PTiX9YsmfQAkgASQAPJPFR8FBKVWJWUtrOlIWUlZASSHXLkMHYnQbFA+uSnaPmP71YdVWvqQ6xmOSR0jaUVlRWVVRBJG58b+EslQzNqx/QOhCycHFCsnNzNcznB5BaCVAKIAhUOuGvU2YrgKQJOykrLOGvYAEkC+iTVKYGqZQlmXreFWr4ch6UO6KqeSumccKqoOjjIBVFZU1umO9atHcGQdkpSVlJWUtbCPCCBjZ8HAkOPhdi8ge3bLnJgREk9pe9D2UFLoCpU0W4Mq9xupra1anMEABgN2/7C2b2X+Hd83AApAGlz5C6a1sudQsIdaAAAAAElFTkSuQmCC"> 
                                                                    </div> 
                                                                    <div id="emp_name" style="top:0px;position:absolute;margin-top: 187px;font-weight: bold;text-align: right;width:202.5px;/* right: 8px; */ left: -4px;-webkit-transform: scale(0.951,1.3570);"> 
                                                                        <span style="font-size:10px;">LOUGENIA MAE A. MOMO</span>
                                                                    </div> 
                                                                    <div id="emp_id" style="top:0px;position:absolute;margin-top: 219px;font-weight: bold;text-align: left;left: 7px;font-size: 9px;-webkit-transform: scale(0.7801,1.2570);">
                                                                        <span style=" font-size: 11px;">0017-0222-5</span> 
                                                                    </div> 
                                                                    <div id="emp_idtype" style="top:0px;position:absolute;margin-top: 219px;font-weight: bold;text-align: center;left: 70px;font-size: 10px;width: 60%;-webkit-transform: scale(0.901,1.3570);"> 
                                                                        <span>COLLEGE</span>
                                                                    </div> 
                                                                    <div id="emp_position" style="top:0px;position:absolute;margin-top: 199px;font-weight: bold;margin-left: 0px;text-align: center;right: 8px;width: 40px;-webkit-transform: scale(0.81,1.2570);"> 
                                                                        <span style="font-size:11px;"> Faculty</span>
                                                                    </div> 
                                                                    <div id="emp_pressignature" style="top:0px;position:absolute;margin-top: 274px;/* margin-left: 83px; */text-align: center;width: 210px;">
                                                                        <img src="../../../documents/PresidentSignature/PresidentSignature.png" style="width: 128px;height: 20px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> 
                                                                    </div> 
                                                                    <div id="emp_presidentname" style="top:0px;position:absolute;margin-top: 293px;font-weight: bold;margin-left: 0px;text-align: center;width: 220px; -webkit-transform: scale(0.781,0.81570);">
                                                                        <span style="color:#3d0b0c;font-size: 12px;">BR. ELLAKIM P. SOSMEÑA, S.C.</span> 
                                                                    </div> 
                                                                    <div id="emp_president" style="top:0px;position:absolute;margin-top: 303px;font-weight: bold;text-align: center;width: 220px;-webkit-transform: scale(0.71,0.75);">
                                                                        <span style=" font-size: 11px; color: #3d0b0c; "> President</span>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div id="_back" style="display: inline-block;  padding: 10px 0px 30px 20px;"> 
                                                                <div id="div_img_id_back" style="border-radius:10px;border: rgba(153, 153, 153, 0) dashed 0.5px;width: 5.43cm;height: 8.58cm;position:relative;float:right;"> 
                                                                    <img id="img_back" src="../../../../ID/views/default/gui/SignaturePad/Backemp.png?Thu Sep 03 2015 21:51:26 GMT-0700 (Pacific Daylight Time)" style="border-radius:5px;width: 5.30cm;height:8.5cm;" alt="Emp ID">
                                                                    <div id="s_SSS" style="position: absolute;top: 28px;left: 75px;font-size: 12px;width: 63%;text-align: left;-webkit-transform: scale(0.91,0.975);font-weight: bold;"> <span> 09-3572076-9 </span></div>
                                                                    <div id="s_tinno" style="position: absolute;top: 47px;left: 75px;font-size: 12px;width: 63%;text-align: left;-webkit-transform: scale(0.91,0.975); font-weight: bold;"> <span> 314-629-913 </span></div>
                                                                    <div id="s_philhealth" style="position: absolute;top: 67px;left: 75px;font-size: 12px;width: 70%;text-align: left;-webkit-transform: scale(0.91,0.975); font-weight: bold;"> <span>16-050586971-8 </span></div> 
                                                                    <div id="s_birthdate" style="position: absolute;top: 88px;left: 75px;font-size: 12px;width: 70%;text-align: left;-webkit-transform: scale(0.91,0.975); font-weight: bold;">  <span>March 31,1993</span></div>
                                                                    <div id="p_civil" style="position: absolute;top: 107px;left: 75px;font-size: 12px;width: 70%;text-align: left;-webkit-transform: scale(0.91,0.975); font-weight: bold;"> <span>Single</span></div>
                                                                    <div id="s_mother" style="position: absolute;top: 148px;left: 0px;font-size: 12px;width: 100%;text-align: left;-webkit-transform: scale(0.91,0.975); font-weight: bold;"> <span>MARY DULCE  AMOR A. JOSEPH</span></div>
                                                                    <div id="p_address" style="position: absolute; top: 160px; left: 0px; font-size: 11px; width: 100%; text-align: left; transform: scale(0.91, 0.975); font-weight: bold;"> <span>Quirino Dist., Padada, Davao Del Sur</span></div>
                                                                    <div id="p_cellno" style="position: absolute; top: 206px; left: 75px; font-size: 12px; width: 70%; text-align: left; transform: scale(0.91, 0.975); font-weight: bold;"> <span>0912-388-2909 </span></div>
                                                                    <div id="emp_signature" style="width: 100%;position: relative;top: -47px;-webkit-transform: scale(0.91,0.975); font-weight: bold;">
                                                                        <img src="../../../documents/AlumniSignature/2009-0418-8.png?Thu Sep 03 2015 21:51:26 GMT-0700 (Pacific Daylight Time)" style="width: 128px;height: 20px;border: #C15858 solid thin;border-color: transparent;border-radius: 5px;" alt=""> 
                                                                    </div> 
                                                                </div>
                                                            </div> 
                                                        </div> -->
                        </div>

<!--                        <div id="theBox"><span>This is the content</span></div>
                        
                        <br>
                        <div id="theBox2"><span>www.dhtmlgoodies.com</span></div>
                     
                        <br>
                        <div id="theBox3"><span>Max height of this box is set to 50px</span></div>-->

                    </div>
                </div>
            </div>
        </div>  
        <input type="submit" id="btnSubmitSaveConfirmation" value="ConfirmSave" style="display:none;" >
    </form>
    <form method="post" accept-charset="utf-8" name="form1AlumniSignature" style="display:none;">    
        <input name="filename" id='filename' type="hidden" value=""/>
    </form>
    <form method="POST" accept-charset="utf-8" name="frmPictures" style="display:none;">
        <input type="hidden" name="img_filenamenew" id="img_filenamenew" value="" />
        <input type="hidden" name="img_filename" id="img_filename" value="" />
        <input type="hidden" name="img_foldername" id="img_foldername" value="" />
    </form>




    <!--     <div class="panel-footer" style="padding:0px;">           
         </div>-->
    <!-- Button trigger modal -->

    <input type="checkbox" id="chkIsAllowMultiple" style="display: none; height: 28px; font-size: 12px; padding: 5px; font-weight: bolder;"  >
</div> 

<!--//Context Menu-->

<div class="contextMenu" class="vmenu"  id="AlumniRecordContextRmenu"  style="display:none;">
    <ul style="width: 200px">
        <li id="mnuadd" style="display:none;">
            <span class="glyphicon glyphicon-plus-sign text-info" aria-hidden="true"></span>
            <label  id="<?= $strModuleName ?>-LBL_NEW"  style="cursor: pointer;"><?= $LBL_NEW ?> </label>
        </li>
        <hr style="margin-bottom: 0; margin-top: 0;">
        <li id="mnuedit">
            <span class="glyphicon glyphicon-log-in text-success" aria-hidden="true"></span>
            <label id="<?= $strModuleName ?>-LBL_EDIT" style="cursor: pointer;"><?= $LBL_EDIT ?> </label>
        </li> 

        <hr style="margin-bottom: 0; margin-top: 0;">
        <li id="mnuview">
            <span class="glyphicon glyphicon-screenshot text-danger" aria-hidden="true"></span>
            <label  id="<?= $strModuleName ?>-LBL_PREVIEWID"  style="cursor: pointer;"><?= $LBL_PREVIEWID ?> </label>

        </li>
        <hr style="margin-bottom: 0; margin-top: 0;">
        <li id="mnurefresh">
            <span class="glyphicon glyphicon-search search-standard text-success" aria-hidden="true"></span>
            <label  id="<?= $strModuleName ?>-LBL_REFRESH"  style="cursor: pointer;"><?= $LBL_REFRESH ?> </label>

        </li>
        <hr style="margin-bottom: 0; margin-top: 0;">
        <li id="mnumultiple">
            <span class="glyphicon glyphicon-collapse-up text-info" aria-hidden="true"></span>
            <label id="lblMultiple"   style="cursor: pointer;">Multiple Selection</label>

        </li>

    </ul>
</div>


<style>
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
        /*width: 100px;*/
        font-weight: normal;
        color:black;
    }

    .custom-combobox-input:not([id='custom-combobox-input-cboModelOption']) {
        margin: 0;
        padding: 5px 2px;
        width: 100px;
        font-weight: normal;
        color:black;
        height: 28px;
        font-size: 11px;
    }
    .ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all{
        height:500px;
        width:150px;
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
    .popover-title {
        padding: 8px 14px;
        margin: 0;
        font-size: 14px;
        font-weight: normal;
        line-height: 10px;
        background-color: #f7f7f7;
        border-bottom: 1px solid #ebebeb;
        border-radius: 5px 5px 0 0;
    }
    .ui-menu .ui-menu-item a {
        text-decoration:none;
        display:block;
        padding:1px;
        line-height:1.5;
        zoom:1;
    }

</style>