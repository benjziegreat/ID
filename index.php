<?php
ini_set("display_errors", 0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>ID System of Cor Jesu College</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8;"/>
        <link rel="shortcut icon" href="views/default/images/cjc/favicon.ico"/>
        <!--<script type="text/javascript" src='views/default/js/jquery-1.7.1.min.js'></script>-->
        <script type="text/javascript" src='views/default/js/jquery-1.8.3.min.js'></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var frm = $("<iframe>", {
                    src: 'redirectindex.php',
                    width: $(window).width(),
                    height: $(window).height(),
                    id: 'frm_index'
                });
                $("#divMain_Container").append(frm);
                $("#frm_index").css('border', 'none');
             
                onresize = function() {
                    resizeWindow();
                };
            });
            function resizeWindow() {
                $('#frm_index').css('height', $(window).height() + 'px');
                $('#frm_index').css('width', $(window).width() + 'px');
            }
          
        </script>
    </head>
    <body style="margin:0px;overflow: hidden;" id="divMain_Container">
        <div id="divglobalip" style="display: none;"></div>
    </body>

</html>
