/* Author Benjziegreat Programmer
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//document.getElementsByTagName("body")[0].oncontextmenu = function(e){ e.preventDefault();}
function SYSTEMLoginCheck(type) {
    if (getCookie("loginUserID") === null || $.trim(getCookie("loginUserID")) === '') {
        if (type == "mobile") {
            window.open("../../../webprofile", "_self");
        } else {
            window.open("../../../redirectindex.php", "_self");
        }

    }

}
function detectBrowser() {
    if (navigator.userAgent.indexOf("Chrome") != -1)
    {
//        alert('Chrome');
        return 'Chrome';
    }
//    else if (navigator.userAgent.indexOf("Opera") != -1)
//    {
//        alert('Opera');
//    }
//    else if (navigator.userAgent.indexOf("Firefox") != -1)
//    {
//        alert('Firefox');
//    }
//    else if ((navigator.userAgent.indexOf("MSIE") != -1) || (!!document.documentMode == true)) //IF IE > 10
//    {
//        alert('IE');
//    }
    else
    {
//        alert('unknown');
        return 'other';
    }
}
function isAllowed(type, name) {

    var returnVal = false;
    $.ajax({
        url: '../../../models/mod.cjc.usersettings.php?ACTION=checkUserAssign',
        data: {
            GETPARAM: {
                type: type,
                typename: name
            }
        },
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function (data) {
//            console.log(parseInt(data));
            if (parseInt(data) > 0) {
//                RecordActivityLogs(type, name,'');
                returnVal = true;
            } else {
                playWarningSound();
                swal("Access denied", JSON.stringify(eval($.trim(getCookie("loginUserName")).split('+').join(' '))).split('"').join('') + " account has limited access", "error");
                returnVal = false;
            }
        }
    });
    return returnVal;
}

function isAllowedAccessClick(type, name, assign) {
    var returnVal = false;
    $.ajax({
        url: '../../../models/mod.cjc.usersettings.php?ACTION=checkUserIfAllowed',
        data: {
            GETPARAM: {
                type: type,
                typename: name,
                assign: assign
            }
        },
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function (data) {
//            console.log(parseInt(data));
            if (parseInt(data) > 0) {
                RecordActivityLogs(type, name, assign);
                returnVal = true;
            } else {
                try {
                    playWarningSound();
                } catch (err) {
                    parent.playWarningSound();
                    console.log(err);
                }
                swal("Access denied", JSON.stringify(eval($.trim(getCookie("loginUserName")).split('+').join(' '))).split('"').join('') + " account has limited access", "error");
                returnVal = false;
            }
        }
    });
    return returnVal;
}
function RecordActivityLogs(type, name, assign) {
    $.ajax({
        url: '../../../models/mod.cjc.usersettings.php?ACTION=RecordActivityLogs',
        data: {
            GETPARAM: {
                type: type,
                typename: name,
                assign: assign
            }
        },
        type: 'GET',
        dataType: 'json',
        async: true,
        success: function (data) {
            console.log(parseInt(data));
        }
    });
}

function doIDSetupSettings(event, type) {
    $('#divAdditionalFilter').contents().remove();
	try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck(type);

//    $('#main').contents().remove();
//   // $('#main').load('view.cjc.studentrecord.php');
//    var iframe = document.createElement('iframe');
//    $(iframe).attr({
//        'src': 'view.cjc.idsetupsettings.php',
//        'width': $('#main').width() - 5,
//        'height': $('#main').height() - 5
//    });
//    $('#main').append($(iframe));
    if (isAllowed('module', 'ID Setup Settings')) {
        
		$('div[id$="dialog"]').remove();
        $('#main').contents().remove();
        IDSetupPopup(event);
    }

}
function  navUserManual(event, type) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck(type);
}
function  navSystemInfo(event, type) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck(type);
    swal({title: "System Info", text: "Project Name:Cor Jesu College ID System\nSystem Version: ID V.1 (Build 201603030001)\nDeveloper: Benjie S. Peñol\nEmail: benjie.penol@gmail.com\nContact#: 0930-9500-607", type: "info", showCancelButton: false, confirmButtonColor: "#DD6B55", confirmButtonText: "Ok", closeOnConfirm: true}, function () {
    });
    $('div[class^="sa-icon"]').css('display', 'none');
    $('div[class^="sweet-alert"] H2').css({'color': '#255A14', 'font-size': '16px', 'padding': '0', 'margin': '0', 'text-align': 'left', 'margin-top': '-15px', 'margin-left': '-11px', 'border-bottom': '#999999 solid 1px', 'line-height': '2', 'margin-bottom': '10px'});
    $('div[class^="sweet-alert"] p').css({'text-align': 'left'});
}

function doUserAccessLogout(event) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
//    if (confirm("Are You Sure To Log-out?")) {
//        document.location.assign('../../../models/mod.hris.usersettings.php?ACTION=logOut');
//    }

    swal({title: "Are You Sure To Log-out?", text: "", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, log me out!", closeOnConfirm: false}, function () {
        RecordActivityLogs('LOGOUT', 'Loging out', 'Log out');
        document.location.assign('../../../models/mod.cjc.usersettings.php?ACTION=logOut');
    });

}
function doUserAccessImportFromSQL(event) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck();
    if (isAllowed('module', 'ID Setup Settings')) {
        swal({title: "Loading", text: "", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Ok", closeOnConfirm: true}, function () {
            $('.sa-button-container .confirm').attr('style','display:none;') 
        });
        $.ajax({
            url: "../../../models/AutoImportCheckRecord.php",
            type: "POST",
            async: true,
            success: function (listIds) {
                // $('.sa-button-container .cancel').click();
               console.log('return data', listIds);
               var arrIds = $.trim(listIds).split(',');
               console.log(arrIds,arrIds.length);
               var titleMsg ="";
               confirmButtonText="";
               var totalRec = (arrIds.length-1);
               if(arrIds.length===1){
                titleMsg ="No new Records found from MSSQL";
                confirmButtonText ="Close";
               }else{ 
                titleMsg ="Do you want to import "+totalRec+" new records found from MSSQL?";
                confirmButtonText ="Import";
               }
               swal({title: titleMsg, text: "", type: "warning", showCancelButton: !(arrIds.length===1), confirmButtonColor: "#DD6B55", confirmButtonText: confirmButtonText, closeOnConfirm: (arrIds.length===1)}, function () {
                RecordActivityLogs('IMPORT', 'Importing From MSSQL', 'Importing From MSSQL');
                if(arrIds.length===1){
                    $('.sa-button-container .cancel').attr('disabled',true).attr('style','display:none;');                    
                }else{
                   // call autoImportRecords function
                   $('.sa-button-container .confirm').attr('disabled',true) // 05132025 add disable button to prevent duplicate import
                     autoImportRecords(listIds);                        
                }
                
               });
            }
        });   
    }
    

}
function autoImportRecords(listIds){
    $.ajax({
        url: "../../../models/AutoImportStudentRecords.php",
        type: "POST",
        async: true,
        success: function (savedListIds) {
           console.log('return savedListIds', savedListIds);   
           var arrIds = $.trim(listIds).split(',');
           swal("Import Success", "Successfully imported "+(arrIds.length-1)+" records.", "success"); 
           $('.sa-button-container .confirm').attr('disabled',true) // 05132025     

        }
    });   
}
function doUserAccessLogoutMobile(event) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
//    if (confirm("Are You Sure To Log-out?")) {
//        document.location.assign('../../../models/mod.hris.usersettings.php?ACTION=logOut');
//    }

    swal({title: "Are You Sure To Log-out?", text: "", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, log me out!", closeOnConfirm: false}, function () {
        document.location.assign('../../../models/mod.cjc.usersettings.php?ACTION=logOutMobile');
    });

}

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Controller Master File:::::::::::::::::::::::::::::::::::::::::::::
function navStudentRecord(event, type) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck(type);
    if (isAllowed('module', 'Student Record')) {
        $('div[id$="dialog"]').remove();
        $('#main').contents().remove();
        $('#main').load('view.cjc.studentrecord.php');
    }

}
function navEmployeeRecord(event, type) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck(type);
    if (isAllowed('module', 'Employee Record')) {
        $('div[id$="dialog"]').remove();
        $('#main').contents().remove();
        $('#main').load('view.cjc.employeerecord.php');
    }


}
function navAlumniRecord(event, type) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck(type);
    if (isAllowed('module', 'Alumni Record')) {
        $('div[id$="dialog"]').remove();
        $('#main').contents().remove();
        $('#main').load('view.cjc.alumnirecord.php');
    }
}



//--Controller Settings::::::::::::::::::::::::::::::::::::::::::::::::
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

function navUserSettings(event, type) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    SYSTEMLoginCheck(type);
    if (isAllowed('module', 'User Settings')) {
        $('div[id$="dialog"]').remove();
        $('#main').contents().remove();
        $('#main').load('view.cjc.usersettings.php');
    }
//    var iframe = document.createElement('iframe');
//    $(iframe).attr({
//        'src': 'view.cjc.usersettings.php',
//        'width': $('#main').width() - 5,
//        'height': $('#main').height() - 5
//    });
//
//    $('#main').append($(iframe));

}
//End Settings:::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::




function navLogin(event) {
    try {
        if (event.ctrlKey)
            return;
    } catch (err) {
        console.log('Event Exception');
    }
    // window.location = '../../../login';
    window.location = '../../../redirectindex.php';
}







