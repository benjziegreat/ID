<?php
include_once '../../../../config/cons.database.php';
include_once '../../../../libs/passencryption.php';

$encryption = new EncyptionCustomize();     
$user = trim($encryption->Newdcryting('mypassword', DB_USER));
$pass = trim($encryption->Newdcryting('mypassword', DB_PASS));

$conn = mysql_connect(DB_HOST, $user, $pass) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8", $conn);
mysql_query("SET NAMES 'utf8'", $conn);
//save.php code
//Show the image

//Renaming Existing Picture
$imagePath="../../../../documents/{$_POST['img_foldername']}/{$_POST['img_filename']}";
$fullpath1 = $imagePath;
if (file_exists($fullpath1)) {
    $newpieces = explode(".", $fullpath1);
    $frontpath = str_replace('.' . end($newpieces), '', $fullpath1);
    $newFileName = strtotime(date("Y-m-d H:i:s")) . '.' . end($newpieces);
    $newpath = $frontpath . '_' . $newFileName;
    $success = rename($fullpath1, $newpath);
    // unlink($file); // delete file
    $empidextension= explode(".", $_POST['img_filename']);
    $empID= str_replace('.' . end($empidextension), '', $_POST['img_filename']);
    if ($_POST['img_foldername'] == "AlumniSignature") {
            $dbname = DB_NAME;
            $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
              id=null,
              emp_id='{$empID}',
              idtype='Alumni',
              path='{$newpath}',
              filename='{$empID}_{$newFileName}'";
            mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        } else if ($_POST['img_foldername'] == "EmployeeSignature") {
            $dbname = DB_NAME;
            $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
              id=null,
              emp_id='{$empID}',
              idtype='Employee',
              path='{$newpath}',
              filename='{$empID}_{$newFileName}'            
            ";
            mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        } else if ($_POST['img_foldername'] == "StudentSignature") {
            $dbname = DB_NAME;
            $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
              id=null,
              emp_id='{$empID}',
              idtype='Student',
              path='{$newpath}',
              filename='{$empID}_{$newFileName}'            
            ";
            mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        }
}

$imagePath2="../../../../documents/{$_POST['img_foldername']}/{$_POST['img_filenamenew']}";
$fullpath2 = $imagePath2;
if (file_exists($fullpath2)) {
    $newpieces = explode(".", $fullpath2);
    $frontpath = str_replace('.' . end($newpieces), '', $fullpath2);
    $newpath = $frontpath . '_' . strtotime(date("Y-m-d H:i:s")) . '.' . end($newpieces);
    $success = rename($fullpath2, $fullpath1);
    // unlink($file); // delete file
    $strSQL = "Update `$dbname`.zsignaturerecord SET 
                     isdeleted='1' 
                   where   filename='{$_POST['img_filenamenew']}'  ";
    mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
}


