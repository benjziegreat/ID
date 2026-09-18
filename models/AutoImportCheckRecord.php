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
   //print_r($varListStudIds.' <br>');

// Free result set
$resultRec -> free_result();
//Close connection mysqli
$mysqli -> close();


//:::::::::::::::::::::::::
///Sql connection mssql::::
$serverName = MSDB_HOST; //serverName\instanceName
$connectionInfo = array( "Database"=>MSDB_NAME, "UID"=>MSDB_USER, "PWD"=>MSDB_PASS ,'CharacterSet'=>MSDB_CHARSET);

$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "SQL Connection established.<br />";
}else{
     //echo "SQL Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
// test insert mssql
// $sql = "INSERT INTO employee ( emp_id,fname,lname,mname,address) VALUES (?,?,?,?,?)";
// $params = array("200904185","Bpe","Bpe","Bpe","Bpe");

// $stmt = sqlsrv_query( $conn, $sql, $params);
// if( $stmt === false ) {
//      die( print_r( sqlsrv_errors(), true));
// }

// test query mssql
// print "<h2>Query Example 1 | Fetching by Associate Array</h2>"; $sql = "SELECT TOP 10 * FROM employee where [emp_id] not in({$varListStudIds});";
$sql = "SELECT [id]
,[empNo]
,[lname]
,[fname]
,[mname]
,[bdate]
,[cellno]
,[email]
,[departmentId]
,[positionId]
,[salaryId]
,[salary]
FROM [dbo].[employee]";
$result = sqlsrv_query($conn, $sql);
if($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
$data = array();
$varStrStudIds ="-1";
while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
    $data[] = array(
                "id" => $row['id'],
                "emp_id" => $row['empNo'],
                "fname" => $row['fname'],
                "lname" => $row['lname'],
                "mname" => $row['mname'],
                "address" => $row['bdate']
                );  
}
//  print_r($data);
foreach ($data as $rowData ){
    //   print_r($rowData);
    //   print_r($rowData['id']);print_r($rowData['emp_id']);
    //  $varStrStudIds = ($varStrStudIds?$varStrStudIds.',':'').$rowData['emp_id'];
      
    if(strpos($varListStudIds, 'x'.$rowData['emp_id'].'x') !== false){
     //print_r('found'. $rowData['emp_id']);
      //already recorded      
     }else{
     // print_r('not-found'. $rowData['emp_id']);
      $varStrStudIds = ($varStrStudIds?$varStrStudIds.',':'').$rowData['emp_id'];
     }
     
  }
  print_r($varStrStudIds);
// print_r(json_encode($data))

// //Auto insert from mssql
// $strSQLValues="";
// foreach ($data as $x => $y) { 
//     // var_dump($y);   
//     $strSQL = "INSERT INTO `cjc_idsystem`.studentrecordfromsql  
//                 SELECT  tempTbl.* 
//                 FROM  (SELECT
//                     null `idnum`,
//                     '{$y['emp_id']}'  `emp_id`,
//                     '{$y['lname']}' `lname`,
//                     '{$y['fname']}' `fname`,
//                     '{$y['mname']}'  `mname`,
//                     null `nameext`,
//                    '{$y['address']}' `designation`,
//                     null  `birthdate`,
//                     '{$y['address']}'  `contact_guardian`,
//                     null  `contact_relation`,
//                     '{$y['address']}'  `contact_address`,
//                     '{$y['address']}'  `contactno`,
//                     1  `isactive`,
//                     '{$y['address']}'  `sex`,
//                     null  `sssgsisno`,
//                     null  `tinno`,
//                     null  `philno`,
//                     '{$y['address']}' `status`,
//                     '{$y['address']}'  `category`,
//                     null  `pagibigno`,
//                     null  `printinghistory`,
//                     'Student' `typeid`,
//                     null pathpicture,
//                     null pathsignature,
//                     0 isforprint,
//                    'System Generated'  `addedby`,
//                     now() `addeddate`,
//                     'System Generated' `modifiedby`,                  
//                     now() `modifieddate`) tempTbl where tempTbl.emp_id not IN({$varListStudIds})";
//     // var_dump($strSQL);
//       mysql_query($strSQL, $connMysql) or die(mysql_error() . $strSQL);
//   }

?>       