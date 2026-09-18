
<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href='js/css/blitzer/jquery-ui-1.8.16.custom.css'/>
        <script type ="text/javascript" src ='js/jquery-1.7.1.min.js'></script>
        <script type ="text/javascript" src ='js/jquery-ui-1.8.16.custom.min.js'></script>
        <script type ="text/javascript" src ='js/common.js'></script>

        <style>
            .ui-dialog-titlebar-close{
                display:none;
            }

            .thumb {
                height: 75px;
                border: 1px solid #000;
                margin: 10px 5px 0 0;
            }
        </style> 
		<script>
            

            $(document).ready(function(){

			 $("#btnLogout").click(function(){
						doLogout();                    
					});
            });
			
            	  function doLogout(){
                document.location.replace('models/mod.login.php?ACTION=logOut');
            }
        </script>
		
	</head>
	<body>
		<br/>
				
			
		
		<input id="btnLogout" name="btnLogout" type="button" value="Logout" style="float:right;margin-right:0px" class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">
	</body>
</html>

<?php 

include_once '../libs/model.php';

		$memcache = new Memcache; 
		$memcache->connect('192.168.0.3',11211);
		 echo "Server's version: " . $memcache->getVersion() . "<br />\n";
		$cacheAvailable = $memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);
		
// mysql_connect("192.168.0.6", "ric202", "test") or die("Could not connect: " . mysql_error());
// mysql_select_db("nkym_security");

$key = '9b96d365a4dc349d77a3d4460409f285';
								 // echo $key ;
// $get_result = array();
// $key =  md5($sql);
$get_result = $memcache->get($key);
 
if ($get_result) {
        echo "<pre>\n";
        echo "Username: " . $_COOKIE['loginUsername'] . "\n";
        echo "Password: " . $_COOKIE['loginPassword'] . "\n";
        echo "Retrieved From Cache\n";
        echo "</pre>\n";
		// print_r($get_result);
} else{

  echo "<pre>\n";
        echo "Username: " . $_COOKIE['loginUsername'] . "\n";
        echo "Password: " . $_COOKIE['loginPassword'] . "\n";
        echo "Retrieved From Database\n";
        echo "</pre>\n";

}

?>