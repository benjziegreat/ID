
var dates = {
    datePrecedingFromAnd:0,
    getTransactionClosingDate: function(ModuleID){
        $.ajax({
            type:'GET',
            url:'../../../models/mod.pdc.trnntcclosingtrnsettings.php?ACTION=getClosingTransactionDetail',
            async:false,
            dataType:'json',
            data:{
                GETPARAM: ModuleID
            },
            success:function(result){
                if(result.length!=0){
                    dates.datePrecedingFromAnd = result[0].ClosingDate;
                }
            }
        });  
    },
    disableRangeOfDays: function(d) {
        if(dates.datePrecedingFromAnd!=0){
            var sdate = dates.datePrecedingFromAnd.split("-");
            if (new Date(sdate[2], (sdate[0] - 1), sdate[1]) >= d) {
                return [false];
            }
            return [true];
        }else{
            return [true];
        }
        
    }
};

var CommonGrid ={
    strTmplt : {
        sorttype : 'string',
        align : 'left',
        width : 150
    },
    numTmplt:{
        sorttype : 'integer',
        align : 'right',
        width : 130,
        formatter : function(cellvalue, options, rowObject) {
            
            if(cellvalue=="" || cellvalue==0 || cellvalue==null){
                return "";
            }else{
                return formatNumeric(cellvalue, "#,###");	
            }
            
        },
        unformat : function(cellvalue, options, cell) {
            return prepareNumeric(cellvalue);
        }
    },
    intTmplt:{
        sorttype : 'integer',
        align : 'right',
        formatter:'integer',
        formatoptions:{
            thousandsSeparator: "", 
            defaultValue: ''
        },
        width : 130
    },
    dblTmplt:{
        sorttype : 'integer',
        align : 'right',
        width : 130,
        formatter : function(cellvalue, options, rowObject) {
            
            if(cellvalue=="" || cellvalue==null){
                return "0";
            }else{
                return formatNumeric(cellvalue, "#,###.##########");	
            }
            
        },
        unformat : function(cellvalue, options, cell) {
            return prepareNumeric(cellvalue);
        }
        
    },
    moneyTmplt:{
        sorttype : 'number',
        align : 'right',
        formatter:'number',
        formatoptions:{
            thousandsSeparator: ",", 
            decimalSeparator :".",
            decimalPlaces:2,
            defaultValue: ''
        },
        width : 130
    },
    dtTmplt:{
        sorttype : 'date',
        align : 'center',
        formatter: 'date',
        formatoptions: {
            S: function (j) {
                return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'
                },
            srcformat: 'ISO8601Long',
            newformat: 'Y-m-d h:i:s a',
            defaultValue:null
        },
        width : 170
    },
    dTmplt:{
        sorttype : 'date',
        align : 'center',
        formatter: 'date',
        formatoptions: {
            S: function (j) {
                return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'
                },
            srcformat: 'ISO8601Long',
            newformat: 'Y-m-d',
            defaultValue:null
        },
        width : 170
    },
    tmTmplt:{
        sorttype : 'date',
        align : 'center',
        formatter: 'date',
        formatoptions: {
            S: function (j) {
                return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'
                },
            srcformat: 'ISO8601Long',
            newformat: 'h:i a',
            defaultValue:null
        },
        width : 170
    }
};

