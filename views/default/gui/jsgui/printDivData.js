// Shows div_print_id0 (and any other cards in divID) exactly as they are currently displayed -
// same markup, same inline styles/positions/font sizes - so the preview is guaranteed to match
// what Ctrl+P / the regular "Print ID" button would show. Confirming in this preview opens the
// browser's native print dialog so the user picks the printer themselves (see
// printPrimacy2CardsViaBrowser) - there is no local Evolis HTTP service to auto-print to.
function printDivData_Primacy2(divID, printingType, isAlumni) {
    var container = document.getElementById(divID);
    if (divID === undefined || divID === null || !container) {
        attributeNotID();
        return;
    }
    animation(0);
    showPrimacy2PrintPreview(container, isAlumni);
}

function showPrimacy2PrintPreview(container, isAlumni) {
    var pageCssStyle = "@page { size: 54mm 86mm portrait; margin: 0; }";
    var mediaPrintCssStyle = "@media print { #primacy2PreviewHeading, #primacy2PreviewActions { display: none !important; } }";

    var cardCount = $(container).children('div[id^="div_print_id"]').length;
    if (cardCount === 0) {
        cardCount = 1;
    }
    var headingText = cardCount + " Card" + (cardCount > 1 ? "s" : "") + " ready to Print";

    var previewHtml = "<html><head><title>Print Preview - Evolis Primacy 2</title>" +
            "<style>" +
            "html,body{height:100%;}" +
            "body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:0;color:black;box-sizing:border-box;}" +
            "#primacy2PreviewHeading{margin:20px 0;text-align:center;}" +
            // A fixed-height, independently scrollable region for the cards (not relying on the
            // whole window/body to scroll), so with many cards there is always a reliable way to
            // reach the rest of them regardless of how tall the combined content is.
            "#primacy2PreviewCards{text-align:center;overflow-y:auto;max-height:calc(100vh - 160px);padding:0 20px 10px 20px;box-sizing:border-box;}" +
            pageCssStyle +
            mediaPrintCssStyle +
            // Fixed to the bottom of the window (not just after the cards in normal flow), so
            // with many cards the actions stay reachable without needing to scroll past them.
            "#primacy2PreviewActions{position:fixed;left:0;bottom:0;width:100%;padding:12px 0;background:#fff;box-shadow:0 -2px 6px rgba(0,0,0,0.2);z-index:1000;box-sizing:border-box;text-align:center;}" +
            "#primacy2PreviewActions button{padding:10px 20px;font-size:14px;margin:0 6px;cursor:pointer;}" +
            "#primacy2PreviewNote{font-size:12px;color:#a15c00;margin:6px 0 0 0;}" +
            "</style></head><body>" +
            "<h3 id='primacy2PreviewHeading'>" + headingText + "</h3>" +
            "<div id='primacy2PreviewCards'>" + container.innerHTML + "</div>" +
            "<div id='primacy2PreviewActions'>" +
            "<button id='btnConfirmPrimacy2Print'>Print to Evolis Primacy 2</button>" +
            "<button id='btnCancelPrimacy2Print'>Cancel</button>" +
            // Each card's front/back are sent as adjacent pages (the pairing a duplex setting
            // expects), but nothing in a web page can flip the printer's own duplex switch - that
            // is a print-dialog/driver setting, so remind the user to turn it on there.
            "<div id='primacy2PreviewNote'>Front and back print as one job per card - make sure \"Print on both sides\" / duplex is turned on for the printer in the print dialog, so each pair lands on the same card.</div>" +
            "</div>" +
            "</body></html>";

    // "#" (not "") keeps the new window on the same URL as this page, so the card's relative
    // image paths (e.g. "../../../documents/...") resolve exactly as they do here - same trick
    // printDivData_WP already relies on.
    var previewWindow = window.open("#", "Primacy2PrintPreview", "location=0,status=0,scrollbars=1,width=" + Math.min($(window).width(), 1000) + ",height=" + Math.min($(window).height(), 800));
    previewWindow.document.open();
    previewWindow.document.write(previewHtml);
    previewWindow.document.close();
    previewWindow.focus();

    previewWindow.document.getElementById("btnConfirmPrimacy2Print").onclick = function () {
        previewWindow.close();
        printPrimacy2CardsViaBrowser(container, isAlumni);
    };
    previewWindow.document.getElementById("btnCancelPrimacy2Print").onclick = function () {
        previewWindow.close();
    };
}

