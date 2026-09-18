/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function doLogin(event) {
    console.log(event);

    if (event.ctrlKey)
        return;

    $.getJSON("../../../models/mod.main.login.php", ({
        ACTION: 'logIn',
        PARAM: ({
            Username: getElementValue("txtUsername"),
            Password: getElementValue("txtPassword"),
            lang: getCookie('lang')
        })
    }),
    function(data) {

        if (data.length > 0) {
            //cookies already set it will go to main page.
            if (getElementValue("shortcut_goto") == 'MRS') {
                document.location.replace('view.pdc.trnstockrequest.php?shorthanded=yes&showtapmenu=no');
            } else {
                document.location.replace('http://192.168.0.3/NTC_HRMS/views/default/gui/view.ntchrms.naviframe.php');
            }

        } else {
            //default reload.
            //can be modified. 
            document.location.replace('http://192.168.0.3/NTC_HRMS/views/default/gui/view.ntchrms.naviframe.php');
        }
    }
    );
}