var CommonExport = {
    openPost : function(url, variables,target){
        var form = document.createElement("form");

        form.setAttribute("method", "post");
        form.setAttribute("target", target);
        form.setAttribute("action", url);
//        form.setAttribute("onsubmit","console.log(event,this);")

        for(variable in variables)

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

    },
    getExportGridOptions : function(gridColModel){
        var colWidth = [];
        var count = 0;
        var frozen_count = -1;
        for(var i=0;i<gridColModel.length;i++){
            if(gridColModel[i]['name']!="cb" && !gridColModel[i]['hidden']){
                count++;
                colWidth.push(gridColModel[i]['width']);
            }
            if(gridColModel[i]['name']!="cb" && !gridColModel[i]['hidden'] && gridColModel[i]['frozen']){
                frozen_count++;
            }
        }
        return {
            colWidth:colWidth,
            colCount:count,            
            frozenCount:frozen_count
        };
    },
    getGridDataNew : function(gridTable,autoSize) {

        switch(autoSize){
            case 'auto':
                autoSize = true;
                break;
            default:
                autoSize = false;
                break;
        }

        var headerDiv = $(gridTable)[0].grid.hDiv;
        var bodyDiv = $(gridTable)[0].grid.bDiv;
        var footerDiv = $(gridTable)[0].grid.sDiv;

        var headerRows = this.getGridRows(headerDiv,'header');
        var bodyRows = this.getGridRows(bodyDiv,'body');
        var footerRows = this.getGridRows(footerDiv,'footer');

        var gridData = {};
        var gridParams = this.getExportGridOptions($(gridTable)[0].p.colModel);
        gridData.colNum = gridParams.colCount;
        gridData.colWidth = gridParams.colWidth;
        gridData.AutoSize = autoSize;
        gridData.frozenCol = gridParams.frozenCount;
        gridData.header = this.getGridColumns(headerRows);
        gridData.body = this.getGridColumns(bodyRows);
        gridData.footer = this.getGridColumns(footerRows);
        
        
        return JSON.stringify(gridData);
    },
    getGridRows : function(objDivElement,strPart){
        var rows = [];

        switch(strPart){
            case 'header':
                rows = $(objDivElement).find('table tr[role="rowheader"]').filter(function(){
                    return $(this).children('*').length != 0;
                });
                break;
            case 'body':
                rows = $(objDivElement).find('table tr:not(:eq(0))').filter(function(){
                    return !$(this).hasClass('jqgroup');
                });
                break;
			case 'bodyGroup':
                rows = $(objDivElement).find('table tr:not(:eq(0))');
                break;
            case 'footer':
                rows = $(objDivElement).find('table tr:not(:eq(1))');
                break;
            default:
                break;
        }

        return rows;
    },
    getGridColumns : function(arrObjElement){
        var arrRows = [];
        $.each(arrObjElement,function(i){
            var columns = $(this).children('th,td').filter(function(){
                var id = $(this).attr('id') == undefined? ($(this).attr('aria-describedby')==undefined? 'NoIDorAria': $(this).attr('aria-describedby')) :$(this).attr('id');
                return id.indexOf('_cb') == -1;
            }).filter(function(){
                return $(this).css('display') != "none";
            });
            var arrColumns = [];
            $.each(columns,function(i){

                var objFormat = {};
                objFormat.width = $(this).css('width');
                objFormat.colSpan = $(this).attr('colspan')==undefined || parseInt($(this).attr('colspan'))==1 ? null : parseInt($(this).attr('colspan'));
                objFormat.rowSpan = $(this).attr('rowspan')==undefined || parseInt($(this).attr('rowspan'))==1 ? null : parseInt($(this).attr('rowspan'));
                var div = $(this).find('div');
                var span = [];
                var s = $(this).find('span').not('.ui-jqgrid-resize').not('.ui-jqgrid-resize-ltr').not('.ui-icon')
                
                if(div.length<=0){
                    span = s;
                    if(span.length<=0){
                        objFormat.text = $(this).text();
                    }
                    else{
                        objFormat.text = span.text();
                    }
                }
                else{
                    var img = div.find('img');
                    var input = div.find('input');

                    var hasImg = img.length>0;
                    var hasInput = input.length>0;

                    if(hasImg){
                        objFormat.text = img.prop('src');
                    }
                    else if(hasInput){
                        if(input.is(':text')){
                            objFormat.text = input.val();
                        }
                        else if(input.is(':checkbox')){
                            objFormat.text = input.is(':checked')? "Yes": "No";
                        }
                    }
                    else{
                        objFormat.text = div.text();
                    }
                }

                objFormat.text = $.trim(objFormat.text);
                objFormat.textColor = span.length<=0? CommonExport.rgb2hex($(this).css('color')) : s.css('color')=='rgb(51, 51, 51)'?null:CommonExport.rgb2hex(span.css('color'));

                objFormat.borderColor = 'D8DCDF';
				objFormat.textUnderline = $(this).find('u').length > 0 ? 1 : 0;
                objFormat.borderStyle = $(this).css('border-bottom');
                objFormat.textBackGroundColor = $(this).css('background-color')=='rgba(0, 0, 0, 0)' || $(this).css('background-color')=="" ? 'FFFFFF' : span.length>0? (span.css('background-color')=='rgba(0, 0, 0, 0)'? 'EEEEEE' : CommonExport.rgb2hex(span.css('background-color'))): CommonExport.rgb2hex($(this).css('background-color'));

                objFormat.textAlignment = span.length<=0? $(this).css('text-align') : span.css('text-align');
                arrColumns.push(objFormat);
            });
            arrRows.push(arrColumns);
        });
        return arrRows;
    },
    rgb2hex:function(rgb){
        if(rgb=='transparent'){
            return 'FFFFFF';
        }
		
		if(rgb==""){
            return "000000";
        }

        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        var base16 =
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);

        return base16.toUpperCase();
    }
}

function getElementValue(strElementID)
{
    var strValue = document.getElementById(strElementID).value;
    return strValue;

}

function setElementValue(strElementID,strValue)
{
    document.getElementById(strElementID).innerHTML = strValue;
}       

function getGridNewID(strGridTargetID){
    var intMaxRowID = 0;
    var arrDataRow = jQuery('#' + strGridTargetID).jqGrid('getDataIDs');
    
    for(var i=0;i < arrDataRow.length;i++) {
        
        if (intMaxRowID < parseInt(arrDataRow[i])){
            intMaxRowID = arrDataRow[i];
        }
    }
    return parseInt(intMaxRowID) + 1;
}
function getGridColumnIndex(strGridTargetID,strColumnName){
    
    var grid = $('#' + strGridTargetID);
    var colModel = grid.jqGrid('getGridParam','colModel');
    
    for (var i = 0; i<colModel.length;i++){
        if (colModel[i].name == strColumnName){
            return i;
        }
    }
    return -1;
}

