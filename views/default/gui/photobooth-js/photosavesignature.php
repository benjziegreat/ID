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
echo '<img src="' . $_POST['img_val'] . '" />';
//Renaming Existing Picture
$imagePath = "../../../../documents/{$_POST['img_foldername']}/{$_POST['img_filename']}.png";
$fullpath = $imagePath;
$isExist = false;
if (file_exists($fullpath)) {
    $newpieces = explode(".", $fullpath);
    $frontpath = str_replace('.' . end($newpieces), '', $fullpath);
    $newFileName = strtotime(date("Y-m-d H:i:s")) . '.' . end($newpieces);
    $newpath = $frontpath . '_' . $newFileName;
    $success = rename($fullpath, $newpath);
    // unlink($file); // delete file
    if ($success) {
        if ($_POST['img_foldername'] == "AlumniSignature") {
            $dbname = DB_NAME;
            $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
              id=null,
              emp_id='{$_POST['img_filename']}',
              idtype='Alumni',
              path='{$newpath}',
              filename='{$_POST['img_filename']}_{$newFileName}'";
            mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        } else if ($_POST['img_foldername'] == "EmployeeSignature") {
            $dbname = DB_NAME;
            $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
              id=null,
              emp_id='{$_POST['img_filename']}',
              idtype='Employee',
              path='{$newpath}',
              filename='{$_POST['img_filename']}_{$newFileName}'            
            ";
            mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        } else if ($_POST['img_foldername'] == "StudentSignature") {
            $dbname = DB_NAME;
            $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
              id=null,
              emp_id='{$_POST['img_filename']}',
              idtype='Student',
              path='{$newpath}',
              filename='{$_POST['img_filename']}_{$newFileName}'            
            ";
            mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        }
    }
    $isExist = true;
}

//Get the base-64 string from data
$filteredData = substr($_POST['img_val'], strpos($_POST['img_val'], ",") + 1);

//Decode the string
$unencodedData = base64_decode($filteredData);

//Save the image img_foldername
file_put_contents($imagePath, $unencodedData);
if ($isExist) {
    
} else {


    if ($_POST['img_foldername'] == "AlumniSignature") {
        $dbname = DB_NAME;
        $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
            id=null,
          emp_id='{$_POST['img_filename']}',
          idtype='Alumni',
          path='{$imagePath}',
          filename='{$_POST['img_filename']}.png'   ";
        mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        $strSQL2 = "UPDATE `$dbname`.`alumni` SET
               pathsignature='{$imagePath}'
               WHERE emp_id='{$_POST['img_filename']}'";
        mysql_query($strSQL2, $conn) or die(mysql_error() . $strSQL2);
    } else if ($_POST['img_foldername'] == "EmployeeSignature") {
        $dbname = DB_NAME;
        $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
            id=null,
          emp_id='{$_POST['img_filename']}',
          idtype='Employee',
          path='{$imagePath}',
          filename='{$_POST['img_filename']}.png'            
            ";
        mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        $strSQL2 = "UPDATE `$dbname`.`employee` SET
               pathsignature='{$imagePath}'
               WHERE emp_id='{$_POST['img_filename']}'";
        mysql_query($strSQL2, $conn) or die(mysql_error() . $strSQL2);
    } else if ($_POST['img_foldername'] == "StudentSignature") {
        $dbname = DB_NAME;
        $strSQL = "INSERT INTO `$dbname`.zsignaturerecord SET  
            id=null,
          emp_id='{$_POST['img_filename']}',
          idtype='Student',
          path='{$imagePath}',
          filename='{$_POST['img_filename']}.png'            
            ";
        mysql_query($strSQL, $conn) or die(mysql_error() . $strSQL);
        $strSQL2 = "UPDATE `$dbname`.`student` SET
               pathsignature='{$imagePath}'
               WHERE emp_id='{$_POST['img_filename']}'";
        mysql_query($strSQL2, $conn) or die(mysql_error() . $strSQL2);
    }
}