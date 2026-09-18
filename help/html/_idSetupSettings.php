<!DOCTYPE html>
<html>
    <head> 
    <topictype value="TOPIC" />
    <title>ID Setup Settings</title>
    <link rel="stylesheet" type="text/css" href="templates/wwhelp.css">
    <script src="templates/jquery.min.js" type="text/javascript"></script>
    <script src="templates/wwhelp.js" type="text/javascript"></script>
    <script>
        // fix up code examples to display tabs	
        $(function () {
            $("#example").codeExampleTabs();
            $('#idh1,#idh2,#idh3').map(function (index, elem) {
                $(elem).css('cursor', 'pointer');
                $('#idul1,#idul2,#idul3').css('display', 'none');
            });            
            $('#idh1,#idh2,#idh3').bind("click", function () {
                var id = $(this).attr('id').split('idh')[1];
                //$('#idul1,#idul2,#idul3').css('display', 'none');
                $('#idul1,#idul2,#idul3').map(function (index, elem) {
                    if ($(elem).attr('id').split('idul')[1] == id) {
                    } else {
                        $(elem).css('display', 'none');
                    }
                });
                if ($('#idul' + id).css('display') == "none") {
                    $('#idul' + id).css('display', '');
                } else {
                    $('#idul' + id).css('display', 'none');
                }
                $('#idh1,#idh2,#idh3').css('color','steelblue');
                $(this).css('color','#387B37');
                if(id=="1"){
                   parent.document.getElementById('idframe2').contentWindow.document.body.scrollTop=0; 
                }else if(id=="2"){
                    parent.document.getElementById('idframe2').contentWindow.document.body.scrollTop=0;
                }else if(id=="3"){
                    parent.document.getElementById('idframe2').contentWindow.document.body.scrollTop=0;
                }

            });
        });
    </script>
</head>
<body>
    <div class="banner">
        <div>
            <span class="projectname">ID Setup Settings</span>
        </div>
        <div class="topicname">
            <img src="bmp/TOPIC.gif">&nbsp;ID Setup Settings
        </div>
    </div>

    <div class="contentpane">


        <div class="contentbody" id="body">
            <h3 id='idh1'>Viewing ID Setup Settings</h3>
            <hr/>
            <ul id='idul1'>
                <h4>Step 1:</h4><br/>
                <li>To view records of Records click the <u>ID Setup Settings</u> button.<br/><br/>
                    <img width=100% src="../Images/Masterfile/idsetupsettings/recordlist.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
               <li>ID Setup List<br/><br/>  
                    <img width=100% src="../Images/Masterfile/idsetupsettings/1a.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                

            </ul>
            <hr>

            <h3 id='idh2'>Adding/Updating Record</h3>
            <hr/>
            <ul id='idul2'>
                <h4>Step 1:</h4><br/>
                <li>To edit Record, select row and then double click row or click Edit Button. To Add New Record click 'New Button'<br/><br/>
                    <img width=100% src="../Images/Masterfile/idsetupsettings/edit_addoncontexts.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                    <h4>Step 2:</h4><br/>
                <li>Fill-up all necessary fields.<br/><br/>
                    <img width=100% src="../Images/Masterfile/idsetupsettings/editselectdetail.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                    <h4>Step 3</h4><br/>
                <li>Configure or change field setup then Save Record details.<br/><br/>
                    <img width=100% src="../Images/Masterfile/idsetupsettings/addnewform2s.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>


            </ul>

            <hr>

            



        </div>


    </div><hr />
    <div class="footer">
        Date Created: 2016-03-03 | 
        &copy Cor Jesu College, Inc., 2016
    </div>
    <br class="clear" />
    <br />
</body>
</html>