function getGridRowHeight (gridTarget) {
    var height = null; // Default

    try{
        height = $(gridTarget).find('tbody').find('tr:first').outerHeight();
    }
    catch(e){
    //catch and just suppress error
    }

    return height;
}

function scrollGridToRow (gridTarget, rowid) {
    var rowHeight = getGridRowHeight(gridTarget) || 23; // Default height
    var index = $(gridTarget).getInd(rowid);
    
    //$(gridTarget).closest(".ui-jqgrid-bdiv").animate({scrollTop:(rowHeight * index)},'slow');
    $(gridTarget).closest(".ui-jqgrid-bdiv").scrollTop(rowHeight * index);
}

function setMergeColumn(strTableID , colIndex,colGroupIndex,isMultiMerge){
	
    isMultiMerge = isMultiMerge || false;
    var itemOld = "";
    var itemOldGroup = "";
    var isFirst = true;
    var intCntrGroup = 0;
    var objElement;
    
    
    //var $rows = $('#' + strTableID + ' tbody tr:not(:first)');
    var $rows = $('#' + strTableID + ' tbody tr:not(:first)').filter(':visible');
    
    //clear all rowspan first.
    if(!isMultiMerge){
        $('#' + strTableID + ' tbody tr:not(:first)').children('td').removeAttr('rowspan');
    }
    
    //get items subject for row span.
   
    $rows.each(function(i) {
        
        var itemCell = $(this).find('td:eq('+ colIndex + ')');
        var itemCellGroup = $(this).find('td:eq('+ colGroupIndex + ')');
        
        var item = itemCell.text();
        var itemGroup = itemCellGroup.text();
        
        itemCell.show();
        itemCell.css({
            'font-weight': 'bold'
        });
        
        if (itemOld != item  || ((colGroupIndex < 0)? false : (itemGroup != itemOldGroup)) ) {

            if (!isFirst && intCntrGroup > 0){

                objElement.attr('rowspan',((intCntrGroup * 1) + 1)).css({
                    'text-align':'center',
                    'vertical-align': 'middle'
                });
            }

            objElement = itemCell;
            intCntrGroup = 0;

        } else {
            intCntrGroup = (intCntrGroup * 1) +  1;
            itemCell.hide();
        }
        
        
        itemOld = item;
        itemOldGroup =  itemGroup;
        isFirst = false;
        
    });
    
    //check last
    if (!isFirst && intCntrGroup > 0){
        
        objElement.attr('rowspan',((intCntrGroup * 1) + 1)).css({
            'text-align':'center',
            'vertical-align': 'middle'
        });
    }

}

function IsNumeric(event){
    event = (event) ? event : window.event
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false
    }
    return true
    
}

function IsNumericWithDecimal(event){
    event = (event) ? event : window.event
    var charCode = (event.which) ? event.which : event.keyCode
    
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode  != 46) {
        return false
    }
    return true
    
}

function OnChangeNumeric(strObjectName, strFormat){
    $("#" + strObjectName).val(formatNumeric($("#" + strObjectName).val(),strFormat));
}

function prepareNumeric(strValue){
    
    if ($.trim(strValue) == ""){
        strValue = "0";
    }
    
    return $.trim(strValue).replace(/,/g, '');
    
}

function prepareString(strValue){
    
    return $.trim(strValue).replace("'", "''");
    
}

function formatNumeric(strValue, strFormat){

    return $.format.number(parseFloat(prepareNumeric(strValue)), strFormat);
    
}

function formatDate(strValue, strFormat){
    
    return $.format.date(new Date(strValue), strFormat);
    
}

function getObjToURIString(obj){
    return decodeURIComponent($.param(obj));
}

//module label utility
//==========================================================================================================================================================================

function setCookie(strName,objValue,daysExpiration)
{
    var dtExpiration = new Date();
        
    if (daysExpiration!=null){
        dtExpiration.setDate(dtExpiration.getDate() + daysExpiration);
        objValue = escape(objValue) + ((daysExpiration==null) ? "" : "; expires = " + dtExpiration.toUTCString());
    }
        
    document.cookie = strName + "=" + objValue 
	
}

function getCookie(strName)
{
    var retValue = null;
        
    var i,x,y,arrCookies = document.cookie.split(";");
        
    for (i=0;i<arrCookies.length;i++){
        x = arrCookies[i].substr(0,arrCookies[i].indexOf("="));
        y = arrCookies[i].substr(arrCookies[i].indexOf("=")+1);
        x = x.replace(/^\s+|\s+$/g,"");
		
        if (x == strName){
                    
            retValue = unescape(y);
        }
    }	
        
    return retValue;
}

function clickLabel(){
 
    $(function(){
        $(document).ready(function() {
            
            $("label").click(function(e){
                if(e.ctrlKey) getLabelLanguage(this);
            });
            $(":button").click(function(e){
                if(e.ctrlKey) getLabelLanguage(this);
            });
            $(":submit").click(function(e){
                if(e.ctrlKey) getLabelLanguage(this);
            });
	

        });
    });

}