// Declaring an explicit @page size in mm (e.g. "86mm 54mm") doesn't reliably match a card
// printer driver's own named paper size (e.g. IDP's "CR80 SMART") - Chrome maps our number onto
// whichever driver size it considers closest, and when that mapped size doesn't exactly match
// ours, the card ends up not filling the page and the job can even repaginate into extra sheets.
// There's no way to read the driver's exact paper dimensions from a web page, so stop trying to
// declare one: say only the ORIENTATION ("landscape"/"portrait", which IS reliably respected)
// and let the browser/driver use whatever paper size is already selected. The page wrapper below
// fills 100% of that page (h/w unknown in advance), and the card itself is never scaled - only
// centered - so the design can't be distorted regardless of what that final page size turns out
// to be.
function buildPrimacy2PrintPage(sourceEl) {
    if (!sourceEl) {
        return "";
    }
    var clone = sourceEl.cloneNode(true);
    clone.style.float = "none";
    clone.style.margin = "0";

    var textSpans = clone.querySelectorAll("span");
    for (var s = 0; s < textSpans.length; s++) {
        textSpans[s].style.whiteSpace = "nowrap";
    }

    return "<div class='primacy2PrintPage'>" + clone.outerHTML + "</div>";
}

// Prints the SAME live "_front"/"_back" markup shown in the preview through the browser's own
// print dialog, so the user picks the printer themselves (there is no local Evolis HTTP service
// to auto-print to). Each card's front and back come out as two consecutive pages, front then
// back - which is what a printer's "print on both sides" / duplex option expects in order to
// print both sides of the same card. Works the same for one card or many - each card just adds
// its own front/back page pair.
function printPrimacy2CardsViaBrowser(container, isAlumni) {
    var $cards = $(container).children('div[id^="div_print_id"]');
    if ($cards.length === 0) {
        $cards = $(container);
    }

    var firstFront = $cards.first().find('div[id="div_img_id_front"]')[0];
    var firstRect = firstFront ? firstFront.getBoundingClientRect() : {width: 0, height: 0};
    var isLandscape = firstRect.width > firstRect.height;

    // Alumni landscape cards print oversized on the Primacy 2 at full scale, so those (only)
    // print at 86%. Alumni portrait, and Student/Employee at any orientation, stay at default
    // (100%) scale.
    var printScale = (isAlumni && isLandscape) ? 0.86 : 1;

    var pagesHtml = "";
    $cards.each(function () {
        var $card = $(this);
        pagesHtml += buildPrimacy2PrintPage($card.find('div[id="div_img_id_front"]')[0]);
        pagesHtml += buildPrimacy2PrintPage($card.find('div[id="div_img_id_back"]')[0]);
    });

    var docs = "<html><head><title>Print - Evolis Primacy 2</title>" +
            "<style>" +
            "@page { size: " + (isLandscape ? "landscape" : "portrait") + "; margin: 0; }" +
            "html,body{margin:0;background:#fff;color:black;height:100%;width:100%;}" +
            // Flex-centers the (unscaled) card on whatever page size the printer/driver actually
            // uses. "100vh" is unreliable here - Chrome's print viewport doesn't always match the
            // resolved @page box, especially once the dialog's own Layout dropdown re-resolves the
            // orientation after this CSS already ran - so each page is chained to the actual page
            // box via percentage heights (html/body/page all 100%) instead. page-break-inside:
            // avoid keeps a page as one atomic unit; the "+" selector (break BEFORE every page
            // after the first, rather than page-break-after on every page) avoids a trailing blank
            // page after the last one.
            ".primacy2PrintPage{width:100%;height:100%;overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center;page-break-inside:avoid;break-inside:avoid;zoom:" + printScale + ";}" +
            ".primacy2PrintPage + .primacy2PrintPage{page-break-before:always;break-before:always;}" +
            "</style></head><body>" +
            pagesHtml +
            "</body></html>";

    var printWindow = window.open("#", "Primacy2BrowserPrint", "location=0,status=0,scrollbars=1,width=800,height=600");
    printWindow.document.open();
    printWindow.document.write(docs);
    printWindow.document.close();
    printWindow.focus();
    setTimeout(function () {
        // Pages are already ordered front,back per card above - that's all this code can
        // guarantee. Whether they land on the same physical card is the printer driver's
        // "Print on both sides" / Duplex toggle, which only the OS print dialog (opening next)
        // can set, so remind the user right before it appears.
        printWindow.alert("Turn ON \"Print on both sides\" / Duplex in the dialog that opens next, so each card's front and back print on the same card.");
        printWindow.print();
    }, 300);
}

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