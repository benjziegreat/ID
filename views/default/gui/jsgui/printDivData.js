function printDivData() {
    var div = $('div[id *= "divReport"]').map(function (v, i) {
        if ($(i).css('display') === "block") {
            return $(i).attr('id');
        }
    })[0];
    if (div === undefined) {
        attributeNotID();
    } else {
        var xPos = (($(window).width() * 0.75) / 8) + 60;
        var yPos = 55 + 31;
        var docs = "<html>" +
                "<head>" +
                "<meta http-equiv='content-type' content='application/x-pdf;charset: utf8;'>" +
                "<meta http-equiv='Content-Disposition' content='attachment; filename=Data.pdf'>" +
                "<title>Print</title>" +
                "<style>" +
                "div{font-family: Arial;}" +
                "@media all{.page-break{display: none;}}" +
                "@page { size : portrait;margin:.25in .25in .25in .25in;mso-header-margin:0in;mso-footer-margin:0in;mso-paper-source:0;}" +
                "@media print {#header, #footer, #nav,input[type='button'],input[type='checkbox'],button{ display: none !important; }} " +
                ".page-break{display: block;page-break-before: always;}}" +
                "</style>" +
                "</head>" +
                "<body>";

        var printArea = $("#" + div).html();
        docs += printArea + "</body></html>";
        var printA = window.open("#", 'Printing Data', "location=1,status=1,scrollbars=1,  width=" + $(window).width() * 0.75 + ",height=" + ($(window).height() - 10));
        printA.moveTo(xPos, yPos);
        printA.document.write(docs);
        printA.print();
        printA.close();

    }
}
function printDivData_WP(divID, orientation, type, printingType) {
//    try{$('div[class="class_barcode"]').attr('style',"top:0px;position:absolute;font-weight: bold;text-align: center;width: 89%;top: 241px;/*left: 12px;*/-webkit-transform: scale(1,0.9081);");}catch(ee){console.log(ee);}
    
	orientation = orientation.toUpperCase() === "P" ? 'portrait' : 'landscape';
    if (divID === undefined || divID === null) {
        attributeNotID();
    } else {
        var xPos = (($(window).width() * 0.75) / 8) + 60;
        var yPos = 55 + 31;
        var pageCssStyle = "@page { size : " + orientation + ";margin:.15in .15in .15in .15in;mso-header-margin:0in;mso-footer-margin:0in;mso-paper-source:0;}";
        var mediaPrintCssStyle ="@media print {footer {page-break-after: always;}#header, #footer, #nav,input[type='button'],button,select,input[type='text'],input[type='submit'],textarea { display: none !important; }td{border-collapse: collapse;border: lightgray solid thin;vertical-align: middle;}th{border-collapse: collapse;border: lightgray solid thin;vertical-align: middle;}} ";
        if(printingType && printingType==='PVC'){
            //Adjust PrintPreview format here
            // $('div[id="_front"]').css('padding-left','10px');
            console.log('printDivData_WP-> printingType', printingType);
            // size: 3.375in 2.125in; pvc size 3.375" x 2.125
            // width: 54mm;  height: 86mm; size: 54mm 86mm; 
            pageCssStyle = "@page { size : 54mm 86mm " + orientation + ";margin: 0px;mso-header-margin:0in;mso-footer-margin:0in;mso-paper-source:0;}"; 
            mediaPrintCssStyle ="@media print {footer {page-break-after: always;}#header, #footer, #nav,input[type='button'],button,select,input[type='text'],input[type='submit'],textarea { display: none !important; }td{border-collapse: collapse;border: lightgray solid thin;vertical-align: middle;}th{border-collapse: collapse;border: lightgray solid thin;vertical-align: middle;}} ";
        }
        var docs = "<html>" +
                "<head>" +
                "<meta http-equiv='content-type' content='application/pdf;charset: utf8;'>" +
                "<meta http-equiv='Content-Disposition' content='attachment; filename=sample.pdf'>" +
                "<title>Print</title>" +               
                "<style>" +
                "@media all{.page-break{display: none;}}" +
                ""+pageCssStyle+"" +
                ""+mediaPrintCssStyle+"" +
                ".page-break{display: block;page-break-before: always;}}" +
                "</style>" +
                "<script>" +
                "function printInvoice(){" +
                "window.print();" +
                "setTimeout(function () {" +
                " try{parent.$('div[aria-labelledby=\"ui-dialog-title-frmStudentIDPreview\"] div:eq(0) a').click();parent.$('div[aria-labelledby=\"ui-dialog-title-frmEmployeeIDPreview\"] div:eq(0) a').click();parent.$('div[aria-labelledby=\"ui-dialog-title-frmAlumniIDPreview\"] div:eq(0) a');}catch(err){console.log(err);}" +
                "}, 1);" +
                "}" +
                " </script>" +
                " </head> " +
                "<body onload=\"printInvoice();\" style='font-family: Arial,sans-serif;'>";

        var printArea = $("#" + divID).html();
        docs += printArea + "</body></html>";
        var printA = window.open("#", type, 'Printing Data', "location=1,status=1,fullscreen=yes,scrollbars=1,  width=" + $(window).width() + ",height=" + ($(window).height() - 10));//0.75
//         printA.moveTo(xPos,yPos);
        printA.document.write(docs);
        printA.print();
        printA.document.close();
        printA.focus();
        printA.close();		
		
        try {
            console.log($('div[aria-labelledby="ui-dialog-title-frmEmployeeIDPreview"] div:eq(0) a'));
            //parent.$('div[aria-labelledby="ui-dialog-title-frmEmployeeIDPreview"] div:eq(0) a').click();
//            parent.$('div[aria-labelledby="ui-dialog-title-frmStudentIDPreview"] div:eq(0) a').click();
            //parent.$('div[aria-labelledby="ui-dialog-title-frmAlumniIDPreview"] div:eq(0) a').click();
        } catch (err) {
            console.log(err);
        }
//    printA.document.contents().remove();
    }
}
function attributeNotID() {
    var dialog = "<div id='attributeNotID' style='display: none;'>" +
            "<div style='float: left;width: 99%;height: 61%;overflow: auto;padding: 10px;'>" +
            "<label id='lblMsg' style='font-size: 14pt;float: left;'>Not valid div ID!</label>" +
            "<div style='clear: both;'></div>" +
            "<!--<label id='lblMsg2' style='font-size: 14pt;float: left;'>Supply the element's \"ID\" preceding with \"#\"</label>-->" +
            "</div>" +
            "<div style='float: right;width: 50%;padding: 10px;'>" +
            "<button style='float: right;width: 75px;background-color: red;' class='btn-action-command' onclick='closeMe(\"attributeNotID\")'>Ok</button>" +
            "</div>" +
            "</div>";
    $("body").append(dialog);
    $("#attributeNotID").dialog({
        title: 'not defined',
        width: 300,
        height: 300,
        modal: true,
        autoOpen: true,
        resizable: false
    });
}
function closeMe(div) {
    $("#" + div).dialog('close').remove();
    return;
}