function changeLang(value) 
{
    $(function(){
        $(document).ready(function() {
             
            if (getCookie("lang") == value) return;
             
            setCookie("lang",value,null);
            window.location.reload();

        });
    });
    
   
            
}
function languageOnChange(ctrlTextArea){
    
    $(ctrlTextArea).removeClass("labelTextAreaModified");
    
    if ($(ctrlTextArea).val() != $(ctrlTextArea).attr("name")){
        $(ctrlTextArea).addClass("labelTextAreaModified");
    }    
}
function setLanguageJQGridColumns(strModuleName,strGridID,strLanguageColumns){
    //Create on the fly...
    var langugeID = "languageDiv";
    $("#" + langugeID).remove();
    
    var lblLanguage = document.createElement('div');
    lblLanguage.id = langugeID;
    document.body.appendChild(lblLanguage);
    
    
    var DIALOG_WIDTH = 725; 
    var DIALOG_HEIGHT = 600;
    
    $(document).ready(function(){
        
        $("#" + langugeID).dialog({
            
            title:  strGridID.replace("#", ""),
            width:  DIALOG_WIDTH,
            height: DIALOG_HEIGHT,
            modal:  true,
            
            buttons:[
            {
                id:     'bLabelAccept',
                text:   'Ok',
                    
                click:function(){
                            
                    var listLanguage = {};
                            
                    $('#' + langugeID + ' textarea').each(function(){
                        if(this.id != null ){
                            listLanguage[this.id] = this.value;	
                        }							
                    });
                            
                            
                    $.post("label.utility.php?ACTION=save",{
                        'AppName':strModuleName,
                        'GridColumnLanguageValues':listLanguage
                    },function(data){
                                      
                        for (key in listLanguage ){
                                    
                            var colModelName = key.split(":")[0];
                            $("#" + strGridID).jqGrid('setLabel',colModelName,listLanguage[key]);
                                    
                        }
						
						if($("#" + strGridID).getGridParam('frozenColumns')){
							$("#" + strGridID).jqGrid('destroyFrozenColumns')
											  .jqGrid('setFrozenColumns')
											  .trigger('reloadGrid');
						}
                                
                    });						

                    $(this).dialog('close');
                    $(this).dialog("destroy");
                }					
            },
                   
            {
                id:'bLabelCancel',
                text:'Cancel',
                click:function(){
                    $(this).dialog('close');
                    $(this).dialog("destroy");
                }
            },						
            ],
            
            close: function(event, ui) {
                $(this).dialog("destroy");
            }
        });
        
        return false;	
    });
    
    $("#" + langugeID).load("label.utility.php?ACTION=show",{
        'AppName':strModuleName,
        'GridColumnLanguageIDs': strLanguageColumns
    },function(response, status, xhr) {
        if (status == "error") {

            var msg =  "Error " + xhr.status + "status " + xhr.statusText;
            alert(msg);
            $("#error").html(msg + xhr.status + " " + xhr.statusText);
        }
    }); 	
    
    
    
    
}

function getLabelLanguage(ctrl){

    if (ctrl.id == null || ctrl.id == '' ) return;
    if (ctrl.id.indexOf('LBL_') == -1) return;
    
    
    var oldObj = document.getElementById("labelDiv");		
    if(oldObj != null) document.body.removeChild(oldObj);

    var lbl = document.createElement("div");
    lbl.id = "labelDiv";

    var args = (ctrl.id).split("-");
    var appName = '';
    var labelID = '';
    var labelName = '';

    appName = args[0];
    labelID = args[1];		
    labelName = ((ctrl.name == null)? '' : ctrl.name );

    document.body.appendChild(lbl);
    
    $(document).ready(function() {
        
        $("#labelDiv").dialog({
            title: args[1],
            width:250,
            height:300,
            modal:true,
                
            close: function(event, ui) {
                $(this).dialog("destroy");
            },
            buttons:[{
                id:'bLabelAccept',
                text:'Ok',
                click:function(){
                    var lblArr = {};
                    $('#labelDiv textarea').each(function(){
                        if(this.id != null ){
                            lblArr[this.id] = this.value;	
                        }							
                    });
                    $('#labelDiv input').each(function(){
                        if(this.id !=null && this.value != null){
                            lblArr[this.id] = this.value;
                        }							
                    });			
                            
                    $.post("label.utility.php?ACTION=save",lblArr,function(data){
                                
                        if(ctrl.tagName == 'INPUT') ctrl.value=data.trim();
                        else ctrl.innerHTML = data.trim();
                                
                    });						

                    $(this).dialog('close');
                    $(this).dialog("destroy");
                }					
            },
            {
                id:'bLabelCancel',
                text:'Cancel',
                click:function(){
                    $(this).dialog('close');
                    $(this).dialog("destroy");
                }
            },						
            ]
        });	
        return false;			        		
    });    
 

    $("#labelDiv").load("label.utility.php?ACTION=show",{
        'AppName':appName,
        'LabelID': labelID,
        'LabelName':labelName
    },function(response, status, xhr) {
        if (status == "error") {

            var msg =  "Error " + xhr.status + "status " + xhr.statusText;
            alert(msg);
            $("#error").html(msg + xhr.status + " " + xhr.statusText);
        }
    }); 			

	
}


