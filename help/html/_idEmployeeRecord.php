<!DOCTYPE html>
<html>
    <head> 
    <topictype value="TOPIC" />
    <title>Employee Record</title>
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
            <span class="projectname">Employee Record</span>
        </div>
        <div class="topicname">
            <img src="bmp/TOPIC.gif">&nbsp;Employee Record
        </div>
    </div>

    <div class="contentpane">


        <div class="contentbody" id="body">
            <h3 id='idh1'>Viewing Employee Record</h3>
            <hr/>
            <ul id='idul1'>
                <h4>Step 1:</h4><br/>
                <li>To view record of Employee click the <u>Employee Record</u> menu.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/1a.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                    <h4>Step 2:</h4><br/>
                <li>Employee Record View<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/recordlist.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>


            </ul>
            <hr>

            <h3 id='idh2'>Adding/Updating Record</h3>
            <hr/>
            <ul id='idul2'>
                <h4>Step 1:</h4><br/>
                <li>To add or edit Record, right click the row and then select your desired option.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/edit_addoncontexts.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                    <h4>Step 2:</h4><br/>
                <li>Fill-up all necessary fields.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/editselectdetail.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                    <h4>Step 3</h4><br/>
                <li>Save the Record details.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/addnewform2s.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>


            </ul>

            <hr>

            <h3 id='idh3'>Steps in Printing  ID</h3>
            <hr/>
            <ul id='idul3'> 
                <h4>Individual Print Preview</h4><br/>
                <li>To view Preview ID, right click the row and then select 'Preview ID'.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/print_preview.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                <li>Click 'Print ID' if you want to print.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/print_preview2.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                
                <h4>Multiple Print Preview</h4><br/>
                <li>Right click the row, then select 'Multiple Selection' to activate multiple selection.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/multipleselection.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                 
                <li>Select records then right click and click 'Preview ID'.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/multiple_selectedrow.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                
                  <li>Click 'Print ID' if you want to print.<br/><br/>
                    <img width=100% src="../Images/Masterfile/employeerecord/multiple_printpreview.png"  style="-webkit-border-radius: 1em;-moz-border-radius: 1em;border-color: #000000;border-width: 2px;" oncontextmenu="return false;"/><p><br>
                

            </ul>



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