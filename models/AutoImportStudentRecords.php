<?php

set_time_limit(0);

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
include_once '../config/cons.database.php';

///MYSQL Connection 
// $connMysql = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
// mysql_query("SET CHARACTER SET utf8", $connMysql);
// mysql_query("SET NAMES 'utf8'", $connMysql);
//Mysqli COnnection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS,DB_NAME);
 mysqli_query($mysqli,"SET CHARACTER SET 'utf8'");
 mysqli_query($mysqli,"SET NAMES SET 'utf8'");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
//get already saved records
$strSQLEmp = "SELECT emp_id FROM `cjc_idsystem`.`studentrecordfromsql`;";
$resultRec = $mysqli -> query($strSQLEmp);


// Associative array mysqli_fetch_all($result, MYSQLI_ASSOC);
$rowRec = mysqli_fetch_all($resultRec, MYSQLI_ASSOC);
// var_dump($rowRec);
$varListStudIds="-1";
foreach ($rowRec as $rowRecData ){
    // var_dump($rowRecData);
    // print_r($rowRecData['emp_id'].'<br>');
    $varListStudIds = ($varListStudIds?$varListStudIds.',':'').'x'.$rowRecData['emp_id'].'x';
}
//   print_r($varListStudIds.' <br>');

  
// Free result set
$resultRec -> free_result();

///Sql connection mssql::::
$serverName = "bpenol"; //serverName\instanceName
$connectionInfo = array( "Database"=>"testsql", "UID"=>"sa", "PWD"=>"rootroot" ,'CharacterSet'=>'UTF-8');
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    // echo "SQL Connection established.<br />";
}else{
     //echo "SQL Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
// query mssql
$sql = "SELECT  * FROM employee";
$result = sqlsrv_query($conn, $sql);
if($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
$data = array();
$varStrStudIds ="-1";
while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
    $data[] = array(
                "id" => $row['id'],
                "emp_id" =>$row['emp_id'],
                "fname" => $row['fname'],
                "lname" => $row['lname'],
                "mname" => $row['mname'],
                "address" => $row['address']
                );  
}
  // print_r($data);
foreach ($data as $rowData ){
      //print_r($rowData);
      //print_r($rowData['id']);print_r($rowData['emp_id']);
     // $varStrStudIds = ($varStrStudIds?$varStrStudIds.',':'').$rowData['emp_id'];
      if(strpos($varListStudIds, 'x'.$rowData['emp_id'].'x') !== false){
        //print_r('found'. $rowData['emp_id']);
         //already recorded      
        }else{
        // print_r('not-found'. $rowData['emp_id']);
         $varStrStudIds = ($varStrStudIds?$varStrStudIds.',':'').$rowData['emp_id'];
        }
  }
  print_r($varStrStudIds);
// var_dump($data);
// var_dump($varStrStudIds);

//::::
///


//Auto insert from mssql 

// Turn autocommit off
$mysqli -> autocommit(FALSE);

$strSQLValues="";
foreach ($data as $x => $y) {  
  
$strSQL = "INSERT INTO `cjc_idsystem`.studentrecordfromsql  
                SELECT  tempTbl.* 
                FROM  (SELECT
                    null `idnum`,
                    '" . $mysqli -> real_escape_string($y['emp_id']) . "'  `emp_id`,
                    '" . $mysqli -> real_escape_string($y['lname']) . "' `lname`,
                    '" . $mysqli -> real_escape_string($y['fname']) . "' `fname`,
                    '" . $mysqli -> real_escape_string($y['fname']) . "'  `mname`,
                    null `nameext`,
                    '" . $mysqli -> real_escape_string($y['address']) . "' `designation`,
                    null  `birthdate`,
                    '" . $mysqli -> real_escape_string($y['address']) . "'  `contact_guardian`,
                    null  `contact_relation`,
                    '" . $mysqli -> real_escape_string($y['address']) . "'  `contact_address`,
                    '" . $mysqli -> real_escape_string($y['address']) . "'  `contactno`,
                    1  `isactive`,
                    '" . $mysqli -> real_escape_string($y['address']) . "'  `sex`,
                    null  `sssgsisno`,
                    null  `tinno`,
                    null  `philno`,
                    '" . $mysqli -> real_escape_string($y['address']) . "' `status`,
                    '" . $mysqli -> real_escape_string($y['address']) . "'  `category`,
                    null  `pagibigno`,
                    null  `printinghistory`,
                    'Student' `typeid`,
                    null pathpicture,
                    null pathsignature,
                    0 isforprint,
                   'System Generated'  `addedby`,
                    now() `addeddate`,
                    'System Generated' `modifiedby`,                  
                    now() `modifieddate`) tempTbl where tempTbl.emp_id not IN({$varListStudIds})";
       var_dump($test);   
    // $mysqli -> query($strSQL );
  }

 // Commit transaction
if (!$mysqli -> commit()) {
    echo "Commit transaction failed strSQL";
    exit();
}else{
    //print_r($varStrStudIds);
}
  

$strSQLAutoInsert= "INSERT INTO cjc_idsystem.student
                    SELECT
                    null `idnum`,
                    `emp_id`,
                    `lname`,
                    `fname`,
                    `mname`,
                    `nameext`,
                    `designation`,
                    `birthdate`,
                    `contact_guardian`,
                    `contact_relation`,
                    `contact_address`,
                    `contactno`,
                    `isactive`,
                    `sex`,
                    null  `sssgsisno`,
                    null  `tinno`,
                    null  `philno`,
                    `status`,
                    `category`,
                    `pagibigno`,
                    `printinghistory`,
                    'Student' `typeid`,
                    null pathpicture,
                    null pathsignature,
                    0 isforprint,
                   'System Generated'  `addedby`,
                    now() `addeddate`,
                    'System Generated' `modifiedby`,                  
                    now() `modifieddate`

                    FROM
                      cjc_idsystem.`studentrecordfromsql` stud
                      
                      where  stud.`emp_id` not IN(select emp_id from cjc_idsystem.student) 
                      ORDER BY stud.`modifieddate` desc
                 ";
//$mysqli -> query($strSQLAutoInsert );
if (!$mysqli -> commit()) {
    echo "Commit transaction failed strSQLAutoInsert";
    exit();
}

//$strResultAutoinsertcf3 = mysql_query($strSQLAutoInsert, $connMysql) or die(mysql_error() . $strSQLAutoInsert);
//var_dump($strResultAutoinsertcf3);  



//Close connection mysqli
$mysqli -> close();
exit;
?>       