//module label utility
//======================================================================================================================================================================


//slide menu
//======================================================================================================================================================================
var slideMenuBuild;
var posiY;
var slideMenuHandler;

function showHideAllMenu(step){
    if(slideMenuBuild!=true){
        //slideMenu.build('module-tap-menu',420,10,10,1);
        slideMenuBuild = true; 
    }
    posiY = parseInt($("#colophon").css("top").replace("px",""),10);
    var menuHeight = parseInt($("#colophon").css("height").replace("px",""),10);
   
    if(posiY >= -20){
        //alert('pa taas' + ' ' + posiY);
        $("#colophon").css("top","-" + menuHeight + "px");
        $("#up-hide-button").html("&#171;");
    //step = -1*(step);
    }else{
        //alert('pa baba' + ' ' + posiY);
        $("#colophon").css("top","-20px");
        $("#up-hide-button").html("&#187;");
    //step = step;
    }

//slideMenuHandler = setInterval(function(){ animateColophonMenu(posiY,step,menuHeight) });
}

function animateColophonMenu(posiY,step,menuHeight){
   
    if((posiY<=-20) && (posiY>(-1*(menuHeight)))){
        //alert(posiY);
        $("#colophon").css("top",posiY+"px");
        posiY = posiY + step;
    //setTimeout("animateColophonMenu("+posiY+","+step+","+menuHeight+")",1);
    //return true;
    }else{
        if(step>0){
            $("#up-hide-button").html("&#187;");
        }else{
            $("#up-hide-button").html("&#171;");
        }
        clearInterval(slideMenuHandler);
    //return false;
    }
}

var slideMenu=function(){
    var sp,st,t,m,sa,l,w,sw,ot;
    return{
        build:function(sm,sw,mt,s,sl,h){
            sp=s;
            st=sw;
            t=mt;
            m=document.getElementById(sm);
            sa=m.getElementsByTagName('li');
            l=sa.length;
            w=m.offsetWidth;
            sw=w/l;
            ot=Math.floor((w-st)/(l-1));
            var i=0;
            for(i;i<l;i++){
                s=sa[i];
                s.style.width=sw+'px';
                this.timer(s)
            }
            if(sl!=null){
                m.timer=setInterval(function(){
                    slideMenu.slide(sa[sl-1])
                },t)
            }
        },
        timer:function(s){
            $(s).find(".groupname").click(function(){
                clearInterval(m.timer);
                m.timer=setInterval(function(){
                    slideMenu.slide(s)
                },t)
            })
        },
        slide:function(s){
            var cw=parseInt(s.style.width,'10');
            if(cw<st){
                var owt=0;
                var i=0;
                for(i;i<l;i++){
                    if(sa[i]!=s){
                        var o,ow;
                        var oi=0;
                        o=sa[i];
                        ow=parseInt(o.style.width,'10');
                        if(ow>ot){
                            oi=Math.floor((ow-ot)/sp);
                            oi=(oi>0)?oi:1;
                            o.style.width=(ow-oi)+'px'
                        }
                        owt=owt+(ow-oi)
                    }
                }
                s.style.width=(w-owt)+'px';
            }else{
                clearInterval(m.timer)
            }
        }
    };
}();

var refreshIntervalId;
function hideFamily(obj,step){
    var daughter  = obj;
    var mother    = $(daughter).parent();
    var grandma   = $(mother).parent();

    var posi = $(grandma).height();
    var daughterH = $(daughter).height() + parseInt($(daughter).css("margin-top").replace("px",""),10);
    step = (posi<=(daughterH+step)) ? step : -1*step;
    $(grandma).addClass("tap-menu-group-boundery");
   
    if(!refreshIntervalId)
        refreshIntervalId = setInterval(function(){
            animateHideShowFamily(daughter,mother,grandma,step);
        },1);
}

function animateHideShowFamily(daughter,mother,grandma,step){
    var posi = $(grandma).height();
    var daughterH = $(daughter).height() + parseInt($(daughter).css("margin-top").replace("px",""),10);
   
    //$(daughter).text(daughterH + '---' + posi + '---' + $(mother).height());
    posi = posi + step;
    $(grandma).css("height",posi+"px");

    if((posi>(daughterH-(step*1))) && (posi <= ($(mother).height()))){
        return true;
    }else{
        clearInterval(refreshIntervalId);
        if($(daughter).find("#the-expander")){
            if($(daughter).find("#the-expander").text()=="+"){
                $(daughter).find("#the-expander").text("-");
            }else{
                $(daughter).find("#the-expander").text("+");
            }
        }
        $(grandma).removeClass("tap-menu-group-boundery");
        refreshIntervalId = false;
        return false;
    }
}

//end slide menu
//======================================================================================================================================================================



//message box 
//======================================================================================================================================================================

