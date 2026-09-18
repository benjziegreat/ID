<html>
<head>
<title>ID System User Manual</TITLE>
    <script type="text/javascript">
        function SetPage() {
            var query = window.location.search;
            var page = query.search("page=");
            var topic = query.search("topic=");
            if (page > -1) {
                page = query.substr(page + 5);
                if (page.toLowerCase().indexOf(".php") < 0)
                    page = page + ".php"
                window.frames[1].location.href = page;
                window.frames[0].location.href = "index2.php?page=" + page.replace(".php", "");
            }
            else if (topic > -1) {            
                page = query.substr(topic + 6);
                // navigate from the child page
                window.frames[0].location.href = "index2.php?topic=" + decodeURIComponent(page);
            }
            else {
                window.frames[1].location.href = "indexpage.php";
                window.frames[0].location.href = "index2.php";
            }
        }
    </script>
</head>
<frameset cols="20%,*" onload="SetPage();">
  <frame id="idframe1" name="wwhelp_left" target="wwhelp_right">
  <frame id="idframe2" name="wwhelp_right">
  <noframes>
  <body>
  <p>This page uses frames, but your browser doesn't support them.<br>View <a href="index2.php"> the non-frames version</a>.</p>
  </body>
  </noframes>
</frameset>
</html>