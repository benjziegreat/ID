<?php

$html =
  '<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Print QRCode</title>
	</head>
	
	<body>
            <img src="http://192.168.0.3/documents/' . $_GET['ProductCode'] . '.png" style="width: 100%; height: 500px;" />
            <div style="clear: both; margin-top: 20px;"></div>
            <label style="width: 100%; text-align: center; float: left;">' . $_GET['ProductCode'] . '</label>
            <div style="clear: both;"></div>
            <label style="width: 100%; text-align: center; float: left;">' . $_GET['ProductName'] . '</label>
            <script>window.print();</script>
	</body>
  </html>';

  echo $html;
  
?>