function getMessageDialog(strModuleID,strMessageID){
    
    var strMessageReturn = "";
    
    $.ajax({  
        url: "../../../models/mod.system.messages.php",  
        dataType: 'json',  
        data: {
            ACTION:"getMessage",
            GETPARAM:({
                ModuleID: strModuleID,
                MessageID: strMessageID,
                Lang:getCookie('lang') 
            })
        },  
        async: false,  
        success: function(jsonReturn){  
            
            if ($.trim(jsonReturn) != ""){
                strMessageReturn = {
                    Code:jsonReturn[0]['Code'],
                    Message:jsonReturn[0]['Message']
                };
            }else{
                strMessageReturn = {
                    Code:"Not Found",
                    Message:strMessageID
                };
            }
        }  
    });  
    
    return strMessageReturn;
}
//end slide menu
//======================================================================================================================================================================


//security access rigths
//======================================================================================================================================================================
function getAccessRights(){
    
    var jsonInfo = {
        
        AllowInsert:'allow_insert',
        AllowUpdate:'allow_update',
        AllowDelete:'allow_delete',
        AllowView:'allow_view',
        AllowExport:'allow_export',
        AllowPrint:'allow_print'
        
    }
    
    return jsonInfo;
}

function verifyModuleAccess(strModuleID,strAccessRights,callBack){
    
    var isAllowed = false;
    var isHasCallBack = false;
    
    if (callBack && typeof(callBack) === "function") {  
        isHasCallBack  = true;  
    }  
    
    $.ajax({
        url:"../../../models/mod.sec.systems.NTCERP.php",
        dataType:'json',
        data:{
            ACTION:'verifyModuleAccess',
            GETPARAM:({
                ModuleID:strModuleID,
                AccessRights:strAccessRights
            })
        },
        //        async:false,
        success: function(jsonReturn){
            
            isAllowed = jsonReturn;
            
            if (isAllowed){
                if (isHasCallBack) callBack(isAllowed);
            }else{
                verifyModuleAccessLogIn(strModuleID, strAccessRights,function(value){
                    isAllowed = value;
                    if (isHasCallBack) callBack(isAllowed);
                });
            }
    
        }
    });
}
function verifyModuleAccessOnly(strModuleID,strAccessRights){
    
    var isAllowed = false;
    
    $.ajax({
        url:"../../../models/mod.sec.systems.php",
        dataType:'json',
        data:{
            ACTION:'verifyModuleAccess',
            GETPARAM:({
                ModuleID:strModuleID,
                AccessRights:strAccessRights
            })
        },
        async:false,
        success: function(jsonReturn){
            isAllowed = jsonReturn;
        }
    });
    
    return  isAllowed;
}
function verifyModuleAccessLogIn(strModuleID,strAccessRights,callBack){
    
    if ($('#divSecPromptAuthorized').length > 0) return;
      
    var messageInfo;
    var strUserName;
    var strPassword;
    var strSecPromptOk;
    var strSecPromptCancel;
    var isAllowed = false;
    var isHasCallBack = false;
    
    if (callBack && typeof(callBack) === "function") {  
        isHasCallBack  = true;  
    }  
    
    messageInfo = 'Current user is not authorized to access.\n Please login authorized user.'
    
    strUserName = "Username"
    strPassword = "Password"
    strSecPromptOk = "OK"
    strSecPromptCancel = "Cancel"
    
    $(document).ready(function() {   
       
        
        var html = '<div style="font-size:14px;"> ' +
        '<div style="width:60px;float:left;margin-left:5px;"><img src="../images/security.prompt.jpg" style="margin-right:15px;"></img></div>' +
        '<div id="divSecPromptMessage" style="height:50px;width:300px;margin-top:5px;float:right">' + messageInfo + '</div>' +
        '<div style="clear:both"></div>' +
                        
        '<div style="height:5px;"></div>' +
        '<label style="display:block;width:100px;float:left" >' + strUserName + '</label>' +
        '<input type="text" id="txtSecPromptUserName" class="common-textbox" style="width:250px;"></input>' +
        '<br/><div style="height:3px;"></div>' +
                        
        '<label style="display:block;width:100px;float:left" >' + strPassword + '</label>' +
        '<input type="password" id = "txtSecPromptPassword" class="common-textbox" style="width:250px;"></input>' +
        '<br/><div style="height:15px"></div>' +
                        
        '<div style="height: 1px;background-color: #fef6f6;"></div>' +
        '<div style="height:5px;"></div>' +
        '<div id="divSecPrompActionCommand " style="height: 39px; margin-top: 5px; float: right;"> ' +
        '<input  id="btnSecPromptOk" type = "button" value = "Ok" class="btn-action-command-common" style="width: 80px;height:30px; "></input> ' +
        '<input  id="btnSecPromptCancel" type = "button" value = "Cancel" class="btn-action-command-common" style="width: 80px;height:30px;" ></input>' +
        '</div> ' +
        '</div>';

        var info = $('<div id="divSecPromptAuthorized">');
        
        info.dialog({
            title: "Authorized Log-In",
            width:400,
            height:235,
            modal:true,
            resizable:false,
            close: function(event, ui) {
                $(this).remove();
                if (isHasCallBack) callBack(isAllowed);
                $("#divPdcStockTransferInInfo").dialog("close");
            }
        });	
        
        info.append(html);
        info.dialog('open');
        $('#txtSecPromptUserName').focus();
        
        //events here:
        $('#btnSecPromptOk').click(function(event){
            
            $.ajax({
                url:"../../../models/mod.sec.systems.php?ACTION=verifyAuthorizedUser",
                dataType:'json',
                type:"POST",
                data:{
                    POSTPARAM:({
                        UserName:$('#txtSecPromptUserName').val(),
                        Password:$('#txtSecPromptPassword').val(),
                        ModuleID:strModuleID,
                        AccessRights:strAccessRights
                    }
                    )
                },
                //async:false,
                success: function(jsonReturn){

                    if($.trim(jsonReturn)=='INVALID_USERNAME_PASSWORD'){
                        $('#divSecPromptMessage').css('border','solid 1px #98160a');
                        $('#divSecPromptMessage').css('background-color','#ffe3e3');
                        $('#divSecPromptMessage').text("Invalid username or password.")
                    }else if (!jsonReturn){
                        $('#divSecPromptMessage').css('border','solid 1px #98160a');
                        $('#divSecPromptMessage').css('background-color','#ffe3e3');
                        $('#divSecPromptMessage').text("You're not authorized user.")
                    }else if (jsonReturn){
                        isAllowed = jsonReturn;
                        $('#divSecPromptAuthorized').remove();
                        if (isHasCallBack) callBack(isAllowed);
                        return;
                    }

                }
            });

        });
        
        $('#btnSecPromptCancel').click(function(event){
            $('#divSecPromptAuthorized').remove();
            if (isHasCallBack) callBack(isAllowed);
            $("#divPdcStockTransferInInfo").dialog("close");
        });
        
        $('#txtSecPromptUserName').keydown(function(event){
            if (event.keyCode == 13){
                $('#txtSecPromptPassword').focus();
            }
        });
        
        $('#txtSecPromptPassword').keydown(function(event){
            if (event.keyCode == 13){
                $('#btnSecPromptOk').click();
            }
        });
    
    });
     
}

//end security access rigths
//======================================================================================================================================================================

//Printing Section
//======================================================================================================================================================================

function exportOptions(event,$id,action,module,pdftitle){


    if (event.ctrlKey){
        return;
    }
    
    var arr_strDataToExport = getGridData($id);

    var file = document.createElement("iframe");
    $('body').append(file);
    var form = document.createElement("form");
    
    $(form).attr({
	
        "action":'../../../models/mod.exportoption.php',
        "method":"POST"
    });
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"csvBuffer",
        "value":arr_strDataToExport
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"action",
        "value":action
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"module",
        "value":module
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"pdftitle",
        "value":pdftitle
    }));
    $(file).attr({
        "id":'hidden_IFrame',
        "style":"visibility:hidden;width:0px;height:0px;"
    });
    
    $(file).contents().find('body').append(form);
    
    
    
    $(form).submit();
    
    $.ajax({
        url:$(form).attr('action'),
        type:'POST',
        data:{
            action:action,
            module:module,
            csvBuffter:arr_strDataToExport,
            pdftitle:pdftitle    		
        },
        success:function(result){
            animation(0);
        }
    	
    });
    
}

function arrayToJSON(array,isObject) {
    isObject = isObject || false;
     
    return (isObject)? '[' + array.join(',') + ']':'["' + array.join('","') + '"]';
}

function getGridData($table){
                
    var tableColModel = $table.jqGrid('getGridParam','colModel');
    var tableColNames = $table.jqGrid('getGridParam','colNames');
                
                
    var arr_GridData = [];
    var arr_GridHeaders = [];
    var arr_GridModel = [];
    var ids= $table.getDataIDs();  // Get All IDs
    var table_id = $table.attr('id');
                
    for(var i=0;i<tableColModel.length;i++){
        if(tableColModel[i]['name']!="cb" && !tableColModel[i]['hidden']){
            var colName = tableColNames[i]=="File Name"? "": tableColNames[i];
            arr_GridHeaders.push(colName);
            var objColStyle = {};
            objColStyle.columnAlignment = (tableColModel[i].align==undefined)?'left':tableColModel[i].align;
            objColStyle.columnWidth = tableColModel[i].width;
            arr_GridModel.push(objColStyle);
        }
    }
               
    //Loop through the ids and process the row ..
    for(var i=0;i<ids.length;i++){
        var rowData = [];
        var rawRowData = $("#"+table_id+" tr[id="+ids[i]+"]").children();
                  
                   
        $.each(rawRowData,function(index){
            if(tableColModel[index]['name']!="cb" && !tableColModel[index]['hidden']){
                var td = $(this);
                var children = td.children();
                var value;
                
                if(!children.is(':checkbox')){
                    
                    if(children.is('div')){
                        var img = td.children('div').children('img');
                        value = img[0].src;
                    }else{
                        value = $(this).text();
                    }
                    
                }else{
                    value = (td.children(':checkbox').is(':checked'))?"Yes":"No";
                }
                rowData.push(value);
 
            }
        });
        arr_GridData.push(JSON.stringify(rowData));
        
    }
               
    //After the Rows has been Added to arr_GridData .. 
    arr_GridData.unshift(JSON.stringify(arr_GridHeaders));
               
    //Insert the Column Alignment to the beginning of the array.
    arr_GridData.unshift(JSON.stringify(arr_GridModel));
               
    //Return the Grid Data as JSON String
    return '['+arr_GridData.join(',')+']';
                
}

function getImageData($id){
    
    var gr = $id.getRowData();
    var rowData = [];
    
    for(var i = 0; i < gr.length; i++) {
        var img = document.createElement('img');
        img.src = '../../../pdc/DRAttachments/'+gr[i]['FileName']+'';

        rowData.push(img.src);
    }
    return JSON.stringify(rowData);
    
}

function printStockSalesMapReceipt(event,$id,action,module,BranchName,CustName,SiteAddress,CustTelNo,ForemanName,ForemanNo,DeliveryMonth,DeliveryDay,DeliveryTime,UnloadingPlace,BigTruck,Mafia,ParkingPlaceDistance,UniCam,RoadCondition,DeliveryCompanion,WithMap,WingCar,Remarks){

    if (event.ctrlKey){
        return;
    }
    
    var arr_strDataToExport = getImageData($id);

    var file = document.createElement("iframe");
    $('body').append(file);
    var form = document.createElement("form");
 
    $(form).attr({
        "action":'../../../models/mod.exportoption.php',
        "method":"POST"
    });
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"csvBuffer",
        "value":arr_strDataToExport
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"action",
        "value":action
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"module",
        "value":module
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"BranchName",
        "value":BranchName
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"CustName",
        "value":CustName
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"SiteAddress",
        "value":SiteAddress
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"CustTelNo",
        "value":CustTelNo
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"ForemanName",
        "value":ForemanName
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"ForemanNo",
        "value":ForemanNo
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"DeliveryMonth",
        "value":DeliveryMonth
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"DeliveryDay",
        "value":DeliveryDay
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"DeliveryTime",
        "value":DeliveryTime
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"UnloadingPlace",
        "value":UnloadingPlace
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"BigTruck",
        "value":BigTruck
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"Mafia",
        "value":Mafia
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"ParkingPlaceDistance",
        "value":ParkingPlaceDistance
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"UniCam",
        "value":UniCam
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"RoadCondition",
        "value":RoadCondition
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"DeliveryCompanion",
        "value":DeliveryCompanion
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"WithMap",
        "value":WithMap
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"WingCar",
        "value":WingCar
    }));
    $(form).append($(document.createElement('input')).attr({
        "type":"hidden",
        "name":"Remarks",
        "value":Remarks
    }));
    $(file).attr({
        "id":'hidden_IFrame',
        "style":"visibility:hidden;width:0px;height:0px;"
    });
    
    $(file).contents().find('body').append(form);
    $(form).submit();
    
}

//End Printing Section
//======================================================================================================================================================================

function animation(show){
	
    if(show){
        $.blockUI({
            message: '<img src="http://nkymerp.nkym.co.jp/views/default/images/NKYM-ERP.gif" />',
            css: {
                'z-index': '99999'
            } 
        });
        $('.blockOverlay').css({
            'z-index':'99999' 
        });
        
    }else{
        $.unblockUI();
    }
    
    
}

function closeBrowser(){
    $("#modalBrowser").dialog("close");
}

function excelizeThisTableShit(objID,title,exceller){
    $("body").append('<form method="post" action="'+exceller+'" id="tobeExcelledShit"><textarea id="tobeExcelledTable" name="tobeExcelledTable">'+$("#"+objID).html()+'</textarea></form>');
   
    $("#tobeExcelledShit").submit();
   
    if($("#tobeExcelledShit").length>0){
        $("#tobeExcelledShit").remove();
    }
}


function PopupCenter(pageURL, title,w,h) {
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    var targetWin = window.open (pageURL+"?pop_up=1", title, 'titlebar=yes,toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}


function __highlight(s, t) {
    var matcher = new RegExp("("+$.ui.autocomplete.escapeRegex(t)+")", "ig" );
    return s.replace(matcher, "<strong>$1</strong>");
}
function renderAutoCompleteFor(element_id,url,parameters,onselect){
    
    //destroy previous autocomplete if any;
    $("#"+element_id).autocomplete("destroy");
    
    //prepare url string
    var source = url+"?"+getObjToURIString(parameters);
    
   
    
    //finally render autocomplete to said element_id;
    $("#"+element_id).autocomplete({
        minLength:0,
        source:source,
        response:function(evt,ui){
        /**
        var fld_val = $(this).val();
        
        $.map(ui.content,function(item){
            item.label = __highlight(item.label, fld_val);
                
            return item;
            });
             **/
        },
        select:function(evt,ui){
            if(ui.item){
                onselect(ui.item,this);
            }
        }
        })
    .data('autocomplete')._renderItem = function( ul, item ) {
        
        item.label = __highlight(item.label,this.term);
        
        return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( '<a>' + item.label + '</a>' )
        .appendTo( ul );
    };
}